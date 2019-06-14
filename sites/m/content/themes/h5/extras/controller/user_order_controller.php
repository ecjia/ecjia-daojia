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
 * 订单模块控制器代码
 */
class user_order_controller
{
    /**
     * 获取全部订单
     */
    public static function order_list()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $type = isset($_GET['type']) ? $_GET['type'] : '';
        if ($type == 'refund') {
            $params_order = array('token' => $token, 'pagination' => array('count' => 10, 'page' => 1), 'type' => $type);
            $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_LIST)->data($params_order)->run();
            $data         = is_ecjia_error($data) ? array() : $data;

            ecjia_front::$controller->assign('order_list', $data);
            ecjia_front::$controller->assign_title(__('售后订单', 'h5'));
            ecjia_front::$controller->assign('title', __('售后订单', 'h5'));
            ecjia_front::$controller->assign('active', 'orderList');

            ecjia_front::$controller->assign_lang();
            return ecjia_front::$controller->display('user_order_return_list.dwt');
        } else {
            $params_order = array('token' => $token, 'pagination' => array('count' => 10, 'page' => 1), 'type' => $type);
            if (!empty($_GET['keywords'])) {
                $params_order['type']     = 'whole';
                $params_order['keywords'] = $_GET['keywords'];
                ecjia_front::$controller->assign('keywords', $params_order['keywords']);
            }
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_LIST)->data($params_order)->run();
            $data = is_ecjia_error($data) ? array() : $data;

            ecjia_front::$controller->assign('type', $type);
            ecjia_front::$controller->assign('order_list', $data);

            $title = __('全部订单', 'h5');
            if ($type == 'await_pay') {
                $title = __('待付款订单', 'h5');
            }
            if ($type == 'await_ship') {
                $title = __('待发货订单', 'h5');
            }
            if ($type == 'shipped') {
                $title = __('待收货订单', 'h5');
            }
            if ($type == 'allow_comment') {
                $title = __('待评价订单', 'h5');
            }
            ecjia_front::$controller->assign_title($title);
            ecjia_front::$controller->assign('title', $title);

            ecjia_front::$controller->assign('active', 'orderList');

            ecjia_front::$controller->assign_lang();
            return ecjia_front::$controller->display('user_order_list.dwt');
        }
    }

    /**
     * 订单详情
     */
    public static function order_detail()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $type     = !empty($_GET['type']) ? $_GET['type'] : 'detail';
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/order/order_list')));
        }

        $token        = ecjia_touch_user::singleton()->getToken();
        $user_info    = ecjia_touch_user::singleton()->getUserinfo();
        $params_order = array('token' => $token, 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();
        $data         = is_ecjia_error($data) ? array() : $data;
        if (empty($data)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/order/order_list')));
        }
        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $token . '-' . $user_info['id'] . '-' . $user_info['name']
            . '-' . $data['order_status'] . '-' . $data['shipping_status'] . '-' . $data['pay_status'];
        $cache_id = sprintf('%X', crc32($cache_id));

        if ($type == 'detail') {
            if (!ecjia_front::$controller->is_cached('user_order_detail.dwt', $cache_id)) {
                ecjia_front::$controller->assign('order', $data);
                ecjia_front::$controller->assign('headInfo', $data['order_status_log'][0]);
                if (($data['shipping_code'] == 'ship_o2o_express' || $data['shipping_code'] == 'ship_ecjia_express') && !empty($data['express_id'])) {
                    ecjia_front::$controller->assign('express_url', RC_Uri::url('user/order/express_position', array('code' => $data['shipping_code'], 'express_id' => $data['express_id'], 'order_id' => $data['order_id'], 'store_id' => $data['store_id'])));
                }
                ecjia_front::$controller->assign('title', __('订单详情', 'h5'));
                ecjia_front::$controller->assign_title(__('订单详情', 'h5'));
                ecjia_front::$controller->assign_lang();

                if ($data['shipping_code'] != 'ship_o2o_express' && $data['shipping_code'] != 'ship_ecjia_express') {
                    $express_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_EXPRESS)->data($params_order)->run();
                    $express_info = is_ecjia_error($express_info) ? array() : $express_info;
                    ecjia_front::$controller->assign('express_info', $express_info[0]);
                }

                if (!empty($data['order_status_code'])) {
                    $params      = array('token' => $token, 'type' => $data['order_status_code']);
                    $reason_list = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_REASONS)->data($params)->run();
                    $reason_list = !is_ecjia_error($reason_list) ? $reason_list : array();

                    ecjia_front::$controller->assign('reason_list', json_encode($reason_list));
                    ecjia_front::$controller->assign('refund_type', 'refund');
                }
            }
            if ($data['order_mode'] == 'storebuy') {
                return ecjia_front::$controller->display('user_order_storebuy_detail.dwt', $cache_id);
            } else {
                //店铺信息
                $parameter_list = array(
                    'seller_id' => $data['store_id'],
                    'city_id'   => $_COOKIE['city_id'],
                );
                $store_info     = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
                $store_info     = is_ecjia_error($store_info) ? array() : $store_info;

                if (!empty($store_info)) {
                    $map_url   = 'https://3gimg.qq.com/lightmap/v1/marker/index.html?type=0&marker=coord:';
                    $url_param = '' . $store_info['location']['latitude'] . ',' . $store_info['location']['longitude'] . ';title:' . $store_info['seller_name'] . ';addr:' . $store_info['shop_address'];
                    $url_param = urlencode($url_param);
                    $map_url   .= $url_param;
                    ecjia_front::$controller->assign('location_url', $map_url);
                }
                return ecjia_front::$controller->display('user_order_detail.dwt', $cache_id);
            }
        } else {
            $express_id = $data['express_id'];
            if (!empty($express_id)) {
                $params_express = array('token' => $token, 'order_id' => $order_id, 'express_id' => $express_id);
                $arr            = ecjia_touch_manager::make()->api(ecjia_touch_api::EXPRESS_USER_LOCATION)->data($params_express)->run();
                $arr            = is_ecjia_error($arr) ? [] : $arr;
                if (!empty($arr)) {
                    ecjia_front::$controller->assign('arr', json_encode($arr));
                    ecjia_front::$controller->assign('express_info', $arr);
                }
            }
            if (!ecjia_front::$controller->is_cached('user_order_status.dwt', $cache_id)) {
                ecjia_front::$controller->assign('order', $data);
                ecjia_front::$controller->assign('title', __('订单状态', 'h5'));
                ecjia_front::$controller->assign_title(__('订单状态', 'h5'));
                ecjia_front::$controller->assign_lang();
            }
            return ecjia_front::$controller->display('user_order_status.dwt', $cache_id);
        }
    }

    /**
     * 物流信息
     */
    public static function express_info()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/order/order_list')));
        }

        $token        = ecjia_touch_user::singleton()->getToken();
        $user_info    = ecjia_touch_user::singleton()->getUserinfo();
        $params_order = array('token' => $token, 'order_id' => $order_id);

        $express_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_EXPRESS)->data($params_order)->run();
        $express_info = is_ecjia_error($express_info) ? array() : $express_info[0];
        if (empty($express_info)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/order/order_list')));
        }

        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $token . '-' . $user_info['id'] . '-' . $user_info['name']
            . '-' . $express_info['label_shipping_status'] . '-' . $express_info['shipping_number'] . '-' . $express_info['shipping_status'];
        $cache_id = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('user_order_express.dwt', $cache_id)) {
            ecjia_front::$controller->assign('express_info', $express_info);
            ecjia_front::$controller->assign('goods_info', $express_info['goods_items'][0]);

            ecjia_front::$controller->assign('title', __('物流信息', 'h5'));
            ecjia_front::$controller->assign_title(__('物流信息', 'h5'));
        }
        return ecjia_front::$controller->display('user_order_express.dwt', $cache_id);
    }

    /**
     * 取消订单
     */
    public static function order_cancel()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $reason_id    = !empty($_GET['reason_id']) ? intval($_GET['reason_id']) : 0;
        $refund_type  = !empty($_GET['refund_type']) ? trim($_GET['refund_type']) : '';
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);

        if (empty($refund_type)) {
            $data    = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_CANCEL)->data($params_order)->run();
            $message = __('取消订单成功', 'h5');
        } else {
            $params_order['reason_id']   = $reason_id;
            $params_order['refund_type'] = 'refund';
            $data                        = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_APPLY)->data($params_order)->run();
            $message                     = __('订单取消申请已提交至商家审核', 'h5');
        }

        $url = RC_Uri::url('user/order/order_detail', array('order_id' => $order_id));
        if (!is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
        }
    }

    // 再次购买 重新加入购物车
    public static function buy_again()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();

        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage('error', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (isset($data['goods_list'])) {
            foreach ($data['goods_list'] as $goods) {
                $params_cart = array(
                    'token'      => ecjia_touch_user::singleton()->getToken(),
                    'goods_id'   => $goods['goods_id'],
                	'product_id' => $goods['product_id'],
                    'number'     => $goods['goods_number'],
                    'location'   => array(
                        'longitude' => $_COOKIE['longitude'],
                        'latitude'  => $_COOKIE['latitude'],
                    ),
                    'city_id'  => $_COOKIE['city_id'],
                );
                if (!empty($goods['goods_attr_id'])) {
                    $params_cart['spec'] = explode(',', $goods['goods_attr_id']);
                }
                $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CREATE)->data($params_cart)->run();
                if (is_ecjia_error($rs)) {
                    if ($_GET['from'] == 'list') {
                        $url = RC_Uri::url('user/order/order_list');
                    } else {
                        $url = RC_Uri::url('user/order/order_detail', array('order_id' => $order_id, 'type' => 'detail'));
                    }
                    return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
                }
            }
        }

        $url = RC_Uri::url('cart/index/init');
        return ecjia_front::$controller->redirect($url);
    }

    /**
     * ajax获取订单
     */
    public static function async_order_list()
    {
        $size  = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $type  = isset($_GET['action_type']) ? $_GET['action_type'] : '';

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'pagination' => array('count' => $size, 'page' => $pages), 'type' => $type);
        if (!empty($_GET['keywords'])) {
            $params_order['type']     = 'whole';
            $params_order['keywords'] = $_GET['keywords'];
        }
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_LIST)->data($params_order)->hasPage()->run();
        if (!is_ecjia_error($data)) {
            list($orders, $page) = $data;
            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            $say_list = '';
            if (!empty($orders)) {
                ecjia_front::$controller->assign('order_list', $orders);
                ecjia_front::$controller->assign('type', $type);
                ecjia_front::$controller->assign_lang();
                $say_list = ecjia_front::$controller->fetch('user_order_list_ajax.dwt');
            }
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }

    /**
     * ajax获取售后订单
     */
    public static function async_return_order_list()
    {
        $size     = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages    = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $order_id = !empty($_GET['order_id']) ? intval($_GET['order_id']) : 0;

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'pagination' => array('count' => $size, 'page' => $pages));
        if (!empty($order_id)) {
            $params_order['order_id'] = $order_id;
        }
        $params_order['type'] = 'refund';
        if (!empty($order_id)) {
            $api = ecjia_touch_api::REFUND_LIST;
        } else {
            $api = ecjia_touch_api::REFUND_LIST;
        }
        $data = ecjia_touch_manager::make()->api($api)->data($params_order)->hasPage()->run();
        if (!is_ecjia_error($data)) {
            list($orders, $page) = $data;
            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            $say_list = '';
            if (!empty($orders)) {
                ecjia_front::$controller->assign('order_list', $orders);
                ecjia_front::$controller->assign_lang();
                if (!empty($order_id)) {
                    $say_list = ecjia_front::$controller->fetch('order_return_list_ajax.dwt');
                } else {
                    $say_list = ecjia_front::$controller->fetch('user_order_return_list_ajax.dwt');
                }
            }
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }

    /**
     * 确认收货
     */
    public static function affirm_received()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $order_type = trim($_GET['order_type']);

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_AFFIRMRECEIVED)->data($params_order)->run();

        if (isset($_GET['from']) && $_GET['from'] == 'list') {
            $url = RC_Uri::url('user/order/order_list', array('type' => $order_type));
        } else {
            $url = RC_Uri::url('user/order/order_detail', array('order_id' => $order_id));
        }

        if (!is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage(__("收货成功", 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
        }
    }

    /**
     * 评价晒单商品列表
     */
    public static function comment_list()
    {
        $token     = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();

        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $token . '-' . $user_info['id'] . '-' . $user_info['name'];
        $cache_id = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('user_comment_list.dwt', $cache_id)) {
            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
            //获取订单内商品列表
            $goods_data = array('token' => $token, 'order_id' => $order_id);
            $goods      = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDERS_COMMENT)->data($goods_data)->run();
            $goods_list = is_ecjia_error($goods) ? array() : $goods;

            ecjia_front::$controller->assign('order_id', $order_id);
            ecjia_front::$controller->assign('goods_list', $goods_list['comment_order_list']);
            ecjia_front::$controller->assign_lang();
        }
        return ecjia_front::$controller->display('user_comment_list.dwt', $cache_id);
    }

    /**
     * 商品评价
     */
    public static function goods_comment()
    {
        $token     = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();
        $cache_id  = $_SERVER['QUERY_STRING'] . '-' . $token . '-' . $user_info['id'] . '-' . $user_info['name'];
        $cache_id  = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('user_goods_comment.dwt', $cache_id)) {
            $goods_id = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

            //获取商品信息
            $goods_data                 = array('token' => $token, 'order_id' => $order_id);
            $goods                      = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDERS_COMMENT)->data($goods_data)->run();
            $goods_list                 = is_ecjia_error($goods) ? array() : $goods;
            $goods_info['rec_id']       = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
            $goods_info['is_commented'] = isset($_GET['is_commented']) ? intval($_GET['is_commented']) : 0;
            $goods_info['is_showorder'] = isset($_GET['is_showorder']) ? intval($_GET['is_showorder']) : 0;
            foreach ($goods_list['comment_order_list'] as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        if ($k == 'rec_id' && $v == $goods_info['rec_id']) {
                            $goods_info = $val;
                        }
                    }
                }
            }
            //rec_id返回的信息
            if ($goods_info['is_commented'] == 1) {
                $rec_data = array('token' => $token, 'rec_id' => $goods_info['rec_id']);
                $rec_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDERS_COMMENT_DETAIL)->data($rec_data)->run();
                $rec_info = is_ecjia_error($rec_info) ? array() : $rec_info;

                ecjia_front::$controller->assign('rec_info', $rec_info);
            }

            ecjia_front::$controller->assign('order_id', $order_id);
            ecjia_front::$controller->assign('goods', $goods_info);
            ecjia_front::$controller->assign_lang();
        }
        return ecjia_front::$controller->display('user_goods_comment.dwt', $cache_id);
    }

    public static function make_comment()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $order_id     = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $rec_id       = isset($_POST['rec_id']) ? intval($_POST['rec_id']) : '';
        $content      = !empty($_POST['note']) ? trim(htmlspecialchars($_POST['note'])) : __('商品质量俱佳，强烈推荐！', 'h5');
        $rank         = isset($_POST['score']) ? intval($_POST['score']) : 0;
        $is_anonymous = isset($_POST['anonymity_status']) ? intval($_POST['anonymity_status']) : '';

        $file  = array();
        $files = $_FILES['picture'];
        for ($i = 0; $i < 5; $i++) {
            if (!empty($files['name'][$i])) {
                $file['picture'][$i] = curl_file_create(realpath($files['tmp_name'][$i]), $files['type'][$i], $files['name'][$i]);
            }
        }
        $push_comment = array(
            'token'        => $token,
            "rec_id"       => $rec_id,
            "content"      => $content,
            "rank"         => $rank,
            "is_anonymous" => $is_anonymous,
        );

        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::COMMENT_CREATE)->data($push_comment)->file($file)->run();
        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
        } else {
            return ecjia_front::$controller->showmessage(__("提交成功", 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/order/comment_list', array('order_id' => $order_id))));
        }
    }

    public static function express_position()
    {
        $code       = trim($_GET['code']);
        $express_id = intval($_GET['express_id']);
        $order_id   = intval($_GET['order_id']);
        $store_id   = intval($_GET['store_id']);

        $token  = ecjia_touch_user::singleton()->getToken();
        $params = array('token' => $token, 'order_id' => $order_id, 'city_id' => $_COOKIE['city_id']);
        $data   = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params)->run();
        if (!is_ecjia_error($data)) {
            ecjia_front::$controller->assign('data', json_encode($data));
        }

        $params_express = array('token' => $token, 'order_id' => $order_id, 'express_id' => $express_id);
        $arr            = ecjia_touch_manager::make()->api(ecjia_touch_api::EXPRESS_USER_LOCATION)->data($params_express)->run();
        if (!is_ecjia_error($arr)) {
            ecjia_front::$controller->assign('arr', json_encode($arr));
        }
        ecjia_front::$controller->assign('express_info', $arr);
        ecjia_front::$controller->assign('hidenav', 1);
        if (!is_ecjia_error($data)) {
            if (!empty($data['order_status_log']) && $data['order_status_log'][0]['status'] == 'finished') {
                //店铺信息
                $parameter_list = array(
                    'seller_id' => $store_id,
                    'city_id'   => $_COOKIE['city_id'],
                );
                $store_info     = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
                if (!is_ecjia_error($store_info)) {
                    ecjia_front::$controller->assign('store_location', json_encode($store_info['location']));
                }
            }
            ecjia_front::$controller->assign_title(__('配送员位置', 'h5'));
            return ecjia_front::$controller->display('user_express_position.dwt');
        }
    }

    //申请售后列表
    public static function return_list()
    {
        $token     = ecjia_touch_user::singleton()->getToken();
        $order_id  = intval($_GET['order_id']);
        $refund_sn = trim($_GET['refund_sn']);

        ecjia_front::$controller->assign('order_id', $order_id);
        ecjia_front::$controller->assign('refund_sn', $refund_sn);

        ecjia_front::$controller->assign_title(__('申请查询', 'h5'));
        ecjia_front::$controller->assign('title', __('申请查询', 'h5'));

        $param = array('token' => $token, 'order_id' => $order_id, 'pagination' => array('count' => 10, 'page' => 1));
        $data  = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_LIST)->data($param)->run();

        $data = is_ecjia_error($data) ? array() : $data;
        ecjia_front::$controller->assign('order_list', $data);

        return ecjia_front::$controller->display('order_return_list.dwt');
    }

    //申请售后页面
    public static function return_order()
    {
        $order_id = intval($_GET['order_id']);
        $token    = ecjia_touch_user::singleton()->getToken();
        $type     = trim($_GET['type']);

        $params_order = array('token' => $token, 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();
        $data         = is_ecjia_error($data) ? array() : $data;

        //重新申请
        if (!empty($data['refund_info'])) {
            $reason_list = $data['refund_info']['refused_reasons'];
            $type        = $data['refund_info']['refund_type'];

            ecjia_front::$controller->assign('refund_info', $data['refund_info']);
        } else {
            if (empty($type)) {
                if ($data['order_status_code'] == 'await_ship' || $data['order_status_code'] == 'payed') {
                    $type                      = 'refund';
                    $data['order_status_code'] = 'await_ship';
                } else if ($data['order_status_code'] == 'shipped' || $type == 'finished') {
                    $type = 'return';
                }
            }
            $params      = array('token' => $token, 'type' => $data['order_status_code']);
            $reason_list = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_REASONS)->data($params)->run();
            $reason_list = !is_ecjia_error($reason_list) ? $reason_list : array();
        }
        ecjia_front::$controller->assign('reason_list', json_encode($reason_list));

        ecjia_front::$controller->assign('refund_fee_info', $data['refund_fee_info']);
        ecjia_front::$controller->assign('order', $data);

        ecjia_front::$controller->assign('order_id', $order_id);
        ecjia_front::$controller->assign('type', $type);

        ecjia_front::$controller->assign_title(__('申请售后', 'h5'));
        ecjia_front::$controller->assign('title', __('申请售后', 'h5'));

        ecjia_front::$controller->assign('img_list', array(0, 1, 2, 3, 4));

        return ecjia_front::$controller->display('order_return_apply.dwt');
    }

    //售后详情
    public static function return_detail()
    {
        $type      = !empty($_GET['type']) ? $_GET['type'] : 'detail';
        $refund_sn = trim($_GET['refund_sn']);
        ecjia_front::$controller->assign('refund_sn', $refund_sn);

        $order_id = !empty($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        ecjia_front::$controller->assign('order_id', $order_id);

        $token  = ecjia_touch_user::singleton()->getToken();
        $params = array('token' => $token, 'refund_sn' => $refund_sn);

        if ($type == 'status') {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_DETAIL)->data($params)->run();
            $data = is_ecjia_error($data) ? array() : $data;

            ecjia_front::$controller->assign('refund_logs', $data['refund_logs']);

            ecjia_front::$controller->assign_title(__('售后进度', 'h5'));
            ecjia_front::$controller->assign('title', __('售后进度', 'h5'));

            return ecjia_front::$controller->display('order_return_status.dwt');
        } elseif ($type == 'return_money') {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_PAYRECORD)->data($params)->run();
            $data = is_ecjia_error($data) ? array() : $data;

            ecjia_front::$controller->assign('data', $data);
            ecjia_front::$controller->assign_title(__('退款详情', 'h5'));
            ecjia_front::$controller->assign('title', __('退款详情', 'h5'));

            return ecjia_front::$controller->display('order_return_money.dwt');
        } else {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_DETAIL)->data($params)->run();
            $data = is_ecjia_error($data) ? array() : $data;

            ecjia_front::$controller->assign('order', $data);
            if (count($data['return_way_list']) == 1) {
                ecjia_front::$controller->assign('return_way_info', $data['return_way_list'][0]);
            }

            if (!empty($data['refund_logs'])) {
                ecjia_front::$controller->assign('refund_logs', $data['refund_logs'][0]);
            }

            ecjia_front::$controller->assign_title(__('售后详情', 'h5'));
            ecjia_front::$controller->assign('title', __('售后详情', 'h5'));

            return ecjia_front::$controller->display('order_return_detail.dwt');
        }
    }

    public static function add_return()
    {
        RC_Logger::getlogger('info')->info([
            'file' => __FILE__,
            'line' => __LINE__,
            '$_FILES' => $_FILES,
            '$file' => $file,
            'post' => $_POST
        ]);
        
        $order_id           = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $reason_id          = !empty($_POST['reason_id']) ? intval($_POST['reason_id']) : 0;
        $refund_type        = !empty($_POST['refund_type']) ? trim($_POST['refund_type']) : '';
        $refund_description = !empty($_POST['question_desc']) ? trim(htmlspecialchars($_POST['question_desc'])) : '';
        $refund_sn          = !empty($_POST['refund_sn']) ? trim($_POST['refund_sn']) : '';

        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($reason_id)) {
            return ecjia_front::$controller->showmessage(__('申请失败，请选择售后原因', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($refund_description)) {
            return ecjia_front::$controller->showmessage(__('申请失败，请填写问题描述', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file  = array();
        $files = $_FILES['refund_images'];
        for ($i = 0; $i < 5; $i++) {
            if (!empty($files['name'][$i])) {
                $file['refund_images'][$i] = curl_file_create(realpath($files['tmp_name'][$i]), $files['type'][$i], $files['name'][$i]);
            }
        }
        $params = array(
            'token'              => ecjia_touch_user::singleton()->getToken(),
            'order_id'           => $order_id,
            'refund_sn'          => $refund_sn,
            'refund_type'        => $refund_type,
            'reason_id'          => $reason_id,
            'refund_description' => $refund_description,
        );
        RC_Logger::getlogger('info')->info([
            'file' => __FILE__,
            'line' => __LINE__,
            '$file' => $file,
        ]);

        $data   = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_APPLY)->data($params)->file($file)->run();
        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $url = RC_Uri::url('user/order/order_detail', array('order_id' => $order_id));
        return ecjia_front::$controller->showmessage(__('提交成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
    }

    //撤销申请
    public static function undo_reply()
    {
        $refund_sn    = isset($_GET['refund_sn']) ? trim($_GET['refund_sn']) : '';
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'refund_sn' => $refund_sn);

        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_CANCEL)->data($params_order)->run();
        $url  = RC_Uri::url('user/order/return_detail', array('refund_sn' => $refund_sn));
        if (!is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage(__('撤销成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
        }
    }

    //返还方式列表
    public static function return_way_list()
    {
        $refund_sn = isset($_GET['refund_sn']) ? trim($_GET['refund_sn']) : '';
        if (empty($refund_sn)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }

        $token  = ecjia_touch_user::singleton()->getToken();
        $params = array('token' => $token, 'refund_sn' => $refund_sn);
        $data   = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_DETAIL)->data($params)->run();
        $data   = is_ecjia_error($data) ? array() : $data;

        ecjia_front::$controller->assign('data', $data);
        ecjia_front::$controller->assign('refund_sn', $refund_sn);

        return ecjia_front::$controller->display('order_return_way_list.dwt');
    }

    public static function return_way()
    {
        $refund_sn = isset($_GET['refund_sn']) ? trim($_GET['refund_sn']) : '';
        if (empty($refund_sn)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }
        $type = !empty($_GET['type']) ? trim($_GET['type']) : '';
        ecjia_front::$controller->assign('type', $type);

        $token  = ecjia_touch_user::singleton()->getToken();
        $params = array('token' => $token, 'refund_sn' => $refund_sn);
        $data   = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_DETAIL)->data($params)->run();
        $data   = is_ecjia_error($data) ? array() : $data;

        $return_info = array();
        if (!empty($data) && !empty($data['return_way_list'])) {
            foreach ($data['return_way_list'] as $k => $v) {
                if ($type == $v['return_way_code']) {
                    $return_info = $v;
                }
            }
        }

        ecjia_front::$controller->assign('return_info', $return_info);
        ecjia_front::$controller->assign('refund_sn', $refund_sn);

        return ecjia_front::$controller->display('order_return_way.dwt');
    }

    public static function add_return_way()
    {
        $refund_sn = isset($_POST['refund_sn']) ? trim($_POST['refund_sn']) : '';
        if (empty($refund_sn)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $type = !empty($_POST['type']) ? trim($_POST['type']) : '';

        $token = ecjia_touch_user::singleton()->getToken();

        if ($type == 'home') {
            $pickup_address     = !empty($_POST['pickup_address']) ? trim($_POST['pickup_address']) : '';
            $expect_pickup_time = !empty($_POST['expect_pickup_time']) ? trim($_POST['expect_pickup_time']) : '';
            $contact_name       = !empty($_POST['contact_name']) ? trim($_POST['contact_name']) : '';
            $contact_phone      = !empty($_POST['contact_phone']) ? trim($_POST['contact_phone']) : '';

            if (empty($expect_pickup_time)) {
                return ecjia_front::$controller->showmessage(__('请选择期望取件时间', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (empty($contact_name)) {
                return ecjia_front::$controller->showmessage(__('请输入联系人', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (empty($contact_phone)) {
                return ecjia_front::$controller->showmessage(__('请输入联系电话', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $params = array(
                'token'              => $token,
                'refund_sn'          => $refund_sn,
                'pickup_address'     => $pickup_address,
                'expect_pickup_time' => $expect_pickup_time,
                'contact_name'       => $contact_name,
                'contact_phone'      => $contact_phone,
            );
            $api    = ecjia_touch_api::REFUND_RETURNWAY_HOME;
        }

        if ($type == 'express') {
            $recipients        = !empty($_POST['recipients']) ? trim($_POST['recipients']) : '';
            $contact_phone     = !empty($_POST['contact_phone']) ? trim($_POST['contact_phone']) : '';
            $recipient_address = !empty($_POST['recipient_address']) ? trim($_POST['recipient_address']) : '';
            $shipping_name     = !empty($_POST['shipping_name']) ? trim($_POST['shipping_name']) : '';
            $shipping_sn       = !empty($_POST['shipping_sn']) ? trim($_POST['shipping_sn']) : '';

            if (empty($shipping_name)) {
                return ecjia_front::$controller->showmessage(__('请输入快递名称', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($shipping_sn)) {
                return ecjia_front::$controller->showmessage(__('请输入快递单号', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $params = array(
                'token'             => $token,
                'refund_sn'         => $refund_sn,
                'recipient_address' => $recipient_address,
                'recipients'        => $recipients,
                'contact_phone'     => $contact_phone,
                'shipping_name'     => $shipping_name,
                'shipping_sn'       => $shipping_sn,
            );
            $api    = ecjia_touch_api::REFUND_RETURNWAY_EXPRESS;
        }

        if ($type == 'shop') {
            $store_name    = !empty($_POST['store_name']) ? trim($_POST['store_name']) : '';
            $contact_phone = !empty($_POST['contact_phone']) ? trim($_POST['contact_phone']) : '';
            $store_address = !empty($_POST['store_address']) ? trim($_POST['store_address']) : '';

            $params = array(
                'token'         => $token,
                'refund_sn'     => $refund_sn,
                'store_name'    => $store_name,
                'contact_phone' => $contact_phone,
                'store_address' => $store_address,
            );
            $api    = ecjia_touch_api::REFUND_RETURNWAY_SHOP;
        }
        $data = ecjia_touch_manager::make()->api($api)->data($params)->run();

        $url = RC_Uri::url('user/order/return_detail', array('refund_sn' => $refund_sn));
        if (!is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage(__('提交成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 团购订单列表
     */
    public static function groupbuy_order()
    {
        $token = ecjia_touch_user::singleton()->getToken();

        $params_order = array('token' => $token, 'pagination' => array('count' => 10, 'page' => 1));
        if (!empty($_GET['keywords'])) {
            $params_order['keywords'] = $_GET['keywords'];
            ecjia_front::$controller->assign('keywords', $params_order['keywords']);
        }
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::GROUPBUY_ORDER_LIST)->data($params_order)->run();
        $data = is_ecjia_error($data) ? array() : $data;

        ecjia_front::$controller->assign('order_list', $data);

        $title = '我的团购';
        ecjia_front::$controller->assign_title($title);
        ecjia_front::$controller->assign('title', $title);

        ecjia_front::$controller->assign_lang();
        return ecjia_front::$controller->display('user_groupbuy_order_list.dwt');
    }

    /**
     * ajax获取团购订单
     */
    public static function async_groupbuy_order()
    {
        $size  = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'pagination' => array('count' => $size, 'page' => $pages));
        if (!empty($_GET['keywords'])) {
            $params_order['keywords'] = $_GET['keywords'];
        }
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::GROUPBUY_ORDER_LIST)->data($params_order)->hasPage()->run();
        if (!is_ecjia_error($data)) {
            list($orders, $page) = $data;
            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            $say_list = '';
            if (!empty($orders)) {
                ecjia_front::$controller->assign('order_list', $orders);
                ecjia_front::$controller->assign_lang();
                $say_list = ecjia_front::$controller->fetch('user_groupbuy_order_list_ajax.dwt');
            }
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }

    /**
     * 团购订单详情
     */
    public static function groupbuy_detail()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $type     = !empty($_GET['type']) ? $_GET['type'] : 'detail';
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/order/order_list')));
        }

        $token        = ecjia_touch_user::singleton()->getToken();
        $user_info    = ecjia_touch_user::singleton()->getUserinfo();
        $params_order = array('token' => $token, 'order_id' => $order_id);
        $data         = ecjia_touch_manager::make()->api(ecjia_touch_api::GROUPBUY_ORDER_DETAIL)->data($params_order)->run();
        $data         = is_ecjia_error($data) ? array() : $data;

        $data['formated_payed'] = ecjia_price_format($data['money_paid'] + $data['surplus']);
        if (empty($data)) {
            return ecjia_front::$controller->showmessage(__('订单不存在', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/order/order_list')));
        }
        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $token . '-' . $user_info['id'] . '-' . $user_info['name']
            . '-' . $data['order_status'] . '-' . $data['shipping_status'] . '-' . $data['pay_status'];
        $cache_id = sprintf('%X', crc32($cache_id));

        if ($type == 'detail') {
            if (!ecjia_front::$controller->is_cached('user_order_detail.dwt', $cache_id)) {
                ecjia_front::$controller->assign('order', $data);
                ecjia_front::$controller->assign('headInfo', $data['order_status_log'][0]);
                if (($data['shipping_code'] == 'ship_o2o_express' || $data['shipping_code'] == 'ship_ecjia_express') && !empty($data['express_id'])) {
                    ecjia_front::$controller->assign('express_url', RC_Uri::url('user/order/express_position', array('code' => $data['shipping_code'], 'express_id' => $data['express_id'], 'order_id' => $data['order_id'], 'store_id' => $data['store_id'])));
                }
                ecjia_front::$controller->assign('title', __('订单详情', 'h5'));
                ecjia_front::$controller->assign_title(__('订单详情', 'h5'));
                ecjia_front::$controller->assign_lang();

                if (!empty($data['order_status_code'])) {
                    $params      = array('token' => $token, 'type' => $data['order_status_code']);
                    $reason_list = ecjia_touch_manager::make()->api(ecjia_touch_api::REFUND_REASONS)->data($params)->run();
                    $reason_list = !is_ecjia_error($reason_list) ? $reason_list : array();

                    ecjia_front::$controller->assign('reason_list', json_encode($reason_list));
                    ecjia_front::$controller->assign('refund_type', 'refund');
                }
            }
            if ($data['order_mode'] == 'storebuy') {
                return ecjia_front::$controller->display('user_order_storebuy_detail.dwt', $cache_id);
            } else {
                //店铺信息
                $parameter_list = array(
                    'seller_id' => $data['store_id'],
                    'city_id'   => $_COOKIE['city_id'],
                );
                $store_info     = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
                $store_info     = is_ecjia_error($store_info) ? array() : $store_info;

                if (!empty($store_info)) {
                    $map_url   = 'https://3gimg.qq.com/lightmap/v1/marker/index.html?type=0&marker=coord:';
                    $url_param = $store_info['location']['latitude'] . ',' . $store_info['location']['longitude'] . ';title:' . $store_info['seller_name'] . ';addr:' . $store_info['shop_address'];
                    $url_param = urlencode($url_param);
                    $map_url   .= $url_param;
                    ecjia_front::$controller->assign('location_url', $map_url);
                }
                return ecjia_front::$controller->display('user_order_detail.dwt', $cache_id);
            }
        } else {
            if (!ecjia_front::$controller->is_cached('user_order_status.dwt', $cache_id)) {
                ecjia_front::$controller->assign('order', $data);
                ecjia_front::$controller->assign('title', __('订单状态', 'h5'));
                ecjia_front::$controller->assign_title(__('订单状态', 'h5'));
                ecjia_front::$controller->assign_lang();
            }
            return ecjia_front::$controller->display('user_order_status.dwt', $cache_id);
        }
    }

    //订单分成
    public static function affiliate()
    {
        $status = !empty($_GET['status']) ? trim($_GET['status']) : 'await_separate';
        $title  = __('订单分成', 'h5');

        ecjia_front::$controller->assign_title($title);
        ecjia_front::$controller->assign('status', $status);

        return ecjia_front::$controller->display('user_order_affiliate.dwt');
    }

    //获取分成订单
    public static function ajax_order_affiliate()
    {
        $status = !empty($_GET['status']) ? trim($_GET['status']) : 'await_separate';
        $limit  = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages  = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $token = ecjia_touch_user::singleton()->getToken();

        $param  = array(
            'token'      => $token,
            'status'     => $status,
            'pagination' => array('count' => $limit, 'page' => $pages),
        );
        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::AFFILIATE_ORDER_RECORDS)->data($param)->hasPage()->run();
        if (!is_ecjia_error($result)) {
            list($data, $page) = $result;

            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            if (!empty($data)) {
                ecjia_front::$controller->assign('list', $data);
            }
            $say_list = ecjia_front::$controller->fetch('user_order_affiliate_ajax.dwt');

            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }

    //分成订单详情
    public static function affiliate_detail()
    {
        $id    = intval($_GET['id']);
        $title = __('分成详情', 'h5');
        ecjia_front::$controller->assign_title($title);

        $token = ecjia_touch_user::singleton()->getToken();
        $param = array(
            'token'    => $token,
            'order_id' => $id,
        );

        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::AFFILIATE_ORDER_DETAIL)->data($param)->run();
        $data = is_ecjia_error($data) ? [] : $data;

        ecjia_front::$controller->assign('data', $data);
        return ecjia_front::$controller->display('user_order_affiliate_detail.dwt');
    }
}

// end
