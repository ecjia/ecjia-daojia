<?php

namespace Royalcms\Component\Support\Facades;

use Royalcms\Component\Cache\SpecialStores\AppCache;
use Royalcms\Component\Cache\SpecialStores\UserDataCache;
use Royalcms\Component\Cache\SpecialStores\TableCache;
use Royalcms\Component\Cache\SpecialStores\QueryCache;
use Royalcms\Component\Cache\SpecialStores\MemoryCache;

/**
 * @see \Royalcms\Component\Cache\CacheManager
 * @see \Royalcms\Component\Cache\Repository
 */
class Cache extends Facade
{
    use AppCache, UserDataCache, TableCache, QueryCache, MemoryCache;

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
