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
$LANG['orders']            		= '订单';
$LANG['orders_desc']       		= '订单功能描述';

/* 订单搜索 */
$LANG['order_sn'] 				= '订单号';
$LANG['consignee'] 				= '收货人';
$LANG['all_status'] 			= '订单状态';
$LANG['thumb_img'] 				= '缩略图';

$LANG['cs'][OS_UNCONFIRMED] 	= '待确认';
$LANG['cs'][CS_AWAIT_PAY] 		= '待付款';
$LANG['cs'][CS_AWAIT_SHIP] 		= '待发货';
$LANG['cs'][CS_FINISHED] 		= '已完成';
$LANG['cs'][PS_PAYING] 			= '付款中';
$LANG['cs'][OS_CANCELED] 		= '取消';
$LANG['cs'][OS_INVALID] 		= '无效';
$LANG['cs'][OS_RETURNED] 		= '退货';
$LANG['cs'][OS_SHIPPED_PART] 	= '部分发货';

/* 订单状态 */
$LANG['os'][OS_UNCONFIRMED] 	= '未确认';
$LANG['os'][OS_CONFIRMED] 		= '已确认';
$LANG['os'][OS_CANCELED] 		= '<font color="red">取消</font>';
$LANG['os'][OS_INVALID] 		= '<font color="red">无效</font>';
$LANG['os'][OS_RETURNED] 		= '<font color="red">退货</font>';
$LANG['os'][OS_SPLITED] 		= '已分单';
$LANG['os'][OS_SPLITING_PART] 	= '部分分单';

$LANG['ss'][SS_UNSHIPPED] 		= '未发货';
$LANG['ss'][SS_PREPARING] 		= '配货中';
$LANG['ss'][SS_SHIPPED] 		= '已发货';
$LANG['ss'][SS_RECEIVED] 		= '收货确认';
$LANG['ss'][SS_SHIPPED_PART] 	= '已发货(部分商品)';
$LANG['ss'][SS_SHIPPED_ING] 	= '发货中';

$LANG['ps'][PS_UNPAYED] 		= '未付款';
$LANG['ps'][PS_PAYING]		 	= '付款中';
$LANG['ps'][PS_PAYED] 			= '已付款';

$LANG['ss_admin'][SS_SHIPPED_ING] = '发货中（前台状态：未发货）';
/* 订单操作 */
$LANG['label_operable_act'] 	= '当前可执行操作：';
$LANG['label_action_note'] 		= '操作备注：';
$LANG['label_invoice_note'] 	= '发货备注：';
$LANG['label_invoice_no'] 		= '发货单号：';
$LANG['label_cancel_note']	 	= '取消原因：';
$LANG['notice_cancel_note'] 	= '（会记录在商家给客户的留言中）';
$LANG['op_confirm'] 			= '确认';
$LANG['op_pay'] 				= '付款';
$LANG['op_prepare'] 			= '配货';
$LANG['op_ship'] 				= '发货';
$LANG['op_cancel'] 				= '取消';
$LANG['op_invalid'] 			= '无效';
$LANG['op_return'] 				= '退货';
$LANG['op_unpay'] 				= '设为未付款';
$LANG['op_unship'] 				= '未发货';
$LANG['op_cancel_ship'] 		= '取消发货';
$LANG['op_receive'] 			= '已收货';
$LANG['op_assign'] 				= '指派给';
$LANG['op_after_service'] 		= '售后';
$LANG['act_ok'] 				= '操作成功';
$LANG['act_false'] 				= '操作失败';
$LANG['act_ship_num'] 			= '此单发货数量不能超出订单商品数量';
$LANG['act_good_vacancy'] 		= '商品已缺货';
$LANG['act_good_delivery'] 		= '货已发完';
$LANG['notice_gb_ship'] 		= '备注：团购活动未处理为成功前，不能发货';
$LANG['back_list'] 				= '返回订单列表';
$LANG['op_remove'] 				= '删除';
$LANG['op_you_can'] 			= '您可进行的操作';
$LANG['op_split'] 				= '生成发货单';
$LANG['op_to_delivery'] 		= '去发货';

/* 订单列表 */
$LANG['order_amount'] 						= '应付金额';
$LANG['total_fee'] 							= '总金额';
$LANG['shipping_name'] 						= '配送方式';
$LANG['pay_name'] 							= '支付方式';
$LANG['address'] 							= '地址';
$LANG['order_time'] 						= '下单时间';
$LANG['detail'] 							= '查看';
$LANG['phone'] 								= '电话';
$LANG['group_buy'] 							= '（团购）';
$LANG['error_get_goods_info'] 				= '获取订单商品信息错误';
$LANG['exchange_goods'] 					= '（积分兑换）';

$LANG['js_languages']['remove_confirm'] 	= '删除订单将清除该订单的所有信息。您确定要这么做吗？';
$LANG['merge_confirm'] 						= '您确定要合并这两个订单吗？';
$LANG['action_note_sure'] 					= '请输入操作备注！';
$LANG['back_order_info'] 					= '返回订单详情！';

/* 订单搜索 */
$LANG['label_order_sn'] 			= '订单号：';
$LANG['label_all_status'] 			= '订单状态：';
$LANG['label_user_name'] 			= '购货人：';
$LANG['label_consignee'] 			= '收货人：';
$LANG['label_email'] 				= '电子邮件：';
$LANG['label_address'] 				= '地址：';
$LANG['label_zipcode'] 				= '邮编：';
$LANG['label_tel'] 					= '电话：';
$LANG['label_mobile'] 				= '手机：';
$LANG['label_shipping'] 			= '配送方式：';
$LANG['label_payment'] 				= '支付方式：';
$LANG['label_order_status'] 		= '订单状态：';
$LANG['label_pay_status'] 			= '付款状态：';
$LANG['label_shipping_status'] 		= '发货状态：';
$LANG['label_area'] 				= '所在地区：';
$LANG['label_time'] 				= '下单时间：';

/* 订单详情 */
$LANG['prev'] 						= '前一个订单';
$LANG['next'] 						= '后一个订单';
$LANG['print_order'] 				= '打印订单';
$LANG['print_shipping'] 			= '打印快递单';
$LANG['print_order_sn'] 			= '订单编号：';
$LANG['print_buy_name'] 			= '购 货 人：';
$LANG['label_consignee_address'] 	= '收货地址：';
$LANG['no_print_shipping'] 			= '很抱歉,目前您还没有设置打印快递单模板.不能进行打印';
$LANG['suppliers_no'] 				= '不指定供货商本店自行处理';
$LANG['restaurant'] 				= '本店';

$LANG['order_info'] 			= '订单信息';
$LANG['base_info'] 				= '基本信息';
$LANG['other_info'] 			= '其他信息';
$LANG['consignee_info'] 		= '收货人信息';
$LANG['fee_info'] 				= '费用信息';
$LANG['action_info'] 			= '操作信息';
$LANG['shipping_info'] 			= '配送信息';

$LANG['label_how_oos'] 			= '缺货处理：';
$LANG['label_how_surplus'] 		= '余额处理：';
$LANG['label_pack'] 			= '包装：';
$LANG['label_card'] 			= '贺卡：';
$LANG['label_card_message'] 	= '贺卡祝福语：';
$LANG['label_order_time'] 		= '下单时间：';
$LANG['label_pay_time'] 		= '付款时间：';
$LANG['label_shipping_time'] 	= '发货时间：';
$LANG['label_sign_building'] 	= '标志性建筑：';
$LANG['label_best_time'] 		= '最佳送货时间：';
$LANG['label_inv_type'] 		= '发票类型：';
$LANG['label_inv_payee'] 		= '发票抬头：';
$LANG['label_inv_content'] 		= '发票内容：';
$LANG['label_postscript'] 		= '客户给商家的留言：';
$LANG['label_region'] 			= '所在地区：';

$LANG['label_shop_url'] 		= '网址：';
$LANG['label_shop_address'] 	= '地址：';
$LANG['label_service_phone'] 	= '电话：';
$LANG['label_print_time'] 		= '打印时间：';

$LANG['label_suppliers'] 		= '选择供货商：';
$LANG['label_agency'] 			= '办事处：';
$LANG['suppliers_name'] 		= '供货商';

$LANG['product_sn'] 			= '货品号';
$LANG['goods_info'] 			= '商品信息';
$LANG['goods_name'] 			= '商品名称';
$LANG['goods_name_brand'] 		= '商品名称 [ 品牌 ]';
$LANG['goods_sn'] 				= '货号';
$LANG['goods_price'] 			= '价格';
$LANG['goods_number'] 			= '数量';
$LANG['goods_attr'] 			= '属性';
$LANG['goods_delivery'] 		= '已发货数量';
$LANG['goods_delivery_curr'] 	= '此单发货数量';
$LANG['storage'] 				= '库存';
$LANG['subtotal'] 				= '小计';
$LANG['label_total'] 			= '合计：';
$LANG['label_total_weight'] 	= '商品总重量：';

$LANG['label_goods_amount'] 	= '商品总金额：';
$LANG['label_discount'] 		= '折扣：';
$LANG['label_tax'] 				= '发票税额：';
$LANG['label_shipping_fee'] 	= '配送费用：';
$LANG['label_insure_fee'] 		= '保价费用：';
$LANG['label_insure_yn'] 		= '是否保价：';
$LANG['label_pay_fee'] 			= '支付费用：';
$LANG['label_pack_fee'] 		= '包装费用：';
$LANG['label_card_fee'] 		= '贺卡费用：';
$LANG['label_money_paid'] 		= '已付款金额：';
$LANG['label_surplus'] 			= '使用余额：';
$LANG['label_integral'] 		= '使用积分：';
$LANG['label_bonus'] 			= '使用红包：';
$LANG['label_order_amount'] 	= '订单总金额：';
$LANG['label_money_dues'] 		= '应付款金额：';
$LANG['label_money_refund'] 	= '应退款金额：';
$LANG['label_to_buyer'] 		= '商家给客户的留言：';
$LANG['save_order'] 			= '保存订单';
$LANG['notice_gb_order_amount'] = '（备注：团购如果有保证金，第一次只需支付保证金和相应的支付费用）';

$LANG['action_user'] 			= '操作者：';
$LANG['action_time'] 			= '操作时间';
$LANG['order_status'] 			= '订单状态';
$LANG['pay_status'] 			= '付款状态';
$LANG['shipping_status'] 		= '发货状态';
$LANG['action_note'] 			= '备注';
$LANG['pay_note'] 				= '支付备注：';

$LANG['sms_time_format'] 		= 'm月j日G时';
$LANG['order_shipped_sms'] 		= '您的订单%s已于%s发货 [%s]';
$LANG['order_splited_sms'] 		= '您的订单%s,%s正在%s [%s]';
$LANG['order_removed'] 			= '订单删除成功。';
$LANG['return_list'] 			= '返回订单列表';

/* 订单处理提示 */
$LANG['surplus_not_enough'] 	= '该订单使用 %s 余额支付，现在用户余额不足';
$LANG['integral_not_enough'] 	= '该订单使用 %s 积分支付，现在用户积分不足';
$LANG['bonus_not_available'] 	= '该订单使用红包支付，现在红包不可用';

/* 购货人信息 */
$LANG['display_buyer'] 	= '显示购货人信息';
$LANG['buyer_info'] 	= '购货人信息';
$LANG['pay_points'] 	= '消费积分';
$LANG['rank_points'] 	= '等级积分';
$LANG['user_money'] 	= '账户余额';
$LANG['email'] 			= '电子邮件';
$LANG['rank_name'] 		= '会员等级';
$LANG['bonus_count'] 	= '红包数量';
$LANG['zipcode'] 		= '邮编';
$LANG['tel'] 			= '电话';
$LANG['mobile'] 		= '备用电话';

/* 合并订单 */
$LANG['order_sn_not_null'] 					= '请填写要合并的订单号';
$LANG['two_order_sn_same'] 					= '要合并的两个订单号不能相同';
$LANG['order_not_exist'] 					= '定单 %s 不存在';
$LANG['os_not_unconfirmed_or_confirmed'] 	= '%s 的订单状态不是“未确认”或“已确认”';
$LANG['ps_not_unpayed'] 					= '订单 %s 的付款状态不是“未付款”';
$LANG['ss_not_unshipped'] 					= '订单 %s 的发货状态不是“未发货”';
$LANG['order_user_not_same'] 				= '要合并的两个订单不是同一个用户下的';
$LANG['merge_invalid_order'] 				= '对不起，您选择合并的订单不允许进行合并的操作。';

$LANG['from_order_sn'] 						= '从订单：';
$LANG['to_order_sn'] 						= '主订单：';
$LANG['merge'] 								= '合并';
$LANG['notice_order_sn'] 					= '当两个订单不一致时，合并后的订单信息（如：支付方式、配送方式、包装、贺卡、红包等）以主订单为准。';

/* 批处理 */
$LANG['pls_select_order'] 			= '请选择您要操作的订单';
$LANG['no_fulfilled_order'] 		= '没有满足操作条件的订单。';
$LANG['updated_order'] 				= '更新的订单：';
$LANG['order'] 						= '订单：';
$LANG['confirm_order'] 				= '有订单无法设置为确认状态';
$LANG['invalid_order'] 				= '有订单无法设置为无效';
$LANG['cancel_order'] 				= '有订单无法取消';
$LANG['remove_order'] 				= '有订单无法被移除';
$LANG['check_info'] 				= '查看详情';

/* 编辑订单打印模板 */
$LANG['edit_order_templates'] 		= '编辑订单打印模板';
$LANG['template_resetore'] 			= '还原模板';
$LANG['edit_template_success'] 		= '编辑订单打印模板操作成功!';
$LANG['remark_fittings'] 			= '（配件）';
$LANG['remark_gift'] 				= '（赠品）';
$LANG['remark_favourable'] 			= '（特惠品）';
$LANG['remark_package'] 			= '（礼包）';

/* 订单来源统计 */
$LANG['from_order'] 				= '订单来源：';
$LANG['from_ad_js'] 				= '广告：';
$LANG['from_goods_js'] 				= '商品站外JS投放';
$LANG['from_self_site'] 			= '来自本站';
$LANG['from'] 						= '来自站点：';

/* 添加、编辑订单 */
$LANG['add_order'] 					= '添加订单';
$LANG['edit_order'] 				= '编辑订单';
$LANG['step']['user'] 				= '请选择您要为哪个会员下订单';
$LANG['step']['goods'] 				= '选择商品';
$LANG['step']['consignee'] 			= '设置收货人信息';
$LANG['step']['shipping'] 			= '选择配送方式';
$LANG['step']['payment'] 			= '选择支付方式';
$LANG['step']['other'] 				= '设置其他信息';
$LANG['step']['money'] 				= '设置费用';
$LANG['anonymous'] 					= '匿名用户';
$LANG['by_useridname'] 				= '按会员编号或会员名搜索';
$LANG['button_prev'] 				= '上一步';
$LANG['button_next'] 				= '下一步';
$LANG['button_finish'] 				= '完成';
$LANG['button_cancel'] 				= '取消';
$LANG['name'] 						= '名称';
$LANG['desc'] 						= '描述';
$LANG['shipping_fee'] 				= '配送费';
$LANG['free_money'] 				= '免费额度';
$LANG['insure'] 					= '保价费';
$LANG['pay_fee'] 					= '手续费';
$LANG['pack_fee'] 					= '包装费';
$LANG['card_fee'] 					= '贺卡费';
$LANG['no_pack'] 					= '不要包装';
$LANG['no_card'] 					= '不要贺卡';
$LANG['add_to_order'] 				= '加入订单';
$LANG['calc_order_amount'] 			= '计算订单金额';
$LANG['available_surplus'] 			= '可用余额：';
$LANG['available_integral'] 		= '可用积分：';
$LANG['available_bonus'] 			= '可用红包：';
$LANG['admin'] 						= '管理员添加';
$LANG['search_goods'] 				= '按商品编号或商品名称或商品货号搜索';
$LANG['category'] 					= '分类';
$LANG['brand'] 						= '品牌';
$LANG['user_money_not_enough'] 		= '用户余额不足';
$LANG['pay_points_not_enough'] 		= '用户积分不足';
$LANG['money_paid_enough'] 			= '已付款金额比商品总金额和各种费用之和还多，请先退款';
$LANG['price_note'] 				= '备注：商品价格中已包含属性加价';
$LANG['select_pack'] 				= '选择包装';
$LANG['select_card'] 				= '选择贺卡';
$LANG['select_shipping'] 			= '请先选择配送方式';
$LANG['want_insure'] 				= '我要保价';
$LANG['update_goods'] 				= '更新商品';
$LANG['notice_user'] 				= '<strong>注意：</strong>搜索结果只显示前50条记录，如果没有找到相' .
        							'应会员，请更精确地查找。另外，如果该会员是从论坛注册的且没有在商城登录过，' .
        							'也无法找到，需要先在商城登录。';
$LANG['amount_increase'] 			= '由于您修改了订单，导致订单总金额增加，需要再次付款';
$LANG['amount_decrease'] 			= '由于您修改了订单，导致订单总金额减少，需要退款';
$LANG['continue_shipping'] 			= '由于您修改了收货人所在地区，导致原来的配送方式不再可用，请重新选择配送方式';
$LANG['continue_payment'] 			= '由于您修改了配送方式，导致原来的支付方式不再可用，请重新选择支付方式';
$LANG['refund'] 					= '退款';
$LANG['cannot_edit_order_shipped'] 	= '您不能修改已发货的订单';
$LANG['address_list'] 				= '从已有收货地址中选择：';
$LANG['order_amount_change'] 		= '订单总金额由 %s 变为 %s';
$LANG['shipping_note'] 				= '说明：因为订单已发货，修改配送方式将不会改变配送费和保价费。';
$LANG['change_use_surplus'] 		= '编辑订单 %s ，改变使用预付款支付的金额';
$LANG['change_use_integral'] 		= '编辑订单 %s ，改变使用积分支付的数量';
$LANG['return_order_surplus'] 		= '由于取消、无效或退货操作，退回支付订单 %s 时使用的预付款';
$LANG['return_order_integral'] 		= '由于取消、无效或退货操作，退回支付订单 %s 时使用的积分';
$LANG['order_gift_integral'] 		= '订单 %s 赠送的积分';
$LANG['return_order_gift_integral'] = '由于退货或未发货操作，退回订单 %s 赠送的积分';
$LANG['invoice_no_mall'] 			= '&nbsp;&nbsp;&nbsp;&nbsp;多个发货单号，请用英文逗号（“,”）隔开。';

$LANG['js_languages']['input_price'] 				= '自定义价格';
$LANG['js_languages']['pls_search_user'] 			= '请搜索并选择会员';
$LANG['js_languages']['confirm_drop'] 				= '确认要删除该商品吗？';
$LANG['js_languages']['invalid_goods_number'] 		= '商品数量不正确';
$LANG['js_languages']['pls_search_goods'] 			= '请搜索并选择商品';
$LANG['js_languages']['pls_select_area'] 			= '请完整选择所在地区';
$LANG['js_languages']['pls_select_shipping'] 		= '请选择配送方式';
$LANG['js_languages']['pls_select_payment'] 		= '请选择支付方式';
$LANG['js_languages']['pls_select_pack'] 			= '请选择包装';
$LANG['js_languages']['pls_select_card'] 			= '请选择贺卡';
$LANG['js_languages']['pls_input_note'] 			= '请您填写备注！';
$LANG['js_languages']['pls_input_cancel'] 			= '请您填写取消原因！';
$LANG['js_languages']['pls_select_refund'] 			= '请选择退款方式！';
$LANG['js_languages']['pls_select_agency'] 			= '请选择办事处！';
$LANG['js_languages']['pls_select_other_agency'] 	= '该订单现在就属于这个办事处，请选择其他办事处！';
$LANG['js_languages']['loading'] 					= '加载中...';

/* 订单操作 */
$LANG['order_operate'] 			= '订单操作：';
$LANG['label_refund_amount'] 	= '退款金额：';
$LANG['label_handle_refund'] 	= '退款方式：';
$LANG['label_refund_note'] 		= '退款说明：';
$LANG['return_user_money'] 		= '退回用户余额';
$LANG['create_user_account'] 	= '生成退款申请';
$LANG['not_handle'] 			= '不处理，误操作时选择此项';
$LANG['order_refund'] 			= '订单退款：%s';
$LANG['order_pay'] 				= '订单支付：%s';
$LANG['send_mail_fail'] 		= '发送邮件失败';
$LANG['send_message'] 			= '发送/查看留言';


/* 发货单操作 */
$LANG['delivery_operate'] 		= '发货单操作：';
$LANG['delivery_sn_number'] 	= '发货单流水号：';
$LANG['invoice_no_sms'] 		= '请填写发货单号！';
/* 发货单搜索 */
$LANG['delivery_sn'] 			= '发货单';
/* 发货单状态 */
$LANG['delivery_status'][0] 	= '已发货';
$LANG['delivery_status'][1] 	= '退货';
$LANG['delivery_status'][2] 	= '正常';
/* 发货单标签 */
$LANG['label_delivery_status'] 	= '发货单状态';
$LANG['label_suppliers_name'] 	= '供货商';
$LANG['label_delivery_time'] 	= '生成时间';
$LANG['label_delivery_sn'] 		= '发货单流水号';
$LANG['label_add_time'] 		= '下单时间';
$LANG['label_update_time'] 		= '发货时间';
$LANG['label_send_number'] 		= '发货数量';
$LANG['tips_delivery_del'] 		= '发货单删除成功！';


/* 退货单操作 */
$LANG['back_operate'] 		= '退货单操作：';
/* 退货单标签 */
$LANG['return_time'] 		= '退货时间：';
$LANG['label_return_time'] 	= '退货时间';
/* 退货单提示 */
$LANG['tips_back_del'] 		= '退货单删除成功！';
$LANG['goods_num_err'] 		= '库存不足，请重新选择！';

// end