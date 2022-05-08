<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

/**
 * 允许上传的最大文件大小
 *
 * Class UploadMaxFilesizeCheck
 * @package Ecjia\App\Installer\Checkers
 */
class UploadMaxFilesizeCheck
{

    public function handle(CheckerInterface $checker)
    {
        $max_filesize = ini_get('upload_max_filesize');

        if ($max_filesize >= 2) {
            $checked_label = $checker->getOk();
            $checked_status = true;
        }
        else {
            $checked_label = $checker->getCancel();
            $checked_status = false;
        }

        return [
            'value' => $max_filesize,
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
            'name' => __('文件上传大小', 'ecjia'),
            'suggest_label' => __('2M及以上', 'ecjia'),
        ];

    }
}