<?php

namespace Royalcms\Component\Sms;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Sms\Manager;

class SmsServiceProvider extends ServiceProvider
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
    }
    
    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->package('royalcms/sms');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('sms', function () {
            return new Manager($this->royalcms);
        });
        
        // Load the alias
        $this->loadAlias();
    }
    
    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $this->royalcms->booting(function()
        {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('RC_Sms', 'Royalcms\Component\Sms\Facades\Sms');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sms'];
    }
}
