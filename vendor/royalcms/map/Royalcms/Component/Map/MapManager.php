<?php

namespace Royalcms\Component\Map;

use Royalcms\Component\Support\Manager;
use Royalcms\Component\Map\Maps\AmapMap;
use Royalcms\Component\Map\Maps\BaiduMap;
use Royalcms\Component\Map\Maps\QQMap;

class MapManager extends Manager
{
    /**
     * Web map ServiceApi version
     */
    const VERSION = '1.0';
    
    /**
     * Get a filesystem instance.
     *
     * @param  string  $name
     * @return 
     */
    public function drive($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
    
        return $this->drivers[$name] = $this->get($name);
    }
    
    /**
     * Attempt to get the pool from the file cache.
     *
     * @param  string  $name
     * @return 
     */
    protected function get($name)
    {
        return isset($this->drivers[$name]) ? $this->drivers[$name] : $this->resolve($name);
    }
    
    /**
     * Resolve the given pool.
     *
     * @param  string  $name
     * @return 
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
    
        if (isset($this->customCreators[$config['driver']]))
        {
            return $this->callCustomCreator($config);
        }
    
        return $this->{"create".ucfirst($config['driver'])."Driver"}($config);
    }
    
    /**
     * Create an instance of the amap map driver.
     *
     * @return 
     */
    protected function createAmapDriver(array $config)
    {
        return new AmapMap();
    }
    
    /**
     * Create an instance of the baidu map driver.
     *
     * @return 
     */
    protected function createBaiduDriver(array $config)
    {
        return new BaiduMap();
    }
    
    /**
     * Create an instance of the qq map driver.
     *
     * @return 
     */
    protected function createQqDriver(array $config)
    {
        return new QQMap();
    }
    
    
    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->royalcms['config']['map::config.default'];
    }
    
    /**
     * Set the default cache driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->royalcms['config']['map::config.default'] = $name;
    }
    
    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->drive(), $method), $parameters);
    }

}