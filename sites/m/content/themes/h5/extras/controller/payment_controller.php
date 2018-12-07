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
 * 支付控制器代码
 */
class payment_controller
{
    public static function init()
    {
        $order_id  = !empty($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $pay_id    = !empty($_GET['pay_id']) ? intval($_GET['pay_id']) : 0;
        $pay_code  = !empty($_GET['pay_code']) ? trim($_GET['pay_code']) : '';
        $tips_show = !empty($_GET['tips_show']) ? trim($_GET['tips_show']) : 0;

        //团购订单
        $type = !empty($_GET['type']) ? trim($_GET['type']) : '';

        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }
        $token = ecjia_touch_user::singleton()->getToken();

        if ($pay_id && $pay_code) {
            //修改支付方式，更新订单
            $params = array(
                'token'    => $token,
                'order_id' => $order_id,
                'pay_id'   => $pay_id,
            );
            $response = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_UPDATE)->data($params)->run();
            if (is_ecjia_error($response)) {
                return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }
        }

        /*获取订单信息*/
        $params_order = array('token' => $token, 'order_id' => $order_id);

        $api_detail = ecjia_touch_api::ORDER_DETAIL;
        $pjaxurl    = RC_Uri::url('user/order/order_detail', array('order_id' => $order_id));
        if ($type == 'group_buy') {
            $api_detail = ecjia_touch_api::GROUPBUY_ORDER_DETAIL;
            $pjaxurl    = RC_Uri::url('user/order/groupbuy_detail', array('order_id' => $order_id));
        }
        $detail = ecjia_touch_manager::make()->api($api_detail)->data($params_order)->run();
        if (is_ecjia_error($detail)) {
            return ecjia_front::$controller->showmessage($detail->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }
        if ($detail['pay_status'] == 2) {
            return ecjia_front::$controller->showmessage('该订单已支付请勿重复支付', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $pjaxurl));
        }

        if ($detail['extension_code'] == 'group_buy') {
            if ($detail['order_status_code'] == 'await_pay') {
                $detail['formated_pay_money'] = $detail['formated_order_amount'];
            } else {
                //支付余额
                $total_money                  = $detail['money_paid'] + $detail['surplus'] + $detail['integral_money'] + $detail['bonus'] + $detail['order_deposit'];
                $has_paid                     = $detail['goods_amount'] + $detail['shipping_fee'] + $detail['insure_fee'] + $detail['pay_fee'] + $detail['pack_fee'] + $detail['card_fee'] + $detail['tax'];
                $detail['formated_pay_money'] = price_format($total_money - $has_paid);
            }
        }

        $change_result = user_function::is_change_payment($detail['pay_code'], $detail['manage_mode']);
        ecjia_front::$controller->assign('change_payment', $change_result['change']);

        if ($change_result['change'] && $detail['pay_code'] != 'pay_cod') {
            ecjia_front::$controller->assign('detail', $detail);
            ecjia_front::$controller->assign('payment_list', $change_result['payment']);
            ecjia_front::$controller->display('pay_change.dwt');
            return false;
        }
        //获得订单支付信息
        $params = array(
            'token'    => $token,
            'order_id' => $order_id,
        );

        //支付方式信息
        if ($detail['pay_code'] == 'pay_wxpay' && empty($change_result['open_id'])) {
            $handler                 = with(new Ecjia\App\Payment\PaymentPlugin)->channel($detail['pay_code']);
            $open_id                 = $handler->getWechatOpenId();
            $params['wxpay_open_id'] = $open_id;
        } elseif (!empty($change_result['open_id'])) {
            $params['wxpay_open_id'] = $change_result['open_id'];
        }

        $rs_pay = [];
        if (in_array($detail['pay_code'], array('pay_wxpay', 'pay_alipay'))) {
            $api = ecjia_touch_api::ORDER_PAY;
            if ($detail['extension_code'] == 'group_buy') {
                $api = ecjia_touch_api::GROUPBUY_ORDER_PAY;
            }
            $rs_pay = ecjia_touch_manager::make()->api($api)->data($params)->run();
            if (is_ecjia_error($rs_pay)) {
                return ecjia_front::$controller->showmessage($rs_pay->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }
            $order = !empty($rs_pay['payment']) ? $rs_pay['payment'] : [];
            if (isset($rs_pay) && $rs_pay['payment']['error_message']) {
                ecjia_front::$controller->assign('pay_error', $rs_pay['payment']['error_message']);
            } else if (empty($rs_pay)) {
                $order['pay_status'] = 'success';
            }
        }

        //免费商品直接余额支付
        if ($detail['order_amount'] !== 0) {
            $need_other_payment = 1;
            /* 调起微信支付*/
            if ($detail['pay_code'] == 'pay_wxpay') {
                $pay_online = array_get($rs_pay, 'payment.private_data.pay_online', array_get($rs_pay, 'payment.pay_online'));
                ecjia_front::$controller->assign('pay_button', $pay_online);
                unset($order['pay_online']);
            } else {
                //其他支付方式
                if ($detail['pay_code'] == 'pay_cod') {
                    $need_other_payment = 0;
                }
                $order['pay_online'] = array_get($order, 'pay_online', array_get($order, 'private_data.pay_online'));
            }
            if ($need_other_payment && empty($order['order_pay_status'])) {
                $payment_list = user_function::get_payment_list($detail['pay_code'], $detail['manage_mode']);
                ecjia_front::$controller->assign('payment_list', $payment_list);
            }
        } else {
            $order['pay_status'] = 'success';
            unset($order['pay_online']);
        }

        if ($order['pay_code'] != 'pay_balance') {
            $order['formated_order_amount'] = price_format($order['order_amount']);
        }
        $order['order_id'] = $order_id;

        ecjia_front::$controller->assign('detail', $detail);
        ecjia_front::$controller->assign('data', $order);
        ecjia_front::$controller->assign('pay_online', $order['pay_online']);
        ecjia_front::$controller->assign('tips_show', $tips_show);

        $url = RC_Uri::url('user/order/order_detail', array('order_id' => $order_id, 'type' => 'detail'));
        if ($detail['extension_code'] == 'group_buy') {
            $url = RC_Uri::url('user/order/groupbuy_detail', array('order_id' => $order_id));
        }

        //生成返回url cookie
        RC_Cookie::set('pay_response_index', RC_Uri::url('touch/index/init'));
        RC_Cookie::set('pay_response_order', $url);

        ecjia_front::$controller->display('pay.dwt');
    }

    public static function notify()
    {
        $msg = '支付成功';
        ecjia_front::$controller->assign('msg', $msg);
        $order_type   = isset($_GET['order_type']) ? trim($_GET['order_type']) : '';
        $url['index'] = RC_Cookie::get('pay_response_index');
        $url['order'] = RC_Cookie::get('pay_response_order');

        $url = array(
            'index' => RC_Cookie::get('pay_response_index') ? RC_Cookie::get('pay_response_index') : str_replace('notify/', '', RC_Uri::url('touch/index/init')),
            'order' => RC_Cookie::get('pay_response_order') ? RC_Cookie::get('pay_response_order') : str_replace('notify/', '', RC_Uri::url('user/order/order_list')),
        );
        ecjia_front::$controller->assign('url', $url);
        ecjia_front::$controller->assign('order_type', $order_type);
        ecjia_front::$controller->display('pay_notify.dwt');
    }

    /**
     *  修改支付方式后支付订单
     */
    public static function pay_order()
    {
        $order_id = intval($_POST['order_id']);
        $pay_id   = intval($_POST['pay_id']);

        if (empty($pay_id)) {
            return ecjia_front::$controller->showmessage(__('请选择支付方式'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $token = ecjia_touch_user::singleton()->getToken();
        //修改支付方式，更新订单
        $params = array(
            'token'    => $token,
            'order_id' => $order_id,
            'pay_id'   => $pay_id,
        );
        $response = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_UPDATE)->data($params)->run();
        if (is_ecjia_error($response)) {
            return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //获得订单支付信息
        $param_list = array(
            'token'    => $token,
            'order_id' => $order_id,
        );
        if (cart_function::is_weixin()) {
            $param_list['wxpay_open_id'] = $_SESSION['wxpay_open_id'];
        }

        $rs_pay = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_PAY)->data($param_list)->run();

        if (!is_ecjia_error($rs_pay)) {
            if (isset($rs_pay) && $rs_pay['payment']['error_message']) {
                return ecjia_front::$controller->showmessage($rs_pay['payment']['error_message'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $notify_url = RC_Uri::url('payment/pay/notify', array('order_id' => $order_id));
            //生成返回url cookie
            RC_Cookie::set('pay_response_index', RC_Uri::url('touch/index/init'));
            RC_Cookie::set('pay_response_order', RC_Uri::url('user/order/order_detail', array('order_id' => $order_id, 'type' => 'detail')));

            $pay_online = array_get($rs_pay, 'payment.private_data.pay_online', array_get($rs_pay, 'payment.pay_online'));
            if (array_get($rs_pay, 'payment.pay_code') == 'pay_alipay') {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('redirect_url' => $pay_online, 'pay_name' => 'alipay'));
            } else if (array_get($rs_pay, 'payment.pay_code') == 'pay_wxpay') {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('weixin_data' => $pay_online, 'pay_name' => 'weixin'));
            } else {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('redirect_url' => $notify_url, 'pay_name' => 'redirect'));
            }
        } else {
            return ecjia_front::$controller->showmessage($rs_pay->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
}

// end
