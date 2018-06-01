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
 * 配送员管理
 * @author songqianqian
 */
class admin_express extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-region');
		RC_Script::enqueue_script('qq_map', 'https://map.qq.com/api/js?v=2.exp');
		
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('admin_express', RC_App::apps_url('statics/js/admin_express.js', __FILE__));
		RC_Style::enqueue_style('admin_express', RC_App::apps_url('statics/css/admin_express.css', __FILE__));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('配送员管理', RC_Uri::url('express/admin_express/init')));
	}
	
	/**
	 * 配送员列表页加载
	 */
	public function init() {
		$this->admin_priv('express_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('配送员管理'));
		$this->assign('ur_here', '配送员列表');
		$this->assign('action_link', array('text' => '添加配送员', 'href' => RC_Uri::url('express/admin_express/add')));
		
		$type = trim($_GET['type']);
		$this->assign('type', $type);
		$data = $this->get_express_list($type);
		$this->assign('data', $data);
		$this->assign('type_count', $data['count']);
		$this->assign('filter', $data['filter']);
		$this->assign('search_action', RC_Uri::url('express/admin_express/init'));

		$this->display('express_list.dwt');
	}
	
	/**
	 * 添加配送员
	 */
	public function add() {
		$this->admin_priv('express_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加配送员'));
		$this->assign('ur_here', '添加配送员');
		$this->assign('action_link', array('text' => '配送员列表', 'href' => RC_Uri::url('express/admin_express/init')));
		
        $provinces = ecjia_region::getSubarea(ecjia::config('shop_country'));
        $this->assign('province', $provinces);
		
		$this->assign('form_action', RC_Uri::url('express/admin_express/insert'));
		
		$this->display('express_edit.dwt');
	}
	
	/**
	 * 添加配送员处理
	 */
	public function insert() {
		$this->admin_priv('express_update');
		
		$mobile = trim($_POST['mobile']);
		$email  = trim($_POST['email']);
		$shippingfee_percent = intval($_POST['shippingfee_percent']);
		$work_type = intval($_POST['work_type']);
		$address   = trim($_POST['address']);
		$password  = empty($_POST['password']) ? ''	: trim($_POST['password']);
		
		if (!preg_match('/^1(3|4|5|7|8)\d{9}$/', $mobile)) {
			return $this->showmessage('手机号码格式错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		} 
	   	$is_exist_mobile = RC_DB::table('staff_user')->where('mobile', $mobile)->get();
        if ($is_exist_mobile) {
            return $this->showmessage('手机号已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if (!preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/', $email)) {
        	return $this->showmessage('email地址格式错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $is_exist_email = RC_DB::table('staff_user')->where('email', $email)->get();
        if ($is_exist_email) {
        	return $this->showmessage('邮箱已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if(empty($_POST['province']) || empty($_POST['city']) || empty($_POST['district']) || empty($_POST['street'])) {
        	return $this->showmessage('请选择配送员所在地区', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        
        if(empty($address)) {
        	return $this->showmessage('请输入详细地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        		
		//产生配送员资料staff_user表
		$salt = rand(1, 9999);
		$staff_info = array(
			'store_id'     => 0,
			'name'         => trim($_POST['name']),
			'user_ident'   => trim($_POST['user_ident']),
			'mobile'       => $mobile,
			'email'        => $email,
			'group_id'	   => -1,	
			'add_time'     => RC_Time::gmtime(),
		);
		
		if($password) {
			$staff_info['password'] = md5(md5($password) . $salt);
			$staff_info['salt']     = $salt;
		}
		$staff_id = RC_DB::table('staff_user')->insertGetId($staff_info);
		
		if($staff_id){
			$data_express = array(
				'user_id'	=> $staff_id,
				'store_id'  => 0,
				'province'  => $_POST['province'],
				'city'      => $_POST['city'],
				'district'  => $_POST['district'],
				'street'    => $_POST['street'],
				'address'	=> $address,
				'work_type' => $work_type,
				'shippingfee_percent' => $shippingfee_percent,	
				'apply_source' => 'admin',					
			);
			
			if(RC_DB::table('express_user')->insert($data_express)){
				return $this->showmessage('添加配送员成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('express/admin_express/edit', array('user_id' => $staff_id))));	
			} else {
				return $this->showmessage('添加配送员失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else{
			return $this->showmessage('添加配送员失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}	
	}
	
	/**
	 * 编辑配送员
	 */
	public function edit() {
		$this->admin_priv('express_update');		

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑配送员'));
		$this->assign('ur_here', '编辑配送员');
		$this->assign('action_link', array('text' => '配送员列表', 'href' => RC_Uri::url('express/admin_express/init')));
		
		$user_id = intval($_GET['user_id']);
		$staff_user   = RC_DB::table('staff_user')->where('user_id', $user_id)->first();
		$express_user = RC_DB::table('express_user')->where('user_id', $user_id)->first();
		$data = array_merge($staff_user,$express_user);
		
		$provinces = ecjia_region::getSubarea(ecjia::config('shop_country'));
		$cities    = ecjia_region::getSubarea($data['province']);
		$districts = ecjia_region::getSubarea($data['city']);
		$streets   = ecjia_region::getSubarea($data['district']);
		$this->assign('province', $provinces);
		$this->assign('city', $cities);
		$this->assign('district', $districts);
		$this->assign('street', $streets);
		$this->assign('data', $data);
		
		$this->assign('form_action', RC_Uri::url('express/admin_express/update'));
	
		$this->display('express_edit.dwt');
	}
	
	/**
	 * 编辑配送员处理
	 */
	public function update() {
		$this->admin_priv('express_update');
		
		$user_id = intval($_POST['user_id']);
		$mobile  = trim($_POST['mobile']);
		$email   = trim($_POST['email']);
		$shippingfee_percent = intval($_POST['shippingfee_percent']);
		$work_type = intval($_POST['work_type']);
		$address   = trim($_POST['address']);
		$newpassword = trim($_POST['newpassword']);
		
		if (!preg_match('/^1(3|4|5|7|8)\d{9}$/', $mobile)) {
			return $this->showmessage('手机号码格式错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		} 
	   	$is_exist_mobile = RC_DB::table('staff_user')->where('user_id', '<>', $user_id)->where('mobile', $mobile)->get();
        if ($is_exist_mobile) {
            return $this->showmessage('手机号已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if (!preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/', $email)) {
        	return $this->showmessage('email地址格式错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $is_exist_email = RC_DB::table('staff_user')->where('email', $email)->where('user_id', '<>', $user_id)->get();
        if ($is_exist_email) {
        	return $this->showmessage('邮箱已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if(empty($_POST['province']) || empty($_POST['city']) || empty($_POST['district']) || empty($_POST['street'])) {
        	return $this->showmessage('请选择配送员所在地区', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        
        if(empty($address)) {
        	return $this->showmessage('请输入详细地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        		
		//产生配送员资料staff_user表
		$salt = rand(1, 9999);
		$staff_info = array(
			'name'         => trim($_POST['name']),
			'user_ident'   => trim($_POST['user_ident']),
			'mobile'       => $mobile,
			'email'        => $email,
		);
		if($newpassword) {
			$staff_info['password'] = md5(md5($newpassword) . $salt);
			$staff_info['salt']     = $salt;
		} 
		RC_DB::table('staff_user')->where('user_id', $user_id)->update($staff_info);

		$data_express = array(
			'province'  => $_POST['province'],
			'city'      => $_POST['city'],
			'district'  => $_POST['district'],
			'street'    => $_POST['street'],
			'address'	=> $address,
			'work_type' => $work_type,
			'shippingfee_percent' => $shippingfee_percent,
		);
		RC_DB::table('express_user')->where('user_id', $user_id)->update($data_express);
		return $this->showmessage('编辑配送员成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('express/admin_express/edit', array('user_id' => $user_id))));
		
	}

	/**
	 * 删除配送员
	 */
	public function remove() {
		$this->admin_priv('express_delete');
	
		$user_id = intval($_GET['user_id']);
		RC_DB::table('staff_user')->where('user_id', $user_id)->delete();
		RC_DB::table('express_user')->where('user_id', $user_id)->delete();
	
		return $this->showmessage('删除配送员成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 批量操作
	 */
	public function batch() {
		$this->admin_priv('express_delete');

		$ids  = explode(',', $_POST['user_id']);
		RC_DB::table('staff_user')->whereIn('user_id', $ids)->delete();
		RC_DB::table('express_user')->whereIn('user_id', $ids)->delete();
		
		return $this->showmessage('批量删除配送员成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('express/admin_express/init')));
	}
	
	/**
	 * 查看详情
	 */
	public function detail() {
		$this->admin_priv('express_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('配送员详情'));
		$this->assign('ur_here', '配送员详情');
		$this->assign('action_link', array('text' => '配送员列表', 'href' => RC_Uri::url('express/admin_express/init')));
		
		$user_id = intval($_GET['user_id']);
		$staff_user   = RC_DB::table('staff_user')->where('user_id', $user_id)->first();
		$express_user = RC_DB::table('express_user')->where('user_id', $user_id)->first();
		$express_info = array_merge($staff_user,$express_user);
		$express_info['add_time']  = RC_Time::local_date('Y-m-d H:i:s', $express_info['add_time']);
		$express_info['province']  = ecjia_region::getRegionName($express_info['province']);
		$express_info['city']      = ecjia_region::getRegionName($express_info['city']);
		$express_info['district']  = ecjia_region::getRegionName($express_info['district']);
		$express_info['street']    = ecjia_region::getRegionName($express_info['street']);
		$this->assign('express_info', $express_info);

		$order_number['finish'] = RC_DB::TABLE('express_order')->where('status', 5)->where('staff_id', $user_id)->count();
		$order_number['grab']	= RC_DB::TABLE('express_order')->where('from', 'grab')->where('staff_id', $user_id)->count();
		$order_number['assign'] = RC_DB::TABLE('express_order')->where('from', 'assign')->where('staff_id', $user_id)->count();
		$this->assign('order_number', $order_number);

		$db_order = RC_DB::table('express_order as eo')
				   ->leftJoin('store_franchisee as sf', RC_DB::raw('eo.store_id'), '=', RC_DB::raw('sf.store_id'));
		$db_order->where(RC_DB::raw('eo.staff_id'), $user_id);
		$count = $db_order->count();
		$page = new ecjia_page($count, 5, 5);
		$data = $db_order
		->selectRaw('eo.express_sn,eo.express_id,eo.district as eodistrict,eo.street as eostreet,eo.address as eoaddress,eo.receive_time,eo.from,eo.commision,eo.status,sf.merchants_name,sf.district,sf.street,sf.address')
		->orderby(RC_DB::raw('eo.express_id'), 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['receive_time']  = RC_Time::local_date('Y-m-d H:i', $row['receive_time']);
				$row['district']      = ecjia_region::getRegionName($row['district']);
				$row['street']        = ecjia_region::getRegionName($row['street']);
				$row['eodistrict']    = ecjia_region::getRegionName($row['eodistrict']);
				$row['eostreet']      = ecjia_region::getRegionName($row['eostreet']);
				$list[] = $row;
			}
		}
		
		$order_list =  array('list' => $list,'page' => $page->show(5), 'desc' => $page->page_desc());
		$this->assign('order_list', $order_list);
		
		$this->display('express_detail.dwt');
	}
	
	/**
	 * 查看账目详情
	 */
	public function account_list() {
		$this->admin_priv('express_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('查看账目详情'));
		$this->assign('ur_here', '查看账目详情');
		$this->assign('action_link', array('text' => '配送员列表', 'href' => RC_Uri::url('express/admin_express/init')));
	
		$user_id = intval($_GET['user_id']);
		$user_money = RC_DB::TABLE('express_user')->where('user_id', $user_id)->pluck('user_money');
		$name = RC_DB::TABLE('staff_user')->where('user_id', $user_id)->pluck('name');
		$this->assign('user_money', $user_money);
		$this->assign('name', $name);
		$this->assign('user_id', $user_id);
		$this->assign('form_action',	RC_Uri::url('express/admin_express/account_list'));
		$start_date = $end_date = '';
		if (isset($_GET['start_date']) && !empty($_GET['end_date'])) {
			$start_date	= RC_Time::local_strtotime($_GET['start_date']);
			$end_date	= RC_Time::local_strtotime($_GET['end_date']);
		} else {
			$start_date	= RC_Time::local_strtotime(RC_Time::local_date(ecjia::config('date_format'), strtotime('-1 month')-8*3600));
			$end_date	= RC_Time::local_strtotime(RC_Time::local_date(ecjia::config('date_format')));
		}
		$this->assign('start_date',		RC_Time::local_date('Y-m-d', $start_date));
		$this->assign('end_date',		RC_Time::local_date('Y-m-d', $end_date));
		$log_db = RC_DB::table('express_user_account_log');
		$log_db->where(RC_DB::raw('staff_user_id'), $user_id);
		$log_db->where('change_time', '>=', $start_date);
		$log_db->where('change_time', '<', $end_date + 86400);
		$count = $log_db->count();
		$page = new ecjia_page($count, 5, 5);
		$data = $log_db
		->selectRaw('staff_user_id,user_money,change_time,change_desc')
		->orderby('log_id', 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['change_time']  = RC_Time::local_date('Y-m-d H:i:s', $row['change_time']);
				$list[] = $row;
			}
		}
		
		$log_list =  array('list' => $list,'page' => $page->show(5), 'desc' => $page->page_desc());
		$this->assign('log_list', $log_list);
	
		$this->display('express_account_list.dwt');
	}
	
	private function get_express_list($type = '') {
		$db_data = RC_DB::table('staff_user as su')
		->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'));
		
		$db_data->where(RC_DB::raw('su.store_id'), 0);
		
		$filter['keyword']	 = trim($_GET['keyword']);
		$filter['work_type'] = trim($_GET['work_type']);

		if ($filter['keyword']) {
			$db_data ->whereRaw('(su.name  like  "%'.mysql_like_quote($filter['keyword']).'%"  or su.mobile like "%'.mysql_like_quote($filter['keyword']).'%")');
		}
		
		if ($filter['work_type']) {
			$db_data ->where('work_type', $filter['work_type']);
		}
		
		$express_count = $db_data->select(RC_DB::raw('count(*) as count'),
				RC_DB::raw('SUM(IF(su.online_status = 1, 1, 0)) as online'),
				RC_DB::raw('SUM(IF(su.online_status = 4, 1, 0)) as offline'))->first();
		
		if ($type == 'online') {
			$db_data->where(RC_DB::raw('su.online_status'), 1);
		} 
		
		if ($type == 'offline') {
			$db_data->where(RC_DB::raw('su.online_status'), 4);
		}
		$count = $db_data->count();
		$page = new ecjia_page($count, 10, 5);
		
		$data = $db_data
		->selectRaw('eu.*, su.user_id, su.name, su.mobile, su.add_time, su.online_status')
		->orderby(RC_DB::raw('su.user_id'), 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['add_time']  = RC_Time::local_date('Y-m-d H:i:s', $row['add_time']);
				$list[] = $row;
			}
		}
		return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $express_count);
	}
}

//end