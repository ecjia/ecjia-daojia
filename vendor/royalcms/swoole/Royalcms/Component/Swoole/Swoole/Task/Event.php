<?php

namespace Royalcms\Component\Swoole\Swoole\Task;

use Royalcms\Component\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;

    public static function fire(self $event)
    {
        /**
         * @var \swoole_http_server $swoole
         */
        $swoole = royalcms('swoole');
        $taskId = $swoole->task($event);
        return $taskId !== false;
    }
}