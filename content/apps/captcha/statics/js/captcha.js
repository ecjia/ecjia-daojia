// JavaScript Document
;(function (app, $) {
    app.captcha = {
        init: function () {
            app.captcha.submit_config();
            app.captcha.choose_captcha();
            app.captcha.change_captcha();
        },
 
        choose_captcha: function () {
            //点击选择样式事件
            $('.wookmark .input').on('click', function () {
                var $this = $(this),
                    url = $this.attr('data-url');
                if ($this.closest('li').find(".flash-choose").hasClass("hidden")) {
                    smoke.confirm(admin_captcha_lang.setupConfirm, function (e) {
                        if (e) {
                            $.get(url, '', function (data) {
                                ecjia.admin.showmessage(data);
                            }, 'json');
                        }
                    }, {
                        ok: admin_captcha_lang.ok,
                        cancel: admin_captcha_lang.cancel
                    });
                } else {
                    smoke.alert(admin_captcha_lang.is_checked);
                }
            });
        },
 
        change_captcha: function () {
            $('[data-toggle="change_captcha"]').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    this_src = $this.attr('data-src') + Math.random();
                $this.attr('src', this_src);
            });
        },
 
        submit_config: function () {
            var $this = $("form[name='theForm']");
            var option = {
                rules: {
                    captcha_width: {
                        required: true,
                        min: 40,
                        max: 145
                    },
                    captcha_height: {
                        required: true,
                        min: 15,
                        max: 50
                    }
                },
                messages: {
                    captcha_width: {
                        required: admin_captcha_lang.captcha_width_required,
                        min: admin_captcha_lang.captcha_width_min,
                        max: admin_captcha_lang.captcha_width_max
                    },
                    captcha_height: {
                        required: admin_captcha_lang.captcha_height_required,
                        min: admin_captcha_lang.captcha_height_min,
                        max: admin_captcha_lang.captcha_height_max
                    }
                },
                submitHandler: function () {
                    $("form[name='theForm']").ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $this.validate(options);
        }
    };
    
})(ecjia.admin, jQuery);
 
// end