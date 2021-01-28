<?php


namespace Ecjia\App\Installer\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;
use RC_Script;

class InstallStartEvent implements BrowserEventInterface
{

    public function __construct()
    {
        RC_Script::enqueue('ecjia-middleware');
        RC_Script::enqueue('js-sprintf');
    }

    public function __invoke()
    {
        $ecjia_lang = [
            'database_host_name'                        => __('请输入数据库主机名称', 'installer'),
            'database_port_number'                      => __('请输入数据库端口号', 'installer'),
            'database_username'                         => __('请输入数据库用户名', 'installer'),
            'database_name'                             => __('请输入数据库名称', 'installer'),
            'database_prefix'                           => __('请输入数据库前缀', 'installer'),
            'administrator_name'                        => __('请输入管理员名称', 'installer'),
            'administrator_login_password'              => __('请输入管理员登录密码', 'installer'),
            'administrator_login_confirmation_password' => __('请输入管理员登录确认密码', 'installer'),
            'administrator_email'                       => __('请输入管理员电子邮箱', 'installer'),
            'email_format'                              => __('请输入正确的email格式', 'installer'),
        ];

        $ecjia_lang = json_encode($ecjia_lang);

        return <<<JS
(function () {
    
    $('#ecjia_install').click(function() {
        
        let ecjia_lang = {$ecjia_lang};
        
        let db_host = $('#db_host').val();
        let db_port = $('#db_port').val();
        let db_user = $('#db_user').val();
        let db_password = $('#db_password').val();
        let db_database = $('#db_database').val();
        let db_prefix = $('#db_prefix').val();
        let user_name = $('#user_name').val();
        let user_password = $('#user_password').val();
        let user_confirm_password = $('#user_confirm_password').val();
        let user_mail = $('#user_mail').val();
        let is_create = $('input[name="is_create"]').val();
    
        if ($.trim(db_host) === '') {
            ecjia.front.install.showmessage('db_host', ecjia_lang.database_host_name);
            return false;
        }
        if ($.trim(db_port) === '') {
            ecjia.front.install.showmessage('db_port', ecjia_lang.database_port_number);
            return false;
        }
        if ($.trim(db_user) === '') {
            ecjia.front.install.showmessage('db_user', ecjia_lang.database_username);
            return false;
        }
        if ($.trim(db_database) === '') {
            ecjia.front.install.showmessage('db_database', ecjia_lang.database_name);
            return false;
        }
        if ($.trim(db_prefix) === '') {
            ecjia.front.install.showmessage('db_prefix', ecjia_lang.database_prefix);
            return false;
        }
        if ($.trim(user_name) === '') {
            ecjia.front.install.showmessage('user_name', ecjia_lang.administrator_name);
            return false;
        }
        if ($.trim(user_password) === '') {
            ecjia.front.install.showmessage('user_password', ecjia_lang.administrator_login_password);
            return false;
        }
        if ($.trim(user_confirm_password) === '') {
            ecjia.front.install.showmessage('user_confirm_password', ecjia_lang.administrator_login_confirmation_password);
            return false;
        }
        let reg = /\w+[@]{1}\w+[.]\w+/;
        if ($.trim(user_mail) === '') {
            ecjia.front.install.showmessage('user_mail', ecjia_lang.administrator_email);
            return false;
        } else if (!reg.test(user_mail)) {
            ecjia.front.install.showmessage('user_mail', ecjia_lang.email_format);
            return false;
        }
        
        let middleware = ecjia.middleware();
        middleware.use(ecjia.front.task.checkDatabasePasswordCorrectTask);
        middleware.use(ecjia.front.task.checkDatabaseExistsTask);
        middleware.use(ecjia.front.task.checkAdminPasswordTask);
        middleware.use(ecjia.front.task.installStartTask);
        middleware.use(ecjia.front.task.createConfigFileTask);
        middleware.use(ecjia.front.task.createDatabaseTask);
        middleware.use(ecjia.front.task.installStructureTask);
        middleware.use(ecjia.front.task.installBaseDataTask);
        middleware.use(ecjia.front.task.installDemoDataTask);
        middleware.use(ecjia.front.task.createAdminPassportTask);
        middleware.use(ecjia.front.task.installFinishTask);
        middleware.handleRequest();
    });
    
    
})();
JS;

    }

}