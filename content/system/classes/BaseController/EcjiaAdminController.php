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
namespace Ecjia\System\BaseController;

use admin_menu;
use admin_nav_here;
use ecjia;
use Ecjia\Component\BrowserEvent\PageEventManager;
use Ecjia\Component\BrowserEvent\PageScriptPrint;
use Ecjia\Component\Contracts\EcjiaTemplateFileLoader;
use Ecjia\System\Admins\AdminPrivilege\AdminPrivilege;
use Ecjia\System\Admins\Users\AdminUserSession;
use Ecjia\System\Models\AdminLogModel;
use ecjia_admin_log;
use ecjia_app;
use ecjia_config;
use ecjia_editor;
use ecjia_notification;
use ecjia_screen;
use ecjia_view;
use RC_Config;
use RC_ENV;
use RC_File;
use RC_Hook;
use RC_Ip;
use RC_Loader;
use RC_Plugin;
use RC_Script;
use RC_Session;
use RC_Style;
use RC_Time;
use Smarty;

/**
 * Class EcjiaAdminController
 * @package Ecjia\System\BaseController
 */
abstract class EcjiaAdminController extends EcjiaController implements EcjiaTemplateFileLoader
{

    /**
     * 模板视图对象静态属性
     *
     * @var \ecjia_view
     */
//    public static $view_object;

    /**
     * 控制器对象静态属性
     * @var \Ecjia\System\BaseController\EcjiaAdminController
     */
    public static $controller;

    /**
     * @var PageEventManager
     */
    protected $page_event;

    public function __construct()
    {
        //定义在后台
        define('IN_ADMIN', true);

        parent::__construct();

        self::$controller  = static::$controller;
        self::$view_object = static::$view_object;

        /* 新加载全局方法 */
        RC_Loader::load_sys_func('global');

        RC_Loader::load_sys_func('general_template');

        // Clears file status cache
        clearstatcache();

        // Catch plugins that include admin-header.php before admin.php completes.
        if (empty(ecjia_screen::$current_screen)) {
            ecjia_screen::set_current_screen();
        }

        RC_Hook::add_action('admin_print_main_header', array(ecjia_screen::$current_screen, 'render_screen_meta'));

        $this->public_route = RC_Hook::apply_filters('admin_access_public_route', config('system::public_route'));

        $this->middleware(config('system::middlewares'));

//		// 判断用户是否登录
//		if (!$this->_check_login()) {
//		    RC_Session::destroy();
//		    if (is_pjax()) {
//		        ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('系统提示')));
//		        $response = $this->showmessage(__('对不起,您没有执行此项操作的权限!'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('重新登录'), 'href' => RC_Uri::url('@privilege/login')))));
//		        royalcms('response')->send();
//		        exit();
//		    } elseif (is_ajax()) {
//		        $this->showmessage(__('对不起,您没有执行此项操作的权限!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//                royalcms('response')->send();
//                exit();
//		    } else {
//
//		        RC_Cookie::set('admin_login_referer', RC_Uri::current_url());
//                $this->redirectWithExited(RC_Uri::url('@privilege/login'));
//		    }
//		}

        $this->load_default_script_style();

        $this->assign('ecjia_admin_cptitle', RC_Hook::apply_filters('ecjia_admin_cptitle', __('ECJIA 管理面板')));
        $this->assign('ecjia_admin_cpname', RC_Hook::apply_filters('ecjia_admin_cpname', 'ECJia Admin <span class="sml_t">' . VERSION . '</span>'));
        $this->assign('admin_message_is_show', RC_Hook::apply_filters('ecjia_admin_message_show', true));
        $this->assign('ecjia_config', ecjia::config());

        /* 判断是否支持 Gzip 模式 */
        if (RC_Config::get('system.gzip') && RC_ENV::gzip_enabled()) {
            ob_start('ob_gzhandler');
        } else {
            ob_start();
        }

        RC_Hook::add_action('admin_enqueue_scripts', function () {
            $this->csrf_token_meta();
        });

        $this->page_event = new PageEventManager($this->getRouteController());

        RC_Hook::do_action('ecjia_admin_finish_launching');
    }

    protected function registerServiceProvider()
    {
        royalcms()->register('Royalcms\Component\Purifier\PurifierServiceProvider');
        royalcms()->register('Ecjia\System\Providers\EcjiaAdminServiceProvider');
    }

    protected function session_start()
    {
        RC_Hook::add_filter('royalcms_session_name', function ($sessin_name) {
            return RC_Config::get('session.session_admin_name');
        });

        RC_Hook::add_filter('royalcms_session_id', function ($sessin_id) {
            return RC_Hook::apply_filters('ecjia_admin_session_id', $sessin_id);
        });

        RC_Session::start();
    }

    public function create_view()
    {
        $view = new ecjia_view($this);

        $view->setTemplateDir(royalcms()->systemPath('templates' . DIRECTORY_SEPARATOR));
        if (!in_array($this->get_template_dir(), $view->getTemplateDir())) {
            $view->addTemplateDir($this->get_template_dir());
        }
        $view->setCompileDir(storage_path('template/compiled/' . 'admin' . DIRECTORY_SEPARATOR));

        if (RC_Config::get('system.debug')) {
            $view->caching       = Smarty::CACHING_OFF;
            $view->debugging     = true;
            $view->force_compile = true;
        } else {
            $view->caching       = Smarty::CACHING_OFF;
            $view->debugging     = false;
            $view->force_compile = false;
        }

        $view = RC_Hook::apply_filters('create_admin_view', $view);
        return $view;
    }

    /**
     * 登录session授权
     */
    public function authSession()
    {
        /* 验证管理员身份 */
        if (session('session_user_id') && session('session_user_type') == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 添加crsf_token头信息
     */
    protected function csrf_token_meta()
    {
        echo '<meta name="csrf-token" content="' . csrf_token() . '">';
    }

//	/**
//	 * 后台判断是否登录
//	 */
//	private function _check_login()
//    {
//        /* 验证公开路由 */
//		if ($this->isVerificationPublicRoute()) {
//		    return true;
//		}
//
//		/* 验证管理员身份 */
//		if ($this->authSession()) {
//		    return true;
//		}
//
//        return (new \Ecjia\System\Admins\RememberPassword\RememberPassword)->verification(function($model) {
//            $this->admin_session($model['user_id'], $model['user_name'], $model['action_list'], $model['last_time']);
//
//            $model->last_login = RC_Time::gmtime();
//            $model->last_ip = RC_Ip::client_ip();
//            $model->save();
//        });
//	}

    /**
     * 获得后台模板目录
     * @return string
     */
    public function get_template_dir()
    {
        if (ROUTE_M != RC_Config::get('system.admin_entrance') && ROUTE_M != 'system') {
            if (RC_Loader::exists_site_app(ROUTE_M)) {
                $dir = SITE_APP_PATH . ROUTE_M . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;
            } else {
                $dir = RC_APP_PATH . ROUTE_M . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;
            }
        } else {
            $dir = SITE_SYSTEM_PATH . 'templates' . DIRECTORY_SEPARATOR;
        }

        return $dir;
    }

    /**
     * 获得后台模版文件
     */
    public function get_template_file($file)
    {
        // 判断是否使用绝对路径的模板文件
        if (strpos($file, '/') !== 0 && strpos($file, ":\\") !== 1) {
            $file = $this->get_template_dir() . $file;
        }

        // 添加模板后缀
        if (!preg_match('@\.[a-z]+$@', $file)) {
            $file .= RC_Config::get('system.tpl_fix');
        }

        // 将目录全部转为小写
        if (is_file($file)) {
            return $file;
        } else {
            return str_replace($this->get_template_dir(), '', $file);
        }
    }

    /**
     * 加载后台模板
     * @param string $file 文件名 格式：file or file/file
     */
    public final function display($tpl_file = null, $cache_id = null, $show = true, $options = array())
    {
        $this->loadPageScript($this->page_event);

        if (strpos($tpl_file, 'string:') !== 0) {
            if (RC_File::file_suffix($tpl_file) !== 'php') {
                $tpl_file = $tpl_file . '.php';
            }
        }
        return parent::display($tpl_file, $cache_id, $show, $options);
    }

    /**
     * 捕获输出为变量
     * @param string $file 文件名 格式：file or file/file
     */
    public final function fetch($tpl_file = null, $cache_id = null, $options = array())
    {
        $this->loadPageScript($this->page_event);

        if (strpos($tpl_file, 'string:') !== 0) {
            if (RC_File::file_suffix($tpl_file) !== 'php') {
                $tpl_file = $tpl_file . '.php';
            }
        }
        return parent::fetch($tpl_file, $cache_id, $options);
    }

    /**
     * 信息提示
     *
     * @param string $msg 提示内容
     * @param string $url 跳转URL
     * @param int $time 跳转时间
     * @param null $tpl 模板文件
     */
    protected function message($msg = '操作成功', $url = null, $time = 2, $tpl = null)
    {
        $revise_url = $url ? "window.location.href='" . $url . "'" : "window.history.back(-1);";
        $system_tpl = SITE_SYSTEM_PATH . 'templates' . DIRECTORY_SEPARATOR . RC_Config::get('system.tpl_message');

        if ($tpl) {
            $this->assign(array(
                'msg'  => $msg,
                'url'  => $revise_url,
                'time' => $time
            ));
            $tpl = SITE_SYSTEM_PATH . 'templates' . DIRECTORY_SEPARATOR . $tpl;
            return $this->display($tpl);
        } elseif (file_exists($system_tpl)) {
            $this->assign(array(
                'msg'  => $msg,
                'url'  => $revise_url,
                'time' => $time
            ));
            return $this->display($system_tpl);
        } else {
            return parent::message($msg, $url, $time, $tpl);
        }
    }

    /**
     * 设置管理员的session内容
     *
     * @access  public
     * @param integer $user_id 管理员编号
     * @param string $user_name 管理员姓名
     * @param string $action_list 权限列表
     * @param string $last_time 最后登录时间
     * @return  void
     */
    public function admin_session($user_id, $username, $action_list, $last_time, $email = '')
    {
// 		$_SESSION['admin_id']    		= $user_id;
// 		$_SESSION['admin_name']  		= $username;
// 		$_SESSION['action_list'] 		= $action_list;
// 		$_SESSION['last_check_order']  	= $last_time; 

//		RC_Session::set('admin_id', $user_id);
//		RC_Session::set('admin_name', $username);
//		RC_Session::set('action_list', $action_list);
//		RC_Session::set('last_check_order', $last_time); // 用于保存最后一次检查订单的时间
//		RC_Session::set('session_user_id', $user_id);
//		RC_Session::set('session_user_type', 'admin');
//		RC_Session::set('email', $email);
//		RC_Session::set('ip', RC_Ip::client_ip());

        (new AdminUserSession())
            ->setAdminId($user_id)
            ->setAdminName($username)
            ->setActionList($action_list)
            ->setLastCheckTime($last_time) // 用于保存最后一次检查订单的时间
            ->setAdminEmail($email)
            ->createLoginSession();

    }

    /**
     * 生成admin_menu对象
     */
    public static function make_admin_menu($action, $name, $link, $sort = 99, $target = '_self')
    {
        return new admin_menu($action, $name, $link, $sort, $target);
    }

    /**
     * 判断管理员对某一个操作是否有权限。
     *
     * 根据当前对应的action_code，然后再和用户session里面的action_list做匹配，以此来决定是否可以继续执行。
     * @param string $priv_str 操作对应的priv_str
     * @param string $msg_type 返回的类型 html,json
     * @return true/false
     */
    public final function admin_priv($priv_str, $msg_type = ecjia::MSGTYPE_HTML, $msg_output = true)
    {
        if (AdminPrivilege::singleton()->isChecked($priv_str)) {
            return true;
        } else {
            if ($msg_output) {
                if ($msg_type == ecjia::MSGTYPE_JSON && is_ajax() && !is_pjax()) {
                    $this->showmessage(__('对不起，您没有执行此项操作的权限！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    //没有权限，强制中断响应
                    royalcms('response')->send();
                    die();
                } else {
                    ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('系统提示')));
                    $this->showmessage(__('对不起，您没有执行此项操作的权限！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
                    //没有权限，强制中断响应
                    royalcms('response')->send();
                    die();
                }
            } else {
                return false;
            }
        }
    }

    public final function load_default_script_style()
    {
        // 加载样式
        // Bootstrap framework
        RC_Style::enqueue_style('bootstrap');
        //响应式css
        RC_Style::enqueue_style('bootstrap-responsive');
        // tooltips 面包导航等
        RC_Style::enqueue_style('jquery-jBreadCrumb');
        // flags
        RC_Style::enqueue_style('flags');
        // 图标css
        RC_Style::enqueue_style('fontello');

        // ecjia css
        RC_Style::enqueue_style('ecjia');
        RC_Style::enqueue_style('ecjia-ui');
        // ecjia function
        RC_Style::enqueue_style('ecjia-function');
        //ecjia skin
        RC_Style::enqueue_style('ecjia-skin-blue');
        RC_Style::enqueue_style('jquery-sticky');


        // 加载脚本
        RC_Script::enqueue_script('ecjia');
        // jquery
        RC_Script::enqueue_script('jquery-migrate');
        // touch events for jquery ui
        RC_Script::enqueue_script('jquery-ui-touchpunch');
        // jquery pjax
        RC_Script::enqueue_script('jquery-pjax');
        // js cookie plugin
        RC_Script::enqueue_script('jquery-cookie');
        RC_Script::enqueue_script('js-json');
        // hidden elements width/height
        RC_Script::enqueue_script('jquery-actual');
        RC_Script::enqueue_script('jquery-sticky');
        RC_Script::enqueue_script('bootstrap');
        // to top 右侧跳到顶部
        RC_Script::enqueue_script('jquery-ui-totop');
        // scroll 处理触摸事件
// 		RC_Script::enqueue_script('nicescroll');

        RC_Script::enqueue_script('ecjia-admin');
        RC_Script::enqueue_script('ecjia-ui');
        RC_Script::enqueue_script('jquery-quicksearch');

        //js语言包调用
        RC_Script::localize_script('ecjia-admin', 'admin_lang', config('system::jslang.admin_default_page'));
    }


    protected function load_hooks()
    {
        RC_Hook::add_action('admin_head', array('ecjia_loader', 'admin_enqueue_scripts'), 1);
        RC_Hook::add_action('admin_print_scripts', array('ecjia_loader', 'print_head_scripts'), 20);
        RC_Hook::add_action('admin_print_footer_scripts', array('ecjia_loader', 'print_admin_footer_scripts'));
        RC_Hook::add_action('admin_print_styles', array('ecjia_loader', 'print_head_styles'), 20);


        RC_Hook::add_action('admin_print_footer_scripts', array(ecjia_notification::make(), 'printScript'));

        //editor loading
        RC_Hook::add_action('editor_setting_first_init', function () {
            if (is_pjax()) {
                RC_Hook::add_action('admin_pjax_footer', array(ecjia_editor::editor_instance(), 'editor_js'), 50);
                RC_Hook::add_action('admin_pjax_footer', array(ecjia_editor::editor_instance(), 'enqueue_scripts'), 1);
            } else {
                RC_Hook::add_action('admin_footer', array(ecjia_editor::editor_instance(), 'editor_js'), 50);
                RC_Hook::add_action('admin_footer', array(ecjia_editor::editor_instance(), 'enqueue_scripts'), 1);
            }
        });

        RC_Loader::load_sys_class('hooks.admin_system', false);

        $system_plugins = ecjia_config::instance()->get_addon_config('system_plugins', true);
        if (is_array($system_plugins)) {
            foreach ($system_plugins as $plugin_file) {
                RC_Plugin::load_files($plugin_file);
            }
        }

        $apps = ecjia_app::installed_app_floders();

        collect($apps)->map(function ($app) {
            //loading hooks
            RC_Loader::load_app_class('hooks.admin_' . $app, $app, false);

            //loading subscriber
            $bundle = royalcms('app')->driver($app);
            $class  = $bundle->getNamespace() . '\Subscribers\AdminHookSubscriber';
            if (class_exists($class)) {
                royalcms('Royalcms\Component\Hook\Dispatcher')->subscribe($class);
            }
        });

    }


    /**
     * 记录管理员的操作内容
     *
     * @access  public
     * @param string $sn 数据的唯一值
     * @param string $action 操作的类型
     * @param string $content 操作的内容
     * @return  void
     */
    public final static function admin_log($sn, $action, $content)
    {
        $log_info = ecjia_admin_log::instance()->get_message($sn, $action, $content);

        $data = array(
            'log_time'   => RC_Time::gmtime(),
            'user_id'    => $_SESSION['admin_id'],
            'log_info'   => stripslashes($log_info),
            'ip_address' => RC_Ip::client_ip(),
        );

        AdminLogModel::insert($data);
    }


    /**
     * 获取当前管理员信息
     *
     * @return  array|bool
     */
    public final static function admin_info()
    {
        $db         = RC_Loader::load_model('admin_user_model');
        $admin_info = $db->find(array('user_id' => intval($_SESSION['admin_id'])));
        if (!empty($admin_info)) {
            return $admin_info;
        }
        return false;
    }

    public static function is_super_admin()
    {

    }


    public static function is_sidebar_hidden()
    {
        $sidebar_display = ecjia_screen::get_current_screen()->get_sidebar_display();
        $ecjia_sidebar   = royalcms('request')->cookie('ecjia_sidebar');

        if ($sidebar_display === false || $ecjia_sidebar == 'hidden') {
            return true;
        } else {
            return false;
        }
    }

    public function loadPageScript($page)
    {
        $print = new PageScriptPrint($page);
        RC_Hook::add_action( 'admin_print_footer_scripts',	array($print, 'printFooterScripts'), 30 );
        RC_Hook::add_action( 'admin_pjax_footer',	array($print, 'printFooterScripts'), 30 );
    }

    /**
     * @return PageEventManager
     */
    public function getPageEvent(): PageEventManager
    {
        return $this->page_event;
    }

}

// end