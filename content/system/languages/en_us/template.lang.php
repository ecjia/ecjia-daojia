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
	'template_manage'		=>'Template Management',
	'current_template'		=> 'Current Template',
	'available_templates'	=> 'Available Templates',
	'select_template'		=> 'Please select a template:',
	'select_library'		=> 'Please select a library:',
	'library_name'			=> 'Library name',
	'region_name'			=> 'Region',
	'sort_order'			=> 'Serial number',
	'contents'				=> 'Content',
	'number'				=> 'Quantity',
	'display'				=> 'Display',
	'select_plz'			=> 'Please select...',
	'button_restore'		=> 'Repeal',
		
	//追加	
	'template_author'		=> 'Author',
	'template_info'			=> 'Template Description',
		
	/* Prompting message */
	'library_not_written'		=> 'Library file %s hasn\'t right to edit, so edit the library file has failed.',
	'install_template_success'	=> 'Enable template successfully.',
	'setup_success'				=> 'Setup template content successfully.',
	'modify_dwt_failed'			=> 'The template file %s can not modify.',
	'setup_failed'				=> 'Setup template content has failed.',
	'update_lib_success'		=> 'Library item content has uploaded successfully.',
	'update_lib_failed'			=> 'Edit library item content has failed. Please check %s directory whether can be read-in.',
	'backup_success'			=> "All template files has copied to the directory (templates/backup). \nAre you download the backup files now?",
	'backup_failed'				=> 'Backup template files has failed, please check the directory (template/backup) whether can be wrote.',
	'not_editable'				=> 'Libs in no-editable region have no options.',
	
	/* Every template file corresponding to language */
	'template_files' => array(
		'article'		=> 'Article content template',
		'article_cat'	=> 'Article category template',
		'brand'			=> 'Brand area',
		//'catalog'		=>'All categories pages',
		'category'		=> 'Products category page template',
		'flow'			=>'Shopping process template',
		'goods'			=> 'Product information template',
		'group_buy_goods'	=> 'Associates products detail template',
		'group_buy_list'	=> 'Associates products list template',
		'index'				=> 'Homepage template',
		'search'			=> 'Search template',
		'compare'			=> 'Compare template',
		'snatch'			=> 'Dutch auction',
		'tag_cloud'			=> 'Tag template',
		'brand'				=> 'Brand page',
		'auction_list'		=> 'Auction list template',
		'auction'			=> 'Auction template',
		'message_board'		=> 'Message Board',
		'exchange_list'		=> 'Mall points list',
	),
	
	/* Every library item's description */
	'template_libs' => array(
		'ad_position'	=> 'AD position',
		'index_ad'		=> 'Homepage AD position',
		'cat_articles'	=> 'Article list',
		'articles'		=> 'Articles',
		'goods_attrlinked'		=> 'Product attrlinked',
		'recommend_best'		=> 'Recommend',
		'recommend_promotion'	=> 'Recommend promotion',
		'recommend_hot'			=> 'Hot',
		'recommend_new'			=> 'New',
		'bought_goods'			=> 'Customers who bought items like this also bought.',
		'bought_note_guide'		=> 'Bought notes',
		'brand_goods'	=> 'Brand product',
		'brands'		=> 'Brands',
		'cart'			=> 'Cart',
		'cat_goods'		=> 'Category',
		'category_tree'	=> 'Category tree',
		'comments'		=> 'User comments list',
		'consignee'		=> 'Place of receipt memu',
		'goods_fittings'=> 'Relational Accessories',
		'page_footer'	=> 'Footer',
		'goods_gallery'	=> 'Gallery',
		'goods_article'	=> 'Article',
		'goods_list'	=> 'List',
		'goods_tags'	=> 'Tags',
		'group_buy'		=> 'Associates',
		'group_buy_fee'	=> 'Total money for associates products',
		'help'			=> 'Help',
		'history'		=> 'History',
		'comments_list'	=> 'Comments list',
		'invoice_query'	=> 'Invoice query',
		'member'		=> 'Members',
		'member_info'	=> 'Members information',
		'new_articles'	=> 'New articles',
		'order_total'	=> 'Total orders money',
		'page_header'	=> 'Top',
		'pages'			=> 'Pages',
		'goods_related'	=> 'Relational products',
		'search_form'	=> 'Search memu',
		'signin'		=> 'Login memu',
		'snatch'		=> 'Dutch auction',
		'snatch_price'	=> 'New bidding',
		'top10'			=> 'Top10',
		'ur_here'		=> 'Current position',
		'user_menu'		=> 'Member center menu',
		'vote'			=> 'Vote',
		'auction'		=> 'Auction',
		'article_category_tree'	=> 'Article Category tree',
		'order_query'	=> 'Front order status inquiries',
		'email_list'	=> 'E-mail Subscriptions',
		'vote_list'		=> 'Online vote',
		'price_grade'	=> 'Price range',
		'filter_attr'	=> 'Filter property',
		'promotion_info'=> 'Promotion infomation',
		'categorys'		=> 'Goods category',
		'myship'		=> 'Shipping',
		'online'		=> 'Number of persons online',
		'relatetag'		=> 'Other applications associated tag data',
		'message_list'	=> 'Message List',
		'exchange_hot'	=> 'Points Mall Hot commodity',
		'exchange_list'	=> 'Points Mall commodity',
	),	

	
	/* 模板布局备份 */
	'backup_setting'		=> 'Backup template settings',
	'cur_setting_template'	=> 'The current template settings can be backed up',
	'no_setting_template'	=> 'There is no backup of the template settings',
	'cur_backup'			=> 'Can be used to back up the template settings',
	'no_backup'				=> 'There is no template settings backup',
	'remarks'				=> 'Backup Notes',
	'backup_setting'		=> 'Backup template settings',
	'select_all'			=> 'Select All',
	'remarks_exist'			=> 'Backup Notes %s has been used, please note the name change',
	'backup_template_ok'	=> 'The success of the backup set',
	'del_backup_ok'			=> 'Delete backup success',
	'restore_backup_ok'		=> 'The success of the restoration of the backup',
	
	/* JS language item */
	'js_languages' => array(
		'setupConfirm'	=> "Enable new template and disable old template. \\nAre you sure enable the new template?",
		'reinstall'		=> 'Reinstall current template',
		'selectPlease'	=> 'Please select...',
		'removeConfirm'	=> 'Are you sure delete the selected contents?',
		'empty_content'	=> 'Sorry, library content can\'t be blank.',
		'save_confirm'	=> 'You have edit template, are you sure don\'t save it?',
	),	
	'backup'	=>  'Back-up current template',
);
