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
 * 闪惠模块控制器代码
 */
class quickpay_controller
{

    /**
     * 优惠买单
     */
    public static function init()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        ecjia_front::$controller->assign('store_id', $store_id);

        //红包
        if ($_POST['bonus_update']) {
            $_SESSION['quick_pay']['temp']['bonus'] = $_POST['bonus'];
        }
        //红包清空
        if ($_POST['bonus_clear']) {
            unset($_SESSION['quick_pay']['temp']['bonus']);
        }

        $integral_name = !empty(ecjia::config('integral_name')) ? ecjia::config('integral_name') : __('积分', 'h5');
        //积分
        if ($_POST['integral_update']) {
            if ($_POST['integral_clear']) {
                unset($_SESSION['quick_pay']['temp']['integral']);
                unset($_SESSION['quick_pay']['temp']['integral_bonus']);
            } else if ($_POST['integral'] > $_SESSION['quick_pay']['activity']['order_max_integral']) {
                return ecjia_front::$controller->showmessage(sprintf(__("%s使用超出订单限制", 'h5', $integral_name)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else if ($_POST['integral'] > $_SESSION['quick_pay']['data']['user_integral']) {
                return ecjia_front::$controller->showmessage(sprintf(__("%s不足", 'h5'), $integral_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $_SESSION['quick_pay']['temp']['integral'] = empty($_POST['integral']) ? 0 : intval($_POST['integral']);
                if (!empty($_POST['integral'])) {
                    $params_integral = array('token' => $token, 'integral' => $_POST['integral']);
                    $data_integral   = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_INTEGRAL)->data($params_integral)->run();
                    $data_integral   = !is_ecjia_error($data_integral) ? $data_integral : array();

                    $_SESSION['quick_pay']['temp']['integral_bonus'] = $data_integral['bonus'];
                }
            }
        }

        if (!empty($_SESSION['quick_pay'])) {
            ecjia_front::$controller->assign('data', $_SESSION['quick_pay']['data']);
            ecjia_front::$controller->assign('temp', $_SESSION['quick_pay']['temp']);
            ecjia_front::$controller->assign('activity', $_SESSION['quick_pay']['activity']);

            $data     = $_SESSION['quick_pay']['data'];
            $temp     = $_SESSION['quick_pay']['temp'];
            $discount = $type_money = 0;
            if (!empty($_SESSION['quick_pay']['activity'])) {
                $discount = $_SESSION['quick_pay']['activity']['discount'];
                if (!empty($_SESSION['quick_pay']['activity']['bonus_list']) && !empty($temp['bonus'])) {
                    $type_money = $_SESSION['quick_pay']['activity']['bonus_list'][$temp['bonus']]['type_money'];
                }
            }
            $total_fee = $data['goods_amount'] - $discount - $temp['integral_bonus'] - $type_money;
            if ($total_fee < 0) {
                $total_fee = 0;
            }
            ecjia_front::$controller->assign('total_fee', $total_fee);
        }

        if (empty($_SESSION['quick_pay']['data']['activity_list'])) {
            //店铺信息
            $parameter_list = array(
                'seller_id' => $store_id,
                'city_id'   => $_COOKIE['city_id'],
            );
            $store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
            if (is_ecjia_error($store_info)) {
                return ecjia_front::$controller->showmessage($store_info->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }
            if (empty($store_info['allow_use_quickpay'])) {
                return ecjia_front::$controller->showmessage(__('该店铺未开启优惠买单活动', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('merchant/index/init', array('store_id' => $store_id))));
            }
            if (!is_ecjia_error($store_info) && !empty($store_info['quickpay_activity_list'])) {
                $_SESSION['quick_pay']['shop_info']['store_id']   = $store_info['id'];
                $_SESSION['quick_pay']['shop_info']['store_name'] = $store_info['seller_name'];
                $_SESSION['quick_pay']['shop_info']['store_logo'] = $store_info['seller_logo'];
                ecjia_front::$controller->assign('activity_list', $store_info['quickpay_activity_list']);
                ecjia_front::$controller->assign('is_available', 1);
            }
        } else {
            ecjia_front::$controller->assign('activity_list', $_SESSION['quick_pay']['data']['activity_list']);
        }
        ecjia_front::$controller->assign('show_exclude_amount', $_SESSION['quick_pay']['show_exclude_amount']);
        ecjia_front::$controller->assign_title($store_info['seller_name']);
        ecjia_front::$controller->assign('store_info', $store_info);
        if (empty($_POST)) {
            unset($_SESSION['quick_pay']['temp']);
            unset($_SESSION['quick_pay']['data']);
        }

        return ecjia_front::$controller->display('quickpay_checkout.dwt');
    }

    /**
     * 检查订单
     */
    public static function flow_checkorder()
    {
        $url         = RC_Uri::site_url() . substr($_SERVER['HTTP_REFERER'], strripos($_SERVER['HTTP_REFERER'], '/'));
        $login_str   = user_function::return_login_str();
        $referer_url = RC_Uri::url($login_str, array('referer_url' => urlencode($url)));

        if (!ecjia_touch_user::singleton()->isSignin()) {
            return ecjia_front::$controller->showmessage('Invalid session', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('referer_url' => $referer_url));
        }

        $token               = ecjia_touch_user::singleton()->getToken();
        $order_money         = !empty($_POST['order_money']) ? $_POST['order_money'] : 0;
        $drop_out_money      = !empty($_POST['drop_out_money']) ? $_POST['drop_out_money'] : 0;
        $store_id            = !empty($_POST['store_id']) ? intval($_POST['store_id']) : 0;
        $activity_id         = !empty($_POST['activity_id']) ? intval($_POST['activity_id']) : 0;
        $show_exclude_amount = !empty($_POST['show_exclude_amount']) ? intval($_POST['show_exclude_amount']) : 0;
        $change_amount       = !empty($_POST['change_amount']) ? intval($_POST['change_amount']) : 0;
        $change_activity     = !empty($_POST['change_activity']) ? intval($_POST['change_activity']) : 0;
        $direct_pay          = intval($_POST['direct_pay']);

        if ($show_exclude_amount != 1) {
            $drop_out_money                               = 0;
            $_SESSION['quick_pay']['show_exclude_amount'] = 0;
        } else {
            $_SESSION['quick_pay']['show_exclude_amount'] = 1;
        }

        if (!empty($order_money) && !empty($store_id)) {
            $param = array(
                'token'             => $token,
                'store_id'          => $store_id,
                'goods_amount'      => $order_money,
                'exclude_amount'    => $drop_out_money,
                'activity_id'       => $activity_id,
                'is_exclude_amount' => $show_exclude_amount,
            );
            $_SESSION['quick_pay']['temp']['goods_amount']   = $order_money;
            $_SESSION['quick_pay']['temp']['exclude_amount'] = $drop_out_money;
            $data                                            = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_FLOW_CHECKORDER)->data($param)->run();
            if (is_ecjia_error($data)) {
                $_SESSION['quick_pay']['temp']['error'] = $data->get_error_message();
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            unset($_SESSION['quick_pay']['temp']['error']);
            if (!is_ecjia_error($data)) {
                $_SESSION['quick_pay']['data'] = $data;
                if (!empty($change_amount)) {
                    unset($_SESSION['quick_pay']['temp']);
                }
                $temp          = $_SESSION['quick_pay']['temp'];
                $discount      = $type_money      = 0;
                $arr           = array();
                $activity_list = $data['activity_list'];

                $auto_activity_id = 0;
                if (!empty($activity_list)) {
                    foreach ($activity_list as $k => $v) {
                        if (!empty($activity_id) && $activity_id == $v['activity_id']) {
                            $activity_list[$k]['is_favorable'] = 1;
                            $discount                          = $v['discount'];
                            $arr                               = $v;
                            $arr['bonus_list']                 = touch_function::change_array_key($arr['bonus_list'], 'bonus_id');
                            $_SESSION['quick_pay']['activity'] = $arr;
                            if (!empty($arr['bonus_list']) && !empty($temp['bonus'])) {
                                $type_money = $arr['bonus_list'][$temp['bonus']]['type_money'];
                            }
                        } else if (($change_amount != 1 || $change_activity == 1) && $direct_pay != 1) {
                            $activity_list[$k]['is_favorable'] = 0;
                        } else if ($v['is_allow_use'] == 1 && $v['is_favorable'] == 1) {
                            $discount                          = $v['discount'];
                            $arr                               = $v;
                            $arr['bonus_list']                 = touch_function::change_array_key($arr['bonus_list'], 'bonus_id');
                            $_SESSION['quick_pay']['activity'] = $arr;
                            if (!empty($arr['bonus_list']) && !empty($temp['bonus'])) {
                                $type_money = $arr['bonus_list'][$temp['bonus']]['type_money'];
                            }
                            $auto_activity_id = $v['activity_id'];
                        }
                    }
                }
                $_SESSION['quick_pay']['data']['activity_list'] = $activity_list;

                ecjia_front::$controller->assign('activity_list', $activity_list);
                ecjia_front::$controller->assign('data', $data);
                ecjia_front::$controller->assign('arr', $arr);
                ecjia_front::$controller->assign('temp', $_SESSION['quick_pay']['temp']);

                $total_fee = $data['goods_amount'] - $discount - $temp['integral_bonus'] - $type_money;

                $data['format_goods_amount'] = price_format($data['goods_amount']);
                $data['format_discount']     = price_format($discount);
                $data['format_total_fee']    = price_format($total_fee);
                if ($total_fee < 0) {
                    $total_fee = 0;
                }
                ecjia_front::$controller->assign('total_fee', $total_fee);
                ecjia_front::$controller->assign('store_id', $store_id);

                $say_list = ecjia_front::$controller->fetch('quickpay_checkout_ajax.dwt');
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'content' => $data, 'activity_id' => $auto_activity_id));
            }
        } elseif (empty($order_money)) {
            unset($_SESSION['quick_pay']['temp']);
            unset($_SESSION['quick_pay']['data']);
        }
    }

    /**
     * 买单优惠说明
     */
    public static function explain()
    {
        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $param    = array('store_id' => $store_id, 'pagination' => array('count' => 10, 'page' => 1));

        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'] . '-' . $store_id));
        if (!ecjia_front::$controller->is_cached('quickpay_explain.dwt', $cache_id)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ACTIVIRY_LIST)->data($param)->run();
            $data = !is_ecjia_error($data) ? $data : array();

            ecjia_front::$controller->assign('data', $data);
        }
        return ecjia_front::$controller->display('quickpay_explain.dwt', $cache_id);
    }

    /**
     * 选择红包
     */
    public static function bonus()
    {
        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        ecjia_front::$controller->assign('store_id', $store_id);

        if (!empty($_SESSION['quick_pay'])) {
            ecjia_front::$controller->assign('temp', $_SESSION['quick_pay']['temp']);
            ecjia_front::$controller->assign('data', $_SESSION['quick_pay']['data']);
            ecjia_front::$controller->assign('activity', $_SESSION['quick_pay']['activity']);
        }
        return ecjia_front::$controller->display('quickpay_bonus.dwt');
    }

    /**
     * 填写积分
     */
    public static function integral()
    {
        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        ecjia_front::$controller->assign('store_id', $store_id);

        if (!empty($_SESSION['quick_pay'])) {
            ecjia_front::$controller->assign('temp', $_SESSION['quick_pay']['temp']);
            ecjia_front::$controller->assign('data', $_SESSION['quick_pay']['data']);
            ecjia_front::$controller->assign('activity', $_SESSION['quick_pay']['activity']);
        }
        return ecjia_front::$controller->display('quickpay_integral.dwt');
    }

    /**
     * 提交订单
     */
    public static function done()
    {
        $url       = RC_Uri::site_url() . substr($_SERVER['HTTP_REFERER'], strripos($_SERVER['HTTP_REFERER'], '/'));
        $login_str = user_function::return_login_str();

        $referer_url = RC_Uri::url($login_str, array('referer_url' => urlencode($url)));
        if (!ecjia_touch_user::singleton()->isSignin()) {
            return ecjia_front::$controller->showmessage('Invalid session', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('referer_url' => $referer_url));
        }
        $token    = ecjia_touch_user::singleton()->getToken();
        $store_id = !empty($_POST['store_id']) ? intval($_POST['store_id']) : 0;

        $goods_amount = !empty($_POST['order_money']) ? $_POST['order_money'] : 0;
        if (empty($goods_amount)) {
            return ecjia_front::$controller->showmessage(__('消费金额不能为空', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $exclude_amount = !empty($_POST['drop_out_money']) ? $_POST['drop_out_money'] : 0;
        $activity_id    = !empty($_POST['activity_id']) ? intval($_POST['activity_id']) : 0;
        $bonus_id       = !empty($_POST['bonus']) ? intval($_POST['bonus']) : 0;
        $integral       = !empty($_POST['integral']) ? intval($_POST['integral']) : 0;

        $show_exclude_amount = isset($_POST['show_exclude_amount']) ? intval($_POST['show_exclude_amount']) : 0;
        if ($show_exclude_amount != 1) {
            $exclude_amount = 0;
        }

        if (!empty($_SESSION['quick_pay']['temp']['error'])) {
            return ecjia_front::$controller->showmessage($_SESSION['quick_pay']['temp']['error'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $params = array(
            'token'             => $token,
            'store_id'          => $store_id,
            'goods_amount'      => $goods_amount,
            'exclude_amount'    => $exclude_amount,
            'activity_id'       => $activity_id,
            'bonus_id'          => $bonus_id,
            'integral'          => $integral,
            'is_exclude_amount' => $show_exclude_amount,
        );
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_FLOW_DONE)->data($params)->run();
        if (is_ecjia_error($rs)) {
            return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $order_id = $rs['order_id'];
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('redirect_url' => RC_Uri::url('user/quickpay/pay', array('order_id' => $order_id)), 'order_id' => $order_id));
        }
    }

    /**
     * 支付
     */
    public static function pay()
    {
        $order_id = !empty($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }

        $token    = ecjia_touch_user::singleton()->getToken();
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'] . '-' . $token));

        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        ecjia_front::$controller->assign('user', $user);

        if (!ecjia_front::$controller->is_cached('quickpay_pay.dwt', $cache_id)) {
            $params_list = array(
                'token'    => $token,
                'order_id' => $order_id,
            );
            $order_info = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_DETAIL)->data($params_list)->run();
            $order_info = !is_ecjia_error($order_info) ? $order_info : array();

            ecjia_front::$controller->assign('order_info', $order_info);

            if ($order_info['order_status_str'] == 'paid') {
                return ecjia_front::$controller->showmessage(__('该订单已支付请勿重复支付', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }

            if (empty($_SESSION['wxpay_open_id']) && cart_function::is_weixin()) {
                //提前获取微信支付wxpay_open_id
                $handler                   = with(new Ecjia\App\Payment\PaymentPlugin)->channel('pay_wxpay');
                $open_id                   = $handler->getWechatOpenId();
                $_SESSION['wxpay_open_id'] = $open_id;
            }

            $params       = array('store_id' => $order_info['store_id']);
            $payment_list = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_SHOP_PAYMENT)->data($params)->run();
            $payment_list = !is_ecjia_error($payment_list) ? $payment_list : array();

            /*根据浏览器过滤支付方式，微信自带浏览器过滤掉支付宝支付，其他浏览器过滤掉微信支付*/
            if (!empty($payment_list['payment'])) {
                if (cart_function::is_weixin() == true) {
                    foreach ($payment_list['payment'] as $key => $val) {
                        if ($val['pay_code'] == 'pay_alipay') {
                            unset($payment_list['payment'][$key]);
                        }
                    }
                } else {
                    foreach ($payment_list['payment'] as $key => $val) {
                        if ($val['pay_code'] == 'pay_wxpay') {
                            unset($payment_list['payment'][$key]);
                        }
                    }
                }
            }
            ecjia_front::$controller->assign('payment_list', $payment_list['payment']);
        }
        return ecjia_front::$controller->display('quickpay_pay.dwt', $cache_id);
    }

    /**
     * 执行支付
     */
    public static function dopay()
    {
        $order_id = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $pay_code = !empty($_POST['pay_code']) ? trim($_POST['pay_code']) : '';
        $token    = ecjia_touch_user::singleton()->getToken();
        $type     = trim($_POST['type']);

        $params_list = array(
            'token'    => $token,
            'pay_code' => $pay_code,
            'order_id' => $order_id,
        );
        if ($pay_code == 'pay_wxpay') {
            if (empty($_SESSION['wxpay_open_id']) && cart_function::is_weixin()) {
                //提前获取微信支付wxpay_open_id
                $handler                   = with(new Ecjia\App\Payment\PaymentPlugin)->channel('pay_wxpay');
                $open_id                   = $handler->getWechatOpenId();
                $_SESSION['wxpay_open_id'] = $open_id;
            }
            $params_list['wxpay_open_id'] = $_SESSION['wxpay_open_id'];
        }

        $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_PAY)->data($params_list)->run();

        if (!is_ecjia_error($pay)) {
            //余额支付 校验支付密码
            if ($type === 'check_paypassword') {
                $value = trim($_POST['value']);
                $pay_record_id = $pay['payment']['pay_record_id'];

                $result = ecjia_touch_manager::make()->api(ecjia_touch_api::PAYMENT_PAY_BALANCE)->data(array('token' => $token, 'record_id' => $pay_record_id, 'paypassword' => $value))->run();
                if (is_ecjia_error($result)) {
                    return ecjia_front::$controller->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }

            if (isset($pay) && $pay['payment']['error_message']) {
                return ecjia_front::$controller->showmessage($pay['payment']['error_message'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $notify_url = RC_Uri::url('user/quickpay/notify', array('order_id' => $order_id));
            //生成返回url cookie
            RC_Cookie::set('pay_response_index', RC_Uri::url('touch/index/init'));
            RC_Cookie::set('pay_response_order', $notify_url);

            $pay_online = array_get($pay, 'payment.private_data.pay_online', array_get($pay, 'payment.pay_online'));

            unset($_SESSION['quick_pay']);
            if (array_get($pay, 'payment.pay_code') == 'pay_alipay') {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('redirect_url' => $pay_online, 'pay_name' => 'alipay'));
            } else if (array_get($pay, 'payment.pay_code') == 'pay_wxpay') {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('weixin_data' => $pay_online, 'pay_name' => 'weixin'));
            } else {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('redirect_url' => $notify_url, 'pay_name' => 'redirect'));
            }
        } else {
            return ecjia_front::$controller->showmessage($pay->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 取消订单
     */
    public static function cancel()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_CANCEL)->data($params_order)->run();

        $url = RC_Uri::url('user/quickpay/quickpay_detail', array('order_id' => $order_id));
        if (!is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage(__('取消成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url, 'is_show' => false));
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
        }
    }

    /**
     * 删除订单
     */
    public static function delete()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_DELETE)->data($params_order)->run();

        $url = RC_Uri::url('user/quickpay/quickpay_list');
        if (!is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage(__('删除成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
        }
    }

    /**
     * 支付成功页面
     */
    public static function notify()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_DETAIL)->data($params_order)->run();
        if (!is_ecjia_error($data)) {
            if (!empty($data)) {
                if (cart_function::is_weixin() == true) {
                    if ($data['pay_code'] == 'pay_alipay') {
                        unset($data['pay_code']);
                    }
                } else {
                    if ($data['pay_code'] == 'pay_wxpay') {
                        unset($data['pay_code']);
                    }
                }
            }
            ecjia_front::$controller->assign('data', $data);
        }
        ecjia_front::$controller->assign_title(__('支付成功', 'h5'));
        return ecjia_front::$controller->display('quickpay_notify.dwt');
    }

    /**
     * 我的买单列表
     */
    public static function quickpay_list()
    {
        $token = ecjia_touch_user::singleton()->getToken();
        $param = array('token' => $token, 'pagination' => array('count' => 10, 'page' => 1));

        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_LIST)->data($param)->run();
        $data = is_ecjia_error($data) ? array() : $data;
        ecjia_front::$controller->assign('order_list', $data);

        ecjia_front::$controller->assign_title(__('我的买单', 'h5'));
        return ecjia_front::$controller->display('quickpay_list.dwt');
    }

    /**
     * 我的买单列表异步
     */
    public static function async_quickpay_list()
    {
        $size  = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $param = array('token' => ecjia_touch_user::singleton()->getToken(), 'pagination' => array('count' => $size, 'page' => $pages));
        $data  = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_LIST)->data($param)->hasPage()->run();
        if (!is_ecjia_error($data)) {
            list($orders, $page) = $data;
            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            $say_list = '';
            if (!empty($orders)) {
                ecjia_front::$controller->assign('data', $orders);
                ecjia_front::$controller->assign_lang();
                $say_list = ecjia_front::$controller->fetch('quickpay_list_ajax.dwt');
            }
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }

    /**
     * 买单订单详情
     */
    public static function quickpay_detail()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $token    = ecjia_touch_user::singleton()->getToken();

        $params_order = array('token' => $token, 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_DETAIL)->data($params_order)->run();
        if (!is_ecjia_error($data)) {
            //店铺信息
            $parameter_list = array(
                'seller_id' => $data['store_id'],
                'city_id'   => $_COOKIE['city_id'],
            );
            $store_info    = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
            $change_result = user_function::is_change_payment($data['pay_code'], $store_info['manage_mode']);

            ecjia_front::$controller->assign('change', $change_result['change']);
            if ($data['order_status_str'] == '') {
                $url = RC_Uri::url('user/quickpay/quickpay_list');
                return ecjia_front::$controller->showmessage(__('该订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
            }
            ecjia_front::$controller->assign('data', $data);
        }

        ecjia_front::$controller->assign_title(__('买单详情', 'h5'));
        return ecjia_front::$controller->display('quickpay_detail.dwt');
    }
}

// end
