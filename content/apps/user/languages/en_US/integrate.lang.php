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
 * ECJia Management center member data integration plug-in management language file
 */
return array(
    'integrate_name'    => 'Name',
    'integrate_version' => 'Version',
    'integrate_author'  => 'Author',

    /* Hint an information*/
    'update_success'    => 'Member data integration plug-in is configed successfully.',
    'install_confirm'   => "Please don\'t edit integration plug-in in use. \nMember data will be cleared if you switch integration plug-in, and include:\n member information, member account datails, member address of receipt, member bonus, order information, cart. \r\n Are you sure install the member data integration plug-in?",
    'need_not_setup'    => 'You needn\'t set wehn you use ECSHOP systerm',
    'different_domain'  => 'The integration object and ECSHOP of[with] your setup is not under same area.<Br/>you member\'s data that can share that system, but can\'t carry out to register in the meantime.',
    'points_set'        => 'Redeem settings',
    'view_user_list'    => 'View Forum User',
    'view_install_log'  => 'See the installation log',

    'integrate_setup' => 'Setup member data integration plug-in.',
    'continue_sync'   => 'Continue synchronous member\'s data.',
    'go_userslist'    => 'Return to member list',

    'user_help'         => 'Usage:<br>
			1:If the users need to integrate other systems, you can install the appropriate plug-ins to integrate the version number.<br>
			2:If you need to replace the user\'s system integration, plug-ins can be installed directly target the integration at the same time automatically uninstall an integrated plug-ins on.<br>
			3:If you do not need any user\'s system integration, please select ecshop installed plug-ins, you can uninstall all of the integration of plug-ins',

    /* 查看安装日志 */
    'lost_install_log'  => 'Did not find the installation log',
    'empty_install_log' => 'Installation log is empty',

    /* The form related language item*/
    'db_notice'         => 'Click“<font color="#000000">Next</font>”Will guide you to the mall user data will be synchronized to the integration of the Forum。If no synchronous data please click“<font color="#000000">Save configuration information directly</font>”',
    'lable_db_host'     => 'Database server host:',
    'lable_db_name'     => 'Database:',
    'lable_db_chartset' => 'The database character list gather:',
    'lable_is_latin1'   => 'Whether to latin1 encoding',

    'lable_db_user' => 'Database account number:',
    'lable_db_pass' => 'Database password:',
    'lable_prefix'  => 'Datasheet prefixion:',
    'lable_url'     => 'Complete URL of the integrated system:',

    /* The form related labguage item(discus5x) */
    'cookie_prefix' => 'COOKIE prefix:',
    'cookie_salt'   => 'COOKIE Encrypted string：',
    'button_next'   => 'next',

    'button_force_save_config' => 'Save configuration information directly',
    'save_confirm'             => 'Are you sure you want to configure the direct preservation of information?',
    'button_save_config'       => 'Save configuration information',

    'error_db_msg'      => 'Database address, user or password is incorrect',
    'error_db_exist'    => 'Database does not exist',
    'error_table_exist' => 'Forum integration of critical data table does not exist, you have mistakenly filled out the information',

    'notice_latin1'            => 'This option will fill in error may lead to Chinese user name can not be used',
    'error_not_latin1'         => 'Integrated database latin1 encoding is not detected! Please re-select',
    'error_is_latin1'          => 'Integrated database to detect lantin1 are coding! Please re-select',
    'invalid_db_charset'       => 'Integrated database detected are% s character set, rather than% s character set',
    'error_latin1'             => 'You fill in the integration of information will lead to serious error, unable to complete the integration of',

    /* 检查同名用户 */
    'conflict_username_check'  => 'Check whether the user and integrating Mall Forum users have duplicate names',
    'check_notice'             => 'This page will detect Mall has been whether or not the user and the forum users have duplicate names, click on "before the inspection began," Chong Ming for the city deal with the user to choose a default method',
    'default_method'           => 'If you have duplicate names detected Mall user, please for the user to select a default way to deal with',
    'shop_user_total'          => 'Mall a total of% s users to check to be',
    'lable_size'               => 'Each inspection, the number of users',
    'start_check'              => 'Checking',
    'next'                     => 'next',
    'checking'                 => 'Checking...(Please do not close your browser)',
    'notice'                   => 'Has inspected %s / %s ',
    'check_complete'           => 'Inspection complete',

    /* 同名用户处理 */
    'conflict_username_modify' => 'Chong Ming Mart User List',
    'modify_notice'            => 'The following is a list of all city and Chong Ming Forum Users and treatment. If you have confirmed all operations, click "Start integration", Chong Ming you change the user\'s operation required the click of a button "Save this page to change" to take effect.',
    'page_default_method'      => 'Chong Ming of the page the user default method of treatment',

    'lable_rename'        => 'Chong Ming Shangcheng users plus the suffix',
    'lable_delete'        => 'Mall of Chong Ming delete users and relevant data',
    'lable_ignore'        => 'Chong Ming users retain Mall, the Forum considered the same name as the user the same user',
    'short_rename'        => 'Mall user renamed',
    'short_delete'        => 'Mall delete users',
    'short_ignore'        => 'Mall users to retain',
    'user_name'           => 'Mall user name',
    'email'               => 'email',
    'reg_date'            => 'Registration Date',
    'all_user'            => 'Chong Ming users all Shangcheng',
    'error_user'          => 'Required to operate the Mall re-select the user',
    'rename_user'         => 'Required a user name of the Shopping Mall',
    'delete_user'         => 'Mall of the required delete users',
    'ignore_user'         => 'Users need to retain the Mall',
    'submit_modify'       => 'Save this page changes',
    'button_confirm_next' => 'The beginning of the integration',

    /* 用户同步 */
    'user_sync'           => 'Synchronization data to the Forum Shopping Mall, and complete integration',
    'button_pre'          => 'Previous',
    'task_name'           => 'Missions were',
    'task_status'         => 'Mission status',
    'task_del'            => '%s months Shangcheng the number of users to be deleted',
    'task_rename'         => '%s months Shangcheng user name required',
    'task_sync'           => '%s months Shangcheng users need to synchronize to the forum',
    'task_save'           => 'Save configuration information, and complete integration',
    'task_uncomplete'     => 'Unfinished',
    'task_run'            => 'Implementation (%s / %s)',
    'task_complete'       => 'Has been completed',
    'start_task'          => 'The beginning of mission',
    'sync_status'         => 'Has been synchronized %s / %s',
    'sync_size'           => 'Each treatment the number of users',
    'sync_ok'             => 'Congratulations. Successful integration',
    'save_ok'             => 'Save successfully',

    /* 积分设置 */
    'no_points'           => 'Forum has not detected points can be exchanged',
    'bbs'                 => 'bbs',
    'shop_pay_points'     => 'Shangcheng consumption points',
    'shop_rank_points'    => 'Mall grade points',
    'add_rule'            => 'New rules',
    'modify'              => 'Modify',
    'rule_name'           => 'Exchange rules',
    'rule_rate'           => 'Exchange ratio',

    /* JS language item */
    'js_languages'        => array(
        'no_host'          => 'The database server host can\'t be blank.',
        'no_user'          => 'The database account number can\'t be blank.',
        'no_name'          => 'The database can\'t be blank.',
        'no_integrate_url' => 'Please enter complete URL of conformity object.',
        'install_confirm'  => "Please don\'t optional replace conformity objectt in the system. \\nAre you sure install the member data conformity plug-in?",
        'num_invalid'      => 'The synchronous data record a number isn\'t an integer',
        'start_invalid'    => 'The start position of the synchronous data isn\'t an integer',
        'sync_confirm'     => "Synchronize member\'s data will rebuild the target data table. \\nPlease backup your data before carrying out synchronize. \\nAre you sure start to synchronize member\'s data?",
        'no_method'        => 'Please select a default way to deal with',
        'rate_not_null'    => 'The ratio should not be empty',
        'rate_not_int'     => 'The ratio of integers can only be filled',
        'rate_invailed'    => 'You fill a void ratio of',
        'user_importing'   => 'Importing users into UCenter Medium ...',
    ),

    'cookie_prefix_notice' => 'UTF8 version of the cookie prefix is xnW_，GB2312/GBK version of the cookie prefix is KD9_。',

    /* UCenter设置语言项 */
    'ucenter_tab_base'     => 'Basic Settings',
    'ucenter_tab_show'     => 'Display Settings',
    'ucenter_lab_id'       => 'UCenter Apply ID:',
    'ucenter_lab_key'      => 'UCenter Communication key:',
    'ucenter_lab_url'      => 'UCenter Access Address:',
    'ucenter_lab_ip'       => 'UCenter IP Address:',

    'ucenter_lab_connect' => 'UCenter Connection:',
    'ucenter_lab_db_host' => 'UCenter Database server:',
    'ucenter_lab_db_user' => 'UCenter Database user name:',
    'ucenter_lab_db_pass' => 'UCenter Database password:',
    'ucenter_lab_db_name' => 'UCenter Database Name:',
    'ucenter_lab_db_pre'  => 'UCenter Table Prefix:',

    'ucenter_lab_tag_number' => 'TAG Tags show the quantity:',
    'ucenter_lab_credit_0'   => 'Grade Points Name:',
    'ucenter_lab_credit_1'   => 'Consumer integral Name:',
    'ucenter_opt_database'   => 'Database approach',
    'ucenter_opt_interface'  => 'Interface mode',

    'ucenter_notice_id'      => 'The value for the current store in UCenter Application ID, please do not change the general situation',
    'ucenter_notice_key'     => 'Communication key for UCenter and ECShop information between the transmission of encrypted, can contain any letters and numbers, please UCenter with identical settings ECShop communication key to ensure that the two systems, normal communication can',
    'ucenter_notice_url'     => 'The value after you finish installing UCenter will be initialized in your address or directory UCenter changing circumstances, to change this, please do not change the general situation such as: http://www.sitename.com/uc_server (Finally do not increase"/")',
    'ucenter_notice_ip'      => 'If your server can not access through the domain name UCenter, can enter the IP address of the server UCenter',
    'ucenter_notice_connect' => 'Depending on your server network environment to choose the appropriate connection method',
    'ucenter_notice_db_host' => 'Can be local can also be a remote database server, if instead of the default MySQL port 3306, please fill out the following form: 127.0.0.1:6033',
    'uc_notice_ip'           => 'Some effort to connect the process of problem, please fill out the server IP address, if you have UC and ECShop mounted on the same server, we recommend that you try to fill in 127.0.0.1',

    'uc_lab_url'  => 'UCenter of URL:',
    'uc_lab_pass' => 'UCenter Founder password:',
    'uc_lab_ip'   => 'UCenter of IP:',

    'uc_msg_verify_failur'  => 'Authentication failure',
    'uc_msg_password_wrong' => 'Founder of the password error',
    'uc_msg_data_error'     => 'Installation of data errors',

    'ucenter_import_username' => 'Member data import into UCenter',
    'uc_import_notice'        => 'Reminder: the data before importing Member to suspend all applications (such as Discuz!, SupeSite, etc.)',
    'uc_members_merge'        => 'Member merger approach',
    'user_startid_intro'      => '<p>Member ID for this start- %s. Such as the original ID for the 888 will become a member of %s +888 value.</p>',
    'uc_members_merge_way1'   => 'UC will work with the same username and password of the user compulsory for the same user',
    'uc_members_merge_way2'   => 'UC will work with the same username and password of the user does not import UC users',
    'start_import'            => 'Began to import',
    'import_user_success'     => 'Member data successfully into UCenter',
    'uc_points'               => 'UCenter dollar set of points required in the management of the background UCenter',
    'uc_set_credits'          => 'Set points exchange program',
    'uc_client_not_exists'    => 'uc_client directory does not exist, please upload it to Shangcheng uc_client directory under the root directory and then integrate',
    'uc_client_not_write'     => 'uc_client/data directory not writable, please uc_client/data directory permissions set to 777',

    'uc_lang' => array(
        'credits'  => array(
            '0' => array(
                '0' => 'Grade points',
                '1' => ''
            ),
            '1' => array(
                '0' => 'Consumption points',
                '1' => ''
            )
        ),
        'exchange' => 'UCenter积分兑换'
    ),

    'save_error'          => 'Save failed',
    'member_integration'  => 'Member Integration',
    'back_integration'    => 'Integration Back Members',
    'integration_ok'      => 'Members successfully enabled the integration of plug-ins',
    'support_UCenter'     => 'Currently only supports UCenter way to integrate members.',
    'integrate_desc'      => 'Description',
    'set_up'              => 'Setup',
    'enable'              => 'Enable',
    'UCenter_api'         => 'UCenter only use the interface connection mode.',
    'UCenter_integration' => 'Currently only supports UCenter member integration',
    'yes'                 => 'Yes',
    'no'                  => 'No',
    'save'                => 'Save',

    'js_lang' => array(
        'sFirst'        => 'Home page',
        'sLast'         => 'End page',
        'sPrevious'     => 'Last page',
        'sNext'         => 'Next page',
        'sInfo'         => 'A total of _TOTAL_ records section _START_ to section _END_',
        'sZeroRecords'  => 'Did not find any record',
        'sEmptyTable'   => 'Did not find any record',
        'sInfoEmpty'    => 'A total of 0 records',
        'sInfoFiltered' => '(retrieval from _MAX_ data)',

        'server_name'   => 'Please enter a server host name!',
        'data_name'     => 'Please enter a database account!',
        'data_password' => 'Please enter a database password!',
        'check_url'     => 'Please enter the full URL!',
        'check_cookie'  => 'Please enter a prefix COOKIE!',
    )
);

//end