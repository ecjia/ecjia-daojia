<?php

use Royalcms\Component\ClassLoader\ClassManager;


/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

//royalcms
require VENDOR_DIR . '/royalcms/framework/royalcms.php';
//helpers
require VENDOR_DIR . '/royalcms/framework/src/Royalcms/Component/Foundation/Helpers/royalcms-hooks.php';
require VENDOR_DIR . '/royalcms/framework/src/Royalcms/Component/Foundation/Helpers/foundation-helpers.php';
//vendor
require VENDOR_DIR . '/autoload.php';

// 判断PHP最低版本
if (version_compare(PHP_VERSION, Royalcms\Component\Foundation\RoyalcmsConstant::PHP_REQUIRED, '<')) {
    header($_SERVER['SERVER_PROTOCOL'] . " 500 " . PHP_VERSION);
    echo 'Current PHP Version: ' . PHP_VERSION . ', Required Version: ' . Royalcms\Component\Foundation\RoyalcmsConstant::PHP_REQUIRED;
    exit();
}


date_default_timezone_set('PRC');
setlocale(LC_ALL, 'C');


/*
|--------------------------------------------------------------------------
| Register The Royalcms Auto Loader
|--------------------------------------------------------------------------
|
| We register an auto-loader "behind" the Composer loader that can load
| model classes on the fly, even if the autoload files have not been
| regenerated for the application. We'll add it to the stack here.
|
*/

ClassManager::register();
\Royalcms\Component\ClassLoader\ClassLoader::register();
\Royalcms\Component\Foundation\AliasLoader::getInstance()->register();

if (file_exists($aliasPath = __DIR__ . '/cache/aliases.php')) {
    \Royalcms\Component\Foundation\AliasLoader::getInstance(require $aliasPath)->register();
}

if (file_exists($classmap_file = __DIR__ . '/classmap.php')) {
    $classmap = include $classmap_file;
    if (is_array($classmap)) {
        ClassManager::getLoader()->addClassMap($classmap);
    }
}

if (file_exists($aliasPath = __DIR__ . '/classalias.php')) {
    \Royalcms\Component\Foundation\AliasLoader::getInstance(require $aliasPath)->register();
}


/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize:compile" is used to create this file.
|
*/

$compiledPath = __DIR__ . '/cache/compiled.php';

if (file_exists($compiledPath)) {
    require $compiledPath;
}

