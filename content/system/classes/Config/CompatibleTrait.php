<?php

namespace Ecjia\System\Config;

use ecjia;

trait CompatibleTrait
{
    
    /**
	 * 返回当前终级类对象的实例
	 *
	 * @return object
	 */
	public static function instance()
	{
	    return royalcms('ecjia.config');
	}
    
	
	/**
	 * 强制重新加载config
	 */
	public function reload_config() 
	{
	    return true;
	}
	
	
	/**
	 * 载入全部配置信息
	 *
	 * @access  public
	 * @return  array
	 */
	public function load_config() 
	{
	    $all = $this->all();
	    return $all ? $all->toArray() : $all;
	}
	
	
	/**
	 * 清除配置文件缓存
	 */
	public function clear_cache() {
	    return $this->clearCache();
	}
	
	/**
	 * 检查配置项是否存在
	 * @param string $code
	 * @return boolean
	 */
	public function check_config($code)
	{
	    return $this->has($code);
	}
	
	/**
	 * 判断配置项值是否空, 为空是
	 * @param string $code
	 */
	public function check_exists($code)
	{
	    return $this->has($code);
	}
	
	
	/**
	 * 读取某项配置
	 * @param string $code
	 * @return string
	 */
	public function read_config($code)
	{
	    return $this->get($code);
	}
	
	
	/**
	 * 写入某项配置
	 * @param string $code
	 * @param string $value
	 */
	public function write_config($code, $value)
	{
	    return $this->write($code, $value);
	}
	
	
	/**
	 * 插入一个配置信息
	 *
	 * @access  public
	 * @param   string      $parent     分组的code
	 * @param   string      $code       该配置信息的唯一标识
	 * @param   string      $value      该配置信息值
	 * @return  void
	 */
	public function insert_config($parent, $code, $value, $options = array())
	{
	    return $this->add($parent, $code, $value, $options);
	}
	
	
	/**
	 * 删除配置项
	 * @param string $code
	 */
	public function delete_config($code)
	{
	    return $this->delete($code);
	}
	
	
	public function add_group($code, $id = null)
	{
	    return $this->addGroup($code, $id);
	}
	
	
	/**
	 * 检查配置项是否存在
	 * @param string $code
	 * @return boolean
	 */
	public function check_group($code)
	{
	    return $this->hasGroup($code);
	}
	
	
	public function load_group()
	{
	    return $this->getGroups()->toArray();
	}
	
	/**
	 * 读取某项配置
	 * @param string $code
	 * @return string|boolean
	 */
	public function read_group($code)
	{
	    return $this->getGroup($code);
	}
	
	
	/**
	 * 删除配置项
	 * @param string $code
	 */
	public function delete_group($code)
	{
	    return $this->deleteGroup($code);
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
	public function get_addon_config($code, $unserialize = false, $use_platform = false)
	{
	    return $this->getAddonConfig($code, $unserialize, $use_platform);
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
	public function set_addon_config($code, $value, $serialize = false, $use_platform = false)
	{
	    return $this->writeAddonConfig($code, $value, $serialize, $use_platform);
	}
    
}

// end