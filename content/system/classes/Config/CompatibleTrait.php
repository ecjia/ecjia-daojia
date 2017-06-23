<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//


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
	    return $this->all();
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