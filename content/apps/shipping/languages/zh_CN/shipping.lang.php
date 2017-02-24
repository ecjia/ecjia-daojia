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
 * ECJia 管理中心配送方式管理语言文件
 */
return array(
	'03_shipping_list' 	=> '配送方式',
	'shipping_name' 	=> '名称',
	'shipping_version' 	=> '插件版本',
	'shipping_desc' 	=> '描述',
	'shipping_author' 	=> '插件作者',
	'insure' 			=> '保价费用',
	'support_cod' 		=> '货到付款',
	'shipping_area' 	=> '设置区域',
	'shipping_print_edit' 		=> '编辑打印模板',
	'shipping_print_template'	=> '快递单模板',
	'shipping_template_info'	=> '订单模板变量说明：<br/>{$shop_name}表示网店名称<br/>{$province}表示网店所属省份<br/>{$city}表示网店所属城市<br/>{$shop_address}表示网店地址<br/>{$service_phone}表示网店联系电话<br/>{$order.order_amount}表示订单金额<br/>{$order.region}表示收件人地区<br/>{$order.tel}表示收件人电话<br/>{$order.mobile}表示收件人手机<br/>{$order.zipcode}表示收件人邮编<br/>{$order.address}表示收件人详细地址<br/>{$order.consignee}表示收件人名称<br/>{$order.order_sn}表示订单号Express order number',
	'shipping_template_info_t'  => '订单模板变量说明',
	'shipping_template_info_l' 	=> '{$shop_name}表示网店名称<br/>{$province}表示网店所属省份<br/>{$city}表示网店所属城市<br/>{$shop_address}表示网店地址<br/>{$service_phone}表示网店联系电话<br/>',
	'shipping_template_info_c' 	=> '{$order.order_amount}表示订单金额<br/>{$order.region}表示收件人地区<br/>{$order.tel}表示收件人电话<br/>{$order.mobile}表示收件人手机<br/>',
	'shipping_template_info_r' 	=> '{$order.zipcode}表示收件人邮编<br/>{$order.address}表示收件人详细地址<br/>{$order.consignee}表示收件人名称<br/>{$order.order_sn}表示订单号',

	'enable' 	=> '启用',
	'disable' 	=> '禁用',
		
	/* 表单部分 */
	'shipping_install' 	=> '安装配送方式',
	'install_succeess' 	=> '配送方式 %s 安装成功！',
	'del_lable' 		=> '删除标签',
	'upload_shipping_bg'=> '上传打印单图片',
	'del_shipping_bg' 	=> '删除打印单图片',
	'save_setting' 		=> '保存设置',
	'recovery_default' 	=> '恢复默认',
	'attradd_succed' 	=> '操作成功!',
	'attradd_faild'   	=> '操作失败!',
		
	/* 快递单部分 */
	'lable_select_notice' => '--选择插入标签--',
	'lable_box' => array(
		'shop_country' 	=> '网店-国家',
		'shop_province' => '网店-省份',
		'shop_city' 	=> '网店-城市',
		'shop_name' 	=> '网店-名称',
		'shop_district' => '网店-区/县',
		'shop_tel' 		=> '网店-联系电话',
		'shop_address' 	=> '网店-地址',
		
		'customer_country' 	=> '收件人-国家',
		'customer_province' => '收件人-省份',
		'customer_city' 	=> '收件人-城市',
		'customer_district' => '收件人-区/县',
		'customer_tel' 		=> '收件人-电话',
		'customer_mobel' 	=> '收件人-手机',
		'customer_post' 	=> '收件人-邮编',
		'customer_address' 	=> '收件人-详细地址',
		'customer_name' 	=> '收件人-姓名',
		
		'year' 		=> '年-当日日期',
		'months' 	=> '月-当日日期',
		'day' 		=> '日-当日日期',
		'order_no' 	=> '订单号-订单',
		
		'order_postscript' 	=> '备注-订单',
		'order_best_time' 	=> '送货时间-订单',
		'pigeon' 			=> '√-对号',
	),
		
	/* 提示信息 */
	'no_shipping_name' 		=> '配送方式名称不能为空。',
	'no_shipping_desc' 		=> '配送方式描述内容不能为空。',
	'change_shipping_desc_faild' => '配送方式描述内容修改失败。',
	'repeat_shipping_name' 	=> '已经存在一个同名的配送方式。',
	'uninstall_success' 	=> '配送方式 %s 已经成功卸载。',
	'add_shipping_area' 	=> '为该配送方式新建配送区域',
	'no_shipping_insure' 	=> '保价费用不能为空，不想使用请将其设置为0',
	'not_support_insure' 	=> '该配送方式不支持保价,保价费用设置失败',
	'invalid_insure' 		=> '配送保价费用不是一个合法价格',
	'no_shipping_install' 	=> '您的配送方式尚未安装，暂不能编辑模板',
	'edit_template_success' => '快递模板已经成功编辑。',
		
	/* JS 语言 */
	'js_languages' => array(
		'lang_removeconfirm' 	=> '您确定要卸载该配送方式吗？',
		'shipping_area' 		=> '设置区域',
		'upload_falid' 			=> '错误：文件类型不正确。请上传“%s”类型的文件！',
		'upload_del_falid' 		=> '错误：删除失败！',
		'upload_del_confirm'	=> "提示：您确认删除打印单图片吗？",
		'no_select_upload' 		=> "错误：您还没有选择打印单图片。请使用“浏览...”按钮选择！",
		'no_select_lable' 		=> "操作终止！您未选择任何标签。",
		'no_add_repeat_lable' 	=> "操作失败！不允许添加重复标签。",
		'no_select_lable_del' 	=> "删除失败！您没有选中任何标签。",
		'recovery_default_suer' => "您确认恢复默认吗？恢复默认后将显示安装时的内容。",
	),
	
	//追加
	'select_image'			=> '选择图片',
	'file_empty'			=> '未选中文件',
	'upload'				=> '上传',
	'edit_shipping_name'	=> '编辑配送方式名称',
	'set_shipping'			=> '设置配送区域',
	'edit_shipping_order' 	=> '编辑配送方式排序',
	'not_support'			=> '不支持',
	
	'select_template_mode'	=> '请选择模板的模式：',
	'code_mode'				=> '代码模式',
	'income_model'			=> '所见即所得模式',
	'mode_notice'			=> '选择“代码模式”可以切换到以前版本。建议您使用“所见即所得模式”。所有模式选择后，同样在打印模板中生效。',
	
	'shipping'	 		=> '配送方式',
	'plugin'			=> '插件',
	'disabled'			=> '已停用',
	'enabled'			=> '已启用',
	'format_error'		=> '输入格式不正确',
	'remove_success'	=> '删除成功',
	'use_again_notice'	=> '要删除的图片是默认图片，恢复模板可再次使用',
	'remove_success'	=> '删除失败',
	'express_template'	=> '快递单模版',
	'edit_template'		=> '快递单模板编辑',
	'shipping_list'		=> '配送方式列表',
	'enter_valid_number'=> '请输入合法数字或百分比%',
	
	'edit_shipping'			=> '编辑配送方式',
	'insure_lable' 			=> '保价费用：',
	'shipping_name_lable'	=> '名称：',
	'shipping_desc_lable' 	=> '描述：',
	'support_cod_label'		=> '货到付款：',
	'shipping_not_available'=> '该配送插件不存在或尚未安装',
	'repeat'				=> '已存在',
	'install_ok' 			=> '安装成功',
	'edit_ok'				=> '编辑成功',
	
	'shipping_manage'		=> '配送方式管理',
	'shipping_merchant_manage'	=> '我的配送',
	
	'js_lang' => array(
		'shipping_area_name_required'	=> '配送区域名称不能为空',
		'not_empty_message'				=> '不能为空且必须是一个整数。',
		'shipping_area_region_required' => '配送区域的所辖区域不能为空。',
		'no_select_region'				=> '没有可选择的地区',
		'add'							=> '添加',
		'region_selected'				=> '该地区已被选择！',
		'shipping_name_required'		=> '请输入配送方式名称',
		'shipping_name_minlength'		=> '配送方式称长度不能小于3',
		'shipping_desc_required'		=> '请输入配送方式描述',
		'shipping_desc_minlength'		=> '配送方式描述长度不能小于6',
	),
	
	'overview'				=> '概述',
	'more_info'         	=> '更多信息：',
	
	'shipping_list_help'	=> '欢迎访问ECJia智能后台配送方式页面，系统中所有的配送方式都会显示在此列表中。',
	'about_shipping_list'	=> '关于配送方式帮助文档',
	
	'edit_template_help'	=> '欢迎访问ECJia智能后台快递单模板编辑页面，可以在此编辑相应的快递单模板信息。',
	'about_edit_template'	=> '关于快递单模板编辑帮助文档',
    'close_distribution'    => '（删除配送区域即可关闭配送方式）',
    'open_distribution'     => '（设置配送区域即可开启配送方式）',
    
    //平台配送列表
    'express_order_list'    			=> '配送列表',
    'admin_express_order_manage' 		=> '配送列表',
    'admin_express_info'				=> '配送详情',
    'admin_view_info'					=> '查看详情',
    'admin_assign'						=> '派单',
    'admin_grab'						=> '抢单',
    'admin_wait_assign'					=> '待派单',
    'admin_wait_assign_express'			=> '未分派运单',
    'admin_wait_pick_up'				=> '已接派单待取货',
    'admin_express_delivery'			=> '已取货派送中',
    'admin_return_express'				=> '退货中',
    'admin_refused'						=> '拒收',
    'admin_already_signed'				=> '已签收',
    'admin_has_returned'				=> '已退回',
    'admin_enter_merchant_keywords' 	=> '输入商家名称关键字',
    'admin_pls_express_sn'				=> '输入配送流水号等关键字',
    'admin_search_express'				=> '搜索',
    'admin_merchants_name'				=> '商家名称',
    /* 基本信息 */
	'admin_label_express_sn'	  		=> '配送流水号：',
	'admin_label_order_sn'	      		=> '订单编号：',
	'admin_label_delivery_sn'	  		=> '发货单流水号：',
	'admin_label_merchant_name'	  		=> '店铺名称：',
	'admin_label_consignee'	      		=> '收货人名称：',
	'admin_label_address'		  		=> '收货地址：',
	'admin_label_email'		      		=> '邮箱地址：',
	'admin_label_mobile'		  		=> '联系方式：',
	'admin_label_remark'		  		=> '客户给商家的留言：',
	'admin_label_distance'	      		=> '送货距离：',
	'admin_label_best_time'	      		=> '期望送货时间：',
	'admin_label_add_time'	      		=> '创建时间：',
	'admin_label_receive_time'	  		=> '接单时间：',
	'admin_label_express_time'	  		=> '取货配送时间：',
	'admin_label_signed_time'	  		=> '签收时间：',
	'admin_label_update_time'	  		=> '更新时间：',
	'admin_label_from'		      		=> '配送来源：',
	'admin_label_express_status'  		=> '配送状态：',
	'admin_label_express_staff_name' 	=> '配送员：',
    'admin_express_sn'					=> '配送流水号',
    'admin_delivery_sn'					=> '发货单流水号',
    'admin_consignee'					=> '收货人名称',
    'admin_address'						=> '收货地址',
    'admin_mobile'						=> '联系方式',
    'admin_add_time'					=> '创建时间',
    'admin_from'						=> '配送来源',
    'admin_express_status'				=> '配送状态',
    /* 详情页*/
    'admin_base_info'			=> '基本信息',
    'admin_consignee_info'		=> '收货人信息',
    'admin_goods_info'			=> '商品信息',
    'admin_goods_name_brand'	=> '商品名称 [品牌 ]',
    'admin_goods_sn'			=> '货号',
    'admin_product_sn'			=> '货品号',
    'admin_goods_attr'			=> '属性',
    'admin_label_send_number'	=> '发货数量',
    'admin_express_op_info'		=> '配送操作信息',
    'admin_label_operable_act'  => '当前可执行操作：',
    'admin_change_express_user'	=> '变更配送人员',
    'admin_label_express_user'	=> '配送人员：',
    'admin_express_user_pickup'	=> '配送员已取货',
);

// end