<?php


namespace Ecjia\App\Cron\Subscribers;


use Ecjia\App\Cron\CronJobManager;
use RC_Cron;
use Royalcms\Component\Hook\Dispatcher;

class ConsoleHookSubscriber
{

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Royalcms\Component\Hook\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        if (!class_exists('RC_Cron')) {
            return;
        }

        // Log only error jobs to database
//        RC_Cron::setLogOnlyErrorJobsToDatabase(true);
        // Add a cron job
        (new CronJobManager())->addCronJobs();
    }

}