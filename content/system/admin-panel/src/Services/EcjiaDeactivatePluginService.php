<?php


namespace Ecjia\System\AdminPanel\Services;


use ecjia_plugin;

/**
 * 卸载插件服务
 * Class DeactivatePluginService
 * @package Ecjia\System\AdminPanel\Services
 */
class EcjiaDeactivatePluginService
{

    /**
     * @param $options ['code'] 插件代号
     * @return mixed
     */
    public function handle($options)
    {
        $code = $options['code'];

        $id = "$code/$code.php";

        $result = ecjia_plugin::deactivate_plugins(array($id));

        return $result;
    }

}