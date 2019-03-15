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
 * 收银台订单退款申请
 * @author zrl
 *
 */
class admin_cashier_orders_refund_apply_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        
		$order_id			= $this->requestData('order_id', 0);
		$refund_way			= $this->requestData('refund_way', ''); //original原路退回,cash退现金，balance退回余额
		$refund_money		= $this->requestData('refund_money', 0);
		$refund_way_arr 	= array('original', 'cash', 'balance');
		
		$device 			=  $this->device;
		
		$reasons = RC_Loader::load_app_config('refund_reasons', 'refund');
		$auto_refuse = $reasons['cashier_refund'];
		$refund_reason = $auto_refuse['0']['reason_id'];
		$refund_content = $auto_refuse['0']['reason_name'];
		
		if (empty($order_id) || empty($refund_way) || !in_array($refund_way, $refund_way_arr)) {
			return new ecjia_error('invalid_parameter', __('参数错误', 'cashier'));
		}
		
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'store_id' => $_SESSION['store_id'], 'referer' => 'ecjia-cashdesk'));
		
		if (empty($order_info)) {
			return new ecjia_error('not_exists_info', __('订单信息不存在！', 'cashier'));
		}
		
		//订单是否属于当前店铺
		if ($order_info['store_id'] != $_SESSION['store_id']) {
			return new ecjia_error('order_error', __('该订单不属于此店铺！', 'cashier'));
		}
		
		//现金支付的订单，只支持退现金
		$pay_code = '';
		if ($order_info['pay_id'] > 0) {
			$pay_code = RC_DB::table('payment')->where('pay_id', $order_info['pay_id'])->pluck('pay_code');
		}
		if (!empty($pay_code) && $pay_code == 'pay_cash') {
			if (($refund_way == 'original') || ($refund_way == 'balance')) {
				return new ecjia_error('refund_way_error', __('现金支付的订单只支持退现金！', 'cashier'));
			}
		}
		
		//余额支付的订单，只支持退余额和现金
		if (!empty($pay_code) && $pay_code == 'pay_balance') {
			if (($refund_way == 'original')) {
				return new ecjia_error('refund_way_error', __('余额支付的订单只支持退回余额或退现金！', 'cashier'));
			}
		}
		
		//如果订单没有添加会员的话；不支持退回余额
		if (empty($order_info['user_id'])) {
			if ($refund_way == 'balance') {
				return new ecjia_error('refund_way_error', __('该订单未添加会员，不支持退回余额！', 'cashier'));
			}
		}
		
		$options = array(
            'refund_type' 			=> 'return',
            'refund_content'		=> $refund_content,
            'device'				=> $device,
            'refund_reason'			=> $refund_reason,
            'order_id'				=> $order_id,
            'order_info'			=> $order_info,
            'is_cashdesk'			=> 1,
            'refund_way'            => $refund_way
		);
		
		//生成退款申请单
		$refundOrderInfo = RC_Api::api('refund', 'refund_apply', $options);
	    
		if (is_ecjia_error($refundOrderInfo)) {
			return $refundOrderInfo;
		}

        if (!empty($refundOrderInfo)) {
            //商家同意退款申请
            $agree_options = array(
                    'refund_id' => $refundOrderInfo['refund_id'],
                    'staff_id'	=> $_SESSION['staff_id'],
                    'staff_name'=> $_SESSION['staff_name']
            );
            $refund_agree = RC_Api::api('refund', 'refund_agree', $agree_options);
            if (is_ecjia_error($refund_agree)) {
                return $refund_agree;
            }

            if ($refund_agree) {
                $returnway_shop_options = array(
                    'refund_id' => $refundOrderInfo['refund_id'],
                );
                //买家退货给商家
                $refund_returnway_shop = RC_Api::api('refund', 'refund_returnway_shop', $returnway_shop_options);
                if (is_ecjia_error($refund_returnway_shop)) {
                    return $refund_returnway_shop;
                }

                if ($refund_returnway_shop) {
                    $merchant_confirm_options = array(
                        'refund_id' 		=> $refundOrderInfo['refund_id'],
                        'action_note' 		=> __('审核通过', 'cashier'),
                        'store_id' 			=> $_SESSION['store_id'],
                        'staff_id' 			=> $_SESSION['staff_id'],
                        'staff_name' 		=> $_SESSION['staff_name'],
                        'refund_way' 		=> $refund_way,
                        'refund_money' 		=> $refund_money
                    );

                    //商家确认收货
                    $refund_merchant_confirm = RC_Api::api('refund', 'merchant_confirm', $merchant_confirm_options);
                    if (is_ecjia_error($refund_merchant_confirm)) {
                        return $refund_merchant_confirm;
                    }

                    //去退款
                    if (!empty($refund_merchant_confirm)) {
                        //原路退回
                        if ($refund_way == 'original') {

                            $back_type = 'original';
                            $result = $this->processRefundOriginalWay($order_info, $refund_merchant_confirm);

                        } elseif ($refund_way == 'cash') { //退现金

                            $back_type = 'cash';
                            $result = $this->processRefundCashWay($order_info);

                        } else {

                            $back_type = '';
                            $result = new ecjia_error('refund_checking', __('退款审核中', 'cashier'));
                        }
                        
                        if (is_ecjia_error($result)) {
                            return $result;
                        }

                        $print_data = $this->refundWithUpdateData($refundOrderInfo['refund_id'], $refund_merchant_confirm['id'], $refund_way, $back_type, $order_info, $result);
						if (is_ecjia_error($print_data)) {
							return $print_data;
						}
                        return $print_data;
                    }

                }

            }
        }

	}

    /**
     * 现金退款处理
     */
	protected function processRefundCashWay($order_info)
    {
        //无退款处理
        return true;
    }


    /**
     * 原路退款处理
     */
    protected function processRefundOriginalWay($order_info, $refund_payrecord)
    {
        /**
         * 需要判断走撤单还是走退款
         * 支付失败，立即走撤单接口，当日订单退款也可以走撤单接口
         * 三个月以内都可以进行退款。
         */

        $order_sn = $order_info['order_sn'];
        //原路退回支付手续费退还,录入打款表时不确定是否原路退回，所以录入时back_money_total支付手续费按不退计算的
        $refund_amount = $refund_payrecord['back_money_total'] + $refund_payrecord['back_pay_fee'];
        $operator = $_SESSION['staff_name'];

        //判断订单是否是当天订单（按订单支付时间计算）
        $today_date = RC_Time::local_date('Y-m-d',RC_Time::gmtime());
        $start_time = RC_Time::local_strtotime($today_date);

        $end_time = $start_time + 86399;
        $pay_time = $order_info['pay_time'];
        
        if ($start_time <= $pay_time && $pay_time <= $end_time) {
            $result = (new Ecjia\App\Payment\Refund\CancelManager($order_sn))->cancel();
        } else {
            $result = (new Ecjia\App\Payment\Refund\RefundManager($order_sn))->refund($refund_amount, $operator);
        }

        if (is_ecjia_error($result)) {
            //该订单撤销正在处理中，请稍候；钱已退；但退款状态未更新
            if ( $result->get_error_code() == 'pay_wait_manual_confirm') {
                $find_result = (new Ecjia\App\Payment\Query\FindManager($order_sn))->find();
                if (is_ecjia_error($find_result)) {
                    return $find_result;
                }

                return $find_result;
            }
        }
		//更新打款表，实际退款金额，原路退回支付手续费退还
		RC_DB::table('refund_payrecord')->where('id', $refund_payrecord['id'])->update(array('back_money_total' => $refund_amount));
		
        return $result;
    }

    /**
     * 退款后更新各项数据
     */
    protected function refundWithUpdateData($refund_id = 0, $refund_payrecord_id = 0, $refund_way = '', $back_type = '', $order_info, $result)
    {
        /**
         * 现金和原路退款成功后，后续操作
         * 每一个步骤写一个方法
         * 1、退积分 (RC_Api)
         * 2、更新打款表 _updateRefundPayrecord()
         * 3、更新订单日志状态 & 操作记录表 _updateOrderStatus()
         * 4、更新售后订单状态日志 & 操作记录表 _updateRefundOrderStatus()
         * 5、更新结算记录 _updateBillOrder()
         * 6、更新商家会员 _updateMerchantUser()
         * 7、退款短信通知 _sendSmsNotice()
         * 8、返回打印数据 _printData()
         */

    	//退款退积分
    	$bak_integral = RC_Api::api('finance', 'refund_back_pay_points', array('refund_id' => $refund_id));
    	if (is_ecjia_error($bak_integral)) {
    		return $bak_integral;
    	}
    	//更新打款表
        $this->_updateRefundPayrecord($refund_payrecord_id, $refund_way, $back_type);
        
        //更新订单日志状态& 操作记录表
        $this->_updateOrderStatus($refund_id);
        
        //更新售后订单状态日志 & 操作记录表
        $this->_updateRefundOrderStatus($refund_id, $refund_way);

        //更新结算记录
        $update_bill = $this->_updateBillOrder($refund_id);
        if (is_ecjia_error($update_bill)) {
        	return $update_bill;
        }
		
        //更新商家会员
        $update_store_user = $this->_updateMerchantUser($refund_id);
        if (is_ecjia_error($update_store_user)) {
        	return $update_store_user;
        }

        $this->_sendSmsNotice($refund_payrecord_id, $refund_way, $order_info);

        $printData = $this->_printData($refund_id, $order_info, $refund_payrecord_id, $refund_way);

        return $printData;
        
    }

    /**
     * 更新打款表
     */
    private function _updateRefundPayrecord($refund_payrecord_id, $refund_way, $back_type)
    {
        if ($refund_way == 'cash') {
            $action_back_content = __('收银台申请退款，现金退款成功', 'cashier');
        } elseif ($refund_way == 'original')  {
            $action_back_content = __('收银台申请退款，原路退回成功', 'cashier');
        } else {
        	$action_back_content = '';
        }
        
        //更新打款表
        $data = array(
            'action_back_type' 		=> $back_type,
            'action_back_time' 		=> RC_Time::gmtime(),
            'action_back_content' 	=> $action_back_content,
            'action_user_type' 		=> 'merchant',
            'action_user_id' 		=> $_SESSION['staff_id'],
            'action_user_name' 		=> $_SESSION['staff_name'],
        );

        RC_DB::table('refund_payrecord')->where('id', $refund_payrecord_id)->update($data);
    }

    /**
     * 更新订单日志状态 & 操作记录表
     */
    private function _updateOrderStatus($refund_id = 0)
    {
        //普通订单状态变动日志表
        $order_id = RC_DB::table('refund_order')->where('refund_id', $refund_id)->pluck('order_id');
        $refund_info =$this->get_refund_info($refund_id);
        $back_money_total = $refund_info['surplus'] + $refund_info['money_paid'];
        OrderStatusLog::refund_payrecord(array('order_id' => $order_id, 'back_money' => $back_money_total));
    }

    /**
     * 更新售后订单状态日志 & 操作记录表
     */
    private function _updateRefundOrderStatus($refund_id = 0, $refund_way)
    {
        //更新售后订单表
        $data = array(
            'refund_status' => \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_TRANSFERED,
            'refund_time' => RC_Time::gmtime(),
        );
        
        RC_DB::table('refund_order')->where('refund_id', $refund_id)->update($data);
		$refund_info = $this->get_refund_info($refund_id);
		
		$back_money_total = Ecjia\App\Refund\RefundOrder::get_back_total_money($refund_info, $refund_way);
		$back_integral 		= $refund_info['integral'];
        
        //更新售后订单操作表
        $action_note = '退款金额已退回' . $back_money_total . '元，退回积分为：' . $back_integral;
        $data = array(
            'refund_id' 			=> $refund_id,
            'action_user_type' 		=> 'merchant',
            'action_user_id' 		=> $_SESSION['staff_id'],
            'action_user_name' 		=> $_SESSION['staff_name'],
            'status' 				=> \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_AGREE,
            'refund_status' 		=> \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_TRANSFERED,
            'return_status' 		=> \Ecjia\App\Refund\Enums\RefundShipEnum::SHIP_CONFIRM_RECV,
            'action_note' 			=> $action_note,
            'log_time' 				=> RC_Time::gmtime(),
        );
        RC_DB::table('refund_order_action')->insertGetId($data);

        //售后订单状态变动日志表
        RefundStatusLog::refund_payrecord(array('refund_id' => $refund_id, 'back_money' => $back_money_total));
    }

    /**
     * 更新结算记录
     */
    private function _updateBillOrder($refund_id = 0)
    {
        //更新结算记录
        $res = RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'refund', 'order_id' => $refund_id));
        if (is_ecjia_error($res)) {
        	return $res;
        }
    }

    /**
     * 更新商家会员
     */
    private function _updateMerchantUser($refund_id = 0)
    {
        //更新商家会员
        $refund_info = $this->get_refund_info($refund_id);
        if ($refund_info['user_id'] > 0 && $refund_info['store_id'] > 0) {
            $res = RC_Api::api('customer', 'store_user_buy', array('store_id' => $refund_info['store_id'], 'user_id' => $refund_info['user_id']));
			if (is_ecjia_error($res)) {
				return $res;
			}
        }
    }

    /**
     * 退款短信通知
     */
    private function _sendSmsNotice($refund_payrecord_id, $refund_way, $order_info)
    {
		if ($order_info['user_id'] > 0) {
			//原路退款短信通知
			if ($refund_way == 'original') {
				$user_info = RC_Api::api('user', 'user_info', array('user_id' => $order_info['user_id']));
				$refund_payrecord_info = RC_DB::table('refund_payrecord')->where('id', $refund_payrecord_id)->first();
				if (!empty($user_info['mobile_phone'])) {
					$back_pay_name = $refund_payrecord_info['back_pay_name'];
					$options = array(
							'mobile' => $user_info['mobile_phone'],
							'event'	 => 'sms_refund_original_arrived',
							'value'  =>array(
									'user_name' 	=> $user_info['user_name'],
									'back_pay_name' => $back_pay_name,
							),
					);
					RC_Api::api('sms', 'send_event_sms', $options);
				}
			}
		}
    }

    /**
     * 返回打印数据
     */
    private function _printData($refund_id = 0, $order_info = array(), $refund_payrecord_id = 0, $refund_way)
    {
    	$print_data = [];
    	if (!empty($refund_id)) {
    		$refund_info 			= $this->get_refund_info($refund_id);
    		$payment_record_info 	= $this->_payment_record_info($refund_info['order_sn'], 'buy');
    		
    		$refund_payrecord_info  = RC_DB::table('refund_payrecord')->where('id', $refund_payrecord_id)->first();
    		
    		$order_goods 			= $this->get_order_goods($refund_info['order_id']);
    		$total_discount 		= $order_info['discount'] + $order_info['integral_money'] + $order_info['bonus'];
    		$money_paid 			= $refund_info['money_paid'] + $refund_info['surplus'];
    		$refund_total_amount	= Ecjia\App\Refund\RefundOrder::get_back_total_money($refund_info, $refund_way);
    		
    		$user_info = [];
    		//有没用户
    		if ($refund_info['user_id'] > 0) {
    			$userinfo = $this->get_user_info($refund_info['user_id']);
    			if (!empty($userinfo)) {
    				$user_info = array(
    						'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
    						'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
    						'user_points'			=> $userinfo['pay_points'],
    						'user_money'			=> $userinfo['user_money'],
    						'formatted_user_money'	=> $userinfo['user_money'] > 0 ? price_format($userinfo['user_money'], false) : '',
    				);
    			}
    		}
    		
    		$print_data = array(
    				'order_sn' 						=> $refund_info['order_sn'],
    				'trade_no'						=> empty($payment_record_info['trade_no']) ? '' : trim($payment_record_info['trade_no']),
    				'trade_type'					=> 'refund',
    				'pay_time'						=> empty($order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']),
    				'goods_list'					=> $order_goods['list'],
    				'total_goods_number' 			=> $order_goods['total_goods_number'],
    				'total_goods_amount'			=> $order_goods['taotal_goods_amount'],
    				'formatted_total_goods_amount'	=> price_format($order_goods['taotal_goods_amount'], false),
    				'total_discount'				=> $total_discount,
    				'formatted_total_discount'		=> price_format($total_discount, false),
    				'money_paid'					=> $money_paid,
    				'formatted_money_paid'			=> price_format($money_paid, false),
    				'integral'						=> intval($refund_info['integral']),
    				'integral_money'				=> $refund_info['integral_money'],
    				'formatted_integral_money'		=> price_format($refund_info['integral_money'], false),
    				'pay_name'						=> !empty($order_info['pay_name']) ? $order_info['pay_name'] : '',
    				'payment_account'				=> '',
    				'user_info'						=> $user_info,
    				'refund_sn'						=> $refund_info['refund_sn'],
    				'refund_total_amount'			=> $refund_total_amount,
    				'formatted_refund_total_amount' => price_format($refund_total_amount, false),
    				'cashier_name'					=> empty($refund_payrecord_info['action_user_name']) ? '' : $refund_payrecord_info['action_user_name'],
    				'pay_fee'						=> $refund_info['pay_fee'],
    				'formatted_pay_fee'				=> ecjia_price_format($refund_info['pay_fee'], false),
    		);
    	}
    	
    	return $print_data;
    	
    }
    
    /**
     * 退款详情
     */
    private  function get_refund_info($refund_id = 0) 
    {
    	$refund_info = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
    	return $refund_info;
    }
    
    /**
     * 用户信息
     */
    private function get_user_info ($user_id = 0) {
    	$user_info = RC_DB::table('users')->where('user_id', $user_id)->first();
    	return $user_info;
    }
    
    /**
     * 订单商品
     */
    private function get_order_goods ($order_id) {
    	$field = 'goods_id, goods_name, goods_number, (goods_number*goods_price) as subtotal';
    	$order_goods = RC_DB::table('order_goods')->where('order_id', $order_id)->select(RC_DB::raw($field))->get();
    	$total_goods_number = 0;
    	$taotal_goods_amount = 0;
    	$list = [];
    	if ($order_goods) {
    		foreach ($order_goods as $row) {
    				$total_goods_number += $row['goods_number'];
    				$taotal_goods_amount += $row['subtotal']; 
    				$list[] = array(
    						'goods_id' 			=> $row['goods_id'],
    						'goods_name'		=> $row['goods_name'],
    						'goods_number'		=> $row['goods_number'],
    						'subtotal'			=> $row['subtotal'],
    						'formatted_subtotal'=> price_format($row['subtotal'], false),
    				);
    		}
    	}
    	
    	return array('list' => $list, 'total_goods_number' => $total_goods_number, 'taotal_goods_amount' => $taotal_goods_amount);
    }
    
    /**
     * 支付记录
     */
    private function _payment_record_info($order_sn = '', $trade_type = '') {
    	$payment_revord_info = [];
    	if (!empty($order_sn) && !empty($trade_type)) {
    		$payment_revord_info = RC_DB::table('payment_record')->where('order_sn', $order_sn)->where('trade_type', $trade_type)->first();
    	}
    	return $payment_revord_info;
    }
}
// end