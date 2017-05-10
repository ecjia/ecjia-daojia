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
 * 首页轮播图及推荐数据
 * @author royalwang
 */
class data_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
		$device		= $this->device;

		$location	= $this->requestData('location', array());
		$city_id	= $this->requestData('city_id', 0);

		$request = null;
		
		if (is_array($location) && isset($location['latitude']) && isset($location['longitude'])) {
			$request                     = array('location' => $location);
			$geohash                     = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code                = $geohash->encode($location['latitude'] , $location['longitude']);
// 			$geohash_code                = substr($geohash_code, 0, 5);
			$request['geohash_code']     = $geohash_code;
			$request['store_id_group']   = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code, 'city_id' => $city_id));

			if (empty($request['store_id_group'])) {
				$request['store_id_group'] = array(0);
			}
		} 
		
		$device['code'] = isset($device['code']) ? $device['code'] : '';
		//流程逻辑开始
		// runloop 流
		$response = array();
		$response = RC_Hook::apply_filters('api_home_data_runloop', $response, $request);//mobile_home_adsense1
		return $response;

	}
}

function filter_adsense_group_data($data) {
    return collect($data)->map(function($item, $key) {
    	return [
    		'image' => $item['ad_img'],
    		'text' => $item['ad_name'],
    		'url' => $item['ad_link'],
    	];
    })->toArray();
}
RC_Hook::add_filter('filter_adsense_group_data', 'filter_adsense_group_data');

function cycleimage_data($response, $request) 
{
    $request = royalcms('request');
    
    $city_id	= $request->input('city_id', 0);
    
    $device_client = $request->header('device-client', 'iphone');
    
    if ($device_client == 'android') {
        $client = Ecjia\App\Adsense\Client::ANDROID;
    } elseif ($device_client == 'h5') {
        $client = Ecjia\App\Adsense\Client::H5;
    } else {
        $client = Ecjia\App\Adsense\Client::IPHONE;
    }
    
	$cycleimageDatas = RC_Api::api('adsense',  'cycleimage', [
	    'code'     => 'home_cycleimage', 
	    'client'   => $client, 
	    'city'     => $city_id
	]);

	$player_data = array();
	foreach ($cycleimageDatas as $val) {
		$player_data[] = array(
			'photo' => array(
					'small'      => $val['image'],
					'thumb'      => $val['image'],
					'url'        => $val['image'],
			),
			'url'        => $val['url'],
			'description'=> $val['text'],
		);
	}

	$response['player'] = $player_data;

	return $response;
}

function mobile_menu_data($response, $request) {
	$request = royalcms('request');
	
	$city_id	= $request->input('city_id', 0);
	
	$device_client = $request->header('device-client', 'iphone');
	
	if ($device_client == 'android') {
	    $client = Ecjia\App\Adsense\Client::ANDROID;
	} elseif ($device_client == 'h5') {
	    $client = Ecjia\App\Adsense\Client::H5;
	} else {
	    $client = Ecjia\App\Adsense\Client::IPHONE;
	}
	
	$shortcutDatas = RC_Api::api('adsense',  'shortcut', [
	    'code'     => 'home_shortcut',
	    'client'   => $client,
	    'city'     => $city_id
	    ]);

	$response['mobile_menu'] = $shortcutDatas;
	return $response;
}

function promote_goods_data($response, $request) {
	
	$promote_goods_data = array();
	$order_sort         = array('g.sort_order' => 'ASC', 'goods_id' => 'DESC');
	$filter = array(
			'intro'	  => 'promotion',
			'sort'	  => $order_sort,
			'page'	  => 1,
			'size'	  => 6,
			'store_id' => $request['store_id_group'],
// 			'geohash' => $request['geohash_code'],
	);

	$result = RC_Api::api('goods', 'goods_list', $filter);
	if ( !empty($result['list']) ) {
		foreach ( $result['list'] as $key => $val ) {
			$promote_goods_data[] = array(
					'id'		                => intval($val['goods_id']),
					'goods_id'	                => intval($val['goods_id']),           //多商铺中不用，后期删除
					'name'		                => $val['goods_name'],
					'market_price'	            => $val['market_price'],
					'shop_price'	            => $val['shop_price'],
					'promote_price'	            => $val['promote_price'],
					'manage_mode'               => $val['manage_mode'],
					'unformatted_promote_price' => $val['unformatted_promote_price'],
					'promote_start_date'        => $val['promote_start_date'],
					'promote_end_date'          => $val['promote_end_date'],
					'img'                       => array(
            							'small' => $val['goods_thumb'],
            							'thumb' => $val['goods_img'],
            							'url'	=> $val['original_img'],
					)
			);
		}
	}
	
	$response['promote_goods'] = $promote_goods_data;
	return $response;
}

function new_goods_data($response, $request) {
	$new_goods_data = array();

	$order_sort = array('g.sort_order' => 'ASC', 'goods_id' => 'DESC');
	$filter     = array(
			'intro'	=> 'new',
			'sort'	=> $order_sort,
			'page'	=> 1,
			'size'	=> 6,
			'store_id' => $request['store_id_group'],
// 			'geohash' => $request['geohash_code'],
	);
	
	$result = RC_Api::api('goods', 'goods_list', $filter);
	if ( !empty($result['list']) ) {
		foreach ( $result['list'] as $key => $val ) {
			$new_goods_data[] = array(
					'id'            => intval($val['goods_id']),
					'goods_id'      => intval($val['goods_id']),           //多商铺中不用，后期删除
					'name'          => $val['goods_name'],
					'manage_mode'   => $val['manage_mode'],
					'market_price'	=> $val['market_price'],
					'shop_price'	=> $val['shop_price'],
					'promote_price'	=> $val['promote_price'],
					'img'           => array(
							'small' => $val['goods_thumb'],
							'thumb' => $val['goods_img'],
							'url'	=> $val['original_img'],
					)
			);
		}
	}

	$response['new_goods'] = $new_goods_data;
	return $response;
}


function mobile_home_adsense_group($response, $request) {
    $request = royalcms('request');
    
    $city_id	= $request->input('city_id', 0);
    
    $device_client = $request->header('device-client', 'iphone');
    
    if ($device_client == 'android') {
        $client = Ecjia\App\Adsense\Client::ANDROID;
    } elseif ($device_client == 'h5') {
        $client = Ecjia\App\Adsense\Client::H5;
    } else {
        $client = Ecjia\App\Adsense\Client::IPHONE;
    }
    
    $mobile_home_adsense_group = RC_Api::api('adsense',  'adsense_group', [
        'code'     => 'home_complex_adsense',
        'client'   => $client,
        'city'     => $city_id
    ]);
    	
	$response['adsense_group'] = $mobile_home_adsense_group;

	return $response;
}

function group_goods_data($response, $request) {
	$response['group_goods'] = array();
	return $response;
}

function mobilebuy_goods_data($response, $request) {
	$response['mobile_buy_goods'] = array();
	return $response;
}

function seller_recommend_data($response, $request) {
		$response['seller_recommend'] = array();
		return $response; 
}

function topic_data($response, $request) {
	$response['mobile_topic_adsense'] = array();
	return $response;
}

function mobile_toutiao_data($response, $request) {
	$response['toutiao'] = $mobile_toutiao_data;
	return $response;
}


RC_Hook::add_filter('api_home_data_runloop', 'cycleimage_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobile_menu_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'promote_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'new_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobile_home_adsense_group', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'group_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobilebuy_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'topic_data', 10, 2);

// end
