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
 * 订单退款申请
 * @author zrl
 *
 */
class apply_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		
		$this->authSession();
		if ($_SESSION['user_id'] <= 0 ) {
			return new ecjia_error(100, 'Invalid session');
		}
		$order_id			= $this->requestData('order_id', 0);
		$refund_type		= $this->requestData('refund_type');
		$reason_id			= $this->requestData('reason_id', '');
		$refund_description = $this->requestData('refund_description');
		$device 			=  $this->device;
		
		if (empty($order_id) || empty($refund_type) || empty($reason_id)) {
			return new ecjia_error('invalid_parameter', '参数错误');
		}
		
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		
		if (is_ecjia_error($order_info)) {
			return $order_info;
		}
		
		if (empty($order_info)) {
			return new ecjia_error('not_exists_info', '订单信息不存在！');
		}
		
		//当前订单是否可申请售后
		if (in_array($order_info['pay_status'], array(PS_UNPAYED))
			|| in_array($order_info['order_status'], array(OS_CANCELED, OS_INVALID))
			|| ($order_info['is_delete'] == '1')
		) {
			return new ecjia_error('error_apply', '当前订单不可申请售后！');
		}
		
		//查询当前订单有没申请过售后
		RC_Loader::load_app_class('order_refund', 'refund', false);
		//过滤掉已取消的和退款处理成功的，保留在处理中的申请
		$order_refund_info = order_refund::currorder_refund_info($order_id);
		if (!empty($order_refund_info)) {
			$refund_id = $order_refund_info['refund_id'];
			//已存在处理中的申请或退款成功的申请
			if (($order_refund_info['status'] == Ecjia\App\Refund\RefundStatus::UNCHECK) 
			   || (($order_refund_info['status'] == Ecjia\App\Refund\RefundStatus::AGREE) && ($order_refund_info['refund_staus'] == Ecjia\App\Refund\RefundStatus::UNTRANSFER))
			   || (($order_refund_info['status'] == Ecjia\App\Refund\RefundStatus::AGREE) && ($order_refund_info['refund_staus'] == Ecjia\App\Refund\RefundStatus::TRANSFERED))
			) {
				return new ecjia_error('error_apply', '当前订单已申请了售后！');
			} elseif ($order_refund_info['status'] == Ecjia\App\Refund\RefundStatus::REFUSED) {
				//申请被拒，重新申请
				$refund_sn = $this->requestData('refund_sn', '');
				if (empty($refund_sn)) {
					return new ecjia_error('invalid_parameter', '参数无效！');
				}
				$update_data = array(
					'refund_reason' 	=> !empty($reason_id) ? $reason_id : $order_refund_info['reason_id'],
					'refund_content' 	=> !empty($refund_description) ? $refund_description : $order_refund_info['refund_content'],
					'status'			=> Ecjia\App\Refund\RefundStatus::UNCHECK,
					'last_submit_time'	=> RC_Time::gmtime()
				);
				
				RC_DB::table('refund_order')->where('refund_sn', $refund_sn)->update($update_data);
				
				//售后申请图片处理
				$image_info = null;
				if (!empty($_FILES)) {
					$save_path = 'data/refund/'.RC_Time::local_date('Ym');
					$upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));
					
					//删除原来的售后图片
					$old_refund_imgs = RC_DB::table('term_attachment')->where('object_app', 'ecjia.refund')
								->where('object_group', 'refund')
								->where('object_id', $order_refund_info['refund_id'])
								->lists('file_path');
					if (!empty($old_refund_imgs)) {
						RC_DB::table('term_attachment')->where('object_app', 'ecjia.refund')->where('object_group', 'refund')->where('object_id', $order_refund_info['refund_id'])->delete();
						foreach ($old_refund_imgs as $row) {
							$upload->remove($row);
						}
					}
					
					//新传的售后图片处理
					$count = count($_FILES['refund_images']['name']);
					//最多可传5张图片
					if ($count > 5) {
						return new ecjia_error('refund_img_error', '申请图片最多可传5张哦！');
					}
					for ($i = 0; $i < $count; $i++) {
						$refund_images = array(
								'name' 		=> 	$_FILES['refund_images']['name'][$i],
								'type' 		=> 	$_FILES['refund_images']['type'][$i],
								'tmp_name' 	=> 	$_FILES['refund_images']['tmp_name'][$i],
								'error'		=> 	$_FILES['refund_images']['error'][$i],
								'size'		=> 	$_FILES['refund_images']['size'][$i],
						);
						if (!empty($refund_images['name'])) {
							if (!$upload->check_upload_file($refund_images)) {
								return new ecjia_error('picture_error', $upload->error());
							}
						}
					}
				
					$image_info	= $upload->batch_upload($_FILES);
					if (!empty($image_info)) {
						foreach ($image_info as $image) {
							if (!empty($image)) {
								$image_url	= $upload->get_position($image);
								$data = array(
										'object_app'		=> 'ecjia.refund',
										'object_group'		=> 'refund',
										'object_id'			=> $order_refund_info['refund_id'],
										'attach_label'  	=> $image['name'],
										'attach_description'=> '退款图片',
										'file_name'     	=> $image['name'],
										'file_path'			=> $image_url,
										'file_size'     	=> $image['size'] / 1000,
										'file_ext'      	=> $image['ext'],
										'file_hash'     	=> $image['sha1'],
										'file_mime'     	=> $image['type'],
										'is_image'			=> 1,
										'user_id'			=> $_SESSION['user_id'],
										'user_type'     	=> 'user',
										'add_time'			=> RC_Time::gmtime(),
										'add_ip'			=> RC_Ip::client_ip(),
										'in_status'     	=> 0
								);
								$attach = RC_DB::table('term_attachment')->insert($data);
							}
						}
					}
				}
				
			}
		} else{
			//退款编号
			$refund_sn = order_refund::get_refund_sn();
			//配送方式信息
			if (!empty($order_info['shipping_id'])) {
				$shipping_id = intval($order_info['shipping_id']);
				$shipping_info = ecjia_shipping::pluginData($shipping_id);
				$shipping_code = $shipping_info['shipping_code'];
			} else {
				$shipping_code = NULL;
			}
			
			//支付方式信息
			if (!empty($order_info['pay_id'])) {
				$payment_info = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order_info['pay_id']);
				$pay_code = $payment_info['pay_code'];
			} else {
				$pay_code = NULL;
			}
			
			//退货状态
			if ($refund_type == 'refund') {
				$return_status = 0;
			} elseif ($refund_type == 'return') {
				$return_status = 1;
			}
			
			//订单的配送状态，订单是否配送了
			if ($order_info['shipping_status'] > SS_UNSHIPPED) {
				$shipping_whether = 1;
			} else {
				$shipping_whether = 0;
			}
			
			
			$refund_data = array(
					'store_id'			=> $order_info['store_id'],
					'user_id'			=> $order_info['user_id'],
					'user_name'			=> $order_info['user_name'],
					'refund_type'		=> $refund_type,
					'refund_sn'			=> $refund_sn,
					'order_id'			=> $order_id,
					'order_sn'			=> $order_info['order_sn'],
					'shipping_code'		=> $shipping_code,
					'shipping_name'		=> $order_info['shipping_name'],
					'shipping_fee'		=> $order_info['shipping_fee'],
					'shipping_whether' 	=> $shipping_whether,
					'insure_fee'		=> $order_info['insure_fee'],
					'pay_code'			=> $pay_code,
					'pay_name'			=> $payment_info['pay_name'],
					'goods_amount'		=> $order_info['goods_amount'],
					'pay_fee'			=> $order_info['pay_fee'],
					'pack_id'			=> $order_info['pack_id'],
					'pack_fee'			=> $order_info['pack_fee'],
					'card_id'			=> $order_info['card_id'],
					'card_fee'			=> $order_info['card_fee'],
					'bonus_id'			=> $order_info['bonus_id'],
					'bonus'				=> $order_info['bonus'],
					'surplus'			=> $order_info['surplus'],
					'integral'			=> $order_info['integral'],
					'integral_money'	=> $order_info['integral_money'],
					'discount'			=> $order_info['discount'],
					'inv_tax'			=> $order_info['tax'],
					'order_amount'		=> $order_info['order_amount'],
					'money_paid'		=> $order_info['money_paid'],
					'status'			=> 0,
					'refund_content'	=> $refund_description,
					'refund_reason'		=> $reason_id,
					'return_status'		=> $return_status,
					'add_time'			=> RC_Time::gmtime(),
					'referer'			=> ! empty($device['client']) ? $device['client'] : 'mobile'
			);
			
			//插入售后申请表数据
			$refund_id = RC_DB::table('refund_order')->insertGetId($refund_data);
			
			if ($refund_id) {
				//售后申请图片处理
				$image_info = null;
				if (!empty($_FILES)) {
					$save_path = 'data/refund/'.RC_Time::local_date('Ym');
					$upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));
						
					$count = count($_FILES['refund_images']['name']);
					//最多可传5张图片
					if ($count > 5) {
						return new ecjia_error('refund_img_error', '申请图片最多可传5张哦！');
					}
					for ($i = 0; $i < $count; $i++) {
						$refund_images = array(
								'name' 		=> 	$_FILES['refund_images']['name'][$i],
								'type' 		=> 	$_FILES['refund_images']['type'][$i],
								'tmp_name' 	=> 	$_FILES['refund_images']['tmp_name'][$i],
								'error'		=> 	$_FILES['refund_images']['error'][$i],
								'size'		=> 	$_FILES['refund_images']['size'][$i],
						);
						if (!empty($refund_images['name'])) {
							if (!$upload->check_upload_file($refund_images)) {
								return new ecjia_error('picture_error', $upload->error());
							}
						}
					}
						
					$image_info	= $upload->batch_upload($_FILES);
					if (!empty($image_info)) {
						foreach ($image_info as $image) {
							if (!empty($image)) {
								$image_url	= $upload->get_position($image);
								$data = array(
										'object_app'		=> 'ecjia.refund',
										'object_group'		=> 'refund',
										'object_id'			=> $refund_id,
										'attach_label'  	=> $image['name'],
										'attach_description'=> '退款图片',
										'file_name'     	=> $image['name'],
										'file_path'			=> $image_url,
										'file_size'     	=> $image['size'] / 1000,
										'file_ext'      	=> $image['ext'],
										'file_hash'     	=> $image['sha1'],
										'file_mime'     	=> $image['type'],
										'is_image'			=> 1,
										'user_id'			=> $_SESSION['user_id'],
										'user_type'     	=> 'user',
										'add_time'			=> RC_Time::gmtime(),
										'add_ip'			=> RC_Ip::client_ip(),
										'in_status'     	=> 0
								);
								$attach = RC_DB::table('term_attachment')->insert($data);
							}
						}
					}
				}
					
				//退商品
				if ($refund_type == 'return') {
					//获取订单的发货单列表
					$delivery_list = order_refund::currorder_delivery_list($order_id);
					if (!empty($delivery_list)) {
						foreach ($delivery_list as $row) {
							//获取发货单的发货商品列表
							$delivery_goods_list   = order_refund::delivery_goodsList($row['delivery_id']);
							if (!empty($delivery_goods_list)) {
								foreach ($delivery_goods_list as $res) {
									$refund_goods_data = array(
											'refund_id'		=> $refund_id,
											'goods_id'		=> $res['goods_id'],
											'product_id'	=> $res['product_id'],
											'goods_name'	=> $res['goods_name'],
											'goods_sn'		=> $res['goods_sn'],
											'is_real'		=> $res['is_real'],
											'send_number'	=> $res['send_number'],
											'goods_attr'	=> $res['goods_attr'],
											'brand_name'	=> $res['brand_name']
									);
									$refund_goods_id = RC_DB::table('refund_goods')->insertGetId($refund_goods_data);
									/* 如果使用库存，则增加库存（不论何时减库存都需要） */
									if (ecjia::config('use_storage') == '1') {
										if ($res['send_number'] > 0) {
											RC_DB::table('goods')->where('goods_id', $res['goods_id'])->increment('goods_number', $res['send_number']);
										}
									}
								}
							}
						}
					}
					
					/* 修改订单的发货单状态为退货 */
					$delivery_order_data = array(
							'status' => 1,
					);
					RC_DB::table('delivery_order')->where('order_id', $order_info['order_id'])->whereIn('status', array(0,2))->update($delivery_order_data);
					
					/* 将订单的商品发货数量更新为 0 */
					$order_goods_data = array(
							'send_number' => 0,
					);
					
					RC_DB::table('order_goods')->where('order_id', $order_info['order_id'])->update($order_goods_data);
				}
			}
		}
		
		//更改订单状态
		RC_DB::table('order_info')->where('order_id', $order_id)->update(array('order_status' => OS_RETURNED));
		//订单操作记录log
		order_refund::order_action($order_id, OS_RETURNED, $order_info['shipping_status'], $order_info['pay_status'], '买家申请退款', '买家');
		//订单状态log记录
		$pra = array('order_status' => '申请退款', 'order_id' => $order_id, 'message' => '您的退款申请已提交，等待商家处理！');
		order_refund::order_status_log($pra);
		
		//售后申请状态记录
		$opt = array('status' => '申请退款', 'refund_id' => $refund_id, 'message' => '您的退款申请已提交，等待商家处理！');
		order_refund::refund_status_log($opt);
		
		return array();
	}
}
// end