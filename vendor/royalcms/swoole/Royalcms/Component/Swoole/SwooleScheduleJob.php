<?php

namespace Royalcms\Component\Swoole;

use Royalcms\Component\Swoole\Timer\CronJob;

class RoyalcmsScheduleJob extends CronJob
{
    protected $artisan;

    public function __construct()
    {
        $this->artisan = royalcms('Royalcms\Component\Console\Contracts\Kernel');
    }

    public function interval()
    {
        return 60 * 1000;// Run every 1 minute
    }

    public function isImmediate()
    {
        return false;
    }

    public function run()
    {
        $this->artisan->call('schedule:run');
    }
}