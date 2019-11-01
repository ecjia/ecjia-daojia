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
 * 找回密码
 */
class get_password extends ecjia_merchant {
	public function __construct() {
		parent::__construct();

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');		
		//禁止以下css加载
		RC_Style::dequeue_style(array(
		'ecjia-mh-owl-theme',
		'ecjia-mh-owl-transitions',
		'ecjia-mh-table-responsive',
		'ecjia-mh-jquery-easy-pie-chart',
		'ecjia-mh-function',
		'ecjia-mh-page',
		));
		
		$this->assign('shop_name', ecjia::config('shop_name'));
		$this->assign('ur_here_mobile',__('手机号找回密码', 'staff'));
		$this->assign('ur_here_email',__('邮箱找回密码', 'staff'));
		$this->assign('logo_display', RC_Hook::apply_filters('ecjia_admin_logo_display', '<div class="logo"></div>'));
	}

	/**
	 * 邮箱找回密码页面
	 */
	public function forget_pwd() {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		
		RC_Loader::load_app_class('hooks.plugin_captcha', 'captcha', false);
		
		if ((intval(ecjia::config('captcha')) & \Ecjia\App\Captcha\Enums\CaptchaEnum::CAPTCHA_ADMIN) && RC_ENV::gd_version() > 0) {
			$this->assign('gd_version', RC_ENV::gd_version());
			$this->assign('random',     mt_rand());
		}
		
    	$this->assign('form_act', 'forget_pwd');

        return $this->display('get_pwd.dwt');
	}
	
	/**
	 * 核对用户名和邮箱
	 */
	public function reset_pwd_mail(){
		$validator = RC_Validator::make($_POST, array(
			'email' => 'required|email',
			'name' => 'required',
		));
		if ($validator->fails()) {
			return $this->showmessage(__('输入的信息不正确！', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$admin_name = trim($_POST['name']);
		$admin_email    = trim($_POST['email']);
	
		/* 管理员用户名和邮件地址是否匹配，并取得原密码 */
		$admin_info = RC_DB::table('staff_user')->where('name', $admin_name)->where('email', $admin_email)->select('user_id', 'password','name')->first();//多个
		
		if (!empty($admin_info)) {
			/* 生成验证的code */
			$admin_id = $admin_info['user_id'];
			$code     = md5($admin_id . $admin_info['password']);
			$reset_email = RC_Uri::url('staff/get_password/reset_pwd_form', array('uid' => $admin_id, 'code' => $code));
			/* 设置重置邮件模板所需要的内容信息 */
			$tpl_name = 'send_password';
			$template   = RC_Api::api('mail', 'mail_template', $tpl_name);
	
			$this->assign('user_name',   $admin_info['name']);
			$this->assign('reset_email', $reset_email);
			$this->assign('shop_name',   ecjia::config('shop_name'));
			$this->assign('send_date',   RC_Time::local_date(ecjia::config('date_format')));
				
			$state = ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR;
				
			if (RC_Mail::send_mail('', $admin_email, $template['template_subject'], $this->fetch_string($template['template_content']), $template['is_html'])) {
				$msg = __('重置密码的邮件已经发到您的邮箱：', 'staff') . $admin_email;
				$state = ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS;
			} else {
				$msg = __('重置密码邮件发送失败!请与管理员联系', 'staff');
			}
			//提示信息
			$link[0]['text'] = __('返回', 'staff');
			$link[0]['href'] = RC_Uri::url('staff/privilege/login');
			return $this->showmessage($msg, $state, array('links' => $link));
		} else {
			/* 提示信息 */
			return $this->showmessage(__('用户名与Email地址不匹配,请重新输入！', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	//处理逻辑
	public function reset_pwd_form(){
		$code = ! empty($_GET['code']) ? trim($_GET['code']) : '';
		$adminid = ! empty($_GET['uid']) ? intval($_GET['uid']) : 0;
	
		if ($adminid == 0 || empty($code)) {
			$href = RC_Uri::url('staff/privilege/login');
			$this->header("Location: $href\n");
			exit;
		}
	
		/* 以用户的原密码，与code的值匹配 */
		$password = RC_DB::table('staff_user')->where('user_id', $adminid)->value('password');
		if (md5($adminid . $password) != $code) {
			// 此链接不合法
			$link[0]['text'] =  __('返回', 'staff');
			$link[0]['href'] = RC_Uri::url('staff/privilege/login');
			return $this->showmessage(__('此链接不合法!', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$this->assign('adminid', $adminid);
			$this->assign('code', $code);
			$this->assign('form_act', 'reset_pwd');
		}
	
		$this->assign('ur_here', __('修改密码', 'staff'));
        return $this->display('get_pwd.dwt');
	}
	
	//重置新密码完成
	public function reset_pwd(){
		$new_password = isset($_POST['password']) ? trim($_POST['password']) : '';
		$confirm_pwd = isset($_POST['confirm_pwd']) ? trim($_POST['confirm_pwd']) : '';
		
		$adminid = isset($_POST['adminid']) ? intval($_POST['adminid']) : 0;
		$code = isset($_POST['code']) ? trim($_POST['code']) : '';
		 
		if (empty($new_password) || empty($code) || $adminid == 0) {
			$href = RC_Uri::url('staff/privilege/login');
			$this->header("Location: $href\n");
			exit();
		}


		/* 以用户的原密码，与code的值匹配 */
		$password = RC_DB::table('staff_user')->where('user_id', $adminid)->value('password');
	
		if (md5($adminid . $password) != $code) {
			// 此链接不合法
			$link[0]['text'] =  __('返回', 'staff');
			$link[0]['href'] = RC_Uri::url('staff/privilege/login');
			return $this->showmessage(__('此链接不合法!', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if ($new_password != $confirm_pwd) {
				return $this->showmessage(__('新密码和确认密码须保持一致', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			// 更新管理员的密码
			$salt = rand(1, 9999);
			$data = array(
				'password' => md5(md5($new_password) . $salt),
				'salt' => $salt
			);
	
			$result = RC_DB::table('staff_user')->where('user_id', $adminid)->update($data);
	
			if ($result) {
				$link[0]['text'] = __('返回', 'staff');
				$link[0]['href'] = RC_Uri::url('staff/privilege/login');
				return $this->showmessage(__('密码修改成功!', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				return $this->showmessage(__('密码修改失败!', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 手机快速找回页面,只输入手机号那个页面
	 */
	public function forget_fast() {
	
		$this->assign('form_act', 'reset_fast_pwd');

        return $this->display('get_pwd.dwt');
	}
	
	/**
	 * 找回密码页面
	 */
	public function fast_reset_pwd() {
		$mobile = $_POST['mobile'];
		if (!empty($mobile)) {
			if (RC_DB::table('staff_user')->where('mobile', $mobile)->count() == 0) {
				return $this->showmessage(__('该手机账号不存在，无法进行重置密码', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}else{
				$back_url = RC_Uri::url('staff/get_password/get_code', array('mobile' => $mobile));
				return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
			}
		}else{
			return $this->showmessage(__('手机号不能为空', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 手机快速找回页面
	 */
	public function get_code() {
		$this->assign('form_act', 'get_code');
		$mobile = $_GET['mobile'];
		$this->assign('mobile', $mobile);

        return $this->display('get_pwd.dwt');
	}
	
	public function get_code_value() {
		$mobile = $_GET['mobile'];
		$user_id = RC_DB::table('staff_user')->where('mobile', $mobile)->value('user_id');
		$code = rand(100000, 999999);
		$options = array(
			'mobile' => $mobile,
			'event'	 => 'sms_get_validate',
			'value'  =>array(
				'code' 			=> $code,
				'service_phone' => ecjia::config('service_phone'),
			),
		);
		
		$_SESSION['temp_user_id'] 	= $user_id;
		$_SESSION['temp_code'] 	= $code;
		$_SESSION['temp_code_time'] = RC_Time::gmtime();
		
		$response = RC_Api::api('sms', 'send_event_sms', $options);
		if (is_ecjia_error($response)) {
			return $this->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage(__('手机验证码发送成功，请注意查收', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}

	/**
	 * 第二步：再次验证校验码是否正确
	 */
	public function get_code_form() {
		$code = isset($_POST['code']) ? trim($_POST['code']) : '';

        if( $_SESSION['temp_code_time'] + 60*30 < RC_Time::gmtime()) {
            return $this->showmessage(__('验证码已过期，请重新获取', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

		if (!empty($code) && $code == $_SESSION['temp_code']) {
            $_SESSION['temp_code_input'] = $code;
			$back_url = RC_Uri::url('staff/get_password/mobile_reset', array('form_act' => 'reset_pwd'));
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
		}else{
			return $this->showmessage(__('请输入正确的手机校验码', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	public function mobile_reset(){
		$this->assign('form_act', 'mobile_reset');
        return $this->display('get_pwd.dwt');
	}
	
	public function mobile_reset_pwd(){
        if( $_SESSION['temp_code_time'] + 60*30 < RC_Time::gmtime()) {
            return $this->showmessage(__('验证码已过期，请重新获取', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
	    if(empty($_SESSION['temp_code_input']) || $_SESSION['temp_code_input'] != $_SESSION['temp_code']) {
            return $this->showmessage(__('验证码错误，请返回重新输入', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

		$new_password = isset($_POST['password']) ? trim($_POST['password']) : '';
		$confirm_pwd  = isset($_POST['confirm_pwd']) ? trim($_POST['confirm_pwd']) : '';
		if ($new_password != $confirm_pwd) {
			return $this->showmessage(__('新密码和确认密码须保持一致', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		// 更新管理员的密码
		$salt = rand(1, 9999);
		$data = array(
			'password' => md5(md5($new_password) . $salt),
			'salt'     => $salt
		);
		$result = RC_DB::table('staff_user')->where('user_id', $_SESSION['temp_user_id'])->update($data);
		if ($result) {
			$back_url = RC_Uri::url('staff/privilege/login');
			return $this->showmessage(__('密码重置成功', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
		} else {
			return $this->showmessage(__('密码修改失败!', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

//end