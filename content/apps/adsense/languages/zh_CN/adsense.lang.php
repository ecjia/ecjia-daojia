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
 * ECJIA 广告应用语言包
 */
return array(
	/* 广告位置字段信息 */
	'position_name' 	=> '广告位名称',
	'ad_width' 			=> '广告位宽度',
	'ad_height' 		=> '广告位高度',
	'position_desc' 	=> '广告位描述',
	'posit_width' 		=> '位置宽度',
	'posit_height' 		=> '位置高度',
	'posit_style' 		=> '广告位模板',
	'outside_posit' 	=> '站外广告',
	'outside_address' 	=> '投放广告的站点名称：',
	'copy_js_code' 		=> '复制JS代码',
	'adsense_code' 		=> '站外投放的JS代码',
	'label_charset' 	=> '选择编码：',
		
	'no_position' 		=> '您还没有设置广告位置',
	'no_ads' 			=> '您还没有添加广告',
	'unit_px' 			=> '像素',
	'ad_content' 		=> '广告内容',
	'width_and_height' 	=> '(宽*高)',
		
	'position_name_empty' 	=> '广告位名称不能为空！',
	'ad_width_empty' 		=> '广告位宽度不能为空！',
	'ad_height_empty' 		=> '广告位高度不能为空！',
	'position_desc_empty' 	=> '广告位描述不能为空！',
		
	'view_static' 		=> '查看统计信息',
	'add_js_code'		=> '生成并复制JS代码',
	'position_add' 		=> '添加广告位',
	'position_edit' 	=> '编辑广告位',
	'posit_name_exist'		 => '此广告位已经存在了！',
	'download_ad_statistics' => '下载广告统计报表',
	'add_js_code_btn'		 => '生成并复制JS代码',
		
	/* JS语言提示 */
	'js_languages' => array(
		'posit_name_empty' 		=> '广告位名称不能为空！',
		'ad_width_empty' 		=> '请输入广告位的宽度！',
		'ad_height_empty' 		=> '请输入广告位的高度！',
		'ad_width_number' 		=> '广告位的宽度必须是一个数字！',
		'ad_height_number' 		=> '广告位的高度必须是一个数字！',
		'no_outside_address' 	=> '建议您指定该广告所要投放的站点的名称，方便于该广告的来源统计！',
		'width_value'			=> '广告位的宽度值必须在1到1024之间！',
		'height_value'			=> '广告位的高度值必须在1到1024之间！',
		'ad_name_empty' 		=> '请输入广告名称！',
		'ad_link_empty' 		=> '请输入广告的链接URL！',
		'ad_text_empty' 		=> '广告的内容不能为空！',
		'ad_photo_empty' 		=> '广告的图片不能为空！',
		'ad_flash_empty' 		=> '广告的flash不能为空！',
		'ad_code_empty' 		=> '广告的代码不能为空！',
		'empty_position_style' 	=> '广告位的模版不能为空！'
	),
		
	'width_value' 		=> '广告位的宽度值必须在1到1024之间！',
	'height_value' 		=> '广告位的高度值必须在1到1024之间！',
	'width_number' 		=> '广告位的宽度必须是一个数字！',
	'height_number' 	=> '广告位的高度必须是一个数字！',
	'not_del_adposit' 	=> '该广告位已经有广告存在，不能删除！',
		
	/* 帮助语言项 */
	'position_name_notic' 	=> '填写广告位置的名称，如：页脚广告，LOGO广告，右侧广告，通栏二_左边部分等等',
	'ad_width_notic' 		=> '广告位置的宽度，此高度将是广告显示时的宽度，单位为像素',
	
	'howto_js' 			=> '如何调用JS代码显示广告',
	'ja_adcode_notic' 	=> '调用JS广告代码的描述',
	
	/* 广告字段信息 */
	'ad_id' 			=> '编号',
	'position_id' 		=> '广告位置',
	'media_type' 		=> '媒介类型',
	'ad_name' 			=> '广告名称',
	'ad_link' 			=> '广告链接：',
	'ad_code' 			=> '广告内容',
	'start_date' 		=> '开始日期',
	'end_date' 			=> '结束日期',
	'link_man' 			=> '广告联系人',
	'link_email' 		=> '联系人Email',
	'link_phone' 		=> '联系电话',
	'click_count' 		=> '点击次数',
	'ads_stats' 		=> '生成订单',
	'cleck_referer' 	=> '点击来源',
	'adsense_name' 		=> '投放的名称',
	'adsense_js_stats' 	=> '站外投放JS统计',
	'gen_order_amount' 	=> '产生订单总数',
	'confirm_order' 	=> '有效订单数',
	'adsense_js_goods' 	=> '站外JS调用商品',
	
	'ads_stats_info' 	=> '广告统计信息',
	'flag' 				=> '状态',
	'enabled' 			=> '是否开启：',
	'is_enabled' 		=> '开启',
	'no_enabled' 		=> '关闭',
	
	'ads_add' 				=> '添加广告',
	'ads_edit' 				=> '编辑广告',
	'edit_success' 			=> '编辑成功',
	'drop_success' 			=> '删除成功',
	'back_ads_list' 		=> '返回广告列表',
	'back_position_list' 	=> '返回广告位列表',
	'continue_add_ad' 		=> '继续添加广告',
	'continue_add_position' => '继续添加广告位',
	'show_ads_template' 	=> '设置在模板中显示该广告位',
	
	/* 描述信息 */
	'ad_img' 	=> '图片',
	'ad_flash' 	=> 'Flash',
	'ad_html' 	=> '代码',
	'ad_text' 	=> '文字',
	
	'upfile_flash' 		=> 'Flash文件：',
	'flash_url' 		=> 'Flash地址：',
	'upfile_img' 		=> '广告图片：',
	'local_upfile_img' 	=> '本地上传',
	'img_url' 			=> '图片地址',
	'enter_code' 		=> '输入广告代码',
	'preview_image'		=> '（预览图片）',
	
	/* 提示语言项 */
	'upfile_flash_type' => '上传的Flash文件类型不正确！',
	'ad_code_repeat' 	=> '广告图片只能是上传的图片文件或者是指定远程的图片',
	'ad_flash_repeat' 	=> 'Flash广告只能是上传的Flash文件或者是指定远程的Flash文件',
	'ad_name_exist' 	=> '该广告名称已经存在！',
	'ad_name_notic' 	=> '广告名称只是作为辨别多个广告条目之用，并不显示在广告中',
	'ad_code_img' 		=> '上传该广告的图片文件，或者你也可以指定一个远程URL地址为广告的图片',
	'ad_code_flash' 	=> '上传该广告的Flash文件，或者你也可以指定一个远程的Flash文件',
	
	'ad_type_lable'			=> '广告类型：',
	'position_name_lable'	=> '广告位名称：',
	'ad_width_lable' 	 	=> '广告位宽度：',
	'ad_height_lable' 	 	=> '广告位高度：',
	'position_desc_lable' 	=> '广告位描述：',
	'ad_code_label'			=> '广告代码：',
	
	'ad_name_lable' 			=> '广告名称：',
	'start_date_lable' 			=> '开始日期：',
	'end_date_lable' 			=> '结束日期：',
	'position_id_lable' 		=> '广告位置：',
	'media_type_lable' 			=> '媒介类型：',
	'ad_custom'					=> '广告自定义',
	'add_custom_ad' 			=> '添加自定义广告',
	'edit_custom_ad'			=> '编辑自定义广告',
	'custom_ad_list'			=> '广告自定义列表',
	'back_custom_ad_list' 		=> '返回自定义广告列表',
	'continue_add_custom_ad'	=> '继续添加自定义广告',
	'add_custom_ad_success'		=> '添加自定义广告成功',
	'edit_custom_ad_success'	=> '编辑自定义广告成功',
	'drop_custom_ad_success'	=> '删除自定义广告成功',
	'edit_status_success'		=> '编辑状态成功',
	
	'search' 				=> '搜索',
	'enter_custom_ad_name'	=> '请输入自定义广告名称',
	'ad_type'				=> '广告类型',
	'add_time'				=> '添加时间',
	'remote_link'			=> '远程链接',
	'specify_logo' 			=> '在指定远程LOGO图片时，LOGO图片的URL网址必须为http:// 或 https://开头的正确URL格式！',
	'browse'				=> '浏览',
	'modify'				=> '修改',
	'edit'					=> '编辑',
	'remove'				=> '删除',
	'confirm_remove'		=> '您确定要删除吗？',
	'template_picture'		=> '此模板的图片标准宽度为：484px 标准高度为：200px',
	'link_address'			=> '链接地址：',
	'upload_flash_file'		=> '上传Flash文件',
	'modify_Flash_file'		=> '修改Flash文件',
	'content'				=> '内容：',
	'update'				=> '更新',
	
	'position_list'			=> '广告位置列表',
	'add_success'			=> '添加成功',
	'choose_media_type'		=> '请选择媒介类型',
	'ad_name_empty'			=> '请输入广告名称',
	'filter'				=> '筛选',
	'edit_ad_name'			=> '编辑广告名称',
	'ad_contact_info'		=> '广告联系人信息',
	'name'					=> '姓名：',
	'email'					=> 'Email：',
	'phone'					=> '电话：',
	'ad_position_name'		=> '请输入广告位置名称',
	'edit_ad_position_name'	=> '编辑广告位置名称',
	'view_ad_content'		=> '查看广告内容',
	'edit_position_width'	=> '编辑位置宽度',
	'edit_position_height'	=> '编辑位置高度',
	
	'ads_manage'			=> '广告管理',
	'ads_list'				=> '广告列表',
	'ads_position'			=> '广告位置',
	'drop_ads'				=> '删除广告',
	'ads_position_manage'	=> '广告位置管理',
	'add_ads_position'		=> '添加广告位置',
	'edit_ads_position'		=> '编辑广告位置',
	'drop_ads_position'		=> '删除广告位置',
	'ads_custom_manage'		=> '广告自定义管理',
	'drop_custom_ad'		=> '删除自定义广告',
	'custom_ad'				=> '自定义广告',
	
	'ad_link_empty' 		=> '请输入广告的链接URL！',
	'ad_text_empty' 		=> '广告的内容不能为空！',
	'ad_photo_empty' 		=> '广告的图片不能为空！',
	'ad_flash_empty' 		=> '广告的flash不能为空！',
	'ad_code_empty' 		=> '广告的代码不能为空！',
	
	//js
	'ad_name_required'		=> '请填写广告名称',
	'position_name_required'=> '请填写广告位置名称',
	'ad_width_required'		=> '请填写广告位宽度',
	'ad_height_required'	=> '请填写广告位高度',
	'gen_code_message'		=> '建议您指定该广告所要投放的站点的名称，方便于该广告的来源统计',
	
	//help
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	
	'adsense_list_help'		=> '欢迎访问ECJia智能后台广告列表页面，系统中所有的广告都会显示在此列表中。',
	'about_adsense_list'	=> '关于广告列表帮助文档',
	'adsense_add_help'		=> '欢迎访问ECJia智能后台添加广告页面，在此页面可以进行添加广告操作。',
	'about_add_adsense'		=> '关于添加广告帮助文档',
	'adsense_edit_help'		=> '欢迎访问ECJia智能后台编辑广告页面，在此页面可以进行编辑广告操作。',
	'about_edit_adsense'	=> '关于编辑广告帮助文档',
	'adsense_genjs_help'	=> '欢迎访问ECJia智能后台添加广告页面，在此页面可以进行生成并复制js代码操作。',
	'abount_genjs'			=> '关于生成并复制js代码帮助文档',
	
	'position_list_help'	=> '欢迎访问ECJia智能后台广告位置列表页面，系统中所有的广告位置都会显示在此列表中。',
	'about_position_list'	=> '关于广告位置列表帮助文档',
	'position_add_help'		=> '欢迎访问ECJia智能后台添加广告位置页面，在此页面可以进行添加广告位置操作。',
	'about_add_position'	=> '关于添加广告位置帮助文档',
	'position_edit_help'	=> '欢迎访问ECJia智能后台编辑广告位置页面，在此页面可以进行编辑广告位置操作。',
	'about_edit_position'	=> '关于编辑广告位置帮助文档',
	
	'custom_list_help'		=> '欢迎访问ECJia智能后台广告自定义列表页面，系统中所有的自定义广告都会显示在此列表中。',
	'abount_custom_list'	=> '关于自定义广告列表帮助文档',
	'add_custom_help'		=> '欢迎访问ECJia智能后台添加自定义广告页面，在此页面可以进行添加自定义广告操作。',
	'about_add_custom'		=> '关于添加自定义广告帮助文档',
	'edit_custom_help'		=> '欢迎访问ECJia智能后台编辑自定义广告页面，在此页面可以进行编辑自定义广告操作。',
	'abount_edit_custom'	=> '关于编辑自定义广告帮助文档',
);

// end