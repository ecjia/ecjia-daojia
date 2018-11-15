<?php
/**
 * 客户联系记录，回访计划管理
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_contact extends ecjia_admin {
	private $db_customer_feedback_view;
	private $db_feedback;
	private $db_view;
	private $db_contact_way;
	private $db_customer_contact_way_view;
	
    public function __construct() {
        parent::__construct();
        /* 加载所需数据模型 */
        $this->db_customer_feedback_view  = RC_Loader::load_app_model('customer_feedback_viewmodel', 'customer');
        $this->db_feedback    		   	  = RC_Loader::load_app_model('customer_feedback_model', 'customer');
        $this->db_view 					  = RC_Loader::load_app_model('customer_viewmodel', 'customer');
        $this->db_contact_way 			  = RC_Loader::load_app_model('customer_contact_way_model', 'customer');
        $this->db_customer_contact_way_view = RC_Loader::load_app_model('customer_contact_way_viewmodel', 'customer');
        /*加载func*/
        RC_Loader::load_app_func('customer', 'customer'); 
        /* 加载所有全局 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        /*时间控件*/
        RC_Style::enqueue_style('datepicker', RC_App::app_dir_url(__FILE__) . 'statics/datepicker/bootstrap-datetimepicker.min.css');
        RC_Script::enqueue_script('bootstrap-timepicker', RC_App::app_dir_url(__FILE__) . 'statics/datepicker/bootstrap-datetimepicker.min.js');
        RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, true);
        RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
        /* 加载自定义js */
        RC_Script::enqueue_script('contact_record_list', RC_App::apps_url('statics/js/contact_record_list.js', __FILE__));
        RC_Script::enqueue_script('contact_plan', RC_App::apps_url('statics/js/contact_plan.js', __FILE__));
        RC_Script::enqueue_script('contact_way', RC_App::apps_url('statics/js/contact_way.js', __FILE__));
        RC_Script::enqueue_script('contact_record', RC_App::apps_url('statics/js/contact_record.js', __FILE__));
    }

        
    /**
     * 联系记录列表
     */
    public function init() {
        /**
         * 联系类型： 客户回访，客户来电，读取数据表（customer_contact_type），列表顶部切换
         */
        /* 客户联系记录列表权限 */
        $this->admin_priv('customer_contact_list');
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('联系记录')));
        $this->assign('ur_here', __('联系记录'));
        $status = (!empty($_GET['status'])) ? intval($_GET['status']) : '';
        $contact_record_list = $this->get_list();
        if ($contact_record_list) {
            $this->assign('keywords', $contact_record_list['filter']['keywords']); //关键字搜索
            $this->assign('status', $contact_record_list['filter']['status']);
            $this->assign('adminner', $contact_record_list['filter']['adminner']);
            $this->assign('way', $contact_record_list['filter']['way']);
            $this->assign('contact_time1', $contact_record_list['filter']['contact_time1']);
            $this->assign('contact_time2', $contact_record_list['filter']['contact_time2']);
            $this->assign('page', $contact_record_list['current_page']); //搜索后的页码
            $this->assign('contact_record_list', $contact_record_list);
            $this->assign('search_action', RC_Uri::url('customer/admin_contact/init'));
            $this->assign('search_contact_action', RC_Uri::url('customer/admin_contact/init'));
            /*查看详情*/
            $this->assign('detail_action', RC_Uri::url('customer/admin_contact/detail', array('page' => $contact_record_list['current_page'])));
            //批量操作
            $this->assign('form_action', RC_Uri::url('customer/admin_contact/batch', array('page' => $contact_record_list['current_page'])));
        }
        $this->assign('search_action', RC_Uri::url('customer/admin_contact/init'));
        $this->assign('search_contact_action', RC_Uri::url('customer/admin_contact/init'));
        //获取员工，联系方式列表
        $this->assign('admin_list', get_admin_user_list());
        $this->assign('contact_way_list', get_contact_way_list());
       
        $this->display('contact_list.dwt');
    }
    
    /**
     * 获取联系记录详情
     */
    public function detail() {
    	$this->admin_priv('customer_contact_list');
    	$feed_id           = $_GET['feed_id'];
    	$demand_detail = $this->db_customer_feedback_view->join(array('customer', 'admin_user', 'customer_contact_type', 'customer_contact_way', 'customer_linkman', 'customer_source', 'customer_state'))
    	->field('cf.*, c.customer_name, cs.state_name, cl.link_man_name, cl.sex, cw.way_name, ct.type_name, au.user_name, co.source_name')->where(array('feed_id' => $feed_id))->find();
    	$sex = array('0' => '男', '1' => '女');
    	if ($demand_detail) {
    	    if ($demand_detail['add_time']) {
    	        $demand_detail['contact_time'] = RC_Time::local_date('Y-m-d H:i', $demand_detail['add_time']);
    	    }
    	    if ($demand_detail['next_time']) {
    	        $demand_detail['next'] = RC_Time::local_date('Y-m-d H:i', $demand_detail['next_time']);
    	    }
    	    if ($demand_detail['sex'] != '') {
    	        $demand_detail['sex_new'] = $sex[$demand_detail['sex']];
    	    }
    	}
    	
    	$this->showmessage($demand_detail,  ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    /**
     * 批量移除联系记录
     */
    public function batch() {
    	$this->admin_priv('customer_contact_del_batch');
    	$status = $_GET['status'];
    	$page = $_GET['page'];
    	$ids = $_POST['checkboxes'];
    	$info = $this->db_customer_feedback_view->join(array('customer'))->field('c.customer_name, cf.summary')->in(array('cf.feed_id' => $ids))->select();
    	if (!empty($_GET['type'])) {
    		$result = $this->db_feedback->in(array('feed_id' => $ids))->delete();
    		if($result) {
    			//log
    			ecjia_admin_log::instance()->add_object('contact_record', '联系记录');
    			if ($info) {
    			    foreach ($info as $v) {
    			        $summary = RC_String::sub_str($v['summary'], '10');
    			        $name = $summary.'【'.$v['customer_name'].'】';
    			        ecjia_admin::admin_log($name, 'batch_remove', 'contact_record');
    			    }
    			}
    			
    			$this->showmessage('操作成功！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array( 'pjaxurl' => RC_Uri::url('customer/admin_contact/init',array('status' => $status, 'page' => $page))));
    		}else{
    			$this->showmessage('操作失败！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    	} else {
    		$this->showmessage('请选择要移至回收站的联系记录',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    
    }
    
    /**
     * 回访计划列表
     */
    public function contact_plan() {
    	/* 权限 */
    	$this->admin_priv('customer_contact_plan');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('回访计划')));
        $this->assign('ur_here', __('回访计划'));
        $status		 = (!empty($_GET['status'])) ? intval($_GET['status']) : '';
        $contact_plan_list = $this->get_contact_plan_list();
        if ($contact_plan_list) {
            $this->assign('keywords', $contact_plan_list['filter']['keywords']); //关键字搜索
            $this->assign('begin_date', $contact_plan_list['filter']['begin_date']);
            $this->assign('end_date', $contact_plan_list['filter']['end_date']);
            $this->assign('page', $contact_plan_list['current_page']); //搜索后的页码
            $this->assign('contact_record_list', $contact_plan_list);
        }
        
        $this->assign('search_action', RC_Uri::url('customer/admin_contact/contact_plan'));
        $this->display('contact_plan_list.dwt');
    }
    /**
     * 联系方式列表
     */
    public function way_list() {
        /*权限 */
        $this->admin_priv('customer_contact_way_manage');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('联系方式管理')));
        $this->assign('ur_here', __('联系方式列表'));
        
        $contact_way_list = $this->get_way_list();
        $this->assign('page', $contact_way_list['current_page']);
        $this->assign('contact_way_list', $contact_way_list);
        //权限
        $this->assign('contact_way_add', $this->admin_priv('contact_way_add', '', false));//添加联系方式权限
        $this->assign('contact_way_update', $this->admin_priv('contact_way_update', '', false));//编辑联系方式权限
        
        $this->display('contact_way_list.dwt');
    }
    
    /**
     * 处理添加的联系方式数据
     */
    public function contact_way_insert() {
    	$this->admin_priv('contact_way_add');
    	$way_name = isset($_POST['way_name']) ? trim($_POST['way_name']) : '';
    	$sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : '';
    	$adder = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '' ;
    	$add_time = RC_Time::gmtime();
    	$page = $_POST['page'];
    	if (!empty($way_name)) {
    		$data = array(
    				'way_name' 		=> $way_name,
    				'adder'  			=> $adder,
    				'sort_order'		=> $sort_order,
    				'is_delete'			=> 0,
    				'updater'  			=> $adder,
    				'update_time'  		=> $add_time,
    				'add_time'  		=> $add_time,
    		);
    		$contact_way_info = $this->db_contact_way->insert($data);
    
    		//log
    		ecjia_admin_log::instance()->add_object('contact_way', '联系方式');
    		ecjia_admin::admin_log($way_name,'add','contact_way');
    		$this->showmessage('操作成功',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array( 'pjaxurl' => RC_Uri::url('customer/admin_contact/way_list', array('page' =>$page))));
    	} else {
    		$this->showmessage('联系方式名称不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 编辑联系方式
     */
    public function contact_way_update() {
    	$this->admin_priv('contact_way_update');
    	$way_id = $_POST['way_id'];
    	$way_name = isset($_POST['way_name']) ? trim($_POST['way_name']) : '';
    	$sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : '';
    	$updater = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '' ;
    	$add_time = RC_Time::gmtime();
    	$page = $_POST['page'];
    	if (!empty($way_name)) {
    		$data = array(
    				'way_name'	 		=> $way_name,
    				'updater'  			=> $updater,
    				'sort_order'		=> $sort_order,
    				'update_time'  		=> $add_time,
    		);
    		$update = $this->db_contact_way->where(array('way_id' => $way_id))->update($data);
    
    		//log
    		ecjia_admin_log::instance()->add_object('contact_way', '联系方式');
    		ecjia_admin::admin_log($way_name,'edit','contact_way');
    		$this->showmessage('操作成功',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array( 'pjaxurl' => RC_Uri::url('customer/admin_contact/way_list', array('page' =>$page))));
    	} else {
    		$this->showmessage('联系方式名称不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 删除联系方式
     */
    public function contact_way_remove() {
    	$this->admin_priv('contact_way_delete');
    	$is_delete = 1;
    	$id = $_GET['id'];
    	$way_name = $_GET['way_name'];
    	
    	$data = array(
    			'is_delete' => $is_delete,
    	);
    	$where['way_id'] = $id;
    	$delete = $this->db_contact_way->where($where)->update($data);
    	//log
    	ecjia_admin_log::instance()->add_object('contact_way', '联系方式');
    	ecjia_admin::admin_log($way_name, 'remove','contact_way');
    	if ($delete)
    	{
    		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    	} else {
    		$this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 获取联系记录列表
     */
    private function get_contact_plan_list() {
    	$filter['keywords'] = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
    	$filter['begin_date'] = !empty($_GET['begin_date']) ? RC_Time::local_strtotime($_GET['begin_date']) : '';
    	$filter['end_date'] = !empty($_GET['end_date']) ? RC_Time::local_strtotime($_GET['end_date']) : '';
    	$this->check_begin_end_time($filter['begin_date'],$filter['end_date']);
    	$today_time = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', RC_Time::gmtime())) + (86400 - 1);
    	
    	$where = array();
    	$where['cf.next_time'] = array('elt' => $today_time);
    	$where['cf.next_goal'] = array('neq' => '');
    	$where['cf.next_time'] = array('neq' => '');
    	
    	if (!empty($filter['keywords'])) {
    		$where[] = '((`customer_name` like "%' . $filter['keywords'] . '%")  or (`link_man_name` like "%' . $filter['keywords'] . '%")  or (cf.telphone like "%' . $filter['keywords'] . '%")
					  or (cf.summary like "%' . $filter['keywords'] . '%")or (au.user_name like "%' . $filter['keywords'] . '%"))';
    	}
    	
    	if ($filter['begin_date'] != '' && $filter['end_date'] != '') {
    		$where['cf.next_time'] = array('egt' => $filter['begin_date'] , 'elt' => $filter['end_date']);
    	}
    	 
    	RC_Loader::load_sys_class('ecjia_page', false);
    
    	$count = $this->db_customer_feedback_view->join(array('admin_user','customer', 'customer_linkman', 'customer_contact_type'))->where($where)->count();
    	$page  = new ecjia_page($count,10, 5);
    	$row = $this->db_customer_feedback_view->join(array('admin_user', 'customer', 'customer_linkman', 'customer_contact_type'))->field('cf.*,c.customer_name,c.url, cl.link_man_name,cl.sex,ct.type_name,au.user_name')->where($where)->order(array('cf.add_time' => 'desc'))->limit($page->limit())->select();
    	if ($row) {
    	    foreach ($row as $key => $val) {
    	        $row[$key]['add_time']      	= RC_Time::local_date('Y-m-d H:i', $row[$key]['add_time']);
    	        $row[$key]['next_time']			= RC_Time::local_date('Y-m-d H:i', $row[$key]['next_time']);
    	        $row[$key]['summary'] 			= RC_String::sub_str($val ['summary'], '60');
    	        $row[$key]['next_goal'] 		= RC_String::sub_str($val ['next_goal'], '60');
    	    }
    	}
    	
    	$arr = array('list' => $row, 'filter' => $filter, 'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page); //'filter' => $filter,筛选
    	return $arr;
    }
    
    /**
     * 获取联系记录列表
     */
    private function get_list() {
    	$filter['keywords'] = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
    	$filter['adminner'] = isset($_GET['adminner']) ? intval($_GET['adminner']) : '';
    	$filter['way'] 		= isset($_GET['way']) ? intval($_GET['way']) : '';
    	$filter['contact_time1'] = !empty($_GET['contact_time1']) ? RC_Time::local_strtotime($_GET['contact_time1']) : '';
    	$filter['contact_time2'] = !empty($_GET['contact_time2']) ? RC_Time::local_strtotime($_GET['contact_time2']) : '';
    	$filter['status']   = isset($_GET['status']) ? $_GET['status']:'1';
    	$this->check_begin_end_time($filter['contact_time1'],$filter['contact_time2']);
    	$where = array();
    	
    	if (!empty($filter['keywords'])) {
    		$where[] = '((`customer_name` like "%' . $filter['keywords'] . '%")  or (`link_man_name` like "%' . $filter['keywords'] . '%")  or (cf.telphone like "%' . $filter['keywords'] . '%")
					  or (cf.summary like "%' . $filter['keywords'] . '%"))';
    	}
    	
    	if ($filter['contact_time1'] !='' && $filter['contact_time2'] !='') {
    		$where['cf.add_time'] = array('egt' => $filter['contact_time1'] , 'elt' => $filter['contact_time2']);
    	}
    	
    	/*员工和联系方式*/
    	if(!empty($filter['adminner'])) {
    		$where['cf.adder'] = $filter['adminner'];
    	}
    	if(!empty($filter['way'])) {
    		$where['cf.type'] = $filter['way'];
    	}
    	
    	RC_Loader::load_sys_class('ecjia_page', false);
    	
    	$counts = $this->db_customer_feedback_view->field("SUM(cf.link_type=1) AS customer_visits,SUM(cf.link_type=2 ) AS customer_calls")->where($where)->select();
    	$counts[0]['all'] = $counts[0]['customer_visits'] + $counts[0]['customer_calls'];
    	$filter['count'] = $counts[0];
    	
    	if($filter['status'] == '3') {
    		$where['cf.link_type'] = '1';
    	} elseif ($filter['status'] == '-1') {
    		$where['cf.link_type'] = '2';
    	}
    
    	$count = $this->db_customer_feedback_view->join(array('customer', 'customer_linkman', 'customer_contact_type', 'customer_contact_way'))->where($where)->count();
    	
    	if($filter['status'] == '1') {
    		$filter['all'] = $count;
    	} elseif($filter['status'] == '3') {
    		$filter['customer_visits'] = $count;
    	}elseif ($filter['status'] == '-1') {
    		$filter['customer_calls'] = $count;
    	}
    	$page  = new ecjia_page($count,10, 5);
    	$row = $this->db_customer_feedback_view->join(array('customer', 'customer_linkman', 'customer_contact_type', 'customer_contact_way'))->field('cf.*, c.customer_name, cl.link_man_name,cl.mobile,cl.sex,ct.type_name, cw.way_name')->where($where)->order(array('cf.add_time' => 'desc'))->limit($page->limit())->select();
    	if ($row) {
    	    foreach ($row as $key => $val) {
        		$row[$key]['add_time'] =  RC_Time::local_date('Y-m-d H:i', $row[$key]['add_time']);
        	}
    	}
    	
    	$arr = array('list' => $row, 'filter' => $filter, 'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page); //'filter' => $filter,筛选
    	return $arr;
    }

    /**
     * 获取联系方式列表
     */
    private function get_way_list() {
    	$where = array();
    	$where['is_delete'] = '0';
    	$count = $this->db_customer_contact_way_view->join(array('admin_user'))->where($where)->count();
    	$page  = new ecjia_page($count,10, 5);
    	$row = $this->db_customer_contact_way_view->join(array('admin_user'))->field('cw.*, au.user_name as updater')->where($where)->order(array('cw.sort_order' => 'asc'))->limit($page->limit())->select();
    	if ($row) {
    	    foreach($row as $key => $val) {
        		$row[$key]['update_time']      	= RC_Time::local_date('Y-m-d H:i', $row[$key]['update_time']);
        	}
    	}
    	
    	$arr = array('list' => $row, 'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page); 
    	return $arr;
    }
    
    /**
     * 检查开始时间是否大于结束时间
     * @return showmessage
     */
    private function check_begin_end_time($sta,$end){
    	if ($sta > $end) {
    		$this->showmessage('结束日期不能小于开始日期',ecjia::MSGTYPE_JSON|ecjia::MSGSTAT_ERROR);
    	}
    }
    
//end
}
