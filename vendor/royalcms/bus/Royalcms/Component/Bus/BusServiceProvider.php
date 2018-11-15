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
        $this->royalcms->singleton('Royalcms\Component\Bus\Dispatcher', function ($royalcms) {
            return new Dispatcher($royalcms, function () use ($royalcms) {
                return $royalcms['Royalcms\Component\Contracts\Queue\Queue'];
            });
        });

        $this->royalcms->alias(
            'Royalcms\Component\Bus\Dispatcher', 'Royalcms\Component\Contracts\Bus\Dispatcher'
        );

        $this->royalcms->alias(
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
