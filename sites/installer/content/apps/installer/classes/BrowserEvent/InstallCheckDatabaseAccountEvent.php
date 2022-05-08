<?php


namespace Ecjia\App\Installer\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;
use RC_Script;

class InstallCheckDatabaseAccountEvent implements BrowserEventInterface
{

    public function __construct()
    {
        RC_Script::enqueue_script('smoke');
    }

    public function __invoke()
    {
        $ok = __('确定', 'installer');

        return <<<JS
(function () {
    
    //检查数据库账号密码是否正确，数据库版本是否小于5.5
    $('#db_password').blur(function() {
        let ecjia_lang = {
            ok: "{$ok}"
        }
        
        let params = {
            db_host: $("#db_host").val(),
            db_port: $("#db_port").val(),
            db_user: $("#db_user").val(),
            db_pass: $("#db_password").val(),
            db_database: $('#db_database').val(),
            db_prefix: $('#db_prefix').val()
        };
        let url = $('.check_db_correct').attr('data-url');
        $.ajax({
            type: 'post',
            url: url,
            data: params,
            async: false,
            success: function(result) {
                if (result.state === 'error') {
                    $('input[name="database_config"]').val(0); //数据库账号密码错误
                    smoke.alert(result.message, {
                        ok: ecjia_lang.ok
                    });
                    return false;
                } else if (result.state === 'success') {
                    $('input[name="database_config"]').val(1); //数据库账号密码正确
                }
            }
        });
    });
    
})();
JS;
    }

}