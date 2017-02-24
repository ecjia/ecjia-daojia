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
 * ECJIA 商品批量上传、修改语言文件
 */
return array(
	'select_method' => 'Product method:',
	'by_cat' 		=> 'Basis product category, brand',
	'by_sn' 		=> 'Basis product No',
	'select_cat' 	=> 'Category:',
	'select_brand' 	=> 'Brand:',
	'goods_list' 	=> 'List:',
	'src_list' 		=> 'Choose product:',
	'dest_list' 	=> 'Chosen product:',
	'input_sn' 		=> 'Enter product NO:',
	'edit_method' 	=> 'Method:',
	'edit_each' 	=> 'One by one',
	'edit_all' 		=> 'Unify',
	'go_edit' 		=> 'Enter',
		
	'notice_edit' 	=> 'Member price -1 express Member price will be calculated in proportion to Member discounts grading',
	'goods_class' 	=> 'Goods Class',
		
	'g_class' => array(
		G_REAL => 'Real Goods',
		G_CARD => 'Virtual Card',
	),
	
	'goods_sn' 		=> 'NO',
	'goods_name' 	=> 'Name',
	'market_price' 	=> 'Market price',
	'shop_price' 	=> 'Shop price',
	'integral' 		=> 'Purchase Points',
	'give_integral' => 'Free points',
	'goods_number' 	=> 'Stock',
	'brand' 		=> 'Brand',
	'batch_edit_ok' => 'Batch modify successfully.',
	
	'export_format' 	=> 'Data formats',
	'export_ecshop' 	=> 'ecshop to support data formats',
	'export_taobao' 	=> 'taobao Assistant to support data formats',
	'export_taobao46' 	=> 'taobao Assistant4.6 to support data formats',
	'export_paipai' 	=> 'paipai Assistant to support data formats',
	'export_paipai3'	=> 'paipai 3.0 Assistant to support data formats',
	'goods_cat' 		=> 'Category:',
	'csv_file' 			=> 'Upload csv files:',
	'notice_file' 		=> '(The product quantity once upload had better be less than 1000 in CSV file, the CSV file size had better be less than 500K.)',
	'file_charset' 		=> 'Character set:',
	'download_file' 	=> 'Download batch CSV files(%s).',
	
	'use_help' 	=> 'Help:' .
	        '<ol>' .
	          '<Li>According to the usage habit, the download corresponds language of csv file, for example Chinese mainland customers download the simplified Chinese character language file, Hongkong and Taiwan customers download the traditional Chinese language file,</li>' .
	          '<Li>Fill in the csv file, can use the excel or text editor to open a csv file,<br />' .
	              'If "Best product" and so on, fill in numeral 0 or 1, 0 means "NO", 1 mean "YES",<br />' .
	              'Please fill in file name with path for product picture and thumbnail, the path is relative path [root directory]/images/, for example, the picture path is [root catalogue]/images/200610/abc.jpg, fill in 200610/abc.jpg,<br />'.
	              '<font style="color:#FE596A,">If Taobao Assistant cvs encoding format, make sure the code on the site, such as the code is incorrect, you can use editing software transcoding.</font></li>' .
	          '<Li>Upload the product picture and thumbnail to correspond directory, for example:[Root catalogue]/images/200610/,</li>' .
	              '<font style="color:#FE596A,">Please upload pictures of goods and commodities csv file and upload the thumbnails, or picture can not be processed.</font></li>' .
	          '<Li>Select category and file code to upload, upload the csv file.</li>'.
	        '</ol>',
	
	'js_languages' => array(
		'please_select_goods' 	=> 'Please select product.',
		'please_input_sn' 		=> 'Please enter product NO..',
		'goods_cat_not_leaf' 	=> 'Please select bottom class category.',
		'please_select_cat' 	=> 'Please select belong category.',
		'please_upload_file' 	=> 'Please upload batch csv files.',
	),
	
	// Batch upload field of product
	'upload_goods' => array(
		'goods_name' 	=> 'Name',
		'goods_sn' 		=> 'NO.',
		'brand_name' 	=> 'Brand',   // Need to be convert brand_id
		'market_price' 	=> 'Market price',
		'shop_price' 	=> 'Shop price',
		'integral' 		=> 'Points limit for buying',
		'original_img' 	=> 'Original picture',
		'goods_img' 	=> 'Picture',
		'goods_thumb' 	=> 'Thumbnail',
		'keywords' 		=> 'Keywords',
		'goods_brief' 	=> 'Brief',
		'goods_desc'	=> 'Details',
		'goods_weight' 	=> 'Weight(kg)',
		'goods_number' 	=> 'Stock quantity',
		'warn_number' 	=> 'Stock warning quantity',
		'is_best' 		=> 'Best',
		'is_new' 		=> 'New',
		'is_hot' 		=> 'Hot',
		'is_on_sale' 	=> 'On sale',
		'is_alone_sale' => 'Can be a common product sale?',
		'is_real' 		=> 'Entity',
	),
	
	'batch_upload_ok' 		=> 'Batch upload successfully.',
	'goods_upload_confirm' 	=> 'Batch upload confirmation.',
	'batch_choose_goods'	=> 'Batch Select Goods',
	'batch_edit_goods'		=> 'Batch Edit Goods',
	'not_exist_goods'		=> 'There is no goods',
	'back_last_page'		=> 'Go back to the last page',
	'batch_edit_ok'			=> 'Batch edit product success!',
	'select_please'			=> 'Please choose',
	'uniform_goods_name'	=> 'Uniform modification of the name of the goods:',
	'all_category'			=> 'All categories',
	'all_brand'				=> 'All brands',
	'filter_goods_info'		=> 'Filter to product information',
	'no_content'			=> 'No content yet',
	'choost_goods_list'		=> 'Selected Goods List',
	'one_per_line'			=> '(One per line)',
);

// end