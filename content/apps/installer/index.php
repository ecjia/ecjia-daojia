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
use Ecjia\System\BaseController\SimpleController;
defined('IN_ECJIA') or exit('No permission resources.');

RC_Package::package('app::installer')->loadClass('install_utility', false);
class index extends SimpleController {
	public function __construct() {
		parent::__construct();

		set_time_limit(60);
		define('DATA_PATH', dirname(__FILE__).'/data/');
		
		/* js与css加载路径*/
  		$this->assign('front_url', RC_App::apps_url('statics/front', __FILE__));
  		$this->assign('system_statics_url', RC_Uri::admin_url('statics'));
  		$this->assign('logo_pic', RC_App::apps_url('statics/front/images/logo_pic.png', __FILE__));

  		$this->assign('version', RC_Config::get('release.version'));
  		$this->assign('build', RC_Config::get('release.build'));
	}

	/**
	 * 欢迎页面加载
	 */
	public function init() {
	    $this->check_installed();
	    
		$this->unset_cookie();
		setcookie('install_step1', 1);
		
		$this->assign('ecjia_step', 1);
		$this->display(
			RC_Package::package('app::installer')->loadTemplate('front/welcome.dwt', true)
		);
	}
	
	/*
	 * 检查环境页面加载
	 */
	public function detect() {
	    $this->check_installed();
		$this->check_step(2);
		setcookie('install_step2', 1);

		$name = $_SERVER['SCRIPT_NAME'];
		$php_path = '1';
		if ($name != '/index.php') {
			$path_name = substr($name, 0, -9);
			$this->assign('path_error', sprintf(RC_Lang::get('installer::installer.path_error'), $path_name));
			$php_path = '0';
		}
		
		$ok = '<i class="fontello-icon-ok"></i>';
		$cancel = '<i class="fontello-icon-cancel"></i>';
		$info = '<i class="fontello-icon-info-circled"></i>';
		
		//操作系统
		$os_array = array('Linux', 'FreeBSD', 'WINNT', 'Darwin');
		$sys_info['os'] = PHP_OS;
		
		$php_os = '0';
		if (in_array($sys_info['os'], $os_array)) {
			$php_os = '1';
		}
		$sys_info['os_info'] = $php_os == 1 ? $ok : $cancel;
		
		$sys_info['ip']           	= $_SERVER['SERVER_ADDR'];
		$sys_info['web_server']   	= $_SERVER['SERVER_SOFTWARE'];

		//WEB服务器
		if (stristr($sys_info['web_server'], 'nginx') || stristr($sys_info['web_server'], 'apache') || stristr($sys_info['web_server'], 'iis')) {
			$sys_info['web_server_info'] = $ok;
		} else {
			$sys_info['web_server_info'] = $info;
		}
		$domain = $_SERVER['SERVER_NAME'];

		$position = strpos($domain, ':'); //查找域名是否带端口号
		if ($position !== false) {
			$domain = substr($domain, 0, $position);
		}
		$domain = strtolower($domain);
		
		$sys_info['php_dns'] 			= preg_match("/^[0-9.]{7,15}$/", @gethostbyname($domain)) ? $ok : $cancel;
		$sys_info['php_ver']            = PHP_VERSION;
		
		$sys_info['safe_mode']          = (boolean) ini_get('safe_mode') ? __('是') : __('否');
		$sys_info['safe_mode_gid']      = (boolean) ini_get('safe_mode_gid') ? $ok : $cancel;
		$sys_info['timezone']           = function_exists("date_default_timezone_get") ? date_default_timezone_get() : __('无需设置');

		//MySQLi
		$php_mysqli = '0';
		if (extension_loaded('mysqli')) $php_mysqli = '1';
		$sys_info['mysqli'] = $php_mysqli == 1 ? $ok : $cancel;
		
		//PDO pdo_mysql
		$php_pdo = '0';
		if (extension_loaded('PDO') && extension_loaded('pdo_mysql')) $php_pdo = '1';
		$sys_info['pdo'] = $php_pdo == 1 ? $ok : $cancel;
		
		//openssl
		$php_openssl = '0';
		if (extension_loaded('openssl')) $php_openssl = '1';
		$sys_info['openssl'] = $php_openssl == 1 ? $ok : $cancel;
		
		//socket
		$php_socket = '0';
		if (function_exists('fsockopen')) $php_socket = '1';
		$sys_info['socket'] = $php_socket == 1 ? $ok : $cancel;
		
		//GD
		$php_gd = '0';
		$gd_info = $cancel;
		if (extension_loaded('gd')) {
			$gd_info = $ok;
			$gd_info .= '支持（';
			if (function_exists('imagepng')) $gd_info .= 'png';
			if (function_exists('imagejpeg')) $gd_info .= ' / jpg';
			if (function_exists('imagegif')) $gd_info .= ' / gif';
			$gd_info .= '）';
			
			$php_gd = '1';
		}
		$sys_info['gd'] = $php_gd == 1 ? $gd_info : $cancel;
		$sys_info['gd_info'] = $php_gd == 1 ? $ok : $cancel;
		
		//curl
		$php_curl = '0';
		if (extension_loaded('curl')) $php_curl = '1';
		$sys_info['curl'] = $php_curl == 1 ? $ok : $cancel;
		
		//fileinfo
		$php_fileinfo = '0';
		if (extension_loaded('fileinfo')) $php_fileinfo = '1';
		$sys_info['fileinfo'] = $php_fileinfo == 1 ? $ok : $cancel;
		
		//zlib
		$php_zlib = '0';
		if (function_exists('gzclose')) $php_zlib = '1';
		$sys_info['zlib'] = $php_zlib == 1 ? $ok : $cancel;
		
		//检测必须开启项是否开启
		$sys_info['is_right'] = $php_path && $php_os && version_compare(PHP_VERSION, '5.4.0', 'ge') && $php_mysqli && $php_pdo && $php_openssl && $php_socket && $php_gd && $php_curl && $php_fileinfo && $php_zlib ? 1 : 0;
		
		//目录检测
		$Upload_Current_Path		= str_replace(SITE_ROOT, '', RC_Upload::upload_path());
		$Cache_Current_Path			= str_replace(SITE_ROOT, '', SITE_CACHE_PATH);
			
		$dir['content/configs']		= str_replace(SITE_ROOT, '', SITE_CONTENT_PATH) . 'configs';
		$dir['content/uploads']		= $Upload_Current_Path;
		$dir['content/storages']	= $Cache_Current_Path;
		$list = array();
		
		$has_unwritable_tpl = 'no';
		/* 检查目录 */
		foreach ($dir AS $key => $val) {
			$mark = RC_File::file_mode_info(SITE_ROOT . $val);
			if ($mark&4 <= 0) {
				$sys_info['is_right'] = 0;
			}
			if ($mark&8 < 1) {
				$has_unwritable_tpl = 'yes';
			}
			$list[] = array('item' => $key . __('目录'), 'r' => $mark&1, 'w' => $mark&2, 'm' => $mark&4);
		}
		$this->assign('list', $list);
		$this->assign('has_unwritable_tpl', $has_unwritable_tpl);
			
		if ($sys_info['is_right'] == 1) {
			setcookie('install_config', 1);
		} elseif ($sys_info['is_right'] == 0) {
			setcookie('install_config', 0);
		}
		
		/* 允许上传的最大文件大小 */
		$sys_info['max_filesize'] = ini_get('upload_max_filesize');
		$filesize = '0';
		if($sys_info['max_filesize'] >= 2){
			$filesize = '1';
		}
		$sys_info['filesize'] = $filesize == 1 ? $ok : $cancel;
		$this->assign('ecjia_version', VERSION);
		$this->assign('ecjia_release', RELEASE);
		$this->assign('sys_info', $sys_info);
		
		$this->assign('ecjia_step', 2);
		$this->display(
			RC_Package::package('app::installer')->loadTemplate('front/detect.dwt', true)
		);
	}
	
	/**
	 * 配置项目包信息页面加载
	 */
	public function deploy() {
	    $this->check_installed();
		$this->check_step(3);
		setcookie('install_step3', 1);
		
		$installer_lang = 'zh_cn';
		$prefix 		= 'ecjia_';
		$show_timezone 	= 'yes';
		$timezones 		= install_utility::getTimezones($installer_lang);
		
		$this->assign('timezones', $timezones);
		$this->assign('show_timezone', $show_timezone);
		$this->assign('local_timezone', install_utility::getLocalTimezone());
		$this->assign('correct_img', RC_App::apps_url('statics/front/images/correct.png', __FILE__));
		$this->assign('error_img', RC_App::apps_url('statics/front/images/error.png', __FILE__));
		
		$this->assign('ecjia_step', 3);
		$this->display(
			RC_Package::package('app::installer')->loadTemplate('front/deploy.dwt', true)
		);
	}

	/**
	 * 完成页面
	 */
	public function finish() {
		$result = $this->check_step(4);
		if (!$result) {
			$this->check_installed();
			//安装完成后的一些善后处理
			install_utility::updateInstallDate();
			install_utility::updateEcjiaVersion();
			install_utility::updateHashCode();
			install_utility::updateDemoApiUrl();
			install_utility::createStorageDirectory();
			install_utility::saveInstallLock();
			
			$admin_name 	= RC_Cache::app_cache_get('admin_name', 'install');
			$admin_password	= RC_Cache::app_cache_get('admin_password', 'install');

			$index_url 		= RC_Uri::home_url();
			$h5_url 		= RC_Uri::home_url().'/sites/m/';
			$admin_url      = RC_Uri::home_url().'/sites/admincp/';
			$merchant_url   = RC_Uri::home_url().'/sites/merchant/';

			$this->assign('index_url', $index_url);
			$this->assign('h5_url', $h5_url);
			$this->assign('admin_url', $admin_url);
			$this->assign('merchant_url', $merchant_url);
			$this->assign('admin_name', $admin_name);
			$this->assign('admin_password', $admin_password);
			
			$finish_message = RC_Lang::get('installer::installer.finish_success');
			$this->assign('finish_message', $finish_message);
			
			$this->assign('ecjia_step', 5);
			$this->display(
				RC_Package::package('app::installer')->loadTemplate('front/finish.dwt', true)
			);
		}
	}
	
	/**
	 * 已经安装过的提示页
	 */
	public function installed() {
		$this->unset_cookie();
		
		$finish_message = RC_Lang::get('installer::installer.has_locked_installer_title');
		$locked_message = RC_Lang::get('installer::installer.locked_message');
		$this->assign('finish_message', $finish_message);
		$this->assign('locked_message', $locked_message);
		
		$index_url 		= RC_Uri::home_url();
		$h5_url 		= RC_Uri::home_url().'/sites/m/';
		$admin_url      = RC_Uri::home_url().'/sites/admincp/';
		$merchant_url   = RC_Uri::home_url().'/sites/merchant/';

		$this->assign('index_url', $index_url);
		$this->assign('h5_url', $h5_url);
		$this->assign('admin_url', $admin_url);
		$this->assign('merchant_url', $merchant_url);
		
		if (! install_utility::checkInstallLock()) {
			return $this->redirect(RC_Uri::url('installer/index/init'));
		}
		
		$this->assign('ecjia_step', 5);
		$this->display(
			RC_Package::package('app::installer')->loadTemplate('front/finish.dwt', true)
		);
	}
	
	/**
	 * 检查数据库密码是否正确
	 */
	public function check_db_correct() {
		$db_host    = isset($_POST['db_host']) ? trim($_POST['db_host']) : '';
		$db_port    = isset($_POST['db_port']) ? trim($_POST['db_port']) : '';
		$db_user    = isset($_POST['db_user']) ? trim($_POST['db_user']) : '';
		$db_pass    = isset($_POST['db_pass']) ? trim($_POST['db_pass']) : '';
		
		$databases  = install_utility::getDataBases($db_host, $db_port, $db_user, $db_pass);
		if (is_ecjia_error($databases)) {
			return $this->showmessage(RC_Lang::get('installer::installer.connect_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$check_version = install_utility::getMysqlVersion($db_host, $db_port, $db_user, $db_pass);
		if (is_ecjia_error($check_version)) {
			return $this->showmessage(RC_Lang::get('installer::installer.connect_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (version_compare($check_version, '5.5', '<')) {
			return $this->showmessage(RC_Lang::get('installer::installer.mysql_version_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$check_result = install_utility::checkMysqlSupport($db_host, $db_port, $db_user, $db_pass);
		if (is_ecjia_error($check_result)) {
			return $this->showmessage(RC_Lang::get('installer::installer.connect_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		foreach ($check_result as $k => $v) {
			if ($v['Variable_name'] == 'have_innodb' && $v['Value'] != 'YES') {
				return $this->showmessage(RC_Lang::get('installer::installer.innodb_not_support'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
		
	/**
	 * 获取数据库列表
	 */
	public function check_db_exists() {
		$db_host    = isset($_POST['db_host']) ? trim($_POST['db_host']) : '';
		$db_port    = isset($_POST['db_port']) ? trim($_POST['db_port']) : '';
		$db_user    = isset($_POST['db_user']) ? trim($_POST['db_user']) : '';
		$db_pass    = isset($_POST['db_pass']) ? trim($_POST['db_pass']) : '';
		$db_database = isset($_POST['dbdatabase']) ? trim($_POST['dbdatabase']) : '';
		
		$databases  = install_utility::getDataBases($db_host, $db_port, $db_user, $db_pass);
		if (is_ecjia_error($databases)) {
			return $this->showmessage(RC_Lang::get('installer::installer.connect_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (in_array($db_database, $databases)) {
				return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('is_exist' => true));
			}
		}
	}
	
	/**
	 * 创建配置文件
	 */
	public function create_config_file() {
		$db_host    = isset($_POST['db_host'])		?   trim($_POST['db_host']) 	: '';
		$db_port    = isset($_POST['db_port'])      ?   trim($_POST['db_port'])     : '';
		$db_name    = isset($_POST['db_name'])      ?   trim($_POST['db_name']) 	: '';
		$db_user    = isset($_POST['db_user'])      ?   trim($_POST['db_user']) 	: '';
		$db_pass    = isset($_POST['db_pass'])      ?   trim($_POST['db_pass']) 	: '';
		$prefix     = isset($_POST['db_prefix'])    ?   trim($_POST['db_prefix']) 	: '';
		$timezone   = isset($_POST['timezone'])     ?   trim($_POST['timezone']) 	: 'Asia/Shanghai';
		$auth_key   = install_utility::getAuthKey();
		
		$data = array(
			'DB_HOST' 		=> $db_host,
		    'DB_PORT'       => $db_port,
			'DB_DATABASE' 	=> $db_name,
			'DB_USERNAME' 	=> $db_user,
			'DB_PASSWORD' 	=> $db_pass,
			'DB_PREFIX' 	=> $prefix,
			'TIMEZONE' 		=> $timezone,
		    'AUTH_KEY'      => $auth_key,
		);
		
		install_utility::createEnv();
		$result = install_utility::modifyEnv($data);
		 
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 创建数据库
	 */
	public function create_database() {
		$db_host    = isset($_POST['db_host'])      ?   trim($_POST['db_host']) : '';
		$db_port    = isset($_POST['db_port'])      ?   trim($_POST['db_port']) : '';
		$db_user    = isset($_POST['db_user'])      ?   trim($_POST['db_user']) : '';
		$db_pass    = isset($_POST['db_pass'])      ?   trim($_POST['db_pass']) : '';
		$db_name    = isset($_POST['db_name'])      ?   trim($_POST['db_name']) : '';
		
		$result = install_utility::createDatabase($db_host, $db_port, $db_user, $db_pass, $db_name);
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 安装数据库结构
	 */
	public function install_structure() {
	    $result = install_utility::installStructure();

	    if (is_ecjia_error($result)) {
	        return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    } else {
	        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	    }
	}

	/**
	 * 安装基本数据
	 */
	public function install_base_data() {	
		$result = install_utility::installBaseData();

		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 安装演示数据
	 */
	public function install_demo_data() {
		$result = install_utility::installDemoData();

		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}

	/**
	 * 创建管理员
	 */
	public function create_admin_passport() {
		$admin_name         = isset($_POST['admin_name'])       ? trim($_POST['admin_name']) 		: '';
		$admin_password     = isset($_POST['admin_password'])   ? trim($_POST['admin_password']) 	: '';
		$admin_password2    = isset($_POST['admin_password2'])  ? trim($_POST['admin_password2']) 	: '';
		$admin_email        = isset($_POST['admin_email'])      ? trim($_POST['admin_email']) 		: '';
		
		RC_Cache::app_cache_set('admin_name', $admin_name, 'install');
		RC_Cache::app_cache_set('admin_password', $admin_password, 'install');
		
		if (! $admin_name) {
		    return $this->showmessage(RC_Lang::get('installer::installer.username_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (! $admin_password) {
		    return $this->showmessage(RC_Lang::get('installer::installer.password_empty_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (!(strlen($admin_password) >= 8 && preg_match("/\d+/",$admin_password) && preg_match("/[a-zA-Z]+/",$admin_password))) {
		    return $this->showmessage(RC_Lang::get('installer::installer.password_invaild'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (!(strlen($admin_password2) >= 8 && preg_match("/\d+/",$admin_password2) && preg_match("/[a-zA-Z]+/",$admin_password2))) {
		    return $this->showmessage(RC_Lang::get('installer::installer.password_invaild'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($admin_password != $admin_password2) {
		    return $this->showmessage(RC_Lang::get('installer::installer.password_not_eq'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$result = install_utility::createAdminPassport($admin_name, $admin_password, $admin_email);
		
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 检查操作步骤
	 */
	private function check_step($step) {
		if ($step > 1) {
			if (!isset($_COOKIE['install_step1']) || !isset($_COOKIE['agree'])) {
				return $this->redirect(RC_Uri::url('installer/index/init'));
			}
			if ($step > 2) {
				if (!isset($_COOKIE['install_step2']) || $_COOKIE['install_config'] != 1) {
					return $this->redirect(RC_Uri::url('installer/index/detect'));
				} else {
					if ($step > 3) {
						if (!isset($_COOKIE['install_step3']) || !isset($_COOKIE['install_step4'])) {
							return $this->redirect(RC_Uri::url('installer/index/deploy'));
						}
					}
				}
			}
		}
		return false;
	}
	
	/**
	 * 检测是否已安装程序
	 */
	private function check_installed() {
	    /* 初始化流程控制变量 */
	    if (install_utility::checkInstallLock()) {
	        return $this->redirect(RC_Uri::url('installer/index/installed'));
	    }
	}
	
	/**
	 * 清除流程cookie
	 */
	private function unset_cookie() {
		setcookie('install_step1', '', time()-3600);
		setcookie('install_step2', '', time()-3600);
		setcookie('install_step3', '', time()-3600);
		setcookie('install_step4', '', time()-3600);
		setcookie('install_config', '', time()-3600);
		setcookie('agree', '', time()-3600);
	}
}

//end