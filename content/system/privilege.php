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
 * ECJIA 管理员信息以及权限管理程序
 */
defined('IN_ECJIA') or exit('No permission resources.');

class privilege extends ecjia_admin {
	
	private $db_admin_user;
	private $db_role;

	/**
	 * 析构函数
	 */
	public function __construct() {
		parent::__construct();
		
		$this->db_admin_user = RC_Model::model('admin_user_model');
		$this->db_role = RC_Loader::load_model('role_model');

		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-validate');
		
		RC_Script::enqueue_script('ecjia-admin_privilege');
		
		$admin_privilege_jslang = array(
				'no_edit'				=> __('此管理员不可以编辑！'),
				'pls_name'				=> __('请输入用户名！'),
				'name_length_check'		=> __('用户名长度不能小于2！'),
				'pls_email'				=> __('请输入邮箱地址！'),
				'email_check'			=> __('请输入正确的邮箱格式！'),
				'pls_password'			=> __('请输入密码！'),
				'password_length_check'	=> __('密码长度不能小于6！'),
				'check_password'		=> __('两次密码不一致！'),
		);
		RC_Script::localize_script('ecjia-admin_privilege', 'admin_privilege', $admin_privilege_jslang );
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员管理'), RC_Uri::url('@privilege/init')));
	}
	
	
	/**
	 * 管理员列表页面
	 */
	public function init() {
		$this->admin_priv('admin_manage');
				
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员列表')));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台管理员列表页面，系统中所有的管理员都会显示在此列表中。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E7.AE.A1.E7.90.86.E5.91.98.E5.88.97.E8.A1.A8" target="_blank">关于管理员列表帮助文档</a>') . '</p>'
		);
		
		$key_type = !empty($_REQUEST['key_type']) ? intval($_REQUEST['key_type']) : 1;
		$keyword = !empty($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		
		$where = array();
		switch ($key_type) {
			case 2:
				if (!empty($keyword)) {
					$where['user_id'] = "$keyword";
				}
				break;
			case 3:
				if (!empty($keyword)) {
					$where['email'] = array('like' => "%$keyword%");
				}
				break;
			case 1:
				if (!empty($keyword)) {
					$where['user_name'] = array('like' => "%$keyword%");
				}
			default :
				break;
		}
		
		$filter = array();
		$filter['sort_by']      = !empty($_GET['sort_by']) ? safe_replace($_GET['sort_by']) : 'user_id';
		$filter['sort_order']   = !empty($_GET['sort_order']) ? safe_replace($_GET['sort_order']) : 'DESC';
		
		$this->assign('ur_here',		__('管理员列表'));
		$this->assign('action_link',	array('href' => RC_Uri::url('@privilege/add'), 'text' => __('添加管理员')));
		
		$this->assign('full_page',		1);
		$this->assign('admin_list',		$this->db_admin_user->get_admin_userlist($where, $filter));
	
		$this->display('privilege_list.dwt');
	}
	
	/**
	 * 登录界面
	 */
	public function login() {
// 		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// 		header("Cache-Control: no-cache, must-revalidate");
// 		header("Pragma: no-cache");
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

		$this->assign('form_action',RC_Uri::url('@privilege/signin'));
		$this->assign('logo_display', RC_Hook::apply_filters('ecjia_admin_logo_display', '<div class="logo"></div>'));
		$this->display('login.dwt');
	}
	
	/**
	 * 退出登录
	 */
	public function logout() {
		/* 清除cookie */
		RC_Cookie::delete('ECJAP[admin_id]');
		RC_Cookie::delete('ECJAP[admin_pass]');

		RC_Session::destroy();
		return $this->redirect(RC_Uri::url('@privilege/login'));
	}
	
	/**
	 * 验证登录信息
	 */
	public function signin() {
		// 登录时验证
		$validate_error = RC_Hook::apply_filters( 'admin_login_validate', $_POST);
		if (!empty($validate_error) && is_string($validate_error)) {
			return $this->showmessage($validate_error, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$_POST['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
		$_POST['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';
		
//  		$ec_salt = $this->db_admin_user->where(array('user_name' => $_POST['username']))->get_field('ec_salt');
//  		/* 检查密码是否正确 */
// 		if (!empty($ec_salt)) {
// 			$row = $this->db_admin_user->field('user_id, user_name, password, last_login, action_list, last_login, suppliers_id, ec_salt')
// 					->find(array('user_name' => $_POST['username'], 'password' => md5(md5($_POST['password']).$ec_salt)));
// 		} else {
// 			$row = $this->db_admin_user->field('user_id, user_name, password, last_login, action_list, last_login, suppliers_id, ec_salt')
// 					->find(array('user_name' => $_POST['username'], 'password' => md5($_POST['password'])));
// 		}
		
		$row = $this->db_admin_user->where(array('user_name' => $_POST['username']))->find();
		if (!empty($row['ec_salt'])) {
		    if (!($row['user_name'] == $_POST['username'] && $row['password'] == md5(md5($_POST['password']) . $row['ec_salt']))) {
		        $row = null;
		    }
		} else {
		    if (!($row['user_name'] == $_POST['username'] && $row['password'] == md5($_POST['password']))) {
		        $row = null;
		    }
		}
		RC_Hook::do_action('ecjia_admin_login_before', $row);

		if ($row) {
			// 登录成功
			$this->admin_session($row['user_id'], $row['user_name'], $row['action_list'], $row['last_login']);
			$_SESSION['suppliers_id'] = $row['suppliers_id'];
			if (empty($row['ec_salt']) && $this->db_admin_user->field_exists('ec_salt')) {
				$ec_salt = rand(1, 9999);
				$new_possword = md5(md5($_POST['password']) . $ec_salt);
				$data = array(
					'ec_salt'	=> $ec_salt,
					'password'	=> $new_possword
				);
				$this->db_admin_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);
				$row['ec_salt'] = $data['ec_salt'];
				$row['password'] = $data['password'];
			}
			//是否开启开店向导
			$result = ecjia_app::validate_application('shopguide');
			if (!is_ecjia_error($result)) {
				if ($row['action_list'] == 'all' && empty($row['last_login'])) {
					$_SESSION['shop_guide'] = true;
				}
			}
			$data = array(
				'last_login' 	=> RC_Time::gmtime(),
				'last_ip'		=> RC_Ip::client_ip(),
			);
			$this->db_admin_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);
			$row['last_login'] = $data['last_login'];
			$row['last_ip'] = $data['last_ip'];

			if (isset($_POST['remember'])) {
				$time = 3600 * 24 * 7;
				RC_Cookie::set('ECJAP[admin_id]', $row['user_id'], array('expire' => $time));
				RC_Cookie::set('ECJAP[admin_pass]', md5($row['password'] . ecjia::config('hash_code')), array('expire' => $time));				
			}
			RC_Hook::do_action('ecjia_admin_login_after', $row);
			
			if(array_get($_SESSION, 'shop_guide')) {
				$back_url = RC_Uri::url('shopguide/admin/init');
			}else{
				if (RC_Cookie::get('admin_login_referer')) {
					$back_url = RC_Cookie::get('admin_login_referer');
					RC_Cookie::delete('admin_login_referer');
				} else {
					$back_url = RC_Uri::url('@index/init');
				}
			}
			return $this->showmessage(__('登录成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
		} else {
			return $this->showmessage(__('您输入的帐号信息不正确。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	
	/**
	 * 添加管理员页面
	 */
	public function add() {
		$this->admin_priv('admin_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加管理员')));
		
		/* 模板赋值 */
		$this->assign('ur_here'		, __('添加管理员'));
		$this->assign('action_link'	, array('href'=>RC_Uri::url('@privilege/init'), 'text' => __('管理员列表')));
		$this->assign('form_link'	, RC_Uri::url('@privilege/insert'));
		$this->assign('pjax_link'	, RC_Uri::url('@privilege/edit'));
		$this->assign('action'		, 'add');
		$this->assign('select_role'	, $this->db_role->get_role_list());
		
		$this->display('privilege_info.dwt');
	}
	
	/**
	 * 添加管理员的处理
	 */
	public function insert() {
		$this->admin_priv('admin_manage');
		
 		if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['password'])) {
			return $this->showmessage(__('数据不完整'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 判断管理员是否已经存在 */
		if (!empty($_POST['user_name'])) {
			$is_only = $this->db_admin_user->is_only(array("user_name" => stripslashes($_POST['user_name'])));
			if (!$is_only) {
				return $this->showmessage(sprintf(__('该管理员 %s 已经存在！'), stripslashes($_POST['user_name'])),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		/* Email地址是否有重复 */
		if (!empty($_POST['email'])) {
			$is_only = $this->db_admin_user->is_only(array("email" => stripslashes($_POST['email'])));
			if (!$is_only) {
				return $this->showmessage(sprintf(__('该Email地址 %s 已经存在！'), stripslashes($_POST['email'])),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		/* 获取添加日期及密码 */
		$add_time = RC_Time::gmtime();
		$password = md5($_POST['password']);
		$role_id = '';
		$action_list = '';
		if (!empty($_POST['select_role'])) {
			$row = $this->db_role->field('action_list')->find('role_id = "'.$_POST['select_role'].'"');	
			$action_list = $row['action_list'];
			$role_id = $_POST['select_role'];
		}
		//$row = $this->db_admin_user->field('nav_list')->find('action_list = "all"');
		$data = array(
				'user_name'		=> trim($_POST['user_name']),
				'email'			=> trim($_POST['email']),
				'password'		=> $password,
				'add_time'		=> $add_time,
				//'nav_list'		=> $row[nav_list],
				'action_list'	=> $action_list,
				'role_id'		=> $role_id,
		);
	 	$new_id = $this->db_admin_user->insert($data);

		/*添加链接*/
		$link[0]['text'] = __('设置管理员权限');
		$link[0]['href'] = RC_Uri::url('@privilege/allot', 'id='.$new_id.'&user='.$_POST['user_name']);
		$link[1]['text'] = __('继续添加管理员');
		$link[1]['href'] = RC_Uri::url('@privilege/add');

		/* 记录管理员操作 */
		ecjia_admin::admin_log($_POST['user_name'], 'add', 'privilege');	
		return $this->showmessage(sprintf(__('添加 %s 操作成功'),$_POST['user_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link, 'id' => $new_id));
	}
	
	/**
	 * 编辑管理员信息
	 */
	public function edit() {
		/* 不能编辑demo这个管理员 */
		if ($_SESSION['admin_name'] == 'demo') {
			$link[] = array('text' => __('返回管理员列表'), 'href'=>RC_Uri::url('@privilege/init'));
			return $this->showmessage(__('您不能对此管理员的权限进行任何操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('link'=>$link));
		}
		$_REQUEST['id'] = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		
		/* 查看是否有权限编辑其他管理员的信息 */
		if ($_SESSION['admin_id'] != $_REQUEST['id']) {
			$this->admin_priv('admin_manage');
		}

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑管理员')));
		
		/* 获取管理员信息 */
		$user_info = $this->db_admin_user->field('user_id, user_name, email, password, agency_id, role_id')->find('user_id = "'.$_REQUEST['id'].'"');
		
		/* 取得该管理员负责的办事处名称 */
		if ($user_info['agency_id'] > 0) {
			$data = $this->db_agency->field('agency_name')->find('agency_id = "'.$user_info['agency_id'].'"');	
			$user_info['agency_name'] = $data['agency_name'];
		}
		
		/* 模板赋值 */
		$this->assign('ur_here',		__('编辑管理员'));
		$this->assign('action_link',	array('text' => __('管理员列表'), 'href' => RC_Uri::url('@privilege/init')));
		$this->assign('user',			$user_info);
		
		/* 获得该管理员的权限 */
		$priv_arr = $this->db_admin_user->field('action_list')->find('user_id = '.$_GET['id'].'');
		$priv_str = $priv_arr['action_list'];
		
		if ($_SESSION['action_list'] == 'all' && $priv_str != 'all') {
			$this->assign('no_oldpwd',	1);
		}
		
		/* 如果被编辑的管理员拥有了all这个权限，将不能编辑 */
		if ($priv_str != 'all') {
			$this->assign('select_role', $this->db_role->get_role_list());
		}
		$this->assign('form_link',		RC_Uri::url('@privilege/update'));
		$this->assign('pjax_link',		RC_Uri::url('@privilege/edit'));
		$this->assign('action',			'edit');
		$this->assign('form_action',	RC_Uri::url('@privilege/update'));
		
		$this->display('privilege_info.dwt');
	}
	
	/**
	 * 更新管理员信息
	 */
	public function update() {
		/* 变量初始化 */
		$admin_id		= !empty($_REQUEST['id'])			? intval($_REQUEST['id'])	 : 0;
		$admin_name 	= !empty($_REQUEST['user_name'])	? trim($_REQUEST['user_name']) : '';
		$admin_email 	= !empty($_REQUEST['email'])		? trim($_REQUEST['email'])	 : '';
		$ec_salt = rand(1, 9999);
		$password = !empty($_POST['new_password']) ? md5(md5($_POST['new_password']) . $ec_salt) : '';
		/* 查看是否有权限编辑其他管理员的信息 */
		if ($_SESSION['admin_id'] != $_REQUEST['id']) {
			$this->admin_priv('admin_manage');
		}
		$g_link = RC_Uri::url('@privilege/init');
		$nav_list = '';

		/* 判断管理员是否已经存在 */
		if (!empty($_POST['user_name'])) {
			$is_only = $this->db_admin_user->is_only(
				array(
					"user_name"	=> stripslashes($_POST['user_name']),
					"user_id"	=> array('neq' => $admin_id)
				)
			);
			if (!$is_only) {
				return $this->showmessage(sprintf(__('该管理员 %s 已经存在！'), stripslashes($_POST['user_name'])), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		/* Email地址是否有重复 */
		if (!empty($_POST['email'])) {
			$is_only = $this->db_admin_user->is_only(
				array(
					"email"		=> stripslashes($_POST['email']),
					"user_id"	=> array('neq' => $admin_id)
				)
			);
		
			if (!$is_only) {
				return $this->showmessage(sprintf(__('该Email地址 %s 已经存在！'), stripslashes($_POST['email'])), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$user_action = $this->db_admin_user->where(array('user_id' => $admin_id))->get_field('`action_list`');
		if ($user_action == 'all') {
			return $this->showmessage(sprintf(__('超级管理员 %s 不可被修改！'), stripslashes($_POST['user_name'])), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//如果要修改密码
		$pwd_modified = false;
		
		if (!empty($_POST['new_password'])) {
			if ($_SESSION['action_list'] != 'all') {
				$row = $this->db_admin_user->field('`password`, `ec_salt`')->find(array('user_id' => $admin_id));
				$old_password = $row['password'];
				$old_ec_salt = $row['ec_salt'];
				
				if (empty($old_ec_salt)) {
					$old_ec_password = md5($_POST['old_password']);
				} else {
					$old_ec_password = md5(md5($_POST['old_password']) . $old_ec_salt);
				}
	
				if ($old_password != $old_ec_password) {
					$link[] = array('text' => __('返回上一页'), 'href'=>'javascript:history.back(-1)');
					return $this->showmessage(__('输入的旧密码错误！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		
			/* 比较新密码和确认密码是否相同 */
			if ($_POST['new_password'] != $_POST['pwd_confirm']) {
				$link[] = array('text' => __('返回上一页'), 'href'=>'javascript:history.back(-1)'); 
				return $this->showmessage(__('两次输入的密码不一致！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$pwd_modified = true;
			}
		}
		$role_id = '';
		$action_list = '';
		if (!empty($_POST['select_role'])) {
			$row			= $this->db_role->field('action_list')->find('role_id = "'.$_POST['select_role'].'"');
			$action_list	= $row['action_list'];
			$role_id		= $_POST['select_role'];
		}
		//更新管理员信息
		if ($pwd_modified) {
			$data = array(
				'user_name'		=> $admin_name,
				'email'			=> $admin_email,
				'ec_salt'		=> $ec_salt,
				'password'		=> $password,
			);
		} else {
			$data = array(
				'user_name'		=> $admin_name,
				'email'			=> $admin_email,
			);
		}
		if (!empty($action_list)) {
			$data['action_list']	= $action_list;
		}
		if (!empty($role_id)) {
			$data['role_id']		= $role_id;	
		}
		if (!empty($nav_list)) {
			$data['nav_list']		= $nav_list;	
		}

		$this->db_admin_user->where('user_id = '.$admin_id.'')->update($data);
        /* 记录日志 */
        ecjia_admin_log::instance()->add_object('admin_user', __('管理员账号'));
		ecjia_admin::admin_log($_POST['user_name'], 'edit', 'admin_user');
		$msg = __('您已经成功的修改了个人帐号信息！');
		
		/* 提示信息 */
		$link[] = array('text' => strpos($g_link, 'list') ? __('返回管理员列表') : __('编辑个人资料'), 'href'=>$g_link);
		return $this->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('link' => $link, 'id' => $admin_id));
	}
	
	/**
	 * 更新管理员信息
	 */
	public function update_self() {
		/* 变量初始化 */
		$admin_id		= !empty($_REQUEST['id'])		? intval($_REQUEST['id'])	 : 0;
		$admin_email	= !empty($_REQUEST['email'])	 ? trim($_REQUEST['email'])	 : '';
		$ec_salt		= rand(1, 9999);
		
		$password		= !empty($_POST['new_password']) ? md5(md5($_POST['new_password']) . $ec_salt) : '';
		$nav_list		= !empty($_POST['nav_list']) ? @join(",", $_POST['nav_list']) : '';

		$admin_oldemail	= $this->db_admin_user->field('email')->find(array("user_id" => $admin_id));
		$admin_oldemail	= $admin_oldemail['email'];
		/* Email地址是否有重复 */
		if ($admin_email && $admin_email != $admin_oldemail) {
			$is_only = $this->db_admin_user->is_only(array("email" => stripslashes($admin_email)));
			if (!$is_only) {
				return $this->showmessage(sprintf(__('该Email地址 %s 已经存在！'), stripslashes($admin_email)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		//如果要修改密码
		$pwd_modified = false;
		
		if (!empty($_POST['new_password'])) {
			/* 查询旧密码并与输入的旧密码比较是否相同 */
			$old_password	= $this->db_admin_user->where(array("user_id" => $admin_id))->get_field('password');
			$old_ec_salt	= $this->db_admin_user->where(array("user_id" => $admin_id))->get_field('ec_salt');
			
			if (empty($old_ec_salt)) {
				$old_ec_password = md5($_POST['old_password']);
			} else {
				$old_ec_password = md5(md5($_POST['old_password']).$old_ec_salt);
			}
			if ($old_password != $old_ec_password) {
				return $this->showmessage(__('输入的旧密码错误！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		
			/* 比较新密码和确认密码是否相同 */
			if ($_POST['new_password'] != $_POST['pwd_confirm']) {
				return $this->showmessage(__('两次输入的密码不一致！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$pwd_modified = true;
			}
		}

		//更新管理员信息
		if ($pwd_modified) {
			$data = array(
				'email'		=> $admin_email,
				'ec_salt'	=> $ec_salt,
				'password'	=> $password,
				'nav_list'	=> $nav_list
			);
		} else {
			$data = array(
				'email'		=> $admin_email,
				'nav_list'	=> $nav_list
			);
		}	
		
		$this->db_admin_user->where(array("user_id" => $admin_id))->update($data);

		/* 记录管理员操作 */
		ecjia_admin_log::instance()->add_object('admin_modif', __('个人资料'));
		ecjia_admin::admin_log($_SESSION['admin_name'], 'edit', 'admin_modif');
		
		/* 清除用户缓存 */
		RC_Cache::userdata_cache_delete('admin_navlist', $admin_id, true);
		
		if ($pwd_modified) {
			/* 如果修改了密码，则需要将session中该管理员的数据清空 */
			RC_Session::session()->delete_spec_admin_session($_SESSION['admin_id']); // 删除session中该管理员的记录
			$msg = __('您已经成功的修改了密码，因此您必须重新登录！');
		} else {
			$msg = __('修改个人资料成功！');
		}

		return $this->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@privilege/modif')));
	}
	
	
	/**
	 * 编辑个人资料
	 */
	public function modif() {
		/* 不能编辑demo这个管理员 */
		if ($_SESSION['admin_name'] == 'demo') {
			$link[] = array('text' => __('返回管理员列表'), 'href' => RC_Uri::url('@privilege/init'));
			return $this->showmessage(__('您不能对此管理员的权限进行任何操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$modules = RC_Loader::load_sys_config("menu");
		$purview = RC_Loader::load_sys_config("priv");
		
		
		RC_Script::enqueue_script('jquery-complexify', RC_Uri::admin_url() . '/statics/lib/complexify/jquery.complexify.min.js', array('jquery'), false, true);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑个人资料')));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台编辑个人资料页面，用户可在此编辑个人资料。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:个人设置" target="_blank">关于编辑个人资料帮助文档</a>') . '</p>'
		);
		

		$user_info = $this->db_admin_user->field('user_id, user_name, email')->find('user_id = "'.$_SESSION['admin_id'].'"');

		/* 获取导航条 */
		$nav_list = $this->db_admin_user->get_nav_list();
		$menus_list = ecjia_admin_menu::singleton()->admin_menu();
		
		/* 模板赋值 */
		$this->assign('ur_here', __('编辑个人资料'));
		$this->assign('action_link', array('text' => __('管理员列表'), 'href'=>RC_Uri::url('@privilege/init')));
		$this->assign('form_link', RC_Uri::url('@privilege/update_self'));
		$this->assign('user', $user_info);
		$this->assign('modules', $modules);
		$this->assign('menus_list', $menus_list);
		$this->assign('nav_arr', $nav_list);
		$this->assign('action', 'modif');
		$this->assign('_FILE_STATIC', RC_Uri::admin_url('statics/'));
		
		$this->assign('form_action', RC_Uri::url('@privilege/update_self'));
		
		$this->display('privilege_info.dwt');
	}
	
	/**
	 * 为管理员分配权限
	 */
	public function allot() {
		$this->admin_priv('allot_priv');
		if ($_SESSION['admin_id'] == $_GET['id']) {
			$this->admin_priv('all');
		}
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('分派权限')));
		
		/* 获得该管理员的权限 */
		$priv_row = $this->db_admin_user->field('user_name, action_list')->find('user_id = '.$_GET['id'].'');
		$user_name = $priv_row['user_name'];
		$priv_str = $priv_row['action_list'];
	
		/* 如果被编辑的管理员拥有了all这个权限，将不能编辑 */
		if ($priv_str == 'all') {
			$link[] = array('text' => __('返回管理员列表'), 'href' => RC_Uri::url('@privilege/init'));
			return $this->showmessage(__('您不能对此管理员的权限进行任何操作！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$priv_group = ecjia_purview::load_purview($priv_str);
		
		/* 赋值 */
		$this->assign('ur_here',		sprintf(__('分派权限 [ %s ] '), $user_name));
		$this->assign('action_link',	array('href'=>RC_Uri::url('@privilege/init'), 'text' => __('管理员列表')));
		$this->assign('priv_group',		$priv_group);
		$this->assign('user_id',		$_GET['id']);
		
		/* 显示页面 */
		$this->assign('form_action',	RC_Uri::url('@privilege/update_allot'));
		
		$this->display('privilege_allot.dwt');
	}

	/**
	 * 更新管理员的权限
	 */
	public function update_allot() {
		$this->admin_priv('admin_manage');
		/* 取得当前管理员用户名 */
		$admin_name = $this->db_admin_user->field('user_name')->find('user_id = '.$_POST['id'].'');
		
		/* 更新管理员的权限 */
		$act_list = join(',', $_POST['action_code']);
		$data = array(
				'action_list'	=> $act_list,
				'role_id'		=> '',
		);
		$this->db_admin_user->where(array('user_id' => $_POST['id']))->update($data);
		
		/* 动态更新管理员的SESSION */
		if ($_SESSION['admin_id'] == $_POST['id']) {
			$_SESSION['action_list'] = $act_list;
		}
		
		/* 记录管理员操作 */
		ecjia_admin::admin_log(addslashes($admin_name['user_name']), 'edit', 'privilege');
		/* 提示信息 */
		$link[] = array(
			'text'	=> __('返回管理员列表'), 
			'href'	=> RC_Uri::url('@privilege/init')
		);
		return $this->showmessage(sprintf(__('编辑 %s 操作成功！'), $admin_name['user_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('link'	=> $link));
	}
	
	
	/**
	 * 删除一个管理员
	 */
	public function remove() {
		$this->admin_priv('admin_drop', ecjia::MSGTYPE_JSON);
		$id = intval($_GET['id']);
		
		/* 获得管理员用户名 */
		$admin_name = $this->db_admin_user->field('user_name')->find('user_id = '.$id.'');
		
		/* demo这个管理员不允许删除 */
		if ($admin_name == 'demo') {
			return $this->showmessage(__('您不能删除demo这个管理员！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* ID为1的不允许删除 */
		if ($id == 1) {
			return $this->showmessage(__('此管理员您不能进行删除操作！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 管理员不能删除自己 */
		if ($id == $_SESSION['admin_id']) {
			return $this->showmessage(__('您不能删除自己！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($this->db_admin_user->drop($id)) {
			RC_Session::session()->delete_spec_admin_session($id); // 删除session中该管理员的记录
            /* 记录日志 */
            ecjia_admin_log::instance()->add_object('admin_user', __('管理员账号'));
			ecjia_admin::admin_log(addslashes($admin_name['user_name']), 'remove', 'admin_user');
			return $this->showmessage(__('删除成功！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(__('操作失败！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end