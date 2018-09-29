<?php

namespace Royalcms\Component\Pay;

use Royalcms\Component\Support\ServiceProvider;

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
     * @author yansongda <me@yansongda.cn>
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/config/pay.php' => config_path('pay.php'), ],
            'royalcms-pay'
        );
    }

    /**
     * Register the service.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/config/pay.php', 'pay');

        $this->royalcms->singleton('pay.alipay', function () {
            return Pay::alipay(config('pay.alipay'));
        });
        $this->royalcms->singleton('pay.wechat', function () {
            return Pay::wechat(config('pay.wechat'));
        });
    }

    /**
     * Get services.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return array
     */
    public function provides()
    {
        return ['pay.alipay', 'pay.wechat'];
    }
}
