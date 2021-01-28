<?php


namespace Royalcms\Component\Cron\Events;

/**
 * 'cron.jobSuccess'
 * Class CronJobSuccessEvent
 * @package Royalcms\Component\Cron\Events
 */
class CronJobSuccessEvent
{

    public $name;

    public $runtime;

    public $rundate;

    /**
     * CronJobSuccessEvent constructor.
     * @param $name
     * @param $runtime
     * @param $rundate
     */
    public function __construct($name, $runtime, $rundate)
    {
        $this->name    = $name;
        $this->runtime = $runtime;
        $this->rundate = $rundate;
    }


}