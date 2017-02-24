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
 * ECJIA 订单管理语言文件
 */
return array(
	/* Order search*/
	'order_sn'		=> 'Order sn',
	'consignee'		=> 'Consignee',
	'label_consignee' => 'Consignee:',
	'all_status'	=> 'Status',
	'thumb_img' 	=> 'Thumbnails',//追加
	
	'cs' => array(
		OS_UNCONFIRMED	=> 'Unconfirmed',
		CS_AWAIT_PAY	=> 'Await pay',
		CS_AWAIT_SHIP	=> 'Await ship',
		CS_FINISHED		=> 'Finished',
	    CS_RECEIVED     => 'Received',
		PS_PAYING		=> 'Payment',
		OS_CANCELED		=> 'Returned',
		OS_INVALID		=> 'Invalid',
		OS_RETURNED		=> 'Returned',
		OS_SHIPPED_PART	=> 'Partial shipment',
	),
	
	/* Order status */
	'os' =>array(
		OS_UNCONFIRMED	=> 'Unconfirmed',
		OS_CONFIRMED	=> 'Confirmed',
		OS_CANCELED		=> 'Canceled',
		OS_INVALID		=> 'Invalid',
		OS_RETURNED		=> 'Returned',
		OS_SPLITED		=> 'Had been a single',
		OS_SPLITING_PART=> 'Part of the sub-single-',
	),
	
	'ss' => array(
		SS_UNSHIPPED	=> 'Unshipped',
		SS_PREPARING	=> 'Preparing',
		SS_SHIPPED		=> 'Shipped',
		SS_RECEIVED		=> 'Received',
		SS_SHIPPED_PART	=> 'Partially Shipped',
		SS_SHIPPED_ING	=> 'No shippings',// Shipped in
	),
	
	'ps' => array(
		PS_UNPAYED	=> 'Unpaid',
		PS_PAYING	=> 'Paying',
		PS_PAYED	=> 'Paid',
	),
	
	'ss_admin' => array(
		SS_SHIPPED_ING	=> 'Shipped in（Future state：No shippings）',
	),
		
	/* Order operate */
	'label_operable_act'	=> 'Current executable operation:',
	'label_action_note'		=> 'Operate remarks:',
	'label_invoice_note'	=> 'Invoice remarks:',
	'label_invoice_no'		=> 'Invoice No.:',
	'label_cancel_note'		=> 'Cause of cancel:',
	'notice_cancel_note'	=> '(Note in message of shopkeeper)',
	'pay_order'				=> 'Pay order %s',
		
	'op_confirm'	=> 'Confirm',
	'op_pay'		=> 'Payment',
	'op_prepare'	=> 'Distribution',
	'op_ship'		=> 'Shipping',
	'op_cancel'		=> 'Cancel',
	'op_invalid'	=> 'Invalid',
	'op_return'		=> 'Refundment',
	'op_unpay'		=> 'Set Unpaid',
	'op_unship'		=> 'Unshipped',
		
	'op_cancel_ship'	=> 'Cancellation Shipping',
	'op_receive'		=> 'Received',
	'op_assign'			=> 'Assign to',
	'op_after_service'	=> 'Aftermarket',
	'act_ok'			=> 'Operate successfully',
	'act_false'			=> 'Operate failed',
	'act_ship_num'		=> 'Shipped quantity is more then order quantity',
	'act_good_vacancy'	=> 'Out of stock',
	'act_good_delivery'	=> 'Shipped',
	'notice_gb_ship'	=> 'Notice: You can\'t shipping until you deal with the associates successfully.',
	'op_remove'			=> 'Remove',
	'op_you_can'		=> 'The operation you can do',
	'op_split'			=> 'Generate delivery invoices',
	'op_to_delivery'	=> 'To delivery',
	
	/* order list */
	'order_amount'			=> 'Orders money',
	'total_fee'				=> 'Total',
	'shipping_name'			=> 'Shipping method',
	'pay_name'				=> 'Payment method',
	'address'				=> 'Address',
	'order_time'			=> 'Time',
	'detail'				=> 'View',
	'phone'					=> 'Phone',
	'group_buy'				=> '(Associates)',
	'error_get_goods_info'	=> 'Orders for merchandise to obtain information error',
	'exchange_goods'		=> '(Points Exchange)',
	
	//追加
	'merge_confirm' 	=> 'Are you sure you want to merge the two orders?',
	'action_note_sure' 	=> 'Enter Action Remark',
	'back_order_info' 	=> 'Back Order Details',
		
	/* The order search*/
	'label_order_sn'	=> 'Order sn:',
	'label_all_status'	=> 'Status:',
	'label_user_name'	=> 'Buyer:',
	'label_consignee'	=> 'Consignee:',
	'label_email'		=> 'Email:',
	'label_address'		=> 'Address:',
	'label_zipcode'		=> 'Post code:',
	'label_tel'			=> 'Telephone:',
	'label_mobile'		=> 'Mobile phone:',
	'label_shipping'	=> 'Shipping method:',
	'label_payment'		=> 'Payment method:',
	'label_order_status'=> 'Order status:',
	'label_pay_status'	=> 'Payment status:',
	'label_shipping_status'	=> 'Shipping status:',
	'label_area'			=> 'Location:',
	'label_time'			=> 'Under a single time:',
	
	/* Order details */
	'prev'						=> 'Previous order',
	'next'						=> 'Next order',
	'print_order'				=> 'Print order',
	'print_shipping'			=> 'Print Express Single',
	'print_order_sn'			=> 'Order Sn:',
	'print_buy_name'			=> 'Buyer:',
	'label_consignee_address'	=> 'Receipt address',
	'no_print_shipping'			=> 'Sorry, you do not set the print express single template, you can not print.',
	'suppliers_no'				=> 'At my disposal(without suppliers)',
	'restaurant'				=> 'Restaurant',
	
	'order_info'		=> 'Order Information',
	'base_info'			=> 'Essential information',
	'other_info'		=> 'Other information',
	'consignee_info'	=> 'Consignee information',
	'fee_info'			=> 'Money information',
	'action_info'		=> 'Operate Information',
	'shipping_info'		=> 'Shipping Info',
	'heading_order_info'=> 'Order information',
	
	'label_how_oos'			=> 'Out of stock dispose:',
	'label_how_surplus'		=> 'Balance dispose:',
	'label_pack'			=> 'Packing:',
	'label_card'			=> 'Card:',
	'label_card_message'	=> 'Blessing card:',
	'label_order_time'		=> 'Order time:',
	'label_pay_time'		=> 'Payment time:',
	'label_shipping_time'	=> 'Shipping time:',
	'label_sign_building'	=> 'Sign building:',
	'label_best_time'		=> 'Optimal shipping time:',
	'label_inv_type'		=> 'Invoice type:',
	'label_inv_payee'		=> 'Invoice title:',
	'label_inv_content'		=> 'Invoice content:',
	'label_postscript'		=> 'Postscript:',
	'label_region'			=> 'Region:',
	
	'label_shop_url'		=> 'URL:',
	'label_shop_address'	=> 'Address:',
	'label_service_phone'	=> 'Service phone:',
	'label_print_time'		=> 'Print time:',
	
	'label_suppliers'	=> 'Choose suppliers:',
	'label_agency'		=> 'Agency:',
	'suppliers_name'	=> 'Suppliers',
	
	'product_sn'			=> 'Item No.',
	'goods_info'			=> 'Goods information',
	'goods_name'			=> 'Goods name',
	'goods_name_brand'		=> 'Goods name [ Brand ]',
	'goods_sn'				=> 'No.',
	'goods_price'			=> 'Price',
	'goods_number'			=> 'Quantity',
	'goods_attr'			=> 'Attribute',
	'goods_delivery'		=> 'Shipped quantity',
	'goods_delivery_curr'	=> 'Invoice quantity',
	'storage'				=> 'Storage',
	'subtotal'				=> 'Subtotal',
	'label_total'			=> 'Total:',
	'label_total_weight'	=> 'Total products weight:',
	'label_goods_price'		=> 'Price:',
	'label_goods_number'	=> 'Quantity:',
	
	'label_goods_amount'	=> 'Total products money:',
	'label_discount'		=> 'Discount:',
	'label_tax'				=> 'Tax invoice:',
	'label_shipping_fee'	=> 'Shipping money:',
	'label_insure_fee'		=> 'Insurance money:',
	'label_insure_yn'		=> 'Insurance?(Y/N):',
	'label_pay_fee'			=> 'Payment money:',
	'label_pack_fee'		=> 'Packing money:',
	'label_card_fee'		=> 'Greeting card money:',
	'label_money_paid'		=> 'Paid money:',
	'label_surplus'			=> 'Use balance:',
	'label_integral'		=> 'Use points:',
	'label_bonus'			=> 'Use bonus:',
	'label_order_amount'	=> 'Total orders money:',
	'label_money_dues'		=> 'Total payable money:',
	'label_money_refund'	=> 'Refundable money:',
	'label_to_buyer'		=> 'Shop message:',
	'save_order'			=> 'Save order',
	'notice_gb_order_amount'=> '(Remarks: If associates with insurance, the insurance and corresponding pay need to be paid in first payment.)',
	
	'action_user'		=> 'Customer',
	'action_time'		=> 'Time',
	'order_status'		=> 'Order status',
	'pay_status'		=> 'Payment status',
	'shipping_status'	=> 'Shipping status',
	'action_note'		=> 'Remarks:',
	'pay_note'			=> 'Pay remarks:',
	
	'sms_time_format'	=> 'j/m G o\'clock',
	'order_shipped_sms'	=> 'Your order %s hss already shipped in %s. [%s]',
	'order_splited_sms'	=> 'Your order%s,%sIs%s [%s]',
	'order_removed'		=> 'Delete order successfully',
	'return_list'		=> 'Return to order list',
	
	/* The order processing hint*/
	'surplus_not_enough'	=> 'The order use %s balance to pay, now the customer balance shortage.',
	'integral_not_enough'	=> 'The order use %s points to pay, now the customer points shortage.',
	'bonus_not_available'	=> 'The order use bonus to pay, the bonus can\'t be used now.',
	'order_prepare_message' => 'Order No. %s for the goods are in stock, please wait patiently',
	'order_goods_served'	=> 'Goods have been served, please sign, thank you for your next visit!',
	'order_send_message'	=> 'Order No. %s goods have been shipped, please wait patiently',
	'notice_merchant_message' => 'Has been notified businesses embrace, please be patient',
	'pay_repeat_message'	=> 'The order has been paid, please do not repeat the payment.',
	'not_enough_balance'	=> 'Your balance is not enough to pay the entire order, please choose other payment methods.',
	
	/* Buy the goods person\'s information*/
	'display_buyer'	=> 'Display buyer information',
	'buyer_info'	=> 'Buyer information',
	'pay_points'	=> 'Consumption points',
	'rank_points'	=> 'Rank points',
	'user_money'	=> 'Account balance',
	'email'			=> 'E-mail',
	'rank_name'		=> 'Member\'s rank',
	'bonus_count'	=> 'Bonus quantity',
	'zipcode'		=> 'Postal code',
	'tel'			=> 'Telephone',
	'mobile'		=> 'Backup telephone',
	
	/* Combine orders */
	'order_sn_not_null'					=> 'Please fill in combine orders No.',
	'two_order_sn_same'					=> 'Combine orders\' No. can\'t be same.',
	'order_not_exist'					=> 'Order %s is nonexistent.',
	'os_not_unconfirmed_or_confirmed'	=> '% of the order status is not "Unconfirmed" or "Confirmed".',
	'ps_not_unpayed'					=> 'Order the %s payment status is not "Unpaid".',
	'ss_not_unshipped'					=> 'Order the %s shipping status is not "Unshipped".',
	'order_user_not_same'				=> 'The two orders belong to different customers',
	'merge_invalid_order'				=> 'Sorry, the orders can\'t be allowed to combine that you have selected.',
	'order_merge_invalid'				=> 'Order merge invalid',
	'and'								=> 'and',
	'new_order_is'						=> ', Into a new order, order number is:',
	'merge_success_notice'				=> '%s and  %s merge to new order, the new order sn is：%s',
	
	'from_order_sn'		=> 'Master order:',
	'to_order_sn'		=> 'Slave order:',
	'merge'				=> 'Combine',
	'notice_order_sn'	=> 'When two order inconformities, order information after merge with the master for standard(such as:Payment mothed, Shipping, Packing, Greeting card, Bonus...etc.).',
	
	/* Criticize a processing*/
	'pls_select_order'		=> 'Please choose the operation you want to order',
	'no_fulfilled_order'	=> 'There is no condition satisfy to operate the order.',
	'updated_order'			=> 'More recent order:',
	'order'					=> 'Order：',
	'confirm_order'			=> 'Can not modify to confirm',
	'invalid_order'			=> 'Can not modify to invalid',
	'cancel_order'			=> 'Can not modify to cancel',
	'remove_order'			=> 'Can not remove',
	'check_info' 			=> 'View details',
	
	/* Edit order to print template*/
	'edit_order_templates'	=> 'Edit order print template',
	'template_resetore'		=> 'Restore template',
	'edit_template_success'	=> 'Edit order print template operation successfully!',
	'remark_fittings'		=> '(Accessories)',
	'remark_gift'			=> '(Gift)',
	'remark_favourable'		=> '(Preferential products)',
	'remark_package'		=> '（Preferential Packeage）',
	
	/* The order source statistics*/
	'from_order'	=> 'Order source:',
	'from_ad_js'	=> 'Advertisement:',
	'from_goods_js'	=> 'The product stand the outside JS throw in',
	'from_self_site'=> 'Come from this station',
	'from'			=> 'Come from a station to order:',
	
	/* Add , edit order*/
	'add_order'		=> 'Add Order',
	'edit_order'	=> 'Edit order',
	
	'step' => array(
		'user'		=> 'Please select which menber is you want to order.',
		'goods'		=> 'Select product',
		'consignee'	=> 'Config consignee information',
		'shipping'	=> 'Select shipping method',
		'payment'	=> 'Payment method',
		'other'		=> 'Create other informations',
		'money'		=> 'Setting money',
	),
	
	'anonymous'		=> 'Guest',
	'by_useridname'	=> 'By member No. or username to search',
	'button_prev'	=> 'Prev',
	'button_next'	=> 'Next',
	'button_finish'	=> 'Completion',
	'button_cancel'	=> 'Cancel',
	'name'			=> 'Name',
	'desc'			=> 'Description',
	'shipping_fee'	=> 'Shipping money',
	'free_money'	=> 'Free limit',
	'insure'		=> 'Insrance money',
	'pay_fee'		=> 'Poundage',
	'pack_fee'		=> 'Packing expense',
	'card_fee'		=> 'The greeting card money',
	'no_pack'		=> 'Don\'t want a packing',
	'no_card'		=> 'Don\'t want a greeting card',
	'add_to_order'	=> 'Join order',
	'calc_order_amount'	=> 'Calculate total orders money',
	'available_surplus'	=> 'Can use balance:',
	'available_integral'=> 'Can use points:',
	'available_bonus'	=> 'Can use bonus:',
	'admin'				=> 'Addition by administrator',
	'search_goods'		=> 'Search by goods ID, name, No.:',
	'category'			=> 'Category',
	'label_category'	=> 'Category:',
	'brand'				=> 'Brand',
	'user_money_not_enough'	=> 'Customer blance shortage',
	'pay_points_not_enough'	=> 'Customer points shortage',
	'money_paid_enough'		=> 'Paid money is more than product total of money and various cost, please refund.',
	'price_note'		=> 'Notice:Have already included the attribute price markup in the goods price.',
	'select_pack'		=> 'Select packing',
	'select_card'		=> 'Select greeting card',
	'select_shipping'	=> 'Select shipping method',
	'want_insure'		=> 'I want to insurance',
	'update_goods'		=> 'Update goods',
	'notice_user'		=> '<Strong>Attention:</Strong>Search result only display the first 20 records, if didn\'t find correlative member, please search accurately. Moreover, if the member registers from the forum and don\'t register in shop, can\'t also find out, need register in the shop first.',
	'amount_increase'	=> 'Because you modified order, causing the total money of order increase, needing to be pay again.',
	'amount_decrease'	=> 'Because you modified order, causing the total money of order reduce, needing to be refund.',
	'continue_shipping'	=> 'Because you modified the consignee place region, causing to shipping method originally no longer can be used, please select shipping method again.',
	'continue_payment'	=> 'Because you modified the shipping method, causing to payment method originally no longer can be used, please select shipping method again.',
	'refund'			=> 'Refundment',
	'cannot_edit_order_shipped'	=> 'You can\'t modify the shipped order.',
	'address_list'				=> 'Select from existing consignee address:',
	'order_amount_change'		=> 'Total orders money from %s change into %s',
	'shipping_note'				=> 'Notice: Because the order has already shipped products, modify shipping method wouldn\'t change shipping money and insurance.',
	'change_use_surplus'		=> 'Edit orders %s, change the use of the advance payment',
	'change_use_integral'		=> 'Edit orders %s, change the use of the number of points paid',
	'return_order_surplus'		=> 'Because of canceled, invalid or return operation, returned to pay for the use of orders %s advances',
	'return_order_integral'		=> 'Because of canceled, invalid or return operation, returned to pay for the use of orders %s points',
	'order_gift_integral'		=> 'Order %s gift points',
	'return_order_gift_integral'=> 'Returns or because of shipping operations, returned to give orders for %s points',
	'invoice_no_mall'			=> '&nbsp;&nbsp;&nbsp;Divided a plurality of invoice No by ","',
	
	'js_lang' => array(
		'input_price'		=> 'Costom price',
		'pls_search_user'	=> 'Please search and select a user',
		'confirm_drop'		=> 'Confirm and delete the product?',
		'invalid_goods_number'	=> 'Product quantity inaccuracy',
		'pls_search_goods'		=> 'Please search and select product.',
		'pls_select_area'		=> 'Please select the area',
		'pls_select_shipping'	=> 'Please select shipping method.',
		'pls_select_payment'	=> 'Please select payment method.',
		'pls_select_pack'		=> 'Please select packing.',
		'pls_select_card'		=> 'Please select card.',
		'pls_input_note'		=> 'Please enter remarks.',
		'pls_input_cancel'		=> 'Please fill out the cancellation of the reasons!',
		'pls_select_refund'		=> 'Please select refundment method.',
		'pls_select_agency'		=> 'Please select an agency.',
		'pls_select_other_agency'	=> 'The order does belong to the agency selected. Please select another agency.',
		'loading'					=> 'Loading...',
		'confirm_merge'				=> 'Are you sure you want to merge these two order?',
		'remove_confirm'			=> 'All informations will be deleted if you delete the order. Are you sure delete it?',
		'merge_order_required'		=> 'You have not chosen to be merged orders!',
		'ok'						=> 'OK',
		'cancel'					=> 'Cancel',
		'operate_order_required'	=> 'Please select the order need to operate!',
		'select_user_empty'			=> 'Not search for users information',
		'select_goods_empty'		=> 'Not search for goods information',
		'no_goods_number'			=> 'No goods',
		'no_brand_name'				=> 'No brand',
		'market_price'				=> 'Market price',
		'goods_price'				=> 'Shop price',
		'custom_price'				=> 'Custom price',
		'no_other_attr'				=> 'No other attributes',
		'not_add_goods'				=> 'Did not add goods! Please add goods after search',
		'consignee_required'		=> 'Please fill in the consignee!',
		'email_required'			=> 'Please enter email!',
		'tel_required'				=> 'Please enter the phone number!',
		'address_required'			=> 'Please enter a detailed address!',
		'city_required'				=> 'Please select the area!',
		'shipping_required'			=> 'Please select the distribution mode!',
		'payment_required'			=> 'Please select the payment method!',
		'confirm'					=> 'Confirm',
		'pay'						=> 'Payment',
		'unpay'						=> 'Set Unpaid',
		'prepare'					=> 'Distribution',
		'unship'					=> 'Unshipped',
		'receive'					=> 'Received',
		'invalid'					=> 'Invalid',
		'after_service' 			=> 'Aftermarket',
		'return_goods'				=> 'Return goods',
		'refund'					=> 'Refund',
	),	
	
	'pls_select_agency'		=> 'Please select an agency',
	
	/* Order operate */
	'order_operate'			=> 'Order operate:',
	'label_refund_amount'	=> 'Refundment money:',
	'label_handle_refund'	=> 'Refundment method:',
	'label_refund_note'		=> 'Refundment note:',
	'return_user_money'		=> 'Return user balance',
	'create_user_account'	=> 'Create user\'s refundment application.',
		
	'not_handle'			=> 'Don\'t process, choose this item when made an error',
	'order_refund'			=> 'Order refundment: %s.',
	'order_pay'				=> 'Order payment: %s.',
	'send_mail_fail'		=> 'Send e-mail failure',
	'send_message'			=> 'Send/View message',
	'refund_error_notice'	=> 'Anonymous users cannot return a refund to the account balance!',
	'error_notice'			=> 'Operation error! Please re-operation!',
	
	/* 发货单操作 */
	'delivery_operate'		=> 'Invoice Operation:',
	'delivery_sn_number'	=> 'Serial number of Invoice:',
	'invoice_no_sms'		=> 'Input Invoice No.',
	
	/* 发货单搜索 */
	'delivery_sn'	=> 'Invoice',
	
	/* 发货单状态 */
	'delivery_status' => array(
		0	=> 'Normal',
		1	=> 'Refunded',
		2	=> 'Has shipped',
	),
	
	/* 发货单标签 */
	'label_delivery_status'	=> 'Invoice status',
	'label_suppliers_name' 	=> 'suppliers name',//追加
	'label_delivery_time'	=> 'Generation Time',
	'label_delivery_sn'		=> 'Invoice No.',
		
	'label_add_time'		=> 'Order time',
	'label_update_time'		=> 'Shipped time',
	'label_send_number'		=> 'Shipped quantity',
	
	/* 发货单提示 */
	'tips_delivery_del'	=> 'Delete invoice success!',
	
	/* 退货单操作 */
	'back_operate'		=> 'Returned Note Operation：',
	
	/* 退货单标签 */
	'return_time'		=> 'Returned time:',
	'label_return_time'	=> 'Returned time',
	
	/* 退货单提示 */
	'tips_back_del'		=> 'Return a single deletion of success!',
	'goods_num_err'		=> 'Out of stocks, please re-select!',
	
	//追加
	'action_user_two' 	=> 'Operator',
	'op' => array(
		'confirm'		=> 'Confirm',
		'pay'			=> 'Payment',
		'prepare'		=> 'Distribution',
		'ship'			=> 'Shipping',
		'cancel'		=> 'Cancel',
		'invalid'		=> 'Invalid',
		'return'		=> 'Refundment',
		'unpay'			=> 'Set Unpaid',
		'unship'		=> 'Unshipped',
		'cancel_ship'	=> 'Cancellation Shipping',
		'receive'		=> 'Received',
		'assign'		=> 'Assign to',
		'after_service'	=> 'Aftermarket',
		'remove'		=> 'Remove',
		'you_can'		=> 'The operation you can do',
		'split'			=> 'Generate delivery invoices',
		'to_delivery'	=> 'To delivery',
	),
	'shipping_not_need' 	=> 'Don\'t need shipping method',
	
	//订单状态
	'label_finished'		=> 'finished',
	'label_await_ship'		=> 'await to be shipped',
	'label_await_pay'		=> 'await to be paid',
	'label_await_confirm'	=> 'await to be confirmed',
	'label_canceled'		=> 'canceled',
		
	'order_back_list'				=>	'Refund Goods list',
	'return_look'					=>	'Return Goods Operation: View',
	'return_form'					=>	'Unable to find the corresponding single return',
	'no_invoice'					=>	'Unable to find the corresponding invoice consignee',
	'a_mistake'						=>	'A mistake',
	'bulk_operations'				=>	'Batch Operations',
	'confirm_delete'				=>	'Are you sure you want to remove these return form?',
	'pls_select_retun'				=>	'Please select a single operating return!',
	'pls_delivery_sn_number'		=>	'Please enter the invoice No.',
	'pls_consignee'					=>	'Please enter order sn or consignee',
	'search'						=>	'Search',
	'confirm_delete_one'			=>	'Are you sure you want to delete the returned list?',
	'look_order'					=>	'Check order',
	'display_consignee_info'		=>	'Display consignee information',
	'delivery_delete'				=>	'Are you sure you want to remove these invoices do?',
	'pls_select_delivery'			=>	'Please select the desired action invoice!',
	'filter'						=>	'Filter',
	
	'search_order_confirm'			=>	'Please re-search order does not exist',
	'pls_add_orders_user_type'		=>	'Please select the type of user to add orders',
	'pls_add_orders_user'			=>	'Select add member order',
	'add_order_goods_info'			=>	'Add order goods information',
	'confirm_shipping_address'		=>	'Confirm shipping address',
	'add_order_shipping'			=>	'Add delivery order',
	'add_order_payment'				=>	'Add An Order Of Payment',
	'add_order_other_info'			=>	'Add An Order Additional Information',
	'add_order_money_info'			=>	'Add An Order Cost Information',
	'order_ship'					=>	'Order has shipped! Can not modify the order (excluding shipping method and invoice number)',
	'edit_goods'					=>	'Edit Order product information',
	'edit_order_receiver'			=>	'Edit Order consignee information',
	'edit_order_shipping'			=>	'Edit Order Delivery',
	'edit_order_payment'			=>	'Edit Payment Order',
	'edit_order_other_info'			=>	'Edit order additional information',
	'edit_order_money_info'			=>	'Edit order cost information',
	'edit_order_ship'				=>	'Edit order invoice number',
	'pls_try_again'					=>	'Order generation failed, please try again',
	'log_edit_goods'				=>	'Edit goods,',
	'log_add_goods'					=>	'Add items,',
	'order_is'						=>	'Order Number is ',
	'update_order_ok'				=>	'Successfully updated your order',
	'pls_search_add'				=>	'You have not choose goods, to the order. Please search Oh!',
	'goods_add_order_ok'			=>	'Goods successfully joined in the Order',
	'log_edit_order'				=>	'Edit consignee, orders',
	'log_edit_shipping'				=>	'Edit distribution methods,',
	'log_edit_payment'				=>	'Edit payment methods,',
	'log_edit_money'				=>	'Edit cost information,',
	'log_edit_info'					=>	'Edit information, order number is ',
	'cancel_add_new_order'			=>	'Cancel Add new order',
	'order_operating'				=>	'Order: Generate invoices',
	'not_exist_order'				=>	'The order does not exist',
	'pls_other_remark'				=>	'Please leave notes and other information',
	'confirm_ok_order'				=>	'Confirm successful order:',
	'invalid_ok_order'				=>	'Invalid successful order:',
	'cancel_ok_order'				=>	'Success canceled orders:',
	'delete_ok_order'				=>	'Deleted successfully order:',
	'log_maybe_handle'				=>	'What you can do:',
	'unable_operation_order'		=>	'Unable to perform the operation orders',
	'delete_error'					=>	'failed to delete',
	'update_error'					=>	'Update failed',
	'no_special_grade'				=>	'Non-special grade',
	'not_member_inf_found'			=>	'Relevant member information not found',
	'no_phone_number'				=>	'No phone number',
	'unverified'					=>	'Unverified',
	'verified'						=>	'Verified',
	
	'confirm_approval_order'		=>	'Are you sure you want to approve the order?',
	'pls_select_order'				=>	'Please select the order to be operated',
	'confirm_order_invalid'			=>	'Are you sure you need to do is set inactive these orders?',
	'confirm_order_cancel'			=>	'Are you sure you want to cancel the order?',
	'search_order'					=>	'Search orders',
	'user_purchase_information'		=>	'User information',
	'confirm_delete_order'			=>	'Are you sure you want to delete this order?',
	
	'no_order_operation_record'		=>	'The order no operating record',
	'pls_order_id'					=>	'Please enter your order number or order id',
	'invoice_information'			=>	'Invoice information',
	'product_thumbnail'				=>	'Thumbnail',
	'warehouse_name'				=>  'Warehouse',
	'order_no_goods'				=>	'There is no goods in this order',
	'operation_record'				=>	'Operation record',
	'order_operate_list' 			=> 	'Order operation',
	'self_support'					=>  'Self-support',
	'merchants_name'				=>  'Merchants name',
	'main_order'					=>  '(Main order)',
	'child_order'					=>  '(Child order)',
	
	'start_time' 					=> 	'Starting time',
	'end_time' 						=> 	'End Time',
	'to' 							=> 	'To',
	'shipping_address_information'	=>	'Shipping address information',
	'country_lable'					=>	'Country:',
	'province_and_city_lable'		=>	'Province / City:',
	'city_lable'					=>	'City:',
	'area_lable'					=>	'Area:',
	'shipping_payment'				=>	'Delivery / Payment',
	'no_correspondence'				=>	'You may not have plug-ins or add delivery consignee address information! No corresponding Delivery!',
	'buy_select'					=>	'The user selects purchase',
	'order_goods_select'			=>	'Order goods selection',
	'payment_delivery'				=>	'Payment / Delivery',
	'claim_costs'					=>	'Claim costs',
	'member_user'					=>	'Member User',
	'user_email_search'				=>	'Search by member\'s mailbox or member name:',
	'pls_keywords'					=>	'Please enter keywords',
	'search_user_list'				=>	'Search for members, to search members will appear below the list box. Click on the list of options, blue background is selected.',
	'filter_information_members'	=>	'Filter information to members',
	'no_content_yet'				=>	'No content yet',
	'member_info'					=>	'member information',
	'member_name_lable'				=>	'Member Name:',
	'member_email_lable'			=>	'Member E-mail:',
	'member_iphone_lable'			=>	'Member Phone:',
	'member_rank_lable'				=>	'Membership level:',
	'registration_time'				=>	'Registration time:',
	'email_verification'			=>	'E-mail verification:',
	'last_login_time'				=>	'last login time:',
	'last_login_ip'					=>	'Last Login IP:',
	'confirm_delete_order_goods'	=>	'Are you sure you want to delete your order it?',
	'filter_information_goods'		=>	'Filter to goods information',
	'goods_sn_lable' 				=> 	'Item:',
	'commodity_stocks_lable' 		=> 	'Stock:',
	'commercial_property' 			=> 	'Goods Property',
	'region_list' 					=> 	'Region',
	'iphone'						=>	'Telephone / Cell phone',
	'default_shipping_address'		=>	'(Default shipping address)',
	'fill_in_shipping_address'		=>	'Fill in shipping address',
	'address_lable'					=>	'Address:',
	'invoice_related'				=>	'Invoice related',
	'message_remarks'				=>	'Message / Remarks',
	'remove_confirm' 				=> 	'Remove orders will erase everything from the order. Are you sure you want to do this?',

	//催单列表
    'list_oder_sn'					=> 'Order sn',
    'list_consignee_address'		=> 'Consignee address',
    'list_audit_status'				=> 'Audit status',
    'lsit_reminder'					=> 'Reminder time',
    'reminder_list'					=> 'Reminder list',
    'processed'						=> 'Processed',
    'untreated'						=> 'Untreated',
    
    'order_manage'			=> 'Order',
    'order_list'			=> 'Order List',
    'order_query'			=> 'Order Query',
    'merge_order'			=> 'Merge Order',
    'order_delivery_list'	=> 'Invoice List',
    'order_reminder_list'	=> 'Reminder list',
    
    'order_ss_edit'			=> 'Edit Shipment Status',
    'order_ps_edit'			=> 'Edit Payment Status',
    'order_os_edit'			=> 'Edit Order Status',
    'order_edit'			=> 'Add Edit Order',
    'order_view'			=> 'View Not Completed Order',
    'order_view_finished'	=> 'View Completed Order',
    'repay_manage'			=> 'Refund Application Management',
    'booking_manage'		=> 'Out Of Stock Registration Management',
    'sale_order_stats'		=> 'Order Sales Statistics',
    'client_flow_stats'		=> 'Customer Traffic Statistics',
    'delivery_view'			=> 'Check The Invoice',
    'back_view'				=> 'View Return Order',
    'remind_order_view'		=> 'Reminder List',
    
    'guest_stats'			=> 'Customer Statistics',
    'order_stats'			=> 'Order Statistic',
    'sale_general_stats' 	=> 'Sales Overview',
    'users_order_stats'		=> 'Member Ranking',
    'sale_list_stats'		=> 'Sales Details',
    'sale_order_stats'		=> 'Sales Ranking',
    'visit_sold_stats'		=> 'Access Purchase Rate',
    'adsense_conversion_stats' => 'AD Conversion Rate',
    
    'invalid_parameter'		=> 'Invalid parameter',
    'etc'					=> 'etc',
    'kind_of_goods'			=> 'Kinds of goods',
    'check_money_fail_info'	=> '[The amount paid is incorrect]: the amount paid is incorrect.',
    'check_money_fail'		=> 'The amount paid is incorrect.',
    'pay_log_id'			=> '[payment log ID]:',
    'pay_status'			=> 'Payment status',
    'buyers'				=> 'Buyers',
    'new_order_notice'		=> 'New order notice: you have',
    'order_and'				=> 'new orders and',
    'new_pay_order'			=> 'new orders for payment.',
    'click_view'			=> 'Click to view',
    'new_order'				=> 'New Order',
    'order_stats_info'		=> 'Order Statistics',
    
    'overview'				=> 'Overview',
    'more_info'             => 'More information:',
    
    'order_back_help'		=> 'You are welcome to visit the ECJia intelligent background return list page, the system will display all the returns in this list.',
    'about_order_back'		=> 'On the return of a single list to help document',
    
    'order_delivery_help'	=> 'Welcome to ECJia intelligent background invoice list page, the system will display all the invoices in this list.',
    'about_order_delivery'	=> 'About Delivery traveling trader working on his own list of help document',
    
    'delivery_info_help'	=> 'Welcome to ECJia intelligent background invoice details page, on this page you can view information about the invoice details.',
    'about_delivery_help'	=> 'About the invoice details help document',

    'order_reminder_help'	=> 'Welcome to ECJia intelligent background delivery reminder list page displays the buyer\'s dunning situation.',
    'about_order_reminder'	=> 'About Delivery remind list help document',
    
    'no_delivery_order'		=> 'Unable to find the corresponding invoice!',
    'order_operate_view'	=> 'Invoice: check',
    'no_delivery_consigness'=> 'Could not find the corresponding delivery order consignee!',
    'operate_error'			=> 'Operation error!',
    
    'order_list_help'		=> 'Welcome to ECJia intelligent background order list page, all the orders in the system will be displayed in this list.',
    'about_order_list'		=> 'About order list help document ',
    
    'order_info_help'		=> 'Welcome to ECJia intelligent background order details page, this page can view all the information about the order.',
    'about_order_info'		=> 'About details of the order help document ',
    
    'order_query_help'		=> 'Welcome to ECJia intelligent background order query page, enter the order information on this page can query the operation of the order.',
    'about_order_query'		=> 'About order inquiry help document ',
    
    'order_merge_help'		=> 'Welcome to ECJia intelligent background merge order page, this page can be combined with the order.',
    'about_order_merge'		=> 'About merge order help document',
    
    'add_order_help'		=> 'Welcome to ECJia intelligent background to add the order page, this page can be added to the operation of the order.',
    'about_add_order'		=> 'About add order help document',
    
    //仪表盘中模块
    'more'					=> 'More',
    'order_operatio'		=> 'Order Operation: Refund',
    
    'not_shipping_orders'	=> 'Not shipping orders',
    'unconfirmed_orders'	=> 'Unconfirmed orders',
    'unpaid_orders'			=> 'Unpaid orders',
    'finished_orders'		=> 'Finished orders',
    'booking'				=> 'Booking [New]',
    'refund_application'	=> 'Refund application',
    'parts_delivery_order'	=> 'Parts delivery orders',
    
    'yuan'					=>	'Yuan',
    'monad'					=>	'Monad',
    'order_money'			=>	'Total orders this month',
    'order_count'			=>	'This month the number of orders',
    'confirm_order'			=>	'Order today to be confirmed',
    'today_order'			=>	'Pending orders shipped today',
);

//end