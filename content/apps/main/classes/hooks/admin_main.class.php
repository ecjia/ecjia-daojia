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

class admin_main_hooks {
    
    
    public static function admin_dashboard_right_2() 
    {
	    $title = __('产品地址');

	    $index_url 	   = RC_Uri::home_url();
	    $h5_url 	   = RC_Uri::home_url().'/sites/m/';
	    $api_url       = RC_Uri::home_url().'/sites/api/';
	    $app_url       = RC_Uri::home_url().'/sites/app/';
	    $platform_url  = RC_Uri::home_url().'/sites/platform/';
	    $merchant_url  = RC_Uri::home_url().'/sites/merchant/'; 
	    $admin_url     = RC_Uri::home_url().'/sites/admincp/';
	    
	    $help_urls = array(
	    	'ECJia到家首页'       => $index_url,
	        'ECJia到家H5端'       => $h5_url,
	        'ECJia到家平台后台'    => $admin_url,
	        'ECJia到家商家后台'    => $merchant_url,
	        'ECJia到家API地址'    => $api_url,
	        'ECJia到家APP下载地址' => $app_url,
	        'ECJia到家公众平台地址' => $platform_url,
	        'ECJia到家帮助文档地址' => 'https://ecjia.com/wiki/帮助:ECJia到家',
	    );
	    
	    ecjia_admin::$controller->assign('title',      $title);
	    ecjia_admin::$controller->assign('help_urls',  $help_urls);
	    
	    ecjia_admin::$controller->display(RC_Package::package('app::main')->loadTemplate('admin/library/widget_admin_dashboard_product_help.lbi', true));
	}

	public static function set_daojia_admin_cpname($name) 
	{
	    return 'ECJia Daojia <span class="sml_t">' . RC_Config::get('release.version') . '</span>';
	}
	
	public static function set_daojia_admin_welcome()
	{
	    if (1) {
	        $ecjia_version = RC_Config::get('release.version');
	        $ecjia_release = RC_Config::get('release.build');
	        $ecjia_welcome_logo = RC_Uri::admin_url('statics/images/ecjiawelcom.png');
	        $ecjia_about_url = RC_Uri::url('@index/about_us');
	        $welcomeecjia 	= __('欢迎使用ECJia到家');
	        $description 	= __("EC+（ecjia）到家是由上海商创网络科技有限公司推出的，一款可开展O2O业务的移动电商系统。
	            它包含：移动端APP，采用原生模式开发，覆盖使用iOS 及Android系统的移动终端；后台系统，针对平台日常运营维护
	            的平台后台，针对入驻店铺管理的商家后台，独立并行；移动端H5，能够灵活部署于微信及其他APP、网页等。
	            ECJia到家是一款符合当下及未来发展的新电商系统，主打三个新：新模式，新框架，新技术。");
	        $more 			= __('了解更多 »');
	        $welcome = <<<WELCOME
		  <div>
			<a class="close m_r10" data-dismiss="alert">×</a>
			<div class="hero-unit">
				<div class="row-fluid">
					<div class="span3">
						<img src="{$ecjia_welcome_logo}" />
					</div>
					<div class="span9">
						<h1>{$welcomeecjia} {$ecjia_version} <span style="font-size:16px">（{$ecjia_release}）</span></h1>
						<p>{$description}</p>
						<a class="btn btn-info" href="{$ecjia_about_url}" target="_self">{$more}</a>
					</div>
				</div>
			</div>
		</div>
WELCOME;
	        echo $welcome;
	    }
	}
	
	public static function set_daojia_admin_about_welcome()
	{
	    $ecjia_version = RC_Config::get('release.version');
	    $ecjia_release = RC_Config::get('release.build');
	    $ecjia_welcome_logo = RC_Uri::admin_url('statics/images/ecjiawelcom.png');
	    $welcome_ecjia 	= __('欢迎使用ECJia到家');
	    $description = __('EC+（ecjia）到家是由上海商创网路科技有限公司推出的，一款可开展O2O业务的移动电商系统。
	            它包含：移动端APP，采用原生模式开发，覆盖使用iOS 及Android系统的移动终端；后台系统，针对平台日常运营维护
	            的平台后台，针对入驻店铺管理的商家后台，独立并行；移动端H5，能够灵活部署于微信及其他APP、网页等。
	            ECJia到家是一款符合当下及未来发展的新电商系统，主打三个新：新模式，新框架，新技术。');
	    $more = __('进入官网 »');
	    $ecjia_url = 'https://ecjia.com/daojia.html';
	    
	    $welcome = <<<WELCOME
        <div class="hero-unit">
			<div class="row-fluid">
				<div class="span9">
					<h1>{$welcome_ecjia} {$ecjia_version} <span style="font-size:16px">（{$ecjia_release}）</span></h1>
					<p>{$description}</p>
					<p><a class="btn btn-info" href="{$ecjia_url}" target="_bank">{$more}</a></p>
				</div>
				<div class="span3">
					<div><img src="{$ecjia_welcome_logo}" /></div>
				</div>
			</div>
		</div>
WELCOME;
	    echo $welcome;
	}
	
	
	public static function remove_admin_about_welcome()
	{
	    RC_Hook::remove_action( 'admin_about_welcome', array('ecjia_admin', 'display_admin_about_welcome') );
	}
	
	public static function set_daojia_version($version)
	{
	    return RC_Config::get('release.version', $version);
	}
}

RC_Hook::add_action( 'admin_dashboard_right', array('admin_main_hooks', 'admin_dashboard_right_2') );
RC_Hook::add_filter( 'ecjia_admin_cpname', array('admin_main_hooks', 'set_daojia_admin_cpname') );
RC_Hook::add_filter( 'ecjia_build_version', array('admin_main_hooks', 'set_daojia_version') );
RC_Hook::remove_action( 'admin_dashboard_top', array('ecjia_admin', 'display_admin_welcome'), 9 );
RC_Hook::add_action( 'admin_dashboard_top', array('admin_main_hooks', 'set_daojia_admin_welcome') );
RC_Hook::add_action( 'admin_print_main_header', array('admin_main_hooks', 'remove_admin_about_welcome') );
RC_Hook::add_action( 'admin_about_welcome', array('admin_main_hooks', 'set_daojia_admin_about_welcome'), 11 );

// end