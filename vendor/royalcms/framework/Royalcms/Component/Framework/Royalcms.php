<?php
/**
 * royalcms.php ROYALCMS框架入口文件
 * 
 * @package Royalcms
 */
use Royalcms\Component\Foundation\RoyalcmsConstant;

define('IN_ROYALCMS', true);
define('ROYALCMS_START', microtime(true));

// ROYALCMS框架路径
define('ROYALCMS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
// 第三方库路径
if (! defined('VENDOR_PATH')) define('VENDOR_PATH', VENDOR_DIR . DIRECTORY_SEPARATOR);
// 站点根路径
if (! defined('SITE_ROOT')) define('SITE_ROOT', VENDOR_PATH . '..' . DIRECTORY_SEPARATOR);

define('VENDOR_TINYMCE', 'tinymce');

if (! isset($_SERVER['HTTP_REFERER'])) {
    $_SERVER['HTTP_REFERER'] = '';
}
if (! isset($_SERVER['SERVER_PROTOCOL']) || ($_SERVER['SERVER_PROTOCOL'] != 'HTTP/1.0' && $_SERVER['SERVER_PROTOCOL'] != 'HTTP/1.1')) {
    $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
}
if (isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = strtolower($_SERVER['HTTP_HOST']);
} else {
    $_SERVER['HTTP_HOST'] = '';
}
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    ini_set('magic_quotes_runtime', 0);
    define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc() ? true : false);
} else {
    define('MAGIC_QUOTES_GPC', false);
}
if (DIRECTORY_SEPARATOR == '\\') {
    ini_set('include_path', '.;' . SITE_ROOT);
} else {
    ini_set('include_path', '.:' . SITE_ROOT);
}
// Add define('RC_DEBUG', true); enable display of notices during development.
if (! defined('RC_DEBUG')) {
    define('RC_DEBUG', false);
}

date_default_timezone_set('PRC');
setlocale(LC_ALL, 'C');

// 判断PHP最低版本
if (version_compare(PHP_VERSION, RoyalcmsConstant::PHP_REQUIRED, '<')) {
    header($_SERVER['SERVER_PROTOCOL'] . " 500 " . PHP_VERSION);
    echo 'Current PHP Version: ' . PHP_VERSION . ', Required Version: ' . RoyalcmsConstant::PHP_REQUIRED;
    exit();
}

// 加载常量定义
require_once ROYALCMS_PATH . 'Royalcms/Component/Foundation/Helpers/royalcms-const.php';

/*
|--------------------------------------------------------------------------
| loading helpers functions
|--------------------------------------------------------------------------
*/
require ROYALCMS_PATH . 'Royalcms/Component/Foundation/Helpers/royalcms-helpers.php';
require ROYALCMS_PATH . 'Royalcms/Component/Foundation/Helpers/foundation-helpers.php';
require ROYALCMS_PATH . 'Royalcms/Component/Foundation/Helpers/compatible.php';
require VENDOR_PATH . 'royalcms/support/Royalcms/Component/Support/helpers.php';

// end