<?php

// autoload_classmap.php 

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Omnipay\\Omnipay' => $baseDir . '/omnipay/common/src/Omnipay/Omnipay.php',
);
