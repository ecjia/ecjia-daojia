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
 * ECJIA 前台用户中心语言项
 */
return array(
	'require_login' 	=> '非法入口。<br />必须登录才能完成操作。',
	'no_records' 		=> '没有记录',
	'shot_message' 		=> "短消息",
	
	/* 用户菜单 */
	'label_welcome' 	=> '欢迎页',
	'label_profile' 	=> '用户信息',
	'label_order' 		=> '我的订单',
	'label_address' 	=> '收货地址',
	'label_message' 	=> '我的留言',
	'label_tag' 		=> '我的标签',
	'label_collection' 	=> '我的收藏',
	'label_bonus' 		=> '我的红包',
	'label_comment' 	=> '我的评论',
	'label_affiliate' 	=> '我的推荐',
	'label_group_buy' 	=> '我的团购',
	'label_booking' 	=> '缺货登记',
		
	'label_user_surplus' 	=> '资金管理',
	'label_track_packages' 	=> '跟踪包裹',
	'label_transform_points'=> '积分兑换',
	'label_logout' 			=> '退出',
	
	/* 会员余额(预付款) */
	'add_surplus_log' 	=> '查看帐户明细',
	'view_application' 	=> '查看申请记录',
	'surplus_pro_type' 	=> '类型',
	'repay_money' 		=> '提现金额',
	'money' 			=> '金额',
	'surplus_type_0' 	=> '充值',
	'surplus_type_1' 	=> '提现',
	'deposit_money' 	=> '充值金额',
	'process_notic' 	=> '会员备注',
	'admin_notic' 		=> '管理员备注',
	'submit_request' 	=> '提交申请',
	'process_time' 		=> '操作时间',
	'use_time' 			=> '使用时间',
	'is_paid' 			=> '状态',
	'is_confirm' 		=> '已完成',
	'un_confirm' 		=> '未确认',
	
	'pay' 				=> '付款',
	'is_cancel' 		=> '取消',
	'account_inc' 		=> '增加',
	'account_dec' 		=> '减少',
	'change_desc' 		=> '备注',
	'surplus_amount'	=> '您的充值金额为：',
	'payment_name' 		=> '您选择的支付方式为：',
	'payment_fee' 		=> '支付手续费用为：',
	'payment_desc' 		=> '支付方式描述：',
	
	'current_surplus' 		=> '您当前的可用资金为：',
	'unit_yuan' 			=> '元',
	'for_free' 				=> '赠品免费',
	
	'surplus_amount_error' 	=> '您要申请提现的金额超过了您现有的余额，此操作将不可进行！',
	'surplus_appl_submit' 	=> '您的提现申请已成功提交，请等待管理员的审核！',
	'process_false' 		=> '此次操作失败，请返回重试！',
	'confirm_remove_account'=> '您确定要删除此条记录吗？',
	'back_page_up' 			=> '返回上一页',
	'back_account_log' 		=> '返回帐户明细列表',
	'amount_gt_zero' 		=> '请在“金额”栏输入大于0的数字',
	'select_payment_pls' 	=> '请选择支付方式',
		
	//JS语言项
	'account_js' => array(
		'surplus_amount_empty' 	=> '请输入您要操作的金额数量！',
		'surplus_amount_error' 	=> '您输入的金额数量格式不正确！',
		'process_desc' 			=> '请输入您此次操作的备注信息！',
		'payment_empty' 		=> '请选择支付方式！',
	),
		
	/* 缺货登记 */
	'oos_booking' 			=> '缺货登记',
	'booking_goods_name' 	=> '订购商品名',
	'booking_amount' 		=> '订购数量',
	'booking_time' 			=> '登记时间',
	'process_desc' 			=> '处理备注',
	'describe' 				=> '订购描述',
	'contact_username' 		=> '联系人',
	'contact_phone' 		=> '联系电话',
	'submit_booking_goods' 	=> '提交缺货登记',
	'booking_success' 		=> '您的商品订购已经成功提交！',
	'booking_rec_exist' 	=> '此商品您已经进行过缺货登记了！',
	'back_booking_list' 	=> '返回缺货登记列表',
	'not_dispose' 			=> '未处理',
	'no_goods_id' 			=> '请指定商品ID',
		
	//JS语言项
	'booking_js' => array(
		'booking_amount_empty' 	=> '请输入您要订购的商品数量！',
		'booking_amount_error' 	=> '您输入的订购数量格式不正确！',
		'describe_empty' 		=> '请输入您的订购描述信息！',
		'contact_username_empty'=> '请输入联系人姓名！',
		'email_empty' 			=> '请输入联系人的电子邮件地址！',
		'email_error' 			=> '您输入的电子邮件地址格式不正确！',
		'contact_phone_empty' 	=> '请输入联系人的电话！',
	),
		
	/* 个人资料 */
	'confirm_submit' 	=> '　确 定　',
	'member_rank'	 	=> '会员等级',
	'member_discount' 	=> '会员折扣',
	'rank_integral' 	=> '成长值',
	'consume_integral' 	=> '消费积分',
	'account_balance' 	=> '账户余额',
	'user_bonus' 		=> '用户红包',
	'user_bonus_info' 	=> '共计 %d 个,价值 %s',
	'not_bonus' 		=> '没有红包',
	'add_user_bonus' 	=> '添加一个红包',
	'bonus_number' 		=> '红包序列号',
	'old_password' 		=> '原密码',
	'new_password' 		=> '新密码',
	'confirm_password' 	=> '确认密码',
		
	'bonus_sn_exist' 	=> '此红包号码已经被占用了！',
	'bonus_sn_not_exist'=> '此红包号码不存在！',
	'add_bonus_sucess' 	=> '添加新的红包操作成功！',
	'add_bonus_false' 	=> '添加新的红包操作失败！',
		
	'not_login' 		=> '用户未登录。无法完成操作',
	'profile_lnk' 		=> '查看我的个人资料',
	'edit_email_failed' => '编辑电子邮件地址失败！',
	
	'edit_profile_success' 	=> '您的个人资料已经成功修改！',
	'edit_profile_failed' 	=> '修改个人资料操作失败！',
	'oldpassword_error' 	=> '您输入的旧密码有误!请确认再后输入！',
		
	//JS语言项
	'profile_js' => array(
		'bonus_sn_empty' 		=> '请输入您要添加的红包号码！',
		'bonus_sn_error' 		=> '您输入的红包号码格式不正确！',
		'email_empty' 			=> '请输入您的电子邮件地址！',
		'email_error' 			=> '您输入的电子邮件地址格式不正确！',
		'old_password_empty' 	=> '请输入您的原密码！',
		'new_password_empty' 	=> '请输入您的新密码！',
		'confirm_password_empty'=> '请输入您的确认密码！',
		'both_password_error' 	=> '您现两次输入的密码不一致！',
		'msg_blank' 			=> '不能为空',
		'no_select_question' 	=> '- 您没有完成密码提示问题的操作',
	),
		
	/* 支付方式 */
	'pay_name' 	=> '名称',
	'pay_desc' 	=> '描述',
	'pay_fee' 	=> '手续费',
		
	/* 收货地址 */
	'consignee_name' 	=> '收货人姓名',
	'country_province' 	=> '配送区域',
	'please_select' 	=> '请选择',
	'city_district' 	=> '城市/地区',
	'email_address' 	=> '电子邮件地址',
	'detailed_address' 	=> '详细地址',
	
	'postalcode' 	=> '邮政编码',
	'phone' 		=> '电话',
	'mobile' 		=> '手机',
	'backup_phone' 	=> '手机',
	'sign_building' => '标志建筑',
	
	'deliver_goods_time' => '最佳送货时间',
	'default' 			 => '默认',
	'default_address'	 => '默认地址',
	
	'yes' 		=> '是',
	'no' 		=> '否',
	'country' 	=> '国家',
	'province'	=> '省份',
	'city' 	    => '城市',
	'area' 		=> '所在区域',
	
	'search_ship' 			=> '查看支持的配送方式',
	'del_address_false' 	=> '删除收货地址失败！',
	'add_address_success'	=> '添加新地址成功！',
	'edit_address_success' 	=> '您的收货地址信息已成功更新！',
	'address_list_lnk' 		=> '返回地址列表',
	'add_address' 			=> '新增收货地址',
	'confirm_edit' 			=> '确认修改',
	'confirm_drop_address' 	=> '你确认要删除该收货地址吗？',
		
	/* 会员密码找回 */
	'username_and_email' 	=> '请输入您注册的用户名和注册时填写的电子邮件地址。',
	'enter_new_password' 	=> '请输入您的新密码',
	'username_no_email' 	=> '您填写的用户名与电子邮件地址不匹配，请重新输入！',
	'fail_send_password' 	=> '发送邮件出错，请与管理员联系！',
	'send_success' 			=> '重置密码的邮件已经发到您的邮箱：',
	'parm_error' 			=> '参数错误，请返回！',
	'edit_password_failure' => '您输入的原密码不正确！',
	'edit_password_success' => '您的新密码已设置成功！',
	'username_not_match_email' 	=> '用户名与电子邮件地址不匹配，请重新输入！',
	'get_question_username' 	=> '请输入您注册的用户名以取得您的密码提示问题。',
	'no_passwd_question' 	=> '您没有设置密码提示问题，无法通过这种方式找回密码。',
	'input_answer' 			=> '请根据您注册时设置的密码问题输入设置的答案',
	'wrong_passwd_answer' 	=> '您输入的密码答案是错误的',
		
	//JS语言项
	'password_js' => array(
		'user_name_empty' 		=> '请输入您的用户名！',
		'email_address_empty' 	=> '请输入您的电子邮件地址！',
		'email_address_error' 	=> '您输入的电子邮件地址格式不正确！',
		'new_password_empty' 	=> '请输入您的新密码！',
		'confirm_password_empty'=> '请输入您的确认密码！',
		'both_password_error' 	=> '您两次输入的密码不一致！',
	),
		
	/* 会员留言 */
	'message_title' 	=> '主题',
	'message_time' 		=> '留言时间',
	'reply_time' 		=> '回复时间',
	'shopman_reply' 	=> '店主回复',
	'send_message' 		=> '发表留言',
	'message_type' 		=> '留言类型',
	'message_content' 	=> '留言内容',
	'submit_message' 	=> '提交留言',
	'upload_img'	 	=> '上传文件',
	'img_name' 			=> '图片名称',
		
	/* 留言类型 */
	'type' => array(
		M_MESSAGE 	=> '留言',
		M_COMPLAINT => '投诉',
		M_ENQUIRY 	=> '询问',
		M_CUSTOME 	=> '售后',
		M_BUY 		=> '求购',
		M_BUSINESS 	=> '商家留言',
	),
		
	'add_message_success' => '发表留言成功',
	'message_list_lnk' 	=> '返回留言列表',
	'msg_title_empty' 	=> '留言标题为空',
	'upload_file_limit' => '文件大小超过了限制 %dKB',
	
	'img_type_tips' 	=> '<font color="red">小提示：</font>',
	'img_type_list' 	=> '您可以上传以下格式的文件：<br />gif、jpg、png、word、excel、txt、zip、ppt、pdf',
	'view_upload_file' 	=> '查看上传的文件',
	'upload_file_type' 	=> '您上传的文件类型不正确,请重新上传！',
	'upload_file_error' => '文件上传出现错误,请重新上传！',
	'message_empty' 	=> '您现在还没有留言！',
	'msg_success' 		=> '您的留言已成功提交！',
	'confirm_remove_msg'=> '你确实要彻底删除这条留言吗？',
		
	/* 会员红包 */
	'bonus_is_used' 	=> '你输入的红包你已经领取过了！',
	'bonus_is_used_by_other' => '你输入的红包已经被其他人领取！',
	'bonus_add_success' => '您已经成功的添加了一个新的红包！',
	'bonus_not_exist' 	=> '你输入的红包不存在',
	'user_bonus_empty' 	=> '您现在还没有红包',
	'add_bonus_sucess' 	=> '添加新的红包操作成功！',
	'add_bonus_false' 	=> '添加新的红包操作失败！',
	'bonus_add_expire' 	=> '该红包已经过期！',
	'bonus_use_expire' 	=> '该红包已经过了使用期！',
    'invalid_bonus' 	=> "您选择的红包并不存在。",
    'bonus_min_amount_error' 	=> '订单商品金额没有达到使用该红包的最低金额 %s',
    
	/* 会员订单 */
	'order_list_lnk'=> '我的订单列表',
	'order_number' 	=> '订单编号',
	'order_addtime' => '下单时间',
	'order_money' 	=> '订单总金额',
	'order_status' 	=> '订单状态',
	'first_order' 	=> '主订单',
	'second_order' 	=> '从订单',
	'merge_order' 	=> '合并订单',
	'no_priv' 		=> '你没有权限操作他人订单',
	'buyer_cancel' 	=> '用户取消',
	'cancel' 		=> '取消订单',
	'pay_money' 	=> '付款',
	'view_order' 	=> '查看订单',
	'received' 		=> '确认收货',
	'ss_received' 	=> '已完成',
	'confirm_cancel'=> '您确认要取消该订单吗？取消后此订单将视为无效订单',
	'merge_ok' 		=> '订单合并成功！',
	
	'merge_invalid_order' => '对不起，您选择合并的订单不允许进行合并的操作。',
	
	'select' 		=> '请选择...',
	'order_not_pay' => "你的订单状态为 %s ,不需要付款",
	'order_sn_empty'=> '合并主订单号不能为空',
	
	'merge_order_notice' => '订单合并是在发货前将相同状态的订单合并成一新的订单。<br />收货地址，送货方式等以主定单为准。',
	'order_exist' 		 => '该订单不存在！',
	'order_is_group_buy' => '[团购]',
	'order_is_exchange'  => '[积分商城]',
	'gb_deposit' 		 => '（保证金）',
	
	'notice_gb_order_amount' 	=> '（备注：团购如果有保证金，第一次只需支付保证金和相应的支付费用）',
	'business_message' 		 	=> '发送/查看商家留言',
	'pay_order_by_surplus'		=> '追加使用余额支付订单：%s',
	'return_surplus_on_cancel' 	=> '取消订单 %s，退回支付订单时使用的预付款',
	'return_integral_on_cancel' => '取消订单 %s，退回支付订单时使用的积分',
		
	/* 订单状态 */
	'os' => array(
		OS_UNCONFIRMED 	=> '未确认',
		OS_CONFIRMED 	=> '已确认',
		OS_SPLITED 		=> '已确认',
		OS_SPLITING_PART=> '已确认',
		OS_CANCELED 	=> '已取消',
		OS_INVALID 		=> '无效',
		OS_RETURNED 	=> '退货',
	),
		
	'ss' => array(
		SS_UNSHIPPED 	=> '未发货',
		SS_PREPARING 	=> '配货中',
		SS_SHIPPED 	 	=> '已发货',
		SS_RECEIVED 	=> '收货确认',
		SS_SHIPPED_PART => '已发货(部分商品)',
		SS_SHIPPED_ING 	=> '配货中', // 已分单
	),
		
	'ps' => array(
		PS_UNPAYED 	=> '未付款',
		PS_PAYING 	=> '付款中',
		PS_PAYED 	=> '已付款',
	),
		
	'shipping_not_need' 			=> '无需使用配送方式',
	'current_os_not_unconfirmed' 	=> '当前订单状态不是“未确认”。',
	'current_os_already_confirmed' 	=> '当前订单已经被确认，无法取消，请与店主联系。',
	'current_ss_not_cancel' 		=> '只有在未发货状态下才能取消，你可以与店主联系。',
	'current_ps_not_cancel' 		=> '只有未付款状态才能取消，要取消请联系店主。',
	'confirm_received' 				=> '你确认已经收到货物了吗？',
		
	/* 合并订单及订单详情 */
	'merge_order_success' 	=> '合并的订单的操作已成功！',
	'merge_order_failed' 	=>'合并的订单的操作失败！请返回重试！',
	'order_sn_not_null' 	=> '请填写要合并的订单号',
	'two_order_sn_same' 	=> '要合并的两个订单号不能相同',
	'order_not_exist' 		=> "订单 %s 不存在",
	'os_not_unconfirmed_or_confirmed' => " %s 的订单状态不是“未确认”或“已确认”",
	'ps_not_unpayed' 		=> "订单 %s 的付款状态不是“未付款”",
	'ss_not_unshipped' 		=> "订单 %s 的发货状态不是“未发货”",
	'order_user_not_same' 	=> '要合并的两个订单不是同一个用户下的',
	
	'from_order_sn' 	=> '第一个订单号：',
	'to_order_sn' 		=> '第二个订单号：',
	'merge' 			=> '合并',
	'notice_order_sn' 	=> '当两个订单不一致时，合并后的订单信息（如：支付方式、配送方式、包装、贺卡、红包等）以第二个为准。',
	'subtotal' 			=> '小计',
	'goods_price' 		=> '商品价格',
	'goods_attr' 		=> '属性',
	'use_balance' 		=> '使用余额',
	'order_postscript' 	=> '订单附言',
	'order_number' 		=> '订单号',
	'consignment' 		=> '发货单',
	'shopping_money' 	=> '商品总价',
	'invalid_order_id' 	=> '订单号错误',
	
	'shipping'	=> '配送方式',
	'payment' 	=> '支付方式',
	'use_pack' 	=> '使用包装',
	'use_card' 	=> '使用贺卡',
	
	'order_total_fee' 	=> '订单总金额',
	'order_money_paid' 	=> '已付款金额',
	'order_amount' 		=> '应付款金额',
	'accessories'	 	=> '配件',
	'largess' 			=> '赠品',
	'use_more_surplus' 	=> '追加使用余额',
	'max_surplus' 		=> '（您的帐户余额：%s）',
	'button_submit' 	=> '确定',
	'order_detail' 		=> '订单详情',
	
	'error_surplus_invalid' 	=> '您输入的数字不正确！',
	'error_order_is_paid' 		=> '该订单不需要付款！',
	'error_surplus_not_enough' 	=> '您的帐户余额不足！',
	
	/* 订单状态 */
	'detail_order_sn' 		=> '订单号',
	'detail_order_status' 	=> '订单状态',
	'detail_pay_status' 	=> '付款状态',
	'detail_shipping_status'=> '配送状态',
	'detail_order_sn' 		=> '订单号',
	'detail_to_buyer' 		=> '卖家留言',
	
	'confirm_time' 	=> '确认于 %s',
	'pay_time' 		=> '付款于 %s',
	'shipping_time' => '发货于 %s',
	
	'select_payment'	=> '所选支付方式',
	'order_amount' 		=> '应付款金额',
	'update_address' 	=> '更新收货人信息',
	'virtual_card_info' => '虚拟卡信息',
	
	/* 取回密码 */
	'back_home_lnk' 		=> '返回首页',
	'get_password_lnk' 		=> '返回获取密码页面',
	'get_password_by_question' => '密码问题找回密码',
	'get_password_by_mail' 	=> '注册邮件找回密码',
	'back_retry_answer' 	=> '返回重试',
	
	/* 登录 注册 */
	'label_username' 	=> '用户名',
	'label_email' 		=> 'email',
	'label_password' 	=> '密码',
	'label_confirm_password' 	=> '确认密码',
	'label_password_intensity' 	=> '密码强度',
	
	'want_login' => '我已有账号，我要登录',
	'other_msn' => 'MSN',
	'other_qq' 	=> 'QQ',
	
	'other_office_phone'=> '办公电话',
	'other_home_phone'	=> '家庭电话',
	'other_mobile_phone'=> '手机',
	'remember' 			=> '请保存我这次的登录信息。',
	'msg_un_blank' 		=> '用户名不能为空',
	'msg_un_length' 	=> '用户名最长不得超过7个汉字',
	'msg_un_format' 	=> '用户名含有非法字符',
	'msg_un_registered' => '用户名已经存在,请重新输入',
	'msg_can_rg' 		=> '可以注册',
	'msg_email_blank' 	=> '邮件地址不能为空',
	'msg_email_registered' => '邮箱已存在,请重新输入',
	'msg_email_format' 	=> '邮件地址不合法',
	'login_success' 	=> '登录成功',
	'confirm_login' 	=> '确认登录',
	'profile_lnk' 		=> '查看我的个人信息',
	'login_failure' 	=> '用户名或密码错误',
	'relogin_lnk' 		=> '重新登录',
	
	'sex' 		=> '性　别',
	'male' 		=> '男',
	'female' 	=> '女',
	'secrecy' 	=> '保密',
	'birthday' 	=> '出生日期',
	'logout' 	=> '您已经成功的退出了。',
	
	'username_empty' 		=> '用户名为空',
	'username_invalid' 		=> '用户名 %s 含有敏感字符',
	'username_exist' 		=> '用户名 %s 已经存在',
	'username_not_allow' 	=> '用户名 %s 不允许注册',
	'confirm_register' 		=> '确认注册',
	
	'agreement' 		=> "我已看过并接受《<a href=\"article.php?cat_id=-1\" style=\"color:blue\" target=\"_blank\">用户协议</a>》",
	'email_empty' 		=> 'email为空',
	'email_invalid'	 	=> '%s 不是合法的email地址',
	'email_exist' 		=> '%s 已经存在',
	'email_not_allow' 	=> 'Email %s 不允许注册',
	'register' 			=> '注册新用户名',
	'register_success' 	=> '用户名 %s 注册成功',
	'passwd_question' 	=> '密码提示问题',
	'sel_question' 		=> '请选择密码提示问题',
	'passwd_answer' 	=> '密码问题答案',
	'passwd_balnk' 		=> '密码中不能包含空格',
	
	/* 用户中心默认页面 */
	'welcome_to' 	=> '欢迎您回到',
	'last_time' 	=> '您的上一次登录时间',
	'your_account' 	=> '您的账户',
	'your_notice' 	=> '用户提醒',
	'your_surplus' 	=> '余额',
	'credit_line' 	=> '信用额度',
	'your_bonus' 	=> '红包',
	'your_message' 	=> '留言',
	'your_order' 	=> '订单',
	'your_integral' => '积分',
	'your_level' 	=> '您的等级是 %s ',
	'next_level' 	=> ',您还差 %s 积分达到 %s ',
	'attention' 	=> '关注',
	'no_attention' 	=> '取消关注',
	'del_attention' => '确认取消此商品的关注么？',
	'add_to_attention' => '确定将此商品加入关注列表么？',
	'label_need_image' => '是否显示商品图片：',
	
	'need' 		=> '显示',
	'need_not' 	=> '不显示',
	'horizontal'=> '横排',
	'verticle' 	=> '竖排',
	'generate' 	=> '生成代码',
	
	'label_goods_num' => '显示商品数量：',
	'label_rows_num'  => '排列显示条目数：',
	'label_arrange'   => '选择商品排列方式：',
	'label_charset'   => '选择编码：',
		
	'charset' => array(
		'utf8' 	=> '国际化编码（utf8）',
		'zh_cn' => '简体中文',
		'zh_tw' => '繁体中文',
	),
		
	'goods_num_must_be_int' => '商品数量应该是整数',
	'goods_num_must_over_0' => '商品数量应该大于0',
	'rows_num_must_be_int' 	=> '排列显示条目数应该是整数',
	'rows_num_must_over_0' 	=> '排列显示条目数应该大于0',
		
	'last_month_order' 	=> '您最近30天内提交了',
	'order_unit' 		=> '个订单',
	'please_received' 	=> '以下订单已发货，请注意查收',
	'your_auction' 		=> '您竟拍到了<strong>%s</strong> ，现在去 <a href="auction.php?act=view&amp,id=%s"><span style="color:#06c,text-decoration:underline,">购买</span></a>',
	'your_snatch' 		=> '您夺宝奇兵竟拍到了<strong>%s</strong> ，现在去 <a href="snatch.php?act=main&amp,id=%s"><span style="color:#06c,text-decoration:underline,">购买</span></a>',
	
	/* 我的标签 */
	'no_tag' 			=> '暂时没有标签',
	'confirm_drop_tag' 	=> '您确认要删除此标签吗？',
		
	/* user_passport.dwt js语言文件 */
	'passport_js' => array(
		'username_empty' 	=> '- 用户名不能为空。',
		'username_shorter' 	=> '- 用户名长度不能少于 3 个字符。',
		'username_invalid' 	=> '- 用户名只能是由字母数字以及下划线组成。',
		'password_empty' 	=> '- 登录密码不能为空。',
		'password_shorter' 	=> '- 登录密码不能少于 6 个字符。',
		'confirm_password_invalid' => '- 两次输入密码不一致',
		'email_empty' 		=> '- Email 为空',
		'email_invalid' 	=> '- Email 不是合法的地址',
		'agreement' 		=> '- 您没有接受协议',
		'msn_invalid' 		=> '- msn地址不是一个有效的邮件地址',
		'qq_invalid' 		=> '- QQ号码不是一个有效的号码',
		'home_phone_invalid' 	=> '- 家庭电话不是一个有效号码',
		'office_phone_invalid' 	=> '- 办公电话不是一个有效号码',
		'mobile_phone_invalid' 	=> '- 手机号码不是一个有效号码',
		'msg_un_blank' 		=> '* 用户名不能为空',
		'msg_un_length' 	=> '* 用户名最长不得超过7个汉字',
		'msg_un_format' 	=> '* 用户名含有非法字符',
		'msg_un_registered' => '* 用户名已经存在,请重新输入',
		'msg_can_rg' 		=> '* 可以注册',
		'msg_email_blank' 	=> '* 邮件地址不能为空',
		'msg_email_registered' 	=> '* 邮箱已存在,请重新输入',
		'msg_email_format' 	=> '* 邮件地址不合法',
		'msg_blank' 		=> '不能为空',
		'no_select_question'=> '- 您没有完成密码提示问题的操作',
		'passwd_balnk' 		=> '- 密码中不能包含空格',
	),
		
	/* user_clips.dwt js 语言文件 */
	'clips_js' => array(
		'msg_title_empty' 	=> '留言标题为空',
		'msg_content_empty' => '留言内容为空',
		'msg_title_limit' 	=> '留言标题不能超过200个字',
	),
		
	/* 合并订单js */
	'merge_order_js' => array(
		'from_order_empty' 	=> '请选择要合并的从订单',
		'to_order_empty' 	=> '请选择要合并的主订单',
		'order_same' 		=> '主订单和从订单相同，请重新选择',
		'confirm_merge' 	=> '您确实要合并这两个订单吗？',
	),
		
	/* 将用户订单中商品加入购物车 */
	'order_id_empty' 			=> '未指定订单号',
	'return_to_cart_success' 	=> '订单中商品已经成功加入购物车中',
		
	/* 保存用户订单收货地址 */
	'consigness_empty' 	  => '收货人姓名为空',
	'address_empty' 	  => '收货地址详情为空',
	'require_unconfirmed' => '该订单状态下不能再修改地址',
		
	/* 红包详情 */
	'bonus_sn' 			=> '红包序号',
	'bonus_name' 		=> '红包名称',
	'bonus_amount' 		=> '红包金额',
	'min_goods_amount' 	=> '最小订单金额',
	'bonus_end_date'	=> '截至使用日期',
	'bonus_status' 		=> '红包状态',
	
	'not_start' => '未开始',
	'overdue' 	=> '已过期',
	'not_use' 	=> '未使用',
	'had_use' 	=> '已使用',
		
	/* 用户推荐 */
	'affiliate_mode' 	=> '分成模式',
	'affiliate_detail' 	=> '分成明细',
	'affiliate_member' 	=> '我推荐的会员',
	'affiliate_code' 	=> '推荐代码',
	'firefox_copy_alert'=> "您的firefox安全限制限制您进行剪贴板操作，请打开’about:config’将signed.applets.codebase_principal_support’设置为true’之后重试",
		
	'affiliate_type' => array(
		0	=> '推荐注册分成',
		1 	=> '推荐订单分成',
		-1 	=> '推荐注册分成',
		-2 	=> '推荐订单分成',
	),
		
	'affiliate_codetype' 	=> '格式',
	'affiliate_introduction'=> '分成模式介绍',
	
	'affiliate_intro' => array(
		0 => '本网店为鼓励推荐新用户注册，现开展<b>推荐注册分成</b>活动，活动流程如下：
			１、将本站提供给您的推荐代码，发送到论坛、博客上。
　　			２、访问者点击链接，访问网店。
　　			３、在访问者点击链接的 <b>%d%s</b> 内，若该访问者在本站注册，即认定该用户是您推荐的，您将获得成长值 <b>%d</b> 的奖励 (当您的成长值超过 <b>%d</b> 时，不再获得奖励)。
　　			４、该用户今后在本站的一切消费，您均能获得一定比例的提成。目前实行的提成总额为订单金额的 <b>%s</b> 、积分的 <b>%s</b> ，分配给您、推荐您的人等，具体分配规则请参阅 <b><a href="#myrecommend">我推荐的会员</a></b>。
　　			５、提成由管理员人工审核发放，请您耐心等待。
　　			６、您可以通过分成明细来查看您的介绍、分成情况。',
		1 => '本网店为鼓励推荐新用户注册，现开展<b>推荐订单分成</b>活动，活动流程如下：
		　　１、在浏览商品时，点击推荐此商品，获得推荐代码，将其发送到论坛、博客上。
		　　２、访问者点击链接，访问网店。
		　　３、在访问者点击链接的 <b>%d%s</b> 内，若该访问者在本站有订单，即认定该订单是您推荐的。
		　　４、您将获得该订单金额的 <b>%s</b> 、积分的 <b>%s</b>的奖励。
		　　５、提成由管理员人工审核发放，请您耐心等待。
		　　６、您可以通过分成明细来查看您的介绍、分成情况。',
	),
	
	'level_point_all' 	=> '积分分成总额百分比',
	'level_money_all' 	=> '现金分成总额百分比',
	'level_register_all'=> '注册积分分成数',
	'level_register_up' => '成长值分成上限',
		
	'affiliate_stats' => array(
		0 => '等待处理',
		1 => '已分成',
		2 => '取消分成',
		3 => '已撤销',
		4 => '等待买家付款',
	),
		
	'level_point' 	=> '积分分成百分比',
	'level_money' 	=> '现金分成百分比',
	
	'affiliate_status' 	=> '分成状态',
	'affiliate_point' 	=> '积分分成',
	'affiliate_money' 	=> '现金分成',
	'affiliate_expire' 	=> '有效时间',
	'affiliate_lever' 	=> '等级',
	'affiliate_num' 	=> '人数',
	'affiliate_view' 	=> '效果',
	'affiliate_code' 	=> '代码',
	'register_affiliate'=> '推荐会员ID %s ( %s ) 注册送积分',
	'register_affiliate_acount'=> '推荐会员ID %s ( %s ) 注册送余额',
	'register_affiliate_integral'=> '推荐会员ID %s ( %s ) 注册送消费积分',
	'register_points' 	=> '注册送积分',
	'validate_ok' 		=> '%s 您好，您email %s 已通过验证',
	'validate_fail' 	=> '验证失败，请确认你的验证链接是否正确',
	'validate_mail_ok' 	=> '验证邮件发送成功',
	'not_validated' 	=> '您还没有通过邮件认证',
	'resend_hash_mail' 	=> '点此发送认证邮件',
	'query_status' 		=> '查询状态',
	'change_payment' 	=> '改用其他在线支付方式',
	'copy_to_clipboard' => '已拷贝至剪贴板。',
		
	'expire_unit' => array(
		'hour' 	=> '小时',
		'day' 	=> '天',
		'week' 	=> '周'
	),
		
	'recommend_webcode' => '网页签名代码',
	'recommend_bbscode' => '论坛签名代码',
	'im_code' 			=> '聊天分享',
	'code_copy' 		=> '复制代码',
	'show_good_to_you' 	=> '推荐给你一个好东西',
		
	/* 积分兑换 */
	'transform_points' 	=> '积分兑换',
	'invalid_points' 	=> '你输入的积分是不一个合法值',
	'invalid_input' 	=> '无效',
	'overflow_points' 	=> '您输入的兑换积分超过您的实际积分',
	'to_pay_points' 	=> '恭喜您， 你%s论坛%s兑换了%s的商城消费积分',
	'to_rank_points' 	=> '恭喜您， 你%s论坛%s兑换了%s的商城成长值',
	'from_pay_points' 	=> '恭喜您， 你%s的商城消费积分兑换%s论坛%s',
	'from_rank_points' 	=> '恭喜您， 你%s论坛%s兑换了%s的商城消费积分',
	
	'cur_points'=> '您的当前积分',
	'rule_list' => '兑换规则',
	'transform' => '兑换',
	'rate_is' 	=> '比例为',
	'rule' 		=> '兑换规则',
	
	'transform_num' 	=> '兑换数量',
	'transform_result' 	=> '兑换结果',
	'bbs' 				=> '论坛',
	'exchange_amount' 	=> '支出',
	'exchange_desamount'=> '收入',
	'exchange_ratio' 	=> '兑换比率',
		
	'exchange_points' => array(
		0 => '商城成长值',
		1 => '商城消费积分',
	),
	'exchange_action' => '换',
		
	'exchange_js' => array(
		'deny' 	  => '禁止兑换',
		'balance' => '您的{%s}余额不足，请重新输入',
	),
		
	'exchange_deny' 	=> '该积分不允许兑换',
	'exchange_success' 	=> '恭喜您， 你用%s个%s兑换了%s个%s',
	'exchange_error_1' 	=> 'UCenter提交积分兑换时发生错误',
	'rank_points' 		=> '商城成长值',
	'pay_points' 		=> '商城消费积分',

    'no_goods_in_cart' 	=> '您的购物车中没有商品！',
    
	/* 密码强度 */
	'pwd_lower' 	=> '弱',
	'pwd_middle' 	=> '中',
	'pwd_high' 		=> '强',
		
	'user_reg_info' => array(
		0 => '如果您不是会员，请注册',
		1 => '友情提示',
		2 => '不注册为会员也可在本店购买商品',
		8 => '不注册为会员不可以在本店购买商品',
		3 => '但注册之后您可以',
		4 => '保存您的个人资料',
		5 => '收藏您关注的商品',
		6 => '享受会员积分制度',
		7 => '订阅本店商品信息',
	),
	'add_bonus' => '添加红包',
		
	/*密码找回问题 */
	'passwd_questions' => array(
		'friend_birthday' => '我最好朋友的生日？',
		'old_address'     => '我儿时居住地的地址？',
		'motto'           => '我的座右铭是？',
		'favorite_movie'  => '我最喜爱的电影？',
		'favorite_song'   => '我最喜爱的歌曲？',
		'favorite_food'   => '我最喜爱的食物？',
		'interest'        => '我最大的爱好？',
		'favorite_novel'  => '我最喜欢的小说？',
		'favorite_equipe' => '我最喜欢的运动队？'
	)
);

// end