<?php

namespace Royalcms\Component\Pay;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Pay\Facades\Pay as RC_Pay;

class PayServiceProvider extends ServiceProvider
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
        /*
        $this->publishes([
            dirname(__DIR__).'/config/pay.php' => config_path('pay.php'), ],
            'royalcms-pay'
        );
        */
    }

    /**
     * Register the service.
     *
     * @return void
     */
    public function register()
    {
        $this->package('royalcms/pay');

        //$this->mergeConfigFrom($this->guessPackagePath('royalcms/pay').'/config/pay.php', 'pay');

        $this->royalcms->singleton('pay', function () {
            return new Pay([]);
        });

        $this->royalcms->singleton('pay.alipay', function ($royalcms, $config = null) {
            if (is_null($config)) {
                $config = config('pay::pay.alipay');
            }
            return RC_Pay::alipay($config);
        });
        $this->royalcms->singleton('pay.wechat', function ($royalcms, $config = null) {
            if (is_null($config)) {
                $config = config('pay::pay.wechat');
            }
            return RC_Pay::wechat($config);
        });
    }

    /**
     * Get services.
     *
     * @return array
     */
    public function provides()
    {
        return ['pay', 'pay.alipay', 'pay.wechat'];
    }
}
