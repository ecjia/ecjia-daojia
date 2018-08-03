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

class merchant_staff_hooks {
	//店铺信息
	public static function merchant_dashboard_information() {
		RC_Loader::load_app_func('merchant', 'merchant');
		$merchant_info = get_merchant_info($_SESSION['store_id']);
		ecjia_admin::$controller->assign('merchant_info', $merchant_info);

		ecjia_merchant::$controller->display(
			RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_information.lbi', true)
		);
	}

	//订单统计
	public static function merchant_dashboard_left_8_1() {
		//当前时间戳
		$now = RC_Time::gmtime();

		//本月开始时间
		$start_month = mktime(0,0,0,date('m'),1,date('Y'))-8*3600;

		RC_Loader::load_app_class('merchant_order_list', 'orders', false);
		$order = new merchant_order_list();
		
		$order_money = RC_DB::table('order_info as o')
			->leftJoin('order_goods as og', RC_DB::raw('o.order_id'), '=', RC_DB::raw('og.order_id'))
			->selectRaw("(" . $order->order_amount_field('o.') . ") AS order_amount")
			->where(RC_DB::raw('o.store_id'), $_SESSION['store_id'])
			->where(RC_DB::raw('o.add_time'), '>=', $start_month)
			->where(RC_DB::raw('o.add_time'), '<=', $now)
			->where(RC_DB::raw('o.is_delete'), 0)
			->whereIn(RC_DB::raw('o.order_status'), array(OS_CONFIRMED, OS_SPLITED))
			->whereIn(RC_DB::raw('o.shipping_status'), array(SS_SHIPPED, SS_RECEIVED))
			->whereIn(RC_DB::raw('o.pay_status'), array(PS_PAYING, PS_PAYED))
			->groupBy(RC_DB::raw('o.order_id'))
			->get();

		//本月订单总额
		$num = 0;
		if (!empty($order_money)) {
			foreach($order_money as $val){
				$num += $val['order_amount'];
			}
			$num = price_format($num);
		}

		//本月订单数量
		$order_number = RC_DB::table('order_info')
			->where('store_id', $_SESSION['store_id'])
			->where('add_time', '>=', $start_month)
			->where('is_delete', 0)
			->count(RC_DB::raw('distinct order_id'));

		//今日开始时间
		$start_time = mktime(0,0,0,date('m'),date('d'),date('Y'))-8*3600;

		//今日待确认订单
		$order_unconfirmed = RC_DB::table('order_info as oi')
			->leftJoin('order_goods as g', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('g.order_id'))
			->select(RC_DB::raw('oi.order_id'))
			->where(RC_DB::raw('oi.store_id'), $_SESSION['store_id'])->where(RC_DB::raw('oi.order_status'), 0)
			->where(RC_DB::raw('oi.add_time'), '>=', $start_time)->where(RC_DB::raw('oi.add_time'), '<=', $now)
			->where(RC_DB::raw('oi.is_delete'), 0)
			->groupBy(RC_DB::raw('oi.order_id'))->get();
		$order_unconfirmed = count($order_unconfirmed);

		$db_order_info = RC_DB::table('order_info as o');

		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment_id_row = $payment_method->payment_id_list(true);
		$payment_id = "";
		foreach ($payment_id_row as $v) {
			$payment_id .= empty($payment_id) ? $v : ','.$v ;
		}
		$payment_id = empty($payment_id) ? "''" : $payment_id;

		$db_order_info->whereIn(RC_DB::raw($alias.'order_status'), array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART));
		$db_order_info->whereIn(RC_DB::raw($alias.'shipping_status'), array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING));
		$db_order_info->whereRaw("( {$alias}pay_status in (" . PS_PAYED .",". PS_PAYING.") OR {$alias}pay_id in (" . $payment_id . "))");

		//今日待发货订单
		$order_await_ship = $db_order_info
			->leftJoin('order_goods as g', RC_DB::raw('o.order_id'), '=', RC_DB::raw('g.order_id'))
			->select(RC_DB::raw('o.order_id'))
			->where(RC_DB::raw('o.store_id'), $_SESSION['store_id'])->where(RC_DB::raw('o.order_status'), 0)
			->where(RC_DB::raw('o.add_time'), '>=', $start_time)->where(RC_DB::raw('o.add_time'), '<=', $now)
			->where(RC_DB::raw('o.is_delete'), 0)
			->groupBy(RC_DB::raw('o.order_id'))->get();
		$order_await_ship = count($order_await_ship);

		ecjia_admin::$controller->assign('order_money', 		$num);
		ecjia_admin::$controller->assign('order_number', 		$order_number);
		ecjia_admin::$controller->assign('order_unconfirmed',	$order_unconfirmed);
		ecjia_admin::$controller->assign('order_await_ship',	$order_await_ship);

		ecjia_admin::$controller->assign('month_start_time', RC_Time::local_date('Y-m-d', $start_month));	//本月开始时间
		ecjia_admin::$controller->assign('month_end_time', RC_Time::local_date('Y-m-d', $now));				//本月结束时间

		ecjia_admin::$controller->assign('today_start_time', RC_Time::local_date('Y-m-d H:i:s', $start_time));				//今天开始时间
		ecjia_admin::$controller->assign('today_end_time', RC_Time::local_date('Y-m-d H:i:s', $start_time+24*3600-1));		//今天结束时间
		ecjia_admin::$controller->assign('wait_ship', CS_AWAIT_SHIP);		//待发货
		ecjia_admin::$controller->assign('unconfirmed', OS_UNCONFIRMED);	//待确认

		ecjia_merchant::$controller->display(
		    RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_overview.lbi', true)
		);
	}

	//个人信息
	public static function merchant_dashboard_right_4_1() {
		$user_info = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
		$user_info['add_time']		= RC_Time::local_date(ecjia::config('time_format'), $user_info['add_time']);
		$user_info['last_login']	= RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);
		
		ecjia_admin::$controller->assign('user_info', $user_info);
		ecjia_merchant::$controller->display(
			RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_profile.lbi', true)
		);
	}

	//订单走势图
	public static function merchant_dashboard_left_8_2() {
		if (!isset($_SESSION['store_id']) || $_SESSION['store_id'] === '') {
			$count_list = array();
		} else {
			$cache_key = 'order_bar_chart_'.md5($_SESSION['store_id']);
			$count_list = RC_Cache::app_cache_get($cache_key, 'order');

			if (!$count_list) {
				$format = '%Y-%m-%d';
				$time = (mktime(0,0,0,date('m'),date('d'),date('Y'))-1)-8*3600;
				$start_time = $time - 30*86400;
				$store_id = $_SESSION['store_id'];

				$where = "add_time >= '$start_time' AND add_time <= '$time' AND store_id = $store_id AND is_delete = 0";

				$list = RC_DB::table('order_info')
					->selectRaw("FROM_UNIXTIME(add_time+8*3600, '". $format ."') AS day, count('order_id') AS count")
					->whereRaw($where)
					->groupby('day')
					->get();

				$days = $data = $count_list = array();

				for ($i=30; $i>0; $i--) {
					$days[] = date("Y-m-d", strtotime(' -'. $i . 'day'));
				}

				$max_count = 100;
				if (!empty($list)) {
					foreach ($list as $k => $v) {
						$data[$v['day']] = $v['count'];
					}
				}

				foreach ($days as $k => $v) {
					if (!array_key_exists($v, $data)) {
						$count_list[$v] = 0;
					} else {
						$count_list[$v] = $data[$v];
					}
				}

				$tmp_day = '';
				$tmp_count = '';
				foreach($count_list as $k => $v) {
					$k = intval(date('d', strtotime($k)));
					$tmp_day .= "'$k',";
					$tmp_count .= "$v,";
				}

				$tmp_day = rtrim($tmp_day, ',');
				$tmp_count = rtrim($tmp_count, ',');
				$count_list['day'] = $tmp_day;
				$count_list['count'] = $tmp_count;

				RC_Cache::app_cache_set($cache_key, $count_list, 'order', 60*24);//24小时缓存
			}
		}
		ecjia_merchant::$controller->assign('order_arr', $count_list);
	    ecjia_merchant::$controller->display(
	        RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_bar_chart.lbi', true)
	    );
    }

	//商家公告
	public static function merchant_dashboard_right_4_2() {
		$list = RC_DB::table('article as a')
 			->orderBy(RC_DB::raw('a.add_time'), 'desc')
 			->take(5)
 			->where(RC_DB::raw('a.article_type'), 'merchant_notice')
 			->get();
		if (!empty($list)) {
			foreach ($list as $k => $v) {
				if (!empty($v['add_time'])) {
					$list[$k]['add_time'] = RC_Time::local_date('m-d', $v['add_time']);
				}
			}
		}
		ecjia_merchant::$controller->assign('list', $list);
		ecjia_merchant::$controller->display(
			RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_notice.lbi', true)
		);
	}


	//操作日志
	public static function merchant_dashboard_right_4_3() {
		if (!ecjia_merchant::$controller->admin_priv('staff_log_manage', ecjia::MSGTYPE_HTML, false)) {
			return false;
		}
		$key = 'staff_log'.$_SESSION['store_id'];
	    $data = RC_Cache::app_cache_get($key, 'staff');
	    if (!$data) {
	        $data = RC_DB::table('staff_log')
	        ->leftJoin('staff_user', 'staff_log.user_id', '=', 'staff_user.user_id')
	        ->select('staff_log.*', 'staff_user.name')
	        ->where('staff_log.store_id', $_SESSION['store_id'])
	        ->orderBy('log_id', 'desc')
	        ->take(5)
	        ->get();
	        RC_Cache::app_cache_set($key, $data, 'staff', 30);
	    }
	    ecjia_admin::$controller->assign('log_lists'  , $data);

		ecjia_merchant::$controller->display(
			RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_loglist.lbi', true)
		);
	}

	public static function set_admin_login_logo() {
		$logo_img = ecjia::config('merchant_admin_login_logo') ? RC_Upload::upload_url() . '/' . ecjia::config('merchant_admin_login_logo') : ecjia_merchant::$controller->get_main_static_url(). '/img/seller_admin_logo.png';
		if ($logo_img) {
			$logo = '<img width="230" height="50" src="' . $logo_img . '" />';
		}
		return $logo;
	}
	
	public static function display_merchant_privilege_menus() {
	    $screen = ecjia_screen::get_current_screen();
	    $code = $screen->get_option('current_code');
	    
	    $menus = with(new \Ecjia\App\Merchant\Frameworks\Privilege\PrivilegeMenu())->authMenus();
	    
	    if (!empty($menus)) {
    	    echo '<ul id="myTab" class="nav nav-tabs m_b20">' . PHP_EOL;
    	    
    	    foreach ($menus as $key => $group) {
    	        if ($group->action == 'divider') {
    	        } elseif ($group->action == 'nav-header') {
    	        } else {
    	            echo '<li';
    	            
    	            if ($code == $group->action) {
    	                echo ' class="active"';
    	            }
    	            echo '>';
    	            
    	            echo '<a class="data-pjax" href="' . $group->link . '">' . $group->name . '</a></li>'.PHP_EOL;//data-pjax
    	        }
    	    }
    	    
    	    echo '</ul>'.PHP_EOL;
	    }
	}
}

RC_Hook::add_action('merchant_dashboard_top', array('merchant_staff_hooks', 'merchant_dashboard_information'));

RC_Hook::add_action('merchant_dashboard_left8', array('merchant_staff_hooks', 'merchant_dashboard_left_8_1'));
RC_Hook::add_action('merchant_dashboard_left8', array('merchant_staff_hooks', 'merchant_dashboard_left_8_2'));

RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_1'), 1);
RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_2'),3);
RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_3'), 4);

RC_Hook::add_action('ecjia_admin_logo_display', array('merchant_staff_hooks', 'set_admin_login_logo'));

RC_Hook::add_action( 'display_merchant_privilege_menus', array('merchant_staff_hooks', 'display_merchant_privilege_menus') );

// end
