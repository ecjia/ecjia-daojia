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
 * 店铺模块控制器代码
 */
class merchant_controller {
   
	/**
	 * 店铺首页
	 */
	public static function init() {
		$store_id 		= intval($_GET['store_id']);
		$category_id 	= intval($_GET['category_id']);
		 
		$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
		$pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
		 
		$type_name = '';
		$action_type = !empty($_GET['type']) ? trim($_GET['type']) : '';
		
		//店铺信息
		$store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_HOME_DATA)->data(array('seller_id' => $store_id, 'location' => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']), 'city_id' => $_COOKIE['city_id']))->run();
		if (!is_ecjia_error($store_info)) {
			$store_info = merchant_function::format_info_distance($store_info);
			
			ecjia_front::$controller->assign('store_info', $store_info);
			ecjia_front::$controller->assign_title($store_info['seller_name']);
			
			if (empty($action_type) && empty($category_id)) {
				$goods_count = $store_info['goods_count'];
				if ($goods_count['best_goods'] > 0) {
					$action_type = 'best';
					$goods_num = $goods_count['best_goods'];
					$type_name = '精选';
				} elseif ($goods_count['hot_goods'] > 0) {
					$action_type = 'hot';
					$goods_num = $goods_count['hot_goods'];
					$type_name = '热销';
				} elseif ($goods_count['new_goods'] > 0) {
					$action_type = 'new';
					$goods_num = $goods_count['new_goods'];
					$type_name = '新品';
				}
			}
			ecjia_front::$controller->assign('title', $store_info['seller_name']);
			ecjia_front::$controller->assign('header_left', ' ');
				
			$header_right = array(
				'href' => RC_Uri::url('merchant/index/position', array('shop_address' => $store_info['shop_address'])),
				'info' => '<i class="iconfont icon-location"></i>',
			);
			ecjia_front::$controller->assign('header_right', $header_right);
		}
		ecjia_front::$controller->assign('action_type', $action_type);
		 
		//店铺分类
		$store_category = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_CATEGORY)->data(array('seller_id' => $store_id))->run();
		if (!is_ecjia_error($store_category)) {
			ecjia_front::$controller->assign('store_category', $store_category);
		}
		
		$goods_list = array();
		if (!empty($action_type) && $action_type != 'all') {
			$parameter = array(
				'action_type' 	=> $action_type,
				'pagination' 	=> array('count' => $limit, 'page' => $pages),
				'seller_id'		=> $store_id
			);
			$response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->hasPage()->run();
			if (!is_ecjia_error($response)) {
				list($data, $page) = $response;
				$goods_num = $page['count'];
				$goods_list = $data;
			}
		} else {
			//店铺分类商品
			$arr = array(
				'filter' 		=> array('category_id' => $category_id),
				'pagination' 	=> array('count' => $limit, 'page' => $pages),
				'seller_id'		=> $store_id
			);
			 
			$response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->hasPage()->run();
			if (!is_ecjia_error($response)) {
				list($data, $page) = $response;
				$goods_num = $page['count'];
				$goods_list = $data;
			}
			if (empty($category_id)) {
				$type_name = '全部';
			}
		}
		 
		$token = ecjia_touch_user::singleton()->getToken();
		$arr = array(
			'token' 	=> $token,
			'seller_id' => $store_id,
			'location' 	=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
			'city_id'   => $_COOKIE['city_id']
		);
		 
		//店铺购物车商品
		$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();

		$goods_cart_list = array();
		$rec_id = '';
		
		if (!is_ecjia_error($cart_list)){
			if (!empty($cart_list['cart_list'][0]['goods_list'])) {
				$cart_list['cart_list'][0]['total']['check_all'] = true;
				$cart_list['cart_list'][0]['total']['check_one'] = false;
				foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
					if (!empty($v['goods_number'])) {
						$goods_cart_list[$v['goods_id']] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id']);
					}
					if ($v['is_checked'] == 1 && $v['is_disabled'] == 0) {
						$cart_list['cart_list'][0]['total']['check_one'] = true;	//至少选择了一个
						if ($k == 0) {
							$rec_id = $v['rec_id'];
						} else {
							$rec_id .= ','.$v['rec_id'];
						}
					} elseif ($v['is_checked'] == 0) {
						$cart_list['cart_list'][0]['total']['check_all'] = false;	//全部选择
						$cart_list['cart_list'][0]['total']['goods_number'] -= $v['goods_number'];
					}
					$rec_id = trim($rec_id, ',');
				}
			} else {
				$cart_list['cart_list'][0]['total']['check_all'] = false;
				$cart_list['cart_list'][0]['total']['check_one'] = false;
			}
		}
		 
		if (!empty($goods_list)) {
			foreach ($goods_list as $k => $v) {
				if (array_key_exists($v['id'], $goods_cart_list)) {
					if (!empty($goods_cart_list[$v['id']]['num'])) {
						$goods_list[$k]['num'] = $goods_cart_list[$v['id']]['num'];
						$goods_list[$k]['rec_id'] = $goods_cart_list[$v['id']]['rec_id'];
					}
				}
			}
		}
		
		if (ecjia_touch_user::singleton()->isSignin() && !is_ecjia_error($cart_list)) {
			ecjia_front::$controller->assign('cart_list', $cart_list['cart_list'][0]['goods_list']);
			ecjia_front::$controller->assign('count', $cart_list['cart_list'][0]['total']);
			ecjia_front::$controller->assign('real_count', $cart_list['total']);
		}
		ecjia_front::$controller->assign('goods_list', $goods_list);
		 
		ecjia_front::$controller->assign('type_name', $type_name);
		ecjia_front::$controller->assign('goods_num', $goods_num);
		 
		ecjia_front::$controller->assign('store_id', $store_id);
		ecjia_front::$controller->assign('category_id', $category_id);
		ecjia_front::$controller->assign('rec_id', $rec_id);
	
		if (isset($_COOKIE['location_address_id']) && $_COOKIE['location_address_id'] > 0) {
			ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
		}
		ecjia_front::$controller->assign('referer_url', urlencode(RC_Uri::url('merchant/index/init', array('store_id' => $store_id))));
		 
		ecjia_front::$controller->display('merchant.dwt');
	}
	
	/**
	 * 店铺详情
	 */
	public static function detail() {
		$store_id = intval($_GET['store_id']);
		$arr = array(
			'seller_id' => $store_id,
			'location' => array(
				'longitude' => $_COOKIE['longitude'], 
				'latitude' => $_COOKIE['latitude']
			),
			'city_id' => $_COOKIE['city_id']
		);
		//店铺信息
		$store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_HOME_DATA)->data($arr)->run();
		if (!is_ecjia_error($store_info)) {
			$store_info = merchant_function::format_info_distance($store_info);
			ecjia_front::$controller->assign('data', $store_info);
		}

		ecjia_front::$controller->assign_title('店铺详情');
		ecjia_front::$controller->display('merchant_detail.dwt');
	}
	
	/**
	 * 获取店铺商品
	 */
	public static function ajax_goods() {
		$store_id = intval($_GET['store_id']);
		$category_id = 0;
		$action_type = '';
		 
		if (!empty($_GET['action_type']) && is_numeric($_GET['action_type'])) {
			$category_id = intval($_GET['action_type']);
		} else {
			$action_type = trim($_GET['action_type']);
		}
		 
		$type_name = '';
		$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
		$pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
		 
		if ($action_type == 'best') {
			$type_name = '精选';
		} elseif ($action_type == 'hot') {
			$type_name = '热销';
		} elseif ($action_type == 'new') {
			$type_name = '新品';
		}
		 
		//店铺分类
		$store_category = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_CATEGORY)->data(array('seller_id' => $store_id))->run();
		 
		$goods_num = 0;
		$goods_list = array();
		if (!empty($action_type) && $action_type != 'all') {
			$parameter = array(
				'action_type' 	=> $action_type,
				'pagination' 	=> array('count' => $limit, 'page' => $pages),
				'seller_id'		=> $store_id
			);
			$response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->hasPage()->run();
			if (!is_ecjia_error($response)) {
				list($data, $page) = $response;
				$goods_num = $page['count'];
				$goods_list = $data;
			}
		} else {
			//店铺分类商品
			$arr = array(
				'filter' 		=> array('category_id' => $category_id),
				'pagination' 	=> array('count' => $limit, 'page' => $pages),
				'seller_id'		=> $store_id
			);
			$response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->hasPage()->run();
			if (!is_ecjia_error($response)) {
				list($data, $page) = $response;
				$goods_num = $page['count'];
				$goods_list = $data;
			}
	
			if (empty($category_id)) {
				$type_name = '全部';
			} else {
				$type_name = '';
				if (!is_ecjia_error($store_category) && !empty($store_category)) {
					foreach ($store_category as $k => $v) {
						if ($v['id'] == $category_id) {
							$type_name = $v['name'];
						} else if ($v['children']) {
							foreach ($v['children'] as $key => $val) {
								if ($val['id'] == $category_id) {
									$type_name = $val['name'];
								}
							}
						}
					}
				}
			}
		}
		 
		$token = ecjia_touch_user::singleton()->getToken();
		$arr = array(
			'token' 	=> $token,
			'seller_id' => $store_id,
			'location' 	=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
			'city_id'   => $_COOKIE['city_id']
		);
		 
		//店铺购物车商品
		$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();
	
		$goods_cart_list = array();
		if (!is_ecjia_error($cart_list)) {
			if (!empty($cart_list['cart_list'][0]['goods_list'])) {
				foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
					if (!empty($v['goods_number'])) {
						$goods_cart_list[$v['goods_id']] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id']);
					}
				}
			}
		}
		 
		if (!empty($goods_list)) {
			foreach ($goods_list as $k => $v) {
				if (array_key_exists($v['id'], $goods_cart_list)) {
					if (!empty($goods_cart_list[$v['id']]['num'])) {
						$goods_list[$k]['num'] = $goods_cart_list[$v['id']]['num'];
						$goods_list[$k]['rec_id'] = $goods_cart_list[$v['id']]['rec_id'];
					}
				}
			}
		}
		 
		if ($pages == 1) {
			ecjia_front::$controller->assign('page', $pages);
			ecjia_front::$controller->assign('type_name', $type_name);
			ecjia_front::$controller->assign('goods_num', $goods_num);
		}
		
		if (isset($page['total']) && $page['total'] == 0) {
			$goods_list = array();
		}
		ecjia_front::$controller->assign('goods_list', $goods_list);
		$say_list = ecjia_front::$controller->fetch('library/merchant_goods.lbi');
	
		if ($page['more'] == 0) $data['is_last'] = 1;
		return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $say_list, 'goods_list' => $goods_list, 'name' => $type_name, 'num' => $goods_num, 'type' => $action_type, 'is_last' => $data['is_last']));
	}

	/**
	 * 店铺位置
	 */
	public static function position() {
		$shop_address = $_GET['shop_address'];
		ecjia_front::$controller->assign('shop_address', $shop_address);
		ecjia_front::$controller->assign_title('店铺位置');
		 
		ecjia_front::$controller->display('merchant_position.dwt');
	}
	
}

// end