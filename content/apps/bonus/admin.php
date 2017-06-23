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
 * 红包类型的处理
 */
class admin extends ecjia_admin {
	private $db_user_bonus;
	private $db_bonus_type;
	
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('admin_bonus');
		
		$this->db_user_bonus 	= RC_Model::model('bonus/user_bonus_model');
		$this->db_bonus_type 	= RC_Model::model('bonus/bonus_type_model' );

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');

		/* 红包、红包类型列表页面 js/css */
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') , array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		
		/* 红包类型编辑页面 js/css */
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bonus_type', RC_App::apps_url('statics/js/bonus_type.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bonus', RC_App::apps_url('statics/js/bonus.js', __FILE__), array(), false, true);
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		$js_lang = array(
			'edit_bonus_type_name'		=> RC_Lang::get('bonus::bonus.edit_bonus_type_name'),
			'edit_bonus_money'			=> RC_Lang::get('bonus::bonus.edit_bonus_money'),
			'edit_order_limit'			=> RC_Lang::get('bonus::bonus.edit_order_limit'),
			'type_name_required'		=> RC_Lang::get('bonus::bonus.type_name_required'),
			'type_name_minlength'		=> RC_Lang::get('bonus::bonus.type_name_minlength'),
			'type_money_required'		=> RC_Lang::get('bonus::bonus.type_money_required'),
			'min_goods_amount_required'	=> RC_Lang::get('bonus::bonus.min_goods_amount_required'),
		);
		RC_Script::localize_script('bonus_type', 'js_lang', $js_lang);
		
		$bonus_js_lang = array(
			'bonus_sum_required'	=> RC_Lang::get('bonus::bonus.bonus_sum_required'),
			'bonus_number_required'	=> RC_Lang::get('bonus::bonus.bonus_number_required'),
			'select_goods_empty'	=> RC_Lang::get('bonus::bonus.select_goods_empty'),
			'select_user_empty'		=> RC_Lang::get('bonus::bonus.select_user_empty'),
		);
		RC_Script::localize_script('bonus', 'bonus_js_lang', $bonus_js_lang);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.bonus_manage'), RC_Uri::url('bonus/admin/init')));
	}
	
	/**
	 * 红包类型列表页面
	 */
	public function init() {
		$this->admin_priv('bonus_type_manage');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.bonus_manage')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('bonus::bonus.overview'),
			'content'	=> '<p>' . RC_Lang::get('bonus::bonus.bonus_type_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('bonus::bonus.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:红包类型" target="_blank">'.RC_Lang::get('bonus::bonus.about_bonus_type').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('bonus::bonus.bonustype_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('system::system.bonustype_add'), 'href' => RC_Uri::url('bonus/admin/add')));
		$this->assign('search_action', RC_Uri::url('bonus/admin/init'));
		
		$list = get_type_list();
		
		$this->assign('type_list', $list);
		$this->assign('count', $list['count']);
		$this->assign('filter', $list['filter']);
		
		$this->display('bonus_type.dwt');
	}

	/**
	 * 红包类型添加页面
	 */
	public function add() {
		$this->admin_priv('bonus_type_update');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.add_bonus_type')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('bonus::bonus.overview'),
			'content'	=> '<p>' . RC_Lang::get('bonus::bonus.add_bonus_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('bonus::bonus.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:红包类型#.E6.B7.BB.E5.8A.A0.E7.BA.A2.E5.8C.85.E7.B1.BB.E5.9E.8B" target="_blank">'.RC_Lang::get('bonus::bonus.about_add_bonus').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('bonus::bonus.add_bonus_type'));
		$this->assign('action_link', array('href' => RC_Uri::url('bonus/admin/init'), 'text' => RC_Lang::get('bonus::bonus.bonustype_list')));
	
		$next_month = RC_Time::local_strtotime('+1 months');
		$bonus_arr['send_start_date'] = RC_Time::local_date('Y-m-d');
		$bonus_arr['use_start_date']  = RC_Time::local_date('Y-m-d');
		$bonus_arr['send_end_date']   = RC_Time::local_date('Y-m-d', $next_month);
		$bonus_arr['use_end_date']    = RC_Time::local_date('Y-m-d', $next_month);
		
		$this->assign('bonus_arr', $bonus_arr);
		$this->assign('form_action', RC_Uri::url('bonus/admin/insert'));
		
		$this->display('bonus_type_info.dwt');
	}
	
	/**
	 * 红包类型添加的处理
	 */
	public function insert() {
		$this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);

		$type_name   = !empty($_POST['type_name']) 			? trim($_POST['type_name']) 		: '';
		$type_id     = !empty($_POST['type_id'])    		? intval($_POST['type_id'])    		: 0;
		$min_amount  = !empty($_POST['min_amount']) 		? floatval($_POST['min_amount']) 	: 0;
		$bonus_type  = intval($_POST['bonus_type']) == 1 	? 1 								: 0;
		$send_type	 = !empty($_POST['send_type'])			? intval($_POST['send_type'])		: 0;
		$store_id = RC_DB::table('bonus_type')->select('store_id')->where('type_id', $type_id)->pluck();
		$store_id    = !empty($store_id)                    ? intval($store_id)    		        : 0;

		if (RC_DB::table('bonus_type')->where('type_name', $type_name)->where('store_id', $store_id)->count() > 0) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.type_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$send_startdate = !empty($_POST['send_start_date']) ? RC_Time::local_strtotime($_POST['send_start_date']) 	: '';
		$send_enddate   = !empty($_POST['send_end_date']) 	? RC_Time::local_strtotime($_POST['send_end_date']) + 86399 : '';
		$use_startdate  = !empty($_POST['use_start_date']) 	? RC_Time::local_strtotime($_POST['use_start_date']) 	: '';
		$use_enddate    = !empty($_POST['use_end_date']) 	? RC_Time::local_strtotime($_POST['use_end_date']) + 86399	: '';
		
		if ($send_type != 0 && $send_type != 3) {
			if (empty($send_startdate)) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_startdate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (empty($send_enddate)) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_enddate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($send_startdate >= $send_enddate) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_start_lt_end'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		if (empty($use_startdate)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_startdate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($use_enddate)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_enddate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($use_startdate >= $use_enddate) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_start_lt_end'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'type_name'        	=> $type_name,
			'type_money'       	=> !empty($_POST['type_money']) ? floatval($_POST['type_money']) : 0,
			'send_start_date'  	=> $send_startdate,
			'send_end_date'    	=> $send_enddate,
			'use_start_date'   	=> $use_startdate,
			'use_end_date'     	=> $use_enddate,
			'send_type'        	=> $send_type,
			'min_amount'       	=> $min_amount,
			'min_goods_amount' 	=> !empty($_POST['min_goods_amount']) ? floatval($_POST['min_goods_amount']) : 0,
			'usebonus_type'		=> $bonus_type,
		);
		$id = RC_DB::table('bonus_type')->insertGetId($data);
		 
		$send_type = RC_Lang::get('bonus::bonus.send_by.'.$send_type);
		ecjia_admin::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send_type.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$type_name, 'add', 'bonustype');
	
		$links[] = array('text' => RC_Lang::get('bonus::bonus.back_list'), 'href' => RC_Uri::url('bonus/admin/init'));
		$links[] = array('text' => RC_Lang::get('bonus::bonus.continus_add'), 'href' => RC_Uri::url('bonus/admin/add'));
		return $this->showmessage(RC_Lang::get('bonus::bonus.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('bonus/admin/edit', array('type_id' => $id))));
	}
	
	/**
	 * 红包类型编辑页面
	 */
	public function edit() {
		$this->admin_priv('bonus_type_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.bonustype_edit')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('bonus::bonus.overview'),
			'content'	=> '<p>' . RC_Lang::get('bonus::bonus.edit_bonus_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('bonus::bonus.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:红包类型#.E7.BC.96.E8.BE.91.E7.BA.A2.E5.8C.85.E7.B1.BB.E5.9E.8B" target="_blank">'.RC_Lang::get('bonus::bonus.about_edit_bonus').'</a>') . '</p>'
		);
	
		$this->assign('ur_here', RC_Lang::get('bonus::bonus.bonustype_edit'));
		$this->assign('action_link', array('href' => RC_Uri::url('bonus/admin/init'), 'text' => RC_Lang::get('bonus::bonus.bonustype_list')));
		
		$type_id   = !empty($_GET['type_id']) ? intval($_GET['type_id']) : 0;
		$bonus_arr = RC_DB::table('bonus_type')->where('type_id', $type_id)->first();
		
		$bonus_arr['send_start_date'] = RC_Time::local_date('Y-m-d', $bonus_arr['send_start_date']);
		$bonus_arr['send_end_date']   = RC_Time::local_date('Y-m-d', $bonus_arr['send_end_date']);
		$bonus_arr['use_start_date']  = RC_Time::local_date('Y-m-d', $bonus_arr['use_start_date']);
		$bonus_arr['use_end_date']    = RC_Time::local_date('Y-m-d', $bonus_arr['use_end_date']);

		$this->assign('bonus_arr',   $bonus_arr);
		$this->assign('form_action', RC_Uri::url('bonus/admin/update'));
		
		$this->display('bonus_type_info.dwt');
	}
	
	/**
	 * 红包类型编辑的处理
	 */
	public function update() {
		$this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);

		$type_name 		= !empty($_POST['type_name']) 		? trim($_POST['type_name']) 	: '';
		$old_typename 	= !empty($_POST['old_typename']) 	? trim($_POST['old_typename']) 	: '';
		$send_type	 	= !empty($_POST['send_type'])		? intval($_POST['send_type'])	: 0;
		
		if ($type_name != $old_typename ) {
			if (RC_DB::table('bonus_type')->where('type_name', $type_name)->count() > 0) {
			 	return $this->showmessage(RC_Lang::get('bonus::bonus.type_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	
		$send_startdate = !empty($_POST['send_start_date']) ? RC_Time::local_strtotime($_POST['send_start_date'])	: 0;
		$send_enddate   = !empty($_POST['send_end_date']) 	? RC_Time::local_strtotime($_POST['send_end_date']) + 86399	: 0;
		$use_startdate  = !empty($_POST['use_start_date']) 	? RC_Time::local_strtotime($_POST['use_start_date'])	: 0;
		$use_enddate    = !empty($_POST['use_end_date']) 	? RC_Time::local_strtotime($_POST['use_end_date']) + 86399	: 0;
		
		$type_id     = !empty($_POST['type_id'])    ? intval($_POST['type_id'])    : 0;
		$min_amount  = !empty($_POST['min_amount']) ? intval($_POST['min_amount']) : 0;
		
		$data = array(
			'type_name'        => $type_name,
			'type_money'       => floatval($_POST['type_money']),
			'use_start_date'   => $use_startdate,
			'use_end_date'     => $use_enddate,
			'send_type'        => $send_type,
			'min_amount'       => $min_amount,
			'min_goods_amount' => floatval($_POST['min_goods_amount']),
			'usebonus_type'	   => intval($_POST['bonus_type']),
		);
		
		if ($send_type != 0 && $send_type != 3) {
			if (empty($send_startdate)) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_startdate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (empty($send_enddate)) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_enddate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($send_startdate >= $send_enddate) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_start_lt_end'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$data['send_start_date'] = $send_startdate;
			$data['send_end_date'] = $send_enddate;
		}
		
		if (empty($use_startdate)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_startdate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($use_enddate)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_enddate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($use_startdate >= $use_enddate) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_start_lt_end'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		RC_DB::table('bonus_type')->where('type_id', $type_id)->update($data);
	
		$send_type = RC_Lang::get('bonus::bonus.send_by.'.$send_type);
		ecjia_admin::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send_type.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$type_name, 'edit', 'bonustype');
		
		$links[] = array('text' => RC_Lang::get('bonus::bonus.back_list'), 'href' => RC_Uri::url('bonus/admin/init'));
		$links[] = array('text' => RC_Lang::get('bonus::bonus.continus_add'), 'href' => RC_Uri::url('bonus/admin/add'));
		return $this->showmessage(RC_Lang::get('bonus::bonus.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('bonus/admin/edit', array('type_id' => $type_id))));
	}
	
	/**
	 * 编辑红包类型名称
	 */
	public function edit_type_name() {
		$this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);
		
		$type_name 	= !empty($_POST['value']) 	? trim($_POST['value']) 	: '';
		$id			= !empty($_POST['pk']) 		? intval($_POST['pk']) 		: 0;
		
		if (!empty($type_name)) {
			if (RC_DB::table('bonus_type')->where('type_name', $type_name)->where('type_id', '!=', $id)->count() == 0) {
				
				RC_DB::table('bonus_type')->where('type_id', $id)->update(array('type_name' => $type_name));
				ecjia_admin::admin_log(RC_Lang::get('bonus::bonus.bonustype_name_is').$type_name, 'edit', 'bonustype');
				
				return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				return $this->showmessage(RC_Lang::get('bonus::bonus.type_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(RC_Lang::get('bonus::bonus.type_name_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑红包金额
	 */
	public function edit_type_money() {
		$this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);
				
		$id  = !empty($_POST['pk']) 	? intval($_POST['pk']) 		: 0;
		$val = !empty($_POST['value']) 	? floatval($_POST['value']) : 0;
		
		if ($val <= 0) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.type_money_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			RC_DB::table('bonus_type')->where('type_id', $id)->update(array('type_money' => $val));
			return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('bonus/admin/init')));
		}
	}
	
	/**
	 * 编辑订单下限
	 */
	public function edit_min_amount() {
		$this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);
		
		$id  = intval($_POST['pk']);
		$val = floatval($_POST['value']);
		
		/* 可为0 */
		if ($val <= 0 && !($_POST['value'] === '0')) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.min_amount_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		else {
			RC_DB::table('bonus_type')->where('type_id', $id)->update(array('min_amount' => $val));
			return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('bonus/admin/init')));
		}
	}
	
	/**
	 * 删除红包类型
	 */
	public function remove() {
		$this->admin_priv('bonus_type_delete', ecjia::MSGTYPE_JSON);	
		
		$id = intval($_GET['id']);
		$info = bonus_type_info($id);
		
		RC_DB::table('bonus_type')->where('type_id', $id)->delete();		//删除红包类型
		RC_DB::table('user_bonus')->where('bonus_type_id', $id)->delete();	//删除该红包类型的用户红包
		
		$data = array('bonus_type_id' => 0);
		RC_DB::table('goods')->where('bonus_type_id', $id)->update($data);	//更新该红包类型的商品红包类型id为0
		
		/*记录管理员日志*/
		$send_type = RC_Lang::get('bonus::bonus.send_by.'.$info['send_type']);
		ecjia_admin::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send_type.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$info['type_name'], 'remove', 'bonustype');
		
		return $this->showmessage(RC_Lang::get('bonus::bonus.del_bonustype_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 红包发送页面
	 */
	public function send() {
		$this->admin_priv('bonus_type_manage');
		
		/* 取得参数 */
		$id = !empty($_GET['id'])  ? intval($_GET['id'])  : 0;
		$this->assign('id', $id);
		
		$send_by = intval($_GET['send_by']);
		$this->assign('ur_here', RC_Lang::get('bonus::bonus.send_bonus'));
		$this->assign('action_link', array('href' => RC_Uri::url('bonus/admin/init', array('bonus_type' => $id)), 'text' => RC_Lang::get('bonus::bonus.bonustype_list')));

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.send_bonus')));
		
		if ($send_by == SEND_BY_USER) {//用户发放
			ecjia_screen::get_current_screen()->add_help_tab(array(
				'id'		=> 'overview',
				'title'		=> RC_Lang::get('bonus::bonus.overview'),
				'content'	=> '<p>' . RC_Lang::get('bonus::bonus.send_by_user_help') . '</p>'
			));
				
			ecjia_screen::get_current_screen()->set_help_sidebar(
				'<p><strong>' . RC_Lang::get('bonus::bonus.more_info') . '</strong></p>' .
				'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:红包类型#.E6.8C.89.E7.85.A7.EF.BC.88.E7.94.A8.E6.88.B7.EF.BC.89.E5.8F.91.E6.94.BE.E7.BA.A2.E5.8C.85" target="_blank">'.RC_Lang::get('bonus::bonus.about_send_by_user').'</a>') . '</p>'
			);
			$bonus_type = RC_DB::table('bonus_type')->select('type_id', 'type_name')->where('type_id', $id)->first();
			
			$this->assign('ranklist',         get_rank_list());
			$this->assign('bonus_type',       $bonus_type);
			$this->assign('form_action',      RC_Uri::url('bonus/admin/send_by_user_rank'));
			$this->assign('form_user_action', RC_Uri::url('bonus/admin/send_by_user'));
			
			$this->display('bonus_by_user.dwt');
		} elseif ($send_by == SEND_BY_GOODS) {//商品发放
			ecjia_screen::get_current_screen()->add_help_tab(array(
				'id'		=> 'overview',
				'title'		=> RC_Lang::get('bonus::bonus.overview'),
				'content'	=> '<p>' . RC_Lang::get('bonus::bonus.send_by_goods_help') . '</p>'
			));
				
			ecjia_screen::get_current_screen()->set_help_sidebar(
				'<p><strong>' . RC_Lang::get('bonus::bonus.more_info') . '</strong></p>' .
				'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:红包类型#.E6.8C.89.E7.85.A7.EF.BC.88.E5.95.86.E5.93.81.EF.BC.89.E5.8F.91.E6.94.BE.E7.BA.A2.E5.8C.85" target="_blank">'.RC_Lang::get('bonus::bonus.about_send_by_goods').'</a>') . '</p>'
			);
			$bonus_type = RC_DB::table('bonus_type')->select('type_id', 'type_name')->where('type_id', $id)->first();
			$goods_list = get_bonus_goods($id);
			/* 模板赋值 */
			$this->assign('cat_list', RC_Api::api('goods', 'get_goods_category'));
			$this->assign('brand_list', RC_Api::api('goods', 'get_goods_brand'));

			$this->assign('bonus_type_id', $id);
			$this->assign('bonus_type', $bonus_type);
			$this->assign('goods_list', $goods_list);
			$this->assign('form_action', RC_Uri::url('bonus/admin/send_by_goods'));
			
			$this->display('bonus_by_goods.dwt');
		} elseif ($send_by == SEND_BY_PRINT) {//线下发放
			ecjia_screen::get_current_screen()->add_help_tab(array(
				'id'		=> 'overview',
				'title'		=> RC_Lang::get('bonus::bonus.overview'),
				'content'	=> '<p>' . RC_Lang::get('bonus::bonus.send_by_print_help') . '</p>'
			));
				
			ecjia_screen::get_current_screen()->set_help_sidebar(
				'<p><strong>' . RC_Lang::get('bonus::bonus.more_info') . '</strong></p>' .
				'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:红包类型#.E6.8C.89.E7.85.A7.EF.BC.88.E7.BA.BF.E4.B8.8B.EF.BC.89.E5.8F.91.E6.94.BE.E7.BA.A2.E5.8C.85" target="_blank">'.RC_Lang::get('bonus::bonus.about_send_by_print').'</a>') . '</p>'
			);
			$this->assign('type_list', get_bonus_type());
			$this->assign('form_action', RC_Uri::url('bonus/admin/send_by_print'));
			
			$this->display('bonus_by_print.dwt');
		} elseif ($send_by == SEND_COUPON) {//优惠券
			ecjia_screen::get_current_screen()->add_help_tab(array(
				'id'		=> 'overview',
				'title'		=> RC_Lang::get('bonus::bonus.overview'),
				'content'	=> '<p>' . RC_Lang::get('bonus::bonus.send_coupon_help') . '</p>'
			));
			
			ecjia_screen::get_current_screen()->set_help_sidebar(
				'<p><strong>' . RC_Lang::get('bonus::bonus.more_info') . '</strong></p>' .
				'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:红包类型#.E6.8C.89.E7.85.A7.EF.BC.88.E5.95.86.E5.93.81.EF.BC.89.E5.8F.91.E6.94.BE.E7.BA.A2.E5.8C.85" target="_blank">'.RC_Lang::get('bonus::bonus.about_send_coupon').'</a>') . '</p>'
			);
			
			$this->assign('cat_list', RC_Api::api('goods', 'get_goods_category'));
			$this->assign('brand_list', RC_Api::api('goods', 'get_goods_brand'));

			$goods_group = RC_DB::table('term_meta')
				->where('object_type', 'ecjia.goods')
				->where('object_group', 'goods_bonus_coupon')
				->where('meta_key', 'bonus_type_id')
				->where('meta_value', $id)
				->lists('object_id');
			
			$goods_list = array();
			if (!empty($goods_group)) {
				$goods_list = RC_DB::table('goods')->whereIn('goods_id', $goods_group)->select('goods_id', 'goods_name')->get();
			}
			$this->assign('bonus_type_id', 	$id);
			$this->assign('goods_list', 	$goods_list);
			$this->assign('form_action', 	RC_Uri::url('bonus/admin/send_by_coupon'));
			
			$this->display('bonus_by_goods.dwt');
		}
	}
	
	/**
	 * 处理红包的发送页面 
	 */
	public function send_by_user_rank() {
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);

		$user_list = array();
		$send_count = 0;
		/* 按等级发放红包时-只给通过邮件验证的用户发放红包 */
		$validated_email = empty($_POST['validated_email']) ? 0 : intval($_POST['validated_email']);
		/* 按会员等级来发放红包 */
		$rank_id = !empty($_POST['rank_id']) ? intval($_POST['rank_id']) : 0;
		
		if ($rank_id > 0) {
			$row = RC_DB::table('user_rank')->select('min_points', 'max_points', 'special_rank')->where('rank_id', $rank_id)->first();
			
			$db_user = RC_DB::table('users');
			$db_user->select('user_id', 'email', 'user_name');
			if ($row['special_rank']) {
				$db_user->where('user_rank', $rank_id);
				/* 特殊会员组处理 */
				if ($validated_email) {
					$db_user->where('is_validated', 1);
				}
			} else {
				$db_user->where('rank_points', '>=', intval($row['min_points']))->where('rank_points', '<', intval($row['max_points']));
				if ($validated_email) {
					$db_user->where('is_validated', 1);
				}
			}
			$user_list = $db_user->get();
		}
		
		/* 发送红包 */
		$loop       	= 0;
		$loop_faild 	= 0;
		$bonus_type_id 	= intval($_POST['id']);
		$bonus_type 	= bonus_type_info($bonus_type_id);
		
		$tpl_name 		= 'send_bonus';
		$tpl   			= RC_Api::api('mail', 'mail_template', $tpl_name);
		$today 			= RC_Time::local_date(ecjia::config('date_format'));
		
		if (!empty($user_list)) {
			foreach ($user_list AS $key => $val) {
				/* 读取邮件配置项 */
				$db_config = RC_Loader::load_model('shop_config_model');
				$arr 	   = $db_config->get_email_setting();
				$email_cfg = array_merge($val, $arr);
				$email_cfg['reply_email'] = $arr['smtp_user'];
				
				$this->assign('user_name', $val['user_name']);
				$this->assign('shop_name', ecjia::config('shop_name'));
				$this->assign('send_date', $today);
				$this->assign('count', 1);
				$this->assign('money', price_format($bonus_type['type_money']));
				
				$content = $this->fetch_string($tpl['template_content']);
				if (add_to_maillist($val['user_name'], $email_cfg['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
					/* 向会员红包表录入数据 */
					$data = array(
						'bonus_type_id' => $bonus_type_id,
						'bonus_sn'  	=> 0,
						'user_id'   	=> $val['user_id'],
						'used_time' 	=> 0,
						'order_id'  	=> 0,
						'emailed'   	=> BONUS_INSERT_MAILLIST_SUCCEED,
					);
					RC_DB::table('user_bonus')->insert($data);
					$loop++;
				} else {
					/* 邮件发送失败，更新数据库 */
					$data = array(
						'bonus_type_id' => $bonus_type_id,
						'bonus_sn'  	=> 0,
						'user_id'   	=> $val['user_id'],
						'used_time' 	=> 0,
						'order_id'  	=> 0,
						'emailed'   	=> BONUS_INSERT_MAILLIST_FAIL,
					);
					RC_DB::table('user_bonus')->insert($data);
					$loop_faild++;
				}
			}
		} 
       
		$send_type = RC_Lang::get('bonus::bonus.send_by.'.$bonus_type['send_type']);
		ecjia_admin::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send_type.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$bonus_type['type_name'].'，'.RC_Lang::get('bonus::bonus.send_rank_is').$rank_name, 'add', 'userbonus');
		
		return $this->showmessage(sprintf(RC_Lang::get('bonus::bonus.sendbonus_count'), $loop), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('max_id' => $bonus_type_id));
	}

	/**
	 * 处理红包的发送页面 post
	 */
	public function send_by_user() {
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);
		
		$user_list = array();
		$user_ids = !empty($_POST['linked_array']) ? $_POST['linked_array'] : '';

		if (empty($user_ids)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.send_user_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$user_array = (is_array($user_ids)) ? $user_ids : explode(',', $user_ids);
		
		$new_ids = array();
		if (!empty($user_array)) {
			foreach ($user_array as $value) {
				$new_ids[] = $value['user_id'];
			}
		}
		
		/* 根据会员ID取得用户名和邮件地址 */
		$user_list = RC_DB::table('users')->select('user_id', 'email', 'user_name')->whereIn('user_id', $new_ids)->get();
		$count = count($user_list);

		/* 发送红包 */
		$bonus_type_id = intval($_POST['bonus_type_id']);
		$bonus_type = bonus_type_info($bonus_type_id);
		$tpl_name = 'send_bonus';
		
		$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
		$today = RC_Time::local_date(ecjia::config('date_format'));
			
		if (!empty($user_list)) {
			foreach ($user_list as $key => $val) {
				/* 读取邮件配置项 */
				$db_config = RC_Loader::load_model('shop_config_model');
				$arr       = $db_config->get_email_setting();
				$email_cfg = array_merge($val, $arr);
				$email_cfg['reply_email'] = $arr['smtp_user'];
				
				$this->assign('user_name', $val['user_name']);
				$this->assign('shop_name', ecjia::config('shop_name'));
				$this->assign('send_date', $today);
				$this->assign('count',     1);
				$this->assign('money',     price_format($bonus_type['type_money']));
				
				$content = $this->fetch_string($tpl['template_content']);
				if (add_to_maillist($val['user_name'], $email_cfg['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
					$data = array(
						'bonus_type_id' => $bonus_type_id,
						'bonus_sn'      => 0,
						'user_id' 	    => $val['user_id'],
						'used_time' 	=> 0,
						'order_id' 		=> 0,
						'emailed' 		=> BONUS_INSERT_MAILLIST_SUCCEED,
					);
					RC_DB::table('user_bonus')->insert($data);
				} else {
					$data = array(
						'bonus_type_id' => $bonus_type_id,
						'bonus_sn' 	    => 0,
						'user_id' 		=> $val['user_id'],
						'used_time' 	=> 0,
						'order_id' 		=> 0,
						'emailed' 		=> BONUS_INSERT_MAILLIST_FAIL,
					);
					RC_DB::table('user_bonus')->insert($data);
				}
			}
			$send_type = RC_Lang::get('bonus::bonus.send_by.'.$bonus_type['send_type']);
			foreach ($user_list as $v) {
				ecjia_admin::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send_type.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$bonus_type['type_name'].'，'.RC_Lang::get('bonus::bonus.send_target_is').$v['user_name'], 'add', 'userbonus');
			}
		}
		return $this->showmessage(sprintf(RC_Lang::get('bonus::bonus.sendbonus_count'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 添加发放红包的商品
	 */
	public function send_by_goods() {
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);
		
		$goods_id 	= isset($_POST['linked_array']) 	? $_POST['linked_array'] 			: '';
		$type_id 	= isset($_POST['bonus_type_id']) 	? intval($_POST['bonus_type_id']) 	: 0;
		
		$data = array('bonus_type_id' => 0);
		RC_DB::table('goods')->where('bonus_type_id', $type_id)->update($data);
		
		$new_ids = array();
		if (!empty($goods_id)) {
			foreach ($goods_id as $value){
				$new_ids[] = $value['goods_id'];
			}
			$data = array('bonus_type_id' => $type_id);
			RC_DB::table('goods')->whereIn('goods_id', $new_ids)->update($data);
			
			$info = bonus_type_info($type_id);
			$goods_name_list = RC_DB::table('goods')->whereIn('goods_id', $new_ids)->lists('goods_name');
			
			$send_type = RC_Lang::get('bonus::bonus.send_by.'.$info['send_type']);
			foreach ($goods_name_list as $v) {
				ecjia_admin::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send_type.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$info['type_name'].'，'.RC_Lang::get('bonus::bonus.send_target_is').$v, 'add', 'userbonus');
			}
		}
		return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 按线下发放红包
	 */
	public function send_by_print()	{
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);
		
		@set_time_limit(0);
		/* 线下红包的类型ID和生成的数量的处理 */
		$bonus_typeid = !empty($_POST['bonus_type_id']) ? intval($_POST['bonus_type_id']) 	: 0;
		$bonus_sum    = !empty($_POST['bonus_sum'])     ? intval($_POST['bonus_sum'])    	: 1;
	
		/* 生成红包序列号 */
		$num = RC_DB::table('user_bonus')->max('bonus_sn');
		$num = $num ? floor($num / 10000) : 100000;
		
		for ($i = 0, $j = 0; $i < $bonus_sum; $i++) {
			$bonus_sn = ($num + $i) . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
			$data = array(
				'bonus_type_id' => $bonus_typeid,
				'bonus_sn' 		=> $bonus_sn
			);
			RC_DB::table('user_bonus')->insert($data);
			$j++;
		}
		$info = bonus_type_info($bonus_typeid);
		$send_type = RC_Lang::get('bonus::bonus.send_by.'.$info['send_type']);
		
		ecjia_admin::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send_type.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$info['type_name'], 'add', 'userbonus');
		return $this->showmessage(RC_Lang::get('bonus::bonus.creat_bonus') . $j . RC_Lang::get('bonus::bonus.creat_bonus_num'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('max_id' => $bonus_typeid));
	}
	
	/**
	 * 发送邮件
	 */
	public function send_mail() {
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);

		$bonus_id = intval($_GET['bonus_id']);
		if ($bonus_id <= 0) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.invalid_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$bonus = bonus_info($bonus_id);

		if (empty($bonus)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.bonus_not_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$count = $this->send_bonus_mail($bonus['bonus_type_id'], array($bonus_id));
		
		return $this->showmessage(sprintf(RC_Lang::get('bonus::bonus.success_send_mail'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 发送红包邮件
	 * @param   int     $bonus_type_id  红包类型id
	 * @param   array   $bonus_id_list  红包id数组
	 * @return  int     成功发送数量
	 */
	function send_bonus_mail($bonus_type_id, $bonus_id_list) {
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);
		

		$bonus_type = bonus_type_info($bonus_type_id);
		if ($bonus_type['send_type'] != SEND_BY_USER) {
			return 0;
		}
		if (!is_array($bonus_id_list)) {
			$bonus_id_list = explode(',', $bonus_id_list);
		}
		$db_view = RC_DB::table('user_bonus')
			->leftJoin('users', 'users.user_id', '=', 'user_bonus.user_id')
			->select('user_bonus.bonus_id', 'users.user_name', 'users.email');

		$bonus_list = $db_view
			->where('user_bonus.order_id', 0)
			->where('users.email', '!=', '')
			->whereIn('user_bonus.bonus_id', $bonus_id_list)
			->get();
		
		if (empty($bonus_list)) {
			return 0;
		}
		$send_count = 0;
		/* 发送邮件 */
		$tpl_name = 'send_bonus';
		$tpl = RC_Api::api('mail', 'mail_template', $tpl_name);
		
		$today = RC_Time::local_date(ecjia::config('date_format'));
		if (!empty($bonus_list)) {
			foreach ($bonus_list AS $bonus) {
				$this->assign('user_name', $bonus['user_name']);
				$this->assign('shop_name', ecjia::config('shop_name'));
				$this->assign('send_date', $today);
				$this->assign('count',     1);
				$this->assign('money',     price_format($bonus_type['type_money']));
				$content = $this->fetch_string($tpl['template_content']);
				
				if (add_to_maillist($bonus['user_name'], $bonus['email'], $tpl['template_subject'], $content, $tpl['is_html'], false)) {
					$data = array('emailed' => BONUS_INSERT_MAILLIST_SUCCEED);
					$send_count++;
				} else {
					$data = array('emailed' => BONUS_INSERT_MAILLIST_FAIL);
				}
				RC_DB::table('user_bonus')->where('bonus_id', $bonus['bonus_id'])->update($data);
			}
		}
		return $send_count;
	}
	
	/**
	 * 导出线下发放的信息 excel
	 */
	public function gen_excel() {
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);
		

		@set_time_limit(0);
		$tid  = !empty($_GET['tid']) ? intval($_GET['tid']) : 0;
		$type_name = RC_DB::table('bonus_type')->where('type_id', $tid)->pluck('type_name');
		
		$bonus_filename = $type_name .'_bonus_list';
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$bonus_filename.xls");
		
		echo mb_convert_encoding(RC_Lang::get('bonus::bonus.bonus_excel_file')."\t\n", "GBK", "UTF-8");
		echo mb_convert_encoding(RC_Lang::get('bonus::bonus.bonus_sn')."\t" ,"GBK", "UTF-8");
		echo mb_convert_encoding(RC_Lang::get('bonus::bonus.type_money')."\t","GBK", "UTF-8") ;
		echo mb_convert_encoding(RC_Lang::get('bonus::bonus.type_name')."\t" ,"GBK", "UTF-8");
		echo mb_convert_encoding(RC_Lang::get('bonus::bonus.use_enddate')."\t\n","GBK", "UTF-8");
		
		$val = array();
		$db_view = RC_DB::table('user_bonus')
			->leftJoin('bonus_type', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id')
			->select('user_bonus.bonus_id', 'user_bonus.bonus_type_id', 'user_bonus.bonus_sn', 'bonus_type.type_name', 'bonus_type.type_money', 'bonus_type.use_end_date');
		$data = $db_view->where('user_bonus.bonus_type_id', $tid)->orderby('user_bonus.bonus_id', 'desc')->get();
		
		$code_table = array();
		if (!empty($data)) {
			foreach ($data as $val) {
				echo mb_convert_encoding($val['bonus_sn']. "\t" ,"GBK", "UTF-8");
				echo mb_convert_encoding($val['type_money']. "\t","GBK", "UTF-8");
				if (!isset($code_table[$val['type_name']])) {
					$code_table[$val['type_name']] = $val['type_name'];
				}
				echo mb_convert_encoding($code_table[$val['type_name']]. "\t" ,"GBK", "UTF-8");
				echo mb_convert_encoding(RC_Time::local_date('Y-m-d', $val['use_end_date']), "GBK", "UTF-8");
				echo "\t\n";
			}
		}
	}
	
	/**
	 * 搜索商品
	 */
	public function get_goods_list() {
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);
		
		$arr = $_POST;
		$type_id = !empty($_POST['type_id']) ? intval($_POST['type_id']) : '';
		$arr['store_id'] = RC_DB::table('bonus_type')->select('store_id')->where('type_id', $type_id)->pluck();
		$row = RC_Api::api('goods', 'get_goods_list', $arr);
		$opt = array();
		if (!empty($row)) {
			foreach ($row AS $key => $val) {
				$opt[] = array(
					'value' => $val['goods_id'],
					'text'  => $val['goods_name'],
					'data'  => $val['shop_price']
				);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $opt));
	}
	
	/**
	 * 搜索用户
	 */
	public function search_users() {
		$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);

		
		$json = $_POST['JSON'];
		$keywords = !empty($json) && isset($json['keyword']) ? trim($json['keyword']) : '';
		
		$db_users = RC_DB::table('users')->select('user_id', 'user_name');
		$row = '';
		if (!empty($keywords)) {
			$row = $db_users->where('user_name', 'like', '%' . mysql_like_quote($keywords) . '%')->orWhere('user_id', 'like', '%' . mysql_like_quote($keywords) . '%')->get();
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $row));
	}
	
	/**
	 * 红包列表
	 */
	public function bonus_list() {
		$this->admin_priv('bonus_type_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.bonus_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('bonus::bonus.overview'),
			'content'	=> '<p>' . RC_Lang::get('bonus::bonus.bonus_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('bonus::bonus.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:红包类型#.E6.9F.A5.E7.9C.8B.E7.BA.A2.E5.8C.85" target="_blank">'.RC_Lang::get('bonus::bonus.about_bonus_list').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('bonus::bonus.bonus_list'));
		$this->assign('action_link', array('href' => RC_Uri::url('bonus/admin/init'), 'text' => RC_Lang::get('bonus::bonus.bonustype_list')));
		
		$list = get_bonus_list();
		$this->assign('bonus_list', $list);
		
		$bonus_type_id = intval($_GET['bonus_type']);
		$bonus_type = bonus_type_info($bonus_type_id);
		
		if ($bonus_type['send_type'] == SEND_BY_PRINT) {
			$this->assign('show_bonus_sn', 1);
		} elseif ($bonus_type['send_type'] == SEND_BY_USER) {
			$this->assign('show_mail', 1);
		}
			
		$this->assign('bonus_type_id', $bonus_type_id);
		$this->assign('form_action', RC_Uri::url('bonus/admin/batch'));
		
		$this->display('bonus_list.dwt');
	}
	
	/**
	 * 删除红包
	 */
	public function remove_bonus() {
		$this->admin_priv('bonus_type_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$bonus_sn = RC_DB::table('user_bonus')->where('bonus_id', $id)->pluck('bonus_sn');
		
		RC_DB::table('user_bonus')->where('bonus_id', $id)->delete();

		ecjia_admin::admin_log($bonus_sn, 'remove', 'userbonus');
		return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);		
	}
	
	/**
	 * 批量操作
	 */
	public function batch() {
		$bonus_type_id 	= intval($_GET['bonus_type_id']);
		$sel_action 	= trim($_GET['sel_action']);
		$action 		= !empty($sel_action) ? $sel_action : 'send';
		$ids 			= $_POST['checkboxes'];
		
		if (!is_array($ids)) {
			$ids = explode(',', $ids);
		}
		$info = RC_DB::table('user_bonus')->whereIn('bonus_id', $ids)->get();
		
		if ($action == 'remove') {
			$this->admin_priv('bonus_type_delete', ecjia::MSGTYPE_JSON);
		} else {
			$this->admin_priv('bonus_type_manage', ecjia::MSGTYPE_JSON);
		}
		
		if (!empty($ids)) {
			switch ($action) {
				case 'remove':
					$count = count($ids);
					RC_DB::table('user_bonus')->whereIn('bonus_id', $ids)->delete();

					foreach ($info as $v) {
						ecjia_admin::admin_log($v['bonus_sn'], 'batch_remove', 'userbonus');
					}
					return $this->showmessage(sprintf(RC_Lang::get('bonus::bonus.batch_drop_success'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('bonus/admin/bonus_list', array('bonus_type' => $bonus_type_id))));
					break;
		
				case 'send' :
					$this->send_bonus_mail($bonus_type_id, $ids);
					
					return $this->showmessage(RC_Lang::get('bonus::bonus.success_send_mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('bonus/admin/bonus_list', array('bonus_type' => $bonus_type_id))));
					break;
					
				default :
					break;
			}
		}
    }
}

//end