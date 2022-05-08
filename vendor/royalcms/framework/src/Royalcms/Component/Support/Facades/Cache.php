<?php

namespace Royalcms\Component\Support\Facades;

use Royalcms\Component\Cache\Traits\CustomCacheScreenTrait;

/**
 * @method static \Illuminate\Contracts\Cache\Repository  store(string|null $name = null)
 * @method static bool has(string $key)
 * @method static bool missing(string $key)
 * @method static mixed get(string $key, mixed $default = null)
 * @method static mixed pull(string $key, mixed $default = null)
 * @method static bool put(string $key, $value, \DateTimeInterface|\DateInterval|int $ttl = null)
 * @method static bool add(string $key, $value, \DateTimeInterface|\DateInterval|int $ttl = null)
 * @method static int|bool increment(string $key, $value = 1)
 * @method static int|bool decrement(string $key, $value = 1)
 * @method static bool forever(string $key, $value)
 * @method static mixed remember(string $key, \DateTimeInterface|\DateInterval|int $ttl, \Closure $callback)
 * @method static mixed sear(string $key, \Closure $callback)
 * @method static mixed rememberForever(string $key, \Closure $callback)
 * @method static bool forget(string $key)
 * @method static \Illuminate\Contracts\Cache\Store getStore()
 *
 * @see \Royalcms\Component\Cache\CacheManager
 * @see \Royalcms\Component\Cache\Repository
 */
class Cache extends Facade
{
    use CustomCacheScreenTrait;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cache';
    }
}
