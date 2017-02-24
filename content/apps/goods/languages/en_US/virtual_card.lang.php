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
 * ECJIA 虚拟卡管理
 */
return array(
	/*------------------------------------------------------ */
	//-- Card information
	/*------------------------------------------------------ */
	'virtual_card_list' => 'Virtual Goods List',
	'return_list'		=> 'Return to virtual goods list',
	'lab_goods_name' 	=> 'Name:',
	'replenish' 		=> 'Replenish',
	'card_sn' 			=> 'No.',
	'card_password' 	=> 'Password',
	'end_date' 			=> 'Deadline',
	'lab_card_id' 		=> 'ID',
	'lab_card_sn' 		=> 'No.:',
	'lab_card_password' => 'Password:',
	'lab_end_date' 		=> 'Deadline:',
	'lab_is_saled' 		=> 'Saled',
	'lab_order_sn' 		=> 'Order No.',
	'action_success' 	=> 'Operation success',
	'action_fail' 		=> 'Operation fail',
	'card' 				=> 'Card list',
	
	'batch_card_add' 	=> 'Batch add products',
	'download_file' 	=> 'Download batch CSV files.',
	'separator' 		=> 'Separating character',
	'uploadfile' 		=> 'Upload file',
	'sql_error' 		=> 'No. %s information was wrong:<br /> ',
	
	/*  Prompting message */
	'replenish_no_goods_id' 		=> 'Lack of product ID parameter, can\'t replenish products',
	'replenish_no_get_goods_name' 	=> 'Product ID parameter was wrong, can\'t get product name',
	
	'drop_card_success' => 'Delete success',
	'batch_drop'		=> 'Batch delete',
	'drop_card_confirm' => 'Are you sure delete the record?',
	'card_sn_exist' 	=> 'Card No. %s already exist,please enter again',
	'go_list' 			=> 'Return',
	'continue_add' 		=> 'Continue to add',
	'uploadfile_fail' 	=> 'Upload file failure',
	'batch_card_add_ok' => 'Already added %s records',
	
	'js_languages' => array(
		'no_card_sn' 			=> 'Card No. or Card Password is blank.',
		'separator_not_null' 	=> 'Separating character can\'t be blank.',
		'uploadfile_not_null' 	=> 'Please select upload file.',
		'updating_info' 		=> '<strong>Updating</strong>(Each 100 records)',
		'updated_info' 			=> '<strong>Updated</strong> <span id=\"updated\">0</span> records.',
	),
	
	'use_help' => 'Help:' .
	        '<ol>' .
	          '<li>Upload file should be CSV file<br />' .
	              'Sequential fill in every row by card ID, password, deadline, these item set off by \',\' or \',\' . But nonsupport \'blank\'<br />'.
	          '<li>Password and deadline can be blank, deadline format should be \'2006-11-6\' or \'2006/11/6\''.
	          '<li>You had better not use chinese in the file to avoid junk.</li>' .
	        '</ol>',

	/*------------------------------------------------------ */
	//-- Change encrypt string
	/*------------------------------------------------------ */
	
	'virtual_card_change' => 'Change Encrypt String',
	'user_guide' => 'Direction:' .
	        '<ol>' .
	          '<li>Encrypt string use for ID and passwrod of encrypt virtual card</li>' .
	          '<li>Encrypt string saved in data/config.php, corresponding constants is AUTH_KEY</li>' .
	          '<li>If you want to change encrypt string, enter old encrypt string and new encrypt string in the textbox, check \'Confirm\' push the button</li>' .
	        '</ol>',
	'label_old_string' => 'Old encrypt string',
	'label_new_string' => 'New encrypt string',
	
	'invalid_old_string' 	=> 'Old encrypt string was wrong',
	'invalid_new_string' 	=> 'New encrypt string was wrong',
	'change_key_ok' 		=> 'Change encrypt string success',
	'same_string' 			=> 'New encrypt string and old encrypt string are the same',
	
	'update_log' 	=> 'Update logs',
	'old_stat' 		=> 'Total %s records. %s records are encrypted by new string, %s records are encrypted by old string(wait for update), %s records are encrypted by unknown string.',
	'new_stat' 		=> '<strong>Update success</strong>, now %s records are encrypted by new string, %s records are encrypted by unknown string.',
	'update_error' 	=> 'Update was wrong: %s',
	
	//追加
	'batch_replenish'			=> 'Batch Replenishment',
	'edit_replenish'			=> 'Edit Replenishment',
	'card_not_empty'			=> 'Card number or card password can not be empty!',
	'card_exists'				=> 'Virtual card %s already exists',
	'insert_records'			=> 'The insert %s record',
	'batch_replenish_success' 	=> 'Batch replenishment success!',
	'card_edit_success'			=> 'Virtual card %s editing success',
	'update_records'			=> 'This update %s records',
	'batch_update_success'		=> 'Batch update success',
	'batch_upload'				=> 'Batch Upload',
	'batch_replenish_confirm'	=> 'Batch replenishment confirmation',
	'pls_upload_file'			=> 'Please choose to upload files',
	'default_auth_key'			=> 'Detected before you could not set the string, the system will initialize the string to 888888, please modify the new encryption string in a timely manner!',
	'update_auth_key'			=> 'Update encryption string ',
	'set_key_success'			=> 'New encryption string set successfully',
	'update_virtual_info'		=> 'At the same time, also updated the %s virtual card information!',
	'stats_edit_success'		=> 'State switch successfully',
	'card_drop_success'			=> 'Virtual card %s deleted successfully',
	'batch_operation'			=> 'Batch Operations',
	'batch_drop_confirm'		=> 'Are you sure you want to bulk delete the selected virtual card?',
	'batch_drop_empty'			=> 'Please select the options you want to operate',
	'batch_edit'				=> 'Batch edit',
	'enter_card_sn'				=> 'Please enter the order number',
	'click_change_stats'		=> 'Click to change status',
	'drop_confirm'				=> 'Are you sure you want to delete the virtual card?',
	'choose_file'				=> 'Select file',
	'modify'					=> 'modify',
	'return_last_page'			=> 'Return to the last page',
	
    'overview'             	=> 'Overview',
    'more_info'            	=> 'More information:',
	
	'vitural_card_help'		=> 'Welcome to ECJia intelligent background module in the change of the encrypted string of pages, through this page can be changed to change the product\'s encryption.',
	'about_vitural_card'	=> 'About change the encryption string help document',
);

// end