<?php


namespace Ecjia\App\Installer\Hookers;


use RC_File;

/**
 * 写入安装锁定文件
 *
 * Class SaveInstallLockFileAction
 * @package Ecjia\App\Installer\Hookers
 */
class SaveInstallLockFileAction
{

    /**
     * Handle the event.
     * @return
     */
    public function handle()
    {
        $dir = base_path('content/storages/data/');
        if (!RC_File::isDirectory($dir)) {
            RC_File::makeDirectory($dir);
        }

        $path = base_path('content/storages/data/install.lock');
        $date = date('Y-m-d');
        return RC_File::put($path, "ECJIA INSTALLED $date");
    }

}