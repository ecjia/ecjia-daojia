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
 * 摇一摇活动管理控制器
 */
class admin_mobile_activity extends ecjia_admin {
	private $db_activity;
	
	public function __construct() {
		parent::__construct();
		/*数据模型*/
		$this->db_activity = RC_Model::model('mobile/mobile_activity_model');

		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');

		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));

		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

		RC_Script::enqueue_script('discover', RC_App::apps_url('statics/js/activity.js', __FILE__), array(), false, false);

		//时间控件
		RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));

		RC_Style::enqueue_style('mobile_activity', RC_App::apps_url('statics/css/mobile_activity.css', __FILE__), array(), false, false);
		
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.activity_manage'), RC_Uri::url('mobile/admin_mobile_activity/init')));
		$activity_id = isset($_GET['id']) ? $_GET['id'] : 0;
		$this->tags = array(
			'edit'				=> array('name' =>  RC_Lang::get('mobile::mobile.edit_activity'), 'pjax' => 1, 'href' => RC_Uri::url('mobile/admin_mobile_activity/edit', "id=$activity_id")),
			'activity_prize'	=> array('name' =>  RC_Lang::get('mobile::mobile.prize_pool'), 'pjax' => 1, 'href' => RC_Uri::url('mobile/admin_mobile_activity/activity_prize', "id=$activity_id")),
			'activity_record'	=> array('name' =>  RC_Lang::get('mobile::mobile.activity_record'), 'pjax' => 1, 'href' => RC_Uri::url('mobile/admin_mobile_activity/activity_record', "id=$activity_id")),
		);
		
		$this->tags[ROUTE_A]['active'] = 1;
	}

	/**
	 *活动列表页面加载
	*/
	public function init () {
		$this->admin_priv('mobile_activity_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.activity_list')));
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.activity_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.add_activity'), 'href' => RC_Uri::url('mobile/admin_mobile_activity/add')));
		$this->assign('search_action', RC_Uri::url('mobile/admin_mobile_activity/init'));

		$activity_list = $this->get_activity_list();
		$this->assign('activity_list', $activity_list);

		$this->display('activity_list.dwt');
	}

	/**
	*添加活动
	*/
    public function add() {
		$this->admin_priv('mobile_activity_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.add_activity')));
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.add_activity'));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_activity/insert'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.back_activity_list'), 'href' => RC_Uri::url('mobile/admin_mobile_activity/init')));

		$this->display('activity_edit.dwt');
    }
  
    /**
     * 添加活动数据处理
    */
    public function insert() {
    	$this->admin_priv('mobile_activity_update', ecjia::MSGTYPE_JSON);
    	
	   	$activity_name 		= empty($_POST['activity_name']) 	? 	'' 	: trim($_POST['activity_name']);
	   	$activity_group 	= empty($_POST['activity_group']) 	? 	1 	: intval($_POST['activity_group']);
	   	$activity_object 	= empty($_POST['activity_object']) 	? 	1 	: intval($_POST['activity_object']);
	   	$enabled 			= empty($_POST['enabled']) 			? 	0 	: intval($_POST['enabled']);
	   	$limit_num 			= empty($_POST['limit_num']) 		? 	0	: intval($_POST['limit_num']);
	   	$limit_time			= empty($_POST['limit_time']) 		? 	0 	: intval($_POST['limit_time']);
	   	$start_time			= empty($_POST['start_time']) 		? 	'' 	: RC_Time::local_strtotime($_POST['start_time']);
	   	$end_time			= empty($_POST['end_time']) 		? 	'' 	: RC_Time::local_strtotime($_POST['end_time']);
	   	$activity_desc		= empty($_POST['activity_desc']) 	? 	'' 	: trim($_POST['activity_desc']);
	   
	   	//查询活动是否重名
	   	$is_only = $this->db_activity->activity_count(array('activity_name' => $activity_name));

	   	if ($is_only > 0) {
	   		return $this->showmessage(RC_Lang::get('mobile::mobile.activity_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	   	}
	    
	   	$data = array(
   			'activity_name'      => $activity_name,
   			'activity_group'     => $activity_group,
   			'activity_object'    => $activity_object,
   			'enabled'         	 => $enabled,
   			'limit_num'    		 => $limit_num,
   			'limit_time'    	 => $limit_time,
   			'start_time'    	 => $start_time,
   			'end_time'    	 	 => $end_time,
   			'activity_desc'    	 => $activity_desc,
   			'add_time'	    	 => RC_Time::gmtime(),
	   	);
	   	$id = $this->db_activity->mobile_activity_manage($data);

	   	if ($id) {
	   		/* 记录管理员操作 */
	   		ecjia_admin::admin_log($activity_name, 'add', 'mobile_activity');
	   		
	   		return $this->showmessage(sprintf(RC_Lang::get('mobile::mobile.edit_success'), $activity_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_activity/edit', array('id' => $id))));
	   	}
	}
   
	/**
     * 活动编辑页面
     */
	public function edit() {
	   	$this->admin_priv('mobile_activity_update');
	   	
	   	$activity_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
	   
	   	$activity_info = $this->db_activity->mobile_activity_find($activity_id);

		$activity_info['start_time'] = RC_Time::local_date('Y-m-d H:i', $activity_info['start_time']);
	   	$activity_info['end_time']   = RC_Time::local_date('Y-m-d H:i', $activity_info['end_time']);
	   	
	   	$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.back_activity_list'), 'href' => RC_Uri::url('mobile/admin_mobile_activity/init')));
	   	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.edit_activity')));

	   	$this->assign('ur_here', RC_Lang::get('mobile::mobile.edit_activity'));
	   	$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_activity/update'));

	   	//设置选中状态,并分配标签导航
	   	$this->assign('action',	ROUTE_A);
	   	
	   	$this->tags['edit']['active'] = 1;
	   	$this->assign('tags', $this->tags);
	   	$this->assign('activity_info', $activity_info);
	   	$this->display('activity_edit.dwt');
	}
   
   /**
   * 更新活动
   */
	public function update() {
		$this->admin_priv('mobile_activity_update', ecjia::MSGTYPE_JSON);
		
		$activity_name 	= empty($_POST['activity_name']) 	? 	'' 	: trim($_POST['activity_name']);
		$activity_group = empty($_POST['activity_group']) 	? 	1 	: intval($_POST['activity_group']);
		$activity_object= empty($_POST['activity_object']) 	? 	1 	: intval($_POST['activity_object']);
		$enabled 		= empty($_POST['enabled']) 			? 	0 	: intval($_POST['enabled']);
		$limit_num 		= empty($_POST['limit_num']) 		? 	0 	: intval($_POST['limit_num']);
		$limit_time		= empty($_POST['limit_time']) 		? 	0 	: intval($_POST['limit_time']);
		$start_time		= empty($_POST['start_time']) 		? 	'' 	: RC_Time::local_strtotime($_POST['start_time']);
		$end_time		= empty($_POST['end_time']) 		? 	'' 	: RC_Time::local_strtotime($_POST['end_time']);
		$activity_desc	= empty($_POST['activity_desc']) 	? 	'' 	: trim($_POST['activity_desc']);
		$id 			= empty($_POST['id']) 				? 	0 	: intval($_POST['id']);
		
		/*判断活动是否重名*/   
	   	$is_only = $this->db_activity->activity_count(array('activity_name' => $activity_name, 'activity_id' => array('neq' => $id)));

		if ($is_only > 0) {
	   		return $this->showmessage(RC_Lang::get('mobile::mobile.activity_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	   	}
	   	
	   	$data = array(
	   		'activity_id' 		=> $id,
		   	'activity_name'     => $activity_name,
		   	'activity_group'    => $activity_group,
		   	'activity_object'   => $activity_object,
		   	'enabled'         	=> $enabled,
		   	'limit_num'    		=> $limit_num,
		   	'limit_time'    	=> $limit_time,
		   	'start_time'    	=> $start_time,
		   	'end_time'    	 	=> $end_time,
		   	'activity_desc'    	=> $activity_desc,
		   	'add_time'	    	=> RC_Time::gmtime(),
		);
	   
	   	$updated = $this->db_activity->mobile_activity_manage($data);

	   	if ($updated){
	   		ecjia_admin::admin_log($activity_name, 'edit', 'mobile_activity');
	   		return $this->showmessage(RC_Lang::get('mobile::mobile.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_activity/edit', array('id' => $id))));
	   	} else {
	   		return $this->showmessage(RC_Lang::get('mobile::mobile.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_activity/edit', array('id' => $id))));
	   	}
	}
    
    /**
    * 删除活动
    */
	public function remove() {
	   	$this->admin_priv('mobile_activity_delete', ecjia::MSGTYPE_JSON);
	   	
	   	if (!empty($_GET['id'])){
	   		$id = intval($_GET['id']);
	   		$activity_name = $this->db_activity->mobile_activity_field($id, 'activity_name');
	   		
			$res = $this->db_activity->mobile_activity_remove($id);

			if ($res){
	   			ecjia_admin::admin_log($activity_name, 'remove', 'mobile_activity');
	   			return $this->showmessage(RC_Lang::get('mobile::mobile.del_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_activity/init')));
	   		} else {
	   			return $this->showmessage(RC_Lang::get('mobile::mobile.del_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_activity/init')));
	   		}
	   	} else {
	   		return $this->showmessage(RC_Lang::get('mobile::mobile.wrong_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	   	}
    }
    
	/**
	 * 是否使用切换
	 */
	public function toggle_show() {
	   	$this->admin_priv('mobile_activity_update', ecjia::MSGTYPE_JSON);
	   	
	   	$activity_id = intval($_POST['id']);
	   	$is_enabled  = intval($_POST['val']);
	   	
	   	$data = array(
	   		'activity_id' 	=> $activity_id,
	   		'enabled' 		=> $is_enabled
	   	);
	   	if ($this->db_activity->mobile_activity_manage($data)) {
	   		return $this->showmessage(RC_Lang::get('mobile::mobile.switch_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_enabled));
	   	}
	}
    
   /**
   * 编辑活动名称
   */
	public function edit_activity_name() {
	   	$this->admin_priv('mobile_activity_update', ecjia::MSGTYPE_JSON);
	   
	   	$activity_name = trim($_POST['value']);
	   	$id	           = intval($_POST['pk']);
	   	
		if (!empty($activity_name)) {
   			if ($this->db_activity->activity_count(array('activity_name' => $activity_name, 'activity_id' => array('neq' =>  $id))) == 0) {
   				$data = array(
   					'activity_id' 	=> $id,
   					'activity_name' => $activity_name
   				);
   				$this->db_activity->mobile_activity_manage($data);

   				return $this->showmessage(RC_Lang::get('mobile::mobile.edit_name_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
   			} else {
   				return $this->showmessage(RC_Lang::get('mobile::mobile.activity_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
   			}
	   	} else {
	   		return $this->showmessage(RC_Lang::get('mobile::mobile.fill_activity_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	   	}
	}
   
   /**
   * 活动记录列表
   */
   public function activity_record() {
	   	$this->admin_priv('activity_record_manage');
	   	
	   	$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.back_activity_list'), 'href' => RC_Uri::url('mobile/admin_mobile_activity/init')));
	   	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.view_activity_record')));
	   
	   	$this->assign('ur_here', RC_Lang::get('mobile::mobile.activity_record'));
	   	$this->assign('action_link', array('href' => RC_Uri::url('mobile/admin_mobile_activity/init'), 'text' => RC_Lang::get('mobile::mobile.back_activity_list')));
	   
	   	$list = $this->get_activity_record_list();
	   	
	   	$this->assign('activity_record_list', $list);
	   	$this->assign('tags', $this->tags);
	   	
	   	$this->display('activity_record.dwt');
	}
	
	/**
	 * 活动奖品池页面显示
	 */
	public function activity_prize() {
		$this->admin_priv('activity_record_manage');
		
		$id = intval($_GET['id']);

		$prize_list = RC_DB::table('mobile_activity_prize')->where('activity_id', $id)->orderby('prize_level', 'asc')->get();
		$this->assign('prize_list', $prize_list);
		
		$bonus_list = RC_DB::table('bonus_type')->select('type_id', 'type_name')->get();
		$this->assign('bonus_list', $bonus_list);
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.prize_pool'));
		$this->assign('id', $id);
		$this->assign('action_link', array('href' => RC_Uri::url('mobile/admin_mobile_activity/init'), 'text' => RC_Lang::get('mobile::mobile.back_activity_list')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_activity/activity_prize_edit'));
		$this->assign('tags', $this->tags);
		
		$this->display('activity_prize.dwt');
	}
	
	/**
	 * 活动奖品池编辑处理
	 */
	public function activity_prize_edit() {
		$this->admin_priv('mobile_activity_update', ecjia::MSGTYPE_JSON);
		
		$prize_level		= $_POST['prize_level'];
		$prize_name			= $_POST['prize_name'];
		$prize_type			= $_POST['prize_type'];
		$prize_value		= $_POST['prize_value'];
		$prize_value_other 	= $_POST['prize_value_other'];
		$prize_number		= $_POST['prize_number'];
		$prize_prob			= $_POST['prize_prob'];
		$prize_id			= isset($_POST['prize_id']) ? $_POST['prize_id'] : 0;
		$activity_id		= intval($_POST['id']);
		
		/* 获取奖品池的奖品id*/
		$prize_id_group = RC_DB::table('mobile_activity_prize')->where('activity_id', $activity_id)->lists('prize_id');
		
		if (!empty($prize_id_group)) {
			RC_DB::table('mobile_activity_prize')->whereIn('prize_id', $prize_id_group)->delete();
		}
		
		$count = count($prize_level);
		$i = 0;
		while ($i < $count) {
			$prize_number[$i]	= empty($prize_number[$i]) 	? 0 : $prize_number[$i];
			$prize_prob[$i]		= empty($prize_prob[$i]) 	? 0 : $prize_prob[$i];
			$data = array(
				'activity_id'	=> $activity_id,
				'prize_level'	=> $prize_level[$i],
				'prize_name'	=> $prize_name[$i],
				'prize_type'	=> $prize_type[$i],
				'prize_value'	=> $prize_type[$i] == 1 ? $prize_value[$i] : $prize_value_other[$i],
				'prize_number'	=> $prize_number[$i],
				'prize_prob'	=> $prize_prob[$i]
			);
			RC_DB::table('mobile_activity_prize')->insert($data);
			$i++;
		}
		
		return $this->showmessage(RC_Lang::get('mobile::mobile.edit_prize_pool_succss'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取活动列表
	 * @return array
	 */
	private function get_activity_list() {
		$db_activity = RC_DB::table('mobile_activity');
		/* 过滤条件 */
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
	
		$where = array();
		if (!empty($filter['keywords'])) {
			$db_activity->where('activity_name', 'like', '%'.$filter['keywords'].'%');
		}
		$filter['record_count'] = $db_activity->count();
		$page = new ecjia_page($filter['record_count'], 15, 5);
		$res = $db_activity->orderBy('add_time', 'desc')->take(15)->skip($page->start_id-1)->get();
		
		if (!empty($res)) {
			foreach ($res as $key => $val) {
				$res[$key]['start_time']  	= RC_Time::local_date('Y-m-d H:i:s', $res[$key]['start_time']);
				$res[$key]['end_time']    	= RC_Time::local_date('Y-m-d H:i:s', $res[$key]['end_time']);
			}
		}
		return array('item' => $res, 'filter' => $filter, 'page' => $page->show(), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
	}
	
	/**
	 * 获取活动记录列表数据
	 * @return array
	 */
	private function get_activity_record_list() {
		$db_activity_log = RC_DB::table('mobile_activity_log');
		
		$activity_id = empty($_GET['id']) ? '0' : $_GET['id'] ;
		$db_activity_log->where('activity_id', $activity_id);
		
		$count = $db_activity_log->count();
		$page  = new ecjia_page($count, 15, 5);
		$res   = $db_activity_log->where('activity_id', $activity_id)->orderBy('add_time', 'desc')->take(15)->skip($page->start_id-1)->get();

		if (!empty($res)) {
			foreach ($res as $key => $val) {
				$res[$key]['issue_time']  	= RC_Time::local_date('Y-m-d H:i:s', $res[$key]['issue_time']);
				$res[$key]['add_time']    	= RC_Time::local_date('Y-m-d H:i:s', $res[$key]['add_time']);
			}
		}
		return array('item' => $res, 'page' => $page->show(), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
	}
}

// end