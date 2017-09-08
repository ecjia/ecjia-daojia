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
 * 推送消息语言包
 */
return array(
	//消息配置
	'msg_config'				=> 'Message Configuration',
	'update_config_success'		=> 'Update message configuration success',
	'platform_config'			=> 'Platform Configuration',
	'label_app_name'			=> 'Application name:',
	'app_name_help'				=> 'Only when prompted for Android application to receive message notification',
	'label_push_development'	=> 'Push environment:',
	'push_development_help'		=> 'App running on the line make sure to switch to the production environment',
	'dev_environment'			=> 'Development environment',
	'produce_environment'		=> 'Production environment',
		
	'label_android_app_key'		=> 'Android App Key:',
	'label_android_app_secret'	=> 'Android App Secret:',
	'label_iphone_app_key'		=> 'iPhone App Key:',
	'label_iphone_app_secret'	=> 'iPhone App Secret:',
	'label_ipad_app_key'		=> 'iPad App Key:',
	'label_ipad_app_secret'		=> 'iPad App Secret:',
	'label_client_order'		=> 'Customer pay order:',
	'client_order_help'			=> 'Whether to push the message to the business when the customer orders',
	'label_client_pay'			=> 'Customer payment:',
	'client_pay_help'			=> 'Whether to send messages to the business when customers pay',
	'label_seller_shipping'		=> 'Merchant shipping:',
	'seller_shipping_help'		=> 'Whether or not to send the message to the customer when the merchant shipping',
	'label_user_register'		=> 'User registration:',
	'user_register_help'		=> 'Whether the user is registered to push messages to customers',
		
	'push'		=> 'Push',
	'not_push'	=> 'Do not push',
	'resend'	=> 'Push again',
	'push_copy' => 'Message reuse',
		
	//消息模板
	'msg_template'				=> 'Message Template',
	'add_msg_template'			=> 'Add Message Template',
	'msg_template_list'			=> 'Message Template List',
	'template_name_exist'		=> 'The message template name already exists',
	'continue_add_template'		=> 'Continue to add message template',
	'back_template_list'		=> 'Return to message template',
	'add_template_success'		=> 'Add message template success',
	'edit_msg_template'			=> 'Edit message template',
	'update_template_success'	=> 'Update message template success',
	'remove_template_success'	=> 'Delete message template success',
		
	'label_msg_template'		=> 'Template name:',
	'label_msg_subject'			=> 'Message topic:',
	'label_msg_content'			=> 'Message content:',
	'update'					=> 'Update',
		
	'msg_template_name'			=> 'Template name',
	'msg_subject'				=> 'Message topic',
	'msg_content'				=> 'Message content',
	'remove_template_confirm'	=> 'Are you sure you want to delete the message template?',
		
	//消息记录
	'all'		=> 'All',
	'android'	=> 'Android',
	'iphone'	=> 'iPhone',
	'ipad'		=> 'iPad',
	
	'batch'		=> 'Batch Operations',
	
	//删除推送消息
	'remove_msg'			=> 'Delete Message',
	'remove_msg_confirm'	=> 'Are you sure you want to delete this push message?',
	'empty_select_msg'		=> 'Please select push message to be deleted',
		
	//再次推送消息
	'resend_msg'			=> 'Push message again',
	'resend_confirm'		=> 'Are you sure you want to push the message that push again?',
	'emtpy_resend_msg' 		=> 'Please select the message to be pushed again',
		
	//推送消息
	'push_confirm'			=> 'Are you sure you want to push this message?',
		
	'select_push_status'	=> 'Select push state',
	'push_fail'				=> 'Push fail',
	'push_success'			=> 'Push complete',
	'filter'				=> 'Filter',
	'msg_keywords'			=> 'Please enter a message subject keyword',
	'search'				=> 'Search',
			
	'device_type'			=> 'Device type',
	'push_status'			=> 'Push state',
	'add_time'				=> 'Add time',
	'has_pushed'			=> 'The message has been pushed',
	'time'					=> 'time',
	'label_push_on' 		=> 'Push on:',
		
	//发送消息
	'msg_subject_help'		=> 'Used to identify messages, to facilitate the search and management',
	'msg_content_help'		=> 'Here is the content of the message to be pushed',
	'push_behavior'			=> 'Push Behavior',
	'label_open_action'		=> 'Open action:',
		
	'nothing'		=> 'Nothing',
	'main_page'		=> 'Home',
	'singin'		=> 'Sign in',
	'signup'		=> 'Register',
	'discover'		=> 'Discover',
	'qrcode'		=> 'QR code scanning',
	'qrshare'		=> 'QR code sharing',
	'history'		=> 'History',
	'feedback'		=> 'Feedback',
	'map'			=> 'Map',
	'message_center'=> 'Message center',
	'webview'		=> 'Built-in browser',
	'setting'		=> 'Set up',
	'language'		=> 'Language selection',
	'cart'			=> 'Cart',
	'help'			=> 'Help center',
	'goods_list'	=> 'List of goods',
	'goods_comment'	=> 'Product reviews',
	'goods_detail'	=> 'Product details',
	'orders_list'	=> 'My order',
	'orders_detail'	=> 'Order details',
	'user_center'	=> 'User center',
	'user_wallet'	=> 'My wallet',
	'user_address'	=> 'Address management',
	'user_account'	=> 'Account balance',
	'user_password'	=> 'Change password',
		
	'label_url'			=> 'URL:',
	'label_keywords'	=> 'Keywords:',
	'lable_category_id' => 'Category ID:',
	'label_goods_id'	=> 'Product ID:',
	'label_order_id'	=> 'Order ID:',
	'push_object'		=> 'Push Object',
	'label_device_type' => 'Device type:',	
	'pleast_select'		=> 'Please select...',
	'device_type_help'	=> 'When pushed to the user or administrator, you do not need to select the device type',
	'label_push_to'		=> 'Push to:',
	'all_people'		=> 'All people',
	'unicast'			=> 'Unicast',
	'user'				=> 'User',
	'administrator'		=> 'Administrator',
	'label_device_token'=> 'Device Token:',
	'label_user_id'		=> 'User ID:',
	'label_admin_id'	=> 'Administrator ID:',
	'push_time'			=> 'Push Opportunity',
	'label_send_time'	=> 'Send time:',
	'send_now'			=> 'Send immediately',
	'send_later'		=> 'Send later',
		
	'msg_record'		=> 'Message Record',
	'add_msg_push'		=> 'Add Message Push',
	'msg_record_list'	=> 'Message Record List',
	'msg_push'			=> 'Message Push',
		
	'url_required'			=> 'Please enter the URL',
	'keywords_required'		=> 'Please enter a keyword',
	'category_id_required'	=> 'Please enter the product category ID',
	'goods_id_required'		=> 'Please enter a product ID',
	'order_id_required'		=> 'Please enter order ID',
	'admin_id_required'		=> 'Please enter the administrator ID',
	'device_info_required'	=> 'The user\'s Device Token not found',
	'user_id_required'		=> 'Please enter your user ID',
	'device_client_required'=> 'The user is not bound to the mobile terminal device',
	'device_token_required'	=> 'Please enter Token Device',
	'device_token_error'	=> 'The length of the input Token Device is not valid',
	
	'msg_push_success'		=> 'Message push success',
	'remove_msg_success'	=> 'Delete message success',
	'batch_push_success'	=> 'Batch push finished',
	'batch_drop_success'	=> 'Batch delete success',	
	'invalid_parameter'		=> 'Invalid parameter',
		
	//菜单
	'push_msg'	=> 'Push Message',
	'send_msg'	=> 'Send Message',
		
	'push_history_manage'	=> 'Message Record Management',
	'push_template_manage'	=> 'Message Template Management',
	'push_template_update'	=> 'Message Template Update',
	'push_template_delete'	=> 'Message Template Remove',
	'push_config_manage'	=> 'Message Configuration Management',
		
	'js_lang' => array(
		'title_required'	=> 'Please enter a message topic!',
		'content_required'	=> 'Please enter the message content!',
		'app_name_required'	=> 'Please fill in the application name!',
		'sFirst'			=> 'Home page',
		'sLast' 			=> 'End page',
		'sPrevious'			=> 'Last page',
		'sNext'				=> 'Next page',
		'sInfo'				=> 'A total of _TOTAL_ records section _START_ to section _END_',
		'sInfoFiltered'		=> '(retrieval from _MAX_ data)',
		'sZeroRecords' 		=> 'Did not find any record',
		'sEmptyTable' 		=> 'Did not find any record',
		'sInfoEmpty'		=> 'A total of 0 records',
		'template_required'	=> 'Template name can not be empty!',
		'subject_required'	=> 'Message theme can not be empty!',
		'msg_content_required' => 'Message content can not be empty!'	,
	)
);

// end