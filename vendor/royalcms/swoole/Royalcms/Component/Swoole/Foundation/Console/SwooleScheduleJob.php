<?php

namespace Royalcms\Component\Swoole\Foundation\Console;

use Royalcms\Component\Swoole\Swoole\Timer\CronJob;

class SwooleScheduleJob extends CronJob
{
    protected $artisan;

    public function __construct()
    {
        $this->artisan = royalcms('Royalcms\Component\Contracts\Console\Kernel');
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