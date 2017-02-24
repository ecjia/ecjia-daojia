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
                        required: '不能为空',
                        min: '请输入大于0.01的数字',
                        max: '打款金额超出未付金额'
                    },
                    payee: {
                        required: '不能为空'
                    },
                    bank_account_number: {
                        required: '不能为空'
                    },
                    bank_name: {
                        required: '不能为空'
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