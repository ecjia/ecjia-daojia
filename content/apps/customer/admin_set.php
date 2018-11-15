<?php
/**
 * 客户设置模块
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_set extends ecjia_admin {

    private $db_customer_exists_fields;
    
    public function __construct() {
        parent::__construct();
        /* 加载所需数据模型 */
        $this->db_customer_exists_fields = RC_Loader::load_app_model('customer_exists_fields_model', 'customer');
        
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
        RC_Script::enqueue_script('customer_set', RC_App::apps_url('statics/js/customer_set.js', __FILE__));
        // 加载func
        RC_Loader::load_app_func('customer', 'customer'); // 加载customer.func
		/*导航*/
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户设置'), RC_Uri::url('customer/admin_set/init')));
		
    }

    /**
     * 包括客户池设置，客户验证设置
     */
    public function init() {
        /* 权限 */
        $this->admin_priv('customer_set');
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户设置')));
        //判断shop_config数据表是否存在以下配置
        if (!ecjia::config('customer_pool_isopen', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'customer_pool_isopen', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('customer_pool_range', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'customer_pool_range', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('customer_pool_period', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'customer_pool_period', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('customer_pool_gain_max', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'customer_pool_gain_max', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('customer_pool_gain_max_day', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'customer_pool_gain_max_day', '', array('type' => 'hidden'));
        }
        
        $this->assign('customer_pool_isopen', 		ecjia::config('customer_pool_isopen'));
        $this->assign('customer_pool_period', 		ecjia::config('customer_pool_period'));
        $this->assign('customer_pool_gain_max', 	ecjia::config('customer_pool_gain_max'));
        $this->assign('customer_pool_gain_max_day', ecjia::config('customer_pool_gain_max_day'));
       	$type_list = get_customer_type_list();
       	$range = ecjia::config('customer_pool_range');
       	$range_new = explode(',', $range);
		foreach ($type_list as $key => $val) {
			if(in_array($val['state_id'], $range_new)) {
				$type_list[$key]['checked'] = $val['state_id'];
			}
		}
       	$this->assign('customer_type_list', $type_list);
       	$this->assign('exists_fields',get_customer_exists_fields());
      
        $this->assign('form_action', RC_Uri::url('customer/admin_set/customer_set_update'));
        $this->display('customer_set.dwt');
        
    }
    
    /**
     * 处理客户池设置的数据
     */
    public function customer_set_update() {
    	$this->admin_priv('customer_set');
    	$customer_pool_isopen =  $_POST['customer_pool_isopen'];
    	$customer_pool_range = $_POST['customer_pool_range'];
    	$customer_pool_range_new = implode(',', $customer_pool_range);
    	
    	$customer_pool_period = $_POST['customer_pool_period'];

    	$customer_pool_gain_max = $_POST['customer_pool_gain_max'];
    	$customer_pool_gain_max_day = $_POST['customer_pool_gain_max_day'];
    	
    	//客户池设置
    	ecjia_config::instance()->write_config('customer_pool_isopen',       $customer_pool_isopen);
    	ecjia_config::instance()->write_config('customer_pool_range',        $customer_pool_range_new);
    	ecjia_config::instance()->write_config('customer_pool_period',       $customer_pool_period);
    	ecjia_config::instance()->write_config('customer_pool_gain_max',     $customer_pool_gain_max);
    	ecjia_config::instance()->write_config('customer_pool_gain_max_day', $customer_pool_gain_max_day);
    	
    	//客户验证设置
    	$exists_fields_ids = $_POST['exists_fields_name'];
    	if ( !empty($exists_fields_ids)) {
    	    $exists_fields_update = $this->db_customer_exists_fields->where(array('exists_fields_id' => $exists_fields_ids))->update(array('is_open' => '1'));
    	    $exists_fields_ids_new = implode(',', $exists_fields_ids);
    	    $exists_fields_ids_other = $this->db_customer_exists_fields->where('exists_fields_id not in ('.$exists_fields_ids_new.') ')->update(array('is_open' => '0'));
    	} else {
    	    $exists_fields_ids_other = $this->db_customer_exists_fields->where(array('exists_fields_id' => array('gt' => '0')))->update(array('is_open' => '0'));
    	}
		
    	/* 清除缓存 */
    	ecjia_config::instance()->clear_cache();
//     	ecjia_cloud::instance()->api('ecjia/record')->data(get_site_info())->run();
    	
    	//log
    	ecjia_admin_log::instance()->add_object('customer_set', '客户池设置');
   		ecjia_admin::admin_log('修改客户池设置','edit','customer_set');
   		$this->showmessage('客户池设置成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('customer/admin_set/init')));
    }
    
    /**
     * 日志
     * @param string $action
     * @param string $customer_name
     * @param integer/array $customer_id
     * @param string $user_name
     * @return NULL
     */
    private function add_admin_log ($action, $customer_name = '', $customer_id = '', $user_name = '', $user_id='', $log_extend = '') {
        ecjia_admin_log::instance()->add_object('customer', '客户');
        ecjia_admin_log::instance()->add_action('import', '导入');
        ecjia_admin_log::instance()->add_action('quit', '放弃');
        ecjia_admin_log::instance()->add_action('share', '共享');
        ecjia_admin_log::instance()->add_action('batch_update', '批量修改客户来源，');
        ecjia_admin_log::instance()->add_action('batch_update_type', '批量修改客户类别，');
        ecjia_admin_log::instance()->add_action('batch_assign', '批量指派客户，');
        ecjia_admin_log::instance()->add_action('batch_share', '批量共享客户，');
        ecjia_admin_log::instance()->add_action('batch_quit', '批量放弃客户，');
        ecjia_admin_log::instance()->add_action('batch_remove', '批量删除客户，');
        //需要用户名的集合
        $need_username_arr = array('add', 'edit');
        if (in_array($action, $need_username_arr)) {
            if ($user_name == '') {
                if (!empty($user_id)) {
                    $user = $this->db_users->field('user_name')->find('user_id='.$user_id);
                    $user_name = $user['user_name'];
                }
            }
            if ($user_name != '' || $user_name != '') {
                $log_extend = '，绑定会员是'.$user_name;
            }
    	}
    	//批量操作集合
    	if (in_array($action, array('batch_trash', 'batch_restore', 'batch_edit', 'batch_update', 'batch_update_type', 'batch_assign', 'batch_quit', 'batch_share', 'batch_remove'))) {
    	    if (!empty($customer_name)) {
    	        ecjia_admin::admin_log($customer_name.$log_extend, $action, 'customer');
    	    } else {
    	        $rs = $this->db_customer->in(array('customer_id' => $customer_id))->select();
    	        $customer = array();
    	        foreach ($rs as $v) {
    	            $customer[$v['customer_id']] = $v['customer_name'];
    	        }
    	        foreach ($rs as $v) {
    	            ecjia_admin::admin_log($customer[$v['customer_id']] . $log_extend, $action, 'customer');
    	        }
    	    }
    	} else {
    	    if ($customer_name == '') {
    	        $name = $this->db_customer->where(array('customer_id' => $customer_id))->find();
    	        $customer_name = $name['customer_name'];
    	    }
    	    ecjia_admin::admin_log($customer_name.$log_extend, $action, 'customer');
    	}
    }
    

//end
}
