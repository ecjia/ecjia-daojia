<?php


namespace Ecjia\System\AdminPanel\Subscribers;

use Royalcms\Component\Hook\Dispatcher;

class AdminPanelHookSubscriber
{

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Royalcms\Component\Hook\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {

        $events->addFilter(
            'create_admin_view',
            \Ecjia\System\AdminPanel\Hookers\CrateAdminViewFilter::class,
            9
        );

    }

}