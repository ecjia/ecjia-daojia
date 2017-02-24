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
 * 管理中心起始页语言文件
 */

return array(
	'shop_guide'		=> '开店向导',
	'set_navigator'		=> '设置导航栏',
	'about'				=> '关于 ECJIA',
	'preview'			=> '查看网店',
	'menu'				=> '菜单',
	'help'				=> '帮助',
	'signout'			=> '退出',
	'profile'			=> '个人设置',
	'view_message'		=> '管理员留言',
	'send_msg'			=> '发送留言',
	'toggle_calculator'	=> '计算器',
	'expand_all'		=> '展开',
	'collapse_all'		=> '闭合',
	'no_help'			=> '暂时还没有该部分内容',
	'license_free'		=> '非授权用户',
	'license_commercial'=> '绿卡用户',
	'license_invalid'	=> '未授权用户',
	'license_failed'	=> '非法用户',
	'license_oem'		=> '授权商业用户',
	'license_oemtest'	=> '体验用户',
		
	'license_Q'		=> '商业',
	'license_G'		=> '商业',
	'license_L'		=> '临时',
	'license_S'		=> '商业',
	'license_O'		=> '企业',
	'license_T'		=> '体验',
	'license_no'	=> '免费',
	'license_test'	=> '免费',
		
	'js_languages'  => array(
		'expand_all'=> '展开',
		'collapse_all'=> '闭合',
		'shop_name_not_null'	=> '商店名称不能为空',
		'good_name_not_null'	=> '商品名称不能为空',
		'good_category_not_null'=> '商品分类不能为空',
		'good_number_not_number'=> '商品数量不是数值',
		'good_price_not_number'	=> '商品价格不是数值',
	),
	
	/*------------------------------------------------------ */
	//-- 计算器
	/*------------------------------------------------------ */
	
	'calculator'		=> '计算器',
	'clear_calculator'	=> '清除',
	'backspace'			=> '退格',
	
	/*------------------------------------------------------ */
	//-- 起始页
	/*------------------------------------------------------ */
	'pm_title'		=> '留言标题',
	'pm_username'	=> '留言者',
	'pm_time'		=> '留言时间',
	
	'order_stat'	=> '订单统计信息',
	'unconfirmed'	=> '未确认订单:',
	'await_ship'	=> '待发货订单:',
	'await_pay'		=> '待支付订单:',
	'finished'		=> '已成交订单数:',
	'new_booking'	=> '新缺货登记:',
	'new_reimburse'	=> '退款申请:',
	'shipped_part'	=> '部分发货订单:',
	
	'goods_stat'		=> '实体商品统计信息',
	'virtual_card_stat'	=> '虚拟卡商品统计',
	'goods_count'		=> '商品总数:',
	'sales_count'		=> '促销商品数:',
	'new_goods'			=> '新品推荐数:',
	'recommed_goods'	=> '精品推荐数:',
	'hot_goods'			=> '热销商品数:',
	'warn_goods'		=> '库存警告商品数:',
	'clear_cache'		=> '清除缓存',
	'ebao_commend'		=> '易宝推荐',
	
	'acess_stat'	=> '访问统计',
	'acess_today'	=> '今日访问:',
	'online_users'	=> '在线人数:',
	'user_count'	=> '会员总数:',
	'today_register'=> '今日注册:',
	'new_feedback'	=> '最新留言:',
	'new_comments'	=> '未审核评论:',
	
	'system_info'	=> '系统信息',
	'os'			=> '服务器操作系统:',
	'web_server'	=> 'Web 服务器:',
	'php_version'	=> 'PHP 版本:',
	'mysql_version'	=> 'MySQL 版本:',
	'gd_version'	=> 'GD 版本:',
	'zlib'			=> 'Zlib 支持:',
	'ecs_version'	=> 'ECJia 版本:',
	'install_date'	=> '安装日期:',
	'ip_version'	=> 'IP 库版本:',
	'max_filesize'	=> '文件上传的最大大小:',
	'safe_mode'		=> '安全模式:',
	'safe_mode_gid'	=> '安全模式GID:',
	'timezone'		=> '时区设置:',
	'no_timezone'	=> '无需设置',
	'socket'		=> 'Socket 支持:',
	'ec_charset'	=> '编码:',
	
	'remove_install'			=> '您还没有删除 install 文件夹，出于安全的考虑，我们建议您删除 install 文件夹。',
	'remove_upgrade'			=> '您还没有删除 upgrade 文件夹，出于安全的考虑，我们建议您删除 upgrade 文件夹。',
	'remove_demo'				=> '您还没有删除 demo 文件夹，出于安全的考虑，我们建议您删除 demo 文件夹。',
	'temp_dir_cannt_read'		=> '您的服务器设置了 open_base_dir 且没有包含 %s，您将无法上传文件。',
	'not_writable'				=> '%s 目录不可写入，%s',
	'data_cannt_write'			=> '您将无法上传包装、贺卡、品牌等等图片文件。',
	'afficheimg_cannt_write'	=> '您将无法上传广告的图片文件。',
	'brandlogo_cannt_write'		=> '您将无法上传品牌的图片文件。',
	'cardimg_cannt_write'		=> '您将无法上传贺卡的图片文件。',
	'feedbackimg_cannt_write'	=> '用户将无法通过留言上传文件。',
	'packimg_cannt_write'		=> '您将无法上传包装的图片文件。',
	'cert_cannt_write'			=> '您将无法上传 ICP 备案证书文件。',
	'images_cannt_write'		=> '您将无法上传任何商品图片。',
	'imagesupload_cannt_write'	=> '您将无法通过编辑器上传任何图片。',
	'tpl_cannt_write'			=> '您的网站将无法浏览。',
	'tpl_backup_cannt_write'	=> '您就无法备份当前的模版文件。',
	'order_print_canntwrite'	=> 'data目录下的order_print.html文件属性为不可写，您将无法修改订单打印模板。',
	'shop_closed_tips'			=> '您的商店已被暂时关闭。在设置好您的商店之后别忘记打开哦！',
	'empty_upload_tmp_dir'		=> '当前的上传临时目录为空，您可能无法上传文件，请检查 php.ini 中的设置。',
	'caches_cleared'			=> '页面缓存已经清除成功。',
	
	/*------------------------------------------------------ */
	//-- 关于我们
	/*------------------------------------------------------ */
	'team_member'		=> 'ECJIA 团队成员',
	'before_team_member'=> 'ECJia 贡献者',
	
	'director'		=> '项目策划',
	'programmer'	=> '程序开发',
	'ui_designer'	=> '界面设计',
	'documentation'	=> '文档整理',
	'special_thanks'=> '特别感谢',
	'official_site'	=> '官方网站',
	'site_url'		=> '网站地址:',
	'support_center'=> '支持中心:',
	'support_forum'	=> '支持论坛:',
	// 邮件群发
	'mailsend_fail'		=> '邮件 %s 发送失败!',
	'mailsend_ok'		=> '邮件 %s 发送成功!还有 %s 邮件未发送!',
	'mailsend_finished'	=> '邮件 %s 发送成功!全部邮件发送完成!',
	'mailsend_null'		=> '邮件发送列表空!',
	'mailsend_skip'		=> '继续发送下一条...',
	'email_sending'		=> '正在处理邮件发送队列...',
	'pause'				=> '暂停',
	'conti'				=> '继续',
	'str'				=> '已经发送了 %d 封邮件。',
	
	//开店向导
	'shop_name'		=> '商店名称',
	'shop_title'	=> '商店标题',
	'shop_country'	=> '所在国家',
	'shop_province'	=> '所在省份',
	'shop_city'		=> '所在城市',
	'shop_address'	=> '详细地址',
	'shop_ship'		=> '配送方式',
	'ship_name'		=> '配送区域名称',
	'ship_country'	=> '国家',
	'ship_province'	=> '省份',
	'ship_city'		=> '城市',
	'ship_district'	=> '县/区',
	'shop_pay'		=> '支付方式',
	'select_please'	=> '请选择...',
	'good_name'		=> '商品名称',
	'good_number'	=> '商品数量',
	'good_category'	=> '商品分类',
	'good_brand'	=> '商品品牌',
	'good_price'	=> '商品价格',
	'good_brief'	=> '商品描述',
	'good_image'	=> '上传商品图片',
	'is_new'		=> '新品',
	'is_best'		=> '精品',
	'is_hot'		=> '热卖',
	'good_intro'	=> '加入推荐',
	'skip'			=> '完成向导',
	'next_step'		=> '下一步',
	'ur_add'		=> '开店向导－添加商品',
	'ur_config'		=> '开店向导－设置网店',
	'shop_basic_first'	=> "设置商店的一些基本信息<em>商店的名字、地址、配送方式、支付方式等</em>",
	'shop_basic_second'	=> "给商店添加一些商品<em>商品的名称、数量、分类、品牌、价格、描述等</em>",
	'shop_basic_third'	=> "恭喜您，您的网店可以使用了！<em>下面是一些常用功能的链接聚合。您关闭本页后，依然可以在左侧菜单相关项目中找到</em>",
	'add_good'			=> '添加商品',
	'add_category'		=> '添加商品分类',
	'add_type'			=> '商品类型',
	'add_favourable'	=> '添加优惠活动',
	'shop_config'		=> '商店设置',
	'select_template'	=> '选择模板',
	'shop_back_in'		=> '进入网店后台',
	'goods_img_too_big'	=> '商品图片文件太大了（最大值:%s），无法上传。',
	'invalid_goods_img'	=> '商品图片格式不正确！',
	
	/*后台语言项*/
	'send_mail_off'	=> '自动发送邮件关闭',
);

// end