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
namespace Ecjia\App\Cart\CartFlow;

use RC_DB;
use ecjia_shipping;
use RC_Time;
use Ecjia\App\User\Location;

/**
 *获取商家配送方式及配送费用
 */
class CartStoreShipping
{
  	/**
     * 商家配送方式及配送费用
     */
    public static function store_cart_goods($cart_goods = array(), $consignee = array())
    {
    	if (!empty($cart_goods['cart_list'])) {
    		foreach ($cart_goods['cart_list'] as $key => $val) {
    			$store_shipping_list = self::store_shipping_list($val['goods_list'], $consignee, $val['store_id']);
    			$val['shipping'] = $store_shipping_list;
    			$val['goods_amount'] = sprintf("%.2f", $val['total']['goods_amount']);
    			unset($val['total']);
    			unset($val['favourable_activity']);
    			$store_cart_goods [] = $val;
    		}
    	}
    	return $store_cart_goods;
    }
    
    /**
     *商家配送方式及配送费用，优惠活动
     */
    public static function store_cart_goods_discount($cart_goods = array(), $consignee = array())
    {
    	if (!empty($cart_goods['cart_list'])) {
    		foreach ($cart_goods['cart_list'] as $key => $val) {
    			$store_shipping_list = self::store_shipping_list($val['goods_list'], $consignee, $val['store_id']);
    			$val['shipping'] = $store_shipping_list;
    			$val['goods_amount'] = sprintf("%.2f", $val['total']['goods_amount']);
    			$store_cart_goods [] = $val;
    		}
    	}
    	$result = array('cart_list' => $store_cart_goods, 'total' => $cart_goods['total']);
    	return $result;
    }
    
    /**
     * 商家配送方式列表
     */
    public static function store_shipping_list($store_goods_list, $consignee, $store_id)
    {
    	$region = array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district'], $consignee['street']);
    	if (empty($store_goods_list)) {
    		return [];
    	}
    	$is_free_ship = 0;
    	$shipping_count = 0;
    	$cart_weight_price['weight'] 		= 0;
    	$cart_weight_price['amount'] 		= 0;
    	$cart_weight_price['number'] 		= 0;
    	 
    	foreach ($store_goods_list as $key => $goods) {
    		if($goods['is_shipping'] == 1) {
    			$shipping_count ++;
    		}
    		$goodsInfo = RC_DB::table('goods')->where('goods_id', $goods['goods_id'])->select('goods_weight', 'weight_unit')->first();
    		//重量统一处理成kg
    		if ($goodsInfo['goods_weight'] > 0) {
    			//存储的是克单位情况处理
    			if ($goodsInfo['weight_unit'] == '1' && $goodsInfo['goods_weight'] > 1) {
    				$goodsWeight = $goodsInfo['goods_weight']/1000;
    			} else {
    				$goodsWeight = $goodsInfo['goods_weight'];
    			}
    		} else {
    			$goodsWeight = 0;
    		}
    		$cart_weight_price['weight'] += floatval($goodsWeight) * $goods['goods_number'];
    		$cart_weight_price['amount'] += floatval($goods['goods_price']) * $goods['goods_number'];
    		$cart_weight_price['number'] += $goods['goods_number'];
    	}
    	if($shipping_count == count($store_goods_list)) {
    		//全部包邮
    		$is_free_ship = 1;
    	}
    	 
    	$shipping_list = ecjia_shipping::availableUserShippings($region, $store_id);
    	$shipping_list_new = [];
    	 
    	if($shipping_list) {
    		foreach ($shipping_list as $key => $row) {
    			// O2O的配送费用计算传参调整 参考flow/checkOrder
    			if (in_array($row['shipping_code'], ['ship_o2o_express','ship_ecjia_express'])) {
    				//配送费
    				$shipping_fee = self::o2o_shipping_fee($cart_weight_price, $is_free_ship, $store_id, $consignee, $row);
    				//配送时间
    				$shipping_cfg = ecjia_shipping::unserializeConfig($row['configure']);
    				/* 获取最后可送的时间（当前时间+需提前下单时间）*/
    				$time = RC_Time::local_date('H:i', RC_Time::gmtime() + $shipping_cfg['last_order_time'] * 60);
    
    				if (empty($shipping_cfg['ship_time'])) {
    					unset($shipping_list[$key]);
    					continue;
    				}
    				$shipping_list[$key]['shipping_date'] = array();
    				$ship_date = 0;
    
    				if (empty($shipping_cfg['ship_days'])) {
    					$shipping_cfg['ship_days'] = 7;
    				}
    
    				while ($shipping_cfg['ship_days']) {
    					foreach ($shipping_cfg['ship_time'] as $k => $v) {
    
    						if ($v['end'] > $time || $ship_date > 0) {
    							$shipping_list[$key]['shipping_date'][$ship_date]['date'] = RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('+'.$ship_date.' day'));
    							$shipping_list[$key]['shipping_date'][$ship_date]['time'][] = array(
    									'start_time' 	=> $v['start'],
    									'end_time'		=> $v['end'],
    							);
    						}
    					}
    					$ship_date ++;
    
    					if (count($shipping_list[$key]['shipping_date']) >= $shipping_cfg['ship_days']) {
    						break;
    					}
    				}
    				$shipping_list[$key]['shipping_date'] = array_merge($shipping_list[$key]['shipping_date']);
    
    			} else {
    				$shipping_fee = $is_free_ship ? 0 : ecjia_shipping::fee($row['shipping_area_id'], $cart_weight_price['weight'], $cart_weight_price['amount'], $cart_weight_price['number']);
    			}
    			//上门取货 自提插件 获得提货时间
    			if($row['shipping_code'] == 'ship_cac') {
    				$shipping_list[$key]['expect_pickup_date'] =\Ecjia\App\Cart\CartFunction::get_ship_cac_date_by_store($store_id, $row['shipping_id']);
    				$shipping_list[$key]['expect_pickup_date_default'] = $shipping_list[$key]['expect_pickup_date'][0]['date'] . ' ' . $shipping_list[$key]['expect_pickup_date'][0]['time'][0]['start_time'] . '-' . $shipping_list[$key]['expect_pickup_date'][0]['time'][0]['end_time'];
    			}
    			 
    			$shipping_list[$key]['shipping_fee']        = $shipping_fee;
    			$shipping_list[$key]['format_shipping_fee'] = ecjia_price_format($shipping_fee, false);
    			unset($shipping_list[$key]['shipping_desc']);
    			unset($shipping_list[$key]['configure']);
    		}
    	}
    	$shipping_list = array_values($shipping_list);
    	return $shipping_list;
    }
    
    /**
     * 商家配送及或众包配送费获取
     */
    public static function o2o_shipping_fee($cart_weight_price, $is_free_ship, $store_id, $consignee, $shipping_val)
    {
    	$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->where('shop_close', '0')->first();
    	$from = ['latitude' => $store_info['latitude'], 'longitude' => $store_info['longitude']];
    	$to = ['latitude' => $consignee['location']['latitude'], 'longitude' => $consignee['location']['longitude']];
    	$distance = Location::getDistance($from, $to);
    	$shipping_fee = $is_free_ship ? 0 : ecjia_shipping::fee($shipping_val['shipping_area_id'], $distance, $cart_weight_price['amount'], $cart_weight_price['number']);
    	return $shipping_fee;
    }
    
    
    
}
