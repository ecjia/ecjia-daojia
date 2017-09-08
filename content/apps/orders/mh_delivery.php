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
use Ecjia\System\Notifications\OrderShipped;
defined('IN_ECJIA') or exit('No permission resources.');


/**
 * ECJIA 订单-发货单管理
 */
class mh_delivery extends ecjia_merchant {
	private $db_delivery_order;
	private $db_order_region;
	private $db_delivery;
	private $db_order_action;
	private $db_goods;
	private $db_products;
	private $db_admin_user;

	public function __construct() {
		parent::__construct();

		RC_Lang::load('order');

		RC_Loader::load_app_func('admin_order', 'orders');
		RC_Loader::load_app_func('merchant_order', 'orders');
		RC_Loader::load_app_func('global', 'goods');
		RC_Loader::load_app_func('global');
		$this->db_delivery_order	= RC_Model::model('orders/delivery_order_model');
		$this->db_order_region		= RC_Model::model('order_region_viewmodel');
		$this->db_delivery			= RC_Model::model('delivery_goods_model');
		$this->db_order_action		= RC_Model::model('order_action_model');
		$this->db_goods				= RC_Model::model('goods/goods_model');
		$this->db_products			= RC_Model::model('goods/products_model');
		$this->db_admin_user		= RC_Model::model('admin_user_model');

		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		
		
		/* 列表页 js/css */
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('order_delivery', RC_App::apps_url('statics/js/merchant_order_delivery.js', __FILE__));
		RC_Style::enqueue_style('orders', RC_App::apps_url('statics/css/merchant_delivery.css', __FILE__), array(), false, false);
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');

		ecjia_merchant_screen::get_current_screen()->set_parentage('order', 'order/mh_delivery.php');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单管理'), RC_Uri::url('orders/merchant/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.order_delivery_list'),RC_Uri::url('orders/mh_delivery/init')));
	}

	/**
	 * 发货单列表
	 */
	public function init() {
		/* 检查权限 */
		$this->admin_priv('delivery_view');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.order_delivery_list')));

		/* 查询 */
		$result = get_merchant_delivery_list();
		/* 模板赋值 */
		$this->assign('ur_here'			, RC_Lang::get('orders::order.order_delivery_list'));
		$this->assign('os_unconfirmed'	, OS_UNCONFIRMED);
		$this->assign('cs_await_pay'	, CS_AWAIT_PAY);
		$this->assign('cs_await_ship'	, CS_AWAIT_SHIP);
		$this->assign('delivery_list'	, $result);
		$this->assign('type_count'		, $result['type_count']);
		$this->assign('filter'			, $result['filter']);
		$this->assign('search_action'	, RC_Uri::url('orders/mh_delivery/init'));
		$this->assign('form_action'		, RC_Uri::url('orders/mh_delivery/remove&type=batch'));

		$this->assign_lang();
		$this->display('delivery_list.dwt');
	}

	/**
	 * 发货单详细
	 */
	public function delivery_info() {
		/* 检查权限 */
		$this->admin_priv('delivery_view');

		$delivery_id = intval(trim($_GET['delivery_id']));
		/* 根据发货单id查询发货单信息 */
		if (!empty($delivery_id)) {
			$delivery_order = delivery_order_info($delivery_id);
		} else {
			return $this->showmessage(__('无法找到对应发货单！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
		if (empty($delivery_order)) {
			return $this->showmessage(__('无法找到对应发货单！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}

	   if ($delivery_order['store_id'] != $_SESSION['store_id']) {
			return $this->showmessage(__('无法找到对应的订单！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('发货单操作：查看')));

		/* 取得用户名 */
		if ($delivery_order['user_id'] > 0) {
			$user = user_info($delivery_order['user_id']);
			if (!empty($user)) {
				$delivery_order['user_name'] = $user['user_name'];
			}
		}

		/* 取得区域名 */
		$field = array("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region");


		$db_order_info = RC_DB::table('order_info as o')
				->leftJoin('region as c', RC_DB::raw('o.country'), '=', RC_DB::raw('c.region_id'))
				->leftJoin('region as p', RC_DB::raw('o.province'), '=', RC_DB::raw('p.region_id'))
				->leftJoin('region as t', RC_DB::raw('o.city'), '=', RC_DB::raw('t.region_id'))
				->leftJoin('region as d', RC_DB::raw('o.district'), '=', RC_DB::raw('d.region_id'));
		$order_id = $delivery_order['order_id'];
		$region = $db_order_info->selectRaw("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region")
				->where(RC_DB::raw('o.order_id'), $order_id)->first();
		$delivery_order['region'] = $region['region'] ;

		/* 是否保价 */
		$order['insure_yn'] = empty($order['insure_fee']) ? 0 : 1;
		/* 取得发货单商品 */
		$goods_list = RC_DB::table('delivery_goods')->where('delivery_id', $delivery_order['delivery_id'])->get();

		/* 是否存在实体商品 */
		$exist_real_goods = 0;
		if ($goods_list) {
			foreach ($goods_list as $value) {
				if ($value['is_real']) {
					$exist_real_goods++;
				}
			}
		}
		/* 取得订单操作记录 */
		$act_list = array();
		$data = RC_DB::table('order_action')->where('order_id', $delivery_order['order_id'])
				->where('action_place', 1)
				->orderBy('log_time', 'asc')
				->orderBy('action_id', 'asc')
				->get();

		if(!empty($data)) {
			foreach ($data as $key => $row) {
				$row['order_status']	= RC_Lang::get('orders::order.os.'.$row['order_status']);
				$row['pay_status']		= RC_Lang::get('orders::order.ps.'.$row['pay_status']);
				$row['shipping_status']	= ($row['shipping_status'] == SS_SHIPPED_ING) ? RC_Lang::get('orders::order.ss_admin.'.SS_SHIPPED_ING) : RC_Lang::get('orders::order.ss.'.$row['shipping_status']);
				$row['action_time']		= RC_Time::local_date(ecjia::config('time_format'), $row['log_time']);
				$act_list[]				= $row;
			}
		}
		
		/* 判断配送方式是否是立即送*/
		$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
		$shipping_info = $shipping_method->shipping_info($delivery_order['shipping_id']);
		if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
			/* 获取正在派单的配送员*/
			$staff_list = RC_DB::table('staff_user')
				->where('store_id', $_SESSION['store_id'])
				->where('online_status', 1)
				->get();
			
			$this->assign('shipping_code', $shipping_info['shipping_code']);
			$this->assign('staff_user', $staff_list);
			
			$express_order = RC_DB::table('express_order')->where('delivery_id', $delivery_order['delivery_id'])->first();
			$this->assign('express_order', $express_order);
		}
		
		//获取shopping_code
		if(empty($delivery_order['invoice_no'])) {
		    $shipping_id = $delivery_order['shipping_id'];
		    $shipping_info = RC_DB::table('shipping')->where('shipping_id', $shipping_id)->first();
		    if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
		        $rand1 = mt_rand(100000,999999);
		        $rand2 = mt_rand(1000000,9999999);
		        $invoice_no = $rand1.$rand2;
		        $delivery_order['invoice_no'] = $invoice_no;
		    }
		}
		
		/* 模板赋值 */
		$this->assign('action_list'			, $act_list);
		$this->assign('delivery_order'		, $delivery_order);
		$this->assign('exist_real_goods'	, $exist_real_goods);
		$this->assign('goods_list'			, $goods_list);
		$this->assign('delivery_id'			, $delivery_id); // 发货单id
		
		/* 显示模板 */
		$this->assign('ur_here'				, RC_Lang::get('orders::order.order_operate_view'));
		$this->assign('action_link'			, array('href' => RC_Uri::url('orders/mh_delivery/init'), 'text' => RC_Lang::get('orders::order.order_delivery_list')));
		$this->assign('action_act'			, ($delivery_order['status'] == 2) ? 'delivery_ship' : 'delivery_cancel_ship');
		$this->assign('form_action'			, ($delivery_order['status'] == 2) ? RC_Uri::url('orders/mh_delivery/delivery_ship') : RC_Uri::url('orders/mh_delivery/delivery_cancel_ship'));

		$this->assign_lang();
		$this->display('delivery_info.dwt');
	}

	/**
	 * 发货单发货确认
	 */
	public function delivery_ship() {
		/* 检查权限 */
		$this->admin_priv('delivery_view', ecjia::MSGTYPE_JSON);
		
		$db_delivery = RC_Loader::load_app_model('delivery_viewmodel','orders');
		/* 定义当前时间 */
		define('GMTIME_UTC', RC_Time::gmtime()); // 获取 UTC 时间戳
		/* 取得参数 */
		$delivery				= array();
		$order_id				= intval(trim($_POST['order_id']));			// 订单id
		$delivery_id			= intval(trim($_POST['delivery_id']));		// 发货单id
		$delivery['invoice_no']	= isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '';
		$action_note			= isset($_POST['action_note']) ? trim($_POST['action_note']) : '';
		
		/*检查订单商品是否存在或已移除到回收站*/
		$order_goods_ids = RC_DB::table('order_goods')->where('order_id', $order_id)->select(RC_DB::raw('goods_id'))->get();
		foreach ($order_goods_ids as $key => $val) {
			$goods_info = RC_DB::table('goods')->where('goods_id', $val['goods_id'])->first();
			$goods_name = $goods_info['goods_name'];
			if (empty($goods_info)) {
				return $this->showmessage('此订单包含的商品已被删除，请核对后再发货！' , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($goods_info['is_delete'] == 1) {
				return $this->showmessage('此订单包含的商品【'.$goods_name.'】已被移除到了回收站，请核对后再发货！' , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		/* 判断备注是否填写*/
		if (empty($_POST['action_note'])) {
		    return $this->showmessage(__('请填写备注信息！') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 根据发货单id查询发货单信息 */
		if (!empty($delivery_id)) {
			$delivery_order = delivery_order_info($delivery_id);
		} else {
			return $this->showmessage( __('无法找到对应发货单！') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($delivery_order)) {
			return $this->showmessage( __('无法找到对应发货单！') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 查询订单信息 */
		$order = order_info($order_id);
		
		/* 检查此单发货商品库存缺货情况 */
		$virtual_goods			= array();
		$delivery_stock_result	= $db_delivery->join(array('goods','products'))->where(array('dg.delivery_id' => $delivery_id))->group('dg.product_id')->select();

		/* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
		if(!empty($delivery_stock_result)) {
			foreach ($delivery_stock_result as $value) {
				if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) &&
					((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
					(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {

					/* 操作失败 */
					$links[] = array('text' => RC_Lang::get('orders::order.order_info'), 'href' => RC_Uri::url('orders/mh_delivery/delivery_info', 'delivery_id=' . $delivery_id));
					return $this->showmessage(sprintf(RC_Lang::get('orders::order.act_goods_vacancy'), $value['goods_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
				}

				/* 虚拟商品列表 virtual_card */
				if ($value['is_real'] == 0) {
					$virtual_goods[] = array(
						'goods_id'		=> $value['goods_id'],
						'goods_name'	=> $value['goods_name'],
						'num'			=> $value['send_number']
					);
				}
			}
		} else {
			$db_delivery->view = array(
				'goods' => array(
					'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
					'alias'		=> 'g',
					'field'		=> 'dg.goods_id, dg.is_real, SUM(dg.send_number) AS sums, g.goods_number, g.goods_name, dg.send_number',
					'on'		=> 'dg.goods_id = g.goods_id ',
				)
			);

			$delivery_stock_result = $db_delivery->where(array('dg.delivery_id' => $delivery_id))->group('dg.goods_id')->select();

			foreach ($delivery_stock_result as $value) {
				if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) &&
					((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
					(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
					/* 操作失败 */
					$links[] = array('text' => RC_Lang::get('orders::order.order_info'), 'href' => RC_Uri::url('orders/order_delilvery/delivery_info', 'delivery_id=' . $delivery_id));
					return $this->showmessage(sprintf(RC_Lang::get('orders::order.act_goods_vacancy'), $value['goods_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
				}

				/* 虚拟商品列表 virtual_card*/
				if ($value['is_real'] == 0) {
					$virtual_goods[] = array(
						'goods_id'		=> $value['goods_id'],
						'goods_name'	=> $value['goods_name'],
						'num'			=> $value['send_number']
					);
				}
			}
		}

		/* 发货 */
		/* 处理虚拟卡 商品（虚货） */
		if (is_array($virtual_goods) && count($virtual_goods) > 0) {
			foreach ($virtual_goods as $virtual_value) {
				virtual_card_shipping($virtual_value,$order['order_sn'], $msg, 'split');
			}
		}

		/* 如果使用库存，且发货时减库存，则修改库存 */
		if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
			foreach ($delivery_stock_result as $value) {
				/* 商品（实货）、超级礼包（实货） */
				if ($value['is_real'] != 0) {
					/* （货品） */
					if (!empty($value['product_id'])) {
						$data = array(
								'product_number' => $value['storage'] - $value['sums'],
						);
						$this->db_products->where(array('product_id' => $value['product_id']))->update($data);
					} else {
						$data = array(
								'goods_number' => $value['storage'] - $value['sums'],
						);
						$this->db_goods->where(array('goods_id' => $value['goods_id']))->update($data);
					}
				}
			}
		}

		/* 修改发货单信息 */
		$invoice_no = str_replace(',', '<br>', $delivery['invoice_no']);
		$invoice_no = trim($invoice_no, '<br>');
		$_delivery['invoice_no']	= $invoice_no;
		$_delivery['status']		= 0;				/* 0，为已发货 */
		$result = $this->db_delivery_order->where(array('delivery_id' => $delivery_id))-> update($_delivery);

		/*操作成功*/
		if ($result) {
			$data = array(
				'order_status'	=> RC_Lang::get('orders::order.ss.'.SS_SHIPPED),
				'message'       => sprintf(RC_Lang::get('orders::order.order_send_message'), $order['order_sn']),
				'order_id'    	=> $order_id,
				'add_time'    	=> RC_Time::gmtime(),
			);
			RC_DB::table('order_status_log')->insert($data);
		} else {
		    $links[] = array('text' => RC_Lang::get('orders::order.delivery_sn') . RC_Lang::get('orders::order.detail'), 'href' => RC_Uri::url('orders/mh_delivery/delivery_info', array('delivery_id' => $delivery_id)));
		    return $this->showmessage(RC_Lang::get('orders::order.act_false'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}

		/* 标记订单为已确认 “已发货” */
		/* 更新发货时间 */
		$order_finish				= get_all_delivery_finish($order_id);
		$shipping_status			= ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
		$arr['shipping_status']		= $shipping_status;
		$arr['shipping_time']		= GMTIME_UTC; // 发货时间
		$arr['invoice_no']			= trim($order['invoice_no'] . '<br>' . $invoice_no, '<br>');
		update_order($order_id, $arr);
		/* 记录日志 */
		ecjia_merchant::admin_log('发货,订单号是'.$order['order_sn'], 'setup', 'order');
		/* 发货单发货记录log */
		order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note, null, 1);
		
		/* 判断发货单，生成配送单*/
		$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
		$shipping_info = $shipping_method->shipping_info($delivery_order['shipping_id']);

		if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
			$staff_id = isset($_POST['staff_id']) ? intval($_POST['staff_id']) : 0;
			$express_from = !empty($staff_id) ? 'assign' : 'grab';
			$express_data = array(
				'express_sn' 	=> date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT),
				'order_sn'		=> $delivery_order['order_sn'],
				'order_id'		=> $delivery_order['order_id'],
				'delivery_id'	=> $delivery_order['delivery_id'],
				'delivery_sn'	=> $delivery_order['delivery_sn'],
				'store_id'		=> $delivery_order['store_id'],
				'user_id'		=> $delivery_order['user_id'],
				'consignee'		=> $delivery_order['consignee'],
				'address'		=> $delivery_order['address'],
				'country'		=> $delivery_order['country'],
				'province'		=> $delivery_order['province'],
				'city'			=> $delivery_order['city'],
				'district'		=> $delivery_order['district'],
				'email'			=> $delivery_order['email'],
				'mobile'		=> $delivery_order['mobile'],
				'best_time'		=> $delivery_order['best_time'],
				'remark'		=> '',
				'shipping_fee'	=> '5.00',
				'commision'		=> '',
				'add_time'		=> RC_Time::gmtime(),
				'longitude'		=> $delivery_order['longitude'],
				'latitude'		=> $delivery_order['latitude'],
				'from'			=> $express_from,
				'status'		=> $express_from == 'grab' ? 0 : 1,
				'staff_id'		=> $staff_id,
			);
				
			if ($staff_id > 0) {
				$express_data['receive_time'] = RC_Time::gmtime();
				$staff_info = RC_DB::table('staff_user')->where('user_id', $staff_id)->first();
				$express_data['express_user']	= $staff_info['name'];
				$express_data['express_mobile']	= $staff_info['mobile'];
			}
				
			$store_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
				
			if (!empty($store_info['longitude']) && !empty($store_info['latitude'])) {
				//腾讯地图api距离计算
              	$key = ecjia::config('map_qq_key');
		        $url = "http://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$store_info['latitude'].",".$store_info['longitude']."&to=".$delivery_order['latitude'].",".$delivery_order['longitude']."&key=".$key;
		        $distance_json = file_get_contents($url);
		     	$distance_info = json_decode($distance_json, true);
		     	$express_data['distance'] = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
			}
				
			$exists_express_order = RC_DB::table('express_order')->where('delivery_sn', $delivery_order['delivery_sn'])->where('store_id', $_SESSION['store_id'])->first();
			if ($exists_express_order) {
				unset($express_data['add_time']);
				$express_data['update_time'] = RC_Time::gmtime();
				RC_DB::table('express_order')->where('express_id', $exists_express_order['express_id'])->update($express_data);
				$express_id = $exists_express_order['express_id'];
			} else {
				$express_id = RC_DB::table('express_order')->insert($express_data);
			}
				
			/* 如果派单*/
			if ($staff_id > 0) {
			    /* 消息插入 */
			    $orm_staff_user_db = RC_Model::model('orders/orm_staff_user_model');
			    $user = $orm_staff_user_db->find($staff_id);
			    
			    $express_order_viewdb = RC_Model::model('orders/express_order_viewmodel');
			    $where = array('express_id' => $express_id);
			    $field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
			    $express_order_info = $express_order_viewdb->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->find();
			    
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
			    $notification_express_data = array(
			        'title'	=> '系统派单',
			        'body'	=> '有单啦！系统已分配配送单到您账户，赶快行动起来吧！',
			        'data'	=> array(
			            'express_id'			=> $express_order_info['express_id'],
			            'express_sn'			=> $express_order_info['express_sn'],
			            'express_type'			=> $express_order_info['from'],
			            'label_express_type'	=> $express_order_info['from'] == 'assign' ? '系统派单' : '抢单',
			            'order_sn'				=> $express_order_info['order_sn'],
			            'payment_name'			=> $express_order_info['pay_name'],
			            'express_from_address'	=> '【'.$express_order_info['merchants_name'].'】'. $express_order_info['merchant_address'],
			            'express_from_location'	=> array(
			                'longitude' => $express_order_info['merchant_longitude'],
			                'latitude'	=> $express_order_info['merchant_latitude'],
			            ),
			            'express_to_address'	=> $express_order_info['address'],
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
			    
				
// 				$devic_info = RC_Api::api('mobile', 'device_info', array('user_type' => 'merchant', 'user_id' => $staff_id));
// 				if (!is_ecjia_error($devic_info) && !empty($devic_info)) {
// 					$push_event = RC_Model::model('push/push_event_viewmodel')->where(array('event_code' => 'system_express_assign', 'is_open' => 1, 'status' => 1, 'mm.app_id is not null', 'mt.template_id is not null', 'device_code' => $devic_info['device_code'], 'device_client' => $devic_info['device_client']))->find();
// 					if (!empty($push_event)) {
// 						RC_Loader::load_app_class('push_send', 'push', false);
// 						ecjia_admin::$controller->assign('express_info', $express_order_info);
// 						$content = ecjia_admin::$controller->fetch_string($push_event['template_content']);
		
// 						if ($devic_info['device_client'] == 'android') {
// 							$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_ANDROID)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
// 						} elseif ($devic_info['device_client'] == 'iphone') {
// 							$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_IPHONE)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
// 						}
// 					}
// 				}
			}

			/* 如果是o2o速递则在 ecjia_express_track_record表内更新一条记录*/
			$express_track_record_data = array(
			    "express_code"    =>  $shipping_info['shipping_code'],
			    "track_number"    =>  $delivery['invoice_no'],
			    "time"            =>  RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()),
			    "context"         =>  "您的订单已配备好，等待配送员取货",
			);
			RC_DB::table('express_track_record')->insert($express_track_record_data);
		}
		
		/* 如果当前订单已经全部发货 */
		if ($order_finish) {
			/* 如果订单用户不为空，计算积分，并发给用户；发红包 */
			if ($order['user_id'] > 0) {
				/* 取得用户信息 */
				$user = user_info($order['user_id']);
				/* 计算并发放积分 */
				$integral = integral_to_give($order);

				$options = array(
					'user_id'		=> $order['user_id'],
					'rank_points'	=> intval($integral['rank_points']),
					'pay_points'	=> intval($integral['custom_points']),
					'change_desc'	=> sprintf(RC_Lang::get('orders::order.order_gift_integral'), $order['order_sn'])
				);
				RC_Api::api('user', 'account_change_log',$options);
				/* 发放红包 */
				send_order_bonus($order_id);
			}

			/* 发送邮件 */
			$cfg = ecjia::config('send_ship_email');
			if ($cfg == '1') {
				$order['invoice_no'] = $invoice_no;
				$tpl_name = 'deliver_notice';
				$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);

				$this->assign('order'			, $order);
				$this->assign('send_time'		, RC_Time::local_date(ecjia::config('time_format')));
				$this->assign('shop_name'		, ecjia::config('shop_name'));
				$this->assign('send_date'		, RC_Time::local_date(ecjia::config('date_format')));
				$this->assign('confirm_url'		, SITE_URL . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
				$this->assign('send_msg_url'	, SITE_URL . RC_Uri::url('user/admin/message_list','order_id=' . $order['order_id']));

				$content = $this->fetch_string($tpl['template_content']);

				if (!RC_Mail::send_mail($order['consignee'], $order['email'] , $tpl['template_subject'], $content, $tpl['is_html'])) {
					return $this->showmessage(RC_Lang::get('orders::order.send_mail_fail') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}

            /* 商家发货 如果需要，发短信 */
			if (!empty($order['mobile'])) {
				//发送短信
				$user_name = RC_DB::TABLE('users')->where('user_id', $order['user_id'])->pluck('user_name');
				$options = array(
					'mobile' => $order['mobile'],
					'event'	 => 'sms_order_shipped',
					'value'  =>array(
						'user_name'    => $user_name,
						'order_sn'     => $order['order_sn'],
						'consignee'    => $order['consignee'],
						'service_phone'=> ecjia::config('service_phone'),
					),
				);
				RC_Api::api('sms', 'send_event_sms', $options);
			}
		}
		
		$user_name = RC_DB::TABLE('users')->where('user_id', $order['user_id'])->pluck('user_name');
		
		/*商家发货 推送消息*/
		$options = array(
			'user_id'   => $order['user_id'],
			'user_type' => 'user',
			'event'     => 'order_shipped',
			'value' => array(
				'user_name'=> $user_name,
				'order_sn' => $order['order_sn'],
				'consignee'=> $order['consignee'],
				'service_phone'=> ecjia::config('service_phone'),
			),
			'field' => array(
				'open_type' => 'admin_message',
			),
		);
		RC_Api::api('push', 'push_event_send', $options);
		
		
		//消息通知
		$orm_user_db = RC_Model::model('orders/orm_users_model');
		$user_ob = $orm_user_db->find($order['user_id']);
		
		$order_data = array(
		    'title'	=> '客户下单',
		    'body'	=> '您有一笔新订单，订单号为：'.$order['order_sn'],
		    'data'	=> array(
		        'order_id'		=> $order['order_id'],
		        'order_sn'		=> $order['order_sn'],
		        'order_amount'	=> $order['order_amount'],
		        'formatted_order_amount' => price_format($order['order_amount']),
		        'consignee'		=> $order['consignee'],
		        'mobile'		=> $order['mobile'],
		        'address'		=> $order['address'],
		        'order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $order['add_time']),
		        'shipping_time'	=> RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']),
		        'invoice_no'	=> $invoice_no,
		    ),
		);
		
		$push_order_shipped = new OrderShipped($order_data);
		RC_Notification::send($user_ob, $push_order_shipped);
		/* 发货通知*/
// 		$devic_info = RC_Api::api('mobile', 'device_info', array('user_type' => 'user', 'user_id' => $order['user_id']));
// 		if (!is_ecjia_error($devic_info) && !empty($devic_info)) {
// 			$push_event = RC_Model::model('push/push_event_viewmodel')->where(array('event_code' => 'order_shipped', 'is_open' => 1, 'status' => 1, 'mm.app_id is not null', 'mt.template_id is not null', 'device_code' => $devic_info['device_code'], 'device_client' => $devic_info['device_client']))->find();
				
// 			if (!empty($push_event)) {
		
// 				RC_Loader::load_app_class('push_send', 'push', false);
// 				ecjia_admin::$controller->assign('order', $order);
// 				$content = ecjia_admin::$controller->fetch_string($push_event['template_content']);
					
// 				if ($devic_info['device_client'] == 'android') {
// 					$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_ANDROID)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
// 				} elseif ($devic_info['device_client'] == 'iphone') {
// 					$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_IPHONE)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
// 				}
// 			}
// 		}


		/* 操作成功 */
		$links[] = array('text' => RC_Lang::get('orders::order.order_delivery_list'), 'href' => RC_Uri::url('orders/mh_delivery/init'));
		$links[] = array('text' => RC_Lang::get('orders::order.delivery_sn') . RC_Lang::get('orders::order.detail'), 'href' => RC_Uri::url('orders/mh_delivery/delivery_info', 'delivery_id=' . $delivery_id));

		return $this->showmessage(RC_Lang::get('orders::order.act_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/mh_delivery/delivery_info', array('delivery_id' => $delivery_id)), 'links' => $links));
	}

	/**
	 * 发货单取消发货
	 */
	public function delivery_cancel_ship() {
		/* 检查权限 */
		$this->admin_priv('delivery_view', ecjia::MSGTYPE_JSON);

		/* 取得参数 */
		$delivery				= '';
		$order_id				= intval(trim($_POST['order_id']));			// 订单id
		$delivery_id			= intval(trim($_POST['delivery_id']));		// 发货单id
		$delivery['invoice_no']	= isset($_POST['invoice_no'])	? trim($_POST['invoice_no']) : '';
		$action_note			= isset($_POST['action_note'])	? trim($_POST['action_note']) : '';

		/* 判断备注是否填写*/
		if (empty($_POST['action_note'])) {
		    return $this->showmessage(__('请填写备注信息！') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 根据发货单id查询发货单信息 */
		if (!empty($delivery_id)) {
			$delivery_order = delivery_order_info($delivery_id);
		} else {
			return $this->showmessage( __('无法找到对应发货单！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($delivery_order)) {
			return $this->showmessage( __('无法找到对应发货单！') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 查询订单信息 */
		$order = order_info($order_id);

		/* 取消当前发货单物流单号 */
		$_delivery['invoice_no']	= '';
		$_delivery['status']		= 2;
		$result = $this->db_delivery_order->where(array('delivery_id' => $delivery_id))->update($_delivery);
		if (!$result) {
			/* 操作失败 */
			$links[] = array('text' => RC_Lang::get('orders::order.delivery_sn') . RC_Lang::get('orders::order.detail'), 'href' => RC_Uri::url('orders/mh_delivery/delivery_info', 'delivery_id=' . $delivery_id));
			return $this->showmessage(RC_Lang::get('orders::order.act_false'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 修改定单发货单号 */
		$invoice_no_order		= explode('<br>', $order['invoice_no']);
		$invoice_no_delivery	= explode('<br>', $delivery_order['invoice_no']);
		foreach ($invoice_no_order as $key => $value) {
			$delivery_key = array_search($value, $invoice_no_delivery);
			if ($delivery_key !== false) {
				unset($invoice_no_order[$key], $invoice_no_delivery[$delivery_key]);
				if (count($invoice_no_delivery) == 0) {
					break;
				}
			}
		}
		$_order['invoice_no'] = implode('<br>', $invoice_no_order);

		/* 更新配送状态 */
		$order_finish				= get_all_delivery_finish($order_id);
		$shipping_status			= ($order_finish == -1) ? SS_SHIPPED_PART : SS_SHIPPED_ING;
		$arr['shipping_status']		= $shipping_status;
		if ($shipping_status == SS_SHIPPED_ING) {
			$arr['shipping_time']	= ''; // 发货时间
		}
		$arr['invoice_no']			= $_order['invoice_no'];
		update_order($order_id, $arr);

		/* 发货单取消发货记录log */
		order_action($order['order_sn'], $order['order_status'], $shipping_status, $order['pay_status'], $action_note, null, 1);

		/* 如果使用库存，则增加库存 */
		if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
			// 检查此单发货商品数量
			$virtual_goods = array();
			$delivery_stock_result = $this->db_delivery->field('goods_id, product_id, is_real, SUM(send_number)|sums')->where(array('delivery_id' => $delivery_id))->group('goods_id')->select();

			foreach ($delivery_stock_result as $key => $value) {
				/* 虚拟商品 */
				if ($value['is_real'] == 0) {
					continue;
				}

				//（货品）
				if (!empty($value['product_id'])) {
					RC_DB::table('products')
						->where('product_id', $value['product_id'])
						->increment('product_number', '"'.$value['sums'].'"');
				}
				RC_DB::table('goods')
					->where('goods', $value['goods_id'])
					->increment('goods_number', '"'.$value['sums'].'"');
			}
		}

		/* 发货单全退回时，退回其它 */
		if ($order['order_status'] == SS_SHIPPED_ING) {
			/* 如果订单用户不为空，计算积分，并退回 */
			if ($order['user_id'] > 0) {
				/* 取得用户信息 */
				$user = user_info($order['user_id']);
				/* 计算并退回积分 */
				$integral = integral_to_give($order);
				$options = array(
					'user_id'		=> $order['user_id'],
					'rank_points'	=> (-1) * intval($integral['rank_points']),
					'pay_points'	=> (-1) * intval($integral['custom_points']),
					'change_desc'	=> sprintf(RC_Lang::get('orders::order.return_order_gift_integral'), $order['order_sn'])
				);
				RC_Api::api('user', 'account_change_log', $options);
				/* todo 计算并退回红包 */
				return_order_bonus($order_id);
			}
		}

		/* 判断发货单，取消配送单*/
		$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
		$shipping_info = $shipping_method->shipping_info($delivery_order['shipping_id']);
		if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
		    /* 如果是o2o速递，退货的时候删除ecjia_express_track_record相对应的记录 */
		    RC_DB::table('express_track_record')->where('track_number', $delivery['invoice_no'])->delete();
		}
		/* 操作成功 */
		$links[] = array('text' => RC_Lang::get('orders::order.delivery_sn') . RC_Lang::get('orders::order.detail'), 'href' => RC_Uri::url('orders/mh_delivery/delivery_info', 'delivery_id=' . $delivery_id));
		return $this->showmessage(RC_Lang::get('orders::order.act_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/mh_delivery/delivery_info', array('delivery_id' => $delivery_id)), 'links' => $links));
	}

	/* 发货单删除 */
	public function remove() {
		/* 检查权限 */
		$this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);

		$delivery_id 	= !empty($_GET['delivery_id']) 	? $_GET['delivery_id'] 	: $_POST['delivery_id'];
		$type 			= isset($_GET['type']) 			? trim($_GET['type'])	: '';

		if (!is_array($delivery_id)) {
			if (strpos($delivery_id , ',') === false) {
				$delivery_id = array($delivery_id);
			} else {
				$delivery_id = explode(',', $delivery_id);
			}
		}
		foreach ($delivery_id as $value_is) {
			$value_is = intval(trim($value_is));
			/* 查询：发货单信息 */
			$delivery_order = delivery_order_info($value_is);

			if (!empty($delivery_order)) {
				/* 如果status不是退货 */
				if ($delivery_order['status'] != 1) {
					/* 处理退货 */
					delivery_return_goods($delivery_id, $delivery_order);
				}
				/* 如果status是已发货并且发货单号不为空 */
				if ($delivery_order['status'] == 0 && $delivery_order['invoice_no'] != '') {
					/* 更新：删除订单中的发货单号 */
					del_order_invoice_no($delivery_order['order_id'], $delivery_order['invoice_no']);
				}
				
				/* 如果是o2o速递，退货的时候删除ecjia_express_track_record相对应的记录 */
				$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
				$shipping_info = $shipping_method->shipping_info($delivery_order['shipping_id']);
				if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
				    RC_DB::table('express_track_record')->where('track_number', $delivery_order['invoice_no'])->delete();
				}
				/* 记录日志 */
				ecjia_admin_log::instance()->add_object('delivery_order', '发货单');
				if ($type == 'batch') {
					ecjia_merchant::admin_log($delivery_order['delivery_sn'], 'batch_remove', 'delivery_order');
				} else {
					ecjia_merchant::admin_log($delivery_order['delivery_sn'], 'remove', 'delivery_order');
				}
			}
		}

		//删除发货单
		RC_DB::table('delivery_order')->whereIn('delivery_id', $delivery_id)->delete();
		//删除发货单商品
		RC_DB::table('delivery_goods')->whereIn('delivery_id', $delivery_id)->delete();

		/* 更新：删除发货单 */
		return $this->showmessage(RC_Lang::get('orders::order.tips_delivery_del'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/mh_delivery/init')));
	}

	/*收货人信息*/
	public function consignee_info(){
		$this->admin_priv('delivery_view', ecjia::MSGTYPE_JSON);

		$id = $_GET['delivery_id'];
		if (!empty($id)) {
			$delivery_order = delivery_order_info($id);
                $row = RC_DB::table('delivery_order')->select(RC_DB::raw('order_id, consignee, address, country, province, city, district, sign_building, email, zipcode, tel, mobile, best_time'))
				            ->where('delivery_id', $id)->first();
			if (!empty($row)) {
			    $region = RC_DB::table('order_info as o')
    			    ->leftJoin('region as c', RC_DB::raw('o.country'), '=', RC_DB::raw('c.region_id'))
    			    ->leftJoin('region as p', RC_DB::raw('o.province'), '=', RC_DB::raw('p.region_id'))
    			    ->leftJoin('region as t', RC_DB::raw('o.city'), '=', RC_DB::raw('t.region_id'))
    			    ->leftJoin('region as d', RC_DB::raw('o.district'), '=', RC_DB::raw('d.region_id'))
    			    ->select(RC_DB::raw("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region"))
    			    ->where(RC_DB::raw('o.order_id'), $row['order_id'])
    			    ->first();
			    $row['region'] = $region['region'];
			} else {
				return $this->showmessage(RC_Lang::get('orders::order.no_delivery_consigness'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(RC_Lang::get('orders::order.operate_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		die(json_encode($row));
	}
}

// end