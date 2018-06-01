<?php

namespace Royalcms\Component\Websocket\Interfaces;

interface WebsocketHandleInterface
{

    public function start($websocket);
    
    public function connect($data);

    public function disconnect($connectionId, $userId);

    public function loop();

    public function action($connectionId, $userID, $action, $data);

}