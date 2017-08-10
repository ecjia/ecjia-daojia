<?php
$_GET['m'] = 'payment';
$_GET['c'] = 'respond';

if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
    $_GET['a'] = 'notify';
} elseif (!empty($_GET)) {
    $_GET['a'] = 'response';
}

$_GET['code'] = 'pay_wxpay_weapp';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . '../index.php';

// end