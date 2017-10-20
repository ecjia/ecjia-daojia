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
                        required: '规则描述不能为空',
                    },
                    quickpay_fee: {
                        required: '收款手续费不能为空',
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