<?php

namespace Ecjia\System\Config;

use Royalcms\Component\Foundation\Royalcms;

class Config
{
    
    use CompatibleTrait;
    
    /**
     * The config repository implementation.
     *
     * @var \Ecjia\System\Config\ConfigRepositoryInterface
     */
    protected $repository;
    
    /**
     * Create a new config instance.
     *
     * @param  \Ecjia\System\Config\ConfigRepositoryInterface  $repository
     * @return void
     */
    public function __construct(ConfigRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
  
    /**
     * Get the config repository instance.
     *
     * @return \Ecjia\System\Config\ConfigRepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }
    
    
    /**
     * Get the all codes.
     *
     * @return array
     */
    public function allKeys()
    {
        return $this->getRepository()->allKeys();
    }
    
    public function all()
    {
        return $this->getRepository()->all();
    }
    
    /**
     * Get the specified configuration value.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->getRepository()->get($key, $default);
    }
    
    
    /**
     * Set a given configuration value.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function set($key, $value)
    {
        return $this->getRepository()->set($key, $value);
    }
    
    
    /**
     * Write a given configuration value.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function write($key, $value)
    {
        return $this->getRepository()->write($key, $value);
    }
    
    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return $this->getRepository()->has($key);
    }
    
    /**
     * 添加配置项
     *
     * @param string $group
     * @param string $key
     * @param string $value
     * @param array $options
     * @return bool
     */
    public function add($group, $key, $value, $options = [])
    {
        return $this->getRepository()->add($group, $key, $value, $options);
    }
    
    /**
     * 修改配置项
     *
     * @param string $group
     * @param string $key
     * @param string $value
     * @param array $options
     * @return bool
     */
    public function change($group, $key, $value, $options = [])
    {
        return $this->getRepository()->change($group, $key, $value, $options);
    }
    
    /**
     * 删除某个配置项
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->getRepository()->delete($key);
    }
    
    
    /**
     * Get all groups.
     */
    public function getGroups()
    {
        return $this->getRepository()->getGroups();
    }
    
    
    /**
     * Determine if a configuration group exists.
     *
     * @param  string  $group
     * @return bool
     */
    public function hasGroup($group)
    {
        return $this->getRepository()->hasGroup($group);
    }
    
    /**
     * Get the specified configuration value.
     *
     * @param  string  $group
     * @param  mixed   $default
     * @return mixed
     */
    public function getGroup($group, $default = null)
    {
        return $this->getRepository()->getGroup($group, $default);
    }
    
    
    public function deleteGroup($group)
    {
        return $this->getRepository()->deleteGroup($group);
    }
    
    
    public function addGroup($group, $id = null)
    {
        return $this->getRepository()->addGroup($group, $id);
    }
    
    public function clearCache()
    {
        return $this->getRepository()->clearCache();
    }
    
    /**
     * 获取插件的配置项
     * addon_app_actives
     * addon_plugin_actives
     * addon_widget_actives
     * @param string $type
     * @param string $code
     * @param string|array $value
     */
    public function getAddonConfig($code, $unserialize = false, $use_platform = false)
    {
        return $this->getRepository()->getAddonConfig($code, $unserialize, $use_platform);
    }
    
    /**
     * 更新插件的配置项
     * addon_app_actives
     * addon_plugin_actives
     * addon_widget_actives
     * @param string $type
     * @param string $code
     * @param string|array $value
     */
    public function writeAddonConfig($code, $value, $serialize = false, $use_platform = false)
    {
        return $this->getRepository()->writeAddonConfig($code, $value, $serialize, $use_platform);
    }
     
}

// end