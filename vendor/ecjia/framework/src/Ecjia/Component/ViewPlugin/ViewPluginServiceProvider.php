<?php


namespace Ecjia\Component\ViewPlugin;


use Royalcms\Component\Support\ServiceProvider;

class ViewPluginServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->registerViewPlugin();
    }

    /**
     * 注册验证码场景
     */
    protected function registerViewPlugin()
    {
        $this->royalcms->singleton('ecjia.view.plugin', function($royalcms) {
            return new ViewPluginManager();
        });
    }

}