<?php

namespace EscolaLms\HeadlessH5P\Commands;

use EscolaLms\HeadlessH5P\Helpers\Helpers;
use EscolaLms\HeadlessH5P\Repositories\H5PFileStorageRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class StorageH5PCopyStorageCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'h5p:storage-copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy local H5P storage to s3 and after delete files from local storage';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $disk = Storage::disk('upload');

        $link = $disk->path('h5p');
        $target = $disk->path('h5p');

        // Inject path gốc từ disk upload
        app(H5PFileStorageRepository::class, ['path' => $disk->path('')])
            ->copyVendorFiles($target, $link);

        Helpers::deleteFileTreeLocal($target);

        $this->info("The files [$target] have been copied to [$link].");
    }
}
