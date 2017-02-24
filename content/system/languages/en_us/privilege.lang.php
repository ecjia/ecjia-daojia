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

return array(
	/* Field information */
	'user_id'	=> 'ID',
	'user_name'	=> 'Username',
	'email'		=> 'Email',
	'password'	=> 'Password',
	'join_time'	=> 'Join time',
	'last_time'	=> 'The latest login time',
	'last_ip'	=> 'The latest visitor\'s IP',
	'action_list'	=> 'Operater authorization',
	'nav_list'		=> 'Navigation',
	'language'		=> 'language',
	
	'allot_priv'	=> 'Assign authorization',
	'allot_list'	=> 'Authorization list',
	'go_allot_priv'	=> 'Administrator authorization config',
	
	'view_log'		=> 'View logs',
	
	'back_home'		=> 'Return to HOME',
	'forget_pwd'	=> 'Do you forget password?',
	'get_new_pwd'	=> 'Get back administrator password',
	'pwd_confirm'	=> 'Re-enter',
	'new_password'	=> 'New password',
	'old_password'	=> 'Primary password',
	'agency'		=> 'Agency the user be in charge of',
	'self_nav'		=> 'Individual navigation',
	'all_menus'		=> 'All menus',
	'add_nav'		=> 'Add',
	'remove_nav'	=> 'Remove',
	'move_up'		=> 'Move up',
	'move_down'		=> 'Move down',
	'continue_add'	=> 'Continue add administrator.',
	'back_list'		=> 'Return to administrator list.',
	'select_role'	=> 'Choose role',
	'select_please'	=> 'Please select...',
	
	'admin_edit'	=> 'Edit administrator',
	'edit_pwd'		=> 'Edit password',
	
	'back_admin_list'	=> 'Return to administrator list.',
	
	/* Prompting message */
	'js_languages' => array(
		'user_name_empty'	=> 'Please enter username!',
		'password_invaild'	=> 'Password must contain both letters and numbers and the length should not be smaller than in 6!',
		'email_empty'		=> 'Email address can\'t be blank!',
		'email_error'		=> 'Email address format is invalid!',
		'password_error'	=> 'The two passwords you entered did not match. Please type it again!',
		'captcha_empty'		=> 'Please enter verification code!',
	),
	'action_succeed'		=> 'Successfully!',
	'edit_profile_succeed'	=> 'You edit account information successfully!',
	'edit_password_succeed'	=> 'You edit password successfully, please re-login!',
	'user_name_exist'		=> 'The administrator already exists.',
	'email_exist'			=> 'Email address already exists.',
	'captcha_error'			=> 'Your verification code is invalid.',
	'login_faild'			=> 'Your accounts information is invalid.',
	'user_name_drop'		=> 'Delete successfully!',
	'pwd_error'				=> 'Primary password is invalid.',
	'old_password_empty'	=> 'If you want edit password, you must enter the primary password!',
	'edit_admininfo_error'	=> 'You can only edit yourself profile!',
	'edit_admininfo_cannot'	=> 'You can\'t operate for the administrator authorization!',
	'edit_remove_cannot'	=> 'You can not delete the administrator demo!',
	'remove_self_cannot'	=> 'Administrator demo can\'t be deleted!',
	'remove_cannot'			=> 'You have no authorization to delete!',
	
	'modif_info'	=> 'Edit Profile',
	'edit_navi'		=> 'Config individual navigation',
	
	/* Help */
	'password_notic'	=> 'If you want to edit the password, please enter primary password, if leave a blank, password isn\'t changed.',
	'email_notic'		=> 'Enter administrator\'s Email address, the format must be valid.',
	'confirm_notic'		=> 'Re-enter administrator\'s password, your password entries must match.',
	
	/* Login memu */
	'label_username'	=> 'Username:',
	'label_password'	=> 'Password:',
	'label_captcha'		=> 'Verification Code:',
	'click_for_another'	=> 'Invisibility? Replace an image.',
	'signin_now'		=> 'Enter',
	'remember'			=> 'Remember my login information.',
);

//end