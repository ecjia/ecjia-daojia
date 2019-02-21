<?php

namespace Royalcms\Component\Metable;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Metable\DataType\Registry;

/**
 * Royalcms-Metable Service Provider.
 *
 */
class MetableServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        /*
        $this->publishes([
            __DIR__.'/../../config/metable.php' => config_path('metable.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../migrations/2017_01_01_000000_create_meta_table.php' => database_path('migrations/'.date('Y_m_d_His').'_create_meta_table.php'),
        ], 'migrations');
        */
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /*
        $this->mergeConfigFrom(
            __DIR__.'/../../config/metable.php', 'metable'
        );
        */

        $this->package('royalcms/metable');

        $this->registerDataTypeRegistry();
    }

    /**
     * Add the DataType Registry to the service container.
     *
     * @return void
     */
    protected function registerDataTypeRegistry()
    {
        $this->royalcms->singleton(Registry::class, function () {
            $registry = new Registry();
            foreach (config('metable::metable.datatypes') as $handler) {
                $registry->addHandler(new $handler());
            }

            return $registry;
        });
        $this->royalcms->alias(Registry::class, 'metable.datatype.registry');
    }
}
