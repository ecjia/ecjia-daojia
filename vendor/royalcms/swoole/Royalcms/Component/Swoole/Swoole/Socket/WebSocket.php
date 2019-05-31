<?php

namespace Royalcms\Component\Swoole\Swoole\Socket;

use Swoole\Server\Port;

abstract class WebSocket implements PortInterface, WebSocketInterface
{
    protected $swoolePort;

    public function __construct(Port $port)
    {
        $this->swoolePort = $port;
    }
}