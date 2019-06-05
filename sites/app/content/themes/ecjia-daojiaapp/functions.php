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

RC_Locale::loadThemeTextdomain('ecjia-daojiaapp');

RC_Hook::add_action('intro/index/init', function () {
	
    //判断是否手机访问，如果手机访问，自动跳到H5页面
    if (RC_Agent::isPhone()) {
        return ecjia_front::$controller->redirect(RC_Uri::home_url() . '/sites/m/');
    }
    
    $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
    
    if (!ecjia_front::$controller->is_cached('index.dwt', $cache_id)) {
        //首页url
        $main_url = RC_Uri::home_url();
        $main_url = str_replace('sites/app/', '', $main_url);
        ecjia_front::$controller->assign('main_url', $main_url);
         
        //商家列表url
        $main_goods_url = RC_Uri::url('merchant/store/category');
        $main_goods_url = str_replace('sites/app/', '', $main_goods_url);
        ecjia_front::$controller->assign('main_goods_url', $main_goods_url);
         
        //商家入驻url
        $merchant_url     = RC_Uri::url('franchisee/merchant/init');
        $merchant_url     = str_replace('sites/app/index.php', 'sites/merchant/index.php', $merchant_url);
        ecjia_front::$controller->assign('merchant_url', $merchant_url);
        	
        //商家登录url
        $merchant_login   = RC_Uri::url('staff/privilege/login');
        $merchant_login   = str_replace('sites/app/index.php', 'sites/merchant/index.php', $merchant_login);
        ecjia_front::$controller->assign('merchant_login', $merchant_login);
    
        // 应用预览图
        $mobile_app_preview_temp 	= ecjia::config('mobile_app_preview');
        $mobile_app_preview 		= unserialize($mobile_app_preview_temp);
        $mobile_app_preview1        = !empty($mobile_app_preview[0])? RC_Upload::upload_url().'/'.$mobile_app_preview[0] : '';
        $mobile_app_preview2        = !empty($mobile_app_preview[1])? RC_Upload::upload_url().'/'.$mobile_app_preview[1] : '';
        // 下载二维码
        $mobile_android_qrcode 		= ecjia::config('mobile_android_qrcode');
        $mobile_iphone_qrcode 		= ecjia::config('mobile_iphone_qrcode');
        $mobile_android_qrcode 		= !empty($mobile_android_qrcode)? RC_Upload::upload_url().'/'.$mobile_android_qrcode : '';
        $mobile_iphone_qrcode 		= !empty($mobile_iphone_qrcode)? RC_Upload::upload_url().'/'.$mobile_iphone_qrcode : '';
        $shop_logo 					= ecjia::config('shop_logo');
        $shop_wechat_qrcode 		= ecjia::config('shop_wechat_qrcode');
        $shop_logo 					= !empty($shop_logo)? RC_Upload::upload_url().'/'.$shop_logo : '';
        $shop_wechat_qrcode 		= !empty($shop_wechat_qrcode)? RC_Upload::upload_url().'/'.$shop_wechat_qrcode : '';
        $mobile_touch_qrcode    	= ecjia::config('mobile_touch_qrcode');
        $mobile_touch_qrcode        = !empty($mobile_touch_qrcode)? RC_Upload::upload_url($mobile_touch_qrcode) : '';

        $shop_info_html = (new Ecjia\App\Article\ShopInfoArticleList)->outputHtml();
    
        $screenshots = RC_DB::table('mobile_screenshots')->where('app_code', '=', 'cityo2o')->orderBy('sort','asc')->take(10)->get();
        foreach($screenshots as $key => $val){
            $screenshots[$key]['img_url'] = !empty($val['img_url'])? RC_Upload::upload_url($val['img_url']) : '';
            if (empty($val['img_url'])) unset($screenshots[$key]);
        }

        $data = array(
            'powered' => 'Powered&nbsp;by&nbsp;<a href="https:\/\/ecjia.com" target="_blank">ECJia</a>',
        );

        $data = RC_Hook::apply_filters('ecjia_general_info_filter', $data);
         
        ecjia_front::$controller->assign_title();
    
        ecjia_front::$controller->assign('screenshots',            $screenshots);
        ecjia_front::$controller->assign('shop_info_html', $shop_info_html);
        ecjia_front::$controller->assign('company_name',           ecjia::config('company_name'));
        ecjia_front::$controller->assign('service_phone',          ecjia::config('service_phone'));
        ecjia_front::$controller->assign('shop_address',           ecjia::config('shop_address'));
        ecjia_front::$controller->assign('mobile_app_name', 		ecjia::config('mobile_app_name'));
        ecjia_front::$controller->assign('mobile_app_version', 	ecjia::config('mobile_app_version'));
        ecjia_front::$controller->assign('mobile_app_description', ecjia::config('mobile_app_description'));
        ecjia_front::$controller->assign('mobile_app_video', 		ecjia::config('mobile_app_video'));
        ecjia_front::$controller->assign('shop_weibo_url', 		ecjia::config('shop_weibo_url'));
        ecjia_front::$controller->assign('mobile_app_video',       ecjia::config('mobile_app_video'));
         
        $stats_code = ecjia::config('stats_code');
        ecjia_front::$controller->assign('stats_code', 			stripslashes($stats_code));
        ecjia_front::$controller->assign('mobile_app_privew1', 	$mobile_app_preview1);
        ecjia_front::$controller->assign('mobile_app_privew2', 	$mobile_app_preview2);
        ecjia_front::$controller->assign('mobile_app_screenshots', ecjia::config('mobile_app_screenshots'));
        ecjia_front::$controller->assign('mobile_iphone_download', ecjia::config('mobile_iphone_download'));
        ecjia_front::$controller->assign('mobile_android_download',ecjia::config('mobile_android_download'));
        ecjia_front::$controller->assign('mobile_iphone_qrcode', 	$mobile_iphone_qrcode);
        ecjia_front::$controller->assign('mobile_android_qrcode', 	$mobile_android_qrcode);
        ecjia_front::$controller->assign('mobile_touch_url',       ecjia::config('mobile_touch_url'));
        ecjia_front::$controller->assign('touch_qrcode', 	        $mobile_touch_qrcode);
        ecjia_front::$controller->assign('shop_logo', 				$shop_logo);
        ecjia_front::$controller->assign('shop_wechat_qrcode', 	$shop_wechat_qrcode);
        ecjia_front::$controller->assign('commoninfo', 	        $data);
    }

    return ecjia_front::$controller->display('index.dwt', $cache_id);
    
});//首页