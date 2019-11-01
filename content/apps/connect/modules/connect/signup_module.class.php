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

class connect_signup_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
		$open_id      = $this->requestData('openid');
		$connect_code = $this->requestData('code');
		$username	  = $this->requestData('username');
		$mobile		  = $this->requestData('mobile');
		$password	  = $this->requestData('password', '');
		$device       = $this->device;
		$invite_code  = $this->requestData('invite_code');
		$code		  = $this->requestData('validate_code');
		$profile	  = $this->requestData('profile');
		$api_version   = $this->request->header('api-version');

		/*兼容1.17之前版本*/
		if (version_compare($api_version, '1.17', '<')) {
		    return $this->versionLessThan_0117();
		}

        if (empty($open_id) || empty($connect_code) || (empty($username) && empty($mobile))) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'connect'), __CLASS__));
        }
		
		$connect_user = new \Ecjia\App\Connect\ConnectUser\ConnectUser($connect_code, $open_id);
		if ($connect_user->checkUser()) {
			return new ecjia_error('connect_userbind', __('您已绑定过会员用户！', 'connect'));
		}
		
		//判断校验码是否过期
		if (!empty($mobile) && (!isset($_SESSION['bindcode_lifetime']) || $_SESSION['bindcode_lifetime'] + 180 < RC_Time::gmtime())) {
			//过期
			return new ecjia_error('code_timeout', __('验证码已过期，请重新获取！', 'connect'));
		}
		//判断校验码是否正确
		if (!empty($mobile) && (!isset($_SESSION['bindcode_lifetime']) || $code != $_SESSION['bind_code'] )) {
			return new ecjia_error('code_error', __('验证码错误，请重新填写！', 'connect'));
		}

		/**
		 * $code
		 * login_weibo
		 * sns_qq
		 * sns_wechat
		 * login_mobile
		 * login_mail
		 * login_username
		 * login_alipay
		 * login_taobao
		 **/
		/* 如有手机号判断手机号是否被绑定过*/
		if (!empty($mobile)) {
			$mobile_count = RC_Model::model('user/users_model')->where(array('mobile_phone' => $mobile))->count();
			if ($mobile_count > 0 ) {
				return new ecjia_error('mobile_exists', __('您的手机号已使用', 'connect'));
			}
		}
		
        if (!empty($username) && empty($mobile)) {
            /* 判断是否为手机号*/
            $check_mobile = Ecjia\App\Sms\Helper::check_mobile($username);
            if($check_mobile === true) {
                /* 生成用户名*/
                $mobile = $username;
                $username = substr_replace($username,'****',3,4);
                if (ecjia_integrate::checkUser($username)) {
                    $username = $username . rand(0, 9);
                }
            }
        } elseif (!empty($mobile) && empty($username)) {
            /* 判断是否为手机号*/
            $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile);
            if($check_mobile === true) {
                /* 生成用户名*/
                $username = substr_replace($mobile,'****',3,4);
                if (ecjia_integrate::checkUser($username)) {
                    $username = $username . rand(0, 9);
                }
            }
        }

		
		//新用户注册并登录
		$email = rc_random(8, 'abcdefghijklmnopqrstuvwxyz0123456789').'@'.$connect_code.'.com';

		$result = ecjia_integrate::addUser($username, $password, $email, $mobile);

		if ($result) {
            ecjia_integrate::setSession($username);
            ecjia_integrate::setCookie($username);

            $connect_user->bindUser($_SESSION['user_id']);

            $user_info = \Ecjia\App\User\UserInfoFunction::EM_user_info($_SESSION['user_id']);
            //会员登录后，相关信息处理
            (new \Ecjia\App\User\UserManager())->apiLoginSuccessHook([
                'user_id'   => $user_info['id'],
                'user_name' => $user_info['name'],
            ]);

			/* 注册送积分 */
			if (ecjia_config::has('register_points')) {
				$options = array(
					'user_id'		=> $_SESSION['user_id'],
					'rank_points'	=> ecjia::config('register_points'),
					'pay_points'	=> ecjia::config('register_points'),
					'change_desc'	=> __('注册送积分', 'connect')
				);
				$result = RC_Api::api('user', 'account_change_log', $options);
			}

			if (!empty($mobile)) {
				RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->update(array('mobile_phone' => $mobile));
			}
			RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->update(array('reg_time' => RC_Time::gmtime()));
			
			if (!empty($profile['avatar_img'])) {
				/* 获取远程用户头像信息*/
				RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['avatar_img']));
			}
			
// 			/*注册送红包*/
// 			RC_Api::api('bonus', 'send_bonus', array('type' => SEND_BY_REGISTER));

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
					->value('meta_value');
				}
			}
			$result = ecjia_app::validate_application('affiliate');
			if (!is_ecjia_error($result) && !empty($invite_code)) {
				RC_Api::api('affiliate', 'invite_bind', array('invite_code' => $invite_code, 'mobile' => $mobile));
			}
			
            unset($_SESSION['bind_code']);
			unset($_SESSION['bindcode_lifetime']);
			unset($_SESSION['bind_value']);
			unset($_SESSION['bind_type']);

			$out = array(
				'token' => RC_Session::session_id(),
				'user'	=> $user_info
			);

			return $out;
		} else {
            return new ecjia_error(ecjia_integrate::getError(), ecjia_integrate::getErrorMessage());
		}
	}

    /**
     * API版本小于1.17的时候
     */
    protected function versionLessThan_0117() {
        $this->authSession();
        $open_id      = $this->requestData('openid');
        $connect_code = $this->requestData('code');
        $username	  = $this->requestData('username');
        $mobile		  = $this->requestData('mobile');
        $password	  = $this->requestData('password', '');
        $device       = $this->device;
        $invite_code  = $this->requestData('invite_code');
        $code		  = $this->requestData('validate_code');
        $profile	  = $this->requestData('profile');
        $api_version   = $this->request->header('api-version');

        /*兼容1.17版本*/
        if (empty($open_id) || empty($password) || empty($connect_code)) {
            return new ecjia_error('invalid_parameter', __('参数错误', 'connect'));
        }


        $connect_user = new \Ecjia\App\Connect\ConnectUser\ConnectUser($connect_code, $open_id);
        $connect_handle = with(new \Ecjia\App\Connect\ConnectPlugin)->channel($connect_code);
        $connect_platform = $connect_handle->loadConfig('connect_platform');
        $connect_user->setConnectPlatform($connect_platform);
        if ($connect_user->checkUser()) {
            return new ecjia_error('connect_userbind', __('您已绑定过会员用户！', 'connect'));
        }

        //判断校验码是否过期
        if (!empty($mobile) && (!isset($_SESSION['bindcode_lifetime']) || $_SESSION['bindcode_lifetime'] + 180 < RC_Time::gmtime())) {
            //过期
            return new ecjia_error('code_timeout', __('验证码已过期，请重新获取！', 'connect'));
        }
        //判断校验码是否正确
        if (!empty($mobile) && (!isset($_SESSION['bindcode_lifetime']) || $code != $_SESSION['bind_code'] )) {
            return new ecjia_error('code_error', __('验证码错误，请重新填写！', 'connect'));
        }

        /**
         * $code
         * login_weibo
         * sns_qq
         * sns_wechat
         * login_mobile
         * login_mail
         * login_username
         * login_alipay
         * login_taobao
         **/
        /* 如有手机号判断手机号是否被绑定过*/
        if (!empty($mobile)) {
            $mobile_count = RC_Model::model('user/users_model')->where(array('mobile_phone' => $mobile))->count();
            if ($mobile_count > 0 ) {
                return new ecjia_error('mobile_exists', __('您的手机号已使用', 'connect'));
            }
        }

        /*兼容1.17*/
        if (ecjia_integrate::checkUser($username)) {
            $username = $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
        }

        //新用户注册并登录
        $email = rc_random(8, 'abcdefghijklmnopqrstuvwxyz0123456789').'@'.$connect_code.'.com';

        $result = ecjia_integrate::addUser($username, $password, $email, $mobile);

        if ($result) {

            ecjia_integrate::setSession($username);
            ecjia_integrate::setCookie($username);

            /* 注册送积分 */
            if (ecjia_config::has('register_points')) {
                $options = array(
                    'user_id'		=> $_SESSION['user_id'],
                    'rank_points'	=> ecjia::config('register_points'),
                    'pay_points'	=> ecjia::config('register_points'),
                    'change_desc'	=> __('注册送积分', 'connect')
                );
                $result = RC_Api::api('user', 'account_change_log',$options);
            }

            if (!empty($mobile)) {
                RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->update(array('mobile_phone' => $mobile));
            }
            RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->update(array('reg_time' => RC_Time::gmtime()));

            $curr_time = RC_Time::gmtime();
            $data = array(
                'connect_code'	=> $connect_user->getConnectCode(),
                'connect_platform' => $connect_user->getConnectPlatform(),
                'open_id'		=> $connect_user->getOpenId(),
                'create_at'     => $curr_time,
                'user_id'		=> $_SESSION['user_id'],
            );
            if (!empty($profile)) {
                $data['profile'] = serialize($profile);
            }
            RC_DB::table('connect_user')->insert($data);
            if (!empty($profile['avatar_img'])) {
                /* 获取远程用户头像信息*/
                RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['avatar_img']));
            }

// 			/*注册送红包*/
// 			RC_Api::api('bonus', 'send_bonus', array('type' => SEND_BY_REGISTER));

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
                        ->value('meta_value');
                }
            }
            $result = ecjia_app::validate_application('affiliate');
            if (!is_ecjia_error($result) && !empty($invite_code)) {
                RC_Api::api('affiliate', 'invite_bind', array('invite_code' => $invite_code, 'mobile' => $mobile));
            }

            //ecjia账号同步登录用户信息更新
            $connect_options = [
                'connect_code'  => 'app',
                'user_id'       => $_SESSION['user_id'],
                'is_admin'      => '0',
                'user_type'     => 'user',
                'open_id'       => md5(RC_Time::gmtime() . $_SESSION['user_id']),
                'access_token'  => RC_Session::session_id(),
                'refresh_token' => md5($_SESSION['user_id'] . 'user_refresh_token'),
            ];
            $ecjiaAppUser = RC_Api::api('connect', 'ecjia_syncappuser_add', $connect_options);
            if (is_ecjia_error($ecjiaAppUser)) {
                return $ecjiaAppUser;
            }

            $user_info = \Ecjia\App\User\UserInfoFunction::EM_user_info($_SESSION['user_id']);
            \Ecjia\App\User\UserInfoFunction::update_user_info(); // 更新用户信息
            \Ecjia\App\Cart\CartFunction::recalculate_price(); // 重新计算购物车中的商品价格

            unset($_SESSION['bind_code']);
            unset($_SESSION['bindcode_lifetime']);
            unset($_SESSION['bind_value']);
            unset($_SESSION['bind_type']);

            //修正关联设备号
            RC_Api::api('mobile', 'bind_device_user', array(
                'device_udid'   => $device['udid'],
                'device_client' => $device['client'],
                'device_code'   => $device['code'],
                'user_type'     => 'user',
                'user_id'       => $_SESSION['user_id'],
            ));

            $out = array(
                'token' => RC_Session::session_id(),
                'user'	=> $user_info
            );

            return $out;
        } else {
            return new ecjia_error(ecjia_integrate::getError(), ecjia_integrate::getErrorMessage());
        }
    }
	
}

// end