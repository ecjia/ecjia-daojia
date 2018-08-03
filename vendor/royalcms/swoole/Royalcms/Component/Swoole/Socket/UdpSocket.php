<?php

namespace Royalcms\Component\Swoole\Socket;

use Swoole\Server\Port;
use Swoole\Server;

abstract class UdpSocket implements PortInterface, UdpInterface
{
    /**
     * @var  \Swoole\Server\Port
     */
    protected $swoolePort;

    public function __construct(Port $port)
    {
        $this->swoolePort = $port;
    }

    abstract public function onPacket(Server $server, $data, array $clientInfo);
}