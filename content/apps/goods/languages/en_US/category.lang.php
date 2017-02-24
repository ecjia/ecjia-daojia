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
 * ECJIA 商品分类管理语言文件
 */
return array(
	/* Commodity category field information */
	'goods_category'=> 'Goods Category',
	'cat_id' 		=> 'ID',
	'cat_name' 		=> 'Name',
	'isleaf' 		=> 'Disallow',
	'noleaf' 		=> 'Allow',
	'keywords' 		=> 'Keywords',
	'cat_desc' 		=> 'Description',
	'parent_id' 	=> 'Parent',
	'sort_order' 	=> 'Sort',
	'measure_unit' 	=> 'Quantity unit',
	'delete_info' 	=> 'Delete checked',
	'category_edit' => 'Edit Category',
	'move_goods' 	=> 'Move Goods',
	'cat_top' 		=> 'Root',
	'show_in_nav' 	=> 'Display in navigation',
	'cat_style' 	=> 'Style sheet document classification',
	'is_show' 		=> 'Whether display',
	'show_in_index' => 'Is set to recommend home',
	'notice_show_in_index' => 'This setting can be the latest in the home, hot, Department recommend that the classification of merchandise under Recommend',
	'goods_number' 	=> 'Goods number',
	'grade' 		=> 'Price range of the number of',
	'notice_grade' 	=> 'This option indicates that the classification of merchandise under the lowest and the highest price level of the division between the number of express no grading fill 0',
	'short_grade' 	=> 'Prices rating',
	
	'nav' 			=> 'Navigation',
	'index_new' 	=> 'Latest',
	'index_best'	=> 'Boutique',
	'index_hot' 	=> 'Top',
	
	'back_list' 	=> 'Return to goods category',
	'continue_add' 	=> 'Continue to add category',
	'notice_style' 	=> 'You can for each classification of merchandise to specify a style sheet document. For example, documents stored in the themes directory then enter:themes/style.css',
	
	/* Prompting message */
	'catname_empty' => 'Please enter a category name!',
	'catname_exist' => 'The category name already exists.',
	"parent_isleaf" => 'The category can\'t be the bottom class category!',
	"cat_isleaf" 	=> 'The category can\'t be deleted, because it isn\'t the bottom class category or some product already exists.',
	"cat_noleaf" 	=> 'There are still subcategories, so you can\'t modify category for the bottom class!',
	"is_leaf_error" => 'The selected higher category can\'t be lower category of current category!',
	'grade_error' 	=> 'Quantity price classification can only be an integer within 0-10',
	
	'catadd_succed' 	=> 'Add category success!',
	'catedit_succed' 	=> 'Edit category success!',
	'catdrop_succed' 	=> 'Delete category success!',
	'catremove_succed' 	=> 'Move category success!',
	'move_cat_success' 	=> 'Move category has finished!',
	
	'cat_move_desc' 	=> 'What is move category?',
	'select_source_cat' => 'Please select category that you want to move.',
	'select_target_cat' => 'Please select category that the target.',
	'source_cat' 		=> 'From that category',
	'target_cat' 		=> 'Move to',
	'start_move_cat' 	=> 'Submit',
	'cat_move_notic' 	=> 'In add product or pruduct management, if you want to change products category, you can manage the products category by the function.',
	'cat_move_empty' 	=> 'Please select category rightly!',
	
	'sel_goods_type' 	=> 'Please choose the type of merchandise',
	'sel_filter_attr' 	=> 'Please select filter property',
	'filter_attr' 		=> 'Filter property',
	'filter_attr_notic' => 'Filter property page to the previous classification of merchandise selection',
	'filter_attr_not_repeated' => 'Filter property can`t be repeated',
	
	/*JS language item*/
	'js_languages' => array(
		'catname_empty' => 'Category name can\'t be blank!',
		'unit_empyt' 	=> 'Unit of quantity can\'t be blank!',
		'is_leafcat' 	=> "You selected category is a bottom class category. \\nThe higher category of new category can\'t be a bottom class category.",
		'not_leafcat' 	=> " You selected category isn\'t a bottom class category. \\nThe category of product transfer can just be operated between the bottom class categories.",
		'filter_attr_not_repeated' => 'Filter property can`t be repeated',
		'filter_attr_not_selected' => 'Please select a filter property',
	),
	
	//追加
	'add_goods_cat'			=> 'Add Category',
	'add_custom_success'	=> 'Add a custom section success',
	'update_fail'			=> 'Missing key parameter update failed',
	'update_custom_success'	=> 'Update successful custom section',
	'drop_custom_success'	=> 'Delete custom section success',
	'sort_edit_ok'			=> 'Sort No. edited successfully',
	'sort_edit_fail'		=> 'Sort number edit fail',
	'number_edit_ok'		=> 'Number of Units edited success',
	'number_edit_fail'		=> 'Number of Units edit fail',
	'grade_edit_ok'			=> 'Prices rating edited success',
	'grade_edit_fail'		=> 'Prices fail grading Edit',
	'drop_cat_img_ok'		=> 'Delete Category image success',
	'use_commas_separate'	=> 'Separated by commas',
	'term_meta'				=> 'Custom sections',
	'edit_term_mate'		=> 'Edit a custom section',
	'name'					=> 'Name',
	'value'					=> 'Value',
	'update'				=> 'Update',
	'remove_custom_confirm'	=> 'Are you sure you want to delete this custom section?',
	'add_term_mate'			=> 'Add a custom section',
	'add_new_mate'			=> 'Add new section',
	'promotion_info'		=> 'Promotions',
	'recommend_index'		=> 'Home recommended',
	'cat_img'				=> 'Category image',
	'select_cat_img'		=> 'Select category picture',
	'edit_cat_img'			=> 'Modify category photos',
	'drop_cat_img_confirm'	=> 'Are you sure you want to delete this category picture?',
	'tv_cat_img'			=> 'TV- Category Photos',
	'seo'					=> 'SEO optimization',
	'enter_number'			=> 'Please enter the number of units',
	'enter_grade'			=> 'Please enter a price rating',
	'enter_order'			=> 'Please enter a sort number',
	'drop_cat_confirm'		=> 'Are you sure you want to delete this category?',
	'notice'				=> 'Notice:',
	
	'label_cat_name'		=> 'Category name:',
	'label_parent_cat'		=> 'Category parent:',
	'label_measure_unit'	=> 'Quantity unit:',
	'label_grade'			=> 'Price interval number:',
	'label_filter_attr'		=> 'Filter properties:',
	'label_keywords'		=> 'Keyword:',
	'label_cat_desc'		=> 'Category description:',
	'label_edit_term_mate'	=> 'Edit custom columns:',
	'label_add_term_mate'	=> 'Add custom columns:',
	'label_sort_order'		=> 'Sort:',
	'label_is_show'			=> 'Whether display:',
	'label_recommend_index'	=> 'Home recommended:',
	'lab_upload_picture'	=> 'Upload category image:',
	'label_source_cat' 		=> 'From that category:',
	'label_target_cat' 		=> 'Move to:',
	
	'overview'              => 'Overview',
	'more_info'             => 'More information:',
	
	'goods_category_help'	=> 'Welcome to ECJia intelligent background category list page, the system will display all goods category in this list.',
	'about_goods_category'	=> 'About category list help document',
	
	'add_category_help'		=> 'Welcome to ECJia intelligent background add category page, you can add items category Info on this page.',
	'about_add_category'	=> 'About add category help document',
	
	'edit_category_help'	=> 'Welcome to ECJia intelligent background edit category page, you can edit items category Info on this page.',
	'about_edit_category'	=> 'About edit category help document',
	
	'move_category_help'	=> 'Welcome to ECJia intelligent background move category page,  you can transfer goods category operation on this page.',
	'about_move_category'	=> 'About move category help document',
);

// end