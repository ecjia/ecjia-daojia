<?php
/**
 * 网站指定登录入口
 */

define('IN_ECJIA', true);
define('RC_DEBUG', true);
if (!defined('USE_PLATFORM_MOBILE')) define('USE_PLATFORM_MOBILE', true);

// 站点根目录
define('SITE_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// 判断PHP最低版本
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    echo 'Current PHP Version: ' . PHP_VERSION . ', Required Version: 5.4.0';
    exit();
}

require SITE_ROOT . 'vendor/autoload.php';

require ROYALCMS_PATH . 'bootstrap/start.php';

royalcms::start();

// end