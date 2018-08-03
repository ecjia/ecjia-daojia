<?php

namespace Royalcms\Component\Swoole\Task;

use Royalcms\Component\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;

    public static function fire(self $event)
    {
        /**
         * @var \Swoole\Http\Server $swoole
         */
        $swoole = royalcms('swoole');
        $taskId = $swoole->task($event);
        return $taskId !== false;
    }
}