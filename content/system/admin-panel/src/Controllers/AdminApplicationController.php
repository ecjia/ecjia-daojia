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

use Ecjia\System\Admins\AdminMenu\HeaderMenuGroup;
use Ecjia\System\Admins\AdminMenu\SidebarMenuGroup;
use RC_App;
use RC_Script;
use RC_Style;
use RC_Uri;
use ecjia_admin;
use ecjia_app;
use ecjia_screen;
use ecjia;
use admin_nav_here;

/**
 * ECJIA 应用管理控制器
 */
class AdminApplicationController extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

        RC_Style::enqueue_style('jquery-stepy');

        RC_Script::enqueue_script('ecjia-admin');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-stepy');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-dataTables-bootstrap');
        RC_Script::enqueue_script('jquery-dataTables-sorting');

        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');

        // 下拉框css
        RC_Style::enqueue_style('chosen');
        //数字input框css
        RC_Style::enqueue_style('jquery-ui-aristo');
        // 下拉框插件
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('ecjia-admin_application');

        //js语言包调用
        RC_Script::localize_script('ecjia-admin_application', 'admin_application', config('system::jslang.application_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('应用管理'), RC_Uri::url('@admin_application/init')));
    }

    /**
     * 应用列表
     */
    public function init()
    {
        $this->admin_priv('application_manage', ecjia::MSGTYPE_JSON);

        if (!empty($_GET['reload'])) {
            RC_App::clean_applications_cache();
        }

        $useapplicationnum = intval($_GET['useapplicationnum']);

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('应用管理')));
        $this->assign('ur_here', __('应用管理'));

        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台应用管理页面，系统中所有的应用都会显示在此列表中。') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:应用管理" target="_blank">关于应用管理帮助文档</a>') . '</p>'
        );

        $active_applications = ecjia_app::active_applications();
        $croe_applications   = ecjia_app::core_applications();
        $croe_applications   = array_keys($croe_applications);

        /* 取得所有应用列表 */
        $applications = RC_App::get_apps();


        $application_num       = count($applications);
        $use_application_num   = 0;
        $unuse_application_num = 0;

        $applications = collect($applications)->map(function ($app, $key) use ($active_applications, $croe_applications, & $use_application_num, & $unuse_application_num) {
            if (in_array($key, $active_applications)) {
                $use_application_num++;
                $app['installed'] = true;
            } else {
                $use_application_num++;
                $app['installed'] = false;
            }

            if (in_array($app['alias'], $croe_applications)) {
                $app['is_core'] = true;
            } else {
                $app['is_core'] = false;
            }

            return $app;
        })->all();

        $use_list = $unuse_list = [];

        foreach ($applications as $key => $val) {
            if (!empty($val['installed'])) {
                $use_list[] = $applications[$key];
            }
            if (empty($val['installed'])) {
                $unuse_list[] = $applications[$key];
            }
        }

        $this->assign('application_num', $application_num);
        $this->assign('use_application_num', count($use_list));
        $this->assign('unuse_application_num', count($unuse_list));
        if ($useapplicationnum == '1') {
            $this->assign('applications', $use_list);
        } elseif ($useapplicationnum == '2') {
            $this->assign('applications', $unuse_list);
        } else {
            $this->assign('applications', $applications);
        }

        return $this->display('application_list.dwt');
    }


    public function clear_cache()
    {
        try {
            RC_App::clean_applications_cache();
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }


    /**
     * 查看应用
     */
    public function detail()
    {
        $this->admin_priv('application_manage', ecjia::MSGTYPE_JSON);

        $id = trim($_GET['id']);

        $app_dir = ecjia_app::get_app_dir($id);
        $result  = ecjia_app::validate_application($app_dir);
        if (is_ecjia_error($result)) {
            //@todo 报错
        }

        $package = RC_App::get_app_package($app_dir);

        if (isset($_GET['step']) && $_GET['step'] == 'install') {
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('应用安装')));
            $this->assign('ur_here', __('应用安装'));
            $this->assign('is_install', true);
        } else {
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('应用详情')));
            $this->assign('ur_here', __('应用详情'));
            $this->assign('action_link', array('href' => RC_Uri::url('@admin_application/init'), 'text' => __('返回应用列表')));
        }
        $this->assign('application', $package);

        return $this->display('application_detail.dwt');
    }

    /**
     * 安装应用
     */
    public function install()
    {
        $this->admin_priv('application_install', ecjia::MSGTYPE_JSON);

        $id = $_GET['id'];

        try {
            $result = ecjia_app::install_application($id);

            if (is_ecjia_error($result)) {
                if ('unexpected_output' == $result->get_error_code()) {
                    return $this->showmessage($result->get_error_data(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }

            $app_dir = ecjia_app::get_app_dir($id);
            $package = RC_App::get_app_package($app_dir);

            /* 清除缓存 */
            (new HeaderMenuGroup())->cleanMenuCache();
            (new SidebarMenuGroup())->cleanMenuCache();

            /* 记录日志 */
            ecjia_admin::admin_log($package['format_name'], 'install', 'app');

            return $this->showmessage(sprintf(__('%s 应用安装成功'), $package['format_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 卸载应用
     */
    public function uninstall()
    {
        $this->admin_priv('application_uninstall', ecjia::MSGTYPE_JSON);

        $id = $_GET['id'];

        try {
            $result = ecjia_app::uninstall_application($id);

            if (is_ecjia_error($result)) {
                if ('unexpected_output' == $result->get_error_code()) {
                    return $this->showmessage($result->get_error_data(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }

            $app_dir = ecjia_app::get_app_dir($id);
            $package = RC_App::get_app_package($app_dir);
            /* 记录日志 */
            ecjia_admin::admin_log($package['format_name'], 'uninstall', 'app');

            return $this->showmessage(sprintf(__('%s 应用卸载成功'), $package['format_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@admin_application/init')));
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

}

// end