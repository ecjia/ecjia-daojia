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

class touch_function {
    
    //获取token
    public static function get_token($return_all = 0) {
        $rs_token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        if (!is_ecjia_error($rs_token)) {
        	if ($return_all) {
        		return $rs_token;
        	} else {
        		return $rs_token['access_token'];
        	}
        }
    }
    
    public static function change_array_key($array, $new_key) {
        $new_array = array();
        if ($array) {
            foreach ($array as $val) {
                $new_array[$val[$new_key]] = $val;
            }
        }
        return $new_array;
    }
    public static function upload_file($url, $params){
//         $data = array(
//             'pic'=>'@'.realpath($path).";type=".$type.";filename=".$filename
//         'pic[0]'=>'@'.realpath($path).";type=".$type.";filename=".$filename//多图
//         );
        $ch = curl_init();
        //设置帐号和帐号名
        
//         curl_setopt($ch, CURLOPT_USERPWD, 'joe:secret' );
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_getinfo($ch);
        $return_data = curl_exec($ch);
        curl_close($ch);
        
        return $return_data;
    }
    
    public static function format_curl_response($data) {
//         {"status":{"succeed":0,"error_code":"comment_exist","error_desc":"\u8bc4\u4ef7\u5df2\u5b8c\u6210\uff0c\u8bf7\u52ff\u91cd\u590d\u8bc4\u4ef7"}}
        $data = json_decode($data, true);
        if ($data['status']['succeed']) {
            return $data['status']['data'];
        } else {
            return new ecjia_error($data['status']['error_code'], $data['status']['error_desc']);
        }
    }
    
    public static function redirect_referer_url($referer_url) {
    	//手动选择定位信息返回处理
    	$addr 		= isset($_GET['addr']) 	? $_GET['addr'] 				: '';
    	$name 		= isset($_GET['name']) 	? $_GET['name'] 				: '';
    	$city_name 	= isset($_GET['city']) 	? $_GET['city'] 				: '';
    	$latng 		= isset($_GET['latng']) ? explode(",", $_GET['latng']) 	: '';
    	$longitude 	= !empty($latng[1]) 	? $latng[1] 					: $_COOKIE['longitude'];
    	$latitude  	= !empty($latng[0]) 	? $latng[0] 					: $_COOKIE['latitude'];
    	
    	$params = array(
    		'token' => ecjia_touch_user::singleton()->getToken(),
    		'city' 	=> $city_name,
    	);
    	$rs = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION_DETAIL)->data($params)->run();
    	if (is_ecjia_error($rs)) {
    		return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
    	} else {
    		$city_id = $rs['region_id'];
    	}
    	 
    	if (!empty($addr)) {
    		setcookie("location_address", $addr, time() + 1800);
    		setcookie("location_name", $name, time() + 1800);
    		setcookie("longitude", $longitude, time() + 1800);
    		setcookie("latitude", $latitude, time() + 1800);
    		setcookie("location_address_id", 0, time() + 1800);
    		setcookie("city_id", $city_id, time() + 1800);
    		setcookie("city_name", $rs['region_name'], time() + 1800);
    		 
    		ecjia_front::$controller->redirect($referer_url);
    		die();
    	}
    }
}

//end