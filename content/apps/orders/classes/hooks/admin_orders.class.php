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

class orders_admin_plugin
{

    public static function widget_admin_dashboard_orderslist()
    {

        if (!ecjia_admin::$controller->admin_priv('order_view', ecjia::MSGTYPE_HTML, false)) {
            return false;
        }

        $result = ecjia_app::validate_application('payment');
        if (is_ecjia_error($result)) {
            return false;
        }

        $title = __('最新订单');

        $order_list = RC_Cache::app_cache_get('admin_dashboard_order_list', 'orders');
        if (!$order_list) {
            $order_query = RC_Loader::load_app_class('order_query', 'orders');
            $order_list = $order_query->get_order_list(5);
            RC_Cache::app_cache_set('admin_dashboard_order_list', $order_list, 'orders', 120);
        }

        ecjia_admin::$controller->assign('title', $title);
        ecjia_admin::$controller->assign('order_count', $order_list['filter']['record_count']);
        ecjia_admin::$controller->assign('order_list', $order_list['orders']);

        ecjia_admin::$controller->assign('lang_os', RC_Lang::get('orders::order.os'));
        ecjia_admin::$controller->assign('lang_ps', RC_Lang::get('orders::order.ps'));
        ecjia_admin::$controller->assign('lang_ss', RC_Lang::get('orders::order.ss'));

        ecjia_admin::$controller->assign_lang();
        ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_orderslist.lbi', 'orders'));
    }

    public static function widget_admin_dashboard_shopstats()
    {
        $static_url = RC_App::apps_url('orders/statics/images/');
        ecjia_admin::$controller->assign('static_url', $static_url);

        $m = RC_Time::local_date('m');
        $d = RC_Time::local_date('d');
        $y = RC_Time::local_date('y');

        $start_date = RC_Time::local_mktime(0, 0, 0, $m, $d - 30, $y); //30天前 开始时间
        $end_date = RC_Time::gmtime(); //当前时间

        $data['goods_num'] = RC_DB::table('goods')->where('is_delete', 0)->where('add_time', '>=', $start_date)->count();
        $data['users_num'] = RC_DB::table('users')->where('reg_time', '>=', $start_date)->count();
        $data['orders_num'] = RC_DB::table('order_info')->where('is_delete', 0)->where('add_time', '>=', $start_date)->count();
        $data['store_num'] = RC_DB::table('store_franchisee')->where('identity_status', 2)->where('apply_time', '>=', $start_date)->count();

        ecjia_admin::$controller->assign('data', $data);
        ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_shopstats_top.lbi', 'orders'));
    }

    public static function widget_admin_dashboard_shopstats_left()
    {
        $m = RC_Time::local_date('m');
        $d = RC_Time::local_date('d');
        $y = RC_Time::local_date('y');

        $start_date = RC_Time::local_mktime(0, 0, 0, $m, $d - 30, $y); //30天前 开始时间
        $end_date = RC_Time::gmtime(); //当前时间

        //配送型订单数及总金额
        $data['order_count'] = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where(function ($query) {
                $query->where('extension_code', '')
                    ->orWhere('extension_code', null);
            })
            ->count('order_id');

        //团购型订单数及总金额
        $data['groupbuy_count'] = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where('extension_code', 'group_buy')
            ->count('order_id');

        //到店型订单数及总金额
        $data['storebuy_count'] = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where('extension_code', 'storebuy')
            ->count('order_id');

        //自提型订单数及总金额
        $data['storepickup_count'] = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where('extension_code', 'storepickup')
            ->count('order_id');

        //会员统计
        $today_start_date = RC_Time::local_mktime(0, 0, 0, $m, $d, $y);
        $data['today_num'] = RC_DB::table('users')->where('reg_time', '>=', $today_start_date)->count();

        $sevendays_start_date = RC_Time::local_mktime(0, 0, 0, $m, $d - 7, $y);
        $data['sevendays_num'] = RC_DB::table('users')->where('reg_time', '>=', $sevendays_start_date)->count();

        $thirtydays_start_date = RC_Time::local_mktime(0, 0, 0, $m, $d - 30, $y);
        $data['thritydays_num'] = RC_DB::table('users')->where('reg_time', '>=', $thirtydays_start_date)->count();

        $data['total_num'] = RC_DB::table('users')->count();

        //待处理财务统计
        $data['recharge_num'] = RC_DB::table('user_account')->where('process_type', 0)->where('is_paid', 0)->count();
        $data['withdraw_num'] = RC_DB::table('user_account')->where('process_type', 1)->where('is_paid', 0)->count();
        $data['refund_num'] = RC_DB::table('refund_payrecord')->where('action_back_time', 0)->count();
        $data['merchant_withdraw_num'] = RC_DB::table('store_account_order')->where('process_type', 'withdraw')->where('status', 1)->count();

        ecjia_admin::$controller->assign('data', $data);
        ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_shopstats_left.lbi', 'orders'));
    }

    public static function widget_admin_dashboard_shopstats_right()
    {
        $m = RC_Time::local_date('m');
        $d = RC_Time::local_date('d');
        $y = RC_Time::local_date('y');

        $start_date = RC_Time::local_mktime(0, 0, 0, $m, $d - 30, $y); //30天前 开始时间
        $end_date = RC_Time::gmtime(); //当前时间

        //配送调度统计
        $data['express_count'] = RC_DB::table('express_order')
            ->where(RC_DB::raw('shipping_code'), 'ship_ecjia_express')
            ->select(RC_DB::raw("count(*) as count"),
                RC_DB::raw("SUM(IF(status = 0, 1, 0)) as wait_grab"),
                RC_DB::raw("SUM(IF(status = 1, 1, 0)) as wait_pickup"),
                RC_DB::raw("SUM(IF(status = 2, 1, 0)) as sending"))
            ->first();

        //促销活动
        $data['promotion_count'] = RC_DB::table('goods')->where('is_promote', 1)->where('is_delete', 0)->count();
        $data['favourable_count'] = RC_DB::table('favourable_activity')->count();
        $data['groupbuy_count'] = RC_DB::table('goods_activity')->where('act_type', GAT_GROUP_BUY)->count();
        $data['quickpay_count'] = RC_DB::table('quickpay_activity')->count();

        //文章统计情况
        $today_start_date = RC_Time::local_mktime(0, 0, 0, $m, $d, $y);
        $data['today_article_count'] = RC_DB::table('article as a')
            ->leftJoin('article_cat as ac', RC_DB::raw('ac.cat_id'), '=', RC_DB::raw('a.cat_id'))
            ->where(RC_DB::raw('a.cat_id'), '!=', '0')->where(RC_DB::raw('ac.cat_type'), 'article')
            ->where(RC_DB::raw('a.store_id'), '=', '0')
            ->where(RC_DB::raw('a.add_time'), '>=', $today_start_date)
            ->count();

        $data['waitcheck_article_count'] = RC_DB::table('article as a')
            ->leftJoin('article_cat as ac', RC_DB::raw('ac.cat_id'), '=', RC_DB::raw('a.cat_id'))
            ->where(RC_DB::raw('a.cat_id'), '!=', '0')->where(RC_DB::raw('ac.cat_type'), 'article')
            ->where(RC_DB::raw('a.store_id'), '=', '0')
            ->where(RC_DB::raw('a.article_approved'), '=', 0)
            ->where(RC_DB::raw('a.article_approved'), '!=', 'spam')
            ->where(RC_DB::raw('a.article_approved'), '!=', 'trash')
            ->count();

        $data['waitcheck_comment_count'] = RC_DB::table('discuss_comments')
            ->where('comment_type', 'article')
            ->where('comment_approved', 0)
            ->where('comment_approved', '!=', 'spam')
            ->where('comment_approved', '!=', 'trash')
            ->count();

        $data['article_count'] = RC_DB::table('article as a')
            ->leftJoin('article_cat as ac', RC_DB::raw('ac.cat_id'), '=', RC_DB::raw('a.cat_id'))
            ->where(RC_DB::raw('a.cat_id'), '!=', '0')->where(RC_DB::raw('ac.cat_type'), 'article')
            ->where(RC_DB::raw('a.store_id'), '=', '0')
            ->count();

        ecjia_admin::$controller->assign('data', $data);
        ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_shopstats_right.lbi', 'orders'));
    }

    public static function widget_admin_dashboard_ordersstat()
    {
        if (!ecjia_admin::$controller->admin_priv('order_view', ecjia::MSGTYPE_HTML, false)) {
            return false;
        }
        $result = ecjia_app::validate_application('payment');
        if (is_ecjia_error($result)) {
            return false;
        }

        $title = RC_Lang::get('orders::order.order_stats_info');

        $order = RC_Cache::app_cache_get('admin_dashboard_order_stats', 'orders');
        if (!$order) {
            $order_query = RC_Loader::load_app_class('order_query', 'orders');
            $db = RC_Model::model('orders/order_info_model');

            /* 已完成的订单 */
            $order['finished'] = $db->where($order_query->order_finished())->count();
            /* 待发货的订单： */
            $order['await_ship'] = $db->where($order_query->order_await_ship())->count();
            /* 待付款的订单： */
            $order['await_pay'] = $db->where($order_query->order_await_pay())->count();
            /* “未确认”的订单 */
            $order['unconfirmed'] = $db->where($order_query->order_unconfirmed())->count();
            /* “部分发货”的订单 */
            $order['shipped_part'] = $db->where(array('shipping_status' => SS_SHIPPED_PART))->count();
            /* 退款申请 */
            $order['new_repay_count'] = RC_DB::table('user_account')->where('process_type', SURPLUS_RETURN)->where('is_paid', 0)->count();

            RC_Cache::app_cache_set('admin_dashboard_order_stats', $order, 'orders', 120);
        }

        $status['await_ship'] = CS_AWAIT_SHIP;
        $status['await_pay'] = CS_AWAIT_PAY;
        $status['shipped_part'] = OS_SHIPPED_PART;
        $status['unconfirmed'] = OS_UNCONFIRMED;
        $status['finished'] = CS_FINISHED;

        ecjia_admin::$controller->assign('title', $title);
        ecjia_admin::$controller->assign('order', $order);
        ecjia_admin::$controller->assign('status', $status);
        ecjia_admin::$controller->assign('booking_goods', $order['booking_goods_count']);
        ecjia_admin::$controller->assign('new_repay', $order['new_repay_count']);

        ecjia_admin::$controller->assign_lang();
        ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_ordersstat.lbi', 'orders'));
    }

    public static function orders_stats_admin_menu_api($menus)
    {
        $menu = array(
            ecjia_admin::make_admin_menu('divider', '', '', 50)->add_purview(array('order_stats', 'guest_stats', 'sale_general_stats', 'users_order_stats', 'sale_list_stats', 'sale_order_stats', 'visit_sold_stats', 'adsense_conversion_stats')),
            ecjia_admin::make_admin_menu('guest_stats', __('客户统计'), RC_Uri::url('orders/admin_guest_stats/init'), 51)->add_purview('guest_stats'),
            ecjia_admin::make_admin_menu('sale_general', __('销售概况'), RC_Uri::url('orders/admin_sale_general/init'), 53)->add_purview('sale_general_stats'),
            ecjia_admin::make_admin_menu('users_order', __('会员排行'), RC_Uri::url('orders/admin_users_order/init'), 54)->add_purview('users_order_stats'),
            ecjia_admin::make_admin_menu('sale_list', __('销售明细'), RC_Uri::url('orders/admin_sale_list/init'), 55)->add_purview('sale_list_stats'),
            ecjia_admin::make_admin_menu('sale_order', __('销售排行'), RC_Uri::url('orders/admin_sale_order/init'), 56)->add_purview('sale_order_stats'),
        );
        $menus->add_submenu($menu);
        return $menus;
    }

    public static function admin_remind_order()
    {
        if (isset($_SESSION['action_list']) && ecjia_admin::$controller->admin_priv('order_view', ecjia::MSGTYPE_HTML, false)) {
            $cache_key = 'admin_remind_order_' . md5($_SESSION['admin_id']);
            $remind_order = RC_Cache::app_cache_get($cache_key, 'order');
            if (empty($remind_order) || $remind_order['time'] + 5 * 60 < RC_Time::gmtime()) {
                $remind_order = RC_Api::api('orders', 'remind_order');
                RC_Cache::app_cache_set($cache_key, array('time' => RC_Time::gmtime(), 'new_orders' => $remind_order['new_orders'], 'new_paid' => $remind_order['new_paid']), 'order', 5);
                if ($remind_order['new_orders'] > 0 || $remind_order['new_paid'] > 0) {
                    $url = RC_Uri::url('orders/admin/init');
                    $html = '新订单通知：您有 <strong style="color:#ff0000">' . $remind_order['new_orders'] .
                        '</strong> 个新订单以及  <strong style="color:#ff0000">' . $remind_order['new_paid'] . '</strong> 个新付款的订单。<a href="' . $url . '"><span style="color:#ff0000">点击查看</span></a>';
                    RC_Cache::app_cache_set($cache_key, array('time' => RC_Time::gmtime()), 'order', 5);
                    ecjia_notification::make()->register('remind_order',
                        admin_notification::make($html)
                            ->setAutoclose(10000)
                            ->setType(admin_notification::TYPE_INFO)
                    );
                }
            }
        }
    }
}

// RC_Hook::add_action('admin_dashboard_top', array('orders_admin_plugin', 'widget_admin_dashboard_shopchart'));
RC_Hook::add_action('admin_dashboard_top', array('orders_admin_plugin', 'widget_admin_dashboard_shopstats'));

RC_Hook::add_action('admin_dashboard_left', array('orders_admin_plugin', 'widget_admin_dashboard_shopstats_left'), 9);
RC_Hook::add_action('admin_dashboard_right', array('orders_admin_plugin', 'widget_admin_dashboard_shopstats_right'), 9);

// RC_Hook::add_action('admin_dashboard_left', array('orders_admin_plugin', 'widget_admin_dashboard_ordersstat'));
// RC_Hook::add_action('admin_dashboard_left', array('orders_admin_plugin', 'widget_admin_dashboard_orderslist'));
RC_Hook::add_filter('stats_admin_menu_api', array('orders_admin_plugin', 'orders_stats_admin_menu_api'));

// end
