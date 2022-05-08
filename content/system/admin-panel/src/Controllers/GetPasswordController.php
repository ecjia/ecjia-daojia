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
namespace Ecjia\System\AdminPanel\Controllers;

use ecjia;
use Ecjia\System\Admins\Users\AdminUserRepository;
use Ecjia\System\Events\AdminUserForgetPasswordEvent;
use ecjia_admin;
use ecjia_password;
use RC_Api;
use RC_Loader;
use RC_Mail;
use RC_Script;
use RC_Style;
use RC_Time;
use RC_Uri;
use RC_Validator;

/**
 * ECJIA 找回管理员密码
 */
class GetPasswordController extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Script::enqueue_script('jquery-form');

        // 禁止以下css加载
        RC_Style::dequeue_style(array(
            'ecjia',
            'general',
            'main',
            'style',
            'color',
            'ecjia-skin-blue',
            'bootstrap-responsive',
            'jquery-ui-aristo',
            'jquery-qtip',
            'jquery-jBreadCrumb',
            'jquery-colorbox',
            'jquery-sticky',
            'google-code-prettify',
            'splashy',
            'flags',
            'datatables-TableTools',
            'fontello',
            'chosen',
            'jquery-stepy'
        ));

        // 加载'bootstrap','jquery-uniform','jquery-migrate','jquery-form',
        // 禁止以下js加载
        RC_Script::dequeue_script(array(
            'ecjia',
            'ecjia-addon',
            'ecjia-autocomplete',
            'ecjia-browser',
            'ecjia-colorselecter',
            'ecjia-common',
            'ecjia-compare',
            'ecjia-cookie',
            'ecjia-flow',
            'ecjia-goods',
            'ecjia-lefttime',
            'ecjia-listtable',
            'ecjia-listzone',
            'ecjia-message',
            'ecjia-orders',
            'ecjia-region',
            'ecjia-selectbox',
            'ecjia-selectzone',
            'ecjia-shipping',
            'ecjia-showdiv',
            'ecjia-todolist',
            'ecjia-topbar',
            'ecjia-ui',
            'ecjia-user',
            'ecjia-utils',
            'ecjia-validator',
            'ecjia-editor',
            'jquery-ui-touchpunch',
            'jquery',
            'jquery-pjax',
            'jquery-peity',
            'jquery-mockjax',
            'jquery-wookmark',
            'jquery-cookie',
            'jquery-actual',
            'jquery-debouncedresize',
            'jquery-easing',
            'jquery-mediaTable',
            'jquery-imagesloaded',
            'jquery-gmap3',
            'jquery-autosize',
            'jquery-counter',
            'jquery-inputmask',
            'jquery-progressbar',
            'jquery-ui-totop',
            'ecjia-admin',
            'jquery-ui',
            'jquery-validate',
            'smoke',
            'jquery-chosen',
            'bootstrap-placeholder',
            'jquery-flot',
            'jquery-flot-curvedLines',
            'jquery-flot-multihighlight',
            'jquery-flot-orderBars',
            'jquery-flot-pie',
            'jquery-flot-pyramid',
            'jquery-flot-resize',
            'jquery-mousewheel',
            'antiscroll',
            'jquery-colorbox',
            'jquery-qtip',
            'jquery-sticky',
            'jquery-jBreadCrumb',
            'ios-orientationchange',
            'google-code-prettify',
            'selectnav',
            'jquery-dataTables',
            'jquery-dataTables-sorting',
            'jquery-dataTables-bootstrap',
            'jquery-stepy',
            'tinymce'
        ));
    }

    public function forget_pwd()
    {
        RC_Loader::load_app_class('hooks.plugin_captcha', 'captcha', false);

        return $this->display('get_pwd.dwt');
    }

    public function reset_pwd_mail()
    {
        try {
            $validator = RC_Validator::make($_POST, array(
                'email'    => 'required|email',
                'username' => 'required',
            ));
            if ($validator->fails()) {
                return $this->showmessage(__('输入的信息不正确！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $admin_username = remove_xss($this->request->input('username'));
            $admin_email    = remove_xss($this->request->input('email'));

            /* 管理员用户名和邮件地址是否匹配，并取得原密码 */
            $admin_model = AdminUserRepository::model()->where('user_name', $admin_username)->where('email', $admin_email)->first();

            if (empty($admin_model)) {
                return $this->showmessage(__('用户名与Email地址不匹配,请返回！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            event(new AdminUserForgetPasswordEvent($admin_model));

            $msg   = __('重置密码的邮件已经发到您的邮箱：') . $admin_email;
            //提示信息
            $links = ecjia_alert_links([
                'text' => __('返回'),
                'href' => RC_Uri::url('@privilege/login'),
            ]);
            return $this->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }

    public function reset_pwd_form()
    {
        $code    = remove_xss($this->request->input('code'));
        $adminid = intval($this->request->input('uid', 0));

        if ($adminid === 0 || empty($code)) {
            return $this->redirect(RC_Uri::url('@privilege/login'));
        }

        /* 以用户的原密码，与code的值匹配 */
        $model = AdminUserRepository::model()->find($adminid);

        $links = ecjia_alert_links([
            'text' => __('返回'),
            'href' => RC_Uri::url('@privilege/login'),
        ]);

        if (empty($model)) {
            // 此链接不合法
            return $this->showmessage(__('此用户不存在!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, ['links' => $links]);
        }

        $password  = $model['password'];
        $hash_code = $model->getMeta('forget_password_hash');

        $pm     = ecjia_password::autoCompatibleDriver($password);
        $status = $pm->verifyResetPasswordHash($code, $adminid, $password, $hash_code);
        if (empty($status)) {
            // 此链接不合法
            return $this->showmessage(__('此链接不合法!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, ['links' => $links]);
        }

        $this->assign('adminid', $adminid);
        $this->assign('code', $code);
        $this->assign('ur_here', __('修改密码'));
        return $this->display('reset_pwd.dwt');
    }

    public function reset_pwd()
    {
        try {
            $new_password = remove_xss($this->request->input('password'));
            $adminid      = intval($this->request->input('adminid', 0));
            $code         = remove_xss($this->request->input('code'));

            if (empty($new_password) || empty($code) || $adminid === 0) {
                return $this->redirect(RC_Uri::url('@privilege/login'));
            }

            /* 以用户的原密码，与code的值匹配 */
            $model     = AdminUserRepository::model()->find($adminid);
            $password  = $model['password'];
            $hash_code = $model->getMeta('forget_password_hash');

            $pm     = ecjia_password::autoCompatibleDriver($password);
            $status = $pm->verifyResetPasswordHash($code, $adminid, $password, $hash_code);

            $links = ecjia_alert_links([
                'text' => __('返回'),
                'href' => RC_Uri::url('@privilege/login'),
            ]);

            // 此链接不合法
            if (empty($status)) {
                return $this->showmessage(__('此链接不合法!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, ['links' => $links]);
            }

            $model->removeMeta('forget_password_hash');

            // 更新管理员的密码
            $ec_salt         = rand(1, 9999);
            $model->password = $pm->createSaltPassword($new_password, $ec_salt);
            $model->ec_salt  = $ec_salt;
            $result          = $model->save();

            if (!$result) {
                return $this->showmessage(__('密码修改失败!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            return $this->showmessage(__('密码修改成功!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, ['links' => $links]);
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

}

// end