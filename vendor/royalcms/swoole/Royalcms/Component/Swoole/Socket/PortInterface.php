<?php

namespace Royalcms\Component\Swoole\Socket;

use Swoole\Server\Port;

interface PortInterface
{
    public function __construct(Port $port);
}