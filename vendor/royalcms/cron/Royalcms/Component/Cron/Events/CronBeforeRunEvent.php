<?php


namespace Royalcms\Component\Cron\Events;

/**
 * 'cron.beforeRun'
 * Class CronBeforeRunEvent
 * @package Royalcms\Component\Cron\Events
 */
class CronBeforeRunEvent
{

    public $rundate;

    /**
     * CronBeforeRun constructor.
     * @param $rundate
     */
    public function __construct($rundate)
    {
        $this->rundate = $rundate;
    }


}