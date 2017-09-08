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
use Ecjia\System\Notifications\ExpressGrab;
defined('IN_ECJIA') or exit('No permission resources.');


/**
 * 配送抢单列表
 * @author will.chen
 */
class grab_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        
		$location	= $this->requestData('location', array());
		$express_id = $this->requestData('express_id');
		
		if (empty($express_id)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		$where                = array('store_id' => $_SESSION['store_id'], 'staff_id' => 0, 'express_id' => $express_id);
		
		$express_order_db     = RC_Model::model('express/express_order_model');
		$express_order_info   = $express_order_db->where($where)->find();
		
		if (!empty($express_order_info)) {
			$update_date                     = array('staff_id' => $_SESSION['staff_id'], 'from' => 'grab', 'status' => 1, 'receive_time' => RC_Time::gmtime());
			$update_date['express_user']	 = $_SESSION['staff_name'];
			$update_date['express_mobile']	 = $_SESSION['staff_mobile'];
			
			$result                  = $express_order_db->where($where)->update($update_date);
			$orm_staff_user_db       = RC_Model::model('express/orm_staff_user_model');
			$user                    = $orm_staff_user_db->find($_SESSION['staff_id']);
			$express_order_viewdb    = RC_Model::model('express/express_order_viewmodel');
			
			$where                   = array('staff_id' => $_SESSION['staff_id'], 'express_id' => $express_id);
			$field                   = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
			$express_order_info      = $express_order_viewdb->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->find();
			
			//消息通知
			$express_data            = array(
				'title'	=> '抢单成功',
				'body'	=> '您已成功抢到配送单号，单号为：'.$express_order_info['express_sn'],
				'data'	=> array(
					'express_id'	        => $express_order_info['express_id'],
					'express_sn'	        => $express_order_info['express_sn'],
					'express_type'	        => $express_order_info['from'],
					'label_express_type'	=> $express_order_info['from'] == 'assign' ? '系统派单' : '抢单',
					'order_sn'		        => $express_order_info['order_sn'],
					'payment_name'	        => $express_order_info['pay_name'],
					'express_from_address'	=> '【'.$express_order_info['merchants_name'].'】'. $express_order_info['merchant_address'],
					'express_from_location'	=> array(
						'longitude'     => $express_order_info['merchant_longitude'],
						'latitude'	    => $express_order_info['merchant_latitude'],
					),
					'express_to_address'	=> $express_order_info['address'],
					'express_to_location'	=> array(
						'longitude'     => $express_order_info['longitude'],
						'latitude'	    => $express_order_info['latitude'],
					),
					'distance'		=> $express_order_info['distance'],
					'consignee'		=> $express_order_info['consignee'],
					'mobile'		=> $express_order_info['mobile'],
					'order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $express_order_info['add_time']),
					'pay_time'		=> empty($express_order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['pay_time']),
					'best_time'		=> empty($express_order_info['best_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['best_time']),
					'shipping_fee'	=> $express_order_info['shipping_fee'],
					'order_amount'	=> $express_order_info['order_amount'],
				),
			);
			$express_grab = new ExpressGrab($express_data);
			RC_Notification::send($user, $express_grab);
			
			/*推送消息*/
// 			$devic_info = RC_Api::api('mobile', 'device_info', array('user_type' => 'merchant', 'user_id' => $_SESSION['staff_id']));
// 			if (!is_ecjia_error($devic_info) && !empty($devic_info)) {
// 				$push_event = RC_Model::model('push/push_event_viewmodel')->where(array('event_code' => 'express_grab', 'is_open' => 1, 'status' => 1, 'mm.app_id is not null', 'mt.template_id is not null', 'device_code' => $devic_info['device_code'], 'device_client' => $devic_info['device_client']))->find();
// 				if (!empty($push_event)) {
// 					RC_Loader::load_app_class('push_send', 'push', false);
// 					ecjia_admin::$controller->assign('express_info', $express_order_info);
// 					$content = ecjia_admin::$controller->fetch_string($push_event['template_content']);
			
// 					if ($devic_info['device_client'] == 'android') {
// 						$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_ANDROID)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
// 					} elseif ($devic_info['device_client'] == 'iphone') {
// 						$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_IPHONE)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
// 					}
// 				}
// 			}

			//推送消息
			$options = array(
				'user_id'   => $_SESSION['staff_id'],
				'user_type' => 'merchant',
				'event'     => 'express_grab',
				'value' => array(
					'express_sn'   => $express_order_info['express_sn'],
					'service_phone'=> ecjia::config('service_phone'),
				),
				'field' => array(
					'open_type'    => 'admin_message',
				),
			);
			RC_Api::api('push', 'push_event_send', $options);		

			//短信发送
			if (!empty($express_order_info['express_mobile'])) {
				$options = array(
					'mobile' => $express_order_info['express_mobile'],
					'event'	 => 'sms_express_grab',
					'value'  =>array(
						'express_sn'   => $express_order_info['express_sn'],
						'service_phone'=> ecjia::config('service_phone'),
					),
				);
				RC_Api::api('sms', 'send_event_sms', $options);
			}
			
			return array();
		} else {
			return new ecjia_error('grab_error', '此单已被抢！');
		}
	 }	
}

// end