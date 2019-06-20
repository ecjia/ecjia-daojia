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
 * Class connect_signin_module
 * @update 190312 v1.28 增加unionid
 */
class connect_signin_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $this->authSession();
        $open_id      = $this->requestData('openid');
        $union_id     = $this->requestData('unionid');//v1.28 190312新增
        $connect_code = $this->requestData('code');
        $device       = $this->device;
        $profile      = $this->requestData('profile');
        $api_version = $this->request->header('api-version');

        if (version_compare($api_version, '1.28', '<')) {
            return $this->versionLessThan_0128();
        }

        if (empty($open_id) || empty($connect_code) || empty($profile)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'connect'), __CLASS__));
        }

        /**
         * $code
         * sns_qq
         * sns_wechat sns_wechat_app sns_wechat_bbc sns_wechat_shop
         * login_mobile
         * login_mail
         * login_username
         * login_alipay
         * login_taobao
         */
        //绑定会员
        $connect_user = RC_Api::api('connect', 'connect_user_bind', [
            'connect_code'     => $connect_code,
            'open_id'          => $open_id,
            'union_id'         => $union_id,
            'profile'          => $profile,
        ]);

        if($connect_code == 'sns_wechat_app') {
            //sns_wechat包含到家app和到家h5 兼容处理
            $connect_handle = with(new \Ecjia\App\Connect\ConnectPlugin)->channel($connect_code);
            $connect_user = $connect_handle->sync_before_data([
                'connect_code'     => $connect_code,
                'open_id'          => $open_id,
                'union_id'         => $union_id,
            ]);
        }

        if(is_ecjia_error($connect_user)) {
            return $connect_user;
        }

        //判断已绑定授权登录用户 直接登录
        if ($connect_user->checkUser()) {
            $connect_user_id = $connect_user->getUserId();
            $user_info = \Ecjia\App\User\UserInfoFunction::EM_user_info($connect_user_id);
            if(is_ecjia_error($user_info)) {
                return $user_info;
            }

            if(empty($user_info)) {
                return new ecjia_error('empty_user_info', __('用户信息异常', 'connect'));
            }

            //会员登录后，相关信息处理
            (new \Ecjia\App\User\UserManager())->apiLoginSuccessHook([
                'user_id'   => $user_info['id'],
                'user_name' => $user_info['name'],
            ]);

            $out = array(
                'token' => RC_Session::getId(),
                'user'  => $user_info
            );
            return $out;

        } else {
            return new ecjia_error('connect_no_userbind', __('请关联或注册一个会员用户！', 'connect'));
        }

    }

    /**
     * API版本小于1.28的时候
     */
    protected function versionLessThan_0128() {
        $this->authSession();
        $open_id      = $this->requestData('openid');
        $union_id     = $this->requestData('unionid');//v1.28 190312新增
        $connect_code = $this->requestData('code');
        $device       = $this->device;
        $profile      = $this->requestData('profile');

        if (empty($open_id) || empty($connect_code)) {
            return new ecjia_error('invalid_parameter', __('参数错误', 'connect'));
        }

        /**
         * $code
         * sns_qq
         * sns_wechat sns_wechat_app sns_wechat_bbc sns_wechat_shop
         * login_mobile
         * login_mail
         * login_username
         * login_alipay
         * login_taobao
         */
        $connect_user = new Ecjia\App\Connect\ConnectUser\ConnectUser($connect_code, $open_id);
        $connect_user->setUnionId($union_id);

        //通过union_id,open_id同步已绑定的用户信息
        if($union_id) {
            $connect_user->bindUserByUnionId();
        } else {
            $connect_user->bindUserByOpenId();
        }

        if(is_ecjia_error($connect_user)) {
            return $connect_user;
        }

        //判断已绑定授权登录用户 直接登录
        if ($connect_user->checkUser()) {
            $connect_user_id = $connect_user->getUserId();
            $user_info = \Ecjia\App\User\UserInfoFunction::EM_user_info($connect_user_id);
            if(is_ecjia_error($user_info)) {
                return $user_info;
            }

            ecjia_integrate::setSession($user_info['name']);
            ecjia_integrate::setCookie($user_info['name']);

            //当接口传入profile参数时才执行
            if (!empty($profile)) {
                $data = array(
                    'profile' => serialize($profile)
                );
                RC_DB::table('connect_user')
                    ->where('connect_code', $connect_user->getConnectCode())
                    ->where('user_type', 'user')
                    ->where('open_id', $connect_user->getOpenId())
                    ->where('user_id', $_SESSION['user_id'])
                    ->update($data);

                //获取远程头像，更新用户头像
                RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['avatar_img']));
            }

        } else {
            return new ecjia_error('connect_no_userbind', __('请关联或注册一个会员用户！', 'connect'));
        }

        //ecjia账号同步登录用户信息更新
        $connect_options = [
            'connect_code'  => 'app',
            'user_id'       => $_SESSION['user_id'],
            'user_type'     => 'user',
            'open_id'       => md5(RC_Time::gmtime() . $_SESSION['user_id']),
            'access_token'  => RC_Session::session_id(),
            'refresh_token' => md5($_SESSION['user_id'] . 'user_refresh_token'),
        ];
        $ecjiaAppUser = RC_Api::api('connect', 'ecjia_syncappuser_add', $connect_options);
        if (is_ecjia_error($ecjiaAppUser)) {
            return $ecjiaAppUser;
        }

        \Ecjia\App\User\UserInfoFunction::update_user_info(); // 更新用户信息
        \Ecjia\App\Cart\CartFunction::recalculate_price(); // 重新计算购物车中的商品价格

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
            'user'  => $user_info
        );
        return $out;
    }
}

// end