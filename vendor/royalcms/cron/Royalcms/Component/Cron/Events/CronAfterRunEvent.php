<?php


namespace Royalcms\Component\Cron\Events;

/**
 * 'cron.afterRun'
 * Class CronAfterRunEvent
 * @package Royalcms\Component\Cron\Events
 */
class CronAfterRunEvent
{

    public $rundate;

    public $inTime = -1;

    public $runtime = -1;

    public $errors = 0;

    public $crons = [];

    public $lastRun = [];

    /**
     * CronAfterRunEvent constructor.
     * @param $rundate
     * @param int $inTime
     * @param int $runtime
     * @param int $errors
     * @param array $crons
     * @param array $lastRun
     */
    public function __construct($rundate, int $inTime = -1, int $runtime = -1, int $errors = 0, array $crons = [], array $lastRun = [])
    {
        $this->rundate = $rundate;
        $this->inTime  = $inTime;
        $this->runtime = $runtime;
        $this->errors  = $errors;
        $this->crons   = $crons;
        $this->lastRun = $lastRun;
    }


}