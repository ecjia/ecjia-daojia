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
 * ECJIA 支付方式管理
 */
class admin_payment_record extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');		
		
		/* 支付方式 列表页面 js/css */

		RC_Script::enqueue_script('payment_admin', RC_App::apps_url('statics/js/payment_admin.js',__FILE__),array(), false, true);
		RC_Script::enqueue_script('payment_admin_record', RC_App::apps_url('statics/js/payment_admin_record.js',__FILE__),array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');

	}

	/**
	 * 支付方式列表
	 */
	public function init() {
	    $this->admin_priv('payment_manage');
	    
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here((RC_Lang::get('payment::payment.transaction_flow_record'))));
		
		$filter = array();
		$filter['order_sn']		= empty($_GET['order_sn'])		? ''		: trim($_GET['order_sn']);
		$filter['keywords']		= empty($_GET['keywords'])		? 0			: trim($_GET['keywords']);
		$filter['pay_status']	= empty($_GET['pay_status'])	? ''		: $_GET['pay_status'];
		
		RC_Loader::load_app_func('global');
	    $db_payment_record = get_payment_record_list($filter);
	    
	    $this->assign('modules', $db_payment_record);
	    $this->assign('search_action', RC_Uri::url('payment/admin_payment_record/init'));
		$this->assign('ur_here', RC_Lang::get('payment::payment.transaction_flow_record'));
		
		$this->display('payment_record_list.dwt');
	}

	/**
	 * 禁用支付方式
	 */
	public function info() {
		$this->admin_priv('payment_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here((RC_Lang::get('payment::payment.transaction_flow_record')), RC_Uri::url('payment/admin_payment_record/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('payment::payment.view_flow_record')));
		RC_Loader::load_app_func('global');
		$id = $_GET['id'];
		$order_sn = RC_DB::table('payment_record')->where('id', $id)->pluck('order_sn');
		
		//获取订单信息
		$order = RC_Api::api('orders', 'order_sn_info', array('order_sn' => $order_sn));
		
		$this->assign('os', RC_Lang::get('orders::order.os'));
		$this->assign('ps', RC_Lang::get('orders::order.ps'));
		$this->assign('ss', RC_Lang::get('orders::order.ss'));
		
		if (is_ecjia_error($order)) {
			$order = array();
		}
		$db_payment_record = RC_DB::table('payment_record')->where('id', $id)->first();
		
		if ($db_payment_record['trade_type'] == 'buy') {
			$db_payment_record['label_trade_type'] = RC_Lang::get('payment::payment.buy');
			$this->assign('check_modules', $order);
		} elseif ($db_payment_record['trade_type'] == 'refund') {
			$db_payment_record['label_trade_type'] = RC_Lang::get('payment::payment.refund');
		} elseif ($db_payment_record['trade_type'] == 'deposit') {
			$db_payment_record['label_trade_type'] = RC_Lang::get('payment::payment.deposit');
		} elseif ($db_payment_record['trade_type'] == 'withdraw') {
			$db_payment_record['label_trade_type'] = RC_Lang::get('payment::payment.withdraw');
		}elseif ($db_payment_record['trade_type'] == 'surplus') {
			$db_payment_record['label_trade_type'] = RC_Lang::get('payment::payment.surplus');
		}
		
		if ($db_payment_record['pay_status'] == 0) {
			$db_payment_record['label_pay_status'] = RC_Lang::get('payment::payment.wait_for_payment');
		} elseif ($db_payment_record['pay_status'] == 1) {
			$db_payment_record['label_pay_status'] = RC_Lang::get('payment::payment.payment_success');
		}

		$db_payment_record['create_time'] = RC_Time::local_date(ecjia::config('time_format'), $db_payment_record['create_time']);
		$db_payment_record['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $db_payment_record['update_time']);
		$db_payment_record['pay_time']    = RC_Time::local_date(ecjia::config('time_format'), $db_payment_record['pay_time']);
		
		/*会员充值订单*/
		if (($db_payment_record['trade_type'] != 'buy') || ($db_payment_record['trade_type'] != 'refund')) {
			$user_account = RC_DB::table('user_account')->where('order_sn', $order_sn)->first();
			$user_account['formated_order_amount'] = price_format($user_account['amount']);
			
			if ($user_account['is_paid'] == '0') {
				$order_status = '未完成';
			} elseif ($user_account['is_paid'] == '1') {
				$order_status = '已完成';
			} elseif ($user_account['is_paid'] == '2') {
				$order_status = '已取消';
			}
			$user_account['formated_order_status'] = $order_status;
			
			if ($user_account['process_type'] == 0) {
				$this->assign('type', 'recharge');
			} elseif ($user_account['process_type'] == 1) {
				$this->assign('type', 'withdraw');
			}
			
			$this->assign('user_account', $user_account);
		}
		
		if ($db_payment_record['trade_type'] == 'surplus') {
			if ($user_account['is_paid'] != '1' && $db_payment_record['pay_status'] =='1') {
				$this->assign('change_status', 1);
			}
		}
		/*订单状态是否改变处理*/
		if ($db_payment_record['trade_type'] == 'buy'){
			if ($order['pay_status'] != PS_PAYED && $db_payment_record['pay_status'] =='1') {
				$this->assign('change_status', 1);
			}
		}
		
		$this->assign('order', $order);
		$this->assign('ur_here', RC_Lang::get('payment::payment.view_flow_record'));
		$this->assign('action_link', array('text' => RC_Lang::get('payment::payment.transaction_flow_record'), 'href' => RC_Uri::url('payment/admin_payment_record/init')));
		$this->assign('modules', $db_payment_record);

		$this->display('payment_record_info.dwt');
	}
	
	/**
	 * 修复订单状态
	 */
	public function change_order_status() {
		$id = empty($_GET['id']) ? 0 :  $_GET['id'];
		$payment_record_info = RC_DB::table('payment_record')->where('id', $id)->first();
		
		if (empty($payment_record_info) || empty($payment_record_info['order_sn'])) {
			return $this->showmessage('订单支付记录信息不存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($payment_record_info['trade_type'] == 'buy') {
			$result = RC_Api::api('orders', 'buy_order_paid', array('order_sn' => $payment_record_info['order_sn'], 'money' => $payment_record_info['total_fee']));
		} elseif ($payment_record_info['trade_type'] == 'surplus') {
			$result = RC_Api::api('finance', 'surplus_order_paid', array('order_sn' => $payment_record_info['order_sn'], 'money' =>  $payment_record_info['total_fee']));
		}
		
		if (is_ecjia_error($result)){
			return $result;
		} else {
			$refresh_url = RC_Uri::url('payment/admin_payment_record/info', array('id' => $id));
			return $this->showmessage(RC_Lang::get('payment::payment.change_status_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
		}
	}
}

// end