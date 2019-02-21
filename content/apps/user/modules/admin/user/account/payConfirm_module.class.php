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
 * 商家给用户充值，充值订单支付确认
 * @author zrl
 *
 */
class payConfirm_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }
        $device = $this->device;

        /* 获取请求当前数据的device信息*/
        $codes = RC_Loader::load_app_config('cashier_device_code', 'cashier');
        if (!is_array($device) || !isset($device['code']) || !in_array($device['code'], $codes)) {
            return new ecjia_error('caskdesk_error', __('非收银台请求！', 'user'));
        }

        $account_id = $this->requestData('account_id');

        if (empty($account_id)) {
            return new ecjia_error('invalid_parameter', __('参数错误', 'user'));
        }

        /* 查询充值订单信息 */
        $user_account_info = RC_DB::table('user_account')->where('id', $account_id)->first();

        if (empty($user_account_info)) {
            return new ecjia_error('deposit_log_not_exist', __('充值记录不存在', 'user'));
        }
        $payment_method = new Ecjia\App\Payment\PaymentPlugin();
        $pay_info       = $payment_method->getPluginDataByCode($user_account_info['payment']);

        $payment_handler = $payment_method->channel($user_account_info['payment']);

        /* 判断是否有支付方式有没*/
        if (is_ecjia_error($payment_handler)) {
            return $payment_handler;
        }

        if (in_array($pay_info['pay_code'], array('pay_koolyun_alipay', 'pay_koolyun_unionpay', 'pay_koolyun_wxpay', 'pay_shouqianba'))) {
            $result = RC_Api::api('finance', 'surplus_order_paid', array('order_sn' => $user_account_info['order_sn'], 'money' => $user_account_info['amount']));
            if (is_ecjia_error($result)) {
                return $result;
            } else {
                $data       = array(
                    'account_id'       => $user_account_info['id'],
                    'amount'           => $user_account_info['amount'],
                    'formatted_amount' => price_format($user_account_info['amount'], false),
                    'pay_code'         => $pay_info['pay_code'],
                    'pay_name'         => $pay_info['pay_name'],
                    'pay_status'       => 'success',
                    'desc'             => __('订单支付成功！', 'user')
                );
                $print_data = $this->_get_print_data($user_account_info);
                return array('payment' => $data, 'print_data' => $print_data);
            }
        } else {
            return new ecjia_error('not_support_payment', __('此充值记录对应的支付方式不支持收银台充值支付！', 'user'));
        }
    }

    /**
     * 获取小票打印数据
     */
    private function _get_print_data($user_account_info = array())
    {
        $surplus_print_data = [];
        if (!empty($user_account_info)) {
            $payment_record_info = $this->_paymentRecord_info($user_account_info['order_sn'], 'surplus');
            $pay_name            = RC_DB::table('payment')->where('pay_code', $user_account_info['payment'])->pluck('pay_name');

            $user_info = [];
            //有没用户
            if ($user_account_info['user_id'] > 0) {
                $userinfo = $this->getuserinfo($user_account_info['user_id']);
                if (!empty($userinfo)) {
                    $user_info = array(
                        'user_name'            => empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
                        'mobile'               => empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
                        'user_points'          => $userinfo['pay_points'],
                        'user_money'           => $userinfo['user_money'],
                        'formatted_user_money' => price_format($userinfo['user_money'], false),
                    );
                }
            }

            //充值操作收银员
            $cashier_name = empty($user_account_info['admin_user']) ? '' : $user_account_info['admin_user'];

            $surplus_print_data = array(
                'order_sn'                      => trim($user_account_info['order_sn']),
                'trade_no'                      => empty($payment_record_info['trade_no']) ? '' : $payment_record_info['trade_no'],
                'order_trade_no'                => empty($payment_record_info['order_trade_no']) ? '' : $payment_record_info['order_trade_no'],
                'trade_type'                    => 'surplus',
                'pay_time'                      => empty($user_account_info['paid_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $user_account_info['paid_time']),
                'goods_list'                    => [],
                'total_goods_number'            => 0,
                'total_goods_amount'            => $user_account_info['amount'],
                'formatted_total_goods_amount'  => price_format($user_account_info['amount'], false),
                'total_discount'                => 0,
                'formatted_total_discount'      => '',
                'money_paid'                    => $user_account_info['amount'],
                'formatted_money_paid'          => price_format($user_account_info['amount'], false),
                'integral'                      => 0,
                'integral_money'                => '',
                'formatted_integral_money'      => '',
                'pay_name'                      => empty($pay_name) ? '' : $pay_name,
                'payment_account'               => '',
                'user_info'                     => $user_info,
                'refund_sn'                     => '',
                'refund_total_amount'           => 0,
                'formatted_refund_total_amount' => '',
                'cashier_name'                  => $cashier_name
            );
        }

        return $surplus_print_data;
    }

    /**
     * 用户信息
     */
    private function getuserinfo($user_id = 0)
    {
        $user_info = RC_DB::table('users')->where('user_id', $user_id)->first();
        return $user_info;
    }

    /**
     * 支付交易记录信息
     * @param string $order_sn
     * @param string $trade_type
     * @return array
     */
    private function _paymentRecord_info($order_sn = '', $trade_type = '')
    {
        $payment_revord_info = [];
        if (!empty($order_sn) && !empty($trade_type)) {
            $payment_revord_info = RC_DB::table('payment_record')->where('order_sn', $order_sn)->where('trade_type', $trade_type)->first();
        }
        return $payment_revord_info;
    }
}

// end