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
 * 第三方登录callback处理
 * @author huangyuyuan@ecmoban.com
 *
 */
class connect_controller
{

    /**
     * 回调显示
     * @param array $data
     */
    public static function callback_template($data)
    {
        unset($_SESSION['user_temp']);

        //获得授权信息，进行关联
        $return_type = $_GET['return_type'];
        if ($return_type == 'bind') {
            $connect_user = $data['connect_user'];
            if (is_ecjia_error($connect_user)) {
                if ($connect_user->get_error_message()) {
                    $msg = $connect_user->get_error_message();
                } else {
                    $msg = '登录授权失败，请稍后再试或联系客服';
                }
                return ecjia_front::$controller->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $connect_code = $connect_user->getConnectCode();
            $open_id      = $connect_user->getOpenId();
            if($connect_code == 'sns_wechat') {
                $user_name = with(new \Ecjia\App\Connect\UserGenerate($connect_user))->getUserName();
            } else {
                $user_name    = $connect_user->getUserName();
            }
            

            //绑定第三方
            $token = ecjia_touch_user::singleton()->getToken();
            $user  = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
            $user  = is_ecjia_error($user) ? array() : $user;

            $connect_user = new \Ecjia\App\Connect\ConnectUser($connect_code, $open_id);
            $result       = false;
            if ($user) {
                $result = $connect_user->bindUser($user['id']);
            }

            return ecjia_front::$controller->redirect(RC_Uri::url('user/profile/bind_info', array('type' => 'wechat')));
        }

        $connect_user = $data['connect_user'];
        if (is_ecjia_error($connect_user)) {
            if ($connect_user->get_error_code() == 'retry_return_login' || $connect_user->get_error_code() == '-1') {
                $login_str = user_function::return_login_str();
                return ecjia_front::$controller->redirect(RC_Uri::url($login_str));
            }

            if ($connect_user->get_error_message()) {
                $msg = $connect_user->get_error_message();
            } else {
                $msg = '登录授权失败，请使用其他方式登录';
            }
            return ecjia_front::$controller->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $connect_code = $connect_user->getConnectCode();
        $open_id      = $connect_user->getOpenId();
        if($connect_code == 'sns_wechat') {
            $user_name = with(new \Ecjia\App\Connect\UserGenerate($connect_user))->getUserName();
        } else {
            $user_name    = $connect_user->getUserName();
        }

        $_SESSION['user_temp']['connect_code'] = $connect_code;
        $_SESSION['user_temp']['open_id']      = $open_id;
        $_SESSION['user_temp']['user_name']    = $user_name;

        ecjia_front::$controller->assign('title', '绑定手机号');
        ecjia_front::$controller->assign_title('绑定手机号');

        return ecjia_front::$controller->fetch('user_bind_mobile.dwt');
    }

    /* 第三方登录快速注册 */
    public static function bind_signup($params)
    {
        $connect_code = royalcms('request')->query('connect_code');
        $open_id      = royalcms('request')->query('open_id');

        if (!$params) {
            if (empty($connect_code) || empty($open_id)) {
                return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }
            ecjia_front::$controller->assign('connect_code', $connect_code);
            ecjia_front::$controller->assign('open_id', $open_id);

            ecjia_front::$controller->assign('title', "注册绑定");
            ecjia_front::$controller->assign_title("注册绑定");
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->display('user_bind_signup.dwt');
        } else {
            $params['name'] = preg_replace('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', '', $params['name']);
            $response       = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => $params['name'], 'password' => $params['password'], 'email' => $params['email']))->run();
            if (is_ecjia_error($response)) {
                return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }
            //登录
            ecjia_touch_user::singleton()->signin('password', $params['name'], $params['password']);
            return $response['session']['uid'];
        }
    }

    public static function bind_signup_do()
    {
        //验证邀请码验证码
        $verification = !empty($_POST['verification']) ? trim($_POST['verification']) : '';
        $mobile       = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';
        $username     = !empty($_POST['username']) ? trim($_POST['username']) : '';
        $password     = !empty($_POST['password']) ? trim($_POST['password']) : '';
        $code         = !empty($_POST['code']) ? trim($_POST['code']) : '';

        $connect_code = !empty($_POST['connect_code']) ? trim($_POST['connect_code']) : '';
        $open_id      = !empty($_POST['open_id']) ? trim($_POST['open_id']) : '';

        if (empty($mobile) || empty($username) || empty($password) || empty($code)) {
            return ecjia_front::$controller->showmessage('请填写完整信息', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($connect_code) || empty($open_id)) {
            return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (strlen($verification) > 6) {
            return ecjia_front::$controller->showmessage('邀请码格式不正确', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $token = ecjia_touch_user::singleton()->getShopToken();

        $response = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_BIND)->data(array('token' => $token, 'type' => 'mobile', 'value' => $mobile, 'code' => $code))->run();
        if (is_ecjia_error($response)) {
            return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($response['registered'] == 1) {
            return ecjia_front::$controller->showmessage(__('该手机号已被注册，请更换其他手机号'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //注册
        $response = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => $username, 'mobile' => $mobile, 'password' => $password, 'invite_code' => $verification))->run();
        if (is_ecjia_error($response)) {
            return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //绑定第三方
        $user_id = $response['user']['id'];

        $connect_user = new \Ecjia\App\Connect\ConnectUser($connect_code, $open_id);
        $result       = false;
        if ($user_id) {
            $result = $connect_user->bindUser($user_id);
        }
        if ($result) {
            //登录
            ecjia_touch_user::singleton()->signin('password', $username, $password);
            $return_url = RC_Cookie::get('referer') ? RC_Cookie::get('referer') : RC_Uri::url('touch/my/init');
            return ecjia_front::$controller->showmessage('恭喜您，注册成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $return_url));
        } else {
            return ecjia_front::$controller->showmessage('授权用户信息关联失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /* 第三方登录绑定关联 */
    public static function bind_signin()
    {
        $connect_code = !empty($_GET['connect_code']) ? trim($_GET['connect_code']) : '';
        $open_id      = !empty($_GET['open_id']) ? trim($_GET['open_id']) : '';
        if (empty($connect_code) || empty($open_id)) {
            return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }
        ecjia_front::$controller->assign('connect_code', $connect_code);
        ecjia_front::$controller->assign('open_id', $open_id);

        ecjia_front::$controller->assign('title', "验证并关联");
        ecjia_front::$controller->assign_title("验证并关联");
        ecjia_front::$controller->assign('hideinfo', '1');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_bind_signin.dwt');
    }

    public static function bind_signin_do()
    {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $username = trim($username);
        $password = trim($password);

        $connect_code = !empty($_POST['connect_code']) ? trim($_POST['connect_code']) : '';
        $open_id      = !empty($_POST['open_id']) ? trim($_POST['open_id']) : '';
        if (empty($connect_code) || empty($open_id)) {
            return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($username) || empty($password)) {
            return ecjia_front::$controller->showmessage('请填写完整信息', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = ecjia_touch_user::singleton()->signin($username, $password);

        if (is_ecjia_error($data)) {
            $message = $data->get_error_message();
            return ecjia_front::$controller->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('info' => $message));
        } else {
            $referer_url = !empty($_POST['referer']) ? urlencode($_POST['referer']) : RC_Uri::url('touch/my/init');

            $connect_user = new \Ecjia\App\Connect\ConnectUser($connect_code, $open_id);
            if ($data['id']) {
                $result = $connect_user->bindUser($data['id']);
            } else {
                return ecjia_front::$controller->showmessage('用户验证成功，获取用户信息失败，请重试！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($result) {
                $return_url = RC_Cookie::get('referer') ? RC_Cookie::get('referer') : RC_Uri::url('touch/my/init', array('connect_code' => $connect_code, 'open_id' => $open_id));
                return ecjia_front::$controller->showmessage('关联成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,
                    array('pjaxurl' => $return_url));
            } else {
                return ecjia_front::$controller->showmessage('授权用户信息关联失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
    }

    private static function sync_wechat_user($user_info)
    {

        if ($user_info['ect_uid']) {
            $count = RC_DB::table('connect_user')->where('connect_code', 'sns_wechat')->where('user_id', $user_info['ect_uid'])->count();
            if ($count) {
                return false;
            }
        }

        $wechat_info = array(
            'openid'     => $user_info['openid'],
            'nickname'   => $user_info['nickname'],
            'sex'        => $user_info['sex'],
            'language'   => $user_info['language'],
            'city'       => $user_info['city'],
            'province'   => $user_info['province'],
            'country'    => $user_info['country'],
            'headimgurl' => $user_info['headimgurl'],
            'privilege'  => array(),
            'unionid'    => $user_info['unionid'],
        );

        $new_user = array(
            'connect_code' => 'sns_wechat',
            'user_id'      => $user_info['ect_uid'],
            'open_id'      => empty($user_info['unionid']) ? $user_info['openid'] : $user_info['unionid'],
            'profile'      => serialize($wechat_info),
        );

        if (RC_DB::table('connect_user')->where('connect_code', 'sns_wechat')->where('open_id', $new_user['open_id'])->count()) {
            RC_DB::table('connect_user')->where('connect_code', 'sns_wechat')->where('open_id', $new_user['open_id'])->update($new_user);
        } else {
            $new_user['is_admin']  = 0;
            $new_user['create_at'] = RC_Time::gmtime();
            RC_DB::table('connect_user')->insert($new_user);
        }

        if ($wechat_info['ect_uid']) {
            RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $wechat_info['headimgurl'], 'user_id' => $wechat_info['ect_uid']));
        }
    }

    /**
     * 手机登录
     */
    public static function mobile_login()
    {
        $mobile_phone = trim($_POST['mobile_phone']);
        if (empty($mobile_phone)) {
            return ecjia_front::$controller->showmessage('请输入手机号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile_phone);
        if (is_ecjia_error($check_mobile)) {
            return ecjia_front::$controller->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $_SESSION['user_temp']['mobile'] = $mobile_phone;

        return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('connect/index/captcha_validate')));
    }

    //图形验证码
    public static function captcha_validate()
    {
        $mobile_phone = $_SESSION['user_temp']['mobile'];

        if (empty($mobile_phone)) {
            $login_str = user_function::return_login_str();
            ecjia_front::$controller->redirect(RC_Uri::url($login_str));
        }

        $token = ecjia_touch_user::singleton()->getShopToken();

        $res = ecjia_touch_manager::make()->api(ecjia_touch_api::CAPTCHA_IMAGE)->data(array('token' => $token))->run();
        $res = !is_ecjia_error($res) ? $res : array();

        ecjia_front::$controller->assign('captcha_image', $res['base64']);

        ecjia_front::$controller->assign('title', '图形验证码');
        ecjia_front::$controller->assign_title('图形验证码');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign('url', RC_Uri::url('connect/index/captcha_check'));
        ecjia_front::$controller->assign('refresh_url', RC_Uri::url('connect/index/captcha_refresh'));

        ecjia_front::$controller->display('user_captcha_validate.dwt');
    }

    //刷新验证码
    public static function captcha_refresh()
    {
        $token = ecjia_touch_user::singleton()->getShopToken();

        $res = ecjia_touch_manager::make()->api(ecjia_touch_api::CAPTCHA_IMAGE)->data(array('token' => $token))->run();
        if (is_ecjia_error($res)) {
            return ecjia_front::$controller->showmessage($res->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        return ecjia_front::$controller->showmessage($res['base64'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    //检查图形验证码
    public static function captcha_check()
    {
        $token  = ecjia_touch_user::singleton()->getShopToken();
        $mobile = $_SESSION['user_temp']['mobile'];

        $type = trim($_POST['type']);
        if ($type == 'resend') {
            $code_captcha = $_SESSION['user_temp']['captcha_code'];
        } else {
            $code_captcha = trim($_POST['code_captcha']);
        }
        if (empty($code_captcha)) {
            return ecjia_front::$controller->showmessage('请输入验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (RC_Time::gmtime() < $_SESSION['user_temp']['resend_sms_time'] + 60) {
            return ecjia_front::$controller->showmessage('规定时间1分钟以外，可重新发送验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $param = array(
            'token'        => $token,
            'type'         => 'mobile',
            'value'        => $mobile,
            'captcha_code' => $code_captcha,
        );

        $res = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_USERBIND)->data($param)->run();
        if (is_ecjia_error($res)) {
            return ecjia_front::$controller->showmessage($res->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $_SESSION['user_temp']['captcha_code']    = $code_captcha;
        $_SESSION['user_temp']['resend_sms_time'] = RC_Time::gmtime();

        //是否已注册
        $registered = 0;
        if ($res['registered'] == 1) {
            $registered = 1;
        }
        $_SESSION['user_temp']['registered'] = $registered;

        //是否被邀请
        $invited = 0;
        if ($res['is_invited'] == 1) {
            $invited = 1;
        }
        $_SESSION['user_temp']['invited'] = $invited;

        $pjaxurl = RC_Uri::url('connect/index/enter_code');
        $message = '验证码已发送';
        if ($type == 'resend') {
            return ecjia_front::$controller->showmessage('发送成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }

        return ecjia_front::$controller->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }

    //输入验证码
    public static function enter_code()
    {
        $mobile = $_SESSION['user_temp']['mobile'];
        if (empty($mobile)) {
            $login_str = user_function::return_login_str();
            ecjia_front::$controller->redirect(RC_Uri::url($login_str));
        }

        $code_captcha = $_SESSION['user_temp']['captcha_code'];

        ecjia_front::$controller->assign('title', '输入验证码');
        ecjia_front::$controller->assign_title('输入验证码');
        ecjia_front::$controller->assign_lang();

        ecjia_front::$controller->assign('type', 'smslogin');
        ecjia_front::$controller->assign('code_captcha', $code_captcha);
        ecjia_front::$controller->assign('mobile', $mobile);

        ecjia_front::$controller->assign('url', RC_Uri::url('connect/index/mobile_signin'));
        ecjia_front::$controller->assign('resend_url', RC_Uri::url('connect/index/captcha_check'));

        ecjia_front::$controller->display('user_enter_code.dwt');
    }

    //验证码验证登录
    public static function mobile_signin()
    {
        $type     = trim($_POST['type']);
        $password = trim($_POST['password']);
        $mobile   = $_SESSION['user_temp']['mobile'];
        $token    = ecjia_touch_user::singleton()->getShopToken();

        $registered   = $_SESSION['user_temp']['registered'];
        $invited      = $_SESSION['user_temp']['invited'];
        $connect_code = $_SESSION['user_temp']['connect_code'];
        $open_id      = $_SESSION['user_temp']['open_id'];

        $connect_user = new \Ecjia\App\Connect\ConnectUser($connect_code, $open_id);

        //已经注册 走登录接口
        if ($registered == 1) {
            $data = ecjia_touch_user::singleton()->signin($type, $mobile, $password);
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /*获取远程用户头像信息*/
            user_controller::sync_avatar($connect_user);

            if ($data['id']) {
                $result = $connect_user->bindUser($data['id']);
            } else {
                return ecjia_front::$controller->showmessage('用户验证成功，获取用户信息失败，请重试！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $url         = RC_Uri::url('touch/my/init', array('connect_code' => $connect_code, 'open_id' => $open_id));
            $referer_url = !empty($_POST['referer_url']) ? urldecode($_POST['referer_url']) : urldecode($_SESSION['user_temp']['referer_url']);
            if (!empty($referer_url) && $referer_url != 'undefined' && !strpos($referer_url, 'user')) {
                $url = $referer_url;
            }
            if ($url == 'undefined') {
                $url = RC_Uri::url('touch/my/init');
            }
            if ($result) {
                return ecjia_front::$controller->showmessage('关联成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            } else {
                return ecjia_front::$controller->showmessage('授权用户信息关联失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            //未注册 走注册接口
            $_SESSION['user_temp']['mobile']          = $mobile;
            $_SESSION['user_temp']['register_status'] = 'succeed';
            $_SESSION['user_temp']['code']            = $password;

            $res = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => '', 'mobile' => $mobile, 'password' => ''))->run();
            if (!is_ecjia_error($res)) {
                $url = RC_Uri::url('touch/my/init');

                $referer_url = isset($_SESSION['user_temp']['referer_url']) ? urldecode($_SESSION['user_temp']['referer_url']) : '';
                if (!empty($referer_url) && $referer_url != 'undefined' && !strpos($referer_url, 'user')) {
                    $url = $referer_url;
                }

                unset($_SESSION['user_temp']);

                ecjia_touch_user::singleton()->signin('smslogin', $mobile, $password);

                if ($res['user']['id']) {
                    $connect_user->bindUser($res['user']['id']);
                }

                /*获取远程用户头像信息*/
                user_controller::sync_avatar($connect_user);

                if ($url == 'undefined') {
                    $url = RC_Uri::url('touch/my/init');
                }
                return ecjia_front::$controller->showmessage(__('恭喜您，注册成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            } else {
                return ecjia_front::$controller->showmessage(__($res->get_error_message()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
    }

    public static function set_password()
    {
        $mobile = !empty($_SESSION['user_temp']['mobile']) ? $_SESSION['user_temp']['mobile'] : '';

        if ($_SESSION['user_temp']['register_status'] != 'succeed' || empty($mobile)) {
            $login_str = user_function::return_login_str();
            ecjia_front::$controller->redirect(RC_Uri::url($login_str));
        }
        if (isset($_POST['username'])) {
            $username          = !empty($_POST['username']) ? trim($_POST['username']) : '';
            $password          = !empty($_POST['password']) ? trim($_POST['password']) : '';
            $show_verification = intval($_POST['show_verification']);

            $verification = '';
            if ($show_verification == 1) {
                $verification = trim($_POST['verification']);
                if (strlen($verification) > 6) {
                    return ecjia_front::$controller->showmessage('邀请码格式不正确', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }

            if (empty($username)) {
                return ecjia_front::$controller->showmessage('请设置用户名', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($password)) {
                return ecjia_front::$controller->showmessage('请设置密码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $connect_code = $_SESSION['user_temp']['connect_code'];
            $open_id      = $_SESSION['user_temp']['open_id'];

            if (empty($connect_code) || empty($open_id)) {
                return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

        }
        if (!empty($username) && !empty($password)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => $username, 'mobile' => $mobile, 'password' => $password, 'invite_code' => $verification))->run();
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage(__($data->get_error_message()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            //绑定第三方
            $user_id = $data['user']['id'];

            $connect_user = new \Ecjia\App\Connect\ConnectUser($connect_code, $open_id);
            $result       = false;
            if ($user_id) {
                $result = $connect_user->bindUser($user_id);
            }
            if ($result) {
                /*获取远程用户头像信息*/
                user_controller::sync_avatar($connect_user);

                $url = RC_Uri::url('touch/my/init');
                if (!empty($_SESSION['user_temp']['referer_url'])) {
                    $url = urldecode($_SESSION['user_temp']['referer_url']);
                }
                unset($_SESSION['user_temp']);

                ecjia_touch_user::singleton()->signin('password', $username, $password);
                return ecjia_front::$controller->showmessage(__('恭喜您，绑定注册成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            } else {
                return ecjia_front::$controller->showmessage('授权用户信息关联失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
            if (!ecjia_front::$controller->is_cached('user_set_password.dwt', $cache_id)) {
                ecjia_front::$controller->assign('title', '设置名字密码');
                ecjia_front::$controller->assign_lang();
            }
            ecjia_front::$controller->assign('invited', $_SESSION['user_temp']['invited']);
            ecjia_front::$controller->assign('set_url', RC_Uri::url('connect/index/set_password'));
            ecjia_front::$controller->assign('user_name', $_SESSION['user_temp']['user_name']);

            ecjia_front::$controller->display('user_set_password.dwt', $cache_id);
        }
    }

    public static function authorize()
    {
        $connect_code = $_GET['connect_code'];
        if (empty($connect_code)) {
            return ecjia_front::$controller->showmessage(RC_Lang::get('connect::connect.not_found'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }

        $url = RC_Uri::url('connect/callback/init', array('connect_code' => 'sns_wechat', 'return_type' => 'bind'));

        /**
         * 第三方登录运行前处理
         * @param $connect_code 插件代号
         */
        RC_Hook::do_action('connect_code_before_launching', $connect_code);

        $connect_handle = with(new Ecjia\App\Connect\ConnectPlugin())->channel($connect_code);

        $redirect_uri = urlencode($url);

        $connect_handle->overwrite_callback_url($redirect_uri);

        $code_url = $connect_handle->authorize_url();

        RC_Cookie::set('referer', RC_Uri::url('user/profile/bind_info', array('type' => 'wechat')));

        RC_Cookie::set('wechat_auto_register', 1);

        return ecjia_front::$controller->redirect($code_url);
    }
}

// end
