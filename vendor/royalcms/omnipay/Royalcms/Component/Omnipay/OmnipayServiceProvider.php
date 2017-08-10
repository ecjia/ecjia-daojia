<?php 

namespace Royalcms\Component\Omnipay;

use Royalcms\Component\Support\ServiceProvider;
use Omnipay\Common\GatewayFactory;

class OmnipayServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
    public function boot()
    {
        $this->package('royalcms/omnipay');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManager();
    }

    /**
     * Register the Omnipay manager
     */
    public function registerManager()
    {
        $this->royalcms->singleton('omnipay', function ($royalcms) {
            $factory = new GatewayFactory;
            $manager = new OmnipayManager($royalcms, $factory);

            return $manager;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['omnipay'];
    }

}