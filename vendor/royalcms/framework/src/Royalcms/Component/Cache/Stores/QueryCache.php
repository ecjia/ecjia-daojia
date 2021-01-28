<?php

namespace Royalcms\Component\Cache\Stores;

use RC_Config;

class QueryCache extends AbstractCache
{

    protected $name = 'query_cache';

    /**
     * 获取默认config
     * @return array
     */
    protected function getDefaultConfig()
    {
        $config = [
            'driver' => 'file',
            'path'   => storage_path().'/temp/query_caches',
            'expire' => 60, //分钟
        ];

        RC_Config::set('cache.stores.'.$this->name, $config);

        return $config;
    }

    protected function buildCacheKey($name)
    {
        return $this->name . ':' . $name;;
    }

}