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
namespace Ecjia\App\Orders;

use RC_DB;
use RC_Loader;
use order_refund;
use OrderStatusLog;
use RefundStatusLog;
use RC_Time;
use RC_Logger;
use RC_Api;
use Ecjia\App\Refund\RefundBackGoodsStock;

/**
 * 自动拒单
 *
 */
class OrderAutoRefuse
{
    /**
     * 获取店铺自动拒单设置
     * @param integer $store_id
     * @return integer
     */
    public static function StoreOrdersAutoRejectTime($store_id = 0)
    {
        $orders_auto_rejection_time = 0;
        if (!empty($store_id)) {
            $orders_auto_rejection_time = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'orders_auto_rejection_time')->pluck('value');
        }
        return $orders_auto_rejection_time;
    }

    /**
     * 自动拒单；默认退款，流程至商家同意，待平台退款处理
     * @param array $order 订单信息
     * @return bool
     */
    public static function AutoRejectOrder($order = array())
    {

        /**
         * 1、生成退款申请单_produceRefundOrder();
         * 2、更新订单状态&订单操作记录&订单状态记录；及更新售后申请状态记录; _updateWithLogs();
         * 3、订单被拒，发送短信通知_sendOrderCanceledSms();
         * 4、更新结算记录_updateCommissionBill();
         * 5、商家同意退款_merchantAgree();
         */

        RC_Loader::load_app_class('order_refund', 'refund', false);
        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        RC_Loader::load_app_class('RefundStatusLog', 'refund', false);

        //生成退款申请单
        $refund_id = self::_produceRefundOrder($order);
        //更新订单状态&订单操作记录&订单状态记录；及更新售后申请状态记录;
        self::_updateWithLogs($order, $refund_id);
        //订单被拒，发送短信通知
        self::_sendOrderCanceledSms($order);
        //更新结算记录
        self::_updateCommissionBill($refund_id);
        //商家同意退款
        self::_merchantAgree($refund_id);

        return true;
    }


    /**
     * 生成退款申请单
     */
    private static function _produceRefundOrder($order)
    {
        $reasons        = RC_Loader::load_app_config('refund_reasons', 'refund');
        $auto_refuse    = $reasons['auto_refuse'];
        $refund_reason  = $auto_refuse['0']['reason_id'];
        $refund_content = $auto_refuse['0']['reason_name'];

        //配送方式信息
        $shipping_code = '';

        //支付方式信息
        if (!empty($order['pay_id'])) {
            $payment_info = RC_DB::table('payment')->where('pay_id', $order['pay_id'])->first();
            $pay_code     = $payment_info['pay_code'];
        } else {
            $pay_code = '';
        }

        //退款编号
        $refund_sn = ecjia_order_refund_sn();

        //撤单退款
        $refund_type   = 'cancel';
        $return_status = 0;
        $refund_status = 1;

        $user_name = RC_DB::table('users')->where('user_id', $order['user_id'])->pluck('user_name');
        /* 进入售后 */
        $refund_data = array(
            'store_id'       => $order['store_id'],
            'user_id'        => $order['user_id'],
            'user_name'      => $user_name,
            'refund_type'    => $refund_type,
            'refund_sn'      => $refund_sn,
            'order_id'       => $order['order_id'],
            'order_sn'       => $order['order_sn'],
            'shipping_code'  => $shipping_code,
            'shipping_name'  => $order['shipping_name'],
            'shipping_fee'   => $order['shipping_fee'],
            'insure_fee'     => $order['insure_fee'],
            'pay_code'       => $pay_code,
            'pay_name'       => $payment_info['pay_name'],
            'goods_amount'   => $order['goods_amount'],
            'pay_fee'        => $order['pay_fee'],
            'pack_id'        => $order['pack_id'],
            'pack_fee'       => $order['pack_fee'],
            'card_id'        => $order['card_id'],
            'card_fee'       => $order['card_fee'],
            'bonus_id'       => $order['bonus_id'],
            'bonus'          => $order['bonus'],
            'surplus'        => $order['surplus'],
            'integral'       => $order['integral'],
            'integral_money' => $order['integral_money'],
            'discount'       => $order['discount'],
            'inv_tax'        => $order['tax'],
            'order_amount'   => $order['order_amount'],
            'money_paid'     => $order['money_paid'],
            'status'         => 1,
            'refund_status'  => $refund_status,
            'return_status'  => $return_status,
            'refund_content' => $refund_content,
            'refund_reason'  => $refund_reason,
            'add_time'       => RC_Time::gmtime(),
            'referer'        => 'merchant',
        );
        $refund_id   = RC_DB::table('refund_order')->insertGetId($refund_data);

        if ($refund_id) {
            RefundBackGoodsStock::refund_back_stock($refund_id);
            //退款还原促销限购数量；用户购买记录减少
            $updateData = new \Ecjia\App\Refund\Goods\Promotion\UpdateGoodsPromotion($refund_id, $order['order_id'], 'refund_apply');
            $updateData->updateGoodsPromotionLimitNum();
        }

        return $refund_id;
    }


    /**
     * 更新订单状态&订单操作记录&订单状态记录；及更新售后申请状态记录;
     */
    private static function _updateWithLogs($order, $refund_id)
    {
        /* 订单状态为“退货” */
        RC_DB::table('order_info')->where('order_id', $order['order_id'])->update(array('order_status' => OS_RETURNED));

        /* 记录log */
        $action_note = __('系统自动退款', 'orders');
        order_refund::order_action($order['order_id'], OS_RETURNED, $order['shipping_status'], $order['pay_status'], $action_note, __('系统', 'orders'));

        //订单状态log记录
        $pra = array('order_status' => __('无法接单', 'orders'), 'order_id' => $order['order_id'], 'message' => __('等待商家退款！', 'orders'));
        order_refund::order_status_log($pra);

        //售后申请状态记录
        $opt = array('status' => __('无法接单', 'orders'), 'refund_id' => $refund_id, 'message' => __('等待商家退款！', 'orders'));
        order_refund::refund_status_log($opt);
    }

    /**
     * 订单被拒，发送短信通知
     */
    private static function _sendOrderCanceledSms($order)
    {
        //订单被拒单短信通知
        if (!empty($order['user_id'])) {
            $user_info = RC_DB::table('users')->where('user_id', $order['user_id'])->select('mobile_phone', 'user_name')->first();
            if (!empty($user_info['mobile_phone'])) {
                //发送短信
                $options = array(
                    'mobile' => $user_info['mobile_phone'],
                    'event'  => 'sms_order_refused',
                    'value'  => array(
                        'order_sn'  => $order['order_sn'],
                        'user_name' => $user_info['user_name']
                    ),
                );
                RC_Api::api('sms', 'send_event_sms', $options);
            }
        }
    }

    /**
     * 更新结算记录
     */
    private static function _updateCommissionBill($refund_id)
    {
        //update commission_bill
        $res = RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'refund', 'order_id' => $refund_id));
        if (is_ecjia_error($res)) {
        }
    }

    /**
     * 商家同意退款
     */
    private static function _merchantAgree($refund_id)
    {
        //仅退款---同意---进入打款表
        $refund_info       = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
        $payment_record_id = RC_DB::table('payment_record')->where('order_sn', $refund_info['order_sn'])->pluck('id');

        //实际支付费用
        $order_money_paid = $refund_info['surplus'] + $refund_info['money_paid'];
        //退款总金额
        $shipping_status = RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->pluck('shipping_status');
        if ($shipping_status > SS_UNSHIPPED) {
            $back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'] - $refund_info['shipping_fee'] - $refund_info['insure_fee'];
            $back_shipping_fee = $refund_info['shipping_fee'];
            $back_insure_fee   = $refund_info['insure_fee'];
        } else {
            $back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'];
            $back_shipping_fee = 0;
            $back_insure_fee   = 0;
        }

        $data = array(
            'store_id'            => $refund_info['store_id'],
            'order_id'            => $refund_info['order_id'],
            'order_sn'            => $refund_info['order_sn'],
            'refund_id'           => $refund_info['refund_id'],
            'refund_sn'           => $refund_info['refund_sn'],
            'refund_type'         => $refund_info['refund_type'],
            'goods_amount'        => $refund_info['goods_amount'],
            'back_pay_code'       => $refund_info['pay_code'],
            'back_pay_name'       => $refund_info['pay_name'],
            'back_pay_fee'        => $refund_info['pay_fee'],
            'back_shipping_fee'   => $back_shipping_fee,
            'back_insure_fee'     => $back_insure_fee,
            'back_pack_id'        => $refund_info['pack_id'],
            'back_pack_fee'       => $refund_info['pack_fee'],
            'back_card_id'        => $refund_info['card_id'],
            'back_card_fee'       => $refund_info['card_fee'],
            'back_bonus_id'       => $refund_info['bonus_id'],
            'back_bonus'          => $refund_info['bonus'],
            'back_surplus'        => $refund_info['surplus'],
            'back_integral'       => $refund_info['integral'],
            'back_integral_money' => $refund_info['integral_money'],
            'back_inv_tax'        => $refund_info['inv_tax'],
            'order_money_paid'    => $order_money_paid,
            'back_money_total'    => $back_money_total,
            'payment_record_id'   => !empty($payment_record_id) ? intval($payment_record_id) : 0,
            'add_time'            => RC_Time::gmtime(),
        );
        RC_DB::table('refund_payrecord')->insertGetId($data);

        $return_status = 0; //无需退货
        $refund_status = 1; //打款待处理

        //录入退款操作日志表
        $data = array(
            'refund_id'        => $refund_id,
            'action_user_type' => 'merchant',
            'action_user_id'   => 0,
            'action_user_name' => __('系统自动拒单自动退款', 'orders'),
            'status'           => 1,
            'refund_status'    => $refund_status,
            'return_status'    => $refund_status,
            'action_note'      => __('系统自动拒单自动退款至余额', 'orders'),
            'log_time'         => RC_Time::gmtime(),
        );
        RC_DB::table('refund_order_action')->insertGetId($data);

        //售后订单状态变动日志表
        RefundStatusLog::refund_order_process(array('refund_id' => $refund_id, 'status' => 1));
        //普通订单状态变动日志表
        OrderStatusLog::refund_order_process(array('order_id' => $refund_info['order_id'], 'status' => 1));
    }

}
