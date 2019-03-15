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
namespace Ecjia\App\Refund;

use ecjia_error;
use ecjia_shipping;
use ecjia;
use RC_Loader;
use RC_DB;
use RC_Time;

use order_refund;
use OrderStatusLog;
use RefundStatusLog;

use Ecjia\App\Refund\RefundBackGoodsStock;

/**
 * 退款自动申请
 */
class ReturnAutoApply
{

    protected $order_id;

    protected $order_info;

    protected $action;

    public function __construct($order_id, $action)
    {
        $this->order_id = $order_id;

        $order_info = RC_DB::table('order_info')->where('order_id', $order_id)->first();

        $order_info['user_name'] = RC_DB::table('users')->where('user_id', $order_info['user_id'])->pluck('user_name');

        $this->order_info = $order_info;

        $this->action = $action;
    }

    /**
     * 自动申请退款单
     */
    public function autoApplyRefundOrder($refund_way = null)
    {
        if (in_array($this->order_info['pay_status'], array(PS_UNPAYED))
            || in_array($this->order_info['order_status'], array(OS_CANCELED, OS_INVALID))
            || ($this->order_info['is_delete'] == 1)) {
            return new ecjia_error('error_apply', __('当前订单不可申请售后！', 'refund'));
        }

        //获取订单退款信息
        $order_refund_info = $this->getRefundOrderInfo();

        //存在退款信息
        if (!empty($order_refund_info)) {
            //检查退款状态
            $result = $this->checkRefundStatus($order_refund_info, $refund_way);
        } else {
            //退款
            $result = $this->createRefundOrder();
        }

        return $result;
    }

    /**
     * 创建退款单
     * 默认申请仅退款
     * @param string $refund_type
     * @return mixed
     */
    public function createRefundOrder($refund_type = 'refund')
    {
        RC_Loader::load_app_class('order_refund', 'refund', false);
        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        RC_Loader::load_app_class('RefundStatusLog', 'refund', false);

        //退款编号
        $refund_sn = ecjia_order_refund_sn();

        $refund_content = '活动失败，系统自动退款'; //退款说明
        $refund_reason  = '36'; //退款原因编号

        $order_info = $this->order_info;

        //配送方式信息
        if (!empty($order_info['shipping_id'])) {
            $shipping_id   = intval($order_info['shipping_id']);
            $shipping_info = ecjia_shipping::pluginData($shipping_id);
            $shipping_code = $shipping_info['shipping_code'];
            $shipping_name = $shipping_info['shipping_name'];
        } else {
            $shipping_code = NULL;
            $shipping_name = '无需物流';
        }

        //支付方式信息
        if (!empty($order_info['pay_id'])) {
            $payment_info = with(new \Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order_info['pay_id']);
            $pay_code     = $payment_info['pay_code'];
            $pay_name     = $payment_info['pay_name'];
        } else {
            $pay_code = NULL;
            $pay_name = '';
        }

        //订单的配送状态，订单是否配送了
        if ($order_info['shipping_status'] > SS_UNSHIPPED) {
            $shipping_whether = 1;
        } else {
            $shipping_whether = 0;
        }

        $refund_data = array(
            'store_id'         => $order_info['store_id'],
            'user_id'          => !empty($order_info['user_id']) ? $order_info['user_id'] : 0,
            'user_name'        => !empty($order_info['user_name']) ? $order_info['user_name'] : '',
            'refund_type'      => $refund_type,
            'refund_sn'        => $refund_sn,
            'order_id'         => $this->order_id,
            'order_sn'         => $order_info['order_sn'],
            'shipping_code'    => $shipping_code,
            'shipping_name'    => $shipping_name,
            'shipping_fee'     => $order_info['shipping_fee'],
            'shipping_whether' => $shipping_whether,
            'insure_fee'       => $order_info['insure_fee'],
            'pay_code'         => $pay_code,
            'pay_name'         => $pay_name,
            'goods_amount'     => $order_info['goods_amount'],
            'pay_fee'          => $order_info['pay_fee'],
            'pack_id'          => $order_info['pack_id'],
            'pack_fee'         => $order_info['pack_fee'],
            'card_id'          => $order_info['card_id'],
            'card_fee'         => $order_info['card_fee'],
            'bonus_id'         => $order_info['bonus_id'],
            'bonus'            => $order_info['bonus'],
            'surplus'          => $order_info['surplus'],
            'integral'         => $order_info['integral'],
            'integral_money'   => $order_info['integral_money'],
            'discount'         => $order_info['discount'],
            'inv_tax'          => $order_info['tax'],
            'order_amount'     => $order_info['order_amount'],
            'money_paid'       => $order_info['money_paid'],
            'status'           => 0,//默认待审核
            'refund_content'   => $refund_content,
            'refund_reason'    => $refund_reason,
            'return_status'    => 0,//默认不需要退货
            'add_time'         => RC_Time::gmtime(),
            'referer'          => 'system'
        );

        //插入售后申请表数据
        $refund_id = RC_DB::table('refund_order')->insertGetId($refund_data);

        if ($refund_id) {
            //退款还原订单商品库存
            RefundBackGoodsStock::refund_back_stock($refund_id);
        }

        //更改订单状态
        RC_DB::table('order_info')->where('order_id', $this->order_id)->update(array('order_status' => OS_RETURNED));

        //订单操作记录log
        \order_refund::order_action($this->order_id, OS_RETURNED, $order_info['shipping_status'], $order_info['pay_status'], $refund_content, '商家');

        //订单状态log记录
        $pra = array('order_status' => '申请退款', 'order_id' => $this->order_id, 'message' => '活动失败退款申请已提交成功！');
        \order_refund::order_status_log($pra);

        //售后申请状态记录
        $opt = array('status' => '申请退款', 'refund_id' => $refund_id, 'message' => '活动失败退款申请已提交成功！');
        \order_refund::refund_status_log($opt);

        $refund_order_info = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();

        //对退款单做同意处理
        $this->agreeRefundOrder($refund_order_info);

        return $refund_order_info;
    }

    /**
     * 获取退款单信息
     * @return array
     */
    public function getRefundOrderInfo()
    {
        //查询当前订单有没申请过售后
        RC_Loader::load_app_class('order_refund', 'refund', false);
        //过滤掉已取消的和退款处理成功的，保留在处理中的申请
        $order_refund_info = \order_refund::currorder_refund_info($this->order_id);

        return $order_refund_info;
    }

    /*
     * 检查退款状态
     */
    protected function checkRefundStatus($order_refund_info, $refund_way = null)
    {
        //原路退回，未审核的及进行中的可继续退款
        if ($refund_way == 'original') {
            //已存在处理中的申请或退款成功的申请
            if (($order_refund_info['status'] == \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_REFUSED)
                || (($order_refund_info['status'] == \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_AGREE) && ($order_refund_info['refund_status'] == \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_TRANSFERED))
            ) {
                return new ecjia_error('error_apply', __('当前订单已申请了售后！', 'refund'));
            } else {
                return $order_refund_info;
            }
        } else {
            //已存在处理中的申请或退款成功的申请
            if (
                ($order_refund_info['status'] == \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_UNCHECK)
                || ($order_refund_info['status'] == \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_AGREE && $order_refund_info['refund_status'] == \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_UNTRANSFER)
                || ($order_refund_info['status'] == \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_AGREE && $order_refund_info['refund_status'] == \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_TRANSFERED)
            ) {
                return new ecjia_error('error_apply', __('当前订单已申请了售后！', 'refund'));
            } else {
                return $order_refund_info;
            }
        }
    }

    protected function agreeRefundOrder($refund_info)
    {
        $status            = 1;
        $refund_status     = 1;
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
            'payment_record_id'   => $payment_record_id,
            'add_time'            => RC_Time::gmtime()
        );
        RC_DB::table('refund_payrecord')->insertGetId($data);
        $log_msg = '同意';
        /*如果订单是众包或商家配送的话；找出对应的配送单更改配送单状态为取消配送*/
        if ($refund_info['shipping_code'] == 'ship_o2o_express' || $refund_info['shipping_code'] == 'ship_ecjia_express') {
            $express_order_info = RC_DB::table('express_order')->where('order_id', $refund_info['order_id'])->get();
            if (!empty($express_order_info)) {
                $result = RC_Api::api('express', 'cancel_express', $express_order_info);
            }
        }

        $refund_id = $refund_info['refund_id'];
        RC_DB::table('refund_order')->where('refund_id', $refund_id)->update(array('status' => $status, 'refund_status' => $refund_status));

        $action_note = '活动失败自动退款';
        $action = $this->action;
        //录入退款操作日志表
        $data = array(
            'refund_id'        => $refund_id,
            'action_user_type' => $action['user_type'],
            'action_user_id'   => $action['user_id'],
            'action_user_name' => $action['user_name'],
            'status'           => $status,
            'refund_status'    => $refund_status,
            'action_note'      => $action_note,
            'log_time'         => RC_Time::gmtime(),
        );
        RC_DB::table('refund_order_action')->insertGetId($data);

        RC_Loader::load_app_class('order_refund', 'refund', false);
        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        RC_Loader::load_app_class('RefundStatusLog', 'refund', false);

        //售后订单状态变动日志表
        \RefundStatusLog::refund_order_process(array('refund_id' => $refund_id, 'status' => $status));

        //普通订单状态变动日志表
        \OrderStatusLog::refund_order_process(array('order_id' => $refund_info['order_id'], 'status' => $status));

        //普通订单操作日志表
        $order_info = RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->select('shipping_status', 'pay_status')->first();
        \order_refund::order_action($refund_info['order_id'], OS_RETURNED, $order_info['shipping_status'], $order_info['pay_status'], $action_note, '商家');
    }

    /*
     * 仅退款
     */
    protected function refundProcess($order_id)
    {
        //下单减库存；退款加库存
        $order_goods = RC_DB::table('order_goods')->where('order_id', $order_id)->get();
        if ($order_goods) {
            foreach ($order_goods as $value) {
                if (ecjia::config('use_storage') == '1') {
                    //货品库存增加
                    if ($value['product_id'] > 0) {
                        RC_DB::table('products')->where('product_id', $value['product_id'])->increment('product_number', $value['send_number']);
                    } else {
                        RC_DB::table('goods')->where('goods_id', $value['goods_id'])->increment('goods_number', $value['send_number']);
                    }
                }
            }
        }
    }

    /*
     * 退货退款
     */
    protected function returnProcess($order_id, $refund_id)
    {
        RC_Loader::load_app_class('order_refund', 'refund', false);

        //获取订单的发货单列表
        $delivery_list = \order_refund::currorder_delivery_list($order_id);
        if (!empty($delivery_list)) {
            foreach ($delivery_list as $row) {
                //获取发货单的发货商品列表
                $delivery_goods_list = \order_refund::delivery_goodsList($row['delivery_id']);
                if (!empty($delivery_goods_list)) {
                    foreach ($delivery_goods_list as $res) {
                        $refund_goods_data = array(
                            'refund_id'   => $refund_id,
                            'goods_id'    => $res['goods_id'],
                            'product_id'  => $res['product_id'],
                            'goods_name'  => $res['goods_name'],
                            'goods_sn'    => $res['goods_sn'],
                            'is_real'     => $res['is_real'],
                            'send_number' => $res['send_number'],
                            'goods_attr'  => $res['goods_attr'],
                            'brand_name'  => $res['brand_name']
                        );
                        $refund_goods_id   = RC_DB::table('refund_goods')->insertGetId($refund_goods_data);
                        /* 如果使用库存，则增加库存；发货减库存；退款则加库存 */
                        if (ecjia::config('use_storage') == '1') {
                            if ($res['send_number'] > 0) {
                                //货品库存增加
                                if ($res['product_id'] > 0) {
                                    RC_DB::table('products')->where('product_id', $res['product_id'])->increment('product_number', $res['send_number']);
                                } else {
                                    RC_DB::table('goods')->where('goods_id', $res['goods_id'])->increment('goods_number', $res['send_number']);
                                }
                            }
                        }
                    }
                }
            }
        }

        /* 修改订单的发货单状态为退货 */
        $delivery_order_data = array(
            'status' => 1,
        );
        RC_DB::table('delivery_order')->where('order_id', $order_id)->whereIn('status', array(0, 2))->update($delivery_order_data);

        /* 将订单的商品发货数量更新为 0 */
        $order_goods_data = array(
            'send_number' => 0,
        );

        RC_DB::table('order_goods')->where('order_id', $order_id)->update($order_goods_data);
    }

}
