<?php

namespace Royalcms\Component\Shouqianba;

use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Shouqianba;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Pay\Facades\Pay as RC_Pay;

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
            return new Shouqianba($config);
        });

        $this->royalcms->singleton('pay.shouqianba', function ($royalcms, $config = null) {
            if (is_null($config)) {
                $config = config('shouqianba::pay.shouqianba');
            }
            return RC_Pay::shouqianba($config);
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
