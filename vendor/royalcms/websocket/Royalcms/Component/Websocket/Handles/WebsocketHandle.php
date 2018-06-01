<?php

namespace Royalcms\Component\Websocket\Handles;

use Royalcms\Component\Websocket\Interfaces\WebsocketHandleInterface;
use GuzzleHttp\json_encode;

class WebsocketHandle implements WebsocketHandleInterface
{
    protected $websocket;
    
    public function start($websocket)
    {
        $this->websocket = $websocket;
    }
    
    public function connect($data)
    {
        $this->log("DataReceive: ".json_encode($data));
        
        return $data = array(
            'user_id' => 1,
        );
        
    }
    
    public function disconnect($connectionId, $userId)
    {
        
    }
    
    public function loop()
    {
        
    }

    // Action handlers
    public  function action($connectionId, $userId, $action, $data)
    {
        
        $this->log(sprintf('connection_id: %s, user_id: %s, data: %s, action: %s', $connectionId, $userId, json_encode($data), $action));
        
        
    }
    
    
    public function log($text)
    {
        echo date("Y-m-d H:m:s") . " ". $text . "\n";
    }

}

// end