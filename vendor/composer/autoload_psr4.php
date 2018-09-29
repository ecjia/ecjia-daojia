<?php

// autoload_psr4.php 

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Symfony\\Component\\Process\\' => array($vendorDir . '/symfony/process'),
    'Symfony\\Component\\HttpKernel\\' => array($vendorDir . '/symfony/http-kernel'),
    'Symfony\\Component\\HttpFoundation\\' => array($vendorDir . '/symfony/http-foundation'),
    'Symfony\\Component\\Finder\\' => array($vendorDir . '/symfony/finder'),
    'Symfony\\Component\\DomCrawler\\' => array($vendorDir . '/symfony/dom-crawler'),
    'Symfony\\Component\\CssSelector\\' => array($vendorDir . '/symfony/css-selector'),
    'Symfony\\Component\\Console\\' => array($vendorDir . '/symfony/console'),
    'Symfony\\Component\\Debug\\' => array($vendorDir . '/symfony/debug'),
    'Symfony\\Component\\EventDispatcher\\' => array($vendorDir . '/symfony/event-dispatcher'),
    'Symfony\\Component\\Yaml\\' => array($vendorDir . '/symfony/yaml'),
    'Symfony\\Component\\Routing\\' => array($vendorDir . '/symfony/routing'),
    'Symfony\\Component\\Translation\\' => array($vendorDir . '/symfony/translation'),
    'Symfony\\Component\\Filesystem\\' => array($vendorDir . '/symfony/filesystem'),
    'Symfony\\Component\\VarDumper\\' => array($vendorDir . '/symfony/var-dumper'),
    'Symfony\\Polyfill\\Mbstring\\' => array($vendorDir . '/symfony/polyfill-mbstring'),
    'Symfony\\Polyfill\\Php56\\' => array($vendorDir . '/symfony/polyfill-php56'),
    'Symfony\\Polyfill\\Php72\\' => array($vendorDir . '/symfony/polyfill-php72'),
    'Symfony\\Polyfill\\Util\\' => array($vendorDir . '/symfony/polyfill-util'),
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
    'phpseclib\\' => array($vendorDir . '/phpseclib/phpseclib/phpseclib'),
    'League\\Flysystem\\' => array($vendorDir . '/league/flysystem/src'),
    'League\\CommonMark\\' => array($vendorDir . '/league/commonmark/src'),
    'ClassPreloader\\' => array($vendorDir . '/classpreloader/classpreloader/src'),
    'PhpParser\\' => array($vendorDir . '/nikic/php-parser/lib/PhpParser'),
    'Doctrine\\Instantiator\\' => array($vendorDir . '/doctrine/instantiator/src/Doctrine/Instantiator'),
    'Carbon\\' => array($vendorDir . '/nesbot/carbon/src/Carbon'),
    'XdgBaseDir\\' => array($vendorDir . '/dnoegel/php-xdg-base-dir/src'),
    'Stringy\\' => array($vendorDir . '/danielstjules/stringy/src'),
    'Faker\\' => array($vendorDir . '/fzaninotto/faker/src/Faker'),
    'SuperClosure\\' => array($vendorDir . '/jeremeamia/SuperClosure/src'),
    'phpDocumentor\\Reflection\\' => array($vendorDir . '/phpdocumentor/reflection-common/src', $vendorDir . '/phpdocumentor/type-resolver/src', $vendorDir . '/phpdocumentor/reflection-docblock/src'),
    'Webmozart\\Assert\\' => array($vendorDir . '/webmozart/assert/src'),
    'Psy\\' => array($vendorDir . '/psy/psysh/src/Psy'),
    'cebe\\markdown\\' => array($vendorDir . '/cebe/markdown'),

);
