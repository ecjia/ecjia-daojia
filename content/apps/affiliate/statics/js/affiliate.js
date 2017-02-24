// JavaScript Document
;(function (app, $) {
    app.affiliate = {
        init: function () {
            app.affiliate.affiliate_form();
            app.affiliate.theForm();
            app.affiliate.search();
            app.affiliate.toggle_view();
            app.affiliate.trigger();
            app.affiliate.invite_reward();
            app.affiliate.invitee_reward();
        },
        
        theForm: function () {
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
        
        affiliate_form: function () {
        	$(".add_affiliate").on('click', function(e) {
        		e.preventDefault();
        		var url = $("form[name='affiliate_form']").attr('action');
        		var level_point = $("input[name='level_point']").val();
        		var level_money = $("input[name='level_money']").val();
        		$.ajax({
					type: "POST",
					url: url,
					data: {
						level_money : level_money,
						level_point : level_point,
					},
					dataType: "json",
					success: function (data) {
						ecjia.admin.showmessage(data);
					}
        		});
        	});
        },
        
        invite_reward : function () {
        	$("input[name='intive_reward_type']").on('change', function(e) {
        		$('.intive_reward_type').addClass('ecjiaf-dn');
        		$('.intive_reward_type_'+$(this).val()).removeClass('ecjiaf-dn');
        	});
        },
        invitee_reward : function () {
        	$("input[name='intivee_reward_type']").on('change', function(e) {
        		$('.intivee_reward_type').addClass('ecjiaf-dn');
        		$('.intivee_reward_type_'+$(this).val()).removeClass('ecjiaf-dn');
        	});
        },
        
        search: function () {
            $(".screen-btn").on('click', function (e) {
                e.preventDefault();
                var status = $("select option:selected").val();
                var url = $("form[name='search_from']").attr('action');
                if (!status) {
                    ecjia.pjax(url);
                } else {
                    ecjia.pjax(url + '&status=' + status);
                }
            });
            $("form[name='search_from']").on('submit', function (e) {
                e.preventDefault();
                var order_sn = $("input[name='order_sn']").val();
                var url = $("form[name='search_from']").attr('action');
                if (!order_sn) {
                    ecjia.pjax(url);
                } else {
                    ecjia.pjax(url + '&order_sn=' + order_sn);
                }
            });
        },
 
        toggle_view: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var href = $this.attr('href');
                var val = $this.attr('data-val') || 'allow';
                var option = {
                    href: href,
                    val: val
                };
                var url = option.href;
                var val = {
                    change: option.val
                };
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.get(url, val, function (data) {
                                var url = $this.attr("data-pjax-url");
                                ecjia.pjax(url, function () {
                                    ecjia.admin.showmessage(data);
                                });
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.get(url, val, function (data) {
                        var url = $this.attr("data-pjax-url");
                        ecjia.pjax(url, function () {
                            ecjia.admin.showmessage(data);
                        });
                    }, 'json');
                }
            });
        },
        
        trigger: function () {
            var $form = $('form[name="theForm"]');
            var separate_by = $form.find($('input[name="separate_by"]'));
            var input_text = $form.find($('input[type="text"]'));
            var select = $form.find($('select[name="expire_unit"]'));
            var level = $('form[name="affiliate_form"]').find($('input[type="text"]'));
 
            $(document).on('click', 'input[name="on"]', function (e) {
                if ($("input[name='on']:checked").val() == '1') {
                    $('.affiliate_btn').prop('disabled', false);
                    input_text.prop('readonly', false);
                    separate_by.prop('disabled', false);
                    separate_by.parent().parent().removeClass('uni-disabled');
                    select.prop('disabled', false);
                } else {
                    input_text.prop('readonly', true);
                    separate_by.prop('disabled', true);
                    separate_by.parent().parent().addClass('uni-disabled');
                    select.prop('disabled', true);
                }
                select.trigger("liszt:updated").trigger("click");
            });
        },
        
        info : function () {
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
 
// end