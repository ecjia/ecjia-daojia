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
 * ECJIA 管理中心优惠活动语言文件
 */
return array(
	/* menu */
	'favourable_list' 			=> 'Favourable List',
	'add_favourable' 			=> 'Add Favourable Activity',
	'edit_favourable' 			=> 'Edit Favourable Activity',
	'favourable_log' 			=> 'Offer bid record',
	'continue_add_favourable' 	=> 'Continue to add favourable activity',
	'back_favourable_list' 		=> 'Return to favourable list',
	'add_favourable_ok' 		=> 'Add favourable activity success',
	'edit_favourable_ok' 		=> 'Edit favourable activity success',
	
	/* list */
	'act_is_going' 			=> 'Show only the ongoing activities',
	'act_name' 				=> 'Name',
	'goods_name' 			=> 'Trade names',
	'start_time' 			=> 'Start time',
	'end_time' 				=> 'End time',
	'min_amount' 			=> 'The amount of the minimum',
	'max_amount' 			=> 'The upper limit',
	'favourable_not_exist' 	=> 'You want to operate the concession does not exist Events',
	
	'batch_drop_ok' 		=> 'Bulk delete successful',
	'no_record_selected' 	=> 'Record no choice',
	
	/* info */
	'label_act_name' 		=> 'Events offers name:',
	'label_start_time' 		=> 'Offer Start Time:',
	'label_end_time' 		=> 'Offers End time:',
	'label_user_rank' 		=> 'To enjoy the favourable treatment of members rating:',
	'not_user'	 			=> 'Non-Member',
	'label_act_range' 		=> 'Offer range:',
	'far_all' 				=> 'All goods',
	'far_category' 			=> 'The following classification',
	'far_brand' 			=> 'The following brands',
	'far_goods' 			=> 'The following merchandise',
	'label_search_and_add' 	=> 'Search and add the scope of concessions',
	
	'label_min_amount' 		=> 'The amount of the minimum:',
	'label_max_amount' 		=> 'The upper limit:',
	'notice_max_amount' 	=> '0 that there is no upper limit',
	'label_act_type' 		=> 'Discount method:',
	'notice_act_type' 		=> 'When the concession for the "enjoyment of gifts (for ex-gratia goods)", please enter the permit buyers to choose gift (ex-gratia goods) the maximum quantity, quantity to 0 express an unlimited number,' .
	        					'When the concession for the "enjoyment of cash for relief", enter the amount of cash relief,' .
	        					'When the concession for the "enjoyment of price discounts", please enter the discount (1-99), such as: playing 9 packs, on the input 90.',
	'fat_goods' 			=> 'Enjoy the gift (for ex-gratia goods)',
	'fat_price'	 			=> 'Enjoy cash relief',
	'fat_discount' 			=> 'Enjoy the price discounts',
	
	'search_result_empty' 		=> 'Record not found a corresponding, re-search',
	'label_search_and_add_gift' => 'Search and add gifts (goods ex-gratia)',
	
	'js_lang' => array(
		'batch_drop_confirm' 		=> 'Are you sure you want to delete the selected concession activities?',
		'all_need_not_search' 		=> 'Offers range of merchandise are all, do not need this operation',
		'range_exists' 				=> 'This option has been in existence for',
		'pls_search' 				=> 'Please search for corresponding data',
		'price_need_not_search' 	=> 'Concessions is to enjoy price discounts do not need this operation',
		'gift' 						=> 'Gifts (goods ex-gratia)',
		'price' 					=> 'Price',
		'act_name_not_null' 		=> 'Please enter the name of concessions Events',
		'min_amount_not_number' 	=> 'The minimum amount is not formatted correctly (figure)',
		'max_amount_not_number' 	=> 'Limit on the amount of incorrect format (digital)',
		'act_type_ext_not_number' 	=> 'Favourable way behind the incorrect value (figure)',
		'amount_invalid' 			=> 'The upper limit is less than the minimum amount.',
		'start_lt_end' 				=> 'Offers start time should not exceed the end of time',
	),
	
	/* post */
	'pls_set_user_rank' => 'Please set to enjoy the favourable treatment of members of hierarchical',
	'pls_set_act_range' => 'Please set up the scope of concessions',
	'amount_error' 		=> 'The amount of the minimum amount should not exceed the upper limit',
	'act_name_exists' 	=> 'Activity name of the discount already exists, please change one',
	'nolimit' 			=> 'There is no limit',

	'favourable_way_is'		=> 'Favourable way is ',
	'remove_success'		=> 'Delete success',
	'edit_name_success'		=> 'Update favourable activity name success',
	'pls_enter_name'		=> 'Please enter activity keywords',
	'pls_enter_merchant_name'	=> 'Please enter merchant name',
	'sort_edit_ok'			=> 'Sort operation success',
	'farourable_time'		=> 'Favourable activity time:',
	'to'					=> 'to',
	'pls_start_time'		=> 'Please choose the event start time',
	'pls_end_time'			=> 'Please choose the event end time',
	'update'				=> 'Update',
	'keywords'				=> 'Enter keywords for search',
	'enter_keywords'		=> 'Enter special items to search for',
	'favourable_way'		=> 'Favourable activity mode',
	'batch_operation'		=> 'Batch Operations',
	'no_favourable_select' 	=> 'Please select the favourable activity to delete!',
	'remove_favourable'		=> 'Delete favourable activity',
	'search'				=> 'Search',
	'edit_act_name'			=> 'Edit Name',
	'edit_act_sort'			=> 'Edit Sort',
	'remove_confirm'		=> 'Are you sure you want to delete the favourable activity?',
	'sort'					=> 'Sort',
	'non_member'			=> 'Non-members',
	'act_range'				=> 'Offer range',
	
	'favourable'			=> 'Favourable Activity',
	'favourable_manage'		=> 'Favourable Activity Management',
	'favourable_add'		=> 'Add Favourable Activity',
	'favourable_update'		=> 'Edit Favourable Activity',
	'favourable_delete'		=> 'Remove Favourable Activity',
	
	'start_lt_end' 			=> 'Offers start time should not exceed the end of time',
	'all_need_not_search' 	=> 'Offers range of merchandise are all, do not need this operation',
	'gift' 					=> 'Gifts (goods ex-gratia)',
	'price' 				=> 'Price',
	'batch_drop_confirm' 	=> 'Are you sure you want to delete the selected concession activities?',
	'all'					=> 'All',
	'on_going'				=> 'On going',
	'merchants'				=> 'Merchants',
	'merchant_name'			=> 'Merchant name',
	
	'overview'         		=> 'Overview',
	'more_info'        		=> 'More information:',
	
	'favourable_list_help'	=> 'Welcome to ECJia intelligent background to the list page of favourable activities, the system will display all the favourable activities in this list.',
	'about_favourable_list'	=> 'About favourable activities list to help document',
	
	'add_favourable_help'	=> 'Welcome to ECJia intelligent background to add favourable activities page, this page can be added to the operation of favourable activities.',
	'about_add_favourable'	=> 'About add favourable activities to help document',
	
	'edit_favourable_help'	=> 'Welcome to ECJia intelligent background to add favourable activities page, the page can be edited for the operation of favourable activities.',
	'about_edit_favourable'	=> 'About edit favourable activities to help document',
);

//end