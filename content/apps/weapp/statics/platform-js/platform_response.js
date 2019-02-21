// JavaScript Document
;
(function (app, $) {
    app.response = {
        init: function () {
            $(".ajaxswitch").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.platform.showmessage(data);
                }, 'json');
            });
            $('.search-btn').off('click').on('click', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var url = $("form[name='search_from']").attr('action'); //请求链接
                if (keywords == 'undefind') keywords = '';
                if (url == 'undefind') url = '';

                if (keywords == '') {
                    ecjia.pjax(url);
                } else {
                    ecjia.pjax(url + '&keywords=' + keywords);
                }
            });

            app.response.theForm();
        },
        //添加必填项js
        theForm: function () {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    rule_name: {
                        required: true
                    },
                    rule_keywords: {
                        required: true
                    }
                },
                messages: {
                    rule_name: {
                        required: js_lang.rule_name_required
                    },
                    rule_keywords: {
                        required: js_lang.rule_keywords_required
                    }
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.platform.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.platform.defaultOptions.validate, option);
            $form.validate(options);
        },
    }
})(ecjia.platform, jQuery);

// end