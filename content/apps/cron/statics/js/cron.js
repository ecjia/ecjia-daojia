// JavaScript Document
;(function (app, $) {
    app.cron = {
        init: function () {
            app.cron.theForm();
            app.cron.toggle_view();
            app.cron.trigger();
            app.cron.select();
        },
        //添加必填项js
        theForm: function () {
            var $form = $("form[name='theForm']");
            var option = {
                submitHandler: function () {
                	$(".remove_select").removeAttr("disabled");
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
 
        toggle_view: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var href = $this.attr('href');
                var val = $this.attr('data-val');
                var option = {
                    href: href,
                    val: val
                };
                var url = option.href;
                var code = {
                    code: option.val
                };
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.get(url, code, function (data) {
                                ecjia.admin.showmessage(data);
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.get(url, code, function (data) {
                        ecjia.admin.showmessage(data);
                    }, 'json');
                }
            });
        },
 
        trigger: function () {
            $('.advance').css('display', 'none');
            if ($("input[name='show_advance']").attr("checked")) {
	        	 $('.advance').css('display', 'block');
	        }

            $(document).on('click', 'input[name="show_advance"]', function (e) {
                if ($("input[name='show_advance']").attr("checked")) {
                    $('.advance').css('display', 'block');
                } else {
                    $('.advance').css('display', 'none');
                }
            });
 
            $("select[name='ttype']").on('change', function (e) {
                $(this).val() == 'day' ? $('.ttype_day').css('display', 'block') : $('.ttype_day').css('display', 'none');
                $(this).val() == 'week' ? $('.ttype_week').css('display', 'block') : $('.ttype_week').css('display', 'none');
                if ($(this).val() == 'unlimit') {
                    $('.ttype_day').css('display', 'none');
                    $('.ttype_week').css('display', 'none');
                }
            });
        },
        
        select: function () {
            $("select[name='select_cron_minute']").on('change', function (e) {
            	if($(this).val() == 'five') {
            		$("#cron_minute").val("0,10,15,20,25,30,35,40,45,50,55");
            	}else if($(this).val() == 'ten'){
            		$("#cron_minute").val("0,10,20,30,40,50");
            	}else if($(this).val() == 'fifteen'){
            		$("#cron_minute").val("0,15,30,45");
            	}else if($(this).val() == 'twenty'){
            		$("#cron_minute").val("0,20,40");
            	}else if($(this).val() == 'thirty'){
            		$("#cron_minute").val("0,30");
            	}else{
            		$("#cron_minute").val("");
            	}
            });
        },
    }
})(ecjia.admin, jQuery);
 
// end