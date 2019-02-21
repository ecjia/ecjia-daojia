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
 * 买单订单管理
 */
class mh_order extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		Ecjia\App\Quickpay\Helper::assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('bootstrap-fileupload-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
		RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);
		
		//时间控件
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		
		RC_Script::enqueue_script('mh_order', RC_App::apps_url('statics/js/mh_order.js', __FILE__));
		RC_Style::enqueue_style('mh_orders', RC_App::apps_url('statics/css/mh_orders.css', __FILE__), array(), false, false);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('买单管理', 'quickpay'), RC_Uri::url('quickpay/mh_order/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('quickpay', 'quickpay/mh_order.php');
	}

	/**
	 * 买单订单列表页面
	 */
	public function init() {
	    $this->admin_priv('mh_quickpay_order_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('买单订单', 'quickpay')));
	    $this->assign('ur_here', __('买单订单列表', 'quickpay'));
	    
	    $this->assign('action_link', array('text' => __('订单查询', 'quickpay'), 'href' => RC_Uri::url('quickpay/mh_order/search_order')));
	    	    
	    $type_list = $this->get_quickpay_type();
	    $this->assign('type_list', $type_list);
	    $status_list = $this->get_all_status();
	    $this->assign('status_list', $status_list);
	    	    
	    $order_list = $this->order_list($_SESSION['store_id']);
	    $this->assign('order_list', $order_list);
	    $this->assign('filter', $order_list['filter']);
	    
	    $this->assign('search_action', RC_Uri::url('quickpay/mh_order/init'));
	    
	    $this->display('quickpay_order_list.dwt');
	}
	
	/**
	 * 买单订单详情页面
	 */
	public function order_info() {
		$this->admin_priv('mh_quickpay_order_manage');
		 
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('买单订单信息', 'quickpay')));
		$this->assign('ur_here', __('买单订单信息', 'quickpay'));
		
		$this->assign('action_link', array('text' => __('买单订单列表', 'quickpay'), 'href' => RC_Uri::url('quickpay/mh_order/init')));
		
		$order_id = intval($_GET['order_id']);
		$order_info = RC_DB::table('quickpay_orders')->where('order_id', $order_id)->first();
		$order_info['pay_time'] = RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']);
		$order_info['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $order_info['add_time']);
		$order_info['verification_time'] = RC_Time::local_date(ecjia::config('time_format'), $order_info['verification_time']);
		
		if ($order_info['activity_type'] == 'discount') { 
			$order_info['activity_name'] = __('价格折扣', 'quickpay');
		} elseif ($order_info['activity_type'] == 'everyreduced') { 
			$order_info['activity_name'] = __('每满多少减多少,最高减多少', 'quickpay');
		} elseif ($order_info['activity_type'] == 'reduced') { 
			$order_info['activity_name'] = __('满多少减多少', 'quickpay');
		} elseif ($order_info['activity_type'] == 'normal') {
			$order_info['activity_name'] = __('无优惠', 'quickpay');
		}
		$order_info['order_amount'] = $order_info['order_amount'] + $order_info['surplus'];
		$os = array(
			0 	=> __('未确认', 'quickpay'),
			1 	=> __('已确认', 'quickpay'),
			9   => __('已取消', 'quickpay'),
			99  => __('已删除', 'quickpay')
		);
		
		$ps = array(
			0 	=> __('未付款', 'quickpay'),
			1 	=> __('已付款', 'quickpay')
		);
		
		$vs = array(
			0 	=> __('未核销', 'quickpay'),
			1 	=> __('已核销', 'quickpay')
		);
		$order_info['status'] = $os[$order_info['order_status']] . ',' .$ps[$order_info['pay_status']] . ',' . $vs[$order_info['verification_status']];
		$this->assign('order_info', $order_info);

		if ($order_info['pay_status'] == 1) {
			$this->assign('has_payed', 1);
		}
		
		$cancel_time = RC_DB::table('quickpay_order_action')->where('order_id', $order_id)->where('order_status', 9)->pluck('add_time');
		$cancel_time = RC_Time::local_date(ecjia::config('time_format'), $cancel_time);
		$this->assign('cancel_time', $cancel_time);
		//订单流程状态
		if ($order_info['order_status']){
			$step = 1;
		}
		if ($order_info['pay_status']){
			$step = 2;
		} 
		if ($order_info['verification_status']){
			$step = 3;
		}
		$this->assign('step', $step);
		
		//操作记录
		$act_list = array();
		$data = RC_DB::table('quickpay_order_action')->where('order_id', $order_id)->orderby('order_id', 'asc')->get();
		foreach ($data as $key => $row) {
			$row['add_time']	= RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
			$row['order_status_name'] 	= $os[$row['order_status']] . ',' .$ps[$row['pay_status']] . ',' . $vs[$row['verification_status']];
			$act_list[] = $row;
		}
		$this->assign('action_list', $act_list);
		
		$this->display('quickpay_order_info.dwt');
	}
	
	
	/**
	 * 核销操作
	 */
	public function order_action() {
		$this->admin_priv('mh_quickpay_order_update');
		
		$action_note = trim($_POST['action_note']);
		$order_id    = intval($_POST['order_id']);
		if (empty($action_note)) {
			return $this->showmessage(__('操作备注不能为空', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR,array('url' => RC_Uri::url('quickpay/mh_order/init')));
		}
		
		$data = array(
			'verification_status'	=> 1,
			'verification_time' 	=> RC_Time::gmtime()
		);
		RC_DB::table('quickpay_orders')->where('order_id', $order_id)->update($data);
		
		$data_action = array(
			'order_id'				=> $order_id,
			'action_user_id'		=> $_SESSION['staff_id'],
			'action_user_name'		=> $_SESSION['staff_name'],
			'action_user_type'		=> 'merchant',
			'order_status'	        => 1,
			'pay_status'	        => 1,
			'verification_status'	=> 1,
			'action_note'			=> $action_note,
			'add_time'				=> RC_Time::gmtime(),
		);
		RC_DB::table('quickpay_order_action')->insertGetId($data_action);
		
// 		$order_amount = RC_DB::table('quickpay_orders')->where('order_id', $order_id)->pluck('order_amount');
// 		$percent_value = 100-ecjia::config('quickpay_fee');
// 		$brokerage_amount = $order_amount * $percent_value / 100;
// 		$data_bill = array(
// 			'store_id'			=> $_SESSION['store_id'],
// 			'order_type'		=> 11,
// 			'order_id'			=> $order_id,
// 			'percent_value'		=> $percent_value,//佣金比例
// 			'brokerage_amount'	=> $brokerage_amount,//佣金金额
// 			'add_time'			=> RC_Time::gmtime(),
// 		);
// 		RC_DB::table('store_bill_detail')->insertGetId($data_bill);
		//结算
// 		RC_Api::api('commission', 'add_bill_detail', array('store_id' => $_SESSION['store_id'], 'order_type' => 'quickpay', 'order_id' => $order_id,));
		RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'quickpay', 'order_id' => $order_id));
		
		$order_sn = RC_DB::table('quickpay_orders')->where('order_id', $order_id)->pluck('order_sn');
		ecjia_merchant::admin_log($order_sn, 'check', 'quickpay_order');
		
		if ($_POST['type_info']) {
			return $this->showmessage(__('核销操作成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('quickpay/mh_order/order_info', array('order_id' => $order_id))));
		} else {
			return $this->showmessage(__('核销操作成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('quickpay/mh_order/init')));
		}
	}
	
	/**
	 * 取消操作
	 */
	public function order_action_cancel() {
		$this->admin_priv('mh_quickpay_order_update');
	
		$action_note = trim($_POST['action_note']);
		$order_id    = intval($_POST['order_id']);
		if (empty($action_note)) {
			return $this->showmessage(__('操作备注不能为空', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR,array('url' => RC_Uri::url('quickpay/mh_order/init')));
		}
	
		$data = array(
			'order_status'	=> 9,
		);
		RC_DB::table('quickpay_orders')->where('order_id', $order_id)->update($data);
	
		$data_action = array(
				'order_id'				=> $order_id,
				'action_user_id'		=> $_SESSION['staff_id'],
				'action_user_name'		=> $_SESSION['staff_name'],
				'action_user_type'		=> 'merchant',
				'order_status'	        => 9,
				'pay_status'	        => 0,
				'verification_status'	=> 0,
				'action_note'			=> $action_note,
				'add_time'				=> RC_Time::gmtime(),
		);
		RC_DB::table('quickpay_order_action')->insertGetId($data_action);
		
		$order_sn = RC_DB::table('quickpay_orders')->where('order_id', $order_id)->pluck('order_sn');
		ecjia_merchant::admin_log($order_sn, 'cancel', 'quickpay_order');
		
		if ($_POST['type_info']) {
			return $this->showmessage(__('核销操作成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('quickpay/mh_order/order_info', array('order_id' => $order_id))));
		} else {
			return $this->showmessage(__('核销操作成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('quickpay/mh_order/init')));
		}
	}
	
	/**
	 * 删除买单订单
	 */
	public function remove() {
		$this->admin_priv('mh_quickpay_order_delete');
	
		$order_id = intval($_GET['order_id']);
		$order_sn = RC_DB::table('quickpay_orders')->where('order_id', $order_id)->pluck('order_sn');
		
		$data = array(
			'order_status' => 99,
		);
		RC_DB::table('quickpay_orders')->where('order_id', $order_id)->update($data);
		
		ecjia_merchant::admin_log($order_sn, 'remove', 'quickpay_order');
		
		return $this->showmessage(__('成功删除该优惠买单订单', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 批量操作买单订单
	 */
	public function batch() {
		$this->admin_priv('mh_quickpay_order_delete');
		
		$ids = explode(',', $_POST['checkboxes']);
		if (isset($_GET['operation'])) {
			if ($_GET['operation'] == 'remove') {
				$this->admin_priv('mh_quickpay_order_delete');
				foreach($ids as $val){
					$pay_status = RC_DB::table('quickpay_orders')->where('order_id', $val)->pluck('order_status');
					$order_sn = RC_DB::table('quickpay_orders')->where('order_id', $val)->pluck('order_sn');
					if($pay_status == 9){
						$data = array(
							'order_status' => 99,
						);
						RC_DB::table('quickpay_orders')->where('order_id', $val)->update($data);
					}
					ecjia_merchant::admin_log($order_sn, 'batch_trash', 'quickpay_order');
				}
			} else {
				$this->admin_priv('mh_quickpay_order_update');
				foreach($ids as $val){
					$status = RC_DB::table('quickpay_orders')->where('order_id', $val)->select('order_status', 'pay_status', 'verification_status')->first();
					$order_sn = RC_DB::table('quickpay_orders')->where('order_id', $val)->pluck('order_sn');
					if($status['order_status'] == 0 && $status['pay_status'] ==0 && $status['verification_status']==0){
						$data = array(
							'order_status' => 9,
						);
						RC_DB::table('quickpay_orders')->where('order_id', $val)->update($data);
					}
					ecjia_merchant::admin_log($order_sn, 'batch_cancel', 'quickpay_order');
				}
				
			}
			
			return $this->showmessage(__('批量操作成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('quickpay/mh_order/init')));
		}
	}
	
	/**
	 * 买单订单查询
	 */
	public function search_order() {
		$this->admin_priv('mh_quickpay_order_search');
		 
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('买单订单查询', 'quickpay')));
		$this->assign('ur_here', __('买单订单查询', 'quickpay'));
		 
		$this->assign('action_link', array('text' => __('买单订单列表', 'quickpay'), 'href' => RC_Uri::url('quickpay/mh_order/init')));
	
		$type_list = $this->get_quickpay_type();
		$this->assign('type_list', $type_list);
		 
		$this->assign('form_action', RC_Uri::url('quickpay/mh_order/init'));
		 
		$this->display('quickpay_order_search.dwt');
	}

	/**
	 * 获取订单列表
	 */
	private function order_list($store_id) {
		$db_quickpay_order = RC_DB::table('quickpay_orders');
		
		$db_quickpay_order->where('store_id', $store_id);
		$db_quickpay_order->where('order_status','!=', 99);
		
		$filter = $_GET;
		
		if ($filter['act_id']) {
			$db_quickpay_order->where('activity_id', $filter['act_id']);
		}
		
		if ($filter['keywords']) {
			$db_quickpay_order->where('order_sn', 'like', '%'.mysql_like_quote($filter['keywords']).'%')->orWhere('user_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
		}
		
		if ($filter['order_sn']) {
			$db_quickpay_order->where('order_sn', 'like', '%'.mysql_like_quote($filter['order_sn']).'%');
		}
		
		if ($filter['activity_type']) {
			$db_quickpay_order->where('activity_type', $filter['activity_type']);
		}
		
		if($filter['order_status'] == 1) {
			$db_quickpay_order->where('order_status', 0);
		} elseif($filter['order_status'] == 2) {
			$db_quickpay_order->where('order_status', 1);
		} elseif($filter['order_status'] == 3) {
			$db_quickpay_order->where('order_status', 9);
		} elseif($filter['order_status'] == 4) {
			$db_quickpay_order->where('order_status', 99);
		} elseif($filter['order_status'] == 5) {
			$db_quickpay_order->where('pay_status', 0)->where('order_status', 0);
		} elseif($filter['order_status'] == 6) {
			$db_quickpay_order->where('pay_status', 1)->where('order_status', 1);
		} elseif($filter['order_status'] == 7) {
			$db_quickpay_order->where('verification_status', 0)->where('order_status', 1)->where('pay_status', 1);
		} elseif($filter['order_status'] == 8){
			$db_quickpay_order->where('verification_status', 1)->where('order_status', 1)->where('pay_status', 1);
		}
		
		if ($filter['start_time']) {
			$start_time = RC_Time::local_strtotime($filter['start_time']);
			$db_quickpay_order->where('add_time', '>=', $start_time);
		}
		
		if ($filter['end_time']) {
			$end_time = RC_Time::local_strtotime($filter['end_time']);
			$db_quickpay_order->where('add_time', '<=', $end_time);
		}

		if ($filter['user_name']) {
			$db_quickpay_order->where('user_name', 'like', '%'.mysql_like_quote($filter['user_name']).'%');
		}
		
		if ($filter['user_mobile']) {
			$db_quickpay_order->where('user_mobile', 'like', '%'.mysql_like_quote($filter['user_mobile']).'%');
		}

		
		$filter['check_type'] = !empty($_GET['check_type']) ? trim($_GET['check_type']) : 'unverification';
		$order_count = $db_quickpay_order->select(RC_DB::raw('SUM(IF(order_status = 0 and verification_status=0 and pay_status=0, 1, 0)) as unpay'),
				RC_DB::raw('SUM(IF(verification_status = 1 and order_status=1 and pay_status=1, 1, 0)) as verification'),
				RC_DB::raw('SUM(IF(verification_status = 0 and order_status =1 and pay_status=1, 1, 0)) as unverification'))->first();
		
		if ($filter['check_type'] == 'unverification') {
			$db_quickpay_order->where('verification_status', 0)->where('order_status', 1)->where('pay_status', 1);
		}
		
		if ($filter['check_type'] == 'verification') {
			$db_quickpay_order->where('verification_status', 1)->where('order_status', 1)->where('pay_status', 1);
		}
		
		if ($filter['check_type'] == 'unpay') {
			$db_quickpay_order->where('verification_status', 0)->where('order_status', 0)->where('pay_status', 0);
		}
		

		$count = $db_quickpay_order->count();
		
		$page = new ecjia_merchant_page($count,10, 5);
		$data = $db_quickpay_order
		->select('order_id', 'order_sn', 'activity_type', 'user_mobile', 'user_name', 'add_time', 'order_amount', 'surplus','order_status','pay_status','verification_status')
		->orderby('order_id', 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		$res = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
				$row['order_amount'] = price_format($row['order_amount'] + $row['surplus']);
				$res[] = $row;
			}
		}

		return array('list' => $res, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'count' => $order_count);
	}
	
	/**
	 * 获取买单优惠类型
	 */
	private function get_quickpay_type(){
		$type_list = array(
			'normal'	=> __('无优惠', 'quickpay'),
			'discount'	=> __('价格折扣', 'quickpay'),
			'reduced'   => __('满多少减多少', 'quickpay'),
			'everyreduced' 	 => __('每满多少减多少,最高减多少', 'quickpay')
		);
		return $type_list;
	}
	
	/**
	 * 获取订单状态
	 */
	private function get_all_status(){
		$status_list = array(
			'1' => __('未确认', 'quickpay'),
			'2' => __('已确认', 'quickpay'),
			'3' => __('已取消', 'quickpay'),
			'4' => __('已删除', 'quickpay'),
			'5'	=> __('未付款', 'quickpay'),
			'6' => __('已付款', 'quickpay'),
			'7'	=> __('未核销', 'quickpay'),
			'8' => __('已核销', 'quickpay'),
		);
		return $status_list;
	}
}

//end