<?php

namespace Ecjia\System\Providers;

use Royalcms\Component\Contracts\Events\Dispatcher as DispatcherContract;
use Royalcms\Component\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Ecjia\System\Events\SomeEvent' => [
            'Ecjia\System\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Royalcms\Component\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
