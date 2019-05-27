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

class orders_merchant_plugin
{
    //订单统计
    public static function merchant_dashboard_left_8_1()
    {
        $filter['store_id']       = $_SESSION['store_id'];
        $filter['extension_code'] = 'default';
        $order_list               = with(new Ecjia\App\Orders\Repositories\OrdersRepository())
            ->getOrderList($filter, 1, 15, null, ['Ecjia\App\Orders\CustomizeOrderList', 'exportOrderListMerchant']);
        $count                    = $order_list['filter_count'];

        ecjia_merchant::$controller->assign('count', $count);

        ecjia_merchant::$controller->display(
            RC_Package::package('app::orders')->loadTemplate('merchant/library/widget_merchant_dashboard_overview.lbi', true)
        );
    }

    //店铺首页商品统计  店铺资金 订单统计类型 平台配送 商家配送 促销活动 商品热卖榜
    public static function merchant_dashboard_left_8_2()
    {
    	//商品统计
    	$store_id       = $_SESSION['store_id'];
    	//在售商品
    	$goods['selling'] = RC_DB::table('goods')
	    	->where('store_id', $store_id)
	    	->where('is_real', 1)
	    	->where('is_on_sale', 1)
	    	->whereIn('review_status', [3,5])
	    	->where('is_delete', 0)
	    	->whereRaw("(extension_code is null or extension_code ='')")
	    	->count();
    	//参与活动
    	$has_activity_input = [
	    	'is_real'				=> 1,
	    	'store_id'  			=> $store_id,
	    	'is_on_sale'			=> 1,
	    	'is_on_sale'			=> 1,
	    	'check_review_status'	=> array(3, 5),
	    	'is_delete'				=> 0,
	    	'no_need_cashier_goods'	=> true,
	    	'has_activity'			=> 1,
	    	'page'					=> 1
    	];
    	$goods_list = (new \Ecjia\App\Goods\GoodsSearch\MerchantGoodsCollection($has_activity_input))->getData();
    	$goods['has_activity'] = $goods_list['total'];
    	//待审核
    	$goods['await_check'] = RC_DB::table('goods')->where('store_id', $store_id)->where('review_status', 1)->where('is_delete', 0)->where('is_real', 1)->whereRaw("(extension_code is null or extension_code ='')")->count();
    	//已下架
    	$goods['obtained'] 	 = RC_DB::table('goods')->where('store_id', $store_id)->where('goods_number', '>', 0)->where('is_on_sale', 0)->whereIn('review_status', [3, 5])->where('is_delete', 0)->where('is_real', 1)->whereRaw("(extension_code is null or extension_code ='')")->count();
    	
    	ecjia_merchant::$controller->assign('goods', $goods);
    	
        //店铺资金
        $data = RC_DB::table('store_account')->where('store_id', $_SESSION['store_id'])->first();
        if (empty($data)) {
            $data['formated_amount_available'] = $data['formated_money'] = $data['formated_frozen_money'] = $data['formated_deposit'] = '￥0.00';
            $data['amount_available']          = $data['money'] = $data['frozen_money'] = $data['deposit'] = '0.00';
        } else {
            $amount_available                  = $data['money'] - $data['deposit']; //可用余额=money-保证金
            $data['formated_amount_available'] = price_format($amount_available);
            $data['amount_available']          = $amount_available;

            $money                  = $data['money'] + $data['frozen_money']; //总金额=money+冻结
            $data['formated_money'] = price_format($money);
            $data['money']          = $money;

            $data['formated_frozen_money'] = price_format($data['frozen_money']);
            $data['formated_deposit']      = price_format($data['deposit']);
        }

        $store_id = $_SESSION['store_id'];
        //配送型订单数及总金额
        $data['order_count'] = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where('store_id', $store_id)
            ->where(function ($query) {
                $query->where('extension_code', '')
                    ->orWhere('extension_code', null);
            })
            ->count('order_id');

        //团购型订单数及总金额
        $data['groupbuy_count'] = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where('store_id', $store_id)
            ->where('extension_code', 'group_buy')
            ->count('order_id');

        //到店型订单数及总金额
        $data['storebuy_count'] = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where('store_id', $store_id)
            ->where('extension_code', 'storebuy')
            ->count('order_id');

        //自提型订单数及总金额
        $data['storepickup_count'] = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where('store_id', $store_id)
            ->where('extension_code', 'storepickup')
            ->count('order_id');

        $data['express_platform_count'] = RC_DB::table('express_order')
            ->where(RC_DB::raw('shipping_code'), 'ship_ecjia_express')
            ->where('store_id', $store_id)
            ->select(RC_DB::raw("count(*) as count"), RC_DB::raw("SUM(IF(status = 0, 1, 0)) as wait_grab"),
                RC_DB::raw("SUM(IF(status = 1, 1, 0)) as wait_pickup"), RC_DB::raw("SUM(IF(status = 2, 1, 0)) as sending"),
                RC_DB::raw("SUM(IF(status = 5, 1, 0)) as finished"))
            ->first();

        foreach ($data['express_platform_count'] as $k => $v) {
            if (empty($data['express_platform_count'][$k])) {
                $data['express_platform_count'][$k] = 0;
            }
        }

        $data['express_merchant_count'] = RC_DB::table('express_order')
            ->where(RC_DB::raw('shipping_code'), 'ship_o2o_express')
            ->where('store_id', $store_id)
            ->select(RC_DB::raw("count(*) as count"), RC_DB::raw("SUM(IF(status = 0, 1, 0)) as wait_grab"),
                RC_DB::raw("SUM(IF(status = 1, 1, 0)) as wait_pickup"), RC_DB::raw("SUM(IF(status = 2, 1, 0)) as sending"),
                RC_DB::raw("SUM(IF(status = 5, 1, 0)) as finished"))
            ->first();

        foreach ($data['express_merchant_count'] as $k => $v) {
            if (empty($data['express_merchant_count'][$k])) {
                $data['express_merchant_count'][$k] = 0;
            }
        }

        $data['promotion_count']  = RC_DB::table('goods')->where('is_promote', 1)->where('is_delete', 0)->where('store_id', $store_id)->count();
        $data['favourable_count'] = RC_DB::table('favourable_activity')->where('store_id', $store_id)->count();
        $data['groupbuy_count']   = RC_DB::table('goods_activity')->where('act_type', GAT_GROUP_BUY)->where('store_id', $store_id)->count();
        $data['quickpay_count']   = RC_DB::table('quickpay_activity')->where('store_id', $store_id)->count();

        $sales_order_data = RC_DB::table('goods as g')
            ->leftJoin('order_goods as og', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->leftJoin('order_info as oi', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('og.order_id'))
            ->select(RC_DB::raw('og.goods_id'), RC_DB::raw('og.goods_sn'), RC_DB::raw('og.goods_name'), RC_DB::raw('oi.order_status'), RC_DB::raw('SUM(og.goods_number) AS goods_num'), RC_DB::raw('SUM(og.goods_number * og.goods_price) AS turnover'))
            ->where(RC_DB::raw('oi.is_delete'), 0)
            ->where(RC_DB::raw('g.is_delete'), 0)
            ->where(RC_DB::raw('g.store_id'), $store_id)
            ->groupBy(RC_DB::raw('og.goods_id'))
            ->orderBy('goods_num', 'desc')
            ->orderBy('turnover', 'desc')
            ->take(10)
            ->get();

        if (!empty($sales_order_data)) {
            foreach ($sales_order_data as $key => $item) {
                $sales_order_data[$key]['wvera_price'] = price_format($item['goods_num'] ? $item['turnover'] / $item['goods_num'] : 0);
                $sales_order_data[$key]['short_name']  = $item['goods_name'];
                $sales_order_data[$key]['turnover']    = price_format($item['turnover']);
                $sales_order_data[$key]['taxis']       = $key + 1;
            }
        }
        $data['sale_item'] = $sales_order_data;

        ecjia_merchant::$controller->assign('data', $data);

        ecjia_merchant::$controller->display(
            RC_Package::package('app::orders')->loadTemplate('merchant/library/widget_merchant_dashboard_commission.lbi', true)
        );
    }

    //订单走势图
    public static function merchant_dashboard_left_8_3()
    {
        if (!isset($_SESSION['store_id']) || $_SESSION['store_id'] === '') {
            $count_list = array();
        } else {
            $cache_key  = 'order_bar_chart_' . md5($_SESSION['store_id']);
            $count_list = RC_Cache::app_cache_get($cache_key, 'order');

            if (!$count_list) {
                $format     = '%Y-%m-%d';
                $time       = (RC_Time::local_mktime(0, 0, 0, RC_Time::local_date('m'), RC_Time::local_date('d'), RC_Time::local_date('Y')) - 1);
                $start_time = $time - 30 * 86400;
                $store_id   = $_SESSION['store_id'];

                $where = "add_time >= '$start_time' AND add_time <= '$time' AND store_id = $store_id AND is_delete = 0";

                $list = RC_DB::table('order_info')
                    ->select(RC_DB::raw("FROM_UNIXTIME(add_time+8*3600, '" . $format . "') AS day"), RC_DB::raw("count('order_id') AS count"))
                    ->whereRaw($where)
                    ->groupby('day')
                    ->get();

                $days = $data = $count_list = array();

                for ($i = 30; $i > 0; $i--) {
                    $days[] = RC_Time::local_date("Y-m-d", RC_Time::local_strtotime(' -' . $i . 'day'));
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

                $tmp_day   = '';
                $tmp_count = '';
                foreach ($count_list as $k => $v) {
                    $k         = intval(date('d', strtotime($k)));
                    $tmp_day   .= "'$k',";
                    $tmp_count .= "$v,";
                }

                $tmp_day             = rtrim($tmp_day, ',');
                $tmp_count           = rtrim($tmp_count, ',');
                $count_list['day']   = $tmp_day;
                $count_list['count'] = $tmp_count;

                RC_Cache::app_cache_set($cache_key, $count_list, 'order', 60 * 24); //24小时缓存
            }
        }
        ecjia_merchant::$controller->assign('order_arr', $count_list);
        ecjia_merchant::$controller->display(
            RC_Package::package('app::orders')->loadTemplate('merchant/library/widget_merchant_dashboard_bar_chart.lbi', true)
        );
    }

    public static function orders_stats_admin_menu_api($menus)
    {
        $menu = array(
            2 => ecjia_merchant::make_admin_menu('02_order_stats', __('订单统计', 'orders'), RC_Uri::url('orders/mh_order_stats/init'), 2)->add_purview('order_stats')->add_icon('fa-bar-chart-o')->add_base('stats'),
            3 => ecjia_merchant::make_admin_menu('03_sale_general', __('销售概况', 'orders'), RC_Uri::url('orders/mh_sale_general/init'), 3)->add_purview('sale_general_stats')->add_icon('fa-bar-chart-o')->add_base('stats'),
            4 => ecjia_merchant::make_admin_menu('04_sale_list', __('销售明细', 'orders'), RC_Uri::url('orders/mh_sale_list/init'), 4)->add_purview('sale_list_stats')->add_icon('fa-list')->add_base('stats'),
            5 => ecjia_merchant::make_admin_menu('05_sale_order', __('销售排行', 'orders'), RC_Uri::url('orders/mh_sale_order/init'), 5)->add_purview('sale_order_stats')->add_icon('fa-trophy')->add_base('stats'),
        );
        $menus->add_submenu($menu);
        return $menus;
    }

}


RC_Hook::add_action('merchant_dashboard_left8', array('orders_merchant_plugin', 'merchant_dashboard_left_8_1'), 1);
RC_Hook::add_action('merchant_dashboard_left8', array('orders_merchant_plugin', 'merchant_dashboard_left_8_2'), 2);
RC_Hook::add_action('merchant_dashboard_left8', array('orders_merchant_plugin', 'merchant_dashboard_left_8_3'), 3);

RC_Hook::add_filter('stats_merchant_menu_api', array('orders_merchant_plugin', 'orders_stats_admin_menu_api'));

// end
