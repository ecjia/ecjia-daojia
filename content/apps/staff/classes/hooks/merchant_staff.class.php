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

class merchant_staff_hooks
{
    //店铺信息
    public static function merchant_dashboard_information()
    {
        $merchant_info = RC_Api::api('store', 'store_info', array('store_id' => $_SESSION['store_id']));

        //判断店铺是否在营业中
        $shop_trade_time = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_trade_time')->value('value');
		$shop_close = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->value('shop_close');
        RC_Loader::load_app_func('merchant', 'merchant');
        $shop_closed = get_shop_close($shop_close, $shop_trade_time);
        $merchant_info['shop_closed'] = $shop_closed;
        
        
        $merchant_info['shop_time_value'] = get_store_trade_time($_SESSION['store_id']);

        $merchant_info['shop_logo'] = !empty($merchant_info['shop_logo']) ? RC_Upload::upload_url($merchant_info['shop_logo']) : '';
        $merchant_info['identity_type'] = intval($merchant_info['identity_type']);

        ecjia_merchant::$controller->assign('merchant_info', $merchant_info);

        echo ecjia_merchant::$controller->fetch(
            RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_information.lbi', true)
        );
    }

    public static function merchant_order_list()
    {
        $statics_url = ecjia_merchant::$controller->get_main_static_url();

        $list = array(
            array('title' => '当日订单', 'url' => RC_Uri::url('orders/merchant/today_order'), 'img' => $statics_url.'img/merchant_dashboard/today_order.png'),
            array('title' => '核销订单', 'url' => RC_Uri::url('orders/mh_validate_order/init'), 'img' => $statics_url.'img/merchant_dashboard/mh_validate_order.png'),
            array('title' => '配送订单', 'url' => RC_Uri::url('orders/merchant/init'), 'img' => $statics_url.'img/merchant_dashboard/order.png'),
            array('title' => '到店订单', 'url' => RC_Uri::url('orders/merchant/init', array('extension_code' => 'storebuy')), 'img' => $statics_url.'img/merchant_dashboard/storebuy_order.png'),
            array('title' => '自提订单', 'url' => RC_Uri::url('orders/merchant/init', array('extension_code' => 'storepickup')), 'img' => $statics_url.'img/merchant_dashboard/storepickup_order.png'),
            array('title' => '团购订单', 'url' => RC_Uri::url('orders/merchant/init', array('extension_code' => 'group_buy')), 'img' => $statics_url.'img/merchant_dashboard/group_buy_order.png'),
            array('title' => '收银台订单', 'url' => RC_Uri::url('orders/merchant/init', array('extension_code' => 'cashdesk')), 'img' => $statics_url.'img/merchant_dashboard/cashdesk_order.png'),
            array('title' => '售后订单', 'url' => RC_Uri::url('refund/merchant/init'), 'img' => $statics_url.'img/merchant_dashboard/refund_order.png'),
        );

        ecjia_merchant::$controller->assign('list', $list);
        echo ecjia_merchant::$controller->fetch(
            RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_order_list.lbi', true)
        );
    }

    //个人信息
    public static function merchant_dashboard_right_4_1()
    {
        $user_info = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
        $user_info['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $user_info['add_time']);
        $user_info['last_login'] = RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);

        ecjia_merchant::$controller->assign('user_info', $user_info);
        echo ecjia_merchant::$controller->fetch(
            RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_profile.lbi', true)
        );
    }

    //联系平台
    public static function merchant_dashboard_right_4_2()
    {
        echo ecjia_merchant::$controller->fetch(
            RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_contact.lbi', true)
        );
    }

    //商家公告
    public static function merchant_dashboard_right_4_3()
    {
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
        echo ecjia_merchant::$controller->fetch(
            RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_notice.lbi', true)
        );
    }
    
    //商城消息
    public static function merchant_dashboard_right_4_4()
    {
    	$list = RC_DB::table('notifications')
    		->where('notifiable_id', $_SESSION['staff_id'])
    		->whereNull('read_at')
    		->orderBy('created_at', 'desc')
    		->take(5)->get();
		if (!empty($list)) {
			foreach ($list as $k => $v) {
				if (!empty($v['data'])) {
					$content = json_decode($v['data'], true);
					$list[$k]['content'] = $content['body'];
				}
			}
		}
    	ecjia_merchant::$controller->assign('list', $list);

        return ecjia_merchant::$controller->fetch(
    		RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_shopmsg.lbi', true)
    	);
    }

    //操作日志
    public static function merchant_dashboard_right_4_5()
    {
        if (!ecjia_merchant::$controller->admin_priv('staff_log_manage', ecjia::MSGTYPE_HTML, false)) {
            return false;
        }
        $key = 'staff_log' . $_SESSION['store_id'];
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
        ecjia_merchant::$controller->assign('log_lists', $data);

        echo ecjia_merchant::$controller->fetch(
            RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_loglist.lbi', true)
        );
    }
    
    //快捷入口
    public static function merchant_dashboard_right_4_6()
    {
        $statics_url = ecjia_merchant::$controller->get_main_static_url();
    	$list = array(
    		array('title' => '商品列表', 'url' => RC_Uri::url('goods/merchant/init'), 'img' => $statics_url.'img/merchant_dashboard/goods_list.png'),
    		array('title' => '验单查询', 'url' => RC_Uri::url('orders/mh_validate_order/init'), 'img' => $statics_url.'img/merchant_dashboard/validate_order.png'),
    		array('title' => '优惠买单', 'url' => RC_Uri::url('quickpay/merchant/init'), 'img' => $statics_url.'img/merchant_dashboard/quickpay.png'),
            array('title' => '收款二维码', 'url' => RC_Uri::url('quickpay/mh_qrcode/init'), 'img' => $statics_url.'img/merchant_dashboard/qrcode.png'),
            array('title' => '推广二维码', 'url' => RC_Uri::url('quickpay/mh_qrcode/init'), 'img' => $statics_url.'img/merchant_dashboard/qrcode.png'),
    		array('title' => '添加员工', 'url' => RC_Uri::url('staff/merchant/add', array('step' => 1)), 'img' => $statics_url.'img/merchant_dashboard/add_staff.png'),
    		array('title' => '订单分成', 'url' => RC_Uri::url('commission/merchant/record'), 'img' => $statics_url.'img/merchant_dashboard/order_commission.png'),
    		array('title' => '运费设置', 'url' => RC_Uri::url('shipping/mh_shipping/shipping_template'), 'img' => $statics_url.'img/merchant_dashboard/ship_set.png'),
    		array('title' => '小票机设置', 'url' => RC_Uri::url('printer/mh_print/init'), 'img' => $statics_url.'img/merchant_dashboard/printer.png'),
    		array('title' => '公众平台', 'url' => RC_Uri::url('platform/merchant/init'), 'img' => $statics_url.'img/merchant_dashboard/platform.png'),
    		array('title' => '小程序模板', 'url' => RC_Uri::url('merchant/merchant/template'), 'img' => $statics_url.'img/merchant_dashboard/weapp.png'),
    	);
        ecjia_merchant::$controller->assign('list', $list);
    	echo ecjia_merchant::$controller->fetch(
    		RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_fastenter.lbi', true)
    	);
    }

    public static function set_admin_login_logo()
    {
        $logo_img = ecjia::config('merchant_admin_login_logo') ? RC_Upload::upload_url() . '/' . ecjia::config('merchant_admin_login_logo') : ecjia_merchant::$controller->get_main_static_url() . '/img/seller_admin_logo.png';
        if ($logo_img) {
            $logo = '<img width="230" height="50" src="' . $logo_img . '" />';
        }
        return $logo;
    }

    public static function display_merchant_privilege_menus()
    {
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

                    echo '<a class="data-pjax" href="' . $group->link . '">' . $group->name . '</a></li>' . PHP_EOL;
                }
            }
            echo '</ul>' . PHP_EOL;
        }
    }
}

RC_Hook::add_action('merchant_dashboard_top', array('merchant_staff_hooks', 'merchant_dashboard_information'));

RC_Hook::add_action('merchant_dashboard_top', array('merchant_staff_hooks', 'merchant_order_list'));

RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_1'), 1);
RC_Hook::add_filter('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_2'), 2);
RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_3'), 3);
RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_4'), 4);
RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_5'), 5);
RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_6'), 6);

RC_Hook::add_action('ecjia_admin_logo_display', array('merchant_staff_hooks', 'set_admin_login_logo'));

RC_Hook::add_action('display_merchant_privilege_menus', array('merchant_staff_hooks', 'display_merchant_privilege_menus'));

// end
