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
	'app_name'		=> 'ECJIA',
	'cp_home'		=> 'ECJIA Management',
	'copyright'		=> ' &copy, 2005-2012 ECJIA Copyright, <br> All Right Reserved.',
	'query_info'	=> 'Run %d queries, spend %s seconds',
	'memory_info'	=> ',memory occupied:%0.3f MB',
	'gzip_enabled'	=> ',Gzip enabled',
	'gzip_disabled'	=> ',Gzip disabled',
	'loading'		=> 'Processing...',
		
	'js_languages' => array(
		'process_request'	=> 'Processing...',
		'todolist_caption'	=> 'To do list',
		'todolist_autosave'	=> 'Auto save',
		'todolist_save'		=> 'Save',
		'todolist_clear'	=> 'Clear',
		'todolist_confirm_save'	=> 'Are you sure save change to To do list?',
		'todolist_confirm_clear'=> 'Are you sure clear text?',
	),

	'auto_redirection'	=> 'If you don\'t select, <span id="spanSeconds">3</span> seconds ago, it will jump to the first URL.',
	'password_rule'		=> 'Password should only contain english character, figure, long between 6 and 16 bits.',
	'username_rule'		=> 'Username should be chinese ,english character, figure combination, between 3 and 15 bits.',
	'plugins_not_found'	=> 'Plug-in %s can\'t be fixed position',
	'no_records'		=> 'Did not find any record',
	'role_describe'		=> 'Description',
	
	'require_field'	=> '<span class="require-field">*</span>',
	'yes'			=> 'Yes',
	'no'			=> 'No',
	'record_id'		=> 'ID',
	'handler'		=> 'Operate',
	'install'		=> 'Install',
	'uninstall'		=> 'Uninstall',
	'list'			=> 'List',
	'add'			=> 'Add',
	'edit'			=> 'Edit',
	'view'			=> 'View',
	'remove'		=> 'Remove',
	'drop'			=> 'Delete',
	'confirm_delete'=> 'Are you sure you want to delete?',
	'disabled'		=> 'Disabled',
	'enabled'		=> 'Enabled',
	'setup'			=> 'Setup',
	'success'		=> 'Success',
	'sort_order'	=> 'Sort',
	'trash'			=> 'Recycle bin',
	'restore'		=> 'Restore',
	'close_window'	=> 'Close Window',
	'btn_select'	=> 'Choose',
	'operator'		=> 'Operator',
	'cancel'		=> 'Cancel',
	'operate_fail'		=> 'Operate Fail',
	'invalid_parameter' => 'Invalid parameter',
	
	'empty'			=> 'Can\'t be blank',
	'repeat'		=> 'Existed',
	'is_int'		=> 'It must be an integer',
	
	'button_submit'	=> ' Submit ',
	'button_save'	=> ' Save ',
	'button_reset'	=> ' Reset ',
	'button_search'	=> ' Search ',
	
	'priv_error'	=> 'Sorry, you haven\'t authorization to run this operation!',
	'drop_confirm'	=> 'Are you sure delete this record?',
	'form_notice'	=> 'View notices',
	'upfile_type_error'	=> 'Upload file type error!',
	'upfile_error'		=> 'Upload file error!',
	'no_operation'		=> 'You do not choose any action',
	
	'go_back'		=> 'Previous',
	'back'			=> 'Back',
	'continue'		=> 'Continue',
	'system_message'=> 'System information',
	'check_all'		=> 'Check all',
	'select_please'	=> 'Please select...',
	'all_category'	=> 'All categories',
	'all_brand'		=> 'All brand',
	'refresh'		=> 'Refresh',
	'update_sort'	=> 'Update sort',
	'modify_failure'=> 'Modify failure!',
	'attradd_succed'=> 'Operate successfully!',
	'todolist'		=> 'To do list',
	'n_a'			=> 'N/A',
	
	//追加
	'sys' => array(
			'wrong' => 'Wrong：',
	),
		
		
	/* Coding */
	'charset' => array(
		'utf8'	=> 'Internationalization coding(utf8)',
		'zh_cn'	=> 'Simplified chinese',
		'zh_tw'	=> 'Traditional Chinese',
		'en_us'	=> 'America english',
		'en_uk'	=> 'English',
	),
		
	/* New order notify */
	'order_notify'	=> 'New order notify',
	'new_order_1'	=> 'You have ',
	'new_order_2'	=> ' New orders and ',
	'new_order_3'	=> ' New paid orders',
	'new_order_link'=> 'View new orders',
	
	/* Language item*/
	'chinese_simplified'	=> 'Simplified chinese',
	'english'				=> 'English',
	
	/* Pagination */
	'total_records'	=> 'Total ',
	'total_pages'	=> 'records, divided into ',
	'page_size'		=> 'page, per page',
	'page_current'	=> 'pages,  current No.',
	'page_first'	=> 'First',
	'page_prev'		=> 'Prev',
	'page_next'		=> 'Next',
	'page_last'		=> 'Last',
	'admin_home'	=> 'HOME',
	
	/* Weight */
	'gram'		=> 'Gram',
	'kilogram'	=> 'Kilogram',
	
	/* Menu category */
	'02_cat_and_goods'	=> 'Product',
	'03_promotion'		=> 'Sales promotion',
	'04_order'			=> 'Order',
	'05_banner'			=> 'Advertisement',
	'06_stats'			=> 'Reports Statistic',
	'07_content'		=> 'Article',
	'08_members'		=> 'Member',
	'09_others'			=> 'Others',
	'10_priv_admin'		=> 'Authorization',
	'11_system'			=> 'System Setup',
	'12_template'		=> 'Template',
	'13_backup'			=> 'Database',
	'14_sms'			=> 'Short Message',
	'15_rec'			=> 'Recommend management',
	'16_email_manage'	=> 'Mass-mailing management',
	
	/* Product management */
	'01_goods_list'		=> 'Product List',
	'02_goods_add'		=> 'New Product',
	'03_category_list'	=> 'Product Category',
	'04_category_add'	=> 'New Category',
	'05_comment_manage'	=> 'User Comments',
	'06_goods_brand_list'	=> 'Product Brand',
	'07_brand_add'			=> 'New Brand',
	'08_goods_type'			=> 'Product Type',
	'09_attribute_list'		=> 'Product Attribute',
	'10_attribute_add'		=> 'Add Attribute',
	'11_goods_trash'		=> 'Recycle Bin',
	'12_batch_pic'			=> 'Pictures Processor ',
	'13_batch_add'			=> 'Upload Products',
	'15_batch_edit'			=> 'Batch Edit',
	'16_goods_script'		=> 'Product Code',
	'17_tag_manage'			=> 'Tag',
	'52_attribute_add'		=> 'Edit Attribute',
	'53_suppliers_goods'	=> 'Management of suppliers of goods',
	
	'14_goods_export'		=> 'Merchandise export volume',
	
	'50_virtual_card_list'	=> 'Virtual Goods List',
	'51_virtual_card_add'	=> 'New Virtual Goods',
	'52_virtual_card_change'=> 'Change encrypt string',
	'goods_auto'			=> 'Automatic merchandise from top to bottom rack',
	'article_auto'			=> 'Published article automatically',
	'navigator'				=> 'Custom navigation bar',
	
	/* Sales promotion management */
	'02_snatch_list'	=> 'Dutch Auction',
	'snatch_add'		=> 'Add Dutch Auction',
	'04_bonustype_list'	=> 'Bonus Type',
	'bonustype_add'		=> 'Add Bonus Type',
	'05_bonus_list'		=> 'Bonus Offline',
	'bonus_add'			=> 'Add User Bonus',
	'06_pack_list'		=> 'Product Packing',
	'07_card_list'		=> 'Greetings Card',
	'pack_add'			=> 'New Packing',
	'card_add'			=> 'New Card',
	'08_group_buy'		=> 'Associates',
	'09_topic'			=> 'Topic',
	'topic_add'			=> 'Add Topic',
	'topic_list'		=> 'Topic List',
	'10_auction'		=> 'Auction',
	'12_favourable'		=> 'Favourable Activity',
	'13_wholesale'		=> 'Wholesale',
	'ebao_commend'		=> 'Ebao commend',
	'14_package_list'	=> 'Preferential Packeage',
	'package_add'		=> 'Add Preferential Packeage',
	
	/* Orders management */
	'02_order_list'		=> 'Order List',
	'03_order_query'	=> 'Order Query',
	'04_merge_order'	=> 'Combine Orders',
	'05_edit_order_print'	=> 'Print Orders',
	'06_undispose_booking'	=> 'Booking Records',
	'08_add_order'			=> 'Add Order',
	'09_delivery_order'		=> 'Delivery Order',
	'10_back_order'			=> 'Returned Order',
	
	/* AD management */
	'ad_position'	=> 'AD Position',
	'ad_list'		=> 'AD List',
	
	/* Report statistic */
	'flow_stats'			=> 'Flux Analyse',
	'searchengine_stats'	=> 'Search engine',
	'report_order'		=> 'Order Statistic',
	'report_sell'		=> 'Sales Survey',
	'sell_stats'		=> 'Sales Ranking',
	'sale_list'			=> 'Sales Details',
	'report_guest'		=> 'Client Statistic',
	'report_users'		=> 'User Ranking',
	'visit_buy_per'		=> 'Visit Purchase Rate',
	'z_clicks_stats'	=> 'External Laid JS',
	
	/* Article management */
	'02_articlecat_list'	=> 'Article Category',
	'articlecat_add'		=> 'New Article Category',
	'03_article_list'		=> 'Articles',
	'article_add'			=> 'New Article',
	'shop_article'			=> 'Shop Article',
	'shop_info'				=> 'Shop Information',
	'shop_help'				=> 'Shop Help',
	'vote_list'				=> 'Vote Online',
	
	/* User management */
	'03_users_list'		=> 'Users',
	'04_users_add'		=> 'New User',
	'05_user_rank_list'	=> 'User Rank',
	'06_list_integrate'	=> 'Integrate User',
	'09_user_account'	=> 'Saving and drawing application',
	'10_user_account_manage'	=> 'account_manage',
		
	//追加
	'menu_user_integrate' 	=> 'Member Integration',
	'menu_user_connect'		=> 'Account connection',
		
	'17_msg_mmanage'		=> 'Feedback',
	'08_unreply_msg'		=> 'User Message',
	'01_order_msg'			=> 'Order Message',
	'02_comment_msg'		=> 'Public messages',
	
	/* Authorization  management */
	'admin_list'		=> 'Administrators',
	'admin_list_role'	=> 'Role list',
	'admin_role'		=> 'Management role',
	'admin_add'			=> 'New Administrator',
	'admin_add_role'	=> 'Add role',
	'admin_edit_role'	=> 'Modify role',
	'admin_logs'		=> 'Logs',
	'agency_list'		=> 'Agency',
	'suppliers_list'	=> 'Suppliers',
	
	/* System setup */
	'01_shop_config'	=> 'Configuration',
	'shop_authorized'	=> 'Authorized',
	'shp_webcollect'	=> 'Webcollect',
		
	'04_mail_settings'	=> 'Mail Settings',
	'05_area_list'		=> 'Area List',
	'shipping_area_list'=> 'Shipping Area',
	'sitemap'			=> 'Sitemap',
	'check_file_priv'	=> 'File Authorization',
// 	'captcha_manage'	=> 'Verification Code Management',
	'fckfile_manage'	=> 'Fck From document management',
	'ucenter_setup'		=> 'UCenter Set',
	'file_check'		=> 'Check File',
// 	'021_reg_fields'	=> 'Register options settings',
	'21_reg_fields'	=> 'Register options settings',
		
		
	'01_payment_list'	=> 'Payment',
	'02_shipping_list'	=> 'Shipping',
	'03_cron_list' 		=> 'Cron',
	'04_cycleimage_manage' => '轮播图管理',
	'05_captcha_setting' => '验证码设置',
	'06_friendlink_list' => '友情链接',
// 	'07_cron_schcron'	=> 'Cron',
// 	'08_friendlink_list'=> 'Links',


	/* Template management */
	'02_template_select'	=> 'Select Template',
	'03_template_setup'		=> 'Setup Template',
	'04_template_library'	=> 'Library Item',
	'mail_template_manage'	=> 'Mail Template',
	'05_edit_languages'		=> 'Language Item',
	'06_template_backup'	=> 'Template Settings backup',
		
	/* Database management */
	'02_db_manage'		=> 'Backup',
	'03_db_optimize'	=> 'Optimize',
	'04_sql_query'		=> 'SQL Query',
	'05_synchronous'	=> 'Synchronous',
	'convert'			=> 'Convertor',
	
	/* Short management */
	'02_sms_my_info'	=> 'Accounts',
	'03_sms_send'		=> 'Send Message',
	'04_sms_charge'		=> 'Accounts Charge',
	'05_sms_send_history'	=> 'Send Record',
	'06_sms_charge_history'	=> 'Charge History',
	
	'affiliate'		=> 'Recommended settings',
	'affiliate_ck'	=> 'Divided into management',
	'flashplay'		=> 'Flash Player Management',
	'search_log'	=> 'Search keywords',
	'email_list'	=> 'E-mail subscription management',
	'magazine_list'	=> 'Journal of Management',
	'attention_list'=> 'Concerned about the management',
	'view_sendlist'	=> 'Mail queue management',
	
	/* 积分兑换管理 */
	'15_exchange_goods'		=> 'Integral Mall Goods',
	'15_exchange_goods_list'=> 'Points Mall commodity list',
	'exchange_goods_add'	=> 'Add new merchandise',
	
	/* cls_image */
	'directory_readonly'		=> 'The directory % is not existed or unable to write.',
	'invalid_upload_image_type'	=> 'Not a allowable image type.',
	'upload_failure'			=> '%s failed to upload',
	'missing_gd'				=> 'GD is missing',
	'missing_orgin_image'		=> 'Can not find %s.',
	'nonsupport_type'			=> 'Nonsupport type of %s.',
	'creating_failure'			=> 'Fail to create image.',
	'writting_failure'			=> 'Fail to write image.',
	'empty_watermark'			=> 'The parameter of watermark is empty.',
	'missing_watermark'			=> 'Can not find %s.',
	'create_watermark_res'		=> 'Fail to create resource of watermark. The image type is %s.',
	'create_origin_image_res'	=> 'Fail to create resource of origin image. The image type is %s.',
	'invalid_image_type'		=> 'Unknown watermark image %s.',
	'file_unavailable'			=> 'File %s don\'t exist or are unreadable.',
	
	/* SMTP ERROR */
	'smtp_setting_error'		=> 'There is an error in SMTP setting.',
	'smtp_connect_failure'		=> 'Unable to connect to SMTP server %s.',
	'smtp_login_failure'		=> 'Invalid SMTP username or password.',
	'sendemail_false'			=> 'E-mail failed, please check your mail server settings!',
	'smtp_refuse'				=> 'SMTP server refuse to send this mail.',
	'disabled_fsockopen'		=> 'Fsocketopen server function is disabled.',
	
	/* 虚拟卡 */
	'virtual_card_oos'	=> 'Virtual card out of stock',
	
	'span_edit_help'	=> 'Click to edit content',
	'href_sort_help'	=> 'Click on the list to sort',
	
	'catname_exist'		=> 'Has exist the same category!',
	'brand_name_exist'	=> 'Has exist the same brand!',
	
	'alipay_login'	=> '<a href="https://www.alipay.com/user/login.htm?goto=https%3A%2F%2Fwww.alipay.com%2Fhimalayas%2Fpracticality_profile_edit.htm%3Fmarket_type%3Dfrom_agent_contract%26customer_external_id%3D%2BC4335319945672464113" target="_blank">Immediate payment interface for free jurisdiction</a>',
	'alipay_look'	=> '<a href=\"https://www.alipay.com/himalayas/practicality.htm\" target=\"_blank\">Please apply after successful login pay treasure account check</a>',	
);

//end