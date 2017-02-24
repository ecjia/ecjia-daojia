<?php

/**
 * @file
 *
 * Gearman Client
 * @notice Gearman is required.
 */

namespace Gearman\Component\Gearman;

use GearmanClient;

/**
 *
 * @see http://cn2.php.net/manual/zh/class.gearmanclient.php
 */
class Client {
    
    //配置
    protected $config = array(
        'timeout'       => -1, //服务端任务认领超时
        'clientTimeout' => 0,  //客户端等待超时
        'servers'       => array(
            array('localhost', 4730),
        ),
    );
   
    //实例
    protected $client;
    
    function __construct($config = array()) {
        if (empty($config)) {
            $config = array();
        }
        $this->config = $config + $this->config;
        $this->client = new GearmanClient();
        $this->setServers($this->config['servers'])
             ->setTimeout($this->config['timeout']);
    }
    
    public function setServer($host = '127.0.0.1', $port = 4730) {
        $this->client->addServer($host, $port);
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
        $this->config['timeout'] = $timeout;
        $this->client->setTimeout($timeout);
        return $this;
    }
    
    public function setClientTimeout($timeout) {
        $this->config['clientTimeout'] = (int) $timeout / 1000;
        return $this;
    }
    
    public function doNormal($func, $workload, $unique = null) {
        $timer = microtime(true);
        do {
            if ($unique) {
                $result = $this->client->doNormal($func, $workload, $unique);
            } else {
                $result = $this->client->doNormal($func, $workload);
            }
            switch ($this->client->returnCode()) {
                case GEARMAN_SUCCESS:
                    break 2;
                case GEARMAN_WORK_FAIL:
                    $result = null;                    
                    break 2;
                case GEARMAN_NOT_CONNECTED:
                case GEARMAN_COULD_NOT_CONNECT:
                case GEARMAN_LOST_CONNECTION:
                    $result = null;           
                    break 2;
                default:
                    break 2;
            }
            if ($this->config['clientTimeout'] && (microtime(true) - $timer > $this->config['clientTimeout'])) {
                $result = null;                
                break;
            }
            if ($this->config['clientTimeout'] && (microtime(true) - $timer < $this->config['clientTimeout'])) {
                usleep(10000);
            }
        }
        while ($this->client->returnCode() != GEARMAN_SUCCESS);

        return $result;
    }
    
    public function doBackground($func, $workload, $unique = null) {
        return $this->client->doBackground($func, msgpack_pack($workload), $unique);
    }
    
}
