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
class user_order_controller {
    /**
     * 获取全部订单
     */
    public static function order_list() {
        $token = ecjia_touch_user::singleton()->getToken();
        
        $type = isset($_GET['type']) ? $_GET['type'] : '';
    
        $params_order = array('token' => $token, 'pagination' => array('count' => 10, 'page' => 1), 'type' => $type);
        if (!empty($_GET['keywords'])) {
            $params_order['type'] = 'whole';
            $params_order['keywords'] = $_GET['keywords'];
            ecjia_front::$controller->assign('keywords', $params_order['keywords']);
        }
  
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_LIST)->data($params_order)->run();
        $data = is_ecjia_error($data) ? array() : $data;

        ecjia_front::$controller->assign('type', $type);
        ecjia_front::$controller->assign('order_list', $data);
        ecjia_front::$controller->assign_title('全部订单');
        ecjia_front::$controller->assign('title', '全部订单');
        ecjia_front::$controller->assign('active', 'orderList');
         
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_order_list.dwt');
    }
    
    /**
     * 订单详情
     */
    public static function order_detail() {
        
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/order/order_list')));
        }
        
        $token = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();
        $params_order = array('token' => $token, 'order_id' => $order_id);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();
        $data = is_ecjia_error($data) ? array() : $data;
        if (empty($data)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/order/order_list')));
        }
        
        $cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name']
            .'-'.$data['order_status'].'-'.$data['shipping_status'].'-'.$data['pay_status'];
        $cache_id = sprintf('%X', crc32($cache_id));
        
        if (!ecjia_front::$controller->is_cached('user_order_detail.dwt', $cache_id)) {
            
            ecjia_front::$controller->assign('order', $data);
            ecjia_front::$controller->assign('title', '订单详情');
            ecjia_front::$controller->assign_title('订单详情');
            ecjia_front::$controller->assign_lang();
        }
        ecjia_front::$controller->display('user_order_detail.dwt', $cache_id);
    }

    /**
     * 取消订单
     */
    public static function order_cancel() {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_CANCEL)->data($params_order)->run();

        $url = RC_Uri::url('user/order/order_detail', array('order_id' => $order_id));
        if (! is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage('取消订单成功', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url,'is_show' => false));
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
        }
    }
    
    // 再次购买 重新加入购物车
    public static function buy_again() {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();
        
        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage('error', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (isset($data['goods_list'])) {
            foreach ($data['goods_list'] as $goods) {
                $params_cart = array(
                    'token' => ecjia_touch_user::singleton()->getToken(),
                    'goods_id' => $goods['goods_id'],
                    'number' => $goods['goods_number'],
                    'location' => array(
                        'longitude' => $_COOKIE['longitude'],
                        'latitude' => $_COOKIE['latitude']
                    ),
                    'city_id' => $_COOKIE['city_id']
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
            $url = RC_Uri::url('cart/index/init');
            ecjia_front::$controller->redirect($url);
        }
    }
    
    /**
    * ajax获取订单
    */
    public static function async_order_list() {
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $type = isset($_GET['action_type']) ? $_GET['action_type'] : '';

        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'pagination' => array('count' => $size, 'page' => $pages), 'type' => $type);
        if (!empty($_GET['keywords'])) {
            $params_order['type'] = 'whole';
            $params_order['keywords'] = $_GET['keywords'];
        }
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_LIST)->data($params_order)->hasPage()->run();
        if (!is_ecjia_error($data)) {
            list($orders, $page) = $data;
            if (isset($page['more']) && $page['more'] == 0) $is_last = 1;
            
            $say_list = '';
            if (!empty($orders)) {
            	ecjia_front::$controller->assign('order_list', $orders);
            	ecjia_front::$controller->assign_lang();
            	$say_list = ecjia_front::$controller->fetch('user_order_list.dwt');
            }
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }

    /**
    * 确认收货
    */
    public static function affirm_received() {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_AFFIRMRECEIVED)->data($params_order)->run();
        
        if (isset($_GET['from']) && $_GET['from'] == 'list') {
            $url = RC_Uri::url('user/order/order_list');
        } else {
            $url = RC_Uri::url('user/order/order_detail', array('order_id' => $order_id));
        }
        if (! is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage("收货成功", ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_SUCCESS);
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }
    }
    
    /**
     * 评价晒单商品列表
     */
    public static function comment_list() {
        $token = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();
        
        $cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
        $cache_id = sprintf('%X', crc32($cache_id));
        
        if (!ecjia_front::$controller->is_cached('user_comment_list.dwt', $cache_id)) {
            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
            //获取订单内商品列表
            $goods_data = array('token' => $token, 'order_id' => $order_id);
            $goods = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDERS_COMMENT)->data($goods_data)->run();
            $goods_list = is_ecjia_error($goods) ? array() : $goods;
            
            ecjia_front::$controller->assign('order_id', $order_id);
            ecjia_front::$controller->assign('goods_list', $goods_list['comment_order_list']);
            ecjia_front::$controller->assign_lang();
        }
        ecjia_front::$controller->display('user_comment_list.dwt', $cache_id);
    }
    
    /**
     * 商品评价
     */
    public static function goods_comment() {
        $token      = ecjia_touch_user::singleton()->getToken();
        $cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
        $cache_id = sprintf('%X', crc32($cache_id));
        
        if (!ecjia_front::$controller->is_cached('user_goods_comment.dwt', $cache_id)) {
            $goods_id = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
            
            //获取商品信息
            $goods_data = array('token' => $token, 'order_id' => $order_id);
            $goods = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDERS_COMMENT)->data($goods_data)->run();
            $goods_list = is_ecjia_error($goods) ? array() : $goods;
            $goods_info['rec_id'] = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
            $goods_info['is_commented'] = isset($_GET['is_commented']) ? intval($_GET['is_commented']) : 0;
            $goods_info['is_showorder'] = isset($_GET['is_showorder']) ? intval($_GET['is_showorder']) : 0;
            foreach ($goods_list['comment_order_list'] as $key => $val){
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
                $rec_id = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDERS_COMMENT_DETAIL)->data($rec_data)->run();
                $rec_info = is_ecjia_error($rec_id) ? array() : $rec_id;
                ecjia_front::$controller->assign('rec_info', $rec_info);
            }
            
            ecjia_front::$controller->assign('order_id', $order_id);
            ecjia_front::$controller->assign('goods', $goods_info);
            ecjia_front::$controller->assign_lang();
        }
        ecjia_front::$controller->display('user_goods_comment.dwt', $cache_id);
    }
    
    public static function make_comment() {
        $token = ecjia_touch_user::singleton()->getToken();
        
        $order_id 		= isset($_POST['order_id']) 		? intval($_POST['order_id']) 			: 0;
        $rec_id 		= isset($_POST['rec_id']) 			? intval($_POST['rec_id']) 				: '';
        $content 		= !empty($_POST['note']) 			? $_POST['note'] 						: '商品质量俱佳，强烈推荐！';
        $rank 			= isset($_POST['score']) 			? intval($_POST['score']) 				: 0;
        $is_anonymous 	= isset($_POST['anonymity_status']) ? intval($_POST['anonymity_status']) 	: '';
       
        $picture = array();
        $_FILES = $_FILES['picture'];
        for ($i=0; $i<5; $i++) {
            if (!empty($_FILES['name'][$i])) {
                $picture['picture['.$i.']'] = '@'.realpath($_FILES['tmp_name'][$i]).";type=".$_FILES['type'][$i].";filename=".$_FILES['name'][$i];
            }
        }

        $push_comment = array(
            'token'         => $token,
            "rec_id"        => $rec_id,
            "content"       => $content,
            "rank"          => $rank,
            "is_anonymous"  => $is_anonymous
        );
        
        $push_comment = array_merge($push_comment, $picture);
        
        $api_url = RC_Hook::apply_filters('custom_site_api_url', RC_Uri::home_url() . ecjia_touch_manager::serverHost . ecjia_touch_api::COMMENT_CREATE);
        $data = touch_function::upload_file($api_url, $push_comment);
        $data = touch_function::format_curl_response($data);
        if (is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
        } else {
            return ecjia_front::$controller->showmessage("提交成功 " , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/order/comment_list', array('order_id' => $order_id))));
        }
    }
}

// end