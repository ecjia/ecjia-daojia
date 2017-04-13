<?php namespace Royalcms\Component\Purifier;

use Royalcms\Component\Foundation\Royalcms;
use Royalcms\Component\Support\ServiceProvider;

class PurifierServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     *
     * @return null
     */
    public function boot()
    {
        $this->setupConfig();
        
        require __DIR__ . '/helpers.php';
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->package('royalcms/purifier');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('purifier', function (Royalcms $royalcms) {
            return new Purifier($royalcms['files'], $royalcms['config']);
        });

        $this->royalcms->alias('purifier', 'Royalcms\Component\Purifier\Purifier');
        
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
            $loader->alias('RC_Purifier', 'Royalcms\Component\Purifier\Facades\Purifier');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['purifier'];
    }
}
