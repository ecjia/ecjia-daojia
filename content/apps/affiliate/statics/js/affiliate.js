11 // JavaScript Document
;
(function (app, $) {
    app.affiliate = {
        init: function () {
            app.affiliate.submit_form();
            app.affiliate.screen_click();
            app.affiliate.search_order();
            app.affiliate.change_type();
        },

        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
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

        screen_click: function () {
            $('.screen-btn').off('click').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='search_from']").attr('action');
                var status = $("select[name='status']").val();
                if (status != '') {
                    url += '&status=' + status;
                }

                var order_sn = $("input[name='order_sn']").val();
                if (order_sn != '') {
                    url += '&order_sn=' + order_sn;
                }

                ecjia.pjax(url);
            });
        },

        search_order: function () {
            $('.search_order').off('click').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='search_from']").attr('action');
                var status = $("select[name='status']").val();
                if (status != '') {
                    url += '&status=' + status;
                }

                var order_sn = $("input[name='order_sn']").val();
                if (order_sn != '') {
                    url += '&order_sn=' + order_sn;
                }
                ecjia.pjax(url);
            });
        },

        change_type: function() {
            $('input[name="intive_reward_type"]').off('click').on('click', function (e) {
                var $this = $(this),
                    val = $this.val();
                $('.intive_reward_type').addClass('ecjiaf-dn');
                $('.intive_reward_type_'+val).removeClass('ecjiaf-dn');
            });

            $('input[name="intivee_reward_type"]').off('click').on('click', function (e) {
                var $this = $(this),
                    val = $this.val();
                $('.intivee_reward_type').addClass('ecjiaf-dn');
                $('.intivee_reward_type_'+val).removeClass('ecjiaf-dn');
            });
        },

        info: function () {
            app.affiliate.percent_form();
        },

        percent_form: function () {
            var $form = $("form[name='percent_form']");
            var option = {
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