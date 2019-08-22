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

use Ecjia\App\Platform\Frameworks\Platform\Account;
use Ecjia\App\Wechat\Controllers\EcjiaWechatUserController;
use Ecjia\App\Wechat\Exceptions\WechatUserNotFoundException;
use Ecjia\App\Wechat\WechatUser;

class mobile_userbind extends EcjiaWechatUserController
{

    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_class('wechat_user', 'wechat', false);

        $this->assign('front_url', RC_App::apps_url('statics/front', __FILE__));
        $this->assign('system_statics_url', RC_Uri::admin_url('statics'));

    }

    public function init()
    {
        $openid = trim($_GET['openid']);
        $uuid   = trim($_GET['uuid']);

        $wechat_id   = with(new Ecjia\App\Platform\Frameworks\Platform\Account($uuid))->getAccountID();
        $wechat_user = new Ecjia\App\Wechat\WechatUser($wechat_id, $openid);

        $ect_uid = $wechat_user->getEcjiaUserId();
        if (!empty($ect_uid)) {
            return $this->redirect(RC_Uri::url('wechat/mobile_profile/init', array('openid' => $openid, 'uuid' => $uuid)));
        }

        $this->assign('openid', $openid);
        $this->assign('uuid', $uuid);

        return $this->display(
            RC_Package::package('app::wechat')->loadTemplate('front/bind_mobile_register.dwt', true)
        );
    }

    //输入验证码
    public function get_code()
    {
        $type = trim($_GET['type']);
        if ($type == 'resend') {
            $openid = trim($_GET['openid']);
            $uuid   = trim($_GET['uuid']);
            $mobile = trim($_GET['mobile']);

            if (RC_Time::gmtime() - $_SESSION['temp_register_code_time'] < 60) {
                return $this->showmessage(__('规定时间1分钟以外，可重新发送验证码', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $openid = trim($_POST['openid']);
            $uuid   = trim($_POST['uuid']);
            $mobile = trim($_POST['mobile']);
        }

        if (empty($mobile)) {
            return $this->showmessage(__('手机号不能为空！', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile);
        if (is_ecjia_error($check_mobile)) {
            return $this->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $code     = rand(100000, 999999);
        $options  = array(
            'mobile' => $mobile,
            'event'  => 'sms_get_validate',
            'value'  => array(
                'code'          => $code,
                'service_phone' => ecjia::config('service_phone'),
            ),
        );
        $response = RC_Api::api('sms', 'send_event_sms', $options);

        $_SESSION['temp_register_code']      = $code;
        $_SESSION['temp_register_code_time'] = RC_Time::gmtime();
        if (!is_ecjia_error($response)) {
            return $this->showmessage(sprintf(__('短信已发送到手机%s，请注意查看', 'wechat'), $mobile), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('wechat/mobile_userbind/enter_code', array('mobile' => $mobile, 'uuid' => $uuid, 'openid' => $openid))));
        } else {
            return $this->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    //输入验证码
    public function enter_code()
    {
        $openid = trim($_GET['openid']);
        $uuid   = trim($_GET['uuid']);
        $mobile = trim($_GET['mobile']);

        $this->assign('mobile', $mobile);
        $this->assign('url', RC_Uri::url('wechat/mobile_userbind/bind_user', array('openid' => $openid, 'uuid' => $uuid, 'mobile' => $mobile)));
        $this->assign('resend_url', RC_Uri::url('wechat/mobile_userbind/get_code', array('type' => 'resend', 'openid' => $openid, 'uuid' => $uuid, 'mobile' => $mobile)));

        return $this->display(
            RC_Package::package('app::wechat')->loadTemplate('front/bind_enter_code.dwt', true)
        );
    }

    public function bind_user()
    {
        $openid = trim($_GET['openid']);
        $uuid   = trim($_GET['uuid']);
        $mobile = trim($_GET['mobile']);
        $code   = trim($_POST['password']);

        if (empty($code)) {
            return $this->showmessage(__('请输入短信验证码', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (RC_Time::gmtime() - $_SESSION['temp_register_code_time'] > 300) {
            return $this->showmessage(__('验证码已过期，请重新获取', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($code != $_SESSION['temp_register_code']) {
            return $this->showmessage(__('验证码输入有误，请重新输入', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('type' => 'error'));
        }

        try {
            $wechat_id   = with(new Ecjia\App\Platform\Frameworks\Platform\Account($uuid))->getAccountID();
            $wechat_user = new Ecjia\App\Wechat\WechatUser($wechat_id, $openid);
        } catch (WechatUserNotFoundException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }


        //判断用户是否存在
        $row = RC_DB::table('users')->where('mobile_phone', $mobile)->first();
        if (!empty($row)) {
            $getUserId = $row['user_id'];
        } else {
            $username     = $wechat_user->getNickname();
            $unionid      = $wechat_user->getUnionid();
            $sex          = $wechat_user->sex();
            $user_profile = $wechat_user->getWechatUser()->toArray();

            $connect_user = new \Ecjia\App\Connect\ConnectUser('sns_wechat', $unionid, 'user');
            /*创建用户*/
            $username = $connect_user->getGenerateUserName();
            $password = $connect_user->getGeneratePassword();
            $email    = $connect_user->getGenerateEmail();
            $reg_time = RC_Time::gmtime();

            $user_info = RC_Api::api('user', 'add_user', array(
                'username' => $username,
                'password' => $password,
                'email'    => $email,
                'mobile'   => $mobile,
                'gender'   => $sex,
                'reg_date' => RC_Time::gmtime(),
            ));

            if (is_ecjia_error($user_info)) {
                return $this->showmessage($user_info->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $getUserId = $user_info['user_id'];
        }
        $wechat_user->setEcjiaUserId($getUserId);

        return $this->showmessage(__('恭喜您，关联成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('wechat/mobile_profile/init', array('openid' => $openid, 'uuid' => $uuid))));
    }

    protected function load_default_script_style()
    {
        //自定义加载
        RC_Style::enqueue_style('touch', RC_App::apps_url('statics/front/css/touch.css', __FILE__));
        RC_Style::enqueue_style('style', RC_App::apps_url('statics/front/css/style.css', __FILE__));

        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('jquery-migrate');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-cookie');

        RC_Script::enqueue_script('bind', RC_App::apps_url('statics/front/js/bind.js', __FILE__), array('ecjia-front'), false, true);

        RC_Script::enqueue_script('js-sprintf');
        RC_Script::localize_script('bind', 'js_lang', config('app-wechat::jslang.mobile_profile_page'));
    }
}
