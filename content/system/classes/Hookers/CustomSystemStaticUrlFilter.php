<?php


namespace Ecjia\System\Hookers;


use RC_Config;
use RC_Uri;

class CustomSystemStaticUrlFilter
{

    /**
     * 自定义系统静态资源访问URL
     * @param string $url
     * @param string $path
     * @return string
     */
    public function handle($url, $path)
    {
        if (RC_Config::get('site.custom_static_url')) {
            $static_url = RC_Config::get('site.custom_static_url');
            $url = $static_url . '/' . $path;
        }
        else {
            $url = RC_Uri::admin_url('admin-panel/statics/') . '/' . $path;
        }
        return rtrim($url, '/');
    }

}