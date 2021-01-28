<?php

namespace Royalcms\Component\Cache\Stores;

use RC_Config;
use RC_Cache;

abstract class AbstractCache implements SpecialStoreInterface
{

    protected $name;

    protected $config;

    public function __construct()
    {
        if (empty($this->name)) {
            $this->name = 'file';
        }

        $this->config = RC_Config::get('cache.stores.'.$this->name);

        if (empty($this->config)) {
            $this->config = $this->getDefaultConfig();
        }
    }

    protected function buildCacheKey($name)
    {
        return $name;
    }

    /**
     * 获取默认config
     * @return array
     */
    abstract protected function getDefaultConfig();

    /**
     * 快速设置APP缓存数据
     *
     * @since 3.4
     *
     * @param string $name
     * @param string|array $data
     */
    public function set($name, $data, $expire = null)
    {
        $expire = $expire ?: $this->config['expire'];
        $key = $this->buildCacheKey($name);
        return RC_Cache::store($this->name)->put($key, $data, $expire);
    }
    
    /**
     * 快速添加APP缓存数据，如果name已经存在，则返回false
     *
     * @since 3.4
     *
     * @param string $name
     * @param string|array $data
     */
    public function add($name, $data, $expire = null)
    {
        $expire = $expire ?: $this->config['expire'];
        $key = $this->buildCacheKey($name);
        return RC_Cache::store($this->name)->add($key, $data, $expire);
    }
    
    /**
     * 快速获取APP缓存数据
     *
     * @since 3.4
     *
     * @param string $name
     */
    public function get($name)
    {
        $key = $this->buildCacheKey($name);
        return RC_Cache::store($this->name)->get($key);
    }
    
    /**
     * 快速删除APP缓存数据
     *
     * @since 3.4
     *
     * @param string $name
     */
    public function delete($name)
    {
        $key = $this->buildCacheKey($name);
        return RC_Cache::store($this->name)->forget($key);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     * @return AbstractCache
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }


}