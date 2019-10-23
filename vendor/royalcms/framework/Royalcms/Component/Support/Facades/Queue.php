<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Queue\QueueManager
 * @see \Royalcms\Component\Queue\Queue
 */
class Queue extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'queue';
    }
}
