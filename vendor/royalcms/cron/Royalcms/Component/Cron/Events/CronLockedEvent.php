<?php


namespace Royalcms\Component\Cron\Events;

/**
 * 'cron.locked'
 * Class CronLockedEvent
 * @package Royalcms\Component\Cron\Events
 */
class CronLockedEvent
{

    public $lockfile;

    /**
     * CronLockedEvent constructor.
     * @param $lockfile
     */
    public function __construct($lockfile)
    {
        $this->lockfile = $lockfile;
    }


}