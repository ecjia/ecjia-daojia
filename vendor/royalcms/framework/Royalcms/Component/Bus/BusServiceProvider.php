<?php

namespace Royalcms\Component\Bus;

use Royalcms\Component\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
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
        $this->app->singleton('Royalcms\Component\Bus\Dispatcher', function ($app) {
            return new Dispatcher($app, function ($connection = null) use ($app) {
                return $app['Royalcms\Component\Contracts\Queue\Factory']->connection($connection);
            });
        });

        $this->app->alias(
            'Royalcms\Component\Bus\Dispatcher', 'Royalcms\Component\Contracts\Bus\Dispatcher'
        );

        $this->app->alias(
            'Royalcms\Component\Bus\Dispatcher', 'Royalcms\Component\Contracts\Bus\QueueingDispatcher'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Royalcms\Component\Bus\Dispatcher',
            'Royalcms\Component\Contracts\Bus\Dispatcher',
            'Royalcms\Component\Contracts\Bus\QueueingDispatcher',
        ];
    }
}
