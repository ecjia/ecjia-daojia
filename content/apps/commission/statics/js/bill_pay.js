// JavaScript Document
;(function (app, $) {
    app.bill_pay = {
        init: function () {
            app.bill_pay.submit_form();
        },
 
        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                	pay_amount: {
                        required: true,
                        min: 0.01,
                        max: MAX_AMOUNT
                    },
                    payee: {
                        required: true
                    },
                    bank_account_number: {
                        required: true
                    },
                    bank_name: {
                        required: true
                    }
                },
                messages: {
                	pay_amount: {
                        required: jslang.canot_empty,
                        min: jslang.input_more_than_001,
                        max: jslang.pay_more_than_unpay_money
                    },
                    payee: {
                        required: jslang.canot_empty
                    },
                    bank_account_number: {
                        required: jslang.canot_empty
                    },
                    bank_name: {
                        required: jslang.canot_empty
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
    }
})(ecjia.admin, jQuery);
 
// end