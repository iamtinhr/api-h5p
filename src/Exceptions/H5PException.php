<?php

namespace EscolaLms\HeadlessH5P\Exceptions;

use Exception;

class H5PException extends Exception
{
    public static function invalidParametersJson(): self
    {
        return new self(__('h5p::h5p_exceptions.invalid_parameters_json'));
    }

    public static function libraryNotFound(): self
    {
        return new self(__('h5p::h5p_exceptions.library_not_found'));
    }

    public static function contentNotFound(): self
    {
        return new self(__('h5p::h5p_exceptions.content_not_found'));
    }

    public static function invalidFileToken(): self
    {
        return new self(__('h5p::h5p_exceptions.invalid_file_token'));
    }

    public static function fileNotFound(): self
    {
        return new self(__('h5p::h5p_exceptions.file_not_found'));
    }

    public static function fileInvalid(): self
    {
        return new self(__('h5p::h5p_exceptions.file_invalid'));
    }

    public static function noContentType(): self
    {
        return new self(__('h5p::h5p_exceptions.no_content_type'));
    }

    public static function invalidContentType(): self
    {
        return new self(__('h5p::h5p_exceptions.invalid_content_type'));
    }

    public static function installDenied(): self
    {
        return new self(__('h5p::h5p_exceptions.install_denied'));
    }

    public static function downloadFailed(): self
    {
        return new self(__('h5p::h5p_exceptions.download_failed'));
    }

    public static function noLibraryParameters(): self
    {
        return new self(__('h5p::h5p_exceptions.no_library_parameters'));
    }
}
