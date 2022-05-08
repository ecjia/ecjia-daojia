<?php


namespace Ecjia\System\Hookers;


use RC_Config;

class CustomOriginalUploadUrlFilter
{

    /**
     * 自定义上传目录访问URL
     * @param string $url
     * @param string $path
     * @return string
     */
    public function handle($url, $path)
    {
        if (RC_Config::get('site.custom_original_upload_url')) {
            $home_url = RC_Config::get('site.custom_original_upload_url');
            $url = $home_url . '/' . $path;
        }

        $upload_url = rtrim($url, '/');

        return $upload_url;
    }

}