<?php


namespace Ecjia\System\Hookers;

use ecjia_app;
use RC_Lang;
use RC_Gettext;

/**
 * 加载应用模块的语言包
 * Class EcjiaLoadLangAction
 * @package Ecjia\System\Hookers
 */
class EcjiaLoadLangAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $apps = ecjia_app::app_floders();

        foreach ($apps as $app) {

	        self::loadTranslationLang($app);

            if (royalcms('config')->get('system.locale') != 'zh_CN') {
                self::loadGettextLang($app);
            }
        }
    }

    public static function loadTranslationLang($app)
    {
        $namespace = $app;

        $dir = SITE_CONTENT_PATH . 'apps/' . $app . '/languages';
        $dir2 = RC_CONTENT_PATH . 'apps/' . $app . '/languages';

        if (is_dir($dir)) {
            $path = $dir;
        } elseif (is_dir($dir2)) {
            $path = $dir2;
        } else {
            $path = null;
        }

        if ($path) {
            RC_Lang::addNamespace($namespace, $path);
        }
    }

    public static function loadGettextLang($app)
    {
        RC_Gettext::loadAppTextdomain($app);
    }

}