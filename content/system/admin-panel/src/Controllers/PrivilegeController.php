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

/**
 * ECJIA 用户登录、修改个人信息及权限管理程序
 */

use admin_nav_here;
use ecjia;
use Ecjia\Component\ShowMessage\Options\PjaxShowMessageOption;
use Ecjia\Component\PasswordLock\PasswordLock;
use Ecjia\System\Admins\AdminMenu\HeaderMenuGroup;
use Ecjia\Component\QuickNav\QuickNav;
use Ecjia\System\Admins\Users\AdminPurviewClass;
use Ecjia\System\Admins\Users\AdminUserRepository;
use ecjia_admin;
use ecjia_admin_log;
use ecjia_password;
use ecjia_screen;
use RC_Cache;
use RC_Cookie;
use RC_Hook;
use RC_Ip;
use RC_Script;
use RC_Session;
use RC_Style;
use RC_Time;
use RC_Uri;

class PrivilegeController extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('verify_csrf_token')->only(['signin']);

        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-validate');

        RC_Script::enqueue_script('ecjia-admin_privilege');

        //js语言包调用
        RC_Script::localize_script('ecjia-admin_privilege', 'admin_privilege', config('system::jslang.privilege_page'));

    }

    /**
     * 登录界面
     */
    public function login()
    {
        //加载'bootstrap','ecjia-ui','uniform-aristo',
        //禁止以下css加载
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
        //加载'bootstrap','jquery-uniform','jquery-migrate','jquery-form',
        //禁止以下js加载
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
            'ecjia-admin_privilege',
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

        $this->assign('form_action', RC_Uri::url('@privilege/signin'));
        $this->assign('logo_display', RC_Hook::apply_filters('ecjia_admin_logo_display', '<div class="logo"></div>'));
        return $this->display('login.dwt');
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        RC_Hook::do_action('ecjia_admin_logout_before');

        /* 清除记住密码 */
        (new \Ecjia\System\Admins\RememberPassword\RememberPassword())->delete();

        RC_Session::destroy();

        return $this->redirect(RC_Uri::url('@privilege/login'));
    }


    /**
     * 验证登录信息
     */
    public function signin()
    {
        try {
            // 登录时验证
            $validate_error = RC_Hook::apply_filters('admin_login_validate', $_POST);
            if (!empty($validate_error) && is_string($validate_error)) {
                return $this->showmessage($validate_error, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $username = remove_xss($this->request->input('username'));
            $password = remove_xss($this->request->input('password'));
            $remember = remove_xss($this->request->input('remember'));

            $model = AdminUserRepository::model()->where('user_name', $username)->first();

            if (empty($model)) {
                return $this->showmessage(__('您输入的帐号信息不正确。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $lock = new PasswordLock($model);

            //从数据库中的密码获取兼容驱动
            $pm = ecjia_password::autoCompatibleDriver($model->password);
            if (!$pm->verifySaltPassword($model->password, $password, $model->ec_salt)) {

                if ($lock->isLoginLock()) {
                    return $this->showmessage(sprintf(__('您登录失败的次数过多，请等%s秒后再进行尝试。'), $lock->getUnLockTime()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    RC_Hook::do_action('ecjia_admin_login_failed', $model);
                    //记录一次失败
                    $lock->failed();
                }

                return $this->showmessage(__('您输入的帐号信息不正确。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            RC_Hook::do_action('ecjia_admin_login_before', $model);

            if ($model->action_list == 'all') {
                $action_list = $model->action_list;
            } else {
                $action_list = (new AdminPurviewClass($model->user_id))->getPurviewInstance()->get();
            }

            $this->admin_session($model->user_id, $model->user_name, $action_list, $model->last_login);

            // 登录成功，清除密码错误锁定
            $lock->clearTimes();
            //有开启强制修改数据库32位非hash密码为64位hash密码
            if (config('login.force_hash_password')) {
                if (empty($model['ec_salt']) || !ecjia_password::isHashPassword($model->password)) {
                    $ec_salt         = rand(1, 9999);
                    $pm              = ecjia_password::driver('hash');
                    $new_possword    = $pm->createSaltPassword($password, $ec_salt);
                    $model->ec_salt  = $ec_salt;
                    $model->password = $new_possword;
                }
            }

            $model->last_login = RC_Time::gmtime();
            $model->last_ip    = RC_Ip::client_ip();
            $model->save();

            if (!empty($remember)) {
                (new \Ecjia\System\Admins\RememberPassword\RememberPassword)->remember($model->user_id, $model->password);
            }

            RC_Hook::do_action('ecjia_admin_login_after', $model);

            if (array_get($_SESSION, 'shop_guide')) {
                $back_url = RC_Uri::url('shopguide/admin/init');
            } else {
                $back_url = RC_Cookie::get('admin_login_referer');

                if ($back_url && !ecjia_compare_urls($back_url, RC_Uri::url('@privilege/login'))) {
                    RC_Cookie::delete('admin_login_referer');
                } else {
                    $back_url = RC_Uri::url('@index/init');
                }
            }

            return $this->showmessage(__('登录成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑个人资料
     */
    public function modif()
    {
        /* 不能编辑demo这个管理员 */
        if ($_SESSION['admin_name'] == 'demo') {
            $links = ecjia_alert_links([
                'text' => __('返回管理员列表'),
                'href' => RC_Uri::url('@admin_user/init')
            ]);
            return $this->showmessage(__('您不能对此管理员的权限进行任何操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_Script::enqueue_script('jquery-complexify', RC_Uri::admin_url() . '/statics/lib/complexify/jquery.complexify.min.js', array('jquery'), false, true);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑个人资料')));

        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台编辑个人资料页面，用户可在此编辑个人资料。') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:个人设置" target="_blank">关于编辑个人资料帮助文档</a>') . '</p>'
        );

        $user_info = AdminUserRepository::model()->find($_SESSION['admin_id'])->toArray();

        /* 模板赋值 */
        $this->assign('ur_here', __('编辑个人资料'));
        $this->assign('action_link', array('text' => __('管理员列表'), 'href' => RC_Uri::url('@admin_user/init')));
        $this->assign('form_action', RC_Uri::url('@privilege/update_self'));

        $this->assign('user', $user_info);

        return $this->display('privilege_info.dwt');
    }

    /**
     * 更新管理员信息
     */
    public function update_self()
    {
        try {
            $admin_id = intval($_SESSION['admin_id']);
            if (empty($admin_id)) {
                return $this->showmessage(__('非法操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $admin_email = remove_xss($this->request->input('email'));

            $model = AdminUserRepository::model()->find($admin_id);

            if (empty($model)) {
                return $this->showmessage(__('非法操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* Email地址是否有重复 */
            if ($admin_email && $admin_email != $model->email && AdminUserRepository::model()->where('email', $admin_email)->count()) {
                return $this->showmessage(sprintf(__('该Email地址 %s 已经存在！'), stripslashes($admin_email)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $new_password = remove_xss($this->request->input('new_password'));

            $model->email = $admin_email;

            if (empty($new_password)) {
                $msg = __('修改个人资料成功！');
            } else {
                /* 旧密与输入的密码比较是否相同 */
                $old_password = remove_xss($this->request->input('old_password'));
                $pm           = ecjia_password::autoCompatibleDriver($model->password);
                if (!$pm->verifySaltPassword($old_password, $model->ec_salt, $model->password)) {
                    return $this->showmessage(__('输入的旧密码错误！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                /* 比较新密码和确认密码是否相同 */
                if ($new_password != remove_xss($this->request->input('pwd_confirm'))) {
                    return $this->showmessage(__('两次输入的密码不一致！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $pm = ecjia_password::driver('hash');

                $ec_salt         = rand(1, 9999);
                $model->ec_salt  = $ec_salt;
                $model->password = $pm->createSaltPassword($new_password, $ec_salt);

                /* 如果修改密码，则需要将session中该管理员的数据清空 */
                RC_Session::session()->deleteSpecSession($_SESSION['admin_id'], 'admin'); // 删除session中该管理员的记录
                $msg = __('您已经成功的修改了密码，因此您必须重新登录！');
            }

            $model->save();

            /* 记录管理员操作 */
            ecjia_admin_log::instance()->add_object('admin_modif', __('个人资料'));
            ecjia_admin::admin_log($_SESSION['admin_name'], 'edit', 'admin_modif');

            /* 清除用户缓存 */
            RC_Cache::userdata_cache_delete('admin_navlist', $admin_id, true);

            return $this->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,
                (new PjaxShowMessageOption())->setPjaxurl(RC_Uri::url('@privilege/modif'))
            );
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

}