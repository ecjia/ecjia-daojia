<?php

namespace Royalcms\Component\Repository\Traits;

use Closure;
use Royalcms\Component\DateTime\Carbon;
use Royalcms\Component\Cache\CacheManager;
use Royalcms\Component\Database\Eloquent\Model;

trait Cacheable
{
    /**
     * Cache instance
     *
     * @var CacheManager
     */
    protected static $cache = null;

    /**
     * Flush the cache after create/update/delete events.
     *
     * @var bool
     */
    protected $eventFlushCache = false;

    /**
     * Global lifetime of the cache.
     *
     * @var int
     */
    protected $cacheMinutes = 60;

    /**
     * Set cache manager.
     *
     * @param CacheManager $cache
     */
    public static function setCacheInstance(CacheManager $cache)
    {
        self::$cache = $cache;
    }

    /**
     * Get cache manager.
     *
     * @return CacheManager
     */
    public static function getCacheInstance()
    {
        if (self::$cache === null) {
            self::$cache = royalcms('cache');
        }

        return self::$cache;
    }

    /**
     * Determine if the cache will be skipped
     *
     * @return bool
     */
    public function skippedCache()
    {
        return config('repository::repositories.cache_enabled', false) === false
            || royalcms('request')->has(config('repository::repositories.cache_skip_param', 'skipCache')) === true;
    }

    /**
     * Get Cache key for the method
     *
     * @param  string $method
     * @param  mixed  $args
     * @param  string  $tag
     *
     * @return string
     */
    public function getCacheKey($method, $args = null, $tag)
    {
        // Sort through arguments
        foreach($args as &$a) {
            if ($a instanceof Model) {
                $a = get_class($a).'|'.$a->getKey();
            }
        }

        // Create hash from arguments and query
        $args = serialize($args) . serialize($this->getScopeQuery());

        return sprintf('%s-%s@%s-%s',
            config('system.locale'),
            $tag,
            $method,
            md5($args)
        );
    }

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param string   $method
     * @param array    $args
     * @param \Closure $callback
     * @param  int     $time
     *
     * @return mixed
     */
    public function cacheCallback($method, $args, Closure $callback, $time = null)
    {
        // Cache disabled, just execute query & return result
        if ($this->skippedCache() === true) {
            return call_user_func($callback);
        }

        // Use the called class name as the tag
        $tag = get_called_class();

        return self::getCacheInstance()->tags(['repositories', $tag])->remember(
            $this->getCacheKey($method, $args, $tag),
            $this->getCacheExpiresTime($time),
            $callback
        );
    }

    /**
     * Flush the cache for the given repository.
     *
     * @return bool
     */
    public function flushCache()
    {
        // Cache disabled, just ignore this
        if ($this->eventFlushCache === false || config('repository::repositories.cache_enabled', false) === false) {
            return false;
        }

        // Use the called class name as the tag
        $tag = get_called_class();

        return self::getCacheInstance()->tags(['repositories', $tag])->flush();
    }

    /**
     * Return the time until expires in minutes.
     *
     * @param int $time
     *
     * @return int
     */
    protected function getCacheExpiresTime($time = null)
    {
        if ($time === self::EXPIRES_END_OF_DAY) {
            return class_exists('Royalcms\Component\DateTime\Carbon')
                ? round(Carbon::now()->secondsUntilEndOfDay() / 60)
                : $this->cacheMinutes;
        }

        return $time ?: $this->cacheMinutes;
    }
}