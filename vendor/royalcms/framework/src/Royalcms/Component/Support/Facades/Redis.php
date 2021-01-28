<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @method static \Illuminate\Redis\Connections\Connection connection(string $name = null)
 * @method static \Illuminate\Redis\Limiters\ConcurrencyLimiterBuilder funnel(string $name)
 * @method static \Illuminate\Redis\Limiters\DurationLimiterBuilder throttle(string $name)
 * 
 * @see \Royalcms\Component\Redis\Database
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
