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
 * 员工管理
 */
class merchant extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
		RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);
		// 步骤导航条
		RC_Style::enqueue_style('bar', RC_App::apps_url('statics/css/bar.css', __FILE__), array());
		RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__) , array() , false, true);
		
		RC_Script::enqueue_script('staff', RC_App::apps_url('statics/js/staff.js', __FILE__));
		/*查看日志js预加载*/
		RC_Script::enqueue_script('staff_logs', RC_App::apps_url('statics/js/staff_logs.js', __FILE__), array(), false, true);
		RC_Script::localize_script('staff_logs', 'js_lang', RC_Lang::get('staff::staff.js_lang'));
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('员工管理', RC_Uri::url('staff/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('staff', 'staff/merchant.php');
	}

	
	/**
	 * 员工列表页面
	 */
	public function init() {
	    $this->admin_priv('staff_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.staff_list')));
	    $this->assign('ur_here', '我的员工');
	    $this->assign('action_link', array('text' => RC_Lang::get('staff::staff.staff_add'), 'href' => RC_Uri::url('staff/merchant/add',array('step' => 1))));

	    $Manager = RC_DB::table('staff_user')->where('store_id',$_SESSION['store_id'])->where('parent_id', 0)->first();
	    $Manager['last_login'] = RC_Time::local_date('Y-m-d H:i', $Manager['last_login']);
	    $Manager['add_time'] = RC_Time::local_date('Y-m-d', $Manager['add_time']);
	    $this->assign('Manager', $Manager);
	    
	    $parent_id = RC_DB::TABLE('staff_user')->where('user_id', $_SESSION['staff_id'])->pluck('parent_id');
	    $this->assign('parent_id', $parent_id);
	    
	    $staff_list = $this->staff_list($_SESSION['store_id']);
	    $this->assign('staff_list', $staff_list);
	    
	    $this->assign('search_action',RC_Uri::url('staff/merchant/init'));
	   
	    $this->display('staff_list.dwt');
	}
	
	/**
	 * 添加员工页面
	 */
	public function add() {
		$this->admin_priv('staff_update');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.staff_add')));
		$this->assign('ur_here', RC_Lang::get('staff::staff.staff_add'));
		$this->assign('action_link',array('href' => RC_Uri::url('staff/merchant/init'),'text' => RC_Lang::get('staff::staff.staff_list')));
		
		$group_list = $this->get_group_select_list($_SESSION['store_id']);
		
		$this->assign('group_list', $group_list);
		$step = $_GET['step'];
		if ($step ==1) {
			$this->assign('form_action',RC_Uri::url('staff/merchant/insert_one', array('step' => 1)));
		} elseif($step ==2) {
			$this->assign('form_action',RC_Uri::url('staff/merchant/insert'));
		} else {
			$user_id = intval($_GET['id']);
			$staff = RC_DB::table('staff_user')->where('user_id', $user_id)->first();
			$staff['add_time']	= RC_Time::local_date('Y-m-d', $staff['add_time']);
			$staff['group_name'] = RC_DB::TABLE('staff_group')->where('group_id', $staff['group_id'])->pluck('group_name');
			if ($staff['group_id'] == -1) {
				$staff['group_name'] = '配送员';
			}
			$this->assign('staff', $staff);
		}
		$this->assign('step', $step);
		
		$manage_id = RC_DB::TABLE('staff_user')->where('user_id', $_SESSION['staff_id'])->pluck('parent_id');
		$this->assign('manage_id', $manage_id);
		
		$this->display('staff_info.dwt');
	}
	
	//触发按钮获取手机验证码
	public function get_code_value() {
		
		$count = RC_DB::table('staff_user')->where('store_id',$_SESSION['store_id'])->where('parent_id', '>', 0)->count();
		if($count >= 10){
			return $this->showmessage('抱歉，目前子员工数额已达到10个，不可再添加', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$mobile = $_GET['mobile'];
		if(empty($mobile)){
			return $this->showmessage('请输入员工手机号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if (RC_DB::table('staff_user')->where('mobile', $mobile)->count() > 0) {
			return $this->showmessage('该手机号已存在，请更换手机号再进行添加员工', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$code = rand(100000, 999999);
		$tpl_name = 'sms_get_validate';
		$tpl = RC_Api::api('sms', 'sms_template', $tpl_name);
		if (!empty($tpl)) {
			$this->assign('code', $code);
			$this->assign('service_phone', 	ecjia::config('service_phone'));
			$content = $this->fetch_string($tpl['template_content']);
			$options = array(
				'mobile' 		=> $mobile,
				'msg'			=> $content,
				'template_id' 	=> $tpl['template_id'],
			);
			$response = RC_Api::api('sms', 'sms_send', $options);
			if ($response === true) {
				$_SESSION['mobile'] 	= $mobile;
				$_SESSION['temp_code'] 	= $code;
				$_SESSION['temp_code_time'] = RC_Time::gmtime();
				return $this->showmessage('手机验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
				
			} else {
				return $this->showmessage('手机验证码发送失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		};
	}
	
	public function insert_one() {
		$code = $_POST['code'];
		$mobile = $_POST['mobile'];
		
		$count = RC_DB::table('staff_user')->where('store_id',$_SESSION['store_id'])->where('parent_id', '>', 0)->count();
		if($count >= 10){
			return $this->showmessage('抱歉，目前子员工数额已达到10个，不可再添加', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (RC_DB::table('staff_user')->where('mobile', $mobile)->count() > 0) {
			return $this->showmessage('该手机号已存在，请更换手机号再进行添加员工', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$time = RC_Time::gmtime() - 6000*3;
		if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/merchant/add', array('step' => 2))));
		}else{
			return $this->showmessage('请输入正确的手机校验码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 处理添加员工
	 */
	public function insert() {
		$this->admin_priv('staff_update', ecjia::MSGTYPE_JSON);
		
		$store_id = $_SESSION['store_id'];		
		$group_id = 0;
		$action_list = '';
		if (!empty($_POST['group_id'])) {
			if ($_POST['group_id'] > 0) {
				$action_list = RC_DB::TABLE('staff_group')
					->where('store_id', $store_id)
					->where('group_id', $_POST['group_id'])
					->pluck('action_list');
			}
			$group_id = $_POST['group_id'];
		}
		
		if (RC_DB::table('staff_user')->where('name', $_POST['name'])->where('store_id', $_SESSION['store_id'])->count() > 0) {
			return $this->showmessage('该员工名称已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (RC_DB::table('staff_user')->where('email', $_POST['email'])->count() > 0) {
			return $this->showmessage('该邮件账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$manager_id = RC_DB::TABLE('staff_user')->where('store_id',$_SESSION['store_id'])->where('parent_id', 0)->pluck('user_id');
		$data = array(
			'store_id' 	    => $store_id,
			'name' 		    => !empty($_POST['name']) 		? $_POST['name'] : '',
			'nick_name'     => !empty($_POST['nick_name']) 	? $_POST['nick_name'] : '',
			'user_ident'    => !empty($_POST['user_ident']) ? $_POST['user_ident'] : '',
			'mobile' 	    => $_SESSION['mobile'],
			'email' 	    => !empty($_POST['email']) 		? $_POST['email'] : '',
			'password' 	    => md5($_POST['password']),
			'group_id' 	    => $group_id,
			'action_list' 	=> $action_list,
			'todolist' 		=> !empty($_POST['todolist']) 	? $_POST['todolist'] : '',
			'add_time' 		=> RC_Time::gmtime(),
			'parent_id' 	=> $manager_id,
			'introduction' 	=> !empty($_POST['introduction']) 	? $_POST['introduction'] : '',
		);
		$staff_id = RC_DB::table('staff_user')->insertGetId($data);
		ecjia_merchant::admin_log($_POST['name'], 'add', 'staff');
		return $this->showmessage(RC_Lang::get('staff::staff.staff_add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/merchant/add', array('step' => 3,'id'=>$staff_id))));
	}
	
	/**
	 * 编辑员工页面
	 */
	public function edit() {
		$this->admin_priv('staff_update');
		
		$this->assign('ur_here',RC_Lang::get('staff::staff.staff_update'));
		$this->assign('action_link',array('href' => RC_Uri::url('staff/merchant/init'),'text' => RC_Lang::get('staff::staff.staff_list')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.staff_update')));
		
		$manage_id = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->pluck('parent_id'); 
		$this->assign('manage_id', $manage_id);
		
		$user_id = intval($_GET['user_id']);
		$staff = RC_DB::table('staff_user')->where('user_id', $user_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($staff)) {
			$links[] = array('text' => '返回员工列表', 'href' => RC_Uri::url('staff/merchant/init'));
			return $this->showmessage('该员工不存在', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}
		
		$staff['add_time']	= RC_Time::local_date('Y-m-d', $staff['add_time']);
		$this->assign('staff', $staff);
		$this->assign('store_id', $_SESSION['store_id']);
		$this->assign('parent_id', $_GET['parent_id']);
	
		$group_list = $this->get_group_select_list($_SESSION['store_id']);
		$this->assign('group_list', $group_list);
		
		$this->assign('form_action',RC_Uri::url('staff/merchant/update'));

		$this->display('staff_edit.dwt');
	}
	
	/**
	 * 编辑员工信息处理
	 */
	public function update() {
	    $this->admin_priv('staff_update', ecjia::MSGTYPE_JSON);
	    
		$user_id	= !empty($_POST['user_id'])		? intval($_POST['user_id'])	 : 0;
		$store_id 	= $_SESSION['store_id'];

		if (RC_DB::table('staff_user')->where('name', $_POST['name'])->where('user_id', '!=', $user_id)->where('store_id', $_SESSION['store_id'])->count() > 0) {
			return $this->showmessage('该员工名称已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$user_ident = !empty($_POST['user_ident'])	? trim($_POST['user_ident']) 	: '';
		$name 		= !empty($_POST['name'])		? trim($_POST['name']) 			: '';
		
		if ($_SESSION['staff_id'] == $user_id) {
			$_SESSION['staff_name'] = $name;
		}
		
		$nick_name 	  = !empty($_POST['nick_name'])	    ? trim($_POST['nick_name']) 	           : '';
		$mobile 	  = !empty($_POST['mobile'])		? trim($_POST['mobile']) 		           : '';
		$email		  = !empty($_POST['email'])		    ? trim($_POST['email'])	 		           : '';
		$todolist	  = !empty($_POST['todolist'])	    ? trim($_POST['todolist'])	 	           : '';
		$salt 		  = rand(1, 9999);
		$password     = !empty($_POST['new_password'])  ? md5(md5($_POST['new_password']) . $salt) : '';
		$introduction = !empty($_POST['introduction'])  ? trim($_POST['introduction'])			   : '';
		
		//如果要修改密码
		$pwd_modified = false;
		if (!empty($_POST['new_password'])) {
			$pwd_modified = true;
		}
		
		//更新管理员信息
		if ($pwd_modified) {
			$data = array(
				'user_ident'	=> $user_ident,
				'name'			=> $name,
				'nick_name'		=> $nick_name,
				'mobile'		=> $mobile,
				'email'			=> $email,
				'todolist'		=> $todolist,
				'introduction'	=> $introduction,
				'salt'			=> $salt,
				'password'		=> $password,
			);
		} else {
			$data = array(
				'user_ident'	=> $user_ident,
				'name'			=> $name,
				'nick_name'		=> $nick_name,
				'mobile'		=> $mobile,
				'email'			=> $email,
				'todolist'		=> $todolist,
				'introduction'	=> $introduction,
			);
		}
	
		if($_POST['parent_id'] !=0){
			$group_id = $_POST['group_id'];
			$action_list = '';
			if ($_POST['group_id'] > 0) {
				$action_list	= RC_DB::TABLE('staff_group')
				->where('group_id', $group_id)
				->pluck('action_list');;
			}
			$data['action_list']	= $action_list;
			$data['group_id']		= $group_id;
		}
		RC_DB::table('staff_user')->where('user_id', $user_id)->where('store_id', $_SESSION['store_id'])->update($data);
		ecjia_merchant::admin_log($name, 'edit', 'staff');
		return $this->showmessage(RC_Lang::get('staff::staff.staff_edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/merchant/edit', array('user_id' => $user_id,'parent_id'=>$_POST['parent_id']))));
	}
	
	/**
	 * 员工权限页面加载
	 */
	public function allot() {
		$this->admin_priv('staff_allot');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('员工分派权限')));
		$this->assign('action_link',	array('href'=>RC_Uri::url('staff/merchant/init'), 'text' => __('管理员列表')));

		$priv_row = RC_DB::table('staff_user')->where('user_id', $_GET['user_id'])->select('name', 'action_list')->first();
		$user_name = $priv_row['name'];
		$priv_str = $priv_row['action_list'];
		
		$priv_group = ecjia_merchant_purview::load_purview($priv_str);
		$this->assign('priv_group',	$priv_group);
		
		$this->assign('ur_here', sprintf(__('分派权限 [ %s ] '), $user_name));
		$this->assign('user_id', $_GET['user_id']);
		
		$this->assign('form_action',	RC_Uri::url('staff/merchant/update_allot'));
		
		$this->display('staff_allot.dwt');
	}

	/**
	 * 更新员工的权限
	 */
	public function update_allot() {
		$this->admin_priv('staff_allot', ecjia::MSGTYPE_JSON);
		 
		$name = RC_DB::table('staff_user')->where('user_id', $_POST['user_id'])->pluck('name');
		$action_list = join(',', $_POST['action_code']);
		$data = array(
			'action_list'	=> $action_list,
			'group_id'		=> '',
		);
		RC_DB::table('staff_user')->where('user_id', $_POST['user_id'])->update($data);
		ecjia_merchant::admin_log($name, 'edit', 'staff');

		return $this->showmessage(sprintf(__('编辑 %s 员工权限操作成功'), $name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/merchant/allot', array('user_id' => $_POST['user_id']))));
	}
	
	/**
	 * 删除员工
	 */
	public function remove() {
		$this->admin_priv('staff_remove', ecjia::MSGTYPE_JSON);
		
		$user_id = intval($_GET['user_id']);
		$db_staff_user = RC_DB::table('staff_user');
		
		$db_staff_user->where(RC_DB::raw('user_id'), $user_id);
		$db_staff_user->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		
		/* 不允许删除主员工*/
		if ($user_id == $_SESSION['staff_id']) {
			return $this->showmessage(RC_Lang::get('staff::staff.no_remove_admin'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$name = $db_staff_user->pluck('name');
		
		if ($db_staff_user->delete()) {
			RC_Session::session()->delete_spec_admin_session($user_id); // 删除session中该管理员的记录
			ecjia_merchant::admin_log($name, 'remove', 'staff');
			return $this->showmessage(RC_Lang::get('staff::staff.delete_success'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('staff/merchant/init')));
		} else {
			return $this->showmessage(RC_Lang::get('staff::staff.delete_fail'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 获取员工列表信息
	 */
	private function staff_list($store_id) {
		$db_staff_user = RC_DB::table('staff_user');
		
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		if ($filter['keywords']) {
			$db_staff_user->where('name', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
		
		$db_staff_user->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		$db_staff_user->where(RC_DB::raw('parent_id'), '<>', 0);
		
		$count = $db_staff_user->count();
		$page = new ecjia_merchant_page($count,10, 5);
		$data = $db_staff_user
		->selectRaw('user_ident,parent_id,user_id,name,nick_name,mobile,email,group_id,last_login')
		->orderby('user_id', 'asc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		$res = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['last_login'] = RC_Time::local_date(ecjia::config('time_format'), $row['last_login']);
				$row['group_name'] = RC_DB::TABLE('staff_group')->where('group_id', $row['group_id'])->pluck('group_name');
				$res[] = $row;
			}
		}
		return array('staff_list' => $res, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
	
	/**
	 * 获取员工组信息
	 */
	private function get_group_select_list($store_id) {
		$data = RC_DB::table('staff_group')
    		->select('group_id', 'group_name')
    		->where('store_id', $store_id)
    		->orderBy('group_id', 'desc')
    		->get();
		$group_list = array();
		/* 设置默认员工组（配送员）*/
		$group_list = array('-1' => '配送员');
		
		if (!empty($data)) {
			foreach ($data as $row ) {
				$group_list[$row['group_id']] = $row['group_name'];
			}
		}
		return $group_list;
	}
}

//end