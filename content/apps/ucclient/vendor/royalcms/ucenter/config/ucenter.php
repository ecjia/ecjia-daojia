<?php

return [
    /**
     * 网站UCenter接受数据地址
     */
    'url'            => env('UC_URL', ''),
    
    /**
     * 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen()
     */
    'connect'        => env('UC_CONNECT', 'api'),
    
    /**
     * 与 UCenter 的通信密钥, 要与 UCenter 保持一致
     */
    'key'            => env('UC_KEY', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
    
    /**
     * UCenter 的 URL 地址, 在调用头像时依赖此常量
     */
    'api'            => env('UC_API', 'http://localhost/sites/uc'),
    
    /**
     * UCenter 的 IP, 当前应用服务器解析域名有问题时, 请设置此值
     */
    'ip'             => env('UC_IP', '127.0.0.1'),
    
    /**
     * UCenter 的字符集
     */
    'charset'        => env('UC_CHARSET', 'utf-8'),
    
    /**
     * 当前应用的 ID
     */
    'appid'          => env('UC_APPID', '1'),
    
    /**
     * 当前应用的 ID
     */
    'ppp'            => env('UC_PPP', '20'),
    
    'apifilename'    => env('UC_APIFILENAME', 'uc.php'),
    'service'        => env('UC_SERVICE', 'Royalcms\Component\Ucenter\Client\Services\Api'),
];
