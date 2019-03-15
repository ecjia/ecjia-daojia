// JavaScript Document
;
(function(app, $) {
    app.shipping_config = {
        init: function() {
            app.shipping_config.submit_form();
        },
        submit_form: function(formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    express_key: {
                        required: true
                    },
                    express_secret: {
                        required: true
                    }
                },
                messages: {
                    express_key: {
                        required: js_lang.required_express_key,
                    },
                    express_secret: {
                        required: js_lang.required_express_secret,
                    }
                },
                submitHandler: function() {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function(data) {
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
// end