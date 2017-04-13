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
 * 入驻申请页面
 */
class franchisee_controller {

	public static function first() {
	    $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
	    
	    if (!ecjia_front::$controller->is_cached('franchisee_first.dwt', $cache_id)) {
	        ecjia_front::$controller->assign('form_action', RC_Uri::url('franchisee/index/first_check'));
	        ecjia_front::$controller->assign_title('店铺入驻');
	        ecjia_front::$controller->assign_lang();
	    }
		ecjia_front::$controller->display('franchisee_first.dwt', $cache_id);
	}

	public static function first_check() {
	    $name 	= empty($_POST['f_name']) ? '' : trim($_POST['f_name']);
	    $email 	= empty($_POST['f_email']) ? '' : trim($_POST['f_email']);
	    $mobile = empty($_POST['f_mobile']) ? '' : trim($_POST['f_mobile']);
	    $code 	= empty($_POST['f_code']) ? '' : trim($_POST['f_code']);
	    
		if (empty($name)) {
			return ecjia_front::$controller->showmessage('请输入真实姓名', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($email)) {
			return ecjia_front::$controller->showmessage('请输入电子邮箱', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($mobile)) {
			return ecjia_front::$controller->showmessage('请输入手机号码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($code)) {
			return ecjia_front::$controller->showmessage('验证码不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$chars = "/^1(3|4|5|7|8)\d{9}$/";
		if (!preg_match($chars, $mobile)) {
			return ecjia_front::$controller->showmessage('手机号码格式错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
	    //验证code
	    $params = array(
	        'token' 		=> ecjia_touch_user::singleton()->getToken(),
	        'type' 			=> 'mobile',
	        'value' 		=> $mobile,
	        'validate_code' => $code,
	        'validate_type' => 'signup'
	    );
	    $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_VALIDATE)->data($params)->run();
	    if (is_ecjia_error($rs)) {
	        return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
	    } else {
	        $_SESSION['franchisee_add'] = array(
	            'name' => $name,
	            'email' => $email,
	            'mobile' => $mobile,
	            'code'   => $code,
	            'access_time' => RC_Time::gmtime()
	        );
	        return ecjia_front::$controller->showmessage( '', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('franchisee/index/second')));
	    }
	}

	//入驻发送验证码
	public static function validate() {
		$mobile    = !empty($_GET['mobile']) ? $_GET['mobile'] : '';
		$type      = !empty($_GET['type']) ? $_GET['type'] : 'signup';

		if (!empty($mobile)) {
			$params = array(
				'token' => ecjia_touch_user::singleton()->getToken(),
				'type' 	=> 'mobile',
				'value' =>  $mobile,
				'validate_type' => $type//process,signup
			);
			$rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_VALIDATE)->data($params)->run();
				
			if (is_ecjia_error($rs)) {
				return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('search_url' => RC_Uri::url('franchisee/index/search')));
			} else {
				return ecjia_front::$controller->showmessage("短信已发送到手机".$mobile."，请注意查看", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		} else {
			if (empty($mobile)) {
				return ecjia_front::$controller->showmessage('请输入手机号码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$chars = "/^1(3|4|5|7|8)\d{9}$/";
			if (!preg_match($chars, $mobile)) {
				return ecjia_front::$controller->showmessage('手机号码格式错误', ecjia::MSGSTAT_JSON | ecjia::MSGTYPE_ERROR);
			}
		}
	}
	
	//入驻第二步
	public static function second() {
	    //验证第一步是否通过
	    if (empty($_SESSION['franchisee_add']) || $_SESSION['franchisee_add']['access_time'] + 1800 < RC_Time::gmtime()) {
	    	return ecjia_front::$controller->showmessage('请先填写基本信息', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('franchisee/index/first')));
	    }
	    
	    $token = ecjia_touch_user::singleton()->getToken();

        //重新修改入驻信息Get获取，正常入驻存session
        if (empty($_SESSION['franchisee_add']['mobile'])) {
            $mobile = !empty($_GET['mobile'])   ? $_GET['mobile']   : '';
        } else {
            $mobile = $_SESSION['franchisee_add']['mobile'];
        }
        if (empty($_SESSION['franchisee_add']['code'])) {
            $code   = !empty($_GET['code'])     ? $_GET['code']     : '';
        } else {
            $code  = $_SESSION['franchisee_add']['code'];
        }

        //之前的入驻信息
        $reaudit = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_PREAUDIT)->data(array('token' => $token, 'mobile' => $mobile, 'validate_code' => $code))->run();
        if (is_ecjia_error($reaudit)) {
        	return ecjia_front::$controller->showmessage($reaudit->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('franchisee/index/first')));
        }
        $category = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_CATEGORY)->data(array('token' => $token))->send()->getBody();
        $province = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('token' => $token, 'type' => 1))->send()->getBody();
         
        $category_list 	= ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_CATEGORY)->data(array('token' => $token))->run();
        $province_list  = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('token' => $token, 'type' => 1))->run();
        $city_list      = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('token' => $token, 'type' => 2))->run();
        $district_list  = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('token' => $token, 'type' => 3))->run();
        
        if (is_ecjia_error($mobile)) {
            return ecjia_front::$controller->showmessage('请先填写基本信息', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('franchisee/index/first')));
        } else {
            $category_show = '';
            foreach ($category_list as $k => $v) {
                if (!empty($reaudit['seller_category']) && in_array($reaudit['seller_category'], $v)) {
                    $category_show = $v['name'];
                }
            }
            if (empty($category_show)) {
                $category_show = $category_list[0]['name'];
            }
            if ($reaudit['validate_type'] == 2) {
                $validate_type = '企业入驻';
            } else {
                $validate_type = '个人入驻';
            }
            
            if (!empty($reaudit)) {
                foreach ($province_list[regions] as $k1 => $v1) {
                    foreach ($v1 as $k2 => $v3) {
                        if ($v3 == $reaudit['province']) {
                            $province_show = $v1['name'];
                        }
                    }
                }
                foreach ($city_list['regions'] as $k1 => $v1) {
                    foreach ($v1 as $k2 => $v3) {
                        if ($v3 == $reaudit['city']) {
                            $city_show = $v1['name'];
                        }
                    }
                }
                foreach ($district_list['regions'] as $k1 => $v1) {
                    foreach ($v1 as $k2 => $v3) {
                        if ($v3 == $reaudit['district']) {
                            $district_show = $v1['name'];
                        }
                    }
                }
                $_COOKIE['seller_category_id']    = $reaudit['seller_category'];
                $_COOKIE['province_id']           = $reaudit['province'];
                $_COOKIE['city_id']               = $reaudit['city'];
                $_COOKIE['district_id']           = $reaudit['district'];
                
            }
        }
        $second_show = array (
            'seller_name' 	=> $reaudit['seller_name'],
            'seller'     	=> $category_show,
            'validate_type' => $validate_type,
            'province_name' => $province_show,
            'city_name'     => $city_show,
            'district_name' => $district_show,
            'address'       => $reaudit['address']
        );
        
        
        $longitude = !empty($_GET['longitude']) ? $_GET['longitude'] : $reaudit['location']['longitude'];
        $latitude = !empty($_GET['latitude']) ? $_GET['latitude'] : $reaudit['location']['latitude'];
        
        ecjia_front::$controller->assign('form_action', RC_Uri::url('franchisee/index/finish'));
        
        ecjia_front::$controller->assign('second_show', $second_show);
        ecjia_front::$controller->assign('mobile', $mobile);
        ecjia_front::$controller->assign('code', $code);
        ecjia_front::$controller->assign('longitude', $longitude);
        ecjia_front::$controller->assign('latitude', $latitude);
        ecjia_front::$controller->assign('province', $province);
        ecjia_front::$controller->assign('category', $category);
        ecjia_front::$controller->assign('category_arr', json_decode($category, true));
        
        ecjia_front::$controller->assign_title('店铺入驻');
        ecjia_front::$controller->assign_lang();
		ecjia_front::$controller->display('franchisee_second.dwt');
	}
	
	public static function get_region() {
		$parent_id = $_POST['parent_id'];
		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('parent_id' => $parent_id))->run();
		if (is_ecjia_error($data)) {
			return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
		} else {
			return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $data['regions']));
		}
	}

	//入驻信息验证提交
	public static function finish() {
	    $token = ecjia_touch_user::singleton()->getToken();
	    
	    $responsible_person = !empty($_SESSION['franchisee_add']['name']) ? $_SESSION['franchisee_add']['name'] : '';
	    $email 				= !empty($_SESSION['franchisee_add']['email']) ? $_SESSION['franchisee_add']['email'] : '';
	    $mobile 			= !empty($_SESSION['franchisee_add']['mobile']) ? $_SESSION['franchisee_add']['mobile'] : '';
	    $validate_code 		= $_SESSION['franchisee_add']['code'];

	    $seller_name        = !empty($_POST['seller_name']) ? $_POST['seller_name'] : '';
	    $seller_category 	= !empty($_POST['seller_category']) ? $_POST['seller_category'] : 0;
	    $validate_type 		= !empty($_POST['validate_type']) ? $_POST['validate_type'] : 0;
	    if ($validate_type == '企业入驻') {
	        $validate_type = 2;
	    } else {
	        $validate_type = 1;
	    }
	    $province 	        = !empty($_POST['province']) ? $_POST['province'] : 0;
	    $city 	            = !empty($_POST['city']) ? $_POST['city'] : 0;
	    $district 	        = !empty($_POST['district']) ? $_POST['district'] : 0;
	    $address 		    = !empty($_POST['address']) ? $_POST['address'] : '';
	    $longitude 			= !empty($_POST['longitude']) ? $_POST['longitude'] : '';
	    $latitude 			= !empty($_POST['latitude']) ? $_POST['latitude'] : '';
	    
	    if (empty($responsible_person)) {
	        return ecjia_front::$controller->showmessage('请输入真实姓名', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($email)) {
	        return ecjia_front::$controller->showmessage('请输入邮箱地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($mobile)) {
	        return ecjia_front::$controller->showmessage('请输入手机号码', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($seller_name)) {
	        return ecjia_front::$controller->showmessage('请输入商店名称', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($seller_category)) {
	        return ecjia_front::$controller->showmessage('请选择店铺分类', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($validate_type)) {
	        return ecjia_front::$controller->showmessage('请选择店铺类型', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($province)) {
	        return ecjia_front::$controller->showmessage('请选择省', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($city)) {
	        return ecjia_front::$controller->showmessage('请选择市', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($district)) {
	        return ecjia_front::$controller->showmessage('请选择区', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($address)) {
	        return ecjia_front::$controller->showmessage('请填写详细地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (empty($longitude) || empty($latitude)) {
	        return ecjia_front::$controller->showmessage('请填写详细地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }

	    $parameter = array(
	        'token'              => $token,
	        'responsible_person' => $responsible_person,
	        'email'              => $email,
	        'mobile'             => $mobile,
	        'seller_name'        => $seller_name,
	        'seller_category'    => $seller_category,
	        'validate_type'      => $validate_type,
	        'province'           => $province,
	        'city'               => $city,
	        'district'           => $district,
	    	'address'            => $address,
	    	
	        'location' => array(
	        	'longitude'      => $longitude,
	            'latitude'       => $latitude,
	        ),
	    	'validate_code'  	 => $validate_code,
	    	'city_id'   		 => $_COOKIE['city_id']
	    );
	    
	    if ($_SESSION['franchisee_add']['property'] == 'resignup') {
	        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_RESIGNUP)->data($parameter)->run();
	    } else {
	        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_SIGNUP)->data($parameter)->run();
	    }
	    
    	if (is_ecjia_error($data)) {
			return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
		} else {
			return ecjia_front::$controller->showmessage("入驻信息已提交，请耐心等耐审核", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url'=>RC_Uri::url('franchisee/index/process', 'show=1')));
		}
	}

	public static function search() {
	    $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
	    
	    if (!ecjia_front::$controller->is_cached('franchisee_search.dwt', $cache_id)) {
	        ecjia_front::$controller->assign('url', RC_Uri::url('franchisee/index/process_search'));
	        ecjia_front::$controller->assign_lang();
	        ecjia_front::$controller->assign_title('进度查询');
	    }
	    ecjia_front::$controller->display('franchisee_search.dwt', $cache_id);
	}

	public static function process_search() {
		$mobile	= !empty($_POST['f_mobile'])	? $_POST['f_mobile']        : '';
		$code	= !empty($_POST['f_code'])      ? trim($_POST['f_code'])    : '';

	    if (empty($mobile)) {
	        return ecjia_front::$controller->showmessage(__('请输入手机号码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }

	    if (empty($code)) {
	        return ecjia_front::$controller->showmessage(__('验证码不能为空'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $chars = "/^1(3|4|5|7|8)\d{9}$/";
	    if (!preg_match($chars, $mobile)) {
	    	return ecjia_front::$controller->showmessage('手机号码格式错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    
	    $params  = array(
	        'token' 		=> ecjia_touch_user::singleton()->getToken(),
	        'mobile' 		=> $mobile,
	        'validate_code' => $code,
	    );
	    $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_PROCESS)->data($params)->run();
	    if (is_ecjia_error($rs)) {
	    	return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    } else {
    	    return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('franchisee/index/process', array('mobile' => $mobile, 'code' => $code))));
	    }
	}
	
	public static function process() {
	    $token     = ecjia_touch_user::singleton()->getToken();
        $mobile    = trim($_GET['mobile']);
        $code      = trim($_GET['code']);
        $show      = trim($_GET['show']);
        
        if ($show) {
            $check_status = 0;
            $info = array(
                'responsible_person' 	=> $_SESSION['franchisee_add']['name'],
                'email' 				=> $_SESSION['franchisee_add']['email'],
                'mobile'		 		=> $_SESSION['franchisee_add']['mobile'],
                'seller_name' 			=> $_COOKIE['seller_name'],
                'seller_category' 		=> $_COOKIE['seller'],
                'address' 				=> $_COOKIE['address'],
            );
        } else {
            $params    = array(
                'token' 		=> $token,
                'mobile' 		=> $mobile,
                'validate_code' => $code,
            );
            $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_PROCESS)->data($params)->run();
             
            if (!is_ecjia_error($rs)) {
                $check_status  = $rs['check_status'];
                $info      	   = $rs['merchant_info'];
            } else {
                return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }
             
            //撤销申请
            $status = !empty($_POST['status']) ? $_POST['status'] : '';
            if ($status == 'cancel') {
                ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_CANCEL)->data($params)->run();
                $back_act = RC_Uri::url('franchisee/index/first');
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('cancel_url' => $back_act));
            }

            //申请修改入驻信息
            $_SESSION['franchisee_add'] = array(
                'name'         => $rs['merchant_info']['responsible_person'],
                'email'        => $rs['merchant_info']['email'],
                'mobile'       => $rs['merchant_info']['mobile'],
				'code'         => $code,
                'property'     => 'resignup',
                'access_time'  => RC_Time::gmtime()
            );
        }
        ecjia_front::$controller->assign('mobile', $mobile);
        ecjia_front::$controller->assign('code', $code);
        ecjia_front::$controller->assign('check_status', $check_status);
        ecjia_front::$controller->assign('info', $info);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('申请进度');
        
	    ecjia_front::$controller->display('franchisee_process.dwt');
	}

	public static function get_location() {
		$token = ecjia_touch_user::singleton()->getToken();
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$token));
		
        if (!ecjia_front::$controller->is_cached('franchisee_get_location.dwt', $cache_id)) {
        	$mobile = !empty($_GET['mobile']) ? $_GET['mobile'] : '';
        	$code = !empty($_GET['code']) ? $_GET['code'] : '';
        	 
        	$province = !empty($_GET['province']) ? $_GET['province'] 	: '';
        	$city 	  = !empty($_GET['city']) 	  ? $_GET['city'] 		: '';
        	$district = !empty($_GET['district']) ? $_GET['district'] 	: '';
        	$address  = !empty($_GET['address'])  ? $_GET['address'] 	: '';
        	$shop_address = $province.$city.$district.$address;
        	
        	ecjia_front::$controller->assign('shop_address', $shop_address);
        	ecjia_front::$controller->assign('mobile', $mobile);
        	ecjia_front::$controller->assign('code', $code);
        	
        	ecjia_front::$controller->assign_lang();
        	ecjia_front::$controller->assign_title('店铺精确位置');
        }
		ecjia_front::$controller->display('franchisee_get_location.dwt', $cache_id);
	}
}

// end