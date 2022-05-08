<?php


namespace Royalcms\Component\Cron\Events;

/**
 * 'cron.collectJobs'
 * Class CronCollectJobsEvent
 * @package Royalcms\Component\Cron\Events
 */
class CronCollectJobsEvent
{
    public $rundate;

    /**
     * CronCollectJobsEvent constructor.
     * @param $rundate
     */
    public function __construct($rundate)
    {
        $this->rundate = $rundate;
    }


}