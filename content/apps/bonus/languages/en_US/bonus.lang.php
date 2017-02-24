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
 * ECJIA 红包类型/红包管理语言包
 */
return array(
	/* Bonus type feild information */
	'bonus_manage' 				=> 'Bonus Manage',
    'bonus_type' 	            => 'Bonus Type',
	'bonus_list' 				=> 'Bonus List',
	'type_name' 				=> 'Name',
	'merchants_name'			=> 'Merchant name',
	'type_money' 				=> 'Bonus money',
	'min_goods_amount' 			=> 'Minimum orders amount',
	'notice_min_goods_amount' 	=> 'Only the total amount of merchandise to achieve this the number of orders to use such red packets.',
	'min_amount' 				=> 'Min limit',
    'min_amount_lable' 			=> 'Min limit:',
	'max_amount' 				=> 'Max limit',
	'send_startdate' 			=> 'Start time',
	'send_enddate' 				=> 'Deadline',
	
	'use_startdate' 	=> 'Start time',
	'use_enddate' 		=> 'Deadline',
	'send_count'	 	=> 'Provide quantity',
	'use_count' 		=> 'Use quantity',
	'send_method' 		=> 'Provide method',
	'send_type' 		=> 'Type',
	'param' 			=> 'Parameter',
	'no_use' 			=> 'No used',
	'yuan' 				=> 'yuan',
	'user_list' 		=> 'Member list',
	'type_name_empty' 	=> 'Bonus type name can\'t be blank!',
	'type_money_empty' 	=> 'Bonus money can\'t be blank!',
	'min_amount_empty' 	=> 'Min limit of order of bonus type can\'t be blank!',
	'max_amount_empty' 	=> 'Max limit of order of bonus type can\'t be blank!',
	'send_count_empty' 	=> 'Quantity of bonus type can\'t be blank!',
	
	'send_by' => array(
		SEND_BY_USER 		=> 'By user',
		SEND_BY_GOODS 		=> 'By product',
		SEND_BY_ORDER 		=> 'By order money',
		SEND_BY_PRINT 		=> 'Offline',
		SEND_BY_REGISTER 	=> 'Register send bonus',
		SEND_COUPON			=> 'Coupon'
	),
	
	'report_form' 		=> 'Report',
	'send' 				=> 'Send',
	'bonus_excel_file' 	=> 'Offline bonus information list ',
	
	'goods_cat' 		=> 'Category',
	'goods_brand' 		=> 'Brand',
	'goods_key' 		=> 'Keywords',
	'all_goods' 		=> 'Optional product',
	'send_bouns_goods' 	=> 'Provide the type bonus product',
	'remove_bouns' 		=> 'Remove bonus',
	'all_remove_bouns' 	=> 'All remove',
	'goods_already_bouns' 	=> 'The product has provided for other type bonus!',
	'send_user_empty' 		=> 'You have no select member whom needs to issue bonus, please return!',
	'batch_drop_success' 	=> ' %d bonuses has be deleted.',
	'sendbonus_count' 	=> 'Total provide %d bonuses.',
	'send_bouns_error' 	=> 'Send out member bonus inaccurate, please try it again!',
	'no_select_bonus' 	=> 'You have no choice need to remove users bonus.',
	'bonustype_edit' 	=> 'Edit Bonus Type',
	'bonustype_view' 	=> 'View details',
	'drop_bonus' 		=> 'Delete',
	'send_bonus' 		=> 'Provide',
	'continus_add' 		=> 'Continue add bonus type',
	'back_list' 		=> 'Return to bonus type list',
	'bonustype_list' 	=> 'Bonus Type List',
	'continue_add' 		=> 'Continue to add bonus.',
	'back_bonus_list' 	=> 'Return to bonus list',
	'validated_email' 	=> 'Only to authenticated users through the mail issuance of red packets.',
	
	/* Prompting message */
	'add_success'			=> 'Add success',
	'edit_success'			=> 'Edit success',
	'attradd_succed' 		=> 'Operation successfully!',
	'del_bonustype_succed' 	=> 'Delete bonus type success',
	
	'js_languages' => array(
		'type_name_empty' 		=> 'Please enter bonus type name!',
		'type_money_empty' 		=> 'Please enter bonus type price!',
		'order_money_empty' 	=> 'Please enter order money!',
		'type_money_isnumber' 	=> 'Type money must be number format!',
		'order_money_isnumber' 	=> 'Order money must be number format!',
		'bonus_sn_empty' 		=> 'Please enter bonus NO.!',
		'bonus_sn_number' 		=> 'Bonus\'s NO. must be a figure!',
		'bonus_sum_empty' 		=> 'Please enter bonus quantity you want to provide!',
		'bonus_sum_number' 		=> 'Provide bonus quantity must be an integer!',
		'bonus_type_empty'	 	=> 'Please select bonus type money!',
		'user_rank_empty' 		=> 'Please appoint member rank!',
		'user_name_empty' 		=> 'Please select a member at least!',
		'invalid_min_amount' 	=> 'Please enter a minimum level of orders (the figure is greater than 0)',
		'send_start_lt_end' 	=> 'bonus release date can not be greater than the beginning date of the end',
		'use_start_lt_end'	 	=> 'bonus use date can not be greater than the beginning date of the end',
	),
	
	'send_count_error' 		=> 'The provide bonus quantiyt must be an integer!',
	'order_money_notic' 	=> 'As long as the amount of the value of orders will be issued red packets to the user',
	'type_money_notic' 		=> 'The type bonus can offset money',
	'send_startdate_notic' 	=> 'The type bonus can be provided only current time between start time and deadline.',
	'use_startdate_notic' 	=> 'Only the current time between the start date and the time between the closing date, this type of red packets can only be used.',
	'type_name_exist' 		=> 'The type name already exists.',
	'type_money_error' 		=> 'The money must be a figure and can\'t less than 0!',
	'bonus_sn_notic' 		=> 'TIP: Bonus NO. is composed of 6 bits serial number seed and 4 bits stochastic numbers.',
	'creat_bonus' 			=> 'Created',
	'creat_bonus_num' 		=> 'Bonus NO.',
	'bonus_sn_error' 		=> 'Bonus NO. must be a figure!',
	'send_user_notice' 		=> 'Please enter username when you provide bonus for user , many usres were divided by (,) <br /> such as:liry, wjz, zwj',
	
	/* Bonus information field */
	'bonus_id' 			=> 'ID',
	'bonus_type_id' 	=> 'Type money:',
	'send_bonus_count' 	=> 'Bonus quantity:',
	'start_bonus_sn' 	=> 'Start NO.',
	'bonus_sn' 			=> 'Bonus NO.',
	'user_id' 			=> 'User',
	'used_time' 		=> 'Time',
	'order_id' 			=> 'Order NO.',
	'send_mail' 		=> 'Send mail',
	'emailed' 			=> 'Email notice',
	
	'mail_status' => array(
		BONUS_NOT_MAIL 					=> 'Not send',
		BONUS_INSERT_MAILLIST_FAIL 		=> 'Insert maillist has failed.',		//追加
		BONUS_INSERT_MAILLIST_SUCCEED 	=> 'Insert maillist has successfully.',	//追加
		BONUS_MAIL_FAIL 				=> 'Send mail has failed.',
		BONUS_MAIL_SUCCEED 				=> 'Send mail has successfully.',
	),
	
	'sendtouser' 			=> 'Provide bonus for appointed user',
	'senduserrank' 			=> 'Provide bonus by user rank ',
	'userrank' 				=> 'User rank',
	'select_rank' 			=> 'All users...',
	'keywords'				=> 'Keywords: ',
	'userlist' 				=> 'User list: ',
	'send_to_user' 			=> 'Disseminate the red envelope to the following users',		
	'search_users' 			=> 'Search user',
	'confirm_send_bonus' 	=> 'Submit',
	'bonus_not_exist' 		=> 'The bonus is nonexistent.',
	'success_send_mail' 	=> 'Send %d mails successfully.',
	'send_continue' 		=> 'Continue to send bonus.',
	
	//追加
	'send_startdate_lable' 	=> 'Payment start date:',
	'send_enddate_lable' 	=> 'Payment end date:',
	'use_startdate_lable' 	=> 'Use start date:',
	'use_enddate_lable' 	=> 'Use end date:',
	'min_amount_lable' 		=> 'Min limit:',
	'send_method_lable' 	=> 'Provide method:',
	'min_goods_amount_lable'=> 'Minimum orders amount:',
	'usage_type_label'		=> 'Usee type:',
	'type_money_lable' 		=> 'Bonus money:',
	'type_name_lable' 		=> 'Name:',
	'add_bonus_type'		=> 'Add Bonus type',
	'send_type_is'			=> 'Send Type is ',
	'bonustype_name_is'		=> 'Bonus type name is ',
	'send_rank_is'			=> 'Send rank is ',
	'send_target_is'		=> 'Send target is ',
	'batch_operation'		=> 'Batch Operations',
	'remove_confirm'		=> 'Are you sure you want to do this?',
	'pls_choose_remove'		=> 'Please select the bonus to delete',
	'pls_choose_send'		=> 'Please select the bonus to insert the message',
	'insert_maillist'		=> 'Insert message to send queue',
	'remove_bonus_confirm'	=> 'Are you sure you want to delete the bonus?',
	'search_goods_help'		=> 'To search for issuing this type of product display in red area on the left, click on the left side of the list option, you can enter the right side of the product distributed red zone. You can also issued a red envelope of merchandise in the right edit.',
	'filter_goods_info'		=> 'Filter to product information',
	'no_content'			=> 'No content yet',
	'user_rank'				=> 'User rank:',
	'enter_user_keywords'	=> 'Please enter a user name',
	'search_user_help'		=> 'Search to distribute this type of bonus to show the user in the left area, click the left list of options, the user can enter the right side of the issue of red envelopes. You can also edit the user on the right side of the editor.',
	'no_info'				=> 'No information.',
	'filter_user_info'		=> 'Screen search user information',
	'update'				=> 'Update',
	'all_send_type'			=> 'All types of send',
	'filter'				=> 'Filter',
	'edit_bonus_type_name'	=> 'Edit bonus Type Name',
	'view_bonus'			=> 'View bonus',
	'general_audience'		=> 'General audience',
	'remove_bonustype_confirm'	=> 'Are you sure you want to remove the bonus type?',
	'gen_excel'					=> 'Export report',
	'edit_bonus_money'			=> 'Edit bonus amount',
	'edit_order_limit'			=> 'Edit order amount limit',
	
	'bonus_type_manage'		=> 'Bonus Type Manage',
	'bonus_type_add'		=> 'Add Bonus Type',
	'bonus_type_update'		=> 'Edit Bonus Type',
	'bonus_type_delete'		=> 'Delete Bonus Type',
	'invalid_parameter'		=> 'Invalid parameter',
	'send_coupon_repeat'	=> 'You have already received the coupon!',
	'list_bonus_type'		=> 'Bonus type',
	
	'bonus_type_help'		=> 'Welcome to ECJia intelligent background bonus type list page, the system will display all of the bonus type in this list.',
	'about_bonus_type'		=> 'About bonus type list help document',
	'add_bonus_help'		=> 'Welcome to ECJia intelligent background add bonus type page, on this page you can add a bonus type of operation.',
	'about_add_bonus'		=> 'About add bonus type of help document',
	'edit_bonus_help'		=> 'Welcome to ECJia intelligent background edit bonus type page, this page can be edited bonus type of operation.',
	'about_edit_bonus'		=> 'About edit bonus type of help document',
	
	'send_by_user_help'		=> 'Welcome to ECJia intelligent background send bonus by user page, on this page the user can operate send bonus.',
	'about_send_by_user'	=> 'About send bonus by user help document',
	
	'send_by_goods_help'	=> 'Welcome to ECJia intelligent background send bonus by goods page, on this page the user can operate send bonus.',
	'about_send_by_goods'	=> 'About send bonus by goods help document',
	
	'send_by_print_help'	=> 'Welcome to ECJia intelligent background send bonus by print page, on this page the user can operate send bonus.',
	'about_send_by_print'	=> 'About send bonus by print help document',
	
	'send_coupon_help'		=> 'Welcome to ECJia intelligent background send coupon by goods page, on this page the user can operate send coupon.',
	'about_send_coupon'		=> 'About send coupon by goods help document',
	
	'bonus_list_help'		=> 'Welcome to ECJia intelligent background bonus list page, the system will display all of the red in this list.',
	'about_bonus_list'		=> 'About bonus list help document',
	
	'overview'				=> 'Overview',
	'more_info'				=> 'More information:',
	
	'type_name_required'		=> 'Please enter bonus type name',
	'type_name_minlength'		=> 'Bonus type name can not be less than 1',
	'type_money_required'		=> 'Please enter the amount of bonus',
	'min_goods_amount_required'	=> 'Please enter a minimum amount order',
	
	'bonus_sum_required'		=> 'Please enter the number of bonus!',
	'bonus_number_required'		=> 'Please enter the number!',
	'select_goods_empty'		=> 'Not search for goods information',
	'select_user_empty'			=> 'Not search for user information',
	
	'send_startdate_required'	=> 'Please enter send start date!',
	'send_enddate_required'		=> 'Please enter send end date!',
	'use_startdate_required'	=> 'Please enter use start date!',
	'use_enddate_required'		=> 'Please enter end start date!',
	
	'send_start_lt_end' 		=> 'bonus release date can not be greater than the beginning date of the end',
	'use_start_lt_end'	 		=> 'bonus use date can not be greater than the beginning date of the end',
	'merchant_notice'			=> 'Settled businesses do not have the right to operate, please visit the business background operation!'
);

//end