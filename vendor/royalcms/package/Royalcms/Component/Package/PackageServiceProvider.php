<?php namespace Royalcms\Component\Package;

use Royalcms\Component\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider {
    
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
        $this->royalcms->bindShared('package', function($royalcms)
        {
            return new PackageManager($royalcms);
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('package');
    }
}
