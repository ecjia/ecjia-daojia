<?php

namespace Royalcms\Component\Swoole\Console;

use Royalcms\Component\Console\Command;
use Swoole\Process;
use Symfony\Component\Console\Input\InputOption;

class SwooleCommand extends Command
{
    protected $name = 'swoole';

    protected $description = 'Start RoyalcmsSwoole console tool';

    protected $actions;

    public function __construct()
    {
        $this->actions = ['start', 'stop', 'restart', 'reload'];
        $actions = implode('|', $this->actions);
//         $this->name .= sprintf(' {action : %s}', $actions);
        $this->description .= ': ' . $actions;

        parent::__construct();
    }

    public function fire()
    {
        $this->handle();
    }
    
    /**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
    {
        return array(
            array('action', null, InputOption::VALUE_REQUIRED, 'action : start|stop|restart|reload|publish', null),
        );
    }

    public function handle()
    {
        $action = (string)$this->argument('action');
        if (!in_array($action, $this->actions, true)) {
            $this->warn(sprintf('Royalcms Swoole: action %s is not available, only support %s', $action, implode('|', $this->actions)));
            return;
        }

        $this->{$action}();
    }

    protected function outputLogo()
    {
        static $logo = <<<EOS
ROYALCMS SWOOLE
EOS;
        $this->info($logo);
        $this->info('Speed up your Royalcms');
        $this->table(['Component', 'Version'], [
            ['Component' => 'PHP', 'Version' => phpversion()],
            ['Component' => 'Swoole', 'Version' => \swoole_version()],
            ['Component' => $this->getApplication()->getName(), 'Version' => $this->getApplication()->getVersion()],
        ]);
    }

    protected function start()
    {
        $this->outputLogo();

        $svrConf = config('swoole::swoole');
        $basePath = array_get($svrConf, 'base_path', base_path());

        if (empty($svrConf['swoole']['document_root'])) {
            $svrConf['swoole']['document_root'] = $basePath;
        }
        if (empty($svrConf['process_prefix'])) {
            $svrConf['process_prefix'] = $basePath;
        }
        if (!empty($svrConf['events'])) {
            if (empty($svrConf['swoole']['task_worker_num']) || $svrConf['swoole']['task_worker_num'] <= 0) {
                $this->error('RoyalcmsSwoole: Asynchronous event listening needs to set task_worker_num > 0');
                return;
            }
        }

        $royalcmsConf = [
            'root_path'          => $basePath,
            'static_path'        => $svrConf['swoole']['document_root'],
            'register_providers' => array_unique((array)array_get($svrConf, 'register_providers', [])),
            '_SERVER'            => $_SERVER,
            '_ENV'               => $_ENV,
        ];

        if (file_exists($svrConf['swoole']['pid_file'])) {
            $pid = (int)file_get_contents($svrConf['swoole']['pid_file']);
            if ($this->killProcess($pid, 0)) {
                $this->warn(sprintf('RoyalcmsSwoole: PID[%s] is already running at %s:%s.', $pid, $svrConf['listen_ip'], $svrConf['listen_port']));
                return;
            }
        }

        // Implements gracefully reload, avoid including royalcms's files before worker start
        $path = realpath(__DIR__ . '/../GoSwoole.php');
        $cmd = sprintf("%s %s", PHP_BINARY, $path);
        
        $ret = $this->popen($cmd, json_encode(compact('svrConf', 'royalcmsConf')));
        if ($ret === false) {
            $this->error('RoyalcmsSwoole: popen ' . $cmd . ' failed');
            return;
        }

        $pidFile = empty($svrConf['swoole']['pid_file']) ? storage_path('swoole.pid') : $svrConf['swoole']['pid_file'];

        // Make sure that master process started
        $time = 0;
        while (!file_exists($pidFile) && $time <= 20) {
            usleep(100000);
            $time++;
        }
        if (file_exists($pidFile)) {
            $this->info(sprintf('RoyalcmsSwoole: PID[%s] is running at %s:%s.', file_get_contents($pidFile), $svrConf['listen_ip'], $svrConf['listen_port']));
        } else {
            $this->error(sprintf('RoyalcmsSwoole: PID file[%s] does not exist.', $pidFile));
        }
    }

    protected function popen($cmd, $input = null)
    {
        $fp = popen($cmd, 'w');
        if ($fp === false) {
            return false;
        }
        if ($input !== null) {
            fwrite($fp, $input);
        }
        pclose($fp);
        return true;
    }

    protected function stop()
    {
        $pidFile = config('swoole::swoole.pid_file') ?: storage_path('swoole.pid');
        if (file_exists($pidFile)) {
            $pid = (int)file_get_contents($pidFile);
            if ($this->killProcess($pid, 0)) {
                if ($this->killProcess($pid, SIGTERM)) {
                    // Make sure that master process quit
                    $time = 0;
                    while ($this->killProcess($pid, 0) && $time <= 20) {
                        usleep(100000);
                        $this->killProcess($pid, SIGTERM);
                        $time++;
                    }
                    if (file_exists($pidFile)) {
                        unlink($pidFile);
                    }
                    $this->info("RoyalcmsSwoole: PID[{$pid}] is stopped.");
                } else {
                    $this->error("RoyalcmsSwoole: PID[{$pid}] is stopped failed.");
                }
            } else {
                $this->warn("RoyalcmsSwoole: PID[{$pid}] does not exist, or permission denied.");
                if (file_exists($pidFile)) {
                    unlink($pidFile);
                }
            }
        } else {
            $this->info('RoyalcmsSwoole: already stopped.');
        }
    }

    protected function restart()
    {
        $this->stop();
        $this->start();
    }

    protected function reload()
    {
        $pidFile = config('swoole::swoole.pid_file') ?: storage_path('swoole.pid');
        if (!file_exists($pidFile)) {
            $this->error('RoyalcmsSwoole: it seems that Swoole is not running.');
            return;
        }

        $pid = (int)file_get_contents($pidFile);
        if (!$this->killProcess($pid, 0)) {
            $this->error("RoyalcmsSwoole: PID[{$pid}] does not exist, or permission denied.");
            return;
        }

        if ($this->killProcess($pid, SIGUSR1)) {
            $this->info("RoyalcmsSwoole: PID[{$pid}] is reloaded.");
        } else {
            $this->error("RoyalcmsSwoole: PID[{$pid}] is reloaded failed.");
        }
    }


    protected function killProcess($pid, $sig)
    {
        try {
            return Process::kill($pid, $sig);
        } catch (\Exception $e) {
            return false;
        }
    }
    
}
