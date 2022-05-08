<?php


namespace Royalcms\Component\Cron\Events;

/**
 * 'cron.jobError'
 * Class CronJobErrorEvent
 * @package Royalcms\Component\Cron\Events
 */
class CronJobErrorEvent
{

    public $name;

    public $return;

    public $runtime;

    public $rundate;

    /**
     * CronJobErrorEvent constructor.
     * @param $name
     * @param $return
     * @param $runtime
     * @param $rundate
     */
    public function __construct($name, $return, $runtime, $rundate)
    {
        $this->name    = $name;
        $this->return  = $return;
        $this->runtime = $runtime;
        $this->rundate = $rundate;
    }


}