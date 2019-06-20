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
 * 用户充值/提现记录详情
 * @author zrl
 */
class user_account_record_detail_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        if ($_SESSION['user_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }
        $account_id = $this->requestData('account_id', 0);
        $user_id    = $_SESSION['user_id'];

        if (empty($account_id)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'user'), __CLASS__));
        }

        $account_info = RC_Api::api('user', 'user_account_info', array('account_id' => intval($account_id)));

        if (is_ecjia_error($account_info)) {
            return $account_info;
        }

        if (empty($account_info)) {
            return new ecjia_error('user_account_info_error', __('充值/提现记录不存在！', 'user'));
        }
        //数据处理
        $formatted_account_info = $this->getFormatInfo($account_info);

        return $formatted_account_info;
    }


    /**
     * 用户充值/提现数据处理
     */
    private function getFormatInfo($account_info = array())
    {
        $format_data = array();
        if ($account_info) {
            $payment_info = array();
            if ($account_info['payment']) {
                $payment_info = RC_DB::table('payment')->where('pay_code', $account_info['payment'])->first();
            }
            //支付状态
            if ($account_info['is_paid'] == '1') {
                $pay_status = __('已完成', 'user');
            } elseif ($account_info['is_paid'] == '2') {
                $pay_status = __('已取消', 'user');
            } else {
                $pay_status = __('未确认', 'user');
            }

            if ($account_info['payment'] == 'withdraw_cash') {
                $pay_name = $account_info['payment_name'];
            } elseif ($account_info['payment'] == 'withdraw_wxpay') {
                $pay_name = $account_info['bank_name'] . ' (' . $account_info['cardholder'] . ')';
            } else {
                $bank_card_str = substr($account_info['bank_card'], -4);
                $pay_name      = $account_info['bank_name'] . ' (' . $bank_card_str . ')';
            }

            $format_data = array(
                'account_id'       => intval($account_info['id']),
                'order_sn'         => !empty($account_info['order_sn']) ? trim($account_info['order_sn']) : '',
                'user_id'          => intval($account_info['user_id']),
                'admin_user'       => !empty($account_info['admin_user']) ? trim($account_info['admin_user']) : '',
                'amount'           => $account_info['amount'],
                'formatted_amount' => price_format(abs($account_info['amount']), false),
                'user_note'        => empty($account_info['user_note']) ? '' : $account_info['user_note'],
                'type'             => $account_info['process_type'] == 0 ? 'deposit' : 'withdraw',
                'lable_type'       => $account_info['process_type'] == 0 ? __('充值', 'user') : __('提现', 'user'),
                'pay_name'         => $account_info['process_type'] == 0 ? (empty($payment_info['pay_name']) ? '' : $payment_info['pay_name']) : $pay_name,

                'pay_id'                => empty($payment_info['pay_id']) ? '' : intval($payment_info['pay_id']),
                'pay_code'              => empty($account_info['payment']) ? '' : $account_info['payment'],
                'pay_status'            => $pay_status,
                'add_time'              => RC_Time::local_date(ecjia::config('time_format'), $account_info['add_time']),
                'pay_fee'               => $account_info['pay_fee'],
                'formatted_pay_fee'     => price_format($account_info['pay_fee'], false),
                'real_amount'           => $account_info['real_amount'],
                'formatted_real_amount' => price_format($account_info['real_amount'], false),
                'bank_name'             => empty($account_info['bank_name']) ? '' : $account_info['bank_name'],
                'bank_card'             => empty($account_info['bank_card']) ? '' : $account_info['bank_card'],
                'cardholder'            => empty($account_info['cardholder']) ? '' : $account_info['cardholder'],
            );
        }

        return $format_data;
    }
}

// end