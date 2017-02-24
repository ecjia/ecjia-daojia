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
 * ECJIA 订单-退货单管理
 */
class mh_back extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('admin_order', 'orders');
		RC_Loader::load_app_func('global', 'goods');
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('jquery-form');

		/* 列表页 js/css */
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('order_delivery', RC_App::apps_url('statics/js/merchant_order_delivery.js', __FILE__));
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('order', 'order/mh_back.php');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单管理'), RC_Uri::url('orders/merchant/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.order_back_list'),RC_Uri::url('orders/mh_back/init')));
		
	}
	
	/**
	 * 退货单列表
	 */
	public function init() {
		/* 检查权限 */
		$this->admin_priv('back_view');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.order_back_list')));

		/* 查询 */
		RC_Loader::load_app_func('merchant_order');
		$result = get_merchant_back_list();
        
		/* 模板赋值 */
		$this->assign('ur_here', 		RC_Lang::get('orders::order.order_back_list'));
		$this->assign('form_action', 	RC_Uri::url('order/admin_order_back/product_add_execute'));

		$this->assign('back_list', 		$result);
		$this->assign('filter', 		$result['filter']);
		$this->assign('form_action', 	RC_Uri::url('orders/mh_back/init'));
		$this->assign('del_action', 	RC_Uri::url('orders/mh_back/remove'));

		$this->assign_lang();
		$this->display('back_list.dwt');
	}

	/**
	 * 退货单详细
	 */
	public function back_info() {
		/* 检查权限 */
		$this->admin_priv('back_view');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.return_look')));
        $store_id = $_SESSION['store_id'];

		$back_id = intval(trim($_GET['back_id']));
		$count = RC_DB::table('back_order as bo')
				->leftJoin('order_goods as og', RC_DB::raw('bo.order_id'), '=', RC_DB::raw('og.order_id'))
				->whereRaw("bo.back_id = $back_id")
				->count();
        
		/* 根据发货单id查询发货单信息 */
		if (!empty($back_id)) {
			RC_Loader::load_app_func('global');
			$back_order = back_order_info($back_id, $store_id);
		} else {
			return $this->showmessage(RC_Lang::get('orders::order.return_form').'！' , ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR) ;
		}
		if (empty($back_order)) {
			return $this->showmessage(RC_Lang::get('orders::order.return_form').'！' , ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR) ;
		}
	
		/* 取得用户名 */
		if ($back_order['user_id'] > 0) {
			$user = user_info($back_order['user_id']);
			if (!empty($user)) {
				$back_order['user_name'] = $user['user_name'];
			}
		}
	
		/* 取得区域名 */
		$field = array("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region");
		/* 是否保价 */
		$order['insure_yn'] = empty($order['insure_fee']) ? 0 : 1;
	
		/* 取得发货单商品 */
		$goods_list	= RC_DB::table('back_goods')->where('back_id', $back_order['back_id'])->get();
		/* 是否存在实体商品 */
		$exist_real_goods = 0;
		if ($goods_list) {
			foreach ($goods_list as $value) {
				if ($value['is_real']) {
					$exist_real_goods++;
				}
			}
		}
		/* 模板赋值 */
		$this->assign('back_order', $back_order);
		$this->assign('ur_here', RC_Lang::get('orders::order.return_look'));
		
		$this->assign('exist_real_goods', exist_real_goods);
		$this->assign('goods_list', $goods_list);
		$this->assign('back_id', $back_id); // 发货单id
		/* 显示模板 */
		$this->assign('action_link', array('href' => RC_Uri::url('orders/mh_back/init'), 'text' => RC_Lang::get('system::system.10_back_order')));
		
		$this->assign_lang();
		$this->display('back_info.dwt');
	}

	/* 退货单删除 */
	public function remove() {
		/* 检查权限 */
		$this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);
		$back_id = $_REQUEST['back_id'];
		/* 记录日志 */
		ecjia_admin_log::instance()->add_object('order_back', RC_Lang::get('orders::order.back_sn'));
		$type = htmlspecialchars($_GET['type']);
		$back = explode(',',$back_id);
        
		$db_back_order = RC_DB::table('back_order')->whereIn('back_id', $back);
		$db_back_order_get = $db_back_order->first();

	    if ($db_back_order_get['store_id'] != $_SESSION['store_id']) {
			return $this->showmessage(__('无法找到对应的订单！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
		
		$db_back_order->delete();
		return $this->showmessage(RC_Lang::get('orders::order.tips_back_del'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl'=>RC_Uri::url('orders/mh_back/init')));
	}

	/*收货人信息*/
	public function consignee_info(){
		$this->admin_priv('back_view', ecjia::MSGTYPE_JSON);
		$id = $_GET['back_id'];
		if (!empty($id)) {
			$field = array('order_id', 'consignee', 'address', 'country', 'province', 'city', 'district', 'sign_building', 'email', 'zipcode', 'tel', 'mobile', 'best_time');
			$row = RC_DB::table('back_order')->select($field)->where('back_id', $id)->first();
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
				return $this->showmessage(RC_Lang::get('orders::order.no_invoice').'！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(RC_Lang::get('orders::order.a_mistake').'！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		die(json_encode($row));
	}
}

// end