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
 * ECJia 管理中心配送方式管理语言文件
 */
return array(
	'shipping_area_name'		=> 'Shipping area name',
	'shipping_area_districts'	=> 'Area list',
	'shipping_area_regions'		=> 'Region',
	'shipping_area_assign'		=> 'Shipping method',
		
	'area_region'		=> 'Region',
	'removed_region' 	=> 'The region has been removed',//追加
	'area_shipping'		=> 'Shipping method',
	'fee_compute_mode'	=> 'Cost calculation',
	'fee_by_weight'		=> 'By weight',
	'fee_by_number'		=> 'By number',
	'new_area'			=> 'Creat Shipping Area',
	'label_country'		=> 'Country:',
	'label_province'	=> 'Province:',
	'label_city'		=> 'City:',
	'label_district'	=> 'District:',
	'batch' 			=> 'Batch Operations',//追加
	'batch_delete' 		=> 'Batch delete operation',//追加
	
	'batch_no_select_falid' => 'Unchecked element, the mass delete operation failed',//追加
	'delete_selected'		=> 'Delete the selected shipping region.',
		
	'btn_add_region'	=> 'Add the selected region',
	'free_money'		=> 'Free allowance',
	'pay_fee'			=> 'Cash on shipping payment',
	'edit_area'			=> 'Edit Area',
	'add_continue'		=> 'Continue to add shipping region',
	'back_list'			=> 'Return to list page',
	'empty_regions'		=> 'Current region has no related regions.',
	
	/* Prompting message */
	'repeat_area_name'	=> 'The shipping region already exists.',
	'not_find_plugin'	=> 'No shipping plug-in.',
	'remove_confirm'	=> 'Are you sure delete the shipping region?',
	'remove_success'	=> 'Appointed shipping region has be deleted successfully!',
	'remove_fail'		=> 'Remove failed',
	'no_shippings'		=> 'No shipping.',
	'add_area_success'	=> 'Add shipping region successfully.',
	'edit_area_success'	=> 'Edit shipping region successfully.',
	'disable_shipping_success'	=> 'Appointed shipping region has be removed.',
	
	/* JS language item */
	'js_languages' => array(
		'no_area_name'		=> 'Please enter name of shipping region.',
		'del_shipping_area'	=> 'Please delete the regional distribution, and then re-add.',
		'invalid_free_mondy'=> 'Please enter a free allowance and it must be an integer.',
		'blank_shipping_area'	=> 'The regional distribution can`t is blank.',
		'lang_remove'			=> 'Remove',
		'lang_remove_confirm'	=> 'Are you sure remove the region?',
			
		'lang_disabled'			=> 'Disabled',
		'lang_enabled'			=> 'Enabled',
		'lang_setup'			=> 'Setup',
		'lang_region'			=> 'Region',
		'lang_shipping'			=> 'Shipping method',
		'region_exists'			=> 'The region already exists.',
	),
	
	//追加
	'item_fee' 			=> 'Single commodity costs',
	'shipping_area'		=> 'Distribution area',
	'list'				=> 'List',
	'shipping_way'		=> 'The mode of distribution is ',
	'add_area_success'	=> 'Add distribution area success',
	'add'				=> 'Add',
	
	'select_shipping_area'	=> 'Select delivery area:',
	'search_country_name'	=> 'Search country name',
	'no_country_choose'		=> 'No country area available...',
	'search_province_name'	=> 'Search province name',
	'choose_province_first'	=> 'Please select the name of the province...',
	'search_city_name'		=> 'Search city / region name',
	'choose_city_first'		=> 'Please select the city / district name...',
	'search_districe_name'	=> 'Search county / Township name',
	'choose_districe_first'	=> 'Please select the county / Township name...',
	'shipping_method'		=> 'Shipping Method',
	
	'batch_drop_confirm'	=> 'Are you sure you want to delete the selected distribution area?',
	'select_drop_area'		=> 'Please select the area you want to remove distribution!',
	'area_name_keywords'	=> 'Please enter area name keywords',
	'drop_area_confirm'		=> 'Are you sure you want to delete the distribution area?',
	
	'search'	=> 'Search',
	'yes'		=> 'Yes',
	'no'		=> 'No',
	
	'label_shipping_area_name' 	=> 'Shipping area name:',
	'label_fee_compute_mode'	=> 'Cost calculation:',
	'shiparea_manage'			=> 'Delivery Area Management',
	'shiparea_delete'			=> 'Delete Delivery Area',
				
	'overview'				=> 'Overview',
	'more_info'         	=> 'More information:',
	
	'shipping_area_help' 	=> 'Welcome to ECJia intelligent background distribution area page, you can view the corresponding distribution list in this page.',
	'about_shipping_area'	=> 'About the distribution area to help document',
	
	'add_area_help'			=> 'Welcome to the new distribution area of ECJia intelligent background page, you can create new distribution area information on this page.',
	'about_add_area'		=> 'About the new distribution area to help document',
	
	'edit_area_help'		=> 'Welcome to ECJia intelligent background editing and distribution area page, you can edit the corresponding distribution of regional information in this page.',
	'about_edit_area'		=> 'About edit the distribution area to help document ',
);

//end