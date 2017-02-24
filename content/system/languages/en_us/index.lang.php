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

return array(
	'shop_guide'	=> 'Shop guide',
	'set_navigator'	=> 'Set navigator',
	'about'			=>'About ECJIA',
	'preview'		=>'Preview',
	'menu'			=>'Menu',
	'help'			=>'Help',
	'signout'		=>'Quit',
	'profile'		=>'Profile',
	'view_message'	=>'Admin Message',
	'send_msg'		=>'Send Message',
	'toggle_calculator'	=>'Calculator',
	'expand_all'		=>'Spread',
	'collapse_all'		=>'Shut',
	'no_help'			=>'Temporarily still have no those part of contents.',
	'license_free'		=> 'Non-authorized users',
	'license_commercial'=> 'Green card users',
	'license_invalid'	=> 'Unauthorized users',
	'license_failed'	=> 'Unauthorized users',
	'license_oem'		=> 'Authorized business users',
	'license_oemtest'	=> 'User experience',
		
	'license_Q'	=> 'Business',
	'license_G'	=> 'Business',
	'license_L'	=> 'Provisional',
	'license_S'	=> 'Business',
	'license_O'	=> 'Enterprise',
	'license_T'	=> 'Experience',
	'license_no'	=> 'Free',
	'license_test'	=> 'Free',
		
	//JS语言
	'js_languages' => array(
		'expand_all'	=>'Spread',
		'collapse_all'	=>'Shut',
		'shop_name_not_null'	=> 'Goods name can not null',
		'good_name_not_null'	=> 'Goods title can not null',
		'good_category_not_null'=> 'Goods category can not null',
		'good_number_not_number'=> 'Goods number is not number',
		'good_price_not_number'	=> 'Goods price is not number',
	),

	
	/*------------------------------------------------------ */
	//-- Calculator
	/*------------------------------------------------------ */
	
	'calculator'		=>'Calculator',
	'clear_calculator'	=>'Clearance',
	'backspace'			=>'Back a space',
	
	/*------------------------------------------------------ */
	//-- Start page
	/*------------------------------------------------------ */
	'pm_title'		=>'Title',
	'pm_username'	=>'Username',
	'pm_time'		=>'Time',
	
	'order_stat'	=>'Orders Statistics Information',
	'unconfirmed'	=>'Unconfirmed orders:',
	'await_ship'	=>'Not shipping orders:',
	'await_pay'		=>'Unpaid orders:',
	'finished'		=>'Finished orders:',
	'new_booking'	=>'Booking [New]:',
	'new_reimburse'	=>'Refund application:',
	'shipped_part'	=> 'Parts delivery order:',
	
	'goods_stat'		=>'Products Statistics Information',
	'virtual_card_stat'	=> 'Virtual Card Statistics Information',
	'goods_count'		=>'Products quantity:',
	'sales_count'		=>'Promotion products:',
	'new_goods'			=>'New products:',
	'recommed_goods'	=>'Best products:',
	'hot_goods'			=>'Hot products:',
	'warn_goods'		=>'Stock warning quantity:',
	'clear_cache'		=>'Clear cache',
	'ebao_commend'		=> 'Epro Recommend',
	
	'acess_stat'	=>'Visit Statistics',
	'acess_today'	=>'Visit today:',
	'online_users'	=>'Online:',
	'user_count'	=>'Member amount:',
	'today_register'=>'Register today:',
	'new_feedback'	=>'Latest message:',
	'new_comments'	=>'Latest comments:',
	
	'system_info'	=>'System Information',
	'os'			=>'Server operate system:',
	'web_server'	=>'Web server:',
	'php_version'	=>'PHP version:',
	'mysql_version'	=>'MySQL version:',
	'gd_version'	=>'GD version:',
	'zlib'			=>'Zlib support:',
	'ecs_version'	=>'ECShop version:',
	'install_date'	=>'Install date:',
	'ip_version'	=>'IP database version:',
	'max_filesize'	=>'Limit size of upload file:',
	'safe_mode'		=>'Safe mode:',
	'safe_mode_gid'	=>'Safe mode GID:',
	'timezone'		=> 'Timezone:',
	'no_timezone'	=> 'n/a',
	'socket'		=> 'Socket enabled:',
	'ec_charset'	=> 'Coding:',
	
	'remove_install'			=>'You haven\'t yet delete the install directory, we suggest you delete the install file for the system safety.',
	'remove_upgrade'			=>'You haven\'t yet delete the upgrade directory, we suggest you delete the upgrade file for the system safety.',
	'remove_demo'				=>'You haven\'t yet delete the demo directory, we suggest you delete the demo file for the system safety.',
	'temp_dir_cannt_read'		=> 'Your server has set open_base_dir without %s, the file will can\'t be uploaded.',
	'not_writable'				=> '%s directory can\'t be wrote in，%s',
	'data_cannt_write'			=> 'You will not update packing, card, brand picture and so on.',
	'afficheimg_cannt_write'	=> 'You will not update the AD picture.',
	'brandlogo_cannt_write'		=> 'You will not update the brand picyure.',
	'cardimg_cannt_write'		=> 'You will not update the card picture.',
	'feedbackimg_cannt_write'	=> 'User will not update file by comment.',
	'packimg_cannt_write'		=> 'You will not update the packing picture.',
	'cert_cannt_write'			=> 'You will not update the ICP certificate file.',
	'images_cannt_write'		=> 'You will not update any product picture.',
	'imagesupload_cannt_write'	=> 'You will not update any picture by editor.',
	'tpl_cannt_write'			=> 'Your website will not be browsed.',
	'tpl_backup_cannt_write'	=> 'Your will not backup the current template file.',
	'order_print_canntwrite'	=> 'Attribute of order_print.html can\'t be wrote in the date directory, you will not modify order print template.',
	'shop_closed_tips'			=> 'Your shop has closed temporarily. Please open your shop after the system has be installed!',
	'empty_upload_tmp_dir'		=> 'The current update temporary directory is blank, you may not update file, please check the config in php.ini.',
	'caches_cleared'			=> 'The page cache has be cleared successfully.',
	
	/*------------------------------------------------------ */
	//-- About us
	/*------------------------------------------------------ */
	'team_member'			=>'ECJIA team member',
	'before_team_member'	=> 'ECJIA Contributor',
	
	'director'		=>'Director',
	'programmer'	=>'Programmer',
	'ui_designer'	=>'Designer',
	'documentation'	=>'Document',
	'special_thanks'=>'Specially thankful',
	'official_site'	=>'Official website',
	'site_url'		=>'Website:',
	'support_center'=>'Support center:',
	'support_forum'	=>'Technical support:',
	// 邮件群发
	'mailsend_fail'		=> 'Send e-mail %s failed!',
	'mailsend_ok'		=> 'Send e-mail %s success! There are %s message was not sent!',
	'mailsend_finished'	=> 'Send e-mail %s success! All e-mail to complete!',
	'mailsend_null'		=> 'E-mail list empty!',
	'mailsend_skip'		=> 'Continue to send the next...',
	'email_sending'		=> 'Are dealing with e-mail queue...',
	'pause'				=> 'Suspended',
	'conti'				=> 'Continue',
	'str'				=> 'Has been sent% d messages.',
		
	//开店向导
	'shop_name'		=> 'Shop name',
	'shop_title'	=> 'Shop title',
	'shop_country'	=> 'Shop country',
	'shop_province'	=> 'Shop province',
	'shop_city'		=> 'Shop city',
	'shop_address'	=> 'Shop address',
	'shop_ship'		=> 'Shop shipping',
	'ship_name'		=> 'Shipping name',
	'ship_country'	=> 'Shipping country',
	'ship_province'	=> 'Shipping province',
	'ship_city'		=> 'Shipping city',
	'ship_district'	=> 'Shipping district',
	'shop_pay'		=> 'Shop payment',
	'select_please'	=> 'Select please',
	'good_name'		=> 'Goods name',
	'good_number'	=> 'Goods number',
	'good_category'	=> 'Goods category',
	'good_brand'	=> 'Goods brand',
	'good_price'	=> 'Goods price',
	'good_brief'	=> 'Goods brief',
	'good_image'	=> 'Good image',
	'is_new'		=> 'New',
	'is_best'		=> 'Best',
	'is_hot'		=> 'Hot',
	'good_intro'	=> 'Goods introduction',
	'skip'			=> 'Done',
	'next_step'		=> 'Next step',
	'ur_add'		=> 'Guide-Add goods',
	'ur_config'		=> 'Guide-Shop config',
	'shop_basic_first'	=> "Shops set up some basic information<em>Store names, addresses, distribution, methods of payment, etc.</em>",
	'shop_basic_second'	=> "Add some goods to stores<em>Commodity name, number, classification, brand, price, description, etc.</em>",
	'shop_basic_third'	=> "Congratulations to you, your shop can use！<em>Below are some common features links polymerization. You close this page, in the left-hand menu can still find related items</em>",
	'add_good'			=> 'Add good',
	'add_category'		=> 'Add category',
	'add_type'			=> 'Good type',
	'add_favourable'	=> 'Add favourable',
	'shop_config'		=> 'Shop config',
	'select_template'	=> 'Select template',
	'shop_back_in'		=> 'Enter the site background',
	'goods_img_too_big'	=>'Product picture file is too big(the biggest value: %s), can\'t upload.',
	'invalid_goods_img'	=>'Product picture format inaccuracy!',
		
	/*后台语言项*/
	'send_mail_off'	=> 'Turn off automatically send e-mail',
);

//end