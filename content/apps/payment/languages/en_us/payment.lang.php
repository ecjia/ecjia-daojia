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
 * ECJia 管理中心支付方式管理语言文件
 */
return array(
	'02_payment_list' 	=> 'Payment',
	'payment'			=> 'Payment Mothod',
	'payment_name'		=> 'Name',
	'version'			=> 'Version',
	'payment_desc'		=> 'Description',
	'short_pay_fee'		=> 'Money',
	'payment_author'	=> 'Author',
	'payment_is_cod'	=> 'Pay after received?',
	'payment_is_online'	=> 'Online payment?',
		
	'enable' 		=> 'Enable',
	'disable' 		=> 'Disable',
	'name_edit' 	=> 'Name of payment method',
	'payfee_edit' 	=> 'Payment method cost',
	'payorder_edit' => 'Order of payment',
	'name_is_null'	=> 'Please enter payment method name!',
	'name_exists'	=> 'The payment method has existed!',
	'pay_fee'		=> 'Poundage',
	'back_list'		=> 'Return to payment mothod list.',
	'install_ok'	=> 'Install success',
	'edit_ok'		=> 'Edit success',
	'edit_falid' 	=> 'Edit failed',
	'uninstall_ok'	=> 'Uninstall success',
	
	'invalid_pay_fee'		=> 'Please enter a valid number of payment.',
	'decide_by_ship'		=> 'Shipping decision',
	'edit_after_install'	=> 'You can\'t use the payment mothod until it is installed.',
	'payment_not_available'	=> 'The payment plug-in don\'t exist or have not been installed yet.',
	
	'js_lang' => array(
		'lang_removeconfirm'	=> 'Are you sure remove the payment method?',
		'pay_name_required'		=> 'Please enter a payment name',
		'pay_name_minlength'	=> 'Payment name length should not be less than 3',
		'pay_desc_required'		=> 'Please enter the payment description',
		'pay_desc_minlength'	=> 'Payment description length should not be less than 6',
	),
		
	'pay_status' 	=> 'Payment status',
	'pay_not_exist' => 'This payment method does not exist or parameter errors!',
	'pay_disabled' 	=> 'This payment method has not been enabled!',
	'pay_success' 	=> 'Your payment operation has been successful!',
	'pay_fail' 		=> 'Payment operation failed, please return to retry!',
	
	'ctenpay'		=> 'Choi pay immediately Merchant Registration No.',
	'ctenpay_url'	=> 'http://union.tenpay.com/mch/mch_register_b2c.shtml?sp_suggestuser=542554970',
	'ctenpayc2c_url'=> 'https://www.tenpay.com/mchhelper/mch_register_c2c.shtml?sp_suggestuser=542554970',
	'tenpay'		=> 'tenpay',
	'tenpayc2c'		=> 'Intermediary security',
	
	'dualpay'			=> 'Standard dual-interface',
	'escrow'			=> 'Secured transactions interface',
	'fastpay'			=> 'Real-time interface transactions arrive',
	'alipay_pay_method'	=> 'Choose interface type：',
	'getPid'			=> 'Get Pid、Key',
		
	//追加
	'repeat'					=> 'repeat',
	'buyer'						=> 'buyer',
	'surplus_type_0'			=> 'Saving',
	'order_gift_integral'		=> 'Order %s integral gift',
	'please_view_order_detail' 	=> 'Please view order detail in Member Center',
	'plugin'					=> 'Plugin',
	'disabled'					=> 'Disabled',
	'enabled'					=> 'Enabled',
	'edit_payment'				=> 'Edit Payment Method',
	'payment_list'				=> 'Payment list',
	'number_valid'				=> 'Please enter a valid digital',
	'enter_valid_number'		=> 'Please enter a valid number or percentage%',
	'edit_free_as'				=> 'Modify Cost is %s',
	'edit_payment_name'			=> 'Edit payment name',
	'edit_payment_order'		=> 'Edit payment sort',
	'label_payment_name'		=> 'Name:',
	'label_payment_desc'		=> 'Description:',
	'label_pay_fee'				=> 'Money:',
	
	'payment_manage'		=> 'Payment Method Management',
	'payment_update'		=> 'Update Payment Method',
	'plugin_install_error'	=> 'The name of the payment method or pay_code cannot be empty',
	'plugin_uninstall_error'=> 'Payment name can not be empty',
	
	'overview'              => 'Overview',
	'more_info'             => 'More information:',
	
	'payment_list_help'		=> 'Welcome to ECJia intelligent background payment page, the system will display all the payment methods in this list.',
	'about_payment_list'	=> 'About payment methods help document '
);

//end