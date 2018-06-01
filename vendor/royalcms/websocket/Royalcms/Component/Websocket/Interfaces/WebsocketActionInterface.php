<?php

namespace Royalcms\Component\Websocket\Interfaces;

interface WebsocketActionInterface
{
    
    public function setWebsocket($websocket);

    public function handle($connectionId, $userId, $data, $meta);

}