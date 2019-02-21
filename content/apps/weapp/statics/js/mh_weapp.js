// JavaScript Document
;
(function (app, $) {
    app.weapp = {
        init: function () {
            ecjia.merchant.weapp.search();
            ecjia.merchant.weapp.edit();
        },

        //公众号列表 搜索/筛选
        search: function () {
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action')
                var platform = $("select[name='platform'] option:selected").val();
                if (platform != '') {
                    url += '&platform=' + platform;
                }
                ecjia.pjax(url);
            });

            $("form[name='searchForm']").on('submit', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var url = $(this).attr('action');
                if (keywords) {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        },

        //公众号 添加/编辑
        edit: function () {
            var $form = $('form[name="theForm"]');
            var option = {
                rules: {
                    name: {required: true},
                    appid: {required: true},
                    appsecret: {required: true},
                },
                messages: {
                    name: {required: js_lang.name_required},
                    appid: {required: js_lang.appid_required},
                    appsecret: {required: js_lang.appsecret_required},
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        },
    };
})(ecjia.merchant, jQuery);

//end