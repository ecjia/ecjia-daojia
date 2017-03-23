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
 * 店铺街列表
 * @author will.chen
 */
class list_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$goods_category = $this->requestData('category_id', 0);

		$keywords = $this->requestData('keywords');
		$location = $this->requestData('location', array());
		$city_id	 = $this->requestData('city_id', 0);

		/* 获取数量 */
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		$options = array(
				'goods_category' => $goods_category,
				'keywords'		=> $keywords,
				'size'			=> $size,
				'page'			=> $page,
// 				'geohash'		=> $geohash_code,
				'sort'			=> array('sort_order' => 'asc'),
				'limit'			=> 'all'
		);

		/*经纬度为空判断*/
		if ((is_array($location) || !empty($location['longitude']) || !empty($location['latitude']))) {
			$geohash      = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
			$options['store_id']   = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code, 'city_id' => $city_id));
		} else {
			$seller_list = array();
			$page = array(
					'total'	=> '0',
					'count'	=> '0',
					'more'	=> '0',
			);
			return array('data' => $seller_list, 'pager' => $page);
		}
		
		if (empty($options['store_id'])) {
			$options['store_id'] = array(0);
		}
		
		$store_data = RC_Api::api('store', 'store_list', $options);
		$seller_list = array();
		if (!empty($store_data['seller_list'])) {
			$collect_store_id = RC_DB::table('collect_store')->where('user_id', $_SESSION['user_id'])->lists('store_id');

			foreach ($store_data['seller_list'] as $key => $row) {
				$favourable_list = array();
				/*增加优惠活动缓存*/
				$store_options = array(
						'store_id' => $row['id']
				);
				$favourable_result = RC_Api::api('favourable', 'store_favourable_list', $store_options);
				if (!empty($favourable_result)) {
					foreach ($favourable_result as $val) {
						if ($val['act_range'] == '0') {
							$favourable_list[] = array(
								'name' => $val['act_name'],
								'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
								'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
							);
						} else {
							$act_range_ext = explode(',', $val['act_range_ext']);
							switch ($val['act_range']) {
								case 1 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								case 2 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								case 3 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								default:
									break;
							}
						}
					}
				}
				
				$goods_options = array('store_id' => $row['id'], 'cat_id' => $goods_category, 'keywords' => $keywords, 'page' => 1, 'size' => 10);
				/* 如有查询添加，不限制分页*/
				if (!empty($goods_category) || !empty($keywords)) {
					$goods_options['size'] = $goods_options['page'] = 0;
				}
				
				$goods_list = array();
				$goods_result = RC_Api::api('goods', 'goods_list', $goods_options);
				if (!empty($goods_result['list'])) {
					foreach ($goods_result['list'] as $val) {
						/* 判断是否有促销价格*/
						$price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
						$activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
						/* 计算节约价格*/
						$saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);

						$goods_list[] = array(
							'goods_id'		=> $val['goods_id'],
							'name'			=> $val['name'],
							'market_price'	=> $val['market_price'],
							'shop_price'	=> $val['shop_price'],
							'promote_price'	=> $val['promote_price'],
							'img' => array(
								'thumb'	=> $val['goods_img'],
								'url'	=> $val['original_img'],
								'small'	=> $val['goods_thumb']
							),
							'activity_type' => $activity_type,
							'object_id'		=> 0,
							'saving_price'	=>	$saving_price,
							'formatted_saving_price' => $saving_price > 0 ? '已省'.$saving_price.'元' : '',
						);
					}
				}
				$goods_store_data = array('goods_list' => $goods_list, 'count' => $goods_result['page']->total_records);

				$distance = getDistance($location['latitude'], $location['longitude'], $row['location']['latitude'], $row['location']['longitude']);
	
				$distance_list[]	= $distance;
				$sort_order[]	 	= $row['sort_order'];
	
				$seller_list[] = array(
					'id'				=> $row['id'],
					'seller_name'		=> $row['seller_name'],
					'seller_category'	=> $row['seller_category'],
					'manage_mode'		=> $row['manage_mode'],
					'seller_logo'		=> $row['shop_logo'],
				    'seller_notice'     => $row['seller_notice'],
					'follower'			=> $row['follower'],
					'is_follower'		=> in_array($row['id'], $collect_store_id) ? 1 : 0,
					'goods_count'       => $goods_store_data['count'],
					'favourable_list'	=> $favourable_list,
					'distance'			=> $distance,
					'label_trade_time'	=> $row['label_trade_time'],
				    'seller_goods'		=> $goods_store_data['goods_list'],
				);
			}
		}
		array_multisort($distance_list, SORT_ASC, $sort_order, SORT_ASC, $seller_list);

		$seller_list = array_slice($seller_list, ($page-1)*$size, $size);
		
		$page = array(
			'total'	=> $store_data['page']->total_records,
			'count'	=> $store_data['page']->total_records,
			'more'	=> $store_data['page']->total_records - $page * $size >= 0 ? 1 : 0,
		);

		return array('data' => $seller_list, 'pager' => $page);
	}
}

/**
 * 计算两组经纬度坐标 之间的距离
 * @param params ：lat1 纬度1； lng1 经度1； lat2 纬度2； lng2 经度2； len_type （1:m or 2:km);
 * @return return m or km
 */
function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 1) {
	$EARTH_RADIUS = 6378.137;
	$PI = 3.1415926;
	$radLat1 = $lat1 * $PI / 180.0;
	$radLat2 = $lat2 * $PI / 180.0;
	$a = $radLat1 - $radLat2;
	$b = ($lng1 * $PI / 180.0) - ($lng2 * $PI / 180.0);
	$s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
	$s = $s * $EARTH_RADIUS;
	$s = round($s * 1000);
	if ($len_type > 1) {
		$s /= 1000;
	}

	return round($s, $decimal);
}

// end