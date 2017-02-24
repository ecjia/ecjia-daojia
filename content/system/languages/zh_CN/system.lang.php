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
 * 管理中心共用语言文件
 */

return array(
	'app_name' 			=> 'ECJIA',
	'cp_home' 			=> 'ECJIA 管理面板',
	'copyright' 		=> '版权所有 &copy, 2013-2014 上海商派网络科技有限公司，并保留所有权利。',
	'query_info' 		=> '共执行 %d 个查询，程序运行用时 %s 秒',
	'memory_info' 		=> '，内存占用 %0.3f MB',
	'gzip_enabled' 		=> '，Gzip 已启用',
	'gzip_disabled' 	=> '，Gzip 已禁用',
	'loading' 			=> '正在处理您的请求...',
		
	'auto_redirection' 	=> '如果您不做出选择，将在 <span id="spanSeconds">3</span> 秒后跳转到第一个链接地址。',
	'password_rule' 	=> '密码应只包含英文字符、数字.长度在6--16位之间',
	'username_rule' 	=> '用户名应为汉字、英文字符、数字组合，3到15位',
	'plugins_not_found' => '插件 %s 无法定位',
	'no_records' 		=> '没有找到任何记录',
	'role_describe' 	=> '角色描述',
		
	'js_languages' => array(
		'process_request' 	=> '正在处理您的请求...',
		'todolist_caption' 	=> '记事本',
		'todolist_autosave' => '自动保存',
		'todolist_save' 	=> '保存',
		'todolist_clear' 	=> '清除',
		'todolist_confirm_save' 	=> '是否将更改保存到记事本？',
		'todolist_confirm_clear' 	=> '是否清空内容？',
	),

	'require_field' 	=> '<span class="require-field" style="color:#FF0000,">*</span>',
	'yes' 				=> '是',
	'no' 				=> '否',
	'record_id' 		=> '编号',
	'handler' 			=> '操作',
	'install' 			=> '安装',
	'uninstall' 		=> '卸载',
	'list' 				=> '列表',
	'add' 				=> '添加',
	'edit' 				=> '编辑',
	'view' 				=> '查看',
	'remove' 			=> '移除',
	'drop' 				=> '删除',
	'confirm_delete' 	=> '您确定要删除吗？',
	'disabled' 			=> '禁用',
	'enabled' 			=> '启用',
	'setup' 			=> '设置',
	'success' 			=> '成功',
	'sort_order' 		=> '排序',
	'trash' 			=> '回收站',
	'restore' 			=> '还原',
	'close_window' 		=> '关闭窗口',
	'btn_select' 		=> '选择',
	'operator' 			=> '操作人',
	'cancel' 			=> '取消',
	'operate_fail'		=> '处理失败',
	'invalid_parameter' => '参数无效',
	
	'empty' 			=> '不能为空',
	'repeat' 			=> '已存在',
	'is_int' 			=> '应该为整数',
	
	'button_submit' 	=> '确定',
	'button_save' 		=> '保存',
	'button_reset' 		=> '重置',
	'button_search' 	=> '搜索',
	
	'priv_error' 		=> '对不起,您没有执行此项操作的权限!',
	'drop_confirm' 		=> '您确认要删除这条记录吗?',
	'form_notice' 		=> '点击此处查看提示信息',
	'upfile_type_error' => '上传文件的类型不正确!',
	'upfile_error' 		=> '上传文件失败!',
	'no_operation' 		=> '您没有选择任何操作',
	
	'go_back' 			=> '返回上一页',
	'back' 				=> '返回',
	'continue' 			=> '继续',
	'system_message' 	=> '系统信息',
	'check_all' 		=> '全选',
	'select_please' 	=> '请选择...',
	'all_category' 		=> '所有分类',
	'all_brand' 		=> '所有品牌',
	'refresh' 			=> '刷新',
	'update_sort' 		=> '更新排序',
	'modify_failure' 	=> '修改失败!',
	'attradd_succed' 	=> '操作成功!',
	'todolist' 			=> '记事本',
	'n_a' 				=> 'N/A',
	
	/* 提示 */
	'sys' => array(
		'wrong' 		=> '错误：',
	),
	
	/* 编码 */
	'charset' => array(
		'utf8' 	=> '国际化编码（utf8）',
		'zh_cn' 	=> '简体中文',
		'zh_tw' 	=> '繁体中文',
		'en_us' 	=> '美国英语',
		'en_uk' 	=> '英文',
	),
	
	
	/* 新订单通知 */
	'order_notify' 		=> '新订单通知',
	'new_order_1' 		=> '您有 ',
	'new_order_2' 		=> ' 个新订单以及 ',
	'new_order_3' 		=> ' 个新付款的订单',
	'new_order_link' 	=> '点击查看新订单',
	
	/*语言项*/
	'chinese_simplified' 	=> '简体中文',
	'english' 				=> '英文',
	
	/* 分页 */
	'total_records' 	=> '总计 ',
	'total_pages' 		=> '条记录分为',
	'page_size' 		=> '页，每页',
	'page_current' 		=> '页当前第',
	'page_first' 		=> '第一页',
	'page_prev' 		=> '上一页',
	'page_next' 		=> '下一页',
	'page_last' 		=> '最末页',
	'admin_home' 		=> '起始页',
	
	/* 重量 */
	'gram' 				=> '克',
	'kilogram' 			=> '千克',
	
	/* 菜单分类部分 */
	'02_cat_and_goods' 	=> '商品管理',
	'03_promotion' 		=> '促销管理',
	'04_order' 			=> '订单管理',
	'05_banner' 		=> '广告管理',
	'06_stats' 			=> '报表统计',
	'07_content' 		=> '文章管理',
	'08_members' 		=> '会员管理',
	'09_others' 		=> '杂项管理',
	'10_priv_admin' 	=> '权限管理',
	'11_system' 		=> '系统设置',
	'12_template' 		=> '模板管理',
	'13_backup' 		=> '数据库管理',
	'14_sms' 			=> '短信管理',
	'15_rec' 			=> '推荐管理',
	'16_email_manage' 	=> '邮件营销',
	
	/* 商品管理 */
	'01_goods_list' 	=> '商品列表',
	'02_goods_add' 		=> '添加新商品',
	'03_category_list' 	=> '商品分类',
	'04_category_add' 	=> '添加分类',
	'05_comment_manage' => '用户评论',
	'06_goods_brand_list' => '商品品牌',
	'07_brand_add' 		=> '添加品牌',
	'08_goods_type' 	=> '商品类型',
	'09_attribute_list' => '商品属性',
	'10_attribute_add' 	=> '添加属性',
	'11_goods_trash' 	=> '商品回收站',
	'12_batch_pic' 		=> '图片批量处理',
	'13_batch_add' 		=> '商品批量上传',
	'15_batch_edit' 	=> '商品批量修改',
	'16_goods_script' 	=> '生成商品代码',
	'17_tag_manage' 	=> '标签管理',
	'18_product_list' 	=> '货品列表',
	'52_attribute_add' 	=> '编辑属性',
	'53_suppliers_goods' => '供货商商品管理',
	
	'14_goods_export' 	=> '商品批量导出',
	
	'50_virtual_card_list' 	=> '虚拟商品列表',
	'51_virtual_card_add' 	=> '添加虚拟商品',
	'52_virtual_card_change' => '更改加密串',
	'goods_auto' 			=> '商品自动上下架',
	'article_auto' 			=> '文章自动发布',
	'navigator' 			=> '菜单管理',
	
	/* 促销管理 */
	'02_snatch_list' 	=> '夺宝奇兵',
	'snatch_add' 		=> '添加夺宝奇兵',
	'04_bonustype_list' => '红包类型',
	'bonustype_add' 	=> '添加红包类型',
	'05_bonus_list' 	=> '线下红包',
	'bonus_add' 		=> '添加会员红包',
	'06_pack_list' 		=> '商品包装',
	'07_card_list' 		=> '祝福贺卡',
	'pack_add' 			=> '添加新包装',
	'card_add' 			=> '添加新贺卡',
	'08_group_buy' 		=> '团购活动',
	'09_topic' 			=> '专题管理',
	'topic_add' 		=> '添加专题',
	'topic_list' 		=> '专题列表',
	'10_auction' 		=> '拍卖活动',
	'12_favourable' 	=> '优惠活动',
	'13_wholesale' 		=> '批发管理',
	'ebao_commend' 		=> '易宝推荐',
	'14_package_list' 	=> '超值礼包',
	'package_add' 		=> '添加超值礼包',
	
	/* 订单管理 */
	'02_order_list' 	=> '订单列表',
	'03_order_query' 	=> '订单查询',
	'04_merge_order' 	=> '合并订单',
	'05_edit_order_print' => '订单打印',
	'06_undispose_booking'=> '缺货登记',
	'08_add_order' 		=> '添加订单',
	'09_delivery_order' => '发货单列表',
	'10_back_order' 	=> '退货单列表',
	
	/* 广告管理 */
	'ad_position' 		=> '广告位置',
	'ad_list' 			=> '广告列表',
	
	/* 报表统计 */
	'flow_stats' 			=> '流量分析',
	'searchengine_stats' 	=> '搜索引擎',
	'report_order' 		=> '订单统计',
	'report_sell' 		=> '销售概况',
	'sell_stats' 		=> '销售排行',
	'sale_list' 		=> '销售明细',
	'report_guest' 		=> '客户统计',
	'report_users' 		=> '会员排行',
	'visit_buy_per' 	=> '访问购买率',
	'z_clicks_stats' 	=> '站外投放JS',
	
	/* 文章管理 */
	'02_articlecat_list' => '文章分类',
	'articlecat_add' 	=> '添加文章分类',
	'03_article_list' 	=> '文章列表',
	'article_add' 		=> '添加新文章',
	'shop_article' 		=> '网店文章',
	'shop_info' 		=> '网店信息',
	'shop_help' 		=> '网店帮助',
	'vote_list' 		=> '在线调查',
	
	/* 会员管理 */
	'03_users_list' 		=> '会员列表',
	'04_users_add' 			=> '添加会员',
	'05_user_rank_list' 	=> '会员等级',
	'06_list_integrate' 	=> '会员整合',
	'09_user_account' 		=> '充值和提现申请',
	'10_user_account_manage' => '资金管理',
	'menu_user_integrate' 	=> '会员整合',
	'menu_user_connect'		=> '帐号连接',
	
	/* 留言管理 */
	'17_msg_mmanage'		=> '留言反馈',
	'08_unreply_msg' 		=> '会员留言',
	'01_order_msg'			=> '订单留言',
	'02_comment_msg'		=> '公共留言',
	
	/* 权限管理 */
	'admin_list' 		=> '管理员列表',
	'admin_list_role' 	=> '角色列表',
	'admin_role' 		=> '角色管理',
	'admin_add' 		=> '添加管理员',
	'admin_add_role' 	=> '添加角色',
	'admin_edit_role' 	=> '修改角色',
	'admin_logs' 		=> '管理员日志',
	'agency_list' 		=> '办事处列表',
	'suppliers_list' 	=> '供货商列表',
	
	/* 系统设置 */
	'01_shop_config' 	=> '商店设置',
	'shop_authorized' 	=> '授权证书',
	'shp_webcollect' 	=> '网罗天下',
	
	'04_mail_settings' 	=> '邮件服务器设置',
	'05_area_list' 		=> '地区列表',
	'shipping_area_list' => '配送区域',
	'sitemap' 			=> '站点地图',
	'check_file_priv' 	=> '文件权限检测',
	'fckfile_manage' 	=> 'Fck上传文件管理',
	'ucenter_setup' 	=> 'UCenter设置',
	'file_check' 		=> '文件校验',
	'21_reg_fields' 	=> '会员注册项设置',
	
	'01_payment_list' 	=> '支付方式',
	'02_shipping_list' 	=> '配送方式',
	'03_cron_list' 		=> '计划任务',
	'04_cycleimage_manage' => '轮播图管理',
	'05_captcha_setting' => '验证码设置',
	'06_friendlink_list' => '友情链接',
	
	/* 模板管理 */
	'02_template_select' 	=> '模板选择',
	'03_template_setup' 	=> '布局管理',
	'04_template_library' 	=> '库项目管理',
	'mail_template_manage' 	=> '邮件模板',
	'05_edit_languages' 	=> '语言项编辑',
	'06_template_backup' 	=> '模板设置备份',
	/* 数据库管理 */
	'02_db_manage' 		=> '数据备份',
	'03_db_optimize' 	=> '数据表优化',
	'04_sql_query' 		=> 'SQL查询',
	'05_synchronous' 	=> '同步数据',
	'convert' 			=> '转换数据',
	
	/* 短信管理 */
	'02_sms_my_info' 	=> '账号信息',
	'03_sms_send' 		=> '发送短信',
	'04_sms_charge' 	=> '账户充值',
	'05_sms_send_history' 	=> '发送记录',
	'06_sms_charge_history' => '充值记录',
	
	'affiliate' 		=> '推荐设置',
	'affiliate_ck' 		=> '分成管理',
	'flashplay' 		=> '首页主广告管理',
	'search_log' 		=> '搜索关键字',
	'email_list' 		=> '邮件订阅管理',
	'magazine_list' 	=> '杂志管理',
	'attention_list' 	=> '关注管理',
	'view_sendlist' 	=> '邮件队列管理',
	
	/* 积分兑换管理 */
	'15_exchange_goods' 		=> '积分商城商品',
	'15_exchange_goods_list' 	=> '积分商城商品列表',
	'exchange_goods_add' 		=> '添加新商品',
	
	/* cls_image类的语言项 */
	'directory_readonly' 		=> '目录 % 不存在或不可写',
	'invalid_upload_image_type' => '不是允许的图片格式',
	'upload_failure' 			=> '文件 %s 上传失败。',
	'missing_gd' 				=> '没有安装GD库',
	'missing_orgin_image' 		=> '找不到原始图片 %s ',
	'nonsupport_type' 			=> '不支持该图像格式 %s ',
	'creating_failure' 			=> '创建图片失败',
	'writting_failure' 			=> '图片写入失败',
	'empty_watermark' 			=> '水印文件参数不能为空',
	'missing_watermark' 		=> '找不到水印文件%s',
	'create_watermark_res' 		=> '创建水印图片资源失败。水印图片类型为%s',
	'create_origin_image_res'	=> '创建原始图片资源失败，原始图片类型%s',
	'invalid_image_type' 		=> '无法识别水印图片 %s ',
	'file_unavailable' 			=> '文件 %s 不存在或不可读',
	
	/* 邮件发送错误信息 */
	'smtp_setting_error' 		=> '邮件服务器设置信息不完整',
	'smtp_connect_failure' 		=> '无法连接到邮件服务器 %s',
	'smtp_login_failure' 		=> '邮件服务器验证帐号或密码不正确',
	'sendemail_false' 			=> '邮件发送失败，请检查您的邮件服务器设置！',
	'smtp_refuse' 				=> '服务器拒绝发送该邮件',
	'disabled_fsockopen' 		=> '服务器已禁用 fsocketopen 函数。',
	
	/* 虚拟卡 */
	'virtual_card_oos' 			=> '虚拟卡已缺货',
	
	'span_edit_help' 			=> '点击修改内容',
	'href_sort_help' 			=> '点击对列表排序',
	
	'catname_exist' 			=> '已存在相同的分类名称!',
	'brand_name_exist' 			=> '已存在相同的品牌名称!',
	
	'alipay_login' 				=> '<a href="https://www.alipay.com/user/login.htm?goto=>https%3A%2F%2Fwww.alipay.com%2Fhimalayas%2Fpracticality_profile_edit.htm%3Fmarket_type%3Dfrom_agent_contract%26customer_external_id%3D%2BC4335319945672464113" target=>"_blank">立即免费申请支付接口权限</a>',
	'alipay_look' 				=> '<a href=\"https://www.alipay.com/himalayas/practicality.htm\" target=>\"_blank\">请申请成功后登录支付宝账户查看</a>',
);

// end