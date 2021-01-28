<?php

namespace Royalcms\Component\Cache\Stores;

use RC_Config;

class TableCache extends AbstractCache
{

    protected $name = 'table_cache';

    /**
     * 获取默认config
     * @return array
     */
    protected function getDefaultConfig()
    {
        $config = [
            'driver' => 'file',
            'path'   => storage_path().'/temp/table_caches',
            'expire' => 1200 //分钟
        ];

        RC_Config::set('cache.stores.'.$this->name, $config);

        return $config;
    }

    protected function buildCacheKey($name)
    {
        return $this->name . ':' . $name;;
    }
}