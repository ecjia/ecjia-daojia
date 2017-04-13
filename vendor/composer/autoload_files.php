<?php

// autoload_files.php 

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    $vendorDir . '/royalcms/framework/royalcms.php',
    $vendorDir . '/swiftmailer/swiftmailer/lib/swift_required.php',
    $vendorDir . '/phpseclib/phpseclib/phpseclib/Crypt/Random.php',
    $vendorDir . '/guzzlehttp/psr7/src/functions_include.php',
    $vendorDir . '/guzzlehttp/guzzle/src/functions_include.php',
    $vendorDir . '/guzzlehttp/promises/src/functions_include.php',
    $vendorDir . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
);
