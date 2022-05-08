<?php


namespace Ecjia\System\Hookers;

use ecjia_loader;
use Royalcms\Component\Foundation\Royalcms;
use RC_Hook;
use RC_Loader;
use RC_Response;
use RC_Script;
use RC_Style;

/**
 * ECJia 初始化
 * Class EcjiaInitLoadAction
 * @package Ecjia\System\Hookers
 */
class EcjiaInitLoadAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        /* 初始化设置 */
        ini_set('memory_limit',          '128M');
        ini_set('display_errors',        1);

        RC_Response::header('X-Powered-By', 'ROYALCMS/' . Royalcms::VERSION . ' ' . APPNAME.'/'.VERSION);

        /**
         * 加载系统配置
         */
        RC_Loader::load_sys_config('constant');

        RC_Loader::load_sys_func('global');
        RC_Loader::load_sys_func('deprecated');
        RC_Loader::load_sys_func('extention');

        $rc_script = RC_Script::instance();
        $rc_style = RC_Style::instance();
        ecjia_loader::default_scripts($rc_script);
        ecjia_loader::default_styles($rc_style);

        /**
         * This hook is fired once ecjia, all plugins, and the theme are fully loaded and instantiated.
         *
         * @since 1.0.0
         */
        RC_Hook::do_action( 'ecjia_loaded' );
    }

}