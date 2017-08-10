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
 * 定位模块控制器代码
 */
class location_controller {
	//首页定位触发进入页面
	//1、获取当前位置2、搜索位置  最终返回首页顶部定位更换信息
    public static function select_location() {
    	ecjia_front::$controller->assign('title', '上海');
    	ecjia_front::$controller->assign_title('定位');
    	
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
    	
    	if (ecjia_touch_user::singleton()->isSignin()) {
    		ecjia_front::$controller->assign('login', 1);
    		$token = ecjia_touch_user::singleton()->getToken();
        	$user_info = ecjia_touch_user::singleton()->getUserinfo();
        	
	    	$cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
	    	$cache_id = sprintf('%X', crc32($cache_id));
    		
    		if (!ecjia_front::$controller->is_cached('select_location.dwt', $cache_id)) {
    			$address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => $token))->run();
    			if (!is_ecjia_error($address_list) && !empty($address_list)) {
    				ecjia_front::$controller->assign('address_list', $address_list);
    			}
    		}
    		$location_url = RC_Uri::url('location/index/select_location');
    		ecjia_front::$controller->assign('location_url', urlencode($location_url));
    	}
    	
    	if (!ecjia_front::$controller->is_cached('select_location.dwt', $cache_id)) {
    		$referer_url = !empty($_GET['referer_url']) ? $_GET['referer_url'] : '';
    		if (!empty($referer_url)) {
    			ecjia_front::$controller->assign('referer_url', urlencode($referer_url));
    			$backurl = urlencode($referer_url);
    		} else{
    			$backurl = urlencode(RC_Uri::url('touch/index/init'));
    		}
    		$key       = ecjia::config('map_qq_key');
    		$referer   = ecjia::config('map_qq_referer');
    		$my_location = "https://apis.map.qq.com/tools/locpicker?search=1&type=0&backurl=".$backurl."&key=".$key."&referer=".$referer;
    		ecjia_front::$controller->assign('my_location', $my_location);
    		
    		$key = ecjia::config('map_qq_key');
    		$lat = $_COOKIE['position_latitude'];
    		$lng = $_COOKIE['position_longitude'];
    		$url = "http://apis.map.qq.com/ws/place/v1/search?boundary=nearby(".$lat.",".$lng.",1000)&page_size=20&page_index=1&keyword=".$_COOKIE['position_city_name']."&orderby=_distance&key=".$key;
    		
    		$response = RC_Http::remote_get($url);
    		$content  = json_decode($response['body'], true);
    		if (empty($content['data'])) {
    			$url = "http://apis.map.qq.com/ws/place/v1/search?boundary=region(".$_COOKIE['position_city_name'].",0)&page_size=20&page_index=1&keyword=".$_COOKIE['position_name']."&orderby=_distance&key=".$key;
    			$response = RC_Http::remote_get($url);
    			$content  = json_decode($response['body'], true);
    		}
    		ecjia_front::$controller->assign('content', $content['data']);
    	}
    	
        ecjia_front::$controller->display('select_location.dwt', $cache_id);
    }
    
    //请求接口返回数据
    public static function search_list() {
    	$region   = urlencode($_GET['region']);
    	$keywords = urlencode($_GET['keywords']);

    	$key		= ecjia::config('map_qq_key');
    	$url       	= "http://apis.map.qq.com/ws/place/v1/suggestion/?&region_fix=1&region=".$region."&keyword=".$keywords."&key=".$key."";

    	$response 	= RC_Http::remote_get($url);
    	$content  	= json_decode($response['body'], true);
    	
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $content));
    }
    
    //选择城市
    public static function select_city() {
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));

    	if (!ecjia_front::$controller->is_cached('select_location_city.dwt', $cache_id)) {
    		$rs = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CONFIG)->run();
    		if (is_ecjia_error($rs)) {
    			return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
    		}
    		ecjia_front::$controller->assign('citylist', $rs['recommend_city']);

    		$referer_url = !empty($_GET['referer_url']) ? $_GET['referer_url'] : '';
    		if (!empty($referer_url)) {
    			ecjia_front::$controller->assign('referer_url', urlencode($referer_url));
    		}
    		
    		$city_id = !empty($_GET['city_id']) ? intval($_GET['city_id']) : 0;
    		ecjia_front::$controller->assign('city_id', $city_id);
    		
    		ecjia_front::$controller->assign_title('选择城市');
    		ecjia_front::$controller->assign_lang();
    	}
    	ecjia_front::$controller->display('select_location_city.dwt', $cache_id);
    }
    

    //请求接口返回数据
    public static function get_location_msg() {
    	$locations 			= $_GET['lat'].','.$_GET['lng'];
    	$key 				= ecjia::config('map_qq_key');
    	$url       			= "https://apis.map.qq.com/ws/geocoder/v1/?location=".$locations."&key=".$key."&get_poi=1";
    	$response_address	= RC_Http::remote_get($url);
    	$content   			= json_decode($response_address['body'],true);
    	$location_content 	= $content['result']['pois'][0];
    	$location_name    	= $location_content['title'];
    	$location_address 	= $location_content['address'];
    	$latng 				= $location_content['location'];
    	$longitude 			= $latng['lng'];
    	$latitude  			= $latng['lat'];

    	$ad_info 			= $location_content['ad_info'];
    	$city_name			= $ad_info['city'];
    	
    	$params = array(
    		'token' => ecjia_touch_user::singleton()->getToken(),
    		'city' 	=> $city_name,
    	);
    	$rs = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION_DETAIL)->data($params)->run();
    	if (is_ecjia_error($rs)) {
    		return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
    	} else {
    		$city_id = !empty($rs['region_id']) ? $rs['region_id'] : 0;
    	}
    	$referer_url = RC_Uri::url('touch/index/init');
    	setcookie("referer_url", $referer_url, RC_Time::gmtime() + 3600 * 24 * 7);
    	
    	$href_url = RC_Uri::site_url() . substr($_SERVER['HTTP_REFERER'], strripos($_SERVER['HTTP_REFERER'], '/'));
    	 
    	$str1 = 'm=location&c=index&a=select_location';
    	if (strpos($href_url, $str1)) {
    		$href_url = RC_Uri::url('touch/index/init');
    	}
    	
    	//写入cookie
    	setcookie("location_address", $location_address, time() + 1800);
    	setcookie("location_name", $location_name, time() + 1800);
    	setcookie("longitude", $longitude, time() + 1800);
    	setcookie("latitude", $latitude, time() + 1800);
    	setcookie("location_address_id", 0, time() + 1800);
    	setcookie("city_id", $city_id, time() + 1800);
    	setcookie("city_name", $rs['region_name'], time() + 1800);
    	
    	//自动定位的城市id name 经纬度
    	setcookie("position_city_id", $city_id, time() + 1800);
    	setcookie("position_city_name", $rs['region_name'], time() + 1800);
    	setcookie("position_name", $location_name, time() + 1800);
    	setcookie("position_longitude", $longitude, time() + 1800);
    	setcookie("position_latitude", $latitude, time() + 1800);
    	
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $href_url));
    }
    
    public static function get_location_info() {
    	$location_msg = array();
    	
    	$location_msg['location_address_id']= $_COOKIE['location_address_id'];
    	$location_msg['location_address']   = $_COOKIE['location_address'];
    	$location_msg['location_name'] 		= $_COOKIE['location_name'];
    	$location_msg['longitude'] 			= $_COOKIE['longitude'];
    	$location_msg['latitude'] 			= $_COOKIE['latitude'];
    	
    	return $location_msg;
    } 
}

// end