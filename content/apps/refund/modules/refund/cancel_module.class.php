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
 * 撤销售后申请
 * @author 
 * zrl
 */
class refund_cancel_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();
    	$user_id = $_SESSION['user_id'];
    	if ($user_id < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}
    	
		$refund_sn	= trim($this->requestData('refund_sn', ''));
		
		
		if (empty($refund_sn)) {
			return new ecjia_error('invalid_parameter', __('参数无效', 'refund'));
		}
		
		RC_Loader::load_app_class('order_refund', 'refund', false);
		$refund_info = order_refund::get_refundorder_detail(array('refund_sn' => $refund_sn));
		if (empty($refund_info)) {
			return new ecjia_error('not_exists_info', __('不存在的信息！', 'refund'));
		}
		
		if (($refund_info['status'] == \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_CANCELED) || (($refund_info['status'] == \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_AGREE) && $refund_info['refund_status'] == \Ecjia\App\Refund\Enums\RefundPayEnum::PAY_TRANSFERED)) {
			return new ecjia_error('cannot_cancel', __('当前售后申请不可撤销！', 'refund'));
		}
		
		$cancel_status = \Ecjia\App\Refund\Enums\RefundOrderEnum::ORDER_CANCELED;
		
        RC_DB::table('refund_order')->where('refund_sn', $refund_sn)->update(array('status' => $cancel_status));
        
        $order_info = $this->get_order_info($refund_info['order_id']);
        
        //退款撤销，退款申请时还原的库存相应再减掉，refund_goods表退货商品删除
        $this->_reduceOrderGoodsStock($order_info, $refund_info);
        
        RC_Loader::load_app_class('order_refund', 'refund', false);
        //撤销退款申请操作记录
        $refund_order_action = array(
        		'refund_id' 		=> $refund_info['refund_id'],
        		'action_user_type'	=> 'user',
        		'action_user_id'	=> $refund_info['user_id'],
        		'action_user_name'  => '买家',
        		'status'			=> 10,
        		'refund_status'		=> $refund_info['refund_status'],
        		'return_status'		=> $refund_info['return_status'],
        		'action_note'		=> '买家撤销退款申请！'
        );
        order_refund::refund_order_action($refund_order_action);
        //还原订单状态
        if ($order_info['shipping_status'] == SS_SHIPPED) {
        	$data = array('order_status' => OS_SPLITED);
        }else{
        	$order_status = $this->getBeforeRefundOrderStatus($refund_info['order_id']);
        	$data = array('order_status' => $order_status);
        }
        RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->update($data);
        
        //订单操作记录log
		order_refund::order_action($refund_info['order_id'], $data['order_status'], $order_info['shipping_status'], $order_info['pay_status'], '买家撤销退款申请', '买家');
		//订单状态log记录
		$pra = array('order_status' => '撤销退款申请', 'order_id' => $refund_info['order_id'], 'message' => '您已成功撤销退款申请！');
		order_refund::order_status_log($pra);
		//售后申请状态记录
		$opt = array('status' => '撤销退款申请', 'refund_id' => $refund_info['refund_id'], 'message' => '您已撤销退款申请！');
		order_refund::refund_status_log($opt);
        
        return array();
	}
	
	
	/**
	 * 撤销退款申请，减掉申请时还原的库存
	 */
	private function _reduceOrderGoodsStock($order_info, $refund_info)
	{
		if (ecjia::config('use_storage') == '1'){
			if (ecjia::config('stock_dec_time') == SDT_PLACE){ //下单时减库存
				//订单商品
				$order_goods = order_refund::currorder_goods_list($refund_info['order_id']);
				if (!empty($order_goods)) {
					foreach ($order_goods as $value) {
						//货品库存减少
						if ($value['product_id'] > 0) {
							$products_info = RC_DB::table('products')->where('product_id', $value['product_id'])->first();
							if ($products_info['product_number'] >= $value['goods_number']) {
								RC_DB::table('products')->where('product_id', $value['product_id'])->decrement('product_number', $value['goods_number']);
							}
						} else {
							$goods_info = RC_DB::table('goods')->where('goods_id', $value['goods_id'])->first();
							if ($goods_info['goods_number'] >= $value['goods_number']) {
								RC_DB::table('goods')->where('goods_id', $value['goods_id'])->decrement('goods_number', $value['goods_number']);
							}
						}
					}
				}
			} else {//发货时减库存
				RC_DB::table('refund_goods')->where('refund_id', $refund_info['refund_id'])->delete();
				//还原发货单状态
				if ($order_info['shipping_status'] > SS_UNSHIPPED) {
					if ($order_info['shipping_status'] == SS_SHIPPED) {
						$delivery_order_status_data = array(
								'status' => 0,
						);
					} else {
						$delivery_order_status_data = array(
								'status' => 2,
						);
					}
					RC_DB::table('delivery_order')->where('order_id', $refund_info['order_id'])->where('status', 1)->update($delivery_order_status_data);
				}
				
				//订单的发货单列表
				$delivery_list = order_refund::currorder_delivery_list($refund_info['order_id']);
				if (!empty($delivery_list)) {
					foreach ($delivery_list as $row) {
						//获取发货单的发货商品
						$delivery_goods_list   = order_refund::delivery_goodsList($row['delivery_id']);
						if (!empty($delivery_goods_list)) {
							foreach ($delivery_goods_list as $res) {
								//还原订单商品发货数量
								RC_DB::table('order_goods')->where('order_id', $refund_info['order_id'])->where('goods_id', $res['goods_id'])->increment('send_number', $res['send_number']);
								/* 还原商品申请售后时增加的库存 */
								if ($res['send_number'] > 0) {
									if ($res['product_id'] > 0){
										$product_number = RC_DB::table('products')->where('product_id', $res['product_id'])->pluck('product_number');
										if ($product_number >= $res['send_number']) {
											RC_DB::table('products')->where('product_id', $res['product_id'])->decrement('product_number', $res['send_number']);
										}
									} else {
										$goods_number = RC_DB::table('goods')->where('goods_id', $res['goods_id'])->pluck('goods_number');
										if ($goods_number >= $res['send_number']) {
											RC_DB::table('goods')->where('goods_id', $res['goods_id'])->decrement('goods_number', $res['send_number']);
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	/**
	 * 获取申请退款前的订单状态
	 */
	private function getBeforeRefundOrderStatus($order_id)
	{
		$berore_refund_status = 0;
		$order_status_arr = RC_DB::table('order_action')->where('order_id', $order_id)->where('order_status', '!=', OS_RETURNED)->orderBy('log_time', 'desc')->lists('action_id');
		$refund_key = $order_status_arr['0']; 
		$order_action_info = RC_DB::table('order_action')->where('action_id', $refund_key)->first();
		$berore_refund_status = $order_action_info['order_status'];
		return $berore_refund_status;
	}
	
	/**
	 * 获取订单信息
	 */
	private function get_order_info($order_id)
	{
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		return $order_info;
	}
}

// end