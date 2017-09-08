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
	'02_payment_list' 	=> '支付方式',
	'payment' 			=> '支付方式',
	'payment_name' 		=> '名称',
	'version' 			=> '版本',
	'payment_desc' 		=> '描述',
	'short_pay_fee' 	=> '费用',
	'payment_author' 	=> '插件作者',
	'payment_is_cod' 	=> '货到付款：',
	'payment_is_online' => '在线支付：',
	
	'enable' 		=> '启用',
	'disable' 		=> '禁用',
	'name_edit' 	=> '支付方式名称',
	'payfee_edit' 	=> '支付方式费用',
	'payorder_edit' => '支付方式排序',
	'name_is_null' 	=> '您没有输入支付方式名称！',
	'name_exists' 	=> '该支付方式名称已存在！',
	'pay_fee' 		=> '支付手续费',
	'back_list' 	=> '返回支付方式列表',
	'install_ok' 	=> '安装成功',
	'edit_ok' 		=> '编辑成功',
	'edit_falid' 	=> '编辑失败',
	'uninstall_ok' 	=> '卸载成功',

	'find_order_sn' =>	'请输入商城订单编号',
	'find_trade_no' =>	'请输入流水号',

	'invalid_pay_fee' 		=> '支付费用不是一个合法的价格',
	'decide_by_ship' 		=> '配送决定',
	'edit_after_install' 	=> '该支付方式尚未安装，请你安装后再编辑',
	'payment_not_available' => '该支付插件不存在或尚未安装',
	
	'js_lang' => array(
		'lang_removeconfirm' 	=> '您确定要卸载该支付方式吗？',
		'pay_name_required'		=> '请输入支付名称',
		'pay_name_minlength'	=> '支付名称长度不能小于3',
		'pay_desc_required'		=> '请输入支付描述',
		'pay_desc_minlength'	=> '支付描述长度不能小于6',
	),

	'wait_for_payment'		=>	'等待付款',
	'payment_success'		=>	'付款成功',
	'heading_order_info' 	=> '订单信息',
	'fund_flow_record' 	=> '资金流水记录',
	'transaction_flow_record'	=> '交易流水',
	'view_flow_record'	=> '查看交易流水',
	'order_id' 		=> '编号',
	'order_sn' 		=> '商城订单编号',
	'trade_type' 	=> '交易类型',
	'trade_no' 		=> '流水号',
	'pay_code' 		=> '支付方式',
	'pay_name' 		=> ' 支付名称',
	'total_fee' 	=> '支付金额',
	'create_time' 	=> '创建时间',
	'pay_times' 	=> '付款时间',
	'update_time' 	=> '修改更新时间',
	'pay_time' 	=> '支付成功时间',
	'pay_status' 	=> '交易状态',
	'pay_not_exist' => '此支付方式不存在或者参数错误！',
	'pay_disabled' 	=> '此支付方式还没有被启用！',
	'pay_success' 	=> '您此次的支付操作已成功！',
	'pay_fail' 		=> '支付操作失败，请返回重试！',
	'buy'			=>	'消费',
	'refund'		=>	'退款',
	'deposit'		=>	'充值',
	'withdraw'		=>	'提现',
	'surplus'		=>	'会员充值',

	'ctenpay' 		=> '立即注册财付通商户号',
	'ctenpay_url' 	=> 'http://union.tenpay.com/mch/mch_register_b2c.shtml?sp_suggestuser=542554970',
	'ctenpayc2c_url'=> 'https://www.tenpay.com/mchhelper/mch_register_c2c.shtml?sp_suggestuser=542554970',
	'tenpay'  		=> '即时到账',
	'tenpayc2c'		=> '中介担保',
			
	'dualpay'			=> '标准双接口',
	'escrow'			=> '担保交易接口',
	'fastpay'			=> '即时到帐交易接口',
	'alipay_pay_method'	=> '选择接口类型：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
	'getPid'			=> '获取Pid、Key',
	
	//追加
	'repeat'					=> '已存在',
	'buyer'						=> '买家',
	'surplus_type_0'			=> '充值',
	'order_gift_integral'		=> '订单 %s 赠送的积分',
	'please_view_order_detail' 	=> '商品已发货，详情请到用户中心订单详情查看',
	'plugin'					=> '插件',
	'disabled'					=> '已停用',
	'enabled'					=> '已启用',
	'edit_payment'				=> '编辑支付方式',
	'payment_list'				=> '支付方式列表',
	'number_valid'				=> '请输入合法数字',
	'enter_valid_number'		=> '请输入合法数字或百分比%',
	'edit_free_as'				=> '修改费用为  %s',
	'edit_payment_name'			=> '编辑支付方式名称',
	'edit_payment_order'		=> '编辑支付方式排序',
	'label_payment_name'		=> '名称：',
	'label_payment_desc'		=> '描述：',
	'label_pay_fee'				=> '支付手续费：',
	
	'payment_manage'		=> '支付方式管理',
	'payment_update'		=> '支付方式更新',
	'plugin_install_error'	=> '支付方式名称或pay_code不能为空',
	'plugin_uninstall_error'=> '支付方式名称不能为空',
	
	'overview'             	=> '概述',
	'more_info'             => '更多信息：',
	
	'payment_list_help'		=> '欢迎访问ECJia智能后台支付方式页面，系统中所有的支付方式都会显示在此列表中。',
	'about_payment_list'	=> '关于支付方式帮助文档',
	'change_status_ok'		=> '修复订单状态成功！'

);

// end