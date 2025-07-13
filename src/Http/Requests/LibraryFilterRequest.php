<?php

namespace EscolaLms\HeadlessH5P\Http\Requests;

use EscolaLms\HeadlessH5P\Exceptions\H5PException;
use Illuminate\Foundation\Http\FormRequest;

class LibraryFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function getLibraryParameters()
    {
        $libraryParameters = json_decode($this->get('libraryParameters'));
        if (!$libraryParameters) {
            abort(422, __('h5p::h5p_exceptions.no_library_parameters'));
        }

        return $libraryParameters;
    }
}
