<?php


namespace Ecjia\System\Hookers;


use RC_Config;

class CustomAssetUrlFilter
{

    /**
     * 自定义后台管理访问URL
     * @param string $url
     * @param string $path
     * @return string
     */
    public function handle($url, $path)
    {
        if (RC_Config::get('site.custom_asset_url')) {
            $admin_url = RC_Config::get('site.custom_asset_url');
            $url = $admin_url . '/' . $path;
        }
        return rtrim($url, '/');
    }

}