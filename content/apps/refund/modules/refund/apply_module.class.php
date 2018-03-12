<?php
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
			
			$refund_data = array(
					'store_id'		=> $order_info['store_id'],
					'user_id'		=> $order_info['user_id'],
					'user_name'		=> $order_info['user_name'],
					'refund_type'	=> $refund_type,
					'refund_sn'		=> $refund_sn,
					'order_id'		=> $order_id,
					'order_sn'		=> $order_info['order_sn'],
					'shipping_code'	=> $shipping_code,
					'shipping_name'	=> $order_info['shipping_name'],
					'shipping_fee'	=> $order_info['shipping_fee'],
					'insure_fee'	=> $order_info['insure_fee'],
					'pay_code'		=> $pay_code,
					'pay_name'		=> $payment_info['pay_name'],
					'goods_amount'	=> $order_info['goods_amount'],
					'pay_fee'		=> $order_info['pay_fee'],
					'pack_id'		=> $order_info['pack_id'],
					'pack_fee'		=> $order_info['pack_fee'],
					'card_id'		=> $order_info['card_id'],
					'card_fee'		=> $order_info['card_fee'],
					'bonus_id'		=> $order_info['bonus_id'],
					'bonus'			=> $order_info['bonus'],
					'surplus'		=> $order_info['surplus'],
					'integral'		=> $order_info['integral'],
					'integral_money'=> $order_info['integral_money'],
					'discount'		=> $order_info['discount'],
					'inv_tax'		=> $order_info['tax'],
					'order_amount'	=> $order_info['order_amount'],
					'money_paid'	=> $order_info['money_paid'],
					'status'		=> 0,
					'refund_content'=> $refund_description,
					'refund_reason'	=> $reason_id,
					'return_status'	=> $return_status,
					'add_time'		=> RC_Time::gmtime(),
					'referer'		=> ! empty($device['client']) ? $device['client'] : 'mobile'
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