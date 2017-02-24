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
 * 员工登录、退出、找回密码
 */
class privilege extends ecjia_merchant {
	public function __construct() {
		parent::__construct();

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');		
	}

	/**
	 * 登录
	 */
	public function login() {
		
		//禁止以下css加载
		RC_Style::dequeue_style(array(
			'ecjia-mh-owl-theme',
			'ecjia-mh-owl-transitions',
			'ecjia-mh-table-responsive',
			'ecjia-mh-jquery-easy-pie-chart',
			'ecjia-mh-function',
			'ecjia-mh-page',
		));

		$this->assign('ur_here', '商家登录');
		$this->assign('shop_name', ecjia::config('shop_name'));
		$this->assign('logo_display', RC_Hook::apply_filters('ecjia_admin_logo_display', '<div class="logo"></div>'));
		
		$this->assign('form_action',RC_Uri::url('staff/privilege/signin'));
		
		$this->display('login.dwt');
	}
	
	/**
	 * 验证登陆信息
	 */
	public function signin() {
		$validate_error = RC_Hook::apply_filters('merchant_login_validate', $_POST);
		if (!empty($validate_error) && is_string($validate_error)) {
			return $this->showmessage($validate_error, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
		$password= isset($_POST['password']) ? trim($_POST['password']) : '';
		$row = RC_DB::table('staff_user')->where('mobile', $mobile)->first();
		if (!empty($row['salt'])) {
			if (!($row['mobile'] == $mobile && $row['password'] == md5(md5($password) . $row['salt']))) {
				$row = null;
			}
		} else {
			if (!($row['mobile'] == $mobile && $row['password'] == md5($password))) {
				$row = null;
			}
		}
		RC_Hook::do_action('ecjia_merchant_login_before', $row);
		if ($row) {
			$status = RC_DB::TABLE('store_franchisee')->where('store_id', $row['store_id'])->pluck('status');
			if ($status == 1) {
				$row['merchants_name'] = RC_DB::TABLE('store_franchisee')->where('store_id', $row['store_id'])->pluck('merchants_name');
				$this->admin_session($row['store_id'], $row['merchants_name'], $row['user_id'], $row['mobile'], $row['name'], $row['action_list'], $row['last_login']);
				if (empty($row['salt'])) {
					$salt = rand(1, 9999);
					$new_possword = md5(md5($password) . $salt);
					$data = array(
							'salt'	=> $salt,
							'password'	=> $new_possword
					);
					RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
				
					$row['salt'] = $data['salt'];
					$row['password'] = $data['password'];
				}
				
				if ($row['action_list'] == 'all' && empty($row['last_login'])) {
						$_SESSION['shop_guide'] = true; //商家开店导航设置开关
				}
				
				$data = array(
						'last_login' 	=> RC_Time::gmtime(),
						'last_ip'		=> RC_Ip::client_ip(),
				);
				RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
				$row['last_login'] = $data['last_login'];
				$row['last_ip'] = $data['last_ip'];
				
				if (isset($_POST['remember'])) {
					$time = 3600 * 24 * 7;
					RC_Cookie::set('ECJAP.staff_id', $row['user_id'], array('expire' => $time));
					RC_Cookie::set('ECJAP.staff_pass', md5($row['password'] . ecjia::config('hash_code')), array('expire' => $time));
				}
				RC_Hook::do_action('ecjia_merchant_login_after', $row);
				if(array_get($_SESSION, 'shop_guide')) {
					$back_url = RC_Uri::url('shopguide/merchant/init');
				}else{
					if (RC_Cookie::has('admin_login_referer')) {
						$back_url = RC_Cookie::get('admin_login_referer');
						RC_Cookie::delete('admin_login_referer');
					} else {
						$back_url = RC_Uri::url('merchant/dashboard/init');
					}
				}
				return $this->showmessage(__('登录成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
			} else {
				return $this->showmessage(__('该店铺已被锁定，暂无法登录'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(__('您输入的帐号信息不正确。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 退出
	 */
	public function logout() {
		/* 清除cookie */
		RC_Cookie::delete('ECJAP.staff_id');
		RC_Cookie::delete('ECJAP.staff_pass');
		
		RC_Session::destroy();
		return $this->redirect(RC_Uri::url('staff/privilege/login'));
	}
}

//end