<?php

namespace Royalcms\Component\Uploader;

use Royalcms\Component\Support\ServiceProvider;

class UploaderServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('royalcms/uploader');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('uploader', function ($royalcms) {
            return new UploaderManager($royalcms);
        });

        $this->royalcms->alias('uploader', 'Royalcms\Component\Uploader\Contracts\Factory');

        $this->royalcms->singleton('uploader.from', function ($royalcms) {
            return $royalcms['uploader']->from();
        });

        $this->royalcms->alias('uploader.from', 'Royalcms\Component\Uploader\Contracts\Uploader');
        
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
            $loader->alias('RC_Uploader', 'Royalcms\Component\Uploader\Facades\Uploader');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['uploader', 'uploader.from'];
    }
}
