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
namespace Ecjia\App\Platform\Frameworks;

use ecjia;
use ecjia_base;
use ecjia_template_fileloader;
use ecjia_update_cache;
use ecjia_admin_menu;
use ecjia_view;
use ecjia_notification;
use ecjia_config;
use ecjia_app;
use admin_nav_here;
use admin_menu;
use ecjia_admin_log;

use RC_Loader;
use RC_Lang;
use RC_Config;
use RC_Hook;
use RC_Session;
use RC_Cookie;
use RC_Script;
use RC_Style;
use RC_App;
use RC_Api;
use RC_Package;
use RC_Plugin;
use RC_Uri;
use RC_File;
use RC_Ip;
use RC_Time;
use RC_DB;
use Smarty;

use Ecjia\App\Platform\Frameworks\Component\Screen;
use Ecjia\App\Platform\Frameworks\Component\Loader;
use Ecjia\App\Platform\Frameworks\Component\Menu;
use Ecjia\App\Platform\Frameworks\Platform\Account;

//定义在后台
define('IN_PLATFORM', true);

abstract class EcjiaPlatform extends ecjia_base implements ecjia_template_fileloader {

	private $public_route;
	
	/**
	 * 
	 * @var \Ecjia\App\Platform\Frameworks\Platform\Account $platformAccount
	 */
	protected $platformAccount;
	
	/**
	 * @var \Ecjia\System\Frameworks\Contracts\ShopInterface
	 */
	protected $currentStore;
	
	/**
	 * 
	 * @var \Ecjia\System\Frameworks\Contracts\UserInterface
	 */
	protected $currentUser;

	public function __construct() {
		parent::__construct();

		self::$controller = static::$controller;
		self::$view_object = static::$view_object;

		if (defined('DEBUG_MODE') == false) {
		    define('DEBUG_MODE', 2);
		}

		/* 新加载全局方法 */
		RC_Loader::load_sys_func('global');

		RC_Loader::load_sys_func('general_template');

		// Clears file status cache
		clearstatcache();

		// Catch plugins that include admin-header.php before admin.php completes.
		if ( empty( Screen::$current_screen ) ) {
		    Screen::set_current_screen();
		}

		RC_Hook::add_action('platform_print_main_header', array(Screen::$current_screen, 'render_screen_meta'));

		$this->public_route = array(
			'platform/privilege/autologin',
		);
		$this->public_route = RC_Hook::apply_filters('platform_access_public_route', $this->public_route);

		// 判断用户是否登录
		if (!$this->_check_login()) {
		    RC_Session::destroy();
		    if (is_pjax()) {
		        Screen::$current_screen->add_nav_here(new admin_nav_here(__('系统提示')));
		        $this->showmessage(RC_Lang::get('system::system.priv_error'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('重新登录'), 'href' => RC_Uri::url('staff/privilege/login')))));
                royalcms('response')->send();
		        exit();
		    } elseif (is_ajax()) {
		        $this->showmessage(RC_Lang::get('system::system.priv_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                royalcms('response')->send();
		        exit();
		    } else {
		        $this->redirect(RC_Uri::url('@privilege/login'));
                royalcms('response')->send();
		        exit();
		    }
		}

		if (RC_Config::get('system.debug')) {
			error_reporting(E_ALL);
		} else {
			error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		}
		
		$rc_script = RC_Script::instance();
		$rc_style = RC_Style::instance();
		Loader::default_scripts($rc_script);
		Loader::default_styles($rc_style);

		$this->load_cachekey();

		$this->load_default_script_style();
		
		
		$this->assign('ecjia_main_static_url', $this->get_main_static_url());
		$this->assign('ecjia_system_static_url', RC_Uri::system_static_url() . '/');
		
		RC_Hook::do_action('ecjia_platform_finish_launching');
	}
	
	public function getPlatformAccount()
    {
        return $this->platformAccount;
    }

    public function getCurrentPlatform()
    {
        return $this->platformAccount->getPlatform();
    }

	protected function session_start()
	{
	    RC_Hook::add_filter('royalcms_session_name', function ($sessin_name) {
	        return RC_Config::get('session.session_platform_name');
	    });

        RC_Hook::add_filter('royalcms_session_id', function ($sessin_id) {
            return RC_Hook::apply_filters('ecjia_platform_session_id', '');
        });

        RC_Session::start();
	}

	public function create_view() {
	    $view = new ecjia_view($this);

	    $view->setTemplateDir($this->get_main_template_dir());
	    if (!in_array($this->get_template_dir(), $view->getTemplateDir())) {
	        $view->addTemplateDir($this->get_template_dir());
	    }
	    $view->setCompileDir(TEMPLATE_COMPILE_PATH . 'platform' . DIRECTORY_SEPARATOR);

	    if (RC_Config::get('system.debug')) {
	        $view->caching = Smarty::CACHING_OFF;
	        $view->debugging = true;
	        $view->force_compile = true;
	    } else {
	        $view->caching = Smarty::CACHING_OFF;
	        $view->debugging = false;
	        $view->force_compile = false;
	    }

	    return $view;
	}
	
	public function get_main_template_dir() {
	    if (RC_Loader::exists_site_app('platform')) {
	        $dir = SITE_APP_PATH . 'platform' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'platform' . DIRECTORY_SEPARATOR;
	    } else {
	        $dir = RC_APP_PATH . 'platform' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'platform' . DIRECTORY_SEPARATOR;
	    }
	    
	    return $dir;
	}
	
	public function get_main_static_dir() {
	    if (RC_Loader::exists_site_app('platform')) {
	        $dir = SITE_APP_PATH . 'platform' . DIRECTORY_SEPARATOR . 'statics' . DIRECTORY_SEPARATOR;
	    } else {
	        $dir = RC_APP_PATH . 'platform' . DIRECTORY_SEPARATOR . 'statics' . DIRECTORY_SEPARATOR;
	    }
	     
	    return $dir;
	}
	
	public function get_main_static_url() {
	    return dirname(dirname(RC_App::app_dir_url(__FILE__))) . '/statics/';
	}
	
	/**
	 * 获得商家后台模板目录
	 * @return string
	 */
	public function get_template_dir()
	{
        if (RC_Loader::exists_site_app(ROUTE_M)) {
            $dir = SITE_APP_PATH . ROUTE_M . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'platform' . DIRECTORY_SEPARATOR;
        } else {
            $dir = RC_APP_PATH . ROUTE_M . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'platform' . DIRECTORY_SEPARATOR;
        }

        return $dir;
	}
	
	/**
	 * 获得商家后台模版文件
	 */
	public function get_template_file($file)
	{
	    // 判断是否使用绝对路径的模板文件
	    if (strpos($file, '/') !== 0 && strpos($file, ":\\") !== 1) {
	        $file = $this->get_template_dir() . $file;
	    }
	
	    // 添加模板后缀
	    if (! preg_match('@\.[a-z]+$@', $file)) {
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
	 * 加载缓存key
	 */
	protected function load_cachekey() {
	    $res = RC_Api::api('system', 'system_cache');
	    if (! empty($res)) {
	        foreach ($res as $cache_handle) {
	            ecjia_update_cache::make()->register($cache_handle->getCode(), $cache_handle);
	        }
	    }
	}

	/**
	 * 后台判断是否登录
	 */
	private function _check_login() {
		$route_controller = ROUTE_M . '/' . ROUTE_C . '/' . ROUTE_A;
		if (in_array($route_controller, $this->public_route)) {
		    return true;
		}

		/* 验证管理员身份 */
		if (session('session_user_id') > 0 && 
		    (session('session_user_type') == 'admin' || session('session_user_type') == 'merchant')) {
			
			if (session('uuid')) {
				$this->platformAccount = new Account(session('uuid'));
				$this->assign('platformAccount', $this->platformAccount);
			
				if (session('store_id') == $this->platformAccount->getStoreId()) {
					if (session('session_user_type') == 'admin') {
						$this->currentStore = new \Ecjia\System\Admins\Stores\AdminShop(session('store_id'));
					} else if (session('session_user_type') == 'merchant') {
						$this->currentStore = new \Ecjia\App\Merchant\Frameworks\Stores\MerchantShop(session('store_id'));
					}
					$this->assign('currentStore', $this->currentStore);

                    $this->assign('ecjia_platform_cptitle', sprintf("%s的%s", $this->currentStore->getStoreName(), $this->platformAccount->getAccountName()));
				} else {
                    return false;
                }
			} else {
				$this->assign('ecjia_platform_cptitle', '公众平台');
			}
			
			if (session('session_user_id') && session('session_user_type')) {
				if (session('session_user_type') == 'admin') {
					$this->currentUser = new \Ecjia\System\Admins\Users\AdminUser(session('session_user_id'), '\Ecjia\App\Platform\Frameworks\Users\AdminUserAllotPurview');
				} else if (session('session_user_type') == 'merchant') {
					$this->currentUser = new \Ecjia\App\Merchant\Frameworks\Users\StaffUser(session('session_user_id'), $this->platformAccount->getStoreId(), '\Ecjia\App\Platform\Frameworks\Users\StaffUserAllotPurview');
				}
				$this->assign('currentUser', $this->currentUser);
			}
			
		    return true;
		}
	}

	/**
	 * 加载后台模板
	 * @param string $file 文件名 格式：file or file/file
	 */
	public final function display($tpl_file = null, $cache_id = null, $show = true, $options = array()) {
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
	public final function fetch($tpl_file = null, $cache_id = null, $options = array()) {
	    if (strpos($tpl_file, 'string:') !== 0) {
	        if (RC_File::file_suffix($tpl_file) !== 'php') {
	            $tpl_file = $tpl_file . '.php';
	        }
	    }
		return parent::fetch($tpl_file, $cache_id, $options);
	}

	/**
	 * 直接跳转
	 *
	 * @param string $url
	 * @param int $code
	 */
	public function redirect($url, $code = 302) {
	    parent::redirect($url, $code);
	}

	/**
	 * 信息提示
	 *
	 * @param string $msg
	 *            提示内容
	 * @param string $url
	 *            跳转URL
	 * @param int $time
	 *            跳转时间
	 * @param null $tpl
	 *            模板文件
	 */
	protected function message($msg = '操作成功', $url = null, $time = 2, $tpl = null)
	{
	    $url = $url ? "window.location.href='" . $url . "'" : "window.history.back(-1);";
	    $system_tpl = $this->get_main_template_dir() . RC_Config::get('system.tpl_message');

// 	    switch ($state) {
// 	    	case 1:
// 	    		$this->assign('page_state', array('icon' => 'glyphicon glyphicon-ok-sign', 'msg' => __('操作成功'), 'class' => 'ecjiafc-blue'));
// 	    		break;
// 	    	case 2:
// 	    		$this->assign('page_state', array('icon' => 'glyphicon glyphicon-info-sign', 'msg' => __('操作提示'), 'class' => 'ecjiafc-blue'));
// 	    		break;
// 	    	case 3:
// 	    		$this->assign('page_state', array('icon' => 'glyphicon glyphicon-exclamation-sign', 'msg' => __('操作警告'), 'class' => ''));
// 	    		break;
// 	    	default:
	    		$this->assign('page_state', array('icon' => 'ft-x-circle', 'msg' => __('操作错误'), 'class' => 'ecjiafc-red'));
// 	    }   

        if (file_exists($system_tpl)) {
	        $this->assign(array(
	            'msg' => $msg,
	            'url' => $url,
	            'time' => $time
	        ));
	        $this->display($system_tpl);
	    } else {
	        return parent::message($msg, $url, $time, $tpl);
	    }

	}

	/**
	 * 设置管理员的session内容
	 *
	 * @access  public
	 * @param   integer $store_id       店铺id
	 * @param   string  $merchants_name 店铺名称
	 * @param   integer $user_id        管理员编号
	 * @param   integer $mobile         管理员手机号
	 * @param   string  $username       管理员姓名
	 * @param   string  $action_list    权限列表
	 * @param   string  $last_time      最后登录时间
	 * @return  void
	 */
	public function admin_session($uuid, $store_id, $user_id, $user_type, $user_name, $action_list, $last_time, $email = '') 
	{
	    RC_Session::set('uuid', $uuid); 
	    RC_Session::set('store_id', $store_id);
		RC_Session::set('action_list', $action_list);
		RC_Session::set('session_user_id', $user_id);
		RC_Session::set('session_user_type', $user_type);
		RC_Session::set('session_user_name', $user_name);
		RC_Session::set('email', $email);
		RC_Session::set('ip', RC_Ip::client_ip());
	}

	/**
	 * 判断管理员对某一个操作是否有权限。
	 *
	 * 根据当前对应的action_code，然后再和用户session里面的action_list做匹配，以此来决定是否可以继续执行。
	 * @param     string    $priv_str    操作对应的priv_str
	 * @param     string    $msg_type    返回的类型 html,json
	 * @return true/false
	 */
	public final function admin_priv($priv_str, $msg_type = ecjia::MSGTYPE_HTML , $msg_output = true) {
		if (Menu::singleton()->admin_priv($priv_str)) {
		    return true;
		} else {
		    if ($msg_output) {
		        if ($msg_type == ecjia::MSGTYPE_JSON && is_ajax() && !is_pjax()) {
		            $this->showmessage(__('对不起，您没有执行此项操作的权限！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    royalcms('response')->send();
		            die();
		        } else {
		            Screen::$current_screen->add_nav_here(new admin_nav_here(__('系统提示')));
		            $this->showmessage(__('对不起，您没有执行此项操作的权限！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
                    royalcms('response')->send();
                    die();
		        }
		    } else {
		        return false;
		    }
		}
	}

	public final function load_default_script_style() {
	    // 加载样式

	    // RC_Style::enqueue_style('ecjia-platform-googleapis');
	    RC_Style::enqueue_style('ecjia-platform-vendors');
	    RC_Style::enqueue_style('ecjia-platform-jquery-jvectormap');
	    RC_Style::enqueue_style('ecjia-platform-morris');
	    RC_Style::enqueue_style('ecjia-platform-unslider');
	    RC_Style::enqueue_style('ecjia-platform-climacons');
	    RC_Style::enqueue_style('ecjia-platform-app');
	    
	    RC_Style::enqueue_style('ecjia-platform-function');
	    
	    RC_Style::enqueue_style('ecjia-platform-vertical-content-menu');
	    RC_Style::enqueue_style('ecjia-platform-palette-gradient');
	    RC_Style::enqueue_style('ecjia-platform-clndr');
	    RC_Style::enqueue_style('ecjia-platform-palette-climacon');
	    RC_Style::enqueue_style('ecjia-platform-users');
	    RC_Style::enqueue_style('ecjia-platform-select');
	    
	    RC_Script::enqueue_script('jquery');
	    RC_Script::enqueue_script('jquery-ui-totop');

        RC_Style::enqueue_style('ecjia-platform-ui');

        // JS脚本
	    
	    RC_Script::enqueue_script('ecjia-platform-vendors');
	    RC_Script::enqueue_script('ecjia-platform-jquery-pjax');
	    
	    RC_Script::enqueue_script('ecjia-platform-jquery-sticky');
	    RC_Script::enqueue_script('ecjia-platform-headroom');
	    RC_Script::enqueue_script('ecjia-platform-jquery-knob');
	    RC_Script::enqueue_script('ecjia-platform-knob');
	    
	    RC_Script::enqueue_script('ecjia-platform-raphael');
	    RC_Script::enqueue_script('ecjia-platform-morris');
	    
	    RC_Script::enqueue_script('ecjia-platform-jquery-jvectormap');
	    RC_Script::enqueue_script('ecjia-platform-jquery-jvectormap-world');
	    RC_Script::enqueue_script('ecjia-platform-visitor-data');
	    RC_Script::enqueue_script('ecjia-platform-chart');
	    RC_Script::enqueue_script('ecjia-platform-jquery-sparkline');
	    RC_Script::enqueue_script('ecjia-platform-unslider');
	    RC_Script::enqueue_script('ecjia-platform-app-menu');
	    RC_Script::enqueue_script('ecjia-platform-app');
	    RC_Script::enqueue_script('ecjia-platform-customizer');
	    RC_Script::enqueue_script('ecjia-platform-breadcrumbs-with-stats');
	    RC_Script::enqueue_script('ecjia-platform-dashboard-analytics');
	    RC_Script::enqueue_script('ecjia-platform-components-modal');
	    RC_Script::enqueue_script('ecjia-platform-jquery-migrate');
	    RC_Script::enqueue_script('ecjia-platform-jquery-quicksearch');
	    RC_Script::enqueue_script('ecjia-platform-select-full');
	    RC_Script::enqueue_script('ecjia-platform-form-select');
	    
	    RC_Script::enqueue_script('ecjia-platform-sweetalert');
	    RC_Script::enqueue_script('ecjia-platform-sweet');
	    
	    RC_Script::enqueue_script('ecjia-platform');
	    RC_Script::enqueue_script('ecjia-platform-ui');
	    
	    $admin_jslang = array(
	        'display_sidebar'	=> __('显示侧边栏'),
	        'hide_sidebar'		=> __('隐藏侧边栏'),
	        'search_check'		=> __('请先输入搜索信息'),
	        'search_no_message'	=> __('未搜索到导航信息'),
	        'success'			=> __('操作成功'),
	        'fail'				=> __('操作失败'),
	        'confirm_jump'		=> __('是否确认跳转？'),
	        'ok'				=> __('确定'),
	        'cancel'			=> __('取消'),
	        'request_failed'	=> __('请求失败，错误编号：'),
	        'error_msg'			=> __('，错误信息：')
	    );
	    RC_Script::localize_script('ecjia-platform', 'admin_lang', $admin_jslang );
	}


	protected function load_hooks() {
		RC_Hook::add_action('platform_head', array('ecjia_platform_loader', 'admin_enqueue_scripts'), 1 );
		RC_Hook::add_action('platform_print_scripts', array('ecjia_platform_loader', 'print_head_scripts'), 20 );
		RC_Hook::add_action('platform_print_footer_scripts', array('ecjia_platform_loader', '_admin_footer_scripts') );
		RC_Hook::add_action('platform_print_styles', array('ecjia_platform_loader', 'print_admin_styles'), 20 );
		RC_Hook::add_action('platform_print_header_nav', array(__CLASS__, 'display_admin_header_nav'));
		RC_Hook::add_action('platform_sidebar_collapse_search', array(__CLASS__, 'display_admin_sidebar_nav_search'), 9);
		RC_Hook::add_action('platform_print_sidebar_nav', array(__CLASS__, 'display_admin_sidebar_nav'), 9);
		RC_Hook::add_filter('upload_default_random_filename', array('ecjia_utility', 'random_filename'));
		RC_Hook::add_action('platform_print_footer_scripts', array(ecjia_notification::make(), 'printScript') );

		RC_Package::package('app::platform')->loadClass('hooks.platform_platform', false);

		$system_plugins = ecjia_config::instance()->get_addon_config('system_plugins', true);
		if (is_array($system_plugins)) {
		    foreach ($system_plugins as $plugin_file) {
		        RC_Plugin::load_files($plugin_file);
		    }
		}

		$platform_plugins = ecjia_config::instance()->get_addon_config('platform_plugins', true);
		if (is_array($platform_plugins)) {
		    foreach ($platform_plugins as $plugin_file) {
		        RC_Plugin::load_files($plugin_file);
		    }
		}

		$apps = ecjia_app::installed_app_floders();
		if (is_array($apps)) {
			foreach ($apps as $app) {
				RC_Package::package('app::'.$app)->loadClass('hooks.platform_' . $app, false);
			}
		}
	}

	/**
	 * 生成admin_menu对象
	 */
	public static function make_admin_menu($action, $name, $link, $sort = 99, $target = '_self') {
	    return new admin_menu($action, $name, $link, $sort, $target);
	}

	/**
	 * 记录管理员的操作内容
	 *
	 * @access  public
	 * @param   string      $sn         数据的唯一值
	 * @param   string      $action     操作的类型
	 * @param   string      $content    操作的内容
	 * @return  void
	 */
	public final function admin_log($sn, $action, $content) {
	    $log_info = ecjia_admin_log::instance()->get_message($sn, $action, $content);

	    $data = array(
	        'log_time' 		=> RC_Time::gmtime(),
	    	'store_id'		=> $this->currentStore->getSotreId(),
	        'user_id' 		=> $this->currentUser->getUserId(),
	        'log_info' 		=> stripslashes($log_info),
	        'ip_address' 	=> RC_Ip::client_ip(),
	    );

	    RC_DB::table('staff_log')->insertGetId($data);
	}


	/**
	 * 获取当前管理员信息
     *
	 * @return  array
	 */
	public static function admin_info() {

	    $admin_info = RC_DB::table('staff_user')->where('user_id', intval($_SESSION[staff_id]))->first();

	    if (!empty($admin_info)) {
	        return $admin_info;
	    }
	    return false;
	}

    /**
     * ==================================
     * static function
     * ==================================
     */

	/**
	 * 添加IE支持的header信息
	 */
	public static function _ie_support_header() {
		if (is_ie()) {
			echo "\n";
			echo '<!--[if lte IE 8]>'. "\n";
			echo '<link rel="stylesheet" href="' . RC_Uri::admin_url() . '/statics/lib/ie/ie.css" />'. "\n";
			echo '<![endif]-->'. "\n";
			echo "\n";
			echo '<!--[if lt IE 9]>'. "\n";
			echo '<script src="' . RC_Uri::admin_url() . '/statics/lib/ie/html5.js"></script>'. "\n";
			echo '<script src="' . RC_Uri::admin_url() . '/statics/lib/ie/respond.min.js"></script>'. "\n";
			echo '<script src="' . RC_Uri::admin_url() . '/statics/lib/flot/excanvas.min.js"></script>'. "\n";
			echo '<![endif]-->'. "\n";
		}
	}


    public static function display_admin_header_nav() {
        $menus = Menu::singleton()->admin_menu();
        $screen = Screen::get_current_screen();

        echo '<ul class="nav navbar-nav">';
        foreach ($menus as $key => $group) {
            if ($group) {
                foreach ($group as $k => $menu) {
                    if ($menu->has_submenus()) {
                        if ($menu->base && $screen->parent_base && $menu->base == $screen->parent_base) {
                            echo '<li class="dropdown active">'.PHP_EOL;
                        } else {
                            echo '<li class="dropdown">'.PHP_EOL;
                        }
                        if ($menu->link) {
                            echo '  <a class="dropdown-toggle" data-toggle="dropdown" href="' . $menu->link . '" target="' . $menu->target . '">'.PHP_EOL;
                        } else {
                            echo '  <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;" target="' . $menu->target . '">'.PHP_EOL;
                        }
                        echo '  <div class="text-center">'.PHP_EOL;
                        echo '      <i class="fa '.$menu->icon.' fa-3x"></i><br>'.$menu->name.' <span class="caret"></span>'.PHP_EOL;
                        echo '  </div>'.PHP_EOL;
                        echo '  </a>'.PHP_EOL;
                        echo '  <ul class="dropdown-menu" role="menu">'.PHP_EOL;

                        if ($menu->submenus) {
                            foreach ($menu->submenus as $child) {
                                if ($child->action == 'divider') {
                                    echo '      <li class="divider"></li>'.PHP_EOL;
                                } else {
                                    echo '      <li><a href="'.$child->link.'"><i class="fa '.$child->icon.'"></i> '.$child->name.'</a></li>'.PHP_EOL;
                                }
                            }
                        }
                        echo '  </ul>'.PHP_EOL;
                        echo '</li>'.PHP_EOL;
                    } else {
                        if ($menu->base && $screen->parent_base && $menu->base == $screen->parent_base) {
                            echo '<li class="active">'.PHP_EOL;
                        } else {
                            echo '<li>'.PHP_EOL;
                        }
                        if ($menu->link) {
                            echo '  <a href="' . $menu->link . '" target="' . $menu->target . '">'.PHP_EOL;
                        } else {
                            echo '  <a href="javascript:;" target="' . $menu->target . '">'.PHP_EOL;
                        }
                        echo '  <div class="text-center">'.PHP_EOL;
                        echo '      <i class="fa '.$menu->icon.' fa-3x"></i><br>'.$menu->name.PHP_EOL;
                        echo '  </div>'.PHP_EOL;
                        echo '  </a>'.PHP_EOL;
                        echo '</li>'.PHP_EOL;
                    }
                }
            }
        }
        echo '</ul>';
    }


    public static function display_admin_sidebar_nav_search() {
        $menus = Menu::singleton()->admin_menu();
        $screen = Screen::get_current_screen();

        foreach ($menus as $key => $group) {
            if ($group) {
                foreach ($group as $k => $menu) {
                    if ($menu->has_submenus()) {

                        if ($menu->submenus) {
                            foreach ($menu->submenus as $child) {
                                if ($child->action == 'divider') {
                                    echo '      <li class="divider"></li>'.PHP_EOL;
                                } else {
                                    echo '      <li><a href="'.$child->link.'"><i class="fa '.$child->icon.'"></i> '.$child->name.'</a></li>'.PHP_EOL;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function display_admin_sidebar_nav() {
        $menus = Menu::singleton()->admin_menu();
        $screen = Screen::get_current_screen();

        if ($screen->get_sidebar_display()) {
            $menuClass = 'main-menu menu-static menu-accordion menu-shadow menu-light';
        } else {
            $menuClass = 'main-menu menu-fixed menu-accordion menu-shadow menu-border menu-light';
        }

        if (!empty($menus)) {
            
            echo '<div class="' . $menuClass . '" data-scroll-to-active="true">' . PHP_EOL;
            echo '<div class="main-menu-content">' . PHP_EOL;
            echo '<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">' . PHP_EOL;
            
            foreach ($menus as $type => $group) {
                if ($group) {
                    // 一级菜单支持
                    foreach ($group as $key => $menu) {
                        if ($menu->action == 'divider') {
                            echo '<li class="divider">';
                        } elseif ($menu->action == 'nav-header') {
                            echo '<li class="navigation-header"><span>' . $menu->name . '</span>';
                            echo '<i class="ft-more-horizontal ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="' . $menu->name . '"></i>';
                        } else {
                        
                            echo '<li class="nav-item">' . PHP_EOL;
                            
                            // 二级菜单支持
                            if ($menu->has_submenus && $menu->submenus) {
                                echo '<a href="#"><i class="' .$menu->icon. '"></i>';
                                echo '<span class="menu-title">' .$menu->name. '</span>';
                                //echo '<span class="badge badge badge-info badge-pill float-right mr-2">5</span>';
                                echo '</a>' . PHP_EOL;
                                
                                echo '      <ul class="menu-content">' . PHP_EOL;
                                foreach ($menu->submenus as $child) {
                                        
                                    if ($child->action == 'divider') {
                                        echo '<li class="divider">';
                                    } elseif ($child->action == 'nav-header') {
                                        echo '<li class="nav-header">' . $child->name;
                                    } else {
                                    	if (RC_Uri::current_url() === $child->link) {
                                    		echo '<li class="active"><a class="menu-item" href="' . $child->link . '">' . $child->name . '</a>';
                                    	} else {
                                    		echo '<li><a class="menu-item" href="' . $child->link . '">' . $child->name . '</a>';
                                    	}
                                    }
                                    
                                    // 三级菜单支持
                                    if ($child->has_submenus && $child->submenus) {
                                        echo PHP_EOL;
                                        echo '<ul class="menu-content">' . PHP_EOL;
                                        
                                        foreach ($child->submenus as $subchild) {
                                            if ($subchild->action == 'divider') {
                                                echo '<li class="divider">';
                                            } elseif ($subchild->action == 'nav-header') {
                                                echo '<li class="nav-header">' . $subchild->name;
                                            } else {
                                                if (RC_Uri::current_url() === $subchild->link) {
                                                    echo '<li class="active"><a class="menu-item" href="' . $subchild->link . '">' . $subchild->name . '</a>';
                                                } else {
                                                    echo '<li><a class="menu-item" href="' . $subchild->link . '">' . $subchild->name . '</a>';
                                                }
                                            }
                                            
                                            // 四级菜单支持
                                            if ($subchild->has_submenus && $subchild->submenus) {
                                                echo PHP_EOL;
                                                echo '<ul class="menu-content">' . PHP_EOL;
                                                
                                                foreach ($subchild->submenus as $fourchild) {
                                                    if ($fourchild->action == 'divider') {
                                                        echo '<li class="divider">';
                                                    } elseif ($fourchild->action == 'nav-header') {
                                                        echo '<li class="nav-header">' . $fourchild->name;
                                                    } else {
                                                        if (RC_Uri::current_url() === $fourchild->link) {
                                                            echo '<li class="active"><a class="menu-item" href="' . $fourchild->link . '">' . $fourchild->name . '</a>';
                                                        } else {
                                                            echo '<li><a class="menu-item" href="' . $fourchild->link . '">' . $fourchild->name . '</a>';
                                                        }
                                                    }
                                                    
                                                    echo '</li>' . PHP_EOL;
                                                }
                                                
                                                echo '</ul>' . PHP_EOL;
                                            }
                                            
                                            echo '</li>' . PHP_EOL;
                                        }
                                        
                                        echo '</ul>' . PHP_EOL;
                                    }
                                    
                                    echo '</li>' . PHP_EOL;
                                }
                                echo '</ul>' . PHP_EOL;
                            } 
                            //一级菜单没有子菜单处理
                            else {
                                echo '<a href="' . $menu->link . '"><i class="' .$menu->icon. '"></i>';
                                echo '<span class="menu-title">' .$menu->name. '</span>';
                                //echo '<span class="badge badge badge-info badge-pill float-right mr-2">5</span>';
                                echo '</a>' . PHP_EOL;
                            }
                            
                            echo '</li>' . PHP_EOL;
                        }
                    }
                    
                }
                
                echo '      </ul>' . PHP_EOL;
                echo '  </div>' . PHP_EOL;
                echo '</div>' . PHP_EOL;
            }
        }
    }

    public static function display_admin_copyright() {
    	$company_msg  = __('版权所有 © 2013-2018 上海商创网络科技有限公司，并保留所有权利。');
    	$ecjia_icon   = RC_Uri::admin_url('statics/images/ecjia_icon.png');

        echo "<div class='row-fluid footer'>
        		<div class='span12'>
        			<span class='f_l w80'>
        				<img src='{$ecjia_icon}' />
        			</span>
        			{$company_msg}
        		</div>
        	</div>";
    }

    public static function is_super_admin() {

    }
}

// end