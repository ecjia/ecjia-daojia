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

class user_signup_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	$shop_reg_closed = ecjia::config('shop_reg_closed');
		if ($shop_reg_closed == '1') {
			return new ecjia_error('shop_reg_closed', '会员注册关闭');
		}
		
		RC_Loader::load_app_class('integrate', 'user', false);
		
		$username	   = $this->requestData('name');
		$password	   = $this->requestData('password', '');
		$email		   = $this->requestData('email');
		$fileld		   = $this->requestData('field', array());
		$device		   = $this->device;
		$mobile		   = $this->requestData('mobile');
		$device_client = isset($device['client']) ? $device['client'] : '';
		$invite_code   = $this->requestData('invite_code');
		$api_version   = $this->request->header('api-version');
	
		$other		   = array();
		$filelds	   = array();
		
		foreach ($fileld as $val) {
			$filelds[$val['id']] = $val['value'];
		}
		$other['msn']	        = isset($filelds[1]) ? $filelds[1] : '';
		$other['qq']	        = isset($filelds[2]) ? $filelds[2] : '';
		$other['office_phone']	= isset($filelds[3]) ? $filelds[3] : '';
		$other['home_phone']	= isset($filelds[4]) ? $filelds[4] : '';
		$other['mobile_phone']	= isset($filelds[5]) ? $filelds[5] : '';
		
		/* 随机生成6位随机数 + 请求客户端类型作为用户名*/
		$code = '';
		$charset 		= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$charset_len    = strlen($charset)-1;
		for ($i = 0; $i < 6; $i++) {
			$code .= $charset[rand(1, $charset_len)];
		}
		
		if (version_compare($api_version, '1.17', '>=')) {
			if (empty($username) && empty($mobile)) {
				return new ecjia_error('invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
			}
			if (!empty($username) && empty($mobile)) {
				/* 判断是否为手机*/
			    $check_mobile = Ecjia\App\Sms\Helper::check_mobile($username);
			    if($check_mobile === true) {
// 				if (is_numeric($username) && strlen($username) == 11 && preg_match('/^1(3|4|5|6|7|8|9)\d{9}$/', $username)) {
					/* 设置用户手机号*/
					$other['mobile_phone'] = $username;
					$mobile = $username;
					$username = substr_replace($username,'****',3,4);
					$user = integrate::init_users();
					
				}
			}elseif (empty($username) && !empty($mobile)) {
				/* 判断是否为手机*/
			    $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile);
			    if($check_mobile === true) {
// 				if (is_numeric($mobile) && strlen($mobile) == 11 && preg_match('/^1(3|4|5|6|7|8|9)\d{9}$/', $mobile)) {
					/* 设置用户手机号*/
					$other['mobile_phone'] = $mobile;
				
					$username = substr_replace($mobile,'****',3,4);
					$user = integrate::init_users();
				}
			}
		} else {
			/* 判断是否为手机*/
		    $check_mobile = Ecjia\App\Sms\Helper::check_mobile($username);
		    if($check_mobile === true) {
// 			if (is_numeric($username) && strlen($username) == 11 && preg_match('/^1(3|4|5|6|7|8|9)\d{9}$/', $username)) {
				/* 设置用户手机号*/
				$other['mobile_phone'] = $username;
				$mobile = $username;
				$username = $device_client.'_'.$code;
				$user = integrate::init_users();
				if ($user->check_user($username)) {
					$username = $username. rand(0,9);
				}
			}
		}
		
		if (empty($email)) {
			$email = $device_client.'_'.$code.'@mobile.com';
		}
		
		$other['mobile_phone'] = empty($mobile) ? $other['mobile_phone'] : $mobile;
// 		if (is_numeric($other['mobile_phone']) && strlen($other['mobile_phone']) == 11 && preg_match('/^1(3|4|5|6|7|8|9)\d{9}$/', $other['mobile_phone'])) {
	    $check_mobile = Ecjia\App\Sms\Helper::check_mobile($other['mobile_phone']);
	    if($check_mobile === true) {
			$db_user      = RC_Loader::load_app_model('users_model', 'user');
			$mobile_count = $db_user->where(array('mobile_phone' => $other['mobile_phone']))->count();
			if ($mobile_count > 0 ) {
				return new ecjia_error('user_exists', '用户已存在！');
			}
		} else {
			$other['mobile_phone'] = '';
		}
		
		$other['last_login'] = RC_Time::gmtime();
		if (version_compare($api_version, '1.17', '>=')) {
			$result = $this->register($username, $password, $email, $other, $api_version);
		} else {
			$result = $this->register($username, $password, $email, $other);
		}
		
		if (is_ecjia_error($result)) {
			return $result;
		} else {
			$db = RC_Loader::load_app_model('reg_extend_info_model','user');
			$db_reg_fields = RC_Loader::load_app_model('reg_fields_model','user');
			
			/*把新注册用户的扩展信息插入数据库*/
	        $fields_arr = $db_reg_fields->field('id')->where(array('type' => 0 , 'display' => 1))->order(array('dis_order' => 'asc' ,'id' => 'asc'))->select();
	        
			$extend_field_str = '';    //生成扩展字段的内容字符串
			if (!empty($fields_arr)) {
				foreach ($fields_arr AS $val) {
					$extend_field_index = $val['id'];
					if(!empty($filelds[$extend_field_index])) {
						$temp_field_content = strlen($filelds[$extend_field_index]) > 100 ? mb_substr($filelds[$extend_field_index], 0, 99) : $filelds[$extend_field_index];
		 				$extend_field_str .= " ('" . $_SESSION['user_id'] . "', '" . $val['id'] . "', '" . $temp_field_content . "'),";
					}
				}
			}
			
	 		$extend_field_str = substr($extend_field_str, 0, -1);
			//插入注册扩展数据
	 		if ($extend_field_str) {
				$data = array(
					    'user_id'      => $_SESSION['user_id'],
					    'reg_field_id' => $val['id'],
					    'content'      => $temp_field_content
				);
				$db->insert($data);  
 			}
 			
 			/*注册送红包*/
 			//RC_Api::api('bonus', 'send_bonus', array('type' => SEND_BY_REGISTER));
 			/*客户端没传invite_code时，判断手机号码有没被邀请过*/
 			if (empty($invite_code)) {
 				/*获取邀请记录信息*/
 				$is_invitedinfo = RC_DB::table('invitee_record')
 				->where('invitee_phone', $mobile)
 				->where('invite_type', 'signup')
 				->where('expire_time', '>', RC_Time::gmtime())
 				->first();
 				if (!empty($is_invitedinfo)) {
 					/*获取邀请者的邀请码*/
 					$invite_code = RC_DB::table('term_meta')
 					->where('object_type', 'ecjia.affiliate')
 					->where('object_group', 'user_invite_code')
 					->where('meta_key', 'invite_code')
 					->where('object_id', $is_invitedinfo['invite_id'])
 					->pluck('meta_value');
 				}
 			}
 			$result = ecjia_app::validate_application('affiliate');
 			if (!is_ecjia_error($result) && !empty($invite_code)) {
 				RC_Api::api('affiliate', 'invite_bind', array('invite_code' => $invite_code, 'mobile' => $mobile));
 			}
 			
 			RC_Loader::load_app_func('admin_user', 'user');
			$user_info = EM_user_info($_SESSION['user_id']);
			
			$out = array(
					'session' => array(
					    'sid' => RC_Session::session_id(),
					    'uid' => $_SESSION['user_id']
					),
					'user' => $user_info
			);
			
			//修正咨询信息
			if($_SESSION['user_id'] > 0) {
				$device_id        = isset($device['udid']) ? $device['udid'] : '';
				$device_client    = isset($device['client']) ? $device['client'] : '';
				//$db_term_relation = RC_Loader::load_model('term_relationship_model');
				//$object_id = $db_term_relation->where(array(
				//									'object_type'	=> 'ecjia.feedback',
				//									'object_group'	=> 'feedback',
				//									'item_key2'		=> 'device_udid',
				//									'item_value2'	=> $device_id ))
				//							->get_field('object_id', true);
				
				$pra = array(
						'object_type'	=> 'ecjia.feedback',
						'object_group'	=> 'feedback',
						'item_key2'		=> 'device_udid',
						'item_value2'	=> $device_id
				);
				$object_id = Ecjia\App\User\TermRelationship::GetObjectIds($pra);
				
				//更新未登录用户的咨询
				//$db_term_relation->where(array('item_key2' => 'device_udid', 'item_value2' => $device_id))->update(array('item_key2' => '', 'item_value2' => ''));
				RC_DB::table('term_relationship')->where('item_key2', 'device_udid')->where('item_value2', $device_id)->update(array('item_key2' => '', 'item_value2' => ''));
				
				if(!empty($object_id)) {
					$db = RC_Loader::load_app_model('feedback_model', 'feedback');
					$db->where(array('msg_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name']));
					$db->where(array('parent_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name']));
				}
				
				//修正关联设备号
				$result = ecjia_app::validate_application('mobile');
				if (!is_ecjia_error($result)) {
					if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
						//$db_mobile_device = RC_Loader::load_app_model('mobile_device_model', 'mobile');
// 						$device_data = array(
// 							'device_udid'	=> $device['udid'],
// 							'device_client'	=> $device['client'],
// 							'device_code'	=> $device['code'],
// 							'user_type'		=> 'user',
// 						);
						RC_DB::table('mobile_device')->where('device_udid', $device['udid'])->where('device_client', $device['client'])->where('device_code', $device['code'])->where('user_type', 'user')->update(array('user_id' => $_SESSION['user_id']));
					}
				}
			}
			
			return $out;
		}
	}


    /**
     * 用户注册，登录函数
     *
     * @access public
     * @param string $username
     *            注册用户名
     * @param string $password
     *            用户密码
     * @param string $email
     *            注册email
     * @param array $other
     *            注册的其他信息
     *
     * @return bool $bool
     */
    private function register($username, $password = null, $email, $other = array(), $api_version = '')
    {
        $db_user = RC_Loader::load_app_model('users_model', 'user');

        /* 检查注册是否关闭 */
        $shop_reg_closed = ecjia::config('shop_reg_closed');
        if ($shop_reg_closed == '1') {
            return new ecjia_error('shop_reg_closed', '会员注册关闭');
        }

        if (version_compare($api_version, '1.17', '>=')) {
            /* 检查username */
            if (empty($username)) {
                return new ecjia_error('username_not_empty', '用户名不能为空！');
            } else {
                if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
                    return new ecjia_error('username_error', '用户名有敏感字符');
                }
            }
        } else {
            /* 检查username */
            if (empty($username)) {
                return new ecjia_error('username_not_empty', '用户名不能为空！');
            } else {
                if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
                    return new ecjia_error('username_error', '用户名有敏感字符');
                }
            }
        }

//     if ($this->admin_registered($username)) {
//     	return new ecjia_error('user_exists', RC_Lang::get('user::users.username_exists'));
//     }

        RC_Loader::load_app_class('integrate', 'user', false);
        $user = integrate::init_users();
        if (!$user->add_user($username, $password, $email)) {
            if (is_ecjia_error($user->error)) {
                return $user->error;
            }

            // 注册失败
            return new ecjia_error('signup_error', '注册失败！');
        } else {
            // 注册成功
            /* 设置成登录状态 */
            $user->set_session($username);
            $user->set_cookie($username);
            /* 注册送积分 */
            if (ecjia_config::has('register_points')) {
                $options = array(
                    'user_id'		=> $_SESSION['user_id'],
                    'rank_points'	=> ecjia::config('register_points'),
                    'pay_points'	=> ecjia::config('register_points'),
                    'change_desc'	=> RC_Lang::get('user::user.register_points')
                );
                $result = RC_Api::api('user', 'account_change_log',$options);
            }



            // 定义other合法的变量数组
            $other_key_array = array(
                'msn',
                'qq',
                'office_phone',
                'home_phone',
                'mobile_phone'
            );
            $update_data['reg_time'] = RC_Time::gmtime();
            if ($other) {
                foreach ($other as $key => $val) {
                    // 删除非法key值
                    if (!in_array($key, $other_key_array)) {
                        unset($other[$key]);
                    } else {
                        $other[$key] = htmlspecialchars(trim($val)); // 防止用户输入javascript代码
                    }
                }
                $update_data = array_merge($update_data, $other);
            }

            $db_user->where(array('user_id' => $_SESSION['user_id']))->update($update_data);

            RC_Loader::load_app_func('admin_user', 'user');
            update_user_info(); // 更新用户信息
            RC_Loader::load_app_func('cart','cart');
            recalculate_price(); // 重新计算购物车中的商品价格

            return true;
        }
    }


    /**
     * 判断超级管理员用户名是否存在
     *
     * @param string $adminname
     *            超级管理员用户名
     * @return boolean
     */
    private function admin_registered ($adminname) {
        //$db = RC_Loader::load_model('admin_user_model');
        //$res = $db->where(array('user_name' => $adminname))->count();
    	$res = RC_DB::table('admin_user')->where('user_name', $adminname)->count();
        return $res;
    }
}



// end