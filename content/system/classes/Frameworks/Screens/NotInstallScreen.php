<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-15
 * Time: 14:10
 */

namespace Ecjia\System\Frameworks\Screens;

use RC_Hook;
use RC_Loader;
use RC_Theme;
use ecjia_controller;
use ecjia_license;
use ecjia_app;
use ecjia;

class NotInstallScreen extends AllScreen
{

    public function loading()
    {

        parent::loading();

        RC_Hook::add_action('init', [__CLASS__, 'load_theme_function']);
        RC_Hook::add_filter('app_scan_bundles', [__CLASS__, 'app_scan_bundles']);
        RC_Hook::add_action('royalcms_default_controller', [__CLASS__, 'royalcms_default_controller']);

        RC_Hook::add_action('ecjia_shop_closed', [__CLASS__, 'custom_shop_closed']);
        RC_Hook::add_action('ecjia_general_info_filter', [__CLASS__, 'ecjia_general_info_filter']);

        RC_Hook::add_action('page_title_suffix', [__CLASS__, 'page_title_suffix']);

        //加载hooks
        ecjia::loadGlobalPlugins();

    }

    public static function royalcms_default_controller($arg)
    {
        return new ecjia_controller();
    }

    /**
     * 加载主题扩展文件
     */
    public static function load_theme_function()
    {
        RC_Loader::load_app_func('functions', 'api');
        $app = config('site.main_app');
        if ($app) {
            RC_Loader::load_app_func('functions', $app);

            RC_Hook::add_filter('template', function () {
                $template_code = RC_Hook::apply_filters('ecjia_theme_template_code', 'template');
                return ecjia::config($template_code);
            });
        } else {
            $request = royalcms('request');
            if ($request->getBasePath() != '' || config('system.tpl_force_specify')) {
                RC_Hook::add_filter('template', function () {
                    return config('system.tpl_style');
                });
            } else {
                RC_Hook::add_filter('template', function () {
                    $template_code = RC_Hook::apply_filters('ecjia_theme_template_code', 'template');
                    return ecjia::config($template_code);
                });
            }
        }

        $dir = RC_Theme::get_template_directory();
        if (file_exists($dir . DS . 'functions.php')) {
            include_once $dir . DS . 'functions.php';
        }
    }

    public static function app_scan_bundles()
    {
        $builtin_bundles = ecjia_app::builtin_bundles();
        if (defined('ROUTE_M') && ROUTE_M != 'installer') {
            $extend_bundles = ecjia_app::extend_bundles();
            return array_merge($builtin_bundles, $extend_bundles);
        }
        return $builtin_bundles;
    }

    /**
     * 自定义商店关闭后输出
     */
    public static function custom_shop_closed()
    {
        header('Content-type: text/html; charset='.RC_CHARSET);
        die('<div style="margin: 150px; text-align: center; font-size: 14px"><p>' . __('本店盘点中，请您稍后再来...') . '</p><p>' . ecjia::config('close_comment') . '</p></div>');
    }


    public static function ecjia_general_info_filter($data)
    {
        if (! ecjia_license::instance()->license_check()) {
            $data['powered'] = ecjia::powerByLink();
        } else {
            $data['powered'] = '';
        }
        return $data;
    }


    public static function page_title_suffix($title)
    {
        if (defined('ROUTE_M') && ROUTE_M != 'installer') {
            if (ecjia_license::instance()->license_check()) {
                return '';
            }
        }
        $suffix = ' - ' . ecjia::powerByText();
        return $suffix;
    }

}