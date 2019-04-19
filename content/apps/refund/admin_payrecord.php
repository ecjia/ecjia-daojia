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
use Ecjia\App\Refund\Notifications\RefundBalanceArrived;

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 交易退款管理
 * @author songqianqian
 */
class admin_payrecord extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_class('RefundReasonList', 'refund', false);

        Ecjia\App\Refund\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url() . '/statics/lib/dropper-upload/jquery.fs.dropper.js', array(), false, true);
        RC_Script::enqueue_script('jquery-imagesloaded');
        RC_Script::enqueue_script('jquery-colorbox');
        RC_Style::enqueue_style('jquery-colorbox');

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');

        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));

        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        RC_Loader::load_app_class('RefundStatusLog', 'refund', false);
        RC_Loader::load_app_class('RefundOrderInfo', 'refund', false);

        //时间控件
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
        RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));

        RC_Script::enqueue_script('admin_payrecord', RC_App::apps_url('statics/js/admin_payrecord.js', __FILE__));
        RC_Style::enqueue_style('admin_payrecord', RC_App::apps_url('statics/css/admin_payrecord.css', __FILE__));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('交易退款', 'refund'), RC_Uri::url('refund/admin_payrecord/init')));
    }

    /**
     * 交易退款
     */
    public function init()
    {
        $this->admin_priv('payrecord_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('交易退款', 'refund')));
        $this->assign('ur_here', __('交易退款', 'refund'));

        $data = $this->payrecord_list();
        if (empty($data['filter']['back_type'])) {
            $data['filter']['back_type'] = 'wait';
        }
        $this->assign('filter', $data['filter']);
        $this->assign('data', $data);

        $this->assign('search_action', RC_Uri::url('refund/admin_payrecord/init'));

        $this->display('payrecord_list.dwt');
    }

    /**
     * 交易退款查看详情
     */
    public function detail()
    {
        $this->admin_priv('payrecord_manage');


        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('退款详情', 'refund')));
        $this->assign('ur_here', __('退款详情', 'refund'));

        $this->assign('action_link', array('text' => __('交易退款', 'refund'), 'href' => RC_Uri::url('refund/admin_payrecord/init')));

        $refund_id = intval($_GET['refund_id']);
        $this->assign('refund_id', $refund_id);

        //获取用户退货退款原因
        $reason_list = RefundReasonList::get_refund_reason();
        $this->assign('reason_list', $reason_list);

        //退款上传凭证素材
        $refund_img_list = RC_DB::table('term_attachment')->where('object_id', $refund_id)->where('object_app', 'ecjia.refund')->where('object_group', 'refund')->select('file_path', 'file_name')->get();
        $this->assign('refund_img_list', $refund_img_list);

        //打款表信息
        $payrecord_info = RC_DB::table('refund_payrecord')->where('refund_id', $refund_id)->first();
        if ($payrecord_info['add_time']) {
            $payrecord_info['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $payrecord_info['add_time']);
        }
        if ($payrecord_info['action_back_time']) {
            $payrecord_info['action_back_time'] = RC_Time::local_date(ecjia::config('time_format'), $payrecord_info['action_back_time']);
        }

        //支持原路退回的支付插件
        $pay_original = config('app-refund::refund_original.pay_code');
        if (in_array($payrecord_info['back_pay_code'], $pay_original)) {
            $payrecord_info['back_pay_type'] = 'original'; //原路退回
        } else {
        	if ($payrecord_info['back_pay_code'] == 'pay_wxpay_merchant') {
        		$payrecord_info['back_pay_type'] = 'original';//商家微信支付的只能原路退回
        	} else {
        		$payrecord_info['back_pay_type'] = 'surplus';
        	}
            
        }

        //原路退回，支付手续费退还
        if (empty($payrecord_info['action_back_type'])) { //未确认退款方式是原路退还是退余额
            if ($payrecord_info['back_pay_type'] == 'original') {
                $payrecord_info['real_back_money_total'] = $payrecord_info['back_money_total'] + $payrecord_info['back_pay_fee'];
            } else {
                $payrecord_info['real_back_money_total'] = $payrecord_info['back_money_total'];
            }
        } else {
            $payrecord_info['real_back_money_total'] = $payrecord_info['back_money_total'];
        }

        //退款金额
        if (in_array($payrecord_info['back_pay_code'], ['pay_balance', 'pay_cash'])) {
        	//余额支付和现金支付不退还支付手续费
        	$refund_total_amount = ecjia_price_format(($payrecord_info['order_money_paid'] - $payrecord_info['back_pay_fee']), false);
        } else {
        	$refund_total_amount = ecjia_price_format($payrecord_info['order_money_paid'], false);
        }
        
        $payrecord_info['order_money_paid_type']  = $refund_total_amount;
        $payrecord_info['back_money_total_type']  = ecjia_price_format($payrecord_info['real_back_money_total'], false);
        $payrecord_info['back_pay_fee_type']      = price_format($payrecord_info['back_pay_fee']);
        $payrecord_info['back_shipping_fee_type'] = price_format($payrecord_info['back_shipping_fee']);
        $payrecord_info['back_insure_fee_type']   = price_format($payrecord_info['back_insure_fee']);
        $payrecord_info['back_inv_tax_type']      = price_format($payrecord_info['back_inv_tax']);
        
        $this->assign('payrecord_info', $payrecord_info);

        //售后订单信息
        $refund_info = RefundOrderInfo::get_refund_order_info($refund_id);
        $this->assign('refund_info', $refund_info);

        //退款流水
        $payment_refund = RC_DB::table('payment_refund')->where('order_sn', $refund_info['order_sn'])->first();
        if ($payment_refund) {
            $payment_refund['refund_create_time']  = empty($payment_refund['refund_create_time']) ? '' : RC_Time::local_date('Y-m-d H:i:s', $payment_refund['refund_create_time']);
            $payment_refund['refund_confirm_time'] = empty($payment_refund['refund_confirm_time']) ? '' : RC_Time::local_date('Y-m-d H:i:s', $payment_refund['refund_confirm_time']);
            $payment_refund['label_refund_status'] = $this->label_refund_status($payment_refund['refund_status']);
        } else {
            $payment_refund = [];
        }
        $this->assign('payment_refund', $payment_refund);

        //售后表实付金额计算
        $refund_total_amount = price_format($refund_info['money_paid'] + $refund_info['surplus']);
        $this->assign('refund_total_amount', $refund_total_amount);

        $this->assign('form_action', RC_Uri::url('refund/admin_payrecord/update'));

        $this->assign('original_img', RC_App::apps_url('statics/images/original_pic.png', __FILE__));
        $this->assign('surplus_img', RC_App::apps_url('statics/images/surplus_pic.png', __FILE__));
        $this->assign('selected_img', RC_App::apps_url('statics/images/selected.png', __FILE__));
        $this->assign('pay_wxpay_img', RC_App::apps_url('statics/images/pay_wxpay_img.png', __FILE__));

        $this->display('payrecord_detail.dwt');
    }


    /**
     * 处理打款逻辑
     */
    public function update()
    {
        $this->admin_priv('payrecord_manage');

        $id               = intval($_POST['id']);
        $refund_id        = intval($_POST['refund_id']);
        $refund_type      = trim($_POST['refund_type']);
        $back_type        = $_POST['back_type'];
        $back_money_total = $_POST['back_money_total'];
        $back_content     = trim($_POST['back_content']);
        $back_money_total = sprintf("%.2f", $back_money_total);
        if (empty($back_content)) {
            return $this->showmessage(__('请输入退款备注', 'refund'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //用户表和资金变动表变动
        $refund_order = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
        
        if (empty($refund_order)) {
            return $this->showmessage(__('退款单信息不存在', 'refund'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if ($back_type == 'surplus') {
			//商家小程序微信支付的，不支持退回余额
			if ($refund_order['pay_code'] == 'pay_wxpay_merchant') {
				return $this->showmessage(__('商家微信支付的订单不支持退回余额，请选择原路退回。', 'refund'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
        	$result = (new Ecjia\App\Payment\Refund\RefundManager($refund_order['order_sn'], null, null))->refundToBalance($back_money_total, $_SESSION['admin_name']);
        	if (is_ecjia_error($result)) {
        		return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}

            //更新打款表
            (new \Ecjia\App\Refund\Models\RefundPayRecordModel)->updateRefundPayrecord($id, 'surplus', $back_content, $_SESSION['admin_id'], $_SESSION['admin_name']);

            //更新refund_order_action表打款操作人信息
            RC_DB::table('refund_order_action')->where('refund_id', $refund_id)->where('refund_status', \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_TRANSFERED)->update(array('action_user_type' => 'admin', 'action_user_id' => $_SESSION['admin_id'], 'action_user_name' => $_SESSION['admin_name']));

            ecjia_admin::admin_log('[' . $refund_order['refund_sn'] . ']', 'payrecord', 'refund_order');
            return $this->showmessage(__('退款操作成功', 'refund'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('refund/admin_payrecord/detail', array('refund_id' => $refund_id))));

        } elseif ($back_type == 'original') {
            //打款表信息
            $payrecord_info = RC_DB::table('refund_payrecord')->where('refund_id', $refund_id)->first();

            $result = (new Ecjia\App\Payment\Refund\RefundManager($refund_order['order_sn'], null, null))->refund($back_money_total, $payrecord_info['action_user_name']);
            if (is_ecjia_error($result)) {
                return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            //更新打款表实际退款金额
            RC_DB::table('refund_payrecord')->where('id', $id)->update(array('back_money_total' => $back_money_total));
            //更新打款表
            (new \Ecjia\App\Refund\Models\RefundPayRecordModel)->updateRefundPayrecord($id, 'original', $back_content, $_SESSION['admin_id'], $_SESSION['admin_name']);

            ecjia_admin::admin_log('[' . $refund_order['refund_sn'] . ']', 'payrecord', 'refund_order');
            return $this->showmessage(__('退款申请已提交，等待微信到款通知即可', 'refund'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('refund/admin_payrecord/detail', array('refund_id' => $refund_id))));
        }

    }

    //对账查询
    public function query()
    {
        /* 检查权限 */
        $this->admin_priv('payrecord_manage', ecjia::MSGTYPE_JSON);

        $result = [];

        if (is_ecjia_error($result)) {
            return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        return $this->showmessage(__('与支付机构对账成功，状态正常', 'refund'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 获取交易退款列表
     */
    private function payrecord_list()
    {
        $db_refund_view = RC_DB::table('refund_payrecord as rp')
            ->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('rp.store_id'));

        $filter['start_date'] = $_GET['start_date'];
        $filter['end_date']   = $_GET['end_date'];
        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $filter['start_date'] = RC_Time::local_strtotime($filter['start_date']);
            $filter['end_date']   = RC_Time::local_strtotime($filter['end_date']);
            $db_refund_view->where('add_time', '>=', $filter['start_date']);
            $db_refund_view->where('add_time', '<', $filter['end_date'] + 86400);
        }

        $filter['keywords'] = trim($_GET['keywords']);
        if ($filter['keywords']) {
            $db_refund_view->whereRaw('(refund_sn  like  "%' . mysql_like_quote($filter['keywords']) . '%"  or s.merchants_name like "%' . mysql_like_quote($filter['keywords']) . '%")');
        }

        $refund_type = $_GET['refund_type'];
        if (!empty($refund_type)) {
            $db_refund_view->where('refund_type', $refund_type);
        }

        $filter['back_type'] = trim($_GET['back_type']);
        $refund_count        = $db_refund_view->select(
            RC_DB::raw('SUM(IF(action_back_time = 0, 1, 0)) as wait'),
            RC_DB::raw('SUM(IF(action_back_time > 0, 1, 0)) as have'))->first();

        if ($filter['back_type'] == 'wait' || $filter['back_type'] == '') {
            $db_refund_view->whereNull(RC_DB::raw('action_back_type'));
        }

        if ($filter['back_type'] == 'have') {
            $db_refund_view->whereNotNull(RC_DB::raw('action_back_type'));
        }
        $count = $db_refund_view->count();
        $page  = new ecjia_page($count, 10, 5);
        $data  = $db_refund_view
            ->select('id', 'order_sn', 'order_id', 'refund_sn', 'back_pay_name', 'back_pay_code', 'refund_id', 'refund_type', 'order_money_paid', 'back_pay_fee', 'back_surplus', 'action_back_time', 'action_back_type', 'add_time', RC_DB::raw('s.merchants_name'))
            ->orderby('id', 'DESC')
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();
        $list  = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                $row['action_back_time'] = RC_Time::local_date('Y-m-d H:i:s', $row['action_back_time']);
                $row['add_time']         = RC_Time::local_date('Y-m-d H:i:s', $row['add_time']);
                $row['shipping_status']  = RC_DB::table('order_info')->where('order_id', $row['order_id'])->pluck('shipping_status');
                //退款金额
                if (in_array($row['back_pay_code'], ['pay_balance', 'pay_cash'])) {
                	//余额支付和现金支付不退还支付手续费
                	$refund_total_amount = ecjia_price_format(($row['order_money_paid'] - $row['back_pay_fee']), false);
                } else {
                	$refund_total_amount = ecjia_price_format($row['order_money_paid'], false);
                }
                $row['order_money_paid'] = $refund_total_amount;
                
                $list[]                  = $row;
            }
        }
        return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $refund_count);
    }


    /**
     * 退款状态处理
     */
    private function label_refund_status($refund_status)
    {
        $label_refund_status = '';
        if ($refund_status == '0') {
            $label_refund_status = __('待处理', 'refund');
        } elseif ($refund_status == '1') {
            $label_refund_status = __('已退款', 'refund');
        } elseif ($refund_status == '2') {
            $label_refund_status = __('退款处理中', 'refund');
        } elseif ($refund_status == '11') {
            $label_refund_status == __('退款失败', 'refund');
        } elseif ($refund_status == '12') {
            $label_refund_status = __('退款关闭', 'refund');
        }
        return $label_refund_status;
    }
}

//end