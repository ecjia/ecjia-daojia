<?php

namespace Royalcms\Component\Websocket;

use GuzzleHttp\json_encode;
class Websocket 
{
	
	private $connections = array();	// Array to save 
	
	public $server;
	
	public $handler;

	public $queueHandle;
	
	public function __construct($host = 'localhost', $port = 8000, $ssl = false)
	{
		$this->server = new Server($host, $port, $ssl);
		$this->server->setMaxClients(100);
		$this->server->setCheckOrigin(false);
		$this->server->setAllowedOrigin('192.168.1.153');
		$this->server->setMaxConnectionsPerIp(100);
		$this->server->setMaxRequestsPerMinute(2000);
		$this->server->setHook($this);
	}

	public function setHooks($handler, $actions, $queueHandle)
    {
        $this->handler = $handler;
        $this->actions = $actions;
        $this->queueHandle = $queueHandle;
    }
	
	public function serve()
	{
	    $this->handler->start($this);
		$this->server->run();
	}
	
	/* Fired when a socket trying to connect */
	public function onConnect($connection_id)
	{
        return true;
    }
    
	/* Fired when a socket disconnected */
    public function onDisconnect($connection_id)
	{
		if (isset($this->connections[$connection_id])) {
			$this->handler->disconnect($this->connections[$connection_id]);
			unset($this->connections[$connection_id]);
		}
    }
    
	/* Fired when data received */
    public function onDataReceive($connection_id, $jsondata)
	{
		$data = json_decode($jsondata, true);
		
		if (! is_null($data)) {
		    if (isset($data['action'])) {
		    
		        $action = $data['action'];
		        	
		        if ($action == 'register') {
		    
		            $this->log("|||| $connection_id: REGISTER " . json_encode($data));
		    
		            if (($data = $this->handler->connect($data)) !== false) {
		                $this->connections[$connection_id] = $connection_id;
		                $this->users[$connection_id] = $data['user_id'];
		                $data['message'] = "Registration confirmed";
		                $this->server->sendData($connection_id, 'registred', $data);
		            }
		    
		        } elseif (!empty($this->actions[$action])) {
		    
		            $this->log("<<<< $connection_id: $action " . json_encode($data));
		            if (isset($this->connections[$connection_id])) {
		                
		                $handle = royalcms($this->actions[$action]);
		                $handle->setWebsocket($this);
		                $handle->handle(
                            $this->connections[$connection_id],
                            $this->users[$connection_id],
                            $data,
                            $this->actions[$action]
                        );
		                
		                //@todo queue
		                /*
		                $this->queueHandle->pushInQueue(
		                    $this->connections[$connection_id],
		                    $this->users[$connection_id],
		                    $data,
		                    $this->actions[$action]
		                );
		                */
		            }
		    
		        } else {
		    
		            $this->handler->action(
		                $this->connections[$connection_id],
		                $this->users[$connection_id],
		                $action,
		                $data
		            );
		            $this->log("Caution : Action handler '$action' not found!");
		        }
		    }
		    
		} else {
		    //@todo 测试
		    $this->handler->connect($jsondata);
		}
		
    }
	
	/* Used to send data to particular connection */
	public function sendData($key, $action, $data)
	{
		if (($id = $this->findBYKey($key)) !== false) {
			$this->log(">>>> $key: $action ". json_encode($data));
			$this->server->sendData($id, $action, $data);
		}
	}

	public function broadcast($action, $data)
    {
        $this->log(">>>> BROADCAST: $action ". json_encode($data));
        foreach ($this->connections as $connectionId => $external) {
            $this->server->sendData($connectionId, $action, $data);
        }
    }

	public function findBYKey($key)
	{
		$keys = array_flip($this->connections);
		if (isset($keys[$key])) {
			return $keys[$key];
		}
		return false;
	}

	public function loop()
    {
        while ($data = $this->queueHandle->popOutQueue()) {
            $to = $data['to'];
            if (!empty($to['broadcast']) && $to['broadcast']) {
                $this->broadcast($data['action'], $data['data']);
            }
            if (!empty($to['connection_id']) && $to['connection_id']) {
                $this->sendData($to['connection_id'], $data['action'], $data['data']);
            }
            if (!empty($to['user_id']) && $to['user_id']) {
                $connectionIDs = array_keys($this->users, $to['user_id']);
                foreach ($connectionIDs as $connectionID) {
                    $this->sendData($connectionID, $data['action'], $data['data']);
                }
            }
        }
        $this->handler->loop();
    }

    public function log($text)
    {
        echo date("Y-m-d H:m:s") . " ". $text . "\n";
    }
}

// end