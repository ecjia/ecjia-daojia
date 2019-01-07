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
 * 支付通知确认退款
 * Class payment_notify_refund_module
 */
class admin_payment_notify_refund_module extends api_admin implements api_interface
{

    /**
     * @param string $order_trade_no 
     * @param array $notify_data 通知数据
     *
     * @param \Royalcms\Component\Http\Request $request
     */
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['staff_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	
        $order_trade_no 	= $this->requestData('order_trade_no');
        $notify_data 		= $this->requestData('notify_data');
		
        $device 			=  $this->device;
        
        //传参判断
        if (empty($order_trade_no) || empty($notify_data)) {
        	return new ecjia_error('invalid_parameter', 'admin_payment_notify_refund_module接口参数无效');
        }
         
        //查找交易记录
        $paymentRecordRepository = new Ecjia\App\Payment\Repositories\PaymentRecordRepository();
        $record_model = $paymentRecordRepository->getPaymentRecord($order_trade_no);
        if (empty($record_model)) {
        	return new ecjia_error('payment_record_not_found', '此笔交易记录未找到');
        }
        
        $refund_amount 	= $record_model->total_fee;
        $operator 		= $_SESSION['staff_name'];
        
        //写业务逻辑
        $result = (new Ecjia\App\Payment\Refund\RefundManager(null, $order_trade_no, null))->setNotifyData($notify_data)->refund($refund_amount, $operator);
		if (is_ecjia_error($result)) {
			return $result;
		}
		
		//退款成功
		if ($result['refund_status'] == 'success') {
			//防止数据有更新，重新获取交易记录信息
			$record_model = $paymentRecordRepository->getPaymentRecord($order_trade_no);
			 
			$trade_apps = [
			'buy'       => 'orders',
			];
			
			$paidOrderOrocess = RC_Api::api($trade_apps[$record_model->trade_type], 'payment_paid_process', ['record_model' => $record_model]);
			
			$orderinfo 	= $paidOrderOrocess->getOrderInfo();
			if (empty($orderinfo)) {
				return new ecjia_error('order_dose_not_exist', $record_model->order_sn . '未找到该订单信息');
			}
			
			//退款步骤；原路退回
			$refund_result = $this->processOrderRefund($orderinfo, $device);
			if (is_ecjia_error($refund_result)) {
				return $refund_result;
			}
			
			//退款步骤完成；更新各项数据
			if (!empty($refund_result)) {
				$refund_result['back_type'] 	= 'original';
				$refund_result['refund_way'] 	= 'original';
				$refund_result['is_cashdesk']	= 1;
				$print_data = $this->ProcessRefundUpdateData($refund_result);
			}
			if (is_ecjia_error($print_data)) {
				return $print_data;
			}
			return $print_data;
		}
    }
    
    
    /**
     * 退款步骤，原路退回
     */
    private function processOrderRefund($order_info, $device)
    {
    	/**
    	 * 退款步骤
    	 * 1、生成退款申请单 GenerateRefundOrder()
    	 * 2、商家同意退款申请 RefundAgree()
    	 * 3、买家退货给商家 RefundReturnWayShop()
    	 * 4、商家确认收货 RefundMerchantConfirm()
    	 */
    	 
    	//生成退款申请单
    	$refundOrderInfo = $this->GenerateRefundOrder($order_info, $device);
    	if (is_ecjia_error($refundOrderInfo)) {
    		return $refundOrderInfo;
    	}
    	 
    	//商家同意退款申请
    	$refund_agree = $this->RefundAgree($refundOrderInfo);
    	if (is_ecjia_error($refund_agree)) {
    		return $refund_agree;
    	}
    	 
    	//买家退货给商家
    	if ($refund_agree) {
    		$refund_returnway_shop = $this->RefundReturnWayShop($refundOrderInfo);
    	}
    	if (is_ecjia_error($refund_returnway_shop)) {
    		return $refund_returnway_shop;
    	}
    	 
    	//商家确认收货
    	if ($refund_returnway_shop) {
    		$refund_merchant_confirm = $this->RefundMerchantConfirm($refundOrderInfo);
    	}
    	if (is_ecjia_error($refund_merchant_confirm)) {
    		return $refund_merchant_confirm;
    	}
    	 
    	$data = array(
    			'refund_order_info' 		=> $refundOrderInfo,
    			'refund_payrecord_info' 	=> $refund_merchant_confirm,
    			'order_info'				=> $order_info,
    			'staff_id'					=> $_SESSION['staff_id'],
    			'staff_name'				=> $_SESSION['staff_name'],
    	);
    	 
    	return $data;
    }
    
    
    /**
     * 生成退款单
     * @param array $order_info
     * @return array | ecjia_error
     */
    private function GenerateRefundOrder($order_info = array(), $device = array())
    {
    	//生成退款申请单
    	$reasons = RC_Loader::load_app_config('refund_reasons', 'refund');
    	$auto_refuse = $reasons['cashier_refund'];
    	$refund_reason = $auto_refuse['0']['reason_id'];
    	$refund_content = $auto_refuse['0']['reason_name'];
    	 
    	$options = array(
    			'refund_type' 			=> 'return',
    			'refund_content'		=> $refund_content,
    			'device'				=> $device,
    			'refund_reason'			=> $refund_reason,
    			'order_id'				=> $order_info['order_id'],
    			'order_info'			=> $order_info,
    			'is_cashdesk'			=> 1,
    			'refund_way'            => 'original'
    	);
    	$refundOrderInfo = RC_Api::api('refund', 'refund_apply', $options);
    
    	if (is_ecjia_error($refundOrderInfo)) {
    		return $refundOrderInfo;
    	}
    	 
    	return $refundOrderInfo;
    }
    
    /**
     * 商家同意退款
     */
    private function RefundAgree($refundOrderInfo)
    {
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
    	return $refund_agree;
    }
    
    /**
     * 买家退货给商家
     */
    private function RefundReturnWayShop($refundOrderInfo)
    {
    	$returnway_shop_options = array(
    			'refund_id' => $refundOrderInfo['refund_id'],
    	);
    	$refund_returnway_shop = RC_Api::api('refund', 'refund_returnway_shop', $returnway_shop_options);
    	if (is_ecjia_error($refund_returnway_shop)) {
    		return $refund_returnway_shop;
    	}
    	return $refund_returnway_shop;
    }
    
    /**
     * 商家确认收货
     */
    private function RefundMerchantConfirm($refundOrderInfo)
    {
    	$merchant_confirm_options = array(
    			'refund_id' 		=> $refundOrderInfo['refund_id'],
    			'action_note' 		=> '审核通过',
    			'store_id' 			=> $_SESSION['store_id'],
    			'staff_id' 			=> $_SESSION['staff_id'],
    			'staff_name' 		=> $_SESSION['staff_name'],
    			'refund_way' 		=> 'original',
    	);
    
    	//商家确认收货
    	$refund_merchant_confirm = RC_Api::api('refund', 'merchant_confirm', $merchant_confirm_options);
    	if (is_ecjia_error($refund_merchant_confirm)) {
    		return $refund_merchant_confirm;
    	}
    	return $refund_merchant_confirm;
    }
    
    /**
     * 退款完成，更新各项数据
     */
    private function ProcessRefundUpdateData($refund_result = array())
    {
    	$update_result = array();
    	if (!empty($refund_result['order_info']) && !empty($refund_result['refund_payrecord_info']) && !empty($refund_result['refund_order_info'])) {
    		$update_result = Ecjia\App\Refund\HandleRefundedUpdateData::updateRefundedData($refund_result);
    	}
    	return $update_result;
    }
}

// end