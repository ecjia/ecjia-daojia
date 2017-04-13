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

use Royalcms\Component\Database\Eloquent\Model;
use RC_Cache;
use RC_Hook;

class ConfigModel extends Model
{

    const CACHE_KEY = 'shop_config';
    
    protected $table = 'shop_config';
    
    public $timestamps = false;
    
    public function load($group)
    {
        if ($group == 'shop') 
        {
            return $this->loadItems();
        }
        else if ($group == 'group')
        {
            return $this->loadGroups();
        }
        else 
        {
            return null;
        }
    }
    
    /**
     * 写入数据库数据
     * @param string $key
     * @param string $value
     */
    public function writeItem($key, $value)
    {
        $this->where('code', $key)->update(['value' => $value]);
        
        $this->clearCache();
    }
    
    /**
     * 修改Item类型及值
     * @param string $group_id
     * @param string $key
     * @param string $value
     * @param string $options
     */
    public function changeItem($group_id, $key, $value = null, $options = [])
    {
        $data = [
        	'parent_id'     => $group_id,
            
            'type'          => array_get($options, 'type', 'text'),
            'store_range'   => array_get($options, 'store_range', ''),
            'store_dir'     => array_get($options, 'store_dir', ''),
            'sort_order'    => array_get($options, 'sort_order', 0),
        ];
        
        if (! is_null($value)) {
            $data['value'] = $value;
        }
        
        $result = $this->where('code', $key)->update($data);
        
        $this->clearCache();
        
        return $result;
    }
    
    /**
     * 添加配置项
     * 
     * @param integer $group_id
     * @param string $key
     * @param string $value
     * @param array $options
     * @return bool
     */
    public function addItem($group_id, $key, $value, $options = [])
    {
        $data = [
            'id'            => $this->getNextItemIdByGroupId($group_id),
        	'parent_id'     => $group_id,
            'code'          => $key,
            'value'         => $value,
            
            'type'          => array_get($options, 'type', 'text'),
            'store_range'   => array_get($options, 'store_range', ''),
            'store_dir'     => array_get($options, 'store_dir', ''),
            'sort_order'    => array_get($options, 'sort_order', 0),
        ];

        $result = $this->insert($data);
        
        $this->clearCache();
        
        return $result;
    }
    
    /**
     * 删除某个配置项
     * @param string $key
     */
    public function deleteItem($key)
    {
        $result = $this->where('parent_id', '>', 0)->where('code', $key)->delete();
        $this->clearCache();
        return $result;
    }
    
    
    /**
     * 获取所有配置项
     */
    public function loadItems()
    {
        $items = $this->getCache();
        
        if (empty($items))
        {
            $data = $this->select('code', 'value')->where('parent_id', '>', 0)->get();
            $items = $data->mapWithKeys(function($item) {
                return [$item['code'] => $item['value']];
            });
        
            $this->setCache($items);
        }
        return RC_Hook::apply_filters('ecjia_config_item_filter', $items);
    }
    
    /**
     * 获取所有的配置组
     * @return array
     */
    public function loadGroups()
    {
        $data = $this->select('code', 'id')->where('parent_id', 0)->where('type', 'group')->get();
        $groups = $data->mapWithKeys(function($group) {
        	return [$group['code'] => $group['id']];
        });

        return RC_Hook::apply_filters('ecjia_config_group_filter', $groups);
    }    
    
    /**
     * 添加用户组项
     * @param unknown $group
     * @param string $id
     */
    public function addGroup($group, $id = null)
    {
        $data = [
        	'parent_id' => 0,
            'code'      => $group,
            'type'      => 'group'
        ];
        
        if ($id)
        {
            $data['id'] = intval($id);
        }
        else 
        {
            $data['id'] = $this->getNextGroupId();
        }

        return $this->insertGetId($data);
    }
    
    /**
     * 删除某个配置组
     * @param unknown $group
     */
    public function deleteGroup($group)
    {
        return $this->where('parent_id', 0)->where('code', $group)->delete();
    }
    
    /**
     * Get the next group id number.
     *
     * @return int
     */
    public function getNextGroupId()
    {
        return $this->getLastGroupId() + 1;
    }
    
    /**
	 * Get the last group id number.
	 *
	 * @return int
	 */
    protected function getLastGroupId()
    {
        $groups = $this->loadGroups();
        $max = $groups->values()->max();
        return $max;
    }
    
    
    protected function getLastItemIdByGroupId($group_id)
    {
        $id = $this->where('parent_id', $group_id)->max('id');
        $id = $id ?: '00';
        return substr($id, -2);
    }
    
    public function getNextItemIdByGroupId($group_id)
    {
        return intval($group_id . $this->getLastItemIdByGroupId($group_id) + 1);
    }
    
    
    /**
     * 添加数据缓存
     * @param array $items
     */
    protected function setCache($items)
    {
        $items = $items->toArray();
        
        return RC_Cache::app_cache_set(self::CACHE_KEY, $items, 'system');
    }
    
    /**
     * 获取数据缓存
     */
    protected function getCache()
    {
        $items = RC_Cache::app_cache_get(self::CACHE_KEY, 'system');
        
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
        return RC_Cache::app_cache_delete(self::CACHE_KEY, 'system');
    }
    
}