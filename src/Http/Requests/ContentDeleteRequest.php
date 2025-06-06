<?php

namespace EscolaLms\HeadlessH5P\Http\Requests;

use EscolaLms\HeadlessH5P\Repositories\Contracts\H5PContentRepositoryContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ContentDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $h5PContentRepository = app(H5PContentRepositoryContract::class);
        $h5pContent = $h5PContentRepository->show($this->route('id'));

//        return Gate::allows('delete', $h5pContent);
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
