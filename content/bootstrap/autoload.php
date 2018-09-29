<?php

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

require SITE_ROOT . 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

$compiledPath = __DIR__.'/cache/compiled.php';

if (file_exists($compiledPath))
{
	require $compiledPath;
}


if (file_exists($classmap_file = __DIR__ . '/classmap.php'))
{
    $classmap = include $classmap_file;
    if (is_array($classmap)) {
        ComposerAutoloaderInit::getLoader()->addClassMap($classmap);
    }
}


$contentDir = realpath(__DIR__ . '/../');
$namespacemap = [
    'Ecjia\\System\\' => [$contentDir . '/system/classes'],
];
foreach ($namespacemap as $namespace => $path) {
    ComposerAutoloaderInit::getLoader()->setPsr4($namespace, $path);
}

if (PHP_VERSION_ID > 70100) {
    ComposerAutoloaderInit::getLoader()->setPsr4('Symfony\Component\VarDumper\\', VENDOR_DIR . '/symfony/var-dumper-php71');
}

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

Royalcms\Component\Support\ClassLoader::register();
