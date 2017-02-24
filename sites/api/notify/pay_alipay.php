<?php
$_GET['m'] = 'payment';
$_GET['c'] = 'respond';

if (!empty($_POST)) {
    $_GET['a'] = 'notify';
} elseif (!empty($_GET)) {
    $_GET['a'] = 'response';
}

$_GET['code'] = 'pay_alipay';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . '../index.php';

// end