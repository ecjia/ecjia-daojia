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

use ecjia;
use ecjia_app;
use ecjia_editor;
use ecjia_loader;
use RC_Config;
use RC_ENV;
use RC_Hook;
use RC_Ip;
use RC_Loader;
use RC_Response;
use RC_Session;

/**
 * ecjia 前端页面控制器父类
 * Class EcjiaFrontController
 * @package Ecjia\System\BaseController
 */
abstract class EcjiaFrontController extends SmartyController
{
    /**
     * 模板视图对象静态属性
     *
     * @var \ecjia_view
     */
//    public static $view_object;

    /**
     * 控制器对象静态属性
     * @var \ecjia_front
     */
//    public static $controller;
    
	public function __construct()
    {
		parent::__construct();
		
		self::$controller = static::$controller;
		self::$view_object = static::$view_object;
	
		if (defined('DEBUG_MODE') == false) {
			define('DEBUG_MODE', 0);
		}

		/* 商店关闭了，输出关闭的消息 */
		if (ecjia::config('shop_closed') == 1) {
		    RC_Hook::do_action('ecjia_shop_closed');
		}
		
		/* session id 定义*/
		defined('SESS_ID') or define('SESS_ID', RC_Session::session_id());
		RC_Hook::do_action('ecjia_front_access_session');
		
		if (isset($_SERVER['PHP_SELF'])) {
			$_SERVER['PHP_SELF'] = htmlspecialchars($_SERVER['PHP_SELF']);
		}

		RC_Response::header('Cache-control', 'private');
		
		//title信息，注册默认标题
		$this->assign_title();
		RC_Hook::do_action('ecjia_compatible_process');
		
        $this->load_default_script_style();

		/* 判断是否支持 Gzip 模式 */
		if (RC_Config::get('system.gzip') && RC_ENV::gzip_enabled()) {
			ob_start('ob_gzhandler');
		} else {
			ob_start();
		}
		
		RC_Hook::do_action('ecjia_front_finish_launching');
	}

    protected function registerServiceProvider()
    {
        royalcms()->forgeRegister('Royalcms\Component\Purifier\PurifierServiceProvider');
    }
	
	protected function session_start()
	{
	    parent::session_start();
        
        $this->default_session();
	}
	
	/**
	 * 默认session项赋值
	 */
	protected function default_session()
	{
	    if (! RC_Session::has('user_rank')) RC_Session::set('user_rank', 0);
	    if (! RC_Session::has('discount')) RC_Session::set('discount', 1.00);
	    if (! RC_Session::has('ip')) RC_Session::set('ip', RC_Ip::client_ip());
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
	    $revise_url = $url ? "window.location.href='" . $url . "'" : "window.history.back(-1);";
	    $front_tpl = SITE_THEME_PATH . RC_Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . RC_Config::get('system.tpl_message');
	
	    if ($tpl) {
	        $this->assign(array(
	            'msg' => $msg,
	            'url' => $revise_url,
	            'time' => $time
	        ));
	        $tpl = SITE_THEME_PATH . RC_Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . $tpl;
            return $this->display($tpl);
	    } elseif (file_exists($front_tpl)) {
	        $this->assign(array(
	            'msg' => $msg,
	            'url' => $revise_url,
	            'time' => $time
	        ));
            return $this->display($front_tpl);
	    } else {
	        return parent::message($msg, $url, $time, $tpl);
	    }
	}
	
	
	/**
	 * 向模版注册title
	 */
	public function assign_title($title = '')
    {
	    $title_suffix = RC_Hook::apply_filters('page_title_suffix', ' - Powered by ECJia');
	    if (empty($title)) {
	        $this->assign('page_title', ecjia::config('shop_title') . $title_suffix);
	    } else {
	        $this->assign('page_title', $title . '-' . ecjia::config('shop_title') . $title_suffix);
	    }
	}
	
	public function assign_template($ctype = '', $catlist = array())
    {
		$this->assign('image_width',   ecjia::config('image_width'));
		$this->assign('image_height',  ecjia::config('image_height'));
		$this->assign('points_name',   ecjia::config('integral_name'));
		$this->assign('qq',            explode(',', ecjia::config('qq')));
		$this->assign('ww',            explode(',', ecjia::config('ww')));
		$this->assign('ym',            explode(',', ecjia::config('ym')));
		$this->assign('msn',           explode(',', ecjia::config('msn')));
		$this->assign('skype',         explode(',', ecjia::config('skype')));
		$this->assign('stats_code',    ecjia::config('stats_code'));
		$this->assign('copyright',     '版权所有 © 2013-2019 上海商创网络科技有限公司，并保留所有权利。');
		$this->assign('shop_name',     ecjia::config('shop_name'));
		$this->assign('service_email', ecjia::config('service_email'));
		$this->assign('service_phone', ecjia::config('service_phone'));
		$this->assign('shop_address',  ecjia::config('shop_address'));
		$this->assign('ecs_version',   VERSION);
		$this->assign('icp_number',    ecjia::config('icp_number'));
		$this->assign('username',      !empty($_SESSION['user_name']) ? $_SESSION['user_name'] : '');
	
		if (ecjia::config('search_keywords', ecjia::CONFIG_CHECK)) {
			$searchkeywords = explode(',', trim(ecjia::config('search_keywords')));
			$this->assign('searchkeywords', $searchkeywords);
		}
	}
	

	protected function load_hooks()
    {
		RC_Hook::add_action( 'front_enqueue_scripts',	array($this, 'front_enqueue_scripts'),	1 );
		RC_Hook::add_action( 'front_print_styles',	array($this, 'front_print_head_styles'),		8 );
		RC_Hook::add_action( 'front_print_scripts',	array($this, 'front_print_head_scripts'),	9 );
		RC_Hook::add_action( 'front_print_footer_scripts',	array($this, 'print_front_footer_scripts'), 20 );

        //editor loading
        RC_Hook::add_action('editor_setting_first_init', function() {
            RC_Hook::add_action('front_print_footer_scripts', array(ecjia_editor::editor_instance(), 'editor_js'), 50);
            RC_Hook::add_action('front_print_footer_scripts', array(ecjia_editor::editor_instance(), 'enqueue_scripts'), 1);
        });

		$apps = ecjia_app::installed_app_floders();
		if (is_array($apps)) {
			foreach ($apps as $app) {
				RC_Loader::load_app_class('hooks.front_' . $app, $app, false);
			}
		}
	}

	protected function load_default_script_style()
    {
        //...
    }

    /**
     * 需要的时候继承修改
     * Fires when scripts and styles are enqueued.
     * @since 1.0.0
     */
    public function front_enqueue_scripts()
    {
        //...
    }

    /**
     * 禁止继承修改
     */
    public final function print_front_footer_scripts()
    {
        $this->front_print_late_styles();
        $this->front_print_footer_scripts();
    }

    /**
     * 前台控制器打印头部style样式文件
     */
    public function front_print_head_styles()
    {
        ecjia_loader::print_head_styles();
    }

    /**
     * 前台控制器打印头部script脚本文件
     */
    public function front_print_head_scripts()
    {
        ecjia_loader::print_head_scripts();
    }

    /**
     * 前台控制器打印底部style样式文件
     */
    protected function front_print_late_styles()
    {
        ecjia_loader::print_late_styles();
    }

    /**
     * 前台控制器打印底部script脚本文件
     */
    protected function front_print_footer_scripts()
    {
        ecjia_loader::print_footer_scripts();
    }
	
}

// end