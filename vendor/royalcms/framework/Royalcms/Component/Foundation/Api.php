<?php 

namespace Royalcms\Component\Foundation;

use RC_Hook;

class Api extends RoyalcmsObject
{ 

    /**
     * 执行指定APP中的同名API
     *
     * @param string $app APP名称
     * @param string $name API名称
     * @param array $params API参数
     * @return array
     */
    public static function api($app, $name, $params = array())
    {
        $api_name = $app . '.' . $name;

        $api_call = $app . '_' . $name . '_apicall';
        if (RC_Hook::has_filter($api_call)) {
            return RC_Hook::apply_filters($api_call, null, $api_name, $params);
        }

        $api_hook = $app . '_' . $name . '_apihook';
        if (RC_Hook::has_filter($api_hook)) {
            $api_name = RC_Hook::apply_filters($api_hook, $api_name, $params);
        }

        return Loader::load_api($api_name, $params);
    }

    /**
     * 调用所有APP中的同名API
     *
     * @param array $apps APP数组
     * @param string $name API名称
     * @param array $param API参数
     * @return array
     */
    public static function apis($apps, $name, $param = array())
    {
        $apis = array();
        if (! empty($apps) && is_array($apps)) {
            foreach ($apps as $app) {
                $data = self::api($app, $name, $param);
                if (! empty($data)) {
                    $apis[$app] = $data;
                }
            }
        }
        
        return $apis;
    }
}

// end