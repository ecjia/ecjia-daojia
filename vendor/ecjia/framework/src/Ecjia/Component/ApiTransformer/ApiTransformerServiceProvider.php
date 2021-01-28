<?php


namespace Ecjia\Component\ApiTransformer;


use Royalcms\Component\Support\ServiceProvider;

class ApiTransformerServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->registerApiTransformerManager();
    }

    /**
     * 注册
     */
    protected function registerApiTransformerManager()
    {
        $this->royalcms->singleton('ecjia.api.transformer', function($royalcms) {
            return new TransformerManager();
        });
    }

}