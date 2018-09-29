<?php

return [
    /*
     * string
     * 监听的IP，监听本机127.0.0.1(IPv4) ::1(IPv6)，监听所有地址 0.0.0.0(IPv4) ::(IPv6)， 默认127.0.0.1。
     */
    'listen_ip'          => env('SWOOLE_LISTEN_IP', '127.0.0.1'),
    
    /*
     * int
     * 监听的端口，如果端口小于1024则需要root权限，default 5200。
     */
    'listen_port'        => env('SWOOLE_LISTEN_PORT', 5200),
    
    /*
     * 默认SWOOLE_SOCK_TCP。通常情况下，无需关心这个配置。
     * 若需Nginx代理至UnixSocket Stream文件，则需修改为SWOOLE_SOCK_UNIX_STREAM，此时listen_ip则是UnixSocket Stream文件的路径。
     */
    'socket_type'        => env('SWOOLE_SOCKET_TYPE', defined('SWOOLE_SOCK_TCP') ? \SWOOLE_SOCK_TCP : 1),
    
    /*
     * bool
     * 当通过RoyalcmsSwoole响应数据时，是否启用gzip压缩响应的内容，依赖库zlib，通过命令php --ri swoole|grep zlib检查gzip是否可用。
     * 如果开启则会自动加上头部Content-Encoding，默认false。
     * 如果存在代理服务器（例如Nginx），建议代理服务器开启gzip，RoyalcmsSwoole关闭gzip，避免重复gzip压缩。
     */
    'enable_gzip'        => env('SWOOLE_ENABLE_GZIP', false),
    
    /*
     * string
     * 当通过RoyalcmsSwoole响应数据时，设置HTTP头部Server的值，若为空则不设置，default RoyalcmsSwoole。
     */
    'server'             => env('SWOOLE_SERVER', 'RoyalcmsSwoole'),
    
    /*
     * bool
     * 是否开启RoyalcmsSwoole处理静态资源(要求 Swoole >= 1.7.21，若Swoole >= 1.9.17则由Swoole自己处理)，默认false，建议Nginx处理静态资源，RoyalcmsSwoole仅处理动态资源。
     * 静态资源的默认路径为base_path('public')，可通过修改swoole.document_root变更。
     */
    'handle_static'      => env('SWOOLE_HANDLE_STATIC', true),
    
    /*
     * string
     * Royalcms的基础路径，默认base_path()，可用于配置符号链接。
     */
    'base_path'          => env('SWOOLE_BASE_PATH', base_path()),
    
    /*
     * array
     */
    'inotify_reload'     => [
        /*
         * bool
         * 是否开启Inotify Reload，用于当修改代码后实时Reload所有worker进程，依赖库inotify，
         * 通过命令php --ri inotify检查是否可用，默认false，建议仅开发环境开启，修改监听数上限。
         */
        'enable'     => env('SWOOLE_INOTIFY_RELOAD', false),

        'watch_path' => base_path(),
        
        /*
         * array
         * Inotify 监控的文件类型，默认有.php。
         */
        'file_types' => ['.php'],
        
        /*
         * bool
         * 是否输出Reload的日志，默认true。
         */
        'log'        => true,
    ],
    'websocket'          => [
        /*
         * bool
         * 是否启用WebSocket服务器。启用后WebSocket服务器监听的IP和端口与Http服务器相同，默认false。
         */
        'enable' => false,
        
        /*
         * string 
         * WebSocket逻辑处理的类名，需实现接口WebSocketHandlerInterface，参考示例
         */
        //'handler' => XxxWebSocketHandler::class,
    ],
    
    /*
     * array
     * 配置TCP/UDP套接字列表，参考示例
     */
    'sockets'            => [
    ],
    
    /*
     * array
     * 配置自定义进程列表，参考示例
     */
    'processes'          => [
    ],
    
    /*
     * array
     */
    'timer'              => [
        'enable' => false,
        'jobs'   => [
            // Enable SwooleScheduleJob to run `php artisan schedule:run` every 1 minute, replace Linux Crontab
            //\Royalcms\Component\Swoole\SwooleScheduleJob::class,
            //XxxCronJob::class,
        ],
    ],
    
    /*
     * array
     * 自定义的异步事件和监听的绑定列表，参考示例
     */
    'events'             => [
    ],
    
    /*
     * array
     * 定义的swoole_table列表，参考示例
     */
    'swoole_tables'      => [
    ],
    
    /*
     * array
     * 每次请求需要重新注册的Service Provider列表，若存在boot()方法，会自动执行。一般用于清理注册了单例的ServiceProvider。
     */
    'register_providers' => [
    ],
    
    /*
     * array
     * 请参考Swoole配置项
     */
    'swoole'             => [
        'daemonize'          => env('SWOOLE_DAEMONIZE', true),
        'dispatch_mode'      => 1,
        'reactor_num'        => function_exists('\swoole_cpu_num') ? \swoole_cpu_num() * 2 : 4,
        'worker_num'         => function_exists('\swoole_cpu_num') ? \swoole_cpu_num() * 2 : 8,
        //'task_worker_num'   => function_exists('\swoole_cpu_num') ? \swoole_cpu_num() * 2 : 8,
        'task_ipc_mode'      => 1,
        'task_max_request'   => 5000,
        'task_tmpdir'        => @is_writable('/dev/shm/') ? '/dev/shm' : '/tmp',
        'message_queue_key'  => ftok(base_path('index.php'), 1),
        'max_request'        => 3000,
        'open_tcp_nodelay'   => true,
        'pid_file'           => storage_path('swoole.pid'),
        'log_file'           => storage_path(sprintf('logs/swoole-%s.log', date('Y-m-d'))),
        'log_level'          => 4,
        'document_root'      => base_path(),
        'buffer_output_size' => 16 * 1024 * 1024,
        'socket_buffer_size' => 128 * 1024 * 1024,
        'package_max_length' => 4 * 1024 * 1024,
        'reload_async'       => true,
        'max_wait_time'      => 60,
        'enable_reuse_port'  => true,

        'user'               => 'royalwang',
        'group'              => 'staff',

        /**
         * More settings of Swoole
         * @see https://wiki.swoole.com/wiki/page/274.html  Chinese
         * @see https://www.swoole.co.uk/docs/modules/swoole-server/configuration  English
         */
    ],
];
