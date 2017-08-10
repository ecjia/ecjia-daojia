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
 * ECJIA 结算管理
 */
class admin extends ecjia_admin {

	private $db_user;
	private $db_store_bill;
	private $db_store_bill_day;
	private $db_store_bill_detail;
	public function __construct() {
		parent::__construct();

		$this->db_user				= RC_Model::model('user/users_model');
		$this->db_store_bill        = RC_Model::model('commission/store_bill_model');
		$this->db_store_bill_day    = RC_Model::model('commission/store_bill_day_model');
		$this->db_store_bill_detail = RC_Model::model('commission/store_bill_detail_model');
		
		/* 加载所全局 js/css */
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Style::enqueue_style('hint_css', RC_Uri::admin_url('statics/lib/hint_css/hint.min.css'), array(), false, false);
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
        
        /*自定义js*/
        RC_Script::enqueue_script('bill-admin', RC_App::apps_url('statics/js/bill_admin.js', __FILE__));
        RC_Script::enqueue_script('bill-pay', RC_App::apps_url('statics/js/bill_pay.js', __FILE__));
        RC_Script::enqueue_script('bill-order', RC_App::apps_url('statics/js/order.js', __FILE__));
        RC_Script::enqueue_script('bill-update', RC_App::apps_url('statics/js/bill_update.js', __FILE__));
	}
	
	/**
	 * 结算账单列表
	 */
	public function init() {
		/* 检查权限 */
		$this->admin_priv('commission_manage');
	    
		$this->assign('search_action', RC_Uri::url('commission/admin/init'));
		$this->assign('ur_here', '账单列表');
		$this->assign('action_link',	array('text' => '账单生成', 'href' => RC_Uri::url('commission/admin/bill_update')));
		
// 		/* 时间参数 */
		$filter['start_date'] = empty($_GET['start_date']) ? null : RC_Time::local_date('Y-m', RC_Time::local_strtotime($_GET['start_date']));
		$filter['end_date']   = empty($_GET['end_date']) ? null : RC_Time::local_date('Y-m', RC_Time::local_strtotime($_GET['end_date']));
		$filter['type']       = $_GET['type'];
		$filter['keywords'] 		 = empty ($_GET['keywords']) 		  ? '' : trim($_GET['keywords']);
		$filter['merchant_keywords'] = empty ($_GET['merchant_keywords']) ? '' : trim($_GET['merchant_keywords']);
		
		$store_id = empty($_GET['store_id']) ? null :$_GET['store_id'];
		
		if ($_GET['refer'] == 'store') {
		    RC_loader::load_app_func('global', 'store');
		    $menu = set_store_menu($store_id, 'bill');
		    $this->assign('menu', $menu);
		    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('入驻商'), RC_Uri::url('store/admin/init')));
		}
		if ($store_id) {
		    $merchants_name = RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');
		    $this->assign('ur_here', $merchants_name.' - 账单列表');
		}
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单列表')));
		
		$bill_list = $this->db_store_bill->get_bill_list($store_id, $_GET['page'], 20, $filter);
		$this->assign('bill_list', $bill_list);
		
		$this->display('bill_list.dwt');
	}
	
	public function bill_update() {
	    /* 检查权限 */
	    $this->admin_priv('commission_update');
	    $this->assign('ur_here', '月账单生成');
	    $this->assign('action_link',	array('text' => '每月账单', 'href' => RC_Uri::url('commission/admin/init')));
	     
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('每月账单'), RC_Uri::url('commission/admin/init')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单生成')));
	     
	    $this->assign('form_action', RC_Uri::url('commission/admin/bill_updata_month'));
	     
	    $this->display('bill_list_month_update.dwt');
	}
	
	public function bill_updata_month() {
	    /* 检查权限 */
	    $this->admin_priv('commission_update');
	     
	    set_time_limit(300);
	     
	    $start_date = $_POST['start_date'];
	    if (empty($start_date)) {
	        return $this->showmessage('请选择时间', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    if ($start_date == RC_Time::local_date('Y-m')) {
	        return $this->showmessage('当月交易未完成，账单暂不能生成', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	     
	    RC_Loader::load_app_class('store_bill', 'commission', false);
	    $store_bill = new store_bill();
	     
	    $store_bill->bill_month(array('month' => $start_date));
	     
	    return $this->showmessage('更新成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	     
	}
	
	public function bill_refresh() {
	    /* 检查权限 */
	    $this->admin_priv('commission_refresh');
	    $id = $_POST['id'];
	    if(empty($id)) {
	        return $this->showmessage('参数错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $bill_info = RC_DB::table('store_bill')->where('bill_id', $id)->first();
	    if (empty($bill_info)) {
	        return $this->showmessage('账单信息不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if ($bill_info['bill_month'] == RC_Time::local_date('Y-m')) {
	        return $this->showmessage('当月交易未完成，账单暂不能生成', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    //重新生成
	    set_time_limit(300);
	    RC_Loader::load_app_class('store_bill', 'commission', false);
	    $store_bill = new store_bill();
	    
	    $store_bill->bill_month_refresh(array('month' => $bill_info['bill_month'], 'store_id' => $bill_info['store_id']));
	    
	    return $this->showmessage('账单生成成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('commission/admin/detail', array('id' => $id))));
	    
	}
	
	public function day() {
	    /* 检查权限 */
	    $this->admin_priv('commission_day_manage');
	     
	    $this->assign('search_action', RC_Uri::url('commission/admin/day'));
	    $this->assign('ur_here', '每日账单');
	    $this->assign('action_link',	array('text' => '账单生成', 'href' => RC_Uri::url('commission/admin/day_update')));
	    
	
	    // 		/* 时间参数 */
	    $filter['start_date'] = empty($_GET['start_date']) ? null : RC_Time::local_date('Y-m-d', RC_Time::local_strtotime($_GET['start_date']));
	    $filter['end_date']   = empty($_GET['end_date']) ? null : RC_Time::local_date('Y-m-d', RC_Time::local_strtotime($_GET['end_date']));
	    $filter['type']       = $_GET['type'];
	    $filter['keywords'] 		 = empty ($_GET['keywords']) 		  ? '' : trim($_GET['keywords']);
	    $filter['merchant_keywords'] = empty ($_GET['merchant_keywords']) ? '' : trim($_GET['merchant_keywords']);
	
	    $store_id = empty($_GET['store_id']) ? null :$_GET['store_id'];
	
	    if ($_GET['refer'] == 'store') {
	        RC_loader::load_app_func('global', 'store');
	        $menu = set_store_menu($store_id, 'bill');
	        $this->assign('menu', $menu);
	        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('入驻商'), RC_Uri::url('store/admin/init')));
	    }
	    if ($store_id) {
	        $merchants_name = RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');
	        $this->assign('ur_here', $merchants_name.' - 每日账单');
	    }
	    if ($filter['start_date'] >  $filter['end_date']) {
	        return $this->showmessage('开始时间不能大于结束时间', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
	    }
	
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('每日账单')));
	
	    $bill_list = $this->db_store_bill_day->get_billday_list($store_id, $_GET['page'], 20, $filter);
	    $this->assign('bill_list', $bill_list);
	
	    $this->display('bill_list_day.dwt');
	}
	
	public function day_update() {
	    /* 检查权限 */
	    $this->admin_priv('commission_day_update');
	    $this->assign('ur_here', '每日账单生成');
	    $this->assign('action_link',	array('text' => '每日账单', 'href' => RC_Uri::url('commission/admin/day')));
	    
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('每日账单'), RC_Uri::url('commission/admin/day')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单生成')));
	    
	    $this->assign('form_action', RC_Uri::url('commission/admin/bill_updata_day'));
	    
	    $this->display('bill_list_day_update.dwt');
	}
	
	public function bill_updata_day() {
	    /* 检查权限 */
	    $this->admin_priv('commission_day_update');
	    
	    set_time_limit(300);
	    
	    $start_date = $_POST['start_date'];
	    $end_date = $_POST['end_date'];
	    if (empty($start_date) || empty($end_date)) {
	        return $this->showmessage('请选择时间', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $seconds_end = RC_Time::local_strtotime($_POST['end_date']);
	    $seconds_start = RC_Time::local_strtotime($_POST['start_date']);
	    if ($_POST['end_date'] > RC_Time::local_date('Y-m-d', RC_Time::gmtime())) {
	        $seconds_end = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', RC_Time::gmtime())) - 86400;
	    }
	    if ($seconds_end < $seconds_start) {
	        return $this->showmessage('开始时间不能大于结束时间', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $days = ($seconds_end-$seconds_start)/86400;
	    
	    RC_Loader::load_app_class('store_bill', 'commission', false);
	    $store_bill = new store_bill();
	    
	    for ($i=0; $i<$days+1; $i++) {
	        $date = RC_Time::local_date('Y-m-d', $seconds_start + $i * 86400);
	        $store_bill->bill_day(array('day' => $date));
	    }
	    return $this->showmessage('更新成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	    
	}
	
	//账单详情
	//模板顶部表格，月账单情况
	//底部详单列表，可翻页，30条一页
	public function detail() {
	    /* 检查权限 */
	    $this->admin_priv('commission_detail');
	    
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家结算'), RC_Uri::url('commission/admin/init')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单列表'),  RC_Uri::url('commission/admin/init')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单详情')));
	    if ($_GET['store_id']) {
	        $action_link_href = RC_Uri::url('commission/admin/init', array('store_id' => $_GET['store_id']));
	    } else {
	        $action_link_href = RC_Uri::url('commission/admin/init');
	    }
	    $this->assign('action_link', array('href' => $action_link_href, 'text' => '账单列表'));
	    
	    $bill_id = empty($_GET['id']) ? null : intval($_GET['id']);
	    if (empty($bill_id)) {
	        return $this->showmessage('参数异常', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $bill_info = $this->db_store_bill->get_bill($bill_id);
	    if (empty($bill_info)) {
	        return $this->showmessage('没有数据', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $bill_info['pay_count'] = RC_Model::model('commission/store_bill_paylog_model')->get_paylog_count($bill_info['bill_id']);
	    $bill_info['merchants_name'] = RC_Model::model('commission/store_franchisee_model')->get_merchants_name($bill_info['store_id']);
	    
	    $this->assign('ur_here', $bill_info['bill_month'].'账单详情');
	    $this->assign('bill_info', $bill_info);
	    
	    //每日
	    $bill_list = $this->db_store_bill_day->get_billday_list($bill_info['store_id'], 1, 40, array('start_date' => $bill_info['bill_month'].'-01', 'end_date' => $bill_info['bill_month'].'-31'));
	    $this->assign('bill_list', $bill_list);
	    
	    //明细
	    $filter['start_date'] = RC_Time::local_strtotime($bill_info['bill_month']);
	    $filter['end_date'] = RC_Time::local_strtotime(RC_Time::local_date('Y-m',$filter['start_date'] + 86400*31).'-01')-1;
	    
	    $record_list = $this->db_store_bill_detail->get_bill_record($bill_info['store_id'], $_GET['page'], 30, $filter, 1);
	    $this->assign('lang_os', RC_Lang::get('orders::order.os'));
	    $this->assign('lang_ps', RC_Lang::get('orders::order.ps'));
	    $this->assign('lang_ss', RC_Lang::get('orders::order.ss'));
	    $this->assign('record_list', $record_list);
	    $this->display('bill_detail.dwt');
	}
	
	//打款
	public function pay() {
	    /* 检查权限 */
	    $this->admin_priv('commission_pay');
	    $bill_id = empty($_GET['bill_id']) ? null : intval($_GET['bill_id']);
	    if (empty($bill_id)) {
	        return $this->showmessage('参数异常', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $this->assign('action_link', array('href' => RC_Uri::url('commission/admin/detail', 'id='.$bill_id), 'text' => '账单详情'));
	    
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家结算'), RC_Uri::url('commission/admin/init')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单列表'), RC_Uri::url('commission/admin/init')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单详情'), RC_Uri::url('commission/admin/detail', 'id='.$bill_id)));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单打款')));
	    $this->assign('ur_here', '账单打款');
	    
	    //账单信息
	    $bill_info = $this->db_store_bill->get_bill($bill_id);
	    if (empty($bill_info)) {
	        return $this->showmessage('没有数据', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $bill_info['merchants_name'] = RC_Model::model('commission/store_franchisee_model')->get_merchants_name($bill_info['store_id']);
	     
	    $this->assign('bill_info', $bill_info);
	    
	    //打款流水
	    $log_list = RC_Model::model('commission/store_bill_paylog_model')->get_bill_paylog_list($bill_info['bill_id'], 1, 100);
	    $this->assign('log_list', $log_list);
	    
	    //打款信息
	    //根据状态和打款流水和判断是否已经全部打款
	    if ($bill_info['pay_status'] == 3 && $log_list['filter']['count_bill_amount'] != $bill_info['bill_amount']) {
	        return $this->showmessage('打款流水异常，请检查', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if ($bill_info['pay_status'] != 3 && $log_list['filter']['count_bill_amount'] != $bill_info['bill_amount']) {
	        $this->assign('form_action', RC_Uri::url('commission/admin/pay_do'));
	        $merchants_info = RC_Model::model('commission/store_franchisee_model')->get_merchants_info($bill_info['store_id']);
	        $merchants_info['pay_amount'] = $bill_info['bill_amount'] - $log_list['filter']['count_bill_amount'];
	        $this->assign('merchants_info', $merchants_info);
	    }
	    $this->display('bill_pay.dwt');
	}
	
	//打款操作
	//TODO:部分格式不可修改，浮点数运算需要
	public function pay_do() {
	    
	    $this->admin_priv('commission_pay', ecjia::MSGTYPE_JSON);
	    
	    $bill_id             = !empty($_POST['bill_id']) 				? intval($_POST['bill_id']) 			: 0;
	    $pay_amount          = is_numeric($_POST['pay_amount']) 		? (double)$_POST['pay_amount'] 			: 0;
	    $payee               = !empty($_POST['payee']) 					? trim($_POST['payee']) 				: '';
	    $bank_account_number = !empty($_POST['bank_account_number']) 	? trim($_POST['bank_account_number']) 	: '';
	    $bank_name           = !empty($_POST['bank_name']) 				? trim($_POST['bank_name']) 			: '';
	    $bank_branch_name    = !empty($_POST['bank_branch_name']) 		? trim($_POST['bank_branch_name']) 		: '';
	    $mobile      	     = !empty($_POST['mobile']) 				? trim($_POST['mobile']) 				: '';
	    
	    if (empty($bill_id) || empty($pay_amount) || empty($payee) || empty($bank_account_number) || empty($bank_name)) {
	        return $this->showmessage('请填写完整的数据', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $bill_info = $this->db_store_bill->get_bill($bill_id);
	    if (empty($bill_info)) {
	        return $this->showmessage('非法数据', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    //打款流水
	    $log_list = RC_Model::model('commission/store_bill_paylog_model')->get_bill_paylog_list($bill_info['bill_id'], 1, 100);
	    
	    
	    $bill_unpayed = $bill_info['bill_amount']-$log_list['filter']['count_bill_amount'];
	    $bill_unpayed = (double)$bill_unpayed;

	    if ($pay_amount　< 0) {
	        return $this->showmessage('打款金额不正确', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }

	    if ($pay_amount-$bill_unpayed > 0) {
	        return $this->showmessage('打款金额超出未付金额', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if ($bill_info['pay_status'] == 3 || $bill_unpayed == 0) {
	        return $this->showmessage('账单已付清', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $add_time = RC_Time::gmtime();
	    $data = array(
	        'bill_id' 				=> $bill_id,
            'bill_amount' 			=> $pay_amount,
            'payee' 				=> $payee,
            'bank_account_number' 	=> $bank_account_number,
            'bank_name' 			=> $bank_name,
            'bank_branch_name' 		=> $bank_branch_name,
            'mobile' 				=> $mobile,
            'admin_id' 				=> $_SESSION['admin_id'],
            'add_time' 				=> $add_time,
	    );
	    
	    $insert_id = RC_DB::table('store_bill_paylog')->insertGetId($data);
	    if ($insert_id) {
	       //更新主表
	       
	       if ($pay_amount==$bill_unpayed) {
	           $pay_status = 3;
	       } else if ($pay_amount-$bill_unpayed<0) {
	           $pay_status = 2;
	       }
	       
	       RC_DB::table('store_bill')->where('bill_id', $bill_id)->update(array('pay_status' => $pay_status, 'pay_time' => $add_time));
           //编辑账单列表，打款，账单编号是201603000015236，打款金额
	       ecjia_admin_log::instance()->add_object('commission', '商家结算');
	       ecjia_admin::admin_log('打款，账单编号 '.$bill_info['bill_sn'].'，'.'打款金额 '.$pay_amount, 'edit', 'commission');
	       return $this->showmessage('打款记录保存成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('commission/admin/pay', array('bill_id' => $bill_id))));
	    }
	}
	
	//打款日志
	public function pay_log() {
	    /* 检查权限 */
	    $this->admin_priv('commission_paylog');
	    $bill_id = empty($_GET['bill_id']) ? 0 : intval($_GET['bill_id']);
	    if (empty($bill_id)) {
	        return $this->showmessage('参数异常', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $this->assign('action_link', array('href' => RC_Uri::url('commission/admin/detail', 'id='.$bill_id), 'text' => '账单详情'));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家结算'), RC_Uri::url('commission/admin/init')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单列表'), RC_Uri::url('commission/admin/init')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单详情'), RC_Uri::url('commission/admin/detail', 'id='.$bill_id)));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('打款流水')));
	    $this->assign('ur_here', '打款流水');
	    $this->bill_and_log($bill_id);
	    $this->assign('action', 'pay_log');
	    $this->display('bill_pay.dwt');
	}
	
	private function bill_and_log($bill_id) {
	    //账单信息
	    $bill_info = $this->db_store_bill->get_bill($bill_id);
	    if (empty($bill_info)) {
	        return $this->showmessage('没有数据', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $bill_info['merchants_name'] = RC_Model::model('commission/store_franchisee_model')->get_merchants_name($bill_info['store_id']);
	    $this->assign('bill_info', $bill_info);
	    //打款流水
	    $log_list = RC_Model::model('commission/store_bill_paylog_model')->get_bill_paylog_list($bill_info['bill_id'], 1, 100);
	    $this->assign('log_list', $log_list);
	}
	
	//订单分成列表
	public function order() {
	    /* 检查权限 */
	    $this->admin_priv('commission_order');
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家结算'), RC_Uri::url('commission/admin/init')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单分成')));
	    $this->assign('ur_here', '订单分成列表');
	    $this->assign('search_action', RC_Uri::url('commission/admin/order'));
	    
	    //明细
// 	    $filter['start_date'] = RC_Time::local_strtotime($bill_info['bill_month']);
// 	    $filter['end_date'] = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', strtotime('+1 month', $filter['start_date']))) - 1;
	    $filter['order_sn'] = !empty($_GET['order_sn']) ? trim($_GET['order_sn']) : null;
	    $filter['merchant_keywords'] = !empty($_GET['merchant_keywords']) ? trim($_GET['merchant_keywords']) : null;
	    $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : null;
	    
	    if ($store_id) {
	        $merchants_name = RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');
	        $this->assign('ur_here', $merchants_name.' - 订单分成列表');
	    }
	     
	    $record_list = $this->db_store_bill_detail->get_bill_record($store_id, $_GET['page'], 20, $filter, 1);
	    $this->assign('lang_os', RC_Lang::get('orders::order.os'));
	    $this->assign('lang_ps', RC_Lang::get('orders::order.ps'));
	    $this->assign('lang_ss', RC_Lang::get('orders::order.ss'));
	    $this->assign('record_list', $record_list);
	    $this->display('order_list.dwt');
	}
}

// end