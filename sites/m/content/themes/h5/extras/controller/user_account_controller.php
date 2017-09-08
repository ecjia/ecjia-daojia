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
use Guzzle\Http\Message\Header;
use Royalcms\Component\Image\Size;
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 资金模块控制器代码
 */
class user_account_controller {

    /**
    * 资金管理
    */
    public static function init() {
        $token = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();
        
        $cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
        $cache_id = sprintf('%X', crc32($cache_id));
        
        if (!ecjia_front::$controller->is_cached('user_account_detail.dwt', $cache_id)) {
            $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
            $user = is_ecjia_error($user) ? array() : $user;
            
            ecjia_front::$controller->assign('user', $user);
            ecjia_front::$controller->assign_title('我的钱包');
        }
        ecjia_front::$controller->display('user_account_detail.dwt', $cache_id);
    }
    /**
     * 余额
     */
    public static function balance(){
        $token = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();
        
        $cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
        $cache_id = sprintf('%X', crc32($cache_id));
        
        if (!ecjia_front::$controller->is_cached('user_account_balance.dwt', $cache_id)) {
            $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
            $user = is_ecjia_error($user) ? array() : $user;
            
            ecjia_front::$controller->assign_title('我的余额');
            ecjia_front::$controller->assign('user', $user);
        }
       
        ecjia_front::$controller->display('user_account_balance.dwt', $cache_id);
    }
    /**
    * 充值
    */
    public static function recharge() {
    	$token = ecjia_touch_user::singleton()->getToken();
    	$user_info = ecjia_touch_user::singleton()->getUserinfo();
    	
    	$cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
    	$cache_id = sprintf('%X', crc32($cache_id));
    	
    	if (!ecjia_front::$controller->is_cached('user_account_recharge.dwt', $cache_id)) {
	        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
	        $user = is_ecjia_error($user) ? array() : $user;
	        $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_PAYMENT)->run();
	        $pay = is_ecjia_error($pay) ? array() : $pay;
	        
	        if (!empty($pay['payment'])) {
	            foreach ($pay['payment'] as $key => $val) {
	                if ($val['is_online'] == '0' || $val['pay_code'] == 'pay_balance') {
	                    unset($pay['payment'][$key]);
	                }
	            }
	        }
	        
	        /*根据浏览器过滤支付方式，微信自带浏览器过滤掉支付宝支付，其他浏览器过滤掉微信支付*/
	        if (!empty($pay['payment'])) {
	            if (cart_function::is_weixin() == true) {
	                foreach ($pay['payment'] as $key => $val) {
	                    if ($val['pay_code'] == 'pay_alipay') {
	                        unset($pay['payment'][$key]);
	                    }
	                    if ($val['pay_code'] == 'pay_wxpay') {
// 	                        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
// 	                        $payment_info = $payment_method->payment_info_by_id($val['pay_id']);
	                        // 取得支付信息，生成支付代码
// 	                        $payment_config = $payment_method->unserialize_config($val['pay_config']);
	        
// 	                        $handler = $payment_method->get_payment_instance($val['pay_code'], $payment_config);
	                        $handler = with(new Ecjia\App\Payment\PaymentPlugin)->channel($val['pay_code']);
	                        $open_id = $handler->get_open_id();
	                        $_SESSION['wxpay_open_id'] = $open_id;
	                    }
	                }
	                ecjia_front::$controller->assign('brownser', 1);
	            } else {
	                foreach ($pay['payment'] as $key => $val) {
	                    if ($val['pay_code'] == 'pay_wxpay') {
	                        unset($pay['payment'][$key]);
	                    }
	                }
	            }
	        }
	        
	        $pay['payment'][array_keys($pay['payment'])[0]]['checked'] = true;
            ecjia_front::$controller->assign('payment_list', $pay['payment']);
            ecjia_front::$controller->assign('user', $user);
            ecjia_front::$controller->assign_title('充值');
            
            //生成返回url cookie
            RC_Cookie::set('pay_response_index', RC_Uri::url('touch/index/init'));
        }
        ecjia_front::$controller->display('user_account_recharge.dwt', $cache_id);
    }


    /**
     *  对会员余额申请的处理
     */
    public static function recharge_account() {
    	$amount = is_numeric($_POST['amount']) ? ($_POST['amount']) : '';
    	$payment_id = !empty($_POST['payment_id']) ? intval($_POST['payment_id']) : '';
    	$account_id = !empty($_POST['account_id']) ? intval($_POST['account_id']) : '';
    	$brownser_wx = $_POST['brownser_wx'];
    	$brownser_other = $_POST['brownser_other'];

    	if ($brownser_wx == 1) {
    		return ecjia_front::$controller->showmessage(__('请使用其他浏览器打开进行支付'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/account/record')));
    	} elseif ($brownser_other == 1) {
    		return ecjia_front::$controller->showmessage(__('请使用微信浏览器打开进行支付'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/account/record')));
    	}
    	
    	if (!empty($amount)) {
    		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_DEPOSIT)->data(array('amount' => $amount, 'payment_id' => $payment_id, 'account_id' => $account_id))->run();
    		if (! is_ecjia_error($data)) {
    		    $data_payment_id = $data['payment']['payment_id'];
    		    $data_account_id = $data['payment']['account_id'];

		        $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_PAY)->data(array('account_id' => $data_account_id, 'payment_id' => $data_payment_id, 'wxpay_open_id' => $_SESSION['wxpay_open_id']))->run();
		        if (! is_ecjia_error($pay)) {
		            //生成返回url cookie
		            RC_Cookie::set('pay_response_index', RC_Uri::url('touch/index/init'));
		            RC_Cookie::set('pay_response_order', RC_Uri::url('user/account/record', array('status' => 'deposit')));

		            $pay_online = array_get($pay, 'payment.private_data.pay_online', array_get($pay, 'payment.pay_online'));
		            if (array_get($pay, 'payment.pay_code') == 'pay_alipay') {
		                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('redirect_url' => $pay_online, 'pay_name' => 'ali'));
		            } else if (array_get($pay, 'payment.pay_code') == 'pay_wxpay'){
		                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('weixin_data' => $pay_online, 'pay_name' => 'weixin'));
		            } else {
		                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('redirect_url' => $pay_online, 'pay_name' => 'redirect'));
		            }
		        } else {
		            return ecjia_front::$controller->showmessage($pay->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
    		}
    	} else {
    		return ecjia_front::$controller->showmessage(__('金额不能为空'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    
    /**
    * 提现
    */
    public static function withdraw() {
        $token = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();
        
        $cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
        $cache_id = sprintf('%X', crc32($cache_id));
        
        if (!ecjia_front::$controller->is_cached('user_account_withdraw.dwt', $cache_id)) {
            $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
            $user = is_ecjia_error($user) ? array() : $user;
            ecjia_front::$controller->assign('user', $user);
            
            ecjia_front::$controller->assign_title('提现');
        }
        ecjia_front::$controller->display('user_account_withdraw.dwt', $cache_id);
    }

    /**
     *  对会员余额申请的处理
     */
    public static function withdraw_account() {
        $amount = !empty($_POST['amount']) ? $_POST['amount'] : '';
        $note   = !empty($_POST['user_note']) ? $_POST['user_note'] : '';
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        if (is_ecjia_error($user)) {
            return ecjia_front::$controller->showmessage(__('error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $user_money = ltrim($user['formated_user_money'], '￥');
        if ($amount > $user_money) {
            return ecjia_front::$controller->showmessage(__('余额不足，请确定提现金额'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (strlen($note) > '300') {
            return ecjia_front::$controller->showmessage(__('输入的文字超过规定字数'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($amount)) {
            return ecjia_front::$controller->showmessage(__('请输入提现金额'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_RAPLY)->data(array('amount' => $amount, 'note' => $note))->run();
            $data = is_ecjia_error($data) ? 'error' : $data;
            return ecjia_front::$controller->showmessage(__($data), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/account/balance')));
        }
    }
    
    /**
     * 充值提现列表
     */
    public static function record() {
        ecjia_front::$controller->assign_title('交易记录');
    	ecjia_front::$controller->display('user_record.dwt');
    }
    
    public static function ajax_record() {
        $type = '';
    	$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
    	$pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	$account_list = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_RECORD)->data(array('pagination' => array('page' => $pages, 'count' => $limit), 'type' => $type))->hasPage()->run();
    	if (!is_ecjia_error($account_list)) {
    	    list($data, $page) = $account_list;

    	    $now_mon =  substr(date('Y-m-d H:i:s',time()),5,2);
        	$now_day =  substr(date('Y-m-d H:i:s',time()),0,10);
        	$time = '';
        	foreach ($data as $key => $val) {
        	    if ($time != substr($val['add_time'],5,2)) {
        	        $time = substr($val['add_time'],5,2);
        	        $day = substr($val['add_time'],8,2);
        	    }
        	    $arr[$time][$key] = $data[$key];
        	    $day = substr($val['add_time'],0,10);
        	    if ($day == $now_day) {
        	        $arr[$time][$key]['add_time'] = '今天'.substr($val['add_time'],11,5);
        	    } else {
        	        $arr[$time][$key]['add_time'] = substr($val['add_time'],5,11);
        	    }
        	}
        	foreach ($arr as $key => $val) {
                ecjia_front::$controller->assign('key'.$key, $key);    	    
        	}
        	$user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
        	$user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        	if (!is_ecjia_error($user) && !empty($user['avatar_img'])) {
        	    $user_img = $user['avatar_img'];
        	}
        	ecjia_front::$controller->assign('user_img', $user_img);
        	ecjia_front::$controller->assign('type', $type);
        	ecjia_front::$controller->assign('now_mon', $now_mon);
        	ecjia_front::$controller->assign('now_day', $now_day);
        	ecjia_front::$controller->assign('sur_amount', $arr);
        	ecjia_front::$controller->assign_lang();
        	$say_list = ecjia_front::$controller->fetch('user_record.dwt');
        	if (isset($page['more']) && $page['more'] == 0) $is_last = 1;
        	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
    	}
    }

    /*提现列表*/
    public static function ajax_record_raply() {
        $type = 'raply';
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $account_list = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_RECORD)->data(array('pagination' => array('page' => $pages, 'count' => $limit), 'type' => $type))->hasPage()->run();

        if (!is_ecjia_error($account_list)) {
            list($data, $page) = $account_list;
            
            $now_mon =  substr(date('Y-m-d H:i:s',time()),5,2);
            $now_day =  substr(date('Y-m-d H:i:s',time()),0,10);
            $time = '';
            foreach ($data as $key => $val) {
                if ($time != substr($val['add_time'],5,2)) {
                    $time = substr($val['add_time'],5,2);
                    $day = substr($val['add_time'],8,2);
                }
                $arr[$time][$key] = $data[$key];
                $day = substr($val['add_time'],0,10);
                if ($day == $now_day) {
                    $arr[$time][$key]['add_time'] = '今天'.substr($val['add_time'],11,5);
                } else {
                    $arr[$time][$key]['add_time'] = substr($val['add_time'],5,11);
                }
            }
            foreach ($arr as $key => $val) {
                ecjia_front::$controller->assign('key'.$key, $key);
            }
            $user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
            $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
            if (!is_ecjia_error($user) && !empty($user['avatar_img'])) {
                $user_img = $user['avatar_img'];
            }
            ecjia_front::$controller->assign('user_img', $user_img);
            ecjia_front::$controller->assign('type', $type);
            ecjia_front::$controller->assign('now_mon', $now_mon);
            ecjia_front::$controller->assign('now_day', $now_day);
            ecjia_front::$controller->assign('sur_amount', $arr);
            ecjia_front::$controller->assign_lang();

            $say_list = ecjia_front::$controller->fetch('user_record.dwt');
            if (isset($page['more']) && $page['more'] == 0) $is_last = 1;
            
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }
    
    /*充值列表*/
    public static function ajax_record_deposit() {
        $type = 'deposit';
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $account_list = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_RECORD)->data(array('pagination' => array('page' => $pages, 'count' => $limit), 'type' => $type))->hasPage()->run();

        if (!is_ecjia_error($account_list)) {
            list($data, $page) = $account_list;
            $now_mon =  substr(date('Y-m-d H:i:s',time()),5,2);
            $now_day =  substr(date('Y-m-d H:i:s',time()),0,10);
            $time = '';
            foreach ($data as $key => $val) {
                if ($time != substr($val['add_time'],5,2)) {
                    $time = substr($val['add_time'],5,2);
                    $day = substr($val['add_time'],8,2);
                }
                $arr[$time][$key] = $data[$key];
                $day = substr($val['add_time'],0,10);
                if ($day == $now_day) {
                    $arr[$time][$key]['add_time'] = '今天'.substr($val['add_time'],11,5);
                } else {
                    $arr[$time][$key]['add_time'] = substr($val['add_time'],5,11);
                }
            }
            foreach ($arr as $key => $val) {
                ecjia_front::$controller->assign('key'.$key, $key);
            }
            $user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
            $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
            if (!is_ecjia_error($user) && !empty($user['avatar_img'])) {
                $user_img = $user['avatar_img'];
            }
            ecjia_front::$controller->assign('user_img', $user_img);
            ecjia_front::$controller->assign('type', $type);
            ecjia_front::$controller->assign('now_mon', $now_mon);
            ecjia_front::$controller->assign('now_day', $now_day);
            ecjia_front::$controller->assign('sur_amount', $arr);
            ecjia_front::$controller->assign_lang();
            $say_list = ecjia_front::$controller->fetch('user_record.dwt');
            
            if (isset($page['more']) && $page['more'] == 0) $is_last = 1;
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }
    /**
     * 充值提现详情
     */
    public static function record_info() {
    	$token = ecjia_touch_user::singleton()->getToken();
    	$user_info = ecjia_touch_user::singleton()->getUserinfo();
    	
    	$cache_id = $_SERVER['QUERY_STRING'].'-'.$token.'-'.$user_info['id'].'-'.$user_info['name'];
    	$cache_id = sprintf('%X', crc32($cache_id));
    	
    	if (!ecjia_front::$controller->is_cached('user_record_info.dwt', $cache_id)) {
	        $data['account_id'] = !empty($_GET['account_id']) ? $_GET['account_id'] : '';
	        $data['amount'] = !empty($_GET['amount']) ? $_GET['amount'] : '';
	        $data['format_amount'] = !empty($_GET['format_amount']) ? $_GET['format_amount'] : '';
	        $data['pay_status'] = !empty($_GET['pay_status']) ? $_GET['pay_status'] : '';
	        $data['type'] = !empty($_GET['type']) ? $_GET['type'] : '';
	        $data['type_lable'] = !empty($_GET['type_lable']) ? $_GET['type_lable'] : '';
	        $data['add_time'] = !empty($_GET['add_time']) ? $_GET['add_time'] : '';
	        $data['payment_id'] = !empty($_GET['payment_id']) ? $_GET['payment_id'] : '';
	        $data['payment_name'] = !empty($_GET['payment_id']) ? trim($_GET['payment_name']) : '';
	        $data['order_sn'] = !empty($_GET['order_sn']) ? trim($_GET['order_sn']) : '';
	        
	        /*微信充值相关处理*/
	        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
	        $payment_info = $payment_method->payment_info_by_id($data['payment_id']);
	        
	        /*依据当前浏览器和所选支付方式给出支付提示*/
	        if (cart_function::is_weixin() == true && $payment_info['pay_code'] == 'pay_alipay') {
	            ecjia_front::$controller->assign('brownser_wx', 1);
	        } elseif (cart_function::is_weixin() == false && $payment_info['pay_code' == 'pay_wxpay']) {
	            ecjia_front::$controller->assign('brownser_other', 1);
	        }
	        
	        if ($payment_info['pay_code'] == 'pay_wxpay') {
	            // 取得支付信息，生成支付代码
// 	            $payment_config = $payment_method->unserialize_config($payment_info['pay_config']);
// 	            $handler = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
	            $handler = with(new Ecjia\App\Payment\PaymentPlugin)->channel($payment_info['pay_code']);
	            $open_id = $handler->get_open_id();
	            $_SESSION['wxpay_open_id'] = $open_id;
	        }

            $user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
            ecjia_front::$controller->assign('user_img', $user_img);
            
            $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
            $user = is_ecjia_error($user) ? array() : $user;
            $user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
            
            if (!empty($user['avatar_img'])) {
                $user_img = $user['avatar_img'];
            }
            
            ecjia_front::$controller->assign('user_img', $user_img);
            ecjia_front::$controller->assign('user', $user);
            ecjia_front::$controller->assign_title('交易明细');
            ecjia_front::$controller->assign('sur_amount', $data);
            $_SESSION['status'] = !empty($_GET['status']) ? $_GET['status'] : '';
        }
        ecjia_front::$controller->display('user_record_info.dwt', $cache_id);
    }
    
    /**
     * 提现充值取消
     */
    public static function record_cancel() {
        $account_id = !empty($_POST['account_id']) ? $_POST['account_id'] : '';
        $record_type = !empty($_POST['record_type']) ? $_POST['record_type'] : '';
        $submit = !empty($_POST['submit']) ? $_POST['submit'] : '';
        $payment_id = !empty($_POST['payment_id']) ? $_POST['payment_id'] : '';
        if ($submit == '取消') {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_CANCEL)->data(array('account_id' => $account_id))->run();
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('user/account/record'), 'msg' => '取消该交易记录'));
        } elseif ($submit == '充值') {
            $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_PAY)->data(array('account_id' => $account_id, 'payment_id' => $payment_id))->run();
            if (is_ecjia_error($pay)) {
                return false;
            }
            $pay_online = $pay['payment']['pay_online'];
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pay_online' => $pay_online));
        }
    }
}

// end
