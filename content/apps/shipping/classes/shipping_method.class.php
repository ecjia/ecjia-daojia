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

/**
 * 配送方法
 * @author royalwang
 */
class shipping_method  {
	private $db;
    
	public function __construct() {
		$this->db = RC_Model::model('shipping/shipping_model');
	}
	
	
	/**
     * 取得可用的配送方式列表
     * @param   array   $region_id_list     收货人地区id数组（包括国家、省、市、区）
     * @return  array   配送方式数组
     */
    public function available_shipping_list($region_id_list, $store_id = 0) {  	
		$data = RC_DB::table('shipping')->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
			->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
			->select('shipping.shipping_id', 'shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure')
			->where('shipping.enabled', 1)
			->where('shipping_area.store_id', $store_id)
			->whereIn('area_region.region_id', $region_id_list)
			->orderby('shipping.shipping_order', 'asc')
			->get();
		$plugins = $this->available_shipping_plugins();

		$has_no_express = false;
		$shipping_list = array();
        if (!empty($data)) {
        	foreach ($data as $row) {
        		if (isset($plugins[$row['shipping_code']])) {
        			$shipping_list[] = $row;
        			if ($row['shipping_code'] == 'ship_no_express') {
        			    $has_no_express = true;
        			}
        		}
        	}
        }
        if (!$has_no_express) {
            $shipping_list[] = RC_DB::table('shipping')->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
            ->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
            ->select('shipping.shipping_id', 'shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure')
            ->where('shipping.enabled', 1)
            ->where('shipping.shipping_code', 'ship_no_express')
            ->first();
        }
        return $shipping_list;
    }
    
    /**
     * 取得可用的配送方式列表-前台
     * @param   array   $region_id_list     收货人地区id数组（包括国家、省、市、区）
     * @return  array   配送方式数组
     */
    public function available_shipping_list_front($region_id_list, $store_id = 0) {
        $data = RC_DB::table('shipping')->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
        ->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
        ->select('shipping.shipping_id', 'shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure')
        ->where('shipping.enabled', 1)
        ->where('shipping_area.store_id', $store_id)
        ->whereIn('area_region.region_id', $region_id_list)
        ->orderby('shipping.shipping_order', 'asc')
        ->get();
        $plugins = $this->available_shipping_plugins();
    
        $shipping_list = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                if (isset($plugins[$row['shipping_code']]) && $row['shipping_code'] != 'ship_no_express') {
                    $shipping_list[] = $row;
                }
            }
        }
        return $shipping_list;
    }
	
    /**
     * 激活的配送方式插件列表
     */
    public function available_shipping_plugins() {
    	return ecjia_config::instance()->get_addon_config('shipping_plugins', true);
    }
    
    /**
     * 取得某配送方式对应于某收货地址的区域信息
     * @param   int     $shipping_id        配送方式id
     * @param   array   $region_id_list     收货人地区id数组
     * @return  array   配送区域信息（config 对应着反序列化的 configure）
     */
    public function shipping_area_info($shipping_id, $region_id_list, $store_id = 0) {
        
        $shipping_code = $this->get_shipping_code($shipping_id);
        if ($shipping_code == 'ship_no_express') {
            $db = RC_DB::table('shipping');
            $db->select('shipping_code', 'shipping_name', 'shipping_desc', 'insure', 'support_cod')
            	->where('shipping_id', $shipping_id)
            	->where('enabled', 1);
        } else {
        	$db = RC_DB::table('shipping');
            $db->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
            	->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
            	->select('shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure')
            	->where('shipping.shipping_id', $shipping_id)
            	->where('shipping.enabled', 1)
            	->whereIn('area_region.region_id', $region_id_list);
            if ($store_id) {
                $db->where('shipping_area.store_id', $store_id);
            }
        }
    	$row = $db->first();
        
        if (!empty($row)) {
            $shipping_config = $this->unserialize_config($row['configure']);
            if (isset($shipping_config['pay_fee'])) {
                if (strpos($shipping_config['pay_fee'], '%') !== false) {
                    $row['pay_fee'] 	= floatval($shipping_config['pay_fee']) . '%';
                } else {
                    $row['pay_fee'] 	= floatval($shipping_config['pay_fee']);
                }
            } else {
                $row['pay_fee'] 	= 0.00;
            }
        }
        return $row;
    }

	
    /**
     * 取得已安装的配送方式
     * @return  array   已安装的配送方式
     */
    public function shipping_list() {
    	$data = RC_DB::table('shipping')->select('shipping_id', 'shipping_name', 'shipping_code')->where('enabled', 1)->get();
    	
    	$plugins = $this->available_shipping_plugins();
    	$pay_list = array();
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			if (isset($plugins[$row['shipping_code']])) {
    				$pay_list[] = $row;
    			}
    		}
    	}
    	return $pay_list;
    }
    
    
    /**
     * 取得配送方式信息
     * @param   int     $shipping_id    配送方式id
     * @return  array   配送方式信息
     */
    public function shipping_info($shipping_id) {
//         return $this->db->find(array('shipping_id' => $shipping_id , 'enabled' => 1));
        
        return RC_DB::table('shipping')->where('shipping_id', $shipping_id)->where('enabled', 1)->first();
    }
	
    
    /**
     * 计算运费
     * @param   string  $shipping_code	  配送方式代码
     * @param   mix	 $shipping_config	配送方式配置信息
     * @param   float   $goods_weight	   商品重量
     * @param   float   $goods_amount	   商品金额
     * @param   float   $goods_number	   商品数量
     * @return  float   运费
     */
    function shipping_fee($shipping_code, $shipping_config, $goods_weight, $goods_amount, $goods_number='') {
    	if (!is_array($shipping_config)) {
    		$shipping_config = unserialize($shipping_config);
    	}
    	
    	RC_Loader::load_app_class('shipping_factory', 'shipping', false);
    	$handler = new shipping_factory($shipping_code, $shipping_config);
    	$shipping_fee = $handler->calculate($goods_weight, $goods_amount, $goods_number);
    	if (empty($shipping_fee)) {
    		return 0;
    	} else {
    		return $shipping_fee;
    	}
    }
    
    /**
     * 处理序列化的支付、配送的配置参数
     * 返回一个以name为索引的数组
     *
     * @access  public
     * @param   string       $cfg
     * @return  void
     */
    public function unserialize_config($cfg) {
    	if (is_string($cfg) && ($arr = unserialize($cfg)) !== false) {
    		$config = array();
    		foreach ($arr AS $key => $val) {
    			$config[$val['name']] = $val['value'];
    		}
    		return $config;
    	} else {
    		return false;
    	}
    }
    
    /**
     * 获取指定配送的保价费用
     *
     * @access  public
     * @param   string	  $shipping_code  配送方式的code
     * @param   float	   $goods_amount   保价金额
     * @param   mix		 $insure		 保价比例
     * @return  float
     */
    public function shipping_insure_fee($shipping_code, $goods_amount, $insure) {
    	if (strpos($insure, '%') === false) {
    		/* 如果保价费用不是百分比则直接返回该数值 */
    		return floatval($insure);
    	} else {
    		RC_Loader::load_app_class('shipping_factory', 'shipping', false);
    		$shipping_handle = new shipping_factory($shipping_code);
    		if ($shipping_handle){
    			$insure   = floatval($insure) / 100;
    			if (method_exists($shipping, 'calculate_insure')) {
    				return $shipping_handle->calculate_insure($goods_amount, $insure);
    			} else {
    				return ceil($goods_amount * $insure);
    			}
    		} else {
    			return false;
    		}
    	}
    }
    
    public function get_shipping_code($shipping_id) {
        return RC_DB::table('shipping')->where('shipping_id', $shipping_id)->pluck('shipping_code');
    }
}

// end