<?php

namespace Royalcms\Component\Events;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms|\Illuminate\Contracts\Foundation\Application  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('events', function ($royalcms) {
            return (new Dispatcher($royalcms))->setQueueResolver(function () use ($royalcms) {
                return $royalcms->make(QueueFactoryContract::class);
            });
        });
    }

}
