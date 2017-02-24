<?php

/**
 * @file
 *
 * Gearman Worker
 * @notice Gearman is required.
 */

namespace Gearman\Component\Gearman;

use GearmanWorker;
use GearmanException;

/**
 *
 * @see http://cn2.php.net/manual/zh/class.gearmanworker.php
 */
class Worker extends GearmanWorker {

    //服务端设置的超时
    protected $timeout = -1;    
   
    public function setOptions($options) {
        parent::addOptions($options);
        return $this;
    }
    
    public function setServer($host = '127.0.0.1', $port = 4730) {
        parent::addServer($host, $port);
        return $this;
    }
    
    public function setServers(array $servers) {
        foreach ($servers as $server) {
            if (is_string($server)) {
                $this->setServer($server);
            }
            elseif (isset($server[0]) && isset($server[1])) {
                $this->setServer($server[0], $server[1]);
            }
        }
        
        return $this;
    }
    
    public function setTimeout($timeout) {
        $timeout = (int) $timeout;
        if ($timeout <= 0) {
            $timeout = -1;
        }
        $this->timeout = $timeout;
        parent::setTimeout($timeout);
        
        return $this;
    }
    
    public function getTimeout() {
        return $this->timeout;
    }

    public function addFunctions($functions, $callback) {
        foreach ($functions as $function => $val) {
            $this->addFunction(strtr($function,'\\','_'), $callback);
        }
        
        return $this;
    }
    
    public function addFunction($function, $callback, $context = null, $timeout = 0) {
        if (isset($context)) {
            parent::addFunction($function, $callback, $context);
        }
        else {
            parent::addFunction($function, $callback);
        }
        
        return $this;
    }
    
    public function unregister($function) {
        parent::unregister($function);
        return $this;
    }
    
    public function unregisterAll() {
        parent::unregisterAll();
        return $this;
    }
    
    public function register($function, $timeout = 0) {
        parent::register($function, $timeout);
        return $this;
    }
    
    public function setId($id) {
        parent::setId($id);
        return $this;
    }
    
    public function run() {
        while (parent::work()) {
            switch (parent::returnCode()) {
                case GEARMAN_SUCCESS:                    
                case GEARMAN_IO_WAIT:
                case GEARMAN_NO_JOBS:
                    break;
                case GEARMAN_NO_ACTIVE_FDS:
                    sleep(5);
                    break;
                case GEARMAN_NOT_CONNECTED:
                case GEARMAN_COULD_NOT_CONNECT:
                    exit('disconnect');
                default:
                    exit('unknown error');
            }
        }
        $this->unregisterAll();
    }
    
}
