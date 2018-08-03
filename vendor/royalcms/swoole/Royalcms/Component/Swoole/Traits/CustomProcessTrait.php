<?php

namespace Royalcms\Component\Swoole\Traits;

use Royalcms\Component\Swoole\Process\CustomProcessInterface;
use Swoole\Server;
use Swoole\Process;

trait CustomProcessTrait
{
    use ProcessTitleTrait;
    use RoyalcmsTrait;

    public function addCustomProcesses(Server $swoole, $processPrefix, array $processes, array $royalcmsConfig)
    {
        $this->initRoyalcms($royalcmsConfig, $swoole);
        
        /**
         * @var []CustomProcessInterface $processList
         */
        $processList = [];
        foreach ($processes as $process) {
            $processHandler = function () use ($swoole, $processPrefix, $process, $royalcmsConfig) {
                $name = $process::getName() ?: 'custom';
                $this->setProcessTitle(sprintf('%s royalcms: %s process', $processPrefix, $name));
                $this->initRoyalcms($royalcmsConfig, $swoole);
                $process::callback($swoole);
            };
            $customProcess = new Process($processHandler, $process::isRedirectStdinStdout(), $process::getPipeType());
            if ($swoole->addProcess($customProcess)) {
                $processList[] = $customProcess;
            }
        }
        return $processList;
    }

}