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
RC_Loader::load_theme('extras/classes/ecjia_extra.class.php');

/**
 * 自动加载类管理
 */
ecjia_extra::autoload();

/**
 * 加载路由
 */
ecjia_extra::routeDispacth();

/**
 * 加载主题选项设置面板
 */
ecjia_extra::loadThemeFrameworkOptions();

/**
 * step:5
 * 这个方法在前台控制器加载后执行，这个时候环境初始化完毕，这里开始正式进入主题框架的流程
 */
RC_Hook::add_action('ecjia_front_finish_launching', function () {

    $key = ecjia::config('map_qq_key');
    $referer = ecjia::config('map_qq_referer');
    ecjia_front::$controller->assign('key', $key);
    ecjia_front::$controller->assign('referer', $referer);
    
    $wap_logo = ecjia::config('wap_logo');
    if (!empty($wap_logo)) {
    	setcookie("wap_logo", RC_Upload::upload_url($wap_logo), time() + 1800);
    }
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($user_agent, 'MicroMessenger') || strpos($user_agent, 'CriOS')) {
    	ecjia_front::$controller->assign('is_weixin', true);
    }
    
    //判断并微信登录
    if (strpos($user_agent, 'MicroMessenger') !== false && ecjia_plugin::is_active('sns_wechat/sns_wechat.php')) {
        //微信浏览器
        if (ROUTE_M != 'connect') {
            if (!ecjia_touch_user::singleton()->isSignin() && !RC_Cookie::get('wechat_not_login', 0)) {
                // if ($_REQUEST['referer_url']) {
                //     RC_Cookie::set('referer', $_REQUEST['referer_url']);
                // } else {
                    RC_Cookie::set('referer', empty($_SERVER['HTTP_REFERER']) ? RC_Uri::current_url() : $_SERVER['HTTP_REFERER']);
                // }
                
                $url = RC_Uri::url('connect/index/init', array('connect_code' => 'sns_wechat', 'login_type' => 'snsapi_userinfo'));
                ecjia_front::$controller->redirect($url);
            }
        }
    }

    if (ROUTE_M == 'user') {
        new user_front();
    }
    
    if (!RC_Agent::isPhone()) {
        $qrcode = with(new Ecjia\App\Mobile\UrlTempQrcode())->getQrcodeBase64();
        ecjia_front::$controller->assign('ecjia_qrcode_image', $qrcode);
    }

    $integral_name = !empty(ecjia::config('integral_name')) ? ecjia::config('integral_name') : '积分';
    ecjia_front::$controller->assign('integral_name', $integral_name);

    ecjia_front::$controller->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
});


/**
 * 第三方登录回调提示模板
 */
RC_Hook::add_filter('connect_callback_user_template', function($templateStr, $data) {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //判断并微信登录
    if (strpos($user_agent, 'MicroMessenger') !== false && ecjia_plugin::is_active('sns_wechat/sns_wechat.php')) {
        $wechat_auto_register = royalcms('request')->cookie('wechat_auto_register', 0);
        if ($wechat_auto_register) {
            RC_Cookie::delete('wechat_auto_register');

            RC_Loader::load_theme('extras/controller/connect_controller.php');
            return connect_controller::callback_template($data);
        
        } else {

            RC_Cookie::set('wechat_not_login', 1);
            //结合cookie判断返回来源url
            $back_url = RC_Cookie::get('referer', RC_Uri::url('touch/index/init'));
            return ecjia_front::$controller->redirect($back_url);
        }
    } else {

        RC_Loader::load_theme('extras/controller/connect_controller.php');
        return connect_controller::callback_template($data);
        
    }
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

    if (is_ecjia_error($user_info)) {
    	return ecjia_front::$controller->showmessage($user_info->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    }
    
    ecjia_integrate::setSession($user_info['name']);
    ecjia_integrate::setCookie($user_info['name']);

    //这里需要请求connect/signin更新token
//    $res = array(
//        'session' => array(
//            'sid' => RC_Session::session_id(),
//            'uid' => $_SESSION['user_id']
//        ),
//        'user' => $user_info
//    );
//    ecjia_touch_user::singleton()->setUserinfo($res);

    ecjia_touch_user::singleton()->connectSignin($connect_user->getOpenId(), $connect_user->getConnectCode());
     
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
    
    RC_Cookie::delete('wechat_not_login');
    if ($back_url == RC_Uri::url('touch/index/cache_set')) {
    	$back_url = RC_Uri::url('touch/my/init');
    } 
    
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
        echo '请先购买并安装微信登录插件<br><a href="https://daojia.ecjia.com/opensource.html" target="_blank">购买链接</a>';
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
//首页
ecjia_open::macro('main', function($querys) {
	return RC_Uri::url('touch/index/init');
});
//我的订单
ecjia_open::macro('orders_list', function($querys) {
	return RC_Uri::url('user/order/order_list');
});
//订单详情
ecjia_open::macro('orders_detail', function($querys) {
	return RC_Uri::url('user/order/order_detail', array('order_id' => $querys['order_id']));
});
//收货地址
ecjia_open::macro('user_address', function() {
	return RC_Uri::url('user/address/address_list');
});
//帮助中心
ecjia_open::macro('help', function() {
	return RC_Uri::url('article/help/init');
});
//用户中心
ecjia_open::macro('user_center', function() {
	return RC_Uri::url('user/profile/init');
});
//商品详情
ecjia_open::macro('goods_detail', function($querys) {
	return RC_Uri::url('goods/index/show', array('goods_id' => $querys['goods_id']));
});
//商品评论
ecjia_open::macro('goods_comment', function($querys) {
	return RC_Uri::url('goods/index/show', array('goods_id' => $querys['goods_id']));
});
//发现
ecjia_open::macro('discover', function($querys) {
	return RC_Uri::url('article/index/init');
});
//钱包
ecjia_open::macro('user_wallet', function($querys) {
	return RC_Uri::url('user/account/init');
});
//购物车
ecjia_open::macro('cart', function($querys) {
	return RC_Uri::url('cart/index/init');
});
//我的余额
ecjia_open::macro('user_account', function($querys) {
	return RC_Uri::url('user/account/balance');
});
//注册
ecjia_open::macro('sign_up', function($querys) {
	return RC_Uri::url('user/privilege/register');
});
//找回密码
ecjia_open::macro('forget_password', function($querys) {
	return RC_Uri::url('user/get_password/init');
});
//修改密码
ecjia_open::macro('user_password', function($querys) {
	return RC_Uri::url('user/profile/edit_password');
});
//促销商品/新品
ecjia_open::macro('goods_suggest', function($querys) {
	if ($querys['type'] == 'promotion') {
		return RC_Uri::url('goods/index/promotion');
	} elseif ($querys['type'] == 'new') {
		return RC_Uri::url('goods/index/new');
	}
});
//店铺分类列表
ecjia_open::macro('goods_seller_list', function($querys) {
	return RC_Uri::url('goods/category/store_list', array('cid' => $querys['category_id']));
});
//所有分类
ecjia_open::macro('goods_list', function($querys) {
    return RC_Uri::url('goods/category/init', array('category_id' => $querys['category_id']));
});
//店铺列表
ecjia_open::macro('seller', function($querys) {
	if (!empty($querys['category_id'])) {
		return RC_Uri::url('merchant/category/list', array('cid' => $querys['category_id']));
	} else {
		return RC_Uri::url('merchant/category/list');
	}
});
//我的红包
ecjia_open::macro('user_bonus', function($querys) {
    return RC_Uri::url('user/bonus/init', array('type' => $querys['type']));
});
//店铺优惠买单
ecjia_open::macro('quickpay', function($querys) {
	return RC_Uri::url('user/quickpay/init', array('store_id' => $querys['merchant_id']));
});
//收款二维码
ecjia_open::macro('collectmoney', function($querys) {
	return RC_Uri::url('merchant/quickpay/collectmoney', array('store_id' => $querys['merchant_id']));
});
//历史记录
ecjia_open::macro('history', function($querys) {
	return RC_Uri::url('touch/index/search');
});
//店铺首页
ecjia_open::macro('merchant', function($querys) {
    return RC_Uri::url('merchant/index/init', array('store_id' => $querys['merchant_id']));
});

/**
 * 支付响应提示模板
 */
RC_Hook::add_filter('payment_respond_template', function($callback) {
    return function ($respond, $msg, $info) {
        return payment_controller::notify($msg);
    };
});

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

