<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 应用语言包
 */

return array(
	/* Links field information */
	'link_id' 		=>  'ID',
	'link_name' 	=>  'Name',
	'link_url' 		=>  'URL',
	'link_logo' 	=>  'Logo',
	'url_logo' 		=>  'Or link URL',
	'link_type' 	=>  'Type',
	'show_order' 	=>  'Sort',
	
	'link_logo_type_local' 	=> 'Local upload',
	'link_logo_type_url' 	=> 'Remote link',
	'link_logo_upload' 		=> 'Upload link LOGO：',
	'link_text' 			=> 'Text',
	'link_img' 				=> 'Image',
	
	'cur_link_logo' 	=>  'Current link LOGO',
	'list_link' 		=>  'Links List',
	'add_link' 			=>  'Add New Link',
	'edit_link' 		=>  'Edit Link',
	'no_links' 			=>  'There is no friendly link',
	'back_list' 		=>  'Return to links list',
	'continue_add' 		=>  'Continue to add link',
	
	'link_name_empty' 	=>  'Link name can\'t be empty!',
	'link_url_empty' 	=>  'Link URL can\'t be empty!',
	'link_logo_empty' 	=>  'Link LOGO can\'t be empty!',
	'link_img_empty' 	=>  'Link image can\'t be empty!',
	'link_url_exist' 	=>  'Links URL already exists.',
	'link_name_exist' 	=>  'Links name already exists.',
	'enter_int' 		=>  'Display the order must be an integer!',
	'link_order'		=>  'Sort number cannot be empty',
	
	/* Help information */
	'url_logo_value' 	=>  'If appoint remote LOGO image, the beginning of LOGO\'s URL must be http:// or https://, and the format should be correctly!',
	'link_name_desc' 	=>  'When you add a text link, the link LOGO will be your link name.',

	/* ajax 提示信息   */	//追加
	'drop_success'	=> 'Delete success！',
	'add_success'	=> 'Add success！',
	'edit_success'	=> 'Edit success！',
	
	/* JS Prompting message */
	'js_languages' => array(
		'link_name_empty' 	=>  'Please enter link name!',
		'link_url_empty' 	=>  'Please enter link URL!',
		'show_order_type' 	=>  'Display the order must be a figure!',
	),
	
	//追加
	'drop_fail'			=> 'Delete failed',
	'edit_fail'			=> 'Edit Failed',
	'link_name_empty'	=> 'Please enter the name of the link',
	'search'			=> 'Search',
	'edit_order'		=> 'Edit sort',
	'edit_link_name'	=> 'Edit link name',
	'drop_confirm'		=> 'Are you sure you want to delete this link?',
	'image_preview'		=> 'Picture preview',
	'browse'			=> 'Browse',
	'modify'			=> 'Modify',
	'drop_logo_confirm'	=> 'Are you sure you want to delete the link LOGO?',
	'update'			=> 'Update',
	'set_check_success' => 'Set the audit status success',
	'set_wait_success'	=> 'Set unapproved state success',
	
	'batch_drop_confirm'=> 'Are you sure you want to delete the selected link?',
	'select_drop_link'	=> 'Please select the links you want to delete',
	'batch_handle'		=> 'Batch Operations',
	'link_keywords'		=> 'Please enter name keywords',
	
	'checked'			=> 'Checked',
	'waitcheck'			=> 'Not audited',
	'wait_check'		=> 'Pending audit',
	'through_audit'		=> 'Through audit',
	'status'			=> 'Audit status:',
	'passed'			=> 'Already passed',
	'not_passed'		=> 'Not through',
	'from'				=> 'Sources:',
	'background_add'	=> 'Background add',
	'foreground_apply'	=> 'Foreground application',
	'release_info'		=> 'Release information',
	'add_time'			=> 'Application time:',
	'pass_confirm'		=> 'Are you sure you want to pass the audit?',
	'not_pass_confirm'	=> 'Are you sure you want to reject the audit?',
	'not_pass'			=> 'Dismiss the audit',
	'replease'			=> 'Release',
	'other_info'		=> 'Other information',
	'label_contact'		=> 'Contact information:',
	'label_description'	=> 'Web description:',
	'label_link_name'	=> 'Name:',
	'label_link_url'	=> 'URL:',
	'label_link_logo'	=> 'LOGO:',
	'label_order'		=> 'Sort order:',
	
	'friendlink_manage' => 'Link Management',
	'friendlink_add'	=> 'Add Link',
	'friendlink_update'	=> 'Edit Link',
	'friendlink_delete'	=> 'Delete Link',
	'friendlink'		=> 'Friendlink',
	
	'link_name_required'=> 'Please enter a name!',
	'link_url_required'	=> 'Please enter the URL!',
	'ok'				=> 'OK',
	'cancel'			=> 'Cancel',
);

// end