<?php


namespace Ecjia\Component\CaptchaScreen;


use Royalcms\Component\Support\ServiceProvider;

class CaptchaScreenServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->registerCaptchaScreen();
    }

    /**
     * 注册验证码场景
     */
    protected function registerCaptchaScreen()
    {
        $this->royalcms->singleton('ecjia.captcha.screen', function($royalcms) {
            return new CaptchaScreenManager();
        });
    }

}