// JavaScript Document
;(function (app, $) {
    app.payment_list = {
        /* 支付方式编辑form提交 */
        submit: function () {
            $('.switch').on('click', function (e) {
                var url = $(this).attr('data-url');
            	$.get(url, function(data) {
            		ecjia.admin.showmessage(data);
            	});
            });
            
            var $form = $('form[name="editForm"]');
            /* 给表单加入submit事件 */
            var option = {
                rules: {
                    pay_name: {
                        required: true,
                        minlength: 3
                    },
                    pay_desc: {
                        required: true,
                        minlength: 6
                    },
                },
                messages: {
                    pay_name: {
                        required: js_lang.pay_name_required,
                        minlength: js_lang.pay_name_minlength,
                    },
                    pay_desc: {
                        required: js_lang.pay_desc_required,
                        minlength: js_lang.pay_desc_minlength,
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

        init: function () {
            $("form[name='searchForm']").on('submit', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var pay_status = $("select[name='pay_status']").val();
                var order_sn = $("input[name='order_sn']").val();
                var keywords = $("input[name='keywords']").val();

                if (pay_status != 0) {
                	url += '&pay_status=' + pay_status;
                }
                if (order_sn != '') {
                    url += '&order_sn=' + order_sn;
                }
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        },

        list: function () {
            /* 配送方式关闭与启用 */
            $('.switch').on('click', function (e) {
                var url = $(this).attr('data-url');
            	$.get(url, function(data) {
            		ecjia.admin.showmessage(data);
            	});
            });
        },
    };
 
})(ecjia.admin, jQuery);
 
//end