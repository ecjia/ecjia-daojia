<?php

namespace Royalcms\Component\Swoole\Traits;

use Royalcms\Component\Swoole\Inotify;
use Swoole\Server;
use Swoole\Process;

trait InotifyTrait
{
    use ProcessTitleTrait;
    use LogTrait;

    public function addInotifyProcess(Server $swoole, array $config)
    {
        if (empty($config['enable'])) {
            return;
        }

        if (!extension_loaded('inotify')) {
            $this->log('Require extension inotify', 'WARN');
            return;
        }

        $fileTypes = isset($config['file_types']) ? (array)$config['file_types'] : [];
        if (empty($fileTypes)) {
            $this->log('No file types to watch by inotify', 'WARN');
            return;
        }

        $autoReload = function () use ($swoole, $config, $fileTypes) {
            $log = !empty($config['log']);
            $this->setProcessTitle(sprintf('%s royalcms: inotify process', $config['process_prefix']));
            $inotify = new Inotify($config['root_path'], IN_CREATE | IN_DELETE | IN_MODIFY | IN_MOVE,
                function ($event) use ($swoole, $log) {
                    $swoole->reload();
                    if ($log) {
                        $this->log(sprintf('reloaded by inotify, file: %s', $event['name']));
                    }
                });
            $inotify->addFileTypes($fileTypes);
            $inotify->watch();
            if ($log) {
                $this->log(sprintf('count of watched files by inotify: %d', $inotify->getWatchedFileCount()));
            }
            $inotify->start();
        };

        $inotifyProcess = new Process($autoReload, false, false);
        if ($swoole->addProcess($inotifyProcess)) {
            return $inotifyProcess;
        }
    }

}