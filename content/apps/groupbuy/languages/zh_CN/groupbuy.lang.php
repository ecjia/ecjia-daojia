<?php
/**
 * ECJIA 管理中心团购商品语言文件
 */

return array(
		/* 当前页面标题及可用链接名称 */
		'group_buy_list' 	=> '团购活动列表',
		'add_group_buy' 	=> '添加团购活动',
		'edit_group_buy' 	=> '编辑团购活动',

		/* 活动列表页 */
		'goods_name'		=> '商品名称',
		'start_date' 		=> '开始时间',
		'end_date' 			=> '结束时间',
		'deposit'			=> '保证金',
		'restrict_amount' 	=> '限购',
		'gift_integral' 	=> '赠送积分',
		'valid_order' 		=> '订单',
		'valid_goods' 		=> '订购商品',
		'current_price' 	=> '当前价格',
		'current_status'	=> '状态',
		'view_order' 		=> '查看订单',

		/* 添加/编辑活动页 */
		'goods_cat' 	=> '商品分类',
		'all_cat' 		=> '所有分类',
		'goods_brand' 	=> '商品品牌',
		'all_brand' 	=> '所有品牌',

		'label_goods_name' 	=> '团购商品：',
		'notice_goods_name' => '请先搜索商品,在此生成选项列表...',
		'label_start_date' 	=> '开始时间：',
		'label_end_date' 	=> '结束时间：',
		'notice_datetime' 	=> '（年月日－时）',
		'label_deposit' 	=> '保证金：',

		'label_restrict_amount'	=> '限购数量：',
		'notice_restrict_amount'=> '达到此数量，团购活动自动结束。0表示没有数量限制。',
		'label_gift_integral' 	=> '赠送积分数：',
		'label_price_ladder' 	=> '价格阶梯：',
		'notice_ladder_amount' 	=> '数量达到',
		'notice_ladder_price' 	=> '享受价格',

		'label_desc'	=> '活动说明：',
		'label_status' 	=> '活动当前状态：',

		'gbs' => array(
				GBS_PRE_START 	=> '未开始',
				GBS_UNDER_WAY 	=> '进行中',
				GBS_FINISHED 	=> '结束未处理',
				GBS_SUCCEED 	=> '成功结束',
				GBS_FAIL 		=> '失败结束',
		),

		'label_order_qty' 		=> '订单数 / 有效订单数：',
		'label_goods_qty' 		=> '商品数 / 有效商品数：',
		'label_cur_price' 		=> '当前价：',
		'label_end_price' 		=> '最终价：',
		'label_handler' 		=> '操作：',
		'error_group_buy' 		=> '您要操作的团购活动不存在',
		'error_status' 			=> '当前状态不能执行该操作！',
		'button_finish' 		=> '结束活动',
		'button_succeed' 		=> '活动成功',
		'notice_succeed' 		=> '（更新订单价格）',
		'button_fail' 			=> '活动失败',
		'notice_fail' 			=> '（取消订单，保证金退回帐户余额，失败原因可以写到活动说明中）',
		'cancel_order_reason' 	=> '团购失败',

		'js_lang' => array(
				'succeed_confirm' 		=> '此操作不可逆，您确定要设置该团购活动成功吗？',
				'fail_confirm' 			=> '此操作不可逆，您确定要设置该团购活动失败吗？',
				'error_goods_null' 		=> '您没有选择团购活动！',
				'error_deposit' 		=> '您输入的保证金不是数字！',
				'error_restrict_amount' => '您输入的限购数量不是整数！',
				'error_gift_integral' 	=> '您输入的赠送积分数不是整数！',
				'search_is_null' 		=> '没有搜索到任何商品，请重新搜索',
				'batch_drop_confirm' 	=> '您确定要删除选定的团购活动吗？',
				'notice_mail' 			=> '通知客户付清余款，以便发货',
				'notice_finish' 		=> '修改活动结束时间为当前时间？',
				'ok'					=> '确定',
				'cancel'				=> '取消',
				'select_groupbuy_goods'	=> '请在添加团购商品区域选择团购商品',
				'select_goods_empty'	=> '未搜索到商品信息',
				'start_time_required'	=> '请输入开始时间！',
				'end_time_required'		=> '请输入结束时间！',
		),

		'button_mail' 	=> '发送邮件',
		'button_sms' 	=> '发送短信',
		'mail_result' 	=> '该团购活动共有 %s 个有效订单，成功发送了 %s 封邮件。',
		'invalid_time' 	=> '您输入了一个无效的团购时间。',

		'add_success' 	=> '添加团购活动成功',
		'edit_success' 	=> '编辑团购活动成功',
		'back_list' 	=> '返回团购活动列表',
		'continue_add' 	=> '继续添加团购活动',

		/* 添加/编辑活动提交 */
		'error_goods_null' 		=> '您没有选择团购活动！',
		'error_goods_exist' 	=> '您选择的商品目前有一个团购活动正在进行！',
		'error_price_ladder' 	=> '您没有输入有效的价格阶梯！',
		'error_restrict_amount' => '限购数量不能小于价格阶梯中的最大数量',

		/* 删除团购活动 */
		'error_exist_order' 	=> '该团购活动已经有订单，不能删除！',
		'batch_drop_success' 	=> '成功删除了 %s 条团购活动记录（已经有订单的团购活动不能删除）。',
		'no_select_group_buy' 	=> '您现在没有团购活动记录！',

		/* 操作日志 */
		'log_action' => array(
				'group_buy' => '团购商品'
		),

		//追加
		'group_buy'			=> '团购活动',
		'add_group_goods'	=> '添加团购商品',
		'set_group_info'	=> '设置团购信息',
		'update_group_goods'=> '更新团购商品',
		'update_group_info'	=> '更新团购信息',
		'update_group_buy'	=> '更新团购活动',
		'mail_send_success'	=> '邮件发送成功',
		'remove_success'	=> '删除成功',
		'remove_fail'		=> '删除失败',

		'batch_remove_success'	=> '批量删除操作成功',
		'batch'					=> '批量操作',
		'batch_drop_confirm' 	=> '您确定要删除选中的团购活动吗？',
		'remove_group_buy'		=> '删除团购',
		'enter_groupbuy_name'	=> '请输入商品名称关键字',
		'search'				=> '搜索',
		'drop_confirm' 			=> '您确定要删除该团购活动吗？',
		'search_goods'			=> '搜索商品',
		'help_goods_name'		=> '需要先在“添加团购商品”区域进行商品搜索，在此会生成商品列表，然后再选择即可',
		'select_start_time'		=> '请选择开始时间',
		'select_end_time'		=> '请选择结束时间',
		'group_buy_introduce'	=> '团购活动介绍',

		'groupbuy_manage'		=> '团购活动管理',
		'groupbuy_add'			=> '团购活动添加',
		'groupbuy_update'		=> '团购活动更新',
		'groupbuy_delete'		=> '团购活动删除',

		'overview'				=> '概述',
		'more_info'				=> '更多信息：',

		'groupbuy_list_help'	=> '欢迎访问ECJia智能后台团购列表页面，系统中所有的团购都会显示在此列表中。',
		'about_groupbuy_list'	=> '关于团购列表帮助文档',

		'add_groupbuy_help'		=> '欢迎访问ECJia智能后台添加团购页面，可以才此页面中进行添加团购操作。',
		'about_add_groupbuy'	=> '关于添加团购帮助文档',

		'edit_groupbuy_help'	=> '欢迎访问ECJia智能后台编辑团购页面，可以才此页面中进行编辑团购操作。',
		'about_edit_groupbuy'	=> '关于编辑团购帮助文档',

		//退款操作语言包
		'refund_error_notice'	=> '匿名用户不能返回退款到帐户余额！',
		'error_notice'			=> '操作有误！请重新操作！',
		'order_refund' 			=> '订单退款：%s',

		'update'	=> '更新'
);

//end