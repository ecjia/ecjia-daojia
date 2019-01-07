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
class user_profile_controller
{

    /**
     * 会员中心：编辑个人资料
     */
    public static function init()
    {
        $token = ecjia_touch_user::singleton()->getToken();
        $user  = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();

        $user_img_login  = RC_Theme::get_template_directory_uri() . '/images/user_center/icon-login-in2x.png';
        $user_img_logout = RC_Theme::get_template_directory_uri() . '/images/user_center/icon-login-out2x.png';

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

        $is_weixin = false;
        if (user_function::is_weixin()) {
            $is_weixin = true;
        }
        ecjia_front::$controller->assign('is_weixin', $is_weixin);

        $list = user_function::get_userInfo_bankcard();

        $available_withdraw_way = !empty($list['available_withdraw_way']) ? $list['available_withdraw_way'] : [];
        ecjia_front::$controller->assign('available_withdraw_way', $available_withdraw_way);

        ecjia_front::$controller->display('user_profile.dwt');
    }

    /* 用户中心编辑用户名称 */
    public static function modify_username()
    {
        $token     = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo(); //id,name

        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'] . '-' . $token . '-' . $user_info['id'] . '-' . $user_info['name']));

        if (!ecjia_front::$controller->is_cached('user_modify_username.dwt', $cache_id)) {
            $user       = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
            $user       = is_ecjia_error($user) ? array() : $user;
            $time       = RC_Time::gmtime();
            $last_time  = $user['update_username_time'];
            $limit_time = RC_Time::local_strtotime($last_time) + 2592000;
            if ($limit_time > $time) {
                ecjia_front::$controller->assign('limit_time', $limit_time);
            }

            $update_username_time = substr($user['update_username_time'], 0, 10);
            ecjia_front::$controller->assign('update_username_time', $update_username_time);
            ecjia_front::$controller->assign('user', $user);
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->assign_title('修改用户名');
        }

        ecjia_front::$controller->display('user_modify_username.dwt', $cache_id);
    }

    /* 处理用户中心编辑用户名称 */
    public static function modify_username_account()
    {
        $name  = !empty($_POST['username']) ? $_POST['username'] : '';
        $token = ecjia_touch_user::singleton()->getToken();

        if (strlen($name) > 20 || strlen($name) < 4 || !preg_match('/^[A-Za-z0-9_\-\x{4e00}-\x{9fa5}]+$/u', $name)) {
            return ecjia_front::$controller->showmessage('修改失败，请输入正确的用户名格式', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (!empty($name)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_UPDATE)->data(array('token' => $token, 'user_name' => $name))->run();
            if (!is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage('修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/profile/init')));
            } else {
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
    }

    /**
     * 修改密码页面
     */
    public static function edit_password()
    {
        //ajax请求
        $type  = !empty($_GET['type']) ? trim($_GET['type']) : '';
        $token = ecjia_touch_user::singleton()->getToken();

        if ($type == 'ajax') {
            $old_password     = !empty($_POST['old_password']) ? trim($_POST['old_password']) : '';
            $new_password     = !empty($_POST['new_password']) ? trim($_POST['new_password']) : '';
            $confirm_password = !empty($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

            if (empty($old_password)) {
                return ecjia_front::$controller->showmessage(__('请输入旧密码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (empty($new_password)) {
                return ecjia_front::$controller->showmessage(__('请输入新密码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (empty($confirm_password)) {
                return ecjia_front::$controller->showmessage(__('请输入确认新密码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (!empty($old_password)) {
                if ($new_password == $confirm_password) {
                    if ($old_password == $new_password) {
                        return ecjia_front::$controller->showmessage(__('新密码不能旧密码相同'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                    $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_PASSWORD)->data(array('token' => $token, 'password' => $old_password, 'new_password' => $new_password))->run();
                    if (!is_ecjia_error($data)) {
                        return ecjia_front::$controller->showmessage(__('修改密码成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('touch/my/init')));
                    } else {
                        return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                } else {
                    return ecjia_front::$controller->showmessage(__('两次输入的密码不同，请重新输入'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        $user_info = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        $user_info = !is_ecjia_error($user_info) ? $user_info : array();
        if (empty($user_info['mobile_phone'])) {
            return ecjia_front::$controller->showmessage('请先绑定手机号码', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }
        ecjia_front::$controller->assign('mobile', $user_info['mobile_phone']);
        ecjia_front::$controller->assign_title('修改密码');
        ecjia_front::$controller->assign('title', '修改密码');
        ecjia_front::$controller->assign_lang();

        ecjia_front::$controller->display('user_modify_password.dwt');
    }

    //提现账户
    public static function withdraw()
    {
        $list = user_function::get_userInfo_bankcard();

        ecjia_front::$controller->assign('list', $list);

        $user_binded_list = !empty($list['user_binded_list']) ? $list['user_binded_list'] : [];

        $bind_list = [];
        $type_list = [];
        if (!empty($user_binded_list)) {
            foreach ($user_binded_list as $k => $v) {
                $bind_list[$v['bank_type']] = $v;
                $type_list[]                = $v['bank_type'];
            }
        }

        $available_withdraw_way = !empty($list['available_withdraw_way']) ? $list['available_withdraw_way'] : [];

        if (!empty($available_withdraw_way)) {
            foreach ($available_withdraw_way as $k => $v) {
                if (in_array($v['bank_type'], $type_list)) {
                    $available_withdraw_way[$k]['bind_info'] = $bind_list[$v['bank_type']];
                }
            }
        }

        ecjia_front::$controller->assign('available_withdraw_way', $available_withdraw_way);

        ecjia_front::$controller->assign_title('提现账户');

        ecjia_front::$controller->display('user_withdraw.dwt');
    }

    /**
     * 绑定信息页面
     */
    public static function account_bind()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        $user = is_ecjia_error($user) ? [] : $user;

        ecjia_front::$controller->assign('user', $user);

        $type   = !empty($_GET['type']) ? trim($_GET['type']) : '';
        $status = !empty($_GET['status']) ? trim($_GET['status']) : '';

        $form_url = RC_Uri::url('user/profile/check_code');

        if ($type == 'mobile') {
            $title = '绑定手机';
        } else if ($type == 'email') {
            $title = '绑定邮箱';
        } else if ($type == 'bank' || $type == 'wechat') {

            if ($type == 'bank') {
                $title = '绑定银行卡';
            } elseif ($type == 'wechat') {
                $title = '绑定微信钱包提现';
            }
            $form_url = RC_Uri::url('user/profile/bind_withdraw');

            //获取用户已绑定的提现方式及网站支持的提现方式
            $list = user_function::get_userInfo_bankcard();

            $user_binded_list = !empty($list['user_binded_list']) ? $list['user_binded_list'] : [];

            $bind_info = [];
            if (!empty($user_binded_list)) {
                foreach ($user_binded_list as $k => $v) {
                    if ($type == $v['bank_type']) {
                        $bind_info = $v;
                    }
                }
            }
            ecjia_front::$controller->assign('bind_info', $bind_info);

            //用户提现所支持的银行
            $bank_list = ecjia_touch_manager::make()->api(ecjia_touch_api::WITHDRAW_BANKS)->run();
            $bank_list = is_ecjia_error($bank_list) ? [] : $bank_list;

            ecjia_front::$controller->assign('bank_list', json_encode($bank_list));
        }
        ecjia_front::$controller->assign('type', $type);

        ecjia_front::$controller->assign_title($title);
        ecjia_front::$controller->assign('form_url', $form_url);

        if (!empty($status)) {
            ecjia_front::$controller->assign('status', $status);
        }
        ecjia_front::$controller->display('user_account_bind.dwt');
    }

    /**
     * 获取绑定验证码
     */
    public static function get_code()
    {
        $mobile = !empty($_GET['mobile']) ? trim($_GET['mobile']) : '';
        $email  = !empty($_GET['email']) ? $_GET['email'] : '';
        $token  = ecjia_touch_user::singleton()->getToken();

        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        if (is_ecjia_error($user)) {
            return ecjia_front::$controller->showmessage($user->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //获取设置支付密码验证码
        $type = trim($_GET['type']);
        if (!empty($mobile) && !empty($type)) {
            if ($type == 'set_paypass') {
                $type = 'user_modify_paypassword';
            } elseif ($type == 'bank') {
                $type = 'user_bind_bank';
            } elseif ($type == 'wechat') {
                $type = 'user_bind_wewallet';
            }
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CAPTCHA_SMS)->data(array('token' => $token, 'type' => $type, 'mobile' => $mobile))->run();
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }
        }

        if (!empty($mobile)) {
            if ($user['mobile_phone'] == $mobile) {
                return ecjia_front::$controller->showmessage('该手机号与当前绑定的手机号相同', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CAPTCHA_SMS)->data(array('token' => $token, 'type' => 'user_modify_mobile', 'mobile' => $mobile))->run();
        } else if (!empty($email)) {
            if ($user['email'] == $email) {
                return ecjia_front::$controller->showmessage('该邮箱地址与当前绑定的邮箱地址相同', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CAPTCHA_MAIL)->data(array('token' => $token, 'type' => 'user_modify_mail', 'mail' => $email))->run();
        } else {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    /**
     * 获取修改密码验证码
     */
    public static function get_sms_code()
    {
        $mobile = !empty($_GET['mobile']) ? trim($_GET['mobile']) : '';
        $token  = ecjia_touch_user::singleton()->getToken();

        if (empty($mobile)) {
            return ecjia_front::$controller->showmessage('手机号码不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CAPTCHA_SMS)->data(array('token' => $token, 'type' => 'user_modify_password', 'mobile' => $mobile))->run();
        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    /**
     * 修改密码
     */
    public static function modify_password()
    {
        $mobile   = trim($_POST['mobile']);
        $code     = trim($_POST['code']);
        $password = trim($_POST['password']);
        $token    = ecjia_touch_user::singleton()->getToken();

        if (empty($mobile)) {
            return ecjia_front::$controller->showmessage('手机号码不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($code)) {
            return ecjia_front::$controller->showmessage('请输入验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($password)) {
            return ecjia_front::$controller->showmessage('请设置密码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (strlen($password) < 6) {
            return ecjia_front::$controller->showmessage('登录密码不能少于 6 个字符', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_PASSWORD)->data(array('token' => $token, 'type' => 'use_sms', 'mobile' => $mobile, 'password' => $code, 'new_password' => $password))->run();
        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            ecjia_touch_user::singleton()->signout();
            RC_Cookie::delete(RC_Config::get('session.session_name'));
            return ecjia_front::$controller->showmessage('修改成功，请重新登录', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/privilege/pass_login')));
        }
    }

    /**
     * 验证验证码并绑定
     */
    public static function check_code()
    {
        $value = !empty($_POST['mobile']) ? trim($_POST['mobile']) : trim($_POST['email']);
        $code  = !empty($_POST['code']) ? trim($_POST['code']) : '';
        $type  = !empty($_POST['type']) ? $_POST['type'] : '';
        $token = ecjia_touch_user::singleton()->getToken();

        if (!empty($code) && ($type == 'set_paypass' || $type == 'bank')) {
            //验证设置支付密码验证码
            if ($type == 'set_paypass') {
                $key     = 'set_paypass_temp';
                $pjaxurl = RC_Uri::url('user/profile/set_pay_pass');
                $type    = 'user_modify_paypassword';

            } elseif ($type == 'bank') {
                $key     = 'set_bank_card_temp';
                $pjaxurl = RC_Uri::url('user/profile/account_bind', array('type' => 'bank'));
                $type    = 'user_bind_bank';
            }

            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CAPTCHA_SMS_CHECKCODE)->data(array('smscode' => $code, 'token' => $token, 'type' => $type))->run();
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $user_info = ecjia_touch_user::singleton()->getUserinfo();

                $_SESSION[$key][$user_info['id']]['smscode'] = $code;
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
            }
        }

        if (!empty($code) && !empty($type)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_BIND)->data(array('type' => $type, 'value' => $value, 'code' => $code, 'token' => $token))->run();
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/profile/init')));
            }
        }
    }

    /**
     * 查看绑定手机号和邮箱
     */
    public static function bind_info()
    {
        $token    = ecjia_touch_user::singleton()->getToken();
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'] . '-' . $token));

        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        $user = !is_ecjia_error($user) ? $user : array();

        ecjia_front::$controller->assign('user', $user);

        $type = !empty($_GET['type']) ? trim($_GET['type']) : '';
        ecjia_front::$controller->assign('type', $type);

        $form_url = '';
        if ($type == 'mobile') {
            $title = '更换手机号';
        } else if ($type == 'email') {
            $title = '更换邮箱';
        } else if ($type == 'wechat') {
            $title = '绑定微信';
            if ($user['wechat_is_bind'] == 1) {
                $title = '解除绑定';
            }
            $form_url = RC_Uri::url('user/profile/unbind_wechat');
        } else if ($type == 'bank') {
            $title = '编辑银行卡';
        }

        ecjia_front::$controller->assign_title($title);
        ecjia_front::$controller->assign('form_url', $form_url);

        ecjia_front::$controller->display('user_bind_info.dwt');
    }

    //解绑验证手机号
    public static function unbind_check_mobile()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        $user = is_ecjia_error($user) ? [] : $user;

        ecjia_front::$controller->assign('user', $user);

        $id          = intval($_GET['id']);
        $type        = trim($_GET['type']);
        $unbind_type = 'user_delete_bankcard';

        ecjia_front::$controller->assign('id', $id);
        ecjia_front::$controller->assign('type', $type);
        ecjia_front::$controller->assign('unbind_type', $unbind_type);
        ecjia_front::$controller->assign_title('验证手机号');

        ecjia_front::$controller->assign('form_url', RC_Uri::url('user/profile/unbind_withdraw'));

        ecjia_front::$controller->display('user_unbind_check_mobile.dwt');
    }

    //删除提现方式
    public static function unbind_withdraw()
    {
        $token   = ecjia_touch_user::singleton()->getToken();
        $type    = trim($_POST['type']);
        $smscode = trim($_POST['smscode']);

        if ($type == 'wechat' || $type == 'bank') {
            $id = intval($_POST['id']);

            if (empty($id)) {
                return ecjia_front::$controller->showmessage('该提现方式不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (empty($smscode)) {
                return ecjia_front::$controller->showmessage('请输入手机验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $param  = array('token' => $token, 'id' => $id, 'smscode' => $smscode);
            $result = ecjia_touch_manager::make()->api(ecjia_touch_api::WITHDRAW_BANKCARD_DELETE)->data($param)->run();
            if (is_ecjia_error($result)) {
                return ecjia_front::$controller->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            return ecjia_front::$controller->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/profile/account_bind', array('type' => $type))));
        }
    }

    //解绑微信
    public static function unbind_wechat()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $smscode = trim($_POST['smscode']);
        if (empty($smscode)) {
            return ecjia_front::$controller->showmessage('请输入验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $param  = array('token' => $token, 'connect_code' => 'sns_wechat', 'smscode' => $smscode);
        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CONNECT_UNBIND)->data($param)->run();
        if (is_ecjia_error($result)) {
            return ecjia_front::$controller->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        return ecjia_front::$controller->showmessage('解绑成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('touch/my/init')));
    }

    //绑定提现方式
    public static function bind_withdraw()
    {
        $token   = ecjia_touch_user::singleton()->getToken();
        $type    = trim($_POST['type']);
        $smscode = trim($_POST['smscode']);

        //绑定银行卡
        if ($type == 'bank') {
            $card_name     = trim($_POST['card_name']);
            $bank_en_short = trim($_POST['bank_en_short']);
            $bank_name     = trim($_POST['bank_name']);
            $bank_number   = trim($_POST['bank_number']);

            if (empty($card_name)) {
                return ecjia_front::$controller->showmessage('请输入持卡人姓名', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($bank_en_short)) {
                return ecjia_front::$controller->showmessage('请选择所属银行', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($bank_name)) {
                return ecjia_front::$controller->showmessage('请输入开户行', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($bank_number)) {
                return ecjia_front::$controller->showmessage('请输入银行卡号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($smscode)) {
                return ecjia_front::$controller->showmessage('请输入手机验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $param = array(
                'token'            => $token,
                'smscode'          => $smscode,
                'cardholder'       => $card_name,
                'bank_branch_name' => $bank_name,
                'bank_card'        => $bank_number,
                'bank_en_short'    => $bank_en_short
            );

            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::WITHDRAW_BANKCARD_BIND)->data($param)->run();
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            return ecjia_front::$controller->showmessage('绑定成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('user/profile/account_bind', array('type' => 'bank'))));
        }

        //绑定微信真实姓名
        if ($type == 'wechat') {
            $real_name = trim($_POST['real_name']);

            if (empty($real_name)) {
                return ecjia_front::$controller->showmessage('请输入微信认证的真实姓名', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (empty($smscode)) {
                return ecjia_front::$controller->showmessage('请输入手机验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $param = array(
                'token'     => $token,
                'real_name' => $real_name,
                'smscode'   => $smscode
            );

            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::WITHDRAW_WECHAT_WALLET_BIND)->data($param)->run();
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            return ecjia_front::$controller->showmessage('绑定成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('user/profile/account_bind', array('type' => 'wechat'))));
        }

    }

    //验证设置支付密码手机号 验证码
    public static function set_pay_password()
    {
        $token    = ecjia_touch_user::singleton()->getToken();
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'] . '-' . $token));

        if (!ecjia_front::$controller->is_cached('user_set_paypass_check.dwt', $cache_id)) {
            $user_info                     = ecjia_touch_user::singleton()->getUserinfo();
            $user_info['str_mobile_phone'] = substr_replace($user_info['mobile_phone'], '****', 3, 4);
            ecjia_front::$controller->assign('user', $user_info);
        }

        ecjia_front::$controller->assign_title('支付密码');
        ecjia_front::$controller->display('user_set_paypass_check.dwt', $cache_id);
    }

    //设置支付密码页面
    public static function set_pay_pass()
    {
        $token    = ecjia_touch_user::singleton()->getToken();
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'] . '-' . $token));

        if (!ecjia_front::$controller->is_cached('user_set_paypass.dwt', $cache_id)) {
            $user_info                     = ecjia_touch_user::singleton()->getUserinfo();
            $user_info['str_mobile_phone'] = substr_replace($user_info['mobile_phone'], '****', 3, 4);
            ecjia_front::$controller->assign('user', $user_info);
            ecjia_front::$controller->assign('url', RC_Uri::url('user/profile/check_pay_pass'));
        }
        $title = '请设置支付密码';
        $type  = trim($_GET['type']);
        if ($type == 'confirm') {
            $title = '再次确认支付密码';
        }
        ecjia_front::$controller->assign_title($title);
        ecjia_front::$controller->assign('type', $type);

        ecjia_front::$controller->display('user_set_paypass.dwt', $cache_id);
    }

    //检查输入的支付密码
    public static function check_pay_pass()
    {
        $user_info = ecjia_touch_user::singleton()->getUserinfo();

        $type     = trim($_POST['type']);
        $password = trim($_POST['password']);

        $token = ecjia_touch_user::singleton()->getToken();
        if (empty($type)) {
            $_SESSION['set_paypass_temp'][$user_info['id']]['password'] = $password;
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('user/profile/set_pay_pass', array('type' => 'confirm'))));
        } elseif ($type == 'confirm') {
            $password         = $_SESSION['set_paypass_temp'][$user_info['id']]['password'];
            $confirm_password = trim($_POST['confirm_password']);
            $smscode          = $_SESSION['set_paypass_temp'][$user_info['id']]['smscode'];

            //判断修改密码是否与原密码相同
            if ($password === $confirm_password) {
                $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_PAYPASSWORD_MODIFY)->data(array('token' => $token, 'paypassword' => $password, 'smscode' => $smscode))->run();
                if (is_ecjia_error($data)) {
                    return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                return ecjia_front::$controller->showmessage('设置成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('touch/my/init')));
            } else {
                return ecjia_front::$controller->showmessage('两次密码输入不一致，请重试', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('type' => 'alert'));
            }
        }
    }

    //注销账号
    public static function cancel_account()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $user_info = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        $user_info = is_ecjia_error($user_info) ? array() : $user_info;

        if (empty($user_info['avatar_img'])) {
            $user_info['avatar_img'] = RC_Theme::get_template_directory_uri() . '/images/user_center/icon-login-in2x.png';
        }
        $user_info['str_mobile_phone'] = substr_replace($user_info['mobile_phone'], '****', 3, 4);

        if (!empty($user_info['delete_time'])) {
            $user_info['delete_time'] = RC_Time::local_strtotime($user_info['delete_time']);
            $user_info['delete_time'] = RC_Time::local_date('Y/m/d H:i:s O', $user_info['delete_time'] + 30 * 24 * 3600);
        }

        ecjia_front::$controller->assign('user', $user_info);

        $article = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_SPECIAL_README_USERDELETE)->run();
        $article = !is_ecjia_error($article) ? $article : [];
        ecjia_front::$controller->assign('article', $article);

        $title = '注销账号';
        $dwt   = 'user_cancel_account.dwt';

        if ($user_info['account_status'] == 'wait_delete') {
            $title = '激活账号';
            $dwt   = 'user_cancel_account_notice.dwt';
        }

        ecjia_front::$controller->assign_title($title);
        ecjia_front::$controller->display($dwt);

    }

    //注销/激活账号 验证短信验证码
    public static function check_mobile()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $user_info = ecjia_touch_user::singleton()->getUserinfo();
        if (empty($user_info['mobile_phone'])) {
            return ecjia_front::$controller->showmessage('请先绑定手机号码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $mobile = $user_info['mobile_phone'];
        $type   = trim($_GET['type']);

        $type_list = array('user_delete_account', 'user_activate_account');
        $type      = in_array($type, $type_list) ? $type : 'user_delete_account';

        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CAPTCHA_SMS)->data(array('token' => $token, 'type' => $type, 'mobile' => $mobile))->run();
        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    //确认注销账号
    public static function confirm_cancel_account()
    {
        $code = trim($_POST['value']);
        if (empty($code)) {
            return ecjia_front::$controller->showmessage('验证码不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $token = ecjia_touch_user::singleton()->getToken();
        $data  = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_DELETE_APPLY)->data(array('token' => $token, 'smscode' => $code))->run();

        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/profile/cancel_account')));
        }
    }

    //确认激活账号
    public static function confirm_activate_account()
    {
        $code = trim($_POST['value']);
        if (empty($code)) {
            return ecjia_front::$controller->showmessage('验证码不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $token = ecjia_touch_user::singleton()->getToken();
        $data  = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_ACTIVATE_APPLY)->data(array('token' => $token, 'smscode' => $code))->run();

        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return ecjia_front::$controller->showmessage('激活成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('touch/my/init')));
        }
    }

    //注销/激活手机号 输短信验证码页
    public static function check_user_mobile()
    {
        $token     = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();
        $type      = trim($_GET['type']);

        $user_info['str_mobile_phone'] = substr_replace($user_info['mobile_phone'], '****', 3, 4);
        ecjia_front::$controller->assign('user', $user_info);

        ecjia_front::$controller->assign('type', $type);

        ecjia_front::$controller->assign_title('验证手机号');
        ecjia_front::$controller->display('user_check_user_mobile.dwt');
    }

}

// end
