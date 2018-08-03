<?php

namespace Royalcms\Component\Swoole\Traits;

use Royalcms\Component\Swoole\Timer\CronJob;
use Swoole\Server;
use Swoole\Process;

trait TimerTrait
{
    use ProcessTitleTrait;
    use RoyalcmsTrait;
    use LogTrait;

    public function addTimerProcess(Server $swoole, array $config, array $royalcmsConfig)
    {
        if (empty($config['enable']) || empty($config['jobs'])) {
            return;
        }

        $startTimer = function () use ($swoole, $config, $royalcmsConfig) {
            $this->setProcessTitle(sprintf('%s swoole: timer process', $config['process_prefix']));
            $this->initRoyalcms($royalcmsConfig, $swoole);
            foreach ($config['jobs'] as $jobClass) {
                $job = new $jobClass();
                if (!($job instanceof CronJob)) {
                    throw new \Exception(sprintf('%s must implement the abstract class %s', get_class($job), '\Royalcms\Component\Swoole\Timer\CronJob'));
                }
                $timerId = swoole_timer_tick($job->interval(), function () use ($job) {
                    try {
                        $job->run();
                    } catch (\Exception $e) {
                        $this->logException($e);
                    }
                });
                $job->setTimerId($timerId);
                if ($job->isImmediate()) {
                    swoole_timer_after(1, function () use ($job) {
                        try {
                            $job->run();
                        } catch (\Exception $e) {
                            $this->logException($e);
                        }
                    });
                }
            }
        };

        $timerProcess = new Process($startTimer, false, false);
        if ($swoole->addProcess($timerProcess)) {
            return $timerProcess;
        }
    }

}