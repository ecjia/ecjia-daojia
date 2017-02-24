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
 * ECJIA Application language adsense
 */
return array(
	/* Ad-position field information */
	'position_name' 	=> 'Name',
	'ad_width' 			=> 'Width',
	'ad_height' 		=> 'Height',
	'position_desc' 	=> 'Description',
	'posit_width' 		=> 'Width',
	'posit_height' 		=> 'Height',
	'posit_style' 		=> 'Ad position:',
	'outside_posit' 	=> 'External Ad',
	'outside_address' 	=> 'Web site name of ad:',
	'copy_js_code' 		=> 'Copy JS code',
	'adsense_code' 		=> 'External Ad JS code',
	'label_charset' 	=> 'Select charset:',
	
	'no_position' 		=> 'No position',
	'no_ads' 			=> 'You do not have to add ads',
	'unit_px' 			=> 'Pixel',
	'ad_content' 		=> 'Ad contents',
	'width_and_height' 	=> '(width*height)',
	
	'position_name_empty' 	=> 'Wrong, the name of Ad-position is blank!',
	'ad_width_empty' 		=> 'Wrong, the width of Ad-position is blank!',
	'ad_height_empty' 		=> 'Wrong, the height of Ad-position is blank!',
	'position_desc_empty' 	=> 'Wrong, the description of Ad-position is blank!',
	
	'view_static' 			=> 'View statistics information.',
	'add_js_code' 			=> 'Produce And Copy The JS Code',
	'position_add' 			=> 'Add Ad Position',
	'position_edit' 		=> 'Edit Position',
	'posit_name_exist' 			=> 'The Ad position has existed!',
	'download_ad_statistics' 	=> 'Download Advertisement statistics',
	'add_js_code_btn'			=> 'Produce and copy the JS code',
			
	/* JS language item */
	'js_languages' => array(
		'posit_name_empty' 		=> 'Wrong, the name of Ad-position is blank!',
		'ad_width_empty' 		=> 'Please enter the width of Ad-position!',
		'ad_height_empty' 		=> 'Please enter the height of Ad-position!',
		'ad_width_number' 		=> 'The width of Ad-position mush be a figure!',
		'ad_height_number' 		=> 'The height of Ad-position mush be a figure!',
		'no_outside_address' 	=> 'We will suggest appoint the name of web site that the Ad will be lay-asided,convenient for statistics Ad source!',
		'width_value' 			=> 'The width of Ad-position value must be set between 1 and 1024!',
		'height_value' 			=> 'The height of Ad-position value must be set between 1 and 1024!',
		'ad_name_empty' 		=> 'Please enter Ad name!',
		'ad_link_empty' 		=> 'Please enter Ad link URL!',
		'ad_text_empty' 		=> 'Ad content can\'t be blank!',
		'ad_photo_empty' 		=> 'Advertising images can not be empty!',
		'ad_flash_empty' 		=> 'Flash ads can not be empty!',
		'ad_code_empty' 		=> 'Ad code can not be empty!',
		'empty_position_style' 	=> 'Ad-position\'s template can\'t be blank!',
	),
	
	'width_value' 		=> 'The width of Ad-position value must be set between 1 and 1024!',
	'height_value'		=> 'The height of Ad-position value must be set between 1 and 1024!',
	'width_number' 		=> 'The width of Ad-position mush be a figure!',
	'height_number'	 	=> 'The height of Ad-position mush be a figure!',
	'not_del_adposit' 	=> 'Wrong, there is an Ad, so the Ad-position can\'t be deleted!',
	
	/* Help language item */
	'position_name_notic' 	=> 'Enter a name of Ad-position, for example: footer Ad, LOGO Ad, the right side Ad and so on.',
	'ad_width_notic' 		=> 'The width of Ad-position, and the height will be the width at the Ad displaied , the unit is pixel.',
	
	'howto_js'			=> 'How to invoke JS code to display Ad?',
	'ja_adcode_notic' 	=> 'Description of invoked JS Ad code.',
	
	/*Ad field information */
	'ad_id' 			=> 'ID',
	'position_id' 		=> 'Ad position',
	'media_type' 		=> 'Media type',
	'ad_name' 			=> 'Name',
	'ad_link' 			=> 'Link:',
	'ad_code' 			=> 'Contents',
	'start_date' 		=> 'Start date',
	'end_date' 			=> 'End date',
	'link_man' 			=> 'Linkman',
	'link_email' 		=> 'Email',
	'link_phone' 		=> 'Phone',
	'click_count' 		=> 'Click counts',
	'ads_stats' 		=> 'Create order',
	'cleck_referer' 	=> 'Click source',
	'adsense_name' 		=> 'Name',
	'adsense_js_stats' 	=> 'External laid JS Statistics',
	'gen_order_amount' 	=> 'Total orders quantity',
	'confirm_order' 	=> 'Valid orders',
	'adsense_js_goods' 	=> 'External JS invoke product',
	
	'ads_stats_info' 	=> 'Ad statistics information',
	'flag' 				=> 'Status',
	'enabled' 			=> 'Enabled:',
	'is_enabled' 		=> 'Enabled',
	'no_enabled' 		=> 'Disabled',
	
	'ads_add' 				=> 'Add New Advertisement',
	'ads_edit' 				=> 'Edit Advertisement',
	'edit_success' 			=> 'Edit success',
	'drop_success' 			=> 'Delete success',
	'back_ads_list' 		=> 'Return to Ads list',
	'back_position_list' 	=> 'Return to Ad position list',
	'continue_add_ad' 		=> 'Continue to add Ad',
	'continue_add_position' => 'Continue to add Ad position',
	'show_ads_template' 	=> 'Show Ad in template',
	
	/* Description information */
	'ad_img' 	=> 'Image',
	'ad_flash' 	=> 'Flash',
	'ad_html' 	=> 'Code',
	'ad_text' 	=> 'Text',
	
	'upfile_flash' 		=> 'Upload flash file:',
	'flash_url' 		=> 'Or Flash website：',
	'upfile_img' 		=> 'Upload ad image:',
	'local_upfile_img' 	=> 'Local upload',
	'img_url' 			=> 'Or image URL',
	'enter_code' 		=> 'Please enter ad code.',
	'preview_image'		=> '(Preview image)',
	
	/* Prompting message */
	'upfile_flash_type' => 'Upload Flash file type is invalid!',
	'ad_code_repeat' 	=> 'The Ad image must be an uploaded file, or appoint a remote image.',
	'ad_flash_repeat' 	=> 'The Ad Flash must be an uploaded file, or appoint a remote Flash.',
	'ad_name_exist' 	=> 'The Ad name has existed!',
	'ad_name_notic' 	=> 'The Ad name only discriminate other Ads, and conceal in the Ad.',
	'ad_code_img' 		=> 'Upload the Ad image file, or appoint a remote URL address.',
	'ad_code_flash' 	=> 'Upload the Ad Flash file, or appoint a remote URL address.',
	
	'ad_type_lable'			=> 'Ad type:',
	'position_name_lable' 	=> 'Name:',
	'ad_width_lable' 		=> 'Width:',
	'ad_height_lable' 		=> 'Height:',
	'position_desc_lable' 	=> 'Description:',
	'ad_code_label'			=> 'Ad code:',
	
	'ad_name_lable' 			=> 'Name:',
	'start_date_lable' 			=> 'Start date:',
	'end_date_lable' 			=> 'End date:',
	'media_type_lable' 			=> 'Media type:',
	'position_id_lable' 		=> 'Ad position:',
	'ad_custom'					=> 'Ad Custom',
	'add_custom_ad' 			=> 'Add Custom Ad',
	'edit_custom_ad' 			=> 'Edit Custom Ad',
	'custom_ad_list'			=> 'Custom Ad List',
	'back_custom_ad_list'		=> 'Return to custom ad list',
	'continue_add_custom_ad'	=> 'Continue to add custom ad',
	'add_custom_ad_success'		=> 'Add custom ad success',
	'edit_custom_ad_success'	=> 'Edit custom ad success',
	'drop_custom_ad_success'	=> 'Delete custom ad success',
	'edit_status_success'		=> 'Edit status success',
	
	'search' 				=> 'Search',
	'enter_custom_ad_name'	=> 'Please enter Ad name',
	'ad_type'				=> 'Ad type',
	'add_time'				=> 'Add time',
	'remote_link'			=> 'Remote link',
	'specify_logo' 			=> 'When you specify a remote LOGO pictures, LOGO image URL must be URL http: // or https: // at the beginning of the correct URL format!',
	'browse'				=> 'Browse',
	'modify'				=> 'Modify',
	'edit'					=> 'Edit',
	'remove'				=> 'Remove',
	'confirm_remove'		=> 'Are you sure you want to delete?',
	'template_picture'		=> 'The picture standard width of this template is: 484px standard height: 200px',
	'link_address'			=> 'Link address:',
	'upload_flash_file'		=> 'Upload flash file',
	'modify_Flash_file'		=> 'Modify flash file',
	'content'				=> 'Content:',
	'update'				=> 'Update',
	
	'position_list'			=> 'Ad Position List',
	'add_success'			=> 'Add success',
	'choose_media_type'		=> 'Please select the type of media',
	'ad_name_empty'			=> 'Please enter Ad name',
	'filter'				=> 'Filter',
	'edit_ad_name'			=> 'Edit ad name',
	'ad_contact_info'		=> 'Advertising contact information',
	'name'					=> 'Name:',
	'email'					=> 'Email:',
	'phone'					=> 'Phone:',
	'ad_position_name'		=> 'Please enter ad position keywords',
	'edit_ad_position_name' => 'Edit ad location name',
	'view_ad_content'		=> 'View ad content',
	'edit_position_width'	=> 'Edit position width',
	'edit_position_height'	=> 'Edit position height',
	
	'ads_manage'			=> 'Advertisement',
	'ads_list'				=> 'Ad List',
	'ads_position'			=> 'Ad Position',
	'drop_ads'				=> 'Delete Advertisement',
	'ads_position_manage'	=> 'Ads Location Management',
	'add_ads_position'		=> 'Add Ad Location',
	'edit_ads_position'		=> 'Edit Ad Location',
	'drop_ads_position'		=> 'Delete Ad Location',
	'ads_custom_manage'		=> 'Ads Custom Management',
	'drop_custom_ad'		=> 'Delete Custom Ad',
	'custom_ad'				=> 'Custom Ad',
	
	'ad_link_empty' 		=> 'Please enter Ad link URL!',
	'ad_text_empty' 		=> 'Ad content can\'t be blank!',
	'ad_photo_empty' 		=> 'Advertising images can not be empty!',
	'ad_flash_empty' 		=> 'Flash ads can not be empty!',
	'ad_code_empty' 		=> 'Ad code can not be empty!',
	
	//js
	'ad_name_required'		=> 'Please fill in the name of the advertisement',
	'position_name_required'=> 'Please fill in the name of the advertisement position',
	'ad_width_required'		=> 'Please fill in the advertising position width',
	'ad_height_required'	=> 'Please fill in the advertisement position height',
	'gen_code_message'		=> 'We recommend that you specify the name of the site to serve the ad, the ad facilitate statistical sources',
	
	//help
	'overview'				=> 'Overview',
	'more_info'				=> 'More information:',
	
	'adsense_list_help'		=> 'Welcome to ECJia intelligent background ad list page, the system will display all the ads in this list.',
	'about_adsense_list'	=> 'About ad list help document',
	'adsense_add_help'		=> 'Welcome to ECJia intelligent background to add advertising page, the page can be added advertising operations.',
	'about_add_adsense'		=> 'About add ads help document',
	'adsense_edit_help'		=> 'Welcome to ECJia intelligent background editing advertising page, this page can be edited advertising operation.',
	'about_edit_adsense'	=> 'About edit ads help document',
	'adsense_genjs_help'	=> 'Welcome to ECJia intelligent background to add advertising page, this page can be generated and copied JS code operation.',
	'abount_genjs'			=> 'About generate and copy the js code help document',
	
	'position_list_help'	=> 'Welcome to ECJia intelligent background ad placement list page, the system will display all of the ad placement in this list.',
	'about_position_list'	=> 'About ad placement list help document ',
	'position_add_help'		=> 'Welcome to ECJia intelligent background ad position on the page, on this page you can add a creative position of the operation.',
	'about_add_position'	=> 'About add ad placement help document',
	'position_edit_help'	=> 'Welcome to ECJia intelligent background editing ad position on the page, the page can be edited in this ad placement operation.',
	'about_edit_position'	=> 'About edit ad placement help document',
	
	'custom_list_help'		=> 'Welcome to ECJia intelligent background advertising custom list page, the system all custom ad will appear in this list.',
	'abount_custom_list'	=> 'About custom list of ads help document',
	'add_custom_help'		=> 'Welcome to ECJia intelligent background add custom ad page, on this page you can add custom advertising operations.',
	'about_add_custom'		=> 'About add custom ads help document',
	'edit_custom_help'		=> 'Welcome to ECJia intelligent background edit custom ad page, this page can be edited to customize advertising operations.',
	'abount_edit_custom'	=> 'About edit custom ads help document',
);

// end