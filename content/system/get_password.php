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
 * ECJIA 找回管理员密码
 */
defined('IN_ECJIA') or exit('No permission resources.');

class get_password extends ecjia_admin {
	private $db;
	public function __construct() {
		parent::__construct();
		
		$this->db = RC_Loader::load_model('admin_user_model');
		RC_Script::enqueue_script('jquery-form');
			
		// 禁止以下css加载
		RC_Style::dequeue_style ( array (
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
		) );
		// 加载'bootstrap','jquery-uniform','jquery-migrate','jquery-form',
		// 禁止以下js加载
		RC_Script::dequeue_script ( array (
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
		) );
	}
	
	public function forget_pwd(){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		
		RC_Loader::load_app_class('hooks.plugin_captcha', 'captcha', false);
		
		if ((intval(ecjia::config('captcha')) & CAPTCHA_ADMIN) && RC_ENV::gd_version() > 0) {
			$this->assign('gd_version', RC_ENV::gd_version());
			$this->assign('random',     mt_rand());
		}
    	$this->assign('form_act', 'forget_pwd');
		
		$this->display('get_pwd.dwt.php');
	}
	
	public function reset_pwd_mail(){
		$validator = RC_Validator::make($_POST, array(
		    'email' => 'required|email',
		    'username' => 'required',
		    ));
		if ($validator->fails()) {
		    return $this->showmessage(__('输入的信息不正确！'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}

		$admin_username = trim($_POST['username']);
		$admin_email    = trim($_POST['email']);

		/* 管理员用户名和邮件地址是否匹配，并取得原密码 */
		$admin_info = $this->db->field('user_id, password')->find(array('user_name' => $admin_username, 'email' => $admin_email));

		if (!empty($admin_info)) {
			/* 生成验证的code */
			$admin_id = $admin_info['user_id'];
			$code     = md5($admin_id . $admin_info['password']);

			$reset_email = RC_Uri::url('@get_password/reset_pwd_form', array('uid' => $admin_id, 'code' => $code));
			
			/* 设置重置邮件模板所需要的内容信息 */
			//$template    = get_mail_template('send_password');
			$tpl_name = 'send_password';
			$template   = RC_Api::api('mail', 'mail_template', $tpl_name);

			$this->assign('user_name',   $admin_username);
			$this->assign('reset_email', $reset_email);
			$this->assign('shop_name',   ecjia::config('shop_name'));
			$this->assign('send_date',   RC_Time::local_date(ecjia::config('date_format')));
			$this->assign('sent_date',   RC_Time::local_date(ecjia::config('date_format')));
			
			$state = ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON;
			
			if (RC_Mail::send_mail('', $admin_email, $template['template_subject'], $this->fetch_string($template['template_content']), $template['is_html'])) {
				$msg = __('重置密码的邮件已经发到您的邮箱：') . $admin_email;
				$state = ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON;
			} else {
				$msg = __('重置密码邮件发送失败!请与管理员联系');
			}
			//提示信息
			$link[0]['text'] = __('返回');
			$link[0]['href'] = RC_Uri::url('@privilege/login');
			return $this->showmessage($msg, $state, array('links' => $link));
		} else {
			/* 提示信息 */
			return $this->showmessage(__('用户名与Email地址不匹配,请返回！'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
	}
	
	public function reset_pwd_form(){
		$code = ! empty($_GET['code']) ? trim($_GET['code']) : '';
		$adminid = ! empty($_GET['uid']) ? intval($_GET['uid']) : 0;
		
		if ($adminid == 0 || empty($code)) {
			$url = RC_Uri::url('@privilege/login');
			return $this->redirect($url);
			exit;
		}
		
		/* 以用户的原密码，与code的值匹配 */
		$password = $this->db->field('password')->where(array('user_id' => $adminid))->find();
		$password = $password['password'];
		
    	if (md5($adminid . $password) != $code) {
    		// 此链接不合法
    		$link[0]['text'] =  __('返回');
    		$link[0]['href'] = RC_Uri::url('@privilege/login');
			return $this->showmessage(__('此链接不合法!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
    	} else {
    		$this->assign('adminid', $adminid);
    		$this->assign('code', $code);
    		$this->assign('form_act', 'reset_pwd');
    	}

    	$this->assign('ur_here', __('修改密码'));
        $this->display('get_pwd.dwt');
	}
	
	public function reset_pwd(){
    	$new_password = isset($_POST['password']) ? trim($_POST['password']) : '';
    	$adminid = isset($_POST['adminid']) ? intval($_POST['adminid']) : 0;
    	$code = isset($_POST['code']) ? trim($_POST['code']) : '';
    	
    	if (empty($new_password) || empty($code) || $adminid == 0) {
			$url = RC_Uri::url('@privilege/login');
			return $this->redirect($url);
    		exit();
    	}
    	
    	/* 以用户的原密码，与code的值匹配 */
		$password = $this->db->field('password')->where(array('user_id' => $adminid))->find();
		$password = $password['password'];

		if (md5($adminid . $password) != $code) {
			// 此链接不合法
			$link[0]['text'] =  __('返回');
			$link[0]['href'] = RC_Uri::url('@privilege/login');
			return $this->showmessage(__('此链接不合法!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		} else {
	    	// 更新管理员的密码
	    	$ec_salt = rand(1, 9999);
	    	$data = array(
	    		'password' => md5(md5($new_password) . $ec_salt),
	    		'ec_salt' => $ec_salt
	    	);

	    	$result = $this->db->where(array('user_id' => $adminid))->update($data);
	    	
	    	if ($result) {
	    		$link[0]['text'] = __('返回');
	    		$link[0]['href'] = RC_Uri::url('@privilege/login');
				return $this->showmessage(__('密码修改成功!'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
	    	} else {
				return $this->showmessage(__('密码修改失败!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    	}
		}
	}
	
}

// end