<?php


namespace Ecjia\App\Installer\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;
use RC_Script;

class InstallCheckDatabaseExistsEvent implements BrowserEventInterface
{

    public function __construct()
    {
        RC_Script::enqueue_script('smoke');
    }

    public function __invoke()
    {
        $ok     = __('确定', 'installer');
        $cancel = __('取消', 'installer');
        $database_name_already_exists = __('该数据库名称已存在，确定要覆盖该数据库信息吗？', 'installer');

        return <<<JS
(function () {
    
    //检查数据库是否存在
    $('#db_database').blur(function() {
        let ecjia_lang = {
            ok: "{$ok}",
            cancel: "{$cancel}",
            database_name_already_exists: "{$database_name_already_exists}"
        }
        
        let params = {
            db_host: $("#db_host").val(),
            db_port: $("#db_port").val(),
            db_user: $("#db_user").val(),
            db_pass: $("#db_password").val(),
            db_database: $('#db_database').val(),
            db_prefix: $('#db_prefix').val()
        };
        let url = $('.check_db_exists').attr('data-url');
        $.ajax({
            type: 'post',
            url: url,
            data: params,
            async: false,
            success: function(result) {
                if (parseInt(result.db_is_exist) === 1) {
                    smoke.confirm(ecjia_lang.database_name_already_exists, function(event) {
                        if (event) {
                            $('input[name="is_create"]').val(0); //不创建数据库
                        } else {
                            $('#db_database').val(params.db_database).focus();
                            $('input[name="is_create"]').val(1); //创建数据库
                        }
                    }, {
                        ok: ecjia_lang.ok,
                        cancel: ecjia_lang.cancel
                    });
                } else {
                    $('input[name="is_create"]').val(1); //创建数据库
                }
            }
        });
    });
    
})();
JS;
    }

}