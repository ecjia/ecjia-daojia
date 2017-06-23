<?php

namespace Royalcms\Component\Alidayu;

use Royalcms\Component\Support\ServiceProvider;

class AlidayuServiceProvider extends ServiceProvider
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
    {
        $this->setupConfig();

        $this->royalcms['alidayu']->configure($this->royalcms['config']->get('alidayu::config'));
    }
    
    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->package('royalcms/alidayu');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('alidayu', function () {
            return new Factory($this->royalcms);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['alidayu'];
    }
}
