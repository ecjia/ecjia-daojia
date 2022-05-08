<?php


namespace Royalcms\Component\Service;

use Royalcms\Component\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServiceService();
    }

    /**
     * Register the session manager instance.
     *
     * @return void
     */
    protected function registerServiceService()
    {
        $this->royalcms->singleton('service', function($royalcms) {
            return new ServiceManager($royalcms);
        });
    }


}