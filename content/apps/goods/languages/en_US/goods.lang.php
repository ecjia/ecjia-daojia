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
 * ECJIA 管理中心起始页语言文件
 */
return array(
	'edit_goods' 			=> 'Edit goods',
	'copy_goods' 			=> 'Copy goods',
	'continue_add_goods' 	=> 'Continue to add goods',
	'back_goods_list' 		=> 'Return to goods list',
	'add_goods_ok' 			=> 'Add goods success',
	'edit_goods_ok' 		=> 'Edit success',
	'trash_goods_ok' 		=> 'Move to recycle bin success',
	'restore_goods_ok' 		=> 'Restore success',
	'drop_goods_ok' 		=> 'Delete success',
	'batch_handle_ok' 		=> 'Batch operations success',
	'drop_goods_confirm'	=> 'Are you sure delete the goods?',
	'batch_drop_confirm'	=> 'All related goods will be deleted if you thorough delete the pruduct!',
	'trash_goods_confirm'	=> 'Are you sure move the goods to recycle bin?',
	'batch_trash_confirm'	=> 'Are you sure move the checked goods to recycle bin?',
	'trash_product_confirm'	=> 'Are you sure you take the goods removed?',
	'restore_goods_confirm' => 'Are you sure restore the goods?',
	'batch_restore_confirm' => 'Are you sure restore the checked goods?',
	'batch_on_sale_confirm' => 'Are you sure set the checked goods as on sale?',
	'batch_not_on_sale_confirm' => 'Are you sure cancel the checked on sale goods?',
	'batch_best_confirm'	=> 'Are you sure set the checked goods as best?',
	'batch_not_best_confirm'=> 'Are you sure cancel the checked best goods?',
	'batch_new_confirm'		=> 'Are you sure set the checked goods as new?',
	'batch_not_new_confirm'	=> 'Are you sure cancel the checked new goods?',
	'batch_hot_confirm'		=> 'Are you sure set the checked goods as hot?',
	'batch_not_hot_confirm'	=> 'Are you surecancel the checked hot goods?',
	'cannot_found_goods' 	=> 'Don\'t find appointed goods.',
	'sel_goods_type' 		=> 'Please choose the type of goods',
	'sel_goods_suppliers' 	=> 'Please select the suppliers',
	
	/*------------------------------------------------------ */
	//-- The picture processing is related to hint an information
	/*------------------------------------------------------ */
	'no_gd' 				=> 'Your server nonsupport GD or didn\'t install to operate the picture type to expand a database perhaps.',
	'img_not_exists' 		=> 'Don\'t find out an original picture, create thumbnail failure.',
	'img_invalid' 			=> 'Create thumbnail failure, because you upload an invalid picture file.',
	'create_dir_failed' 	=> 'The images file clip and can\'t write, create thumbnail failure.',
	'safe_mode_warning' 	=> 'Your server circulate under the safe mode, and %s directory nonentity. Your needing probably to establish a directory in advance then can upload a picture.',
	'not_writable_warning' 	=> 'The %s directory can\'t be wrote, you need to config the directory as writable then can upload a picture.',
	
	/*------------------------------------------------------ */
	//-- Product list
	/*------------------------------------------------------ */
	'goods_cat' 	=> 'All Categories',
	'goods_brand' 	=> 'All Brands',
	'intro_type' 	=> 'All',
	'keyword' 		=> 'Keywords',
	'is_best' 		=> 'Best',
	'is_new' 		=> 'New',
	'is_hot' 		=> 'Hot',
	'is_promote' 	=> 'Sales promotion',
	'all_type'		=> 'All recommend',
	'sort_order' 	=> 'Sort',
	
	'goods_name' 	=> 'Name',
	'goods_sn' 		=> 'Sn',
	'shop_price' 	=> 'Price',
	'is_on_sale' 	=> 'On sale',
	'goods_number' 	=> 'Stock',
	
	'copy' 			=> 'Copy',
	'product_list'	=> 'Product list',
	
	'integral' 		=> 'Points limit',
	'on_sale' 		=> 'On sale',
	'not_on_sale' 	=> 'Not on sale',
	'best' 			=> 'Best product',
	'not_best' 		=> 'Cancel best product',
	'new' 			=> 'New product',
	'not_new' 		=> 'Cancel new product',
	'hot' 			=> 'Hot product',
	'not_hot' 		=> 'Cancel hot product',
	'move_to' 		=> 'Move to category',
	
	// ajax
	'goods_name_null' 		=> 'Please enter goods name.',
	'goods_sn_null' 		=> 'Please enter goods sn.',
	'shop_price_not_number' => 'Price must be a figure.',
	'shop_price_invalid' 	=> 'You have entered an illegal market price.',
	'goods_sn_exists' 		=> 'The goods sn already exist, please change a number.',
	
	/*------------------------------------------------------ */
	//-- Add /edit a product information
	/*------------------------------------------------------ */
	'tab_general' 		=> 'Brief',
	'tab_detail' 		=> 'Details',
	'tab_mix' 			=> 'Others',
	'tab_properties' 	=> 'Attribute',
	'tab_gallery'		=> 'Gallery',
	'tab_linkgoods' 	=> 'Relational goods',
	'tab_groupgoods' 	=> 'Accessories',
	'tab_article' 		=> 'Relational articles',
	
	'lab_goods_name' 	=> 'Name:',
	'lab_goods_sn' 		=> 'Sn:',
	'lab_goods_cat' 	=> 'Category:',
	'lab_other_cat' 	=> 'Extend category:',
	'lab_goods_brand' 	=> 'Brand:',
	'lab_shop_price' 	=> 'Shop price:',
	'lab_market_price' 	=> 'Market price:',
	'lab_user_price' 	=> 'User price:',
	'lab_promote_price' => 'Price:',
	'lab_promote_date' 	=> 'Date:',
	'lab_picture' 		=> 'Upload picture:',
	'lab_thumb' 		=> 'Upload thumbnail:',
	'auto_thumb' 		=> 'Create thumbnail automatically',
	'lab_keywords' 		=> 'Keywords:',
	'lab_goods_brief' 	=> 'Brief:',
	'lab_seller_note' 	=> 'Shop notice:',
	'lab_goods_type' 	=> 'Goods type：',
	'lab_picture_url' 	=> 'Merchandise picture external URL',
	'lab_thumb_url' 	=> 'External merchandise Thumbnail URL',
	
	'lab_goods_weight' 		=> 'Weight:',
	'unit_g' 				=> 'Gram',
	'unit_kg' 				=> 'Kilogram',
	'lab_goods_number' 		=> 'Stock quantity:',
	'lab_warn_number' 		=> 'Stock warning quantity:',
	'lab_integral' 			=> 'Integral purchase amount:',
	'lab_give_integral' 	=> 'Consumption presented a few points:',
	'lab_rank_integral' 	=> 'Presented a number of grade points:',
	'lab_intro' 			=> 'Recommend:',
	'lab_is_on_sale' 		=> 'On sale:',
	'lab_is_alone_sale' 	=> 'Common goods:',
	'lab_is_free_shipping' 	=> 'Free shipping:',

	'compute_by_mp' 		=> 'Calculate',
	'notice_goods_sn' 		=> 'If you don\'t enter product sn, the system will create unique sn automatically.',
	'notice_integral' 		=> '（This required amount）Buy the goods can use points.',
	'notice_give_integral' 	=> 'Purchase the merchandise when presented fraction of consumption, express -1 presented by commodity prices',
	'notice_rank_integral' 	=> 'Purchase the merchandise when presented fraction grading, express -1 presented by commodity prices',
	'notice_seller_note' 	=> 'Only provide information for shop owner.',
	'notice_storage' 		=> 'Inventories of goods for the virtual goods or commodities when there is non-editable state of goods, inventory value depends on its quantity or volume of goods virtual goods',
	'notice_keywords' 		=> 'Divided by blank character.',
	'notice_user_price' 	=> 'Member price is -1, said member prices Member grade discount rate. You can also specify a hierarchy for each fixed-price',
	'notice_goods_type' 	=> 'Please select the type of the goods, then complete the attributes of the goods',
	
	'on_sale_desc' 			=> 'Checked means it can be allowed to sale, otherwise can be disallowed to sale.',
	'alone_sale'			=> 'Checked means it can be sold as common product, otherwise can be sold as accessories or gifts.',
	'free_shipping'			=> 'Checked means it can shipped free, otherwise as regular.',
	
	'invalid_goods_img' 	=> 'Goods picture format inaccuracy!',
	'invalid_goods_thumb' 	=> 'Goods thumbnail format inaccuracy!',
	'invalid_img_url' 		=> 'Goods gallery the %s picture format inaccuracy!',
	
	'goods_img_too_big' 	=> 'Goods picture file is too big(the biggest value: %s), can\'t upload.',
	'goods_thumb_too_big' 	=> 'Goods thumbnail file is too big(the biggest value: %s), can\'t upload.',
	'img_url_too_big'		=> 'Goods gallery in the %s picture file is too big(the biggest value: %s), can\'t upload.',
	
	'integral_market_price' => 'Take integral',
	'upload_images' 		=> 'Upload a picture',
	'spec_price' 			=> 'Attribute price',
	'drop_img_confirm' 		=> 'Are you sure delete the picture?',
	
	'select_font' 		=> 'Font Style',
	'font_styles' 		=> array('strong' => 'Bold', 'em' => 'Italic', 'u' => 'Underline', 'strike' => 'Strike Through'),
	
	'rapid_add_cat' 	=> 'Add category',
	'rapid_add_brand' 	=> 'Rapid add brand',
	'category_manage' 	=> 'Category manage',
	'brand_manage' 		=> 'Brand manage',
	'hide' 				=> 'Hide',
	
	'lab_volume_price' 			=> 'Goods favourable price：',
	'volume_number' 			=> 'Volume No.',
	'volume_price' 				=> 'Sale price',
	'notice_volume_price' 		=> 'Purchase quantity discount when the total number of preferential prices',
	'volume_number_continuous' 	=> 'Repeat quantity discount!',
	
	'label_suppliers' 	=> 'Choice of supplier:',
	'suppliers_no' 		=> 'Do not specify a supplier of goods belonging to our',
	'suppliers_move_to' => 'Transferred to the supplier',
	'lab_to_shopex' 	=> 'Transferred to the Shop',
	
	/*------------------------------------------------------ */
	//-- Connection product
	/*------------------------------------------------------ */
	
	'all_goods' 	=> 'Choose product',
	'link_goods' 	=> 'Relational products',
	'single' 		=> 'Single',
	'double' 		=> 'Double',
	'all_article' 	=> 'Choose product',
	'goods_article' => 'Relational articles',
	'top_cat' 		=> 'Top Categories',
	
	/*------------------------------------------------------ */
	//-- Combine a product
	/*------------------------------------------------------ */
	
	'group_goods' 	=> 'Accessories',
	'price' 		=> 'Price',
	
	/*------------------------------------------------------ */
	//-- Product gallery
	/*------------------------------------------------------ */
	
	'img_desc' 	=> 'Description',
	'img_url' 	=> 'Upload a file',
	'img_file' 	=> 'or input the url of the image',
	
	/*------------------------------------------------------ */
	//-- Connection article
	/*------------------------------------------------------ */
	'article_title' 			=> 'Article title',
	'goods_not_exist' 			=> 'The product doesn\'t exist. ',
	'goods_not_in_recycle_bin' 	=> 'The product can\'t be deleted until it is removed to recycle bin.',
	
	'js_lang' => array(
		'cat_name_required'		=> 'Please enter a type name',
		'attr_name_required'	=> 'Please enter the attribute name',
		'cat_id_select'			=> 'Please select the relevant product type',
		'old_key_required'		=> 'Please enter the original encrypted string!',
		'new_key_required'		=> 'Please enter a new encryption string!',
		'separator_required'	=> 'Separator can not be empty!',
		'brand_name_required'	=> 'Please enter a brand name',
		'select_goods_attr'		=> 'Choose filter property',
		'category_name_required'=> 'Please enter a category name',
		'add_new_mate'			=> 'Add new section',
		'back_select_mate'		=> 'Back select columns',
		'transfer_confirm'		=> 'Are you sure you transfer under the classification of goods it?',
		'ok'					=> 'OK',
		'cancel'				=> 'Cancel',
		'choose_select_goods'	=> 'Please select the need to transfer goods',
		'give_up_confirm'		=> 'Are you sure you give up the contents of the current page editor?',
		'not_calculate'			=> 'Not calculate',
		'goods_name_required'	=> 'Please enter the name of the goods!',
		'shop_price_required'	=> 'Please enter the goods price!',
		'shop_price_limit'		=> 'Please enter the correct price format!',
		'goods_number_required'	=> 'Please enter the goods inventory!',
		'goods_number_limit'	=> 'Goods inventory can only be 0!',
		'category_id_select'	=> 'Please select a goods category!',
		'product_sn_required'	=> 'Please enter a number.',
		'product_number_required' => 'Please enter stock',
		'select_goods_empty'	=> 'Not search for goods information',
		'change_connect'		=> 'Switch',
		'single' 				=> 'Single',
		'double' 				=> 'Double',
		'modify_price'			=> 'Modify the price',
		'save'					=> 'Save',
		'price'					=> 'Price',
		'select_article_empty'	=> 'Not search for article information',
		'drag_here_upload'		=> 'Drag here to upload pictures',
		'select_operate_options'=> 'Please select the options you want to operate',
		'card_sn_required'		=> 'Please enter the card number',
		'card_password_required'=> 'Please enter a card password',
		'pls_upload_file'		=> 'Please upload file',
		'pls_select'            => 'Please select...',
		'brand_name_empty'      => 'Brand name cann\'t be empty',
		'cat_name_empty'		=> 'Category name cann\'t be empty',
		'add_goods_ok' 			=> 'Add goods success',
	),
	
	/* 虚拟卡 */
	'card' 				=> 'See the virtual card information',
	'replenish' 		=> 'Replenishment',
	'batch_card_add' 	=> 'Batch replenishment',
	'add_replenish' 	=> 'Add a virtual secret card',
	'goods_number_error'=> 'Merchandise inventory quantity errors',
	
	/*------------------------------------------------------ */
	//-- 货品
	/*------------------------------------------------------ */
	'product' 					=> 'Goods',
	'product_info' 				=> 'Item Information',
	'specifications' 			=> 'Specifications',
	'total' 					=> 'Total:',
	'add_product' 				=> 'Add Item',
	'save_products' 			=> 'Save the success of goods',
	'product_id_null' 			=> 'Goods id is empty',
	'cannot_found_products' 	=> 'Specified items not found',
	'product_batch_del_success' => 'Remove the success of bulk goods',
	'product_batch_del_failure' => 'Goods bulk delete failed',
	'batch_product_add' 	=> 'Bulk Add',
	'batch_product_edit' 	=> 'Batch Edit',
	'products_title' 		=> 'Product Name:%s',
	'products_title_2' 		=> 'Item:%s',
	'good_shop_price' 		=> '(Price:%d)',
	'good_goods_sn' 		=> '(Product Code:%s)',
	'exist_same_goods_sn' 	=> 'Item No. Item and products are not allowed to repeat',
	'exist_same_product_sn' => 'No duplication of goods',
	'cannot_add_products' 	=> 'Add a failure of goods',
	'exist_same_goods_attr' => 'Item Specifications Property repeat',
	'cannot_goods_number' 	=> 'Item Specifications Property repeat',
	'not_exist_goods_attr' 	=> 'This product does not exist specifications, please add the size of their',
	'goods_sn_exists' 		=> 'The goods_sn you entered already exists',
	'edit_product'			=> 'Edit product',
	'edit_product_sn'		=> 'Edit product sn',
	'edit_product_number'	=> 'Edit product number',
	
	//追加
	'same_attrbiute_goods' 	=> 'The same %s products.',
	'promotion_time' 		=> 'promotion time from %s to %s, please hurry up!',
	'goods_attr' 			=> 'Attribute',
	'drop_success'			=> 'Delete successfully',
	'goods_list'			=> 'Goods List',
	'edit_goods_photo'		=> 'Edit Goods Photo Album',
	'add_goods_photo'		=> 'Add Goods Photo Album',
	'tab_product'			=> 'Product manage',
	'parameter_missing'		=> 'Parameter missing',
	'upload_success'		=> 'Upload success',
	'edit_success'			=> 'Edit success',
	'edit_fail'				=> 'Edit Failed',
	'save_sort_ok'			=> 'Save Sort success',
	'goods_photo_notice'	=> '(Editing, sorting, deleting)',
	'goods_photo_help'		=> 'Click on the "Save sort" sorted',
	'ok'					=> 'OK',
	'cancel'				=> 'Cancel',
	'save'					=> 'Save',
	'move'					=> 'Move',
	'no_title'				=> 'No title',
	'save_sort'				=> 'Save sort',
	'drop_photo_confirm'	=> 'Are you sure you want to delete this photo album?',
	'no_goods'				=> 'Not detected this commodity',
	'return_last_page'		=> 'Return to the last page',
	'goods_preview'			=> 'Goods Preview',
	'goods_edit'			=> 'Goods edit',
	'goods_recycle'			=> 'Goods Trash',
	'edit_virtual_goods'	=> 'Edit virtual goods',
	'copy_virtual_goods'	=> 'Copy virtual goods',
	'pls_choose_operate'	=> 'Select Options',
	'edit_ok'				=> 'Successfully modified',
	'toggle_on_sale'		=> 'You have successfully switched Added state',
	'toggle_best'			=> 'You have successfully switched Recommended status',
	'toggle_new'			=> 'New products have successfully switched state',
	'toggle_hot'			=> 'Successfully selling recommend switching state',
	'lost_parameter'		=> 'Missing parameters, please try again',
	'add_attr_first'		=> 'Please add inventory property, and then set the goods stock goods management',
	'product_sn_exsits'		=> 'Article Number repeat',
	'property_not_empty'	=> 'Property can not be empty',
	'goods_name_is'			=> 'Goods name is ',
	'product_sn_is'			=> 'Number of goods ',
	'edit_goods_desc'		=> 'Edit Goods Description',
	'add_goods_desc'        => 'Add Goods Description',
	'canot_find_goods'		=> 'Can not find the ID for the %s goods!',
	'edit_goods_attr'		=> 'Edit Goods Attribute',
	'add_goods_attr'		=> 'Add Goods Attribute',
	'edit_attr_success'		=> 'Edit attribute success',
	'edit_link_goods'		=> 'Edit Related Goods',
	'add_link_goods'		=> 'Add Related Goods',
	'edit_link_parts'		=> 'Edit Related Parts',
	'add_link_parts'		=> 'Add Related Parts',
	'edit_link_article'		=> 'Edit Related Article',
	'add_link_article'		=> 'Add Related Article',
	
	'goods_count_info'		=> 'Commodity Statistics',
	'goods_total'			=> 'Total number of goods',
	'warn_goods_number'		=> 'Inventory warning',
	'new_goods_number'		=> 'Number of new products',
	'best_goods_number'		=> 'Recommended number of products',
	'hot_goods_number'		=> 'Hot commodity number',
	'promote_goods_numeber'	=> 'Promotional merchandise count',
	
	'discard_changes'		=> 'Do you want to drop this page?',
	'as_goods'				=> 'As commodity',
	'seo'					=> 'SEO optimization',
	'remark_info'			=> 'Remark information',
	'update'				=> 'Update',
	'issue'					=> 'Relesae',
	'choose_goods_cat'		=> 'Select product categories',
	'select_cat_first'		=> 'Please select the type of goods',
	'select_extend_cat'		=> 'Select extended classification',
	'add_cat'				=> 'Add categorie',
	'select_goods_brand'	=> 'Choose brand',
	'add_brand'				=> 'Add brand',
	'goods_image'			=> 'Product picture',
	'goods_thumb'			=> 'Product Thumbnail:',
	'thumb_img_notice'		=> 'Click to replace the goods or merchandise image thumbnails.',
	'promote_price'			=> 'Discounts, promotional price',
	'add_promote_price'		=> 'Add deals',
	'promotion_info'		=> 'Promotions',
	'integral_about'		=> 'Related points',
	'id_or_sn'				=> 'Please enter the article ID or Num.',
	'search'				=> 'Search',
	'product_information'	=> 'product information',
	
	'add_time'				=> 'add time:',
	'last_update'			=> 'latest update:',
	'link_parts_notice'		=> 'To search for related parts, accessories search to appear on the left list box. Click on the left list of options and accessories to go to the right of the linked list. Effect after save. You can also edit the associated parts in the right price.',
	'filter_goods_info'		=> 'Filter to product information',
	'no_content'			=> 'No content yet',
	'edit_price'			=> 'Modify the price',
	
	'link_goods_notice'		=> 'To search for related merchandise, merchandise search to appear on the left list box. Click on the left side of the list option, you can enter the right side of the trade association linked list. Effect after save. You can also edit the right of association mode.',
	'switch_relation'		=> 'Switch relation',
	
	'link_article_notice'	=> 'To search for related articles, article search to appear on the left list box. Click on the left side of the list option, you can enter the right side of the associated article linked list. Effect after save.',
	'filter_article_info'	=> 'Filter to Article',
	
	'batch_handle'			=> 'Batch Operations',
	'restore_confirm'		=> 'Are you sure you want to restore the product from the recycle bin?',
	
	'select_goods_msg'		=> 'Please select item to be operated',
	'enter_keywords'		=> 'Please enter goods keywords',
	'restore'				=> 'Restore',
	'move_to_cat'			=> 'Transfer goods to classification',
	'move_confirm'			=> 'Will the selected items be transferred to classification?',
	'select_move_goods'		=> 'Please select the goods to be transferred',
	'start_move'			=> 'Began to shift',
	'is_on_saled'			=> 'On the shelves',
	'not_on_saled'			=> 'Not on the shelves',
	'move_to_trash'			=> 'Move to recycle bin',
	
	'select_trash_goods'	=> 'Please choose to move to the recycle bin.',
	'select_sale_goods'		=> 'Please select the goods to be on the shelves',
	'select_not_sale_goods'	=> 'Please choose the goods under the shelf.',
	'select_best_goods'		=> 'Please choose to set as a boutique goods',
	'select_not_best_goods'	=> 'Please choose to cancel the quality of goods',
	'select_new_goods'		=> 'Please choose to set for new products',
	'select_not_news_goods' => 'Please choose to cancel the new product',
	'select_hot_goods'		=> 'Please choose to be a hot commodity.',
	'select_not_hot_goods'	=> 'Please choose to cancel the sale of goods',
	
	'filter'				=> 'Filter',
	'thumb'					=> 'Thumbnail',
	'preview'				=> 'Preview',
	'card_info'				=> 'Virtual card information',
	'enter_goods_sn'		=> 'Please enter the goods sn',
	'enter_goods_price'		=> 'Please enter the goods price',
	'enter_sort_order'		=> 'Please enter the sort number',
	'enter_goods_number'	=> 'Please enter the number of inventory',
	'enter_goods_keywords'	=> 'Please enter goods keywords',
	'product_attr_repeat'   => 'The product attribute cannot be repeated',
	'product_sn_error'      => 'The product sn cannot be repeated',
	
	'upload_goods_image_error'	=> 'Goods image path is invalid',
	'copy_gallery_image_fail'	=> 'Goods photo album copy failed',
	'upload_thumb_error'		=> 'Goods thumbnail path invalid',
	'free'						=> 'Free',
	'label_as_goods'			=> 'As goods:',
	'label_keywords'			=> 'Keywords:',
	'category'					=> 'Category',
	'brand'						=> 'Brand',
	
	'goods_manage'			=> 'Goods',
	'add_new_goods'			=> 'Add Goods',
	'goods_type'			=> 'Goods Types',
	'goods_booking'			=> 'Out Of Stock Registration',
	'virtual_goods_list'	=> 'Virtual Goods List',
	'add_virtual_goods'		=> 'Add Virtual Goods',
	'encrypted_string'		=> 'Encrypted string',
	'virtual_card_change' 	=> 'Change Encryption String',
	'goods_auto'			=> 'Automatic Release Of Goods',
	'goods_add_update'		=> 'Goods Add / Edit',
	'remove_back'			=> 'Goods Recycling / Recovery',
	'drop_goods'			=> 'Goods Completely Remove',
	'cat_manage'			=> 'Category Add / Edit',
	'cat_drop'				=> 'Category Transfer / Delete',
	'attr_manage'			=> 'Goods Property Management',
	'goods_brand_manage'	=> 'Brand Management',
	'goods_auto_update'		=> 'Goods Update Automatic Loading Rack',
	'goods_auto_delete'		=> 'Goods Automatic Loading Rack Deleted',
	'virualcard_manage'		=> 'Virtual Card Management',
	'picture_batch'			=> 'Image Batch Processing',
	'goods_export'			=> 'Goods Batch Export',
	'goods_batch'			=> 'Goods Upload / Modify',
	'gen_goods_script'		=> 'Generate Product Code',
	'invalid_parameter'		=> 'Invalid parameter',
	'batch_start'			=> 'Batch shelves',
	'batch_end'				=> 'Batch lower frame',
	'quick_add_cat'			=> 'Quick add category',
	'quick_add_cat_help'	=> 'As already Select a product category is added to the sub-class, otherwise the top category',
	'quick_add_brand'		=> 'Quickly add brand',
	'next_step'				=> 'Next step',
	'complete'				=> 'Complete',
	
    'overview'              => 'Overview',
    'more_info'             => 'More information:',
	
	'goods_gallery_help'	=> 'Welcome to ECJia intelligent background commodity album page, the system all the goods images are displayed on this page.',
	'about_goods_gallery'	=> 'About goods photo albums to help document',
	
	'goods_list_help'		=> 'Welcome to ECJia intelligent background goods list page, the system will display all the items in this list.',
	'about_goods_list'		=> 'About the goods List help document',
	
	'goods_preview_help'	=> 'Welcome to ECJia intelligent background goods preview page, this page can preview all the details about the goods.',
	'about_goods_preview'	=> 'About preview goods help document',
	
	'goods_trash_help'		=> 'Welcome to ECJia intelligent background trash goods page, delete the list of goods in the goods will be placed in the trash, completely remove or restore operation. This page can be goods.',
	'about_goods_trash'		=> 'About the goods recycle bin help document ',
	
	'add_goods_help'		=> 'Welcome to ECJia intelligent background to add goods page, you can add goods information on this page.',
	'about_add_goods'		=> 'About add goods help document',
	
	'edit_goods_help'		=> 'Welcome to ECJia intelligent background edit goods pages, this can be edited on the corresponding goods.',
	'about_edit_goods'		=> 'About edit goods help document',
	
	'copy_goods_help'		=> 'Welcome to ECJia intelligent background copy goods pages, you can modify any items that have been copied by the information page.',
	'about_copy_goods'		=> 'About copy goods help document',
	
	'edit_attr_help'		=> 'Welcome to ECJia intelligent background goods attributes page, you can attribute this to the relevant items for editing.',
	'about_edit_attr'		=> 'About edit goods attributes help document',
	
	'edit_link_goods_help'	=> 'Welcome to ECJia intelligence background related goods page, you can here the corresponding goods linked operation.',
	'about_edit_link_goods'	=> 'About related goods help document',
	
	'edit_link_parts_help'	=> 'Welcome to ECJia intelligent background backstage goods related accessories page, you can here the corresponding goods related accessories operation.',
	'about_edit_link_parts'	=> 'About related goods help document',
	
	'edit_link_article_help'	=> 'Welcome to ECJia intelligent background backstage goods related story page, you can here the corresponding article related goods operations.',
	'about_edit_link_article'	=> 'About related articles help document',
	
	
	'goods_update' 	=>'Update goods',
	'goods_delete' 	=>'Remove goods',
	'remove_back'	=>'Goods trash/restore',
	
	'category_update'	=>'Update category',
	'category_move'		=>'Category move',
	'category_delete'	=>'Remove category',
	
	'goods_type_update'=>'Update goods type',
	'goods_type_delete'=>'Remove goods type',
	
	'brand_update' 	=> 'Update brand',
	'brand_delete' 	=> 'Remove brand',
	
	'attr_update'	=> 'Update goods attributes',
	'attr_delete'	=> 'Remove goods attributes',
	
	'business_name'=>'Business',
	'check_goods'=>'Check',
);

// end