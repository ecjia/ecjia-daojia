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
 * 配送方式列表
 * @author will
 *
 */
class admin_orders_shipping_list_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();

        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$result_view = $this->admin_priv('order_view');
		$result_edit = $this->admin_priv('order_edit');
		if (is_ecjia_error($result_view)) {
			return $result_view;
		} elseif (is_ecjia_error($result_edit)) {
			return $result_edit;
		}
		$order_id	= $this->requestData('order_id', 0);
		if ($order_id <= 0) {
			return new ecjia_error(101, '参数错误');
		}
		
		/*验证订单是否属于此入驻商*/
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$store_id_group = RC_Model::model('orders/order_info_model')->where(array('order_id' => $order_id))->group('store_id')->get_field('store_id', true);
			if (count($store_id_group) > 1 || $store_id_group[0] != $_SESSION['store_id']) {
				return new ecjia_error('no_authority', '对不起，您没权限对此订单进行操作！');
			}
		}
		
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		/* 获取订单store_id*/
		$order_info['store_id'] = RC_Model::model('orders/order_info_model')->where(array('order_id' => $order_id))->get_field('store_id');
		/* 取得可用的配送方式列表 */
		$region_id_list = array(
			$order_info['country'], $order_info['province'], $order_info['city'], $order_info['district'], $order_info['street']
		);
		
		//$shipping_method   = RC_Loader::load_app_class('shipping_method', 'shipping');
		//$shipping_list     = $shipping_method->available_shipping_list($region_id_list, $order_info['store_id']);
		$shipping_list     = ecjia_shipping::availableUserShippings($region_id_list, $order_info['store_id']);
		
		$consignee = array(
				'country'		=> $order_info['country'],
				'province'		=> $order_info['province'],
				'city'			=> $order_info['city'],
				'district'		=> $order_info['district'],
				'street'		=> $order_info['street'],
		);
		
		RC_Loader::load_app_func('global', 'orders');
		RC_Loader::load_app_func('admin_order', 'orders');
		$goods_list = order_goods($order_id);
		
		/* 取得配送费用 */
		$total = order_weight_price($order_id);
		$new_shipping_list = array();
		
		if (!empty($shipping_list)) {
			foreach ($shipping_list as $a => $b) {
				if (empty($b['shipping_id'])) {
					unset($shipping_list[$a]);
				}
			}
		}
		
		/* ===== 计算收件人距离 ===== */
		// 收件人地址，带坐标 $consignee
		// 获取到店家的地址，带坐标
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $order_info['store_id'])->where('shop_close', '0')->first();
		// 计算店家距离收件人距离 $distance
		if (!empty($store_info['longitude']) && !empty($store_info['latitude'])) {
			//腾讯地图api距离计算
			$province_name = ecjia_region::getRegionName($order_info['province']);
			$city_name = ecjia_region::getRegionName($order_info['city']);
			$district_name = ecjia_region::getRegionName($order_info['distreet']);
			$street_name = ecjia_region::getRegionName($order_info['street']);
				
			$consignee_address = '';
			if (!empty($province_name)) {
				$consignee_address .= $province_name;
			}
			if (!empty($city_name)) {
				$consignee_address .= $city_name;
			}
			if (!empty($district_name)) {
				$consignee_address .= $district_name;
			}
			if (!empty($street_name)) {
				$consignee_address .= $street_name;
			}
			$consignee_address .= $order_info['address'];
			$consignee_address = urlencode($consignee_address);
				
			//腾讯地图api 地址解析（地址转坐标）
			$map_qq_key = ecjia::config('map_qq_key');
			$shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$consignee_address."&key=".$map_qq_key);
			$shop_point = json_decode($shop_point['body'], true);
			
			if (isset($shop_point['result']) && !empty($shop_point['result']['location'])) {
				$consignee['latitude'] = $shop_point['result']['location']['lat'];
				$consignee['longitude'] = $shop_point['result']['location']['lng'];
			}
			$url = "https://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$store_info['latitude'].",".$store_info['longitude']."&to=".$consignee['latitude'].",".$consignee['longitude']."&key=".$map_qq_key;
			$distance_json = file_get_contents($url);
			$distance_info = json_decode($distance_json, true);
			$distance = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
		}
		/* ===== 计算收件人距离 ===== */
		if (!empty($shipping_list)) {
			foreach ($shipping_list AS $key => $shipping) {
				$shipping_cfg = ecjia_shipping::unserializeConfig($shipping['configure']);
				if ($shipping['shipping_code'] == 'ship_o2o_express' || $shipping['shipping_code'] == 'ship_ecjia_express') {
					$shipping_fee = ecjia_shipping::fee($shipping['shipping_area_id'], $distance, $total['amount'], $total['number']);
				} else {
					$shipping_fee = ecjia_shipping::fee($shipping['shipping_area_id'], $total['weight'], $total['amount'], $total['number']);
				}
				$shipping_list[$key]['shipping_fee'] = $shipping_fee;
				$shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee);
				$shipping_list[$key]['free_money']          = price_format($shipping_cfg['free_money'], false);

				/* o2o*/
				if ($shipping['shipping_code'] == 'ship_o2o_express' || $shipping['shipping_code'] == 'ship_ecjia_express') {
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
				
				}
				
				
				$shipping_list = array_values($shipping_list);
			}
					
			foreach ($shipping_list as $a => $b) {
				unset($shipping_list[$a]['configure']);
				unset($shipping_list[$a]['shipping_desc']);
				unset($shipping_list[$a]['insure']);
				unset($shipping_list[$a]['support_cod']);
				unset($shipping_list[$a]['shipping_area_id']);
			}
			
		}
		return $shipping_list;
	} 
}


// end