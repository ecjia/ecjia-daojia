<?php

namespace Royalcms\Component\Shouqianba;

use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Shouqianba\Gateways\Shouqianba;
use Royalcms\Component\Support\ServiceProvider;

class ShouqianbaServiceProvider extends ServiceProvider
{
    /**
     * If is defer.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service.
     *
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service.
     *
     * @return void
     */
    public function register()
    {
        $this->package('royalcms/shouqianba');

        //$this->mergeConfigFrom($this->guessPackagePath('royalcms/shouqianba').'/config/pay.php', 'shouqianba');

        $this->royalcms['pay']->extend('shouqianba', function (Config $config) {
            return royalcms('pay.shouqianba');
        });

        $this->royalcms->singleton('pay.shouqianba', function ($royalcms) {
            return $royalcms['pay']->make(Shouqianba::class);
        });

    }

    /**
     * Get services.
     *
     * @return array
     */
    public function provides()
    {
        return ['pay.shouqianba'];
    }
}
