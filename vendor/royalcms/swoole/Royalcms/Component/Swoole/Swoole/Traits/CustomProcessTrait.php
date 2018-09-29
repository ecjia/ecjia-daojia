<?php

namespace Royalcms\Component\Swoole\Swoole\Traits;

use Royalcms\Component\Swoole\Swoole\Process\CustomProcessInterface;

trait CustomProcessTrait
{
    use ProcessTitleTrait;
    use RoyalcmsTrait;

    public function addCustomProcesses(\swoole_server $swoole, $processPrefix, array $processes, array $royalcmsConfig)
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
            $customProcess = new \swoole_process($processHandler, $process::isRedirectStdinStdout(), $process::getPipeType());
            if ($swoole->addProcess($customProcess)) {
                $processList[] = $customProcess;
            }
        }
        return $processList;
    }

}