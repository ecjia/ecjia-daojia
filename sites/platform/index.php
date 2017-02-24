<?php
/**
 * 网站指定登录入口
 */

define('RC_SITE', 'platform');
define('USE_SUB_DOMAIN', false);
define('USE_SUB_CACHE', false);
define('USE_SUB_UPLOAD', false);

include_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.php');

// end