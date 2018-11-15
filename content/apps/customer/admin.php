<?php

/**
 * 客户模块
 * 作者:
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin extends ecjia_admin {

    private $db_customer;
    private $db_customer_admin_user_view;
    private $db_admin_user_customer_view;
    private $db_customer_contract;
    private $db_customer_share;
    private $db_customer_pool;
    private $db_customer_pool_view;
    private $db_customer_linkman;
    private $db_customer_linkman_view;
    private $db_customer_feedback;
    private $db_customer_feedback_view;
    private $db_view;
    private $db_customer_state_type_view;
    private $db_provinceview;
    private $db_cityview;
    private $db_districtview;
    private $db_region;
    private $db_users;
    private $db_adviser;
    private $db_usersview;
    private $db_employees;
    private $db_admin_user;
    private $db_customer_exists_fields;
    private $db_customer_distribute;
    private $detail_show_records = 20;

    public function __construct() {
        parent::__construct();
        /* 加载所需数据模型 */
        $this->db_customer_feedback = RC_Loader::load_app_model('customer_feedback_model', 'customer');
        $this->db_customer_admin_user_view = RC_Loader::load_app_model('admin_user_customer_viewmodel', 'customer');
        $this->db_admin_user_customer_view = RC_Loader::load_app_model('customer_admin_user_viewmodel', 'customer');
        $this->db_customer_contract = RC_Loader::load_app_model('customer_contract_doc_model', 'customer');
        $this->db_customer_feedback_view = RC_Loader::load_app_model('customer_feedback_viewmodel', 'customer');
        $this->db_customer = RC_Loader::load_app_model('customer_model', 'customer');
        $this->db_customer_share = RC_Loader::load_app_model('customer_share_model', 'customer');
        $this->db_customer_pool = RC_Loader::load_app_model('customer_pool_model', 'customer');
        $this->db_customer_pool_view = RC_Loader::load_app_model('customer_pool_viewmodel', 'customer');
        $this->db_customer_linkman = RC_Loader::load_app_model('customer_linkman_model', 'customer');
        $this->db_customer_linkman_view = RC_Loader::load_app_model('customer_linkman_viewmodel', 'customer');
        $this->db_view 	   = RC_Loader::load_app_model('customer_viewmodel', 'customer');
        $this->db_customer_state_type_view = RC_Loader::load_app_model('customer_state_type_viewmodel', 'customer');
        $this->db_users    = RC_Loader::load_app_model('customer_users_model', 'customer');
        $this->db_adviser  = RC_Loader::load_app_model('adviser_model', 'customer');
        $this->db_usersview= RC_Loader::load_app_model('users_viewmodel', 'customer');
        $this->db_admin_user = RC_Loader::load_app_model('customer_admin_user_model', 'customer');
        $this->db_customer_distribute = RC_Loader::load_app_model('customer_distribute_model', 'customer');
		
        $this->db_provinceview = RC_Loader::load_app_model('customer_province_viewmodel', 'customer');
        $this->db_cityview = RC_Loader::load_app_model('customer_city_viewmodel', 'customer');
        $this->db_districtview = RC_Loader::load_app_model('customer_district_viewmodel', 'customer');
        $this->db_customer_exists_fields = RC_Loader::load_app_model('customer_exists_fields_model', 'customer');
        $this->db_employees    		   	  = RC_Loader::load_app_model('employees_model', 'customer');
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
        RC_Script::enqueue_script('search', RC_App::apps_url('statics/js/search.js', __FILE__));
        RC_Script::enqueue_script('linkman', RC_App::apps_url('statics/js/linkman.js', __FILE__));
        RC_Script::enqueue_script('contact_record', RC_App::apps_url('statics/js/contact_record.js', __FILE__));
        RC_Script::enqueue_script('contact_record_list', RC_App::apps_url('statics/js/contact_record_list.js', __FILE__));
        RC_Script::enqueue_script('contract_doc', RC_App::apps_url('statics/js/contract_doc.js', __FILE__));
        RC_Script::enqueue_script('customer', RC_App::apps_url('statics/js/customer.js', __FILE__));
        RC_Script::enqueue_script('bind_adviser', RC_App::apps_url('statics/js/bind_adviser.js', __FILE__));
        RC_Script::enqueue_script('ecjia-region', RC_Uri::admin_url('statics/ecjia.js/ecjia.region.js'));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户列表'), RC_Uri::url('customer/admin/init', array( 'status' => 1 ))));
        
        // 加载func
        RC_Loader::load_app_func('area_select', 'customer'); // 加载地区联动
        RC_Loader::load_app_func('customer', 'customer'); // 加载customer.func
        // 时间控件
        RC_Style::enqueue_style('datepicker', RC_App::app_dir_url(__FILE__) . 'statics/datepicker/bootstrap-datetimepicker.min.css');
        RC_Script::enqueue_script('bootstrap-timepicker', RC_App::app_dir_url(__FILE__) . 'statics/datepicker/bootstrap-datetimepicker.min.js');
        RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, true);
        RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
        // 时间控件,只有日期的
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.min.css'));
        RC_Script::enqueue_script('bootstrap-datepicker.min', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        
        $this->db_region = RC_Loader::load_app_model('region_model', 'customer');
        $this->db_provinceview = RC_Loader::load_app_model('customer_province_viewmodel', 'customer');
        $this->db_cityview = RC_Loader::load_app_model('customer_city_viewmodel', 'customer');
        $this->db_districtview = RC_Loader::load_app_model('customer_district_viewmodel', 'customer');
        
        /* 更新客户池 */
        $this->update_pool();
    }

    /**
     * 获取客户列表页面
     */
    public function init() {
        $menu = empty($_GET['menu']) ? null : trim($_GET['menu']);
        if ($menu == 'all') {
            //全部客户管理  
            /* 客户管理权限 */
            $this->admin_priv('customer_manage_all');
            $nav_name = '全部客户管理';
            $this->assign('priv_manage_all', $this->admin_priv('customer_manage_all', '', false));
        } else {
            //我的客户
            /* 客户管理权限 */
            $this->admin_priv('customer_manage');
            $nav_name = '客户列表';
        }
        
      	ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__($nav_name)));
        $this->assign('ur_here', __($nav_name));
        
        //加载配置中视图数据
        $view_list = RC_Loader::load_app_config('customer_view', 'customer');
        $this->assign('view_list',$view_list);
        
        $customer_list = $this->get_list();
        $keywords = $customer_list['filter']['keywords'];
        $status = $customer_list['filter']['status'];
        $view	= $customer_list['filter']['view'];
        $menu = $customer_list['filter']['menu'];
        $customer_type = $customer_list['filter']['type_customer'];
        $customer_source = $customer_list['filter']['source_customer'];
        $page = $customer_list['current_page'];
        
        $this->assign('keywords', $keywords); //关键字搜索
        $this->assign('status', $status);
        $this->assign('view', $view);
        $this->assign('menu', $menu);
        $this->assign('customer_type', $customer_type);
        $this->assign('customer_source', $customer_source);
        $this->assign('page', $page); //搜索后的页码
        $this->assign('customer_list', $customer_list);
        $this->assign('search_action', RC_Uri::url('customer/admin/init'));
        $this->assign('search_source_action', RC_Uri::url('customer/admin/init'));
        //获取来源和类别列表
        $this->assign('source_list', get_source_list());
        $this->assign('customer_type_list', get_customer_type_list());
        $this->assign('admin_list', get_admin_user_list());
//         $this->assign('department_list', get_department_list());
        /*导出*/
//         $this->assign('export_action', RC_Uri::url('customer/admin/customer_export', array('page' => $customer_list['current_page'])));
        //批量操作
        $this->assign('form_action', RC_Uri::url('customer/admin/batch', array('page' => $customer_list['current_page'], 'keywords' => $keywords, 'status'=> $status, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu)));
        $this->assign('binding_priv', $this->admin_priv('binding_adviser', '', false));//绑定权限
        
        $this->assign('customer_share', $this->admin_priv('customer_share', '', false)); // 共享客户权限
        $this->assign('customer_source_update_batch', $this->admin_priv('customer_source_update_batch', '', false)); // 批量修改来源权限
        $this->assign('customer_assign_batch', $this->admin_priv('customer_assign_batch', '', false)); // 批量指派权限
        $this->assign('customer_type_update_batch', $this->admin_priv('customer_type_update_batch', '', false)); // 批量修改类型权限
        $this->assign('customer_share_batch', $this->admin_priv('customer_share_batch', '', false)); // 批量共享权限
        $this->assign('customer_del_batch', $this->admin_priv('customer_del_batch', '', false)); // 批量删除权限
        $this->assign('customer_quit_batch', $this->admin_priv('customer_quit_batch', '', false)); // 批量放弃权限
        $this->assign('customer_quit', $this->admin_priv('customer_quit', '', false)); // 单个放弃权限
        $this->assign('customer_reback', $this->admin_priv('customer_reback', '', false));//还原客户权限
        
        $this->display('customer_list.dwt');
    }
    
    
    /**
     * 导出excel
     * 一期导出全部
     * 二期增加条件
     */
    public function customer_export() {
    	$this->admin_priv('customer_excel_export');
    
    	@set_time_limit(0);
    	$now_time = RC_Time::local_date("YmdHis", RC_Time::gmtime());
    	$filename = 'customer' . $now_time;
    	header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    	header("Content-Disposition: attachment;filename=$filename.xls");
    	//引入文件
    	RC_Loader::load_app_class('PHPExcel', 'customer', false);
    	
    	//搜索条件，导出搜索后信息
    	$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
    	$type_customer = isset($_GET['type_customer']) ? intval($_GET['type_customer']) : '';
    	$source_customer = isset($_GET['source_customer']) ? intval($_GET['source_customer']) : '';
    	$view	 = isset($_GET['view']) ? intval($_GET['view']) : '';
    	
    	$where = array();
    	$where['c.is_delete'] = '0';
    	
    	if (!empty($keywords)) {
    		$where[] = '((`customer_name` like "%' . $keywords. '%")  or (`link_man` like "%' . $keywords . '%")  or (c.mobile like "%' . $keywords . '%")
					  or (`telphone1` like "%' . $keywords . '%")  or (`telphone2` like "%' . $keywords . '%"))';
    	}
    	/*类型和来源*/
    	if(!empty($type_customer)) {
    		$where['c.state_id'] = $type_customer;
    	}
    	if(!empty($source_customer)) {
    		$where['c.source_id'] = $source_customer;
    	}
    	/*视图*/
    	if(!empty($view)) {
    		if($view == '1') {
    			$start_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d',RC_time::gmtime()));
    			$end_date 	= $start_date + (24*60*60-1);
    			$where['c.add_time'] = array('egt' => $start_date, 'elt' => $end_date);
    		} elseif($view == '2') {
    			$end_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d',RC_time::gmtime())) -1 ;
    			$start_date = $end_date - (24*60*60-1);
    			$where['c.add_time'] = array('egt' => $start_date, 'elt' => $end_date);
    		} elseif ($view == '3'){
    			$end_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d',RC_time::gmtime())) + (24*60*60-1);
    			$start_date = $end_date - (7*24*60*60) + 1;
    			$where['c.add_time'] = array('egt' => $start_date, 'elt' => $end_date);
    		} elseif($view == '4'){
    			$end_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d',RC_time::gmtime())) + (24*60*60-1);
    			$start_date = $end_date - (7*24*60*60) + 1;
    			$where['c.last_contact_time'] = array('egt' => $start_date, 'elt' => $end_date);
    		} elseif($view == '5'){
    			$end_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d',RC_time::gmtime())) + (24*60*60-1);
    			$start_date = $end_date - (15*24*60*60) + 1;
    			$where['c.last_contact_time'] = array('egt' => $start_date, 'elt' => $end_date);
    		}
    	}
    	
    	$objPHPExcel = new PHPExcel();
    	/*设置第一个工作表为客户信息表*/
    	$objPHPExcel->setActiveSheetIndex(0); 
    	/*设置工作表名称*/
    	$objPHPExcel->getActiveSheet()->setTitle('客户信息表'); 
    	
    	$arrHeader = array(array('客户名称', '联系人', '性别', '手机', '联系电话', '办公电话', '传真', '电子邮件', '省份', '城市', '县区', '详细地址', 
    					'客户来源', '客户类别', '合同开始日期', '合同结束日期', '备注信息', 'QQ', '微信','建档时间', '所属行业', '生日', '生日类型', '建档人', '客户负责人'));
    	
    	//设置单元格宽度
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(19);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(19);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(19);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(35);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
		 
    	$data_cusinfo = $this->db_view->join(array('admin_user', 'customer_state', 'customer_source', 'customer_linkman'))
        ->where($where)->field('c.customer_name,c.link_man,c.sex,c.mobile,c.telphone1,c.telphone2,c.fax,c.email,c.province,c.city,
        		c.district,c.address,co.source_name,cs.state_name,c.contract_start,c.contract_end,c.summary,c.qq,c.wechat,c.add_time,c.industry,
        		c.birthday,c.birth_type,c.adder,c.charge_man')->select(); //二维数组
    	 
    	$province_rows = $this->db_provinceview->get_field('province,region_name');
        $city_rows = $this->db_cityview->get_field('city,region_name');
        $district_rows = $this->db_districtview->get_field('district,region_name');
        $chargeman_rows = $this->db_customer_admin_user_view->get_field('charge_man,user_name');
        $adder_rows = $this->db_admin_user_customer_view->get_field('adder,user_name');
    	 
    	 
    	$sex = array(
            '0' => '男',
            '1' => '女'
        );
        $birth_type = array(
            '0' => '公历',
            '1' => '农历'
        );
        

        foreach ($data_cusinfo as $key => $val) {
            $data_cusinfo[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
            $data_cusinfo[$key]['province'] = $province_rows[$val['province']]['region_name'];
            $data_cusinfo[$key]['city'] = $city_rows[$val['city']]['region_name'];
            $data_cusinfo[$key]['district'] = $district_rows[$val['district']]['region_name'];
            $data_cusinfo[$key]['charge_man'] = $chargeman_rows[$val['charge_man']]['user_name'];
            $data_cusinfo[$key]['adder'] = $adder_rows[$val['adder']]['user_name'];
            $data_cusinfo[$key]['sex'] = $sex[$val['sex']];
            $data_cusinfo[$key]['birth_type'] = $birth_type[$val['birth_type']];
        }
        /*设置手机，联系电话，办公电话为文本格式*/
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode("@");
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode("@");
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode("@");
    	$arrExcelInfo = array_merge($arrHeader, $data_cusinfo);
    	
    	/*$arrExcelInfo是赋值的数组；NULL 忽略的值,不会在excel中显示，A1 赋值的起始位置*/
    	$objPHPExcel->getActiveSheet()->fromArray($arrExcelInfo, NULL, 'A1' );
    	
    	//创建第二个工作表
    	$msgWorkSheet = new PHPExcel_Worksheet($objPHPExcel, '联系人信息表'); //创建一个工作表
    	$objPHPExcel->addSheet($msgWorkSheet); //插入工作表
    	$objPHPExcel->setActiveSheetIndex(1); //切换到新创建的工作表
    	$arrHeader2 = array(array('客户名称', '联系人', '性别', '联系电话', '手机', '生日', '生日类型', '部门', '职务', '邮件', 'QQ', '微信','备注信息'));
    	
    	//设置单元格宽度
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(19);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(19);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
    	
    	$linkInfo = $this->db_customer_linkman_view->join(array('customer'))->where($where)
            ->field('c.customer_name, cl.link_man_name, cl.sex, cl.telphone, cl.mobile, cl.birthday,
    	cl.birth_type, cl.department, cl.duty, cl.email, cl.qq, cl.wechat, cl.summary')
            ->select();
    	foreach ($linkInfo as $key => $val) {
    		$linkInfo[$key]['sex']				= $sex[$val['sex']];
    		$linkInfo[$key]['birth_type']		= $birth_type[$val['birth_type']];
    	}
    	/*联系电话，手机设置为文本格式*/
    	$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode("@");
    	$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode("@");
    	
    	$arrExcelInfo2 = array_merge($arrHeader2, $linkInfo);
    	
    	/*$arrExcelInfo是赋值的数组；NULL 忽略的值,不会在excel中显示，A1 赋值的起始位置*/
    	$objPHPExcel->getActiveSheet()->fromArray($arrExcelInfo2, NULL, 'A1');
    	
    	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
    	$objWriter->save('php://output');
    	
    	$objPHPExcel->disconnectWorksheets();
    	unset($objPHPExcel);
    }
    
    
    /**
     * 客户-订单列表
     */
    public function get_orders_list($user_id, $customer_id) {
    	if(!empty($user_id)){
    		$count = $this->db_view->join(array('order_info', 'order_goods'))->where(array('i.user_id' => $user_id, 'customer_id' => $customer_id))->order('`pay_time` desc')->count('i.order_id');
    		RC_Loader::load_sys_class('ecjia_page', false);
    		$page = new ecjia_page($count, 10, 5);
    		$order = $this->db_view->join(array('order_info', 'order_goods'))->where(array('i.user_id' => $user_id, 'customer_id' => $customer_id))->order('`pay_time` desc')->limit($page->limit())->select();
    		
    		if ($order) {
    		    foreach ($order as $key => $v) {
    		        $order[$key]['pay_time'] = RC_Time::local_date('Y-m-d H:i', $order[$key]['pay_time']);
    		        $order[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $order[$key]['add_time']);
    		    }
    		}
    		
    		$arr = array('list' => $order,  'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page);
    		return $arr;
    	}
    }
    
    /**
     * 共享客户列表
     */
    public function share_list() {
        /* 权限 */
        $this->admin_priv('customer_share_list');
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('共享客户')));
        $this->assign('ur_here', __('共享客户'));
        
        $share_type = empty($_GET['share_type']) ? 'share_customers' : $_GET['share_type'];
        $this->assign('share_type', $share_type);
        $my_share = false;
        if ($share_type == 'my_share') {
            $my_share = true;
        }
        $customer_list = get_share_list($my_share);
        $this->assign('keywords', $customer_list['filter']['keywords']); //关键字搜索
        $this->assign('customer_type', $customer_list['filter']['type_customer']);
        $this->assign('page', $customer_list['current_page']); //搜索后的页码
        $this->assign('customer_list', $customer_list);
        $this->assign('search_action', RC_Uri::url('customer/admin/share_list'));
        $this->assign('batch_action', RC_Uri::url('customer/admin/share_cancel'));
  
        //获取类别列表
        $this->assign('customer_type_list',get_customer_type_list());
        $this->display('share_list.dwt');
    }
    /**
     * 取消共享
     */
    public function share_cancel() {
        $batch_type = empty($_GET['batch']) ? null : $_GET['batch'];
        if ($batch_type == 'cancel') {
            $share_id = explode(',', $_POST['checkboxes']);
            if(empty($share_id)){
            	return false;
            }
            //取消共享
            $where = array(
                'share_id'  => $share_id,
                'sharer'    => $_SESSION['admin_id'],
            );
            $share_row = $this->db_customer_share->where($where)->select();
            $rs = $this->db_customer_share->where($where)->delete();
        } else {
            $share_id = !empty($_GET['id']) ? intval($_GET['id']) : null;
            $customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : null;
            if (empty($share_id)) {
                $this->showmessage('参数异常', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            //取消共享
            $where = array(
                'share_id'  => $share_id,
                'sharer'    => $_SESSION['admin_id'],
            );
            $share_row = $this->db_customer_share->where($where)->select();
            $rs = $this->db_customer_share->where($where)->delete();
        }
        
        if ($rs) {
            //log
            if ($batch_type == 'cancel') {
                foreach ($share_row as $key => $val) {
                    $customer_ids[] = $val['customer_id'];
                }
                $this->add_admin_log('batch_edit', '', $customer_ids, '', '', '，取消共享客户');
                
            } else {
                $this->add_admin_log('edit', $customer_name.'，取消共享客户');
            }
            
            $url_array = get_url_params($_GET, array('customer_name'));
            /* if (!empty($_GET['page'])) {
                $url_array['page'] = $_GET['page'];
            }
            if (!empty($_GET['status'])) {
                $url_array['status'] = $_GET['status'];
            }
            if (!empty($_GET['keywords'])) {
                $url_array['keywords'] = $_GET['keywords'];
            }
            if (!empty($_GET['customer_type'])) {
                $url_array['customer_type'] = $_GET['customer_type'];
            }
            if (!empty($_GET['type'])) {
                $url_array['type'] = $_GET['type'];
            } */
            $this->showmessage('取消共享成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/share_list', $url_array)));
        } else {
            $this->showmessage('取消共享失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
    /**
     * 公共客户列表
     */
    public function public_list() {
        /* 权限 */
        $this->admin_priv('customer_public_list');
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('公共客户')));
        $this->assign('ur_here', __('公共客户'));
        //负责人为空的客户记录
        $_GET['status'] = 2;
        $customer_list = $this->get_list();
        $this->assign('keywords', $customer_list['filter']['keywords']); //关键字搜索
        $this->assign('status', $customer_list['filter']['status']);
        $this->assign('customer_type', $customer_list['filter']['type_customer']);
        $this->assign('page', $customer_list['current_page']); //搜索后的页码
        $this->assign('customer_list', $customer_list);
        $this->assign('search_action', RC_Uri::url('customer/admin/public_list'));
        /*批量操作权限*/
        $this->assign('customer_get', $this->admin_priv('customer_get', '', false)); // 批量领用客户权限
        $this->assign('customer_assign_batch', $this->admin_priv('customer_assign_batch', '', false)); // 批量指派客户权限
        /* 获取来源和类别列表 */
        $this->assign('customer_type_list', get_customer_type_list());
        $this->assign('customer_list', $customer_list);
        $this->assign('admin_list', get_admin_user_list());
        $this->display('public_list.dwt');
    }
    /*
     * 公共客户领用
     */
    public function get_customer() {
        /* 权限 */
        $this->admin_priv('customer_get');
        $day_num = ecjia::config('customer_pool_gain_max_day');
        $max_num = ecjia::config('customer_pool_gain_max');
        //今日时间条件
        $start_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', RC_time::gmtime()));
        $end_date = $start_date + (24 * 60 * 60 - 1);
        //领用数量
        $day_get_num = $this->db_customer_pool->where(array('operate_time' =>array('egt' => $start_date, 'elt' => $end_date), 'operateor' => $_SESSION['admin_id'], 'operate_type' => '3'))->count();
        $total_get  = $this->db_customer_pool->where(array('operateor' => $_SESSION['admin_id'], 'operate_type' => '3'))->count();
		//员工个人领用限制数
        $employee_id = get_employee_id();
        $employee_max_number = $this->db_employees->where(array('employee_id' => $employee_id))->get_field('max_customer');
        $batch_type = empty($_GET['batch']) ? null : $_GET['batch'];
        if ($batch_type == 'true') {
            //批量领用
            $customer_id = explode(',', $_POST['checkboxes']);
            //判断是否公共客户
            $rs = $this->db_customer->in($customer_id)->where(array('is_delete' => '0', 'is_lock' => 0 ))->select();
            //系统
            if(empty($max_num) || $max_num === false ) {
            	if(((!empty($day_num)) && $day_get_num >= $day_num)) {
            		$this->showmessage('每日领用客户次数已使用完', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	}
            }else {
            	if($total_get >= $max_num) {
            		$this->showmessage('领用客户次数已达到最大限制', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	}
            	if((($total_get < $max_num) && ((!empty($day_num))) && ($day_get_num >= $day_num))) {
            		$this->showmessage('每日领用客户次数已使用完', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	}
            }
            //个人
            if (!empty($employee_max_number) && $total_get >= $employee_max_number) {
            	$this->showmessage('您的领用客户次数已达到最大限制', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            foreach ($rs as $key => $val) {
            	if (!empty($val['charge_man'])) {
            		$this->showmessage('领用客户失败，【'.$val['customer_name'].'】已被其他人领用。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	} else {
            		//领用
            		$customer_update = $this->db_customer->where("customer_id = ".$val['customer_id'])->update( array('charge_man' => $_SESSION['admin_id']));
            		$data = array(
            				'customer_id'   => $val['customer_id'],
            				'operate_type'  => 3,
            				'operateor'     => $_SESSION['admin_id'],
            				'operate_time'  => RC_Time::gmtime(),
            		);
            		$pool_insert = $this->db_customer_pool->insert($data);
            		//log
            		if ($customer_update && $pool_insert) {
            			$this->add_admin_log('batch_edit', $val['customer_name'].'，领用客户', $val['customer_id']);
            		}
            	}
            }
            
        } else {
        	//系统
        	if(empty($max_num) || $max_num === false ) {
        		if((!empty($day_num) && $day_get_num >= $day_num)) {
        			$this->showmessage('每日领用客户次数已使用完', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        		}
        	}else {
        		if($total_get >= $max_num) {
            		$this->showmessage('领用客户次数已达到最大限制', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	}
            	if((($total_get < $max_num) && (!empty($day_num)) && ($day_get_num >= $day_num))) {
            		$this->showmessage('每日领用客户次数已使用完', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	}
        	}
        	//个人
        	if (!empty($employee_max_number) && $total_get >= $employee_max_number) {
        		$this->showmessage('您的领用客户次数已达到最大限制', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
        	$customer_id = intval($_GET['id']);
        	if (empty($customer_id)) {
        		$this->showmessage('参数异常', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
        	//查询是否为公共客户
        	$customer_info = $this->db_customer->where(array('customer_id' => array('in' => $customer_id), 'is_delete' => '0', 'is_lock' => 0 ))->find();
        	if (empty($customer_info['charge_man'])) {
        		//领用
        		$customer_update = $this->db_customer->where("customer_id = ".$customer_id)->update( array('charge_man' => $_SESSION['admin_id']));
        		$data = array(
        				'customer_id'   => $customer_info['customer_id'],
        				'operate_type'  => 3,
        				'operateor'     => $_SESSION['admin_id'],
        				'operate_time'  => RC_Time::gmtime(),
        		);
        		$pool_insert = $this->db_customer_pool->insert($data);
        		//log
        		if ($customer_update && $pool_insert) {
        			$this->add_admin_log('edit', $customer_info['customer_name'].'，领用客户');
        		}
        	} else {
        		$this->showmessage('该客户不可领用', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
        }
        if ($customer_update && $pool_insert) {
            $url_array = array();
            if (!empty($_GET['page'])) {
                $url_array['page'] = $_GET['page'];
            }
            if (!empty($_GET['status'])) {
                $url_array['status'] = $_GET['status'];
            }
            if (!empty($_GET['keywords'])) {
                $url_array['keywords'] = $_GET['keywords'];
            }
            if (!empty($_GET['customer_type'])) {
                $url_array['customer_type'] = $_GET['customer_type'];
            }
            $this->showmessage('领用客户成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/public_list', $url_array)));
        } else {
            $this->showmessage('领用客户失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    /**
     * 添加客户 
     */
    public function add() {
        /* 客户添加权限 */
        $this->admin_priv('customer_add');
        
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        $status = empty($_GET['status']) ? 1 : $_GET['status'];
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户列表'), RC_Uri::url('customer/admin/init', array('status' => $status))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加客户')));
        $this->assign('ur_here', __('添加客户'));
        $this->assign('action_link', array('text' => '返回客户列表', 'href' => RC_Uri::url('customer/admin/init', array('status' => $status))));
        $this->assign('country_list', get_regions()); //省市区联动调用functions proxy.func
		//获取来源和类别列表
        $this->assign('source_list', get_source_list());
        $this->assign('customer_type_list',get_customer_type_list());
        $verify = $this->db_customer_exists_fields->field('exists_fields_name, is_open')->select();
        $openinfo = array();
        foreach($verify as $key=> $val){
        	$openinfo[$val['exists_fields_name']] = $val['is_open'];
        }
        $this->assign('is_open', $openinfo);
        $this->assign('form_action', RC_Uri::url('customer/admin/insert'));
        $this->display('customer_edit.dwt');
    }

    /**
     * 添加页面中，增加搜索用户名 
     */
    public function search_users() {
        $user_name = (!empty($_POST['keyword'])) ? trim($_POST['keyword']) : '';
        $result = array();
        if (!empty($user_name)) {
            $data = $this->db_usersview->join('adviser')->field('user_id,u.email,user_name,sex,u.qq,u.mobile_phone,home_phone,adviser_id,username')->where("user_name like '%". $user_name . "%'")->select();
        }
        foreach ($data as $key => $row) {
            $order_count = 1;
//             $order_count = $this->db_usersview->join('order_info')->where("pay_status =2 and oi.user_id = ".$row['user_id'])->count('pay_status');
        	array_push($result, array(
        	       'value'         => $row['user_id'], 
        	       'qq'            => $row['qq'], 
        	       'sex'           => $row['sex'], 
        	       'email'         => $row['email'], 
        	       'mobile_phone'  => $row['mobile_phone'], 
        	       'home_phone'    => $row['home_phone'],
        	       'user_name'     => $row['user_name'],
        	       'has_order'     => $order_count,
        	       'adviser_id'    => $row['adviser_id'],
        	       'adviser_username'  => $row['username'],
        	       'text'          => $row['user_name']."  ".'('.$row['email'].')')
        	); 
        }
        $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('user' => $result));
    }
    /**
     * 客户数据插入 
     */
    public function insert() {
        
        //主联系人插入联系人表 -待增加
        
        $customer_name= (!empty($_POST['customer_name'])) ? trim($_POST['customer_name']) : '';
        $link_man     = (!empty($_POST['link_man'])) ? trim($_POST['link_man']) : '';
        $user_id      = (!empty($_POST['user_id'])) ? trim($_POST['user_id']) : '';
        $sex          = (!empty($_POST['sex'])) ? $_POST['sex'] : '0';
        $mobile       = (!empty($_POST['mobile'])) ? trim($_POST['mobile']) : '';
        $country      = (!empty($_POST['country'])) ? trim($_POST['country']) : '';
        $province     = (!empty($_POST['province'])) ? trim($_POST['province']) : '';
        $city         = (!empty($_POST['city'])) ? trim($_POST['city']) : '';
        $district     = (!empty($_POST['district'])) ? trim($_POST['district']) : '';
        $address      = (!empty($_POST['address'])) ? trim($_POST['address']) : '';
        $qq           = (!empty($_POST['qq'])) ? $_POST['qq'] : '';
        $wechat       = (!empty($_POST['wechat'])) ? $_POST['wechat'] : '';
        $email        = (!empty($_POST['email'])) ? trim($_POST['email']) : '';
        $summary      = (!empty($_POST['summary'])) ? trim($_POST['summary']) : '';
        //其他信息字段
        $customer_source = (!empty($_POST['customer_source'])) ? intval($_POST['customer_source']) : '';
        $customer_type	 = (!empty($_POST['customer_type'])) ? intval($_POST['customer_type']) : '';
        $industry		 = (!empty($_POST['industry'])) ? $_POST['industry'] : '';
        $contract_start	 = (!empty($_POST['contract_start'])) ? $_POST['contract_start'] : NULL;
        $contract_end	 = (!empty($_POST['contract_end'])) ? $_POST['contract_end'] : NULL;
        $position		 = (!empty($_POST['position'])) ? trim($_POST['position']) : '';
        $telphone1		 = (!empty($_POST['telphone1'])) ? trim($_POST['telphone1']) : '';
        $telphone2		 = (!empty($_POST['telphone2'])) ? trim($_POST['telphone2']) : '';
        $fax			 = (!empty($_POST['fax'])) ? $_POST['fax'] : '';
        $birthday		 = (!empty($_POST['birthday'])) ? $_POST['birthday'] : NULL;
        $birth_type 	 = (!empty($_POST['birth_type'])) ? intval($_POST['birth_type']) : '';
        
        $addtime      = RC_Time::gmtime();
        $adder        = (!empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '0';
        
        //url处理
        if (strstr($_POST['web_site'], "http://") || strstr($_POST['web_site'], "https://")) {
        	$url =   $_POST['web_site'];
        } else {
        	$url =   "http://".$_POST['web_site'];
        }
        
        //判断必填项是否填写完整
        $verify = $this->db_customer_exists_fields->field('exists_fields_name, is_open')->where(array('is_open' => '1'))->select();
        $openinfo = array();
        foreach($verify as $val){
        	$openinfo[] = $val['exists_fields_name'];
        }
        foreach ($_POST as $k => $v) {
        	if(in_array($k, $openinfo)) {
        		if(empty($v)) {
        			$this->showmessage('必填项没有填写完整', ecjia::MSGTYPE_JSON  | ecjia::MSGSTAT_ERROR);
        		}
        	}
        }
      
        //关联顾问
        $adviser_id   = (!empty($_POST['adviser_id'])) ? trim($_POST['adviser_id']) : '0';
        
        if(!empty($user_id)){
            $countrecord=$this->db_customer->where(array('user_id'=>$user_id))->find();
            if(!empty($countrecord)){
                $this->showmessage('该用户已被['.$countrecord['customer_name'].']绑定，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        if (!empty($user_id)) {
        	$adviserinfo = $this->db_users->field('adviser_id')->where(array('user_id'=>$user_id))->find();

        	if($adviserinfo['adviser_id'] == 0 && $adviser_id != '0'){
        		$adviser = $this->db_users->where(array('user_id' => $user_id))->update(array('adviser_id' => $adviser_id));
        	}
        }
        /*检查手机号码否重复*/
        if(!empty($mobile)){
        	$count = $this->db_customer->where(array('mobile' => $mobile))->count();
        }
        
        if (!empty($mobile) && $count>0) {
        	$this->showmessage('此手机号码已存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if (empty($mobile) && empty($email) && empty($telphone1) && empty($telphone2)) {
        	$this->showmessage('固定电话，手机，办公电话，邮箱不能都为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $data = array(
            'link_man'      	=> $link_man,
            'user_id'       	=> $user_id,
            'sex'           	=> $sex,
            'mobile'        	=> $mobile,
            'country'       	=> $country,
            'province'      	=> $province,
            'city'          	=> $city,
            'district'      	=> $district,
            'address'       	=> $address,
            'qq'            	=> $qq,
        	'wechat'            => $wechat,
            'url'           	=> $url,
        	'customer_name' 	=> $customer_name,
            'email'         	=> $email,
            'summary'       	=> $summary,
        	'telphone1'         => $telphone1,
        	'telphone2'       	=> $telphone2,
        	'charge_man'		=> $adder,
        		
        	'source_id'   		=> $customer_source,
        	'state_id' 			=> $customer_type,
        	'industry'         	=> $industry,
        	'position' 			=> $position,
        	'fax' 		      	=> $fax,
        	'birth_type'       	=> $birth_type,
        	
        	'adder'				=> $adder,
            'add_time'      	=> $addtime,
            'customer_sn'       => get_customer_sn(),
        ); 
        
        if (!empty( $contract_start)) {
        	$data['contract_start'] = $contract_start;
        }
        if(!empty($contract_end)) {
        	$data['contract_end'] = $contract_end;
        }
        if(!empty($birthday)) {
        	$data['birthday'] =  $birthday;
        }
        
        $id = $this->db_customer->insert($data);
      	if($id) {
      		$data_link = array(
      				'customer_id'   	=> $id,
      				'link_man_name' 	=> $link_man,
      				'sex' 	        	=> $sex,
      				'telphone'    		=> $telphone1,
      				'mobile'		    => $mobile,
      				'email' 			=> $email,
      				'qq'         		=> $qq,
      				'birth_type' 		=> $birth_type,
      				'duty'       		=> $position,
      				'summary'       	=> $summary,
      				'adder'       		=> $adder,
      				'add_time'      	=> $addtime
      		);
      		if(!empty($birthday)) {
      			$data_link['birthday'] =  $birthday;
      		}
      		$insert_linkinfo = $this->db_customer_linkman->insert($data_link);
      	}
        
        if ($id && $insert_linkinfo) {
        	$links[] = array('text' => '返回客户列表', 'href'=> RC_Uri::url('customer/admin/init'));
        	$links[] = array('text' => '继续添加新客户', 'href'=> RC_Uri::url('customer/admin/add'));
        	//log
        	$this->add_admin_log('add',$customer_name,'','',$user_id);
            $this->showmessage('添加客户成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links ,'pjaxurl' => RC_Uri::url('customer/admin/edit', array('id' => $id))));
        } else {
            $this->showmessage('添加客户失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑客户 
     */
    public function edit() {
        /* 客户更新权限 */
        $this->admin_priv('customer_update');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑客户')));
        RC_Script::enqueue_script('customer', RC_App::apps_url('statics/js/customer.js', __FILE__));

        $keywords = empty($_GET['keywords']) ? null : trim($_GET['keywords']);
        $id = empty($_GET['id']) ? null : intval($_GET['id']);
        $page = empty($_GET['page']) ? null : intval($_GET['page']);
        $menu = empty($_GET['menu']) ? null : trim($_GET['menu']);
        $status = empty($_GET['status']) ? null : trim($_GET['status']);
        
        $arr = $this->db_view->join(array('users','adviser', 'customer_state', 'customer_source'))->field('c.*, cs.state_name, cs.state_id, co.source_id,co.source_name, u.user_name,u.adviser_id,ad.username')->find($id);
        $this->assign('ur_here', __('编辑客户'));
        $this->assign('customer_info', $arr);
        $this->assign('proxy_info', $arr);
        $this->assign('country_list', get_regions());
        $this->assign('province_list', get_regions(1, 1));
        $this->assign('city_list', get_regions(2, $arr['province']));
        $this->assign('district_list', get_regions(3, $arr['city']));
        
        //获取来源和类别列表
        $this->assign('source_list', get_source_list());
        $this->assign('customer_type_list',get_customer_type_list());
        
        $this->assign_lang();
        $this->assign('action_link', array('text' => '返回客户列表', 'href' => RC_Uri::url('customer/admin/init', get_url_params($_GET))));
        $this->assign('id', $id);
        $this->assign('menu', $menu);
        $this->assign('status', $status);
        $this->assign('form_action', RC_Uri::url('customer/admin/update'));
        $this->assign('binding_priv',$this->admin_priv('binding_adviser', '', false));//绑定权限
        $this->display('customer_edit.dwt');
    }

    /**
     * 更新客户 
     */
    public function update() {
        /* 更新信息 */
        $id             = intval($_POST['id']);
        $link_man       = (!empty($_POST['link_man'])) ? trim($_POST['link_man']) : '';
        $user_id        = (!empty($_POST['user_id'])) ? trim($_POST['user_id']) : '';
        $sex            = (!empty($_POST['sex'])) ? intval($_POST['sex']) : '0';
        $mobile         = (!empty($_POST['mobile'])) ? trim($_POST['mobile']) : '';
        $country        = empty($_POST['country']) ? 0 : intval($_POST['country']);
        $province       = empty($_POST['province']) ? 0 : intval($_POST['province']);
        $city           = empty($_POST['city']) ? 0 : intval($_POST['city']);
        $district       = empty($_POST['district']) ? 0 : intval($_POST['district']);
        $address        = (!empty($_POST['address'])) ? trim($_POST['address']) : '';
        $qq             = (!empty($_POST['qq'])) ? trim($_POST['qq']) : '';
        $wechat         = (!empty($_POST['wechat'])) ? trim($_POST['wechat']) : '';
        $customer_name  = (!empty($_POST['customer_name'])) ? trim($_POST['customer_name']) : '';
        $email          = (!empty($_POST['email'])) ? trim($_POST['email']) : '';
        $summary        = (!empty($_POST['summary'])) ? trim($_POST['summary']) : '';
        //其他信息字段
        $customer_source = (!empty($_POST['customer_source'])) ? intval($_POST['customer_source']) : '';
        $customer_type	 = (!empty($_POST['customer_type'])) ? intval($_POST['customer_type']) : '';
        $industry		 = (!empty($_POST['industry'])) ? $_POST['industry'] : '';
        $contract_start	 = (!empty($_POST['contract_start'])) ? $_POST['contract_start'] : NULL;
        $contract_end	 = (!empty($_POST['contract_end'])) ? $_POST['contract_end'] : NULL;
        $position		 = (!empty($_POST['position'])) ? trim($_POST['position']) : '';
        $telphone1		 = (!empty($_POST['telphone1'])) ? trim($_POST['telphone1']) : '';
        $telphone2		 = (!empty($_POST['telphone2'])) ? trim($_POST['telphone2']) : '';
        $fax			 = (!empty($_POST['fax'])) ? $_POST['fax'] : '';
        $birthday		 = (!empty($_POST['birthday'])) ? $_POST['birthday'] : NULL;
        $birth_type 	 = (!empty($_POST['birth_type'])) ? intval($_POST['birth_type']) : '';
        
        $addtime      = RC_Time::gmtime();
        $adder        = (!empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '0';
        
        //url处理
        if (strstr($_POST['web_site'], "http://") || strstr($_POST['web_site'], "https://")) {
        	$url =   $_POST['web_site'];
        } else {
        	$url =   "http://".$_POST['web_site'];
        }
        
        //判断必填项是否填写完整
        $verify = $this->db_customer_exists_fields->field('exists_fields_name, is_open')->where(array('is_open' => '1'))->select();
        $openinfo = array();
        foreach($verify as $val){
        	$openinfo[] = $val['exists_fields_name'];
        }
        foreach ($_POST as $k => $v) {
        	if(in_array($k, $openinfo)) {
        		if(empty($v)) {
        			$this->showmessage('必填项没有填写完整', ecjia::MSGTYPE_JSON  | ecjia::MSGSTAT_ERROR);
        		}
        	}
        }
        
        //关联顾问
        $adviser_id     = (!empty($_POST['adviser_id'])) ? trim($_POST['adviser_id']) : '';
        
       if(!empty($user_id)){
            $countrecord=$this->db_customer->where(array('user_id'=>$user_id,'customer_id'=>array('neq'=>$id)))->find();
            if(!empty($countrecord)){
                $this->showmessage('该用户已被['.$countrecord['customer_name'].']绑定，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        if (!empty($user_id)) {
        	$adviserinfo = $this->db_users->field('adviser_id')->where(array('user_id'=>$user_id))->find();
        	if($adviserinfo['adviser_id'] == 0){
        		$adviser = $this->db_users->where(array('user_id' => $user_id))->update(array('adviser_id' => $adviser_id));
        	}
        }
        
        /*检查手机号码是否相同*/
        if(!empty($mobile)) {
        	$is_only = $this->db_customer->where(array('mobile' => $_POST['mobile'], 'customer_id' => array('neq' => $_POST['id'])))->count();
        	if ($is_only > 0) {
        		/* 提示信息 */
        		$this->showmessage('此手机号码已存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
        }
        
        if (empty($mobile) && empty($email) && empty($telphone1) && empty($telphone2)) {
        	$this->showmessage('固定电话，手机，办公电话，邮箱不能都为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $data = array(
            'customer_name' => $customer_name,
            'link_man'      => $link_man,
            'user_id'       => $user_id,
            'sex'           => $sex,
            'telphone1'     => $telphone1,
            'mobile'        => $mobile,
            'country'       => $country,
            'province'      => $province,
            'city'          => $city,
            'district'      => $district,
            'address'       => $address,
            'qq'            => $qq,
        	'wechat'        => $wechat,
            'url'           => $url,
            'email'         => $email,
            'summary'       => $summary,
        	'telphone1'     => $telphone1,
        	'telphone2'     => $telphone2,
        		
        	'source_id'   	=> $customer_source,
        	'state_id' 		=> $customer_type,
        	'industry'      => $industry,
        	'position' 		=> $position,
        	'fax' 		    => $fax,
       		'birth_type'    => $birth_type,
        		 
       		'adder'			=> $adder,
       		'update_time'   => $addtime
        );
       
        if (!empty( $contract_start)) {
        	$data['contract_start'] = $contract_start;
        }
        if(!empty($contract_end)) {
        	$data['contract_end'] = $contract_end;
        }
        if(!empty($birthday)) {
        	$data['birthday'] =  $birthday;
        }
        $customer_updated = $this->db_customer->where(array('customer_id' => $id))->update($data);
        if ($customer_updated) {
            //log
            $this->add_admin_log('edit', $customer_name, '', '', $user_id);
            $this->showmessage('编辑客户成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/edit', array('id' => $id, 'status' => $_POST['statu'], 'menu' => $_POST['menu']))));
        } else {
            $this->showmessage('编辑客户失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 客户还原
     */
    public function reback() {
        $this->admin_priv('customer_reback');
        $id = empty($_GET['id']) ? '' : intval($_GET['id']);
        /*user_id存在且不冲突*/
        $data = array(
            'is_delete' => '0'
        );
        $user=$this->db_customer->field('user_id,customer_name')->where(array('customer_id' => $id))->find();
        
        if(!empty($user['user_id'])){
        	/*user_id存在且冲突*/
            $countrecord=$this->db_customer->where(array('user_id'=>$user['user_id'],'customer_id'=>array('neq'=>$id),'is_delete'=>array('neq'=>1)))->find();
            
            if(!empty($countrecord)){
                $userinfo=array(
                    'user_id'=>0,
                    'is_delete' => '0'
                );
                $this->db_customer->where(array('customer_id'=>$id))->update($userinfo);
                $this->showmessage('该客户绑定的用户已被['.$countrecord['customer_name'].']绑定，请重新绑定', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
             
            }
        }else{
        	/*user_id为null或0*/
        	$data = array(
        			'is_delete' => '0'
        	);
        }
        if ($id) {
            $this->db_customer->where(array('customer_id' => $id))->update($data);
            //log
            $this->add_admin_log('restore', $user['customer_name']);
            $this->showmessage(__('操作成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            $this->showmessage(__('操作失败'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 移至回收站
     */
    public function remove() {
        //客户删除权限
        $this->admin_priv('customer_del');
        $is_delete = 1;
        $data = array(
            'is_delete' => $is_delete,
        );
        $customer_delete = $this->db_customer->where(array('customer_id' => $_GET['id']))->update($data);
        if ($customer_delete) {
            //log
            $this->add_admin_log('remove', '', $_GET['id']);
            $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            $this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
	
    /**
     * 放弃客户
     */
    public function quit() {
    	//客户放弃权限
    	$this->admin_priv('customer_quit');
    	$charge_man = '0';
    	$id =  $_GET['id'];
    	$data = array(
    			'charge_man' => $charge_man,
    	);
    	$customer_quit = $this->db_customer->where(array('customer_id' => $id))->update($data);
    	if($customer_quit) {
    		$data_pool = array(
    				'customer_id' 	=> $id,
    				'operate_type' 	=> '1',
    				'operateor'    	=> $_SESSION['admin_id'],
    				'operate_time'	=> RC_Time::gmtime(),
    		);
    		$insert_pool = $this->db_customer_pool->insert($data_pool);
    	}
    	if ($customer_quit && $insert_pool) {
    		//log
    		$this->add_admin_log('quit', '', $_GET['id']);
    		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    	} else {
    		$this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 列表单个分享客户
     */
    public function share() {
    	//客户分享权限
    	$this->admin_priv('customer_share');
    	$customer_id =  $_POST['customer-share-id'];
    	$admin_ids 	   = intval($_POST['sharer_id']) ;
    	
    	if(strpos($admin_ids,",")) {
    		$admin_ids_new = explode(',', $admin_ids);
    	}else{
    		$admin_ids_new = intval($_POST['sharer_id']);
    	}
    	if(is_array($admin_ids_new)) {
          /*一条数据分享给多个人*/
           foreach($admin_ids_new as $val) {
            $data = array(
            	'customer_id' => $customer_id,
         		'admin_id'    => $val,
            	'sharer'	  => $_SESSION['admin_id'],
         		'share_time'  => RC_Time::gmtime(),
           		);
           	$result = $this->db_customer_share->insert($data);
          }	
        }else{
           /*一条数据分享给一个人*/
            $data = array(
                'customer_id' => $customer_id,
		         'admin_id'    => $admin_ids_new,
		         'sharer'	  => $_SESSION['admin_id'],
		         'share_time'  => RC_Time::gmtime(),
             	);
            $result = $this->db_customer_share->insert($data);
         }
    	if ($result) {
    		//log
    		$this->add_admin_log('share', '', $customer_id);
    		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    	} else {
    		$this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 客户详细页面
     */
    public function detail() {
    	//客户详情权限
   		$this->admin_priv('customer_check');
        //获取参数
        $id        = intval($_GET['id']);
        if (empty($id)) {
            $this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('customer/admin/init')));
        }
        $status    = empty($_GET['status']) ? 1 : $_GET['status'];
        $page      = empty($_GET['page']) ? null : $_GET['page'];
        $keywords  = empty($_GET['keywords']) ? null : $_GET['keywords'];
        
        $url_array = get_url_params($_GET);
        $url_array['status'] = $status;

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户列表'), RC_Uri::url('customer/admin/init', $url_array)));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户详情')));
        $type       = !empty($_GET['type']) ?  $_GET['type'] : 'orders';
        
        $row = $this->db_view->join(array('users','adviser', 'customer_source', 'customer_state', 'admin_user'))->field('c.*,u.user_name,ad.username as adviser_name,ad.id as ad_id, co.source_name, cs.state_name, au.user_name')->find($id);
        $row['adder'] = $this->db_admin_user->where(array('user_id' => $row['adder']))->get_field('user_name');
        $row['username'] = $this->db_users->where(array('user_id' => $row['user_id']))->get_field('user_name');
        $row['chargeman'] = $this->db_admin_user->where(array('user_id' => $row['charge_man']))->get_field('user_name');
        $row['last_contact_time'] = RC_Time::local_date('Y-m-d H:i', $row['last_contact_time']);
        /* type查询
         * 查询信息分页
         *  
         */
        
        if ($row['user_id'] != '') {
            //根据type查询
            switch ($type) {
                case 'orders' : 
                    $order_list   = $this->get_orders_list($row['user_id'], $row['customer_id']);
                    $this->assign('order_list', $order_list);
                    break;
                case 'service' : 
                    $service_list = get_service_list($row['user_id'], $row['customer_id']);
                    $this->assign('service_list', $service_list);
                    break;
                case 'tickets' : 
                    $tickets_list = get_tickets_list($row['user_id'], $row['customer_id']);
                    $this->assign('ticket_lists', $tickets_list);
                    break;
                case 'complain' : 
                    $complain_list= get_complain_list($row['user_id'], $row['customer_id']);
                    $this->assign('complain_list', $complain_list);
                    break;
                default : 
                    $order_list   = $this->get_orders_list($row['user_id'], $row['customer_id']);
                    $this->assign('order_list', $order_list);
                    break;
            }
        }
        //根据type查询
        switch ($type) {
            case 'contact' : 
                $contact_list = get_contact_list('', $row['customer_id']);
                $this->assign('contact_list', $contact_list); 
                break;
            case 'linkman' : 
                $linkman_list = get_link_man_list($row['customer_id']);
                $this->assign('linkman_list', $linkman_list);
                break;
            case 'files'   : 
                $files_list   = get_files_list('', $row['customer_id']);
                $this->assign('files_list', $files_list);
                break;
        }
        $row['add_time'] = RC_Time::local_date('Y-m-d H:i', $row['add_time']); //将时间戳格式化
        $row['reservation_time'] = RC_Time::local_date('Y-m-d H:i', $row['reservation_time']);
        /* 获得对应的省市区 */
        $province_rows = $this->db_provinceview->where(array('region_id' => $row['province']))->get_field('region_name');
        $city_rows = $this->db_cityview->where(array('region_id' => $row['city']))->get_field('region_name');
        $district_rows = $this->db_districtview->where(array('region_id' => $row['district']))->get_field('region_name'); 
        $row['address'] =$province_rows." ".$city_rows." ".$district_rows." ".$row['address'];
        $this->assign('ur_here', __('客户信息详情'));
        //分配用户名
        $this->assign('id', $id);
        $this->assign('customer', $row);
        
        $this->assign('keywords', $keywords);
        $this->assign('type', $type);
        $this->assign('page', $page);
        $this->assign('status', $status);
        /*查看详情*/
        $this->assign('detail_action', RC_Uri::url('customer/admin/linkman_detail'));
        
        $share_type = empty($_GET['share_type']) ? null : $_GET['share_type'];
        $refer = empty($_GET['refer']) ? null : $_GET['refer'];
        if ($refer == 'public') {
            $this->assign('action_link', array('text' => '返回公共客户', 'href' => RC_Uri::url('customer/admin/public_list', array('status' => $status, 'page' => $page,'keywords'=>$keywords))));
        } elseif ($refer == 'share') {
            $this->assign('action_link', array('text' => '返回共享客户', 'href' => RC_Uri::url('customer/admin/share_list', array('share_type' => $share_type, 'page' => $page,'keywords'=>$keywords))));
        } else {
            $this->assign('action_link', array('text' => '返回客户列表', 'href' => RC_Uri::url('customer/admin/init', $url_array)));
        }
        
        $this->display('customer_detail.dwt');
    }
    
    /**
     * 联系人-添加
     */
    public function linkman_add() {
        /* 联系人添加权限,同客户详情查看权限 */
        $this->admin_priv('customer_check');
        $id          = (!empty($_GET['id'])) ? intval($_GET['id']) : '';
        $status		 = (!empty($_GET['status'])) ? intval($_GET['status']) : '';
        $page		 = (!empty($_GET['page'])) ? intval($_GET['page']) : '';
        $keywords	 = (!empty($_GET['keywords'])) ? trim($_GET['keywords']) : '';
        $type 		 = (!empty($_GET['type'])) ? trim($_GET['type']) : '';
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户详情'), RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'linkman', 'page' => $page, 'status' => $status, 'keywords' => $keywords))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加联系人')));
        $this->assign('ur_here', __('添加联系人'));
        $this->assign('action_link', array('text' => '返回客户详情', 'href' => RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'linkman', 'page' => $page, 'status' => $status, 'keywords' => $keywords))));
        
        $this->assign('keywords', $keywords);
        $this->assign('type', $type);
        $this->assign('page', $page);
        $this->assign('status', $status);
        $this->assign('id', $id);
        $this->assign('form_action', RC_Uri::url('customer/admin/linkman_insert'));
        $this->display('linkman_edit.dwt');
    }
    
    /**
     * 联系人-添加数据处理
     */
    public function linkman_insert() {
    	$customer_id = (!empty($_POST['id'])) ? intval($_POST['id']) : '';
    	if (empty($customer_id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$status		 = (!empty($_POST['statu'])) ? intval($_POST['statu']) : '';
    	$page		 = (!empty($_POST['page'])) ? intval($_POST['page']) : '';
    	$keywords	 = (!empty($_POST['keywords'])) ? trim($_POST['keywords']) : '';
    	$type 		 = (!empty($_POST['types'])) ? trim($_POST['types']) : '';
    	/*联系人表更新数据*/
    	$link_man_name    	= (!empty($_POST['link_man_name'])) ? trim($_POST['link_man_name']) : '';
    	$sex	    		= (!empty($_POST['sex'])) ? $_POST['sex'] : '';
    	$mobile	    		= (!empty($_POST['mobile'])) ? $_POST['mobile'] : '';
    	$telphone	  		= (!empty($_POST['telphone'])) ? trim($_POST['telphone']) : '';
    	$email	     		= (!empty($_POST['email'])) ? trim($_POST['email']) : '';
    	$qq			 		= (!empty($_POST['qq'])) ? trim($_POST['qq'])  : '';
    	$wechat			 	= (!empty($_POST['wechat'])) ? $_POST['wechat']  : '';
    	$summary	  		= (!empty($_POST['summary'])) ? trim($_POST['summary']) : '';
    	$department	  		= (!empty($_POST['department'])) ? trim($_POST['department']) : '';
    	$duty		  		= (!empty($_POST['duty'])) ? trim($_POST['duty']) : '';
    	$birthday	  		= (!empty($_POST['birthday'])) ? trim($_POST['birthday']) : '';
    	$birth_type	  		= (!empty($_POST['birth_type'])) ? intval($_POST['birth_type']) : '';
    	$adder        		= (!empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '0';
    	$add_time 	 		= RC_Time::gmtime();
    	
    	$data = array(
    			'customer_id' 		=> $customer_id,
    			'link_man_name' 	=> $link_man_name,
    			'sex' 				=> $sex,
    			'birth_type' 		=> $birth_type,
    			'mobile'  			=> $mobile,
    			'telphone'			=> $telphone,
    			'email'			 	=> $email,
    			'qq'			 	=> $qq,
    			'wechat'			=> $wechat,
    			'summary' 			=> $summary,
    			'department'		=> $department,
    			'duty'				=> $duty,
    			'add_time'			=> $add_time,
    			'adder'				=> $adder
    	);
    	if(!empty($birthday) ){
    		$data['birthday'] = $birthday;
    	}
    	 
    	$insert_linkman = $this->db_customer_linkman->insert($data);
    	if($insert_linkman){
    		//log
    		$cus_name = $this->db_customer->where(array('c.customer_id' => $customer_id))->get_field('customer_name');
    		$cus_name_new = $link_man_name.'【'.$cus_name.'】';
    		ecjia_admin_log::instance()->add_object('link_man', '联系人');
    		ecjia_admin::admin_log($cus_name_new,'add','link_man');
    		$this->showmessage('添加联系人成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/detail', array('id' => $customer_id, 'type' => $type, 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    	}else{
    		$this->showmessage('添加联系人失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 联系人-编辑
     */
    public function linkman_edit() {
    	/*权限 */
    	$this->admin_priv('customer_linkman_edit');
    
    	$id          = (!empty($_GET['id'])) ? intval($_GET['id']) : '';
    	if (empty($id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$status		 = (!empty($_GET['status'])) ? intval($_GET['status']) : '';
    	$page		 = (!empty($_GET['page'])) ? intval($_GET['page']) : '';
    	$keywords	 = (!empty($_GET['keywords'])) ? trim($_GET['keywords']) : '';
    	$type 		 = (!empty($_GET['type'])) ? trim($_GET['type']) : '';
    	$link_id 	 = (!empty($_GET['link_id'])) ? trim($_GET['link_id']) : '';
    	 
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户详情'), RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => $type, 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑联系人')));
    	$this->assign('ur_here', __('编辑联系人'));
    	$this->assign('action_link', array('text' => '返回客户详情', 'href' => RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'linkman', 'page' => $page, 'status' => $status, 'keywords' => $keywords))));
    	/*获取客户联系记录信息*/
    	$linkman_info = $this->db_customer_linkman->where(array('customer_id' => $id, 'link_id' => $link_id))->find();
    	/*参数分配*/
    	$this->assign('id', $id);
    	$this->assign('link_id', $link_id);
    	$this->assign('page', $page);
    	$this->assign('keywords', $keywords);
    	$this->assign('type', $type);
    	$this->assign('status', $status);
    	$this->assign('linkman_info', $linkman_info);
    	$this->assign('form_action', RC_Uri::url('customer/admin/linkman_update'));
    	$this->display('linkman_edit.dwt');
    }
    
    /**
     * 联系人-编辑数据处理
     */
    public function linkman_update() {
    	$link_id 	 = (!empty($_POST['link_id'])) ? intval($_POST['link_id']) : '';
    	$customer_id = (!empty($_POST['id'])) ? intval($_POST['id']) : '';
    	if (empty($link_id) || empty($customer_id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$status		 = (!empty($_POST['statu'])) ? intval($_POST['statu']) : '';
    	$page		 = (!empty($_POST['page'])) ? intval($_POST['page']) : '';
    	$keywords	 = (!empty($_POST['keywords'])) ? trim($_POST['keywords']) : '';
    	$type 		 = (!empty($_POST['types'])) ? trim($_POST['types']) : '';
    	/*联系人表更新数据*/
    	$link_man_name    	= (!empty($_POST['link_man_name'])) ? trim($_POST['link_man_name']) : '';
    	$sex	    		= (!empty($_POST['sex'])) ? $_POST['sex'] : '';
    	$mobile	    		= (!empty($_POST['mobile'])) ? $_POST['mobile'] : '';
    	$telphone	  		= (!empty($_POST['telphone'])) ? trim($_POST['telphone']) : '';
    	$email	     		= (!empty($_POST['email'])) ? trim($_POST['email']) : '';
    	$qq			 		= (!empty($_POST['qq'])) ? trim($_POST['qq'])  : '';
    	$wechat			 	= (!empty($_POST['wechat'])) ? $_POST['wechat']  : '';
    	$summary	  		= (!empty($_POST['summary'])) ? trim($_POST['summary']) : '';
    	$department	  		= (!empty($_POST['department'])) ? trim($_POST['department']) : '';
    	$duty		  		= (!empty($_POST['duty'])) ? trim($_POST['duty']) : '';
    	$birthday	  		= (!empty($_POST['birthday'])) ? trim($_POST['birthday']) : '';
    	$birth_type	  		= (!empty($_POST['birth_type'])) ? intval($_POST['birth_type']) : '';
    	$adder        		= (!empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '0';
    	$add_time 	 		= RC_Time::gmtime();
    	
    	$data = array(
    			'customer_id' 		=> $customer_id,
    			'link_man_name' 	=> $link_man_name,
    			'sex' 				=> $sex,
    			'birth_type' 		=> $birth_type,
    			'mobile'  			=> $mobile,
    			'telphone'			=> $telphone,
    			'email'			 	=> $email,
    			'qq'			 	=> $qq,
    			'wechat'			=> $wechat,
    			'summary' 			=> $summary,
    			'department'		=> $department,
    			'duty'				=> $duty,
    			'add_time'			=> $add_time,
    			'adder'				=> $adder
    	);
    	if(!empty($birthday) ) {
    		$data['birthday'] = $birthday;
    	}
    	$update_linkman = $this->db_customer_linkman->where(array('link_id' => $link_id, 'customer_id' => $customer_id))->update($data);
    	if($update_linkman) {
    		//log
    		$cus_name = $this->db_customer->where(array('c.customer_id' => $customer_id))->get_field('customer_name');
    		$cus_name_new = $link_man_name.'【'.$cus_name.'】';
    		ecjia_admin_log::instance()->add_object('link_man', '联系人');
    		ecjia_admin::admin_log($cus_name_new,'edit','link_man');
    		$this->showmessage('编辑联系人成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/detail', array('id' => $customer_id, 'type' => $type, 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    	} else {
    		$this->showmessage('编辑联系人失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 删除某条客户的某个联系人
     */
    public function linkman_remove() {
    	//删除客户联系记录权限
    	$this->admin_priv('customer_linkman_del');
    	$link_name = empty($_GET['link_man_name']) ?　null : $_GET['link_man_name'];
    	$link_id = empty($_GET['link_id']) ?　null : $_GET['link_id'];
    	$id = empty($_GET['id']) ?　null : $_GET['id'];
    	$delete = $this->db_customer_linkman->where(array('link_id' => $link_id, 'customer_id' => $id ))->delete();
    	if ($delete) {
    		//log
    		$cus_name = $this->db_customer->where(array('c.customer_id' => $id))->get_field('customer_name');
    		$cus_name_new = $link_name.'【'.$cus_name.'】';
    		ecjia_admin_log::instance()->add_object('link_man', '联系人');
    		ecjia_admin::admin_log($cus_name_new,'remove','link_man');
    
    		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    	} else {
    		$this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 获取联系记录详情
     */
    public function linkman_detail() {
    	//$this->admin_priv('demand_list_manage');
    	$link_id           = $_GET['link_id'];
    	$customer_id	   = $_GET['id'];
    	$sex = array('0' => '男', '1' => '女');
    	$birth_type	 = array('0' => '公历', '1' => '农历');
    	$linkman_detail = $this->db_customer_linkman_view->join(array('customer', 'admin_user'))
    	->field('cl.*, au.user_name')->where(array('cl.link_id' => $link_id, 'cl.customer_id' => $customer_id))->find();
    	$linkman_detail['add_time'] = RC_Time::local_date('Y-m-d H:i', $linkman_detail['add_time']);
    	$linkman_detail['sex_new']  = $sex[$linkman_detail['sex']];
    	$linkman_detail['birth_type_new']  = $birth_type[$linkman_detail['birth_type']];
    	$this->showmessage($linkman_detail,  ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    /**
     * 联系记录-添加
     */
    public function contact_add() {
        /*权限，同查看客户详情一样 */
       $this->admin_priv('customer_check');
    
        $id          = !empty($_GET['id']) ? intval($_GET['id']) : null;
        $status		 = !empty($_GET['status']) ? intval($_GET['status']) : null;
        $page		 = !empty($_GET['page']) ? intval($_GET['page']) : null;
        $keywords	 = !empty($_GET['keywords']) ? trim($_GET['keywords']) : null;
        $type 		 = !empty($_GET['type']) ? trim($_GET['type']) : null;
        if (empty($id)) {
            $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户详情'), RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'contact', 'page' => $page, 'status' => $status, 'keywords' => $keywords))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加联系记录')));
        $this->assign('ur_here', __('添加联系记录'));
        $this->assign('action_link', array('text' => '返回客户详情', 'href' => RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'contact', 'page' => $page, 'status' => $status, 'keywords' => $keywords))));

        $this->assign('keywords', $keywords);
        $this->assign('type', $type);
        $this->assign('page', $page);
        $this->assign('status', $status);
        /*获取部分客户信息*/
        $time = RC_Time::local_date('Y-m-d H:i', RC_Time::gmtime());
        //获取联系方式，联系类型和客户类别列表
        $this->assign('linkman_lists', get_linkman_list($id)); //读取当前客户下联系人
        $this->assign('contact_way_list', get_contact_way_list());
        $this->assign('contact_type_list', get_contact_type_list());
        $this->assign('customer_type_list', get_customer_type_list());
        /*获取当前客户4条联系记录*/
        $this->assign('contact_record_list', get_contact_record_list($id));
        /*获取客户类别信息*/
        $typeinfo = $this->db_customer_state_type_view->where(array('customer_id' => $id))->field('cs.state_name,c.state_id')->find();
        /*获取主联系人信息*/
        $info = $this->db_customer_linkman->where(array('customer_id' => $id))->field('mobile, telphone, link_man_name')->order(array('add_time' => 'asc'))->select();
    	if(!empty($info)){
    		if(!empty($info[0]['mobile'])&& !empty($info[0]['telphone'])){
    			$mobile_telphone = $info[0]['mobile'].'，'.$info[0]['telphone'];
    		}elseif (!empty($info[0]['mobile'])&& empty($info[0]['telphone'])){
    			$mobile_telphone = $info[0]['mobile'];
    		}elseif(empty($info[0]['mobile']) && !empty($info[0]['telphone'])){
    			$mobile_telphone = $info[0]['telphone'];
    		}
    	}
    	/*获取客户名称*/
        $cus_name = $this->db_customer->where(array('c.customer_id' => $id))->get_field('customer_name');
        $this->assign('cus_name', $cus_name);
        $this->assign('typeinfo', $typeinfo['state_name']);
        $this->assign('typeinfo_state_id', $typeinfo['state_id']);
        $this->assign('id', $id);
        $this->assign('mobile_telphone', $mobile_telphone);
        $this->assign('time', $time);
        $this->assign('form_action', RC_Uri::url('customer/admin/contact_insert'));
        $this->display('contact_edit.dwt');
    }
    
    /**
     * 联系记录-添加数据处理
     */
    public function contact_insert() {
    	$customer_id = (!empty($_POST['customer_id'])) ? intval($_POST['customer_id']) : '';
    	$status		 = (!empty($_POST['statu'])) ? intval($_POST['statu']) : '';
    	$page		 = (!empty($_POST['page'])) ? intval($_POST['page']) : '';
    	$keywords	 = (!empty($_POST['keywords'])) ? trim($_POST['keywords']) : '';
    	$type 		 = (!empty($_POST['types'])) ? trim($_POST['types']) : '';
    	/*联系记录表更新数据*/
    	$summary	  = (!empty($_POST['summary'])) ? trim($_POST['summary']) : '';
    	$next_time    = (!empty($_POST['next_time'])) ? RC_Time::local_strtotime($_POST['next_time']) : '';
    	$next_goal    = (!empty($_POST['next_goal'])) ? trim($_POST['next_goal']) : '';
    	$link_type    = (!empty($_POST['link_type'])) ? $_POST['link_type'] : '';
    	$link_man     = (!empty($_POST['link_man'])) ? intval($_POST['link_man']) : '';
    	$contact_way  = (!empty($_POST['contact_way'])) ? trim($_POST['contact_way']) : '';
    	$telphone     = (!empty($_POST['telphone'])) ? trim($_POST['telphone']) : '';
    	$contact_time = (!empty($_POST['contact_time'])) ?  RC_Time::local_strtotime($_POST['contact_time']) : '';
    	$adder        = (!empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '0';
    	$add_time 	  = RC_Time::gmtime();
    	/*客户表更新字段*/
    	$customer_type = (!empty($_POST['customer_type'])) ? $_POST['customer_type'] : '';
    	$data = array(
    			'customer_id' 	=> $customer_id,
    			'summary' 		=> $summary,
//     			'next_time' 	=> $next_time,
//     			'next_goal'		=> $next_goal,
    			'link_type' 	=> $link_type,
    			'link_man'  	=> $link_man,
    			'type'		 	=> $contact_way,
    			'telphone'		=> $telphone,
    			'add_time'		=> $contact_time,
    			'adder'			=> $adder
    	);
    	if(!empty($next_time) && !empty($next_goal)) {
    		$data['next_time'] = $next_time;
    		$data['next_goal'] = $next_goal;
    	}
    	
    	$insert_feedback = $this->db_customer_feedback->insert($data);
    	if($insert_feedback) {
    		$this->db_customer->where(array('customer_id' => $customer_id))->update(array('last_contact_time' => $add_time, 'reservation_time' => $next_time));
    	}
    	if(!empty($customer_type)) {
    		$this->db_customer->where(array('customer_id' => $customer_id))->update(array('state_id' => $customer_type));
    	}
    	if($insert_feedback) {
    		$where2 = array();
    		$where2['customer_id'] = $customer_id;
    		$where2['feed_id'] = array('neq' => $insert_feedback);
    		$this->db_customer_feedback->where($where2)->update(array('next_time' => ''));
    		//log
    		$cus_name = $this->db_customer->where(array('c.customer_id' => $customer_id))->get_field('customer_name');
    		$new_summary = RC_String::sub_str($summary, '10');
    		$cus_name_new= $new_summary.'【'.$cus_name.'】';
    		ecjia_admin_log::instance()->add_object('contact_record', '联系记录');
    		ecjia_admin::admin_log($cus_name_new,'add','contact_record');
    		$this->showmessage('添加联系记录成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/detail', array('id' => $customer_id, 'type' => $type, 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    	} else {
    		$this->showmessage('添加联系记录失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 联系记录-编辑
     */
    public function contact_edit() {
    	/*权限 */
    	$this->admin_priv('customer_contact_edit');
    
        $id          = !empty($_GET['id']) ? intval($_GET['id']) : null;
    	$status		 = !empty($_GET['status']) ? intval($_GET['status']) : null;
    	$page		 = !empty($_GET['page']) ? intval($_GET['page']) : null;
    	$keywords	 = !empty($_GET['keywords']) ? trim($_GET['keywords']) : null;
    	$type 		 = !empty($_GET['type']) ? trim($_GET['type']) : null;
    	$feed_id 	 = !empty($_GET['feed_id']) ? trim($_GET['feed_id']) : null;
    	$refer       = !empty($_GET['refer']) ? trim($_GET['refer']) : null;
    	if (empty($id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户详情'), RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'contact', 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑联系记录')));
    	$this->assign('ur_here', __('编辑联系记录'));
    	
    	if ($refer == 'to_contact_record') {
    		$this->assign('action_link', array('text' => '返回联系记录列表', 'href' => RC_Uri::url('customer/admin_contact/init', array('status' => $status, 'page' => $page,'keywords'=>$keywords))));
    	} else {
    		$this->assign('action_link', array('text' => '返回客户详情', 'href' => RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'contact', 'page' => $page, 'status' => $status, 'keywords' => $keywords))));
    	}
    	
    	//获取联系方式，联系类型和客户类别列表
    	$this->assign('linkman_lists', get_linkman_list($id)); //读取当前客户下联系人
    	$this->assign('contact_way_list', get_contact_way_list());
    	$this->assign('contact_type_list', get_contact_type_list());
    	$this->assign('customer_type_list', get_customer_type_list());
    	/*获取当前客户4条联系记录*/
    	$this->assign('contact_record_list', get_contact_record_list($id));
    	/*获取客户联系记录信息*/
    	$contact_info = $this->db_customer_feedback_view->join(array('customer', 'admin_user', 'customer_contact_type', 'customer_contact_way', 'customer_linkman'))->field('cf.*,c.state_id,au.user_name as admin_name,ct.type_name,cw.way_name,cl.link_man_name,cl.mobile')
    	->where(array('cf.customer_id' => $id, 'cf.feed_id' => $feed_id))->find();
        if ($contact_info) {
    	    $contact_info['add_time'] = RC_Time::local_date('Y-m-d H:i', $contact_info['add_time']);
    	    $contact_info['next_time']= RC_Time::local_date('Y-m-d H:i', $contact_info['next_time']);
    	    $this->assign('contact_info', $contact_info);
    	    $cus_type = $contact_info['state_id'];
    	    $this->assign('cus_type', $cus_type);
    	}
    	/*参数分配*/
		$this->assign('id', $id);
		$this->assign('feed_id', $feed_id);
		$this->assign('page', $page);
		$this->assign('keywords', $keywords);
		$this->assign('type', $type);
		$this->assign('status', $status);
		$this->assign('refer', $refer);
    
    	/*获取客户名称*/
    	$cus_name = $this->db_customer->where(array('c.customer_id' => $id))->get_field('customer_name');
    	$this->assign('cus_name', $cus_name);
    	$this->assign('form_action', RC_Uri::url('customer/admin/contact_update'));
    	$this->display('contact_edit.dwt');
    }
    
    /**
     * 联系记录-编辑数据处理
     */
    public function contact_update() {
    	$refer 	 	 = (!empty($_POST['refer'])) ? trim($_POST['refer']) : '';
    	$feed_id 	 = (!empty($_POST['feed_id'])) ? intval($_POST['feed_id']) : '';
    	$customer_id = (!empty($_POST['customer_id'])) ? intval($_POST['customer_id']) : '';
    	$status		 = (!empty($_POST['statu'])) ? intval($_POST['statu']) : '';
    	$page		 = (!empty($_POST['page'])) ? intval($_POST['page']) : '';
    	$keywords	 = (!empty($_POST['keywords'])) ? trim($_POST['keywords']) : '';
    	$type 		 = (!empty($_POST['types'])) ? trim($_POST['types']) : '';
    	$customer_type_old 	= (!empty($_POST['cus_type'])) ? trim($_POST['cus_type']) : '';
    	/*联系记录表更新数据*/
    	$summary	  = (!empty($_POST['summary'])) ? trim($_POST['summary']) : '';
    	$next_time    = (!empty($_POST['next_time'])) ? RC_Time::local_strtotime($_POST['next_time']) : '';
    	$next_goal    = (!empty($_POST['next_goal'])) ? trim($_POST['next_goal']) : '';
    	$link_type    = (!empty($_POST['link_type'])) ? $_POST['link_type'] : '';
    	$link_man     = (!empty($_POST['link_man'])) ? intval($_POST['link_man']) : '';
    	$contact_way  = (!empty($_POST['contact_way'])) ? trim($_POST['contact_way']) : '';
    	$telphone     = (!empty($_POST['telphone'])) ? trim($_POST['telphone']) : '';
    	$contact_time = (!empty($_POST['contact_time'])) ?  RC_Time::local_strtotime($_POST['contact_time']) : '';
    	$add_time 	  = RC_Time::gmtime();
    	$adder        = (!empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '0';
    	/*客户表更新字段*/
    	$customer_type = (!empty($_POST['customer_type'])) ? $_POST['customer_type'] : '';
    	$data = array(
    			'customer_id' 	=> $customer_id,
    			'summary' 		=> $summary,
//     			'next_time' 	=> $next_time,
//     			'next_goal'		=> $next_goal,
    			'link_type' 	=> $link_type,
    			'link_man'  	=> $link_man,
    			'type'		 	=> $contact_way,
    			'telphone'		=> $telphone,
    			'add_time'		=> $contact_time,
    			'adder'			=> $adder
    	);
    	if(!empty($next_time) && !empty($next_goal)) {
    		$data['next_time'] = $next_time;
    		$data['next_goal'] = $next_goal;
    	}
    	$update_feedback = $this->db_customer_feedback->where(array('feed_id' => $feed_id))->update($data);
    	if($update_feedback) {
    		$this->db_customer->where(array('customer_id' => $customer_id))->update(array('last_contact_time' => $add_time, 'reservation_time' => $next_time));
    	}
    	if(!empty($customer_type) && $customer_type != $customer_type_old) {
    		$this->db_customer->where(array('customer_id' => $customer_id))->update(array('state_id' => $customer_type));
    	}
    	if($update_feedback){
    		//log
    		$cus_name = $this->db_customer->where(array('c.customer_id' => $customer_id))->get_field('customer_name');
    		$new_summary = RC_String::sub_str($summary, '10');
    		$cus_name_new= $new_summary.'【'.$cus_name.'】';
    		ecjia_admin_log::instance()->add_object('contact_record', '联系记录');
    		ecjia_admin::admin_log($cus_name_new,'edit','contact_record');
    		if($refer) {
    			$this->showmessage('编辑联系记录成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin_contact/init')));
    		} else {
    			$this->showmessage('编辑联系记录成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/detail', array('id' => $customer_id, 'type' => $type, 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    		}
    	} else {
    		$this->showmessage('编辑联系记录失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 删除某条客户联系记录
     */
    public function contact_remove() {
        //删除客户联系记录权限
        $this->admin_priv('customer_contact_del');
        $info = $this->db_customer_feedback_view->join(array('customer'))->field('c.customer_name, cf.summary')->where(array('cf.feed_id' => $_GET['feed_id'], 'cf.customer_id' => $_GET['id']))->find();
        
        $feed_id 	 = !empty($_GET['feed_id']) ? ($_GET['feed_id']) : null;
        if (empty($feed_id)) {
            $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $delete = $this->db_customer_feedback->where(array('feed_id' => $feed_id))->delete();
        if ($delete) {
            //log
            $summary = RC_String::sub_str($info['summary'], '10');
            $name = $summary.'【'.$info['customer_name'].'】';
    
            ecjia_admin_log::instance()->add_object('contact_record', '联系记录');
            ecjia_admin::admin_log($name,'remove','contact_record');
    
            $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            $this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
    /**
     * 客户-合同文档-添加
     */
    public function files_add() {
        /*权限 */
        $this->admin_priv('customer_files_add');
        
        $id          = (!empty($_GET['id'])) ? intval($_GET['id']) : '';
        $status		 = (!empty($_GET['status'])) ? intval($_GET['status']) : '';
        $page		 = (!empty($_GET['page'])) ? intval($_GET['page']) : '';
        $keywords	 = (!empty($_GET['keywords'])) ? trim($_GET['keywords']) : '';
        $type 		 = (!empty($_GET['type'])) ? trim($_GET['type']) : '';
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户详情'), RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'files', 'page' => $page, 'status' => $status, 'keywords' => $keywords))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加文档')));
        $this->assign('ur_here', __('添加文档'));
        $this->assign('action_link', array('text' => '返回客户详情', 'href' => RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => 'files', 'page' => $page, 'status' => $status, 'keywords' => $keywords))));
        
        $this->assign('keywords', $keywords);
        $this->assign('type', $type);
        $this->assign('page', $page);
        $this->assign('status', $status);
        $this->assign('id', $id);
        
        //加载配置中分类数据
        $doc_category_list = RC_Loader::load_app_config('customer_contract_doc_type', 'customer');
        $this->assign('doc_category_list', $doc_category_list);
        
        $this->assign('form_action', RC_Uri::url('customer/admin/files_insert'));
        $this->display('files_edit.dwt');
    }
    
    /**
     * 客户-合同文档-添加数据处理
     */
    public function files_insert() {
    	$customer_id = (!empty($_POST['id'])) ? intval($_POST['id']) : '';
    	if (empty($customer_id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$status		 = (!empty($_POST['statu'])) ? intval($_POST['statu']) : '';
    	$page		 = (!empty($_POST['page'])) ? intval($_POST['page']) : '';
    	$keywords	 = (!empty($_POST['keywords'])) ? trim($_POST['keywords']) : '';
    	$type 		 = (!empty($_POST['types'])) ? trim($_POST['types']) : '';
    	
    	/*合同文档表数据更新*/
    	$doc_name	    	= (!empty($_POST['doc_name'])) ? trim($_POST['doc_name']) : '';
    	$doc_category	    = (!empty($_POST['doc_category'])) ? $_POST['doc_category'] : '';
    	$doc_summary	  	= (!empty($_POST['doc_summary'])) ? trim($_POST['doc_summary']) : '';
    	
    	$is_only = $this->db_customer_contract->where(array('doc_name' => $doc_name))->count();
    	if ($is_only > 0) {
    		$this->showmessage('此文档名称已存在', stripslashes($doc_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
    	} else {
    		//获取上传文件的信息
    		$file = !empty($_FILES['file']) ? $_FILES['file'] : null;
    		
    		if(empty($file)) {
    			$this->showmessage('上传文件不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		/*判断用户是否选择了文件*/
    		if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
    			/*判断上传类型*/
    			$extname = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
    			//目前限制只能上传文件
    			if(strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname)){
    				$upload = RC_Upload::uploader('file', array('save_path' => 'data/customer', 'auto_sub_dirs' => true));
    				$file_info = $upload->upload($file);
    				/* 判断是否上传成功 */
    				if (!empty($file_info)) {
    					$file_name = $file_info['savepath'] . '/' . $file_info['savename'];
    				} else {
    					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    			}else {
    				$upload = RC_Upload::uploader('image', array('save_path' => 'data/customer', 'auto_sub_dirs' => true));
    				$image_info = $upload->upload($file);
    				/* 判断是否上传成功 */
    				if (!empty($image_info)) {
    					$file_name = $image_info['savepath'] . '/' . $image_info['savename'];
    				} else {
    					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    					
    			}
    		}
    	
    		$extname = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
    			
    		$add_time = RC_Time::gmtime();
    		$adder	  = $_SESSION['admin_id'];
    		$data = array(
    				'customer_id'  => $customer_id,
    				'doc_name'     => $doc_name,
    				'doc_category' => $doc_category,
    				'doc_path' 	   => $file_name,
    				'doc_summary'  => $doc_summary,
    				'add_time'     => $add_time,
    				'adder'        => $adder,
    				'is_lock'      => 0,
    				'is_delete'    => 0,
    		);
    		$doc_id = $this->db_customer_contract->insert($data);
    		if($doc_id){
    			//log
    			$cus_name = $this->db_customer->where(array('c.customer_id' => $customer_id))->get_field('customer_name');
    			$cus_name_new = $doc_name.'【'.$cus_name.'】';
    			ecjia_admin_log::instance()->add_object('contract_doc', '合同文档');
    			ecjia_admin::admin_log($cus_name_new,'add','contract_doc');
    			$this->showmessage('添加文档成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/detail', array('id' => $customer_id, 'type' => $type, 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    		}else{
    			$this->showmessage('添加文档失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}	
    	}
    }
	
    /**
     * 合同文档-编辑
     */
    public function files_edit() {
    	/*权限 */
    	$this->admin_priv('customer_files_edit');
    
    	$id          = (!empty($_GET['id'])) ? intval($_GET['id']) : '';
    	if (empty($id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$status		 = (!empty($_GET['status'])) ? intval($_GET['status']) : '';
    	$page		 = (!empty($_GET['page'])) ? intval($_GET['page']) : '';
    	$keywords	 = (!empty($_GET['keywords'])) ? trim($_GET['keywords']) : '';
    	$type 		 = (!empty($_GET['type'])) ? trim($_GET['type']) : '';
    	$doc_id 	 = (!empty($_GET['doc_id'])) ? trim($_GET['doc_id']) : '';
    	 
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客户详情'), RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => $type, 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑合同文档')));
    	$this->assign('ur_here', __('编辑合同文档'));
    	$this->assign('action_link', array('text' => '返回客户详情', 'href' => RC_Uri::url('customer/admin/detail', array('id' => $id, 'type' => $type, 'page' => $page, 'status' => $status, 'keywords' => $keywords))));
    	 //加载配置中分类数据
        $doc_category_list = RC_Loader::load_app_config('customer_contract_doc_type', 'customer');
        $this->assign('doc_category_list', $doc_category_list);
        
    	/*获取客户联系记录信息*/
    	$doc_info = $this->db_view->join(array('admin_user', 'customer_contract_doc'))->field('cd.*,au.user_name as admin_name')
    	->where(array('c.customer_id' => $id, 'cd.doc_id' => $doc_id))->find();
    	
    	$extname = strtolower(substr($doc_info['doc_path'], strrpos($doc_info['doc_path'], '.') + 1));
    	if ($doc_info['doc_path']) {
    		if (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'),$extname)) {
    			$doc_info['image_url'] = RC_Uri::admin_url('statics/images/ecjiafile.png');
    		} else {
    			$doc_info['image_url'] = RC_Upload::upload_url($doc_info['doc_path']);
    		}
    	}
    	
    	$add_time = RC_Time::local_date('Y-m-d H:i', $doc_info['add_time']);
    	/*参数分配*/
    	$this->assign('id', $id);
    	$this->assign('doc_id', $doc_id);
    	$this->assign('page', $page);
    	$this->assign('keywords', $keywords);
    	$this->assign('type', $type);
    	$this->assign('status', $status);
    	/*获取客户名称*/
    	$cus_name = $this->db_customer->where(array('c.customer_id' => $id))->get_field('customer_name');
    	$this->assign('cus_name', $cus_name);
    	$this->assign('add_time', $add_time);
    	$this->assign('doc_info', $doc_info);
    	$this->assign('form_action', RC_Uri::url('customer/admin/files_update'));
    	$this->display('files_edit.dwt');
    }
    
    /**
     * 合同文档-编辑数据处理
     */
    public function files_update() {
    	$doc_id 	 = (!empty($_POST['doc_id'])) ? intval($_POST['doc_id']) : '';
    	if (empty($doc_id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$customer_id = (!empty($_POST['id'])) ? intval($_POST['id']) : '';
    	$status		 = (!empty($_POST['statu'])) ? intval($_POST['statu']) : '';
    	$page		 = (!empty($_POST['page'])) ? intval($_POST['page']) : '';
    	$keywords	 = (!empty($_POST['keywords'])) ? trim($_POST['keywords']) : '';
    	$type 		 = (!empty($_POST['types'])) ? trim($_POST['types']) : '';
    	
    	/*合同文档表数据更新*/
    	$doc_name	    	= (!empty($_POST['doc_name'])) ? trim($_POST['doc_name']) : '';
    	$doc_category	    = (!empty($_POST['doc_category'])) ? $_POST['doc_category'] : '';
    	$doc_summary	  	= (!empty($_POST['doc_summary'])) ? trim($_POST['doc_summary']) : '';
    	
    	$is_only = $this->db_customer_contract->where(array('doc_name' => $doc_name, 'doc_id' => array('neq' => $doc_id)))->count();
    	if ($is_only != 0) {
    		$this->showmessage('此文档名称已存在', $doc_name, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	} else {
    		$file_name = (!empty($_POST['file_name'])) ? trim($_POST['file_name']) : '';
    		if(empty($file_name)){
    			//获取上传文件的信息
    			$file = !empty($_FILES['file']) ? $_FILES['file'] : null;
    			if(empty($file)){
    				$this->showmessage('上传文件不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    			//判断用户是否选择了文件
    			if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
    				/*判断上传类型*/
    				$extname = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
//     				$dir = date("Ym", time());
    				//目前限制只能上传文件
    				if(strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'),$extname)){
    					$upload = RC_Upload::uploader('file', array('save_path' => 'data/customer', 'auto_sub_dirs' => true));
    					$file_info = $upload->upload($file);
    					/* 判断是否上传成功 */
    					if (!empty($file_info)) {
    						$file_name = $file_info['savepath'] . '/' . $file_info['savename'];
    					} else {
    						$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    					}
    				} else {
    					$upload = RC_Upload::uploader('image', array('save_path' => 'data/customer', 'auto_sub_dirs' => true));
    					$image_info = $upload->upload($file);
    					/* 判断是否上传成功 */
    					if (!empty($image_info)) {
    						$file_name = $image_info['savepath'] . '/' . $image_info['savename'];
    					} else {
    						$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    					}
    						
    				}
    			}
    		}
    		$extname = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
    		$adder	  = $_SESSION['admin_id'];
    		$data = array(
    				'customer_id'  => $customer_id,
    				'doc_name'     => $doc_name,
    				'doc_category' => $doc_category,
    				'doc_path' 	   => $file_name,
    				'doc_summary'  => $doc_summary,
    				'adder'        => $adder,
    				'is_lock'      => 0,
    				'is_delete'    => 0,
    		);
    		$update = $this->db_customer_contract->where(array('doc_id' => $doc_id, 'customer_id' => $customer_id))->update($data);
    		if($update){
    			//log
    			$cus_name = $this->db_customer->where(array('c.customer_id' => $customer_id))->get_field('customer_name');
    			$cus_name_new = $doc_name.'【'.$cus_name.'】';
    			ecjia_admin_log::instance()->add_object('contract_doc', '合同文档');
    			ecjia_admin::admin_log($cus_name_new, 'edit', 'contract_doc');
    			$this->showmessage('编辑文档成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/detail', array('id' => $customer_id, 'type' => $type, 'page' => $page, 'keywords' => $keywords, 'status' => $status))));
    		} else {
    			$this->showmessage('编辑文档失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}	
    	}
    }
    
    /**
     * 删除某个客户的某条合同文档
     */
    public function files_remove() {
    	//删除客户合同文档权限
    	$this->admin_priv('customer_files_del');
    	$doc_name = (!empty($_GET['doc_name'])) ? trim($_GET['doc_name']) : '';
    	$id       = (!empty($_GET['id'])) ? intval($_GET['id']) : '';
    	$doc_id   = (!empty($_GET['doc_id'])) ? intval($_GET['doc_id']) : '';
    	$old_url = $this->db_customer_contract->where(array('doc_id' => $doc_id))->get_field('doc_path');
    	$uploads_dir_info    = RC_Upload::upload_dir();
    	@unlink($uploads_dir_info['basedir'].'/'. $old_url);
    	
    	$delete = $this->db_customer_contract->where(array('doc_id' => $doc_id, 'customer_id' => $id ))->delete();
    	if ($delete) {
    		//log
    		$cus_name = $this->db_customer->where(array('c.customer_id' => $id))->get_field('customer_name');
    		$cus_name_new = $doc_name.'【'.$cus_name.'】';
    		ecjia_admin_log::instance()->add_object('contract_doc', '合同文档');
    		ecjia_admin::admin_log($cus_name_new,'remove','contract_doc');
    
    		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    	} else {
    		$this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 删除附件
     */
    public function files_delfile() {
    	$customer_id = (!empty($_GET['customer_id'])) ? intval($_GET['customer_id']) : '';
    	$id = (!empty($_GET['id'])) ? intval($_GET['id']) : '';
    	if (empty($customer_id) || empty($id)) {
    	    $this->showmessage('参数不完整', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$old_url = $this->db_customer_contract->where(array('doc_id' => $id))->get_field('doc_path');
    	$uploads_dir_info    = RC_Upload::upload_dir();
    	@unlink($uploads_dir_info['basedir'].'/'. $old_url);
    	$this->db_customer_contract->where(array('doc_id' => $id))->update(array('doc_path' => ''));
    
    	$this->showmessage('删除附件成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    /**
     * 批量操作
     */
    public function batch() {
        /* 客户批量权限 */
        //根据状态区分权限
        $status = empty($_GET['status']) ? '1' : $_GET['status'];
        
        $page = !empty($_GET['page']) ? $_GET['page'] : null;
        $menu = !empty($_GET['menu']) ? $_GET['menu'] : null;
        $keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : null;
        $customer_type = !empty($_GET['type_customer']) ? $_GET['type_customer'] : null;
        $customer_source = !empty($_GET['source_customer']) ? $_GET['source_customer'] : null;
        $type = !empty($_GET['type']) ? $_GET['type'] : null;
        if (!empty($type) && !empty($_POST['checkboxes'])) {
            if ($type == 'change_source') {
                $this->admin_priv('customer_source_update_batch');
				$source_id = !empty($_GET['customer_source']) ? $_GET['customer_source'] : null;
                if (empty($source_id)) {
                	$this->showmessage('请选择要修改的客户来源', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $data = array(
                    'source_id' => $source_id,
                );
                $this->db_customer->in(array('customer_id' => $_POST['checkboxes']))->update($data);
                //log
                $this->add_admin_log('batch_update', '', $_POST['checkboxes'], '', '');
                
                $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page, 'keywords' => $keywords, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu))));
            } elseif ($type == 'change_type') {
                $this->admin_priv('customer_type_update_batch');
            	$state_id = !empty($_GET['customer_type']) ? $_GET['customer_type'] : null;
            	if(empty($state_id)){
            		$this->showmessage('请选择要修改的客户类别', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	}
            	$data = array(
                    'state_id' => $state_id,
                );
                $this->db_customer->in(array('customer_id' => $_POST['checkboxes']))->update($data);
                //log
                $this->add_admin_log('batch_update_type', '', $_POST['checkboxes'], '', '');
                $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page, 'keywords' => $keywords, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu))));
            } elseif ($type == 'button_assign_customer') {
                $this->admin_priv('customer_assign_batch');
            	$charge_man = !empty($_GET['customer_assign']) ? $_GET['customer_assign'] : null;
            	if(empty($charge_man)){
            		$this->showmessage('请选择要指派的管理员', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	}
            	$ids = $_POST['checkboxes'];
            	$customer_info = $this->db_customer->in(array('customer_id' => $_POST['checkboxes']))->select();
                foreach ($customer_info as $val) {
                    $distibute[] = array (
                        'customer_id'       => $val['customer_id'],
                        'original_charge_man'=> $val['charge_man'],
                        'new_charge_man'    => $charge_man,
                        'reason'            => !empty($_GET['reason']) ? $_GET['reason'] : null,
                        'is_delete'         => '0',
                        'operator'          => $_SESSION['admin_id'],
                        'operate_time'      => RC_Time::gmtime(),
                    );
                    $ids_new = $val['customer_id'];
                    $customer_url = RC_Uri::url('customer/admin/detail', array('id' => $ids_new));
                    $cus_names[] = '<a href='.$customer_url.' target="_blank">'.$val['customer_name'].'</a>';
                }
                
                $cus_names_new = implode('，', $cus_names);
                $this->db_customer_distribute->batch_insert($distibute);
                $data = array(
                    'charge_man' => $charge_man,
                );
                $this->db_customer->in(array('customer_id' => $ids))->update($data);
                //发邮件和记log用
                $userinfo = $this->db_admin_user->where(array('user_id' => $charge_man))->field('user_name, email')->select();
                $user_name = $userinfo[0]['user_name'];
                //发送邮件
                if (!empty($_GET['send_email'])) {
                	//提交日期
//                 	$customer_url = RC_Config::system('CUSTOM_MAIN_SITE_URL')."/index.php?m=customer&c=admin&a=detail&id='.$ids_new.'";
                
                	$this->assign('send_date', RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()));
                    $this->assign('user_name', $userinfo[0]['user_name']);
                    $this->assign('admin_name', $_SESSION['admin_name']);
                    $this->assign('customer_name', $cus_names_new);
                    $this->assign('reason', !empty($_GET['reason']) ? $_GET['reason'] : null);
                    $this->assign('customer_url', $customer_url);
                	
                	$email = $userinfo[0]['email'];
                	$tpl_name = 'customer_assign';
                	$template   = RC_Api::api('mail', 'mail_template', $tpl_name);
                	$content = $this->fetch_string($template['template_content']);
                	/* 发送邮件 */
                	RC_Mail::send_mail($user_name, $email, $template['template_subject'], $content,$template['is_html']);
                }
                //log
             	
             	$this->add_admin_log('batch_assign', '', $_POST['checkboxes'], '', '', '，指派给：'.$user_name.'');
             	$refer = !empty($_GET['refer']) ? $_GET['refer'] : null;
             	if($refer == 'public') {
             	    $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/public_list', array('status' => $status, 'page' => $page))));
             	} else {
             	    $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page, 'keywords' => $keywords, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu))));
             	}
            } elseif ($type == 'button_quit') {
                $this->admin_priv('customer_quit_batch');
            	$charge_man = '0';
            	$data = array(
                    'charge_man' => $charge_man,
                );
                $this->db_customer->in(array('customer_id' => $_POST['checkboxes']))->update($data);
             //log
                $this->add_admin_log('batch_quit', '', $_POST['checkboxes'], '', '');
                $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page, 'keywords' => $keywords, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu))));
            } elseif ($type == 'button_share_customer') {
                $this->admin_priv('customer_share_batch');
            	$customer_id = !empty($_GET['customer_id']) ? $_GET['customer_id'] : null;
            	$customer_ids = $_POST['checkboxes'];
            	$admin_ids = !empty($_GET['share']) ? $_GET['share'] : null;
            	if(empty($admin_ids)) {
            		$this->showmessage('请选择要分享的管理员', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            	}
            	if (strpos($customer_ids, ",")) {
                    $customer_ids_new = explode(',', $customer_ids);
                } else {
                    $customer_ids_new = $_POST['checkboxes'];
                }
                if (strpos($admin_ids, ",")) {
                    $admin_ids_new = explode(',', $admin_ids);
                } else {
                    $admin_ids_new = !empty($_GET['share']) ? $_GET['share'] : null;
                }
            	
            	if (is_array($customer_ids_new)) {
            		/*多条数据分享给多个人*/
            		if(is_array($customer_ids_new) && is_array($admin_ids_new)) {
            			foreach($customer_ids_new as $val) {
            				foreach($admin_ids_new as $v) {
            					$data = array(
            							'customer_id' => $val,
            							'admin_id'    => $v,
            							'sharer'	  => $_SESSION['admin_id'],
            							'share_time'  => RC_Time::gmtime(),
            					);
            					$result = $this->db_customer_share->insert($data);
            				}
            			}
            		} else {
            			/*多条数据分享给一个人*/
            			foreach($customer_ids_new as $val) {
            				$data = array(
            						'customer_id' => $val,
            						'admin_id'    => $admin_ids_new,
            						'sharer'	  => $_SESSION['admin_id'],
            						'share_time'  => RC_Time::gmtime(),
            				);
            				$result = $this->db_customer_share->insert($data);
            			}
            		}
            	} else {
            		if(is_array($admin_ids_new)) {
            			/*一条数据分享给多个人*/
            			foreach($admin_ids_new as $val) {
            				$data = array(
            						'customer_id' => $customer_ids_new,
            						'admin_id'    => $val,
            						'sharer'	  => $_SESSION['admin_id'],
            						'share_time'  => RC_Time::gmtime(),
            				);
            				$result = $this->db_customer_share->insert($data);
            			}	
            		} else {
            			/*一条数据分享给一个人*/
            			$data = array(
		                    'customer_id' => $customer_ids_new,
		            		'admin_id'    => $admin_ids_new,
		            		'sharer'	  => $_SESSION['admin_id'],
		            		'share_time'  => RC_Time::gmtime(),
               		 	);
            			$result = $this->db_customer_share->insert($data);
            		}
            	}
             	//log
                $this->add_admin_log('batch_share', '', $_POST['checkboxes'], '', '');
                $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page, 'keywords' => $keywords, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu))));
            } elseif ($type == 'button_remove') {
                $this->admin_priv('customer_del_batch');
            	$is_delete = '1';
            	$data = array(
                    'is_delete' => $is_delete,
                );
                $this->db_customer->in(array('customer_id' => $_POST['checkboxes']))->update($data);
             //log
                $this->add_admin_log('batch_remove', '', $_POST['checkboxes']);
                $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page, 'keywords' => $keywords, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu))));
            } elseif ($type == 'button_reback') {
                $this->admin_priv('customer_reback');
                $ids = $_POST['checkboxes'];
            	/*user_id存在且不冲突*/
            	$data = array(
            			'is_delete' => '0'
            	);
            	/*查询出客户id是$ids的用户id，用户名*/
            	$user=$this->db_customer->field('user_id,customer_name')->in(array('customer_id' => $ids))->select();
				foreach ($user as $val){
					$user_id_new[] = $val['user_id'];
					$customer_name_new[] = $val['customer_name'];
				}
				$customer_name_news = implode('，', $customer_name_new);
            	
            	if(!empty($user) && !in_array('0', $user_id_new)){
            		/*user_id存在且冲突*/
            		$countrecord=$this->db_customer->where(array('user_id'=>$user_id_new,'customer_id'=>array('neq'=>$ids),'is_delete'=>array('neq'=>1)))->select();
					foreach($countrecord as $val) {
						$customer_name[] = $val['customer_name'];
					}
					$customer_names = implode('，', $customer_name);

            		if(!empty($countrecord)){
            			$userinfo=array(
            					'user_id'=>0,
            					'is_delete' => '0'
            			);
            			$this->db_customer->in(array('customer_id'=>$ids))->update($userinfo);
            			$this->showmessage('操作成功，当前所还原的客户['.$customer_name_news.']绑定的用户已被['.$customer_names.']绑定，请重新绑定', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page, 'keywords' => $keywords, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu))));
            		}
            	} else {
            		/*user_id为null或0*/
            		$data = array(
            				'is_delete' => '0'
            		);
            	}
            	if($ids){
            		$this->db_customer->in(array('customer_id' => $ids))->update($data);
            	}
             	//log
                $this->add_admin_log('batch_restore', '', $_POST['checkboxes']);
                $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page, 'keywords' => $keywords, 'type_customer' => $customer_type, 'source_customer' => $customer_source, 'menu' => $menu))));
            }else {
                $this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('customer/admin/init')));
            }
        } else {
            $this->showmessage('请选择要操作的客户', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 绑定营销顾问页面
     */
    public function binding_adviser() {
    	/* 绑定营销顾问权限 */
    	$this->admin_priv('binding_adviser');
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('绑定/更换营销顾问')));
    	$this->assign('ur_here', __('绑定/更换营销顾问'));
    	$page = intval($_GET['page']);
    	$status = intval($_GET['status']);
    	$customer_id = $_GET['id'];
    	$this->assign('action_link', array('text' => '返回客户列表', 'href' => RC_Uri::url('customer/admin/init', array('status' => $status, 'page' => $page))));
    	$this->assign('form_action', RC_Uri::url('customer/admin/binding'));
    	
    	$id = intval($_GET['user_id']);
    	if(empty($id)){
    	    $this->showmessage('请选择你要操作的客户，或未绑定！', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
    	}
    	if(!empty($id)) {
    		$adviser = $this->db_view->field(array('u.email','user_name','ad.email as ad_email','username as ad_name','ad.id as ad_id','c.customer_name as c_name','c.email as c_email'))->join(array('adviser','users'))->where(array('u.user_id' => $id))->find();
    		//停用
//     		if($adviser['adviser_id'] !=0) {
//     			$this->showmessage('该用户已绑定营销顾问！', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
//     		}
    	}
    	$this->assign('user_id',$id);
    	$this->assign('customer_id',$customer_id);
    	$this->assign('adviser',$adviser);
    	$this->assign('page',$page);
    	$this->assign('status',$status);
    	$this->display('bind_adviser.dwt');
    }
    /**
     * 根据客户邮箱手机号查询客户
     */
    public function query_customer_info() {
        $keywords = trim($_POST['keyword_customer']);
        $page     = $_POST['page'];
        $status   = $_POST['status'];

        $info = $this->db_customer->where("(email = '".$keywords."' or mobile = '".$keywords."' or customer_name = '".$keywords."')")->field(array('customer_id','user_id'))->find();
        if (!empty($info)) {
            $url = RC_Uri::url("customer/admin/binding_adviser", array('id' => $info['customer_id'], 'user_id' => $info['user_id'], 'page' =>$page, 'status' => $status));
            $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } else {
            $this->showmessage('客户不存在请重新搜索！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    /**
     * 绑定营销顾问
     */
    public function binding() {
        $user_id 		= $_POST['user_id'];
        $adviser_id 	= $_POST['adviser_id'];
        $customer_id 	= $_POST['customer_id'];
        $page 			= $_POST['page'];
        $status 		= $_POST['status'];
        $data = array(
        		'adviser_id' => $adviser_id,
        );
        if($user_id != 0 && $adviser_id !=0) {
        	$update_user = $this->db_users->where(array('user_id' => $user_id))->update($data);
        	if($update_user){
        	    //log
        	    ecjia_admin_log::instance()->add_object('member', '会员');
            	$log_text = '';
            	if(!empty($user_id)){
            	    $user = $this->db_usersview->join('adviser')->field('user_name,ad.username')->find('user_id='.$user_id);
            	    $log_text = '，顾问是'.$user['username'];
            	}
            	ecjia_admin::admin_log($user['user_name'].$log_text,'edit','member');
        		$this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('customer/admin/binding_adviser', array('id' => $customer_id, 'page' =>$page, 'status' => $status, 'user_id' => $user_id))));
        	}
        }
    }
    /**
     * 绑定顾问页面中，增加搜索营销顾问
     */
    public function search_adviser() {
    	$user_name = (!empty($_POST['keywords'])) ? trim($_POST['keywords']) : '';
    	$result = array();
    	if (!empty($user_name)) {
    		$data = $this->db_adviser->field('id,email,username,qq,tel')->where("username like '%". $user_name . "%'")->select();
    	}
    	foreach ($data as $key => $row) {
    		array_push($result, array('value' =>$row['id'],'email'=>$row['email'],'username'=>$row['username'],'qq'=>$row['qq'],'tel'=>$row['tel'],'text' =>$row['username']."  ".'('.$row['email'].')'));
    	}
    	$this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('user' => $result));
    }
    
    /**
     * excel导入
     */
    public function excel_upload() {
        /* 权限  */
        $this->admin_priv('customer_excel_upload');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('从EXCEL导入客户资料')));
        $this->assign('ur_here', __('从EXCEL导入客户资料'));
        $this->assign('form_action', RC_Uri::url('customer/admin/excel_upload_do'));
        $this->assign('download_url', RC_App::apps_url('statics/files/customer.xls', __FILE__));
         
        $this->display('excel_upload.dwt');
    }
    /* 部分客户资料，省市区未处理
     * 成功提示，未处理
     * 未验证联系电话重复
     * 导入客户 未创建对应联系人
     * 如要完善，要修改批量操作为逐条插入。
     *  */
    public function excel_upload_do() {
        /* 权限  */
        $this->admin_priv('customer_excel_upload');
        //获取上传文件的信息
        $file = $_FILES['file'];
        //判断用户是否选择了文件
        if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
            /*判断上传类型*/
            $extname = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
            //目前限制只能上传文件
            if(strrpos('xls', $extname) !== false) {
                $file_name = $file['tmp_name'];
            } else {
                $this->showmessage('文件格式不合法', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            //excel导入
            $data_excel = excel_to_array($file_name);
            $customer_arr = change_key($data_excel);
            if ($customer_arr) {
                foreach ($customer_arr as $val) {
                    //部分客户资料  未处理
                    $insert_id = $this->db_customer->insert($val);
                    //导入联系人
                    if ($insert_id) {
                        $data = array(
                            'customer_id' => $insert_id,
                            'link_man_name' => $val['link_man'],
                            'sex' => $val['sex'],
                            'telphone' => $val['telphone1'],
                            'mobile' => $val['mobile'],
                            'email' => $val['email'],
                            'qq' => $val['qq'],
                            'adder' => $val['adder'],
                            'add_time' => $val['add_time'],
                        
                        );
                        $this->db_customer_linkman->insert($data);
                        $this->add_admin_log('import', 'excel导入：'.$val['link_man']);
                    }
                }
                if($insert_id) {
                    $this->showmessage('导入成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
                } else {
                    $this->showmessage('导入失败请重试', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $this->showmessage('文件数据有误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $this->showmessage('请上传excel文件', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    /**
     * 客户池回收
     * 条件：开启回收，超过回收时间未联系
     */
    public function update_pool()
    {
        if (ecjia::config('customer_pool_isopen') == '1') {

            /* 非公共客户，未删除 客户 */
            $where = array(
                'is_delete' => 0,
                'charge_man' => array('gt' => 0),
            );
            $customer_list = $this->db_customer->where($where)->select();
            $pool_range = explode(',', ecjia::config('customer_pool_range'));
            $time = RC_Time::gmtime();
            if ($customer_list) {
                foreach ($customer_list as $val) {
                    //判断回收范围
                    if (in_array($val['state_id'], $pool_range)) {
                        //判断时间
                        $pool_info = $this->db_customer_pool->where(array('customer_id' => $val['customer_id'], 'operate_type' => '3'))->order('operate_time DESC')->find();
                        if (empty($val['last_contact_time']) || $pool_info['operate_time'] > $val['last_contact_time']) {
                            $start_time = empty($pool_info['operate_time']) ? $val['add_time'] : $pool_info['operate_time'];
                        } else {
                            $start_time = $val['last_contact_time'];
                        }
                        if ($time - $start_time > ecjia::config('customer_pool_period') * 86400) {
                            // 回收
                            // 如未联系，最后一次联系时间为空。需判断领用时间
                            // 客户领用后是否清空，最后联系时间和预约时间。不清空，判断领用时间是否大于联系时间
                            $this->add_admin_log('edit', '系统自动回收');
                            $this->db_customer->where(array('customer_id' => $val['customer_id']))->update( array('charge_man' => '', 'update_time' => $time));
                            $data = array(
                                'customer_id'    => $val['customer_id'],
                                'operate_type'   => '2',
                                'operate'        => '0',
                                'operate_time'   => $time,
                            );
                            $this->db_customer_pool->insert($data);
                        }
                    }
                }
            }
        }
    }
    /**
     * 获取客户列表
     */
    private function get_list() {
        $filter['keywords'] = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
//      $filter['customer_fields'] = isset($_GET['customer_fields']) ? trim($_GET['customer_fields']) : '';
        $filter['type_customer'] = isset($_GET['type_customer']) ? intval($_GET['type_customer']) : '';
        $filter['source_customer'] = isset($_GET['source_customer']) ? intval($_GET['source_customer']) : '';
        $filter['status']   = isset($_GET['status']) ? $_GET['status'] : '1';
        $filter['view']   = isset($_GET['view']) ? $_GET['view'] : '';
        $filter['menu']   = isset($_GET['menu']) ? $_GET['menu'] : '';
        
        $charge_man_id = $_SESSION['admin_id'];
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
        if(!empty($filter['source_customer'])) {
        	$where['c.source_id'] = $filter['source_customer'];
        }
        /*视图*/
        if(!empty($filter['view'])) {
        	if ($filter['view'] == '1') {
                $start_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', RC_time::gmtime()));
                $end_date = $start_date + (24 * 60 * 60 - 1);
        		$where['c.add_time'] = array('egt' => $start_date, 'elt' => $end_date);
        	} elseif ($filter['view'] == '2') {
                $end_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', RC_time::gmtime())) - 1;
                $start_date = $end_date - (24 * 60 * 60 - 1);
        		$where['c.add_time'] = array('egt' => $start_date, 'elt' => $end_date);
        	} elseif ($filter['view'] == '3') {
                $end_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', RC_time::gmtime())) + (24 * 60 * 60 - 1);
                $start_date = $end_date - (7 * 24 * 60 * 60) + 1;
        		$where['c.add_time'] = array('egt' => $start_date, 'elt' => $end_date);
        	} elseif ($filter['view'] == '4') {
                $end_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', RC_time::gmtime())) + (24 * 60 * 60 - 1);
                $start_date = $end_date - (7 * 24 * 60 * 60) + 1;
        		$where['c.last_contact_time'] = array('egt' => $start_date, 'elt' => $end_date);
        	} elseif ($filter['view'] == '5') {
                $end_date = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', RC_time::gmtime())) + (24 * 60 * 60 - 1);
                $start_date = $end_date - (15 * 24 * 60 * 60) + 1;
        		$where['c.last_contact_time'] = array('egt' => $start_date, 'elt' => $end_date);
        	}
        }
        
        /*时间排序参数*/
        $filter['sort_by']      = !empty($_GET['sort_by']) ? safe_replace($_GET['sort_by']) : 'last_contact_time';
        $filter['sort_order']   = !empty($_GET['sort_order']) ? safe_replace($_GET['sort_order']) : 'DESC';
        
        RC_Loader::load_sys_class('ecjia_page', false);
		//即将回收
        $time = RC_Time::gmtime();
        $back_time = $time - ecjia::config('customer_pool_period') * 86400;
        
        $countw = $this->db_customer->field("SUM(c.is_delete =0) AS whole")->where($where)->select();
        $countm = $this->db_customer->field("SUM(c.charge_man =$charge_man_id) AS count_mine")->where($where)->select();
        $countb = $this->db_customer->field("SUM(c.charge_man =$charge_man_id AND c.last_contact_time < $back_time ) AS count_back")->where($where)->select();
      	
        /*状态为-2时查询数量条件参数处理*/
        $result = $this->db_customer_pool->where(array('operate_type' => '3', 'operateor' => $_SESSION['admin_id']))->group('customer_id')->order(array('operate_time' => 'desc'))->select();
        foreach($result as $k => $v) {
        	$ids[] = $v['customer_id'];
        }
        //$ids_new = implode(',', $ids);
        $where['c.customer_id'] = $ids;
        $countr = $this->db_customer->field("SUM(c.charge_man =$charge_man_id) AS count_my_recipients")->where($where)->select();
		/*回收站数量查询，条件拼接*/
        unset($where['c.is_delete']);
        unset($where['c.customer_id']);
        $where['c.is_delete'] = '1';
		if($filter['menu'] == 'all'){
			$count_transhed = $this->db_customer->field("SUM(c.is_delete =1) AS throwed")->where($where)->select();
		}else{
			$count_transhed = $this->db_customer->field("SUM(c.charge_man =$charge_man_id) AS throwed")->where($where)->select();
		}
        
		$filter['count_w'] = $countw[0];
        $filter['count_m'] = $countm[0];
        $filter['count_r'] = $countr[0];
        $filter['count_b'] = $countb[0];
        $filter['count_t'] = $count_transhed[0];
        
        /*条件重新赋值*/
        $where['c.is_delete'] = '0';
//         $where['c.customer_id'] = $ids;
		/*全部客户权限*/
        if ($filter['menu'] == 'all') {
        	$this->admin_priv('customer_manage_all');
        }
        
        if ($filter['status'] == '1') {
       		$where['charge_man'] = $charge_man_id;
        } elseif ($filter['status'] == '-2') {
			if(!empty($ids)) {
        		$where['c.customer_id'] = $ids;
        		$where['c.charge_man'] = $_SESSION['admin_id'];
        		$count = $this->db_customer->where($where)->count();
        		$page = new ecjia_page($count, 10, 5);
        		$row = $this->db_view->join(array('users', 'admin_user', 'customer_state', 'customer_source','customer_pool'))->field('c.*, cs.state_name, co.source_name, u.adviser_id, u.user_name as member_name, au.user_name as add_user_name, cp.operate_time')->group('c.customer_id')->order(array('cp.operate_time' => 'desc', $filter['sort_by'] => $filter['sort_order']))->limit($page->limit())
        		->where($where)->select();
			}else{
				$page = new ecjia_page(0, 10, 5);
			}
        } elseif ($filter['status'] == '2') {
            $where[] = " (charge_man = 0 OR charge_man ='' OR charge_man is NULL)";
        } elseif ($filter['status'] == '-1') {
        	$where['charge_man'] = $charge_man_id;
        	$where['c.last_contact_time'] = array('elt' => $back_time);
        } elseif ($filter['status'] == 'transhed'){
        	unset($where['c.customer_id']);
        	if(!empty($filter['menu'])){
        		$where['c.is_delete'] = '1';
        	}else{
        		$where['c.is_delete'] = '1';
        		$where['charge_man'] = $charge_man_id;
        	}
        	
        	$count = $this->db_view->join(array('users', 'admin_user', 'customer_state', 'customer_source'))->where($where)->count('c.customer_id');
        	$page  = new ecjia_page($count, 10, 5);
        	$row   = $this->db_view->join(array('users', 'admin_user', 'customer_state', 'customer_source'))->field('c.*, cs.state_name, co.source_name, u.adviser_id, u.user_name as member_name, au.user_name as add_user_name')->order(array('add_time' => 'desc', $filter['sort_by'] => $filter['sort_order']))->limit($page->limit())->where($where)->select();
        }

        if($filter['status'] != '-2' || $filter['status'] !== 'transhed' || $filter['menu'] == 'all') {
        	if($filter['menu'] == 'all'){
        		unset($where['charge_man']);
        	}
        	$count = $this->db_view->join(array('users', 'admin_user', 'customer_state', 'customer_source'))->where($where)->count('c.customer_id');
        	$page  = new ecjia_page($count, 10, 5);
        	$row   = $this->db_view->join(array('users', 'admin_user', 'customer_state', 'customer_source'))->field('c.*, cs.state_name, co.source_name, u.adviser_id, u.user_name as member_name, au.user_name as add_user_name')->order(array('add_time' => 'desc', $filter['sort_by'] => $filter['sort_order']))->limit($page->limit())->where($where)->select();
        }
        
        if ($filter['status'] == '1') {
            $filter['count_m']['count_mine'] = $count;
        } elseif ($filter['status'] == '-2') {
            $filter['count_r']['count_my_recipients'] = $count;
        } elseif ($filter['status'] == 'transhed') {
            $filter['count_t']['throwed'] = $count;
        } elseif ($filter['status'] == 'whole') {
            $filter['count_w']['whole'] = $count;
        } elseif ($filter['status'] == '-1') {
        	$filter['count_b']['count_back'] = $count;
        }
        $admin_user_name = get_admin_user_name();

        if ($row) {
            foreach ($row as $key => $val) {
                $row[$key]['add_time']      	= RC_Time::local_date('Y-m-d H:i', $row[$key]['add_time']);
                $row[$key]['last_contact_time'] = RC_Time::local_date('Y-m-d H:i', $row[$key]['last_contact_time']);
                $row[$key]['reservation_time']  = RC_Time::local_date('Y-m-d H:i', $row[$key]['reservation_time']);
                $row[$key]['charge_man_name']   = $admin_user_name[$val['charge_man']];
            }
        }
		
        $arr = array('list' => $row, 'filter' => $filter, 'page' => $page->show(5), 'asc' => $page->page_desc(), 'current_page' => $page->current_page); //'filter' => $filter,筛选
        return $arr;
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
