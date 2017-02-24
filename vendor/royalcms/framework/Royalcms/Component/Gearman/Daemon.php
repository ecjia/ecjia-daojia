<?php

/**
 * @file
 *
 * Daemon
 */

namespace Gearman\Component\Gearman;

use Exception;

/**
 *
 * SIGNAL @see http://s99f.blog.163.com/blog/static/35118365201122861827837/
 */
class Daemon {
    
    //进程号
    protected $pid = 0;
    
    //是否为守护进程
    protected $isDaemon = false;
    
    //Woker进程数
    protected $numWorkers = 5;
    
    //Worker进程最大运行时间(秒)
    protected $maxRuntime = 3600;
    
    //worker进程清单: Daemon用来监控Worker进程列表
    protected $workers = array();
    
    //强制关闭worker进程的缓冲时间(秒)
    protected $buffTime = 60;
    
    //是否终止进程
    protected $stop = false; 
    
    //结束的时间
    protected $stopTime = 0;
    
    //运行用户
    protected $uid = 0;
    
    //运行用户组
    protected $gid = 0;
    
    //注册的服务器
    protected $servers = array();
    
    //前缀
    protected $prefix = '';
    
    /**
     * 析构函数
     *
     * 环境需求检测
     */
    public function __construct(array $config = array()) {
        if (!extension_loaded('posix')) {
            throw new Exception('Daemon needs support of posix extension.');
        }
        if (!extension_loaded('pcntl')) {
            throw new Exception('Daemon needs support of pcntl extension.');
        }
        foreach ($config as $key => $val) {
            switch ($key) {
                case 'numWorkers':
                case 'maxRuntime':
                case 'buffTime':
                case 'gid':
                case 'uid':
                case 'prefix':
                case 'servers':
                    $this->{$key} = $val;
                    break;
            }
        }
    }
    
    //开启子进程: Daemon进程
    public function start($simple = false) {
        //设置运行用户组和用户
        if ($this->gid) {
            posix_setgid($this->gid);
        }
        if ($this->uid) {
            posix_setuid($this->uid);
        }
        if ($simple) {
            $this->isDaemon = true;
            $this->pid = posix_getpid();
            $this->output("Daemon started with pid {$this->pid}");
            if (!posix_setsid()) {
                throw new Exception('Cannot detach from terminal.');
            }
            pcntl_signal(SIGTERM, array($this, 'signalHandler'));
            pcntl_signal(SIGINT,  array($this, 'signalHandler'));
            pcntl_signal(SIGHUP,  array($this, 'signalHandler'));
            pcntl_signal(SIGQUIT, array($this, 'signalHandler'));
            pcntl_signal(SIGUSR1, array($this, 'signalHandler'));
            pcntl_signal(SIGUSR2, array($this, 'signalHandler'));
            $this->startWorkers();
        } else {
            switch ($pid = pcntl_fork()) {
                //fork失败
                case -1:
                    throw new Exception('Cannot fork process.');
                    break;
                //子进程: Daemon进程
                case 0:
                    $this->isDaemon = true;
                    $this->pid = posix_getpid();
                    $this->output("Daemon started with pid {$this->pid}");
                    //提升为session leader
                    if (!posix_setsid()) {
                        throw new Exception('Cannot detach from terminal.');
                    }
                    //注册信号处理器
                    pcntl_signal(SIGTERM, array($this, 'signalHandler')); //自身正常退出
                    pcntl_signal(SIGUSR1, array($this, 'signalHandler')); //用户定义信号1
                    pcntl_signal(SIGUSR2, array($this, 'signalHandler')); //用户定义信号2
                    //开启孙子进程: worker进程
                    $this->startWorkers();
                    break;
                //父进程
                default:
                    exit;
            }
        }
        //如果无终止命令或者worker在跑,守护进程监控worker进程
        while ((!$this->stop || count($this->workers)) && $this->isDaemon) {
            $this->monitorWorkers();
            usleep(500000);
        }
    }
    
    //开启孙子进程: Worker进程
    public function startWorkers() {
        for ($i = 1; $i <= $this->numWorkers; $i++) {
            $this->startWorker();
        }
    }
    
    //开启worker进程
    public function startWorker() {
        switch ($pid = pcntl_fork()) {
            case -1:
                $this->output("Cannot fork worker process.");
                break;
            //Worker进程
            case 0:
                $this->isDaemon = false;
                $this->workers  = array();
                $this->pid = posix_getpid();
                $this->stopTime = time() + $this->maxRuntime;
                $this->output("Worker started with pid {$this->pid}");
                $this->runWorker($this->pid);
                exit(0);
            //Daemon进程
            default:
                $this->workers[$pid] = 1;
                break;
        }
    }
    
    //执行Worker
    public function runWorker($pid = 0) {
        $worker = new Worker();
        $worker->setTimeout(5000);
        if (!empty($this->servers) && is_array($this->servers)) {
            $worker->setServers($this->servers);
        } else {
            $worker->setServer();
        }
        $functions = \GearmanKernel::getFunctions(null, $this->prefix);
        if (empty($functions)) {
            $this->output("Worker has no functions");
            return false;
        }
        $worker->addFunctions($functions, array('GearmanKernel','responseGearman'));
        while (!$this->stop) {
            //@notice GearmanWork的work()默认是阻塞,所以上面设置了timeout
            if ($worker->work()) {
                switch ($worker->returnCode()) {
                    case GEARMAN_SUCCESS:                    
                    case GEARMAN_IO_WAIT:
                    case GEARMAN_NO_JOBS:
                        break;
                    case GEARMAN_NO_ACTIVE_FDS:
                        sleep(2);
                        break;
                    case GEARMAN_NOT_CONNECTED:
                    case GEARMAN_COULD_NOT_CONNECT:
                    case GEARMAN_LOST_CONNECTION:
                        $this->output("Try to stop worker with pid {$pid} [not connected]");
                        $this->stop = true;
                        break;
                    default:
                        $this->output("Try to stop worker with pid {$pid} [unknown gearman runcode]");
                        $this->stop = true;
                        break;
                }
            }
            //超过最大运行时间则退出
            if ($this->maxRuntime > 0 && time() > $this->stopTime) {
                $this->output("Try to stop worker with pid {$pid} [out of maxRuntime]");
                $this->stop = true;
            }
        }
        $worker->unregisterAll();
    }
    
    //监控孙子进程: Worker进程
    public function monitorWorkers() {
        $pid = pcntl_wait($status, WNOHANG);
        //如果有进程退出,并在Daemon的监控范围内
        if ($pid && isset($this->workers[$pid])) {
            unset($this->workers[$pid]);
            $this->output("Worker exited with pid {$pid}");
            //如果守护进程没有收到停止命令,则尝试重起孙子进程: Worker进程
            if (!$this->stop) {
                $this->startWorker();
            }
        }
        //如果接受了stop,超过缓冲时间的进程强制终止
        if ($this->stop && time() > $this->stopTime) {
            $this->output('Force stop workers ...');
            $this->stopWorkers(true);
        }
    }
    
    //终止Worker进程
    //@notice 如果Daemon的stop为FALSE,则只会重起Worker进程
    public function stopWorkers($force = false) {
        $signal = $force ? SIGKILL : SIGTERM;
        foreach ($this->workers as $pid => $val) {
            $this->output("Try to stop worker with pid {$pid} [signal:{$signal}]");
            posix_kill($pid, $signal);
            $this->workers[$pid]++;
            if ($this->workers[$pid] > 5) {
                unset($this->workers[$pid]);
            }
        }
    }
    
    //信号处理器
    public function signalHandler($signo) {
        //Daemon进程
        if ($this->isDaemon) {
            switch ($signo) {
                case SIGTERM:
                case SIGINT:
                case SIGHUP:
                case SIGQUIT:
                    $this->stop = true;
                    $this->stopTime = time() + $this->buffTime;
                    $this->stopWorkers();
                    break;
                case SIGUSR1:
                case SIGUSR2:
                    
                    break;
                default:
                    break;
            }
        }
        //Worker进程
        else {
            switch ($signo) {
                case SIGTERM:
                    $this->stop = true;
                    break;
                default:
                    break;
            }
        }
    }

    //输出信息
    public function output($msg) {
        try {
            logger('daemon')->info($msg);
        }
        catch (Exception $e) {}
    }
    
}
