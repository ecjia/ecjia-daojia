<?php


namespace Royalcms\Component\Service;

use Royalcms\Component\Service\Facades\Service;
use RC_Hook;
use RC_Package;

class ApiCall
{

    /**
     * 执行指定APP中的同名API
     *
     * @param string $app APP名称
     * @param string $name API名称
     * @param array $params API参数
     * @return array
     */
    public static function api($app, $name, $params = [])
    {
        $api_name = $app . '.' . $name;

        /**
         * 检查api调用拦截，如果有，使用hook调用
         */
        $api_call = $app . '_' . $name . '_apicall';
        if (RC_Hook::has_filter($api_call)) {
            return RC_Hook::apply_filters($api_call, null, $api_name, $params);
        }

        /**
         * 检查是否有Service handle，如果有，使用Service调用
         */
        if (self::hasServiceHandle($name, $app)) {
            return self::serviceHandle($name, $app, $params);
        }

        /**
         * 检查api名称过滤器，如果有，使用新的api_name调用
         */
        $api_name_hook = $app . '_' . $name . '_apihook';
        if (RC_Hook::has_filter($api_name_hook)) {
            $api_name = RC_Hook::apply_filters($api_name_hook, $api_name, $params);
        }

        return self::apiHandle($api_name, $params);
    }

    /**
     * 调用所有APP中的同名API
     *
     * @param array $apps APP数组
     * @param string $name API名称
     * @param array $param API参数
     * @return array
     */
    public static function apis($apps, $name, $param = [])
    {
        if (is_array($apps)) {
            return collect($apps)->mapWithKeys(function ($app) use ($name, $param) {
                return [$app => self::api($app, $name, $param)];
            })->filter()->all();
        }

        return null;
    }

    /**
     * @param $api
     * @param $params
     * @return bool
     */
    private static function apiHandle($api, $params = [])
    {
        $keys = explode('.', $api);
        $app = $keys[0];
        $class = $app . '_' . $keys[1] . '_api';
        $key = $keys[1];

        if ($app == 'system' || $app == config('system.admin_entrance')) {
            $system_api = RC_Package::package('system')->loadApi($key);
            if ($system_api) {
                return $system_api->call($params);
            }
        } else {
            $app_api = RC_Package::package('app::'.$app)->loadApi($key);
            if ($app_api) {
                return $app_api->call($params);
            }
        }

        return null;
    }

    /**
     * @param $name
     * @param $app
     * @param $params
     */
    private static function serviceHandle($name, $app, $params = [])
    {
        return Service::fire($name, $app, $params);
    }

    /**
     * @param $name
     * @param $app
     * @return mixed
     */
    private static function hasServiceHandle($name, $app = null)
    {
        return Service::hasHandleWithTag($name, $app);
    }


}