<?php

return [
    'shouqianba' => [
        // 收钱吧分配的 APPID
        'app_id' => env('SHOUQIANBA_APP_ID', ''),

        // 服务商序列号/vendor_sn:服务商序列号
        'vendor_sn' => env('SHOUQIANBA_VENDOR_SN', ''),

        // 服务商密钥/vendor_key:服务商密钥
        'vendor_key' => env('SHOUQIANBA_VENDOR_KEY', ''),


        // 收钱吧异步通知地址
        'notify_url' => '',

        // 支付成功后同步通知地址
        'return_url' => '',

        // 终端号/terminal_sn:终端序列号
        'terminal_sn' => env('SHOUQIANBA_TERMINAL_SN', ''),

        // 终端密钥/terminal_key:终端密钥，支付类接口使用终端序列号和终端密钥进行签名
        'terminal_key' => env('SHOUQIANBA_TERMINAL_KEY', ''),

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/royalcms-pay.log'
        'log' => [
            'file' => storage_path('logs/shouqianba.log'),
        //  'level' => 'debug'
        //  'type' => 'single', // optional, 可选 daily.
        //  'max_file' => 30,
        ],

        // optional，设置此参数，将进入沙箱模式
        // 'mode' => 'dev',
    ],

];
