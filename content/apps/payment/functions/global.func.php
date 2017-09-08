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
 * ECJia 支付接口函数库
 */

/**
 * 取得返回信息地址
 * @param   string  $code   支付方式代码
 */
function return_url($code) {
    return $GLOBALS['ecs']->url() . 'respond.php?code=' . $code;
}

/**
 *  取得某支付方式信息
 *  @param  string  $code   支付方式代码
 */
function get_payment($code) {
	// $db = RC_Loader::load_app_model('payment_model', 'payment');
	// $payment = $db->find('pay_code = "'. $code. '" AND enabled = "1"');
    $payment = RC_DB::table('payment')->where('pay_code', $code)->where('enabled', 1)->first();

    if ($payment) {
        $config_list = unserialize($payment['pay_config']);
        foreach ($config_list AS $config) {
            $payment[$config['name']] = $config['value'];
        }
    }
    return $payment;
}

/**
 *  通过订单sn取得订单ID
 *  @param  string  $order_sn   订单sn
 *  @param  blob    $voucher    是否为会员充值
 */
function get_order_id_by_sn($order_sn, $voucher = 'false') {
    $db_pay = RC_Model::model('orders/pay_log_model');
    $db_order = RC_Model::model('orders/order_info_model');
    
    if ($voucher == 'true') {
        if(is_numeric($order_sn)) {
			return $db_pay->field('log_id')->find('order_id = "'. $order_sn .'" AND order_type = 1');
        } else {
            return "";
        }
    } else {
        if (is_numeric($order_sn)) {
        	$order_id = $db_order->field('order_id')->find('order_sn = "'. $order_sn .'"');
        } 
        if (!empty($order_id)) {
        	$pay_log_id = $db_pay->field('log_id')->find('order_id = "'. $order_id .'"');
        	return $pay_log_id;       	
        } else {
            return "";
        }
    }
}

/**
 *  通过订单ID取得订单商品名称
 *  @param  string  $order_id   订单ID
 */
function get_goods_name_by_id($order_id) {
    $db = RC_Model::model('orders/order_goods_model');

	$goods_name = $db->field('goods_name')->find('order_id = "'. $order_id .'"');
	return implode(',', $goods_name);
}

function get_payment_record_list($args = array()) {
	
    $db_payment_record = RC_DB::table('payment_record');
    $filter = array();
    $filter['order_sn']		= empty($args['order_sn'])		? ''		: trim($args['order_sn']);
    $filter['keywords']		= empty($args['keywords'])		? 0			: trim($args['keywords']);
    $filter['pay_status']	= $args['pay_status'];
    
    if ($filter['order_sn']) {
        $db_payment_record->where('order_sn', 'LIKE', '%' . mysql_like_quote($filter['order_sn']) . '%');
    }
    if ($filter['keywords']) {
        //$db_payment_record->where('trade_no', 'LIKE', '%' . mysql_like_quote($filter['trade_no']) . '%');
    	$db_payment_record ->whereRaw('(trade_no like  "%' . mysql_like_quote($filter['keywords']) . '%" or order_trade_no like "%'.mysql_like_quote($filter['keywords']).'%" )');
    }

    
    if ($filter['pay_status'] &&  $filter['pay_status'] == 1) {
    	$db_payment_record->where('pay_status', 0);
    } elseif ($filter['pay_status'] && $filter['pay_status'] == 2) {
    	$db_payment_record->where('pay_status', 1);
    }
    
    $count = $db_payment_record->count();
    
    $page = new ecjia_page($count, 15, 5);
    
    $filter['skip'] = $page->start_id-1;
    $filter['limit'] = 15;
    //$db_payment_record = $db_payment_record->get();
    $db_payment_record = $db_payment_record
    ->orderBy('id', 'desc')
    ->take($filter['limit'])
    ->skip($filter['skip'])
    ->get();

    foreach ($db_payment_record as $key => $val) {
        if ($db_payment_record[$key]['pay_status'] == 0) {
            $db_payment_record[$key]['pay_status'] = RC_Lang::get('payment::payment.wait_for_payment');
        } elseif ($db_payment_record[$key]['pay_status'] == 1) {
            $db_payment_record[$key]['pay_status'] = RC_Lang::get('payment::payment.payment_success');
        }
        if ($db_payment_record[$key]['trade_type'] == 'buy') {
            $db_payment_record[$key]['trade_type'] = RC_Lang::get('payment::payment.buy');
        } elseif ($db_payment_record[$key]['trade_type'] == 'refund') {
            $db_payment_record[$key]['trade_type'] = RC_Lang::get('payment::payment.refund');
        } elseif ($db_payment_record[$key]['trade_type'] == 'deposit') {
            $db_payment_record[$key]['trade_type'] = RC_Lang::get('payment::payment.deposit');
        } elseif ($db_payment_record[$key]['trade_type'] == 'withdraw') {
            $db_payment_record[$key]['trade_type'] = RC_Lang::get('payment::payment.withdraw');
        }elseif ($db_payment_record[$key]['trade_type'] == 'surplus') {
            $db_payment_record[$key]['trade_type'] = RC_Lang::get('payment::payment.surplus');
        }
        $db_payment_record[$key]['create_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['create_time']);
        $db_payment_record[$key]['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['update_time']);
        $db_payment_record[$key]['pay_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['pay_time']);
    }
    return array('item' => $db_payment_record, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'filter' => $filter);
}

/**
 * 检查支付的金额是否与订单相符
 *
 * @access  public
 * @param   string   $log_id      支付编号
 * @param   float    $money       支付接口返回的金额
 * @return  true
 */
function check_money($log_id, $money) {
    $db_pay = RC_Model::model('orders/pay_log_model');
    
    if (is_numeric($log_id)) {
    		$amount = $db_pay->field('order_amount')->find('log_id = "'. $log_id .'"');
    } else {
        return false;
    }
    if ($money == $amount) {
        return true;
    } else {
        return false;
    }
}

/**
 * 修改订单的支付状态
 *
 * @access  public
 * @param   string  $log_id     支付编号
 * @param   integer $pay_status 状态
 * @param   string  $note       备注
 * @return  void
 */
function order_paid($log_id, $pay_status = PS_PAYED, $note = '') {
	$db_pay = RC_Model::model('orders/pay_log_model');
	$db_order = RC_Model::model('orders/order_info_model');
	$db_user = RC_Model::model('user/user_account_model');

    /* 取得支付编号 */
    $log_id = intval($log_id);
    if ($log_id > 0) {
        /* 取得要修改的支付记录信息 */
        $pay_log = $db_pay->find('log_id = '.$log_id.'');
        if ($pay_log && $pay_log['is_paid'] == 0) {
            /* 修改此次支付操作的状态为已付款 */
	        $data = array( 'is_paid' => '1' );
			$db_pay->where('log_id = '.$log_id.'')->update($data);

            /* 根据记录类型做相应处理 */
            if ($pay_log['order_type'] == PAY_ORDER) {
                /* 取得订单信息 */
                $order = $db_order->field('order_id, user_id, order_sn, consignee, address, tel, shipping_id, extension_code, extension_id, goods_amount')->find('order_id = '. $pay_log['order_id']. '');
                $order_id = $order['order_id'];
                $order_sn = $order['order_sn'];

                /* 修改订单状态为已付款 */
                $data = array(
                	'order_status' => OS_CONFIRMED,
                	'confirm_time' => RC_Time::gmtime(),
                	'pay_status'   => $pay_status,
                	'pay_time'     => RC_Time::gmtime(),
                	'money_paid'   => order_amount,
                	'order_amount' => 0,
                );
                
                $db_order->where('order_id = '.$order_id.'')->update($data);

                /* 记录订单操作记录 */
                order_action($order_sn, OS_CONFIRMED, SS_UNSHIPPED, $pay_status, $note, RC_Lang::get('payment::payment.buyer'));

                /* 如果需要，发短信 */
//                 if ($GLOBALS['_CFG']['sms_order_payed'] == '1' && $GLOBALS['_CFG']['sms_shop_mobile'] != '')
//                 {
// 					//include_once(ROOT_PATH.'includes/cls_sms.php');                
//                     $sms = new sms();
//                     $sms->send($GLOBALS['_CFG']['sms_shop_mobile'],
//                     sprintf($GLOBALS['_LANG']['order_payed_sms'], $order_sn, $order['consignee'], $order['tel']),'', 13,1);
//                 }

                /* 对虚拟商品的支持 */
                $virtual_goods = get_virtual_goods($order_id);
                if (!empty($virtual_goods)) {
                    $msg = '';
                    if (!virtual_goods_ship($virtual_goods, $msg, $order_sn, true)) {
                        $GLOBALS['_LANG']['pay_success'] .= '<div style="color:red;">'.$msg.'</div>'.$GLOBALS['_LANG']['virtual_goods_ship_fail'];
                    }

                    /* 如果订单没有配送方式，自动完成发货操作 */
                    if ($order['shipping_id'] == -1) {
                        /* 将订单标识为已发货状态，并记录发货记录 */
	                    	$data = array(
	                    		'shipping_status' 	=> SS_SHIPPED,
	                    		'shipping_time' 	=> RC_Time::gmtime(),
	                    	);
                    		$db_order->where('order_id = '.$order_id.'')->update($data);

                         /* 记录订单操作记录 */
                        order_action($order_sn, OS_CONFIRMED, SS_SHIPPED, $pay_status, $note, RC_Lang::get('payment::payment.buyer'));
                        $integral = integral_to_give($order);
                        $options = array(
                        	'user_id'		=> $order['user_id'],
                        	'rank_points'	=> intval($integral['rank_points']),
                        	'pay_points'	=> intval($integral['custom_points']),
                        	'change_desc'	=> sprintf(RC_Lang::get('payment::payment.order_gift_integral'), $order['order_sn'])
                        );
                        RC_Api::api('user', 'account_change_log',$options);
//                         log_account_change($order['user_id'], 0, 0, intval($integral['rank_points']), intval($integral['custom_points']), sprintf($GLOBALS['_LANG']['order_gift_integral'], $order['order_sn']));
                    }
                }

            } elseif ($pay_log['order_type'] == PAY_SURPLUS) {
            		$res_id = $db_user -> field('`id`')->find('`id` = '.$pay_log['order_id'].' AND `is_paid` = 1');
                if (empty($res_id)) {
					/* 更新会员预付款的到款状态 */
	                	$data = array(
                			'paid_time' => RC_Time::gmtime(),
                			'is_paid'   => 1
                		);
                	
                		$db_user->where('`id` = '.$pay_log['order_id'].'')->update($data);
                    /* 取得添加预付款的用户以及金额 */
                		$arr = $db_user->field('user_id, amount')->find('`id` = '. $pay_log['order_id'].'');
                    /* 修改会员帐户金额 */
//                     $_LANG = array();
//                     include_once(ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/user.php');
                    $options = array(
                    	'user_id'		=> $arr['user_id'],
                    	'user_money'	=> $arr['amount'],
                    	'change_desc'	=> RC_Lang::get('payment::payment.surplus_type_0'),
                    	'change_type'	=> ACT_SAVING
                    );
                    RC_Api::api('user', 'account_change_log',$options);
//                     log_account_change($arr['user_id'], $arr['amount'], 0, 0, 0, RC_Lang::get('payment::payment.surplus_type_0'), ACT_SAVING);
                }
            }
        } else {
            /* 取得已发货的虚拟商品信息 */
            $post_virtual_goods = get_virtual_goods($pay_log['order_id'], true);

            /* 有已发货的虚拟商品 */
            if (!empty($post_virtual_goods)) {
                $msg = '';
                /* 检查两次刷新时间有无超过12小时 */
                $row = $db_order->field('pay_time, order_sn')->find('`order_id` = '. $pay_log['order_id'].'');
                $intval_time = RC_Time::gmtime() - $row['pay_time'];
                if ($intval_time >= 0 && $intval_time < 3600 * 12) {
                    $virtual_card = array();
                    foreach ($post_virtual_goods as $code => $goods_list) {
                        /* 只处理虚拟卡 */
                        if ($code == 'virtual_card') {
                            foreach ($goods_list as $goods) {
                                if ($info = virtual_card_result($row['order_sn'], $goods)) {
                                    $virtual_card[] = array('goods_id' => $goods['goods_id'], 'goods_name' => $goods['goods_name'], 'info'=>$info);
                                }
                            }
                            ecjia_front::$controller->assign('virtual_card', $virtual_card);
                        }
                    }
                } else {
                    $msg = '<div>' .  RC_Lang::get('payment::payment.please_view_order_detail') . '</div>';
                }
                $GLOBALS['_LANG']['pay_success'] .= $msg;
			}

			/* 取得未发货虚拟商品 */
			$virtual_goods = get_virtual_goods($pay_log['order_id'], false);
            if (!empty($virtual_goods)) {
				$GLOBALS['_LANG']['pay_success'] .= '<br />' . $GLOBALS['_LANG']['virtual_goods_ship_fail'];
            }
		}
    }
}

/**
 * 取得货到付款和非货到付款的支付方式
 * @return  array('is_cod' => '', 'is_not_cod' => '')
 */
function get_pay_ids() {
	$db = RC_Model::model('payment/payment_model');

	$ids = array('is_cod' => '0', 'is_not_cod' => '0');
	$data = $db->field('pay_id, is_cod')->where('enabled = 1')->select();
	if(!empty($data)) {
		foreach ($data as $row) {
			if ($row['is_cod']) {
				$ids['is_cod'] .= ',' . $row['pay_id'];
			} else {
				$ids['is_not_cod'] .= ',' . $row['pay_id'];
			}
		}
	}
	return $ids;
}

// end