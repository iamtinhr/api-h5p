<?php

namespace EscolaLms\HeadlessH5P\Repositories;

use Exception;
use H5PCore;
use H5peditorFile;
use H5PFileStorage;
use H5PDefaultStorage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class H5PFileStorageRepository extends H5PDefaultStorage implements H5PFileStorage
{
}
