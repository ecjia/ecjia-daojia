<?php
/**
 * 客户类别管理
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_customer_type extends ecjia_admin {
	private $db_customer_state_view;
	private $db_customer_state;
	private $db_customer_view;
	private $db_customer;
    public function __construct() {
        parent::__construct();
        /* 加载所需数据模型 */
        $this->db_customer_state   = RC_Loader::load_app_model('customer_state_model', 'customer');
        $this->db_customer 	       = RC_Loader::load_app_model('customer_model', 'customer');
        $this->db_customer_view    = RC_Loader::load_app_model('customer_viewmodel', 'customer');
        $this->db_customer_state_view  = RC_Loader::load_app_model('customer_state_viewmodel', 'customer');
        /* 加载所有全局 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        /* 加载自定义js */
        RC_Script::enqueue_script('customer_type_search', RC_App::apps_url('statics/js/customer_type_search.js', __FILE__));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户类别列表'), RC_Uri::url('customer/admin_customer_type/init')));
    }

    /**
     * 客户类别列表页面
     */
    public function init() {
        /* 客户类别管理权限 */
        $this->admin_priv('customer_type_list');
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户类别列表')));
        $this->assign('ur_here', __('客户类别列表'));
        $customer_type_list = $this->get_list();
        $page		 = (!empty($_GET['page'])) ? intval($_GET['page']) : '';
        $keywords	 = (!empty($_GET['keywords'])) ? trim($_GET['keywords']) : '';
        $this->assign('keywords', $keywords); //关键字搜索
        $this->assign('page', $page);
        $this->assign('customer_type_list', $customer_type_list);
        $this->assign('search_action', RC_Uri::url('customer/admin_customer_type/init'));
        
        //批量操作
        $this->assign('form_action', RC_Uri::url('customer/admin_customer_type/batch', array('page' => $page)));
        //权限
        $this->assign('customer_type_add', $this->admin_priv('customer_type_add', '', false));//添加类别权限
        $this->assign('customer_type_update', $this->admin_priv('customer_type_update', '', false));//编辑类别权限
        $this->assign('customer_type_batch', $this->admin_priv('customer_type_batch', '', false));//批量删除权限
        
        $this->display('customer_type_list.dwt');
        
    }
	
    /**
     * 处理添加的客户类别数据
     */
    public function insert() {
    	$this->admin_priv('customer_type_add');
    	$state_name = isset($_POST['state_name']) ? trim($_POST['state_name']) : '';
    	$summary = isset($_POST['summary']) ? $_POST['summary'] : '';
    	$adder = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '' ;
    	$add_time = RC_Time::gmtime();
    	$page = $_POST['page'];
    	$keywords = $_POST['add_keywords'];
    	if (!empty($state_name)) {
    		$data = array(
    				'state_name' 		=> $state_name,
    				'adder'  			=> $adder,
    				'summary'			=> $summary,
    				'is_lock'  			=> 0,
    				'is_delete'			=> 0,
    				'add_time'  		=> $add_time,
    		);
    		$customer_source_info = $this->db_customer_state->insert($data);
    
    		//log
    		ecjia_admin_log::instance()->add_object('customer_type', '客户类别');
    		ecjia_admin::admin_log($state_name,'add','customer_type');
    		$this->showmessage('操作成功',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array( 'pjaxurl' => RC_Uri::url('customer/admin_customer_type/init', array('page' =>$page, 'keywords' =>$keywords))));
    	} else {
    		$this->showmessage('客户来源名称不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 编辑客户类别
     */
    public function update() {
    	$this->admin_priv('customer_type_update');
    	$state_id = $_POST['state_id'];
    	$state_name = isset($_POST['state_name']) ? trim($_POST['state_name']) : '';
    	$summary = isset($_POST['summary']) ? $_POST['summary'] : '';
    	$adder = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '' ;
    	$add_time = RC_Time::gmtime();
    	$page = $_POST['page'];
    	$keywords = $_POST['edit_keywords'];
    	if (!empty($state_name)) {
    		$data = array(
    				'state_name' 		=> $state_name,
    				'adder'  			=> $adder,
    				'summary'			=> $summary,
    				'is_lock'  			=> 0,
    				'is_delete'			=> 0,
    				'update_time'  		=> $add_time,
    		);
    		$customer_state_info_update = $this->db_customer_state->where(array('state_id' => $state_id))->update($data);
    
    		//log
    		ecjia_admin_log::instance()->add_object('customer_type', '客户类别');
    		ecjia_admin::admin_log($state_name,'edit','customer_type');
    		$this->showmessage('操作成功',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array( 'pjaxurl' => RC_Uri::url('customer/admin_customer_type/init', array('page' =>$page, 'keywords' =>$keywords))));
    	} else {
    		$this->showmessage('客户来源名称不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
   /**
     * 删除客户类别
     */
    public function remove() {
    	$this->admin_priv('customer_type_del');
    	$is_delete = 1;
    	$id = $_GET['id'];
    	$state_name = $_GET['state_name'];
    	$count = $this->db_customer->where(array('state_id' => $id))->count();
    	if( $count > 0 ) {
    		$this->showmessage('类别【'.$state_name.'】已经被客户使用了，不允许删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$data = array(
    			'is_delete' => $is_delete,
    	);
    	$where['state_id'] = $id;
    	$delete = $this->db_customer_state->where($where)->update($data);
    	//log
    	ecjia_admin_log::instance()->add_object('customer_type', '客户类别');
    	ecjia_admin::admin_log($state_name,'remove','customer_type');
    	if ($delete)
    	{
    		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    	} else {
    		$this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
   /**
     * 批量操作
     */
    public function batch() {
    	$this->admin_priv('customer_type_batch');
    	$state_ids = $_POST['checkboxes'];
    	$info = $this->db_customer_state->in(array('state_id' => $state_ids))->select();
    	$in_ids_name = $this->db_customer_view->join(array('customer_state'))->in(array('cs.state_id' => $state_ids))->field('cs.state_name')->select();
    	if( !empty($in_ids_name) ) {
    		foreach($in_ids_name as $val) {
    			$name .= $val['state_name'].'，';
    		}
    		$name_new = rtrim($name, '，');
    		$this->showmessage('类别【'.$name_new.'】已经被客户使用了，不允许删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	if (!empty($_GET['type'])) {
    		if ($_GET['type'] == 'button_remove') {
    			$data = array(
    					'is_delete' =>1,
    			);
    		}else {
    			$this->showmessage('操作失败！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		$this->db_customer_state->in(array('state_id' => $state_ids))->update($data);
    		//log
    		ecjia_admin_log::instance()->add_object('customer_type', '客户类别');
    	    if ($info) {
    		    foreach ($info as $v) {
    		        ecjia_admin::admin_log($v['state_name'], 'batch_remove', 'customer_type');
    		    }
    		}
    		$this->showmessage('操作成功！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array( 'pjaxurl' => RC_Uri::url('customer/admin_customer_type/init')));
    	} else {
    		$this->showmessage('请选择要删除的客户类别',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 修改是否默认
     */
    public function is_default() {
    	$this->admin_priv('customer_type_update');
    	$state_id  = intval($_POST['id']);
    	$is_lock  = intval($_POST['val']);
    	$data = array(
    			'is_lock'       => $is_lock
    	);
    	if($is_lock == 1){
    		$update1 = $this->db_customer_state->where(array('state_id' => $state_id))->update($data);
    		if($update1) {
    			$update_other = $this->db_customer_state->where(array('state_id' => array('neq' => $state_id)))->update(array('is_lock' => '0'));
    		}
    		if ($update1 && $update_other) {
    		    $this->showmessage('设置成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_lock, 'pjaxurl' => RC_Uri::url('customer/admin_customer_type/init')));
    		}
    	} else {
    		$update = $this->db_customer_state->where(array('state_id' => $state_id))->update($data);
    		if ($update) {
    		    $this->showmessage('设置成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_lock, 'pjaxurl' => RC_Uri::url('customer/admin_customer_type/init')));
    		}
    	}
    }
    
    /**
     * 获取客户类别列表
     */
    private function get_list() {
    	$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
    	$where = array();
    	if (!empty($keywords)) {
    		$where[] = '((`state_name` like "%' . $keywords . '%")  or (`summary` like "%' . $keywords . '%"))';
    	}
    	$where['cs.is_delete'] = '0';
    	$count = $this->db_customer_state_view->where($where)->count('cs.state_id');
    	RC_Loader::load_sys_class('ecjia_page', false);
    	$page = new ecjia_page($count, 15, 5); 
    	$row = $this->db_customer_state_view->join(array('admin_user'))->field('cs.*,au.user_name as adder')->order('`add_time` DESC')->limit($page->limit())->where($where)->select();
    	if ($row) {
    	    foreach ($row as $key => $val) {
    	        $row[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i', $row[$key]['add_time']);
    	    }
    	}
    
    	$arr = array('list' => $row,'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page); //'filter' => $filter,筛选
    	return $arr;
    }
    
//end
}
