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
 * ECJIA Application language pack
 */
return array(
	/**
	 * ECJIA 文章列表字段信息
	 */
	'title' 		=> 'Title',
	'cat' 			=> 'Category',
	'cat_lable' 	=> 'Category:',
	'reserve' 		=> 'Reserve',
	'article_type' 	=> 'Importance',
	'author' 		=> 'Author',
	'email' 		=> 'Email',
	'keywords' 		=> 'Keywords:',
	
	'lable_description' 	=> 'Page Description',
	'content' 				=> 'Content',
	'is_open' 				=> 'Display',
	'is_open_lable' 		=> 'Display:',
	'article_id' 			=> 'ID',
	'add_time' 				=> 'Time',
	'upload_file' 			=> 'Upload file',
	'file_url' 				=> 'Or enter file address',
	'invalid_file' 			=> 'The file type is invalid',
	'article_name_exist' 	=> 'The title already exists.',
	'select_plz' 			=> 'Please select...',
	'external_links' 		=> 'External links:',
	
	'top' 				=> 'Top',
	'common' 			=> 'Common',
	'isopen' 			=> 'Open',
	'isclose' 			=> 'Close',
	'no_article' 		=> 'There is no article.',
	'no_select_article' => 'Please select an article.',
	'no_select_act' 	=> 'Select Article Categories!',
	
	'display' 		=> 'Display the article content.',
	'download' 		=> 'Download',
	'both' 			=> 'Both display content and download files.',
	'batch'   		=> 'Batch Operations',
	'button_remove' => 'Batch delete',
	'button_hide' 	=> 'Batch hidden',
	'button_show' 	=> 'Batch show',
	'move_to' 		=> 'Transfer to the category',
	
	'article_edit' 		=> 'Edit Article Content',
	'preview_article'   => 'Article Preview',
	'article_editbtn'   => 'Edit Article',
	'view'   			=> 'View',
	'tab_general' 		=> 'Common information',
	'tab_content' 		=> 'Content',
	'tab_goods' 		=> 'Relational goods',
	'link_goods' 		=> 'Products related to article',
	'keyword' 			=> 'Keywords',
	
	/* Prompting message */
	'title_exist' 			=> 'Article name is already exists.',
	'back_article_list' 	=> 'Article list',
	'continue_article_add' 	=> 'Continue to add new article',
	'articleadd_succeed' 	=> 'Add new article success',
	'articleedit_succeed' 	=> 'Edit article %s success',
	'articleedit_fail' 		=> 'Edit article has failed.',
	'no_title' 				=> 'Please enter article title.',
	'drop_confirm' 			=> 'Are you sure you want to delete?',
	'batch_handle_ok'   	=> 'Batch operation success',
	'batch_handle_ok_del' 	=> 'Batch delete success',
	'batch_handle_ok_hide'  => 'Batch hide success',
	'batch_handle_ok_show'  => 'Batch show success',
	'batch_handle_ok_move'	=> 'Batch move success',
	
	/*JS language item*/
	'js_languages' => array(
		'no_title' 			=> 'No title',
		'no_cat' 			=> 'Please select a category.',
		'not_allow_add' 	=> 'System to retain the classification in the classification does not allow to add article',
		'drop_confirm' 		=> 'Are you sure you want to delete?',
		'no_catname' 		=> 'Please enter article category name.',
		'sys_hold' 			=> 'Retain the classification system is not permitted to add sub-categories',
		'remove_confirm' 	=> 'Are you sure delete the selected category?',
	),
	
	'all_cat' 			=>  'All Categories',
	'search_article'	=>	'Search Article',
	
	/**
	 * ECJIA 文章分类字段信息
	 */
	'cat_name' 	=> 'Name',
	'type' 		=> 'Category Type',
	'type_name' => array(
		COMMON_CAT 	=> 'General classification',
		SYSTEM_CAT 	=> 'Taxonomy',
		INFO_CAT	=> 'Shop information',
		UPHELP_CAT 	=> 'Help Category',
		HELP_CAT    => 'Shop help',
	),
	
	'cat_keywords' 		=> 'Keywords',
	'cat_desc' 			=> 'Description',
	'parent_cat' 		=> 'Superior categories:',
	'cat_top' 			=> 'Top categories',
	'not_allow_add' 	=> 'Classification does not allow you to add the selected sub-classification',
	'not_allow_remove' 	=> 'System to retain the classification does not allow delete',
	'is_fullcat' 		=> 'There are sub-classified under the classification, first delete its sub-classification',
	'show_in_nav' 		=> 'Display in navigation',
	'add_article' 		=> 'Add New Article',
	'articlecat_edit' 	=> 'Edit article category',
	
	/* Prompting message */
	'catname_exist' 	=> '%s already exists.',
	'parent_id_err' 	=> 'Category name %s parent classification should not set itself or its own sub-classification',
	'back_cat_list' 	=> 'Article Category',
	'continue_add' 		=> 'Continue to add new category',
	'catadd_succed' 	=> 'Add success!',
	'catedit_succed' 	=> 'Edit category %s success!',
	'edit_title_success'=> 'Edit article title %s success!',
	'no_catname' 		=> 'Please enter a category name.',
	'edit_fail' 		=> 'Edit failed',
	'enter_int' 		=> 'Please enter an integer',
	'not_emptycat' 		=> 'Wrong, there are articles in the category.',
	
	/* Help */
	'notice_keywords'   => 'The keywords is optional, for search conveniently.',
	'notice_isopen' 	=> 'Whether display the category in navigation.',
	
	/**
	 * ECJIA 文章自动发布字段信息
	 */
	'id' 					=> 'No.',
	'starttime' 			=> 'Published',
	'endtime' 				=> 'The abolition of time',
	'article_name' 			=> 'Article name',
	'articleatolist_name'   => 'Article name',
	'ok' 					=> 'Determine',
	'edit_ok' 				=> 'Operate success',
	'edit_error'			=> 'Operate fail',
	'delete' 				=> 'Revocation',
	'deleteck' 				=> 'Delete this article to determine the automatic publish // unpublish handle it? This action will not affect the article itself',
	'enable_notice' 		=> 'You need to system settings -> plans to open mission in order to use this feature.',
	'button_start' 			=> 'Batch Release',
	'button_end' 			=> 'Volume Unpublishing',
	'no_select_goods' 		=> 'No article selected',
	'batch_start_succeed' 	=> 'Batch success posted',
	'batch_end_succeed' 	=> 'Cancel Batch success',
	'back_list'	 			=> 'Published article automatically return',
	'select_time' 			=> 'Please select the time',
	'drop_success'			=> 'Delete success',
    'batch_setup'           => 'Batch setup',
    
	'add_custom_columns_success'	=> 'Add a custom columns success',
	'miss_parameters_faild'			=> 'Lack of critical parameters, update failed!',
	'update_custom_columns_success'	=> 'Update custom columns success',
	'drop_custom_columns_success' 	=> 'Delete custom section success',
	'edit_link_goods'				=> 'Edit Link Goods',
	'article_title_is'				=> 'Article title is ',
	'article_title_empty'			=> 'Article Title can not be empty',
	'display_article'				=> 'Display article',
	'hide_article'					=> 'Hide article',
	'delete_attachment_success'		=> 'Delete attachment success ',
	'move_article'					=> 'Move article',
	'to_category'					=> 'to category  ',
	'move_to_category'				=> 'Move article to category',
	'select_move_article'			=> 'Please select the article you want to transfer!',
	'begin_move'					=> 'Begin to move',
	'confirm_drop'					=> 'Are you sure you want to do this?',
	'select_drop_article'			=> 'Please select the article you want to delete!',
	'select_hide_article'			=> 'Please select the article you want to hide!',
	'select_display_article'		=> 'Please select the article you want to display first!',
	'drop_article'					=> 'Delete',
	'display'						=> 'Display',
	'hide'							=> 'Hide',
	'move_category'					=> 'Move category',
	'filter'						=> 'Filter',
	'enter_article_title'			=> 'Please enter the title keywords',
	'edit_article_title'			=> 'Edit article name',
	'move_confirm'					=> 'Whether the selected articles transferred to a Category?',
	'enter_title_article_here'		=> 'Enter the article title',
	'links_help_block'				=> 'If you enter an external link, the link is preferred.',
	'seo_optimization'				=> 'SEO optimization',
	'split'							=> 'Separated by commas',
	'simple_description'			=> 'Quick description:',
	'custom_columns_success'		=> 'Custom columns',
	'edit_custom_columns_success'	=> 'Edit a custom columns',
	'name'							=> 'name',
	'value'							=> 'value',
	'update'						=> 'Update',
	'drop_custom_columns_confirm'	=> 'Are you sure you want to delete this custom columns?',
	'add_custom_columns'			=> 'Add a custom columns',
	'add_new_columns'				=> 'Add new columns',
	'category_info'					=> 'Category information',
	'is_top'						=> 'IsTop:',
	'issue'							=> 'Release',
	'author_info'					=> 'Author information',
	'author_name'					=> 'Name:',
	'author_email'					=> 'Mailbox:',
	'file_address'					=> 'File address：',
	'drop_file'						=> 'Delete file',
	'drop_file_confirm'				=> 'Are you sure you want to delete the attachment of this article?',
	'modify_file'					=> 'Modify file',
	'articlecat_add'				=> 'New Article Category',
	'catedit_ok'					=> 'Edited success',
	'sort_order'					=> 'Please enter the sort number',
	'drop_cat_confirm'				=> 'Are you sure you want to delete this Article Category?',
	'tips'							=> 'Reminder：',
	'choose_time'					=> 'Please select the time',
	'batch_issue_confirm'			=> 'Are you sure you want to bulk release the selected article?',
	'select_article_msg'			=> 'Please select to batch publish articles',
	'batch_cancel_confirm'			=> 'Are you sure you want to bulk unpublish the selected article?',
	'select_cancel_article'			=> 'Please select the batch you want to unpublish articles',
	'search' 						=> 'Search',
	'article_keywords'				=> 'Please enter the keyword of the article name',
	'select_issue_time'				=> 'Edit release time',
	'select_cancel_time'			=> 'Edit cancel time',
	'cancel_confirm'				=> 'Are you sure you want to revoke this article?',
	'link_goods_tip'				=> 'Search to be related to the goods, search to the goods will be displayed in the left list box. Click on the left side of the list of options, the associated goods can be entered on the right side of the list has been associated. Save after entry into force. You can also edit the associated mode on the right side.',
	'screen_search_goods'			=> 'Screen search for goods information',
	'no_content'					=> 'No content',
	'add_time' 						=> 'Add time',
	'related_download'				=> 'Related Download',
	'total'							=> 'Total',
	'piece'							=> 'piece',
	'drop_article_confirm'			=> 'Are you sure you want to delete this help article?',
	'time_format_error'				=> 'Time format is not correct',
	'article_name_is'				=> 'Article name is ',
	
	'article_manage'		=> 'Article',
	'article_list'			=> 'Article List',
	'shop_help'		  		=> 'Shop Help',
	'shop_info'				=> 'Shop Information',
	'article_auto_release'	=> 'Published Article Automatically',
	'article_add_update'	=> 'Article Add / Update',
	'article_remove'		=> 'Article Delete',
	'cat_add_update'		=> 'Category Add / Update',
	'cat_remove'			=> 'Category Delete',
	'shopinfo_manage'		=> 'Shop Information Management',
	'shophelp_manage'		=> 'Shop Help Manage',
	'article_auto_manage'	=> 'Automatic Article Management',
	'article_auto_update'	=> 'Automatic Update Article',
	'article_auto_delete'	=> 'Automatic Delete Article',
	'invalid_parameter'		=> 'Invalid parameter',
	
	//help
	'overview'				=> 'Overview',
	'more_info'				=> 'More information:',
	
	//文章帮助
	'article_list_help'		=> 'Welcome to ECJia intelligent background articles list page, the system will display all the articles in this list.',
	'about_article_list'	=> 'About the list of articles help document',
	'add_article_help'		=> 'Welcome to ECJia intelligent add background article page, you can add the article information on this page.',
	'about_add_article'		=> 'About add articles help document',
	'edit_article_help'		=> 'Welcome to ECJia intelligent background edit posts page, you can edit the article information on this page.',
	'about_edit_article'	=> 'About edit articles help document',
	'preview_article_help'	=> 'Welcome to ECJia intelligent article page preview, you can preview Base information here.',
	'about_preview_article'	=> 'About previewing articles help document',
	'link_goods_help'		=> 'Welcome to ECJia intelligence related product page, you can edit the corresponding related product information on this page.',
	'about_link_goods'		=> 'About related products help document',
	
	//文章分类
	'cat_name_required'		=> 'Please enter the name of the article category!',
	
	//文章分类帮助
	'article_cat_help'		=> 'Welcome to ECJia intelligent background articles category page, the system will display all the articles in this list.',
	'about_article_cat'		=> 'About articles category help document',
	'add_cat_help'			=> 'Welcome to ECJia intelligent background add article category page, you can add articles category information on this page.',
	'about_add_cat'			=> 'About add article category help document',
	'edit_cat_help'			=> 'Welcome to ECJia intelligent background editing articles category page, you can Base category information on this page editor.',
	'about_edit_cat'		=> 'About edit article category help document',
	
	'shophelp_title_required' => 'Please enter the help article title!',
	
	//网店帮助
	'shophelp_help'			=> 'Welcome to ECJia intelligence background help shop list page, the system will display all of the shop to help in this list.',
	'about_shophelp'		=> 'About shop help list help document',
	'shophelp_article_help'	=> 'Welcome to ECJia intelligence background help articles list page, under the classification system specified in the shop help articles will appear in this list.',
	'about_shophelp_article'=> 'About shop help articles help document',
	'add_shophelp_help'		=> 'Welcome to ECJia intelligent help articles add background page, you can add the information in this article help page.',
	'about_add_shophelp'	=> 'About add help articles help document',
	'edit_shophelp_help'	=> 'Welcome to ECJia intelligence background help edit the article page, you can edit the information in this article help page.',
	'about_edit_shophelp'	=> 'About edit help articles help document',
	
	'shopinfo_title_required' => 'Please enter a shop title!',
	
	//网店信息
	'shopinfo_help'			=> 'Welcome to ECJia intelligence background shop information pages, the system will display all shop information in this list.',
	'about_shopinfo'		=> 'About shop information help document',
	'add_shopinfo_help'		=> 'Welcome to ECJia intelligence background shop add background information pages, you can add shop information on this page.',
	'about_add_shopinfo'	=> 'About add shop information help document',
	'edit_shopinfo_help'	=> 'Welcome back to edit ECJia smart shop information page, you can edit the corresponding shop information on this page.',
	'about_edit_shopinfo'	=> 'About edit shop information help document',
	
	'js_lang' => array(
		'select_moved_article'		=> 'Please select the batch you need to transferred articles',
		'article_title_required'	=> 'Please enter the title of the article!',
		'back_select_term'			=> 'Return to select column',
		'select_goods_empty'		=> 'Not search for goods information',
		'editable_miss_parameters'	=> 'editable parameters missing',
		'edit_info'					=> 'Edit information',
		'operate_selected_confirm'  => 'Are you sure you want to operate all of the selected items?',
		'noSelectMsg'				=> 'Please select the action items!',
		'batch_miss_parameters'		=> 'Batch operations missing parameters!',
		'ok'						=> 'OK',
		'cancel'					=> 'Cancel',
	    'select_time' 			    => 'Please select the time',
	),
	
	'cat_manage'	=>	'articel category manage'
);

//end