<?php
namespace EscolaLms\HeadlessH5P\Repositories\Contracts;

use EscolaLms\Core\Dtos\OrderDto;
use EscolaLms\HeadlessH5P\Dtos\ContentFilterCriteriaDto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

use EscolaLms\HeadlessH5P\Models\H5PContent;
use EscolaLms\HeadlessH5P\Models\H5PLibrary;
use Illuminate\Pagination\LengthAwarePaginator;

interface H5PContentRepositoryContract
{
    public function create($request): int;

    public function edit(int $id, $request): int;

    public function list(
        ContentFilterCriteriaDto $contentFilterDto,
        $per_page = 15,
        array $columns = ['hh5p_contents.*'],
        ?OrderDto $orderDto = null
    ): LengthAwarePaginator;

    public function unpaginatedList(
        ContentFilterCriteriaDto $contentFilterDto,
        array $columns = ['hh5p_contents.*'],
        ?OrderDto $orderDto = null
    ): Collection;

    public function delete(int $id): int;

    public function show(int $id): H5PContent;

    public function upload($file, $content = null, $only_upgrade = null, $disable_h5p_security = false): H5PContent;

    public function download($id): string;

    public function getLibraryById(int $id): H5PLibrary;

    public function deleteUnused(): Collection;
}
