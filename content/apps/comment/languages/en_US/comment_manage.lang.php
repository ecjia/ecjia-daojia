<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 评论管理的语言文件
 */

return array(
	'comment_id' 		=> 'ID',
	'user_name' 		=> 'Username',
	'from' 				=> 'sent comment at ',
	'to' 				=> 'to',
	'send_comment' 		=> 'comment',
	'user_name' 		=> 'Username',
	'email' 			=> 'Email',
	'anonymous' 		=> 'Anonymous',
	'send_email_notice' => 'Email notification',
	'remail' 			=> 'Re-issued e-mail',
	
	'comment_type' 		=> 'Type',
	'comment_obj' 		=> 'Comment object',
	'content' 			=> 'Comment contents:',
	'comment_time' 		=> 'Time',
	'reply_content' 	=> 'Reply',
	'comment_flag' 		=> 'Flag',
	'no_reply' 			=> 'No reply',
	'yes_reply' 		=> 'Replied',
	'admin_user_name' 	=> 'Administrator',
	
	'type' 				=> array('Product', 'Article'),
	
	'ip_address' 		=> 'IP address',
	'ip_address_lable' 	=> 'IP address:',
	'view_reply' 		=> 'View reply',
	'view_content' 		=> 'View content',
	'comment_rank' 		=> 'Comment rank:',
	'search_comment' 	=> 'Enter a comment keywords',
	'no_reply_comment' 	=> 'Not replied comment',
	'all_comment' 		=> 'View all comments',
	'reply_comment' 	=> 'Reply',
	'comment_info' 		=> 'Comment Details',
	'comment_list' 		=> 'Comment list',
	'list_comment_info'	=> 'Comment details',
	
	'drop_select'  	=> 'Delete comment',
	'reply'			=> 'Reply',
	'check' 		=> 'Check',
	'allow' 		=> 'Open',
	'forbid' 		=> 'Close',
	'display' 		=> 'display',
	'hidden' 		=> 'hidden',
	
	'no_select_comment' 	=> 'You have no choice need to delete the comments!',
	'reply_comment_success' => 'Reply the comment successfully!',
	'batch_drop_success'	=> 'Command successfully!',
	'back_list' 			=> 'Return to comment list.',
	
	/* JS Prompting message */
	'js_lang' => array(
		'ok'		 		=> 'OK',
		'cancel'	 		=> 'Cancel',
		'content_required'	=> 'Please enter comment contents!',
		'one_level'			=> 'Level 1 - a serious failure',
		'two_level'			=> 'Level 2 - not qualified',
		'three_level'		=> 'Level 3 - qualified',
		'four_level'		=> 'Level 4 - excellent',
		'five_level'		=> 'Level 5 - perfect',
		'select_goods_empty'=> 'Not search for goods information',
		'select_user_empty'	=> 'Not search for user information',
		'request_failed'	=> 'Request failed',
	),
	
	'have_reply_content' => 'TIP: The comment has replied, if you reply the message again, the old message will be losed!',
	'cfm_allow' 		=> 'Are you sure you want to allow shows the selected comments?',
	'cfm_remove' 		=> 'Are you sure you want to delete the selected comments?',
	'cfm_deny' 			=> 'Are you sure you want to ban shows the selected comments?',
	'mail_send_fail' 	=> 'Mail sent failed, please check the e-mail server settings and try again.',

	//追加
	'drop_success' 			=> 'Delete success',
	'goods_comment'			=> 'Goods Comment',
	'article_comment'		=> 'Article Comment',
	'add_goods_comment'		=> 'Add Goods Comment',
	'add_article_comment'	=> 'Add Article Comment',
	'goods_comment_list'	=> 'Goods Comment List',
	'article_comment_list'	=> 'Article Comment List',
	'add_comment_success'	=> 'Add comment success',
	'no_comment_info'		=> 'Comment is not found',
	'mail_notice_success'	=> 'Mail Notification Success',
	'mail_send_fail'		=> 'Failed to send message',
	'reply_success'			=> 'Comments reply success',
	
	'show_success'			=> 'Display status switch successfully',
	'valid_success'			=> 'Has been successfully set to a valid comment',
	'reset_success'			=> 'The review has been successfully recovered from the recycle bin',
	'hide_success'			=> 'Hidden state switch successfully',
	'trash_success'			=> 'Has been successfully set to garbage review',
	'trashed_success'		=> 'The comment has been successfully moved to the trash',
	'operation_failed'		=> 'Operation failed',
	'operation_success'		=> 'Successful operation',
	
    'binding_article'		=> 'Binding article:',
    'binding_goods'		    => 'Binding goods:',
    'binding_user'		    => 'Binding user:',
    
	'bind_article_lable'	=> 'Binding article',
	'search_article_notice'	=> 'Please click on the search button, select article',
	'enter_article_name'	=> 'Please enter the article name',
	'search_article'		=> 'Search',
	'filter_article_info'	=> 'Filter to article',
	'no_content'			=> 'No content yet',
	'bind_article_info'		=> 'Click on the search results to bind the article information',
	
	'bind_user_lable'		=> 'Binding user',
	'search_user_notice'	=> 'Please click on the search button, select Member',
	'enter_user_name'		=> 'Please enter a username',
	'search_user'			=> 'Search',
	'filter_user_name'		=> 'Search for membership information',
	'bind_user_info'		=> 'Click search results to bind member information',
	
	'bind_goods_lable'		=> 'Binding goods',
	'search_goods_notice'	=> 'Please click on the search button below, select the product',
	'enter_goods_name'		=> 'Please enter the name of the goods',
	'search_goods'			=> 'Search',
	'filter_goods_info'		=> 'Screen search for product information',
	'bind_goods_info'		=> 'Click on the search results to bind the product information',
	
	'all'					=> 'All',
	'waitcheck'				=> 'Wait check',
	'checked'				=> 'Checked',
	'trash_msg'				=> 'Comment spam',
	'trashed_msg'			=> 'Recycle bin',
	'batch_operation'		=> 'Batch Operations',
	'move_to_recycle'		=> 'Move to recycle bin',
	'no_trash_msg'			=> 'Not Spam',
	'restore_review'		=> 'Restore Comments',
	
	'comment_on'			=> 'Comment on',
	'reject'				=> 'Reject',
	'view_reply'			=> 'View and reply',
	'remove_forever'		=> 'Permanently deleted',
	
	'trash_confirm'		    => 'Are you sure you want to set the comment spam comment?',
	'move_confirm'		    => 'Are you sure you want to move the comment to the trash?',
	
	'batch_allow_confirm'   => 'Are you sure you want to batch allows to display the selected comment?',
	'batch_fobid_confirm'   => 'Are you sure you want to batch disable the display of selected comments?',
	'batch_trash_confirm'   => 'Are you sure you want to set the selected comment to the garbage comment?',
	'batch_move_confirm'    => 'Are you sure you want to batch move the selected comment to the recycle bin?',
	'batch_cancel_confirm'  => 'Are you sure you want to batch uncheck comments as spam comment?',
	'batch_restore_confirm' => 'Are you sure you want to batch restore the selected comment?',
	
	'remove_confirm'		=> 'Are you sure you want to delete this comment?',
	'pls_select_comment'	=> 'Please select a comment to be operated on.',
	'approval'				=> 'Approval',
	'published_in'			=> 'Published in:',
	'reply_to'				=> 'Reply to',
	
	'comment_manage'	=> 'Comments',
	'comment_add'		=> 'Add Comment',
	'comment_update'	=> 'Edit Comment',
	'comment_delete'	=> 'Delete Comment',
	
	'overview'			=> 'Overview',
	'more_info'			=> 'More information:',
	
	'goods_comment_list_help'		=> 'Welcome to ECJia intelligent background goods comment list page, the system reviews the commodity will be displayed in this list.',
	'about_goods_comment_list'		=> 'About the comment list of product reviews help document',
	
	'article_comment_list_help'		=> 'Welcome to ECJia intelligent background articles comment list page, the system will be displayed in this list in the comments.',
	'about_article_comment_list'	=> 'About the comment list of article help document',
	
	'goods_comment_detail_help'		=> 'Welcome to ECJia intelligent background product reviews details page, you can view all comments about the product details on this page, and you can reply.',
	'about_goods_comment_detail'	=> 'About goods reviews details help document',
	
	'article_comment_detail_help'	=> 'Welcome to ECJia intelligent background articles review details page, you can view all comments on this article details on this page, and you can reply.',
	'about_article_comment_detail'	=> 'About comments on the article details help document',
);

// end