// JavaScript Document
;
(function (app, $) {
    app.admin_plugin = {
        init: function () {
            $('.switch').on('click', function (e) {
                var url = $(this).attr('data-url');
                $.get(url, function (data) {
                    ecjia.admin.showmessage(data);
                });
            });
        },

        submit: function () {
            $('.switch').on('click', function (e) {
                var url = $(this).attr('data-url');
                $.get(url, function (data) {
                    ecjia.admin.showmessage(data);
                });
            });

            var $form = $('form[name="editForm"]');
            /* 给表单加入submit事件 */
            var option = {
                rules: {
                    withdraw_name: {
                        required: true,
                        minlength: 3
                    },
                    withdraw_desc: {
                        required: true,
                        minlength: 6
                    },
                },
                messages: {
                    withdraw_name: {
                        required: js_lang.withdraw_name_required,
                        minlength: js_lang.withdraw_name_minlength,
                    },
                    withdraw_desc: {
                        required: js_lang.withdraw_desc_required,
                        minlength: js_lang.withdraw_desc_minlength,
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
    };

})(ecjia.admin, jQuery);

//end