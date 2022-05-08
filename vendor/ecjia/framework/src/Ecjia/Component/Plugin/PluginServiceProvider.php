<?php


namespace Ecjia\Component\Plugin;


use Royalcms\Component\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPluginManager();
    }

    /**
     * Register the Plugin manager
     * \Ecjia\Component\Plugin\PluginManager
     *
     * @return void
     */
    public function registerPluginManager()
    {
        $this->royalcms->singleton('ecjia.plugin.manager', function($royalcms) {
            return new PluginManager($royalcms);
        });
    }

}