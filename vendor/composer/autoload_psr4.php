<?php

// autoload_psr4.php 

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Symfony\\Component\\Filesystem\\' => array($vendorDir . '/symfony/filesystem'),
    'Symfony\\Polyfill\\Mbstring\\' => array($vendorDir . '/symfony/polyfill-mbstring'),
    'Symfony\\Component\\VarDumper\\' => array($vendorDir . '/symfony/var-dumper'),
    'TijsVerkoyen\\CssToInlineStyles\\' => array($vendorDir . '/tijsverkoyen/css-to-inline-styles/src'),
    'Predis\\' => array($vendorDir . '/predis/predis/src'),
    'Hashids\\' => array($vendorDir . '/hashids/hashids/lib/Hashids'),
    'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-message/src'),
    'GuzzleHttp\\' => array($vendorDir . '/guzzlehttp/guzzle/src'),
    'GuzzleHttp\\Psr7\\' => array($vendorDir . '/guzzlehttp/psr7/src'),
    'GuzzleHttp\\Promise\\' => array($vendorDir . '/guzzlehttp/promises/src'),
    'Omnipay\\GlobalAlipay\\' => array($vendorDir . '/omnipay/global-alipay/src'),
    'Omnipay\\WechatPay\\' => array($vendorDir . '/omnipay/wechatpay/src'),
    'Omnipay\\UnionPay\\' => array($vendorDir . '/omnipay/unionpay/src'),
    'Omnipay\\Alipay\\' => array($vendorDir . '/omnipay/alipay/src'),
);
