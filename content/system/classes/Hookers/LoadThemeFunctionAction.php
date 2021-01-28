<?php


namespace Ecjia\System\Hookers;

use ecjia;
use RC_Hook;
use RC_Loader;
use RC_Theme;

/**
 * 加载主题扩展文件
 * Class LoadThemeFunctionAction
 * @package Ecjia\System\Hookers
 */
class LoadThemeFunctionAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        //加载API应用functions.func.php
        if (defined('RC_SITE') && RC_SITE == 'api') {
            RC_Loader::load_app_func('functions', 'api');
        }

        if (config('system.tpl_force_specify')) {
            $this->_load_default_style();
        }
        else {

            $app = config('site.main_app');
            if ($app) {
                RC_Loader::load_app_func('functions', $app);
                $this->_load_custom_handle_style();
            }
            else {
                $request = royalcms('request');
                if ($request->getBasePath() != '') {
                    $this->_load_default_style();
                }
                else {
                    $this->_load_custom_handle_style();
                }
            }

        }

        //加载主题框架functions.php
        $dir = RC_Theme::get_template_directory();
        if (file_exists($dir . DS . 'functions.php')) {
            include_once $dir . DS . 'functions.php';
        }

    }


    /**
     * 加载自定义的Handle主题模板
     */
    protected function _load_custom_handle_style()
    {
        RC_Hook::add_filter('template', function () {
            $template_code = RC_Hook::apply_filters('ecjia_theme_template_code', 'template');
            return ecjia::config($template_code);
        });
    }

    /**
     * 加载默认配置中的主题模板
     */
    protected function _load_default_style()
    {
        RC_Hook::add_filter('template', function () {
            return config('system.tpl_style');
        });
    }

}