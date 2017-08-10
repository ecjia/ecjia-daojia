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

class orders_merchant_plugin {
	
	public static function widget_admin_dashboard_orderslist() {

	}
	
	// 商城简报
	public static function widget_admin_dashboard_shopchart() {
	    $order_query = RC_Loader::load_app_class('merchant_order_query','orders');
		$db	= RC_Loader::load_app_model('order_info_viewmodel','orders');
		$db->view = array(
			'order_goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'on' 	=> 'oi.order_id = g.order_id '
			)
		);
		$db_order_viewmodel = RC_Loader::load_app_model('order_pay_viewmodel', 'orders');
		//TODO: 入驻商订单筛选条件
		$month_order = $db->where(array('oi.store_id' => $_SESSION['store_id'], 'oi.add_time' => array('gt' => RC_Time::gmtime() - 2592000)))->count('distinct oi.order_id');
        $now = RC_Time::gmtime();
        
		$order_money = $db_order_viewmodel->field('pl.order_amount')->where(array('oi.store_id' => $_SESSION['store_id'], 'oi.add_time' =>array('gt' => $now-3600*24*30, 'lt' => $now), 'pl.is_paid' => 1))->group(array('oi.order_id'))->select();
		foreach($order_money as $val){
		    $num+=intval($val['order_amount']);
		}
        $order_unconfirmed = $db->field('oi.order_id')->where(array('oi.order_status' => 0, 'oi.store_id'  => $_SESSION['store_id'], 'oi.add_time' => array('gt'=> $now-3600*60*24, 'lt' => $now)))->group('oi.order_id')->select();
        $order_unconfirmed = count($order_unconfirmed);
        
        $order_await_ship = $db->field('oi.order_id')->where(array_merge($order_query->order_await_ship('oi.'), array('oi.store_id'  => $_SESSION['store_id'], 'oi.add_time' => array('gt'=> $now-3600*60*24, 'lt' => $now))))->group('oi.order_id')->select();;
        $order_await_ship = count($order_await_ship);
        
        ecjia_admin::$controller->assign('month_order', $month_order);
		ecjia_admin::$controller->assign('order_money', intval($num));
		ecjia_admin::$controller->assign('order_unconfirmed', $order_unconfirmed);
		ecjia_admin::$controller->assign('order_await_ship', $order_await_ship);
		
	    $title = __('商城简报');
	    
	    ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_shopchart.lbi', 'orders'));
	}
	
	// 销售走势图
	public static function widget_admin_dashboard_salechart() {
	    $title = __('销售走势图');
        $db_order	= RC_Loader::load_app_model('order_info_viewmodel','orders');

        $now_time = RC_Time::gmtime()+28800;
        $start_time = $now_time - 2592000;
        $sale_arr = array();

        for($i = 30; $i>=0; $i--) {
            $tmp_time = $now_time - $i * 86400;
            $tmp_day = RC_Time::local_date('m-d', $tmp_time);
            $sale_arr[$tmp_day] = '0.00';
        }

        $where = array(
            'oi.store_id' => $_SESSION['store_id'],
            'oi.pay_status' => PS_PAYED,
            'oi.pay_time'   => array(
                'elt'   => $now_time,
                'gt'    => $start_time
            ),
        );

        $rs = $db_order->field('oi.order_id')->where($where)->select();
        $arr = array();
        foreach($rs as $value){
            if(empty($value['main_order_id'])){
                $arr[$value['order_id']]['order_id']        = $value['order_id']; // 主订单 和普通订单
            }else{
                $order[$value['order_id']]['order_id']      = $value['order_id'];
                $order[$value['order_id']]['main_order_id'] = $value['main_order_id']; // 子订单
            }
        }
        foreach ($order as $key => $val){
            unset($arr[$val['main_order_id']]); //删除主订单
            unset($order[$key]['main_order_id']);
        }
        $order = array_merge($order, $arr);
        $in['oi.order_id'] = array(0);
        if (!empty($order)) {
            foreach ($order as $val){
                $in['oi.order_id'][] = $val['order_id'];
            }
        }
        $orders = $db_order->field('count(oi.order_id) as numbers, sum(oi.money_paid) + sum(oi.surplus) as payed, FROM_UNIXTIME(oi.pay_time,"%m-%d")|date')->in($in)->group('date')->select();

        foreach($orders as $order) {
            $sale_arr[$order['date']] = $order['payed'];
        }
        $tmp_day = '';
        $tmp_price = '';
        foreach($sale_arr as $k => $v) {
            $tmp_day .= "'$k',";
            $tmp_price .= "$v,";
        }
        $tmp_day = rtrim($tmp_day, ',');
        $tmp_price = rtrim($tmp_price, ',');
        $sale_arr['day'] = $tmp_day;
        $sale_arr['price'] = $tmp_price;

        ecjia_admin::$controller->assign('sale_arr' , $sale_arr);


        ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_salechart.lbi', 'orders'));
	}
	
	// 订单走势图
	public static function widget_admin_dashboard_orderschart() {
	    $title = __('订单走势图');
	    $db_order	= RC_Loader::load_app_model('order_info_viewmodel','orders');

        $now_time = RC_Time::gmtime()+28800;
        $start_time = $now_time - 2592000;
        $order_arr = array();

        for($i = 30; $i>=0; $i--) {
            $tmp_time = $now_time - $i * 86400;
            $tmp_day = date('m-d',$tmp_time);
            $order_arr[$tmp_day] = '0';
        }

        $where = array(
        	'oi.store_id' => $_SESSION['store_id'],
            'oi.pay_status' => PS_PAYED,
            'oi.pay_time'   => array(
                'elt'   => $now_time,
                'gt'    => $start_time
            ),
        );

        $rs = $db_order->field('oi.order_id')->where($where)->select();
        $arr = array();
	    foreach($rs as $value){
	        if(empty($value['main_order_id'])){
	            $arr[$value['order_id']]['order_id']        = $value['order_id']; // 主订单 和普通订单
	        }else{
	            $order[$value['order_id']]['order_id']      = $value['order_id'];
	            $order[$value['order_id']]['main_order_id'] = $value['main_order_id']; // 子订单
	        }
	    }
	    foreach ($order as $key => $val){
	        unset($arr[$val['main_order_id']]); //删除主订单
	        unset($order[$key]['main_order_id']);
	    }
	    $order = array_merge($order, $arr);
        $in['oi.order_id'] = array(0);
	    if (!empty($order)) {
            foreach ($order as $val){
                $in['oi.order_id'][] = $val['order_id'];
            }
        }
	    $orders = $db_order->field('count(oi.order_id) as numbers, sum(oi.money_paid) + sum(oi.surplus) as payed, FROM_UNIXTIME(oi.pay_time,"%m-%d")|date')->in($in)->group('date')->select();

        foreach($orders as $order) {
            $order_arr[$order['date']] = $order['numbers'];
        }
        $tmp_day = '';
        $tmp_price = '';
        foreach($order_arr as $k => $v) {
            $tmp_day .= "'$k',";
            $tmp_price .= "$v,";
        }
        $tmp_day = rtrim($tmp_day, ',');
        $tmp_price = rtrim($tmp_price, ',');
        $order_arr['day'] = $tmp_day;
        $order_arr['price'] = $tmp_price;

		ecjia_admin::$controller->assign('order_arr' , $order_arr);

	    ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_orderschart.lbi', 'orders'));
	}
	
	// 订单统计信息
	public static function widget_admin_dashboard_ordersstat() {
		$result = ecjia_app::validate_application('payment');
		if (is_ecjia_error($result)) {
			return false;
		}
		 
		$title = __('订单统计信息');
		$order_query = RC_Loader::load_app_class('merchant_order_query','orders');
		
		$db	= RC_Loader::load_app_model('order_info_viewmodel','orders');
		$db_good_booking = RC_Loader::load_app_model('goods_booking_model','goods');
		$db_user_account = RC_Loader::load_app_model('user_account_model','user');
		
		$db->view = array(
			'order_goods' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'g',
				'on'	=> 'oi.order_id = g.order_id'
			)
		);
		/* 全部订单 */
		//TODO: 入驻商订单筛选条件
		$order['count']	= $db->where(array('oi.store_id' => $_SESSION['store_id']))->count('distinct oi.order_id');
		
		
		/* 已完成的订单 */
		$order['finished']		= $db->field('oi.order_id')->where(array_merge($order_query->order_finished('oi.'), array('oi.store_id'  => $_SESSION['store_id'])))->group('oi.order_id')->select();
		$order['finished'] 		= count($order['finished']);
		$status['finished']		= CS_FINISHED;
	   
		/* 待发货的订单： */
		$order['await_ship']	= $db->field('oi.order_id')->where(array_merge($order_query->order_await_ship('oi.'), array('oi.store_id'  => $_SESSION['store_id'])))->group('oi.order_id')->select();
		$order['await_ship'] 	= count($order['await_ship']);
		$status['await_ship']	= CS_AWAIT_SHIP;
		
		/* 待付款的订单： */
		$order['await_pay']		= $db->field('oi.order_id')->where(array_merge($order_query->order_await_pay('oi.'), array('oi.store_id'  => $_SESSION['store_id'])))->group('oi.order_id')->select();
		$order['await_pay'] 	= count($order['await_pay']);
		$status['await_pay']	= CS_AWAIT_PAY;
		
		/* “未确认”的订单 */
		$order['unconfirmed']	= $db->field('oi.order_id')->where(array_merge(array('oi.order_status' => 0),array('oi.store_id'  => $_SESSION['store_id'])))->group('oi.order_id')->select();
		$order['unconfirmed'] 	= count($order['unconfirmed']);
		$status['unconfirmed']	= OS_UNCONFIRMED;
		
		/* “部分发货”的订单 */
		$order['shipped_part']	= $db->field('oi.order_id')->where(array('oi.shipping_status'=> SS_SHIPPED_PART, 'oi.store_id' => $_SESSION['store_id']))->count('oi.order_id');
		$status['shipped_part'] = OS_SHIPPED_PART;
		
		ecjia_admin::$controller->assign('title', $title);
		ecjia_admin::$controller->assign('order', $order);
		ecjia_admin::$controller->assign('count', $order['count']);
		ecjia_admin::$controller->assign('status', $status);
		 
		ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_ordersstat.lbi', 'orders'));
	}
	
	static public function orders_stats_admin_menu_api($menus) {
	    $menu = array(
	        ecjia_admin::make_admin_menu('guest_stats', __('客户统计'), RC_Uri::url('orders/admin_guest_stats/init'), 51)->add_purview('guest_stats'),
	        ecjia_admin::make_admin_menu('order_stats', __('订单统计'), RC_Uri::url('orders/admin_order_stats/init'), 52)->add_purview('order_stats'),
	        ecjia_admin::make_admin_menu('sale_general', __('销售概况'), RC_Uri::url('orders/admin_sale_general/init'), 53)->add_purview('sale_general_stats'),
	        ecjia_admin::make_admin_menu('users_order', __('会员排行'), RC_Uri::url('orders/admin_users_order/init'), 54)->add_purview('users_order_stats'),
	        ecjia_admin::make_admin_menu('sale_list', __('销售明细'), RC_Uri::url('orders/admin_sale_list/init'), 55)->add_purview('sale_list_stats'),
	        ecjia_admin::make_admin_menu('sale_order', __('销售排行'), RC_Uri::url('orders/admin_sale_order/init'), 56)->add_purview('sale_order_stats'),
	        ecjia_admin::make_admin_menu('visit_sold', __('访问购买率'), RC_Uri::url('orders/admin_visit_sold/init'), 57)->add_purview('visit_sold_stats'),
	        ecjia_admin::make_admin_menu('adsense', __('广告转化率'), RC_Uri::url('orders/admin_adsense/init'), 58)->add_purview('adsense_conversion_stats')
	    );
	    $menus->add_submenu($menu);
	    return $menus;
	}
	
}

RC_Hook::add_action('admin_dashboard_top', array('orders_merchant_plugin', 'widget_admin_dashboard_shopchart'), 21);
RC_Hook::add_action('admin_dashboard_left', array('orders_merchant_plugin', 'widget_admin_dashboard_orderschart'));
RC_Hook::add_action('admin_dashboard_left', array('orders_merchant_plugin', 'widget_admin_dashboard_ordersstat'), 11);
RC_Hook::add_action('admin_dashboard_right', array('orders_merchant_plugin', 'widget_admin_dashboard_salechart'));
RC_Hook::add_filter('stats_admin_menu_api', array('orders_merchant_plugin', 'orders_stats_admin_menu_api'));

// end