<?php

namespace Royalcms\Component\SmartyView;

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
        $dir = static::guessPackageClassPath('royalcms/smarty-view');

        return [
//            $dir . '/Cache/KeyValueStorage.php',
//            $dir . '/Cache/Memcached.php',
//            $dir . '/Cache/Redis.php',
            $dir . '/Cache/Storage.php',
            $dir . '/Console/CacheClearCommand.php',
            $dir . '/Console/ClearCompiledCommand.php',
            $dir . '/Console/OptimizeCommand.php',
            $dir . '/SmartyFactory.php',
            $dir . '/FileViewFinder.php',
            $dir . '/Engines/SmartyEngine.php',
            $dir . '/SmartyServiceProvider.php',
            $dir . '/SmartyConsoleServiceProvider.php',
        ];
    }
}
