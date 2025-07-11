<?php

namespace EscolaLms\HeadlessH5P\Http\Requests;

use App\Models\Config;
use EscolaLms\HeadlessH5P\Models\H5PLibrary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class FilesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return Gate::allows('upload', H5PLibrary::class);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $maxUploadFile = Config::whereName('maximum_capacity')->value('value');
        $kb = $maxUploadFile === null ? 5242880 : convertToKB($maxUploadFile);
        return [
            'file' => ['required', "max:$kb"],
            'field' => ['required', 'string'],
            'contentId' => ['required', 'string'],
        ];
    }
}
