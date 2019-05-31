<?php

namespace Royalcms\Component\Swoole\Swoole\Socket;

use Swoole\Server\Port;

abstract class Http implements PortInterface, HttpInterface
{
    /**
     * @var  \Swoole\Server\Port
     */
    protected $swoolePort;

    public function __construct(Port $port)
    {
        $this->swoolePort = $port;
    }
}