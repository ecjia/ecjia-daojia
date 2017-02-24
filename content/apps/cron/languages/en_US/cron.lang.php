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

/**
 * ECJIA 计划任务程序语言包
 */
return array(
	'cron' 				=> 'Cron Jobs',
	'cron_name' 		=> 'Name planned mission',
	'cron_code' 		=> 'The program mission',
	'if_open' 			=> 'Open',
	'version' 			=> 'Version',
	'cron_desc' 		=> 'Plan task description',
	'cron_author' 		=> 'Plug-Author',
	'cron_time' 		=> 'Mission plan execution time',
	'cron_next' 		=> 'The next execution time',
	'cron_this' 		=> 'Last execution time',
	'cron_allow_ip' 	=> 'Permit the implementation of the server ip',
	'cron_run_once' 	=> 'Turn off after the implementation of',
		
	'cron_alow_files' 	=> 'Permit the implementation of the page',
	'notice_alow_files' => 'Front trigger is scheduled to run pages, blank pages that were triggered in all',
	'notice_alow_ip' 	=> 'Mission plans to permit the server to run IP, please use comma to separate multiple IP',
	'notice_minute' 	=> 'Use commas to separate multiple minutes',
	'cron_do' 			=> 'Perform',
	'do_ok' 			=> 'Execution succeed',
	'cron_month' 		=> 'Monthly',
	'cron_day' 			=> 'Date',
	'cron_week' 		=> 'Weekly',
	'cron_thatday' 		=> 'Day',
	'cron_hour' 		=> 'Hours',
	'cron_minute' 		=> 'Minutes',
	'cron_unlimit' 		=> 'Daily',
	'cron_advance' 		=> 'Advanced Options',
	'cron_show_advance' => 'Show advanced options',
	'install_ok' 		=> 'Installed successfully',
	'edit_ok' 			=> 'Edited successfully',
	
	'week' => array(
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday',
		7 => 'Sunday',
	),
	
	'minute' => array(
		'custom'  => 'Custom',
		'five'    => 'Every 5 minutes',
		'ten' 	  => 'Every 10 minutes',
		'fifteen' => 'Every 15 minutes',
		'twenty'  => 'Every 20 minutes',
		'thirty'  => 'Every 30 minutes',
	),
	
	'uninstall_ok' 			=> 'Uninstall successful',
	'cron_not_available' 	=> 'Mission of the plan does not exist or is not installed',
	'back_list' 			=> 'Plans to return a list of mission',
	'name_is_null' 			=> 'You do not have plans to enter the name of mission!',
	
	'js_languages' 	=> array(
		'lang_removeconfirm' => 'Are you sure you want to uninstall the program mission?',
	),
	
	'enable' 	=> 'Enable',
	'disable' 	=> 'Disable',
	
	'page' => array(
		'index' 		=> 'Home',
		'user'	 		=> 'User Center',
		'pick_out' 		=> 'Shopping center',
		'flow' 			=> 'Shopping Cart',
		'group_buy' 	=> 'Buy merchandise',
		'snatch' 		=> 'Indiana Jones',
		'tag_cloud' 	=> 'Tag cloud',
		'category' 		=> 'Merchandise list page',
		'goods' 		=> 'Merchandise page',
		'article_cat' 	=> 'Article list page',
		'article' 		=> 'Article page',
		'brand' 		=> 'Brand Area',
		'search'	 	=> 'Search results pages',
	),
	
	'cron_disabled'		=> 'Planning tasks have been disabled',
	'cron_enable'		=> 'Planning tasks are enabled',
	'edit_cron'			=> 'Edit Planning Task',
	'edit_fail'			=> 'Editor failed',
	'do_fail'			=> 'Execution failed',
	'no_page_allowed'	=> 'Did not find the page allows execution',
	'disabled_confirm'	=> 'Are you sure you want to disable the program task?',
	'enable_confirm'	=> 'Are you sure you want to enable the planned task?',
	'do_confirm'		=> 'Are you sure you want to implement the plan task?',
	
	'label_cron_name'		=> 'Planning task name:',
	'label_cron_desc'		=> 'Planning task description:',
	'label_cron_time'		=> 'Planning task execution time:',
	'label_cron_minute'		=> 'Minute:',
	'label_cron_run_once'	=> 'Execute after shutdown:',
	'label_cron_advance'	=> 'Advanced options:',
	'label_cron_allow_ip'	=> 'Allow the execution of the server IP:',
	'label_cron_advance'	=> 'Advanced options:',
	
	'cron_manage'		=> 'Cron Manage',
	'cron_update'		=> 'Cron Update',
	'plugin_name_empty'	=> 'Planning task plugin name cannot be empty',
	'plugin_exist'		=> 'Installed plugins already exist',

	'js_lang' => array(
		'ok'		=> 'OK',
		'cancel'	=> 'Cancel',
	)
);

// end