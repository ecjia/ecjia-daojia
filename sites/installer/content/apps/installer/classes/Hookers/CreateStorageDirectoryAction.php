<?php


namespace Ecjia\App\Installer\Hookers;

use RC_File;
use RC_Package;

/**
 * 创建存储目录
 * Class CreateStorageDirectoryAction
 * @package Ecjia\App\Installer\Hookers
 */
class CreateStorageDirectoryAction
{

    /**
     * Handle the event.
     * @return void
     */
    public function handle()
    {
        $dirs = config('app-installer::checking_dirs');
        collect($dirs)->each(function ($dir) {
            if (!RC_File::isDirectory($dir)) {
                RC_File::makeDirectory($dir);
            }
        });
    }

}