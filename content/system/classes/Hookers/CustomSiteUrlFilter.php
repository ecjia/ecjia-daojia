<?php


namespace Ecjia\System\Hookers;


use RC_Config;

class CustomSiteUrlFilter
{

    /**
     * 自定义项目访问URL
     * @param string $url
     * @param string $path
     * @return string
     */
    public function handle($url, $path, $scheme)
    {
        if (RC_Config::get('site.custom_site_url')) {
            $home_url = RC_Config::get('site.custom_site_url');
            $url = $home_url . '/' . $path;
        }
        return rtrim($url, '/');
    }

}