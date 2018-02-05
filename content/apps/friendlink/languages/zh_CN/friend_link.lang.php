<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 应用语言包
 */

return array(
	/* 友情链接字段信息 */
	'link_id' 		=> '编号',
	'link_name' 	=> '链接名称',
	'link_url' 		=> '链接地址',
	'link_logo' 	=> '链接LOGO',
	'url_logo' 		=> 'LOGO地址：',
	'link_type' 	=> '链接类型',
	'show_order' 	=> '排序',
	
	'link_logo_type_local' 	=> '本地上传',
	'link_logo_type_url' 	=> '远程链接',
	'link_logo_upload' 		=> '链接LOGO上传：',
	'link_text' 			=> '文字',
	'link_img' 				=> '图片',
	
	'cur_link_logo' 	=> '当前链接LOGO',
	'list_link'  		=> '链接列表',
	'add_link' 			=> '添加链接',
	'edit_link'  		=> '编辑链接',
	'no_links' 	 		=> '您还没有添加友情链接',
	'back_list'  		=> '返回链接列表',
	'continue_add' 		=> '继续添加链接',
	
	'link_name_empty' 	=> '友情链接名称不能为空',
	'link_url_empty' 	=> '友情链接地址不能为空',
	'link_logo_empty' 	=> '友情链接LOGO不能为空',
	'link_img_empty' 	=> '友情链接的图片LOGO不能为空',
	'link_url_exist' 	=> '此链接URL已经存在',
	'link_name_exist' 	=> '此链接名称已经存在',
	'enter_int' 		=> '显示顺序的类型必须为数字',
	'link_order'		=> '排序不能为空',
	
	/* 帮助信息 */
	'url_logo_value' 	=> '在指定远程LOGO图片时, LOGO图片的URL网址必须为http:// 或 https://开头的正确URL格式',
	'link_name_desc' 	=> '当你添加文字链接时，链接LOGO为你的链接名称。',
	
	/* ajax 提示信息   */
	'drop_success'	=> '删除成功',
	'add_success'	=> '添加成功',
	'edit_success'	=> '编辑成功',
	
	/* JS提示信息 */
	'js_languages' => array(
		'link_name_empty'	=> '请输入链接名称',
		'link_url_empty' 	=> '请输入链接地址',
		'show_order_type' 	=> '显示的顺序必须是一个数字'
	),
	
	//追加
	'drop_fail'			=> '删除失败',
	'edit_fail'			=> '编辑失败',
	'link_name_empty'	=> '请输入链接名称',
	'search'			=> '搜索',
	'edit_order'		=> '编辑排序',
	'edit_link_name'	=> '编辑链接名称',
	'drop_confirm'		=> '您确定要删除该友情链接吗？',
	'image_preview'		=> '图片预览',
	'browse'			=> '浏览',
	'modify'			=> '修改',
	'drop_logo_confirm'	=> '您确定要删除该友情链接LOGO吗？',
	'update'			=> '更新',
	'set_check_success' => '设为 已审核 状态成功',
	'set_wait_success'	=> '设为 未审核 状态成功',
	
	'batch_drop_confirm'=> '您确定要删除选中的友情链接吗？',
	'select_drop_link'	=> '请选择要删除的友情链接',
	'batch_handle'		=> '批量操作',
	'link_keywords'		=> '请输入链接名称关键字',
	
	'checked'			=> '已审核',
	'waitcheck'			=> '未审核',
	'wait_check'		=> '待审核',
	'through_audit'		=> '通过审核',
	'status'			=> '审核状态：',
	'passed'			=> '已通过',
	'not_passed'		=> '未通过',
	'from'				=> '来源：',
	'background_add'	=> '后台添加',
	'foreground_apply'	=> '前台申请',
	'release_info'		=> '发布信息',
	'add_time'			=> '申请时间：',
	'pass_confirm'		=> '您确定要通过审核吗？',
	'not_pass_confirm'	=> '您确定要驳回审核吗？',
	'not_pass'			=> '驳回审核',
	'replease'			=> '发布',
	'other_info'		=> '其他信息',
	'label_contact'		=> '联系方式：',
	'label_description'	=> '网站描述：',
	'label_link_name'	=> '链接名称：',
	'label_link_url'	=> '链接地址：',
	'label_link_logo'	=> '链接LOGO：',
	'label_order'		=> '排序：',
	
	'friendlink_manage' => '友情链接管理',
	'friendlink_add'	=> '添加友情链接',
	'friendlink_update'	=> '编辑友情链接',
	'friendlink_delete'	=> '删除友情链接',
	'friendlink'		=> '友情链接',
	
	'link_name_required'=> '请输入名称！',
	'link_url_required' => '请输入URL！',
	'ok'				=> '确定',
	'cancel'			=> '取消',
);

// end