<?php

// autoload_files.php 

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    $vendorDir . '/royalcms/framework/royalcms.php',
    $vendorDir . '/swiftmailer/swiftmailer/lib/swift_required.php',
    $vendorDir . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    $vendorDir . '/guzzlehttp/psr7/src/functions_include.php',
    $vendorDir . '/guzzlehttp/guzzle/src/functions_include.php',
    $vendorDir . '/guzzlehttp/promises/src/functions_include.php',
    $vendorDir . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
    $vendorDir . '/symfony/polyfill-mbstring/bootstrap.php',
    $vendorDir . '/hamcrest/hamcrest-php/hamcrest/Hamcrest.php',
    $vendorDir . '/symfony/var-dumper/Resources/functions/dump.php',
    $vendorDir . '/symfony/polyfill-php56/bootstrap.php',
    $vendorDir . '/symfony/polyfill-php72/bootstrap.php',
    $vendorDir . '/paragonie/random_compat/lib/random.php',
    $vendorDir . '/danielstjules/stringy/src/Create.php',

);
