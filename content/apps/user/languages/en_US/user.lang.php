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
 * ECJIA User center foreground language entry
 */
return array(
	'require_login'		=> 'Illegal entry.<br />You can\'t finish the operation until login.',
	'no_records'		=> 'No record',
	'shot_message'		=> "Short message",
		
	/* 用户菜单 */
	'label_welcome'		=> 'Welcome',
	'label_profile'		=> 'My Information',
	'label_order'		=> 'My Order',
	'label_address'		=> 'Consignee Address',
	'label_message'		=> 'My Feedback',
	'label_tag'			=> 'My Tag',
	'label_collection'	=> 'My Favorite',
	'label_bonus'		=> 'My Bonus',
	'label_comment'		=> 'My comment',
	'label_affiliate'	=> 'My recommendation',
	'label_group_buy'	=> 'My Associates',
	'label_booking'		=> 'Booking Records',
		
	'label_user_surplus'	=> 'Account Details',
	'label_track_packages'	=> 'Tracking packages',
	'label_transform_points'=> 'Points transform',
	'label_logout'			=> 'Logout',
	
	/* 会员余额(预付款) */
	'add_surplus_log'	=> 'Details',
	'view_application'	=> 'View application record',
	'surplus_pro_type'	=> 'Type',
	'repay_money'		=> 'Refund money',
	'money'				=> 'Quantity',
	'surplus_type_0'	=> 'Advance payment',
	'surplus_type_1'	=> 'Apply for refund',
	'deposit_money'		=> 'Payment',
	'process_notic'		=> 'Member remarks',
	'admin_notic'		=> 'Admin remarks',
	'submit_request'	=> 'Submi',
	'process_time'		=> 'Time',
	'use_time'			=> 'Use time',
	'is_paid'			=> 'Status',
	'is_confirm'		=> 'Confirmed',
	'un_confirm'		=> 'Unconfirmed',
		
	'pay'				=> 'Payment',
	'is_cancel'			=> 'Cancel',
	'account_inc'		=> 'Increase',
	'account_dec'		=> 'Decrease',
	'change_desc'		=> 'Description',
	'surplus_amount'	=> 'Your advance payment is:',
	'payment_name'		=> 'The payment method of yours is:',
	'payment_fee'		=> 'Poundage is:',
	'payment_desc'		=> 'Description of payment method:',
		
	'current_surplus'	=> 'Description of payment method:',
	'unit_yuan'			=> 'Yuan',
	'for_free'			=> 'For free',
		
	'surplus_amount_error'	=> 'Error, the refundment of your application is more than existing money!',
	'surplus_appl_submit'	=> 'Refundment of your application is submitted successfully, please wait for check!',
	'process_false'			=> 'Operate failed, please try it again.',
	'confirm_remove_account'=> 'Are you sure delete this record?',
	'back_page_up'			=> 'Previous',
	'back_account_log'		=> 'Back to account details list',
	'amount_gt_zero'		=> 'Enter numbers bigger than zero in Amount',
	'select_payment_pls'	=> 'Select payment mode',
		
	//JS语言项
	'account_js' => array(
		'surplus_amount_empty'	=> 'Please enter a money amount!',
		'surplus_amount_error'	=> 'Please enter a valid amount!',
		'process_desc'			=> 'Please enter remarks!',
		'payment_empty'			=> 'Please select a payment method!',
	),

	/* 缺货登记 */
	'oos_booking'		=> 'Booking records',
	'booking_goods_name'=> 'Name',
	'booking_amount'	=> 'Quantity',
	'booking_time'		=> 'Time',
	'process_desc'		=> 'Remarks',
	'describe'			=> 'Description',
	'contact_username'	=> 'Contact',
	'contact_phone'		=> 'Phone',
	'submit_booking_goods'	=> 'Submit',
	'booking_success'		=> 'Your product order have submitted successfully!',
	'booking_rec_exist'		=> 'The product you have already booked!',
	'back_booking_list'		=> 'Return to booking records list',
	'not_dispose'			=> 'Undisposed',
	'no_goods_id'			=> 'Please appoint to product ID.',
	
	//JS语言项
	'booking_js' => array(
		'booking_amount_empty'=> 'Please enter a quantity of products!',
		'booking_amount_error'=> 'Please enter a valid format of quantity!',
		'describe_empty'=> 'Please enter a description of your order!',
		'contact_username_empty'=> 'Please enter a username!',
		'email_empty'=> 'Please enter a email address!',
		'email_error'=> 'Please enter a valid email address!',
		'contact_phone_empty'=> 'Please enter a telephone number!',
	),
	
	/* 个人资料 */
	'confirm_submit'	=> 'Submit',
	'member_rank'		=> 'Member rank',
	'member_discount'	=> 'Member discount',
	'rank_integral'		=> 'Rank points',
	'consume_integral'	=> 'Consume points',
	'account_balance'	=> 'Account balance',
	'user_bonus'		=> 'User bonus',
	'user_bonus_info'	=> 'Total %d, value %s',
	'not_bonus'			=> 'No bonus',
	'add_user_bonus'	=> 'Add',
	'bonus_number'		=> 'Bonus NO.',
	'old_password'		=> 'Primary password',
	'new_password'		=> 'New password',
	'confirm_password'	=> 'Re-enter password',
	
	'bonus_sn_exist'	=> 'The bonus NO. already exists.',
	'bonus_sn_not_exist'=> 'The bonus NO. is nonexistent!',
	'add_bonus_sucess'	=> 'Successfully!',
	'add_bonus_false'	=> 'Failure!',
	
	'not_login'			=> 'Please login firstly',
	'profile_lnk'		=> 'View My Profile',
	'edit_email_failed'	=> 'Edit email address failed.',
		
	'edit_profile_success'	=> 'Your profile has edited successfully!',
	'edit_profile_failed'	=> 'Edit profile failed!',
	'oldpassword_error'		=> 'Wrong, please enter a valid primary password!',
		
	//JS语言项
	'profile_js' => array(
		'bonus_sn_empty'          => 'Please enter a bonus NO. that you want to add!',
		'bonus_sn_error'          => 'Please enter a valid bonus NO.!',
		'email_empty'             => 'Please enter your email address!',
		'email_error'             => 'Please enter a valid email address!',
		'old_password_empty'      => 'Please enter your primary password.',
		'new_password_empty'      => 'Please enter the new password!',
		'confirm_password_empty'  => 'Re-enter password !',
		'both_password_error'     => 'The two passwords you entered did not match. Please type it again!',
		'msg_blank'               => 'is blank',
		'no_select_question'      => '- You do not complete the operation password prompt problem',
	),

	/* 支付方式 */
	'pay_name'	=> 'Name',
	'pay_desc'	=> 'Description',
	'pay_fee'	=> 'Poundage',
	
	/* 收货地址 */
	'consignee_name'	=> 'Name',
	'country_province'	=> 'Country/Province',
	'please_select'		=> 'Please select...',
	'city_district'		=> 'City/District',
	'email_address'		=> 'Email',
	'detailed_address'	=> 'Email',
		
	'postalcode'		=> 'Postalcode',
	'phone'				=> 'Phone',
	'mobile'			=> 'Mobile telephone',
	'backup_phone'		=> 'Another phone',
	'sign_building'		=> 'Sign building',
		
	'deliver_goods_time'	=> 'Optimal shipping time',
	'default'				=> 'Default',
	'default_address'		=> 'Default address',
		
	'yes'					=> 'Yes',
	'no'					=> 'No',
	'country'				=> 'Country',
	'province'				=> 'Province',
	'city'					=> 'City',
	'area'					=> 'Area',
	
	'search_ship'			=> 'Search shipping methods',
	'del_address_false'		=> 'Delete failed!',
	'add_address_success'	=> 'Add successfully!',
	'edit_address_success'	=> 'Your shipping address information has already modified successfully!',
	'address_list_lnk'		=> 'Return the address list',
	'add_address'			=> 'Add a new place of receipt',
	'confirm_edit'			=> 'Submit',
	'confirm_drop_address'	=> 'Are you sure delete the place of receipt?',
		
	/* 会员密码找回 */
	'username_and_email'	=> 'Please enter your username and email address.',
	'enter_new_password'	=> 'Please enter your new password:',
	'username_no_email'		=> 'Please username and email must match. Please type it again.',
	'fail_send_password'	=> 'Failure, please contact with administrator!',
	'send_success'			=> 'Changed password has sent to your emailbox:',
	'parm_error'			=> 'Error, Please return!',
	'edit_password_failure'	=> 'The original password inaccuracy of your importation',
	'edit_password_success'	=> 'Change password successfully!',
	'username_not_match_email'	=> 'Username or password is wrong, please type it again!',
	'get_question_username'		=> 'Please enter your registered user name to get your password question.',
	'no_passwd_question'		=> 'You do not set the password question, can not retrieve your password in this way.',
	'input_answer'				=> 'Please input the answer setted by the question you choosed in the registering time',
	'wrong_passwd_answer'		=> 'You entered a wrong answer',
	
	//JS语言项
	'password_js' => array(
		'user_name_empty'		=> 'Please enter your username!',
		'email_address_empty'	=> 'Please enter your email address!',
		'email_address_error'	=> 'Please enter a valid email address!',
		'new_password_empty'	=> 'Please enter a new password!',
		'confirm_password_empty'=> 'Re-enter the password!',
		'both_password_error'	=> 'The two passwords you entered did not match. Please type it again!',
	),
	
	/* 会员留言 */
	'message_title'	    => 'Title',
	'message_time'	    => 'Message time',
	'reply_time'	    => 'Reply time',
	'shopman_reply'	    => 'Reply of the shop owner',
	'send_message'	    => 'Send message',
	'message_type'	    => 'Feedback type',
	'message_content'	=> 'Contents',
	'submit_message'	=> 'Submit',
	'upload_img'		=> 'Upload file',
	'img_name'			=> 'Image name',
		
	/* 留言类型 */
	'type' => array(
		M_MESSAGE	=> 'Message',
		M_COMPLAINT	=> 'Complaint',
		M_ENQUIRY	=> 'Enquiry',
		M_CUSTOME	=> 'Aftersales',
		M_BUY		=> 'I want to buy...',
		M_BUSINESS	=> 'Business message',
	),
	
	'add_message_success'	=> 'Publish message successfully!',
	'message_list_lnk'		=> 'Return to the message list',
	'msg_title_empty'		=> 'The title is blank',
	'upload_file_limit'		=> 'File larger than %dKB',
	
	'img_type_tips'	        => '<font color="red">TIP:</font>',
	'img_type_list'	        => 'You can upload file type as follows:<br />gif、jpg、png、word、excel、txt、zip、ppt、pdf',
	'view_upload_file'	    => 'View the upload file',
	'upload_file_type'	    => 'Please upload a valid file type, please upload again!',
	'upload_file_error'	    => 'Wrong, please upload again!',
	'message_empty'		    => 'You hasn\'t message as yet!',
	'msg_success'		    => 'Your message have submitted  successfully!',
	'confirm_remove_msg'    => 'Are you sure delete those messages?',
	
	/* 会员红包 */
	'bonus_is_used'			=> 'The bonus has used.',
	'bonus_is_used_by_other'=> 'The bonus has used by others.',
	'bonus_add_success'		=> 'Add a new bonus successfully.',
	'bonus_not_exist'		=> 'The bonus is nonexistent.',
	'user_bonus_empty'		=> 'You have no bonus now',
	'add_bonus_sucess'		=> 'Add new bonus operate successfully!',
	'add_bonus_false'		=> 'Add new bonus operate failure!',
	'bonus_add_expire'		=> 'Bonus expired!',
	'bonus_use_expire'		=> 'Bonus expired!',
		
	/* 会员订单 */
	'order_list_lnk'	=> 'My order list',
	'order_number'		=> 'NO.',
	'order_addtime'		=> 'Time',
	'order_money'		=> 'Total',
	'order_status'		=> 'Status',
	'first_order'		=> 'First orde',
	'second_order'		=> 'Secondary order',
	'merge_order'		=> 'Combine orders',
	'no_priv'		=> 'You have no authorization to operate others\' order.',
	'buyer_cancel'	=> 'Buyer cancel',
	'cancel'		=> 'Cancel order',
	'pay_money'		=> 'Payment',
	'view_order'	=> 'View order',
	'received'		=> 'Received',
	'ss_received'	=> 'Deal succeeds',
	'confirm_cancel'=> 'Are you sure cancel this order? After canceled this order will be invalid.',
	'merge_ok'		=> 'Combine orders successfully!',
		
	'merge_invalid_order'=> 'Sorry, the orders can\'t be combined.',
		
	'select'		=> 'Select...',
	'order_not_pay'	=> "Your order status is %s, so you don\'t payment.",
	'order_sn_empty'=> 'Please enter NO. of combined main order',
		
	'merge_order_notice'	=> 'Combine orders refers to consolidating the orders in the same condition into a new order.<br />Address and shipping method depend on the main order.',
	'order_exist'			=> 'The order is nonexistent!',
	'order_is_group_buy'	=> '[Associates]',
	'order_is_exchange'		=> '[Points Mall]',
	'gb_deposit'			=> '(Bail)',
		
	'notice_gb_order_amount'=> '(Remarks: If associates with insurance, the insurance and corresponding pay need to be paid in first payment.)',
	'business_message'		=> 'Send/view business message',
	'pay_order_by_surplus'	=> 'Pay order by balance:%s',
	'return_surplus_on_cancel'	=> 'Cancel order %s,return advancedly payed balance for order',
	'return_integral_on_cancel'	=> 'Cancel order %s,return points payed for order',
	
	/* 订单状态 */
	'os' => array(
		OS_UNCONFIRMED		=> 'Unconfirmed',
		OS_CONFIRMED		=> 'Confirmed',
		OS_SPLITED			=> 'Confirmed',
		OS_SPLITING_PART	=> 'Confirmed',
		OS_CANCELED			=> 'Canceled',
		OS_INVALID			=> 'Invalid',
		OS_RETURNED			=> 'Returned purchase',
	),	
		
	'ss' => array(
		SS_UNSHIPPED	=> 'Unshipped',
		SS_PREPARING	=> 'Preparing',
		SS_SHIPPED		=> 'Shipped',
		SS_RECEIVED		=> 'Received',
		SS_SHIPPED_PART	=> 'Shipped(part of all)',
		SS_SHIPPED_ING	=> 'Preparing', // 已分单
	),
	
	'ps' => array(
		PS_UNPAYED	=> 'Unpaid',
		PS_PAYING	=> 'Paying',
		PS_PAYED	=> 'Payed',
	),
	
	'shipping_not_need'				=> 'Don\'t need shipping method.',
	'current_os_not_unconfirmed'	=> 'Current order status is not [Unconfirmed].',
	'current_os_already_confirmed'	=> 'Please communicate with communicate with shopkeeper since current order has been confirmed and not canceled.',
	'current_ss_not_cancel'			=> 'You can cancel the order before shipping and communicate with shopkeeper.',
	'current_ps_not_cancel'			=> 'You can\'t cancel the order until non-payment, if you want to cancel it please contact with shop owner.',
	'confirm_received'				=> 'Are you sure you have received the products?',
	
	/* 合并订单及订单详情 */
	'merge_order_success'	=> 'Combine orders successfully!',
	'merge_order_failed'	=> 'Combine orders has failed! Please type it again!',
	'order_sn_not_null'		=> 'Please enter orders NO. that you want to combine.',
	'two_order_sn_same'		=> 'The two NO. that you want to combine must be different.',
	'order_not_exist'		=> "The order %s is nonexistent",
	'os_not_unconfirmed_or_confirmed'	=> " %s order status isn\'t [Unconfirmed] or [Confirmed].",
	'ps_not_unpayed'					=> "The payment status of %s isn\'t [Unpaid].",
	'ss_not_unshipped'					=> "The shipping status of %s isn\'t [Unshipped].",
	'order_user_not_same'				=> 'You can\'t combine those orders because they aren\'t belong to a user.',
		
	'from_order_sn'			=> 'First order NO.',
	'to_order_sn'			=> 'Secondary order NO.:',
	'merge'					=> 'Merge',
	'notice_order_sn'		=> 'The combined information of the order form(such as payment method, shipping method packaging,card,bonus etc) will be correct information, if there are some distinction between two order forms.',
	'subtotal'				=> 'Subtotal',
	'goods_price'			=> 'Price',
	'goods_attr'		=> 'Attribute',
	'use_balance'		=> 'Balance',
	'order_postscript'	=> 'Order postscript',
	'order_number'		=> 'NO.',
	'consignment'		=> 'Consignment',
	'shopping_money'	=> 'Total price',
	'invalid_order_id'	=> 'Invalid order number',
		
	'shipping'			=> 'Shipping type',
	'payment'			=> 'payment method',
	'use_pack'			=> 'Packaging',
	'use_card'			=> 'Card',
		
	'order_total_fee'	=> 'Total money',
	'order_money_paid'	=> 'Paid money',
	'order_amount'		=> 'Payable money',
	'accessories'		=> 'Payable money',
	'largess'			=> 'Gift',
	'use_more_surplus'	=> 'Use Balance',
	'max_surplus'		=> '(Account balance: %s)',
	'button_submit'		=> 'OK',
	'order_detail'		=> 'Order Detail',
		
	'error_surplus_invalid'		=> 'Please enter a valid number.',
	'error_order_is_paid'		=> 'The order is already paid.',
	'error_surplus_not_enough'	=> 'You have not enough balance.',
	
	/* 订单状态 */
	'detail_order_sn'		=> 'You have not enough balance.',
	'detail_order_status'	=> 'Status',
	'detail_pay_status'		=> 'Payment status',
	'detail_shipping_status'=> 'Shipping status',
	'detail_order_sn'		=> 'NO.',
	'detail_to_buyer'		=> 'Buyer message',
	
	'confirm_time'		=> 'Confirmation time is %s',
	'pay_time'			=> 'Payment time is %s',
	'shipping_time'		=> 'Shipping time %s',
	
	'select_payment'	=> 'Payment method',
	'order_amount'		=> 'Sum payable',
	'update_address'	=> 'Update consignee address',
	'virtual_card_info'	=> 'Virtual card infomation',
	
	/* 取回密码 */
	'back_home_lnk'		=> 'Return to HOME page.',
	'get_password_lnk'	=> 'Return to get the password page.',
	'get_password_by_question'	=> 'Fimd back your password by a password question',
	'get_password_by_mail'		=> 'Fimd back your password by Email',
	'back_retry_answer'			=> 'back and retry',
	
	/* 登录 注册 */
	'label_username'	=> 'Username',
	'label_email'		=> 'email',
	'label_password'	=> 'Password',
	'label_confirm_password'	=> 'Re-enter password',
	'label_password_intensity'	=> 'Password intensity',
		
	'want_login'			=> 'I have a username, and I will login.',
	'other_msn'				=> 'MSN',
	'other_qq'				=> 'QQ',
		
	'other_office_phone'	=> 'Office phone',
	'other_home_phone'		=> 'Home phone',
	'other_mobile_phone'	=> 'Mobile phone',
	'remember'				=> 'Remember my login information.',
	'msg_un_blank'			=> 'Username is blank',
	'msg_un_length'			=> 'Username cannot exceed 7 Chinese charaters',
	'msg_un_format'			=> 'Username has invalid charater',
	'msg_un_registered'		=> 'Username exists, please register again',
	'msg_can_rg'			=> 'Register',
	'msg_email_blank'		=> 'Email address is blank',
	'msg_email_registered'	=> 'Email exists, please enter again',
	'msg_email_format'		=> 'Email address is unvalid',
	'login_success'			=> 'Login successfully.',
	'confirm_login'			=> 'Enter',
	'profile_lnk'			=> 'View my profile.',
	'login_failure'			=> 'Username or password is wrong.',
	'relogin_lnk'			=> 'Return',
	
	'sex'				=> 'Sex',
	'male'				=> 'Male',
	'female'			=> 'Female',
	'secrecy'			=> 'Secrecy',
	'birthday'			=> 'Birthday',
	'logout'			=> 'You logout successfully.',
	
	'username_empty'		=> 'Username is blank.',
	'username_invalid'		=> 'Username %s contains sensitive characters.',
	'username_exist'		=> '%s already exists',
	'username_not_allow'	=> 'Username %s not allow',
	'confirm_register'		=> 'Submit',
	
	'agreement'			=> "I have read and agree with《<a href=\"article.php?cat_id=-1\" style=\"color:blue\">User agreement</a>》",
	'email_empty'		=> 'Email is blank',
	'email_invalid'		=> '%s is invalid email address.',
	'email_exist'		=> '%s already exists.',
	'email_not_allow'	=> 'Email %s not allow',
	'register'			=> 'Register.',
	'register_success'	=> '%s register successfully.',
	'passwd_question'	=> 'Password Question',
	'sel_question'		=> 'Please choose a password prompt problem',
	'passwd_answer'		=> 'Password question answer',
	'passwd_balnk'		=> 'Password can`t have blank',
	
	/* 用户中心默认页面 */
	'welcome_to'	=> 'Welcome back to',
	'last_time'		=> 'Your login last time is',
	'your_account'	=> 'Account',
	'your_notice'	=> 'Notice',
	'your_surplus'	=> 'Balance',
	'credit_line'	=> 'Credit line',
	'your_bonus'	=> 'Bonus',
	'your_message'	=> 'Message',
	'your_order'	=> 'Orders',
	'your_integral'	=> 'Points',
	'your_level'	=> 'Your rank: %s ',
	'next_level'	=> ',you need %s points to reach next level %s ',
	'attention'		=> 'attention',
	'no_attention'	=> 'Cancel attention',
	'del_attention'	=> 'Are you sure to cancel attention?',
	'add_to_attention'	=> 'Are you sure to add the goods to attention list?',
	'label_need_image'	=> 'Display image:',
		
	'need'				=> 'Display',
	'need_not'			=> 'No display',
	'horizontal'		=> 'Horizontal',
	'verticle'			=> 'Vertical',
	'generate'			=> 'Code generated',
		
	'label_goods_num'	=> 'Display goods quantiy:',
	'label_rows_num'	=> 'Shows that the number of entries arranged：',
	'label_arrange'		=> 'Goods arrange:',
	'label_charset'		=> 'Select charset:',
		
	'charset' => array(
		'utf8'	=> 'Internationalized charset(utf8)',
		'zh_cn'	=> 'Simple Chinese',
		'zh_tw'	=> 'Traditional Chinese',
	),
	
	'goods_num_must_be_int'	=> 'Goods quantity should be integral',
	'goods_num_must_over_0'	=> 'Goods quantity must be over 0',
	'rows_num_must_be_int'	=> 'Order entry shows that the number is an integer',
	'rows_num_must_over_0'	=> 'Order entry shows that the number should be greater than 0',
	
	'last_month_order'	=> 'In recent 30 days, your have submitted  ',
	'order_unit'		=> ' order(s)',
	'please_received'	=> 'The oreders has shipped, please give attention to receive.',
	'your_auction'		=> 'You bid for <strong>%s</strong> ，go to <a href="auction.php?act=view&amp,id=%s"><span style="color:#06c,text-decoration:underline,"> to buy </span></a>',
	'your_snatch'		=> 'You bid in Dutch Auction for <strong>%s</strong> ，go to <a href="snatch.php?act=main&amp,id=%s"><span style="color:#06c,text-decoration:underline,"> to buy </span></a>',
	
	/* 我的标签 */
	'no_tag'			=> 'No tag',
	'confirm_drop_tag'	=> 'Are you sure delete the tag?',
	
	/* user_passport.dwt js语言文件 */
	'passport_js' => array(
		'username_empty'			=> '- Please enter username.',
		'username_shorter'			=> '- Username length can\'t less than 3 characters.',
		'username_invalid'			=> '- Username only can be composed of letters, figure and underline.',
		'password_empty'			=> '- Please enter password.',
		'password_shorter'			=> '- Password can\'t less than 6 characters.',
		'confirm_password_invalid'	=> '- The two passwords you entered did not match.',
		'email_empty'				=> '- Email can\'t be blank.',
		'email_invalid'				=> '- Email isn\'t a legal address.',
		'agreement'					=> '- You do not agree with the agreement',
		'msn_invalid'				=> '- msn address is invalid',
		'qq_invalid'				=> '- QQ number is invalid',
		'home_phone_invalid'		=> '- Home phone No. is invalid',
		'office_phone_invalid'		=> '- Office phone No. is invalid',
		'mobile_phone_invalid'		=> '- Mobile No. is invalid',
		'msg_un_blank'				=> '* Username is blank',
		'msg_un_length'				=> '* Username should not exceed 7 Chinese characters',
		'msg_un_format'				=> '* Username contain invalid characters',
		'msg_un_registered'			=> '* Username exists, please enter again',
		'msg_can_rg'				=> '* You can register',
		'msg_email_blank'			=> '* Email address is blank',
		'msg_email_registered'		=> '* Mail-box exists, please enter again',
		'msg_email_format'			=> '* Email address is invalid',
		'msg_blank'					=> 'is blank',
		'no_select_question'		=> '- You have not finished the password question operation',
		'passwd_balnk'				=> '- The password entered can`t have blank',
	),

	/* user_clips.dwt js 语言文件 */
	'clips_js' => array(
		'msg_title_empty'	=> 'Title message is blank.',
		'msg_content_empty'	=> 'Message content is blank.',
		'msg_title_limit'	=> 'Message title should not exceed 200 charaters',
	),
	
	/* 合并订单js */
	'merge_order_js' => array(
		'from_order_empty'	=> 'Please select secondary orders you want to combine.',
		'to_order_empty'	=> 'Please select the first order you want to combine.',
		'order_same'		=> 'The first order same with secondary order, please select again.',
		'confirm_merge'		=> 'Are you sure to merge the two orders?',
	),
	
	/* 将用户订单中商品加入购物车 */
	'order_id_empty'			=> 'Unspecified order NO.',
	'return_to_cart_success'	=> 'The product of orders have added in your cart.',
	
	/* 保存用户订单收货地址 */
	'consigness_empty'		=> 'Consignee name is blank.',
	'address_empty'			=> 'Place of receipt is blank.',
	'require_unconfirmed'	=> 'You can\'t rechange in the status.',
	
	/* 红包详情 */
	'bonus_sn'			=> 'NO. ',
	'bonus_name'		=> 'Name ',
	'bonus_amount'		=> 'Money ',
	'min_goods_amount'	=> 'Minimum goods amount',
	'bonus_end_date'	=> 'Deadline ',
	'bonus_status'		=> 'Status',
	
	'not_start'	=> 'Not start',
	'overdue'	=> 'Overdue',
	'not_use'	=> 'Unused',
	'had_use'	=> 'Used',
	
	/* 用户推荐 */
	'affiliate_mode'	=> 'Affiliate mode',
	'affiliate_detail'	=> 'Affiliate Detail',
	'affiliate_member'	=> 'Affiliate Member',
	'affiliate_code'	=> 'Affiliate Code',
	'firefox_copy_alert'=> "Your firefox security restrictions limit your clipboard to carry out the operation, open 'about: config' to signed.applets.codebase_principal_support 'is set to true' try again later",
		
	'affiliate_type' => array(
		0	=> 'Recommended registeration affiliate',
		1	=> 'Recommended order affiliate',
		-1	=> 'Recommended registeration affiliate',
		-2	=> 'Recommended order affiliate',
	),	
		
	'affiliate_codetype'	=> 'code type affiliate',
	'affiliate_introduction'=> 'Affiliate introduction',
	
	'affiliate_intro' => array(
		0 => 'We hold <b> recommended registeration affiliate </b> to encourage recommending new member to register. Flows are as following:
		　　1.  Send recommendation code offered by us to BBS and blog.
		　   2.  Visitors visit our shop by clicking links.
		　　3.  Within links <b>%d%s</b> clicked by visitors，if visitors register in our shop, they are recognized as your recommendation and you can get rank points <b>%d</b> as an award (no more award when your rank points are over <b>%d</b> ).
		　　4.  You can get deduction of percentage from any shopping by users you recommended.Current total deduction amount for you and your recommender is <b>% out of order amount.s</b> and <b>%s</b> out of points. For details please refer to <b><a href="#myrecommend"> Members I recommended </a></b>.
		　　5.  Deduction is checked and distribute by administrator, please wait.
		　　6.  View your recommendation and affiliation on affiliation list.',
	　　1 => 'We hold <b> Recommended order affiliate </b> to encourage recommending new member to register. Flows are as following:
		　　1.  Click Recommend the good to get recommendation code and send it to BBS and blog.
		　　2.  Visitors visit our shop by clicking links.
		　　3.  Within links <b>%d%s</b> clicked by visitros, if visitors submit any order, the order is recognized as your recommendation.
		　　4、 You can get an award out of order amount and <b>%s</b> out of points.
		　　5.  Deduction is checked and distribute by administrator, please wait.
		　　6.  View your recommendation and affiliation on affiliation list.',
	), 
		
	'level_point_all'		=> 'level of all affiliated points',
	'level_money_all'		=> 'level of all affiliated money',
	'level_register_all'	=> 'level of registered points',
	'level_register_up'		=> 'upper level of rank points',
	
	'affiliate_stats' => array(
		0	=> 'Waiting for processing',
		1	=> 'Affiliated',
		2	=> 'Cancel affiliate',
		3	=> 'Canceled',
		4	=> 'Buyers wait for payment',
	),
	
	'level_point'	=> 'Level of points',
	'level_money'	=> 'Level of money',
		
	'affiliate_status'	=> 'Affiliate status',
	'affiliate_point'	=> 'Point affiliate',
	'affiliate_money'	=> 'Money affiliate',
	'affiliate_expire'	=> 'Time valid',
	'affiliate_lever'	=> 'Level',
	'affiliate_num'		=> 'Number',
	'affiliate_view'	=> 'View',
	'affiliate_code'	=> 'Code',
	'register_affiliate'	=> 'Points for recommended memberID %s ( %s ) registration',
	'register_points'		=> 'Points for registeration',
	'validate_ok'		=> '%s hello, youremail %s is validated',
	'validate_fail'		=> 'Validate failed, please check your link',
	'validate_mail_ok'	=> 'Validated mail sent successfully',
	'not_validated'		=> 'Not validated',
	'resend_hash_mail'	=> 'Resend hash mail',
	'query_status'		=> 'Query status',
	'change_payment'	=> 'Change to other online payment mode',
	'copy_to_clipboard'	=> 'Copy to clipboard.',
		
	'expire_unit' => array(
		'hour'=> 'Hour',
		'day' => 'Day',
		'week'=> 'Week',
	),
	
	'recommend_webcode'	=> 'Recommended webcode',
	'recommend_bbscode'	=> 'Recommended bbscode',
	'im_code'			=> 'Share Chat',
	'code_copy'			=> 'copy codes',
	'show_good_to_you'	=> 'show you a good thing',
	
	/* 积分兑换 */
	'transform_points'	=> 'Points transformation',
	'invalid_points'	=> 'Points invalid',
	'invalid_input'		=> 'Invalid',
	'overflow_points'	=> 'Points input higher than the existing points',
	'to_pay_points'		=> 'Congratulations! %s BBS %s transform into %s pay-points',
	'to_rank_points'	=> 'Congratulations! %s BBS %s transform into %s rank-points',
	'from_pay_points'	=> 'Congratulations! %s pay-points transform into %s BBS %s',
	'from_rank_points'	=> 'Congratulations! %s BBS %s transform into %s pay-points',
		
	'cur_points'		=> 'Current points',
	'rule_list'			=> 'Rules of transformation',
	'transform'			=> 'Transform',
	'rate_is'			=> 'Rate is',
	'rule'				=> 'Rules',
		
	'transform_num'		=> 'Transform number',
	'transform_result'	=> 'Transform result',
	'bbs'				=> 'BBS',
	'exchange_amount'	=> 'Amount',
	'exchange_desamount'=> 'Desamount',
	'exchange_ratio'	=> 'Ratio',

	'exchange_points' => array(
		0	=> 'Grade Points',
		1	=> 'Consumer Points',
	),
	'exchange_action'	=> 'Exchange',
		
	'exchange_js' => array(
		'deny'=> 'Prohibition of conversion',
		'balance'=> 'Your {%s} lack of balance, please re-enter',
	),	
		
	'exchange_deny'		=> 'The exchange does not allow points',
	'exchange_success'	=> 'Congratulations，exchange success',
	'exchange_error_1'	=> 'Exchange Error',
	'pay_points'		=> 'Pay-point',
	'rank_points'		=> 'Rank-point ',
	
	/* 密码强度 */
	'pwd_lower'		=> 'Lower',
	'pwd_middle'	=> 'Middle',
	'pwd_high'		=> 'High',
		
	'user_reg_info' => array(
		0	=> 'If you are not a member, please register',
		1	=> 'Friendship tips',
		2	=> 'Registration for non-members can purchase goods at the restaurant',
		8	=> "Don't register as a member may not purchase goods in the shop",
		3	=> 'After registration, but you can',
		4	=> 'Save your personal data',
		5	=> 'You are concerned about the collection of goods',
		6	=> 'Members enjoy the points system',
		7	=> 'We subscribe to information goods',
	),
	'add_bonus'=> 'Add Bouns',
	
	/* 密码找回问题 */
	'passwd_questions' => array(
		'friend_birthday'	=> 'My Best Friend\'s Birthday',
		'old_address'		=> 'My childhood place of residence address',
		'motto'				=> 'My motto',
		'favorite_movie'	=> 'My favorite movies',
		'favorite_song'		=> 'My favorite song',
		'favorite_food'		=> 'My favorite food',
		'interest'			=> 'My best interest',
		'favorite_novel'	=> 'My favorite novel',
		'favorite_equipe'	=> 'My favorite sports team',
	),
);

//end