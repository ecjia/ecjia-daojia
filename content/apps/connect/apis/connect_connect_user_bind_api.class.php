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
 * openid是否存在及是否关联用户
 * TODO 目前只适合wechat插件使用
 * @author zrl
 */
class connect_connect_user_bind_api extends Component_Event_Api
{

    /**
     * 参数说明
     * @param string $connect_code 插件代号
     * @param string $connect_platform 平台
     * @param string $open_id 第三方帐号绑定唯一值
     * @param string $union_id 第三方帐号绑定唯一值
     * @param string $profile 个人信息
     * @param string $user_type 用户类型，选填，默认user，user:普通用户，merchant:商家，admin:管理员
     * @see Component_Event_Api::call()
     */
    public function call(&$options)
    {
        if (!array_get($options, 'connect_code') || !array_get($options, 'open_id') || !array_get($options, 'profile')) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'connect'), __CLASS__));
        }

        $expires_in       = array_get($options, 'expires_in', 7200);
        $profile          = $options['profile'];
        $connect_code     = $options['connect_code'];
        $connect_platform = $options['connect_platform'];
        $open_id          = $options['open_id'];
        $union_id         = $options['union_id'];
        $mobile           = $options['mobile'];
        $user_id		  = $options['user_id'];
        
        if(empty($connect_platform)) {
            $connect_handle = with(new \Ecjia\App\Connect\ConnectPlugin)->channel($connect_code);
            $connect_platform = $connect_handle->loadConfig('connect_platform');
        }

        $connect_user = new \Ecjia\App\Connect\ConnectUser\ConnectUser($connect_code, $open_id);
        $connect_user->setConnectPlatform($connect_platform);
        $connect_user->setUnionId($union_id);

        //通过union_id,open_id同步已绑定的用户信息
        if($union_id) {
            $bind_result = $connect_user->bindUserByUnionId();
        } else {
            $bind_result =  $connect_user->bindUserByOpenId();
        }
        
        //判断是否绑定用户
        if ($connect_user->checkUser()) {
            $user_id = $connect_user->getUserId();
            //更新connect_user表profile
            if (!empty($profile) && !empty($bind_result->id)) {
            	RC_DB::table('connect_user')->where('id', $bind_result->id)->update(['profile' => serialize($profile)]);
            }
            //获取远程头像，更新用户头像
            if (!empty($profile['headimgurl']) && !empty($user_id)) {
                $update_avatar_img = RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['headimgurl'], 'user_id' => $user_id));
                if (is_ecjia_error($update_avatar_img)) {
                    return $update_avatar_img;
                }
            }
            return $connect_user;
        } else {
            //判断openid是否存在
            $user_model = $connect_user->checkOpenId();
            if ($user_model) {
                $connect_user->saveConnectProfile($user_model, null, null, serialize($profile), $expires_in);
            } else {
                $user_model = $connect_user->createUser(0);
                $connect_user->saveConnectProfile($user_model, null, null, serialize($profile), $expires_in);
            }
        }

        $connect_user->refreshConnectUser();

        /**
         * @debug royalwang
         */
//        ecjia_log_debug('connect_user', (array)$connect_user);

        if (! empty($mobile) || !empty($user_id)) {

        	if (! empty($mobile)) {
        		$userinfo = RC_Api::api('user', 'get_local_user', array('mobile' => $mobile));
        	} elseif (!empty($user_id)) {
        		$userinfo = RC_Api::api('user', 'get_local_user', array('user_id' => $user_id));
        	}
            
            if (is_ecjia_error($userinfo)) {

                /*创建用户*/
                $username = with(new \Ecjia\App\Connect\UserGenerate($connect_user))->getGenerateUserName();
                $email    = with(new \Ecjia\App\Connect\UserGenerate($connect_user))->getGenerateEmail();

                $userinfo = RC_Api::api('user', 'add_user', array('username' => $username, 'email' => $email, 'mobile' => $mobile));

                if (is_ecjia_error($userinfo)) {
                    return $userinfo;
                }

            }

        }

        if (empty($userinfo)) {
            return new ecjia_error('connect_no_userbind', __('请关联或注册一个会员用户！', 'connect'));
        }

        //获取远程头像，更新用户头像
        if (!empty($profile['headimgurl']) && !empty($userinfo['user_id'])) {
            $update_avatar_img = RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['headimgurl'], 'user_id' => $userinfo['user_id']));
            if (is_ecjia_error($update_avatar_img)) {
                return $update_avatar_img;
            }
        }

        /**
         * @debug royalwang
         */
//        ecjia_log_debug('connect_connect_user_bind_api获取会员信息', $userinfo);

        /*绑定*/
        $result = $connect_user->bindUser($userinfo['user_id']);
        if ($result) {
            return $connect_user;
        } else {
            return new ecjia_error('bind_user_error', __('绑定用户失败', 'connect'));
        }
    }
}

// end