<?php
/**
 * 客户来源管理
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_customer_source extends ecjia_admin {
	private $db_customer_source;
	private $db_customer_source_view;
    public function __construct() {
        parent::__construct();
        /* 加载所需数据模型 */
        $this->db_customer_source 	   = RC_Loader::load_app_model('customer_source_model', 'customer');
        $this->db_customer_source_view = RC_Loader::load_app_model('customer_source_viewmodel', 'customer');
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
        RC_Script::enqueue_script('customer_source', RC_App::apps_url('statics/js/customer_source.js', __FILE__));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户来源列表'), RC_Uri::url('customer/admin_customer_source/init')));
    }

    /**
     * 客户来源列表页面
     */
    public function init() {
        /* 客户来源管理权限 */
        $this->admin_priv('customer_source_list');
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户来源列表')));
        $this->assign('ur_here', __('客户来源列表'));
        $customer_source_list = $this->get_list();
        $page		 = (!empty($_GET['page'])) ? intval($_GET['page']) : '';
        $keywords	 = (!empty($_GET['keywords'])) ? trim($_GET['keywords']) : '';
        $this->assign('keywords', $keywords); //关键字搜索
        $this->assign('page', $page);
        $this->assign('customer_source_list', $customer_source_list);
        $this->assign('search_action', RC_Uri::url('customer/admin_customer_source/init'));
        
        //批量操作
        $this->assign('form_action', RC_Uri::url('customer/admin_customer_source/batch', array('page' => $page)));
        //权限
        $this->assign('customer_source_add', $this->admin_priv('customer_source_add', '', false));//添加来源权限
        $this->assign('customer_source_update', $this->admin_priv('customer_source_update', '', false));//编辑来源权限
        $this->assign('customer_source_batch', $this->admin_priv('customer_source_batch', '', false));//批量删除权限
        
        $this->display('customer_source_list.dwt');
        
    }
	
    /**
     * 处理添加的客户来源数据
     */
    public function insert() {
    	$this->admin_priv('customer_source_add');
    	$source_name = isset($_POST['source_name']) ? trim($_POST['source_name']) : '';
    	$adder = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '' ;
    	$add_time = RC_Time::gmtime();
    	$page = (!empty($_POST['page'])) ? intval($_POST['page']) : '';
    	$keywords = (!empty($_POST['add_keywords'])) ? intval($_POST['add_keywords']) : '';
    	if (!empty($source_name)) {
    		$data = array(
    				'source_name' 		=> $source_name,
    				'adder'  			=> $adder,
    				'is_lock'  			=> 0,
    				'is_delete'			=> 0,
    				'add_time'  		=> $add_time,
    		);
    		$customer_source_info = $this->db_customer_source->insert($data);
    
    		//log
    		ecjia_admin_log::instance()->add_object('customer_source', '客户来源');
    		ecjia_admin::admin_log($source_name, 'add', 'customer_source');
    		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array( 'pjaxurl' => RC_Uri::url('customer/admin_customer_source/init', array('page' => $page, 'keywords' => $keywords))));
    	} else {
    		$this->showmessage('客户来源名称不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 编辑客户来源
     */
    public function update() {
    	$this->admin_priv('customer_source_update');
    	$source_id = isset($_POST['source_id']) ? intval($_POST['source_id']) : '';
    	if (empty($source_id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$source_name = isset($_POST['source_name']) ? trim($_POST['source_name']) : '';
    	$adder = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '' ;
    	$add_time = RC_Time::gmtime();
    	$page = (!empty($_POST['page'])) ? intval($_POST['page']) : '';
    	$keywords = !empty($_POST['edit_keywords']) ? intval($_POST['edit_keywords']) : '';
    	if (!empty($source_name)) {
    		$data = array(
    				'source_name' 		=> $source_name,
    				'adder'  			=> $adder,
    				'is_lock'  			=> 0,
    				'is_delete'			=> 0,
    				'update_time'  		=> $add_time,
    		);
    		$customer_source_info_update = $this->db_customer_source->where(array('source_id' => $source_id))->update($data);
    
    		//log
    		ecjia_admin_log::instance()->add_object('customer_source', '客户来源');
    		ecjia_admin::admin_log($source_name, 'edit', 'customer_source');
    		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array( 'pjaxurl' => RC_Uri::url('customer/admin_customer_source/init', array('page' => $page, 'keywords' => $keywords))));
    	} else {
    		$this->showmessage('客户来源名称不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 删除客户来源
     */
    public function remove() {
    	$this->admin_priv('customer_source_del');
    	$is_delete = 1;
    	$source_name = isset($_GET['source_name']) ? trim($_GET['source_name']) : '';
    	$data = array(
            'is_delete' => $is_delete
        );
    	$where['source_id'] = isset($_GET['id']) ? trim($_GET['id']) : '';
    	if (empty($where['source_id'])) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$delete = $this->db_customer_source->where($where)->update($data);
    	//log
    	ecjia_admin_log::instance()->add_object('customer_source', '客户来源');
    	ecjia_admin::admin_log($source_name, 'remove', 'customer_source');
    	if ($delete) {
            $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            $this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
    /**
     * 批量操作
     */
    public function batch() {
    	$this->admin_priv('customer_source_batch');
    	$source_ids = (!empty($_POST['checkboxes'])) ? trim($_POST['checkboxes']) : '';
    	if (empty($source_ids)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$info = $this->db_customer_source->in(array('source_id' => $source_ids))->select();
    	$type = (!empty($_GET['type'])) ? trim($_GET['type']) : '';
    	if (!empty($type)) {
    		if ($type == 'button_remove') {
                $data = array(
                    'is_delete' => 1
                );
            } else {
                $this->showmessage('操作失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
    		$this->db_customer_source->in(array('source_id' => $source_ids))->update($data);
    		//log
    		ecjia_admin_log::instance()->add_object('customer_source', '客户来源');
    		if ($info) {
    		    foreach ($info as $v) {
    		        ecjia_admin::admin_log($v['source_name'], 'batch_remove', 'customer_source');
    		    }
    		}
    		$this->showmessage('操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array( 'pjaxurl' => RC_Uri::url('customer/admin_customer_source/init')));
    	} else {
    		$this->showmessage('请选择要删除的客户来源', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 修改是否默认
     */
    public function is_default() {
    	$this->admin_priv('customer_source_update');
    	$source_id  = !empty($_POST['id']) ? intval($_POST['id']) : '';
    	$is_lock  = !empty($_POST['val']) ? intval($_POST['val']) : '';
    	$data = array(
    			'is_lock'       => $is_lock
    	);
    	$rs = false;
    	if ($is_lock == 1) {
    		$update = $this->db_customer_source->where(array('source_id' => $source_id))->update($data);
    		$update_other = null;
    		if($update) {
    			$update_other = $this->db_customer_source->where(array('source_id' => array('neq' => $source_id)))->update(array('is_lock' => '0'));
    		}
        	if ($update && $update_other) {
        	    $rs = true;
        	}
    	} else {
    		$update = $this->db_customer_source->where(array('source_id' => $source_id))->update($data);
    		if ($update) {
    		    $rs = true;
    		}
    	}
    	if ($rs) {
    		$this->showmessage('设置成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_lock, 'pjaxurl' => RC_Uri::url('customer/admin_customer_source/init')));
    	} else {
    	    $this->showmessage('设置失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 获取客户来源列表
     */
    private function get_list() {
    	$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
    	$where = array();
    	if (!empty($keywords)) {
    		$where[] = '(`source_name` like "%' . $keywords . '%")';
    	}
    	$where['c.is_delete'] = '0';
    	$count = $this->db_customer_source_view->join(array('admin_user'))->where($where)->count('c.source_id');
    	RC_Loader::load_sys_class('ecjia_page', false);
    	$page = new ecjia_page($count, 15, 5);
    	$row = $this->db_customer_source_view->join(array('admin_user'))->field('c.*,au.user_name as adder')->order('`add_time` DESC')->limit($page->limit())->where($where)->select();
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
