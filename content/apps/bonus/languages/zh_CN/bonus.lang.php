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
 * ECJIA 红包类型/红包管理语言包
 */
return array(
	/* 红包类型字段信息 */
    'bonus_type' 	            => '红包类型',
	'bonus_manage' 				=> '红包管理',
	'bonus_list' 				=> '红包列表',
	'type_name' 				=> '类型名称',
	'merchants_name'			=> '商家名称',
	'type_money' 				=> '红包金额',
	'min_goods_amount' 			=> '最小订单金额',
	'notice_min_goods_amount' 	=> '只有商品总金额达到这个数的订单才能使用这种红包',
	'min_amount' 				=> '订单下限',
	'max_amount' 				=> '订单上限',
	'send_startdate' 			=> '发放起始日期',
	'send_enddate' 				=> '发放结束日期',
	
	'use_startdate' 	=> '使用起始日期',
	'use_enddate' 		=> '使用结束日期',
	'send_count' 		=> '发放数量',
	'use_count' 		=> '使用数量',
	'send_method' 		=> '如何发放此类型红包',
	'send_type' 		=> '发放类型',
	'param' 			=> '参数',
	'no_use' 			=> '未使用',
	'yuan' 				=> '元',
	'user_list' 		=> '会员列表',
	'type_name_empty' 	=> '红包类型名称不能为空！',
	'type_money_empty' 	=> '红包金额不能为空！',
	'min_amount_empty' 	=> '红包类型的订单下限不能为空！',
	'max_amount_empty' 	=> '红包类型的订单上限不能为空！',
	'send_count_empty' 	=> '红包类型的发放数量不能为空！',
	
	'send_by' => array(
		SEND_BY_USER 		=> '按用户发放',
		SEND_BY_GOODS 		=> '按商品发放',
		SEND_BY_ORDER 		=> '按订单金额发放',
		SEND_BY_PRINT 		=> '线下发放的红包',
		SEND_BY_REGISTER 	=> '注册送红包',
		SEND_COUPON			=> '优惠券'
	),
	
	'report_form' 		=> '报表',
	'send' 				=> '发放',
	'bonus_excel_file' 	=> '线下红包信息列表',
	
	'goods_cat' 		=> '选择商品分类',
	'goods_brand' 		=> '商品品牌',
	'goods_key' 		=> '商品关键字',
	'all_goods' 		=> '可选商品',
	'send_bouns_goods' 	=> '发放此类型红包的商品',
	'remove_bouns' 		=> '移除红包',
	'all_remove_bouns' 	=> '全部移除',
	'goods_already_bouns' 	=> '该商品已经发放过其它类型的红包了！',
	'send_user_empty' 		=> '您没有选择需要发放红包的会员，请返回！',
	'batch_drop_success' 	=> '成功删除了 %d 个红包',
	'sendbonus_count' 	=> '共发送了 %d 个红包。',
	'send_bouns_error' 	=> '发送会员红包出错, 请返回重试！',
	'no_select_bonus' 	=> '您没有选择需要删除的用户红包',
	'bonustype_edit' 	=> '编辑红包类型',
	'bonustype_view' 	=> '查看详情',
	'drop_bonus' 		=> '删除红包',
	'send_bonus' 		=> '发放红包',
	'continus_add' 		=> '继续添加红包类型',
	'back_list' 		=> '返回红包类型列表',
	'bonustype_list' 	=> '红包类型列表',
	'continue_add' 		=> '继续添加红包',
	'back_bonus_list' 	=> '返回红包列表',
	'validated_email' 	=> '只给通过邮件验证的用户发放红包',
		
	/* 提示信息 */
	'add_success'			=> '添加成功',
	'edit_success'			=> '编辑成功',
	'attradd_succed' 		=> '操作成功！',
	'del_bonustype_succed' 	=> '删除红包类型成功！',
	
	'js_languages' => array(
		'type_name_empty' 		=> '请输入红包类型名称！',
		'type_money_empty' 		=> '请输入红包类型价格！',
		'order_money_empty' 	=> '请输入订单金额！',
		'type_money_isnumber' 	=> '类型金额必须为数字格式！',
		'order_money_isnumber' 	=> '订单金额必须为数字格式！',
		'bonus_sn_empty' 		=> '请输入红包的序列号！',
		'bonus_sn_number' 		=> '红包的序列号必须是数字！',
		'bonus_sum_empty' 		=> '请输入您要发放的红包数量！',
		'bonus_sum_number' 		=> '红包的发放数量必须是一个整数！',
		'bonus_type_empty' 		=> '请选择红包的类型金额！',
		'user_rank_empty' 		=> '您没有指定会员等级！',
		'user_name_empty' 		=> '您至少需要选择一个会员！',
		'invalid_min_amount' 	=> '请输入订单下限（大于0的数字）',
		'send_start_lt_end' 	=> '红包发放起始日期不能大于或等于发放结束日期',
		'use_start_lt_end' 		=> '红包使用起始日期不能大于或等于使用结束日期',
	),
		
	'send_count_error' 		=> '红包的发放数量必须是一个整数！',
	'order_money_notic' 	=> '只要订单金额达到该数值，就会发放红包给用户',
	'type_money_notic' 		=> '此类型的红包可以抵销的金额',
	'send_startdate_notic' 	=> '只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以发放',
	'use_startdate_notic' 	=> '只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以使用',
	'type_name_exist' 		=> '此类型的名称已经存在！',
	'type_money_error' 		=> '金额必须是数字并且不能小于 0 ！',
	'bonus_sn_notic' 		=> '提示:红包序列号由六位序列号种子加上四位随机数字组成',
	'creat_bonus' 			=> '生成了 ',
	'creat_bonus_num' 		=> ' 个红包序列号',
	'bonus_sn_error' 		=> '红包序列号必须是数字！',
	'send_user_notice' 		=> '给指定的用户发放红包时,请在此输入用户名, 多个用户之间请用逗号(,)分隔开<br />如:liry, wjz, zwj',
		
	/* 红包信息字段 */
	'bonus_id' 			=> '编号',
	'bonus_type_id' 	=> '类型金额',
	'send_bonus_count' 	=> '红包数量',
	'start_bonus_sn' 	=> '起始序列号',
	'bonus_sn' 			=> '红包序列号',
	'user_id' 			=> '使用会员',
	'used_time' 		=> '使用时间',
	'order_id' 			=> '订单号',
	'send_mail' 		=> '发邮件',
	'emailed' 			=> '邮件通知',
    'handler'           => '操作',
    
	'mail_status' => array(
		BONUS_NOT_MAIL 					=> '未发',
		BONUS_INSERT_MAILLIST_FAIL 		=> '插入邮件发送队列失败',
		BONUS_INSERT_MAILLIST_SUCCEED 	=> '插入邮件发送队列成功',
		BONUS_MAIL_FAIL 				=> '发送邮件通知失败',
		BONUS_MAIL_SUCCEED 				=> '发送邮件通知成功',
	),
		
	'sendtouser' 			=> '给指定用户发放红包',
	'senduserrank' 			=> '按用户等级发放红包',
	'userrank' 				=> '用户等级',
	'select_rank' 			=> '选择会员等级...',
	'keywords' 				=> '关键字：',
	'userlist' 				=> '会员列表：',
	'send_to_user' 			=> '给下列用户发放红包',
	'search_users' 			=> '搜索会员',
	'confirm_send_bonus' 	=> '确定发放红包',
	'bonus_not_exist' 		=> '该红包不存在',
	'success_send_mail'	 	=> '已成功加入邮件列表',
	'send_continue' 		=> '继续发放红包',
	
	//追加
	'send_startdate_lable' 	=> '发放起始日期：',
	'send_enddate_lable' 	=> '发放结束日期：',
	'use_startdate_lable' 	=> '使用起始日期：',
	'use_enddate_lable' 	=> '使用结束日期：',
	'min_amount_lable' 		=> '订单下限：',
	'send_method_lable' 	=> '如何发放此类型红包：',
	'min_goods_amount_lable'=> '最小订单金额：',
	'usage_type_label'		=> '使用类型：',
	'type_money_lable' 		=> '红包金额：',
	'type_name_lable'		=> '类型名称：',
	'add_bonus_type'		=> '添加红包类型',
	'send_type_is'			=> '发放类型是 ',
	'bonustype_name_is'		=> '红包类型名称是 ',
	'send_rank_is'			=> '发放等级是 ',
	'send_target_is'		=> '发放目标是 ',
	'batch_operation'		=> '批量操作',
	'remove_confirm'		=> '您确定要这么做吗？',
	'pls_choose_remove'		=> '请先选中要删除的红包',
	'pls_choose_send'		=> '请先选中要插入邮件发送队列的红包',
	'insert_maillist'		=> '插入邮件发送队列',
	'remove_bonus_confirm'	=> '您确定要删除该红包吗？',
	'search_goods_help'		=> '搜索要发放此类型红包的商品展示在左侧区域中，点击左侧列表中选项，商品即可进入右侧发放红包区域。您还可以在右侧编辑将发放红包的商品。',
	'filter_goods_info'		=> '筛选搜索到的商品信息',
	'no_content'			=> '暂无内容',
	'user_rank'				=> '会员级别：',
	'enter_user_keywords'	=> '请输入用户名的关键字',
	'search_user_help'		=> '搜索要发放此类型红包的用户展示在左侧区域中，点击左侧列表中选项，用户即可进入右侧发放红包区域。您还可以在右侧编辑将发放红包的用户。',
	'no_info'				=> '暂无信息',
	'filter_user_info'		=> '筛选搜索到的用户信息',
	'update'				=> '更新',
	'all_send_type'			=> '所有发放类型',
	'filter'				=> '筛选',
	'edit_bonus_type_name'	=> '编辑红包类型名称',
	'view_bonus'			=> '查看红包',
	'general_audience'		=> '全场通用',
	'remove_bonustype_confirm' 	=> '您确定要删除该红包类型吗？',
	'gen_excel'					=> '导出报表',
	'edit_bonus_money'			=> '编辑红包金额',
	'edit_order_limit'			=> '编辑订单下限金额',
	
	'bonus_type_manage'		=> '红包类型管理',
	'bonus_type_add'		=> '红包类型添加',
	'bonus_type_update'		=> '红包类型编辑',
	'bonus_type_delete'		=> '红包类型删除',
	'invalid_parameter'		=> '参数无效',
	'send_coupon_repeat'	=> '您已领取过该优惠券！',
	'list_bonus_type'		=> '红包类型',
	
	'bonus_type_help'		=> '欢迎访问ECJia智能后台红包类型列表页面，系统中所有的红包类型都会显示在此列表中。',
	'about_bonus_type'		=> '关于红包类型列表帮助文档',
	'add_bonus_help'		=> '欢迎访问ECJia智能后台添加红包类型页面，在此页面中可以进行添加红包类型操作。',
	'about_add_bonus'		=> '关于添加红包类型帮助文档',
	'edit_bonus_help'		=> '欢迎访问ECJia智能后台编辑红包类型页面，在此页面中可以进行编辑红包类型操作。',
	'about_edit_bonus'		=> '关于编辑红包类型帮助文档',
	
	'send_by_user_help'		=> '欢迎访问ECJia智能后台按照用户发放红包页面，在此页面可以对用户进行发放红包操作。',
	'about_send_by_user'	=> '关于按照用户发放红包帮助文档',
	
	'send_by_goods_help'	=> '欢迎访问ECJia智能后台按照商品发放红包页面，在此页面可以对商品进行发放红包操作。',
	'about_send_by_goods'	=> '关于按照商品发放红包帮助文档',
	
	'send_by_print_help'	=> '欢迎访问ECJia智能后台按照线下发放红包页面，在此页面可以进行线下发放红包操作。',
	'about_send_by_print'	=> '关于按照线下发放红包帮助文档',
	
	'send_coupon_help'		=> '欢迎访问ECJia智能后台按照商品发放优惠券，在此页面可以对商品进行发放优惠券操作。',
	'about_send_coupon'		=> '关于按照商品发放红包帮助文档',
	
	'bonus_list_help'		=> '欢迎访问ECJia智能后台红包列表页面，系统中所有的红包都会显示在此列表中。',
	'about_bonus_list'		=> '关于红包列表帮助文档',
	
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	
	'type_name_required'		=> '请输入红包类型名称',
	'type_name_minlength'		=> '红包类型名称长度不能小于1',
	'type_money_required'		=> '请输入红包金额',
	'min_goods_amount_required'	=> '请输入最小订单金额',
	
	'bonus_sum_required'		=> '请输入红包数量！',
	'bonus_number_required'		=> '请输入数字！',
	'select_goods_empty'		=> '未搜索到商品信息',
	'select_user_empty'			=> '未搜索到用户信息',
	
	'send_startdate_required'	=> '请输入发放起始日期！',
	'send_enddate_required'		=> '请输入发放结束日期！',
	'use_startdate_required'	=> '请输入使用起始日期！',
	'use_enddate_required'		=> '请输入使用结束日期！',
	
	'send_start_lt_end' 		=> '红包发放起始日期不能大于或等于发放结束日期',
	'use_start_lt_end' 			=> '红包使用起始日期不能大于或等于使用结束日期',
	
	'all'						=> '全部',
	'merchants'					=> '商家',
	'enter_merchant_keywords'	=> '请输入商家名称关键字',
	'enter_type_keywords'		=> '请输入类型名称关键字',
	'self'						=> '自营',
);		

//end