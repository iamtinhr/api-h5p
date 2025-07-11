<?php

namespace EscolaLms\HeadlessH5P\Http\Controllers;

use EscolaLms\HeadlessH5P\Dtos\ContentFilterCriteriaDto;
use EscolaLms\HeadlessH5P\Http\Controllers\Swagger\ContentApiSwagger;
use EscolaLms\HeadlessH5P\Http\Requests\ContentCreateRequest;
use EscolaLms\HeadlessH5P\Http\Requests\ContentDeleteRequest;
use EscolaLms\HeadlessH5P\Http\Requests\ContentListRequest;
use EscolaLms\HeadlessH5P\Http\Requests\AdminContentReadRequest;
use EscolaLms\HeadlessH5P\Http\Requests\ContentReadRequest;
use EscolaLms\HeadlessH5P\Http\Requests\ContentUpdateRequest;
use EscolaLms\HeadlessH5P\Http\Requests\LibraryStoreRequest;
use EscolaLms\HeadlessH5P\Http\Resources\ContentIndexResource;
use EscolaLms\HeadlessH5P\Http\Resources\ContentResource;
use EscolaLms\HeadlessH5P\Repositories\Contracts\H5PContentRepositoryContract;
use EscolaLms\HeadlessH5P\Services\Contracts\HeadlessH5PServiceContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContentApiController extends BaseController implements ContentApiSwagger
{
    private HeadlessH5PServiceContract $hh5pService;
    private H5PContentRepositoryContract $contentRepository;

    public function __construct(HeadlessH5PServiceContract $hh5pService, H5PContentRepositoryContract $contentRepository)
    {
        $this->hh5pService = $hh5pService;
        $this->contentRepository = $contentRepository;
    }

    public function index(ContentListRequest $request): JsonResponse
    {
        $contentFilterDto = ContentFilterCriteriaDto::instantiateFromRequest($request);
        $columns = [
            'hh5p_contents.id',
            'hh5p_contents.uuid',
            'hh5p_contents.library_id',
            'hh5p_contents.user_id',
            'hh5p_contents.parameters',
        ];
        $list = $request->get('per_page') !== null && $request->get('per_page') == 0 ?
            $this->contentRepository->unpaginatedList($contentFilterDto, $columns) :
            $this->contentRepository->list($contentFilterDto, $request->get('per_page'), $columns);

        return $this->sendResponseForResource(ContentIndexResource::collection($list));
    }

    public function update(ContentUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $contentId = $this->contentRepository->edit($id, $request);
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponse(['id' => $contentId]);
    }

    public function store(ContentCreateRequest $request): JsonResponse
    {
        try {
            $contentId = $this->contentRepository->create($request);
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponse(['id' => $contentId]);
    }

    public function destroy(ContentDeleteRequest $request, int $id): JsonResponse
    {
        try {
            $contentId = $this->contentRepository->delete($id);
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponse(['id' => $contentId]);
    }

    public function show(AdminContentReadRequest $request, int $id): JsonResponse
    {
        try {
            $settings = $this->hh5pService->getContentSettings($id);
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponse($settings);
    }

    public function frontShow(ContentReadRequest $request, string $id): JsonResponse
    {
        try {
            $settings = $this->hh5pService->getContentSettings($request, $request->getH5PContent()->id);
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponse($settings);
    }

    public function upload(LibraryStoreRequest $request): JsonResponse
    {
        try {
            $content = $this->contentRepository->upload($request->file('h5p_file'));
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponseForResource(ContentResource::make($content));
    }

    public function download(AdminContentReadRequest $request, $id): StreamedResponse
    {
        ob_end_clean();
        ob_start();

        $filepath = $this->contentRepository->download($id);

        return Storage::disk('upload')->download($filepath);
    }

    public function deleteUnused(): JsonResponse
    {
        try {
            $ids = $this->contentRepository->deleteUnused();
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponse(['ids' => $ids]);
    }
}
