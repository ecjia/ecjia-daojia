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
 * 订单售后
 */
class order_refund {
	/**
	 * 获取取消订单和售后原因单个
	 */
	 public static function get_reason($options){
	 	$reason = '';
	 	if (!empty($options['reason_id'])) {
	 		$data = RC_Loader::load_app_config('refund_reasons', 'refund');
	 		if (!empty($data)) {
	 			foreach ($data as $val) {
	 				if (!empty($val)) {
	 					foreach ($val as $b) {
	 						if ($options['reason_id'] == $b['reason_id']) {
	 							$reason = $b['reason_name'];
	 						}
	 					}
	 				}
	 				
	 			}
	 		}
	 	}
		return $reason;
	}
	
	
	/**
	 * 获取取消订单和售后原因列表
	 */
	public static function reason_list($type){
		$reason_list = array();
		if (!empty($type)) {
			$data = RC_Loader::load_app_config('refund_reasons', 'refund');
			if ($type == 'await_ship') {
				$reason_list = $data['await_ship'];
			} elseif ($type == 'shipped') {
				$reason_list = $data['shipped'];
			} elseif ($type == 'finished') {
				$reason_list = $data['finished'];
			}
		}
	
		return $reason_list;
	}
	
	
	/**
	 * 获取售后申请图片
	 */
	public static function get_return_images($refund_id){
		$data = array();
		if (!empty($refund_id)) {
			$db = RC_DB::table('term_attachment');
			$return_images = $db->where('object_app', 'ecjia.refund')
								->where('object_group', 'refund')
								->where('object_id', $refund_id)
								->lists('file_path');
			
			if (!empty($return_images)) {
				foreach ($return_images as $val) {
					if (!empty($val)) {
						$data[] = RC_Upload::upload_url($val);
					}
				}
			}
		}
		return $data;
	}

	
	/**
	 * 售后申请操作记录
	 * @param array $options
	 */
	public static function refund_order_action($options){
		$data = array(
        		'refund_id' 		=> $options['refund_id'],
        		'action_user_type'	=> $options['action_user_type'],
        		'action_user_id'	=> $options['action_user_id'],
        		'action_user_name'  => $options['action_user_name'],
        		'status'			=> $options['status'],
        		'refund_status'		=> $options['refund_status'],
        		'return_status'		=> $options['return_status'],
        		'action_note'		=> $options['action_note'],
		   		'log_time'			=> RC_Time::gmtime()
         );
		
		$action_id = RC_DB::table('refund_order_action')->insertGetId($data);
		
		return $action_id;
	}
	
	/**
	 * 得到新售后编号
	 * @return  string
	 */
	public static function get_refund_sn() {
		/* 选择一个随机的方案 */
		$str = date('Ymd') . str_pad(mt_rand(1, 9999999), 5, '0', STR_PAD_LEFT);
		return $str;
	}
	
	/**
	 * 获取某个订单的售后申请信息（有效的，不含取消的）
	 * @return  array
	 */
	public static function currorder_refund_info($order_id) {
		$refund_info = array();
		
		if (!empty($order_id)) {
			$refund_info = RC_DB::table('refund_order')->where('order_id', $order_id)->where('status', '<>', 10)->first();
		}
		
		return $refund_info;
	}
	
	/**
	 * 获取某个订单的订单商品
	 * @return  array
	 */
	public static function currorder_goods_list($order_id) {
		$list = array();
	
		if (!empty($order_id)) {
			$list = RC_DB::table('order_goods as og')
			->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
			->select(RC_DB::raw('og.*'), RC_DB::raw('g.goods_thumb'), RC_DB::raw('g.goods_img'), RC_DB::raw('g.original_img'))
			->where(RC_DB::raw('og.order_id'), $order_id)->get();
		}
	
		return $list;
	}
	
	/**
	 * 获取某个订单的发货单列表
	 * array
	 */
	public static function currorder_delivery_list($order_id) {
		$delivery_list = array();
		if (!empty($order_id)) {
			$delivery_list = RC_DB::table('delivery_order')->where('order_id', $order_id)->whereIn('status', array(0,2))->get();
		}
		return $delivery_list;
	}
	
	/**
	 * 获取某个订单的发货了的商品信息
	 * array
	 */
	public static function delivery_goodsList($delivery_id) {
		$deliveryGoods_list = array();
		if (!empty($delivery_id)) {
			$deliveryGoods_list = RC_DB::table('delivery_goods')->where('delivery_id', $delivery_id)->select('goods_id', 'product_id', 'product_sn', 'goods_name', 'goods_sn', 'is_real', 'send_number', 'goods_attr')->get();
		}
		return $deliveryGoods_list;
	}
	
	/**
	 * 记录订单操作记录
	 *
	 * @access public
	 * @param string $order_sn
	 *        	订单编号
	 * @param integer $order_status
	 *        	订单状态
	 * @param integer $shipping_status
	 *        	配送状态
	 * @param integer $pay_status
	 *        	付款状态
	 * @param string $note
	 *        	备注
	 * @param string $username
	 *        	用户名，用户自己的操作则为 buyer
	 * @return void
	 */
	public static function order_action($order_id, $order_status, $shipping_status, $pay_status, $note = '', $username = null, $place = 0) {
		if (is_null ( $username )) {
			$username = empty($_SESSION ['admin_name']) ? '系统' : $_SESSION ['admin_name'];
		}
	
	
		$data = array (
				'order_id'           => $order_id,
				'action_user'        => $username,
				'order_status'       => $order_status,
				'shipping_status'    => $shipping_status,
				'pay_status'         => $pay_status,
				'action_place'       => $place,
				'action_note'        => $note,
				'log_time'           => RC_Time::gmtime()
		);
		RC_DB::table('order_action')->insert($data);
	}
	
	/**
	 * 订单状态log记录
	 * @param array $options
	 */
	public static function order_status_log($options) {
		$data = array(
			'order_status' 	=> $options['order_status'],
			'order_id' 		=> $options['order_id'],
			'message' 		=> $options['message'],
			'add_time'		=> RC_Time::gmtime()
		);
		RC_DB::table('order_status_log')->insert($data);
	}
	
	/**
	 * 售后申请状态log记录
	 * @param array $options
	 */
	public static function refund_status_log($options) {
		$data = array(
				'status' 		=> $options['status'],
				'refund_id' 	=> $options['refund_id'],
				'message' 		=> $options['message'],
				'add_time'		=> RC_Time::gmtime()
		);
		RC_DB::table('refund_status_log')->insert($data);
	}

	/**
	 * 获取退款申请最新一条log
	 * @param array $options
	 */
	public static function get_latest_refund_log($refund_id) {
		if (!empty($refund_id)) {
			$log_data = RC_DB::table('refund_status_log')->where('refund_id', $refund_id)->orderBy('add_time', 'desc')->get();
			if ($log_data) {
				$log_data = $log_data['0'];
			}
		} else {
			$log_data = array();
		}
		
		return $log_data;
	}
	
	
	/**
	 * 获取退款退货售后申请的退货商品
	 * @return  array
	 */
	public static function refund_backgoods_list($refund_id) {
		$list = array();
	
		if (!empty($refund_id)) {
			$list = RC_DB::table('refund_goods as rg')
						->leftJoin('goods as g',  RC_DB::raw('bg.goods_id'), '=', RC_DB::raw('g.goods_id'))
						->select(RC_DB::raw('bg.*'), RC_DB::raw('g.goods_thumb'), RC_DB::raw('g.goods_img'), RC_DB::raw('g.original_img'))
						->where(RC_DB::raw('bg.back_id'), $refund_id)
						->get();
		}
	
		return $list;
	}
	
	/**
	 * 获取退款详情
	 * @return  array
	 */
	public static function get_refundorder_detail($options) {
		$detail = array();
		$refund_sn = $options['refund_sn'];
		if (!empty($refund_sn)) {
			$detail = RC_DB::table('refund_order')->where('refund_sn', $refund_sn)->first();
			if (!empty($detail['refund_reason'])) {
				$reason_list = RC_Loader::load_app_config('refund_reasons', 'refund');
				foreach ($reason_list as $row) {
					foreach ($row as $a) {
						$data[] = $a;
					}
				}
				foreach ($data as $b) {
					if ($b['reason_id'] == $detail['refund_reason']) {
						$detail['reason'] = $b['reason_name'];
					}
				}
			}
		}
	
		return $detail;
	}
	
	/**
	 * 获取一周后日期（上门取件日期）
	 * @return  array
	 */
	public static function get_pickup_dates() {
		$time = RC_Time::gmtime();
		$date1 = date('Y-m-d', ($time . ' +1 day'));
		$date2 = date('Y-m-d', strtotime($date1 . ' +1 day'));
		$date3 = date('Y-m-d', strtotime($date2 . ' +1 day'));
		$date4 = date('Y-m-d', strtotime($date3 . ' +1 day'));
		$date5 = date('Y-m-d', strtotime($date4 . ' +1 day'));
		$date6 = date('Y-m-d', strtotime($date5 . ' +1 day'));
		$date7 = date('Y-m-d', strtotime($date6 . ' +1 day'));
		
		$dates = array($date1, $date2, $date3, $date4, $date5, $date6, $date7);
		
		return $dates;
	}
	
	/**
	 * 获取上门取件时间段
	 * @return  array
	 */
	public static function get_pickup_times() {
		$times = array(array('start_time' => '08:00', 'end_time' => '18:00'));
	
		return $times;
	}
	
	/**
	 * 获取退款进度日志
	 * @return  array
	 */
	public static function get_refund_logs($refund_id) {
		$logs = RC_DB::table('refund_status_log')->where('refund_id', $refund_id)->orderBy('add_time', 'desc')->get();
	
		return $logs;
	}
	
	/**
	 * 获取打款信息
	 * @return  array
	 */
	public static function get_refund_payrecord($refund_id) {
		$refund_payrecord = array();
		$refund_payrecord = RC_DB::table('refund_payrecord')->where('refund_id', $refund_id)->first();
	
		return $refund_payrecord;
	}
	
	/**
	 * 获取某个原因id所在的那组原因
	 * @return  array
	 */
	public static function get_one_group_reasons($reason_id) {
		$refused_reasons = array();
		if (!empty($reason_id)) {
			$reasons = RC_Loader::load_app_config('refund_reasons', 'refund');
			$refused_reasons = array();
			if (!empty($reasons)) {
				foreach ($reasons as $kk => $value) {
				if ($reason_id == $value['reason_id']) {
					$reason_str = $kk;
				}
					if (!empty($value)) {
						foreach ($value as $bb) {
							if ($reason_id == $bb['reason_id']) {
								$reason_str = $kk;
							}
						}
					}
						
				}
				$refused_reasons = $reasons[$reason_str];
			}
		}
		return $refused_reasons;
	}
}	


// end