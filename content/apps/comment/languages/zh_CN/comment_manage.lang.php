<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 评论管理的语言文件
 */

return array(
	'comment_id' 		=> '编号',
	'user_name' 		=> '用户名',
	'from' 				=> '于',
	'to' 				=> '对',
	'send_comment' 		=> '发表评论',
	'user_name' 		=> '用户名',
	'email' 			=> '电子邮箱',
	'anonymous' 		=> '匿名用户',
	'send_email_notice' => '邮件通知',
	'remail' 			=> '重发邮件',
	
	'comment_type' 		=> '类型',
	'comment_obj' 		=> '评论对象',
	'content' 			=> '评论内容：',
	'comment_time' 		=> '评论时间',
	'reply_content' 	=> '回复内容',
	'comment_flag' 		=> '状态',
	'no_reply' 			=> '未回复',
	'yes_reply'		 	=> '已回复',
	'admin_user_name' 	=> '管理员',
	
	'type' 				=> array('商品','文章'),
	
	'ip_address' 		=> 'IP地址',
	'ip_address_lable' 	=> 'IP地址：',
	'view_reply' 		=> '查看回复',
	'view_content' 		=> '查看详情',
	'comment_rank' 		=> '评论等级：',
	'search_comment' 	=> '输入评论内容',
	'no_reply_comment' 	=> '未回复的评论',
	'all_comment' 		=> '查看所有评论',
	'reply_comment' 	=> '回复评论',
	'comment_info' 		=> '评论详情',
	'comment_list' 		=> '评论列表',
	'list_comment_info' => '评论详情',
	
	'drop_select' 	=> '删除评论',
	'reply' 		=> '回复',
	'check' 		=> '审核',
	'allow' 		=> '允许显示',
	'forbid' 		=> '禁止显示',
	'display' 		=> '显示',
	'hidden' 		=> '隐藏',
	
	'no_select_comment' 	=> '您没有选择需要删除的评论!',
	'reply_comment_success' => '回复评论操作成功!',
	'batch_drop_success' 	=> '执行成功!',
	'back_list' 			=> '返回评论列表',
	
	/* JS提示信息 */
	'js_lang' => array(
		'ok'		 		=> '确定',
		'cancel'	 		=> '取消',
		'content_required'	=> '请填写回复内容！',
		'one_level'			=> '1级-严重不合格',
		'two_level'			=> '2级-不合格',
		'three_level'		=> '3级-合格',
		'four_level'		=> '4级-优秀',
		'five_level'		=> '5级-完美',
		'select_goods_empty'=> '未搜索到商品信息',
		'select_user_empty'	=> '未搜索到会员信息',
		'request_failed'	=> '请求失败',
	),
	
	'have_reply_content'	=> '提示: 此条评论已有回复, 如果继续回复将更新原来回复的内容!',
	'cfm_allow' 			=> '你确定要允许显示所选评论吗？',
	'cfm_remove' 			=> '你确定要删除所选评论吗？',
	'cfm_deny' 				=> '你确定要禁止显示所选评论吗？',
	'mail_send_fail' 		=> '邮件发送失败，请检查邮件服务器设置后重新发送邮件。',
	
	//追加
	'drop_success' 			=> '删除成功',
	'goods_comment'			=> '商品评价',
	'article_comment'		=> '文章评论',
	'add_goods_comment'		=> '添加商品评论',
	'add_article_comment'	=> '添加文章评论',
	'goods_comment_list'	=> '商品评论列表',
	'article_comment_list'	=> '文章评论列表',
	'add_comment_success'	=> '添加评论成功',
	'no_comment_info'		=> '没有找到相应的评论信息',
	'mail_notice_success'	=> '邮件通知成功',
	'mail_send_fail'		=> '邮件发送失败',
	'reply_success'			=> '评论回复成功',
	'admin_goods_comment'	=> '平台-商品评论',
	'check_trash_comment'	=> '查看回收站',
	'store_goods_comment_list'	=> '店铺商品评论列表',
	'store_goods_comment'	=> '店铺商品评论',
	
	'show_success'			=> '批准成功',
	'valid_success'			=> '已成功设置为有效评论',
	'reset_success'			=> '已成功将评论从回收站中还原',
	'hide_success'			=> '驳回成功',
	'trash_success'			=> '已成功设置为垃圾评论',
	'trashed_success'		=> '已成功将评论移至回收站',
	'operation_failed'		=> '操作失败',
	'operation_success'		=> '操作成功',
	
	'binding_article'		=> '绑定文章：',
    'binding_goods'		    => '绑定商品：',
    'binding_user'		    => '绑定会员：',
    
	'bind_article_lable'	=> '绑定文章',
	'search_article_notice'	=> '请先点击下面搜索按钮，选择文章',
	'enter_article_name'	=> '请输入文章名',
	'search_article'		=> '搜索文章',
	'filter_article_info'	=> '筛选搜索到的文章信息',
	'no_content'			=> '暂无内容',
	'bind_article_info'		=> '点击搜索结果绑定文章信息',
	
	'bind_user_lable'		=> '绑定会员',
	'search_user_notice'	=> '请先点击下面搜索按钮，选择会员',
	'enter_user_name'		=> '请输入会员名',
	'search_user'			=> '搜索会员',
	'filter_user_name'		=> '筛选搜索到的会员信息',
	'bind_user_info'		=> '点击搜索结果绑定会员信息',
	
	'bind_goods_lable'		=> '绑定商品',
	'search_goods_notice'	=> '请先点击下面搜索按钮，选择商品',
	'enter_goods_name'		=> '请输入商品名',
	'search_goods'			=> '搜索商品',
	'filter_goods_info'		=> '筛选搜索到的商品信息',
	'bind_goods_info'		=> '点击搜索结果绑定商品信息',
	
	'all'					=> '全部',
	'waitcheck'				=> '待审',
	'checked'				=> '获准',
	'trash_msg'				=> '垃圾评论',
	'trashed_msg'			=> '回收站',
	'batch_operation'		=> '批量操作',
	'move_to_recycle'		=> '移至回收站',
	'no_trash_msg'			=> '不是垃圾评论',
	'restore_review'		=> '还原评论',
	'wait_check'			=> '待审核',
	
	'comment_on'			=> '评论于',
	'reject'				=> '驳回',
	'view_reply'			=> '查看及回复',
	'remove_forever'		=> '永久删除',
	
	'trash_confirm'		    => '您确定要将该评论设为垃圾评论吗？',
	'move_confirm'		    => '您确定要将该评论移至回收站吗？',
	
	'batch_allow_confirm'   => '您确定要批量允许显示选中的评论吗？',
	'batch_fobid_confirm'   => '您确定要批量禁止显示选中的评论吗？',
	'batch_trash_confirm'   => '您确定要批量将选中的评论设为垃圾评论吗？',
	'batch_move_confirm'    => '您确定要批量将选中的评论移至回收站吗？',
	'batch_cancel_confirm'  => '您确定要批量取消选中的评论为垃圾评论吗？',
	'batch_restore_confirm' => '您确定要批量还原选中的评论吗？',
	
	'remove_confirm'		=> '您确定要删除该评论吗？',
	'pls_select_comment'	=> '请选择需要操作的评论',
	'approval'				=> '批准',
	'published_in'			=> '发表于',
	'reply_to'				=> '回复于',
	
	'comment_manage'	=> '评价晒单',
	'comment_add'		=> '添加评论',
	'comment_update'	=> '评论更新',
	'comment_delete'	=> '评论删除',
	
	'overview'			=> '概述',
	'more_info'			=> '更多信息：',
	
	'goods_comment_list_help'		=> '欢迎访问ECJia智能后台商品评论列表页面，系统中有关商品的评论都会显示在此列表中。',
	'about_goods_comment_list'		=> '关于商品评论列表帮助文档',
	
	'article_comment_list_help'		=> '欢迎访问ECJia智能后台文章评论列表页面，系统中有关文章的评论都会显示在此列表中。',
	'about_article_comment_list'	=> '关于文章评论列表帮助文档',
	
	'goods_comment_detail_help'		=> '欢迎访问ECJia智能后台商品评论详情页面，可以在此页面查看有关该商品的所有评论详情，同时可以进行回复。',
	'about_goods_comment_detail'	=> '关于商品评论详情帮助文档',
	
	'article_comment_detail_help'	=> '欢迎访问ECJia智能后台文章评论详情页面，可以在此页面查看有关该文章的所有评论详情，同时可以进行回复。',
	'about_article_comment_detail'	=> '关于文章评论详情帮助文档',
);

// end