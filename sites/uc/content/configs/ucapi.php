<?php

defined('IN_ECJIA') or exit('No permission resources.');

return array(
    
    'user/register'         => 'ucserver::server/user/register',
    'user/login'            => 'ucserver::server/user/login',
    'user/synlogin'         => 'ucserver::server/user/synlogin',
    'user/synlogout'        => 'ucserver::server/user/synlogout',
    'user/edit'             => 'ucserver::server/user/edit',
    'user/delete'           => 'ucserver::server/user/delete',
    'user/deleteavatar'     => 'ucserver::server/user/deleteavatar',
    'user/check_username'   => 'ucserver::server/user/check_username',
    'user/check_email'      => 'ucserver::server/user/check_email',
    'user/check_mobile'     => 'ucserver::server/user/check_mobile',
    'user/logincheck'       => 'ucserver::server/user/logincheck',
    'user/get_user'         => 'ucserver::server/user/get_user',
    'user/merge'            => 'ucserver::server/user/merge',
    'user/merge_remove'     => 'ucserver::server/user/merge_remove',
    'user/addprotected'     => 'ucserver::server/user/addprotected',
    'user/deleteprotected'  => 'ucserver::server/user/deleteprotected',
    'user/getprotected'     => 'ucserver::server/user/getprotected',
    'version/check'         => 'ucserver::server/version/check',
    'version/release'       => 'ucserver::server/version/release',

);

// end