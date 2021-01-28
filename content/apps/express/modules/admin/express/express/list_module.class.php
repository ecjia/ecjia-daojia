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
 * 配送信息列表
 * @author will.chen
 */
class admin_express_express_list_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
		$express_type = $this->requestData('express_type');
		$type = $this->requestData('type');
		$order_sn = $this->requestData('order_sn');//配送单号
		$size     = $this->requestData('pagination.count', 15);
		$page     = $this->requestData('pagination.page', 1);
		
		if (empty($express_type)) {
			return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'express'), __CLASS__));
		}
		//$where    = array('staff_id' => $_SESSION['staff_id']);
		//switch ($express_type) {
		//	case 'wait_pickup' :
		//		$where['eo.status'] = 1;
		//		break;
		//	case 'wait_shipping' :
		//		$where['eo.status'] = 2;
		//		break;
		//	case 'finished' :
		//		$where['eo.status'] = array(5,7);
		//		break;
		//	default : 
		//		if (!empty($order_sn)) {
		//			$where['eo.express_sn'] = array('like' => '%'.$order_sn.'%');
		//		} else {
		//			return new ecjia_error('invalid_parameter', __('参数无效', 'express'));
		//		}
		//}
		//if (!empty($type) && in_array($type, array('assign', 'grab'))) {
		//    $where['eo.from'] = $type;
		//}
		
		//$express_order_db = RC_Model::model('express/express_order_viewmodel');
		//$count = $express_order_db->join(null)->where($where)->count();
		
		$express_order_db = RC_DB::table('express_order as eo')
                                        ->leftjoin('store_franchisee as sf', RC_DB::raw('sf.store_id'), '=', RC_DB::raw('eo.store_id'))
                                        ->leftjoin('order_info as oi', RC_DB::raw('eo.order_id'), '=', RC_DB::raw('oi.order_id'));
                                        
		$express_order_db->where(RC_DB::raw('eo.staff_id'), $_SESSION['staff_id']);
		if (!empty($express_type)) {
			if ($express_type == 'wait_pickup') {
				$express_order_db->where(RC_DB::raw('eo.status'), 1);
			} elseif ($express_type == 'wait_shipping') {
				$express_order_db->where(RC_DB::raw('eo.status'), 2);
			} elseif ($express_type == 'finished') {
				$express_order_db->whereIn(RC_DB::raw('eo.status'), array(5,7));
			}
		}
		if (!empty($order_sn)) {
			$express_order_db->where(RC_DB::raw('eo.express_sn'), 'like', '%'.mysql_like_quote($order_sn).'%');
		}
		if (!empty($type) && in_array($type, array('assign', 'grab'))) {
			$express_order_db->where(RC_DB::raw('eo.from'), $type);
		}
		
		$count = $express_order_db->count(RC_DB::raw('eo.express_id'));
		
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$field = 'eo.*, oi.expect_shipping_time, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.district as sf_district, sf.street as sf_street, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
		//$express_order_result = $express_order_db->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->order(array('express_id' => 'desc'))->limit($page_row->limit())->select();
		$express_order_result = $express_order_db->select(RC_DB::raw($field))->take($size)->skip($page_row->start_id-1)->get();
		$express_order_list = array();
		if (!empty($express_order_result)) {
			foreach ($express_order_result as $val) {
				
				if ($val['status'] == '1') {
					$status = 'wait_pickup';
					$label_express_status = '待取货';
				} elseif ($val['status'] == '2') {
					$status = 'wait_shipping';
					$label_express_status = '配送中';
				} elseif ($val['status'] == '5' || $val['status'] == '7') {
					$status = 'finished';
					$label_express_status = '已完成';
				}
				$sf_district_name = ecjia_region::getRegionName($val['sf_district']);
				$sf_street_name = ecjia_region::getRegionName($val['sf_street']);
				$district_name = ecjia_region::getRegionName($val['district']);
				$street_name = ecjia_region::getRegionName($val['street']);
			
				/*店铺电话*/
				$shop_kf_mobile = RC_DB::table('merchants_config')->where('store_id', $val['store_id'])->where('code', 'shop_kf_mobile')->value('value');
				
				$express_order_list[] = array(
					'express_id'	         => $val['express_id'],
					'express_sn'	         => $val['express_sn'],
					'express_type'	         => $val['from'],
					'label_express_type'	 => $val['from'] == 'assign' ? '系统派单' : '抢单',
					'order_sn'		         => $val['order_sn'],
					'payment_name'	         => $val['pay_name'],
					'store_name'			 => $val['merchants_name'],
					'shop_kf_mobile'		 => empty($shop_kf_mobile) ? '' : $shop_kf_mobile,
					'express_from_address'	 => $sf_district_name. $sf_street_name. $val['merchant_address'],
					'express_from_location'	 => array(
						'longitude' => $val['merchant_longitude'],
						'latitude'	=> $val['merchant_latitude'],
					),
					'express_to_address'	 => $district_name. $street_name. $val['address'],
					'express_to_location'	 => array(
						'longitude' => $val['longitude'],
						'latitude'	=> $val['latitude'],
					),
					'express_status' => $status,
					'label_express_status' => $label_express_status,
					'distance'		=> $val['distance'],
					'consignee'		=> $val['consignee'],
					'mobile'		=> $val['mobile'],
					'receive_time'	=> $val['receive_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $val['receive_time']) : '',
					'express_time'	=> $val['express_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $val['express_time']) : '',
					'order_time'	=> $val['order_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $val['order_time']) : '',
					'pay_time'		=> empty($val['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $val['pay_time']),
					'signed_time'	=> $val['signed_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $val['signed_time']) : '',
					'best_time'		=> $val['expect_shipping_time'],
					'shipping_fee'	=> $val['commision'],
					'order_amount'	=> $val['order_amount'],
					'delivery_id'	=> intval($val['delivery_id']),	
					'delivery_sn'	=> empty($val['delivery_sn']) ? '' : trim($val['delivery_sn'])	
				);
			}
		}
		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $express_order_list, 'pager' => $pager);
	 }	
}

// end