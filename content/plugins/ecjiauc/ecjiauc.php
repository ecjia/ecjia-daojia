<?php
/*
Plugin Name: ECJiaUC会员系统
Plugin URI: http://www.ecjia.com/plugins/ecjia.ecjiauc/
Description: ECJia UCenter会员系统
Author: ECJIA TEAM
Version: 2.0.0
Author URI: http://www.ecjia.com/
Plugin App: integrate
*/
defined('IN_ECJIA') or exit('No permission resources.');

class plugin_integrate_ecjiauc {

    public static function install() {
        $param = array('file' => __FILE__);
        return RC_Api::api('integrate', 'integrate_install', $param);
    }


    public static function uninstall() {
        $param = array('file' => __FILE__);
        return RC_Api::api('integrate', 'integrate_uninstall', $param);
    }

}

Ecjia_PluginManager::extend('ecjiauc', function() {
    require_once RC_Plugin::plugin_dir_path(__FILE__) . 'ecjiauc.class.php';
    return new ecjiauc();
});

RC_Plugin::register_activation_hook(__FILE__, array('plugin_integrate_ecjiauc', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_integrate_ecjiauc', 'uninstall'));

if (! function_exists('ecjia_uc_call')) {
    /**
     * 调用UCenter的函数
     *
     * @param string $func
     * @param array $params
     *
     * @return mixed
     */
    function ecjia_uc_call($func, $params = null)
    {
        if (ecjia::config('integrate_code') == 'ecjiauc') {
            restore_error_handler();
            $ucenter = royalcms('ucenter');
            $res = call_user_func_array([$ucenter, $func], $params);
            return $res;
        } else {
            return false;
        }
    }
}

if (! function_exists('ecjiauc_connect_user')) {

    /**
     * @param $open_id
     * @param $user_type
     * @return ecjiauc_connect_user
     */
    function ecjiauc_connect_user($open_id, $user_type)
    {
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'ecjiauc_connect_user.class.php';

        return new ecjiauc_connect_user($open_id, $user_type);
    }
}

// end