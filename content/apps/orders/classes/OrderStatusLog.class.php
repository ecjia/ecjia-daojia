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
 * 订单状态日志记录
 *
 */
class OrderStatusLog
{
    /**
     * 生成订单时状态日志
     * @param array $options
     * @return bool
     */
    public static function generate_order($options)
    {
        $data = array(
            'order_status' => __('订单提交成功', 'orders'),
            'order_id'     => $options['order_id'],
            'message'      => sprintf(__('下单成功，订单号：%s', 'orders'), $options['order_sn']),
            'add_time'     => RC_Time::gmtime(),
        );
        RC_DB::table('order_status_log')->insert($data);
        return true;
    }

    /**
     * 生成订单同时提醒付款
     * @param array $options
     * @return bool
     */
    public static function remind_pay($options)
    {
        RC_DB::table('order_status_log')->insert(array(
            'order_status' => __('待付款', 'orders'),
            'order_id'     => $options['order_id'],
            'message'      => __('请尽快支付该订单，超时将会自动取消订单', 'orders'),
            'add_time'     => RC_Time::gmtime(),
        ));
        return true;
    }

    /**
     * 订单付款成功时
     * @param array $options
     * @return bool
     */
    public static function order_paid($options)
    {
        $ps = array(
            PS_UNPAYED => __(__('未付款', 'orders'), 'orders'),
            PS_PAYING  => __(__('付款中', 'orders'), 'orders'),
            PS_PAYED   => __(__('已付款', 'orders'), 'orders'),
        );
        RC_DB::table('order_status_log')->insert(array(
            'order_status' => $ps[PS_PAYED],
            'order_id'     => $options['order_id'],
            'message'      => __('已通知商家处理，请耐心等待', 'orders'),
            'add_time'     => RC_Time::gmtime(),
        ));
        return true;
    }


    /**
     * 订单付款成功时同时通知商家
     * @param array $options
     * @return bool
     */
    public static function notify_merchant($options)
    {
        RC_DB::table('order_status_log')->insert(array(
            'order_status' => __('等待商家接单', 'orders'),
            'order_id'     => $options['order_id'],
            'message'      => __('订单已通知商家，等待商家处理', 'orders'),
            'add_time'     => RC_Time::gmtime(),
        ));
        return true;
    }

    /**
     * 发货单入库
     * @param array $options
     * @return bool
     */
    public static function generate_delivery_orderInvoice($options)
    {
        $ss   = array(
            SS_UNSHIPPED    => __(__('未发货', 'orders'), 'orders'),
            SS_PREPARING    => __(__('配货中', 'orders'), 'orders'),
            SS_SHIPPED      => __(__('已发货', 'orders'), 'orders'),
            SS_RECEIVED     => __(__('收货确认', 'orders'), 'orders'),
            SS_SHIPPED_PART => __(__('已发货(部分商品)', 'orders'), 'orders'),
            SS_SHIPPED_ING  => __(__('发货中', 'orders'), 'orders'),
        );
        $data = array(
            'order_status' => $ss[SS_PREPARING],
            'order_id'     => $options['order_id'],
            'message'      => sprintf(__('订单号为 %s 的商品正在备货中，请您耐心等待', 'orders'), $options['order_sn']),
            'add_time'     => RC_Time::gmtime()
        );
        RC_DB::table('order_status_log')->insert($data);
        return true;
    }

    /**
     * 完成发货
     * @param array $options
     * @return bool
     */
    public static function delivery_ship_finished($options)
    {
        $ss   = array(
            SS_UNSHIPPED    => __(__('未发货', 'orders'), 'orders'),
            SS_PREPARING    => __(__('配货中', 'orders'), 'orders'),
            SS_SHIPPED      => __(__('已发货', 'orders'), 'orders'),
            SS_RECEIVED     => __(__('收货确认', 'orders'), 'orders'),
            SS_SHIPPED_PART => __(__('已发货(部分商品)', 'orders'), 'orders'),
            SS_SHIPPED_ING  => __(__('发货中', 'orders'), 'orders'),
        );
        $data = array(
            'order_status' => $ss[SS_SHIPPED],
            'message'      => sprintf(__('订单号为 %s 的商品已发货，请您耐心等待', 'orders'), $options['order_sn']),
            'order_id'     => $options['order_id'],
            'add_time'     => RC_Time::gmtime(),
        );
        RC_DB::table('order_status_log')->insert($data);
        return true;
    }

    /**
     * 订单确认收货
     * @param array $options
     * @return bool
     */
    public static function affirm_received($options)
    {
        $order_status_data = array(
            'order_status' => __('已确认收货', 'orders'),
            'order_id'     => $options['order_id'],
            'message'      => __('宝贝已签收，购物愉快！', 'orders'),
            'add_time'     => RC_Time::gmtime()
        );
        RC_DB::table('order_status_log')->insert($order_status_data);

        $order_status_data = array(
            'order_status' => __('订单已完成', 'orders'),
            'order_id'     => $options['order_id'],
            'message'      => sprintf(__('感谢您在 %s 购物，欢迎您再次光临！', 'orders'), ecjia::config('shop_name')),
            'add_time'     => RC_Time::gmtime()
        );
        RC_DB::table('order_status_log')->insert($order_status_data);
        return true;
    }

    /**
     * 取消订单
     * @param array $options
     * @return bool
     */
    public static function cancel($options)
    {
        RC_DB::table('order_status_log')->insert(array(
            'order_status' => __('订单已取消', 'orders'),
            'order_id'     => $options['order_id'],
            'message'      => __('您的订单已取消成功！', 'orders'),
            'add_time'     => RC_Time::gmtime(),
        ));
        return true;
    }

    /**
     * 订单自动取消
     * @param array $options
     * @return bool
     */
    public static function order_auto_cancel($options)
    {
        RC_DB::table('order_status_log')->insert(array(
            'order_status' => __('超时未支付取消', 'orders'),
            'order_id'     => $options['order_id'],
            'message'      => __('订单超时未支付，已自动取消！', 'orders'),
            'add_time'     => RC_Time::gmtime(),
        ));
        return true;
    }

    /**
     * 仅退款订单已处理
     * @param array $options
     * @return bool
     */
    public static function refund_order_process($options)
    {
        if ($options['status'] == 1) {
            $message = __('申请审核已通过', 'orders');
        } else {
            $message = __('申请审核未通过', 'orders');
        }
        $data = array(
            'order_status' => __('订单退款申请已处理', 'orders'),
            'message'      => $message,
            'order_id'     => $options['order_id'],
            'add_time'     => RC_Time::gmtime(),
        );
        /*相同条件的数据不存在时录入*/
        $order_status_log_info = RC_DB::table('order_status_log')->where('order_status', $data['order_status'])->where('message', $message)->where('order_id', $options['order_id'])->first();
		if (empty($order_status_log_info)) {
			RC_DB::table('order_status_log')->insert($data);
		}
        return true;
    }

    /**
     * 退货退款订单已处理
     * @param array $options
     * @return bool
     */
    public static function return_order_process($options)
    {
        if ($options['status'] == 1) {
            $message = __('申请审核已通过，请选择返回方式', 'orders');
        } else {
            $message = __('申请审核未通过', 'orders');
        }
        $data = array(
            'order_status' => __('订单退货退款申请已处理', 'orders'),
            'message'      => $message,
            'order_id'     => $options['order_id'],
            'add_time'     => RC_Time::gmtime(),
        );
        RC_DB::table('order_status_log')->insert($data);
        return true;
    }

    /**
     * 订单确认收货处理
     * @param array $options
     * @return bool
     */
    public static function return_confirm_receive($options)
    {
        if ($options['status'] == 3) {
            $message = __('商家已确认收货，等价商家退款', 'orders');
        } else {
            $message = __('商家未收到货', 'orders');
        }
        $data = array(
            'order_status' => __('确认收货处理', 'orders'),
            'message'      => $message,
            'order_id'     => $options['order_id'],
            'add_time'     => RC_Time::gmtime(),
        );
        $order_status_log_info = RC_DB::table('order_status_log')->where('order_status', $data['order_status'])->where('message', $message)->where('order_id', $options['order_id'])->first();
        if (empty($order_status_log_info)) {
        	RC_DB::table('order_status_log')->insert($data);
        }
        return true;
    }

    /**
     * 订单退款到账处理
     * @param array $options
     * @return bool
     */
    public static function refund_payrecord($options)
    {
        if (!empty($options['back_pay_name'])) {
            $message = sprintf(__('您的退款 %s 元，已退回至您的 %s 账户，请查收', 'orders'), $options['back_money'], $options['back_pay_name']);
        } else {
            $message = sprintf(__('您的退款 %s 元，已退回至您的余额，请查收', 'orders'), $options['back_money']);
        }
        $data = array(
            'order_status' => __('退款到账', 'orders'),
            'message'      => $message,
            'order_id'     => $options['order_id'],
            'add_time'     => RC_Time::gmtime(),
        );
        RC_DB::table('order_status_log')->insert($data);
        return true;
    }

    /**
     * 团购订单支付成功时
     * @param array $options
     * @return bool
     */
    public static function groupbuy_order_paid($options)
    {
        $ps   = array(
            PS_UNPAYED => __(__('未付款', 'orders'), 'orders'),
            PS_PAYING  => __(__('付款中', 'orders'), 'orders'),
            PS_PAYED   => __(__('已付款', 'orders'), 'orders'),
        );
        $data = array(
            'order_status' => $ps[PS_PAYED],
            'order_id'     => $options['order_id'],
            'message'      => __('保证金支付成功，等活动成功结束后尽快支付商品部分余款！', 'orders'),
            'add_time'     => RC_Time::gmtime(),
        );

        RC_DB::table('order_status_log')->insert($data);
        return true;
    }

    /**
     * 自提和配送订单（开启自动接单时）；订单支付成功，默认已接单
     * @param array $options
     * @return bool
     */
    public static function orderpaid_autoconfirm($options)
    {
        $data = array(
            'order_status' => __('商家已接单', 'orders'),
            'order_id'     => $options['order_id'],
            'message'      => __('已被商家接单，订单正在备货中', 'orders'),
            'add_time'     => RC_Time::gmtime()
        );
        RC_DB::table('order_status_log')->insert($data);
        return true;
    }
}
