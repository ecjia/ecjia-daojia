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
 * 会员编辑个人信息模块控制器代码
 */
class user_profile_controller {

    /**
     * 会员中心：编辑个人资料
     */
    public static function init() {
    	$token = ecjia_touch_user::singleton()->getToken();			//token参数
    	$user_info = ecjia_touch_user::singleton()->getUserinfo();	//id,name
    	$cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
    	$cache_id = sprintf('%X', crc32($cache_id));
    	
    	if (!ecjia_front::$controller->is_cached('user_profile.dwt', $cache_id)) {
    		$user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
    		$user_img_login = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
    		$user_img_logout = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-out2x.png';
    		if (!empty($user) && !is_ecjia_error($user)) {
    			if (!empty($user['avatar_img'])) {
    				$user_img_login = $user['avatar_img'];
    			}
    			ecjia_front::$controller->assign('user', $user);
    			ecjia_front::$controller->assign('user_img', $user_img_login);
    		} else {
    			ecjia_front::$controller->assign('user_img', $user_img_logout);
    		}
    		
    		ecjia_front::$controller->assign_lang();
    		ecjia_front::$controller->assign_title('个人资料');
    	}
    	if (user_function::is_weixin()) {
    		ecjia_front::$controller->assign('is_weixin', true);
    	}
        ecjia_front::$controller->display('user_profile.dwt', $cache_id);
    }
    
    /* 用户中心编辑用户名称 */
    public static function modify_username() {
    	$token = ecjia_touch_user::singleton()->getToken();
    	$user_info = ecjia_touch_user::singleton()->getUserinfo();	//id,name
    	
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name']));
    	
    	if (!ecjia_front::$controller->is_cached('user_modify_username.dwt', $cache_id)) {
    		$user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
    		$user = is_ecjia_error($user) ? array() : $user;
    		$time = RC_Time::gmtime();
    		$last_time = $user['update_username_time'];
    		$limit_time = RC_Time::local_strtotime($last_time) + 2592000;
    		if ($limit_time  > $time) {
    			ecjia_front::$controller->assign('limit_time', $limit_time);
    		}
    		
    		$update_username_time = substr($user['update_username_time'],0,10);
    		ecjia_front::$controller->assign('update_username_time', $update_username_time);
    		ecjia_front::$controller->assign('user', $user);
    		ecjia_front::$controller->assign_lang();
    		ecjia_front::$controller->assign_title('修改用户名');
    	}
      
        ecjia_front::$controller->display('user_modify_username.dwt', $cache_id);
    }

    /* 处理用户中心编辑用户名称 */
    public static function modify_username_account() {
        $name = !empty($_POST['username']) ? $_POST['username'] :'';
        if (strlen($name) > 20 || strlen($name) < 4) {
              return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('msg' => '修改失败，请输入4-20个字符'));
        }
        if (!empty($name)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_UPDATE)->data(array('user_name' => $name))->run();
            if (! is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('msg' => RC_Uri::url('user/profile/init')));
            } else {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('msg' => $data->get_error_message()));
            }
        }
    }
    
    /**
     * 修改密码页面
     */
    public static function edit_password() {
    	
    	//ajax请求
    	$type = !empty($_GET['type']) ? trim($_GET['type']) : '';
    	
    	if ($type == 'ajax') {
    		$old_password = !empty($_POST['old_password']) ? trim($_POST['old_password']) : '';
    		$new_password = !empty($_POST['new_password']) ? trim($_POST['new_password']) : '';
    		$comfirm_password = !empty($_POST['comfirm_password']) ? trim($_POST['comfirm_password']) : '';
    		
    		if (empty($old_password)) {
    			return ecjia_front::$controller->showmessage(__('请输入旧密码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		 
    		if (empty($new_password)) {
    			return ecjia_front::$controller->showmessage(__('请输入新密码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		 
    		if (empty($comfirm_password)) {
    			return ecjia_front::$controller->showmessage(__('请输入确认新密码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		 
    		$token = ecjia_touch_user::singleton()->getToken();
    		if (!empty($old_password)) {
    			if ($new_password == $comfirm_password) {
    				if ($old_password == $new_password) {
    					return ecjia_front::$controller->showmessage(__('新密码不能旧密码相同'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    				$data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_PASSWORD)->data(array('token' => $token, 'password' => $old_password, 'new_password' => $new_password))->run();
    				if (!is_ecjia_error($data)) {
    					return ecjia_front::$controller->showmessage(__('修改密码成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('touch/my/init')));
    				} else {
    					return ecjia_front::$controller->showmessage(__($data->get_error_message()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    			} else {
    				return ecjia_front::$controller->showmessage(__('两次输入的密码不同，请重新输入'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    		}
    	}
    	
    	$user_info = ecjia_touch_user::singleton()->getUserinfo();
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name']));
    	
    	if (!ecjia_front::$controller->is_cached('user_edit_password.dwt', $cache_id)) {
    		ecjia_front::$controller->assign_title('修改密码');
    		ecjia_front::$controller->assign_lang();
    	}   	
    	ecjia_front::$controller->display('user_edit_password.dwt', $cache_id);            
    }
    
    /**
     * 修改密码页面
     */
    public static function account_bind() {
        $token      = ecjia_touch_user::singleton()->getToken();
        $cache_id   = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$token));
        
        if (!ecjia_front::$controller->is_cached('user_account_bind.dwt', $cache_id)) {
            $type=!empty($_GET['type']) ? trim($_GET['type']) : '';
            $status = !empty($_GET['status']) ? trim($_GET['status']) : '';
            
            if ($type == 'mobile') {
                ecjia_front::$controller->assign('type', 'mobile');
            } else if ($type == 'email') {
                ecjia_front::$controller->assign('type', 'email');
            }
            
            if (!empty($status)) {
                ecjia_front::$controller->assign('status', $status);
            }
        }
        ecjia_front::$controller->display('user_account_bind.dwt', $cache_id);
    }
    
    /**
     * 获取绑定验证码
     */
    public static function get_code() {
        $mobile = !empty($_GET['mobile']) ? trim($_GET['mobile']) : '';
        $email = !empty($_GET['email']) ? $_GET['email'] : '';

        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        if (!empty($mobile)) {
            if ($user['mobile_phone'] == $mobile) {
                return ecjia_front::$controller->showmessage('该手机号与当前绑定的手机号相同', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CAPTCHA_SMS)->data(array('type' => 'user_modify_mobile', 'mobile' => $mobile))->run();
        } else if (!empty($email)) {
            if ($user['email'] == $email) {
                return ecjia_front::$controller->showmessage('该邮箱地址与当前绑定的邮箱地址相同', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CAPTCHA_MAIL)->data(array('type' => 'user_modify_mail', 'mail' => $email))->run();
        } else {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage(__($data->get_error_message()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }
    
    /**
     * 验证验证码并绑定
     */
    public static function check_code() {
        $value = !empty($_POST['mobile']) ? trim($_POST['mobile']) : trim($_POST['email']);
        $code = !empty($_POST['code']) ? trim($_POST['code']) : '';
        $type = !empty($_POST['type']) ? $_POST['type'] : '';
        
        if (!empty($code) && !empty($type)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_BIND)->data(array('type' => $type, 'value' => $value, 'code' => $code))->run();
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage(__($data->get_error_message()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/profile/init')));
            }
        }
    }
    /**
     * 查看绑定手机号和邮箱
     */
    public static function bind_info() {
        $token      = ecjia_touch_user::singleton()->getToken();
        $cache_id   = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$token));
        
        if (!ecjia_front::$controller->is_cached('user_bind_info.dwt', $cache_id)) {
            $user       = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
            $type       = !empty($_GET['type']) ? trim($_GET['type']) : '';
            ecjia_front::$controller->assign('user', $user);
            if ($type == 'mobile') {
                ecjia_front::$controller->assign('type', 'mobile');
            } else if ($type == 'email') {
                ecjia_front::$controller->assign('type', 'email');
            } 
        }
        ecjia_front::$controller->display('user_bind_info.dwt', $cache_id);
    }
}

// end