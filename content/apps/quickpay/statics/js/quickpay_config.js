// JavaScript Document
;(function (app, $) {
    app.quickpay_config = {
        init: function () {

            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                	quickpay_rule: {
                        required: true,
                    },
                    quickpay_fee: {
                        required: true,
                    }
                },
                messages: {
                	quickpay_rule: {
                        required: js_lang.quickpay_rule_required,
                    },
                    quickpay_fee: {
                        required: js_lang.quickpay_fee_required,
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
        }
    };
})(ecjia.admin, jQuery);
 
// end