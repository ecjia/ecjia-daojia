<?php
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    /*
     * Session Driver
     * mysql, ecjiaredis, memcache
     */
    'driver'                => env('SESSION_DRIVER', 'mysql'),

    'connection'            => 'ecjia',
    'table'                 => 'session',

    'session_name'          => env('SESSION_NAME', 'ecjia_token'),
    'session_admin_name'    => env('SESSION_ADMIN_NAME', 'ecjia_admin_token'),
    
    'lifetime'              => env('SESSION_LIFETIME', 43200),
    'domain'                => env('SESSION_DOMAIN', null),
    'secure'                => env('SESSION_SECURE_COOKIE', false),
    
    'httponly'              => true,

);

// end