<?php

namespace Royalcms\Component\Swoole\Foundation\Console;

use Royalcms\Component\Console\Command;
use Swoole\Process;
use Symfony\Component\Console\Input\InputOption;


class SwooleCommand extends Command
{
    protected $name = 'swoole';

    protected $description = 'Start Royalcms Swoole console tool';

    protected $actions;

    public function __construct()
    {
        $this->actions = ['start', 'stop', 'restart', 'reload'];
        $actions = implode('|', $this->actions);
//        $this->signature .= sprintf(' {action : %s} {--d|daemonize : Whether run as a daemon for start & restart} {--i|ignore : Whether ignore checking process pid for start & restart}', $actions);
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
            array('action', InputOption::VALUE_REQUIRED, 'action : start|stop|restart|reload', null),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('daemonize', 'd', InputOption::VALUE_OPTIONAL, 'daemonize : Whether run as a daemon for start & restart', null),
            array('ignore', 'i', InputOption::VALUE_OPTIONAL, 'ignore : Whether ignore checking process pid for start & restart', null),
        );
    }

    public function handle()
    {
        $action = (string)$this->argument('action');
        if (!in_array($action, $this->actions, true)) {
            $this->warn(sprintf('Royalcms Swoole: action %s is not available, only support %s', $action, implode('|', $this->actions)));
            return 127;
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
                $this->error('Royalcms Swoole: Asynchronous event listening needs to set task_worker_num > 0');
                return 1;
            }
        }
        if ($this->option('daemonize')) {
            $svrConf['swoole']['daemonize'] = true;
        }

        $royalcmsConf = [
            'root_path'          => $basePath,
            'static_path'        => $svrConf['swoole']['document_root'],
            'register_providers' => array_unique((array)array_get($svrConf, 'register_providers', [])),
            '_SERVER'            => $_SERVER,
            '_ENV'               => $_ENV,
        ];

        if (!$this->option('ignore') && file_exists($svrConf['swoole']['pid_file'])) {
            $pid = (int)file_get_contents($svrConf['swoole']['pid_file']);
            if ($pid > 0 && $this->killProcess($pid, 0)) {
                $this->warn(sprintf('Royalcms Swoole: PID[%s] is already running at %s:%s.', $pid, $svrConf['listen_ip'], $svrConf['listen_port']));
                return 1;
            }
        }

        if (!$svrConf['swoole']['daemonize']) {
            $this->info(sprintf('Royalcms Swoole: Swoole is listening at %s:%s.', $svrConf['listen_ip'], $svrConf['listen_port']));
        }

        // Implements gracefully reload, avoid including royalcms's files before worker start
        $path = realpath(__DIR__ . '/../../GoSwoole.php');
        $cmd = sprintf("%s %s", PHP_BINARY, $path);

        $ret = $this->popen($cmd, json_encode(compact('svrConf', 'royalcmsConf')));
        if ($ret === false) {
            $this->error('Royalcms Swoole: popen ' . $cmd . ' failed');
            return 1;
        }

        $pidFile = empty($svrConf['swoole']['pid_file']) ? storage_path('swoole.pid') : $svrConf['swoole']['pid_file'];

        // Make sure that master process started
        $time = 0;
        while (!file_exists($pidFile) && $time <= 20) {
            usleep(100000);
            $time++;
        }
        if (file_exists($pidFile)) {
            $this->info(sprintf('Royalcms Swoole: PID[%s] is running at %s:%s.', file_get_contents($pidFile), $svrConf['listen_ip'], $svrConf['listen_port']));
            return 0;
        } else {
            $this->error(sprintf('Royalcms Swoole: PID file[%s] does not exist.', $pidFile));
            return 1;
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
        if (!file_exists($pidFile)) {
            $this->info('Royalcms Swoole: already stopped.');
            return 0;
        }

        $pid = (int)file_get_contents($pidFile);
        if ($this->killProcess($pid, 0)) {
            if ($this->killProcess($pid, SIGTERM)) {
                // Make sure that master process quit
                $time = 1;
                $waitTime = config('swoole::swoole.max_wait_time', 60);
                while ($this->killProcess($pid, 0)) {
                    if ($time > $waitTime) {
                        $this->error("Royalcms Swoole: PID[{$pid}] cannot be stopped gracefully in {$waitTime}s, will be stopped forced right now.");
                        return 1;
                    }
                    $this->warn("Royalcms Swoole: Waiting PID[{$pid}] to stop. [{$time}]");
                    sleep(1);
                    $time++;
                }
                if (file_exists($pidFile)) {
                    unlink($pidFile);
                }
                $this->info("Royalcms Swoole: PID[{$pid}] is stopped.");
                return 0;
            } else {
                $this->error("Royalcms Swoole: PID[{$pid}] is stopped failed.");
                return 1;
            }
        } else {
            $this->warn("Royalcms Swoole: PID[{$pid}] does not exist, or permission denied.");
            if (file_exists($pidFile)) {
                unlink($pidFile);
            }
            return $this->option('ignore') ? 0 : 1;
        }
    }

    protected function restart()
    {
        $exitCode = $this->stop();
        if ($exitCode !== 0) {
            return $exitCode;
        }
        return $this->start();
    }

    protected function reload()
    {
        $pidFile = config('swoole::swoole.pid_file') ?: storage_path('swoole.pid');
        if (!file_exists($pidFile)) {
            $this->error('Royalcms Swoole: it seems that Swoole is not running.');
            return 1;
        }

        $pid = (int)file_get_contents($pidFile);
        if (!$this->killProcess($pid, 0)) {
            $this->error("Royalcms Swoole: PID[{$pid}] does not exist, or permission denied.");
            return 1;
        }

        if ($this->killProcess($pid, SIGUSR1)) {
            $now = date('Y-m-d H:i:s');
            $this->info("Royalcms Swoole: PID[{$pid}] is reloaded at {$now}.");
            return 0;
        } else {
            $this->error("RoyalcmsSwoole: PID[{$pid}] is reloaded failed.");
            return 1;
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
