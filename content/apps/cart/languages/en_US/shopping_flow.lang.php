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
 * ECJIA 购物流程相关语言
 */
return array(
	'flow_login_register' => array(
		'username_not_null' => 'Please enter username.',
		'username_invalid' 	=> 'Please enter a valid username.',
		'password_not_null' => 'Please enter password.',
		'email_not_null' 	=> 'Please enter email address.',
		'email_invalid' 	=> 'Please enter a valid email address.',
		'password_not_same' => 'Re-enter password.',
		'password_lt_six' 	=> 'Please enter password more than six charactor.',
	),
		
	'regist_success' 	=> "Congratulations! %s register successfully!",
	'login_success' 	=> 'Congratulations! Login successfully!',
	
	/* 购物车 */
	'update_cart' 			=> 'Update the cart',
	'back_to_cart' 			=> 'Back to the cart',
	'update_cart_notice' 	=> 'Update successfully, please choose the gift again.',
	'direct_shopping' 		=> 'I don\'t plan to login, directly purchase.',
	'goods_not_exists' 		=> 'Sorry, the product is nonexistence.',
	'drop_goods_confirm' 	=> 'Are you sure remove it from the cart?',
	'goods_number_not_int' 	=> 'Please enter a valid number.',
	'stock_insufficiency' 	=> 'Sorry, the stocks of products %s only %d, you can buy %d largest.',
	'package_stock_insufficiency' => 'Sorry, the stocks of packages is not enough, please reduce the number of the package or inform of the seller.',
	'shopping_flow' 		=> 'Shopping flow',
	'username_exists' 		=> 'The username already exists, please enter another one and try it again.',
	'email_exists' 			=> 'The email address already exists, please enter another one and try it again.',
	'surplus_not_enough' 	=> 'Your balance is not enough.',
	'integral_not_enough' 	=> 'Your points is not enough.',
	'integral_too_much' 	=> "The points of your used can\'t more than %d.",
	'invalid_bonus' 		=> "he bonus is nonexistent.",
	'no_goods_in_cart' 		=> 'There is blank in your cart!',
	'not_submit_order' 		=> 'The order of associates have submitted, please don\'t do it again!',
	'pay_success' 			=> 'Paid successfully, it is imperative that we make a quick shipping for you.',
	'pay_fail' 				=> 'Paid failed, please contact with us timely.',
	'pay_disabled' 			=> 'The payment mode have disconnected.',
	'pay_invalid' 			=> 'The payment mode is invalid. Please contact with us timely.',
	'flow_no_shipping' 		=> 'Select one shipping method.',
	'flow_no_payment' 		=> 'Please select a payment mode!',
	'pay_not_exist' 		=> 'The payment mode is nonexistence.',
	'storage_short' 		=> 'Out of stock',
	'subtotal' 				=> 'Subtotal',
	'accessories' 			=> 'Accessories',
	'largess' 				=> 'Largess',
	'shopping_money' 		=> 'Subtotal %s',
	'than_market_price' 	=> 'Market price is %s, you save %s (%s). ',
	'your_discount' 		=> 'Your discount is %s',
	'no' 					=> 'No',
	'not_support_virtual_goods' => 'There is(are) virtual product(s), it is not support purchase without login, please login validly.',
	'not_support_insure' 	=> 'No support insure.',
	'clear_cart' 			=> 'Clear the cart.',
	'drop_to_collect' 		=> 'Drop to collect.',
	
	'password_js' => array(
		'show_div_text' => 'Please Update Cart',
		'show_div_exit' => 'Close',
	),
	'goods_fittings' 	=> 'Goods Fittings',
	'parent_name' 		=> 'Goods Releate：',
	'remark_package' 	=> 'Preferential Packeage',
	
	/* 优惠活动 */
	'favourable_name' 	=> 'Favourable name:',
	'favourable_period' => 'Favourable period:',
	'favourable_range' 	=> 'Favourable range:',
	
	'far_ext' => array(
		FAR_ALL 		=> 'All products',
		FAR_BRAND 		=> 'Following brand',
		FAR_CATEGORY 	=> 'Following category',
		FAR_GOODS 		=> 'Following goods',
	),
	
	'fat_ext' => array(
		FAT_DISCOUNT 	=> 'Enjoy %d%% discount',
		FAT_GOODS 		=> 'Select %d from the following gifts (0 indicates no limitation to quantity)',
		FAT_PRICE 		=> 'Price reduced by %d',
	),
	
	'favourable_amount' => 'Favourable amount:',
	'favourable_type' 	=> 'Favourable type:',
	
	'favourable_not_exist' 		=> 'Favourable is nonexistence',
	'favourable_not_available' 	=> 'Favourable is nonexistence',
	'favourable_used' 			=> 'Favourable is used',
	'pls_select_gift' 			=> 'Please select gift',
	'gift_count_exceed' 		=> 'Gift quantity selected is maximizing',
	'gift_in_cart' 				=> 'Gift in the cart: %s',
	'label_favourable' 			=> 'Favourable',
	'label_collection' 			=> 'Collection',
	'collect_to_flow' 			=> 'Buy',
	
	/* 登录注册 */
	'forthwith_login' 		=> 'Login',
	'forthwith_register' 	=> 'Register',
	'signin_failed' 		=> 'Soory, login failure, please check your username and password.',
	'gift_remainder' 		=> 'Note: please select gift again after login or registering.',
	
	/* 收货人信息 */
	'flow_js' => array(
		'consignee_not_null' 	=> 'Please enter name of consignee!',
		'country_not_null' 		=> 'Please select a country of consignee!',
		'province_not_null' 	=> 'Please select a province of consignee!',
		'city_not_null' 		=> 'Please select a city of consignee!',
		'district_not_null' 	=> 'Please select a district of consignee!',
		'invalid_email' 		=> 'Please enter a valid email address.',
		'address_not_null' 		=> 'Please enter an address!',
		'tele_not_null' 		=> 'Please enter a phone number!',
		'shipping_not_null' 	=> 'Please select a shipping method!',
		'payment_not_null' 		=> 'Please select a payment mode!',
		'goodsattr_style' 		=> 1,
		'tele_invaild' 			=> 'Please enter valid phone No.',
		'zip_not_num' 			=> 'Zip code should be numbers',
		'mobile_invaild' 		=> 'Mobile No. is invalid',
	),
	
	'new_consignee_address' => 'New consignee address',
	'consignee_address' => 'Address',
	'consignee_name' 	=> 'Name',
	'country_province' 	=> 'Country/Province',
	'please_select' 	=> 'Please select...',
	'city_district' 	=> 'City/District',
	'email_address' 	=> 'Email',
	'detailed_address' 	=> 'Address',
	'postalcode' 		=> 'Postalcode',
	'phone' 			=> 'Phone',
	'mobile' 			=> 'Mobile',
	'backup_phone' 		=> 'Mobile',
	'sign_building' 	=> 'Sign building',
	'deliver_goods_time'=> 'Optimal shipping time',
	'default' 			=> 'Default',
	'default_address' 	=> 'Default address',
	'confirm_submit' 	=> 'Submit',
	'confirm_edit' 		=> 'Submit',
	'country' 			=> 'Country',
	'province' 			=> 'Province',
	'city' 				=> 'City',
	'area' 				=> 'Area',
	'consignee_add' 	=> 'Add a new consignee.',
	'shipping_address' 	=> 'Shipping according to this address.',
	'address_amount' 	=> 'The place of receipt should be less than three.',
	'not_fount_consignee' => 'Sorry, the place of receipt is nonexistence.',
	
	/*------------------------------------------------------ */
	//-- 订单提交
	/*------------------------------------------------------ */
	'goods_amount_not_enough' 	=> 'Goods amount is less than the minimum amount %s required, order cannot be submited.',
	'balance_not_enough' 		=> 'Your balance is not enough, please select another paymen mode',
	'select_shipping' 			=> 'Your select shipping method is',
	'select_payment' 			=> 'Your select payment mode is',
	'order_amount' 				=> 'Your order money is',
	'remember_order_number' 	=> 'Thanks for your shopping! Your order have submitted, please remember your order numbers.',
	'back_home' 				=> '<a href="index.php">Back to home</a>',
	'goto_user_center' 			=> '<a href="user.php">Member center</a>',
	'order_submit_back' 		=> 'You can %s or go to %s',
	
	'order_placed_sms' 	=> "You has a new order.Consignee:%s Phone:%s",
	'sms_paid' 			=> 'Paid',
	
	'notice_gb_order_amount' 	=> '（(Remarks: If associates with insurance, the insurance and corresponding pay need to be paid in first payment.)',
	'pay_order' 				=> 'Pay order %s',
	'validate_bonus' 			=> 'Vadidate bonus',
	'input_bonus_no' 			=> 'Input bonus No.',
	'select_bonus' 				=> 'Select existing bonus',
	'bonus_sn_error' 			=> 'Please enter valid bonus No.',
	'bonus_min_amount_error' 	=> 'Order amount is less than the minimum amount of bonus %s',
	'bonus_is_ok' 				=> 'Bonus No. is avaible, can be used as %s',
	
	'shopping_myship' 	=> 'My shipping',
	'shopping_activity' => 'Activity list',
	'shopping_package' 	=> 'Package list',
);

// end