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
 * ECJIA 短信模块语言文件
 */
return array(
	/* Navigation */
	'register_sms'	=> 'Register Or Enable Sms Account.',
	'sms_deliver' 	=> 'Merchant shipping notice templates',//追加
	'sms_order' 	=> 'Customer orders notice template',//追加
	'sms_money' 	=> 'Payouts notification templates',//追加
	
	/* Register or enable sms */
	'email'			=> 'Email',
	'password'		=> 'Password',
	'domain'		=> 'Domain',
	'error_tips'	=> 'Set in the shop - "SMS settings, first register and properly configure the SMS messaging service!',
	'register_new'	=> 'Register',
	'enable_old'	=> 'Enable account',
	
	/* Sms special service message */
	'sms_user_name'		=> 'Username:',
	'sms_password'		=> 'Password:',
	'sms_domain'		=> 'Domain:',
	'sms_num'			=> 'Sms special service number:',
	'sms_count'			=> 'Send smsquantity:',
	'sms_total_money'	=> 'Total money:',
	'sms_balance'		=> 'Balance:',
	'sms_last_request'	=> 'Latest request time:',
	'disable'			=> 'Disable sms service',
	
	/* Send sms */
	'phone'			=> 'Mobile phone',
	'user_rand'		=> 'Send short message by the user level',
	'phone_notice'	=> 'More than one phone number divided by DBC case comma.',
	'msg'			=> 'Message',
	'msg_notice'	=> '70 character at most',
	'send_date'		=> 'Send at certain times',
	'send_date_notice'		=> 'Format is YYYY-MM-DD HH:II. If it is blank then send immediately.',
	'back_send_history'		=> 'Return to send history',
	'back_charge_history'	=> 'Return to charge history',
	
	/* Record query interface */
	'start_date'		=> 'Start date',
	'date_notice'		=> 'Format:YYYY-MM-DD. Allowed blank.',
	'end_date'			=> 'Deadline',
	'page_size'			=> 'Display every page',
	'page_size_notice'	=> 'Can be blank, diaplay every 20 records.',
	'page'				=> 'Page quantity',
	'page_notice'		=> 'Can be blank,express display every 1 page.',
	'charge'			=> 'Please enter the charge what you want to recharge.',
	
	/* Confirm action information */
	'history_query_error'	=> 'Sorry, error in the process of query.',
	'enable_ok'				=> 'Congratulations, you have enabled sms service!',
	'enable_error'			=> 'Sorry, you enable sms service has failed.',
	'disable_ok'			=> 'You logout sms service successfully.',
	'disable_error'			=> 'Logout sms service has failed.',
	'register_ok'			=> 'Congratulations, you register sms service successfully!',
	'register_error'		=> 'Sorry, you register sms service has failed.',
	'send_ok'				=> 'Congratulations ,your message has be sent successfully!',
	'send_error'			=> 'Sorry, error in the process of send.',
	'error_no'				=> 'Error mark',
	'error_msg'				=> 'Error description',
	'empty_info'			=> 'Your sms special service is blank.',
	
	/* cellphone replenishing record */
	'order_id'	=> 'Order ID',
	'money'		=> 'Recharge money',
	'log_date'	=> 'Recharge date',
	
	/* Send logs */
	'sent_phones'	=> 'Sent cellphone number',
	'content'		=> 'Content',
	'charge_num'	=> 'Payments',
	'sent_date'		=> 'Sent date',
	'send_status'	=> 'Send status',
	
	'status' => array(
		0	=> 'Fail',
		1	=> 'Succeed',
	),
	
	'user_list'		=> 'All user',
	'please_select'	=> 'Please choose the membership grade',
	
	/* Prompting message */
	'test_now'	=> '<span style="color:red,"></span>',
	'msg_price'	=> '<span style="color:green,">0.1 yuan(RMB) every message</span>',
	
	/* API return error information */
	'api_errors' => array(
		//--register
		'register' => array(
			1	=> 'Domain name can\'t be blank.',
			2	=> 'Mailbox is invalid.',
			3	=> 'Username already exists.',
			4	=> 'Unknown error.',
			5	=> 'Port error.',
		),
		//--Gain balance
		'get_balance' => array(
			1	=> 'Password is invalid.',
			2	=> 'User disable.',
		),
		//--Send sms
		'send' => array(
			1	=> 'Password is invalid.',
			2	=> 'Sms content length is invalid.',
			3	=> 'Send time should later than current time.',
			4	=> 'Error number.',
			5	=> 'Balance not enough.',
			6	=> 'Account is stoped.',
			7	=> 'Port error.',
		),
		//--History record
		'get_history' => array(
			1	=> 'Password is invalid.',
			2	=> 'No record.',
		),
		//--User verify
		'auth' => array(
			1	=> 'Password error.',
			2	=> 'No user.',
		),
	),
	
	/* User server detected error information */
	'server_errors' => array(
		1	=> 'error invalid register information.',//ERROR_INVALID_REGISTER_INFO
		2	=> 'error invalid enable information.',//ERROR_INVALID_ENABLE_INFO
		3	=> 'error invalid send information.',//ERROR_INVALID_SEND_INFO
		4	=> 'error invalid history query.',//ERROR_INVALID_HISTORY_QUERY
		5	=> 'error invalid passport.',//ERROR_INVALID_PASSPORT
		6	=> 'error invalid URL.',//ERROR_INVALID_URL
		7	=> 'error empty response.',//ERROR_EMPTY_RESPONSE
		8	=> 'error invalid xml file.',//ERROR_INVALID_XML_FILE
		9	=> 'error invalid node name.',//ERROR_INVALID_NODE_NAME
		10	=> 'error cant store.',//ERROR_CANT_STORE
		11	=> 'SMS feature is not yet activated.',//ERROR_INVALID_PASSPORT
	),
	
	/* Client JS language item */
	//--Register or  invocation
	'js_languages' => array(
		'password_empty_error'	=> 'Please enter password.',
		'username_empty_error'	=> 'Please enter username.',
		'username_format_error'	=> 'Username format is invalid.',
		'domain_empty_error'	=> 'Domain can\'t be blank.',
		'domain_format_error'	=> 'Domain format is invalid.',
		'send_empty_error'		=> 'Send phone number and send at least fill out a rating！',
		//--Send
		'phone_empty_error'		=> 'Please enter phone number.',
		'phone_format_error'	=> 'Phone member format is invalid.',
		'msg_empty_error'		=> 'Please enter meaasge content.',
		'send_date_format_error'=> 'Timing format is invalid.',
		//--History record
		'start_date_format_error'	=> 'Start time format is invalid.',
		'end_date_format_error'		=> 'Deadline format is invalid.',
		//--Recharge
		'money_empty_error'		=> 'Please enter charge what you want to recharge.',
		'money_format_error'	=> 'Money format is invalid.',
	),
	
	//追加
	'sms_config'		=> 'SMS Configuration',
	'set_config'		=> 'SMS Management > SMS Configuration',
	'update_success'	=> 'Update SMS configuration success!',
	'surplus'			=> 'Your current message is still remaining %s',
	'platform_config'	=> 'Platform Configuration',
	'label_sms_account'	=> 'Account:',
	'label_sms_password'=> 'Password:',
	'search_balance'	=> 'Query account balance',
	'label_shop_mobile'	=> 'Merchant telephone:',
	
	'label_config_order'		=> 'Customer order:',
	'label_config_money'		=> 'Customer payment:',
	'label_config_shipping'		=> 'Merchant shipping:',
	'label_config_user'			=> 'User registration:',
	'sms_receipt_code'			=> 'Receiving verification code:',
	'send_sms'					=> 'Send messages',
	'not_send_sms'				=> 'Don\'t send messages',
	'config_order_notice' 		=> 'Whether to send messages to businesses when the customer orders',
	'config_money_notice'		=> 'Whether to send messages to businesses when customers pay',
	'config_shipping_notice'	=> 'Whether or not to send a message to the customer when the merchant shipping',
	'config_user_notice'		=> 'Users to send messages when the user is registered',
	'receipt_code_notice'		=> 'Do you send the receipt verification code to the customer after payment',
	
	'sms_template'			=> 'SMS Template',
	'sms_template_list'		=> 'SMS Template List',
	'add_sms_template'		=> 'Add SMS Template',
	'template_name_exist'	=> 'The name of the SMS template already exists!',
	'template_code_is'		=> 'Template name is %s',
	'template_subject_is'	=> 'SMS theme is %s',
	'return_template_list'	=> 'Return to SMS template list',
	'continue_add_template'	=> 'Continue to add SMS template',
	'add_template_success'	=> 'Add SMS template success',
	'edit_sms_template'		=> 'Edit SMS template',
	'edit_template_success'	=> 'Edit SMS template success',
	'remove_template_success' => 'Delete SMS template success',
	
	'label_sms_template'	=> 'Template name:',
	'label_subject'			=> 'SMS theme:',
	'label_content'			=> 'Template content:',
	'update'				=> 'Update',
	'sms_template_code'		=> 'Template name',
	'sms_template_subject'	=> 'SMS theme',
	'sms_template_content'	=> 'Template content',
	'drop_confirm'			=> 'Are you sure you want to delete the SMS template?',
	
	'sms_record'			=> 'SMS Record',
	'sms_record_list'		=> 'SMS Record List',
	'send_sms'				=> 'Send messages',
	'add_sms_send'			=> 'Add SMS send',
	'receive_number_is'		=> 'Send a message again, reception number is %s',
	'send_success'			=> 'Sent successfully!',
	'batch_send_success'	=> 'Batch send success',
	'label_user_rank'		=> 'Send short messages by user level:',
	'select_user_rank'		=> 'Please select member level',
	'label_send_num'		=> 'Receive mobile phone number:',
	'send_num_notice'		=> 'Multiple phone numbers separated by commas',
	'label_msg'				=> 'Message Content:',
	
	'all'			=> 'All',
	'wait_send'		=> 'To be send',
	'send_success'	=> 'Send success',
	'send_faild'	=> 'Failed to send',
	'batch_handle'	=> 'Batch Operations',
	
	'batch_send_confirm'	=> 'Are you sure you want to send the selected messages again?',
	'select_confirm'		=> 'Please select the message you want to send again!',
	'send_sms_again'		=> 'Send messages again',
	
	'start_time'	=> 'Start time',
	'to'			=> 'to',
	'end_time'		=> 'End time',
	'filter'		=> 'Filter',
	'sms_keywords'	=> 'Please enter message number or content keywords',
	'search'		=> 'Search',
	'sms_number'	=> 'Receive number',
	'sms_content'	=> 'SMS content',
	'send_time'		=> 'Send time',
	'send_status'	=> 'Send status',
	'error_times'	=> 'Times Send Error',
	'send_again'	=> 'Resend',
	
	'not_found_smsid'	=> 'Did not find this message record',
	'invalid_argument'	=> 'Invalid parameter',
	'invalid_account'	=> 'Invalid account information',
	
	'sms_manage'			=> 'SMS Management',
	'sms_send_manage'		=> 'SMS Send Management',
	'sms_history_manage'	=> 'SMS History Management',
	'sms_template_manage'	=> 'SMS Template Management',
	'sms_config_manage'		=> 'SMS Configuration Management',
	'batch_setup'			=> 'Batch setting ',
	
	'overview'				=> 'Overview',
	'more_info'     		=> 'More information:',
	
	'sms_config_help'		=> 'Welcome to ECJia intelligent background SMS configuration page, the system in the information configuration information display on this page.',
	'about_sms_config'		=> 'About SMS configuration help document',
	
	'sms_template_help'		=> 'Welcome to ECJia intelligent background SMS template page, the system will display all the SMS template in this list.',
	'about_sms_template'	=> 'About SMS templates help document',
	
	'add_template_help'		=> 'Welcome to ECJia intelligent background to add SMS template page, you can add SMS template.',
	'about_add_template'	=> 'About add SMS templates help document',
	
	'edit_template_help'	=> 'Welcome to ECJia intelligent background edit SMS template page, you can edit the corresponding SMS template information.',
	'about_edit_template'	=> 'About edit SMS template help document',
	
	'sms_history_help'		=> 'Welcome to ECJia intelligent background SMS record list page, the system will display all the text messages in this list.',
	'about_sms_history'		=> 'About SMS record help document ',
	
	'js_lang' => array(
		'sms_user_name_required'	=> 'Please fill in the SMS platform account!',
		'sms_password_required'		=> 'Please enter the SMS platform password!',
		'sms_password_minlength'	=> 'SMS platform password length should not be less than 6!',

		'sFirst'					=> 'Home page',
		'sLast' 					=> 'End page',
		'sPrevious'					=> 'Last page',
		'sNext'						=> 'Next page',
		'sInfo'						=> 'A total of _TOTAL_ records section _START_ to section _END_',
		'sZeroRecords' 				=> 'Did not find any record',
		'sEmptyTable' 				=> 'Did not find any record',
		'sInfoEmpty'				=> 'A total of 0 records',
		'sInfoFiltered'				=> '(retrieval from _MAX_ data)',

		'template_code_required'	=> 'Template name can not be empty!',
		'subject_required'			=> 'SMS theme can not be empty!',
		'content_required'			=> 'Template content can not be empty!',

		'start_lt_end_time'			=> 'Start time can not be greater than the end time!',
		'send_num_required'			=> 'Please fill out the receiving phone number!',
		'msg_required'				=> 'Please fill in the message content!',
	),
	
	//追加
	'sms_template_update'	=> 'Update template',
	'sms_template_delete'	=> 'Remove template',
	'sms_config_update' 	=> 'Configuration update'
);

//end