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

RC_Loader::load_app_class('touch', 'touch', false);

RC_Loader::load_theme('extras/controller/touch_controller.php');
RC_Hook::add_action('touch/index/init', array('touch_controller', 'init'));
RC_Hook::add_action('touch/index/ajax_goods', array('touch_controller', 'ajax_goods'));
RC_Hook::add_action('touch/index/ajax_suggest_store', array('touch_controller', 'ajax_suggest_store'));
RC_Hook::add_action('touch/index/search', array('touch_controller', 'search'));
RC_Hook::add_action('touch/index/del_search', array('touch_controller', 'del_search'));

//定位
RC_Loader::load_theme('extras/controller/location_controller.php');
RC_Hook::add_action('location/index/select_location', array('location_controller', 'select_location'));
RC_Hook::add_action('location/index/search_list', 	  array('location_controller', 'search_list'));
RC_Hook::add_action('location/index/select_city', 	  array('location_controller', 'select_city'));
RC_Hook::add_action('location/index/get_location_msg',array('location_controller', 'get_location_msg'));

//商品
RC_Loader::load_theme('extras/controller/goods_controller.php');
RC_Hook::add_action('goods/category/init', array('goods_controller', 'init'));
RC_Hook::add_action('goods/category/store_list', array('goods_controller', 'store_list'));//店铺分类列表
RC_Hook::add_action('goods/category/seller_list', array('goods_controller', 'seller_list'));//店铺分类列表
RC_Hook::add_action('goods/index/show', array('goods_controller', 'show'));//商品详情页
RC_Hook::add_action('goods/index/promotion', array('goods_controller', 'promotion'));
RC_Hook::add_action('goods/index/ajax_goods', array('goods_controller', 'ajax_goods'));
RC_Hook::add_action('goods/index/new', array('goods_controller', 'goods_new'));
RC_Hook::add_action('goods/index/ajax_goods_comment', array('goods_controller', 'ajax_goods_comment'));//获取商品评论

//店铺
RC_Loader::load_theme('extras/controller/merchant_controller.php');
RC_Hook::add_action('merchant/index/init', array('merchant_controller', 'init'));//店铺首页
RC_Hook::add_action('merchant/index/ajax_goods', array('merchant_controller', 'ajax_goods'));//获取店铺商品
RC_Hook::add_action('merchant/index/position', array('merchant_controller', 'position'));//店铺位置
RC_Hook::add_action('merchant/index/ajax_store_comment', array('merchant_controller', 'ajax_store_comment'));//获取店铺评论

//文章
RC_Loader::load_theme('extras/controller/article_controller.php');
RC_Hook::add_action('article/help/init', array('article_controller', 'init'));
RC_Hook::add_action('article/help/detail', array('article_controller', 'detail'));
RC_Hook::add_action('article/shop/detail', array('article_controller', 'shop_detail'));

RC_Hook::add_action('article/index/init', array('article_controller', 'article_index'));	//发现首页
RC_Hook::add_action('article/index/detail', array('article_controller', 'article_detail'));	//发现文章详情
RC_Hook::add_action('article/index/ajax_article_list', array('article_controller', 'ajax_article_list'));//获取分类下的文章
RC_Hook::add_action('article/index/add_comment', array('article_controller', 'add_comment'));//获取分类下的文章
RC_Hook::add_action('article/index/ajax_comment_list', array('article_controller', 'ajax_comment_list'));//获取文章评论列表
RC_Hook::add_action('article/index/like_article', array('article_controller', 'like_article'));//文章点赞/取消点赞

//购物车
RC_Loader::load_theme('extras/controller/cart_controller.php');
RC_Hook::add_action('cart/index/init', array('cart_controller', 'init'));
RC_Hook::add_action('cart/index/update_cart', array('cart_controller', 'update_cart'));//更新购物车中商品
RC_Hook::add_action('cart/index/check_spec', array('cart_controller', 'check_spec'));//检查购物车中商品规格
RC_Hook::add_action('cart/flow/checkout', array('cart_controller', 'checkout'));
RC_Hook::add_action('cart/flow/pay', array('cart_controller', 'pay'));
RC_Hook::add_action('cart/flow/shipping', array('cart_controller', 'shipping'));
RC_Hook::add_action('cart/flow/shipping_date', array('cart_controller', 'shipping_date'));
RC_Hook::add_action('cart/flow/invoice', array('cart_controller', 'invoice'));
RC_Hook::add_action('cart/flow/bonus', array('cart_controller', 'bonus'));
RC_Hook::add_action('cart/flow/integral', array('cart_controller', 'integral'));
RC_Hook::add_action('cart/flow/note', array('cart_controller', 'note'));
RC_Hook::add_action('cart/flow/goods_list', array('cart_controller', 'goods_list'));
RC_Hook::add_action('cart/flow/done', array('cart_controller', 'done'));

//支付
RC_Loader::load_theme('extras/controller/pay_controller.php');
RC_Hook::add_action('pay/index/init', array('pay_controller', 'init'));
RC_Hook::add_action('pay/index/notify', array('pay_controller', 'notify'));

//会员
RC_Loader::load_theme('extras/controller/user_controller.php');
RC_Hook::add_action('touch/my/init', array('user_controller', 'init'));
RC_Hook::add_action('user/index/spread', array('user_controller', 'spread'));
RC_Hook::add_action('user/index/wxconfig', array('user_controller', 'wxconfig'));

//商家入驻申请
RC_Loader::load_theme('extras/controller/franchisee_controller.php');
RC_Hook::add_action('franchisee/index/first', array('franchisee_controller', 'first'));//入驻申请加载页面
RC_Hook::add_action('franchisee/index/first_check', array('franchisee_controller', 'first_check'));//入驻申请第一步验证
RC_Hook::add_action('franchisee/index/validate', array('franchisee_controller', 'validate'));//入驻验证码
RC_Hook::add_action('franchisee/index/second', array('franchisee_controller', 'second'));//入驻申请第二步
RC_Hook::add_action('franchisee/index/finish', array('franchisee_controller', 'finish'));//处理入驻申请

RC_Hook::add_action('franchisee/index/search', array('franchisee_controller', 'search'));//处理入驻申请
RC_Hook::add_action('franchisee/index/process', array('franchisee_controller', 'process'));//查询进度
RC_Hook::add_action('franchisee/index/process_search', array('franchisee_controller', 'process_search'));//查询进度处理

RC_Hook::add_action('franchisee/index/location', array('franchisee_controller', 'get_location'));//获取店铺精确位置
RC_Hook::add_action('franchisee/index/location_finish', array('franchisee_controller', 'location_finish'));//提交店铺精确位置
RC_Hook::add_action('franchisee/index/get_region', array('franchisee_controller', 'get_region'));//提交店铺精确位置

//登录注册
RC_Loader::load_theme('extras/controller/user_privilege_controller.php');
RC_Hook::add_action('user/privilege/login', array('user_privilege_controller', 'login'));
RC_Hook::add_action('user/privilege/signin', array('user_privilege_controller', 'signin'));
RC_Hook::add_action('user/privilege/signup', array('user_privilege_controller', 'signup'));
RC_Hook::add_action('user/privilege/register', array('user_privilege_controller', 'register'));
RC_Hook::add_action('user/privilege/validate_code', array('user_privilege_controller', 'validate_code'));
RC_Hook::add_action('user/privilege/set_password', array('user_privilege_controller', 'set_password'));
RC_Hook::add_action('user/privilege/logout', array('user_privilege_controller', 'logout'));

//找回密码
RC_Loader::load_theme('extras/controller/user_get_password_controller.php');
RC_Hook::add_action('user/get_password/mobile_register', array('user_get_password_controller', 'mobile_register'));
RC_Hook::add_action('user/get_password/mobile_register_account', array('user_get_password_controller', 'mobile_register_account'));
RC_Hook::add_action('user/get_password/reset_password', array('user_get_password_controller', 'reset_password'));

RC_Loader::load_theme('extras/controller/user_account_controller.php');
RC_Hook::add_action('user/account/init', array('user_account_controller', 'init'));//我的钱包
RC_Hook::add_action('user/account/recharge', array('user_account_controller', 'recharge'));
RC_Hook::add_action('user/account/recharge_account', array('user_account_controller', 'recharge_account'));
RC_Hook::add_action('user/account/withdraw', array('user_account_controller', 'withdraw'));
RC_Hook::add_action('user/account/withdraw_account', array('user_account_controller', 'withdraw_account'));
RC_Hook::add_action('user/account/balance', array('user_account_controller', 'balance'));//余额
RC_Hook::add_action('user/account/record', array('user_account_controller', 'record'));
RC_Hook::add_action('user/account/ajax_record', array('user_account_controller', 'ajax_record'));
RC_Hook::add_action('user/account/ajax_record_raply', array('user_account_controller', 'ajax_record_raply'));
RC_Hook::add_action('user/account/ajax_record_deposit', array('user_account_controller', 'ajax_record_deposit'));
RC_Hook::add_action('user/account/record_info', array('user_account_controller', 'record_info'));
RC_Hook::add_action('user/account/record_cancel', array('user_account_controller', 'record_cancel'));

//用户收货地址
RC_Loader::load_theme('extras/controller/user_address_controller.php');
RC_Hook::add_action('user/address/address_list', array('user_address_controller', 'address_list'));
RC_Hook::add_action('user/address/add_address', array('user_address_controller', 'add_address'));
RC_Hook::add_action('user/address/insert_address', array('user_address_controller', 'insert_address'));
RC_Hook::add_action('user/address/edit_address', array('user_address_controller', 'edit_address'));
RC_Hook::add_action('user/address/update_address', array('user_address_controller', 'update_address'));
RC_Hook::add_action('user/address/del_address', array('user_address_controller', 'del_address'));
RC_Hook::add_action('user/address/save_temp_data', array('user_address_controller', 'save_temp_data'));
RC_Hook::add_action('user/address/near_location', array('user_address_controller', 'near_location'));
RC_Hook::add_action('user/address/set_default', array('user_address_controller', 'set_default'));
RC_Hook::add_action('user/address/choose_address', array('user_address_controller', 'choose_address'));

//用户红包
RC_Loader::load_theme('extras/controller/user_bonus_controller.php');
RC_Hook::add_action('user/bonus/init', array('user_bonus_controller', 'init'));
RC_Hook::add_action('user/bonus/async_allow_use', array('user_bonus_controller', 'async_allow_use'));
RC_Hook::add_action('user/bonus/async_is_used', array('user_bonus_controller', 'async_is_used'));
RC_Hook::add_action('user/bonus/async_expired', array('user_bonus_controller', 'async_expired'));
RC_Hook::add_action('user/bonus/my_reward', array('user_bonus_controller', 'my_reward'));
RC_Hook::add_action('user/bonus/reward_detail', array('user_bonus_controller', 'reward_detail'));
RC_Hook::add_action('user/bonus/get_integral', array('user_bonus_controller', 'get_integral'));
RC_Hook::add_action('user/bonus/async_reward_detail', array('user_bonus_controller', 'async_reward_detail'));

//订单
RC_Loader::load_theme('extras/controller/user_order_controller.php');
RC_Hook::add_action('user/order/order_list', array('user_order_controller', 'order_list'));
RC_Hook::add_action('user/order/order_cancel', array('user_order_controller', 'order_cancel'));
RC_Hook::add_action('user/order/async_order_list', array('user_order_controller', 'async_order_list'));
RC_Hook::add_action('user/order/order_detail', array('user_order_controller', 'order_detail'));
RC_Hook::add_action('user/order/affirm_received', array('user_order_controller', 'affirm_received'));
RC_Hook::add_action('user/order/comment_list', array('user_order_controller', 'comment_list'));
RC_Hook::add_action('user/order/goods_comment', array('user_order_controller', 'goods_comment'));
RC_Hook::add_action('user/order/make_comment', array('user_order_controller', 'make_comment'));
RC_Hook::add_action('user/order/buy_again', array('user_order_controller', 'buy_again'));

//用户资料
RC_Loader::load_theme('extras/controller/user_profile_controller.php');
RC_Hook::add_action('user/profile/init', array('user_profile_controller', 'init'));
RC_Hook::add_action('user/profile/modify_username', array('user_profile_controller', 'modify_username'));
RC_Hook::add_action('user/profile/modify_username_account', array('user_profile_controller', 'modify_username_account'));
RC_Hook::add_action('user/profile/edit_password', array('user_profile_controller', 'edit_password'));
RC_Hook::add_action('user/profile/account_bind', array('user_profile_controller', 'account_bind'));
RC_Hook::add_action('user/profile/get_code', array('user_profile_controller', 'get_code'));
RC_Hook::add_action('user/profile/check_code', array('user_profile_controller', 'check_code'));
RC_Hook::add_action('user/profile/bind_info', array('user_profile_controller', 'bind_info'));

//授权登录
RC_Loader::load_theme('extras/controller/connect_controller.php');
RC_Hook::add_action('connect/index/dump_user_info', array('connect_controller', 'dump_user_info'));
RC_Hook::add_action('connect/index/bind_signup', array('connect_controller', 'bind_signup'));
RC_Hook::add_action('connect/index/bind_signup_do', array('connect_controller', 'bind_signup_do'));
RC_Hook::add_action('connect/index/bind_signin', array('connect_controller', 'bind_signin'));
RC_Hook::add_action('connect/index/bind_signin_do', array('connect_controller', 'bind_signin_do'));

RC_Loader::load_theme('extras/controller/mobile_controller.php');
RC_Hook::add_action('mobile/discover/init', array('mobile_controller', 'init'));//百宝箱

/**
 * step：3
 * 这里开始 注册“方法函数”自动加载列表 到Hook自动加载列表，为自动加载做准备
 */
RC_Hook::add_action('class_touch_function',     function () {RC_Loader::load_theme('extras/classes/utility/touch_function.class.php');});
RC_Hook::add_action('class_article_function',   function () {RC_Loader::load_theme('extras/classes/utility/article_function.class.php');});
RC_Hook::add_action('class_cart_function',      function () {RC_Loader::load_theme('extras/classes/utility/cart_function.class.php');});
RC_Hook::add_action('class_goods_function',     function () {RC_Loader::load_theme('extras/classes/utility/goods_function.class.php');});
RC_Hook::add_action('class_orders_function',    function () {RC_Loader::load_theme('extras/classes/utility/orders_function.class.php');});
RC_Hook::add_action('class_user_function',      function () {RC_Loader::load_theme('extras/classes/utility/user_function.class.php');});
RC_Hook::add_action('class_merchant_function', 	function () {RC_Loader::load_theme('extras/classes/utility/merchant_function.class.php');});

RC_Hook::add_action('class_user_front',      function () {RC_Loader::load_theme('extras/classes/user/user_front.class.php');});

/**
 * step:5
 * 这个方法在前台控制器加载后执行，这个时候环境初始化完毕，这里开始正式进入主题框架的流程
 */
RC_Hook::add_action('ecjia_front_finish_launching', function ($arg) {
    
    $key = ecjia::config('map_qq_key');
    $referer = ecjia::config('map_qq_referer');
    ecjia_front::$controller->assign('key', $key);
    ecjia_front::$controller->assign('referer', $referer);
    //判断并微信登录
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($user_agent, 'MicroMessenger') !== false && ecjia_plugin::is_active('sns_wechat/sns_wechat.php')) {
        //微信浏览器
        if (ROUTE_M != 'connect') {
            if (!ecjia_touch_user::singleton()->isSignin()) {
                if ($_REQUEST['referer_url']) {
                    RC_Cookie::set('referer', $_REQUEST['referer_url']);
                }
                $url = RC_Uri::url('connect/index/init', array('connect_code' => 'sns_wechat', 'login_type' => 'snsapi_userinfo'));
                ecjia_front::$controller->redirect($url);
            }
        }
    }

    if (ROUTE_M == 'user') {
        new user_front();
    }

    ecjia_front::$controller->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
});


/**
 * 第三方登录回调提示模板
 */
RC_Hook::add_filter('connect_callback_user_template', function($templateStr, $data) {
    RC_Loader::load_theme('extras/controller/connect_controller.php');
    return connect_controller::callback_template($data);
}, 10, 2);
    
/**
 * 第三方登录用户注册
 */
RC_Hook::add_filter('connect_callback_user_bind_signup', function($userid, $username, $password, $email) {
    $result = connect_controller::bind_signup(array('name' => $username, 'password' => $password, 'email' => $email));
    if (is_ecjia_error($result)) {
        RC_Logger::getlogger('wechat')->info('connect_callback_bind_signup-error');
        return ecjia_front::$controller->showmessage($result->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    } else {
        return $result;
    }
}, 10, 4);

/**
 * 第三方登录用户登录
 */
RC_Hook::add_action('connect_callback_user_signin', function($connect_user) {
    RC_Loader::load_app_func('admin_user', 'user');
    $userid = $connect_user->getUserId();
    $user_info = EM_user_info($userid);
    if (empty($user_info)) {
        return ecjia_front::$controller->showmessage('关联用户不存在，请联系管理员', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    }
    
    RC_Loader::load_app_class('integrate', 'user', false);
    $user = integrate::init_users();
    $user->set_session($user_info['name']);
    $user->set_cookie($user_info['name']);
    $res = array(
        'session' => array(
            'sid' => RC_Session::session_id(),
            'uid' => $_SESSION['user_id']
        ),
    
        'user' => $user_info
    );
    ecjia_touch_user::singleton()->setUserinfo($res);
     
    update_user_info(); // 更新用户信息
    
    /*获取远程用户头像信息*/
    user_controller::sync_avatar($connect_user);
    
    // 重新计算购物车中的商品价格
    RC_Loader::load_app_func('cart','cart');
    recalculate_price(); 
    
    //结合cookie判断返回来源url
    $back_url = RC_Cookie::get('referer', RC_Uri::url('touch/index/init'));

    RC_Logger::getlogger('wechat')->info('connect_callback_user_signin-info');
    RC_Logger::getlogger('wechat')->info($back_url);
    
    return ecjia_front::$controller->redirect($back_url);
});

/**
 * 用户绑定完成后的结果判断处理，用于界面显示
 * @param $result boolean 判断对错
 */
RC_Hook::add_action('connect_callback_user_bind_complete', function($result) {
    if (is_ajax() && !is_pjax()) {
        if ($result) {
            $link[] = array(RC_Lang::get('connect::connect.back_member'), 'href' => RC_Uri::url('touch/my/init'));
            return ecjia_front::$controller->showmessage(RC_Lang::get('connect::connect.bind_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link));
        } else {
            $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
            return ecjia_front::$controller->showmessage(RC_Lang::get('connect::connect.bind_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
        }
    } else {
        if ($result) {
            return ecjia_front::$controller->redirect(RC_Uri::url('touch/my/init'));
        } else {
            $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
            return ecjia_front::$controller->showmessage(RC_Lang::get('connect::connect.bind_fail'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
        }
    }
});

/**
 * 判断是否安装微信登录
 */
RC_Hook::add_action('connect_code_before_launching', function($connect_code) {
    if ($connect_code == 'sns_wechat' && !ecjia_plugin::is_active('sns_wechat/sns_wechat.php')) {
        echo '请先购买并安装微信登录插件<br><a href="https://ecjia.com/daojia_authorize.html" target="_blank">购买链接</a>';
        exit();
    }
});

RC_Hook::add_action('connect_sns_wechat_handle', function($connect_handle) {
    $login_type = royalcms('request')->query('login_type');
    
    if ($login_type) {
        $connect_handle->set_login_type($login_type);
    }
});


/**
 * ecjiaopen协议 
 **/
ecjia_open::macro('goods_seller_list', function($querys) {
    return RC_Uri::url('goods/category/store_list', array('cid' => $querys['category_id']));
});
ecjia_open::macro('goods_list', function($querys) {
    return RC_Uri::url('goods/category/init', array('cid' => $querys['category_id']));
});
ecjia_open::macro('goods_detail', function($querys) {
	return RC_Uri::url('goods/index/show', array('goods_id' => $querys['goods_id']));
});
ecjia_open::macro('seller', function($querys) {
	return RC_Uri::url('goods/category/seller_list', array('cid' => $querys['category_id']));
});
ecjia_open::macro('user_bonus', function($querys) {
    return RC_Uri::url('user/bonus/init', array('type' => $querys['type']));
});
ecjia_open::macro('user_address', function() {
	return RC_Uri::url('user/address/address_list');
});
ecjia_open::macro('help', function() {
	return RC_Uri::url('article/help/init');
});

/**
 * 支付响应提示模板
 */
RC_Hook::add_filter('payment_respond_template', function($respond, $msg){
    return pay_controller::notify($msg);
}, 10, 2);

/**
 * 自定义站点API地址
 * @param string $url
 * @return string
 */
function custom_site_api_url($url) {
    return RC_Config::get('site.site_api', $url);
}
RC_Hook::add_filter('custom_site_api_url', 'custom_site_api_url');

/**
 * 修改Http请求超时时间
 */
RC_Hook::add_filter('http_request_timeout', function($time) {
	return 20;
});
