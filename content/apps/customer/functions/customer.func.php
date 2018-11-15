<?php

/**
 * 获取客户来源列表，用于添加
 * @return array
 */
function get_source_list(){
	$db_customer_source = RC_Loader::load_app_model('customer_source_model', 'customer');
	$list = array();
	$list = $db_customer_source->field('source_id,source_name,add_time, is_lock')->order(array('is_lock' => 'DESC'))->select();
	return $list;
}

/**
 * 获取客户类别列表，用于添加
 * @return array
 */
function get_customer_type_list(){
	$db_customer_state = RC_Loader::load_app_model('customer_state_model', 'customer');
	$list = array();
	$list = $db_customer_state->field('state_id,state_name,add_time, is_lock')->order(array('is_lock' => 'DESC'))->select();
	return $list;
}

/**
 * 获取客户类别列表，用于添加
 * @return array
 */
function get_customer_exists_fields(){
	$db_customer_exists_fields = RC_Loader::load_app_model('customer_exists_fields_viewmodel', 'customer');
	$list = array();
	$list = $db_customer_exists_fields->field('exists_fields_id,exists_fields_name,is_open,field_name')->select();
	return $list;
}

/**
 * 生成客户唯一编号
 */
function get_customer_sn() {
	$str  = RC_Time::local_date('Ymd') . str_pad(1, 5, '0', STR_PAD_LEFT);
	$db_customer = RC_Loader::load_app_model('customer_model', 'customer');
	$result = $db_customer->field('customer_sn')->where(array('customer_sn' => array('egt' => $str)))->order(array('customer_sn' => 'desc'))->select();
	
	if(!empty($result)) {
		$result_new = array();
		foreach($result as $val) {
			$result_new[] = $val['customer_sn'];
		}
		$str_max = $result_new[0];
		$str2 = $str_max + 1;
	} else {
		$str2 = $str;
	}

	return $str2;
    }

/**
 * 获取管理员列表
 * @return array
 */
function get_admin_user_list(){
	$list = array();
	$db_admin_user = RC_Loader::load_app_model('customer_admin_user_model', 'customer');
	$list = $db_admin_user->field('user_id,user_name,email,add_time,last_login')->order(array('user_id' => 'DESC'))->select();
	foreach ($list AS $key=>$val) {
		$list[$key]['add_time']     = RC_Time::local_date('Y-m-d H:i', $val['add_time']);
		$list[$key]['last_login']   = RC_Time::local_date('Y-m-d H:i', $val['last_login']);
	}
	return $list;
}

/**
 * 客户-联系记录列表
 */
 function get_contact_list($user_id, $customer_id) {
 	$db_customer_feedback_view = RC_Loader::load_app_model('customer_feedback_viewmodel', 'customer');
	$count = $db_customer_feedback_view->join(array('customer'))->where(array('cf.customer_id' => $customer_id))->order(array('cf.add_time' => 'desc'))->count('cf.customer_id');
	RC_Loader::load_sys_class('ecjia_page', false);
	$page = new ecjia_page($count, 10, 5);
	$contact = $db_customer_feedback_view->join(array('customer', 'admin_user', 'customer_contact_type', 'customer_contact_way', 'customer_linkman'))->field('cf.*,au.user_name as admin_name,ct.type_name,cw.way_name,cl.link_man_name,cl.mobile')
	->where(array('cf.customer_id' => $customer_id))->order(array('cf.add_time' => 'desc'))->limit($page->limit())->select();
	if ($contact) {
	    foreach ($contact as $key => $v) {
	        $contact[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i', $contact[$key]['add_time']);
	        $contact[$key]['next_time'] = RC_Time::local_date('Y-m-d H:i', $contact[$key]['next_time']);
	    }
	}
	
	$arr = array('list' => $contact,  'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page);
	return $arr;
}

/**
 * 获取当前客户最近4条联系记录
 */
function get_contact_record_list($customer_id) {
	$db_customer_feedback_view = RC_Loader::load_app_model('customer_feedback_viewmodel', 'customer');
	$contact = $db_customer_feedback_view->join(array('customer_linkman'))->field('cf.*,cl.link_man_name, cl.sex')
	->where(array('cf.customer_id' => $customer_id))->order(array('cf.add_time' => 'desc'))->limit(4)->select();
	$sex = array('0' => '男', '1' => '女');
	if ($contact) {
	    foreach ($contact as $key => $v) {
	        $contact[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i', $contact[$key]['add_time']);
	        if ($v['sex']) {
	            $contact[$key]['sex_new'] = $sex[$v['sex']];
	        }
	    } 
	}
	
	return $contact;
}


/**
 * 获取联系方式列表
 */
function get_contact_way_list() {
	$db_customer_contact_way = RC_Loader::load_app_model('customer_contact_way_model', 'customer');
	$result = $db_customer_contact_way->select();
	return $result;
}

/**
 * 获取联系类型列表
 */
function get_contact_type_list() {
	$db_customer_contact_type = RC_Loader::load_app_model('customer_contact_type_model', 'customer');
	$result = $db_customer_contact_type->select();
	return $result;
}

/**
 * 获取当前客户的联系人列表
 */
function get_linkman_list($customer_id) {
	$db_customer_linkman_view = RC_Loader::load_app_model('customer_linkman_viewmodel', 'customer');
	$result = $db_customer_linkman_view->where(array('cl.customer_id' => $customer_id))->field('cl.*')->order(array('cl.add_time' => 'desc'))->select();
	return $result;
}

/**
 * 获取当前客户的联系人列表,详情页
 */
function get_link_man_list($customer_id) {
	$db_linkman = RC_Loader::load_app_model('customer_linkman_model', 'customer');
	$count = $db_linkman->where(array('customer_id' => $customer_id))->order(array('add_time' => 'desc'))->count('link_id');
	RC_Loader::load_sys_class('ecjia_page', false);
	$page = new ecjia_page($count, 10, 5);
	$result = $db_linkman->where(array('customer_id' => $customer_id))->order(array('add_time' => 'desc'))->limit($page->limit())->select();
	
	$arr = array('list' => $result,  'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page);
	return $arr;
}

/**
 * 客户-服务信息
 */
 function get_service_list($user_id, $customer_id) {
 	if(!empty($user_id)){
 		$db_view = RC_Loader::load_app_model('customer_viewmodel', 'customer');
 		$count = $db_view->join(array('service'))->where(array('s.user_id' => $user_id, 'c.customer_id' => $customer_id))->order(array('s.add_time' => 'desc'))->count('s.service_id');
 		RC_Loader::load_sys_class('ecjia_page', false);
 		$page = new ecjia_page($count, 10, 5);
 		$service = $db_view->join(array('service'))->field('s.*')
 		->where(array('s.user_id' => $user_id, 'c.customer_id' => $customer_id))->order(array('s.add_time' => 'desc'))->limit($page->limit())->select();
 		if ($service) {
 		    foreach ($service as $key => $v) {
 		        $service[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i', $service[$key]['add_time']);
 		        if ($v['status'] == '0') {
 		            if ($v['end_date'] < RC_Time::local_date('Y-m-d')) {
 		                $service[$key]['status_name'] = '已过期';
 		            } else {
 		                $service[$key]['status_name'] = '正常';
 		            }
 		        } elseif ($v['status'] == '1') {
 		            $service[$key]['status_name'] = '停止';
 		        } elseif ($v['status'] == '-1') {
 		            $service[$key]['status_name'] = '回收站';
 		        }
 		    }
 		}
 		
 		$arr = array('list' => $service,  'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page);
 		return $arr;
 	}
 }

 /**
  * 客户-工单
  */
 function get_tickets_list($user_id, $customer_id) {
 	if(!empty($user_id)) {
 		$db_view = RC_Loader::load_app_model('customer_viewmodel', 'customer');
 		$count = $db_view->join(array('ticket'))->where(array('t.user_id' => $user_id, 'c.customer_id' => $customer_id))->order(array('t.add_time' => 'desc'))->count('t.ticket_id');
 		RC_Loader::load_sys_class('ecjia_page', false);
 		$page = new ecjia_page($count, 10, 5);
 		$ticket = $db_view->join(array('ticket'))->field('t.*')
 		->where(array('t.user_id' => $user_id, 'c.customer_id' => $customer_id))->order(array('t.add_time' => 'desc'))->limit($page->limit())->select();
 		if ($ticket) {
 		    foreach ($ticket as $key => $v) {
 		     			$ticket[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i', $ticket[$key]['add_time']);
 		    }
 		}
 		
 		$arr = array('list' => $ticket,  'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page);
 		return $arr;
 	}
 }
 
 /**
  * 客户-投诉
  */
function get_complain_list($user_id, $customer_id) {
	if(!empty($user_id)) {
		$db_view = RC_Loader::load_app_model('customer_viewmodel', 'customer');
		$count = $db_view->join(array('ticket', 'ticket_complain'))->where(array('tc.user_id' => $user_id, 'c.customer_id' => $customer_id))->order(array('tc.add_time' => 'desc'))->count('tc.ticket_id');
		RC_Loader::load_sys_class('ecjia_page', false);
		$page = new ecjia_page($count, 10, 5);
		$ticket_complain = $db_view->join(array('ticket', 'ticket_complain'))->field('tc.*, t.ticket_sn')
		->where(array('tc.user_id' => $user_id, 'c.customer_id' => $customer_id))->order(array('tc.add_time' => 'desc'))->limit($page->limit())->select();
		if ($ticket_complain) {
		    foreach ($ticket_complain as $key => $v) {
		        $ticket_complain[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i', $ticket_complain[$key]['add_time']);
		    }
		}
		
		$arr = array('list' => $ticket_complain,  'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page);
		return $arr;
	}
 }
 
 /**
  * 客户-合同文档
  */
 function get_files_list($a, $customer_id) {
 	$db_view = RC_Loader::load_app_model('customer_viewmodel', 'customer');
 	$count = $db_view->join(array('customer_contract_doc'))->where(array('cd.customer_id' => $customer_id))->order(array('cd.add_time' => 'desc'))->count('cd.doc_id');
 	RC_Loader::load_sys_class('ecjia_page', false);
 	$page = new ecjia_page($count, 10, 5);
 	$contract_doc = $db_view->join(array('admin_user', 'customer_contract_doc'))->field('cd.*,au.user_name as admin_name')
 	->where(array('cd.customer_id' => $customer_id))->order(array('cd.add_time' => 'desc'))->limit($page->limit())->select();
 	$contract = array();
 	if ($contract_doc) {
 	    foreach ($contract_doc as $key => $v) {
 	        $contract_doc[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i', $contract_doc[$key]['add_time']);
 	        $contract 						= explode('/', $contract_doc[$key]['doc_path']);
 	        $contract_doc[$key]['file_name']= $contract[count($contract)-1];
 	        $contract_doc[$key]['image_url'] = RC_Upload::upload_url($contract_doc[$key]['doc_path']);
 	    }
 	}
 	
 	$arr = array('list' => $contract_doc,  'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page);
 	return $arr;
 }
 

/**
 * excel转为数组
 * @param string $filepath
 * @return array
 */
function excel_to_array($filepath) {
    //引入文件
    RC_Loader::load_app_class('PHPExcel', 'customer');
    require_once RC_APP_PATH.'customer/classes/PHPExcel/IOFactory.php';
    require_once RC_APP_PATH.'customer/classes/PHPExcel/Reader/Excel5.php';
    
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($filepath);
    
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
    $data_excel = array();
    for ($row = 1; $row <= $highestRow; $row++) {
        $strs = array();
        //注意highestColumnIndex的列数索引从0开始
        for ($col = 0; $col < $highestColumnIndex; $col++) {
            $cell = $objWorksheet->getCellByColumnAndRow($col, $row);
            $strs[$col] = $cell->getValue();
        }
        $data_excel[] = $strs;
    }
    return $data_excel;
}
/**
 * 导入数组修改键
 * @param array $customer
 * @return array
 */
function change_key($customer) {
    $new_arr = array();
    unset($customer['0']);
    $customer_sn = get_customer_sn();
    foreach ($customer as $key => $val) {
        foreach ($val as $key2 => $info) {
            switch ($key2) {
                case 0 : $new_key = 'customer_name'; break;
                case 1 : $new_key = 'link_man'; break;
                case 2 : $new_key = 'sex'; break;
                case 3 : $new_key = 'mobile'; break;
                case 4 : $new_key = 'telphone1'; break;
                case 5 : $new_key = 'email'; break;
                case 6 : $new_key = 'qq'; break;
                case 7 : $new_key = 'province'; break;
                case 8 : $new_key = 'city'; break;
                case 9 : $new_key = 'district'; break;
                case 10 : $new_key = 'address'; break;
                case 11 : $new_key = 'source_id'; break;
                case 12 : $new_key = 'state_id'; break;
                case 13 : $new_key = 'contract_start'; break;
                case 14 : $new_key = 'contract_end'; break;
                case 15 : $new_key = 'summary'; break;
                default : break ;
            }
            if ($new_key == 'sex') {
                $info = $info == '女' ? 1 : 0 ;
            } elseif ($new_key == 'province') {
            
            } elseif ($new_key == 'city') {
                
            } elseif ($new_key == 'district') {
                
            } elseif ($new_key == 'source_id') {
                
            } elseif ($new_key == 'state_id') {
                
            } elseif ($new_key == 'contract_start' || $new_key == 'contract_end') {
                //处理excel时间
                $info = RC_Time::local_date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($info));
            }
            $new_arr[$key][$new_key] = $info;
        }
        $new_arr[$key]['customer_sn'] = $customer_sn + $key;
        $new_arr[$key]['level'] = 1;
        $new_arr[$key]['add_time'] = RC_Time::local_gettime();
        $new_arr[$key]['adder'] = $_SESSION['admin_id'];
        $new_arr[$key]['charge_man'] = $_SESSION['admin_id'];
    }
    return $new_arr;
}

/* 获取分享列表 */
function get_share_list($myshare = false) {
    $db_view = RC_Loader::load_app_model('customer_viewmodel', 'customer');
    $filter['keywords'] = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
    //      $filter['customer_fields'] = isset($_GET['customer_fields']) ? trim($_GET['customer_fields']) : '';
    $filter['type_customer'] = isset($_GET['type_customer']) ? intval($_GET['type_customer']) : '';
    $filter['source_customer'] = isset($_GET['source_customer']) ? intval($_GET['source_customer']) : '';
    $filter['status']   = isset($_GET['status']) ? $_GET['status'] :'1';
    $where = array();
    $where['c.is_delete'] = '0';
    
    if (!empty($filter['keywords'])) {
        $where[] = '((`customer_name` like "%' . $filter['keywords'] . '%")  or (`link_man` like "%' . $filter['keywords'] . '%")  or (`mobile` like "%' . $filter['keywords'] . '%")
					  or (`telphone1` like "%' . $filter['keywords'] . '%")  or (`telphone2` like "%' . $filter['keywords'] . '%"))';
    }
    /*类型和来源*/
    if(!empty($filter['type_customer'])) {
        $where['c.state_id'] = $filter['type_customer'];
    }
    /*时间排序参数*/
    $filter['sort_by']      = !empty($_GET['sort_by']) ? safe_replace($_GET['sort_by']) : 'last_contact_time';
    $filter['sort_order']   = !empty($_GET['sort_order']) ? safe_replace($_GET['sort_order']) : 'DESC';
    
    
    RC_Loader::load_sys_class('ecjia_page', false);
    
//     $where[] = " (charge_man != 0 and charge_man !='' and charge_man is NOT NULL)";
    //count
    $where['admin_id'] = $_SESSION['admin_id'];
    $filter['count_share_customers'] = $db_view->join(array('users', 'admin_user', 'customer_state', 'customer_share', 'customer_source'))->where($where)->count('c.customer_id');
    unset($where['admin_id']);
    $where['sharer'] = $_SESSION['admin_id'];
    $filter['count_my_share'] = $db_view->join(array('users', 'admin_user', 'customer_state', 'customer_share', 'customer_source'))->where($where)->count('c.customer_id');
    unset($where['sharer']);
    if ($myshare) {
        $where['sharer'] = $_SESSION['admin_id'];
        $page_count = $filter['count_my_share'];
    } else {
        $where['admin_id'] = $_SESSION['admin_id'];
        $page_count = $filter['count_share_customers'];
    }
    
    $page = new ecjia_page($page_count, 10, 5);
    $row = $db_view->join(array('users', 'admin_user', 'customer_state', 'customer_share', 'customer_source'))->field('c.*, cshare.share_id, cshare.admin_id, cshare.sharer, cshare.share_time, cs.state_name, co.source_name, u.adviser_id, u.user_name as member_name, au.user_name as add_user_name')->order(array($filter['sort_by'] => $filter['sort_order'], 'add_time' => 'desc'))->limit($page->limit())->where($where)->select();
    
    $admin_user = get_admin_user_name();
    if ($row) {
        foreach ($row as $key => $val) {
            $row[$key]['add_time']      	= RC_Time::local_date('Y-m-d H:i', $row[$key]['add_time']);
            $row[$key]['last_contact_time'] = RC_Time::local_date('Y-m-d H:i', $row[$key]['last_contact_time']);
            $row[$key]['reservation_time']  = RC_Time::local_date('Y-m-d H:i', $row[$key]['reservation_time']);
            $row[$key]['employee']          = $admin_user[$val['admin_id']];//共享给
            $row[$key]['sharer']            = $admin_user[$val['sharer']];
            $row[$key]['share_time']        = RC_Time::local_date('Y-m-d H:i', $row[$key]['share_time']);;
        }
    }
    
    $arr = array('list' => $row, 'filter' => $filter, 'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page); //'filter' => $filter,筛选
    return $arr;
    
}
function get_admin_user_name() {
    $db_admin_user = RC_Loader::load_app_model('customer_admin_user_model', 'customer');
    $row_admin_user = $db_admin_user->field('user_id, user_name')->select();
    $admin_user =array();
    if ($row_admin_user) {
        foreach ($row_admin_user as $val) {
            $admin_user[$val['user_id']] = $val['user_name'];
        }
    }
    
    return $admin_user;
}

/**
 * 获取绑定管理员对应的员工id
 *
 */
function get_employee_id(){
	$admin_id = $_SESSION['admin_id'];
	$db_db_employees = RC_Loader::load_app_model('employees_model', 'customer');
	$employee_id = $db_db_employees->where(array('admin_id' => $admin_id))->get_field('employee_id');
	return $employee_id;
}

function get_url_params($get, $not_include = array()) {
    $url_arr = null;
    if ($get) {
        foreach ($get as $key => $val) {
            if (in_array($key, array('_', '_pjax'))) {
                continue;
            }
            if (in_array($key, $not_include)) {
                continue;
            }
            if (isset($val) && $val != '') {
                $url_arr[$key] = $val;
            }
        }  
    }
    
    return $url_arr;
}

//end