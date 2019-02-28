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
 * 取消订单
 * @author royalwang
 */
class order_cancel_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        $user_id = $_SESSION['user_id'];
        if ($user_id < 1) {
            return new ecjia_error(100, __('Invalid session', 'orders'));
        }

        $order_id = $this->requestData('order_id', 0);
        if ($user_id < 1 || $order_id < 1) {
            return new ecjia_error('invalid_parameter', __('参数无效', 'orders'));
        }
        $result = $this->cancel_order($order_id, $user_id);
        if (!is_ecjia_error($result)) {

            return array();
        } else {
            return $result;
        }
    }

    /**
     * 取消一个用户订单
     *
     * @access public
     * @param int $order_id
     *            订单ID
     * @param int $user_id
     *            用户ID
     * @return void
     */
    private function cancel_order($order_id, $user_id = 0)
    {
        $db = RC_Model::model('orders/order_info_model');
        /* 查询订单信息，检查状态 */
        $order = $db->field('user_id, order_id, order_sn , surplus , integral , bonus_id, order_status, shipping_status, pay_status')->find(array('order_id' => $order_id));

        if (empty($order)) {
            return new ecjia_error('order_exist', __('该订单不存在！', 'orders'));
        }

        // 如果用户ID大于0，检查订单是否属于该用户
        if ($user_id > 0 && $order['user_id'] != $user_id) {
            return new ecjia_error('no_priv', __('你没有权限操作他人订单', 'orders'));
        }

        // 发货状态只能是“未发货”
        if ($order['shipping_status'] != SS_UNSHIPPED) {
            return new ecjia_error('current_ss_not_cancel', __('只有在未发货状态下才能取消，你可以与店主联系。', 'orders'));
        }

        // 如果付款状态是“已付款”、“付款中”，不允许取消，要取消和商家联系
        if ($order['pay_status'] != PS_UNPAYED) {
            return new ecjia_error('current_ps_not_cancel', __('只有未付款状态才能取消，要取消请联系店主。', 'orders'));
        }

        if ($order['order_status'] == OS_CANCELED) {
            return new ecjia_error('order_has_canceled', __('该订单已取消过了！', 'orders'));
        }

        // 将用户订单设置为取消
        $query = $db->where(array('order_id' => $order_id))->update(array('order_status' => OS_CANCELED));
        if ($query) {
            RC_Loader::load_app_func('admin_order', 'orders');
            //订单取消，如果是下单减库存，还原库存
            if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                RC_Loader::load_app_class('cart', 'cart', false);
                $result = cart::change_order_goods_storage($order['order_id'], false, SDT_PLACE);
                if (is_ecjia_error($result)) {
                    /* 库存不足删除已生成的订单（并发处理） will.chen*/
                    RC_DB::table('order_info')->where('order_id', $order['order_id'])->delete();
                    RC_DB::table('order_goods')->where('order_id', $order['order_id'])->delete();
                    return $result;
                }
            }

            /* 记录log */
            order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, __('用户取消', 'orders'), 'buyer');
            /* 退货用户余额、积分、红包 */
            if ($order['user_id'] > 0 && $order['surplus'] > 0) {
                $options = array(
                    'user_id'     => $order['user_id'],
                    'user_money'  => $order['surplus'],
                    'change_desc' => sprintf(__('取消订单 %s，退回支付订单时使用的预付款', 'orders'), $order['order_sn'])
                );
                $result  = RC_Api::api('user', 'account_change_log', $options);
                if (is_ecjia_error($result)) {
                    return $result;
                }
            }
            if ($order['user_id'] > 0 && $order['integral'] > 0) {
                $options = array(
                    'user_id'     => $order['user_id'],
                    'pay_points'  => $order['integral'],
                    'change_desc' => sprintf(__('取消订单 %s，退回下订单时使用的积分', 'orders'), $order['order_sn']),
                    'from_type'   => 'ordercancel_back_integral',
                    'from_value'  => $order['order_sn']
                );
                $result  = RC_Api::api('user', 'account_change_log', $options);
                if (is_ecjia_error($result)) {
                    return $result;
                }
            }
            if ($order['user_id'] > 0 && $order['bonus_id'] > 0) {
                RC_Loader::load_app_func('admin_bonus', 'bonus');
                change_user_bonus($order['bonus_id'], $order['order_id'], false);
            }

            /* 如果使用库存，且下订单时减库存，则增加库存 */
            if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                change_order_goods_storage($order['order_id'], false, 1);
            }

            /* 修改订单 */
            $arr = array(
                'bonus_id'       => 0,
                'bonus'          => 0,
                'integral'       => 0,
                'integral_money' => 0,
                'surplus'        => 0
            );
            update_order($order['order_id'], $arr);
            RC_DB::table('order_status_log')->insert(array(
                'order_status' => __('订单已取消', 'orders'),
                'order_id'     => $order['order_id'],
                'message'      => __('您的订单已取消成功！', 'orders'),
                'add_time'     => RC_Time::gmtime(),
            ));
            return true;
        } else {
            return new ecjia_error('database_query_error', $db->error());
        }
    }
}



// end