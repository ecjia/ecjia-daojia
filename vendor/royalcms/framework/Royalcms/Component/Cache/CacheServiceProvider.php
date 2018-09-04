<?php

namespace Royalcms\Component\Cache;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Cache\Console\ClearCommand;
use Royalcms\Component\Cache\Console\CacheTableCommand;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('cache', function ($royalcms) {
            return new CacheManager($royalcms);
        });

        $this->royalcms->singleton('cache.store', function ($royalcms) {
            return $royalcms['cache']->driver();
        });

        $this->royalcms->singleton('memcached.connector', function () {
            return new MemcachedConnector;
        });

        $this->registerCommands();
    }

    /**
     * Register the cache related console commands.
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->royalcms->singleton('command.cache.clear', function ($royalcms) {
            return new ClearCommand($royalcms['cache']);
        });

        $this->royalcms->singleton('command.cache.table', function ($royalcms) {
            return new CacheTableCommand($royalcms['files'], $royalcms['composer']);
        });

        $this->commands('command.cache.clear', 'command.cache.table');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'cache', 'cache.store', 'memcached.connector', 'command.cache.clear', 'command.cache.table',
        ];
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        return [
            __DIR__ . "/SpecialStores/AppCache.php",
            __DIR__ . "/SpecialStores/UserDataCache.php",
            __DIR__ . "/SpecialStores/TableCache.php",
            __DIR__ . "/SpecialStores/QueryCache.php",
            __DIR__ . "/SpecialStores/MemoryCache.php",
        ];
    }
}
