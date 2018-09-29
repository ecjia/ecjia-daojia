<?php

define('IN_ECJIA', true);

// 站点根目录
if (!defined('SITE_ROOT')) define('SITE_ROOT', dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . DIRECTORY_SEPARATOR);

// 判断PHP最低版本
if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    echo 'Current PHP Version: ' . PHP_VERSION . ', Required Version: 7.0.0';
    exit(0);
}

$input = file_get_contents('php://stdin');

$cfg = json_decode($input, true);

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . substr(str_replace('\\', '/', $class), 26) . '.php';
    
    if (is_readable($file)) {
        require $file;
        return true;
    }
    return false;
});

(new Royalcms\Component\Swoole\RoyalcmsSwoole($cfg['svrConf'], $cfg['royalcmsConf']))->run();