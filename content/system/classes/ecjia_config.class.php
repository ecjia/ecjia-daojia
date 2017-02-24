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
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_config {
	private $config	= array();
	private $db_config;
	
	private static $instance = null;
	
	/**
	 * 返回当前终级类对象的实例
	 *
	 * @param $cache_config 缓存配置
	 * @return object
	 */
	public static function instance() {
	    if (self::$instance === null) {
	        self::$instance = new self();
	    }
	    return self::$instance;
	}
	
	public function __construct() {
		try {
		    $this->db_config = RC_Loader::load_model('shop_config_model');
		    $this->config = $this->_load_config();
		} catch(Exception $e) {
		}
	}
	
	/**
	 * 载入全部配置信息
	 *
	 * @access  public
	 * @return  array
	 */
	public function load_config() {
		return RC_Hook::apply_filters('set_ecjia_config_filter', $this->config);
	}
	
	/**
	 * 清除配置文件缓存
	 */
	public function clear_cache() {
	    RC_Cache::app_cache_delete('shop_config', 'system');
	}
	
	/**
	 * 载入全部配置信息
	 *
	 * @access  public
	 * @return  array
	 */
	private function _load_config($force = false) {
		$arr = array();
		$data = RC_Cache::app_cache_get('shop_config', 'system');
		if (empty($data) || $force) {
// 			$res = $this->db_config->field('`code`, `value`')->where('`parent_id` > 0')->select();
			$res = RC_DB::table('shop_config')->select('code', 'value')->where('parent_id', '>', 0)->get();
			if (!empty($res)) {
				foreach ($res AS $row) {
					$arr[$row['code']] = $row['value'];
				}
			}
			RC_Cache::app_cache_set('shop_config', $arr, 'system');
		} else {
			$arr = $data;
		}

		return $arr;
	}
	
	/**
	 * 检查配置项是否存在
	 * @param unknown $code
	 * @return boolean
	 */
	public function check_config($code) {
		$data = $this->load_config();

		if (isset($data[$code])) {
			return true;
		}

		return false;
	}
	
	/**
	 * 判断配置项值是否空, 为空是
	 * @param unknown $code
	 */
	public function check_exists($code) {
		$data = $this->load_config();

		if (isset($data[$code]) && !empty($data[$code])) {
			return true;
		}

		return false;
	}
	
	/**
	 * 读取某项配置
	 * @param unknown $code
	 * @return unknown|boolean
	 */
	public function read_config($code) {
		if ($this->check_config($code)) {
			$data = $this->load_config();
			return $data[$code];
		}

		return false;
	}
	
	
	/**
	 * 写入某项配置
	 * @param unknown $code
	 * @param unknown $value
	 */
	public function write_config($code, $value) {
	    if (!is_a($this->db_config, 'shop_config_model')) {
	        return null;
	    }
	    
// 		$rs = $this->db_config->where(array('code' => $code))->update(array('value' => $value));
		$rs = RC_DB::table('shop_config')->where('code', $code)->update(array('value' => $value));
		if ($rs) {
		    $this->clear_cache();
		    return true;
		}

		return false;
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
	public function insert_config($parent, $code, $value, $options = array()) {
	    if (!is_a($this->db_config, 'shop_config_model')) {
	        return null;
	    }
	    
// 		$parent_id = $this->db_config->where("`code` = '$parent' AND `parent_id` = 0")->get_field('id');
		$parent_id = RC_DB::table('shop_config')->where('code', $parent)->where('parent_id', 0)->pluck('id');
		$data = array(
				'parent_id' => $parent_id,
				'code' 		=> $code,
				'value' 	=> $value,
		);

		if (isset($options['type'])) {
			$data['type'] = $options['type'];
		}

		if (isset($options['store_range'])) {
			$data['store_range'] = $options['store_range'];
		}

		if (isset($options['store_dir'])) {
			$data['store_dir'] = $options['store_dir'];
		}

		if (isset($options['sort_order'])) {
			$data['sort_order'] = $options['sort_order'];
		}

		$this->db_config->insert_ignore($data);
		
		$this->clear_cache();
	}
	
	
	/**
	 * 删除配置项
	 * @param string $code
	 */
	public function delete_config($code) {
	    if (!is_a($this->db_config, 'shop_config_model')) {
	        return null;
	    }
	    
// 	    $rs = $this->db_config->where(array('code' => $code))->delete();
	    $rs = RC_DB::table('shop_config')->where('code', $code)->delete();
	    if ($rs) {
	        $this->clear_cache();
	        return true;
	    }
	    
	    return false;
	}
	
	public function add_group($code, $id = null) {
	    $data = array(
	        'parent_id' => 0,
	        'code' 		=> $code,
	        'type' 	    => 'group',
	    );
	    
	    if ($id) {
	        $data['id'] = intval($id);
	    }
	    
	    $this->db_config->insert_ignore($data);
	}
	
	/**
	 * 载入全部配置信息
	 *
	 * @access  public
	 * @return  array
	 */
	private function _load_group($force = false) {
	    $arr = array();
	    $data = RC_Cache::app_cache_get('shop_config_group', 'system');
	    if (empty($data) || $force) {
	        $res = RC_DB::table('shop_config')->select('code', 'value')->where('parent_id', 0)->where('type', 'group')->get();
	        if (!empty($res)) {
	            foreach ($res AS $row) {
	                $arr[$row['code']] = $row['id'];
	            }
	        }
	        RC_Cache::app_cache_set('shop_config_group', $arr, 'system');
	    } else {
	        $arr = $data;
	    }
	
	    return $arr;
	}
	
	/**
	 * 检查配置项是否存在
	 * @param unknown $code
	 * @return boolean
	 */
	public function check_group($code) {
	    $data = $this->load_group();
	
	    if (isset($data[$code])) {
	        return true;
	    }
	
	    return false;
	}
	
	public function load_group()
	{
	    return RC_Hook::apply_filters('set_ecjia_config_filter', $this->_load_group());
	}
	
	/**
	 * 读取某项配置
	 * @param unknown $code
	 * @return unknown|boolean
	 */
	public function read_group($code) {
	    if ($this->check_group($code)) {
	        $data = $this->load_group();
	        return $data[$code];
	    }
	
	    return false;
	}
	
	/**
	 * 删除配置项
	 * @param string $code
	 */
	public function delete_group($code) {
	    return $this->delete_config($code);
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
	public function get_addon_config($code, $unserialize = false, $use_platform = false) {   
	    if ($use_platform) {
	        $code = 'addon_' . ecjia::current_platform() . '_' . $code;
	    } else {
	        $code = 'addon_' . $code;
	    }  
	    
	    if ($this->check_config($code)) {
	    	$value = $this->read_config($code);
	    } else {
	        $this->insert_config('hidden', $code, '', array('type' => 'hidden'));
	        $value = '';
	    }
	    if ($unserialize) {
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
	public function set_addon_config($code, $value, $serialize = false, $use_platform = false) {
	  if ($use_platform) {
	        $code = 'addon_' . ecjia::current_platform() . '_' . $code;
	    } else {
	        $code = 'addon_' . $code;
	    } 
	    
	    if ($serialize) {
	        $value or $value = array();
	    	$value = serialize($value);
	    }
	    $data = $this->_load_config(true);
	    if (isset($data[$code])) {
	        $this->write_config($code, $value);
	    } else {
	        $this->insert_config('hidden', $code, $value, array('type' => 'hidden'));
	    }
	}
		
}


// end