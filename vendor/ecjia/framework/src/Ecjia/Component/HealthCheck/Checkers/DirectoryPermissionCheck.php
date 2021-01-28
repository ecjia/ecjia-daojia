<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;
use RC_File;
use RC_Upload;

/**
 * 目录权限检测
 * Class DirectoryPermissionCheck
 * @package Ecjia\App\Installer\Checkers
 */
class DirectoryPermissionCheck
{

    public function handle(CheckerInterface $checker)
    {
        //目录检测
        $dirPermission = $this->getCheckDirPermission();

        $checked = collect($dirPermission)->map(function ($item) use ($checker) {
            if ($item['m'] > 0) {
                $checked_label  = $checker->getOk() . __('可写', 'ecjia');
                $checked_status = true;
            } else {
                $checked_label  = $checker->getCancel() . __('不可写', 'ecjia');
                $checked_status = false;
            }

            if ($item['dir']) {
                $dir = rtrim($item['dir'], '/\\') . '/';
            }

            $dir = '/' . $dir;

            return [
                'value'          => $dir,
                'checked_label'  => $checked_label,
                'checked_status' => $checked_status,
                'name' => $item['item'],
                'suggest_label' => __('可写', 'ecjia'),
            ];
        })->all();

        return $checked;
    }


    /**
     * 检测目录权限
     */
    public function getCheckDirPermission()
    {
        $royalcms = royalcms();

        $dirs = [
            '/'                       => '',
            'content/bootstrap/cache' => str_replace(SITE_ROOT, '', $royalcms->bootstrapPath('cache')),
            'content/configs'         => str_replace(SITE_ROOT, '', $royalcms->configPath()),
            'content/uploads'         => str_replace(SITE_ROOT, '', RC_Upload::upload_path()),
            'content/storages'        => str_replace(SITE_ROOT, '', storage_path()),
        ];

        $list = array();

        /* 检查目录 */
        foreach ($dirs as $key => $val) {
            $mark = RC_File::file_mode_info(SITE_ROOT . $val);

            $list[] = array(
                'item' => $key . __('目录', 'ecjia'),
                'dir'  => $val,
                'mark' => $mark,
                'r'    => $mark & 1,
                'w'    => $mark & 2,
                'm'    => $mark & 4
            );

        }

        return $list;
    }

}