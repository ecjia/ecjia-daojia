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
 * ECJIA 会员充值提现管理
*/
class admin_account extends ecjia_admin {

	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('admin_user');
		RC_Loader::load_app_func('global', 'goods');
		RC_Loader::load_app_func('global');
		assign_adminlog();
		
		/* 加载所需js */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('admin_account', RC_App::apps_url('statics/js/admin_account.js', __FILE__));
		
		RC_Style::enqueue_style('orders', RC_App::apps_url('statics/css/admin_finance.css', __FILE__), array());
		
		$account_jslang = array(
			'keywords_required'			=> RC_Lang::get('user::user_account.keywords_required'),
			'username_required'			=> RC_Lang::get('user::user_account.username_required'),
			'amount_required'			=> RC_Lang::get('user::user_account.amount_required'),
			'check_time'				=> RC_Lang::get('user::user_account.check_time'),
		);
		RC_Script::localize_script('admin_account', 'account_jslang', $account_jslang);
		
		$type = empty($_GET['type']) ? 'recharge' : $_GET['type'];
		if ($type == 'recharge') {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.recharge_order'), RC_Uri::url('finance/admin_account/init', array('type' => $type))));
		} elseif ($type == 'widthdraw'){
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.withdraw_apply'), RC_Uri::url('finance/admin_account/init', array('type' => $type))));
		}
		
	}

	/**
	 * 充值提现申请列表
	 */
	public function init() {
		$this->admin_priv('surplus_manage');
				
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		
		$type = empty($_GET['type']) ? 'recharge' : $_GET['type'];
		
		if ($type == 'recharge') {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.recharge_order')));
		} elseif ($type == 'withdraw'){
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.withdraw_apply')));
		}
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' . RC_Lang::get('user::users.user_account_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:充值和提现申请" target="_blank">'.RC_Lang::get('user::users.about_user_account').'</a>') . '</p>'
		);
		
		if ($type == 'recharge') {
			$this->assign('ur_here', RC_Lang::get('user::user_account.recharge_order'));
		} elseif ($type == 'withdraw'){
			$this->assign('ur_here', RC_Lang::get('user::user_account.withdraw_apply'));
		}
		
		$this->assign('action_link',	array('text' => RC_Lang::get('user::user_account.surplus_add'), 'href' => RC_Uri::url('finance/admin_account/add', array('type' => $type))));
		
		$filter = array();
		$filter['user_id'] 		= !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$filter['keywords']		= empty($_GET['keywords'])			? ''                            : trim($_GET['keywords']);
		//$filter['process_type']	= !empty($_GET['process_type'])		? intval($_GET['process_type']) : -1;
		$filter['payment']		= empty($_GET['payment'])			? ''                            : trim($_GET['payment']);
		$filter['is_paid']		= !empty($_GET['is_paid'])			? intval($_GET['is_paid'])      : -1;
		$filter['start_date']	= !empty($_GET['start_date'])		? ''                            : $_GET['start_date'];
		$filter['end_date']		= !empty($_GET['end_date'])			? ''                            : $_GET['end_date'];
		
		$filter['type'] = empty($_GET['type']) ? 'recharge' : $_GET['type'];
		$list = get_account_list($filter);
		
		$payment = get_payment();
		
		$this->assign('type',		$type);
		$this->assign('id',			$filter['user_id']);
		$this->assign('payment',	$payment);
		$this->assign('list',		$list);
		
		$this->assign('form_action',	RC_Uri::url('finance/admin_account/init', array('type' => $type)));
		$this->assign('batch_action',	RC_Uri::url('finance/admin_account/batch_remove'));
		
		$this->display('admin_account_list.dwt');
	}
	
	/**
	 * 添加充值提现
	 */
	public function add() {
		$this->admin_priv('surplus_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.surplus_add')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' .RC_Lang::get('user::users.add_account_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:充值和提现申请#.E6.B7.BB.E5.8A.A0.E7.94.B3.E8.AF.B7" target="_blank">'.RC_Lang::get('user::users.about_add_account').'</a>') . '</p>'
		);
		$this->assign('ur_here',		RC_Lang::get('user::user_account.surplus_add'));
		
		$type = empty($_GET['type']) ? 'recharge' : $_GET['type'];
		if ($type == 'recharge') {
			$this->assign('action_link',	array('href' => RC_Uri::url('finance/admin_account/init', array('type' => $type)), 'text' => RC_Lang::get('user::user_account.recharge_order')));
		} elseif ($type == 'widthdraw'){
			$this->assign('action_link',	array('href' => RC_Uri::url('finance/admin_account/init', array('type' => $type)), 'text' => RC_Lang::get('user::user_account.withdraw_apply')));
		}
				
		/* 获得支付方式列表, 不包括“货到付款” */
		$payment = get_payment();
		
		$this->assign('payment',		$payment);
		$this->assign('type',		$_GET['type']);
		$this->assign('form_action',	RC_Uri::url('finance/admin_account/insert'));
		
		$this->display('admin_account_edit.dwt');
	}

	/**
	 * 添加充值提现申请
	 */
	public function insert() {
		$this->admin_priv('surplus_manage');
		
		/* 初始化变量 */
		$id				= isset($_POST['id'])				? intval($_POST['id'])				: 0;
		$is_paid		= !empty($_POST['is_paid'])			? intval($_POST['is_paid'])			: 0;
		$amount			= !empty($_POST['amount'])			? floatval($_POST['amount'])		: 0;
		$process_type	= !empty($_POST['process_type'])	? intval($_POST['process_type'])	: 0;
		$user_mobile		= !empty($_POST['user_mobile'])		? trim($_POST['user_mobile'])			: '';
		$admin_note		= !empty($_POST['admin_note'])		? trim($_POST['admin_note'])		: '';
		$user_note		= !empty($_POST['user_note'])		? trim($_POST['user_note'])			: '';
		$payment		= !empty($_POST['payment'])			? trim($_POST['payment'])			: '';
		$payment		= !empty($_POST['payment'])			? trim($_POST['payment'])			: '';
		$amount_count   = $amount;

		/* 验证参数有效性  */
		if (!is_numeric($amount) || empty($amount) || $amount <= 0 || strpos($amount, '.') > 0) {
			return $this->showmessage(RC_Lang::get('user::user_account.js_languages.deposit_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$user_info = RC_DB::table('users')->where('mobile_phone', $user_mobile)->first();
		/* 此会员是否存在 */
		if (empty($user_info)) {
			return $this->showmessage(RC_Lang::get('user::user_account.username_not_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($payment)) {
			return $this->showmessage(RC_Lang::get('user::user_account.js_languages.pay_code_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 退款，检查余额是否足够 */
		if ($process_type == 1) {
			$user_account = get_user_surplus($user_info['user_id']);
			/* 如果扣除的余额多于此会员拥有的余额，提示 */
			if ($amount > $user_account) {
				return $this->showmessage(RC_Lang::get('user::user_account.surplus_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		/* 入库的操作 */
		if ($process_type == 1) {
			$amount = (-1) * $amount;
		}
		
		/*金额必须为1元起*/
		if ($amount < 1) {
			return $this->showmessage(RC_Lang::get('user::user_account.min_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$order_sn = $this->get_order_sn();
		
		$data = array(
			'user_id'		=> $user_info['user_id'],
			'admin_user'	=> $_SESSION['admin_name'],
			'amount'		=> $amount,
			'add_time'		=> RC_Time::gmtime(),
			'admin_note'	=> $admin_note,
			'user_note'		=> $user_note,
			'process_type'	=> $process_type,
			'payment'		=> $payment,
			'is_paid'		=> $is_paid,
			'order_sn'		=> $order_sn,
		);
		if ($is_paid == 1) {
			$data['paid_time']		= RC_Time::gmtime();
		}
		
		
		RC_DB::table('user_account')->insertGetId($data);
		/* 更新会员余额数量 */
		if ($is_paid == 1) {
			$change_desc = $amount > 0 ? RC_Lang::get('user::user_account.surplus_type.0') : RC_Lang::get('user::user_account.surplus_type.1');
			$change_type = $amount > 0 ? ACT_SAVING : ACT_DRAWING;
			change_account_log($user_info['user_id'] , $amount , 0 , 0 , 0 , $change_desc , $change_type);
		}
		
		/* 如果是预付款并且未确认，向pay_log插入一条记录 */
		if ($process_type == 0 && $is_paid == 0) {
			/* 取支付方式信息 */
			$payment_info = array();
			$payment_info = RC_DB::table('payment')->where('pay_name', $payment)->where('enabled', 1)->first();
			RC_Loader::load_app_func('admin_order', 'orders');
			/* 计算支付手续费用 */
			$pay_fee	  = pay_fee($payment_info['pay_id'], $amount, 0);
			$total_fee	  = $pay_fee + $amount;
		
			/* 插入 pay_log */
			$data = array(
				'order_id'		=> $id,
				'order_amount'	=> $total_fee,
				'order_type'	=> PAY_SURPLUS,
				'is_paid'		=> 0,
			);
			RC_DB::table('pay_log')->insertGetId($data);
		}
		if ($process_type == 0) {
			$account = RC_Lang::get('user::user_account.deposit');
		} else {
			$account = RC_Lang::get('user::user_account.withdraw');
		}
		
		$type = empty($_POST['type']) ? 'recharge' : $_POST['type'];
		
		ecjia_admin::admin_log(RC_Lang::get('user::user_account.log_username').$user_info['user_name'].','.$account.$amount, 'add', 'user_account');

		if ($type == 'recharge') {
			$links[0]['text'] = RC_Lang::get('user::user_account.back_recharge_list');
		} elseif ($type == 'withdraw'){
			$links[0]['text'] = RC_Lang::get('user::user_account.back_withdraw_list');
		}
		
		$links[0]['href'] = RC_Uri::url('finance/admin_account/init', array('type' => $type));
		$links[1]['text'] = RC_Lang::get('user::user_account.continue_add');
		$links[1]['href'] = RC_Uri::url('finance/admin_account/add', array('type' => $type));
		
		return $this->showmessage(RC_Lang::get('user::user_account.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('finance/admin_account/init', array('type' => $type))));
	}
	
	/**
	 * 编辑充值提现申请
	 */
	public function edit() {
		$this->admin_priv('surplus_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.surplus_edit')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' . RC_Lang::get('user::users.edit_account_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:充值和提现申请#.E6.B7.BB.E5.8A.A0.E7.94.B3.E8.AF.B7" target="_blank">'.RC_Lang::get('user::users.about_edit_account').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('user::user_account.surplus_edit'));
		
		$type = empty($_GET['type']) ? 'recharge' : $_GET['type'];
		
		if ($type == 'recharge') {
			$this->assign('action_link', array('text' => RC_Lang::get('user::user_account.recharge_order'), 'href' => RC_Uri::url('finance/admin_account/init'), array('type'=> $type)));
		} elseif ($type == 'widthdraw'){
			$this->assign('action_link', array('text' => RC_Lang::get('user::user_account.withdraw_apply'), 'href' => RC_Uri::url('finance/admin_account/init'), array('type'=> $type)));
		}
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
		/* 查询当前的预付款信息 */
		$account = array();
		$account = RC_DB::table('user_account')->where('id', $id)->first();
		
		$account['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $account['add_time']);
		$user_mobile = RC_DB::table('users')->where('user_id', $account['user_id'])->pluck('mobile_phone');
		
		$account['user_note']	= htmlspecialchars($account['user_note']);
		$account['payment']		= strip_tags($account['payment']);
		$account['amount']		= abs($account['amount']);

		/* 模板赋值 */
		$this->assign('surplus', $account);
		$this->assign('user_mobile', $user_mobile);
		$this->assign('id', $id);
		$this->assign('type',  $_GET['type']);
		
		$this->assign('form_action', RC_Uri::url('finance/admin_account/update'));

		$this->display('admin_account_check.dwt');
	}
	
	/**
	 * 更新充值提现申请
	 */
	public function update() {
		/* 权限判断 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		$id				= isset($_POST['id'])			? intval($_POST['id'])			: 0;	
		$admin_note		= !empty($_POST['admin_note'])	? trim($_POST['admin_note'])	: '';
		$user_note		= !empty($_POST['user_note'])	? trim($_POST['user_note'])		: '';
		$user_mobile		= !empty($_POST['user_mobile'])	? trim($_POST['user_mobile'])		: '';
		
		$info = RC_DB::table('user_account')->where('id', $id)->first();
		
		if (!empty($info['order_sn'])) {
			$order_sn = $info['order_sn'];
		} else {
			$order_sn = $this->get_order_sn();
		}
		
		/* 更新数据表 */
		$data = array(
			'admin_note'	=> $admin_note,
			'user_note'		=> $user_note,
			'order_sn'		=> $order_sn
		);
		RC_DB::table('user_account')->where('id', $id)->update($data);
		
		if ($info['process_type'] == 0) {
			$account = RC_Lang::get('user::user_account.deposit');
		} else {
			$account = RC_Lang::get('user::user_account.withdraw');
			$info['amount'] = abs($info['amount']);
		}
		
		ecjia_admin::admin_log(RC_Lang::get('user::user_account.log_username').$user_name.','.$account.$info['amount'], 'edit', 'user_account');
		
		$type = empty($_POST['type']) ? 'recharge' : $_POST['type'];
		
		if ($type == 'recharge') {
			$links[0]['text'] = RC_Lang::get('user::user_account.back_recharge_list');
		} elseif ($type == 'withdraw'){
			$links[0]['text'] = RC_Lang::get('user::user_account.back_withdraw_list');
		}
		
		$links[0]['href'] = RC_Uri::url('finance/admin_account/init', array('type' => $_POST['type']));
		return $this->showmessage(RC_Lang::get('user::user_account.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
	}
	
	/**
	 * 审核会员余额页面
	 */
	public function check() {
		$this->admin_priv('surplus_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.check')));
		$this->assign('ur_here', RC_Lang::get('user::user_account.check'));
		
		$type = empty($_GET['type']) ? 'recharge' : $_GET['type'];
		
		if ($type == 'recharge') {
			$this->assign('action_link', array('text' => '充值订单', 'href' => RC_Uri::url('finance/admin_account/init', array('type' => $type))));
		} elseif ($type == 'withdraw') {
			$this->assign('action_link', array('text' => '提现申请', 'href' => RC_Uri::url('finance/admin_account/init', array('type' => $type))));
		}
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

		/* 查询当前的预付款信息 */
		$account = array();
		$account = RC_DB::table('user_account')->where('id', $id)->first();
		
		$account['add_time']    = RC_Time::local_date(ecjia::config('time_format'), $account['add_time']);
		$account['user_note']	= htmlspecialchars($account['user_note']);
		
		$user_name    = RC_DB::table('users')->where('user_id', $account['user_id'])->pluck('user_name');
		$payment_name = RC_DB::table('payment')->where('pay_code', $account['payment'])->pluck('pay_name');
		
		$account['payment']	= empty($payment_name) ? strip_tags($account['payment']) : strip_tags($payment_name);
		$account['amount']	= abs($account['amount']);
		
		$this->assign('surplus',		$account);
		$this->assign('user_name',		$user_name);
		$this->assign('id',				$id);
		$this->assign('check_action',	RC_Uri::url('finance/admin_account/action'));
		$this->assign('is_check',		1);
		$this->assign('type',  $type);
		
		$this->display('admin_account_check.dwt');
	}
	
	/**
	 * 更新会员余额的状态
	 */
	public function action() {
		/* 检查权限 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		/* 初始化 */
		$id			= isset($_POST['id'])			? intval($_POST['id'])			: 0;
		$is_paid	= isset($_POST['is_paid'])		? intval($_POST['is_paid'])		: 0;
		$admin_note	= isset($_POST['admin_note'])	? trim($_POST['admin_note'])	: '';
		
		/* 查询当前的预付款信息 */
		$account	= array();
		$account	= RC_DB::table('user_account')->where('id', $id)->first();
		$amount		= $account['amount'];
		
		/* 如果是退款申请, 并且已完成,更新此条记录,扣除相应的余额 */
		if ($is_paid == '1') {
			if ($account['process_type'] == '1') {
				$user_account = get_user_surplus($account['user_id']);
				$fmt_amount   = str_replace('-', '', $amount);
				
				/* 如果扣除的余额多于此会员拥有的余额，提示 */
				if ($fmt_amount > $user_account) {
					return $this->showmessage(RC_Lang::get('user::user_account.surplus_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				
				update_user_account($id, $amount, $admin_note, 1);
				
				/* 更新会员余额数量 */
				change_account_log($account['user_id'], $amount, 0, 0, 0, RC_Lang::get('user::user_account.surplus_type.1'), ACT_DRAWING);
			} else {
				/* 如果是预付款，并且已完成, 更新此条记录，增加相应的余额 */
				update_user_account($id, $amount, $admin_note, 1);
				
				/* 更新会员余额数量 */
				change_account_log($account['user_id'], $amount, 0, 0, 0, RC_Lang::get('user::user_account.surplus_type.0'), ACT_SAVING);
			}
		} else {
			/* 否则更新信息 */
			$data = array(
				'admin_user'	=> $_SESSION['admin_name'],
				'admin_note'	=> $admin_note,
				'is_paid'		=> $is_paid,
			);
			RC_DB::table('user_account')->where('id', $id)->update($data);
		}
		
		ecjia_admin::admin_log('(' . addslashes(RC_Lang::get('user::user_account.check')) . ')' . $admin_note, 'check', 'user_surplus');
		
		$type = empty($_POST['type']) ? 'recharge' : $_POST['type'];
		
		if ($type == 'recharge') {
			$links[0]['text'] = RC_Lang::get('user::user_account.back_recharge_list');
		} elseif ($type == 'withdraw'){
			$links[0]['text'] = RC_Lang::get('user::user_account.back_withdraw_list');
		}
		
		$links[0]['href'] = RC_Uri::url('finance/admin_account/init', array('type'=> $type));
		return $this->showmessage(RC_Lang::get('user::user_account.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
	}
	
	/**
	 * ajax删除一条信息
	 */
	public function remove() {
		$db_view    = RC_Model::model('user_account_viewmodel', ecjia::MSGTYPE_JSON);
		/* 检查权限 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		$id 		= intval($_GET['id']);
		
		$user_account_info = RC_DB::table('user_account')->where('id', $id)->first();
		$name = RC_DB::table('users')->where('user_id', $user_account_info['user_id'])->pluck('user_name');
		
		$user_name 	= empty($name) ? RC_Lang::get('user::users.no_name') : $name;
		
		RC_DB::table('user_account')->where('id', $id)->delete();
		ecjia_admin::admin_log(addslashes($user_name), 'remove', 'user_account');
		return $this->showmessage(RC_Lang::get('user::user_account.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 批量删除
	 */
	public function batch_remove() {
		/* 检查权限 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (isset($_POST['checkboxes'])) {
			$idArr = explode(',', $_POST['checkboxes']);
			$count = count($idArr);
			$data = RC_DB::table('user_account AS ua')
				->leftJoin('users as u', RC_DB::raw('ua.user_id'), '=', RC_DB::raw('u.user_id'))
				->select(RC_DB::raw('ua.*, u.user_name'))
				->whereIn(RC_DB::raw('ua.id'), $idArr)
				->get();
			
			if (RC_DB::table('user_account')->whereIn('id', $idArr)->delete()) {
				foreach ($data as $v) {
					if ($v['process_type'] == 1) {
						$amount = (-1) * $v['amount'];
						ecjia_admin::admin_log(sprintf(RC_Lang::get('user::user_account.user_name_is'), $v['user_name']).sprintf(RC_Lang::get('user::user_account.money_is'), price_format($amount)), 'batch_remove', 'withdraw_apply');
					} else {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('user::user_account.user_name_is'), $v['user_name']).sprintf(RC_Lang::get('user::user_account.money_is'), price_format($v['amount'])), 'batch_remove', 'pay_apply');
					}
				}
				return $this->showmessage(sprintf(RC_Lang::get('user::user_account.delete_record_count'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('finance/admin_account/init')));
			}
		} else {
			return $this->showmessage(RC_Lang::get('user::user_account.select_operate_item'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 充值提现详情
	 */
	public function info() {
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('订单详情'));
		$this->assign('ur_here', '订单详情');
		$type = empty($_GET['type']) ? 'recharge' : $_GET['type'];
		
		if ($type == 'recharge') {
			$this->assign('action_link', array('text' => '充值订单', 'href' => RC_Uri::url('finance/admin_account/init', array('type' => $type))));
		} elseif ($type == 'withdraw') {
			$this->assign('action_link', array('text' => '提现申请', 'href' => RC_Uri::url('finance/admin_account/init', array('type' => $type))));
		}
		
		$order_sn = isset($_GET['order_sn']) ? $_GET['order_sn'] : '';
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		
		$account_info 				= RC_DB::table('user_account')->where('id', $id)->first();
		$account_info['user_name']  = RC_DB::table('users')->where('user_id', $account_info['user_id'])->pluck('user_name');
		$account_info['pay_name'] 	= RC_DB::table('payment')->where('pay_code', $account_info['payment'])->pluck('pay_name');
		$account_info['amount']		= abs($account_info['amount']);
		$account_info['user_note']	= htmlspecialchars($account_info['user_note']);
		$account_info['add_time']   = RC_Time::local_date(ecjia::config('time_format'), $account_info['add_time']);
		$account_info['pay_time']   = RC_Time::local_date(ecjia::config('time_format'), $account_info['paid_time']);
		
		//订单流程状态
		if ($account_info['is_paid'] == 0) {
			$is_paid = 0;
		}elseif ($account_info['is_paid'] == 1) {
				$is_paid = 1;
		} elseif($account_info['is_paid'] == 2) {
				$is_paid = 2;
		}
		$this->assign('is_paid', $is_paid);
		
		$this->assign('check_action',	RC_Uri::url('finance/admin_account/action'));
		$this->assign('form_action', RC_Uri::url('finance/admin_account/update'));
		
		$this->assign('account_info',  $account_info);
		$this->assign('order_sn',  $order_sn);
		$this->assign('id',  $id);
		$this->assign('type',  $_GET['type']);
		$this->display('admin_account_info.dwt');
	}
	
	/**
	 * 账户信息ajax验证
	 */
	public function validate_acount() {
		$user_mobile =  empty($_POST['user_mobile']) ? 0 : $_POST['user_mobile'];
		
		if (empty($user_mobile)) {
			return $this->showmessage('会员手机号码不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$user_info = RC_DB::table('users')->where('mobile_phone', $user_mobile)->first();
		if (empty($user_info)) {
			return $this->showmessage('会员信息不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$result = array();
		$result = array('status' => 1, 'username' => $user_info['user_name']);
		die(json_encode($result));
	}
	
	/**
	 * 得到新订单号
	 * @return  string
	 */
	private function get_order_sn() {
		/* 选择一个随机的方案 */
		mt_srand((double) microtime() * 1000000);
		return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
	}
}

// end