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
 * 订单物流信息列表（用户一个月内订单，且有物流信息的订单）
 * @author zrl
 */
class user_orders_express_message_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
    	$user_id = $_SESSION['user_id'];
    	if ($user_id < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}
    	
    	$size     = $this->requestData('pagination.count', '15');
    	$page     = $this->requestData('pagination.page', '1');
    	
    	$size	  = empty($size) ? 15 : $size;
    	$page	  = empty($page) ? 1 : $page;
    	
    	$cloud_express_key = ecjia::config('cloud_express_key');
    	$cloud_express_secret = ecjia::config('cloud_express_secret');
    	
    	if (empty($cloud_express_key) || empty($cloud_express_secret)) {
    		return new ecjia_error('track_setting_error', '物流跟踪配置不正确');
    	}
    	
    	//用户近一个月内订单，且有物流信息的
    	$current_time = RC_Time::gmtime();
    	$one_month_ago = RC_Time::local_date('Y-m-d', RC_Time::local_strtotime("-1 month"));
    	$one_month_ago = RC_Time::local_strtotime($one_month_ago);
    	
    	$order_ids = RC_DB::table('order_info')->where('is_delete', 0)
    					->where('user_id', $user_id)
    					->whereRaw('invoice_no is not null and invoice_no !=""')
    					->where('shipping_time', '>=', $one_month_ago)
    					->where('shipping_time', '<=', $current_time)
    					->lists('order_id');
    	
    	//最近一个月订单没有满足条件的返回空
    	if (empty($order_ids)) {
    		$pager = array(
    				'total'	=>	0,
    				'count'	=> 	0,
    				'more'	=> 	0
    		);
    		
    		return array('data' => array(), 'pager' => $pager);
    	}
    	
    	//这些订单物流数据为空时，请求接口，录入物流信息
    	$ship_code 		= RC_Loader::load_app_config('shipping_code', 'shipping');
    	$track_status 	= RC_Loader::load_app_config('track_status', 'track');
    	
    	$order_track_list = [];
    	if (!empty($order_ids)) {
    		$order_track_list = RC_DB::table('track_logistic')->whereIn('order_id', $order_ids)->get();
    	}
    	
    	if (empty($order_track_list)) {
    		$delivery_result = RC_DB::table('delivery_order')->whereIn('order_id', $order_ids)->get();
    		
    		if (!empty($delivery_result)) {
    			foreach ($delivery_result as $val) {
    				$shipping_info = RC_DB::table('shipping')->where('shipping_id', $val['shipping_id'])->first();
    				$typeCom = $ship_code[$shipping_info['shipping_code']];
    				if ($shipping_info['shipping_code'] !='ship_o2o_express' && $shipping_info['shipping_code'] !='ship_ecjia_express') {
    					if (!empty($typeCom) && !empty($val['invoice_no'])) {
    						$params = array(
    								'app_key' => $cloud_express_key,
    								'app_secret' => $cloud_express_secret,
    								'company' => $typeCom,
    								'number' => $val['invoice_no'],
    								'order' => 'desc',
    						);
    						$cloud = ecjia_cloud::instance()->api('express/track')->data($params)->run();
    						if (is_ecjia_error($cloud->getError())) {
    							$data = array('content' => array('time' => 'error', 'context' => $cloud->getError()->get_error_message()));
    						} else {
    							$data = $cloud->getReturnData();
    							//本地数据库录入
    							$track_logistic_info = RC_DB::table('track_logistic')->where('order_id', $val['order_id'])->where('order_type', 'default')->where('track_number', $val['number'])->first();
    							if (!empty($data['company']) && !empty($data['number'])) {
    								if (!empty($track_logistic_info)) {
    									$this->update_track_logistic($val['order_id'], $data);
    								} else {
    									$this->insert_track_logistic($val['order_id'], $data);
    								}
    							}
    						}
    					}
    				}
    			}
    		}
    	} else {
    		if (!empty($order_ids)) {
    			//一个月订单有部分录入数据库，部分未录入物流数据库时
    			$tracked_number = RC_DB::table('track_logistic')->whereIn('order_id', $order_ids)->where('order_type', 'default')->lists('track_number');
    			$delivery = RC_DB::table('delivery_order')->whereIn('order_id', $order_ids)->get();
    			
    			if (!empty($delivery)) {
    				foreach ($delivery as $value) {
    					if (!in_array($value['invoice_no'], $tracked_number)) {
    						$shipping_info = RC_DB::table('shipping')->where('shipping_id', $value['shipping_id'])->first();
    						$typeCom = $ship_code[$shipping_info['shipping_code']];
    						 
    						if ($shipping_info['shipping_code'] !='ship_o2o_express' && $shipping_info['shipping_code'] !='ship_ecjia_express') {
    							$params = array(
    									'app_key' => $cloud_express_key,
    									'app_secret' => $cloud_express_secret,
    									'company' => $typeCom,
    									'number' => $value['invoice_no'],
    									'order' => 'desc',
    							);
    							$cloud = ecjia_cloud::instance()->api('express/track')->data($params)->run();
    							if (is_ecjia_error($cloud->getError())) {
    								$data = array('content' => array('time' => 'error', 'context' => $cloud->getError()->get_error_message()));
    							} else {
    								$data = $cloud->getReturnData();
    								//本地数据库录入
    								$track_logistic_info = RC_DB::table('track_logistic')->where('order_id', $value['order_id'])->where('order_type', 'default')->where('track_number', $value['number'])->first();
    								if (!empty($data['company']) && !empty($data['number'])) {
    									if (!empty($track_logistic_info)) {
    										$this->update_track_logistic($value['order_id'], $data);
    									} else {
    										$this->insert_track_logistic($value['order_id'], $data);
    									}
    								}
    							}
    						}
    					}
    				}
    			}
    	
    			//这些订单的物流更新时间有没超过3小时的，有超过3小时的请求接口更新本地数据库；
    			$time_period = 1*3600;
    			$period = $current_time - $time_period;
    			$result = [];
    			$result = RC_DB::table('track_logistic')->whereIn('order_id', $order_ids)->where('update_time', '<=', $period)->get();
    			
    			if (!empty($result)) {
    				foreach ($result as $row) {
    					$params = array(
    							'app_key' 		=> $cloud_express_key,
    							'app_secret' 	=> $cloud_express_secret,
    							'company' 		=> $row['company_code'],
    							'number' 		=> $row['track_number'],
    							'order' 		=> 'desc',
    					);
    					$cloud = ecjia_cloud::instance()->api('express/track')->data($params)->run();
    					if (is_ecjia_error($cloud->getError())) {
    						return new ecjia_error('track_setting_error', $cloud->getError()->get_error_message());
    					} else {
    						$data = $cloud->getReturnData();
    						if (!empty($data['company']) && !empty($data['number'])) {
    							$this->update_track_logistic($row['order_id'], $data);
    						}
    					}
    				}
    			}
    		}
    	}
    	
    	//查询本地数据库物流信息
    	$arr = [];
    	if (!empty($order_ids)) {
    		$count = RC_DB::table('track_logistic')->whereIn('order_id', $order_ids)->count();
    		//实例化分页
    		$page_row = new ecjia_page($count, $size, 6, '', $page);
    		$latest_express_log = [];
    		$list = RC_DB::table('track_logistic')->whereIn('order_id', $order_ids)->take($size)->skip($page_row->start_id - 1)->orderBy('update_time', 'desc')->get();
    		
			if (!empty($list)) {
				foreach ($list as $v) {
					$delivery_goods = [];
					$delivery_id = 0;
					$label_shipping_status = $track_status[$v['status']];
					$track_log = RC_DB::table('track_log')->where('track_number', $v['track_number'])->where('track_company', $v['company_code'])->orderBy('time', 'desc')->get();
					
					if (!empty($track_log)) {
						$latest_express_log = array('time' => $track_log['0']['time'], 'context' => $track_log['0']['context']);
					}
					//发货商品
					$delivery_id = RC_DB::table('delivery_order')->where('order_id', $v['order_id'])->where('invoice_no', $v['track_number'])->pluck('delivery_id');
					$delivery_goods = $this->get_delivery_goods($delivery_id);
					
					$arr[] = array(
							'order_id' 					=> intval($v['order_id']),
							'company_name'				=> empty($v['company_name']) ? '' : $v['company_name'],
							'company_code'				=> empty($v['company_code']) ? '' : $v['company_code'],
							'shipping_number'			=> empty($v['track_number']) ? '' : $v['track_number'],
							'shipping_status'			=> isset($v['shipping_status']) ? 0 : intval($v['shipping_status']),
							'label_shipping_status' 	=> $label_shipping_status,
							'sign_time_formated'		=> empty($v['sign_time']) ? '' : $v['sign_time'],
							'latest_express_log'		=> $latest_express_log,
							'goods_items'				=> $delivery_goods
							
					);
				}
			}
    		
			$pager = array(
					'total' => $page_row->total_records,
					'count' => $page_row->total_records,
					'more'	=> $page_row->total_pages <= $page ? 0 : 1,
			);
    	} else {
    		$pager = array(
    				"total" => 0,
    				"count" => 0,
    				"more"  => 0
    		);
    	}
    	
    	return array('data' => $arr, 'pager' => $pager);
	}
	
	/**
	 * 录入物流信息主表
	 */
	private function insert_track_logistic($order_id, $data) {
		$ship_company = RC_Loader::load_app_config('shipping_company', 'track');
		$arr = array(
				'order_id' 		=> $order_id,
				'order_type'	=> 'default',
				'company_code'	=> empty($data['company']) ? '' : $data['company'],
				'company_name'	=> $ship_company[$data['company']],
				'status'		=> !empty($data['state']) ? $data['state'] : 0,
				'track_number'  => !empty($data['number']) ? $data['number'] : '',
				'add_time'		=> RC_Time::gmtime(),
				'update_time'	=> RC_Time::gmtime(),
				'sign_time'		=> !empty($data['sign_time_formated']) ? $data['sign_time_formated'] : '',
		);
		
		RC_DB::table('track_logistic')->insert($arr);
		//物流详细信息记录
		$track_log_list = RC_DB::table('track_log')->where('track_company', $data['company'])->where('track_number', $data['number'])->orderBy('time', 'desc')->get();
		if (!empty($data['content'])) {
			if (count($track_log_list) > 0) {
				$this->update_track_log($data, $track_log_list);
			} else {
				$this->insert_track_log($data);
			}
		}
	}
	
	/**
	 * 更新物流信息主表
	 */
	private function update_track_logistic($order_id, $data) {
		if (!empty($data['company']) && !empty($data['number'])) {
			$sign_time = empty($data['sign_time_formated']) ? '' : ($data['sign_time_formated']);
			$track_data = array('status' => $data['state'], 'update_time' => RC_Time::gmtime(), 'sign_time' => $sign_time); 
			RC_DB::table('track_logistic')
				->where('order_id', $order_id)
				->where('order_type', 'default')
				->where('track_number', $data['number'])
				->update($track_data);
			if (!empty($data['content'])) {
				$track_log_list = RC_DB::table('track_log')->where('track_company', $data['company'])->where('track_number', $data['number'])->orderBy('time', 'desc')->get();
				$this->update_track_log($data, $track_log_list);
			}
		}
	}
	
	/**
	 * 录入物流详细记录
	 */
	private function insert_track_log($data) {
		$content = $data['content'];
		if (!empty($content)) {
			foreach ($content as $val) {
				$time = empty($val['time']) ? '' : $val['time'];
				$desc = empty($val['context']) ? '' : $val['context'];
				
				RC_DB::table('track_log')->insert(array('track_company' => $data['company'], 'track_number' => $data['number'], 'time' => $time, 'context' => $desc));
			}
		}
		return true;
	}
	
	/**
	 * 更新物流详细记录
	 */
	private function update_track_log($data, $track_log_list) {
		if (!empty($data['content'])) {
			//最后一条更新时间
			if (!empty($track_log_list)) {
				$last_time = $track_log_list[0]['time'];
			} else {
				$last_time = 0;
			}
			foreach ($data['content'] as $val) {
				if ($val['time'] > $last_time) {
					$data_log = array(
							'track_company' => $data['company'],
							'track_number' 	=> $data['number'],
							'time'  		=> $val['time'],
							'context' 		=> $val['context']
					);
					RC_DB::table('track_log')->insert($data_log);
				}
			}
		}
		return true;
	}
	
	/**
	 * 发货单商品
	 */
	private function get_delivery_goods($delivery_id = 0) {
		$goods_list = [];
		if (!empty($delivery_id)) {
			$delivery_goods_view = RC_DB::table('delivery_goods as dg')->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('dg.goods_id'));
			$field = 'dg.goods_id, dg.goods_name, dg.goods_sn, dg.send_number, g.goods_thumb, g.goods_img, g.original_img';
			$delivery_goods = $delivery_goods_view->where('delivery_id', $delivery_id)->select(RC_DB::raw($field))->get();
			if (!empty($delivery_goods)) {
				$goods_list = [];
				foreach ($delivery_goods as $rows) {
					$goods_list[] = array(
							'id' 		=> $rows['goods_id'],
							'name'		=> $rows['goods_name'],
							'goods_sn'	=> $rows['goods_sn'],
							'number'	=> $rows['send_number'],
							'img'		=> array(
									'thumb' => empty($rows['goods_thumb']) ? '' : RC_Upload::upload_url($rows['goods_thumb']),
									'url' => empty($rows['original_img']) ? '' : RC_Upload::upload_url($rows['original_img']),
									'small' => empty($rows['goods_img']) ? '' : RC_Upload::upload_url($rows['goods_img'])
							)
					);
				}
			}
		}
		return $goods_list;
	}
}


// end