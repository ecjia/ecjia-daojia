<?php namespace Royalcms\Component\SmartyView;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class SmartyCompileServiceProvider
 *
 */
class SmartyCompileServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function compiles()
    {
        return [
            base_path() . '/vendor/royalcms/smarty-view/Smarty/Cache/Memcached.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/Cache/Redis.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/Cache/Storage.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/Console/CacheClearCommand.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/Console/ClearCompiledCommand.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/Console/OptimizeCommand.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/SmartyFactory.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/Engines/SmartyEngine.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/SmartyServiceProvider.php',
            base_path() . '/vendor/royalcms/smarty-view/Smarty/SmartyConsoleServiceProvider.php',
            base_path() . '/vendor/smarty/smarty/libs/Smarty.class.php',
            base_path() . '/vendor/smarty/smarty/libs/Autoloader.php',
        ];
    }
}
