<?php


namespace Ecjia\System\Hookers;


use RC_Config;

class CustomUploadPathFilter
{
    /**
     * 自定义上传目录路径
     * @param string $url
     * @param string $path
     * @return string
     */
    public function handle($url, $path)
    {
        if (RC_Config::get('site.custom_upload_path')) {
            $upload_path = RC_Config::get('site.custom_upload_path');
        } else {
            $upload_path = SITE_UPLOAD_PATH;
        }

        $upload_path = $upload_path . ltrim($path, '/');

        return $upload_path;
    }
}