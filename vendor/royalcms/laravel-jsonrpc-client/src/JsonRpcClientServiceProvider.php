<?php

namespace Royalcms\Laravel\JsonRpcClient;

use Illuminate\Support\ServiceProvider;


class JsonRpcClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publish();
    }

    /**
     * Publish config file.
     */
    protected function publish()
    {
        $source = realpath($raw = __DIR__.'/../config/rpc-services.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('rpc-services.php'),
            ]);
        }

        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom($source, 'rpc-services');
        }
    }

}
