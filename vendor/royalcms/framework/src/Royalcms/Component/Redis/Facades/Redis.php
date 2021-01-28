<?php

namespace Royalcms\Component\Redis\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Redis\RedisManager
 * @see \Royalcms\Component\Redis\Contracts\Factory
 */
class Redis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }
}
