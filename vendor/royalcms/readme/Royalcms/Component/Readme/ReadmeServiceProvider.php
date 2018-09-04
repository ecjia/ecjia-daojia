<?php

namespace Royalcms\Component\Readme;

use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Support\ServiceProvider;
use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use Royalcms\Component\Readme\Services\ReadmeService;

class ReadmeServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('royalcms/readme');

        //publish configs.
        $this->publishes([
            __DIR__.'/../../../config/readme.php' => config_path('readme.php'),
        ], 'readme');

        //load routes
        $this->loadRoutesFrom(__DIR__.'/../../../routes/readme.php');

        //load views
        $viewPath = __DIR__.'/../../../resources/views';
        $this->loadViewsFrom($viewPath, 'readme');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // load config.
        $this->mergeConfigFrom(
            __DIR__.'/../../../config/readme.php', 'readme'
        );

        // ReadmeService.
        $this->royalcms->singleton('ReadmeService', function ($royalcms)
        {
            return new ReadmeService();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['readme'];
    }

}
