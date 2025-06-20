<?php

namespace EscolaLms\HeadlessH5P\Services\Contracts;

use EscolaLms\HeadlessH5P\Repositories\Contracts\H5PFrameworkInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

use H5PFileStorage;
use H5PStorage;
use H5PCore;
use H5PValidator;
use H5peditor;
use EditorStorage;
use EditorAjaxRepository;
use H5PContentValidator;

interface HeadlessH5PServiceContract
{
    public function getEditor(): H5peditor;

    public function getRepository(): H5PFrameworkInterface;

    public function getFileStorage(): H5PFileStorage;

    public function getCore(): H5PCore;

    public function getValidator(): H5PValidator;

    public function getStorage(): H5PStorage;

    public function getContentValidator(): H5PContentValidator;

    public function validatePackage(UploadedFile $file, $skipContent = true, $h5p_upgrade_only = false): bool;

    public function savePackage(object $content = null, int $contentMainId = null, bool $skipContent = true, array $options = []): bool;

    public function getMessages(string $type);

    public function listLibraries(): Collection;

    public function getConfig(): array;

    public function getLibraries(string $machineName = null, string $major_version = null, string $minor_version = null, int $library_id = null);

    public function getEditorSettings($content = null): array;

    public function getContentSettings($request, $id): array;

    public function deleteLibrary($id): bool;

    public function uploadLibrary($token, $file, $contentId): array;

    public function getContentTypeCache(): array;

    public function getUpdatedContentHubMetadataCache();

    public function libraryInstall($machineName);

    public function reinstallLibraryDependencies(string $machineName): void;

    public function filterLibraries($libraryParameters);

    public function getTranslations(array $libraries, ?string $language = null): array;

    public function uploadFile($contentId, $field, $token, $nonce = null);
}
