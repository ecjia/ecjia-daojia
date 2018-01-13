<?php

namespace Royalcms\Component\Redis;

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Support\ServiceProvider;

class RedisServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('redis', function ($royalcms) {
            $config = $royalcms->make('config')->get('database.redis');

            return new RedisManager(Arr::pull($config, 'client', 'predis'), $config);
        });

        $this->royalcms->bind('redis.connection', function ($royalcms) {
            return $royalcms['redis']->connection();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['redis', 'redis.connection'];
    }
}
