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
use Ecjia\System\Notifications\ExpressAssign;
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 发货后；配送方式是众包配送时自动派单给平台配送员
 * @author zrl
 *
 */
class express_ecjiaauto_assign_expressOrder_api extends Component_Event_Api {
    /**
     * @param  array 
     * @return array
     */
	public function call(&$options) {
		$express_id = $options['express_id'];
		
		if (empty($express_id)) {
			return array();
		}
		
		$pra = array(
				'online_status' => 1,
		);
		
		//获取配送员列表
		$online_express_user_list = $this->get_express_user_list($pra);
		
		//获取每个配送员待取货和配送中的配送单数量
		$data = array();
		if (!empty($online_express_user_list)) {
			foreach ($online_express_user_list as  $row) {
				$express_count 				= $this->get_express_count($row['user_id']);
				$row['wait_pickup_count'] 	= $express_count['wait_pickup'];
				$row['sending_count']		= $express_count['sending'];
				$row['total_count']			= $express_count['wait_pickup'] + $express_count['sending'];
				$data[] = $row;
			}
			
			//过滤掉配送员手中未完成配送订单数大于10的配送员;
			foreach ($data as $a => $b) {
				if (($b['total_count'] > 10)) {
					unset($data[$a]);
				}
			}
		}
		
		/*计算每个配送员与订单之间的距离*/
		if (!empty($data)) {
			$field = 'eo.*, oi.add_time as order_time, oi.pay_time,  oi.expect_shipping_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.district as sf_district, sf.street as sf_street, sf.address as merchant_address, sf.longitude as sf_longitude, sf.latitude as sf_latitude';
			$dbview = RC_DB::table('express_order as eo')
			->leftJoin('store_franchisee as sf', RC_DB::raw('sf.store_id'), '=', RC_DB::raw('eo.store_id'))
			->leftJoin('order_info as oi', RC_DB::raw('eo.order_id'), '=', RC_DB::raw('oi.order_id'));
			
			$express_order_info	= $dbview->where(RC_DB::raw('eo.express_id'), $express_id)->selectRaw($field)->first();
			
			
			$express_user_data = array();
			
			foreach ($data as $k => $v) {
				if (!empty($express_order_info['sf_latitude']) && !empty($express_order_info['sf_longitude'])) {
					//腾讯地图api距离计算
					$keys = ecjia::config('map_qq_key');
					$url = "http://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$express_order_info['sf_latitude'].",".$express_order_info['sf_longitude']."&to=".$v['latitude'].",".$v['longitude']."&key=".$keys;
					$distance_json = file_get_contents($url);
					$distance_info = json_decode($distance_json, true);
					$v['distance'] = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
					$express_user_data[] = $v;
				}
			}
			/*过滤掉离订单距离大于5公里的配送员*/
			if (!empty($express_user_data)) {
				foreach ($express_user_data as $kk => $vv) {
					if ($vv['distance'] > 5000) {
						unset($express_user_data[$kk]);
					}
				}
			}
			//获取离订单最近的配送员id
			if (!empty($express_user_data)) {
				$express_user_dis = array();
				if ($express_user_data) {
					foreach ($express_user_data as $aa => $bb) {
						$express_user_dis[$bb['user_id']] =  $bb['distance'];
					}
				}
				$hots = $express_user_dis;
				$staff_id = array_search(min($hots),$hots);
			}
	
			if ($staff_id) {
				$ex_u_info = RC_DB::table('staff_user as su')
								->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'))
								->selectRaw('su.*, eu.shippingfee_percent')
								->where(RC_DB::raw('su.user_id'), $staff_id)->first();
				
				$commision = $ex_u_info['shippingfee_percent']/100*$express_order_info['shipping_fee'];
				$commision = sprintf("%.2f", $commision);
				$assign_data = array(
					'from'				=> 'assign',
					'status'			=> 1,
					'express_user' 		=> $ex_u_info['name'],
					'express_mobile' 	=> $ex_u_info['mobile'],
					'staff_id'			=> $staff_id,
					'receive_time'		=> RC_Time::gmtime(),
					'commision'			=> $commision,
					'commision_status'	=> 0
				);
				
				$query = RC_DB::table('express_order')->where('express_id', $express_id)->update($assign_data);
				
				if ($query) {
					/* 消息插入 */
					$orm_staff_user_db = RC_Model::model('orders/orm_staff_user_model');
					$user = $orm_staff_user_db->find($staff_id);
					 
					/* 派单发短信 */
					if (!empty($express_order_info['express_mobile'])) {
						$options = array(
								'mobile' => $express_order_info['express_mobile'],
								'event'	 => 'sms_express_system_assign',
								'value'  =>array(
										'express_sn'=> $express_order_info['express_sn'],
								),
						);
						RC_Api::api('sms', 'send_event_sms', $options);
					}
					
					/*派单推送消息*/
					$options = array(
							'user_id'   => $staff_id,
							'user_type' => 'merchant',
							'event'     => 'express_system_assign',
							'value' => array(
									'express_sn'=> $express_order_info['express_sn'],
							),
							'field' => array(
									'open_type' => 'admin_message',
							),
					);
					RC_Api::api('push', 'push_event_send', $options);
					
					
					//消息通知
					$express_from_address = ecjia_region::getRegionName($express_order_info['sf_district']).ecjia_region::getRegionName($express_order_info['sf_street']).$express_order_info['merchant_address'];
					$express_to_address = ecjia_region::getRegionName($express_order_info['district']).ecjia_region::getRegionName($express_order_info['street']).$express_order_info['address'];
					
					$notification_express_data = array(
							'title'	=> '系统派单',
							'body'	=> '有单啦！系统已分配配送单到您账户，赶快行动起来吧！',
							'data'	=> array(
									'express_id'			=> $express_order_info['express_id'],
									'express_sn'			=> $express_order_info['express_sn'],
									'express_type'			=> $express_order_info['from'],
									'label_express_type'	=> '系统派单',
									'order_sn'				=> $express_order_info['order_sn'],
									'payment_name'			=> $express_order_info['pay_name'],
									'express_from_address'	=> '【'.$express_order_info['merchants_name'].'】'. $express_from_address,
									'express_from_location'	=> array(
											'longitude' => $express_order_info['merchant_longitude'],
											'latitude'	=> $express_order_info['merchant_latitude'],
									),
									'express_to_address'	=> $express_to_address,
									'express_to_location'	=> array(
											'longitude' => $express_order_info['longitude'],
											'latitude'	=> $express_order_info['latitude'],
									),
									'distance'		=> $express_order_info['distance'],
									'consignee'		=> $express_order_info['consignee'],
									'mobile'		=> $express_order_info['mobile'],
									'receive_time'	=> RC_Time::local_date(ecjia::config('time_format'), $express_order_info['receive_time']),
									'order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $express_order_info['order_time']),
									'pay_time'		=> empty($express_order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['pay_time']),
									'best_time'		=> $express_order_info['best_time'],
									'shipping_fee'	=> $express_order_info['shipping_fee'],
									'order_amount'	=> $express_order_info['order_amount'],
							),
					);
					$express_assign = new ExpressAssign($notification_express_data);
					RC_Notification::send($user, $express_assign);
				}
			}
			
		}
		
		return array();
	}
	
	
	/**
	 * 获取配送员列表
	 */
	public function get_express_user_list($pra){
		$db = RC_DB::table('staff_user as su')->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'));
		$db->where(RC_DB::raw('su.store_id'), 0);
		$db->where(RC_DB::raw('eu.work_type'), 1);
		
		if (!empty($pra['online_status'])) {
			$db->where(RC_DB::raw('su.online_status'), 1);
		}
		
		$list = $db->selectRaw('eu.*, su.online_status')->get();
		
		return $list;
	}
	
	
	/**
	 * 获取配送员待取货和配送中的配送单数量
	 */
	public function get_express_count($user_id){
		$db = RC_DB::table('express_order');
		
		$express_order_count = $db
		->where('staff_id', $user_id)
		->selectRaw('SUM(IF(status = 1, 1, 0)) as wait_pickup, SUM(IF(status = 2, 1, 0)) as sending')
		->first();
		
		return $express_order_count;
	}
}

// end