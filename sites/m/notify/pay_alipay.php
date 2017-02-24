<?php
$_GET['m'] = 'payment';
$_GET['c'] = 'respond';

if (!empty($_POST)) {
    $_GET['a'] = 'notify';
} elseif (!empty($_GET)) {
    $_GET['a'] = 'response';
}
// $_GET['a'] = 'notify';//test测试notify打开注释

$_GET['code'] = 'pay_alipay';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . '../index.php';

// end