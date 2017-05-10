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
 * 管理员登录
 * @author will
 */
class signin_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();
		
		$username	= $this->requestData('username');
		$password	= $this->requestData('password');
		$device		= $this->device;

		if (empty($username) || empty($password)) {
			$result = new ecjia_error('login_error', __('您输入的帐号信息不正确'));
			return $result;
		}
		
		//根据用户名判断是商家还是平台管理员
		//如果商家员工表存在，以商家为准
		$row_staff = RC_DB::table('staff_user')->where('mobile', $username)->first();
		
		if ($row_staff) {
		    //商家
		    return signin_merchant($username, $password, $device);
		} else {
		    //平台
		    $result = new ecjia_error('login_error', __('此账号不是商家账号'));
		    return $result;
// 		    return signin_admin($username, $password, $device);
		}
	}
}

function signin_merchant($username, $password, $device) {
    /* 收银台请求判断处理*/
    if (!empty($device) && is_array($device) && $device['code'] == '8001') {
        $adviser_info = RC_Model::model('achievement/adviser_model')->find(array('username' => $username));
        if (empty($adviser_info)) {
			$result = new ecjia_error('login_error', __('您输入的帐号信息不正确'));
			return $result;
        }
        $admin_info = RC_DB::table('staff_user')->where('user_id', $adviser_info['admin_id'])->first();
        $username	= $admin_info['mobile'];
        $salt	    = $admin_info['salt'];
    } else {
        $salt = RC_DB::table('staff_user')->where('mobile', $username)->pluck('salt');
    }
    
    /* 检查密码是否正确 */
    $db_staff_user = RC_DB::table('staff_user')->selectRaw('user_id, mobile, name, store_id, nick_name, email, last_login, last_ip, action_list, avatar, group_id, online_status');
    if (!empty($salt)) {
        $db_staff_user->where('mobile', $username)->where('password', md5(md5($password).$salt) );
    } else {
        $db_staff_user->where('mobile', $username)->where('password', md5($password) );
    }
    $row = $db_staff_user->first();
    
    if ($row) {
        // 登录成功
        /* 设置session信息 */
        /*  
         [store_id] => 15
         [store_name] => 天天果园专营店
         [staff_id] => 1
         [staff_mobile] => 15921158110
         [staff_name] => hyy
         [staff_email] => hyy
         [last_login] => 1476816441
         adviser_id
         shop_guide
         [admin_id] => 0
         [admin_name] => 0
         [action_list] => all
         [email] => 0
         [device_id]
         [ip] => 0.0.0.0
          */
    
    
        $_SESSION['admin_id']	    = 0;
        $_SESSION['admin_name']	    = null;
        $_SESSION['action_list']    = $row['action_list'];
         
        $_SESSION['store_id']	    = $row['store_id'];
        $_SESSION['store_name']	    = RC_DB::table('store_franchisee')->where('store_id', $row['store_id'])->pluck('merchants_name');
        $_SESSION['staff_id']	    = $row['user_id'];
        $_SESSION['staff_mobile']	= $row['mobile'];
        $_SESSION['staff_name']	    = $row['name'];
        $_SESSION['staff_email']	= $row['email'];
        
        $_SESSION['last_login']	    = $row['last_login'];
        $_SESSION['last_ip']	    = $row['last_ip'];
        
        /* 获取device_id*/
        $device_id = RC_Model::model('mobile/mobile_device_model')->where(array('device_udid' => $device['udid'], 'device_client' => $device['client'], 'device_code' => $device['code']))->get_field('id');
        $_SESSION['device_id']	    = $row['device_id'];
         
        if ($device['code'] == '8001') {
            $_SESSION['adviser_id']	= $row['user_id'];
            $_SESSION['admin_name']	= $row['mobile'];
        }
         
        if (empty($row['salt'])) {
            $salt = rand(1, 9999);
            $new_possword = md5(md5($password) . $salt);
            $data = array(
                'salt'	=> $salt,
                'password'	=> $new_possword
            );
            RC_DB::table('staff_user')->where('user_id', $_SESSION['admin_id'])->update($data);
        }
    
        if ($row['action_list'] == 'all' && empty($row['last_login'])) {
            $_SESSION['shop_guide'] = true;
        }
    
        $data = array(
            'last_login' 	=> RC_Time::gmtime(),
            'last_ip'		=> RC_Ip::client_ip(),
        );
        RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
    
        $out = array(
            'session' => array(
                'sid' => RC_Session::session_id(),
                'uid' => $_SESSION['admin_id']
            ),
        );
        $role_name = $group = '';
        
        switch ($row['group_id']) {
        	case -1 : 
        		$role_name	= "配送员";
        		$group		= 'express';
        		break;
        	default:
        		if ($row['group_id'] > 0) {
        			$role_name = RC_DB::table('staff_group')->where('group_id', $row['group_id'])->pluck('group_name');
        		}
        		break;
        }

        /* 登入后默认设置离开状态*/
        if ($row['online_status'] != 4 && $group == 'express') {
        	RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('online_status' => 4));
        	/* 获取当前时间戳*/
        	$time = RC_Time::gmtime();
        	$fomated_time = RC_Time::local_date('Y-m-d', $time);
        	/* 查询签到记录*/
        	$checkin_log = RC_DB::table('express_checkin')->where('user_id', $_SESSION['staff_id'])->orderBy('log_id', 'desc')->first();
        	if ($fomated_time == $checkin_log['checkin_date'] && empty($checkin_log['end_time'])) {
        		$duration = $time - $checkin_log['start_time'];
        		RC_DB::table('express_checkin')->where('log_id', $checkin_log['log_id'])->update(array('end_time' => $time, 'duration' => $duration));
        	}
        }
        
        $out['userinfo'] = array(
            'id' 			=> $row['user_id'],
            'username'		=> $row['mobile'],
            'email'			=> $row['email'],
            'last_login' 	=> RC_Time::local_date(ecjia::config('time_format'), $row['last_login']),
            'last_ip'		=> RC_Ip::area($row['last_ip']),
            'role_name'		=> $role_name,
            'role_type'		=> $row['group_id'] == -1 ? 'express_user' : '',
        	'group'			=> $group,
            'avator_img'	=> !empty($row['avatar']) ? RC_Upload::upload_url($row['avatar']) : null,
        );
        
        if ($device['code'] == '8001') {
            $out['userinfo']['username'] = $adviser_info['username'];
            $out['userinfo']['email']	 = $adviser_info['email'];
        }
        
        //修正关联设备号
        $result = ecjia_app::validate_application('mobile');
        if (!is_ecjia_error($result)) {
            if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
            	$db_mobile_device = RC_Model::model('mobile/mobile_device_model');
            	$device_data = array(
            			'device_udid'	=> $device['udid'],
            			'device_client'	=> $device['client'],
            			'device_code'	=> $device['code'],
            			'user_type'		=> 'merchant',
            	);
            	$device_info = $db_mobile_device->find($device_data);
            	if (empty($device_info)) {
            		$device_data['add_time'] = RC_Time::gmtime();
            		$db_mobile_device->insert($device_data);
            	} else {
            		$db_mobile_device->where($device_data)->update(array('user_id' => $_SESSION['staff_id'], 'update_time' => RC_Time::gmtime()));
            	}
            }
        }
         
        return $out;
    } else {
        return new ecjia_error('login_error', __('您输入的帐号信息不正确'));
    }
}

function signin_admin($username, $password, $device) {
    $db_user = RC_Model::model('user/admin_user_model');
    //到家后台不允许平台管理员登录
    if (!empty($device) && is_array($device) && ($device['code'] == '6001' || $device['code'] == '6002')) {
        if ($db_user->where(array('user_name' => $username))->count()) {
            return new ecjia_error('login_error', __('平台管理员请登录掌柜管理'));
        } else {
            return new ecjia_error('login_error', __('您输入的帐号信息不正确'));
        }
        
    }
    
    /* 收银台请求判断处理*/
    if (!empty($device) && is_array($device) && $device['code'] == '8001') {
        $adviser_info = RC_Model::model('achievement/adviser_model')->find(array('username' => $username));
        if (empty($adviser_info)) {
            $result = new ecjia_error('login_error', __('您输入的帐号信息不正确'));
            return $result;
        }
        $admin_info = $db_user->field(array('user_name', 'ec_salt'))->find(array('user_id' => $adviser_info['admin_id']));
        $username	= $admin_info['user_name'];
        $ec_salt	= $admin_info['ec_salt'];
    } else {
        $ec_salt    = $db_user->where(array('user_name' => $username))->get_field('ec_salt');
    }
    
    
    /* 检查密码是否正确 */
    if (!empty($ec_salt)) {
        $row = $db_user->find(array('user_name' => $username, 'password' => md5(md5($password).$ec_salt)));
    } else {
        $row = $db_user->find(array('user_name' => $username, 'password' => md5($password)));
    }
    
    if ($row) {
        // 登录成功
        /* 设置session信息 */
        $_SESSION['admin_id']	    = $row['user_id'];
        $_SESSION['admin_name']	    = $row['user_name'];
        $_SESSION['action_list']	= $row['action_list'];
        $_SESSION['last_login']	    = $row['last_login'];
        $_SESSION['suppliers_id']	= $row['suppliers_id'];
        
        $_SESSION['store_id']	    = 0;
        $_SESSION['store_name']	    = null;
        $_SESSION['staff_id']	    = 0;
        $_SESSION['staff_mobile']	= null;
        $_SESSION['staff_name']	    = null;
        $_SESSION['staff_email']	= null;
        
        $_SESSION['last_ip']	    = $row['last_ip'];
        	
        /* 获取device_id*/
        $device_id = RC_Model::model('mobile/mobile_device_model')->where(array('device_udid' => $device['udid'], 'device_client' => $device['client'], 'device_code' => $device['code']))->get_field('id');
        $_SESSION['device_id']	    = $row['device_id'];
    
        	
        if ($device['code'] == '8001') {
            $_SESSION['adviser_id']	= $row['id'];
            $_SESSION['admin_name']	= $row['username'];
        }
        	
        if (empty($row['ec_salt'])) {
            $ec_salt = rand(1, 9999);
            $new_possword = md5(md5($password) . $ec_salt);
            $data = array(
                'ec_salt'	=> $ec_salt,
                'password'	=> $new_possword
            );
            $db_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);
        }
    
        if ($row['action_list'] == 'all' && empty($row['last_login'])) {
            $_SESSION['shop_guide'] = true;
        }
    
        $data = array(
            'last_login' 	=> RC_Time::gmtime(),
            'last_ip'		=> RC_Ip::client_ip(),
        );
        $db_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);
    
        $out = array(
            'session' => array(
                'sid' => RC_Session::session_id(),
                'uid' => $_SESSION['admin_id']
            ),
        );
        $db_role = RC_Loader::load_model('role_model');
        $role_name = $db_role->where(array('role_id' => $row['role_id']))->get_field('role_name');
        	
        $out['userinfo'] = array(
            'id' 			=> $row['user_id'],
            'username'		=> $row['user_name'],
            'email'			=> $row['email'],
            'last_login' 	=> RC_Time::local_date(ecjia::config('time_format'), $row['last_login']),
            'last_ip'		=> RC_Ip::area($row['last_ip']),
            'role_name'		=> !empty($role_name) ? $role_name : '',
            'role_type'		=> $row['group_id'] == -1 ? 'express_user' : '',
            'avator_img'	=> RC_Uri::admin_url('statics/images/admin_avatar.png'),
        );
        	
        if ($device['code'] == '8001') {
            $out['userinfo']['username'] = $adviser_info['username'];
            $out['userinfo']['email']	 = $adviser_info['email'];
        }
        	
        //修正关联设备号
        $result = ecjia_app::validate_application('mobile');
        if (!is_ecjia_error($result)) {
            if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
                $db_mobile_device = RC_Model::model('mobile/mobile_device_model');
                $device_data = array(
                    'device_udid'	=> $device['udid'],
                    'device_client'	=> $device['client'],
                    'device_code'	=> $device['code'],
                    'user_type'		=> 'admin',
                );
                $device_info = $db_mobile_device->find($device_data);
                if (empty($device_info)) {
                	$device_data['add_time'] = RC_Time::gmtime();
                	$db_mobile_device->insert($device_data);
                } else {
                	$db_mobile_device->where($device_data)->update(array('user_id' => $_SESSION['admin_id'], 'update_time' => RC_Time::gmtime()));
                }
            }
        }
        	
        return $out;
    } else {
        $result = new ecjia_error('login_error', __('您输入的帐号信息不正确'));
        return $result;
    }
}

// end