<?php namespace Royalcms\Component\Foundation;
defined('IN_ROYALCMS') or exit('No permission resources.');

class Api extends Object
{ 

    /**
     * 执行指定APP中的同名API
     *
     * @param string $app
     *            APP名称
     * @param string $name
     *            API名称
     * @param array $params
     *            API参数
     * @return array
     */
    public static function api($app, $name, $params = array())
    {
        $api_name = $app . '.' . $name;
        return Loader::load_api($api_name, $params);
    }

    /**
     * 调用所有APP中的同名API
     *
     * @param $name API名称            
     * @param array $param
     *            API参数
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