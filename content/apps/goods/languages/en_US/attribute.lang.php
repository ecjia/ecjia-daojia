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
 * ECJIA 商品类型管理语言文件
 */
return array(
	/* List */
	'by_goods_type' 	=> 'Display by product type:',
	'all_goods_type' 	=> 'All products type',
	'attr_id' 			=> 'ID',
	'cat_id' 			=> 'Product type',
	'attr_name' 		=> 'Attribute name',
	'attr_input_type' 	=> 'Enter mode',
	'attr_values' 		=> 'Choice value list',
	'attr_type' 		=> 'Whether need select the value of attribute for shopping?',
	
	'value_attr_input_type' => array(
		ATTR_TEXT 		=> 'Manual enter',
		ATTR_OPTIONAL 	=> 'Select from list',
		ATTR_TEXTAREA 	=> 'Multirow textbox',
	),
		
	'drop_confirm' 	=> 'Are you sure delete the attribute?',
	'batchdrop' 	=> 'Batch drop',	//追加
		
	/* Add/Edit */
	'label_attr_name' 	=> 'Attribute name:',
	'label_cat_id' 		=> 'Category:',
	'label_attr_index' 	=> 'Index:',
	'label_is_linked' 	=> 'Relational products with same attribute?:',
	'no_index' 			=> 'Needn\'t index',
	'keywords_index' 	=> 'Keywords index',
	'range_index' 		=> 'Range index',
	'note_attr_index' 	=> 'Please select have no use for search if have no use for the attribute become a situation of search product condition. Please select keywords search if have use for the attribute carry through keywords search. Please select range search if the attribute search need to appoint a certain range.',
	'label_attr_input_type' => 'Attribute value enter mode:',
	'text' 				=> 'Manual enter',
	'select' 			=> 'Select from below (one line stand for one value)',
	'text_area' 		=> 'Multirow textbox',
	'label_attr_values' => 'Choice value list:',
	'label_attr_group' 	=> 'Property division:',
	'label_attr_type' 	=> 'Property is optional:',
	'note_attr_type' 	=> 'Select "Yes" when the merchandise can set up a number of property value, while property values specified for different different price increases, users need to purchase merchandise at selected specific property value. Choose "No" when the property value of the merchandise can only set a value, the user can only view the value.',
	'attr_type_values' 	=> array(
		0 => 'The only property',
		1 => 'Radio property',
		2 => 'Check property',
	),
	
	'add_next' 	=> 'Continue to add attribute',
	'back_list' => 'Return to goods attribute',
	'add_ok' 	=> 'Add attribute [%s] success',
	'edit_ok' 	=> 'Edit attribute [%s] success',
	
	/* Prompting message */
	'name_exist' 			=> 'The attribute name already exists, please change another one.',
	'drop_confirm' 			=> 'Are you sure delete the attribute?',
	'notice_drop_confirm' 	=> 'Already has %s the use of the property of merchandise, you sure you want to delete the right property?',
	'name_not_null' 		=> 'Attribute name can\'t be blank.',
	'no_select_arrt' 		=> 'You have no choice need to remove the attribute name',
	'drop_ok' 		 		=> 'Delete success',

	'js_languages' => array(
		'name_not_null' 	=> 'Please enter attribute name.',
		'values_not_null' 	=> 'Please enter the attribute\'s value.',
		'cat_id_not_null' 	=> 'Please select the attribute of product type.',
	),
	
	//追加
	'goods_attribute'	=> 'Goods Attribute',
	'add_attribute'		=> 'Add Attribute',
	'cat_not_empty'		=> 'Product type can not be empty',
	'edit_success'		=> 'Edit success',
	'format_error'		=> 'Please enter a number greater than 0',
	'drop_success'		=> 'Success delete',
	
	'drop_select_confirm'	=> 'Are you sure you want to delete the selected goods attributes?',
	'batch_operation'		=> 'Batch Operations',
	'name_not_null'			=> 'Please enter a property name',
	'order_not_null'		=> 'Please enter the sort number',
	
    'overview'              => 'Overview',
    'more_info'             => 'More information:',
	
	'goods_attribute_help'	=> 'Welcome to ECJia intelligent background goods properties list page, the system will display all the goods properties in this list.',
	'about_goods_attribute'	=> 'About the goods properties list help document',
	
	'add_attribute_help'	=> 'Welcome to ECJia intelligent background to add goods attributes page, you can add the goods attribute information on this page.',
	'about_add_attribute'	=> 'About add goods attributes help document',
	
	'edit_attribute_help'	=> 'Welcome to ECJia intelligent background editing goods properties page, you can edit the goods attribute information on this page.',
	'about_edit_attribute'	=> 'About edit goods attributes help document',
);

// end