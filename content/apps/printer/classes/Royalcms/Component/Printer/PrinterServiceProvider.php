<?php

namespace Royalcms\Component\Printer;

use Royalcms\Component\Support\ServiceProvider;

class PrinterServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {}


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('printer', function () {
            return new Factory();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['printer'];
    }
}
