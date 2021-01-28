<?php


namespace Ecjia\Component\Config\Models;


use RC_Cache;
use Illuminate\Support\Collection;

trait CacheTrait
{

    protected static $CACHE_KEY = 'shop_config';

    /**
     * 添加数据缓存
     * @param Collection $items
     */
    protected function setCache(Collection $items)
    {
        $items = $items->toArray();

        return RC_Cache::app_cache_set(self::$CACHE_KEY, $items, 'system');
    }


    /**
     * 获取数据缓存
     */
    protected function getCache()
    {
        $items = RC_Cache::app_cache_get(self::$CACHE_KEY, 'system');

        if (!empty($items) && is_array($items))
        {
            return collect($items);
        }

        return null;
    }


    /**
     * 清除数据缓存
     */
    public function clearCache()
    {
        return RC_Cache::app_cache_delete(self::$CACHE_KEY, 'system');
    }

}