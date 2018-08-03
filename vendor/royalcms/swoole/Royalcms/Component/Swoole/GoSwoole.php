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

// $input = '{"svrConf":{"listen_ip":"127.0.0.1","listen_port":5200,"socket_type":1,"enable_gzip":false,"server":"RoyalcmsSwoole","handle_static":false,"base_path":"\/Users\/royalwang\/WorksPHP\/ecjia-cityo2o","inotify_reload":{"enable":false,"file_types":[".php"],"log":true},"websocket":{"enable":false},"sockets":[],"processes":[],"timer":{"enable":false,"jobs":[]},"events":[],"swoole_tables":[],"register_providers":[],"swoole":{"daemonize":true,"dispatch_mode":1,"reactor_num":8,"worker_num":8,"task_ipc_mode":3,"task_max_request":3000,"task_tmpdir":"\/tmp","message_queue_key":822358243,"max_request":3000,"open_tcp_nodelay":true,"pid_file":"\/Users\/royalwang\/WorksPHP\/ecjia-cityo2o\/content\/storages\/swoole.pid","log_file":"\/Users\/royalwang\/WorksPHP\/ecjia-cityo2o\/content\/storages\/logs\/swoole-2018-07-03.log","log_level":4,"document_root":"\/Users\/royalwang\/WorksPHP\/ecjia-cityo2o","buffer_output_size":16777216,"socket_buffer_size":134217728,"package_max_length":4194304,"reload_async":true,"max_wait_time":60,"enable_reuse_port":true,"user":"royalwang","group":"staff"},"process_prefix":"\/Users\/royalwang\/WorksPHP\/ecjia-cityo2o"},"royalcmsConf":{"root_path":"\/Users\/royalwang\/WorksPHP\/ecjia-cityo2o","static_path":"\/Users\/royalwang\/WorksPHP\/ecjia-cityo2o","register_providers":[],"_SERVER":{"TERM_SESSION_ID":"w0t2p0:A6832214-6480-4550-91CE-6509CDA5A05C","SSH_AUTH_SOCK":"\/private\/tmp\/com.apple.launchd.TnfKTJt894\/Listeners","Apple_PubSub_Socket_Render":"\/private\/tmp\/com.apple.launchd.g9sug33qSX\/Render","COLORFGBG":"15;0","ITERM_PROFILE":"Default","XPC_FLAGS":"0x0","PWD":"\/Users\/royalwang\/WorksPHP\/ecjia-cityo2o","SHELL":"\/usr\/local\/bin\/zsh","LC_CTYPE":"UTF-8","TERM_PROGRAM_VERSION":"3.1.6","TERM_PROGRAM":"iTerm.app","PATH":"\/usr\/local\/sbin:\/Users\/royalwang\/bin:\/usr\/local\/bin:\/usr\/local\/bin:\/usr\/bin:\/bin:\/usr\/sbin:\/sbin:\/opt\/X11\/bin","DISPLAY":"\/private\/tmp\/com.apple.launchd.3dHZMAvAXI\/org.macosforge.xquartz:0","COLORTERM":"truecolor","TERM":"xterm-256color","HOME":"\/Users\/royalwang","TMPDIR":"\/var\/folders\/19\/1ln8_y_j1c54v1h1ty41qqr00000gn\/T\/","USER":"royalwang","XPC_SERVICE_NAME":"0","LOGNAME":"royalwang","__CF_USER_TEXT_ENCODING":"0x1F5:0x0:0x0","ITERM_SESSION_ID":"w0t2p0:A6832214-6480-4550-91CE-6509CDA5A05C","SHLVL":"1","OLDPWD":"\/Users\/royalwang\/WorksPHP","CLICOLOR":"1","LSCOLORS":"Gxfxcxdxbxegedabagacad","ZSH":"\/Users\/royalwang\/.oh-my-zsh","PAGER":"less","LESS":"-R","AUTOJUMP_SOURCED":"1","AUTOJUMP_ERROR_PATH":"\/Users\/royalwang\/Library\/autojump\/errors.log","_":"\/usr\/local\/bin\/php","PHP_SELF":"ecjia","SCRIPT_NAME":"ecjia","SCRIPT_FILENAME":"ecjia","PATH_TRANSLATED":"ecjia","DOCUMENT_ROOT":"","REQUEST_TIME_FLOAT":1530551550.395009,"REQUEST_TIME":1530551550,"argv":["ecjia","swoole","start"],"argc":3,"HTTP_REFERER":"","SERVER_PROTOCOL":"HTTP\/1.0","HTTP_HOST":"","ROYALCMS_ENV":"local"},"_ENV":{"ROYALCMS_ENV":"local"}}}';

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