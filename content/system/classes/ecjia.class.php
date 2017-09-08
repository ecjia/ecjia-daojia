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
/**
 * ECJIA 控制器基础类
 */
defined('IN_ECJIA') or exit('No permission resources.');

define('APPNAME', 'ECJIA');
define('VERSION', '1.22');
define('RELEASE', '20170901'); 

class ecjia {
	
	protected $config;
	
	/**
	 * Config read or wirte
	 * @var int
	 */
	const CONFIG_READ		= 1;
	const CONFIG_CHECK		= 2;
	const CONFIG_EXISTS		= 3;
	
	
	/**
	 * MSG types
	 */
	const MSGTYPE_HTML		= 0x00;
	const MSGTYPE_ALERT		= 0x10;
	const MSGTYPE_JSON		= 0x20;
	const MSGTYPE_XML	    = 0x30;
	
	/**
	 * DATA types 
	 */
	const DATATYPE_HTML    = 1;
	const DATATYPE_TEXT    = 2;
	const DATATYPE_JSON    = 3;
	const DATATYPE_XML     = 4;
	
	
	/**
	 * MSG stats
	 */
	const MSGSTAT_ERROR		= 0x00;
	const MSGSTAT_SUCCESS	= 0x01;
	const MSGSTAT_INFO		= 0x02;
	const MSGSTAT_CONFIRM	= 0x03;
	
	
	/**
	 * Addon types
	 */
	const TYPE_APP 		= 'app';
	const TYPE_PLUGIN 	= 'plugin';
	const TYPE_WIDGET	= 'widget';
	const TYPE_THEME	= 'theme';
	
	
	/**
	 * Platform types
	 */
	const PLATFORM_WEB     = 'web';
	const PLATFORM_MOBILE  = 'mobile';
	const PLATFORM_WAP	   = 'wap';
	const PLATFORM_WEIXIN  = 'weixin';
	const PLATFORM_WEIBO   = 'weibo';
	
	/**
	 * Debug modes
	 * @var int
	 */
	const DM_DISABLED       = 0x0;
	const DM_OUTPUT_ERROR   = 0x1;
	const DM_DISABLED_CACHE = 0x10;
	const DM_SHOW_DEBUG     = 0x100;
	const DM_LOGGING_SQL    = 0x1000;
	const DM_DISPLAY_SQL    = 0x10000;
	
	
	/**
	 * 调用站点配置文件
	 * 
	 * @param string $name
	 * @return ArrayObject|string
	 */
	public final static function config($name = null, $what = self::CONFIG_READ) {
		if (is_null($name)) {
			return ecjia_config::instance()->load_config();
		}
		if ($what === ecjia::CONFIG_READ) {
			return ecjia_config::instance()->read_config($name);
		} elseif ($what === ecjia::CONFIG_CHECK) {
			return ecjia_config::instance()->check_config($name);
		} elseif ($what === ecjia::CONFIG_EXISTS) {
			return ecjia_config::instance()->check_exists($name);
		}
	}
	
	public final static function current_platform() {
	    if (defined('USE_PLATFORM_MOBILE') && USE_PLATFORM_MOBILE === true) {
	        $platform = self::PLATFORM_MOBILE;
	    }
	    elseif (defined('USE_PLATFORM_WAP') && USE_PLATFORM_WAP === true) {
	        $platform = self::PLATFORM_WAP;
	    }
	    elseif (defined('USE_PLATFORM_WEB') && USE_PLATFORM_WEB === true) {
	        $platform = self::PLATFORM_WEB;
	    }
	    elseif (defined('USE_PLATFORM_WEIXIN') && USE_PLATFORM_WEIXIN === true) {
	        $platform = self::PLATFORM_WEIXIN;
	    }
	    elseif (defined('USE_PLATFORM_WEIBO') && USE_PLATFORM_WEIBO === true) {
	        $platform = self::PLATFORM_WEIBO;
	    }
	    else {
	        $platform = self::PLATFORM_WEB;
	    }
	    return $platform;
	}
	
	/**
	 * Registers plugin to be used in templates
	 *
	 * @param  string                       $type       plugin type
	 * @param  string                       $tag        name of template tag
	 * @param  callback                     $callback   PHP callback to register
	 * @param  boolean                      $cacheable  if true (default) this fuction is cachable
	 * @param  array                        $cache_attr caching attributes if any
	 * @return Smarty_Internal_Templatebase current Smarty_Internal_Templatebase (or Smarty or Smarty_Internal_Template) instance for chaining
	 * @throws SmartyException              when the plugin tag is invalid
	 */
	public final static function register_view_plugin($type, $tag, $callback, $cacheable = true, $cache_attr = null) {
		return static::$view_object->registerPlugin($type, $tag, $callback, $cacheable, $cache_attr);
	}
	
	/**
	 * Unregister Plugin
	 *
	 * @param  string                       $type of plugin
	 * @param  string                       $tag  name of plugin
	 * @return Smarty_Internal_Templatebase current Smarty_Internal_Templatebase (or Smarty or Smarty_Internal_Template) instance for chaining
	 */
	public final static function unregister_view_plugin($type, $tag) {
		return static::$view_object->unregisterPlugin($type, $tag);
	}
	
	/**
	 * 获取ECJia版本号
	 */
	public static function version() {
	    return RC_Hook::apply_filters('ecjia_build_version', VERSION);
	}
	
	/**
	 * 获取ECJia发布日期
	 */
	public static function release() {
	    return RC_Hook::apply_filters('ecjia_build_release', RELEASE);
	}
	
    /**
     * ecjia 初始化
     */
	public static function init_load() {
		/* 初始化设置 */
		ini_set('memory_limit',          '128M');
		ini_set('display_errors',        1);

		RC_Response::header('X-Powered-By', APPNAME.'/'.VERSION);

		/**
		 * 加载系统配置
		 */
		RC_Loader::load_sys_config('constant');
		
		RC_Loader::load_sys_func('global');
		RC_Loader::load_sys_func('extention');
		
		RC_Hook::add_filter('set_server_timezone', array(__CLASS__, 'current_timezone'));
		RC_Hook::add_action('admin_print_main_bottom', array(__CLASS__, 'echo_query_info'), 99);
		
		$rc_script = RC_Script::instance();
		$rc_style = RC_Style::instance();
		ecjia_loader::default_scripts($rc_script);
		ecjia_loader::default_styles($rc_style);

		/**
		 * This hook is fired once ecjia, all plugins, and the theme are fully loaded and instantiated.
		 *
		 * @since 1.0.0
		 */
		RC_Hook::do_action( 'ecjia_loaded' );
	}
	
	/**
	 * 加载应用模块的语言包
	 * @param array $apps
	 */
	public static function load_lang() {
	    $apps = ecjia_app::app_floders();
	    foreach ($apps as $app) {
	        $namespace = $app;
	        $dir = SITE_CONTENT_PATH . 'apps/' . $app . '/languages';
	        $dir2 = RC_CONTENT_PATH . 'apps/' . $app . '/languages';
	        if (is_dir($dir)) {
	            $path = $dir;
	        } elseif (is_dir($dir2)) {
	            $path = $dir2;
	        } else {
	            $path = null;
	        }
	        if ($path) {
	            RC_Lang::addNamespace($namespace, $path);
	        }
	    }
	}
	
    
    /**
     * 获得查询时间和次数，内存占用
     */
    public static function echo_query_info() {
        if (RC_Config::get('system.debug') === false || RC_Config::get('system.debug_display') === false) {
            return false;
        }

    	$query_info = $memory_info = $gzip_enabled = '';

    	/* 数据库查询情况 */
        $timer = RC_Timer::formatTimer(RC_Timer::getLoadTime());
    	$query_info = sprintf(RC_Lang::get('system::system.query_info'), RC_Model::sql_count(), $timer);
    
    	/* 内存占用情况 */
    	if (RC_Lang::get('system::system.memory_info') && function_exists('memory_get_usage')) {
    		$memory_info = sprintf(RC_Lang::get('system::system.memory_info'), memory_get_usage() / 1048576);
    	}
    	 
    	/* 是否启用了 gzip */
    	$gzip_enabled = ecjia_utility::gzip_enabled(RC_ENV::gzip_enabled()) ? RC_Lang::get('system::system.gzip_enabled') : RC_Lang::get('system::system.gzip_disabled');

    	echo '<div class="main_content_bottom">' . rc_user_crlf();
    	echo '<hr />' . rc_user_crlf();
    	echo "{$query_info}{$gzip_enabled}{$memory_info} <br />";
    	
    	if (RC_Config::get('system.debug_display_query') == true) {
        	echo "<br />";
        	echo "SQL查询清单 <br />";
        	
        	foreach ($queries = RC_DB::getQueryLog() as $query) {
        	    echo vsprintf(str_replace('?', '%s', $query["query"]), $query['bindings']). " (time: " . $query['time'] ."ms)" . "<br />";
        	}
        	
        	foreach (RC_Model::sql_all() as $sql) {
        		echo $sql . "<br />";
        	}
    	}
    	
    	if (RC_Config::get('system.debug_display_included') == true) {
    	    /* 加载文件顺序 */
    	    $load_files = get_included_files();
    	    
    	    echo "<br />";
    	    echo "加载文件列表 <br />";
    	    foreach ($load_files as $key => $file) {
    	        echo $key . " " . $file . "<br />";
    	    }
    	}    	
    	
    	echo '</div>' . rc_user_crlf();
    }


    
    /**
     * 设置当前时区
     * @param unknown $timezone
     * @return number
     */
    public static function current_timezone($timezone) {
    	return isset($_SESSION['timezone']) ? $_SESSION['timezone'] : self::config('timezone');
    }
    
    /**
     * 加载手动加载的类
     */
    public static function manual_load_classes() {
        $autoload_classes = RC_Package::package('system')->loadConfig('autoload_class');
        if (!empty($autoload_classes)) {
            foreach ($autoload_classes as $key => $class) {
                RC_Hook::add_action($key, function () use ($class) {
                    RC_Package::package('system')->loadClass($class, false);
                });
            }
        }

        RC_Hook::do_action('ecjia_manual_load_classes');
    }
    
    /**
     * auto laod classes
     */
    public static function auto_load_classes($classname) {
        if (RC_Hook::has_action('class_' . $classname)) {
            return RC_Hook::do_action('class_' . $classname);
        } elseif (strpos($classname, 'ecjia') === 0) {
            return RC_Loader::load_sys_class($classname, false);
        } 
        return false;
    }
    
    /**
     * 注册自动加载方法
     */
    public static function autoload_register() {
        spl_autoload_register(array(__CLASS__, 'auto_load_classes'), true);
    }
    
    /**
     * 注销自动加载方法
     */
    public static function autoload_unregister() {
        spl_autoload_unregister(array(__CLASS__, 'auto_load_classes'), true);
    }
    
}

RC_Hook::add_action('init', array('ecjia', 'manual_load_classes'), 0);
RC_Hook::add_action('init', array('ecjia', 'autoload_register'), 0);
RC_Hook::add_action('init', array('ecjia', 'init_load'), 1);
RC_Hook::add_action('init', array('ecjia', 'load_lang'), 3);
// RC_Hook::add_action('init', array('RC_Cache', 'memory_cache_init'), 1);
// RC_Hook::add_action('init', array('ecjia_upgrade_db', 'initialization'),1);
// RC_Hook::add_action('init', array('ecjia_widget', 'widgets_init'), 2);

// end