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
 * 商家配送中心
 * @author songqianqina
 */
class merchant extends ecjia_merchant {
	
	public function __construct() {
		parent::__construct();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('bootstrap-fileupload-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
		RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('mh_express_task', RC_App::apps_url('statics/js/mh_express_task.js', __FILE__));
		RC_Script::enqueue_script('mh_express_order_list', RC_App::apps_url('statics/js/mh_express_order_list.js', __FILE__));
		
		RC_Style::enqueue_style('mh_express_task', RC_App::apps_url('statics/css/mh_express_task.css', __FILE__));
		
		RC_Script::enqueue_script('qq_map', ecjia_location_mapjs());
		
        RC_Script::localize_script('mh_express_task', 'js_lang', config('app-express::jslang.express_mh_page'));
        RC_Script::localize_script('mh_express_order_list', 'js_lang', config('app-express::jslang.express_mh_page'));

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('配送管理', 'express'), RC_Uri::url('shipping/mh_shipping/shipping_template')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家配送', 'express'), RC_Uri::url('express/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('express', 'express/merhcant.php');
	}
	
	/**
	 * 任务中心
	 */
	public function init() {
		$this->admin_priv('mh_express_task_manage');
		
		$platform = !empty($_GET['platform']) ? intval($_GET['platform']) : 0;
		$this->assign('platform', $platform);
		
		$title = !empty($platform) ? __('平台配送', 'express') : __('商家配送', 'express');
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($title));
		$this->assign('ur_here', $title);
		
		$type = empty($_GET['type']) ? 'wait_grab' : remove_xss($_GET['type']);
		$this->assign('type', $type);
		
		/*待派单列表*/
		$wait_grab_list = $this->get_wait_grab_list($type, $platform);

		/*第一个订单获取*/
		$first_express_order = $wait_grab_list['list']['0'];
		$first_express_order_id = $first_express_order['express_id'];
		$start = $first_express_order['sf_latitude'].','.$first_express_order['sf_longitude'];
		$end = $first_express_order['latitude'].','.$first_express_order['longitude'];
		$this->assign('start', $start);
		$this->assign('end', $end);
		$this->assign('first_express_id', $first_express_order_id);
		
		/*配送员列表*/
		$keywords = empty($_GET['keywords']) ? '' : remove_xss($_GET['keywords']);
		$express_user_list = $this->get_express_user_list($type, $keywords);
		
		/*配送员列表与第一个订单之间的距离数组*/
		$express_user_dis_data = array();
		if (!empty($express_user_list['list']) && !empty($first_express_order)) {
			foreach ($express_user_list['list'] as $k => $v) {
				if ($v['online_status'] == '1') {
					if (!empty($first_express_order['sf_latitude']) && !empty($first_express_order['sf_longitude'])) {
						//腾讯地图api距离计算
						$keys = ecjia::config('map_qq_key');
						$url = "https://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$first_express_order['sf_latitude'].",".$first_express_order['sf_longitude']."&to=".$v['latitude'].",".$v['longitude']."&key=".$keys;
						$distance_json = file_get_contents($url);
						$distance_info = json_decode($distance_json, true);
						$v['distance'] = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
						$express_user_dis_data[] = $v;
					}
				}
			}
		}
		
		/*过滤掉5公里以外的配送员*/
		foreach ($express_user_dis_data as $key => $val) {
			if ($val['distance'] > 5000) {
				unset($express_user_dis_data[$key]);
			}
		}
		
		/*获取离第一个订单最近的配送员的id*/
		$express_user_dis_data_new = array();
		if ($express_user_dis_data) {
			foreach ($express_user_dis_data as $a => $b) {
				$express_user_dis_data_new[$b['user_id']] =  $b['distance'];
			}
		}
		$hots = $express_user_dis_data_new;
		$key = array_search(min($hots),$hots);
		
		if ($key) {
			$express_info = RC_DB::table('express_user as eu')
				->leftJoin('staff_user as su', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'))
				->select(RC_DB::raw('eu.*'), RC_DB::raw('su.mobile'), RC_DB::raw('su.name'), RC_DB::raw('su.avatar'), RC_DB::raw('su.online_status'))
				->where(RC_DB::raw('su.user_id'), $key)
				->first();
			
			$this->assign('express_info', $express_info);
			$this->assign('has_staff', 1);
		} else {
			$this->assign('has_staff', 0);
		}
		
		$this->assign('search_action', RC_Uri::url('express/merchant/waitgrablist_search_user', array('type' => $type)));
		
		$app_url =  RC_App::apps_url('statics/images', __FILE__);
		$this->assign('app_url', $app_url);
		
		$this->assign('filter', $wait_grab_list['filter']);
		$this->assign('first_express_order', $first_express_order);
		$this->assign('express_order_count', $wait_grab_list['express_order_count']);
		$this->assign('wait_grab_list', $wait_grab_list);
		$this->assign('express_count', $express_user_list['express_count']);
		$this->assign('express_user_list', $express_user_list);

        return $this->display('express_task_list.dwt');
	}
	
	/**
	 * 获取距离当前订单最近的配送员信息
	 */
	public function get_nearest_exuser() {
		$this->admin_priv('mh_express_task_manage');
		
		$sf_lng = remove_xss($_POST['sf_lng']);
		$sf_lat = remove_xss($_POST['sf_lat']);
		/*配送员列表*/
		$express_user_list = $this->get_express_user_list();
		
		/*配送员列表与第一个订单之间的距离数组*/
		$express_user_dis_data = array();
		if (!empty($express_user_list['list']) && !empty($sf_lng) && !empty($sf_lat)) {
			foreach ($express_user_list['list'] as $k => $v) {
				if ($v['online_status'] == '1') {
					if (!empty($sf_lat) && !empty($sf_lng)) {
						//腾讯地图api距离计算
						$keys = ecjia::config('map_qq_key');
						$url = "https://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$sf_lat.",".$sf_lng."&to=".$v['latitude'].",".$v['longitude']."&key=".$keys;
						$distance_json = file_get_contents($url);
						$distance_info = json_decode($distance_json, true);
						$v['distance'] = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
						$express_user_dis_data[] = $v;
					}
				}
			}
		}
		
		/*过滤掉5公里以外的配送员*/
		foreach ($express_user_dis_data as $key => $val) {
			if ($val['distance'] > 5000) {
				unset($express_user_dis_data[$key]);
			}
		}
		
		/*获取离当前订单最近的配送员的id*/
		$express_user_dis_data_new = array();
		if ($express_user_dis_data) {
			foreach ($express_user_dis_data as $a => $b) {
				$express_user_dis_data_new[$b['user_id']] =  $b['distance'];
			}
		}
		$hots = $express_user_dis_data_new;
		$key = array_search(min($hots),$hots);
		
		$express_info = array();
		
		if ($key) {
			$express_info = RC_DB::table('express_user as eu')
			->leftJoin('staff_user as su', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'))
			->select(RC_DB::raw('eu.*'), RC_DB::raw('su.mobile'), RC_DB::raw('su.name'))
			->where(RC_DB::raw('su.user_id'), $key)
			->first();
			$express_info['has_staff'] = 1;
		} else {
			$express_info['has_staff'] = 0;
		}
	
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('express_info' => $express_info));
	}
	
	/**
	 * 指派订单
	 */
	public function assign_express_order() {
		$this->admin_priv('mh_express_task_manage');

		$express_id = intval($_POST['express_id']);
		if (empty($express_id)) {
			return $this->showmessage(__('暂无可指派的订单！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$staff_id = intval($_GET['staff_id']);
		$type 	  = remove_xss($_GET['type']);
		
		$field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.expect_shipping_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.district as sf_district, sf.street as sf_street, sf.address as merchant_address, sf.longitude as sf_longitude, sf.latitude as sf_latitude';
			$dbview = RC_DB::table('express_order as eo')
			->leftJoin('store_franchisee as sf', RC_DB::raw('sf.store_id'), '=', RC_DB::raw('eo.store_id'))
			->leftJoin('order_info as oi', RC_DB::raw('eo.order_id'), '=', RC_DB::raw('oi.order_id'));
			
		$express_order_info	= $dbview->where(RC_DB::raw('eo.express_id'), $express_id)->select(RC_DB::raw('eo.*'), RC_DB::raw('oi.add_time as order_time'), RC_DB::raw('oi.pay_time'), RC_DB::raw('oi.expect_shipping_time'), RC_DB::raw('oi.order_amount'), RC_DB::raw('oi.pay_name'), RC_DB::raw('sf.merchants_name'), RC_DB::raw('sf.district as sf_district'), RC_DB::raw('sf.street as sf_street'), RC_DB::raw('sf.address as merchant_address'), RC_DB::raw('sf.longitude as sf_longitude'), RC_DB::raw('sf.latitude as sf_latitude'))->first();
		$staff_user_info = RC_DB::table('staff_user as su')->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'))
							->where(RC_DB::raw('su.user_id'), $staff_id)
							->select(RC_DB::raw('su.name'), RC_DB::raw('su.mobile'), RC_DB::raw('su.store_id'), RC_DB::raw('eu.shippingfee_percent'))->first();

		$commision = $staff_user_info['shippingfee_percent']/100 * $express_order_info['shipping_fee'];
		$commision = sprintf("%.2f", $commision);
		$data = array(
				'from' 			=> 'assign',
				'status'		=> 1,
				'staff_id'		=> $staff_id,
				'express_user'	=> $staff_user_info['name'],
				'express_mobile'=> $staff_user_info['mobile'],
				'commision'		=> $commision,
				'commision_status'	=> 0,
				'receive_time'	=> RC_Time::gmtime()
		);
	
		$update = RC_DB::table('express_order')->where('express_id', $express_id)->update($data);
		
		/*指派后*/
		if ($staff_id > 0) {
			/* 消息插入 */
			$orm_staff_user_db = RC_Model::model('orders/orm_staff_user_model');
			$user = $orm_staff_user_db->find($staff_id);
			$express_mobile = RC_DB::table('express_order')->where('staff_id', $staff_id)->value('express_mobile');
			/* 派单发短信 */
			if (!empty($express_mobile)) {
				$options = array(
						'mobile' => $express_mobile,
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
					'title'	=> __('系统派单', 'express'),
					'body'	=> __('有单啦！系统已分配配送单到您账户，赶快行动起来吧！', 'express'),
					'data'	=> array(
							'express_id'			=> $express_order_info['express_id'],
							'express_sn'			=> $express_order_info['express_sn'],
							'express_type'			=> $express_order_info['from'],
							'label_express_type'	=> $express_order_info['from'] == 'assign' ? __('系统派单', 'express') : __('抢单', 'express'),
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
							'best_time'		=> $express_order_info['expect_shipping_time'],
							'shipping_fee'	=> $express_order_info['shipping_fee'],
							'order_amount'	=> $express_order_info['order_amount'],
					),
			);
			$express_assign = new ExpressAssign($notification_express_data);
			RC_Notification::send($user, $express_assign);
		}
	
		if ($type == 'wait_grab') {
			return $this->showmessage(__('指派订单成功！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('express/merchant/init', array('type' => $type))));
		} else {
			return $this->showmessage(__('指派订单成功！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS , array('pjaxurl' => RC_Uri::url('express/merchant/wait_pickup', array('type' => $type))));
		}
	}
	
	/**
	 * 查看订单详情
	 */
	public function express_order_detail() {
		$this->admin_priv('mh_express_task_manage');
	
		$express_id = intval($_GET['express_id']);
		$type = remove_xss($_GET['type']);
		
		$platform = intval($_GET['platform']);
		$this->assign('platform', $platform);
		
		$express_info = RC_DB::table('express_order')->where('express_id', $express_id)->select('store_id','order_id', 'order_sn', 'delivery_id', 'delivery_sn', 'user_id', 'mobile', 'consignee', 'express_sn', 'distance', 'shipping_fee', 'commision','express_user','express_mobile','from','signed_time','province as eoprovince','city as eocity','district as eodistrict','street as eostreet','address as eoaddress')->first();
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $express_info['store_id'])->select('merchants_name','contact_mobile','province','city','district','street','address')->first();
		//$users_info = RC_DB::table('users')->where('user_id', $express_info['user_id'])->select('user_name','mobile_phone')->first();
		$order_info = RC_DB::table('order_info')->where('order_id', $express_info['order_id'])->select('add_time','expect_shipping_time','postscript')->first();
		//$goods_list = RC_DB::table('order_goods')->where('order_id', $express_info['order_id'])->select('goods_id', 'goods_name' ,'goods_price','goods_number')->get();
		/*配送单对应的发货单商品*/
		$goods_list = RC_DB::table('delivery_goods')->where('delivery_id', $express_info['delivery_id'])->select(RC_DB::raw('goods_id'), RC_DB::raw('goods_name'), RC_DB::raw('send_number'))->get();
		
		foreach ($goods_list as $key => $val) {
			$goods_list[$key]['image']  				= RC_DB::table('goods')->where('goods_id', $val['goods_id'])->value('goods_thumb');
			$goods_list[$key]['goods_price']			= RC_DB::table('order_goods')->where('order_id', $express_info['order_id'])->where('goods_id', $val['goods_id'])->value('goods_price');
			$goods_list[$key]['formated_goods_price']	= price_format($goods_list[$key]['goods_price']);
		}
		$disk = RC_Filesystem::disk();
		foreach ($goods_list as $key => $val) {
			if (!$disk->exists(RC_Upload::upload_path($val['image'])) || empty($val['image'])) {
				$goods_list[$key]['image'] = RC_Uri::admin_url('statics/images/nopic.png');
			} else {
				$goods_list[$key]['image'] = RC_Upload::upload_url($val['image']);
			}
		}
		
		$content = array_merge($express_info,$store_info,$order_info);
		$content['district']      		= ecjia_region::getRegionName($content['district']);
		$content['street']        		= ecjia_region::getRegionName($content['street']);
		$content['eoprovince']    		= ecjia_region::getRegionName($content['eoprovince']);
		$content['eocity']        		= ecjia_region::getRegionName($content['eocity']);
		$content['eodistrict']    		= ecjia_region::getRegionName($content['eodistrict']);
		$content['eostreet']      		= ecjia_region::getRegionName($content['eostreet']);
		$content['add_time']  	  		= RC_Time::local_date('Y-m-d H:i:s', $content['add_time']);
		$content['signed_time']   		= RC_Time::local_date('Y-m-d H:i', $content['signed_time']);
		$content['all_address'] 		= $content['district'].$content['street'];
		$content['express_all_address'] = $content['eodistrict'].$content['eostreet'];

		$this->assign('type', $type);
		$this->assign('content', $content);
		$this->assign('goods_list', $goods_list);

        $show_taked_ship = false;
        if ($type == 'wait_pickup') {
            $show_taked_ship = true;
        }
        $this->assign('show_taked_ship', $show_taked_ship);

		$data = $this->fetch('express_order_detail.dwt');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	

	/**
	 * 待取货和配送中列表
	 */
	public function wait_pickup() {
		$this->admin_priv('mh_express_task_manage');
	
		$platform = !empty($_GET['platform']) ? intval($_GET['platform']) : 0;
		$this->assign('platform', $platform);
		
		$title = !empty($platform) ? __('平台配送', 'express') : __('商家配送', 'express');
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($title));
		$this->assign('ur_here', $title);
	
		$type = empty($_GET['type']) ? 'wait_pickup' : remove_xss($_GET['type']);
		$keywords = empty($_GET['keywords']) ? '' : remove_xss($_GET['keywords']);
		$this->assign('type', $type);
	
		/*待取货列表*/
		$wait_pickup_list = $this->get_wait_grab_list($type, $platform);
		$this->assign('search_action', RC_Uri::url('express/merchant/wait_pickup'));
		
		$this->assign('express_order_count', $wait_pickup_list['express_order_count']);
		$this->assign('filter', $wait_pickup_list['filter']);
		
		$this->assign('wait_pickup_list', $wait_pickup_list);

        return $this->display('express_order_wait_pickup.dwt');
	}
	
	/**
	 * 查看当前位置
	 */
	public function express_location() {
		$this->admin_priv('mh_express_task_manage');
	
		$express_id = intval($_GET['express_id']);
		$store_id   = intval($_GET['store_id']);
		$type = remove_xss($_GET['type']);
	
		$express_info = RC_DB::table('express_order as eo')
							->leftJoin('express_user as eu', RC_DB::raw('eo.staff_id'), '=', RC_DB::raw('eu.user_id'))
							->where(RC_DB::raw('eo.express_id'), $express_id)	
							->select(RC_DB::raw('eo.express_user'), RC_DB::raw('eo.express_mobile'), RC_DB::raw('eo.longitude as u_longitude'), RC_DB::raw('eo.latitude as u_latitude'), RC_DB::raw('eu.longitude as eu_longitude'), RC_DB::raw('eu.latitude as eu_latitude'))
							->first();
		
		$store_info =  RC_DB::table('store_franchisee')->where('store_id', $store_id)->select(RC_DB::raw('longitude as sf_longitude'), RC_DB::raw('latitude as sf_latitude'))->first();
		
		$content = array_merge($express_info, $store_info);
		
		$content['start'] =  $content['sf_latitude'].','.$content['sf_longitude'];
		$content['end']   =  $content['u_latitude'].','.$content['u_longitude'];
		
		$this->assign('content', $content);
	
		$data = $this->fetch('express_current_location.dwt');
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	/**
	 * 订单重新指派
	 */
	public function express_reasign_detail() {
		$this->admin_priv('mh_express_task_manage');
	
		$express_id = intval($_GET['express_id']);
		$store_id   = intval($_GET['store_id']);
		$type       = remove_xss($_GET['type']);
		
		$express_info = RC_DB::table('express_order as eo')
		->leftJoin('express_user as eu', RC_DB::raw('eo.staff_id'), '=', RC_DB::raw('eu.user_id'))
		->where(RC_DB::raw('eo.express_id'), $express_id)
		->select(RC_DB::raw('eo.express_user'), RC_DB::raw('eo.express_mobile'), RC_DB::raw('eo.longitude as u_longitude'), RC_DB::raw('eo.latitude as u_latitude'), RC_DB::raw('eu.longitude as eu_longitude'), RC_DB::raw('eu.latitude as eu_latitude'))
		->first();
	
		$store_info =  RC_DB::table('store_franchisee')->where('store_id', $store_id)->select(RC_DB::raw('longitude as sf_longitude'), RC_DB::raw('latitude as sf_latitude'))->first();
	
		$content = array_merge($express_info, $store_info);
	
		$content['start'] =  $content['sf_latitude'].','.$content['sf_longitude'];
		$content['end']   =  $content['u_latitude'].','.$content['u_longitude'];
		
		/*配送员列表*/
		$express_user_list = $this->get_express_user_list($type);
		$this->assign('express_user_list', $express_user_list);
		$this->assign('express_count', $express_user_list['express_count']);
		$app_url =  RC_App::apps_url('statics/images', __FILE__);
		$this->assign('app_url', $app_url);
		$this->assign('type', $type);
		$this->assign('content', $content);
		$this->assign('express_id', $express_id);
		
		$this->assign('search_action', RC_Uri::url('express/merchant/reassign_search_user', array('type' => $type)));
		
		$data = $this->fetch('express_order_reassign.dwt');
	
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	/**
	 * 待派单列表页搜索配送员
	 */
	public function waitgrablist_search_user() {
		$this->admin_priv('mh_express_task_manage');
		
		$type = remove_xss($_GET['type']);
		
		/*配送员列表*/
		$express_user_list = $this->get_express_user_list();
	
		$this->assign('express_user_list', $express_user_list);

		$wait_pickup_list = $this->get_wait_grab_list($type);
		
		$this->assign('express_order_count', $wait_pickup_list['express_order_count']);
	
		$this->assign('express_count', $express_user_list['express_count']);
		$app_url =  RC_App::apps_url('statics/images', __FILE__);
		$this->assign('app_url', $app_url);
		$this->assign('type', $type);
		$this->assign('search_action', RC_Uri::url('express/merchant/waitgrablist_search_user', array('type' => $type)));
		$data = $this->fetch('waitgrablist_search_user_list.dwt');
	
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	
	/**
	 * 重新指派页搜索配送员
	 */
	public function reassign_search_user() {
		$this->admin_priv('mh_express_task_manage');
		
		$type = remove_xss($_GET['type']);
		$keywords = remove_xss($_GET['keywords']);
		
 		/*配送员列表*/
		$express_user_list = $this->get_express_user_list($type, $keywords);
	
		$this->assign('express_user_list', $express_user_list);
		
		$this->assign('express_count', $express_user_list['express_count']);
		$app_url =  RC_App::apps_url('statics/images', __FILE__);
		$this->assign('app_url', $app_url);
		$this->assign('type', $type);
		$this->assign('search_action', RC_Uri::url('express/merchant/reassign_search_user', array('type' => $type)));
		
		$data = $this->fetch('reassign_express_user_list.dwt');
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}

    public function taked_ship() {
        /* 检查权限 */
        $this->admin_priv('mh_express_task_manage', ecjia::MSGTYPE_JSON);

        $delivery_sn = remove_xss($_POST['sn']);
        if (empty($delivery_sn)) {
            return $this->showmessage(__('配送单号不能为空', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
       

        $express_order = array();
        //$express_order_db = RC_Model::model('express/express_order_viewmodel');
        //$where = array('eo.store_id' => $_SESSION['store_id'], 'eo.express_sn' => $delivery_sn, 'eo.status' => 1, 'eo.shipping_code' => 'ship_o2o_express');
        //$field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.district as sf_district, sf.street as sf_street, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
        //$express_order_info = $express_order_db->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->find();
        $express_order_db = RC_DB::table('express_order as eo')
        						->leftJoin('store_franchisee as sf', RC_DB::raw('sf.store_id'), '=', RC_DB::raw('eo.store_id'))
        						->leftJoin('order_info as oi', RC_DB::raw('eo.order_id'), '=', RC_DB::raw('oi.order_id'));

        $platform = intval($_GET['platform']); //1平台配送
        $shipping_code = !empty($platform) ? 'ship_ecjia_express' : 'ship_o2o_express';

        $express_order_db->where(RC_DB::raw('eo.store_id'), $_SESSION['store_id'])
        	->where(RC_DB::raw('eo.express_sn'), $delivery_sn)
        	->where(RC_DB::raw('eo.status'), 1)
        	->where(RC_DB::raw('eo.shipping_code'), $shipping_code);
        
        $field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.district as sf_district, sf.street as sf_street, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
        $express_order_info = $express_order_db->select(RC_DB::raw($field))->first();

        if (empty($express_order_info)) {
            return $this->showmessage(__('此配送单不存在！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } elseif ($express_order_info['status'] > 1) {
            return $this->showmessage(__('此单已被取走！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } elseif ($express_order_info['store_id'] != $_SESSION['store_id']) {
            return $this->showmessage(__('此配送单不属于当前商家！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } elseif (empty($express_order_info['staff_id']) || $express_order_info['status'] == '0') {
            return $this->showmessage(__('此配送单并未有配送员接单！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //$where = array('store_id' => $_SESSION['store_id'], 'staff_id' => $express_order_info['staff_id'], 'express_sn' => $delivery_sn);
        //RC_Model::model('express/express_order_model')->where($where)->update(array('status' => 2, 'express_time' => RC_Time::gmtime()));
        RC_DB::table('express_order')->where('store_id', $_SESSION['store_id'])
        							 ->where('staff_id', $express_order_info['staff_id'])
        							 ->where('express_sn', $delivery_sn)
        							 ->update(array('status' => 2, 'express_time' => RC_Time::gmtime()));

        /*当订单配送方式为o2o速递时,记录o2o速递物流信息*/
        $order_info = RC_DB::table('order_info')->where('order_id', $express_order_info['order_id'])->first();
        if ($order_info['shipping_id'] > 0) {
            $shipping_info = ecjia_shipping::pluginData($order_info['shipping_id']);
            if ($shipping_info['shipping_code'] == 'ship_o2o_express' || $shipping_info['shipping_code'] == 'ship_ecjia_express') {
                $data = array(
                    'express_code' => $shipping_info['shipping_code'],
                    'track_number' => $order_info['invoice_no'],
                    'time' => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()),
                    'context' => __('配送员已取货，正在向您奔去，配送员：', 'express') . $express_order_info['express_user'],
                );
                RC_DB::table('express_track_record')->insert($data);
                //订单状态log记录
                RC_DB::table('order_status_log')->insert(array(
                	'order_status'	=> __('配送员已取货', 'express'),
               		'order_id'		=> $express_order_info['order_id'],
                	'message'		=> __('配送员已取货，正在向您奔去，配送员：', 'express').$express_order_info['express_user'],
                	'add_time'		=> RC_Time::gmtime(),
                ));
            }
        }
        $url = RC_Uri::url('express/merchant/wait_pickup', array('type' => 'wait_pickup'));
        if (!empty($platform)) {
      		$url = RC_Uri::url('express/merchant/wait_pickup', array('type' => 'wait_pickup', 'platform' => 1));
        }
        return $this->showmessage(__('操作成功', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
    }

    //提醒指派
    public function remind_assign() {
    	$express_id = intval($_GET['id']);
    	$express_sn = RC_DB::table('express_order')->where('express_id', $express_id)->where('store_id', $_SESSION['store_id'])->value('express_sn');
    	if (empty($express_sn)) {
    		return $this->showmessage(__('该配送单不存在', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$count = RC_DB::table('express_order_reminder')->where('express_id', $express_id)->count();
    	if ($count != 0) {
    		return $this->showmessage(__('该配送单已提醒过平台派单，请勿重复提醒！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$data = array(
    		'express_id' 	=> $express_id,
    		'message'  		=> '商家【'.$_SESSION['store_name'].'】'.'正在进行派单提醒,配送单号:'.$express_sn.'，请赶快派单吧！',
    		'status'   		=> 0,
    		'create_time' 	=> RC_Time::gmtime(),
    	);
    	RC_DB::table('express_order_reminder')->insert($data);
    	
    	return $this->showmessage(__('已提醒平台派单', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
	/**
	 * 待派单列表
	 */
	private function get_wait_grab_list($type = '', $platform = 0){
		$dbview = RC_DB::table('express_order as eo')
					->leftJoin('store_franchisee as sf', RC_DB::raw('eo.store_id'), '=', RC_DB::raw('sf.store_id'));
		
		$dbview->where(RC_DB::raw('eo.store_id'), $_SESSION['store_id']);
		if (!empty($platform)) {
			$dbview->where(RC_DB::raw('eo.shipping_code'), 'ship_ecjia_express');
		} else {
			$dbview->where(RC_DB::raw('eo.shipping_code'), 'ship_o2o_express');
		}
		$field = 'eo.consignee, eo.mobile as consignee_mobile, eo.express_id, eo.store_id, eo.express_sn, eo.country, eo.province, eo.city, eo.district, eo.street, eo.address, eo.distance, eo.add_time, 
				  eo.longitude, eo.latitude, eo.express_user, eo.express_mobile, eo.staff_id, eo.from, eo.receive_time, sf.province as sf_province, sf.city as sf_city, sf.longitude as sf_longitude, sf.latitude as sf_latitude, 
				  sf.district as sf_district, sf.street as sf_street, sf.address as sf_address';
		
		$filter['keywords']	= empty($_GET['keywords']) ? '' : remove_xss($_GET['keywords']);
		$filter['type'] 	= empty($type) ? 'wait_grab' : $type;
		
		$db = RC_DB::table('express_order');
		$db->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		if (!empty($platform)) {
			$db->where('shipping_code', 'ship_ecjia_express');
		} else {
			$db->where('shipping_code', 'ship_o2o_express');
		}
		
		$keywords = $filter['keywords'];
		if ($type != 'wait_grab') {
			if (!empty($filter['keywords'])) {
				$db->where(function($query) use ($keywords) {
					$query->where('express_user', 'like', '%'.mysql_like_quote($keywords).'%')->orWhere('express_sn', 'like', '%'.mysql_like_quote($keywords).'%');
				});
			}
		}
		
		$express_order_count = $db
		->select(RC_DB::raw('count(*) as count'), RC_DB::raw('SUM(IF(status = 0, 1, 0)) as wait_grab'), RC_DB::raw('SUM(IF(status = 1, 1, 0)) as wait_pickup'), RC_DB::raw('SUM(IF(status = 2, 1, 0)) as sending'))
		->first();
	
		if ($type == 'wait_grab') {
			$dbview->where(RC_DB::raw('eo.status'), 0);
		} elseif ($type == 'wait_pickup') {
			$dbview->where(RC_DB::raw('eo.status'), 1);
		} elseif ($type == 'sending') {
			$dbview->where(RC_DB::raw('eo.status'), 2);
		}
		
		if (!empty($filter['keywords'])) {
			$dbview->where(function($query) use ($keywords) {
				$query->where(RC_DB::raw('eo.express_user'), 'like', '%'.mysql_like_quote($keywords).'%')->orWhere(RC_DB::raw('eo.express_sn'), 'like', '%'.mysql_like_quote($keywords).'%');
			});
		}
		
		$count = $dbview->count();
		$page = new ecjia_merchant_page($count, 10, 5);
		
		$list = $dbview->select(RC_DB::raw($field))
			->orderBy(RC_DB::raw('eo.add_time'), 'desc')
			->take(10)
			->skip($page->start_id-1)
			->get();
		
		$data = array();
		if (!empty($list)) {
			foreach ($list as $row) {
				if ($type !='wait_grab') {
					if ($row['staff_id'] > 0) {
						$row['online_status'] = RC_DB::table('staff_user')->where('user_id', $row['staff_id'])->value('online_status');
					}
				}
				$row['format_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
				$row['format_receive_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['receive_time']);
				$row['from_address'] 	= ecjia_region::getRegionName($row['sf_district']).ecjia_region::getRegionName($row['sf_street']).$row['sf_address'];
				$row['to_address']		= ecjia_region::getRegionName($row['district']).ecjia_region::getRegionName($row['street']).$row['address'];
				$data[] = $row;
			}
		}
		
		$res = array('list' => $data, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'express_order_count' => $express_order_count);
		return $res;
	}

	
	/**
	 * 配送员列表
	 */
	private function get_express_user_list($type ='', $keywords ='') {
		$express_user_view =  RC_DB::table('staff_user as su')
		->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'));
		$express_user_view->where(RC_DB::raw('su.store_id'), $_SESSION['store_id']);
		$express_user_view->where(RC_DB::raw('su.group_id'), Ecjia\App\Staff\StaffGroupConstant::GROUP_EXPRESS);
		$keywords = remove_xss($_GET['keywords']);
		if (!empty($keywords)) {
			$express_user_view ->whereRaw('(su.name  like  "%'.mysql_like_quote($keywords).'%")');
		}
		
		
		$db = RC_DB::table('staff_user as su')
		->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'));
		$db->where(RC_DB::raw('su.store_id'), $_SESSION['store_id']);
		$db->where(RC_DB::raw('su.group_id'), Ecjia\App\Staff\StaffGroupConstant::GROUP_EXPRESS);
		
		if (!empty($keywords)) {
			$db ->whereRaw('(su.name  like  "%'.mysql_like_quote($keywords).'%")');
		}
		
		if (!empty($type)) {
			if ($type == 'online') {
				$express_user_view->where(RC_DB::raw('su.online_status'), 1);
				$db->where(RC_DB::raw('su.online_status'), 1);
			} elseif ($type == 'offline') {
				$express_user_view->where(RC_DB::raw('su.online_status'), 4);
				$db->where(RC_DB::raw('su.online_status'), 1);
			}
		}
		
		$express_user_count = $db
		->where(RC_DB::raw('su.store_id'), $_SESSION['store_id'])
		->select(RC_DB::raw('count(*) as count'),RC_DB::raw('SUM(IF(su.online_status = 1, 1, 0)) as online'),RC_DB::raw('SUM(IF(su.online_status = 4, 1, 0)) as offline'))
		->first();
		
		$list = $express_user_view->select(RC_DB::raw('eu.*'), RC_DB::raw('su.mobile'), RC_DB::raw('su.name'), RC_DB::raw('su.avatar'), RC_DB::raw('su.online_status'))->orderBy('online_status', 'asc')->get();
		$data = array();
		if (!empty($list)) {
			foreach ($list as $row) {
				$count = RC_DB::table('express_order')->where('staff_id', $row['user_id'])->select(RC_DB::raw('count(*) as count'),RC_DB::raw('SUM(IF(status = 1, 1, 0)) as wait_pickup'),RC_DB::raw('SUM(IF(status = 2, 1, 0)) as sending'))->first();
				$row['avatar'] = empty($row['avatar']) ? '' : RC_Upload::upload_url($row['avatar']);
				$row['wait_pickup_count'] = $count['wait_pickup'];
				$row['sending_count'] = $count['sending'];
				$data[] = $row;
			}
		}
		
		$result = array('list' => $data, 'express_count' => $express_user_count);
		
		return $result;
	}
}

//end