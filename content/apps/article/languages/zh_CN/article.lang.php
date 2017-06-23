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
 * 文章管理语言项
 */
return array(
	/**
	 * ECJIA 文章列表字段信息
	 */
	'title' 		=> '文章标题',
	'cat'			=> '文章分类',
	'cat_lable'		=> '文章分类：',
	'reserve'  		=> '保留',
	'article_type'	=> '文章重要性',
	'author'		=> '文章作者',
	'email'			=> '作者email',
	'keywords' 		=> '关键字：',
	
	'lable_description' 	=> '网页描述：',
	'content' 				=> '文章内容：',
	'is_open' 				=> '是否显示',
	'is_open_lable' 		=> '是否显示：',
	'article_id' 			=> '编号',
	'add_time' 				=> '添加日期',
	'upload_file' 			=> '上传文件',
	'file_url' 				=> '或输入文件地址',
	'invalid_file'  		=> '上传文件格式不正确',
	'article_name_exist' 	=> '有相同的文章名称存在',
	'select_plz'  			=> '请选择...',
	'external_links'	 	=> '外部链接：',
	
	'top' 					=> '置顶',
	'default'				=> '默认',
	'common' 				=> '普通',
	'isopen'				=> '显示',
	'isclose' 				=> '不显示',
	'no_article'   			=> '您现在还没有任何文章',
	'no_select_article'   	=> '您没有选择任何文章',
	'no_select_act'   		=> '请选择文章分类',
	
	'display'   	=> '显示文章内容',
	'download'  	=> '下载文件',
	'both'   		=> '既显示文章内容又下载文件',
	'batch'   		=> '批量操作' ,
	'button_remove' => '批量删除',
	'button_hide' 	=> '批量隐藏',
	'button_show' 	=> '批量显示',
	'move_to'   	=> '转移到分类',
	
	'article_edit'   	=> '编辑文章内容',
	'preview_article'   => '文章预览',
	'article_editbtn'   => '编辑文章',
	'view'   			=> '预览',
	'tab_general'   	=> '通用信息',
	'tab_content'   	=> '文章内容',
	'tab_goods'   		=> '关联商品',
	'link_goods'   		=> '跟该文章关联的商品',
	'keyword'			=> '关键字',
	
	/* 提示信息 */
	'title_exist'			=> '文章 %s 已经存在',
	'back_article_list' 	=> '返回文章列表',
	'continue_article_add' 	=> '继续添加新文章',
	'articleadd_succeed' 	=> '文章已经添加成功',
	'articleedit_succeed' 	=> '文章 %s 成功编辑',
	'articleedit_fail' 		=> '文章编辑失败',
	'no_title'		 		=> '没有输入文章标题',
	'drop_confirm'   		=> '您确认要删除这篇文章吗？',
	'batch_handle_ok'   	=> '批量操作成功',
	'batch_handle_ok_del'   => '批量删除操作成功',
	'batch_handle_ok_hide'  => '批量隐藏操作成功',
	'batch_handle_ok_show'  => '批量显示操作成功',
	'batch_handle_ok_move'	=> '批量转移操作成功',
		
	/*JS 语言项*/
	'js_languages' => array(
		'no_title'   		=> '没有文章标题',
		'no_cat'   			=> '没有选择文章分类',
		'not_allow_add' 	=> '系统保留分类，不允许在该分类添加文章',
		'drop_confirm'  	=> '您确定要删除文章吗？',
		'no_catname'   		=> '没有输入分类的名称',
		'sys_hold'   		=> '系统保留分类，不允许添加子分类',
		'remove_confirm'   	=> '您确定要删除选定的分类吗？',
	),
		
	'all_cat'   		=> '全部分类',
	'search_article'	=> '搜索文章',
		
	/**
	 * ECJIA 文章分类字段信息
	 */
	'cat_name'  => '文章分类名称',
	'type'   	=> '分类类型',
	'type_name' => array(
		COMMON_CAT  => '普通分类',
		SYSTEM_CAT  => '系统分类',
		INFO_CAT	=> '网店信息',
		UPHELP_CAT  => '帮助分类',
		HELP_CAT  	=> '网店帮助',
	),
		
	'cat_keywords'		=> '关键字：',
	'cat_desc'   		=> '描述',
	'parent_cat'   		=> '上级分类：',
	'cat_top'   		=> '顶级分类',
	'not_allow_add' 	=> '你所选分类不允许添加子分类',
	'not_allow_remove'  => '系统保留分类，不允许删除',
	'is_fullcat'   		=> '该分类下还有子分类，请先删除其子分类',
	'show_in_nav'   	=> '是否显示在导航栏',
	'add_article'   	=> '添加文章',
	'articlecat_edit'   => '编辑文章分类',
		
	/* 提示信息 */
	'catname_exist'   		=> '分类名已经存在',
	'parent_id_err'   		=> '分类名的父分类不能设置成本身或本身的子分类',
	'back_cat_list'   		=> '返回分类列表',
	'continue_add'			=> '继续添加新分类',
	'catadd_succed'   		=> '已成功添加',
	'catedit_succed'   		=> '分类 %s 编辑成功',
	'edit_title_success'   	=> '文章标题 %s 编辑成功',
	'no_catname'   			=> '请填入分类名',
	'edit_fail'   			=> '编辑失败',
	'enter_int'   			=> '请输入一个整数',
	'not_emptycat'   		=> '分类下还有文章，不允许删除非空分类',
	
	/*帮助信息*/
	'notice_keywords' 		=> '关键字为选填项，其目的在于方便外部搜索引擎搜索',
	'notice_isopen' 		=> '该文章分类是否显示在前台的主导航栏中。',
	
	/**
	 * ECJIA 文章自动发布字段信息
	 */
	'id'   					=> '编号',
	'starttime'   			=> '发布时间',
	'endtime'   			=> '取消时间',
	'article_name'   		=> '文章名称：',
	'articleatolist_name'   => '文章名称',
	'ok'   					=> '确定',
	'edit_ok'   			=> '操作成功',
	'edit_error'   			=> '操作失败',
	'delete'   				=> '撤销',
	'deleteck'   			=> '确定删除此文章的自动发布/取消发布处理么?此操作不会影响文章本身',
	'enable_notice'   		=> '您需要到工具->计划任务中开启该功能后才能使用。',
	'button_start'   		=> '批量发布',
	'button_end'   			=> '批量取消发布',
	'no_select_goods'   	=> '没有选定文章',
	'batch_start_succeed'   => '批量发布成功',
	'batch_end_succeed'   	=> '批量取消成功',
	'back_list'   			=> '返回文章自动发布',
	'select_time'   		=> '请选定时间',
	'drop_success'			=> '删除成功',
    'batch_setup'           => '批量设置',
    
	'add_custom_columns_success'	=> '添加自定义栏目成功',
	'miss_parameters_faild'			=> '缺少关键参数，更新失败',
	'update_custom_columns_success'	=> '更新自定义栏目成功',
	'drop_custom_columns_success' 	=> '删除自定义栏目成功',
	'edit_link_goods'				=> '编辑关联商品',
	'article_title_is'				=> '文章标题是 ',
	'article_title_empty'			=> '文章标题不能为空',
	'display_article'				=> '显示文章',
	'hide_article'					=> '隐藏文章',
	'delete_attachment_success'		=> '删除附件成功 ',
	'move_article'					=> '转移文章 ',
	'to_category'					=> '至分类  ',
	'move_to_category'				=> '转移文章至分类',
	'select_move_article'			=> '请先选中要转移的文章',
	'begin_move'					=> '开始转移',
	'confirm_drop'					=> '您确定要这么做吗？',
	'select_drop_article'			=> '请先选中要删除的文章',
	'select_hide_article'			=> '请先选中要隐藏的文章',
	'select_display_article'		=> '请先选中要显示的文章',
	'select_trash_article'			=> '请选择要移到回收站的文章',
	'select_approve_article'		=> '请选择要通过的文章',
	'select_rubbish_article'		=> '请选择要设为垃圾文章的文章',
	'drop_article'					=> '删除文章',
	'display'						=> '显示',
	'hide'							=> '隐藏',
	'move_category'					=> '转移分类',
	'filter'						=> '筛选',
	'enter_article_title'			=> '请输入文章名称',
	'edit_article_title'			=> '编辑文章名称',
	'move_confirm'					=> '是否将选中文章转移至分类？',
	'enter_title_article_here'		=> '在此输入文章标题',
	'links_help_block'				=> '若输入外部链接，则该链接优先',
	'seo_optimization'				=> 'SEO优化',
	'split'							=> '用英文逗号分隔',
	'simple_description'			=> '简单描述：',
	'custom_columns_success'		=> '自定义栏目',
	'edit_custom_columns_success'	=> '编辑自定义栏目',
	'name'							=> '名称',
	'value'							=> '值',
	'update'						=> '更新',
	'drop_custom_columns_confirm'	=> '您确定要删除此条自定义栏目吗？',
	'add_custom_columns'			=> '添加自定义栏目',
	'add_new_columns'				=> '添加新栏目',
	'category_info'					=> '分类信息',
	'is_top'						=> '是否置顶：',
	'issue'							=> '发布',
	'author_info'					=> '作者信息',
	'author_name'					=> '作者名称：',
	'author_email'					=> '作者邮箱：',
	'file_address'					=> '文件地址：',
	'drop_file'						=> '删除文件',
	'drop_file_confirm'				=> '您确定要删除该文章附件吗？',
	'modify_file'					=> '修改文件',
	'articlecat_add'				=> '添加文章分类',
	'catedit_ok'					=> '编辑成功',
	'sort_order'					=> '请输入排序序号',
	'drop_cat_confirm'				=> '您确定要删除该文章分类吗？',
	'tips'							=> '温馨提示：',
	'choose_time'					=> '请选择时间',
	'batch_issue_confirm'			=> '您确定要批量发布选中的文章吗？',
	'select_article_msg'			=> '请先选中要批量发布的文章',
	'batch_cancel_confirm'			=> '您确定要批量取消发布选中的文章吗？',
	'select_cancel_article'			=> '请先选中要批量取消发布的文章',
	'search' 						=> '搜索',
	'article_keywords'				=> '请输入文章名称关键词',
	'edit_issue_time'				=> '编辑发布时间',
	'edit_cancel_time'				=> '编辑取消时间',
	'cancel_confirm'				=> '您确定要撤销该文章吗？',
	'link_goods_tip'				=> '搜索要关联的商品，搜到商品会展示在左侧列表框中。点击左侧列表中选项，关联商品即可进入右侧已关联列表。保存后生效。您还可以在右侧编辑关联模式。',
	'screen_search_goods'			=> '筛选搜索到的商品信息',
	'no_content'					=> '暂无内容',
	'add_time' 						=> '添加时间',
	'related_download'				=> '相关下载',
	'total'							=> '共',
	'piece'							=> '篇',
	'drop_article_confirm'			=> '您确定要删除该文章吗？',
	'time_format_error'				=> '时间格式不正确',
	'article_name_is'				=> '文章名称为 ',
	
	'article_manage'		=> '文章管理',
	'article_list'			=> '文章列表',
	'store_article_list'	=> '商家投稿',
	'shop_help'		  		=> '网店帮助',
	'shop_info'				=> '网店信息',
	'article_auto_release'	=> '文章自动发布',
	'article_update'		=> '文章更新',
	'article_remove'		=> '文章删除',
	'cat_update'			=> '分类更新',
	'cat_remove'			=> '分类删除',
	'shopinfo_manage'		=> '网店信息管理',
	'shophelp_manage'		=> '网店帮助管理',
	'article_auto_manage'	=> '文章自动管理',
	'article_auto_update'	=> '文章自动更新',
	'article_auto_delete'	=> '文章自动删除',
	'invalid_parameter'		=> '参数无效',
	
	//help
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	
	//文章帮助
	'article_list_help'		=> '欢迎访问ECJia智能后台文章列表页面，系统中所有的文章都会显示在此列表中。',
	'about_article_list'	=> '关于文章列表帮助文档',
	'add_article_help'		=> '欢迎访问ECJia智能后台添加文章页面，可以在此页面添加文章信息。',
	'about_add_article'		=> '关于添加文章帮助文档',
	'edit_article_help'		=> '欢迎访问ECJia智能后台编辑文章页面，可以在此页面编辑相应的文章信息。',
	'about_edit_article'	=> '关于编辑文章帮助文档',
	'preview_article_help'	=> '欢迎访问ECJia智能后台预览文章页面，可以在此预览相应的文章信息。',
	'about_preview_article'	=> '关于预览文章帮助文档',
	'link_goods_help'		=> '欢迎访问ECJia智能后台关联商品页面，可以在此页面编辑相应的关联商品信息。',
	'about_link_goods'		=> '关于关联商品帮助文档',
	
	//文章分类
	'cat_name_required'		=> '请输入文章分类名称',
	
	//文章分类帮助
	'article_cat_help'		=> '欢迎访问ECJia智能后台文章分类页面，系统中所有的文章分类都会显示在此列表中。',
	'about_article_cat'		=> '关于文章分类帮助文档',
	'add_cat_help'			=> '欢迎访问ECJia智能后台添加文章分类页面，可以在此页面添加文章分类信息。',
	'about_add_cat'			=> '关于添加文章分类帮助文档',
	'edit_cat_help'			=> '欢迎访问ECJia智能后台编辑文章分类页面，可以在此页面编辑相应的文章分类信息。',
	'about_edit_cat'		=> '关于编辑文章分类帮助文档',
	
	'shophelp_title_required' => '请输入帮助文章标题',
	
	//网店帮助
	'shophelp_help'			=> '欢迎访问ECJia智能后台网店帮助列表页面，系统中所有的网店帮助都会显示在此列表中。',
	'about_shophelp'		=> '关于网店帮助列表帮助文档',
	'shophelp_article_help'	=> '欢迎访问ECJia智能后台网店帮助文章列表页面，系统中指定分类下的网店帮助文章都会显示在此列表中。',
	'about_shophelp_article'=> '关于网店帮助文章帮助文档',
	'add_shophelp_help'		=> '欢迎访问ECJia智能后台添加帮助文章页面，可以在此页面添加帮助文章信息。',
	'about_add_shophelp'	=> '关于添加帮助文章帮助文档',
	'edit_shophelp_help'	=> '欢迎访问ECJia智能后台编辑帮助文章页面，可以在此页面编辑相应的帮助文章信息。',
	'about_edit_shophelp'	=> '关于编辑帮助文章帮助文档',
	
	'shopinfo_title_required' => '请输入网店标题',
	
	//网店信息
	'shopinfo_help'			=> '欢迎访问ECJia智能后台网店信息页面，系统中所有的网店信息都会显示在此列表中。',
	'about_shopinfo'		=> '关于网店信息帮助文档',
	'add_shopinfo_help'		=> '欢迎访问ECJia智能后台添加网店信息页面，可以在此页面添加网店信息。',
	'about_add_shopinfo'	=> '关于添加网店信息帮助文档',
	'edit_shopinfo_help'	=> '欢迎访问ECJia智能后台编辑网店信息页面，可以在此页面编辑相应的网店信息。',
	'about_edit_shopinfo'	=> '关于编辑网店信息帮助文档',
	
	'js_lang' => array(
		'select_moved_article'		=> '请选择需要转移的文章',
		'article_title_required'	=> '请输入文章标题',
		'back_select_term'			=> '返回选择栏目',
		'select_goods_empty'		=> '未搜索到商品信息',
		'editable_miss_parameters'	=> 'editable缺少参数',
		'edit_info'					=> '编辑信息',
		'operate_selected_confirm'  => '您确定要操作所有选中项吗？',
		'noSelectMsg'				=> '请先选中操作项',
		'batch_miss_parameters'		=> '批量操作缺少参数',
		'ok'						=> '确定',
		'cancel'					=> '取消',
	    'select_time'   		    => '请选择时间',
	    'no_select_cat'				=> '请选择文章分类',
	),
	
	'cat_manage'				=> '文章分类管理',
	'upload_thumb'				=> '上传缩略图',
	'label_upload_image'		=> '上传图片：',
	'label_preview_image'		=> '预览图片：',
	'select_image'				=> '选择图片',
	'modify_image'				=> '修改图片',
	'label_image_address'		=> '图片地址：',
	'drop_image'				=> '删除图片',
	'drop_image_confirm'		=> '您确定要删除该图片吗？',
	'store_notice'				=> '商家公告',
	'system_info'				=> '系统信息',
	'article_title_required'	=> '请输入文章标题',
	'article_cover'				=> '文章封面',
	'label_cat_type'			=> '文章类型：',
	'content_required'			=> '请输入文章内容',
	'link_required'				=> '请输入链接',
	'file_required'				=> '请上传文件',
	'article_required'			=> '没有找到该文章',
	
	'all'			=> '全部',
	'has_checked'	=> '通过审核',
	'wait_check'	=> '待审核',
	'trash'			=> '回收站',
	'unpass'		=> '未通过审核',
	'trash_comment'	=> '垃圾评论',
	'label_author'	=> '文章作者：',
	'label_add_time'=> '添加时间：',
	'not_available'	=> '暂无',
	'rubbish_article' => '垃圾文章',
	
	'label_add_custom_columns' 	=> '添加自定义栏目：',
	'label_edit_custom_columns'	=> '编辑自定义栏目：',
	'label_suggest_type'		=> '推荐类型：',
	'article_comment'			=> '文章评论',
    'user_name'                 => '用户名',
    'comment_detail'            => '评论详情',
    'label_comment_time'        => '评论时间',
    'article_comment_list'      => '文章评论列表',
    'enter_comment_username'    => '请输入用户名或评论关键字',
    'article_comments'			=> '文章评论',
    'comment_list'				=> '文章评论列表',
    'rubbish_comments'			=> '垃圾评论',	
    'drop_comment'				=> '删除评论',
    'select_drop_comment'		=> '请选择要删除的评论',
    'select_trash_comment'		=> '请选择要移至回收站的评论',
    'select_approve_comment'	=> '请选择要审核通过的评论',
    'select_rubbish_comment'	=> '请选择要设为垃圾评论的评论',
    'article_comment_update'	=> '审核文章评论',
    'comment_is'				=> '评论内容是 ',
    'article_comment_delete'	=> '删除文章评论',
   	'view_comment'				=> '查看评论',
   	'like_count'				=> '点赞数',
   	'drop_comment_confirm'		=> '您确定要删除该文章评论吗？',
   	'comment_required'			=> '没有找到该评论',
   	'article_title_is'			=> '文章标题是',	
   	'trash_confirm'		    => '您确定要将该文章设为垃圾文章吗？',
   	'spam_confirm'		    => '您确定要将该文章移至回收站吗？',
   	'trash_msg'				=> '垃圾文章',
   	'move_to_recycle'		=> '移至回收站',
   	'remove_comment_confirm'=> '您确定要删除这条评论吗？',
   	'remove_forever'		=> '永久删除',
   	'comment_content_is'	=> '评论内容是：',
   	'comment_count'			=> '评论数',
   	'comment_status'		=> '审核状态',
   	'trash_comment_confirm'	=> '您确定要将该评论设为垃圾评论吗？',
   	'article_comment'		=> '文章评论',
   	'article_comment_manage'=> '文章评论管理',
);

//end