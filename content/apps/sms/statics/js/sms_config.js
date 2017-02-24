// JavaScript Document
;(function (app, $) {
    app.sms_config = {
        init: function () {
 
        }
    };
 
    app.sms_config_edit = {
        init: function () {
            app.sms_config_edit.check_balance();
            app.sms_config_edit.submit_form();
        },
 
        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    sms_user_name: {
                        required: true
                    },
                    sms_password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    sms_user_name: {
                        required: js_lang.sms_user_name_required
                    },
                    sms_password: {
                        required: js_lang.sms_password_required,
                        minlength: js_lang.sms_password_minlength
                    }
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
 
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $form.validate(options);
        },
 
        check_balance: function () {
            $('.check').on('click', function () {
                var checkURL = $('.checkaction').attr('data-url');
                $.get(checkURL, function (data) {
                    app.sms_config_edit.load_balance_opt(data);
                    ecjia.admin.showmessage(data);
                }, "JSON");
            })
        },
 
        load_balance_opt: function (data) {
            var html = data.content;
            $('.balance').html(html);
        }
    };
 
})(ecjia.admin, jQuery);
 
// end