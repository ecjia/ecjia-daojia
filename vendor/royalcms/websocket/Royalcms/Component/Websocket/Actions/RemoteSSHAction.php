<?php

namespace Royalcms\Component\Websocket\Actions;

use Royalcms\Component\Websocket\Interfaces\WebsocketActionInterface;

class RemoteSSHAction implements WebsocketActionInterface
{
    protected $websocket;
    
    public function setWebsocket($websocket)
    {
        $this->websocket = $websocket;
    }
    
    
    // Action handlers
    public  function handle($connectionId, $userId, $data, $meta)
    {
        
        $this->log(sprintf('connect_id: %s, user_id: %s, data: %s, meta: %s', $connectionId, $userId, json_encode($data), json_encode($meta)));
        
        
        $hostname = $data['host'].':'.$data['port'];
        $username = 'root';
        $password = $data['password'];
        
        $config = royalcms('config');
        $connections['websocket'] = array(
            'host'      => $hostname,
            'username'  => $username,
            'password'  => $password,
            'key'       => '',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 3600,
            'root'      => '/var/www',
        );
        
        $config->set('remote::remote.connections', $connections);
        
        $server = $this->websocket->server;
        
        \RC_SSH::into('websocket')->run([
        	'hostname',
            'yum update -y',
            'yum remove php* mysql* -y',
            'yum install php* mysql* -y',
            'hostname',
            'hostname',
            'hostname',
            'hostname',
            'hostname',
            'hostname',
            'hostname',
        ], function ($line) use ($server, $connectionId, $userId) {
            
            $data['message'] = $line;
            $data['user_id'] = $userId;
                
            $server->sendData($connectionId, 'remote_ssh', $data);
        });
    }
    
    public function log($text)
    {
        echo date("Y-m-d H:m:s") . " ". $text . "\n";
    }

}