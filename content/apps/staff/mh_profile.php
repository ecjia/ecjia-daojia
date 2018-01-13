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
 * 个人信息
 */
class mh_profile extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Staff\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');

        RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
        RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);
        RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__), array(), false, true);

        RC_Script::enqueue_script('profile', RC_App::apps_url('statics/js/profile.js', __FILE__));

        RC_Style::enqueue_style('style', RC_App::apps_url('statics/css/style.css', __FILE__), array());
        RC_Script::enqueue_script('cropbox', RC_App::apps_url('statics/js/cropbox.js', __FILE__));
    }

    /**
     * 个人资料
     */
    public function init()
    {
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('个人资料')));
        $this->assign('ur_here', __('个人资料'));

        $user_info               = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
        $user_info['add_time']   = RC_Time::local_date(ecjia::config('date_format'), $user_info['add_time']);
        $user_info['last_login'] = RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);
        $this->assign('user_info', $user_info);

        $this->assign('form_action', RC_Uri::url('staff/mh_profile/update_self'));

        $this->display('profile_info.dwt');
    }

    /**
     * 处理更新资料逻辑
     */
    public function update_self()
    {
        $user_ident             = !empty($_POST['user_ident']) ? trim($_POST['user_ident']) : '';
        $name                   = !empty($_POST['name']) ? trim($_POST['name']) : '';
        $_SESSION['staff_name'] = $name;
        $nick_name              = !empty($_POST['nick_name']) ? trim($_POST['nick_name']) : '';
        $todolist               = !empty($_POST['todolist']) ? trim($_POST['todolist']) : '';
        $introduction           = !empty($_POST['introduction']) ? trim($_POST['introduction']) : '';

        if (RC_DB::table('staff_user')->where('name', $name)->where('user_id', '!=', $_SESSION['staff_id'])->count() > 0) {
            return $this->showmessage('该员工名称已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'user_ident'   => $user_ident,
            'name'         => $name,
            'nick_name'    => $nick_name,
            'todolist'     => $todolist,
            'introduction' => $introduction,
        );
        RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
        ecjia_merchant::admin_log('', 'edit', 'staff_profile');
        return $this->showmessage('编辑个人资料成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/init')));
    }

    /**
     * 修改账户
     */
    public function setting()
    {
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账户设置')));
        $this->assign('ur_here', __('账户设置'));

        $user_info               = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
        $user_info['add_time']   = RC_Time::local_date(ecjia::config('date_format'), $user_info['add_time']);
        $user_info['last_login'] = RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);
        $this->assign('user_info', $user_info);

        $this->assign('form_action', RC_Uri::url('staff/mh_profile/update_set'));

        $this->display('profile_setting.dwt');
    }

    /**
     * 处理账户逻辑
     */
    public function update_set()
    {
        $staff_id = $_SESSION['staff_id'];
        $salt     = rand(1, 9999);
        $password = !empty($_POST['new_password']) ? md5(md5($_POST['new_password']) . $salt) : '';
        $mobile   = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';
        $email    = !empty($_POST['email']) ? trim($_POST['email']) : '';

        $admin_oldemail = RC_DB::TABLE('staff_user')->where('user_id', $staff_id)->pluck('email'); //单个
        /* Email地址是否有重复 */
        if ($email && $email != $admin_oldemail) {
            $is_only = RC_DB::table('staff_user')->where('email', $email)->count();
            if ($is_only != 0) {
                return $this->showmessage(sprintf(__('该Email地址 %s 已经存在！'), stripslashes($email)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        $pwd_modified = false;
        if (!empty($_POST['new_password'])) {
            $old_password = RC_DB::TABLE('staff_user')->where('user_id', $staff_id)->pluck('password');
            $old_salt     = RC_DB::TABLE('staff_user')->where('user_id', $staff_id)->pluck('salt');

            if (empty($_POST['old_password'])) {
                return $this->showmessage('请输入当前密码进行核对之后才可以修改新密码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (empty($old_salt)) {
                $old_ecjia_password = md5($_POST['old_password']);
            } else {
                $old_ecjia_password = md5(md5($_POST['old_password']) . $old_salt);
            }

            if ($old_password != $old_ecjia_password) {
                return $this->showmessage('输入的旧密码错误！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 比较新密码和确认密码是否相同 */
            if ($_POST['new_password'] == $_POST['pwd_confirm']) {
                $pwd_modified = true;
            }
        }
        //更新管理员信息
        if ($pwd_modified) {
            $data = array(
                'salt'     => $salt,
                'password' => $password,
                'mobile'   => $mobile,
                'email'    => $email,
            );
        } else {
            $data = array(
                'mobile' => $mobile,
                'email'  => $email,
            );
        }

        RC_DB::table('staff_user')->where('user_id', $staff_id)->update($data);
        ecjia_merchant::admin_log('', 'edit', 'account_set');
        /* 清除用户缓存 */
        RC_Cache::userdata_cache_delete('admin_navlist', $staff_id, true);

        if ($pwd_modified) {
            /* 如果修改了密码，则需要将session中该管理员的数据清空 */
            RC_Session::session()->deleteSpecSession($_SESSION['staff_id'], 'merchant'); // 删除session中该管理员的记录

            $msg = __('您已经成功的修改了密码，因此您必须重新登录！');
        } else {
            $msg = __('修改个人资料成功！');
        }

        return $this->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/setting')));
    }

    //获取短信验证码
    public function get_mobile_code()
    {
        $newmobile = $_GET['newmobile'];
        if (empty($newmobile)) {
            return $this->showmessage('请输入新的手机账号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (RC_DB::table('staff_user')->where('mobile', $newmobile)->count() > 0) {
            return $this->showmessage('该手机账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $code    = rand(100000, 999999);
        $options = array(
            'mobile' => $newmobile,
            'event'  => 'sms_get_validate',
            'value'  => array(
                'code'          => $code,
                'service_phone' => ecjia::config('service_phone'),
            ),
        );

        $_SESSION['temp_code']      = $code;
        $_SESSION['temp_code_time'] = RC_Time::gmtime();

        $response = RC_Api::api('sms', 'send_event_sms', $options);
        if (is_ecjia_error($response)) {
            return $this->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return $this->showmessage('手机验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    //更换手机账号
    public function update_mobile()
    {

        $code      = $_POST['mobilecode'];
        $newmobile = $_POST['newmobile'];
        if (RC_DB::table('staff_user')->where('mobile', $newmobile)->count() > 0) {
            return $this->showmessage('该手机账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $time = RC_Time::gmtime() - 6000 * 3;
        if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
            $data = array(
                'mobile' => $newmobile,
            );
            RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
            ecjia_merchant::admin_log('', 'edit', 'account_set');
            return $this->showmessage('更改手机账号成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/setting')));
        } else {
            return $this->showmessage('请输入正确的手机校验码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    //获取邮箱验证码
    public function get_email_code()
    {
        $newemail = $_GET['newemail'];

        if (empty($newemail)) {
            return $this->showmessage('请输入新的邮件账号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (RC_DB::table('staff_user')->where('email', $newemail)->count() > 0) {
            return $this->showmessage('该邮件账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $code     = rand(100000, 999999);
        $tpl_name = 'send_validate';
        $template = RC_Api::api('mail', 'mail_template', $tpl_name);
        if (!empty($template)) {
            $this->assign('user_name', $_SESSION['staff_name']);
            $this->assign('code', $code);
            $this->assign('shop_name', ecjia::config('shop_name'));
            $this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
            $this->assign('service_phone', ecjia::config('service_phone'));

            if (RC_Mail::send_mail('', $newemail, $template['template_subject'], $this->fetch_string($template['template_content']), $template['is_html'])) {
                $_SESSION['temp_code']      = $code;
                $_SESSION['temp_code_time'] = RC_Time::gmtime();
                return $this->showmessage('邮件验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            } else {
                return $this->showmessage('邮件验证码验证码发送失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

    }

    //更换邮箱账号
    public function update_email()
    {

        $code     = $_POST['emailcode'];
        $newemail = $_POST['newemail'];
        if (RC_DB::table('staff_user')->where('email', $newemail)->count() > 0) {
            return $this->showmessage('该邮件账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $time = RC_Time::gmtime() - 6000 * 3;
        if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
            $data = array(
                'email' => $newemail,
            );
            RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
            ecjia_merchant::admin_log('', 'edit', 'account_set');
            return $this->showmessage('更改邮件账号成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/setting')));
        } else {
            return $this->showmessage('请输入正确的验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 个人资料
     */
    public function avatar()
    {
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('个人资料')));
        $this->assign('ur_here', __('个人资料'));

        $user_info               = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
        $user_info['add_time']   = RC_Time::local_date(ecjia::config('date_format'), $user_info['add_time']);
        $user_info['last_login'] = RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);
        $this->assign('user_info', $user_info);

        $this->assign('form_action', RC_Uri::url('staff/mh_profile/avatar_update'));

        $this->display('profile_avatar.dwt');

    }
    /**
     * 个人资料
     */
    public function avatar_update()
    {
        $img      = $_POST['img'];
        $staff_id = $_SESSION['staff_id'];
        $store_id = $_SESSION['store_id'];

        $path          = RC_Upload::upload_path('merchant/' . $store_id . '/data/avatar');
        $filename_path = $path . '/' . $staff_id . "_" . 'avatar.png';
        RC_Filesystem::mkdir($path, 0777, true, true);
        $img = base64_decode($img);
        file_put_contents($filename_path, $img);
        $file_url = 'merchant/' . $store_id . '/data/avatar/' . $staff_id . "_" . 'avatar.png';
        $data     = array(
            'avatar' => $file_url,
        );
        RC_DB::table('staff_user')->where('user_id', $staff_id)->update($data);
        return $this->showmessage('上传新头像成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/avatar')));
    }
}

//end
