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

use Closure;
use ArrayAccess;
use ecjia;
use Ecjia\System\Config\Exceptions\ConfigGroupRepeatException;

class DatabaseConfigRepository implements ConfigRepositoryInterface, ArrayAccess {

	/**
	 * The default group.
	 *
	 * @var string
	 */
	protected $defaultGroup = 'shop';

	/**
	 * All of the configuration items.
	 *
	 * @var array
	 */
	protected $items = array();

	/**
	 * The after load callbacks for namespaces.
	 *
	 * @var array
	 */
	protected $afterLoad = array();
	
	/**
	 * The name of the config table model.
	 *
	 * @var string
	 */
	protected $tableModel;
	
	/**
	 * A cache of the parsed items.
	 *
	 * @var array
	 */
	protected $parsed = array();

	/**
	 * Create a new configuration repository.
	 *
	 * @param  \Ecjia\System\Config\ConfigModel  $tableModel
	 * @return void
	 */
	public function __construct($tableModel)
	{
		$this->tableModel = $tableModel;
	}
	
	/**
	 * Get the all codes.
	 *
	 * @return array
	 */
	public function allKeys()
	{
	    $itemKeys = array_keys($this->all());
	    $groupKeys = array_keys($this->getGroups());
	    return array_merge($groupKeys, $itemKeys);
	}
	
	/**
	 * Get the all codes.
	 *
	 * @return array
	 */
	public function all()
	{
	    $this->load('shop');
	     
	    $collection = array_get($this->items, 'shop');
	    
	    return $collection->toArray();
	}

	/**
	 * Determine if the given configuration value exists.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function has($key)
	{
		$default = microtime(true);

		return $this->get($key, $default) !== $default;
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
		list($group, $item) = $this->parseKey($key);

		// Configuration items are actually keyed by "collection", which is simply a
		// combination of each namespace and groups, which allows a unique way to
		// identify the arrays of configuration items for the particular files.
		$collection = $this->getCollection($group);

		$this->load($collection);

		return array_get($this->items[$collection], $item, $default);
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
		list($group, $item) = $this->parseKey($key);

		$collection = $this->getCollection($group);

		// We'll need to go ahead and lazy load each configuration groups even when
		// we're just setting a configuration item so that the set item does not
		// get overwritten if a different item in the group is requested later.
		$this->load($collection);

		if (is_null($item))
		{
			$this->items[$collection] = $value;
		}
		else
		{
			$this->items[$collection]->set($item, $value);
		}
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
	    list($group, $item) = $this->parseKey($key);

        $this->tableModel->writeItem($item, $value);
        
        $this->set($key, $value);
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
	    list($agroup, $item) = $this->parseKey($key);
	    
	    if ($this->has($item)) {
	        return false;
	    }
        
	    if (! $this->hasGroup($group)) {
	        $group_id = $this->addGroup($group);
	    } else {
	        $group_id = $this->getGroup($group);
	    }

	    $collection = $this->getCollection($agroup);
	    
	    $this->items[$collection]->put($item, $value);
	    
	    return $this->tableModel->addItem($group_id, $item, $value, $options);
	}
	
	/**
	 * 修改Item类型及值
	 *
	 * @param string $group
	 * @param string $key
	 * @param string $value
	 * @param array $options
	 * @return bool
	 */
	public function change($group, $key, $value, $options = [])
	{
	    list($agroup, $item) = $this->parseKey($key);
	    
	    if (! $this->has($item))
	    {
	        return false;
	    }
	    
	    if (! $this->hasGroup($group)) {
	        $group_id = $this->addGroup($group);
	    } else {
	        $group_id = $this->getGroup($group);
	    }

	    $collection = $this->getCollection($agroup);
	    
	    $this->items[$collection]->set($item, $value);
	        
	    return $this->tableModel->changeItem($group_id, $item, $value, $options);
	}
	
	/**
	 * 删除某个配置项
	 * @param string $key
	 * @return bool
	 */
	public function delete($key)
	{
	    list($group, $item) = $this->parseKey($key);
	    
	    $collection = $this->getCollection($group);
	    
	    // We'll need to go ahead and lazy load each configuration groups even when
	    // we're just setting a configuration item so that the set item does not
	    // get overwritten if a different item in the group is requested later.
	    $this->load($collection);
	    
	    if ($item)
	    {
	        $this->items[$collection]->forget($item);
	        
	        $result = $this->tableModel->deleteItem($item);
	    }	    
	    return $result;
	}
	
	/**
	 * 获取所有配置组
	 */
	public function getGroups()
	{
	    $this->load('group');

	    $collection = array_get($this->items, 'group');
	     
	    return $collection->toArray();
	}
	
	/**
	 * Determine if a configuration group exists.
	 *
	 * @param  string  $group
	 * @return bool
	 */
	public function hasGroup($group)
	{	    
	    $groups = $this->getGroups();

	    if (empty($groups)) return false;
	    
	    $default = microtime(true);
	    
	    return array_get($groups, $group, $default) !== $default;
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
	    $groups = $this->getGroups();

	    if (empty($groups)) return 0;
	    
	    return array_get($groups, $group, $default);
	}
	
	public function deleteGroup($group)
	{
	    $this->tableModel->deleteGroup($group);
	    
	    $this->items['group']->forget('group');
	}
	
	public function addGroup($group, $id = null)
	{
	    $allKeys = $this->allKeys();
	    
	    if (array_get($allKeys, $group)) {
	        throw new ConfigGroupRepeatException("Config group [$group] already exists.");
	    }
	    
	    $id = $this->tableModel->addGroup($group, $id);
	    
	    $this->items['group']->put($group, $id);
	    
	    return $id;
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
	    if ($use_platform) 
	    {
	        $code = 'addon_' . ecjia::current_platform() . '_' . $code;
	    } 
	    else 
	    {
	        $code = 'addon_' . $code;
	    }
	    
	    if ($this->has($code))
	    {
	        $value = $this->get($code);
	    }
	    else 
	    {
	        $this->add('addon', $code, null, ['type' => 'hidden']);
	        $value = null;
	    }
	    
	    if ($unserialize)
	    {
	        $value or $value = serialize(array());
	        $value = unserialize($value);
	    }
	    
	    return $value;
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
	    if ($use_platform)
	    {
	        $code = 'addon_' . ecjia::current_platform() . '_' . $code;
	    }
	    else
	    {
	        $code = 'addon_' . $code;
	    }
	    
	    if ($serialize) 
	    {
	        $value or $value = array();
	        $value = serialize($value);
	    }
	    
	    if ($this->has($code))
	    {
	        $result = $this->write($code, $value);
	    }
	    else
	    {
	        $result = $this->add('addon', $code, $value, ['type' => 'hidden']);
	    }
	    
	    return $result;
	}
	
	
	public function clearCache()
	{
	    return $this->tableModel->clearCache();
	}
	
	
	/**
	 * Parse a key into namespace, group, and item.
	 *
	 * @param  string  $key
	 * @return array
	 */
	protected function parseKey($key)
	{
	    // If we've already parsed the given key, we'll return the cached version we
	    // already have, as this will save us some processing. We cache off every
	    // key we parse so we can quickly return it on all subsequent requests.
	    if (isset($this->parsed[$key]))
	    {
	        return $this->parsed[$key];
	    }
	
	    $segments = explode('.', $key);
	
	    // If the key does not contain a double colon, it means the key is not in a
	    // namespace, and is just a regular configuration item. Namespaces are a
	    // tool for organizing configuration items for things such as modules.
	    if (strpos($key, '.') === false)
	    {
	        $parsed = $this->parseBasicSegments($segments);
	    }
	
	    // Once we have the parsed array of this key's elements, such as its groups
	    // and namespace, we will cache each array inside a simple list that has
	    // the key and the parsed array for quick look-ups for later requests.
	    return $this->parsed[$key] = $parsed;
	}
	
	/**
	 * Parse an array of basic segments.
	 *
	 * @param  array  $segments
	 * @return array
	 */
	protected function parseBasicSegments(array $segments)
	{
	    // The first segment in a basic array will always be the group, so we can go
	    // ahead and grab that segment. If there is only one total segment we are
	    // just pulling an entire group out of the array and not a single item.
	    $group = $segments[0];
	
	    if (count($segments) == 1)
	    {
	        return array(null, $group);
	    }
	
	    // If there is more than one segment in this group, it means we are pulling
	    // a specific item out of a groups and will need to return the item name
	    // as well as the group so we know which item to pull from the arrays.
	    else
	    {
	        $item = implode('.', array_slice($segments, 1));
	
	        return array($group, $item);
	    }
	}
	
	/**
	 * Get the collection identifier.
	 *
	 * @param  string  $key
	 * @param  string  $group
	 * @return string
	 */
	protected function getCollection($group = null)
	{
	    $group = $group ?: $this->defaultGroup;
	
	    return $group;
	}

	/**
	 * Load the configuration group for the key.
	 *
	 * @param  string  $group
	 * @return void
	 */
	protected function load($group)
	{
		// If we've already loaded this collection, we will just bail out since we do
		// not want to load it again. Once items are loaded a first time they will
		// stay kept in memory within this class and not loaded from disk again.
		if (isset($this->items[$group]))
		{
			return;
		}

		$items = $this->tableModel->load($group);

		// If we've already loaded this collection, we will just bail out since we do
		// not want to load it again. Once items are loaded a first time they will
		// stay kept in memory within this class and not loaded from disk again.
		if (isset($this->afterLoad[$group]))
		{
			$items = $this->callAfterLoad($group, $items);
		}

		$this->items[$group] = $items;
	}

	/**
	 * Call the after load callback for a group.
	 *
	 * @param  string  $group
	 * @param  array   $items
	 * @return array
	 */
	protected function callAfterLoad($group, $items)
	{
		$callback = $this->afterLoad[$group];

		return call_user_func($callback, $this, $items);
	}

	/**
	 * Register an after load callback for a given group.
	 *
	 * @param  string   $group
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function afterLoading($group, Closure $callback)
	{
		$this->afterLoad[$group] = $callback;
	}

	/**
	 * Get the after load callback array.
	 *
	 * @return array
	 */
	public function getAfterLoadCallbacks()
	{
		return $this->afterLoad;
	}

	/**
	 * Get all of the configuration items.
	 *
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * Determine if the given configuration option exists.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return $this->has($key);
	}

	/**
	 * Get a configuration option.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}

	/**
	 * Set a configuration option.
	 *
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * Unset a configuration option.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function offsetUnset($key)
	{
		$this->set($key, null);
	}

}
