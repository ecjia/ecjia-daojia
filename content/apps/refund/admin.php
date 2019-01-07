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
 * 退货退款管理
 * @author songqianqian
 */
class admin extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_class('RefundReasonList', 'refund', false);
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url() . '/statics/lib/dropper-upload/jquery.fs.dropper.js', array(), false, true);
		RC_Script::enqueue_script('jquery-imagesloaded');
		RC_Script::enqueue_script('jquery-colorbox');
		RC_Style::enqueue_style('jquery-colorbox');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');

		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');

		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));

		//时间控件
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));

		RC_Script::enqueue_script('admin_refund', RC_App::apps_url('statics/js/admin_refund.js', __FILE__));
		RC_Script::enqueue_script('admin_payrecord', RC_App::apps_url('statics/js/admin_payrecord.js', __FILE__));
		RC_Style::enqueue_style('admin_refund', RC_App::apps_url('statics/css/admin_refund.css', __FILE__));
		RC_Style::enqueue_style('admin_payrecord', RC_App::apps_url('statics/css/admin_payrecord.css', __FILE__));
		
		RC_Loader::load_app_class('OrderInfo', 'refund', false);
		RC_Loader::load_app_class('RefundOrderInfo', 'refund', false);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('售后列表', RC_Uri::url('refund/admin/init')));
	}
	
	/**
	 * 售后列表页
	 */
	public function init() {
		$this->admin_priv('refund_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('售后列表'));
		$this->assign('ur_here', '售后列表');
		
		$data = $this->refund_list();
		$this->assign('data', $data);
		$this->assign('filter', $data['filter']);
		
		$this->assign('search_action', RC_Uri::url('refund/admin/init'));
		
		$this->display('refund_list.dwt');
	}
	
	/**
	 * 退款-----查看详情
	 */
	public function refund_detail() {
		$this->admin_priv('refund_manage');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('退款服务'));
		$this->assign('ur_here', '退款服务');
		
		$this->assign('action_link', array('text' => '售后列表', 'href' => RC_Uri::url('refund/admin/init')));
	
		$refund_id = intval($_GET['refund_id']);
		$this->assign('refund_id', $refund_id);
	
		//售后订单信息
		$refund_info = RefundOrderInfo::get_refund_order_info($refund_id);
		$this->assign('refund_info', $refund_info);
				
		//获取用户退货退款原因
		$reason_list = RefundReasonList::get_refund_reason();
		$this->assign('reason_list', $reason_list);
		
		//退款上传凭证素材
		$refund_img_list = RC_DB::table('term_attachment')->where('object_id', $refund_id)->where('object_app', 'ecjia.refund')->where('object_group','refund')->select('file_path','file_name')->get();
		$this->assign('refund_img_list', $refund_img_list);
	
		//店铺信息
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $refund_info['store_id'])->select('merchants_name','province','city','district','street','address')->first();  
		$mer_info['merchants_name'] = $store_info['merchants_name'];
		$mer_info['address'] = ecjia_region::getRegionName($store_info['province']).ecjia_region::getRegionName($store_info['city']).ecjia_region::getRegionName($store_info['district']).ecjia_region::getRegionName($store_info['street']).$store_info['address'];
		$shop_trade_time = RC_DB::table('merchants_config')->where('store_id', $refund_info['store_id'])->where('code', 'shop_trade_time')->pluck('value');
		$mer_info['shop_trade_time'] = unserialize($shop_trade_time);
		$mer_info['img'] = 	RC_DB::table('merchants_config')->where('store_id',$refund_info['store_id'])->where('code', 'shop_logo')->pluck('value');
		$mer_info['shop_kf_mobile'] = RC_DB::table('merchants_config')->where('store_id',$refund_info['store_id'])->where('code', 'shop_kf_mobile')->pluck('value');
		$mer_info['count'] = RC_DB::table('refund_order')->where('store_id', $refund_info['store_id'])
							->select(RC_DB::raw('SUM(IF(refund_type = "refund", 1, 0)) as refund_count'),RC_DB::raw('SUM(IF(refund_type = "return", 1, 0)) as return_count'))
							->first();
		$this->assign('mer_info', $mer_info);
		
		
		//退款售后订单关联通订单信息
		$is_order = RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->first();
		if (!empty($is_order)) {
			$order_info = OrderInfo::get_order_info($refund_info['order_id']);
			$this->assign('order_info', $order_info);
			
			//普通订单实付金额
			$order_money_total = OrderInfo::order_money_total($refund_info['order_id']);
			$this->assign('order_money_total', $order_money_total);
			
			$this->assign('order_data', 'order_data');
		} 
		
		//退费计算
		$refund_total_amount  = price_format($refund_info['money_paid'] + $refund_info['surplus']);
		$this->assign('refund_total_amount', $refund_total_amount);
		
		//送货商品信息
		$goods_list = OrderInfo::get_goods_list($refund_info['order_id']);
		$this->assign('goods_list', $goods_list);
		
		//商家审核操作记录
		$action_mer_msg = RC_DB::table('refund_order_action')->where('action_user_type', 'merchant')->where('refund_id', $refund_info['refund_id'])->where('status', $refund_info['status'])->select('action_note','action_user_name','log_time')->first();
		if ($action_mer_msg['log_time']) {
			$action_mer_msg['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $action_mer_msg['log_time']);
		}
		$this->assign('action_mer_msg', $action_mer_msg);
	
		//平台审核操作记录
		if ($refund_info['refund_status'] == '2') {
			$action_admin_msg = RC_DB::table('refund_order_action')->where('action_user_type', 'admin')->where('refund_id', $refund_info['refund_id'])->where('refund_status', $refund_info['refund_status'])->select('action_note','action_user_name','log_time')->first();
			if ($action_admin_msg['log_time']) {
				$action_admin_msg['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $action_admin_msg['log_time']);
			}
			$this->assign('action_admin_msg', $action_admin_msg);
		}
	
		//平台打款信息
		$payrecord_info = RC_DB::table('refund_payrecord')->where('refund_id', $refund_info['refund_id'])->first();
		if ($payrecord_info['action_back_time']) {
			$payrecord_info['action_back_time'] = RC_Time::local_date(ecjia::config('time_format'), $payrecord_info['action_back_time']);
		}
		$payrecord_info['order_money_paid_type'] = price_format($payrecord_info['order_money_paid']);
		$payrecord_info['back_money_total_type'] = price_format($payrecord_info['back_money_total']);
		$payrecord_info['back_pay_fee_type'] 	 = price_format($payrecord_info['back_pay_fee']);
		$payrecord_info['back_shipping_fee_type']= price_format($payrecord_info['back_shipping_fee']);
		$payrecord_info['back_insure_fee_type']  = price_format($payrecord_info['back_insure_fee']);
		$payrecord_info['back_inv_tax_type']  = price_format($payrecord_info['back_inv_tax']);
		$this->assign('payrecord_info', $payrecord_info);
	
		$this->display('refund_detail.dwt');
	}
	
	/**
	 * 退款退货-----查看详情
	 */
	public function return_detail() {
		$this->admin_priv('refund_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('退货退款服务'));
		$this->assign('ur_here', '退货退款服务');
		
		$this->assign('action_link', array('text' => '售后列表', 'href' => RC_Uri::url('refund/admin/init')));
		
		$refund_id = intval($_GET['refund_id']);
		$this->assign('refund_id', $refund_id);
		
		//售后订单信息
		$refund_info = RefundOrderInfo::get_refund_order_info($refund_id);
		if ($refund_info['return_shipping_range']) {
			$return_shipping_range = explode(",",$refund_info['return_shipping_range']);
			foreach($return_shipping_range as $key=>$val){
				if($val == 'home'){
					$return_shipping_range[$key] ='上门取件';
				} elseif($val == 'express'){
					$return_shipping_range[$key] ='自选快递';
				} elseif($val == 'shop'){
					$return_shipping_range[$key] ='到店退货';
				}
			}
			$range = implode(" ",$return_shipping_range);
		}
		$this->assign('range', $range);
		$this->assign('refund_info', $refund_info);
		
		$return_shipping_value = unserialize($refund_info['return_shipping_value']);
		$this->assign('return_shipping_value', $return_shipping_value);
		
		//获取用户退货退款原因
		$reason_list = RefundReasonList::get_refund_reason();
		$this->assign('reason_list', $reason_list);
		
		//退款上传凭证素材
		$refund_img_list = RC_DB::table('term_attachment')->where('object_id', $refund_info['refund_id'])->where('object_app', 'ecjia.refund')->where('object_group','refund')->select('file_path','file_name')->get();
		$this->assign('refund_img_list', $refund_img_list);
		
		//店铺信息
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $refund_info['store_id'])->select('merchants_name','province','city','district','street','address')->first();
		$mer_info['merchants_name'] = $store_info['merchants_name'];
		$mer_info['address'] = ecjia_region::getRegionName($store_info['province']).ecjia_region::getRegionName($store_info['city']).ecjia_region::getRegionName($store_info['district']).ecjia_region::getRegionName($store_info['street']).$store_info['address'];
		$shop_trade_time = RC_DB::table('merchants_config')->where('store_id', $refund_info['store_id'])->where('code', 'shop_trade_time')->pluck('value');
		$mer_info['shop_trade_time'] = unserialize($shop_trade_time);
		$mer_info['img'] = 	RC_DB::table('merchants_config')->where('store_id',$refund_info['store_id'])->where('code', 'shop_logo')->pluck('value');
		$mer_info['shop_kf_mobile'] = RC_DB::table('merchants_config')->where('store_id',$refund_info['store_id'])->where('code', 'shop_kf_mobile')->pluck('value');
		$mer_info['count'] = RC_DB::table('refund_order')->where('store_id', $refund_info['store_id'])
		->select(RC_DB::raw('SUM(IF(refund_type = "refund", 1, 0)) as refund_count'),RC_DB::raw('SUM(IF(refund_type = "return", 1, 0)) as return_count'))
		->first();
		$this->assign('mer_info', $mer_info);
		
		//退款售后订单关联通订单信息
		$order_info = OrderInfo::get_order_info($refund_info['order_id']);
		$this->assign('order_info', $order_info);
		
		//退款售后订单关联通订单信息
		$is_order = RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->first();
		if (!empty($is_order)) {
			$order_info = OrderInfo::get_order_info($refund_info['order_id']);
			$this->assign('order_info', $order_info);
		
			//普通订单实付金额
			$order_money_total = OrderInfo::order_money_total($refund_info['order_id']);
			$this->assign('order_money_total', $order_money_total);
		
			$this->assign('order_data', 'order_data');
		}
		//退费计算
		$refund_total_amount  = price_format($refund_info['money_paid'] + $refund_info['surplus']);
		$this->assign('refund_total_amount', $refund_total_amount);
		
		//送货商品信息
		$goods_list = OrderInfo::get_goods_list($refund_info['order_id']);
		$this->assign('goods_list', $goods_list);
		
		//退货商品
		$refund_list = RC_DB::table('refund_goods')->where('refund_id', $refund_info['refund_id'])->get();
		foreach ($refund_list as $key => $val) {
			$refund_list[$key]['image']  = RC_DB::table('goods')->where('goods_id', $val['goods_id'])->pluck('goods_thumb');
			$goods_price = RC_DB::table('order_goods')->where('goods_id', $val['goods_id'])->where('order_id', $refund_info['order_id'])->pluck('goods_price');
			$refund_list[$key]['goods_price']  = price_format($goods_price);
		}
		$disk = RC_Filesystem::disk();
		foreach ($refund_list as $key => $val) {
			if (!$disk->exists(RC_Upload::upload_path($val['image'])) || empty($val['image'])) {
				$refund_list[$key]['image'] = RC_Uri::admin_url('statics/images/nopic.png');
			} else {
				$refund_list[$key]['image'] = RC_Upload::upload_url($val['image']);
			}
		}
		$this->assign('refund_list', $refund_list);
		
		//商家审核操作记录
		$action_mer_msg_return = RC_DB::table('refund_order_action')->where('action_user_type','merchant')->where('refund_id', $refund_info['refund_id'])->where('status', $refund_info['status'])->select('action_note','action_user_name','log_time')->first();
		if(!empty($action_mer_msg_return['log_time'])) {
			$action_mer_msg_return['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $action_mer_msg_return['log_time']);
		}
		$this->assign('action_mer_msg_return', $action_mer_msg_return);
		
		$action_mer_msg_confirm = RC_DB::table('refund_order_action')->where('action_user_type','merchant')->where('refund_id', $refund_info['refund_id'])->where('return_status',$refund_info['return_status'])->select('action_note','action_user_name','log_time')->first();
		if(!empty($action_mer_msg_confirm['log_time'])) {
			$action_mer_msg_confirm['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $action_mer_msg_confirm['log_time']);
		}
		$this->assign('action_mer_msg_confirm', $action_mer_msg_confirm);
		
		//平台审核操作记录
		if ($refund_info['refund_status'] == '2') {
			$action_admin_msg = RC_DB::table('refund_order_action')->where('refund_id', $refund_info['refund_id'])->where('refund_status', $refund_info['refund_status'])->select('action_note','action_user_name','log_time')->first();
			if ($action_admin_msg['log_time']) {
				$action_admin_msg['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $action_admin_msg['log_time']);
			}
			$this->assign('action_admin_msg', $action_admin_msg);
		}
		
		//平台打款信息
		$payrecord_info = RC_DB::table('refund_payrecord')->where('refund_id', $refund_info['refund_id'])->first();
		if ($payrecord_info['action_back_time']) {
			$payrecord_info['action_back_time'] = RC_Time::local_date(ecjia::config('time_format'), $payrecord_info['action_back_time']);
		}
		$payrecord_info['order_money_paid_type'] = price_format($payrecord_info['order_money_paid']);
		$payrecord_info['back_money_total_type'] = price_format($payrecord_info['back_money_total']);
		$payrecord_info['back_pay_fee_type'] 	 = price_format($payrecord_info['back_pay_fee']);
		$payrecord_info['back_shipping_fee_type']= price_format($payrecord_info['back_shipping_fee']);
		$payrecord_info['back_insure_fee_type']  = price_format($payrecord_info['back_insure_fee']);
		$payrecord_info['back_inv_tax_type']  = price_format($payrecord_info['back_inv_tax']);
		$this->assign('payrecord_info', $payrecord_info);
					
		$this->display('return_detail.dwt');
	}
	
	/**
	 * 获取退款退货订单列表
	 */
	private function refund_list() {
		$db_refund_view = RC_DB::table('refund_order as ro')
		->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('ro.store_id'));
		
		$filter ['sort_by'] 	= empty ($_REQUEST ['sort_by']) 	? 'refund_id'	: trim($_REQUEST ['sort_by']);
		$filter ['sort_order'] 	= empty ($_REQUEST ['sort_order']) 	? 'desc' 				: trim($_REQUEST ['sort_order']);
		
		$filter['start_date']= $_GET['start_date'];
		$filter['end_date']  = $_GET['end_date'];
		if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
			$filter['start_date']	= RC_Time::local_strtotime($filter['start_date']);
			$filter['end_date']		= RC_Time::local_strtotime($filter['end_date']);
			$db_refund_view->where('add_time', '>=', $filter['start_date']);
			$db_refund_view->where('add_time', '<', $filter['end_date'] + 86400);
		}
		$filter['keywords']  = trim($_GET['keywords']);
		if ($filter['keywords']) {
			$db_refund_view ->whereRaw('(refund_sn like "%'.mysql_like_quote($filter['keywords']).'%"  
			or s.merchants_name like "%'.mysql_like_quote($filter['keywords']).'%" 
			or ro.order_sn like "%'.mysql_like_quote($filter['keywords']).'%")');
		}
		
		$refund_status = $_GET['refund_status'];
		if (!empty($refund_status) || $refund_status == '0') {
			$db_refund_view ->where('refund_status', $refund_status);
		}
	
		$filter['refund_type'] = trim($_GET['refund_type']);
		$refund_count = $db_refund_view->select(RC_DB::raw('count(*) as count'),
				RC_DB::raw('SUM(IF(refund_type = "refund", 1, 0)) as refund'),
				RC_DB::raw('SUM(IF(refund_type = "cancel", 1, 0)) as cancel'),
				RC_DB::raw('SUM(IF(refund_type = "return", 1, 0)) as return_refund'))->first();
	
		if ($filter['refund_type'] == 'refund') {
			$db_refund_view->where(RC_DB::raw('refund_type'), 'refund');
		} elseif ($filter['refund_type'] == 'return') {
			$db_refund_view->where(RC_DB::raw('refund_type'), 'return');
		} elseif ($filter['refund_type'] == 'cancel') {
			$db_refund_view->where(RC_DB::raw('refund_type'), 'cancel');
		}
	
		$count = $db_refund_view->count();
		$page = new ecjia_page($count, 10, 5);
		$data = $db_refund_view
		->select('refund_id','refund_sn','refund_type','order_id','order_sn','money_paid','surplus','add_time','shipping_fee','pack_fee','refund_status',RC_DB::raw('ro.status'),RC_DB::raw('s.merchants_name'))
		->orderby($filter['sort_by'], $filter['sort_order'])
		->take(10)
		->skip($page->start_id-1)
		->get();
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['add_time']  = RC_Time::local_date('Y-m-d H:i:s', $row['add_time']);
				$row['shipping_status'] = RC_DB::table('order_info')->where('order_id', $row['order_id'])->pluck('shipping_status');
				$row['refund_total_amount']  = price_format($row['money_paid'] + $row['surplus']);
				$list[] = $row;
			}
		}
		return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $refund_count);
	}
}

//end