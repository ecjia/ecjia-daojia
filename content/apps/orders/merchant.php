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
 * ECJIA 订单管理
 */
class merchant extends ecjia_merchant
{

    private $db_order_info;
    private $db_order_good;
    private $db_order_view;
    private $db_order_action;
    private $db_user_rank;
    private $db_bonus;
    private $db_order_goodview;
    private $db_delivery;
    private $db_goods;
    private $db_products;
    private $db_pay_log;
    private $db_goods_attr;
    private $db_user_bonus;
    private $db_delivery_order;
    private $db_virtual_card;
    private $order_class;
    private $db_user;

    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('admin_order', 'orders');
        RC_Loader::load_app_func('merchant_order', 'orders');
        RC_Loader::load_app_func('global', 'goods');
        RC_Loader::load_app_func('global', 'orders');
        Ecjia\App\Orders\Helper::assign_adminlog_content();

        $this->db_order_info     = RC_Model::model('orders/order_info_model');
        $this->db_order_good     = RC_Model::model('orders/order_goods_model');
        $this->db_order_view     = RC_Model::model('orders/order_order_info_viewmodel');
        $this->db_order_action   = RC_Model::model('orders/order_action_model');
        $this->db_user_rank      = RC_Model::model('user/user_rank_model');
        $this->db_bonus          = RC_Model::model('orders/bonus_type_user_viewmodel');
        $this->db_order_goodview = RC_Model::model('orders/order_order_goods_viewmodel');
        $this->db_delivery       = RC_Model::model('orders/delivery_goods_model');
        $this->db_goods          = RC_Model::model('goods/goods_model');
        $this->db_products       = RC_Model::model('goods/products_model');
        $this->db_pay_log        = RC_Model::model('orders/pay_log_model');
        $this->db_goods_attr     = RC_Model::model('goods/goods_attr_model');
        $this->db_delivery_order = RC_Model::model('orders/delivery_order_model');

        $this->db_user = RC_Model::model('user/users_model');

        /* 加载所全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('ecjia-region');
        RC_Script::enqueue_script('jquery-ui');
        RC_Script::enqueue_script('smoke');

        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        RC_Script::enqueue_script('order_list', RC_App::apps_url('statics/js/merchant_orders.js', __FILE__), array(), false, 1);
        RC_Style::enqueue_style('aristo', RC_Uri::admin_url('statics/lib/jquery-ui/css/Aristo/Aristo.css'), array(), false, false);

        RC_Script::enqueue_script('jq_quicksearch', RC_Uri::admin_url('statics/lib/multi-select/js/jquery.quicksearch.js'), array('jquery'), false, true);
        RC_Style::enqueue_style('merchant_orders', RC_App::apps_url('statics/css/merchant_orders.css', __FILE__), array(), false, false);
        RC_Script::enqueue_script('order_delivery', RC_App::apps_url('statics/js/merchant_order_delivery.js', __FILE__), array(), false, 1);

        RC_Script::enqueue_script('js-sprintf');
        RC_Script::localize_script('order_list', 'js_lang', config('app-orders::jslang.merchant_page'));

        ecjia_merchant_screen::get_current_screen()->set_parentage('order', 'order/merchant.php');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单管理', 'orders'), RC_Uri::url('orders/merchant/init')));
    }

    /**
     * 订单列表
     */
    public function init()
    {
        /* 检查权限 */
        $this->admin_priv('order_view');

        RC_Script::enqueue_script('order_query', RC_App::apps_url('statics/js/merchant_order_query.js', __FILE__));

        $filter = $_GET;
        $page   = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $size   = 15;
        $with   = null;

        //判断订单类型
        if ($filter['extension_code'] == 'storebuy') {
            $order_model                = 'storebuy';
            $ur_here                    = __('到店订单', 'orders');
            $filter['composite_status'] = !empty($_GET['composite_status']) ? intval($_GET['composite_status']) : 102;
        } elseif ($filter['extension_code'] == 'cashdesk') {
            $order_model                = 'cashdesk';
            $ur_here                    = __('收银台订单', 'orders');
            $filter['composite_status'] = !empty($_GET['composite_status']) ? intval($_GET['composite_status']) : 102;
        } elseif ($filter['extension_code'] == 'storepickup') {
            $order_model                = 'storepickup';
            $ur_here                    = __('自提订单', 'orders');
            $filter['composite_status'] = !empty($_GET['composite_status']) ? intval($_GET['composite_status']) : 101;
        } elseif ($filter['extension_code'] == 'group_buy') {
            $order_model = 'groupbuy';
            $ur_here     = __('团购订单', 'orders');
        } else {
            $order_model = 'default';
            $ur_here     = __('配送订单', 'orders');
        }
        $this->assign('order_model', $order_model);

        $filter['store_id']       = $_SESSION['store_id'];
        $filter['extension_code'] = !empty($_GET['extension_code']) ? trim($_GET['extension_code']) : 'default';
        $order_list               = with(new Ecjia\App\Orders\Repositories\OrdersRepository())
            ->getOrderList($filter, $page, $size, $with, ['Ecjia\App\Orders\CustomizeOrderList', 'exportOrderListMerchant']);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
        $this->assign('ur_here', $ur_here);

        $action_link = array('href' => RC_Uri::url('orders/merchant/order_query'), 'text' => __('订单查询', 'orders'));
        $this->assign('action_link', $action_link);

        $this->assign('order_list', $order_list);

        $this->assign('filter', $filter);
        $this->assign('count', $order_list['filter_count']);

        $this->assign('form_action', RC_Uri::url('orders/merchant/operate', array('batch' => 1)));
        $this->assign('search_action', RC_Uri::url('orders/merchant/init'));

        $url_info = $this->get_search_url($filter);
        $this->assign('search_url', $url_info['url']);

        $import_url = RC_Uri::url('orders/merchant/import');
        if (!empty($url_info['param'])) {
            $import_url = RC_Uri::url('orders/merchant/import', $url_info['param']);
        }
        $this->assign('import_url', $import_url);

        $group_buy_id = isset($_GET['group_buy_id']) ? intval($_GET['group_buy_id']) : 0;
        $this->assign('group_buy_id', $group_buy_id);

        //订单状态筛选
        $status_list = with(new Ecjia\App\Orders\OrderStatus())->getOrderCsStatusList();
        if ($order_model != 'default') {
            unset($status_list[CS_UNCONFIRMED]);
        }
        $this->assign('status_list', $status_list);

        //配送方式
        $shipping_list          = ecjia_shipping::getEnableList();
        $merchant_shipping_list = RC_DB::table('shipping_area')->where('store_id', $_SESSION['store_id'])->lists('shipping_id');
        if (!empty($shipping_list)) {
            foreach ($shipping_list as $k => $v) {
                if (!in_array($v['shipping_id'], $merchant_shipping_list)) {
                    unset($shipping_list[$k]);
                }
            }
        }
        $this->assign('shipping_list', $shipping_list);

        //支付方式
        $pay_list = with(new Ecjia\App\Payment\PaymentPlugin)->getEnableList();
        $this->assign('pay_list', $pay_list);

        //下单渠道
        $referer_list = array(
            'ecjia-storebuy'    => __('到店', 'orders'),
            'ecjia-storepickup' => __('自提', 'orders'),
            'ecjia-cashdesk'    => __('收银台', 'orders'),
            'invitecode'        => __('邀请码', 'orders'),
            'mobile'            => __('手机端', 'orders'),
            'h5'                => __('H5', 'orders'),
            'weapp'             => __('小程序', 'orders'),
            'android'           => __('Andriod端', 'orders'),
            'iphone'            => __('iPhone端', 'orders'),
        );
        $this->assign('referer_list', $referer_list);

        if ($order_model == 'groupbuy') {
            return $this->display('mh_groupbuy_order_list.dwt');
        } else {
            return $this->display('mh_order_list.dwt');
        }
    }

    //当天订单
    public function today_order()
    {
        /* 检查权限 */
        $this->admin_priv('order_view');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('当天订单', 'orders')));
        RC_Script::enqueue_script('order_query', RC_App::apps_url('statics/js/merchant_order_query.js', __FILE__));

        $filter                   = $_GET;
        $page                     = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $size                     = 15;
        $with                     = null;
        $filter['today_order']    = 1;
        $filter['store_id']       = $_SESSION['store_id'];
        $filter['extension_code'] = array('default', 'storepickup');
        $order_list               = with(new Ecjia\App\Orders\Repositories\OrdersRepository())
            ->getOrderList($filter, $page, $size, $with, ['Ecjia\App\Orders\CustomizeOrderList', 'exportOrderListMerchant']);

        /* 模板赋值 */
        $this->assign('ur_here', __('当天订单', 'orders'));

        $action_link = array('href' => RC_Uri::url('orders/merchant/order_query'), 'text' => __('订单查询', 'orders'));
        $this->assign('action_link', $action_link);

        $composite_status = isset($_GET['composite_status']) ? $_GET['composite_status'] : '';
        if ($composite_status === '') {
            $composite_status = '';
        } elseif ($composite_status == 0) {
            $composite_status = 'await_confirm';
        } elseif ($composite_status == 100) {
            $composite_status = 'await_pay';
        } elseif ($composite_status == 101) {
            $composite_status = 'await_ship';
        } elseif ($composite_status == 104) {
            $composite_status = 'order_shipped';
        } elseif ($composite_status == 102) {
            $composite_status = 'order_finished';
        }
        $this->assign('composite_status', $composite_status);

        $this->assign('back_order_list', array('href' => RC_Uri::url('orders/merchant/init'), 'text' => __('订单列表', 'orders')));

        $t          = RC_Time::gmtime();
        $start_time = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m", $t), RC_Time::local_date("d", $t), RC_Time::local_date("Y", $t)); //当天开始时间
        $end_time   = RC_Time::local_mktime(23, 59, 59, RC_Time::local_date("m", $t), RC_Time::local_date("d", $t), RC_Time::local_date("Y", $t)); //当天结束时间
        $count      = get_merchant_order_count();
        $cache_key  = 'count_pay' . $start_time . $end_time;

        $count_payed = RC_Cache::app_cache_get($cache_key, 'orders');
        //有已付款新订单
        if (!empty($count['payed']) && $count['payed'] > $count_payed) {
            $this->assign('new_order', 1);
        }
        RC_Cache::app_cache_set($cache_key, $count['payed'], 'orders', 86400);

        $this->assign('count', $count);
        $this->assign('music_url', RC_App::apps_url('statics/music/', __FILE__));

        //货到付款订单 start
        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        $payment_id_row = $payment_method->payment_id_list('pay_cod');

        $payment_id = "";
        foreach ($payment_id_row as $v) {
            $payment_id = $v;
        }
        $db_order_info = RC_DB::table('order_info');
        if (!empty($payment_id)) {
            $db_order_info->where('pay_id', $payment_id);
        }

        $start_time          = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date('m'), RC_Time::local_date('d'), RC_Time::local_date('Y')); //当天开始时间
        $end_time            = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date('m'), RC_Time::local_date('d') + 1, RC_Time::local_date('Y')) - 1; //当天结束时间
        $cash_delivery       = $db_order_info
            ->select('order_id')
            ->where('store_id', $_SESSION['store_id'])
            ->where('add_time', '>=', $start_time)
            ->where('add_time', '<', $end_time)
            ->where('is_delete', 0)
            ->whereIn('order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED))
            ->groupBy('order_id')
            ->get();
        $count_cash_delivery = count($cash_delivery);

        $cache_key                 = 'cash_delivery' . $start_time . $end_time;
        $count_cash_delivery_cache = RC_Cache::app_cache_get($cache_key, 'orders');
        if (!empty($count_cash_delivery) && $count_cash_delivery > $count_cash_delivery_cache) {
            $this->assign('new_order', 1);
        }
        RC_Cache::app_cache_set($cache_key, $count_cash_delivery, 'orders', 86400);
        //货到付款订单 end

        $on_off = RC_Cache::app_cache_get('switch_on_off', 'orders');
        if (empty($on_off)) {
            $this->assign('on_off', 'on');
            RC_Cache::app_cache_set('switch_on_off', 'on', 'orders', 86400);
        } else {
            $this->assign('on_off', $on_off);
            RC_Cache::app_cache_set('switch_on_off', $on_off, 'orders', 86400);
        }
        $this->assign('payed', PS_PAYED);

        $this->assign('order_list', $order_list);

        $this->assign('filter', $filter);
        $this->assign('count', $order_list['filter_count']);

        $this->assign('form_action', RC_Uri::url('orders/merchant/operate', array('batch' => 1)));
        $this->assign('search_action', RC_Uri::url('orders/merchant/today_order'));

        $status_list = with(new Ecjia\App\Orders\OrderStatus())->getOrderCsStatusList();
        $this->assign('status_list', $status_list);
        $this->assign('search_url', RC_Uri::url('orders/merchant/today_order'));

        return $this->display('today_order_list.dwt');
    }

    /**
     * 订单详情页面
     */
    public function info()
    {
        $order_id = intval($_GET['order_id']);
        $order_sn = trim($_GET['order_sn']);

        /* 根据订单id或订单号查询订单信息 */
        $order = RC_Api::api('orders', 'merchant_order_info', array('order_id' => $order_id, 'order_sn' => $order_sn));

        if (empty($order) || is_ecjia_error($order) || $order['store_id'] != $_SESSION['store_id']) {
            return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        $order_id = $order['order_id'];
        $order_sn = $order['order_sn'];

        /* 根据订单是否完成检查权限 */
        if (order_finished($order)) {
            $this->admin_priv('order_view_finished');
        } else {
            $this->admin_priv('order_view');
        }

        if ($order['extension_code'] == 'storebuy') {
            $order_model = 'storebuy'; //到店订单
            $ur_here     = __('到店订单信息', 'orders');
        } elseif ($order['extension_code'] == 'cashdesk') {
            $order_model = 'cashdesk'; //收银台订单
            $ur_here     = __('收银台订单信息', 'orders');
        } elseif ($order['extension_code'] == 'storepickup') {
            $order_model = 'storepickup';
            $ur_here     = __('自提订单信息', 'orders');
        } elseif ($order['extension_code'] == 'group_buy') {
            $order_model = 'group_buy';
            $ur_here     = __('团购订单信息', 'orders');
        } else {
            $order_model = 'default';
            $ur_here     = __('配送订单信息', 'orders');
        }
        $url = RC_Uri::url('orders/merchant/init', array('extension_code' => $order_model));
        if ($order_model == 'default') {
            $url = RC_Uri::url('orders/merchant/init');
        }
        $extension_code_label = \Ecjia\App\Orders\OrderExtensionCode::getExtensionCodeLabel($order_model);
        $nav_here             = in_array($order_model, array('default', 'storebuy', 'storepickup', 'group_buy', 'cashdesk')) ? $extension_code_label : __('配送订单', 'orders');

        $this->assign('extension_code', $order['extension_code']);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, $url));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单信息', 'orders')));

        /*发票抬头和发票识别码处理*/
        if (!empty($order['inv_payee'])) {
            if (strpos($order['inv_payee'], ",") > 0) {
                $inv = explode(',', $order['inv_payee']);
                $this->assign('inv_payee', $inv['0']);
                $this->assign('inv_tax_no', $inv['1']);
            } else {
                $this->assign('inv_payee', $order['inv_payee']);
            }
        } else {
            $this->assign('inv_payee', $order['inv_payee']);
        }

        RC_Loader::load_app_class('merchant_order_list', 'orders', false);
        $getlast_db = new merchant_order_list();
        $getnext_db = new merchant_order_list();

        /* 取得上一个、下一个订单号 */
        $composite_status = RC_Cookie::get('composite_status');
        if (!empty($composite_status)) {
            $filter['composite_status'] = $composite_status;
            if (!empty($filter['composite_status'])) {
                //综合状态
                switch ($filter['composite_status']) {
                    case CS_AWAIT_PAY:
                        $getlast_db->order_await_pay();
                        $getnext_db->order_await_pay();
                        break;
                    case CS_AWAIT_SHIP:
                        $getlast_db->order_await_ship();
                        $getnext_db->order_await_ship();
                        break;
                    case CS_FINISHED:
                        $getlast_db->order_finished();
                        $getnext_db->order_finished();
                        break;
                    default:
                        if ($filter['composite_status'] != -1) {
                            $getlast_db->db_order_info->where(RC_DB::raw('o.order_status'), $filter['composite_status']);
                            $getnext_db->db_order_info->where(RC_DB::raw('o.order_status'), $filter['composite_status']);
                        }
                }
            }
        }

        $getlast = $getlast_db->db_order_info->where(RC_DB::raw('o.order_id'), '<', $order_id)->where(RC_DB::raw('o.is_delete'), '=', '0')->where(RC_DB::raw('o.store_id'), $_SESSION['store_id'])->where(RC_DB::raw('o.extension_code'), $order['extension_code'])->max('order_id');
        $getnext = $getnext_db->db_order_info->where(RC_DB::raw('o.order_id'), '>', $order_id)->where(RC_DB::raw('o.is_delete'), '=', '0')->where(RC_DB::raw('o.store_id'), $_SESSION['store_id'])->where(RC_DB::raw('o.extension_code'), $order['extension_code'])->min('order_id');
        
        $this->assign('prev_id', $getlast);
        $this->assign('next_id', $getnext);

        /* 取得用户名 */
        if ($order['user_id'] > 0) {
            $user = RC_Api::api('user', 'user_info', array('user_id' => $order['user_id']));
            if (!empty($user)) {
                $order['user_name'] = $user['user_name'];
            }
        }

        /* 取得区域名 */
        $order['region'] = get_regions($order_id);

        /* 格式化金额 */
        if ($order['order_amount'] < 0) {
            $order['money_refund']          = abs($order['order_amount']);
            $order['formated_money_refund'] = price_format(abs($order['order_amount']));
        }

        /* 其他处理 */
        $order['order_time']    = RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
        $order['pay_time']      = RC_Time::local_date(ecjia::config('time_format'), $order['pay_time']);
        $order['shipping_time'] = RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']);
        $order['confirm_time']  = RC_Time::local_date(ecjia::config('time_format'), $order['confirm_time']);

        $payment_info    = with(new \Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
        $order['is_cod'] = $payment_info->is_cod;

        $status          = with(new \Ecjia\App\Orders\OrderStatus())->getOrderStatusLabel($order['order_status'], $order['shipping_status'], $order['pay_status'], $order['is_cod']);
        $order['status'] = $status['0'];

        $order['invoice_no'] = $order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == SS_PREPARING ? __('未发货', 'orders') : $order['invoice_no'];

        //订单流程
        $flow_status = with(new \Ecjia\App\Orders\OrderStatus())->getOrderFlowLabel($order);
        $this->assign('flow_status', $flow_status);

        /* 取得订单的来源 */
        if ($order['from_ad'] == 0) {
            $order['referer'] = empty($order['referer']) ? __('来自本站', 'orders') : $order['referer'];
        } elseif ($order['from_ad'] == -1) {
            $order['referer'] = sprintf(__('商品站外JS投放(来自站点：%s)', 'orders'), $order['referer']);
        }

        //订单发货单流水号
        $delivery_info = RC_DB::table('order_info as oi')
            ->leftJoin('delivery_order as do', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('do.order_id'))
            ->where(RC_DB::raw('oi.order_id'), $order['order_id'])
            ->orderBy(RC_DB::raw('do.delivery_id'), 'desc')
            ->first();
        $this->assign('delivery_info', $delivery_info);

        /* 取得订单商品总重量 */
        $weight_price          = order_weight_price($order_id);
        $order['total_weight'] = $weight_price['formated_weight'];

        /* 取得用户信息 */
        if ($order['user_id'] > 0) {
            $where = array();
            /* 用户等级 */
            if ($user['user_rank'] > 0) {
                $where['rank_id'] = $user['user_rank'];
            } else {
                $where['min_points'] = array('elt' => intval($user['rank_points']));
                $orderby             = array('min_points' => 'desc');
            }
            if (isset($orderby)) {
                $user['rank_name'] = $this->db_user_rank->where($where)->order($orderby)->get_field('rank_name');
            }

            // 用户红包数量
            $day                 = RC_Time::local_getdate();
            $today               = RC_Time::local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);
            $user['bonus_count'] = $this->db_bonus->join('user_bonus')->where(array('ub.user_id' => $order['user_id'], 'ub.order_id' => 0, 'bt.use_start_date' => array('elt' => $today), 'bt.use_end_date' => array('egt' => $today)))->count();
            $this->assign('user', $user);

            // 地址信息
            $data = \Ecjia\App\User\UserAddress::UserAddressList($order['user_id']);
            $this->assign('address_list', $data);
        }

        /* 取得订单商品及货品 */
        $goods_list = array();
        $goods_attr = array();

        $this->db_order_goodview->view = array(
            'products' => array(
                'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'p',
                'field' => "o.*, IF(o.product_id > 0, p.product_number, g.goods_number) AS storage, o.goods_attr, g.suppliers_id, IFNULL(b.brand_name, '') AS brand_name, p.product_sn, g.goods_img, g.goods_sn as goods_sn",
                'on'    => 'p.product_id = o.product_id ',
            ),
            'goods'    => array(
                'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'g',
                'on'    => 'o.goods_id = g.goods_id ',
            ),
            'brand'    => array(
                'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'b',
                'on'    => 'g.brand_id = b.brand_id ',
            ),
        );
        $data                          = $this->db_order_goodview->join(array('products', 'goods', 'brand'))->where(array('o.order_id' => $order_id))->select();

        if (!empty($data)) {
            foreach ($data as $key => $row) {
                $row['formated_subtotal']    = price_format($row['goods_price'] * $row['goods_number']);
                $row['formated_goods_price'] = price_format($row['goods_price']);
                $row['goods_img']            = get_image_path($row['goods_id'], $row['goods_img']);
                $goods_attr[]                = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组

                if ($row['extension_code'] == 'package_buy') {
                    $row['storage']            = '';
                    $row['brand_name']         = '';
                    $row['package_goods_list'] = get_package_goods($row['goods_id']);
                }
                $goods_list[] = $row;
            }
        }

        $attr = array();
        $arr  = array();
        if (isset($goods_attr)) {
            foreach ($goods_attr as $index => $array_val) {
                foreach ($array_val as $value) {
                    $arr            = explode(':', $value); //以 : 号将属性拆开
                    $attr[$index][] = @array('name' => $arr[0], 'value' => $arr[1]);
                }
            }
        }

        $this->assign('goods_attr', $attr);
        $this->assign('goods_list', $goods_list);

        /* 取得能执行的操作列表 */
        $operable_list = merchant_operable_list($order);
        $this->assign('operable_list', $operable_list);

        /* 取得订单操作记录 */
        $act_list = array();
        $data     = $this->db_order_action->where(array('order_id' => $order['order_id']))->order(array('log_time' => 'asc', 'action_id' => 'asc'))->select();
        if (!empty($data)) {
            foreach ($data as $key => $row) {
                $label_status         = with(new \Ecjia\App\Orders\OrderStatus())->getOrderStatusLabel($row['order_status'], $row['shipping_status'], $row['pay_status'], $order['is_cod']);
                $row['action_status'] = $label_status[0];

                $row['action_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['log_time']);
                $act_list[]         = $row;
            }
        }
        $this->assign('action_list', $act_list);

        $express_info            = RC_DB::table('express_order')->where('order_sn', $order['order_sn'])->orderBy('express_id', 'desc')->first();
        $order['express_user']   = $express_info['express_user'];
        $order['express_mobile'] = $express_info['express_mobile'];

        /* 判断是否为上门取货*/
        $shipping_info = ecjia_shipping::getPluginDataById($order['shipping_id']);
        if ($shipping_info['shipping_code'] == "ship_cac") {
            $meta_value = RC_DB::table('term_meta')
                ->where('object_type', 'ecjia.order')
                ->where('object_group', 'order')
                ->where('meta_key', 'receipt_verification')
                ->where('object_id', $order_id)
                ->value('meta_value');

            $pickup_status = __('暂无', 'orders');
            if (!empty($meta_value)) {
                $pickup_status         = __('<span class="ecjiafc-red">未提货</span>', 'orders');
                $meta_value_encryption = '';
                $len                   = strlen($meta_value);
                $meta_value_encryption = substr_replace($meta_value, str_repeat('*', $len), 0, $len);
                $this->assign('meta_value', array('normal' => $meta_value, 'encryption' => $meta_value_encryption));

                // set the barcode content and type
                $barcodeobj = new TCPDFBarcode($meta_value, 'C39');

                // output the barcode as HTML object
                $pickup_barcode = $barcodeobj->getBarcodeHTML(1.5, 50, 'black');

                $this->assign('pickup_barcode', $pickup_barcode);
            }

            if ((($order['pay_status'] == PS_PAYED || $order['is_cod']) && $order['shipping_status'] == SS_RECEIVED)) {
                $pickup_status = __('已提货', 'orders');
            }
            $this->assign('pickup_status', $pickup_status);
        }

        /* 取得是否存在实体商品 */
        $this->assign('exist_real_goods', exist_real_goods($order['order_id']));
        $this->assign_lang();

        /* 是否打印订单，分别赋值 */
        if (isset($_GET['print'])) {
            /* 此订单的发货备注(此订单的最后一条操作记录) 打印订单中用到*/
            $order['invoice_note'] = $this->db_order_action->where(array('order_id' => $order['order_id'], 'shipping_status' => 1))->order(array('log_time' => 'DESC'))->get_field('action_note');

            $this->assign('shop_name', ecjia::config('shop_name'));
            $this->assign('shop_url', RC_Uri::home_url());
            $this->assign('shop_address', ecjia::config('shop_address'));
            $this->assign('service_phone', ecjia::config('service_phone'));
            $this->assign('print_time', RC_Time::local_date(ecjia::config('time_format')));
            $this->assign('action_user', $_SESSION['staff_name']);
            /* 参数赋值：订单 */
            $this->assign('order', $order);

            return $this->display('order_print.dwt');
        } elseif (isset($_GET['shipping_print'])) {
            /* 打印快递单 */
            $this->assign('print_time', RC_Time::local_date(ecjia::config('time_format')));
            //发货地址所在地
            $region_array   = array();
            $region_id      = ecjia::config('shop_country', ecjia::CONFIG_CHECK) ? ecjia::config('shop_country') . ',' : '';
            $region_id      .= ecjia::config('shop_province', ecjia::CONFIG_CHECK) ? ecjia::config('shop_province') . ',' : '';
            $region_id      .= ecjia::config('shop_city', ecjia::CONFIG_CHECK) ? ecjia::config('shop_city') . ',' : '';
            $region_id      = substr($region_id, 0, -1);
            $region_id_list = explode(',', $region_id);

            $region = ecjia_region::getRegions($region_id_list);
            if (!empty($region)) {
                foreach ($region as $region_data) {
                    $region_array[$region_data['region_id']] = $region_data['region_name'];
                }
            }

            $this->assign('shop_name', ecjia::config('shop_name'));
            $this->assign('order_id', $order_id);
            $this->assign('province', $region_array[ecjia::config('shop_province')]);
            $this->assign('city', $region_array[ecjia::config('shop_city')]);
            $this->assign('shop_address', ecjia::config('shop_address'));
            $this->assign('service_phone', ecjia::config('service_phone'));
            $this->assign('order', $order);

            $shipping = ecjia_shipping::getPluginDataById($order['shipping_id']);

            //打印单模式
            if ($shipping['print_model'] == 2) {
                /* 可视化 快递单*/
                /* 判断模板图片位置 */
                if (!empty($shipping['print_bg']) && trim($shipping['print_bg']) != '') {
                    $uploads_dir_info = RC_Upload::upload_dir();
                    if (mb_strstr($shipping['print_bg'], 'data/receipt')) {
                        $shipping['print_bg'] = $uploads_dir_info[baseurl] . '/' . $shipping['print_bg'];
                    } else {
                        $shipping['print_bg'] = $shipping['print_bg'];
                    }
                } else {
                    /* 使用插件默认快递单图片 */
                    $plugin_handle        = ecjia_shipping::channel($shipping['shipping_code']);
                    $shipping['print_bg'] = $plugin_handle->printBcakgroundImage();
                }
                /* 取快递单背景宽高 */
                if (!empty($shipping['print_bg'])) {
                    $_size = @getimagesize($shipping['print_bg']);
                    if ($_size != false) {
                        $shipping['print_bg_size'] = array('width' => $_size[0], 'height' => $_size[1]);
                    }
                }

                if (empty($shipping['print_bg_size'])) {
                    $shipping['print_bg_size'] = array('width' => '1024', 'height' => '600');
                }

                /* 标签信息 */
                $lable_box                        = array();
                $lable_box['t_shop_country']      = $region_array[ecjia::config('shop_country')]; //网店-国家
                $lable_box['t_shop_city']         = $region_array[ecjia::config('shop_city')]; //网店-城市
                $lable_box['t_shop_province']     = $region_array[ecjia::config('shop_province')]; //网店-省份
                $lable_box['t_shop_name']         = ecjia::config('shop_name'); //网店-名称
                $lable_box['t_shop_district']     = ''; //网店-区/县
                $lable_box['t_shop_tel']          = ecjia::config('service_phone'); //网店-联系电话
                $lable_box['t_shop_address']      = ecjia::config('shop_address'); //网店-地址
                $lable_box['t_customer_country']  = $region_array[$order['country']]; //收件人-国家
                $lable_box['t_customer_province'] = $region_array[$order['province']]; //收件人-省份
                $lable_box['t_customer_city']     = $region_array[$order['city']]; //收件人-城市
                $lable_box['t_customer_district'] = $region_array[$order['district']]; //收件人-区/县
                $lable_box['t_customer_tel']      = $order['tel']; //收件人-电话
                $lable_box['t_customer_mobel']    = $order['mobile']; //收件人-手机
                $lable_box['t_customer_post']     = $order['zipcode']; //收件人-邮编
                $lable_box['t_customer_address']  = $order['address']; //收件人-详细地址
                $lable_box['t_customer_name']     = $order['consignee']; //收件人-姓名
                $gmtime_utc_temp                  = RC_Time::gmtime(); //获取 UTC 时间戳
                $lable_box['t_year']              = date('Y', $gmtime_utc_temp); //年-当日日期
                $lable_box['t_months']            = date('m', $gmtime_utc_temp); //月-当日日期
                $lable_box['t_day']               = date('d', $gmtime_utc_temp); //日-当日日期
                $lable_box['t_order_no']          = $order['order_sn']; //订单号-订单
                $lable_box['t_order_postscript']  = $order['postscript']; //备注-订单
                $lable_box['t_order_best_time']   = $order['best_time']; //送货时间-订单
                $lable_box['t_pigeon']            = '√'; //√-对号
                $lable_box['t_custom_content']    = ''; //自定义内容

                //标签替换
                $temp_config_lable = explode('||,||', $shipping['config_lable']);
                if (!is_array($temp_config_lable)) {
                    $temp_config_lable[] = $shipping['config_lable'];
                }
                foreach ($temp_config_lable as $temp_key => $temp_lable) {
                    $temp_info = explode(',', $temp_lable);
                    if (is_array($temp_info)) {
                        $temp_info[1] = $lable_box[$temp_info[0]];
                    }
                    $temp_config_lable[$temp_key] = implode(',', $temp_info);
                }
                $shipping['config_lable'] = implode('||,||', $temp_config_lable);
                $this->assign('shipping', $shipping);

                return $this->display('print.dwt');

            } elseif (!empty($shipping['shipping_print'])) {
                //自定义模板设置
                echo $this->fetch_string(stripslashes($shipping['shipping_print']));
            } else {
                //未进行自定义设置,打印为系统默认模板
                $shipping_code = RC_DB::table('shipping')->where('shipping_id', $order['shipping_id'])->value('shipping_code');
                $plugin_handle   = ecjia_shipping::channel($shipping_code);
                $shipping_print_template  = $plugin_handle->loadPrintOption('shipping_print');

                if ($shipping_print_template) {//存在模板文件
                    return $this->display($shipping_print_template);
                } else {
                    echo __('很抱歉，目前您还没有设置打印快递单模板，不能进行打印。', 'orders');
                }
            }
        } else {
            $this->assign('ur_here', $ur_here);
            $action_link = array('href' => RC_Uri::url('orders/merchant/init'), 'text' => __('订单列表', 'orders'));
            if ($order['extension_code'] == 'group_buy') {
                $action_link = array('href' => RC_Uri::url('orders/merchant/init', array('extension_code' => 'group_buy')), 'text' => __('订单列表', 'orders'));
            }
            $this->assign('action_link', $action_link);
            $this->assign('form_action', RC_Uri::url('orders/merchant/operate'));
            $this->assign('remove_action', RC_Uri::url('orders/merchant/remove_order'));

            //无效订单 只能查看和删除 不能进行其他操作
            $invalid_order = false;
            $this->assign('invalid_order', $invalid_order);

            if ($order['pay_status'] == PS_PAYED) {
                $this->assign('has_payed', 1);
            }

            $order_referer_list     = array(
                'ecjia-storebuy'    => __('到店', 'orders'),
                'ecjia-storepickup' => __('自提', 'orders'),
                'ecjia-cashdesk'    => __('收银台', 'orders'),
                'invitecode'        => __('邀请码', 'orders'),
                'mobile'            => __('手机端', 'orders'),
                'h5'                => __('H5', 'orders'),
                'weapp'             => __('小程序', 'orders'),
                'android'           => __('安卓端', 'orders'),
                'iphone'            => __('iPhone端', 'orders'),
            );
            $order['label_referer'] = $order_referer_list[$order['referer']];
            /* 参数赋值：订单 */
            $this->assign('order', $order);
            $this->assign('order_id', $order_id);

            if ($order['order_amount'] < 0) {
                $anonymous = $order['user_id'] <= 0 ? 1 : 0;
                $this->assign('refund_url', RC_Uri::url('orders/merchant/process', 'func=load_refund&anonymous=' . $anonymous . '&order_id=' . $order['order_id'] . '&refund_amount=' . $order['money_refund']));
            }
            $order_finishied = 0;
            if (in_array($order['order_status'], array(OS_CONFIRMED, OS_SPLITED)) && in_array($order['shipping_status'], array(SS_SHIPPED, SS_RECEIVED)) && in_array($order['pay_status'], array(PS_PAYED, PS_PAYING))) {
                $order_finishied = 1;
                $this->assign('order_finished', $order_finishied);
            }

            RC_Loader::load_app_class('RefundReasonList', 'refund', false);

            //读取有关返回方式的信息（店长信息和店铺信息）
            $Manager                                   = RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('parent_id', 0)->first();
            $return_shipping_content['staff_name']     = $Manager['name'];
            $return_shipping_content['staff_mobile']   = $Manager['mobile'];
            $return_shipping_content['store_name']     = $_SESSION['store_name'];
            $store_info                                = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->select('province', 'city', 'district', 'street', 'address')->first();
            $return_shipping_content['address']        = ecjia_region::getRegionName($store_info['province']) . ecjia_region::getRegionName($store_info['city']) . ecjia_region::getRegionName($store_info['district']) . ecjia_region::getRegionName($store_info['street']) . $store_info['address'];
            $return_shipping_content['shop_kf_mobile'] = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_kf_mobile')->value('value');
            $this->assign('return_shipping_content', $return_shipping_content);

            //获取用户退货退款原因
            $reason_list = RefundReasonList::get_refund_reason();
            $this->assign('reason_list', $reason_list);

            //一键发货配送方式
            $region_id_list = array(
                $order['country'], $order['province'], $order['city'], $order['district'], $order['street'],
            );
            $shipping_list  = ecjia_shipping::availableUserShippings($region_id_list, $_SESSION['store_id']);
            $this->assign('shipping_list', $shipping_list);

            if (!empty($order['shipping_id'])) {
                $shipping_info = ecjia_shipping::getPluginDataById($order['shipping_id']);
                $this->assign('shipping_code', $shipping_info['shipping_code']);
            }

            $order_handle = true;
            $this->assign('order_model', $order_model);
            if ($order_model == 'storebuy' || $order_model == 'cashdesk') {
                return $this->display('order_storebuy_info.dwt');
            } elseif ($order_model == 'storepickup') {
                return $this->display('order_storepickup_info.dwt');
            } else {
                if ($order_model == 'group_buy') {
                    RC_Loader::load_app_func('admin_goods', 'goods');
                    $groupbuy_info = group_buy_info($order['extension_id']);
                    $this->assign('groupbuy_info', $groupbuy_info);

                    //团购活动没有成功/失败完成 禁止操作
                    if ($groupbuy_info['is_finished'] != GBS_SUCCEED_COMPLETE && $groupbuy_info ['is_finished'] != GBS_FAIL_COMPLETE) {
                        $order_handle = false;
                    }
                    $groupbuy_deposit_status = $this->get_groupbuy_deposit_status($order, $groupbuy_info);
                    $this->assign('groupbuy_deposit_status', $groupbuy_deposit_status);
                }
                $this->assign('order_handle', $order_handle);//订单是否允许操作
                return $this->display('order_info.dwt');
            }
        }
    }

    //快递单模板打印
    public function shipping_print() {
        $order_id = intval($_GET['order_id']);
        $order = RC_Api::api('orders', 'merchant_order_info', array('order_id' => $order_id));

        /* 打印快递单 */
        $this->assign('print_time', RC_Time::local_date(ecjia::config('time_format')));
        //发货地址所在地
        $region_array   = array();
        $region_id      = ecjia::config('shop_country', ecjia::CONFIG_CHECK) ? ecjia::config('shop_country') . ',' : '';
        $region_id      .= ecjia::config('shop_province', ecjia::CONFIG_CHECK) ? ecjia::config('shop_province') . ',' : '';
        $region_id      .= ecjia::config('shop_city', ecjia::CONFIG_CHECK) ? ecjia::config('shop_city') . ',' : '';
        $region_id      = substr($region_id, 0, -1);
        $region_id_list = explode(',', $region_id);

        $region = ecjia_region::getRegions($region_id_list);
        if (!empty($region)) {
            foreach ($region as $region_data) {
                $region_array[$region_data['region_id']] = $region_data['region_name'];
            }
        }

        $this->assign('shop_name', ecjia::config('shop_name'));
        $this->assign('order_id', $order_id);
        $this->assign('province', $region_array[ecjia::config('shop_province')]);
        $this->assign('city', $region_array[ecjia::config('shop_city')]);
        $this->assign('shop_address', ecjia::config('shop_address'));
        $this->assign('service_phone', ecjia::config('service_phone'));
        $this->assign('order', $order);

        $store_info = RC_DB::table('store_franchisee')->where('store_id', $order['store_id'])->first();
        $gmtime_utc_temp = RC_Time::gmtime();

        $shipping = ecjia_shipping::getPluginDataById($order['shipping_id']);

        //打印单模式-可视化 快递单
        if ($shipping['print_model'] == 2) {
            /* 判断模板图片位置 */
            if (!empty($shipping['print_bg']) && trim($shipping['print_bg']) != '') {
                $uploads_dir_info = RC_Upload::upload_dir();
                if (mb_strstr($shipping['print_bg'], 'data/receipt')) {
                    $shipping['print_bg'] = $uploads_dir_info[baseurl] . '/' . $shipping['print_bg'];
                } else {
                    $shipping['print_bg'] = $shipping['print_bg'];
                }
            } else {
                /* 使用插件默认快递单图片 */
                $plugin_handle        = ecjia_shipping::channel($shipping['shipping_code']);
                $shipping['print_bg'] = $plugin_handle->printBcakgroundImage();
            }
            /* 取快递单背景宽高 */
            if (!empty($shipping['print_bg'])) {
                $_size = @getimagesize($shipping['print_bg']);
                if ($_size != false) {
                    $shipping['print_bg_size'] = array('width' => $_size[0], 'height' => $_size[1]);
                }
            }

            if (empty($shipping['print_bg_size'])) {
                $shipping['print_bg_size'] = array('width' => '1024', 'height' => '600');
            }

            //获取店铺信息
            $templatebox = new \Ecjia\App\Shipping\ShippingTemplateBox();
            $templatebox->setTemplateData('shop_name', $store_info['merchants_name']);//网店-名称
            $templatebox->setTemplateData('shop_tel', $store_info['contact_mobile']);//网店-联系电话
            $templatebox->setTemplateData('shop_country', ecjia_region::getRegionName(ecjia::config('shop_country')));//网店-国家
            $templatebox->setTemplateData('shop_province', ecjia_region::getRegionName($store_info['province']));//网店-省份
            $templatebox->setTemplateData('shop_city', ecjia_region::getRegionName($store_info['city']));//网店-城市
            $templatebox->setTemplateData('shop_district', ecjia_region::getRegionName($store_info['district']));//网店-区/县
            $templatebox->setTemplateData('shop_street', ecjia_region::getRegionName($store_info['street']));//网店-地址
            $templatebox->setTemplateData('shop_address', $store_info['address']);//网店-地址

            //收件人信息
            $templatebox->setTemplateData('customer_name', $order['consignee']);//收件人-姓名
            $templatebox->setTemplateData('customer_tel', $order['tel']);//收件人-电话
            $templatebox->setTemplateData('customer_mobel', $order['mobile']);//收件人-手机
            $templatebox->setTemplateData('customer_post', $order['zipcode']);//收件人-邮编
            $templatebox->setTemplateData('customer_country',ecjia_region::getRegionName($order['country']));//收件人-国家
            $templatebox->setTemplateData('customer_province', ecjia_region::getRegionName($order['province']));//收件人-省份
            $templatebox->setTemplateData('customer_city', ecjia_region::getRegionName($order['city']));//收件人-城市
            $templatebox->setTemplateData('customer_district', ecjia_region::getRegionName($order['district']));//收件人-区/县
            $templatebox->setTemplateData('customer_street', ecjia_region::getRegionName($order['street']));//收件人-街道
            $templatebox->setTemplateData('customer_address', $order['address']);//收件人-详细地址

            //订单信息
            $templatebox->setTemplateData('order_no', $order['order_sn']);//订单号
            $templatebox->setTemplateData('order_postscript', $order['postscript']);//订单-备注
            $templatebox->setTemplateData('order_best_time', $order['best_time']);//订单-最佳送货时间
            $templatebox->setTemplateData('year', date('Y', $gmtime_utc_temp));//年-当日日期
            $templatebox->setTemplateData('months', date('m', $gmtime_utc_temp));//月-当日日期
            $templatebox->setTemplateData('day', date('d', $gmtime_utc_temp));//日-当日日期

            $templatebox->setTemplateData('pigeon', '√');//√-对号
            $templatebox->setTemplateData('custom_content', '');//自定义内容

            //标签替换
            $shipping['config_lable'] = $templatebox->transformPrintData($shipping['config_lable']);
            $this->assign('shipping', $shipping);

            return $this->display('print.dwt');

        } else {
            $templatebox = new \Ecjia\App\Shipping\ShippingTemplate();

            //获取店铺信息
            $templatebox = new \Ecjia\App\Shipping\ShippingTemplateBox();
            $templatebox->setTemplateData('shop_name', $store_info['merchants_name']);//网店-名称
            $templatebox->setTemplateData('shop_tel', $store_info['contact_mobile']);//网店-联系电话
            $templatebox->setTemplateData('shop_country', ecjia_region::getRegionName(ecjia::config('shop_country')));//网店-国家
            $templatebox->setTemplateData('shop_province', ecjia_region::getRegionName($store_info['province']));//网店-省份
            $templatebox->setTemplateData('shop_city', ecjia_region::getRegionName($store_info['city']));//网店-城市
            $templatebox->setTemplateData('shop_district', ecjia_region::getRegionName($store_info['district']));//网店-区/县
            $templatebox->setTemplateData('shop_street', ecjia_region::getRegionName($store_info['street']));//网店-地址
            $templatebox->setTemplateData('shop_address', $store_info['address']);//网店-地址

            //收件人信息
            $templatebox->setTemplateData('customer_name', $order['consignee']);//收件人-姓名
            $templatebox->setTemplateData('customer_tel', $order['tel']);//收件人-电话
            $templatebox->setTemplateData('customer_mobel', $order['mobile']);//收件人-手机
            $templatebox->setTemplateData('customer_post', $order['zipcode']);//收件人-邮编
            $templatebox->setTemplateData('customer_country',ecjia_region::getRegionName($order['country']));//收件人-国家
            $templatebox->setTemplateData('customer_province', ecjia_region::getRegionName($order['province']));//收件人-省份
            $templatebox->setTemplateData('customer_city', ecjia_region::getRegionName($order['city']));//收件人-城市
            $templatebox->setTemplateData('customer_district', ecjia_region::getRegionName($order['district']));//收件人-区/县
            $templatebox->setTemplateData('customer_street', ecjia_region::getRegionName($order['street']));//收件人-街道
            $templatebox->setTemplateData('customer_address', $order['address']);//收件人-详细地址

            //订单信息
            $templatebox->setTemplateData('order_no', $order['order_sn']);//订单号
            $templatebox->setTemplateData('order_postscript', $order['postscript']);//订单-备注
            $templatebox->setTemplateData('order_best_time', $order['best_time']);//订单-最佳送货时间

            $templatebox->setTemplateData('year', date('Y', $gmtime_utc_temp));//年-当日日期
            $templatebox->setTemplateData('months', date('m', $gmtime_utc_temp));//月-当日日期
            $templatebox->setTemplateData('day', date('d', $gmtime_utc_temp));//日-当日日期

            //自定义内容
            $templatebox->setTemplateData('custom_content', '');

            //获取已经成功设置过的数据
            $templatebox->getTemplateDataWithCallback(function($item, $key) {
                $this->assign($key, $item);
            });

            if (!empty($shipping['shipping_print'])) { //自定义模板设置
                echo $this->fetch_string(stripslashes($shipping['shipping_print']));
            } else {
                //未进行自定义设置,打印为系统默认模板
                $shipping_code = RC_DB::table('shipping')->where('shipping_id', $order['shipping_id'])->value('shipping_code');
                $plugin_handle   = ecjia_shipping::channel($shipping_code);
                $shipping_print_template  = $plugin_handle->loadPrintOption('shipping_print');

                if ($shipping_print_template) {//存在模板文件
                    return $this->display($shipping_print_template);
                } else {
                    return $this->showmessage(__('很抱歉，目前您还没有设置打印快递单模板，不能进行打印。', 'orders'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_HTML);
                }

            }
        }

    }

    /**
     * 根据订单号与订单id查询
     */
    public function query_info()
    {
        $this->admin_priv('order_view', ecjia::MSGTYPE_JSON);
        $keywords   = is_numeric($_POST['keywords']) ? $_POST['keywords'] : 0;
        $extension_code = remove_xss($_POST['extension_code']);

        $db = RC_DB::table('order_info')
            ->whereRaw("order_id = " . $keywords . " OR order_sn = " . $keywords . "")->where('extension_code', $extension_code);

        $query = $db->first();

        if ($extension_code == 'storebuy') {
            $extension_name = __('到店订单信息', 'orders');
        } elseif ($extension_code == 'cashdesk') {
            $extension_name = __('收银台订单信息', 'orders');
        } elseif ($extension_code == 'storepickup') {
            $extension_name = __('自提订单信息', 'orders');
        } elseif ($extension_code == 'group_buy') {
            $extension_name = __('团购订单信息', 'orders');
        } else {
            $extension_name = __('配送订单信息', 'orders');
        }

        if ($query['store_id'] != $_SESSION['store_id']) {
            return $this->showmessage(__('无法找到对应的' . $extension_name . '！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (!empty($query)) {
            $url = RC_Uri::url('orders/merchant/info', array('order_id' => $query['order_id']));
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
        } else {
            return $this->showmessage(__('订单不存在请重新搜索！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 订单查询页面
     */
    public function order_query()
    {
        /* 检查权限 */
        $this->admin_priv('order_view');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单查询', 'orders')));
        RC_Script::enqueue_script('order_query', RC_App::apps_url('statics/js/merchant_order_query.js', __FILE__));

        /* 载入配送方式 */
        $shipping_method = RC_Loader::load_app_class("shipping_method", "shipping");
        if (!empty($shipping_method)) {
            $this->assign('shipping_list', $shipping_method->shipping_list());
        }

        /* 载入支付方式 */
        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');

        if (!empty($payment_method)) {
            $this->assign('pay_list', $payment_method->available_payment_list());
        }
        $provinces = ecjia_region::getProvinces(); //获取当前国家的所有省份
        $this->assign('provinces', $provinces);

        /* 载入订单状态、付款状态、发货状态 */
        $this->assign('os_list', get_status_list('order'));
        $this->assign('ps_list', get_status_list('payment'));
        $this->assign('ss_list', get_status_list('shipping'));
        $this->assign('ur_here', __('订单查询', 'orders'));
        $this->assign('action_link', array('href' => RC_Uri::url('orders/merchant/init'), 'text' => __('订单列表', 'orders')));
        $this->assign('form_action', RC_Uri::url('orders/merchant/init'));

        $this->assign_lang();
        return $this->display('order_query.dwt');
    }

    /**
     * 合并订单
     */
    public function merge()
    {
        $this->admin_priv('order_os_edit');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('合并订单', 'orders')));
        RC_Script::enqueue_script('order_merge', RC_App::apps_url('statics/js/merchant_order_merge.js', __FILE__));

        /* 取得满足条件的订单 */
        $order_query         = RC_Loader::load_app_class('merchant_order_query');
        $where               = array();
        $where['oi.user_id'] = array('gt' => 0);
        $where               = array_merge($where, $order_query->order_unprocessed());

        $db_order_info = RC_DB::table('order_info as oi')
            ->leftJoin('users as u', RC_DB::raw('oi.user_id'), '=', RC_DB::raw('u.user_id'));

        isset($_SESSION['store_id']) ? $db_order_info->where(RC_DB::raw('oi.store_id'), $_SESSION['store_id']) : '';
        foreach ($where as $key => $val) {
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    if ($k === 'gt') {
                        $db_order_info->where(RC_DB::raw($key), '>', $v);
                    } else {
                        $db_order_info->whereIn(RC_DB::raw($key), $val);
                    }
                }
            } else {
                $db_order_info->where(RC_DB::raw($key), RC_DB::raw($val));
            }
        }

        $query = $db_order_info->select(RC_DB::raw('oi.order_sn'), RC_DB::raw('u.user_name'))->get();

        $this->assign('order_list', $query);
        $this->assign('ur_here', __('合并订单', 'orders'));
        $this->assign('action_link', array('href' => RC_Uri::url('orders/merchant/init'), 'text' => __('订单列表', 'orders')));
        $this->assign('form_action', RC_Uri::url('orders/merchant/ajax_merge_order'));

        $this->assign_lang();
        return $this->display('order_merge.dwt');
    }

    /**
     * 合并订单操作
     */
    public function ajax_merge_order()
    {

    }

    /**
     * 修改订单（载入页面）
     */
    public function edit()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit');

        /* 取得参数 order_id */
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单信息', 'orders'), RC_Uri::url("orders/merchant/info&order_id=$order_id")));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑订单', 'orders')));

        $order = RC_Api::api('orders', 'merchant_order_info', array('order_id' => $order_id));

        if (empty($order) || is_ecjia_error($order) || $order['store_id'] != $_SESSION['store_id']) {
            $links[] = array('text' => __('返回订单列表', 'orders'), 'href' => RC_Uri::url('orders/merchant/init'));
            return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }
        if ($order['order_status'] == OS_INVALID) {
            $links[] = array('text' => __('返回订单列表', 'orders'), 'href' => RC_Uri::url('orders/merchant/init'));
            return $this->showmessage(__('该订单已失效无法操作！', 'orders'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }

        /* 取得参数 step */
        $step_list = array('user', 'goods', 'consignee', 'shipping', 'payment', 'other', 'money');
        $step      = isset($_GET['step']) && in_array($_GET['step'], $step_list) ? $_GET['step'] : 'user';

        /* 取得参数 act */
        $act = ROUTE_A;
        $this->assign('order_id', $order_id);
        $this->assign('step', $step);
        $this->assign('step_act', $act);

        /* 取得订单信息 */
        if ($order_id > 0) {
            /* 发货单格式化 */
            $order['invoice_no'] = str_replace('<br>', ',', $order['invoice_no']);

            /* 如果已发货，就不能修改订单了（配送方式和发货单号除外） */
            if ($order['shipping_status'] == SS_SHIPPED || $order['shipping_status'] == SS_RECEIVED) {
                if ($step != 'shipping') {
                    return $this->showmessage(__('订单已发货！无法修改订单了（配送方式和发货单号除外）！', 'orders'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
                } else {
                    $step = 'invoice';
                    $this->assign('step', $step);
                }
            }
            $this->assign('order', $order);
        }

        /* 选择会员 */
        if ('user' == $step) {
            // 无操作
        } elseif ('goods' == $step) {
            return false; //去除编辑订单商品
            /* 增删改商品 */
            $ur_here = __('编辑订单商品信息', 'orders');
            /* 取得订单商品 */
            $goods_list = order_goods($order_id);

            if (!empty($goods_list)) {
                foreach ($goods_list as $key => $goods) {
                    /* 计算属性数 */
                    $attr = $goods['goods_attr'];
                    if ($attr == '') {
                        $goods_list[$key]['rows'] = 1;
                    } else {
                        $goods_list[$key]['rows'] = count(explode(chr(13), $attr));
                    }
                }
            }
            $this->assign('goods_list', $goods_list);
            /* 取得商品总金额 */
            $this->assign('goods_amount', order_amount($order_id));
        } elseif ('consignee' == $step) {
            // 设置收货人
            $ur_here = __('编辑订单收货人信息', 'orders');
            /* 查询是否存在实体商品 */
            $exist_real_goods = exist_real_goods($order_id);
            $this->assign('exist_real_goods', $exist_real_goods);

            /* 取得收货地址列表 */
            if ($order['user_id'] > 0) {
                $this->assign('address_list', address_list($order['user_id']));
                $address_id = isset($_GET['address_id']) ? intval($_GET['address_id']) : 0;
                if ($address_id > 0) {
                    $address = address_info($address_id);
                    if ($address) {
                        $order['consignee']     = $address['consignee'];
                        $order['country']       = $address['country'];
                        $order['province']      = $address['province'];
                        $order['city']          = $address['city'];
                        $order['district']      = $address['district'];
                        $order['email']         = $address['email'];
                        $order['address']       = $address['address'];
                        $order['zipcode']       = $address['zipcode'];
                        $order['tel']           = $address['tel'];
                        $order['mobile']        = $address['mobile'];
                        $order['sign_building'] = $address['sign_building'];
                        $order['best_time']     = $address['best_time'];
                        $this->assign('order', $order);
                    }
                }
            }

            if ($exist_real_goods) {
                $province = ecjia_region::getSubarea(ecjia::config('shop_country'));
                $city     = ecjia_region::getSubarea($order['province']);
                $district = ecjia_region::getSubarea($order['city']);
                $street   = ecjia_region::getSubarea($order['district']);

                $this->assign('province', $province);
                $this->assign('city', $city);
                $this->assign('district', $district);
                $this->assign('street', $street);
            }
        } elseif ('shipping' == $step) {
            /* 查询是否存在实体商品 */
            $exist_real_goods = exist_real_goods($order_id);
            if ($exist_real_goods) {
                // 选择配送方式
                $ur_here = __('编辑订单配送方式', 'orders');
                /* 取得可用的配送方式列表 */
                $region_id_list = array(
                    $order['country'], $order['province'], $order['city'], $order['district'], $order['street'],
                );
                $shipping_list  = ecjia_shipping::availableUserShippings($region_id_list, $_SESSION['store_id']);

                if (empty($shipping_list)) {
                    $this->assign('shipping_list_error', 1);
                }
                /* 取得配送费用 */
                $total = order_weight_price($order_id);
                if (!empty($shipping_list)) {
                    foreach ($shipping_list as $key => $shipping) {
                        $shipping_fee = ecjia_shipping::fee($shipping['shipping_area_id'], $total['weight'], $total['amount'], $total['number']);

                        $shipping_list[$key]['shipping_fee']        = $shipping_fee;
                        $shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee);
                        $shipping_list[$key]['free_money']          = price_format($shipping['configure']['free_money']);
                    }
                }
                $this->assign('shipping_list', $shipping_list);
            }
            // 选择支付方式
            $ur_heres = __('编辑订单支付方式', 'orders');
            /* 取得可用的支付方式列表 */
            $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
            if (exist_real_goods($order_id)) {
                /* 存在实体商品 */
                $region_id_list  = array(
                    $order['country'], $order['province'], $order['city'], $order['district'], $order['street'],
                );
                $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
                $shipping_area   = $shipping_method->shipping_area_info($order['shipping_id'], $region_id_list);
                $pay_fee         = ($shipping_area['support_cod'] == 1) ? $shipping_area['pay_fee'] : 0;
                $payment_list    = $payment_method->available_payment_list(true, $pay_fee);
            } else {
                /* 不存在实体商品 */
                $payment_list = $payment_method->available_payment_list(false);
            }

            /* 过滤掉使用余额支付 */
            foreach ($payment_list as $key => $payment) {
                if ($payment['pay_code'] == 'balance') {
                    unset($payment_list[$key]);
                }
            }
            $this->assign('ur_heres', $ur_heres);
            $this->assign('exist_real_goods', $exist_real_goods);
            $this->assign('payment_list', $payment_list);
        } elseif ('other' == $step) {
            // 选择包装、贺卡
            $ur_here = __('编辑订单其他信息', 'orders');
            /* 查询是否存在实体商品 */
            $exist_real_goods = exist_real_goods($order_id);
            $this->assign('exist_real_goods', $exist_real_goods);
        } elseif ('money' == $step) {
            // 费用
            $ur_here = __('编辑订单费用信息', 'orders');
            /* 查询是否存在实体商品 */
            $exist_real_goods = exist_real_goods($order_id);
            $this->assign('exist_real_goods', $exist_real_goods);
            /* 取得用户信息 */
            if ($order['user_id'] > 0) {
                $user = user_info($order['user_id']);
                /* 计算可用余额 */
                $this->assign('available_user_money', $order['surplus'] + $user['user_money']);
                /* 计算可用积分 */
                $this->assign('available_pay_points', $order['integral'] + $user['pay_points']);
                /* 取得用户可用红包 */
                RC_Loader::load_app_func('admin_bonus', 'bonus');
                $user_bonus = user_bonus($order['user_id'], $order['goods_amount']);
                if ($order['bonus_id'] > 0) {
                    $bonus        = bonus_info($order['bonus_id']);
                    $user_bonus[] = $bonus;
                }

                $this->assign('available_bonus', $user_bonus);
            }
        } elseif ('invoice' == $step) {
            // 发货后修改配送方式和发货单号
            $ur_here = __('编辑订单发货单号', 'orders');
            /* 如果不存在实体商品 */
            if (!exist_real_goods($order_id)) {
                return $this->showmessage('Hacking Attemp', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
            }

            /* 取得可用的配送方式列表 */
            $region_id_list  = array(
                $order['country'], $order['province'], $order['city'], $order['district'], $order['street'],
            );
            $shipping_method = RC_Loader::load_app_class("shipping_method", "shipping");
            $shipping_list   = $shipping_method->available_shipping_list($region_id_list, $_SESSION['store_id']);

            /* 取得配送费用 */
            $total = order_weight_price($order_id);
            foreach ($shipping_list as $key => $shipping) {
                $shipping_fee                               = $shipping_method->shipping_fee($shipping['shipping_code'], unserialize($shipping['configure']), $total['weight'], $total['amount'], $total['number']);
                $shipping_list[$key]['shipping_fee']        = $shipping_fee;
                $shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee);
                $shipping_list[$key]['free_money']          = price_format($shipping['configure']['free_money']);
            }
            $this->assign('shipping_list', $shipping_list);
        }
        $this->assign('ur_here', $ur_here);
        /* 显示模板 */
        $this->assign_lang();
        return $this->display('order_step.dwt');
    }

    /**
     * 修改订单（处理提交）
     */
    public function step_post()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);

        /* 取得参数 step */
        $step_list = array('user', 'edit_goods', 'add_goods', 'goods', 'consignee', 'shipping', 'payment', 'other', 'money', 'invoice');
        $step      = isset($_GET['step']) && in_array($_GET['step'], $step_list) ? $_GET['step'] : 'user';
        $store_id  = isset($_SESSION['store_id']) ? $_SESSION['store_id'] : '';

        /* 取得参数 order_id */
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if ($order_id > 0) {
            $old_order = order_info($order_id);
        }

        /* 取得参数 step_act 添加还是编辑 */
        $step_act = isset($_GET['step_act']) ? $_GET['step_act'] : 'add';

        /* 插入订单信息 */
        if ('user' == $step || ('user_select' == $step && $_GET['user'] == '0')) {
            /* 取得参数：user_id */
            $user_id = ($_POST['anonymous'] == 1) ? 0 : intval($_POST['user']);
            /* 插入新订单，状态为无效 */
            $order             = array(
                'user_id'         => $user_id,
                'add_time'        => RC_Time::gmtime(),
                'order_status'    => OS_INVALID,
                'shipping_status' => SS_UNSHIPPED,
                'pay_status'      => PS_UNPAYED,
                'from_ad'         => 0,
                'referer'         => __('管理员添加', 'orders'),
            );
            $order['order_sn'] = ecjia_order_buy_sn();
            $order_id          = $this->db_order_info->insert($order);
            if (!$order_id) {
                return $this->showmessage(__('订单生成失败！请重新尝试！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            ecjia_merchant::admin_log($order['order_sn'], 'add', 'order');
            /* 插入 pay_log */
            $data = array(
                'order_id'     => $order_id,
                'order_amount' => 0,
                'order_type'   => PAY_ORDER,
                'is_paid'      => 0,
            );
            $this->db_pay_log->insert($data);
            /* 下一步 */
            $url = RC_Uri::url('orders/merchant/' . $step_act, "order_id=" . $order_id . "&step=goods");
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
        } elseif ('edit_goods' == $step) {
            /* 编辑商品信息 */
            if (isset($_POST['rec_id'])) {
                foreach ($_POST['rec_id'] as $key => $rec_id) {
                    $goods_number_all = $this->db_goods->where(array('goods_id' => $_POST['goods_id'][$key]))->get_field('goods_number');

                    /* 取得参数 */
                    $goods_price  = floatval($_POST['goods_price'][$key]);
                    $goods_number = intval($_POST['goods_number'][$key]);
                    $goods_attr   = $_POST['goods_attr'][$key];
                    $product_id   = intval($_POST['product_id'][$key]);
                    if ($product_id) {
                        $goods_number_all = $this->db_products->where(array('product_id' => $_POST['product_id'][$key]))->get_field('product_number');
                    }

                    if ($goods_number_all >= $goods_number) {
                        /* 修改 */
                        $data = array(
                            'goods_price'  => $goods_price,
                            'goods_number' => $goods_number,
                            'goods_attr'   => $goods_attr,
                        );
                        $this->db_order_good->where(array('rec_id' => $rec_id))->update($data);
                    } else {
                        return $this->showmessage(__('库存不足，请重新选择！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                }

                /* 更新商品总金额和订单总金额 */
                $goods_amount = order_amount($order_id);
                update_order($order_id, array('goods_amount' => $goods_amount));
                update_order_amount($order_id);

                /* 更新 pay_log */
                update_pay_log($order_id);

                /* todo 记录日志 */
                $sn        = $old_order['order_sn'];
                $new_order = order_info($order_id);
                if ($old_order['total_fee'] != $new_order['total_fee']) {
                    $sn .= ',' . sprintf(__('订单总金额由 %s 变为 %s', 'orders'), $old_order['total_fee'], $new_order['total_fee']);
                }
                ecjia_merchant::admin_log(sprintf(__('编辑商品，订单号是%s', 'orders'), $sn), 'edit', 'order');
                $order = order_info($order_id);
                order_action($order['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_UNPAYED, $sn);
            }
            /* 商品 */
            /* 下一步 */
            if (isset($_POST['next'])) {
                $url = RC_Uri::url('orders/merchant/' . $step_act, "order_id=" . $order_id . "&step=consignee");
                return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            } elseif (isset($_POST['finish'])) {
                /* 完成 */
                /* 初始化提示信息和链接 */
                $msgs  = array();
                $links = array();
                /* 如果已付款，检查金额是否变动，并执行相应操作 */
                $order = order_info($order_id);
                handle_order_money_change($order, $msgs, $links);
                /* 显示提示信息 */
                if (!empty($msgs)) {
                    return $this->showmessage(join(chr(13), $msgs), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    /* 跳转到订单详情 */
                    $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
                    return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
                }
            }
        } elseif ('add_goods' == $step) {
            /* 添加商品 */
            /* 取得参数 */
            $goods_id = intval($_POST['goodslist']);
            if (empty($goods_id)) {
                return $this->showmessage(__('您还没有选择商品,请搜索后加入订单哦！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $goods_price = $_POST['add_price'] != 'user_input' ? floatval($_POST['add_price']) : floatval($_POST['input_price']);

                $goods_attr = '0';
                for ($i = 0; $i < $_POST['spec_count']; $i++) {
                    if (is_array($_POST['spec_' . $i])) {
                        $temp_array       = $_POST['spec_' . $i];
                        $temp_array_count = count($_POST['spec_' . $i]);
                        for ($j = 0; $j < $temp_array_count; $j++) {
                            if ($temp_array[$j] !== null) {
                                $goods_attr .= ',' . $temp_array[$j];
                            }
                        }
                    } else {
                        if ($_POST['spec_' . $i] !== null) {
                            $goods_attr .= ',' . $_POST['spec_' . $i];
                        }
                    }
                }

                $goods_number = $_POST['add_number'];
                $attr_list    = $goods_attr;
                $goods_attr   = explode(',', $goods_attr);
                $k            = array_search(0, $goods_attr);
                unset($goods_attr[$k]);

                $res = $this->db_goods_attr->field('attr_value, attr_price')->in(array('goods_attr_id' => $attr_list))->select();

                if (!empty($res)) {
                    foreach ($res as $row) {
                        $attr_value[] = $row['attr_value'];
                        $goods_price  += $row['attr_price'];
                    }
                }

                if (!empty($attr_value) && is_array($attr_value)) {
                    $attr_value = implode(",", $attr_value);
                }

                $prod = $this->db_products->find(array('goods_id' => $goods_id));
                RC_Loader::load_app_func('admin_goods', 'goods');
                //商品存在规格 是货品 检查该货品库存
                if (is_spec($goods_attr) && !empty($prod)) {
                    $product_info = get_products_info($_POST['goodslist'], $goods_attr);
                    if (!empty($goods_attr)) {
                        /* 取规格的货品库存 */
                        if ($goods_number > $product_info['product_number']) {
                            return $this->showmessage(__('库存不足，请重新选择！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                        }
                    }
                } else {
                    $goods_info = goods_info($goods_id);
                    if ($goods_number > $goods_info['goods_number']) {
                        return $this->showmessage(__('库存不足，请重新选择！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                }

                //判断该商品或货品是否在该订单中
                if (!isset($product_info['product_id'])) {
                    $product_info['product_id'] = 0;
                }
                $db_order_goods = RC_DB::table('order_goods')->where('order_id', $order_id)->where('product_id', $product_info['product_id'])->where('goods_id', $goods_id);
                $count          = $db_order_goods->count();
                if ($count != 0) {
                    return $this->showmessage(__('该商品或货品已存在该订单中，请编辑商品数量', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $row = $this->db_goods->field(' goods_id, goods_name, goods_sn, market_price, is_real, extension_code')->find(array('goods_id' => $goods_id));
                if (is_spec($goods_attr) && !empty($prod)) {
                    /* 插入订单商品 */
                    $data = array(
                        'order_id'       => $order_id,
                        'goods_id'       => $row['goods_id'],
                        'goods_name'     => $row['goods_name'],
                        'goods_sn'       => $product_info['product_sn'],
                        'product_id'     => $product_info['product_id'],
                        'goods_number'   => $goods_number,
                        'market_price'   => $row['market_price'],
                        'goods_price'    => $goods_price,
                        'goods_attr'     => $attr_value,
                        'is_real'        => $row['is_real'],
                        'extension_code' => $row['extension_code'],
                        'parent_id'      => 0,
                        'is_gift'        => 0,
                        'goods_attr_id'  => implode(',', $goods_attr),
                    );
                } else {
                    $data = array(
                        'order_id'       => $order_id,
                        'goods_id'       => $row['goods_id'],
                        'goods_name'     => $row['goods_name'],
                        'goods_sn'       => $row['goods_sn'],
                        'goods_number'   => $goods_number,
                        'market_price'   => $row['market_price'],
                        'goods_price'    => $goods_price,
                        'goods_attr'     => $attr_value,
                        'is_real'        => $row['is_real'],
                        'extension_code' => $row['extension_code'],
                        'parent_id'      => 0,
                        'is_gift'        => 0,
                    );
                }
                $this->db_order_good->insert($data);
                /* 如果使用库存，且下订单时减库存，则修改库存 */
                if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                    //（货品）
                    if (!empty($product_info['product_id'])) {
                        RC_DB::table('products')
                            ->where('product_id', $product_info['product_id'])
                            ->decrement('product_number', $goods_number);
                    }
                    RC_DB::table('goods')
                        ->where('goods_id', $goods_id)
                        ->limit(1)
                        ->decrement('goods_number', $goods_number);
                }

                /* 更新商品总金额和订单总金额 */
                update_order($order_id, array('goods_amount' => order_amount($order_id)));
                update_order_amount($order_id);
                /* 更新 pay_log */
                update_pay_log($order_id);
                /* todo 记录日志 */
                $sn        = $old_order['order_sn'];
                $new_order = order_info($order_id);
                if ($old_order['total_fee'] != $new_order['total_fee']) {
                    $sn .= ',' . sprintf(__('订单总金额由 %s 变为 %s', 'orders'), $old_order['total_fee'], $new_order['total_fee']);
                }
                ecjia_merchant::admin_log($sn, 'edit', 'order');

                /* 跳回订单商品 */
                return $this->showmessage(__('商品成功加入订单！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('orders/merchant/' . $step_act, "step=goods&order_id=" . $order_id)));
            }
        } elseif ('goods' == $step) {
            /* 商品 */
            /* 下一步 */
            if (isset($_POST['next'])) {
                $url = RC_Uri::url('orders/merchant/' . $step_act, "order_id=" . $order_id . "&step=consignee");
                return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            } elseif (isset($_POST['finish'])) {
                /* 完成 */
                /* 初始化提示信息和链接 */
                $msgs  = array();
                $links = array();
                /* 如果已付款，检查金额是否变动，并执行相应操作 */
                $order = order_info($order_id);
                handle_order_money_change($order, $msgs, $links);
                /* 显示提示信息 */
                if (!empty($msgs)) {
                    return $this->showmessage(join(chr(13), $msgs), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    /* 跳转到订单详情 */
                    $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
                    return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
                }
            }
        } elseif ('consignee' == $step) {
            /* 保存收货人信息 */
            /* 保存订单 */
            $order = $_POST;

            if (isset($order['next'])) {
                unset($order['next']);
            }
            if (isset($order['finish'])) {
                unset($order['finish']);
            }
            //如果是会员订单则读取会员地址信息
            if ($order['user_address'] > 0 && $old_order['user_id'] > 0) {
                $field  = "consignee, email, country, province, city, district, street, address, zipcode, tel,mobile, sign_building, best_time";
                $orders = RC_DB::table('user_address')->select(RC_DB::raw($field))->where('user_id', $old_order['user_id'])->where('address_id', $order['user_address'])->first();
                update_order($order_id, $orders);
            } else {
                if (isset($order['user_address'])) {
                    unset($order['user_address']);
                }
                update_order($order_id, $order);
            }
            /* todo 记录日志 */
            $sn = $old_order['order_sn'];
            ecjia_merchant::admin_log(sprintf(__('编辑收货人信息，订单编号是%s', 'orders'), $sn), 'edit', 'order');
            /* 如果是编辑且存在实体商品，检查收货人地区的改变是否影响原来选的配送 */
            if ('edit' == $step_act && exist_real_goods($order_id)) {
                $order = order_info($order_id);
                /* 取得可用配送方式 */
                $region_id_list  = array(
                    $order['country'], $order['province'], $order['city'], $order['district'], $order['street'],
                );
                $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
                $shipping_list   = $shipping_method->available_shipping_list($region_id_list, $_SESSION['store_id']);

                /* 判断订单的配送是否在可用配送之内 */
                $exist = false;
                foreach ($shipping_list as $shipping) {
                    if ($shipping['shipping_id'] == $order['shipping_id']) {
                        $exist = true;
                        break;
                    }
                }
                /* 如果不在可用配送之内，提示用户去修改配送 */
                if (!$exist) {
                    // 修改配送为空，配送费和保价费为0
                    update_order($order_id, array('shipping_id' => 0, 'shipping_name' => ''));
                    $links[] = array('text' => __('选择配送方式', 'orders'), 'href' => RC_Uri::url('orders/merchant/edit', array('order_id' => $order_id, 'step' => 'shipping')));
                    return $this->showmessage(__('由于您修改了收货人所在地区，导致原来的配送方式不再可用，请重新选择配送方式', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
                }
            }
            $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));

        } elseif ('shipping' == $step) {
            /* 保存配送信息 */
            /* 取得订单信息 */
            $order_info = order_info($order_id);

            $region_id_list = array($order_info['country'], $order_info['province'], $order_info['city'], $order_info['district'], $order_info['street']);
            /* 保存订单 */
            $shipping_id     = $_POST['shipping'];
            $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
            $shipping        = $shipping_method->shipping_area_info($shipping_id, $region_id_list, $store_id);
            $weight_amount   = order_weight_price($order_id);
            $shipping_fee    = $shipping_method->shipping_fee($shipping['shipping_code'], $shipping['configure'], $weight_amount['weight'], $weight_amount['amount'], $weight_amount['number']);
            $order           = array(
                'shipping_id'   => $shipping_id,
                'shipping_name' => addslashes($shipping['shipping_name']),
                // 'shipping_fee'    => $shipping_fee //修改配送方式 配送费不变，价格自行商家承担
            );

            if (isset($_POST['insure'])) {
                /* 计算保价费 */
                $order['insure_fee'] = shipping_insure_fee($shipping['shipping_code'], order_amount($order_id), $shipping['insure']);
            } else {
                $order['insure_fee'] = 0;
            }
            update_order($order_id, $order);
            update_order_amount($order_id);

            /* 更新 pay_log */
            update_pay_log($order_id);

            /* todo 记录日志 */
            $sn        = $old_order['order_sn'];
            $new_order = order_info($order_id);
            if ($old_order['total_fee'] != $new_order['total_fee']) {
                $sn .= ',' . sprintf(__('订单总金额由 %s 变为 %s', 'orders'), $old_order['total_fee'], $new_order['total_fee']);
            }
            ecjia_merchant::admin_log(sprintf(__('编辑支付方式与配送方式，订单是%s', 'orders'), $sn), 'edit', 'order');

            /* 取得支付信息 */
            $pay_id         = $_POST['payment'];
            $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
            $payment        = $payment_method->payment_info($pay_id);
            /* 计算支付费用 */
            $order_amount = order_amount($order_id);
            if ($payment['is_cod'] == 1) {
                $order           = order_info($order_id);
                $region_id_list  = array($order['country'], $order['province'], $order['city'], $order['district'], $order['street']);
                $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
                $shipping        = $shipping_method->shipping_area_info($order['shipping_id'], $region_id_list);
                $pay_fee         = pay_fee($pay_id, $order_amount, $shipping['pay_fee']);
            } else {
                $pay_fee = pay_fee($pay_id, $order_amount);
            }
            /* 保存订单 */
            $order = array(
                'pay_id'   => $pay_id,
                'pay_name' => addslashes($payment['pay_name']),
                'pay_fee'  => $pay_fee,
            );
            update_order($order_id, $order);
            update_order_amount($order_id);

            /* 更新 pay_log */
            update_pay_log($order_id);

            //已付款订单修改配送方式为上门取货 重新生成取货码
            if ($shipping['shipping_code'] == 'ship_cac' && $order_info['pay_status'] == PS_PAYED) {
                $db_term_meta = RC_DB::table('term_meta');
                $max_code     = $db_term_meta
                    ->where('object_type', 'ecjia.order')
                    ->where('object_group', 'order')
                    ->where('meta_key', 'receipt_verification')
                    ->max('meta_value');

                $max_code = $max_code ? ceil($max_code / 10000) : 1000000;
                $code     = $max_code . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

                $mobile  = RC_DB::table('users')->where('user_id', $order_info['user_id'])->value('mobile_phone');
                $options = array(
                    'mobile' => $mobile,
                    'event'  => 'sms_order_pickup',
                    'value'  => array(
                        'order_sn'      => $order['order_sn'],
                        'user_name'     => $order['consignee'],
                        'code'          => $code,
                        'service_phone' => ecjia::config('service_phone'),
                    ),
                );
                RC_Api::api('sms', 'send_event_sms', $options);

                $term_meta_db = RC_DB::table('term_meta')
                    ->where('object_type', 'ecjia.order')
                    ->where('object_group', 'order')
                    ->where('object_id', $order_id)
                    ->where('meta_key', 'receipt_verification');

                //判断是否存在提货码信息
                $count = $term_meta_db->count();

                //存在更新
                if ($count != 0) {
                    $term_meta_db->update(array('meta_value' => $code));
                } else {
                    //不存在添加
                    $meta_data = array(
                        'object_type'  => 'ecjia.order',
                        'object_group' => 'order',
                        'object_id'    => $order_id,
                        'meta_key'     => 'receipt_verification',
                        'meta_value'   => $code,
                    );
                    RC_DB::table('term_meta')->insert($meta_data);
                }
            }

            /* todo 记录日志 */
            $sn        = $old_order['order_sn'];
            $new_order = order_info($order_id);

            if ($old_order['total_fee'] != $new_order['total_fee']) {
                $sn .= ',' . sprintf(__('订单总金额由 %s 变为 %s', 'orders'), $old_order['total_fee'], $new_order['total_fee']);
            }
            ecjia_merchant::admin_log(sprintf(__('编辑支付方式与配送方式，订单号是%s', 'orders'), $sn), 'edit', 'order');

            if (isset($_POST['next'])) {
                /* 下一步 */
                $url = RC_Uri::url('orders/merchant/' . $step_act, "order_id=" . $order_id . "&step=other");
                return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            } elseif (isset($_POST['finish'])) {
                /* 初始化提示信息和链接 */
                $msgs  = array();
                $links = array();
                /* 如果已付款，检查金额是否变动，并执行相应操作 */
                $order = order_info($order_id);
                handle_order_money_change($order, $msgs, $links);

                /* 显示提示信息 */
                if (!empty($msgs)) {
                    return $this->showmessage(join(chr(13), $msgs), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    /* 完成 */
                    $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
                    return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
                }
            }
        } elseif ('other' == $step) {
            /* 其他处理  */
            /* 保存订单 */
            $order = array();
            if (isset($_POST['pack']) && $_POST['pack'] > 0) {

            } else {
                $order['pack_id']   = 0;
                $order['pack_name'] = '';
                $order['pack_fee']  = 0;
            }
            if (isset($_POST['card']) && $_POST['card'] > 0) {
                $order['card_message'] = $_POST['card_message'];
            } else {
                $order['card_id']      = 0;
                $order['card_name']    = '';
                $order['card_fee']     = 0;
                $order['card_message'] = '';
            }
            $order['inv_type']    = $_POST['inv_type'];
            $order['inv_payee']   = $_POST['inv_payee'];
            $order['inv_content'] = $_POST['inv_content'];
            $order['how_oos']     = $_POST['how_oos'];
            $order['postscript']  = $_POST['postscript'];
            $order['to_buyer']    = $_POST['to_buyer'];
            update_order($order_id, $order);
            update_order_amount($order_id);

            /* 更新 pay_log */
            update_pay_log($order_id);

            /* todo 记录日志 */
            $sn = $old_order['order_sn'];
            ecjia_merchant::admin_log(sprintf(__('其他信息，订单号是%s', 'orders'), $sn), 'edit', 'order');

            /* 完成 */
            $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
        } elseif ('money' == $step) {
            /* 订单生成 信息 */
            /* 取得订单信息 */
            $old_order = order_info($order_id);
            if ($old_order['user_id'] > 0) {
                /* 取得用户信息 */
                $user = user_info($old_order['user_id']);
            }

            /* 保存信息 */
            $order['goods_amount']   = $old_order['goods_amount'];
            $order['discount']       = isset($_POST['discount']) && floatval($_POST['discount']) >= 0 ? round(floatval($_POST['discount']), 2) : 0;
            $order['tax']            = round(floatval($_POST['tax']), 2);
            $order['shipping_fee']   = isset($_POST['shipping_fee']) && floatval($_POST['shipping_fee']) >= 0 ? round(floatval($_POST['shipping_fee']), 2) : 0;
            $order['insure_fee']     = isset($_POST['insure_fee']) && floatval($_POST['insure_fee']) >= 0 ? round(floatval($_POST['insure_fee']), 2) : 0;
            $order['pay_fee']        = floatval($_POST['pay_fee']) >= 0 ? round(floatval($_POST['pay_fee']), 2) : 0;
            $order['pack_fee']       = isset($_POST['pack_fee']) && floatval($_POST['pack_fee']) >= 0 ? round(floatval($_POST['pack_fee']), 2) : 0;
            $order['card_fee']       = isset($_POST['card_fee']) && floatval($_POST['card_fee']) >= 0 ? round(floatval($_POST['card_fee']), 2) : 0;
            $order['money_paid']     = $old_order['money_paid'];
            $order['surplus']        = 0;
            $order['integral']       = intval($_POST['integral']) >= 0 ? intval($_POST['integral']) : 0;
            $order['integral_money'] = 0;
            $order['bonus_id']       = 0;
            $order['bonus']          = 0;

            /* 计算待付款金额 */
            $order['order_amount'] = $order['goods_amount'] - $order['discount']
                + $order['tax']
                + $order['shipping_fee']
                + $order['insure_fee']
                + $order['pay_fee']
                + $order['pack_fee']
                + $order['card_fee']
                - $order['money_paid'];
            if ($order['order_amount'] > 0) {
                if ($old_order['user_id'] > 0) {
                    /* 如果选择了红包，先使用红包支付 */
                    if ($_POST['bonus_id'] > 0) {
                        RC_Loader::load_app_func('admin_bonus', 'bonus');
                        /* todo 检查红包是否可用 */
                        $order['bonus_id']     = $_POST['bonus_id'];
                        $bonus                 = bonus_info($_POST['bonus_id']);
                        $order['bonus']        = $bonus['type_money'];
                        $order['order_amount'] -= $order['bonus'];
                    }

                    /* 使用红包之后待付款金额仍大于0 */
                    if ($order['order_amount'] > 0) {
                        if ($old_order['extension_code'] != 'exchange_goods') {
                            /* 如果设置了积分，再使用积分支付 */
                            if (isset($_POST['integral']) && intval($_POST['integral']) > 0) {
                                /* 检查积分是否足够 */
                                $order['integral']       = intval($_POST['integral']);
                                $order['integral_money'] = value_of_integral(intval($_POST['integral']));
                                if ($old_order['integral'] + $user['pay_points'] < $order['integral']) {
                                    return $this->showmessage(__('用户积分不足', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                                }
                                $order['order_amount'] -= $order['integral_money'];
                            }
                        } else {
                            if (intval($_POST['integral']) > $user['pay_points'] + $old_order['integral']) {
                                return $this->showmessage(__('用户积分不足', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                            }
                        }
                        if ($order['order_amount'] > 0) {
                            /* 如果设置了余额，再使用余额支付 */
                            if (isset($_POST['surplus']) && floatval($_POST['surplus']) >= 0) {
                                /* 检查余额是否足够 */
                                $order['surplus'] = round(floatval($_POST['surplus']), 2);
                                if ($old_order['surplus'] + $user['user_money'] + $user['credit_line'] < $order['surplus']) {
                                    return $this->showmessage(__('用户余额不足', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                                }
                                /* 如果红包和积分和余额足以支付，把待付款金额改为0，退回部分积分余额 */
                                $order['order_amount'] -= $order['surplus'];
                                if ($order['order_amount'] < 0) {
                                    $order['surplus']      += $order['order_amount'];
                                    $order['order_amount'] = 0;
                                }
                            }
                        } else {
                            /* 如果红包和积分足以支付，把待付款金额改为0，退回部分积分 */
                            $order['integral_money'] += $order['order_amount'];
                            $order['integral']       = integral_of_value($order['integral_money']);
                            $order['order_amount']   = 0;
                        }
                    } else {
                        /* 如果红包足以支付，把待付款金额设为0 */
                        $order['order_amount'] = 0;
                    }
                }
            }

            update_order($order_id, $order);

            /* 更新 pay_log */
            update_pay_log($order_id);

            /* todo 记录日志 */
            $sn        = $old_order['order_sn'];
            $new_order = order_info($order_id);
            if ($old_order['total_fee'] != $new_order['total_fee']) {
                $sn .= ',' . sprintf(__('订单总金额由 %s 变为 %s', 'orders'), $old_order['total_fee'], $new_order['total_fee']);
            }
            ecjia_merchant::admin_log(sprintf(__('费用信息，订单编是%s', 'orders'), $sn), 'edit', 'order');

            /* 如果余额、积分、红包有变化，做相应更新 */
            if ($old_order['user_id'] > 0) {
                $user_money_change = $old_order['surplus'] - $order['surplus'];
                if ($user_money_change != 0) {
                    $options = array(
                        'user_id'     => $user['user_id'],
                        'user_money'  => $user_money_change,
                        'change_desc' => sprintf(__('编辑订单 %s ，改变使用预付款支付的金额', 'orders'), $old_order['order_sn']),
                    );
                    RC_Api::api('user', 'account_change_log', $options);
                }
                $pay_points_change = $old_order['integral'] - $order['integral'];

                if ($pay_points_change != 0) {
                    $options = array(
                        'user_id'     => $user['user_id'],
                        'pay_points'  => $pay_points_change,
                        'change_desc' => sprintf(__('编辑订单 %s ，改变使用积分支付的数量', 'orders'), $old_order['order_sn']),
                    );
                    RC_Api::api('user', 'account_change_log', $options);
                }

                if ($old_order['bonus_id'] != $order['bonus_id']) {
                    if ($old_order['bonus_id'] > 0) {
                        $data = array(
                            'used_time' => 0,
                            'order_id'  => 0,
                        );
                        RC_DB::table('user_bonus')->where('bonus_id', $old_order['bonus_id'])->update($data);
                    }

                    if ($order['bonus_id'] > 0) {
                        $data = array(
                            'used_time' => RC_Time::gmtime(),
                            'order_id'  => $order_id,
                        );
                        RC_DB::table('user_bonus')->where('bonus_id', $order['bonus_id'])->update($data);
                    }
                }
            }
            if (isset($_POST['finish'])) {
                /* 完成 */
                if ($step_act == 'add') {
                    /* 订单改为已确认，（已付款） */
                    $arr['order_status'] = OS_CONFIRMED;
                    $arr['confirm_time'] = RC_Time::gmtime();
                    if ($order['order_amount'] <= 0) {
                        $arr['pay_status'] = PS_PAYED;
                        $arr['pay_time']   = RC_Time::gmtime();
                    }
                    update_order($order_id, $arr);
                }
                /* 初始化提示信息和链接 */
                $msgs  = array();
                $links = array();
                /* 如果已付款，检查金额是否变动，并执行相应操作 */
                $order = order_info($order_id);
                handle_order_money_change($order, $msgs, $links);

                /* 显示提示信息 */
                if (!empty($msgs)) {
                    return $this->showmessage(join(chr(13), $msgs), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
                    return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
                }
            }
        } elseif ('invoice' == $step) {
            /* 保存发货后的配送方式和发货单号 */
            /* 如果不存在实体商品，退出 */
            if (!exist_real_goods($order_id)) {
                return $this->showmessage('Hacking Attemp', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
//             $shipping_method = RC_Loader::load_app_class("shipping_method","shipping");
            /* 保存订单 */
            $shipping_id = $_POST['shipping'];
            $shipping    = ecjia_shipping::pluginData($shipping_id);
            $invoice_no  = trim($_POST['invoice_no']);
            $invoice_no  = str_replace(',', '<br>', $invoice_no);
            $order       = array(
                'shipping_id'   => $shipping_id,
                'shipping_name' => addslashes($shipping['shipping_name']),
                'invoice_no'    => $invoice_no,
            );
            update_order($order_id, $order);

            /* todo 记录日志 */
            $sn = $old_order['order_sn'];
            ecjia_merchant::admin_log($sn, 'edit', 'order');

            if (isset($_POST['finish'])) {
                $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
                return $this->showmessage("", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            }
        }
    }

    /**
     * 处理
     */
    public function process()
    {
        /* 取得参数 func */
        $func = isset($_REQUEST['func']) ? $_REQUEST['func'] : '';
        /* 删除订单商品 */
        if ('drop_order_goods' == $func) {
            /* 检查权限 */
            $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);

            /* 取得参数 */
            $rec_id   = intval($_GET['rec_id']);
            $order_id = intval($_GET['order_id']);

            /* 如果使用库存，且下订单时减库存，则修改库存 */
            if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                $goods = $this->db_order_good->field('goods_id, goods_number')->find(array('rec_id' => $rec_id));
                RC_DB::table('goods')
                    ->where('goods_id', $goods['goods_id'])
                    ->increment('goods_number', $goods['goods_number']);
            }

            /* 删除 */
            $this->db_order_good->where(array('rec_id' => $rec_id))->delete();

            /* 更新商品总金额和订单总金额 */
            update_order($order_id, array('goods_amount' => order_amount($order_id)));
            update_order_amount($order_id);

            /* 跳回订单商品 */
            return $this->showmessage(__('操作成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } elseif ('cancel_order' == $func) {
            /* 取消刚添加或编辑的订单 */
            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

            /* 如果是编辑，返回订单信息 */
            $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
            return $this->showmessage("", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));

        } elseif ('refund' == $func) {
            /* 编辑订单时由于订单已付款且金额减少而退款 */
            /* 处理退款 */
            $order_id      = $_POST['order_id'];
            $refund_type   = $_POST['refund'];
            $refund_note   = $_POST['refund_note'];
            $refund_amount = $_POST['refund_amount'];
            $order         = order_info($order_id);
            $result        = order_refund($order, $refund_type, $refund_note, $refund_amount);
            if (is_ecjia_error($result)) {
                return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            /* 修改应付款金额为0，已付款金额减少 $refund_amount */
            update_order($order_id, array('order_amount' => 0, 'money_paid' => $order['money_paid'] - $refund_amount));

            /* 返回订单详情 */
            $url = RC_Uri::url('orders/merchant/info', array('order_id' => $order_id));
            return $this->showmessage("", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } elseif ('load_refund' == $func) {
            /* 载入退款页面 */
            $order_id                         = intval($_GET['order_id']);
            $anonymous                        = $_GET['anonymous'];
            $refund_amount                    = floatval($_GET['refund_amount']);
            $refund['refund_amount']          = $refund_amount;
            $refund['formated_refund_amount'] = price_format($refund_amount);
            $refund['anonymous']              = $anonymous;
            $refund['order_id']               = $order_id;
            $refund['ur_here']                = __('退款', 'orders');
            die(json_encode($refund));
        } else {
            return $this->showmessage(__('参数无效', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    public function go_shipping()
    {
        /* 查询：检查权限 */
        $this->admin_priv('order_ss_edit');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单操作：生成发货单', 'orders')));
        $order_id    = $_GET['order_id'];
        $action_note = $_GET['action_note'];

        $order_id    = intval(trim($order_id));
        $action_note = trim($action_note);

        /* 查询：根据订单id查询订单信息 */
        $order = RC_Api::api('orders', 'merchant_order_info', array('order_id' => $_GET['order_id'], 'order_sn' => $_GET['order_sn']));

        if (empty($order) || is_ecjia_error($order) || $order['store_id'] != $_SESSION['store_id']) {
            return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        /* 查询：根据订单是否完成 检查权限 */
        if (order_finished($order)) {
            $this->admin_priv('order_view_finished');
        } else {
            $this->admin_priv('order_view');
        }

        /* 查询：取得用户名 */
        if ($order['user_id'] > 0) {
            $user = user_info($order['user_id']);
            if (!empty($user)) {
                $order['user_name'] = $user['user_name'];
            }
        }

        /* 查询：取得区域名 */
        $order['region'] = get_regions($order_id);

        /* 查询：其他处理 */
        $order['order_time'] = RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
        $order['invoice_no'] = $order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == SS_PREPARING ? __('未发货', 'orders') : $order['invoice_no'];

        /* 查询：是否保价 */
        $order['insure_yn'] = empty($order['insure_fee']) ? 0 : 1;

        /* 查询：是否存在实体商品 */
        $exist_real_goods = exist_real_goods($order_id);

        /* 查询：取得订单商品 */
        $_goods = get_order_goods(array('order_id' => $order['order_id'], 'order_sn' => $order['order_sn']));

        $attr       = $_goods['attr'];
        $goods_list = $_goods['goods_list'];
        unset($_goods);

        /* 查询：商品已发货数量 此单可发货数量 */
        if ($goods_list) {
            foreach ($goods_list as $key => $goods_value) {
                if (!$goods_value['goods_id']) {
                    continue;
                }
                /* 超级礼包 */
                if (($goods_value['extension_code'] == 'package_buy') && (count($goods_value['package_goods_list']) > 0)) {
                    $goods_list[$key]['package_goods_list'] = package_goods($goods_value['package_goods_list'], $goods_value['goods_number'], $goods_value['order_id'], $goods_value['extension_code'], $goods_value['goods_id']);

                    foreach ($goods_list[$key]['package_goods_list'] as $pg_key => $pg_value) {
                        $goods_list[$key]['package_goods_list'][$pg_key]['readonly'] = '';
                        /* 使用库存 是否缺货 */
                        if ($pg_value['storage'] <= 0 && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
                            $goods_list[$key]['package_goods_list'][$pg_key]['send']     = __('商品已缺货', 'orders');
                            $goods_list[$key]['package_goods_list'][$pg_key]['readonly'] = 'readonly="readonly"';
                        } /* 将已经全部发货的商品设置为只读 */
                        elseif ($pg_value['send'] <= 0) {
                            $goods_list[$key]['package_goods_list'][$pg_key]['send']     = __('货已发完', 'orders');
                            $goods_list[$key]['package_goods_list'][$pg_key]['readonly'] = 'readonly="readonly"';
                        }
                    }
                } else {
                    $goods_list[$key]['sended'] = $goods_value['send_number'];
                    $goods_list[$key]['send']   = $goods_value['goods_number'] - $goods_value['send_number'];

                    $goods_list[$key]['readonly'] = '';
                    /* 是否缺货 */
                    if ($goods_value['storage'] <= 0 && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
                        $goods_list[$key]['send']     = __('商品已缺货', 'orders');
                        $goods_list[$key]['readonly'] = 'readonly="readonly"';
                    } elseif ($goods_list[$key]['send'] <= 0) {
                        $goods_list[$key]['send']     = __('货已发完', 'orders');
                        $goods_list[$key]['readonly'] = 'readonly="readonly"';
                    }
                }
            }
        }

        if (!empty($order['shipping_id'])) {
            $shipping_info = ecjia_shipping::getPluginDataById($order['shipping_id']);
            $this->assign('shipping_code', $shipping_info['shipping_code']);
        }

        $this->assign('order', $order);
        $this->assign('exist_real_goods', $exist_real_goods);
        $this->assign('goods_attr', $attr);
        $this->assign('goods_list', $goods_list);
        $this->assign('order_id', $order_id); // 订单id
        $this->assign('operation', 'split'); // 订单id
        $this->assign('action_note', $action_note); // 发货操作信息
        /* 显示模板 */
        $this->assign('ur_here', __('订单操作：生成发货单', 'orders'));
        $this->assign('form_action', RC_Uri::url('orders/merchant/operate_post'));

        $this->assign_lang();
        return $this->display('order_delivery_info.dwt');
    }

    public function operate_note()
    {
        /* 检查权限 */
        $this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);

        $order = RC_Api::api('orders', 'merchant_order_info', array('order_id' => $_GET['order_id'], 'order_sn' => $_GET['order_sn']));

        if (empty($order) || is_ecjia_error($order) || $order['store_id'] != $_SESSION['store_id']) {
            return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        /* 取得订单id（可能是多个，多个sn）和操作备注（可能没有） */
        if (isset($_REQUEST['order_id'])) {
            /* 判断是一个还是多个 */
            if (is_array($_REQUEST['order_id'])) {
                $order_id = implode(',', $_REQUEST['order_id']);
            } else {
                $order_id = $_REQUEST['order_id'];
            }
        }
        /* 确认 */
        if (isset($_GET['confirm'])) {
            $require_note = false;
            $action       = __('确认', 'orders');
            $operation    = 'confirm';
        } elseif (isset($_GET['pay'])) {
//            /* 付款 */
//            $require_note = ecjia::config('order_pay_note') == 1 ? true : false;
//            $action       = __('付款', 'orders');
//            $operation    = 'pay';
        } elseif (isset($_GET['unpay'])) {
//            /* 未付款 */
//            $require_note = ecjia::config('order_unpay_note') == 1 ? true : false;
//            $order        = order_info($order_id);
//            if ($order['money_paid'] > 0) {
//                $show_refund = true;
//            }
//            $anonymous = $order['user_id'] == 0;
//            $action    = __('设为未付款', 'orders') ? true : false;
//            $operation = 'unpay';
        } elseif (isset($_GET['prepare'])) {
            /* 配货 */
            $require_note = false;
            $action       = __('配货', 'orders') ? true : false;
            $operation    = 'prepare';
        } elseif (isset($_GET['unship'])) {
            /* 未发货 */
            $require_note = ecjia::config('order_unship_note') == 1 ? true : false;
            $action       = __('未发货', 'orders');
            $operation    = 'unship';
        } elseif (isset($_GET['receive'])) {
            /* 收货确认 */
            $require_note = ecjia::config('order_receive_note') == 1 ? true : false;
            $action       = __('已收货', 'orders');
            $operation    = 'receive';
        } elseif (isset($_GET['cancel'])) {
            /* 取消 */
            $require_note     = ecjia::config('order_cancel_note') == 1 ? true : false;
            $action           = __('取消', 'orders');
            $operation        = 'cancel';
            $show_cancel_note = true;
            $order            = order_info($order_id);
            if ($order['money_paid'] > 0) {
                $show_refund = true;
            }
            $anonymous = $order['user_id'] == 0;
        } elseif (isset($_GET['invalid'])) {
            /* 无效 */
            $require_note = ecjia::config('order_invalid_note') == 1 ? true : false;
            $action       = __('无效', 'orders');
            $operation    = 'invalid';
        } elseif (isset($_GET['after_service'])) {
            /* 售后 */
            $require_note = true;
            $action       = __('售后', 'orders');
            $operation    = 'after_service';
        } elseif (isset($_GET['confirm_return'])) {
            /* 退货退款确认 */
            $action    = __('退货确认', 'orders');
            $operation = 'confirm_return';
        } elseif (isset($_GET['return'])) {
            /* 退货 */
            $require_note = ecjia::config('order_return_note') == 1 ? true : false;
            $order        = order_info($order_id);
            if ($order['money_paid'] > 0) {
                $show_refund = true;
            }
            $anonymous = $order['user_id'] == 0;
            $action    = __('退货', 'orders');
            $operation = 'return';
        }
        $result = array();
        /* 直接处理还是跳到详细页面 */
        if ($require_note || isset($show_invoice_no) || isset($show_refund)) {
            $result['result']           = false;
            $result['require_note']     = $require_note; // 是否要求填写备注
            $result['show_cancel_note'] = isset($show_cancel_note); // 是否要求填写备注
            $result['show_invoice_no']  = isset($show_invoice_no); // 是否显示发货单号
            $result['show_refund']      = isset($show_refund); // 是否显示退款
            $result['anonymous']        = isset($anonymous) ? $anonymous : true; // 是否匿名
            if ($result['show_cancel_note'] || $result['show_invoice_no'] || $result['show_refund']) {
                $result['result'] = true;
            }
        }

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $result);
    }

    /**
     * 操作订单状态（载入页面）
     */
    public function operate()
    {
        /* 检查权限 */
        $this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);
        $order_id = '';
        /* 取得订单id（可能是多个，多个sn）和操作备注（可能没有） */
        if (isset($_REQUEST['order_id'])) {
            /* 判断是一个还是多个 */
            if (is_array($_REQUEST['order_id'])) {
                $order_id = implode(',', $_REQUEST['order_id']);
            } else {
                $order_id = $_REQUEST['order_id'];
            }
        }

        $batch       = isset($_GET['batch']); // 是否批处理
        $action_note = isset($_POST['action_note']) ? trim($_POST['action_note']) : '';
        $operation   = isset($_POST['operation']) ? $_POST['operation'] : ''; // 订单操作

        if (!empty($_REQUEST['order_id'])) {
            $order_id = $_REQUEST['order_id'];

            $db_order_info = RC_DB::table('order_info');
            if (is_array($order_id) || strpos($order_id, ',')) {
                if (strpos($order_id, ',')) {
                    $order_id = explode(',', $order_id);
                }
                $db_order_info->whereIn('order_id', $order_id);
            } else {
                $db_order_info->where('order_id', $order_id);
            }

            isset($_SESSION['store_id']) ? $db_order_info->where('store_id', $_SESSION['store_id']) : '';
            $order_id_list = $db_order_info->lists('order_id');

            if (empty($order_id_list)) {
                return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 取得订单id（可能是多个，多个sn）和操作备注（可能没有） */
        $batch       = isset($_GET['batch']); // 是否批处理
        $action_note = isset($_POST['action_note']) ? trim($_POST['action_note']) : '';
        $operation   = $_POST['operation']; // 订单操作

        /* 确认 */
        if (isset($_GET['confirm'])) {
            $require_note = false;
            $action       = __('确认', 'orders');
            $operation    = 'confirm';
        } elseif (isset($_GET['pay'])) {
            /* 付款 */
            /* 检查权限 */
            $this->admin_priv('order_ps_edit', ecjia::MSGTYPE_JSON);
            $require_note = ecjia::config('order_pay_note');
            $action       = __('付款', 'orders');
            $operation    = 'pay';
        } elseif (isset($_GET['unpay'])) {
            /* 未付款 */
            /* 检查权限 */
            $this->admin_priv('order_ps_edit', ecjia::MSGTYPE_JSON);

            $require_note = ecjia::config('order_unpay_note');
            $order        = order_info($order_id);
            if ($order['money_paid'] > 0) {
                $show_refund = true;
            }
            $anonymous = $order['user_id'] == 0;
            $action    = __('设为未付款', 'orders');
            $operation = 'unpay';
        } elseif (isset($_GET['prepare'])) {
            /* 配货 */
            $require_note = false;
            $action       = __('配货', 'orders');
            $operation    = 'prepare';
        } elseif (isset($_GET['ship'])) {
            /* 生成发货单 */
            //内容新添了一个func处理
            $url = RC_Uri::url('orders/merchant/go_shipping', 'order_id=' . $order_id . '&action_note=' . $action_note);
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
        } elseif (isset($_GET['unship'])) {
            /* 未发货 */
            /* 检查权限 */
            $this->admin_priv('order_ss_edit', ecjia::MSGTYPE_JSON);
            $require_note = ecjia::config('order_unship_note');
            $action       = __('未发货', 'orders');
            $operation    = 'unship';
        } elseif (isset($_GET['receive'])) {
            return false; //商家后台去除
            /* 收货确认 */
            $require_note = ecjia::config('order_receive_note') == 1;
            $action       = __('已收货', 'orders');
            $operation    = 'receive';
        } elseif (isset($_GET['cancel'])) {
            /* 取消 */
            $require_note     = ecjia::config('order_cancel_note');
            $action           = __('取消', 'orders');
            $operation        = 'cancel';
            $show_cancel_note = true;
            $order            = order_info($order_id);
            if ($order['money_paid'] > 0) {
                $show_refund = true;
            }
            $anonymous = $order['user_id'] == 0;
        } elseif (isset($_GET['invalid'])) {
            /* 无效 */
            $require_note = ecjia::config('order_invalid_note');
            $action       = __('无效', 'orders');
            $operation    = 'invalid';
        } elseif (isset($_GET['after_service'])) {
            /* 售后 */
            $require_note = true;
            $action       = __('售后', 'orders');
            $operation    = 'after_service';
        } elseif (isset($_GET['confirm_return'])) {
            /* 退货退款确认 */
            $require_note = true;
            $action       = __('退货确认', 'orders');
            $operation    = 'confirm_return';
        } elseif (isset($_GET['return'])) {
            /* 退货 */
            $require_note = ecjia::config('order_return_note') == 1;
            $order        = order_info($order_id);
            if ($order['money_paid'] > 0) {
                $show_refund = true;
            }
            $anonymous = $order['user_id'] == 0;
            $action    = __('退货', 'orders');
            $operation = 'return';
        } elseif (isset($_GET['assign'])) {
            /* 指派 */
            /* 取得参数 */
            $new_agency_id = isset($_POST['agency_id']) ? intval($_POST['agency_id']) : 0;
            if ($new_agency_id == 0) {
                return $this->showmessage(__('请选择办事处！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 查询订单信息 */
            $order = order_info($order_id);

            /* 操作成功 */
            $links[] = array('href' => RC_Uri::url('orders/merchant/init'), 'text' => __('订单列表', 'orders'));
            return $this->showmessage(__('操作成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
        } elseif (isset($_GET['remove'])) {
            /* 订单删除 */
            $this->remove_order();
        } elseif (isset($_GET['print'])) {
            /* 赋值公用信息 */
            $this->assign('shop_name', ecjia::config('shop_name'));
            $this->assign('shop_url', SITE_URL);
            $this->assign('shop_address', ecjia::config('shop_address'));
            $this->assign('service_phone', ecjia::config('service_phone'));
            $this->assign('print_time', RC_Time::local_date(ecjia::config('time_format')));
            $this->assign('action_user', $_SESSION['staff_name']);

            $html = '';

            $order_id_array = is_array($order_id) ? $order_id : explode(',', $order_id);

            foreach ($order_id_array as $id) {
                /* 取得订单信息 */
                $order = order_info($id);
                if (empty($order)) {
                    continue;
                }

                /* 根据订单是否完成检查权限 */
                if (order_finished($order)) {
                    if (!$this->admin_priv('order_view_finished', '', false)) {
                        continue;
                    }
                } else {
                    if (!$this->admin_priv('order_view', '', false)) {
                        continue;
                    }
                }
                /* 取得用户名 */
                if ($order['user_id'] > 0) {
                    $user = user_info($order['user_id']);
                    if (!empty($user)) {
                        $order['user_name'] = $user['user_name'];
                    }
                }

                /* 取得区域名 */
                $order['region'] = get_regions($id);


                $ss_label  = __('未发货', 'orders');
                $ps_label  = __('未付款', 'orders');
                $os_status = with(new Ecjia\App\Orders\OrderStatus())->getOrderOsStatusLabel($order['order_status']);
                $ps_status = with(new Ecjia\App\Orders\OrderStatus())->getOrderPsStatusLabel($order['pay_status']);
                $ss_status = with(new Ecjia\App\Orders\OrderStatus())->getOrderSsStatusLabel($order['shipping_status']);

                /* 其他处理 */
                $order['order_time']    = RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
                $order['pay_time']      = $order['pay_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $order['pay_time']) : $ps_label;
                $order['shipping_time'] = $order['shipping_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']) : $ss_label;
                $order['status']        = $os_status . ',' . $ps_status . ',' . $ss_status;
                $order['invoice_no']    = $order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == SS_PREPARING ? $ss_label : $order['invoice_no'];

                /* 此订单的发货备注(此订单的最后一条操作记录) */

                $order['invoice_note'] = $this->db_order_action->where(array('order_id' => $order['order_id'], 'shipping_status' => 1))->order(array('log_time' => 'DESC'))->get_field('action_note');
                /* 参数赋值：订单 */
                $this->assign('order', $order);

                /* 取得订单商品 */
                $goods_list = array();
                $goods_attr = array();

                $this->db_order_goodview->view = array(
                    'goods' => array(
                        'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                        'alias' => 'g',
                        'field' => "o.*, g.goods_number AS storage, o.goods_attr, IFNULL(b.brand_name, '') AS brand_name",
                        'on'    => 'o.goods_id =  g.goods_id',
                    ),
                    'brand' => array(
                        'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                        'alias' => 'b',
                        'on'    => 'g.brand_id = b.brand_id ',
                    ),
                );

                $data = $this->db_order_goodview->where(array('o.order_id' => $order['order_id']))->select();

                foreach ($data as $key => $row) {
                    $row['formated_subtotal']    = price_format($row['goods_price'] * $row['goods_number']);
                    $row['formated_goods_price'] = price_format($row['goods_price']);

                    $goods_attr[] = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组
                    $goods_list[] = $row;
                }

                $attr = array();
                $arr  = array();
                foreach ($goods_attr as $index => $array_val) {
                    foreach ($array_val as $value) {
                        $arr            = explode(':', $value); //以 : 号将属性拆开
                        $attr[$index][] = @array('name' => $arr[0], 'value' => $arr[1]);
                    }
                }

                $this->assign('goods_attr', $attr);
                $this->assign('goods_list', $goods_list);

                $this->assign_lang();
                $html .= $this->fetch('order_print.dwt') . '<div style="PAGE-BREAK-AFTER:always"></div>';
            }
            echo $html;
            exit;

        } elseif (isset($_GET['to_delivery'])) {
            $require_note = ecjia::config('order_ship_note');
            /*判断备注是否填写*/
            if ($require_note == 1 && empty($_POST['action_note']) && $batch != 1) {
                return $this->showmessage(__('请填写备注信息！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            /* 去发货 */
            $url = RC_Uri::url('orders/mh_delivery/init', array('order_sn' => $_GET['order_sn'], 'type' => 2));
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
        }

        /*判断备注是否填写*/
        if ($require_note == 1 && empty($_POST['action_note']) && $batch != 1) {
            return $this->showmessage(__('请填写备注信息！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 直接处理 */
        if (!$batch) {
            /* 一个订单 */
            return $this->operate_post();
        } else {
            /* 多个订单 */
            return $this->batch_operate_post();

        }
    }

    /**
     * 操作订单状态（处理批量提交）
     */
    public function batch_operate_post()
    {
        /* 检查权限 */
        $this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);

        /* 取得参数 */
        $extension_code = isset($_GET['extension_code']) ? $_GET['extension_code'] : '';
        $order_id_list  = $_POST['order_id']; // 订单id（逗号格开的多个订单id）
        $operation      = isset($_POST['operation']) ? $_POST['operation'] : $_GET['operation']; // 订单操作
        $action_note    = $_POST['action_note']; // 操作备注

        if (!is_array($order_id_list)) {
            if (strpos($order_id_list, ',') === false) {
                $order_id_list = array($order_id_list);
            } else {
                $order_id_list = explode(',', $order_id_list);
            }
        }
        /* 初始化处理的订单sn */
        $sn_list     = array();
        $sn_not_list = array();
        $url         = RC_Uri::url('orders/merchant/init');
        if (!empty($extension_code)) {
            $url = RC_Uri::url('orders/merchant/init', array('extension_code' => $extension_code));
        }

        /* 确认 */
        if ('confirm' == $operation) {
            foreach ($order_id_list as $id_order) {
                $order = $this->db_order_info->find(array('order_id' => $id_order, 'order_status' => OS_UNCONFIRMED));

                /* 检查能否操作 */
                if ($order) {
                    $operable_list = merchant_operable_list($order);
                    if (!isset($operable_list['confirm'])) {
                        /* 失败  */
                        $sn_not_list[] = $id_order;
                        continue;
                    } else {
                        $order_id = $order['order_id'];

                        /* 标记订单为已确认 */
                        update_order($order_id, array('order_status' => OS_CONFIRMED, 'confirm_time' => RC_Time::gmtime()));
                        update_order_amount($order_id);
                        $ordersn = $this->db_order_info->where(array('order_id' => $order_id))->get_field('order_sn');
                        /* 记录日志 */
                        ecjia_merchant::admin_log(sprintf(__('设为确认, 订单号是%s', 'orders'), $ordersn), 'batch_setup', 'order');
                        /* 记录log */
                        order_action($order['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_UNPAYED, $action_note);

                        //订单已接单短信通知
                        if (!empty($order['user_id'])) {
                            $user_info = RC_DB::table('users')->where('user_id', $order['user_id'])->select('mobile_phone', 'user_name')->first();
                            if (!empty($user_info['mobile_phone'])) {
                                //发送短信
                                $options = array(
                                    'mobile' => $user_info['mobile_phone'],
                                    'event'  => 'sms_order_confirmed',
                                    'value'  => array(
                                        'order_sn'  => $order['order_sn'],
                                        'user_name' => $user_info['user_name'],
                                    ),
                                );
                                RC_Api::api('sms', 'send_event_sms', $options);
                            }
                        }

                        /* 发送邮件 */
                        if (ecjia::config('send_confirm_email') == '1') {
                            $tpl_name = 'order_confirm';
                            $tpl      = RC_Api::api('mail', 'mail_template', $tpl_name);

                            $order['formated_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
                            $this->assign('order', $order);
                            $this->assign('shop_name', ecjia::config('shop_name'));
                            $this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));

                            $content = $this->fetch_string($tpl['template_content']);
                            RC_Mail::send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']);
                        }

                        $sn_list[] = $order['order_sn'];
                    }
                } else {
                    $sn_not_list[] = $id_order;
                }
            }
            $sn_str      = __('有订单无法设置为确认状态', 'orders');
            $success_str = __("确认成功的订单：", 'orders');
        } elseif ('invalid' == $operation) {
            /* 无效 */
            foreach ($order_id_list as $id_order) {
                $order_query       = RC_Loader::load_app_class('merchant_order_query', 'orders');
                $where             = array();
                $where['order_id'] = $id_order;
                $where             = array_merge($where, $order_query->order_unpay_unship());
                $order             = $this->db_order_info->find($where);

                if ($order) {
                    /* 检查能否操作 */
                    $operable_list = merchant_operable_list($order);
                    if (!isset($operable_list['invalid'])) {
                        $sn_not_list[] = $id_order;
                        continue;
                    } else {
                        $order_id = $order['order_id'];

                        /* 标记订单为“无效” */
                        update_order($order_id, array('order_status' => OS_INVALID));
                        /* 记录日志 */
                        $ordersn = $this->db_order_info->where(array('order_id' => $order_id))->get_field('order_sn');
                        ecjia_merchant::admin_log(sprintf(__('设为无效, 订单号是%s', 'orders'), $ordersn), 'batch_setup', 'order');
                        /* 记录log */
                        order_action($order['order_sn'], OS_INVALID, SS_UNSHIPPED, PS_UNPAYED, $action_note);

                        /* 如果使用库存，且下订单时减库存，则增加库存 */
                        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                            change_order_goods_storage($order_id, false, SDT_PLACE);
                        }

                        /* 发送邮件 */
                        if (ecjia::config('send_invalid_email') == '1') {
                            $tpl_name = 'order_invalid';
                            $tpl      = RC_Api::api('mail', 'mail_template', $tpl_name);

                            $this->assign('order', $order);
                            $this->assign('shop_name', ecjia::config('shop_name'));
                            $this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
                            $content = $this->fetch_string($tpl['template_content']);
                            RC_Mail::send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']);
                        }

                        /* 退还用户余额、积分、红包 */
                        return_user_surplus_integral_bonus($order);
                        $sn_list[] = $order['order_sn'];
                    }
                } else {
                    $sn_not_list[] = $id_order;
                }
            }
            $sn_str      = __('有订单无法设置为无效', 'orders');
            $success_str = __("无效成功的订单：", 'orders');
        } elseif ('cancel' == $operation) {

            /* 取消 */
            foreach ($order_id_list as $id_order) {
                $order_query       = RC_Loader::load_app_class('merchant_order_query', 'orders');
                $where             = array();
                $where['order_id'] = $id_order;
                $where             = array_merge($where, $order_query->order_unpay_unship());
                $order             = $this->db_order_info->find($where);

                if ($order) {
                    /* 检查能否操作 */
                    $operable_list = merchant_operable_list($order);
                    if (!isset($operable_list['cancel'])) {
                        /* 失败  */
                        $links[] = array('text' => __('查看详情', 'orders'), 'href' => RC_Uri::url('orders/merchant/init'));
                        return $this->showmessage(__('有订单无法取消', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
                    } else {
                        $order_id = $order['order_id'];

                        /* 标记订单为“取消”，记录取消原因 */
                        $cancel_note = trim($_POST['cancel_note']);
                        update_order($order_id, array('order_status' => OS_CANCELED, 'to_buyer' => $cancel_note));
                        /* 记录日志 */
                        $ordersn = $this->db_order_info->where(array('order_id' => $order_id))->get_field('order_sn');
                        ecjia_merchant::admin_log(sprintf(__('设为取消, 订单号是%s', 'orders'), $ordersn), 'batch_setup', 'order');
                        /* 记录log */
                        order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, $action_note);

                        /* 如果使用库存，且下订单时减库存，则增加库存 */
                        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                            change_order_goods_storage($order_id, false, SDT_PLACE);
                        }

                        /* 发送邮件 */
                        if (ecjia::config('send_cancel_email') == '1') {
                            $tpl_name = 'order_cancel';
                            $tpl      = RC_Api::api('mail', 'mail_template', $tpl_name);

                            $this->assign('order', $order);
                            $this->assign('shop_name', ecjia::config('shop_name'));
                            $this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
                            $content = $this->fetch_string($tpl['template_content']);

//                                 if (!RC_Mail::send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
                            //                                     return $this->showmessage('发送邮件失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                            //                                 }
                        }
                        /* 退还用户余额、积分、红包 */
                        return_user_surplus_integral_bonus($order);
                        $sn_list[] = $order['order_sn'];
                    }
                } else {
                    $sn_not_list[] = $id_order;
                }

            }
            $sn_str      = __('有订单无法取消', 'orders');
            $success_str = __("取消成功的订单：", 'orders');
        } elseif ('remove' == $operation) {
            $data = array(
                'is_delete'   => 1,
                'delete_time' => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()),
            );

            /* 删除 */
            foreach ($order_id_list as $id_order) {
                /* 检查能否操作 */
                $order         = order_info($id_order);
                $operable_list = merchant_operable_list($order);

                if (!isset($operable_list['remove'])) {
                    $sn_not_list[] = $id_order;
                    continue;
                }
                /* 记录日志 */
                ecjia_merchant::admin_log(' 订单号是' . $order['order_sn'], 'batch_remove', 'order');
                /* 删除订单 */
                RC_DB::table('order_info')->where('order_id', $order['order_id'])->update($data);

                $action_array = array('delivery', 'back');
                del_delivery($order['order_id'], $action_array);
                $sn_list[] = $order['order_sn'];
            }
            $sn_str      = __('有订单无法被移除', 'orders');
            $success_str = __('删除成功的订单：', 'orders');
        } else {
            return $this->showmessage(__('参数错误', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
        }

        /* 取得备注信息 */
        if (empty($sn_not_list)) {
            $sn_list = empty($sn_list) ? '' : $success_str . join($sn_list, ',');
            $msg     = $sn_list;
            return $this->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } else {
            $sn_str .= "<br/>";

            $order_list_no_fail = array();
            $data               = $this->db_order_info->in(array('order_id' => $sn_not_list))->select();

            foreach ($data as $key => $row) {
                $sn_str .= "<br>订单号：" . $row['order_sn'] . ";&nbsp;&nbsp;&nbsp;";

                $order_list_fail = '';

                $op = array(
                    'confirm'        => __('确认', 'orders'),
                    'pay'            => __('付款', 'orders'),
                    'prepare'        => __('配货', 'orders'),
                    'ship'           => __('发货', 'orders'),
                    'cancel'         => __('取消', 'orders'),
                    'invalid'        => __('无效', 'orders'),
                    'return'         => __('退货', 'orders'),
                    'unpay'          => __('设为未付款', 'orders'),
                    'unship'         => __('未发货', 'orders'),
                    'confirm_pay'    => __('确认付款', 'orders'),
                    'cancel_ship'    => __('取消发货', 'orders'),
                    'receive'        => __('已收货', 'orders'),
                    'assign'         => __('指派给', 'orders'),
                    'after_service'  => __('售后', 'orders'),
                    'return_confirm' => __('退货确认', 'orders'),
                    'remove'         => __('删除', 'orders'),
                    'you_can'        => __('您可进行的操作', 'orders'),
                    'split'          => __('生成发货单', 'orders'),
                    'to_delivery'    => __('去发货', 'orders'),
                );
                foreach (merchant_operable_list($row) as $key => $value) {
                    if ($key != $operation) {
                        $order_list_fail .= $op[$key] . ',';
                    }
                }
                $sn_str .= __("您可进行的操作：", 'orders') . substr($order_list_fail, 0, -1);

            }

            return $this->showmessage($sn_str, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $url));
        }
    }

    /**
     * 操作订单状态（处理提交）
     */
    public function operate_post()
    {

        /* 检查权限 */
        $this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);

        /* 取得参数 */
        $order_id  = intval(trim($_POST['order_id'])); // 订单id
        $operation = $_POST['operation']; // 订单操作
        /* 取得备注信息 */
        $action_note = $_POST['action_note'];

        /* 查询订单信息 */
        $order = order_info($order_id);

        /* 检查能否操作 */
        $operable_list = merchant_operable_list($order);
        if (!isset($operable_list[$operation])) {
            return $this->showmessage(__("无法对订单执行该操作", 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ('confirm' == $operation) {
            /* 标记订单为已确认 */
            update_order($order_id, array('order_status' => OS_CONFIRMED, 'confirm_time' => RC_Time::gmtime()));
            update_order_amount($order_id);
            /* 记录日志 */

            ecjia_merchant::admin_log(sprintf(__('设为确认，订单号是%s', 'orders'), $order['order_sn']), 'setup', 'order');
            /* 记录log */
            order_action($order['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_PAYED, $action_note);
            /*订单状态表log记录*/
            RC_Loader::load_app_class('order_refund', 'refund', false);
            $pra = array('order_status' => __('商家已接单', 'orders'), 'order_id' => $order_id, 'message' => __('已被商家接单，订单正在备货中', 'orders'));
            order_refund::order_status_log($pra);

            /* 如果原来状态不是“未确认”，且使用库存，且下订单时减库存，则减少库存 */
            if ($order['order_status'] != OS_UNCONFIRMED && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                change_order_goods_storage($order_id, true, SDT_PLACE);
            }

            //更新商家会员
            RC_Api::api('customer', 'store_user_buy', array('store_id' => $order['store_id'], 'user_id' => $order['user_id']));

            //订单已接单短信通知
            if (!empty($order['user_id'])) {
                $user_info = RC_DB::table('users')->where('user_id', $order['user_id'])->select('mobile_phone', 'user_name')->first();
                if (!empty($user_info['mobile_phone'])) {
                    //发送短信
                    $options = array(
                        'mobile' => $user_info['mobile_phone'],
                        'event'  => 'sms_order_confirmed',
                        'value'  => array(
                            'order_sn'  => $order['order_sn'],
                            'user_name' => $user_info['user_name'],
                        ),
                    );
                    RC_Api::api('sms', 'send_event_sms', $options);
                }
            }

            /* 发送邮件 */
            $cfg = ecjia::config('send_confirm_email');
            if ($cfg == '1') {
                $tpl_name = 'order_confirm';
                $tpl      = RC_Api::api('mail', 'mail_template', $tpl_name);

                $this->assign('order', $order);
                $this->assign('shop_name', ecjia::config('shop_name'));
                $this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));

                $content = $this->fetch_string($tpl['template_content']);

//                     if (!RC_Mail::send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
                //                         return $this->showmessage('发送邮件失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                //                     }
            } else {
                //                 return $this->showmessage('操作成功' , ecjia::MSGTYPE_JSON |ecjia::MSGSTAT_SUCCESS, );
            }

        } elseif ('pay' == $operation) {
            /* 付款 */
            /* 检查权限 */
            $this->admin_priv('order_ps_edit');

            /* 标记订单为已确认、已付款，更新付款时间和已支付金额，如果是货到付款，同时修改订单为“收货确认” */
            if ($order['order_status'] != OS_CONFIRMED) {
                $arr['order_status'] = OS_CONFIRMED;
                $arr['confirm_time'] = RC_Time::gmtime();
            }
            $arr['pay_status']   = PS_PAYED;
            $arr['pay_time']     = RC_Time::gmtime();
            $arr['money_paid']   = $order['money_paid'] + $order['order_amount'];
            $arr['order_amount'] = 0;
            $payment_method      = RC_Loader::load_app_class('payment_method', 'payment');
            $payment             = $payment_method->payment_info($order['pay_id']);
            if ($payment['is_cod']) {
                $arr['shipping_status']   = SS_RECEIVED;
                $order['shipping_status'] = SS_RECEIVED;
            }
            update_order($order_id, $arr);

            /* 记录日志 */
            ecjia_merchant::admin_log('设为付款，订单号是' . $order['order_sn'], 'setup', 'order');
            /* 记录log */
            order_action($order['order_sn'], OS_CONFIRMED, $order['shipping_status'], PS_PAYED, $action_note);
        } elseif ('unpay' == $operation) {
            /* 设为未付款 */
            /* 检查权限 */
            $this->admin_priv('order_ps_edit');

            /* 标记订单为未付款，更新付款时间和已付款金额 */
            $arr = array(
                'pay_status'   => PS_UNPAYED,
                'pay_time'     => 0,
                'money_paid'   => 0,
                'order_amount' => $order['money_paid'],
            );
            update_order($order_id, $arr);

            /* todo 处理退款 */
            $refund_type = @$_POST['refund'];
            $refund_note = @$_POST['refund_note'];
            order_refund($order, $refund_type, $refund_note);
            /* 记录日志 */
            ecjia_merchant::admin_log(sprintf(__('设为未付款，订单号是%s', 'orders'), $order['order_sn']), 'setup', 'order');
            /* 记录log */
            order_action($order['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_PAYED, $action_note);
        } elseif ('prepare' == $operation) {
            /* 配货 */
            /* 标记订单为已确认，配货中 */
            if ($order['order_status'] != OS_CONFIRMED) {
                $arr['order_status'] = OS_CONFIRMED;
                $arr['confirm_time'] = RC_Time::gmtime();
            }
            $arr['shipping_status'] = SS_PREPARING;
            update_order($order_id, $arr);
            /* 记录log */
            order_action($order['order_sn'], OS_CONFIRMED, SS_PREPARING, $order['pay_status'], $action_note);
        } elseif ('split' == $operation) {
            /* 分单确认 */
            /* 检查权限 */
            $this->admin_priv('order_ss_edit', ecjia::MSGTYPE_JSON);

            /* 定义当前时间 */
            define('GMTIME_UTC', RC_Time::gmtime()); // 获取 UTC 时间戳

            /* 获取表单提交数据 */
            $suppliers_id = isset($_POST['suppliers_id']) ? intval(trim($_POST['suppliers_id'])) : '0'; //供货商

            array_walk($_POST['delivery'], 'trim_array_walk');
            $delivery = $_POST['delivery'];
            array_walk($_POST['send_number'], 'trim_array_walk');
            array_walk($_POST['send_number'], 'intval_array_walk');

            $send_number = $_POST['send_number'];
            $action_note = isset($_POST['action_note']) ? trim($_POST['action_note']) : '';

            $delivery['user_id'] = intval($delivery['user_id']);

            $delivery['country']  = trim($delivery['country']);
            $delivery['province'] = trim($delivery['province']);
            $delivery['city']     = trim($delivery['city']);
            $delivery['district'] = trim($delivery['district']);
            $delivery['street']   = trim($delivery['street']);

            $delivery['agency_id']    = intval($delivery['agency_id']);
            $delivery['insure_fee']   = floatval($delivery['insure_fee']);
            $delivery['shipping_fee'] = floatval($delivery['shipping_fee']);

            /* 订单是否已全部分单检查 */
            if ($order['order_status'] == OS_SPLITED) {
                /* 操作失败 */
                $links[]  = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', 'order_id=' . $order_id));
                $os_label = __('已分单', 'orders');
                $ss_label = __('发货中', 'orders');
                return $this->showmessage(sprintf(__('您的订单%s，%s正在%s，%s', 'orders'), $order['order_sn'], $os_label, $ss_label, ecjia::config('shop_name')), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
            }

            /* 取得订单商品 */
            $_goods     = get_order_goods(array('order_id' => $order_id, 'order_sn' => $delivery['order_sn']));
            $goods_list = $_goods['goods_list'];

            /* 检查此单发货数量填写是否正确 合并计算相同商品和货品 */
            if (!empty($send_number) && !empty($goods_list)) {
                $goods_no_package = array();
                foreach ($goods_list as $key => $value) {
                    /* 去除 此单发货数量 等于 0 的商品 */
                    if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
                        // 如果是货品则键值为商品ID与货品ID的组合
                        $_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);

                        // 统计此单商品总发货数 合并计算相同ID商品或货品的发货数
                        if (empty($goods_no_package[$_key])) {
                            $goods_no_package[$_key] = $send_number[$value['rec_id']];
                        } else {
                            $goods_no_package[$_key] += $send_number[$value['rec_id']];
                        }

                        // 去除
                        if ($send_number[$value['rec_id']] <= 0) {
                            unset($send_number[$value['rec_id']], $goods_list[$key]);
                            continue;
                        }
                    } else {
                        /* 组合超值礼包信息 */
                        $goods_list[$key]['package_goods_list'] = package_goods($value['package_goods_list'], $value['goods_number'], $value['order_id'], $value['extension_code'], $value['goods_id']);

                        /* 超值礼包 */
                        foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
                            // 如果是货品则键值为商品ID与货品ID的组合
                            $_key = empty($pg_value['product_id']) ? $pg_value['goods_id'] : ($pg_value['goods_id'] . '_' . $pg_value['product_id']);

                            // 统计此单商品总发货数 合并计算相同ID产品的发货数
                            if (empty($goods_no_package[$_key])) {
                                $goods_no_package[$_key] = $send_number[$value['rec_id']][$pg_value['g_p']];
                            } else {
                                // 否则已经存在此键值
                                $goods_no_package[$_key] += $send_number[$value['rec_id']][$pg_value['g_p']];
                            }

                            // 去除
                            if ($send_number[$value['rec_id']][$pg_value['g_p']] <= 0) {
                                unset($send_number[$value['rec_id']][$pg_value['g_p']], $goods_list[$key]['package_goods_list'][$pg_key]);
                            }
                        }

                        if (count($goods_list[$key]['package_goods_list']) <= 0) {
                            unset($send_number[$value['rec_id']], $goods_list[$key]);
                            continue;
                        }
                    }

                    /* 发货数量与总量不符 */
                    if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
                        $sended = order_delivery_num($order_id, $value['goods_id'], $value['product_id']);
                        if (($value['goods_number'] - $sended - $send_number[$value['rec_id']]) < 0) {
                            /* 操作失败 */
                            $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', 'order_id=' . $order_id));
                            return $this->showmessage(__('此单发货数量不能超出订单商品数量', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));

                        }
                    } else {
                        /* 超值礼包 */
                        foreach ($goods_list[$key]['package_goods_list'] as $pg_key => $pg_value) {
                            if (($pg_value['order_send_number'] - $pg_value['sended'] - $send_number[$value['rec_id']][$pg_value['g_p']]) < 0) {
                                /* 操作失败 */
                                $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', 'order_id=' . $order_id));
                                return $this->showmessage(__('此单发货数量不能超出订单商品数量', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
                            }
                        }
                    }
                }
            }

            /* 对上一步处理结果进行判断 兼容 上一步判断为假情况的处理 */
            if (empty($send_number) || empty($goods_list)) {
                /* 操作失败 */
                $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', 'order_id=' . $order_id));
                return $this->showmessage(__('发货数量或商品不能为空', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
            }

            /* 检查此单发货商品库存缺货情况 */
            /* $goods_list已经过处理 超值礼包中商品库存已取得 */
            $virtual_goods         = array();
            $package_virtual_goods = array();
            foreach ($goods_list as $key => $value) {
                // 商品（超值礼包）
                if ($value['extension_code'] == 'package_buy') {
                    foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
                        if ($pg_value['goods_number'] < $goods_no_package[$pg_value['g_p']] &&
                            ((ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) ||
                                (ecjia::config('use_storage') == '0' && $pg_value['is_real'] == 0))) {
                            /* 操作失败 */
                            $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id)));
                            return $this->showmessage(sprintf(__('商品 %s 已缺货', 'orders'), $pg_value['goods_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
                        }

                        /* 商品（超值礼包） 虚拟商品列表 package_virtual_goods*/
                        if ($pg_value['is_real'] == 0) {
                            $package_virtual_goods[] = array(
                                'goods_id'   => $pg_value['goods_id'],
                                'goods_name' => $pg_value['goods_name'],
                                'num'        => $send_number[$value['rec_id']][$pg_value['g_p']],
                            );
                        }
                    }
                } elseif ($value['extension_code'] == 'virtual_card' || $value['is_real'] == 0) {
                    // 商品（虚货）
                    $num = $this->db_virtual_card->where(array('goods_id' => $value['goods_id'], 'is_saled' => 0))->count();

                    if (($num < $goods_no_package[$value['goods_id']]) && !(ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE)) {
                        /* 操作失败 */
                        $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id)));
                        return $this->showmessage(sprintf(__('虚拟卡已缺货', 'orders'), $value['goods_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
                    }

                    /* 虚拟商品列表 virtual_card*/
                    if ($value['extension_code'] == 'virtual_card') {
                        $virtual_goods[$value['extension_code']][] = array('goods_id' => $value['goods_id'], 'goods_name' => $value['goods_name'], 'num' => $send_number[$value['rec_id']]);
                    }
                } else {
                    // 商品（实货）、（货品）
                    //如果是货品则键值为商品ID与货品ID的组合
                    $_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);

                    /* （实货） */
                    if (empty($value['product_id'])) {
                        $num = $this->db_goods->where(array('goods_id' => $value['goods_id']))->get_field('goods_number');
                    } else {
                        /* （货品） */
                        $num = $this->db_products->where(array('goods_id' => $value['goods_id'], 'product_id' => $value['product_id']))->get_field('product_number');
                    }

                    if (($num < $goods_no_package[$_key]) && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
                        /* 操作失败 */
                        $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id)));
                        return $this->showmessage(sprintf(__('商品 %s 已缺货', 'orders'), $value['goods_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));

                    }
                }
            }

            /* 生成发货单 */
            /* 获取发货单号和流水号 */
            $delivery['delivery_sn'] = ecjia_order_delivery_sn();
            $delivery_sn             = $delivery['delivery_sn'];
            /* 获取当前操作员 */
            $delivery['action_user'] = $_SESSION['staff_name'];
            /* 获取发货单生成时间 */
            $delivery['update_time'] = GMTIME_UTC;
            $delivery_time           = $delivery['update_time'];

            $delivery['add_time'] = $this->db_order_info->where(array('order_sn' => $delivery['order_sn']))->get_field('add_time');

            /* 获取发货单所属供应商 */
            $delivery['suppliers_id'] = $suppliers_id;
            /* 设置默认值 */
            $delivery['status']   = 2; // 正常
            $delivery['order_id'] = $order_id;

            /*地区经纬度赋值*/
            $delivery['longitude'] = $order['longitude'];
            $delivery['latitude']  = $order['latitude'];
            /* 期望送货时间*/
            $delivery['best_time'] = $order['expect_shipping_time'];

            if (empty($delivery['longitude']) || empty($delivery['latitude'])) {
                $province_name = ecjia_region::getRegionName($delivery['province']);
                $city_name     = ecjia_region::getRegionName($delivery['city']);
                $district_name = ecjia_region::getRegionName($delivery['district']);
                $street_name   = ecjia_region::getRegionName($delivery['street']);

                $consignee_address = '';
                if (!empty($province_name)) {
                    $consignee_address .= $province_name;
                }
                if (!empty($city_name)) {
                    $consignee_address .= $city_name;
                }
                if (!empty($district_name)) {
                    $consignee_address .= $district_name;
                }
                if (!empty($street_name)) {
                    $consignee_address .= $street_name;
                }
                $consignee_address .= $delivery['address'];
                $consignee_address = urlencode($consignee_address);

                //腾讯地图api 地址解析（地址转坐标）
                $key        = ecjia::config('map_qq_key');
                $shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=" . $consignee_address . "&key=" . $key);
                $shop_point = json_decode($shop_point['body'], true);
                if (isset($shop_point['result']) && !empty($shop_point['result']['location'])) {
                    $delivery['longitude'] = $shop_point['result']['location']['lng'];
                    $delivery['latitude']  = $shop_point['result']['location']['lat'];
                }
            }

            /* 过滤字段项 */
            $filter_fileds = array(
                'order_sn', 'add_time', 'user_id', 'how_oos', 'shipping_id', 'shipping_fee',
                'consignee', 'address', 'longitude', 'latitude', 'country', 'province', 'city', 'district', 'street', 'sign_building',
                'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'insure_fee',
                'agency_id', 'delivery_sn', 'action_user', 'update_time',
                'suppliers_id', 'status', 'order_id', 'shipping_name',
            );
            $_delivery     = array();
            foreach ($filter_fileds as $value) {
                $_delivery[$value] = $delivery[$value];
            }

            $_delivery['store_id'] = $_SESSION['store_id'];

            /* 发货单入库 */
            $delivery_id = $this->db_delivery_order->insert($_delivery);

            if ($delivery_id) {
                $data = array(
                    'order_status' => __('发货中', 'orders'),
                    'order_id'     => $order_id,
                    'message'      => sprintf(__('订单号为 %s 的商品正在备货中，请您耐心等待', 'orders'), $order['order_sn']),
                    'add_time'     => RC_Time::gmtime(),
                );
                RC_DB::table('order_status_log')->insert($data);
            }

            if ($delivery_id) {
                $delivery_goods = array();
                if (!empty($goods_list)) {
                    foreach ($goods_list as $value) {
                        // 商品（实货）（虚货）
                        if (empty($value['extension_code']) || $value['extension_code'] == 'virtual_card') {
                            $delivery_goods = array(
                                'delivery_id' => $delivery_id,
                                'goods_id'    => $value['goods_id'],
                                'product_id'  => $value['product_id'],
                                'product_sn'  => $value['product_sn'],
                                'goods_id'    => $value['goods_id'],
                                'goods_name'  => addslashes($value['goods_name']),
                                'brand_name'  => addslashes($value['brand_name']),
                                'goods_sn'    => $value['goods_sn'],
                                'send_number' => $send_number[$value['rec_id']],
                                'parent_id'   => 0,
                                'is_real'     => $value['is_real'],
                                'goods_attr'  => addslashes($value['goods_attr']),
                            );

                            /* 如果是货品 */
                            if (!empty($value['product_id'])) {
                                $delivery_goods['product_id'] = $value['product_id'];
                            }
                            $query = $this->db_delivery->insert($delivery_goods);
                        } elseif ($value['extension_code'] == 'package_buy') {
                            // 商品（超值礼包）
                            foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
                                $delivery_pg_goods = array(
                                    'delivery_id'    => $delivery_id,
                                    'goods_id'       => $pg_value['goods_id'],
                                    'product_id'     => $pg_value['product_id'],
                                    'product_sn'     => $pg_value['product_sn'],
                                    'goods_name'     => $pg_value['goods_name'],
                                    'brand_name'     => '',
                                    'goods_sn'       => $pg_value['goods_sn'],
                                    'send_number'    => $send_number[$value['rec_id']][$pg_value['g_p']],
                                    'parent_id'      => $value['goods_id'], // 礼包ID
                                    'extension_code' => $value['extension_code'], // 礼包
                                    'is_real'        => $pg_value['is_real'],
                                );
                                $query             = $this->db_delivery->insert($delivery_pg_goods);
                            }
                        }
                    }
                }
            } else {
                /* 操作失败 */
                $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id)));
                return $this->showmessage(__('操作失败', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));

            }
            unset($filter_fileds, $delivery, $_delivery, $order_finish);

            /* 订单信息更新处理 */
            if (true) {
                /* 订单信息 */
                $_sended = &$send_number;
                foreach ($_goods['goods_list'] as $key => $value) {
                    if ($value['extension_code'] != 'package_buy') {
                        unset($_goods['goods_list'][$key]);
                    }
                }
                foreach ($goods_list as $key => $value) {
                    if ($value['extension_code'] == 'package_buy') {
                        unset($goods_list[$key]);
                    }
                }
                $_goods['goods_list'] = $goods_list + $_goods['goods_list'];
                unset($goods_list);

                /* 更新订单的虚拟卡 商品（虚货） */
                $_virtual_goods = isset($virtual_goods['virtual_card']) ? $virtual_goods['virtual_card'] : '';
                update_order_virtual_goods($order_id, $_sended, $_virtual_goods);

                /* 更新订单的非虚拟商品信息 即：商品（实货）（货品）、商品（超值礼包）*/
                update_order_goods($order_id, $_sended, $_goods['goods_list']);

                /* 标记订单为已确认 “发货中” */
                /* 更新发货时间 */
                $order_finish    = get_order_finish($order_id);
                $shipping_status = SS_SHIPPED_ING;
                if ($order['order_status'] != OS_CONFIRMED && $order['order_status'] != OS_SPLITED && $order['order_status'] != OS_SPLITING_PART) {
                    $arr['order_status'] = OS_CONFIRMED;
                    $arr['confirm_time'] = GMTIME_UTC;
                }

                $arr['order_status']    = $order_finish ? OS_SPLITED : OS_SPLITING_PART; // 全部分单、部分分单
                $arr['shipping_status'] = $shipping_status;
                update_order($order_id, $arr);
            }

            /* 记录log */
            order_action($order['order_sn'], $arr['order_status'], $shipping_status, $order['pay_status'], $action_note);
            $url = RC_Uri::url('orders/mh_delivery/delivery_info', array('delivery_id' => $delivery_id));
            return $this->showmessage(__('操作成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        } elseif ('unship' == $operation) {
            /*判断备注是否填写*/
            $require_note = ecjia::config('order_unship_note');
            if ($require_note == 1 && empty($_POST['action_note'])) {
                return $this->showmessage(__('请填写备注信息！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 设为未发货 */
            /* 检查权限 */
            $this->admin_priv('order_ss_edit', ecjia::MSGTYPE_JSON);

            /* 标记订单为“未发货”，更新发货时间, 订单状态为“确认” */
            update_order($order_id, array('shipping_status' => SS_UNSHIPPED, 'shipping_time' => 0, 'invoice_no' => '', 'order_status' => OS_CONFIRMED));

            /* 记录日志 */
            ecjia_merchant::admin_log(sprintf(__('取消发货，订单号是%s', 'orders'), $order['order_sn']), 'setup', 'order');
            /* 记录log */
            order_action($order['order_sn'], $order['order_status'], SS_UNSHIPPED, $order['pay_status'], $action_note);

            /* 如果订单用户不为空，计算积分，并退回 */
            if ($order['user_id'] > 0) {
                /* 取得用户信息 */
                $user = user_info($order['user_id']);

                /* 计算并退回积分 */
                $integral = integral_to_give($order);
                $options  = array(
                    'user_id'     => $order['user_id'],
                    'rank_points' => (-1) * intval($integral['rank_points']),
                    'pay_points'  => (-1) * intval($integral['custom_points']),
                    'change_desc' => sprintf(__('由于退货或未发货操作，退回订单 %s 赠送的积分', 'orders'), $order['order_sn']),
                );
                RC_Api::api('user', 'account_change_log', $options);

                /* todo 计算并退回红包 */
                return_order_bonus($order_id);
            }

            /* 如果使用库存，则增加库存 */
            if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
                change_order_goods_storage($order['order_id'], false, SDT_SHIP);
            }

            /* 删除发货单 */
            del_order_delivery($order_id);

            /* 将订单的商品发货数量更新为 0 */

            $data = array(
                'send_number' => 0,
            );
            $this->db_order_good->where(array('order_id' => $order_id))->update($data);
        } elseif ('receive' == $operation) {
            /*判断备注是否填写*/
            $require_note = ecjia::config('order_unship_note');
            if ($require_note == 1 && empty($_POST['action_note'])) {
                return $this->showmessage(__('请填写备注信息！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 收货确认 */
            /* 标记订单为“收货确认”，如果是货到付款，同时修改订单为已付款 */
            $arr            = array('shipping_status' => SS_RECEIVED);
            $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
            $payment        = $payment_method->payment_info($order['pay_id']);
            if ($payment['is_cod']) {
                $arr['pay_status']   = PS_PAYED;
                $order['pay_status'] = PS_PAYED;
            }
            $update = update_order($order_id, $arr);
            if ($update) {
                $data = array(
                    'order_status' => __('收货确认', 'orders'),
                    'order_id'     => $order_id,
                    'message'      => __('商品已送达，请签收，感谢您下次光顾！', 'orders'),
                    'add_time'     => RC_Time::gmtime(),
                );
                RC_DB::table('order_status_log')->insert($data);
                // update commission_bill
                // RC_Api::api('commission', 'add_bill_detail', array('store_id' => $order['store_id'], 'order_type' => 'buy', 'order_id' => $order_id, 'order_amount' => $order['order_amount']));
                RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'buy', 'order_id' => $order_id));
                RC_Api::api('goods', 'update_goods_sales', array('order_id' => $order_id));
            }

            /* 记录log */
            order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], $action_note);
        } elseif ('cancel' == $operation) {
            /* 取消 */

            /*判断是否需要填写备注*/
            $require_note = ecjia::config('order_cancel_note');
            if ($require_note == 1 && empty($_POST['action_note'])) {
                return $this->showmessage(__('请填写操作备注！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* todo 处理退款 */
            if ($order['money_paid'] > 0) {
                $refund_type = $_POST['refund'];
                $refund_note = $_POST['refund_note'];
                $result      = order_refund($order, $refund_type, $refund_note);
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }

            /* 标记订单为“取消”，记录取消原因 */
            $cancel_note = isset($_POST['cancel_note']) ? trim($_POST['cancel_note']) : '';
            $arr         = array(
                'order_status' => OS_CANCELED,
                'to_buyer'     => $cancel_note,
                'pay_status'   => PS_UNPAYED,
                'pay_time'     => 0,
                'money_paid'   => 0,
                'order_amount' => $order['money_paid'],
            );
            update_order($order_id, $arr);

//             $confirm_receive = update_order($order_id, $arr);
            //             if ($confirm_receive) {
            //                 $data = array(
            //                     'order_status' => RC_Lang::get('orders::order.cs.' . CS_FINISHED),
            //                     'order_id' => $order_id,
            //                     'add_time' => RC_Time::gmtime(),
            //                 );
            //                 RC_DB::table('order_status_log')->insert($data);
            //             }

            RC_DB::table('order_status_log')->insert(array(
                'order_status' => __('订单已取消', 'orders'),
                'order_id'     => $order_id,
                'message'      => __('您的订单已取消成功！', 'orders'),
                'add_time'     => RC_Time::gmtime(),
            ));

            /* 记录日志 */
            ecjia_merchant::admin_log(sprintf(__('设为取消，订单号是%s', 'orders'), $order['order_sn']), 'setup', 'order');
            /* 记录log */
            order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, $action_note);

            /* 如果使用库存，且下订单时减库存，则增加库存 */
            if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                change_order_goods_storage($order_id, false, SDT_PLACE);
            }

            /* 退还用户余额、积分、红包 */
            return_user_surplus_integral_bonus($order);

            /* 发送邮件 */
            $cfg = ecjia::config('send_cancel_email');
            if ($cfg == '1') {
                $tpl_name = 'order_cancel';
                $tpl      = RC_Api::api('mail', 'mail_template', $tpl_name);

                $this->assign('order', $order);
                $this->assign('shop_name', ecjia::config('shop_name'));
                $this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
                $content = $this->fetch_string($tpl['template_content']);
            }

        } elseif ('invalid' == $operation) {
            /*判断备注是否填写*/
            $require_note = ecjia::config('order_invalid_note');
            if ($require_note == 1 && empty($_POST['action_note'])) {
                return $this->showmessage(__('请填写备注信息！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 设为无效 */
            /* 标记订单为“无效”、“未付款” */
            update_order($order_id, array('order_status' => OS_INVALID));
            /* 记录日志 */
            ecjia_merchant::admin_log(sprintf(__('设为无效，订单号是%s', 'orders'), $order['order_sn']), 'setup', 'order');
            /* 记录log */
            order_action($order['order_sn'], OS_INVALID, $order['shipping_status'], PS_UNPAYED, $action_note);

            /* 如果使用库存，且下订单时减库存，则增加库存 */
            if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
                change_order_goods_storage($order_id, false, SDT_PLACE);
            }
            /* 发送邮件 */
            $cfg = ecjia::config('send_invalid_email');
            if ($cfg == '1') {
                $tpl_name = 'order_invalid';
                $tpl      = RC_Api::api('mail', 'mail_template', $tpl_name);

                $this->assign('order', $order);
                $this->assign('shop_name', ecjia::config('shop_name'));
                $this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
                $content = $this->fetch_string($tpl['template_content']);
            }

            /* 退货用户余额、积分、红包 */
            return_user_surplus_integral_bonus($order);
        } elseif ('after_service' == $operation) {
            /* 记录log */
            order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], $action_note);
            /* 记录日志 */
            ecjia_merchant::admin_log(sprintf(__('添加售后，订单号是%s', 'orders'), $order['order_sn']), 'setup', 'order');
        } elseif ('confirm_return' == $operation) {
            order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], $action_note);
        } else {
            return $this->showmessage('invalid params', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 操作成功 */
        $links[] = array('text' => __('返回订单详情！', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id)));
        return $this->showmessage(__('操作成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id))));
    }

    /**
     *  添加订单商品,获取商品信息
     */
    public function goods_json()
    {
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);

        /* 取得商品信息 */
        $goods_id = !empty($_POST['goods_id']) ? $_POST['goods_id'] : 0;

        $store_id = !empty($_SESSION['store_id']) ? intval($_SESSION['store_id']) : 0;

        $fields = 'g.goods_id, mc.cat_name, g.goods_sn, g.goods_name, g.goods_img, g.goods_number, g.market_price, g.shop_price, g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_type, g.is_promote';
        $goods  = RC_DB::table('goods as g')
            ->leftJoin('merchants_category as mc', RC_DB::raw('g.merchant_cat_id'), '=', RC_DB::raw('mc.cat_id'))
            ->where(RC_DB::raw('g.goods_id'), $goods_id)
            ->where(RC_DB::raw('g.store_id'), $store_id)
            ->where(RC_DB::raw('mc.store_id'), $store_id)
            ->select(RC_DB::raw('g.goods_id'), RC_DB::raw('mc.cat_name'), RC_DB::raw('g.goods_sn'), RC_DB::raw('g.goods_name'), RC_DB::raw('g.goods_img'), RC_DB::raw('g.goods_number'), RC_DB::raw('g.market_price'), RC_DB::raw('g.shop_price'), RC_DB::raw('g.promote_price'), RC_DB::raw('g.promote_start_date'), RC_DB::raw('g.promote_end_date'), RC_DB::raw('g.goods_brief'), RC_DB::raw('g.goods_type'), RC_DB::raw('g.is_promote'))
            ->first();

        $today                = RC_Time::gmtime();
        $goods['goods_price'] = ($goods['is_promote'] == 1 && $goods['promote_start_date'] <= $today && $goods['promote_end_date'] >= $today) ? $goods['promote_price'] : $goods['shop_price'];

        /* 取得会员价格 */
        $goods['user_price'] = RC_DB::table('member_price as mp')
            ->leftJoin('user_rank as r', RC_DB::raw('mp.user_rank'), '=', RC_DB::raw('r.rank_id'))
            ->select(RC_DB::raw('mp.user_price'), RC_DB::raw('r.rank_name'))
            ->where(RC_DB::raw('mp.goods_id'), $goods_id)
            ->get();

        /* 取得商品属性 */
        $data = RC_DB::table('goods_attr as ga')
            ->leftJoin('attribute as a', RC_DB::raw('ga.attr_id'), '=', RC_DB::raw('a.attr_id'))
            ->where(RC_DB::raw('ga.goods_id'), $goods_id)
            ->select(RC_DB::raw('a.attr_id'), RC_DB::raw('a.attr_name'), RC_DB::raw('ga.goods_attr_id'), RC_DB::raw('ga.attr_value'), RC_DB::raw('ga.attr_price'), RC_DB::raw('a.attr_input_type'), RC_DB::raw('a.attr_type'))
            ->get();

        $goods['attr_list'] = array();
        if (!empty($data)) {
            foreach ($data as $key => $row) {
                $goods['attr_list'][$row['attr_id']][] = $row;
            }
        }

        $goods['goods_name']       = $goods['goods_name'];
        $goods['short_goods_name'] = RC_String::str_cut($goods['goods_name'], 26);
        $goods['attr_list']        = array_values($goods['attr_list']);
        $goods['goods_img']        = get_image_path($goods['goods_id'], $goods['goods_img']);
        $goods['preview_url']      = RC_Uri::url('goods/merchant/preview', 'id=' . $goods_id);

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('goods' => $goods));
    }

    /**
     * 删除订单
     */
    public function remove_order()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);
        $order_id = intval($_REQUEST['order_id']);

        /* 检查订单是否允许删除操作 */
        $order         = order_info($order_id);
        $operable_list = merchant_operable_list($order);

        if (!isset($operable_list['remove'])) {
            return $this->showmessage(__('无法对订单执行该操作', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'is_delete'   => 1,
            'delete_time' => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()),
        );
        RC_DB::table('order_info')->where('order_id', $order_id)->update($data);

        $action_array = array('delivery', 'back');
        del_delivery($order_id, $action_array);

        ecjia_merchant::admin_log(sprintf(__('订单号是 %s', 'orders'), $order['order_sn']), 'remove', 'order');

        return $this->showmessage(__('订单删除成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('orders/merchant/init')));

    }

    /**
     * 根据关键字和id搜索用户
     */
    public function search_users()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);
        $id_name = empty($_POST['id_name']) ? '' : trim($_POST['id_name']);

        $result = array();
        if (!empty($id_name)) {
            $db_user = RC_Loader::load_app_model('users_model', 'user');
            $data    = $db_user->field('user_id, user_name,email')->where("email like '%" . mysql_like_quote($id_name) . "%' or user_name like '%" . mysql_like_quote($id_name) . "%'")->limit(50)->select();
            if (!empty($data)) {
                foreach ($data as $key => $row) {
                    array_push($result, array('value' => $row['user_id'], 'text' => sprintf(__("%s [ 邮箱地址：%s ]", 'orders'), $row['user_name'], $row['email'])));
                }
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('user' => $result));
    }

    /**
     * 根据关键字搜索商品
     */
    public function search_goods()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);
        $keyword  = empty($_POST['keyword']) ? '' : trim($_POST['keyword']);
        $store_id = !empty($_SESSION['store_id']) ? trim($_SESSION['store_id']) : '';

        $result = array();
        if (!empty($keyword)) {
            $data = $this->db_goods->field('goods_id, goods_name, goods_sn')
                ->where(array('is_delete' => 0, 'is_on_sale' => 1, 'is_alone_sale' => 1, 'store_id' => $store_id, '( goods_id like "%' . mysql_like_quote($keyword) . '%" or goods_name like "%' . mysql_like_quote($keyword) . '%" or goods_sn like "%' . mysql_like_quote($keyword) . '%" )'))->limit(20)->select();
            if (!empty($data)) {
                foreach ($data as $key => $row) {
                    array_push($result, array('value' => $row['goods_id'], 'text' => $row['goods_name'] . '  ' . $row['goods_sn']));
                }
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('goods' => $result));
    }

    /**
     * 编辑收货单号
     */
    public function edit_invoice_no()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);

        $no       = empty($_POST['val']) ? 'N/A' : trim($_POST['val']);
        $no       = $no == 'N/A' ? '' : $no;
        $order_id = empty($_POST['id']) ? 0 : intval($_POST['id']);

        if ($order_id == 0) {
            return $this->showmessage('NO ORDER ID', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data  = array(
            'invoice_no' => $no,
        );
        $query = $this->db_order_info->where(array('order_id' => $order_id))->update($data);

        if ($query) {
            if (empty($no)) {
                return $this->showmessage('N/A', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            } else {
                return $this->showmessage(stripcslashes($no), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripcslashes($no)));
            }
        } else {
            return $this->showmessage(__('更新失败！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    /**
     * 编辑付款备注
     */
    public function edit_pay_note()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);

        $no       = empty($_POST['val']) ? 'N/A' : trim($_POST['val']);
        $no       = $no == 'N/A' ? '' : $no;
        $order_id = empty($_POST['id']) ? 0 : intval($_POST['id']);

        if (empty($order_id)) {
            return $this->showmessage(__('该订单不存在', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data  = array(
            'pay_note' => $no,
        );
        $query = $this->db_order_info->where(array('order_id' => $order_id))->update($data);
        if ($query) {
            if (empty($no)) {
                return $this->showmessage('N/A', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            } else {
                return $this->showmessage(stripcslashes($no), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }
        } else {
            return $this->showmessage(__('更新失败！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 添加订单时选择用户展现用户信息的信息（json返回）
     */
    public function user_info()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);
        $id      = $_POST['user_id'];
        $db_user = RC_Loader::load_app_model('users_model', 'user');
        $row     = $db_user->find(array('user_id' => $id));
        if ($row['user_rank'] > 0) {
            $db_user_rank      = RC_Loader::load_app_model('user_rank_model', 'user');
            $user['user_rank'] = $db_user_rank->where(array('rank_id' => $row['user_rank']))->get_field('rank_name');
        } else {
            $user['user_rank'] = __('非特殊等级', 'orders');
        }

        if ($row) {
            $user['user_id']      = $row['user_id'];
            $user['user_name']    = "<a href='" . RC_Uri::url('user/admin/info', 'id=' . $row['user_id']) . "' target='_blank'>" . $row['user_name'] . "</a>";
            $user['email']        = $row['email'];
            $user['reg_time']     = RC_Time::local_date(ecjia::config('time_format'), $row['reg_time']);
            $user['mobile_phone'] = !empty($row['mobile_phone']) ? $row['mobile_phone'] : __('暂无手机号', 'orders');
            $user['is_validated'] = $row['is_validated'] == 0 ? __('未验证', 'orders') : __('已验证', 'orders');
            $user['last_login']   = RC_Time::local_date(ecjia::config('time_format'), $row['last_login']);
            $user['last_ip']      = $row['last_ip'] . '(' . RC_Ip::area($row['last_ip']) . ')';

            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('user' => $user));
        } else {
            return $this->showmessage(__('未找到相关会员信息', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    public function switch_on_off()
    {
        $val = !empty($_POST['val']) ? trim($_POST['val']) : 'off';
        RC_Cache::app_cache_set('switch_on_off', $val, 'orders', 10080);
    }

    /* 退货退款功能 songqianqian */
    public function mer_action_return()
    {
        $this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);

        RC_Loader::load_app_class('order_refund', 'refund', false);
        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        RC_Loader::load_app_class('RefundStatusLog', 'refund', false);

        $refund_type          = trim($_POST['refund_type']);
        $refund_reason        = intval($_POST['refund_reason']);
        $order_id             = intval($_POST['order_id']);
        $refund_content       = trim($_POST['refund_content']);
        $merchant_action_note = trim($_POST['merchant_action_note']); //管理员操作日志
        $order                = order_info($order_id); //查询订单信息

        /* 检查能否操作 */
        $operable_list = merchant_operable_list($order);
        if (!isset($operable_list['return'])) {
            return $this->showmessage(__("无法对订单执行该操作", 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //配送方式信息
        if (!empty($order['shipping_id'])) {
            $shipping_id   = intval($order['shipping_id']);
            $shipping_info = ecjia_shipping::pluginData($shipping_id);
            $shipping_code = $shipping_info['shipping_code'];
        } else {
            $shipping_code = null;
        }

        //支付方式信息
        if (!empty($order['pay_id'])) {
            $payment_info = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
            $pay_code     = $payment_info['pay_code'];
        } else {
            $pay_code = null;
        }

        //退款编号
        $refund_sn = ecjia_order_refund_sn();
        if ($refund_type == 'refund') { //仅退款
            $return_status = 0;
            $refund_status = 1;
        } elseif ($refund_type == 'return') { //退货退款
            $return_status = 1;
            $refund_status = 0;
        }
        $user_name = RC_DB::table('users')->where('user_id', $order['user_id'])->value('user_name');
        /* 进入售后 */
        $refund_data = array(
            'store_id'       => $order['store_id'],
            'user_id'        => $order['user_id'],
            'user_name'      => $user_name,
            'refund_type'    => $refund_type,
            'refund_sn'      => $refund_sn,
            'order_id'       => $order_id,
            'order_sn'       => $order['order_sn'],
            'shipping_code'  => $shipping_code,
            'shipping_name'  => $order['shipping_name'],
            'shipping_fee'   => $order['shipping_fee'],
            'insure_fee'     => $order['insure_fee'],
            'pay_code'       => $pay_code,
            'pay_name'       => $payment_info['pay_name'],
            'goods_amount'   => $order['goods_amount'],
            'pay_fee'        => $order['pay_fee'],
            'pack_id'        => $order['pack_id'],
            'pack_fee'       => $order['pack_fee'],
            'card_id'        => $order['card_id'],
            'card_fee'       => $order['card_fee'],
            'bonus_id'       => $order['bonus_id'],
            'bonus'          => $order['bonus'],
            'surplus'        => $order['surplus'],
            'integral'       => $order['integral'],
            'integral_money' => $order['integral_money'],
            'discount'       => $order['discount'],
            'inv_tax'        => $order['tax'],
            'order_amount'   => $order['order_amount'],
            'money_paid'     => $order['money_paid'],
            'status'         => 1,
            'refund_status'  => $refund_status,
            'return_status'  => $return_status,
            'refund_content' => $refund_content,
            'refund_reason'  => $refund_reason,
            'add_time'       => RC_Time::gmtime(),
            'referer'        => 'merchant',
        );
        $refund_id   = RC_DB::table('refund_order')->insertGetId($refund_data);

        //退款还原订单商品库存
        Ecjia\App\Refund\RefundBackGoodsStock::refund_back_stock($refund_id);

        /* 订单状态为“退货” */
        RC_DB::table('order_info')->where('order_id', $order_id)->update(array('order_status' => OS_RETURNED));

        /* 记录log */
        $action_note = trim($_POST['action_note']);
        order_refund::order_action($order_id, OS_RETURNED, $order['shipping_status'], $order['pay_status'], $action_note, $_SESSION['staff_name']);

        /* 发货单状态为“退货” */
        $data = array('status' => 1);
        $this->db_delivery_order->where(array('order_id' => $order['order_id']))->in(array('status' => array(0, 2)))->update($data);

        /* 将订单的商品发货数量更新为 0 */
        $data = array();
        $this->db_order_good->where(array('order_id' => $order_id))->update(array('send_number' => 0));

        //update commission_bill
        //         RC_Api::api('commission', 'add_bill_detail', array('store_id' => $order['store_id'], 'order_type' => 'refund', 'order_id' => $order_id, 'order_amount' => $order['order_amount']));
        RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'refund', 'order_id' => $refund_id));

        //仅退款---同意---进入打款表
        $refund_info = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
        if ($refund_type == 'refund') {
            $payment_record_id = RC_DB::table('payment_record')->where('order_sn', $refund_info['order_sn'])->value('id');

            //实际支付费用
            $order_money_paid = $refund_info['surplus'] + $refund_info['money_paid'];
            //退款总金额
            $shipping_status = RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->value('shipping_status');
            if ($shipping_status > SS_UNSHIPPED) {
                $back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'] - $refund_info['shipping_fee'] - $refund_info['insure_fee'];
                $back_shipping_fee = $refund_info['shipping_fee'];
                $back_insure_fee   = $refund_info['insure_fee'];
            } else {
                $back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'];
                $back_shipping_fee = 0;
                $back_insure_fee   = 0;
            }
            $data = array(
                'store_id'            => $_SESSION['store_id'],
                'order_id'            => $refund_info['order_id'],
                'order_sn'            => $refund_info['order_sn'],
                'refund_id'           => $refund_info['refund_id'],
                'refund_sn'           => $refund_info['refund_sn'],
                'refund_type'         => $refund_info['refund_type'],
                'goods_amount'        => $refund_info['goods_amount'],
                'back_pay_code'       => $refund_info['pay_code'],
                'back_pay_name'       => $refund_info['pay_name'],
                'back_pay_fee'        => $refund_info['pay_fee'],
                'back_shipping_fee'   => $back_shipping_fee,
                'back_insure_fee'     => $back_insure_fee,
                'back_pack_id'        => $refund_info['pack_id'],
                'back_pack_fee'       => $refund_info['pack_fee'],
                'back_card_id'        => $refund_info['card_id'],
                'back_card_fee'       => $refund_info['card_fee'],
                'back_bonus_id'       => $refund_info['bonus_id'],
                'back_bonus'          => $refund_info['bonus'],
                'back_surplus'        => $refund_info['surplus'],
                'back_integral'       => $refund_info['integral'],
                'back_integral_money' => $refund_info['integral_money'],
                'back_inv_tax'        => $refund_info['inv_tax'],
                'order_money_paid'    => $order_money_paid,
                'back_money_total'    => $back_money_total,
                'payment_record_id'   => !empty($payment_record_id) ? intval($payment_record_id) : 0,
                'add_time'            => RC_Time::gmtime(),
            );
            RC_DB::table('refund_payrecord')->insertGetId($data);
        } else { //退货退款---同意---进入待买家发货
            $return_shipping_range = $_POST['return_shipping_range'];
            $return_shipping_range = implode(",", $return_shipping_range);
            RC_DB::table('refund_order')->where('refund_id', $refund_id)->update(array('return_shipping_range' => $return_shipping_range));
        }

        //录入退款操作日志表
        $data = array(
            'refund_id'        => $refund_id,
            'action_user_type' => 'merchant',
            'action_user_id'   => $_SESSION['staff_id'],
            'action_user_name' => $_SESSION['staff_name'],
            'status'           => 1,
            'refund_status'    => $refund_status,
            'return_status'    => $refund_status,
            'action_note'      => $merchant_action_note,
            'log_time'         => RC_Time::gmtime(),
        );
        RC_DB::table('refund_order_action')->insertGetId($data);

        //售后订单状态变动日志表
        RefundStatusLog::refund_order_process(array('refund_id' => $refund_id, 'status' => 1));
        //普通订单状态变动日志表
        OrderStatusLog::refund_order_process(array('order_id' => $refund_info['order_id'], 'status' => 1));

        /* 操作成功 */
        return $this->showmessage(__('申请操作成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id))));
    }

    public function unconfirm_order()
    {
        $this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);

        RC_Loader::load_app_class('order_refund', 'refund', false);
        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        RC_Loader::load_app_class('RefundStatusLog', 'refund', false);

        $order_id             = intval($_POST['order_id']);
        $unconfirm_reason_key = intval($_POST['unconfirm_reason']); //拒单原因
        $reason_list          = array(
            31 => __('该订单商品已售完', 'orders'),
            32 => __('由于天气原因，本店铺暂不接单', 'orders'),
            33 => __('商家忙碌，暂时无法接单', 'orders'),
        );
        $order                = order_info($order_id); //查询订单信息
        $unconfirm_reason     = array_get($reason_list, $unconfirm_reason_key);

        /* 检查能否操作 */
        $operable_list = merchant_operable_list($order);
        if (!isset($operable_list['unconfirm'])) {
            return $this->showmessage(__("无法对订单执行该操作", 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //配送方式信息
        $shipping_code = null;

        //支付方式信息
        if (!empty($order['pay_id'])) {
            $payment_info = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
            $pay_code     = $payment_info['pay_code'];
        } else {
            $pay_code = null;
        }

        //订单被拒短信通知
        if (!empty($order['user_id'])) {
            $user_info = RC_DB::table('users')->where('user_id', $order['user_id'])->select('mobile_phone', 'user_name')->first();
            if (!empty($user_info['mobile_phone'])) {
                //发送短信
                $options = array(
                    'mobile' => $user_info['mobile_phone'],
                    'event'  => 'sms_order_refused',
                    'value'  => array(
                        'order_sn'  => $order['order_sn'],
                        'user_name' => $user_info['user_name'],
                    ),
                );
                RC_Api::api('sms', 'send_event_sms', $options);
            }
        }

        $action_note = trim($_POST['action_note']);

        //货到付款订单 走取消
        if ($order['order_status'] == OS_UNCONFIRMED) {
            if ($pay_code == 'pay_cod' && $order['pay_status'] == PS_UNPAYED) {
                RC_DB::table('order_info')->where('order_id', $order['order_id'])->update(array('order_status' => OS_CANCELED));
                RC_DB::table('order_status_log')->insert(array(
                    'order_status' => __('订单已取消', 'orders'),
                    'order_id'     => $order['order_id'],
                    'message'      => __('订单已取消！', 'orders'),
                    'add_time'     => RC_Time::gmtime(),
                ));

                order_refund::order_action($order_id, OS_CANCELED, $order['shipping_status'], $order['pay_status'], $action_note, $_SESSION['staff_name']);
                return $this->showmessage(__('操作成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id))));
            }
        }

        //退款编号
        $refund_sn = ecjia_order_refund_sn();

        //仅退款
        $refund_type   = 'refund';
        $return_status = 0;
        $refund_status = 1;

        $user_name = RC_DB::table('users')->where('user_id', $order['user_id'])->value('user_name');
        /* 进入售后 */
        $refund_data = array(
            'store_id'       => $order['store_id'],
            'user_id'        => $order['user_id'],
            'user_name'      => $user_name,
            'refund_type'    => $refund_type,
            'refund_sn'      => $refund_sn,
            'order_id'       => $order_id,
            'order_sn'       => $order['order_sn'],
            'shipping_code'  => $shipping_code,
            'shipping_name'  => $order['shipping_name'],
            'shipping_fee'   => $order['shipping_fee'],
            'insure_fee'     => $order['insure_fee'],
            'pay_code'       => $pay_code,
            'pay_name'       => $payment_info['pay_name'],
            'goods_amount'   => $order['goods_amount'],
            'pay_fee'        => $order['pay_fee'],
            'pack_id'        => $order['pack_id'],
            'pack_fee'       => $order['pack_fee'],
            'card_id'        => $order['card_id'],
            'card_fee'       => $order['card_fee'],
            'bonus_id'       => $order['bonus_id'],
            'bonus'          => $order['bonus'],
            'surplus'        => $order['surplus'],
            'integral'       => $order['integral'],
            'integral_money' => $order['integral_money'],
            'discount'       => $order['discount'],
            'inv_tax'        => $order['tax'],
            'order_amount'   => $order['order_amount'],
            'money_paid'     => $order['money_paid'],
            'status'         => 1,
            'refund_status'  => $refund_status,
            'return_status'  => $return_status,
            'refund_content' => $unconfirm_reason,
            'refund_reason'  => $unconfirm_reason_key,
            'add_time'       => RC_Time::gmtime(),
            'referer'        => 'merchant',
        );
        $refund_id   = RC_DB::table('refund_order')->insertGetId($refund_data);

        /* 订单状态为“退货” */
        RC_DB::table('order_info')->where('order_id', $order_id)->update(array('order_status' => OS_RETURNED));

        /* 记录log */
        order_refund::order_action($order_id, OS_RETURNED, $order['shipping_status'], $order['pay_status'], $action_note, $_SESSION['staff_name']);

        //订单状态log记录
        $pra = array('order_status' => __('无法接单', 'orders'), 'order_id' => $order_id, 'message' => __('等待商家退款！', 'orders'));
        order_refund::order_status_log($pra);

        //售后申请状态记录
        $opt = array('status' => __('无法接单', 'orders'), 'refund_id' => $refund_id, 'message' => __('等待商家退款！', 'orders'));
        order_refund::refund_status_log($opt);

        //update commission_bill
        RC_Api::api('commission', 'add_bill_queue', array('order_type' => 'refund', 'order_id' => $refund_id));

        //仅退款---同意---进入打款表
        $refund_info       = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
        $payment_record_id = RC_DB::table('payment_record')->where('order_sn', $refund_info['order_sn'])->value('id');

        //实际支付费用
        $order_money_paid = $refund_info['surplus'] + $refund_info['money_paid'];
        //退款总金额
        $shipping_status = RC_DB::table('order_info')->where('order_id', $refund_info['order_id'])->value('shipping_status');
        if ($shipping_status > SS_UNSHIPPED) {
            $back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'] - $refund_info['shipping_fee'] - $refund_info['insure_fee'];
            $back_shipping_fee = $refund_info['shipping_fee'];
            $back_insure_fee   = $refund_info['insure_fee'];
        } else {
            $back_money_total  = $refund_info['money_paid'] + $refund_info['surplus'] - $refund_info['pay_fee'];
            $back_shipping_fee = 0;
            $back_insure_fee   = 0;
        }
        $data = array(
            'store_id'            => $_SESSION['store_id'],
            'order_id'            => $refund_info['order_id'],
            'order_sn'            => $refund_info['order_sn'],
            'refund_id'           => $refund_info['refund_id'],
            'refund_sn'           => $refund_info['refund_sn'],
            'refund_type'         => $refund_info['refund_type'],
            'goods_amount'        => $refund_info['goods_amount'],
            'back_pay_code'       => $refund_info['pay_code'],
            'back_pay_name'       => $refund_info['pay_name'],
            'back_pay_fee'        => $refund_info['pay_fee'],
            'back_shipping_fee'   => $back_shipping_fee,
            'back_insure_fee'     => $back_insure_fee,
            'back_pack_id'        => $refund_info['pack_id'],
            'back_pack_fee'       => $refund_info['pack_fee'],
            'back_card_id'        => $refund_info['card_id'],
            'back_card_fee'       => $refund_info['card_fee'],
            'back_bonus_id'       => $refund_info['bonus_id'],
            'back_bonus'          => $refund_info['bonus'],
            'back_surplus'        => $refund_info['surplus'],
            'back_integral'       => $refund_info['integral'],
            'back_integral_money' => $refund_info['integral_money'],
            'back_inv_tax'        => $refund_info['inv_tax'],
            'order_money_paid'    => $order_money_paid,
            'back_money_total'    => $back_money_total,
            'payment_record_id'   => !empty($payment_record_id) ? intval($payment_record_id) : 0,
            'add_time'            => RC_Time::gmtime(),
        );
        RC_DB::table('refund_payrecord')->insertGetId($data);

        $merchant_action_note = trim($_POST['merchant_action_note']); //管理员操作日志
        //录入退款操作日志表
        $data = array(
            'refund_id'        => $refund_id,
            'action_user_type' => 'merchant',
            'action_user_id'   => $_SESSION['staff_id'],
            'action_user_name' => $_SESSION['staff_name'],
            'status'           => 1,
            'refund_status'    => $refund_status,
            'return_status'    => $refund_status,
            'action_note'      => $merchant_action_note,
            'log_time'         => RC_Time::gmtime(),
        );
        RC_DB::table('refund_order_action')->insertGetId($data);

        //售后订单状态变动日志表
        RefundStatusLog::refund_order_process(array('refund_id' => $refund_id, 'status' => 1));
        //普通订单状态变动日志表
        OrderStatusLog::refund_order_process(array('order_id' => $refund_info['order_id'], 'status' => 1));

        /* 操作成功 */
        return $this->showmessage(__('操作成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id))));
    }

    //一键发货
    public function ship()
    {
        /* 检查权限 */
        $this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);

        $order_id    = intval($_POST['order_id']);
        $shipping_id = intval($_POST['shipping_id']);

        if (empty($order_id)) {
            return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        define('GMTIME_UTC', RC_Time::gmtime()); // 获取 UTC 时间戳

        /* 一键发货 */
        $order = RC_Api::api('orders', 'merchant_order_info', array('order_id' => $order_id));
        if(empty($order)) {
            return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($shipping_id != $order['shipping_id']) {
            $ship_info              = ecjia_shipping::pluginData($shipping_id);
            $order['shipping_id']   = $ship_info['shipping_id'];
            $order['shipping_name'] = $ship_info['shipping_name'];
        }
        /* 查询：取得订单商品 */
        $_goods = get_order_goods(array('order_id' => $order['order_id'], 'order_sn' => $order['order_sn']));

        $attr       = $_goods['attr'];
        $goods_list = $_goods['goods_list'];

        $send_number = [];
        /* 查询：商品已发货数量 此单可发货数量 */
        if ($goods_list) {
            foreach ($goods_list as $key => $goods_value) {
                if (!$goods_value['goods_id']) {
                    continue;
                }
                $send_number[$goods_value['rec_id']] = $goods_value['goods_number'] - $goods_value['send_number'];

                /* 是否缺货 */
                if ($goods_value['storage'] <= 0 && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
                    $send_number[$goods_value['rec_id']] = __('商品已缺货', 'orders');
                } elseif ($send_number[$goods_value['rec_id']] <= 0) {
                    $send_number[$goods_value['rec_id']] = __('货已发完', 'orders');
                }
            }
        }

        /* 获取表单提交数据 */
        $suppliers_id = isset($_POST['suppliers_id']) ? intval(trim($_POST['suppliers_id'])) : '0'; //供货商

        $data = array(
            'order_sn'      => $order['order_sn'],
            'add_time'      => $order['order_time'],
            'user_id'       => $order['user_id'],
            'how_oos'       => $order['how_oos'],
            'shipping_id'   => $order['shipping_id'],
            'shipping_fee'  => $order['shipping_fee'],
            'consignee'     => $order['consignee'],
            'address'       => $order['address'],
            'country'       => $order['country'],
            'province'      => $order['province'],
            'city'          => $order['city'],
            'district'      => $order['district'],
            'street'        => $order['street'],
            'sign_building' => $order['sign_building'],
            'email'         => $order['email'],
            'mobile'        => $order['mobile'],
            'best_time'     => $order['best_time'],
            'postscript'    => $order['postscript'],
            'insure_fee'    => $order['insure_fee'],
            'agency_id'     => $order['agency_id'],
            'shipping_name' => $order['shipping_name'],
        );
        array_walk($data, 'trim_array_walk');
        $delivery = $data;
        array_walk($send_number, 'trim_array_walk');
        array_walk($send_number, 'intval_array_walk');

        $action_note = isset($_POST['action_note']) ? trim($_POST['action_note']) : __('一键发货', 'orders');

        $delivery['user_id']      = intval($delivery['user_id']);
        $delivery['country']      = trim($delivery['country']);
        $delivery['province']     = trim($delivery['province']);
        $delivery['city']         = trim($delivery['city']);
        $delivery['district']     = trim($delivery['district']);
        $delivery['street']       = trim($delivery['street']);
        $delivery['agency_id']    = intval($delivery['agency_id']);
        $delivery['insure_fee']   = floatval($delivery['insure_fee']);
        $delivery['shipping_fee'] = floatval($delivery['shipping_fee']);

        /* 订单是否已全部分单检查 */
        if ($order['order_status'] == OS_SPLITED) {
            /* 操作失败 */
            $links[]  = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', 'order_id=' . $order_id));
            $os_label = __('已分单', 'orders');
            $ss_label = __('发货中', 'orders');
            return $this->showmessage(sprintf(__('您的订单%s，%s正在%s，%s', 'orders'), $order['order_sn'], $os_label, $ss_label, ecjia::config('shop_name')), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }

        /* 检查此单发货数量填写是否正确 合并计算相同商品和货品 */
        if (!empty($send_number) && !empty($goods_list)) {
            $goods_no_package = array();
            foreach ($goods_list as $key => $value) {
                /* 去除 此单发货数量 等于 0 的商品 */
                if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
                    // 如果是货品则键值为商品ID与货品ID的组合
                    $_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);

                    // 统计此单商品总发货数 合并计算相同ID商品或货品的发货数
                    if (empty($goods_no_package[$_key])) {
                        $goods_no_package[$_key] = $send_number[$value['rec_id']];
                    } else {
                        $goods_no_package[$_key] += $send_number[$value['rec_id']];
                    }

                    //去除
                    if ($send_number[$value['rec_id']] <= 0) {
                        unset($send_number[$value['rec_id']], $goods_list[$key]);
                        continue;
                    }
                } else {
                    /* 组合超值礼包信息 */
                    $goods_list[$key]['package_goods_list'] = package_goods($value['package_goods_list'], $value['goods_number'], $value['order_id'], $value['extension_code'], $value['goods_id']);

                    /* 超值礼包 */
                    foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
                        // 如果是货品则键值为商品ID与货品ID的组合
                        $_key = empty($pg_value['product_id']) ? $pg_value['goods_id'] : ($pg_value['goods_id'] . '_' . $pg_value['product_id']);

                        //统计此单商品总发货数 合并计算相同ID产品的发货数
                        if (empty($goods_no_package[$_key])) {
                            $goods_no_package[$_key] = $send_number[$value['rec_id']][$pg_value['g_p']];
                        } else {
                            //否则已经存在此键值
                            $goods_no_package[$_key] += $send_number[$value['rec_id']][$pg_value['g_p']];
                        }

                        //去除
                        if ($send_number[$value['rec_id']][$pg_value['g_p']] <= 0) {
                            unset($send_number[$value['rec_id']][$pg_value['g_p']], $goods_list[$key]['package_goods_list'][$pg_key]);
                        }
                    }

                    if (count($goods_list[$key]['package_goods_list']) <= 0) {
                        unset($send_number[$value['rec_id']], $goods_list[$key]);
                        continue;
                    }
                }

                /* 发货数量与总量不符 */
                if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
                    $sended = order_delivery_num($order_id, $value['goods_id'], $value['product_id']);
                    if (($value['goods_number'] - $sended - $send_number[$value['rec_id']]) < 0) {
                        /* 操作失败 */
                        $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', 'order_id=' . $order_id));
                        return $this->showmessage(__('此单发货数量不能超出订单商品数量', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));

                    }
                } else {
                    /* 超值礼包 */
                    foreach ($goods_list[$key]['package_goods_list'] as $pg_key => $pg_value) {
                        if (($pg_value['order_send_number'] - $pg_value['sended'] - $send_number[$value['rec_id']][$pg_value['g_p']]) < 0) {
                            /* 操作失败 */
                            $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', 'order_id=' . $order_id));
                            return $this->showmessage(__('此单发货数量不能超出订单商品数量', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
                        }
                    }
                }
            }
        }

        /* 对上一步处理结果进行判断 兼容 上一步判断为假情况的处理 */
        if (empty($send_number) || empty($goods_list)) {
            /* 操作失败 */
            $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', 'order_id=' . $order_id));
            return $this->showmessage(__('发货数量或商品不能为空', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }

        /* 检查此单发货商品库存缺货情况 */
        /* $goods_list已经过处理 超值礼包中商品库存已取得 */
        $virtual_goods         = array();
        $package_virtual_goods = array();
        foreach ($goods_list as $key => $value) {
            // 商品（实货）、（货品）
            //如果是货品则键值为商品ID与货品ID的组合
            $_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);

            /* （实货） */
            if (empty($value['product_id'])) {
                $num = $this->db_goods->where(array('goods_id' => $value['goods_id']))->get_field('goods_number');
            } else {
                /* （货品） */
                $num = $this->db_products->where(array('goods_id' => $value['goods_id'], 'product_id' => $value['product_id']))->get_field('product_number');
            }

            if (($num < $goods_no_package[$_key]) && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
                /* 操作失败 */
                $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id)));
                return $this->showmessage(sprintf(__('商品 %s 已缺货', 'orders'), $value['goods_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));

            }
        }

        /* 生成发货单 */
        /* 获取发货单号和流水号 */
        $delivery['delivery_sn'] = ecjia_order_delivery_sn();
        $delivery_sn             = $delivery['delivery_sn'];
        /* 获取当前操作员 */
        $delivery['action_user'] = $_SESSION['staff_name'];
        /* 获取发货单生成时间 */
        $delivery['update_time'] = GMTIME_UTC;
        $delivery_time           = $delivery['update_time'];

        $delivery['add_time'] = RC_DB::table('order_info')->where('order_sn', $delivery['order_sn'])->value('add_time');

        /* 获取发货单所属供应商 */
        $delivery['suppliers_id'] = $suppliers_id;
        /* 设置默认值 */
        $delivery['status']   = 2; // 正常
        $delivery['order_id'] = $order_id;

        /*地区经纬度赋值*/
        $delivery['longitude'] = $order['longitude'];
        $delivery['latitude']  = $order['latitude'];
        /* 期望送货时间*/
        $delivery['best_time'] = $order['expect_shipping_time'];

        if (empty($delivery['longitude']) || empty($delivery['latitude'])) {
            $province_name = ecjia_region::getRegionName($delivery['province']);
            $city_name     = ecjia_region::getRegionName($delivery['city']);
            $district_name = ecjia_region::getRegionName($delivery['district']);
            $street_name   = ecjia_region::getRegionName($delivery['street']);

            $consignee_address = '';
            if (!empty($province_name)) {
                $consignee_address .= $province_name;
            }
            if (!empty($city_name)) {
                $consignee_address .= $city_name;
            }
            if (!empty($district_name)) {
                $consignee_address .= $district_name;
            }
            if (!empty($street_name)) {
                $consignee_address .= $street_name;
            }
            $consignee_address .= $delivery['address'];
            $consignee_address = urlencode($consignee_address);

            //腾讯地图api 地址解析（地址转坐标）
            $key        = ecjia::config('map_qq_key');
            $shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=" . $consignee_address . "&key=" . $key);
            $shop_point = json_decode($shop_point['body'], true);
            if (isset($shop_point['result']) && !empty($shop_point['result']['location'])) {
                $delivery['longitude'] = $shop_point['result']['location']['lng'];
                $delivery['latitude']  = $shop_point['result']['location']['lat'];
            }
        }

        /* 过滤字段项 */
        $filter_fileds = array(
            'order_sn', 'add_time', 'user_id', 'how_oos', 'shipping_id', 'shipping_fee',
            'consignee', 'address', 'longitude', 'latitude', 'country', 'province', 'city', 'district', 'street', 'sign_building',
            'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'insure_fee',
            'agency_id', 'delivery_sn', 'action_user', 'update_time',
            'suppliers_id', 'status', 'order_id', 'shipping_name',
        );
        $_delivery     = array();
        foreach ($filter_fileds as $value) {
            $_delivery[$value] = $delivery[$value];
        }

        $_delivery['store_id'] = $_SESSION['store_id'];

        /* 发货单入库 */
        $delivery_id = RC_DB::table('delivery_order')->insertGetId($_delivery);

        if ($delivery_id) {
            $ss_label = __('配货中', 'orders');
            $data     = array(
                'order_status' => $ss_label,
                'order_id'     => $order_id,
                'message'      => sprintf(__('订单号为 %s 的商品正在备货中，请您耐心等待', 'orders'), $order['order_sn']),
                'add_time'     => RC_Time::gmtime(),
            );
            RC_DB::table('order_status_log')->insert($data);
        }

        if ($delivery_id) {
            $delivery_goods = array();
            if (!empty($goods_list)) {
                foreach ($goods_list as $value) {
                    // 商品（实货）（虚货）
                    if (empty($value['extension_code']) || $value['extension_code'] == 'virtual_card') {
                        $delivery_goods = array(
                            'delivery_id' => $delivery_id,
                            'goods_id'    => $value['goods_id'],
                            'product_id'  => $value['product_id'],
                            'product_sn'  => $value['product_sn'],
                            'goods_id'    => $value['goods_id'],
                            'goods_name'  => addslashes($value['goods_name']),
                            'brand_name'  => addslashes($value['brand_name']),
                            'goods_sn'    => $value['goods_sn'],
                            'send_number' => $send_number[$value['rec_id']],
                            'parent_id'   => 0,
                            'is_real'     => $value['is_real'],
                            'goods_attr'  => addslashes($value['goods_attr']),
                        );

                        /* 如果是货品 */
                        if (!empty($value['product_id'])) {
                            $delivery_goods['product_id'] = $value['product_id'];
                        }
                        RC_DB::table('delivery_goods')->insert($delivery_goods);
                    } elseif ($value['extension_code'] == 'package_buy') {
                        // 商品（超值礼包）
                        foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
                            $delivery_pg_goods = array(
                                'delivery_id'    => $delivery_id,
                                'goods_id'       => $pg_value['goods_id'],
                                'product_id'     => $pg_value['product_id'],
                                'product_sn'     => $pg_value['product_sn'],
                                'goods_name'     => $pg_value['goods_name'],
                                'brand_name'     => '',
                                'goods_sn'       => $pg_value['goods_sn'],
                                'send_number'    => $send_number[$value['rec_id']][$pg_value['g_p']],
                                'parent_id'      => $value['goods_id'], // 礼包ID
                                'extension_code' => $value['extension_code'], // 礼包
                                'is_real'        => $pg_value['is_real'],
                            );
                            RC_DB::table('delivery_goods')->insert($delivery_pg_goods);
                        }
                    }
                }
            }
        } else {
            /* 操作失败 */
            $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/merchant/info', array('order_id' => $order_id)));
            return $this->showmessage(__('操作失败', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));

        }
        unset($filter_fileds, $delivery, $_delivery, $order_finish);

        /* 订单信息更新处理 */
        if (true) {
            /* 订单信息 */
            $_sended = &$send_number;
            foreach ($_goods['goods_list'] as $key => $value) {
                if ($value['extension_code'] != 'package_buy') {
                    unset($_goods['goods_list'][$key]);
                }
            }
            foreach ($goods_list as $key => $value) {
                if ($value['extension_code'] == 'package_buy') {
                    unset($goods_list[$key]);
                }
            }
            $_goods['goods_list'] = $goods_list + $_goods['goods_list'];
            unset($goods_list);

            /* 更新订单的虚拟卡 商品（虚货） */
            $_virtual_goods = isset($virtual_goods['virtual_card']) ? $virtual_goods['virtual_card'] : '';
            update_order_virtual_goods($order_id, $_sended, $_virtual_goods);

            /* 更新订单的非虚拟商品信息 即：商品（实货）（货品）、商品（超值礼包）*/
            update_order_goods($order_id, $_sended, $_goods['goods_list']);

            /* 标记订单为已确认 “发货中” */
            /* 更新发货时间 */
            $order_finish    = get_order_finish($order_id);
            $shipping_status = SS_SHIPPED_ING;
            if ($order['order_status'] != OS_CONFIRMED && $order['order_status'] != OS_SPLITED && $order['order_status'] != OS_SPLITING_PART) {
                $arr['order_status'] = OS_CONFIRMED;
                $arr['confirm_time'] = GMTIME_UTC;
            }

            $arr['order_status']    = $order_finish ? OS_SPLITED : OS_SPLITING_PART; // 全部分单、部分分单
            $arr['shipping_status'] = $shipping_status;
            $arr['shipping_id']     = $order['shipping_id'];
            $arr['shipping_name']   = $order['shipping_name'];

            update_order($order_id, $arr);
        }

        /* 记录log */
        order_action($order['order_sn'], $arr['order_status'], $shipping_status, $order['pay_status'], $action_note);

        $delivery_order = delivery_order_info($delivery_id);

        /* 取得用户名 */
        if ($delivery_order['user_id'] > 0) {
            $user = user_info($delivery_order['user_id']);
            if (is_ecjia_error($user)) {
                $user = array();
            }
            if (!empty($user)) {
                $delivery_order['user_name'] = $user['user_name'];
            }
        }

        /* 取得区域名 */
        $field         = array("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region");
        $db_order_info = RC_DB::table('order_info as o')
            ->leftJoin('regions as c', RC_DB::raw('o.country'), '=', RC_DB::raw('c.region_id'))
            ->leftJoin('regions as p', RC_DB::raw('o.province'), '=', RC_DB::raw('p.region_id'))
            ->leftJoin('regions as t', RC_DB::raw('o.city'), '=', RC_DB::raw('t.region_id'))
            ->leftJoin('regions as d', RC_DB::raw('o.district'), '=', RC_DB::raw('d.region_id'));
        $order_id      = $delivery_order['order_id'];

        $region = $db_order_info
            ->select(RC_DB::raw("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region"))
            ->where(RC_DB::raw('o.order_id'), $order_id)->first();

        $delivery_order['region'] = $region['region'];

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
        $data     = RC_DB::table('order_action')->where('order_id', $delivery_order['order_id'])
            ->where('action_place', 1)
            ->orderBy('log_time', 'asc')
            ->orderBy('action_id', 'asc')
            ->get();

        if (!empty($data)) {
            $os = array(
                OS_UNCONFIRMED   => __('未接单', 'orders'),
                OS_CONFIRMED     => __('已接单', 'orders'),
                OS_CANCELED      => __('<font color="red">取消</font>', 'orders'),
                OS_INVALID       => __('<font color="red">无效</font>', 'orders'),
                OS_RETURNED      => __('<font color="red">退货</font>', 'orders'),
                OS_SPLITED       => __('已分单', 'orders'),
                OS_SPLITING_PART => __('部分分单', 'orders'),
            );

            $ps = array(
                PS_UNPAYED => __('未付款', 'orders'),
                PS_PAYING  => __('付款中', 'orders'),
                PS_PAYED   => __('已付款', 'orders'),
            );

            $ss_admin = array(
                SS_SHIPPED_ING => __('发货中（前台状态：未发货）', 'orders')
            );

            $ss = array(
                SS_UNSHIPPED    => __('未发货', 'orders'),
                SS_PREPARING    => __('配货中', 'orders'),
                SS_SHIPPED      => __('已发货', 'orders'),
                SS_RECEIVED     => __('收货确认', 'orders'),
                SS_SHIPPED_PART => __('已发货(部分商品)', 'orders'),
                SS_SHIPPED_ING  => __('发货中', 'orders'),
            );

            foreach ($data as $key => $row) {
                $row['order_status']    = $os[$row['order_status']];
                $row['pay_status']      = $ps[$row['pay_status']];
                $row['shipping_status'] = ($row['shipping_status'] == SS_SHIPPED_ING) ? $ss_admin[SS_SHIPPED_ING] : $ss[$row['shipping_status']];
                $row['action_time']     = RC_Time::local_date(ecjia::config('time_format'), $row['log_time']);
                $act_list[]             = $row;
            }
        }

        /* 判断配送方式是否是立即送*/
        $shipping_info = ecjia_shipping::pluginData(intval($delivery_order['shipping_id']));
        if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
            /* 获取正在派单的配送员*/
            $staff_list = RC_DB::table('staff_user')
                ->where('store_id', $_SESSION['store_id'])
                ->where('online_status', 1)
                ->get();

            $express_order = RC_DB::table('express_order')->where('delivery_id', $delivery_order['delivery_id'])->first();
            $order         = RC_Api::api('orders', 'order_info', array('order_id' => $delivery_order['order_id']));
        }

        /*配送方式为o2o速递或众包配送时，自动生成运单号*/
        if (empty($delivery_order['invoice_no'])) {
            $shipping_id   = $delivery_order['shipping_id'];
            $shipping_info = RC_DB::table('shipping')->where('shipping_id', $shipping_id)->first();
            if ($shipping_info['shipping_code'] == 'ship_o2o_express' || $shipping_info['shipping_code'] == 'ship_ecjia_express') {
                $rand1                        = mt_rand(100000, 999999);
                $rand2                        = mt_rand(1000000, 9999999);
                $invoice_no                   = $rand1 . $rand2;
                $delivery_order['invoice_no'] = $invoice_no;
            }
        }
        /*检查订单商品是否存在或已移除到回收站*/
        $order_goods_ids = RC_DB::table('order_goods')->where('order_id', $order_id)->select(RC_DB::raw('goods_id'))->get();
        foreach ($order_goods_ids as $key => $val) {
            $goods_info = RC_DB::table('goods')->where('goods_id', $val['goods_id'])->first();
            $goods_name = $goods_info['goods_name'];
            if (empty($goods_info)) {
                return $this->showmessage(__('此订单包含的商品已被删除，请核对后再发货！', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($goods_info['is_delete'] == 1) {
                return $this->showmessage(sprintf(__('此订单包含的商品【%s】已被移除到了回收站，请核对后再发货！', 'orders'), $goods_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        /* 检查此单发货商品库存缺货情况 */
        $virtual_goods         = array();
        $delivery_stock_result = RC_DB::table('delivery_goods as dg')
            ->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->leftJoin('products as p', RC_DB::raw('dg.product_id'), '=', RC_DB::raw('p.product_id'))
            ->select(RC_DB::raw('dg.goods_id'), RC_DB::raw('dg.is_real'), RC_DB::raw('dg.product_id'), RC_DB::raw('SUM(dg.send_number) AS sums'), RC_DB::raw("IF(dg.product_id > 0, p.product_number, g.goods_number) AS storage"), RC_DB::raw('g.goods_name'), RC_DB::raw('dg.send_number'))
            ->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
            ->groupBy(RC_DB::raw('dg.product_id'))
            ->get();

        /* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
        if (!empty($delivery_stock_result)) {
            foreach ($delivery_stock_result as $value) {
                if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) &&
                    ((ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) ||
                        (ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {

                    /* 操作失败 */
                    $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/mh_delivery/delivery_info', 'delivery_id=' . $delivery_id));
                    return $this->showmessage(sprintf(__('商品 %s 已缺货', 'orders'), $value['goods_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
                }

                /* 虚拟商品列表 virtual_card */
                if ($value['is_real'] == 0) {
                    $virtual_goods[] = array(
                        'goods_id'   => $value['goods_id'],
                        'goods_name' => $value['goods_name'],
                        'num'        => $value['send_number'],
                    );
                }
            }
        } else {
            $delivery_stock_result = RC_DB::table('delivery_goods as dg')
                ->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
                ->select(RC_DB::raw('dg.goods_id'), RC_DB::raw('dg.is_real'), RC_DB::raw('SUM(dg.send_number) AS sums'), RC_DB::raw('g.goods_number'), RC_DB::raw('g.goods_name'), RC_DB::raw('dg.send_number'))
                ->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
                ->groupBy(RC_DB::raw('dg.goods_id'))
                ->get();

            foreach ($delivery_stock_result as $value) {
                if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) &&
                    ((ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) ||
                        (ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
                    /* 操作失败 */
                    $links[] = array('text' => __('订单信息', 'orders'), 'href' => RC_Uri::url('orders/order_delilvery/delivery_info', 'delivery_id=' . $delivery_id));
                    return $this->showmessage(sprintf(__('商品 %s 已缺货', 'orders'), $value['goods_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
                }

                /* 虚拟商品列表 virtual_card*/
                if ($value['is_real'] == 0) {
                    $virtual_goods[] = array(
                        'goods_id'   => $value['goods_id'],
                        'goods_name' => $value['goods_name'],
                        'num'        => $value['send_number'],
                    );
                }
            }
        }

        /* 发货 */
        /* 处理虚拟卡 商品（虚货） */
        // if (is_array($virtual_goods) && count($virtual_goods) > 0) {
        //     foreach ($virtual_goods as $virtual_value) {
        //         virtual_card_shipping($virtual_value, $order['order_sn'], $msg, 'split');
        //     }
        // }

        /* 如果使用库存，且发货时减库存，则修改库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
            RC_Loader::load_app_class('order_stork', 'orders');
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
                        //发货警告库存发送短信
                        order_stork::sms_goods_stock_warning($value['goods_id']);
                    }
                }
            }
        }

        /* 修改发货单信息 */
        $_delivery['invoice_no'] = !empty($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '';
        $_delivery['status']     = 0; /* 0，为已发货 */
        $result                  = $this->db_delivery_order->where(array('delivery_id' => $delivery_id))->update($_delivery);

        /*操作成功*/
        if ($result) {
            $data = array(
                'order_status' => __('已发货', 'orders'),
                'message'      => sprintf(__('订单号为 %s 的商品已发货，请您耐心等待', 'orders'), $order['order_sn']),
                'order_id'     => $order_id,
                'add_time'     => RC_Time::gmtime(),
            );
            RC_DB::table('order_status_log')->insert($data);
        } else {
            $links[] = array('text' => __('发货单查看', 'orders'), 'href' => RC_Uri::url('orders/mh_delivery/delivery_info', array('delivery_id' => $delivery_id)));
            return $this->showmessage(__('操作失败', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }

        /* 标记订单为已确认 “已发货” */
        /* 更新发货时间 */
        $order_finish           = get_all_delivery_finish($order_id);
        $shipping_status        = ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
        $arr['shipping_status'] = $shipping_status;
        $arr['shipping_time']   = GMTIME_UTC; // 发货时间
        $arr['invoice_no']      = $_delivery['invoice_no'];

        update_order($order_id, $arr);
        /* 记录日志 */
        ecjia_merchant::admin_log(sprintf(__('发货，订单号是%s', 'orders'), $order['order_sn']), 'setup', 'order');
        /* 发货单发货记录log */
        order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note, null, 1);

        /* 判断发货单，生成配送单*/
        $shipping_info = ecjia_shipping::pluginData(intval($delivery_order['shipping_id']));

        if ($shipping_info['shipping_code'] == 'ship_o2o_express' || $shipping_info['shipping_code'] == 'ship_ecjia_express') {
            $staff_id     = isset($_POST['staff_id']) ? intval($_POST['staff_id']) : 0;
            $express_from = !empty($staff_id) ? 'assign' : 'grab';
            $express_data = array(
                'express_sn'    => ecjia_order_express_sn(),
                'order_sn'      => $delivery_order['order_sn'],
                'order_id'      => $delivery_order['order_id'],
                'delivery_id'   => $delivery_order['delivery_id'],
                'delivery_sn'   => $delivery_order['delivery_sn'],
                'store_id'      => $delivery_order['store_id'],
                'user_id'       => $delivery_order['user_id'],
                'consignee'     => $delivery_order['consignee'],
                'address'       => $delivery_order['address'],
                'country'       => $delivery_order['country'],
                'province'      => $delivery_order['province'],
                'city'          => $delivery_order['city'],
                'district'      => $delivery_order['district'],
                'street'        => $delivery_order['street'],
                'email'         => $delivery_order['email'],
                'mobile'        => $delivery_order['mobile'],
                'best_time'     => $delivery_order['best_time'],
                'remark'        => '',
                'shipping_fee'  => $delivery_order['shipping_fee'],
                'shipping_code' => $shipping_info['shipping_code'],
                'commision'     => '',
                'add_time'      => RC_Time::gmtime(),
                'longitude'     => $delivery_order['longitude'],
                'latitude'      => $delivery_order['latitude'],
                'from'          => $express_from,
                'status'        => $express_from == 'grab' ? 0 : 1,
                'staff_id'      => $staff_id,
            );

            if ($staff_id > 0) {
                $express_data['receive_time']   = RC_Time::gmtime();
                $staff_info                     = RC_DB::table('staff_user')->where('user_id', $staff_id)->first();
                $express_data['express_user']   = $staff_info['name'];
                $express_data['express_mobile'] = $staff_info['mobile'];
            }

            $store_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();

            if (!empty($store_info['longitude']) && !empty($store_info['latitude'])) {
                //腾讯地图api距离计算
                $key                      = ecjia::config('map_qq_key');
                $url                      = "https://apis.map.qq.com/ws/distance/v1/?mode=driving&from=" . $store_info['latitude'] . "," . $store_info['longitude'] . "&to=" . $delivery_order['latitude'] . "," . $delivery_order['longitude'] . "&key=" . $key;
                $distance_json            = file_get_contents($url);
                $distance_info            = json_decode($distance_json, true);
                $express_data['distance'] = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
            }

            $exists_express_order = RC_DB::table('express_order')->where('delivery_sn', $delivery_order['delivery_sn'])->where('store_id', $_SESSION['store_id'])->first();
            if ($exists_express_order) {
                unset($express_data['add_time']);
                $express_data['update_time'] = RC_Time::gmtime();
                RC_DB::table('express_order')->where('express_id', $exists_express_order['express_id'])->update($express_data);
                $express_id = $exists_express_order['express_id'];
            } else {
                $express_id = RC_DB::table('express_order')->insertGetId($express_data);
            }

            /*配送单生成后，自动派单。只有订单配送方式是众包配送和商家配送时才去自动派单*/
            if ($shipping_info['shipping_code'] == 'ship_ecjia_express' && empty($staff_id)) {
                $params = array(
                    'express_id' => $express_id,
                );
                $result = RC_Api::api('express', 'ecjiaauto_assign_expressOrder', $params);
            } elseif ($shipping_info['shipping_code'] == 'ship_o2o_express' && empty($staff_id)) {
                $params = array(
                    'express_id' => $express_id,
                    'store_id'   => $_SESSION['store_id'],
                );
                $result = RC_Api::api('express', 'o2oauto_assign_expressOrder', $params);
            }

            /* 如果派单*/
            if ($staff_id > 0) {
                /* 消息插入 */
                $orm_staff_user_db = RC_Model::model('orders/orm_staff_user_model');
                $user              = $orm_staff_user_db->find($staff_id);

                //$where = array('express_id' => $express_id);
                $field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.district as sf_district, sf.street as sf_street, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
                //$express_order_info = $express_order_viewdb->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->find();

                $express_order_viewdb = RC_DB::table('express_order as eo')
                    ->leftjoin('store_franchisee as sf', RC_DB::raw('sf.store_id'), '=', RC_DB::raw('eo.store_id'))
                    ->leftjoin('order_info as oi', RC_DB::raw('eo.order_id'), '=', RC_DB::raw('oi.order_id'));

                $express_order_info = $express_order_viewdb->where(RC_DB::raw('eo.express_id'), $express_id)->select(RC_DB::raw($field))->first();

                /* 派单发短信 */
                if (!empty($express_order_info['express_mobile'])) {
                    $options = array(
                        'mobile' => $express_order_info['express_mobile'],
                        'event'  => 'sms_express_system_assign',
                        'value'  => array(
                            'express_sn' => $express_order_info['express_sn'],
                        ),
                    );
                    RC_Api::api('sms', 'send_event_sms', $options);
                }

                /*派单推送消息*/
                $options = array(
                    'user_id'   => $staff_id,
                    'user_type' => 'merchant',
                    'event'     => 'express_system_assign',
                    'value'     => array(
                        'express_sn' => $express_order_info['express_sn'],
                    ),
                    'field'     => array(
                        'open_type' => 'admin_message',
                    ),
                );
                RC_Api::api('push', 'push_event_send', $options);

                //消息通知
                $express_from_address = ecjia_region::getRegionName($express_order_info['sf_district']) . ecjia_region::getRegionName($express_order_info['sf_street']) . $express_order_info['merchant_address'];
                $express_to_address   = ecjia_region::getRegionName($express_order_info['district']) . ecjia_region::getRegionName($express_order_info['street']) . $express_order_info['address'];

                $notification_express_data = array(
                    'title' => __('系统派单', 'orders'),
                    'body'  => __('有单啦！系统已分配配送单到您账户，赶快行动起来吧！', 'orders'),
                    'data'  => array(
                        'express_id'            => $express_order_info['express_id'],
                        'express_sn'            => $express_order_info['express_sn'],
                        'express_type'          => $express_order_info['from'],
                        'label_express_type'    => $express_order_info['from'] == 'assign' ? __('系统派单', 'orders') : __('抢单', 'orders'),
                        'order_sn'              => $express_order_info['order_sn'],
                        'payment_name'          => $express_order_info['pay_name'],
                        'express_from_address'  => '【' . $express_order_info['merchants_name'] . '】' . $express_from_address,
                        'express_from_location' => array(
                            'longitude' => $express_order_info['merchant_longitude'],
                            'latitude'  => $express_order_info['merchant_latitude'],
                        ),
                        'express_to_address'    => $express_to_address,
                        'express_to_location'   => array(
                            'longitude' => $express_order_info['longitude'],
                            'latitude'  => $express_order_info['latitude'],
                        ),
                        'distance'              => $express_order_info['distance'],
                        'consignee'             => $express_order_info['consignee'],
                        'mobile'                => $express_order_info['mobile'],
                        'receive_time'          => RC_Time::local_date(ecjia::config('time_format'), $express_order_info['receive_time']),
                        'order_time'            => RC_Time::local_date(ecjia::config('time_format'), $express_order_info['order_time']),
                        'pay_time'              => empty($express_order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['pay_time']),
                        'best_time'             => $express_order_info['best_time'],
                        'shipping_fee'          => $express_order_info['shipping_fee'],
                        'order_amount'          => $express_order_info['order_amount'],
                    ),
                );
                $express_assign            = new ExpressAssign($notification_express_data);
                RC_Notification::send($user, $express_assign);

            }

            /* 如果是o2o速递则在 ecjia_express_track_record表内更新一条记录*/
            $express_track_record_data = array(
                "express_code" => $shipping_info['shipping_code'],
                "track_number" => $delivery_order['invoice_no'],
                "time"         => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()),
                "context"      => __("您的订单已配备好，等待配送员取货", 'orders'),
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
                $integral      = integral_to_give($order);
                $integral_name = ecjia::config('integral_name');
                if (empty($integral_name)) {
                    $integral_name = __('积分', 'orders');
                }
                $options = array(
                    'user_id'     => $order['user_id'],
                    'rank_points' => intval($integral['rank_points']),
                    'pay_points'  => intval($integral['custom_points']),
                    'change_desc' => sprintf(__('%s赠送的' . $integral_name, 'orders'), $order['order_sn']),
                    'from_type'   => 'order_give_integral',
                    'from_value'  => $order['order_sn'],
                );
                RC_Api::api('user', 'account_change_log', $options);
                /* 发放红包 */
                send_order_bonus($order_id);
            }

            /* 发送邮件 */
            $cfg = ecjia::config('send_ship_email');
            if ($cfg == '1') {
                $order['invoice_no'] = $invoice_no;
                $tpl_name            = 'deliver_notice';
                $tpl                 = RC_Api::api('mail', 'mail_template', $tpl_name);

                $this->assign('order', $order);
                $this->assign('send_time', RC_Time::local_date(ecjia::config('time_format')));
                $this->assign('shop_name', ecjia::config('shop_name'));
                $this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
                $this->assign('confirm_url', SITE_URL . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
                $this->assign('send_msg_url', SITE_URL . RC_Uri::url('user/admin/message_list', 'order_id=' . $order['order_id']));

                $content = $this->fetch_string($tpl['template_content']);
            }
            /* 商家发货 如果需要，发短信 */
            $userinfo = RC_DB::table('users')->where('user_id', $order['user_id'])->select('user_name', 'mobile_phone')->first();
            if (!empty($userinfo['mobile_phone'])) {
                //发送短信
                $user_name = $userinfo['user_name'];
                $options   = array(
                    'mobile' => $userinfo['mobile_phone'],
                    'event'  => 'sms_order_shipped',
                    'value'  => array(
                        'user_name'     => $user_name,
                        'order_sn'      => $order['order_sn'],
                        'consignee'     => $order['consignee'],
                        'service_phone' => ecjia::config('service_phone'),
                    ),
                );
                RC_Api::api('sms', 'send_event_sms', $options);
            }

        }

        $user_name = RC_DB::table('users')->where('user_id', $order['user_id'])->value('user_name');
        /*商家发货 推送消息*/
        $options = array(
            'user_id'   => $order['user_id'],
            'user_type' => 'user',
            'event'     => 'order_shipped',
            'value'     => array(
                'user_name'     => $user_name,
                'order_sn'      => $order['order_sn'],
                'consignee'     => $order['consignee'],
                'service_phone' => ecjia::config('service_phone'),
            ),
            'field'     => array(
                'open_type' => 'admin_message',
            ),
        );
        RC_Api::api('push', 'push_event_send', $options);

        //消息通知
        $orm_user_db = RC_Model::model('orders/orm_users_model');
        $user_ob     = $orm_user_db->find($order['user_id']);

        $order_data = array(
            'title' => __('客户下单', 'orders'),
            'body'  => sprintf(__('您有一笔新订单，订单号为：%s', 'orders'), $order['order_sn']),
            'data'  => array(
                'order_id'               => $order['order_id'],
                'order_sn'               => $order['order_sn'],
                'order_amount'           => $order['order_amount'],
                'formatted_order_amount' => price_format($order['order_amount']),
                'consignee'              => $order['consignee'],
                'mobile'                 => $order['mobile'],
                'address'                => $order['address'],
                'order_time'             => RC_Time::local_date(ecjia::config('time_format'), $order['add_time']),
                'shipping_time'          => RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']),
                'invoice_no'             => $invoice_no,
            ),
        );

        $push_order_shipped = new OrderShipped($order_data);
        RC_Notification::send($user_ob, $push_order_shipped);

        /* 操作成功 */
        $links[] = array('text' => __('发货单列表', 'orders'), 'href' => RC_Uri::url('orders/mh_delivery/init'));
        $links[] = array('text' => __('发货单查看', 'orders'), 'href' => RC_Uri::url('orders/mh_delivery/delivery_info', 'delivery_id=' . $delivery_id));

        return $this->showmessage(__('操作成功', 'orders'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/mh_delivery/delivery_info', array('delivery_id' => $delivery_id)), 'links' => $links));

    }

    public function import()
    {
        $filter                   = $_GET;
        $filter['store_id']       = $_SESSION['store_id'];
        $filter['extension_code'] = !empty($_GET['extension_code']) ? trim($_GET['extension_code']) : 'default';
        $orders                   = with(new Ecjia\App\Orders\Repositories\OrdersRepository())
            ->getOrderList($filter, 0, 0, null, ['Ecjia\App\Orders\CustomizeOrderList', 'exportAllOrderListMerchant']);

        RC_Excel::load(RC_APP_PATH . 'orders' . DIRECTORY_SEPARATOR . 'statics/files/merchant_orders.xls', function ($excel) use ($orders) {
            $excel->sheet('First sheet', function ($sheet) use ($orders) {
                foreach ($orders as $key => $item) {
                    $sheet->appendRow($key + 2, $item);
                }
            });
        })->download('xls');
    }

    //生成发货单页面 编辑配送方式 （原订单已付款页面编辑订单功能）
    public function edit_shipping()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit');

        /* 取得参数 order_id */
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单信息', 'orders'), RC_Uri::url("orders/merchant/info&order_id=$order_id")));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑订单', 'orders')));

        $order = RC_Api::api('orders', 'merchant_order_info', array('order_id' => $order_id));

        if (empty($order) || is_ecjia_error($order) || $order['store_id'] != $_SESSION['store_id']) {
            $links[] = array('text' => __('返回订单列表', 'orders'), 'href' => RC_Uri::url('orders/merchant/init'));
            return $this->showmessage(__('无法找到对应的订单！', 'orders'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }
        if ($order['order_status'] == OS_INVALID) {
            $links[] = array('text' => __('返回订单列表', 'orders'), 'href' => RC_Uri::url('orders/merchant/init'));
            return $this->showmessage(__('该订单已失效无法操作！', 'orders'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }
        $this->assign('order_id', $order_id);

        $action_note = trim($_GET['action_note']);
        $this->assign('action_note', $action_note);

        /* 取得订单信息 */
        if ($order_id > 0) {
            /* 发货单格式化 */
            $order['invoice_no'] = str_replace('<br>', ',', $order['invoice_no']);
            $this->assign('order', $order);
        }

        $ur_here = __('编辑订单配送方式', 'orders');
        $this->assign('ur_here', $ur_here);

        /* 查询是否存在实体商品 */
        $exist_real_goods = exist_real_goods($order_id);
        if ($exist_real_goods) {
            /* 取得可用的配送方式列表 */
            $region_id_list = array(
                $order['country'], $order['province'], $order['city'], $order['district'], $order['street'],
            );
            $shipping_list  = ecjia_shipping::availableUserShippings($region_id_list, $_SESSION['store_id']);

            if (empty($shipping_list)) {
                $this->assign('shipping_list_error', 1);
            }
            /* 取得配送费用 */
            $total = order_weight_price($order_id);
            if (!empty($shipping_list)) {
                foreach ($shipping_list as $key => $shipping) {
                    $shipping_fee = ecjia_shipping::fee($shipping['shipping_area_id'], $total['weight'], $total['amount'], $total['number']);

                    $shipping_list[$key]['shipping_fee']        = $shipping_fee;
                    $shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee);
                    $shipping_list[$key]['free_money']          = price_format($shipping['configure']['free_money']);
                }
            }
            $this->assign('shipping_list', $shipping_list);
        }

        /* 取得可用的支付方式列表 */
        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        if (exist_real_goods($order_id)) {
            /* 存在实体商品 */
            $region_id_list = array(
                $order['country'], $order['province'], $order['city'], $order['district'], $order['street'],
            );
            $shipping_area  = ecjia_shipping::shippingArea($order['shipping_id'], $region_id_list, $_SESSION['store_id']);

            $pay_fee      = ($shipping_area['support_cod'] == 1) ? $shipping_area['pay_fee'] : 0;
            $payment_list = $payment_method->available_payment_list(true, $pay_fee);

        } else {
            /* 不存在实体商品 */
            $payment_list = $payment_method->available_payment_list(false);
        }

        /* 过滤掉使用余额支付 */
        foreach ($payment_list as $key => $payment) {
            if ($payment['pay_code'] == 'balance') {
                unset($payment_list[$key]);
            }
        }
        $this->assign('exist_real_goods', $exist_real_goods);
        $this->assign('payment_list', $payment_list);

        return $this->display('order_edit_shipping.dwt');
    }

    //编辑订单提交
    public function edit_shipping_post()
    {
        /* 检查权限 */
        $this->admin_priv('order_edit', ecjia::MSGTYPE_JSON);

        $store_id = $_SESSION['store_id'];

        /* 取得参数 order_id */
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if ($order_id > 0) {
            $old_order = order_info($order_id);
        }
        $action_note = trim($_POST['action_no']);

        /* 保存配送信息 */
        /* 取得订单信息 */
        $order_info = order_info($order_id);

        $region_id_list = array($order_info['country'], $order_info['province'], $order_info['city'], $order_info['district'], $order_info['street']);
        /* 保存订单 */
        $shipping_id     = $_POST['shipping'];
        $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
        $shipping        = $shipping_method->shipping_area_info($shipping_id, $region_id_list, $store_id);
//         $weight_amount = order_weight_price($order_id);
        //         $shipping_fee = $shipping_method->shipping_fee($shipping['shipping_code'], $shipping['configure'], $weight_amount['weight'], $weight_amount['amount'], $weight_amount['number']);

        $order = array(
            'shipping_id'   => $shipping_id,
            'shipping_name' => addslashes($shipping['shipping_name']),
//             'shipping_fee'    => $shipping_fee //修改配送方式 配送费不变，价格自行商家承担
        );

        if (isset($_POST['insure'])) {
            /* 计算保价费 */
            $order['insure_fee'] = shipping_insure_fee($shipping['shipping_code'], order_amount($order_id), $shipping['insure']);
        } else {
            $order['insure_fee'] = 0;
        }

        update_order($order_id, $order);
        update_order_amount($order_id);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* todo 记录日志 */
        $sn        = $old_order['order_sn'];
        $new_order = order_info($order_id);
        if ($old_order['total_fee'] != $new_order['total_fee']) {
            $sn .= ',' . sprintf(__('订单总金额由 %s 变为 %s', 'orders'), $old_order['total_fee'], $new_order['total_fee']);
        }
        ecjia_merchant::admin_log(sprintf(__('编辑配送方式，订单是%s', 'orders'), $sn), 'edit', 'order');

        /* 取得支付信息 */
        $pay_id         = $_POST['payment'];
        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        $payment        = $payment_method->payment_info($pay_id);
        /* 计算支付费用 */
        $order_amount = order_amount($order_id);
        if ($payment['is_cod'] == 1) {
            $order           = order_info($order_id);
            $region_id_list  = array($order['country'], $order['province'], $order['city'], $order['district'], $order['street']);
            $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
            $shipping        = $shipping_method->shipping_area_info($order['shipping_id'], $region_id_list);

            $pay_fee = pay_fee($pay_id, $order_amount, $shipping['pay_fee']);
        } else {
            $pay_fee = pay_fee($pay_id, $order_amount);
        }
        /* 保存订单 */
        $order = array(
            'pay_id'   => $pay_id,
            'pay_name' => addslashes($payment['pay_name']),
            'pay_fee'  => $pay_fee,
        );
        update_order($order_id, $order);
        update_order_amount($order_id);

        /* 更新 pay_log */
        update_pay_log($order_id);

        //已付款订单修改配送方式为上门取货 重新生成取货码
        if ($shipping['shipping_code'] == 'ship_cac' && $order_info['pay_status'] == PS_PAYED) {
            $db_term_meta = RC_DB::table('term_meta');
            $max_code     = $db_term_meta
                ->where('object_type', 'ecjia.order')
                ->where('object_group', 'order')
                ->where('meta_key', 'receipt_verification')
                ->max('meta_value');

            $max_code = $max_code ? ceil($max_code / 10000) : 1000000;
            $code     = $max_code . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $mobile  = RC_DB::table('users')->where('user_id', $order_info['user_id'])->value('mobile_phone');
            $options = array(
                'mobile' => $mobile,
                'event'  => 'sms_order_pickup',
                'value'  => array(
                    'order_sn'      => $order['order_sn'],
                    'user_name'     => $order['consignee'],
                    'code'          => $code,
                    'service_phone' => ecjia::config('service_phone'),
                ),
            );
            RC_Api::api('sms', 'send_event_sms', $options);

            $term_meta_db = RC_DB::table('term_meta')
                ->where('object_type', 'ecjia.order')
                ->where('object_group', 'order')
                ->where('object_id', $order_id)
                ->where('meta_key', 'receipt_verification');

            //判断是否存在提货码信息
            $count = $term_meta_db->count();

            //存在更新
            if ($count != 0) {
                $term_meta_db->update(array('meta_value' => $code));
            } else {
                //不存在添加
                $meta_data = array(
                    'object_type'  => 'ecjia.order',
                    'object_group' => 'order',
                    'object_id'    => $order_id,
                    'meta_key'     => 'receipt_verification',
                    'meta_value'   => $code,
                );
                RC_DB::table('term_meta')->insert($meta_data);
            }
        }

        /* todo 记录日志 */
        $sn        = $old_order['order_sn'];
        $new_order = order_info($order_id);

        if ($old_order['total_fee'] != $new_order['total_fee']) {
            $sn .= ',' . sprintf(__('订单总金额由 %s 变为 %s', 'orders'), $old_order['total_fee'], $new_order['total_fee']);
        }
        ecjia_merchant::admin_log(sprintf(__('编辑配送方式，订单号是%s', 'orders'), $sn), 'edit', 'order');

        /* 初始化提示信息和链接 */
        $msgs  = array();
        $links = array();
        /* 如果已付款，检查金额是否变动，并执行相应操作 */
        $order = order_info($order_id);
        handle_order_money_change($order, $msgs, $links);

        $url = RC_Uri::url('orders/merchant/go_shipping', array('order_id' => $order_id));
        if (!empty($action_note)) {
            $url = RC_Uri::url('orders/merchant/go_shipping', array('order_id' => $order_id, 'action_note' => $action_note));
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
    }

    private function get_search_url()
    {
        $url    = RC_Uri::url('orders/merchant/init');
        $param  = [];
        $filter = $_GET;

        //订单类型 配送/自提/到店/团购
        if (!empty($filter['extension_code'])) {
            $param['extension_code'] = $filter['extension_code'];
        }
        //商家名称关键字
        if (!empty($filter['merchant_keywords'])) {
            $param['merchant_keywords'] = $filter['merchant_keywords'];
            $filter['show_search']      = 0;
        }
        //订单编号或购买者信息
        if (!empty($filter['keywords'])) {
            $param['keywords']     = $filter['keywords'];
            $filter['show_search'] = 0;
        }

        //显示高级搜索
        if (!empty($filter['show_search'])) {
            $param['show_search'] = $filter['show_search'];

            //订单编号关键字
            if (!empty($filter['order_sn'])) {
                $param['order_sn'] = trim($filter['order_sn']);
            }
            //开始时间
            if (!empty($filter['start_time'])) {
                $param['start_time'] = $filter['start_time'];
            }
            //结束时间
            if (!empty($filter['end_time'])) {
                $param['end_time'] = $filter['end_time'];
            }
            //配送方式
            if (!empty($filter['shipping_id'])) {
                $param['shipping_id'] = intval($filter['shipping_id']);
            }
            //支付方式
            if (!empty($filter['pay_id'])) {
                $param['pay_id'] = intval($filter['pay_id']);
            }
            //下单渠道
            if (!empty($filter['referer'])) {
                $param['referer'] = trim($filter['referer']);
            }
            //商品名称
            if (!empty($filter['goods_keywords'])) {
                $param['goods_keywords'] = trim($filter['goods_keywords']);
            }
            //购买人
            if (!empty($filter['consignee'])) {
                $param['consignee'] = trim($filter['consignee']);
            }
            //手机号
            if (!empty($filter['mobile'])) {
                $param['mobile'] = trim($filter['mobile']);
            }
        }
        if (!empty($param)) {
            $url = RC_Uri::url('orders/merchant/init', $param);
        }
        return array('url' => $url, 'param' => $param);
    }

    //获取团购活动保证金状态
    private function get_groupbuy_deposit_status($order = [], $groupbuy = [])
    {
        //团购活动保证金
        $formated_deposit = $groupbuy['formated_deposit'];

        //活动失败
        if ($groupbuy['status'] == GBS_FAIL && $groupbuy['is_finished'] == GBS_FAIL) {
            //已付款
            if ($order['pay_status'] == PS_PAYED) {
                $total_amount     = $order['surplus'] + $order['money_paid'];
                $total_amount     = ecjia_price_format($total_amount);
                $formated_deposit .= sprintf(__('（需退款：%s）', 'orders'), $total_amount);
            }

            //进行中
        } elseif ($groupbuy['status'] == GBS_UNDER_WAY) {
            $formated_deposit .= __('（等待团购活动结束）', 'orders');

            //活动成功
        } elseif ($groupbuy['status'] == GBS_SUCCEED && $groupbuy['is_finished'] == GBS_SUCCEED) {

            //活动失败完成
        } elseif ($groupbuy['status'] == GBS_FAIL && $groupbuy['is_finished'] == GBS_FAIL_COMPLETE) {

            $refund_id = RC_DB::table('refund_order')->where('store_id', $_SESSION['store_id'])->where('order_sn', $order['order_sn'])->value('refund_id');

            RC_Loader::load_app_class('RefundOrderInfo', 'refund', false);
            $refund_info = RefundOrderInfo::get_refund_order_info($refund_id);

            if ($refund_info['refund_status'] == 1) {
                $refund_total_amount = price_format($refund_info['money_paid'] + $refund_info['surplus']);

                $formated_deposit .= sprintf(__('（需退款：%s）', 'orders'), $refund_total_amount);
            }

            //活动成功完成
        } elseif ($groupbuy['status'] == GBS_SUCCEED && $groupbuy['is_finished'] == GBS_SUCCEED_COMPLETE) {
            if ($order['pay_status'] == PS_UNPAYED) {
                $formated_deposit .= sprintf(__('（需支付尾款：%s）', 'orders'), $order['order_amount']);
            }
        }

        return $formated_deposit;
    }

}

// end
