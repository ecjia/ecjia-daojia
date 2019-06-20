<?php 

namespace Royalcms\Component\Ucenter;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Ucenter\Client\Ucenter;

class UcenterServiceProvider extends ServiceProvider
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
        // Default config
        $this->royalcms['config']->package('royalcms/ucenter', __DIR__ . '/../../../config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->bind('ucenter', function ($royalcms) {
            return new Ucenter;
        });

        $this->royalcms->bind('ucenter.service', function ($royalcms) {
            $class = config('ucenter::ucenter.service');
            return new $class;
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
            $loader->alias('RC_Ucenter', 'Royalcms\Component\Ucenter\Facades\Ucenter');
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('ucenter');
    }
}
