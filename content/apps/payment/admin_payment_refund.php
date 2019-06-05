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
 * ECJIA 退款交易流水
 */
class admin_payment_refund extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');		
		
		
		RC_Script::enqueue_script('payment_refund', RC_App::apps_url('statics/js/payment_refund.js',__FILE__),array(), false, 1);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
	
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		//js语言包
		RC_Script::localize_script('payment_refund', 'js_lang', config('app-payment::jslang.payment_refund_page'));
	}

	/**
	 * 退款交易流水
	 */
	public function init() {
	    $this->admin_priv('payment_refund_manage');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('退款流水', 'payment')));
		
		$filter = array();
		
		$payment_refund = $this->get_payment_refund();
		$this->assign('payment_refund', $payment_refund);
		$this->assign('filter', $payment_refund['filter']);
		
		return $this->display('payment_refund_list.dwt');
	}

	
	/**
	 * 退款交易流水详情
	 */
	public function payment_refund_info() {
		$this->admin_priv('payment_refund_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('退款流水', 'payment'), RC_Uri::url('payment/admin_payment_refund/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('查看退款流水', 'payment')));
		$this->assign('ur_here', __('查看退款流水', 'payment'));
		$this->assign('action_link', array('text' => __('退款流水', 'payment'), 'href' => RC_Uri::url('payment/admin_payment_refund/init')));
	
		$id = $_GET['id'];
	
		$payment_refund_info = RC_DB::table('payment_refund')->where('id', $id)->first();
		if (!empty($payment_refund_info)) {
			//退款状态处理
			$payment_refund_info['label_refund_status'] = $this->label_refund_status($payment_refund_info['refund_status']);
			//订单类型处理
			if ($payment_refund_info['order_type'] == 'buy') {
				$payment_refund_info['label_order_type'] = __('消费', 'payment');
			} else {
				$payment_refund_info['label_order_type'] = '';
			}
		}
		//时间处理
		$payment_refund_info['refund_create_time'] 	= !empty($payment_refund_info['refund_create_time']) ? RC_Time::local_date('Y-m-d H:i:s', $payment_refund_info['refund_create_time']) : '';
		$payment_refund_info['refund_confirm_time'] = !empty($payment_refund_info['refund_confirm_time']) ? RC_Time::local_date('Y-m-d H:i:s', $payment_refund_info['refund_confirm_time']) : '';
	
		//获取退款单信息
		$refund_order = RC_DB::table('refund_order')->where('order_sn', $payment_refund_info['order_sn'])->where('status', '<>', 10)->first();
		$refund_order['should_refund_amount'] =  sprintf("%.2f", $refund_order['money_paid'] + $refund_order['surplus']); //应退款金额
		
		//打款单信息
		$refund_payrecord = RC_DB::table('refund_payrecord')->where('refund_id', $refund_order['refund_id'])->first();
		
		$this->assign('payment_refund_info', $payment_refund_info);
		$this->assign('refund_order', $refund_order);
		$this->assign('refund_payrecord', $refund_payrecord);
	
		return $this->display('payment_refund_info.dwt');
	}

    //对账查询
    public function query()
    {
        /* 检查权限 */
        $this->admin_priv('payrecord_manage', ecjia::MSGTYPE_JSON);

        /* 初始化 */
        $id = $this->request->input('id');

        try {

            /* 查询当前的预付款信息 */
            $account = (new Ecjia\App\Payment\Repositories\PaymentRefundRepository())->findPaymentRefundId($id);

            //到款状态不能再次修改
            if (empty($account)) {
                return $this->showmessage(__('该退款流水记录不存在', 'payment'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $result = (new \Ecjia\App\Payment\Refund\RefundQueryManager($account['order_sn']))->refundQuery();

            if (is_ecjia_error($result)) {
                return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            return $this->showmessage(__('与支付机构对账成功，状态正常', 'payment'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }
	
	/**
	 * 退款流水数据
	 */
	private function get_payment_refund()
	{
		$db = RC_DB::table('payment_refund');
		
		$filter['order_sn'] 		= trim($_GET['order_sn']);
		$filter['start_date']		= $_GET['start_date'];
		$filter['end_date']  		= $_GET['end_date'];
		$filter['refund_status']   	= trim($_GET['refund_status']);
		$filter['keywords']			= trim($_GET['keywords']);
		
		
		//时间筛选
		if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
			$filter['start_date']	= RC_Time::local_strtotime($filter['start_date']);
			$filter['end_date']		= RC_Time::local_strtotime($filter['end_date']);
			$db->where('refund_create_time', '>=', $filter['start_date']);
			$db->where('refund_create_time', '<', $filter['end_date'] + 86400);
		}
		
		//退款状态筛选
		if (!empty($filter['refund_status']) &&  $filter['refund_status'] == 'wait') {
			$db->where('refund_status', 0);
		} elseif (!empty($filter['refund_status']) && $filter['refund_status'] == 'refunded') {
			$db->where('refund_status', 1);
		} elseif (!empty($filter['refund_status']) && $filter['refund_status'] == 'processing') {
			$db->where('refund_status', 2);
		} elseif (!empty($filter['refund_status']) && $filter['refund_status'] == 'failed') {
			$db->where('refund_status', 11);
		} elseif (!empty($filter['refund_status']) && $filter['refund_status'] == 'closed') {
			$db->where('refund_status', 12);
		}
		
		//订单号筛选
		if (!empty($filter['order_sn'])) {
			$db->where('order_sn', 'LIKE', '%' . mysql_like_quote($filter['order_sn']) . '%');
		}
		//订单退款流水号和支付公司退款流水号筛选
		$keywords = $filter['keywords'];
		if (!empty($filter['keywords'])) {
			$db->where(function($query) use ($keywords) {
				$query->where('refund_out_no', 'like', '%'.mysql_like_quote($keywords).'%')->orWhere('refund_trade_no', 'like', '%'.mysql_like_quote($keywords).'%');
			});
		}
		
		$count = $db->count();
		
		$page = new ecjia_page($count, 10, 5);
		$data = $db
		->orderby('refund_create_time', 'DESC')
		->take(10)
		->skip($page->start_id-1)
		->get();
		$list = [];
		if (!empty($data)) {
			foreach ($data as $row) {
				//退款状态
				$row['label_refund_status'] = $this->label_refund_status($row['refund_status']);
				$row['refund_create_time']  = !empty($row['refund_create_time']) ? RC_Time::local_date('Y-m-d H:i:s', $row['refund_create_time']) : '';
				$row['refund_confirm_time']  = !empty($row['refund_confirm_time']) ? RC_Time::local_date('Y-m-d H:i:s', $row['refund_confirm_time']) : '';
				$list[] = $row;
			}
		}
		return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
	
	/**
	 * 退款状态处理
	 */
	private function label_refund_status($refund_status)
	{
		$label_refund_status = '';
		if ($refund_status == '0') {
			$label_refund_status = __('待处理', 'payment');
		} elseif ($refund_status == '1') {
			$label_refund_status = __('已退款', 'payment');
		} elseif ($refund_status == '2') {
			$label_refund_status = __('退款处理中', 'payment');
		} elseif ($refund_status == '11') {
			$label_refund_status == __('退款失败', 'payment');
		}elseif ($refund_status == '12') {
			$label_refund_status = __('退款关闭', 'payment');
		}
		return $label_refund_status;
	}
}

// end