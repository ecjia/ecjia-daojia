<?php
/**
 * 网站指定登录入口
 */

define('IN_ECJIA', true);
//define('NO_CHECK_INSTALL', true);

// 站点根目录
define('SITE_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('VENDOR_DIR', SITE_ROOT . 'vendor');

require SITE_ROOT . 'content/bootstrap/kernel.php';

// end