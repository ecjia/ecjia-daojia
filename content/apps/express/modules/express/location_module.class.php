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
 * 查看配送员位置
 * @author zrl
 */
class express_location_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	//如果用户登录获取其session
    	$this->authSession();
    	$user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		
		$order_id = $this->requestData('order_id', 0);
		$express_id = $this->requestData('express_id', 0);
		/*参数为空判断*/
		if (empty($order_id)) {
			return new ecjia_error('invalid_parameter', __('参数无效', 'express'));
		}
		
    	/* 订单详情 */
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		if (is_ecjia_error($order_info)) {
			return $order_info;
		}
		
		$out = array();
			
		/*收货地址既送达位置处理*/
		$to = array();

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
			$to = array(
				'name' 		=> $order_info['address'],
				'location'	=> array(
					'lat' => $shop_point['result']['location']['lat'],
					'lng' => $shop_point['result']['location']['lng']
				),
			);
		}
		
		/*配送员信息*/
		if (empty($express_id)) {
			$express_order_info = RC_DB::table('express_order')->where('order_id', $order_id)->first();
		} else {
			$express_order_info = RC_DB::table('express_order')->where('express_id', $express_id)->first();
		}
		$staff_user_info = RC_DB::table('staff_user')->where('user_id', $express_order_info['staff_id'])->first();
		$express_user = $staff_user_info['name'];
		$express_mobile = $staff_user_info['mobile'];
		$avatar = empty($staff_user_info['avatar']) ? '' :  RC_Upload::upload_url($staff_user_info['avatar']);
		
		
		/*配送员当前位置处理*/
		$from = array();
		$express_user_info = RC_DB::table('express_user')->where('user_id', $express_order_info['staff_id'])->first();
		//腾讯地图api 地址解析（坐标转地址）
		$current_location = $express_user_info['latitude'].','.$express_user_info['longitude'];
		
		$current_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?location=".$current_location."&key=".$map_qq_key."&get_poi=1");
		$current_point = json_decode($current_point['body'], true);
		
		if (isset($current_point['result']) && !empty($current_point['result']['address']) && !empty($express_user_info['latitude']) && !empty($express_user_info['longitude'])) {
			$from = array(
					'name' 		=> $current_point['result']['address'],
					'location'	=> array(
							'lat' => $express_user_info['latitude'],
							'lng' => $express_user_info['longitude'],
					),
			);
		}
		
		/*配送状态*/
		if ($order_info['shipping_status'] == SS_RECEIVED) {
			$shipping_status = 'finished';
			$label_shipping_status = '您的商品已成功送达！';
		} else {
			$shipping_status = 'onShipping';
			$label_shipping_status = '您的商品正在配送中，请耐心等待！';
		}
		
		$out = array(
				'from' 					=> $from,
				'to'   					=> $to,
				'express_user' 			=> $express_user,
				'express_mobile'		=> $express_mobile,
				'avatar'				=> $avatar,
				'shipping_status'		=> $shipping_status,
				'label_shipping_status'	=> $label_shipping_status
		);
		
		return $out;
	 }	
}

// end