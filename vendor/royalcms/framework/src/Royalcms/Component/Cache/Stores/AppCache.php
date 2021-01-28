<?php

namespace Royalcms\Component\Cache\Stores;

use RC_Config;

class AppCache extends AbstractCache
{

    protected $name = 'app_cache';

    protected $app;

    /**
     * 获取默认config
     * @return array
     */
    protected function getDefaultConfig()
    {
        $config = [
            'driver' => 'file',
            'path'   => storage_path().'/cache',
            'expire' => 60, //分钟
        ];

        RC_Config::set('cache.stores.'.$this->name, $config);

        return $config;
    }

    protected function buildCacheKey($name)
    {
        if (!empty($this->app)) {
            $key = $this->app . ':' . $name;
        }
        else {
            $key = $name;
        }
        return $key;
    }

    /**
     * @return null
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @param null $app
     * @return AppCache
     */
    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }



}