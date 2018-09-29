<?php

namespace Royalcms\Component\Swoole\Swoole\Socket;

interface PortInterface
{
    public function __construct(\swoole_server_port $port);
}