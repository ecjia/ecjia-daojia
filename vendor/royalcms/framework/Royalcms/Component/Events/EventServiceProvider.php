<?php

namespace Royalcms\Component\Events;

use Royalcms\Component\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('events', function ($royalcms) {
            return (new Dispatcher($royalcms))->setQueueResolver(function () use ($royalcms) {
                return $royalcms->make('Royalcms\Component\Contracts\Queue\Factory');
            });
        });
    }
}
