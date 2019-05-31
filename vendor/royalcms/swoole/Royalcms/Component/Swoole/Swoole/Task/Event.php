<?php

namespace Royalcms\Component\Swoole\Swoole\Task;

use Royalcms\Component\Queue\SerializesModels;
use Swoole\Http\Server as HttpServer;
use Swoole\WebSocket\Server as WebSocketServer;

abstract class Event
{
    use SerializesModels;

    public static function fire(self $event)
    {
        /**@var HttpServer|WebSocketServer $swoole */
        $swoole = royalcms('swoole');
        $taskId = $swoole->task($event);
        return $taskId !== false;
    }
}