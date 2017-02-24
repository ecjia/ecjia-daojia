<?php
/**
 * 网站指定登录入口
 */

define('RC_SITE', 'm');
define('USE_SUB_DOMAIN', false);
define('USE_SUB_CACHE', false);
define('USE_SUB_UPLOAD', false);
define('WEB_PATH', '/sites/m/');

include_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.php');

// end