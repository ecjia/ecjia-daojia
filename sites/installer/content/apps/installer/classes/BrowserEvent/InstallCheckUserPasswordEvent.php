<?php


namespace Ecjia\App\Installer\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;

class InstallCheckUserPasswordEvent implements BrowserEventInterface
{


    public function __invoke()
    {

        $password_length = __('密码长度不能小于8', 'installer');
        $password_letters_numbers = __('密码必须同时包含字母及数字', 'installer');
        $passwords_different = __('密码不相同', 'installer');

        return <<<JS
(function () {
    
    let ecjia_lang = {
        password_length: "{$password_length}",
        password_letters_numbers: "{$password_letters_numbers}",
        passwords_different: "{$passwords_different}"
    }

    //用户名密码验证
    $('#user_password').blur(function() {
        let password = $('#user_password').val();
        let confirm_password = $('#user_confirm_password').val();
        let password_error_el = $('.password-error');
        if (!(password.length >= 8 && /\d+/.test(password) && /[a-zA-Z]+/.test(password))) {
            $("#ecjia_install").prop("disabled", "true");
            if (!(password.length >= 8)) {
                password_error_el.html(ecjia_lang.password_length);
            } else {
                password_error_el.html(ecjia_lang.password_letters_numbers);
            }
        } else {
            password_error_el.html('');
            if (password === confirm_password) {
                $("#ecjia_install").prop("disabled", false);
                $('.confirm-password-error').html('');
            } else {
                $("#ecjia_install").prop("disabled", "true");
                if (confirm_password !== '') {
                    password_error_el.html(ecjia_lang.passwords_different);
                }
            }
        }
    });

    //确认用户名密码验证
    $('#user_confirm_password').blur(function() {
        var password = $('#user_password').val();
        var confirm_password = $('#user_confirm_password').val();

        if (!(confirm_password.length >= 8 && /\d+/.test(confirm_password) &&
            /[a-zA-Z]+/.test(confirm_password) && 
            password === confirm_password)) {
            $("#ecjia_install").prop("disabled", "true");

            if (!(confirm_password.length >= 8)) {
                $('.confirm-password-error').html(ecjia_lang.password_length);
            } else {
                if (password === confirm_password) {
                    $('.confirm-password-error').html(ecjia_lang.password_letters_numbers);
                } else {
                    $('.confirm-password-error').html(ecjia_lang.passwords_different);
                }
            }
        } else {
            $("#ecjia_install").prop("disabled", false);
            $('.confirm-password-error').html('');
            $('.password-error').html('');
        }
    });
    
})();
JS;

    }

}