// JavaScript Document
;(function (app, $) {
    app.weapp = {
        init: function () {
            ecjia.admin.weapp.search();
            ecjia.admin.weapp.edit();
        },

        //小程序列表 搜索/筛选
        search: function () {
            $("form[name='searchForm']").on('submit', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var url = $(this).attr('action');
                if (keywords) {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
            //小程序用户列表搜索/筛选
            $("form[name='filterForm']").on('submit', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var weapp_id = $("select[name='weapp_id']").val();
                var url = $(this).attr('action');
                if (keywords) {
                    url += '&keywords=' + keywords;
                }
                if (weapp_id) {
                    url += '&weapp_id=' + weapp_id;
                }
                ecjia.pjax(url);
            });

            //切换小程序账号
            $(".ajaxswitch").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.admin.showmessage(data);
                }, 'json');
            });
        },

        //小程序 添加/编辑
        edit: function () {
            var $form = $('form[name="theForm"]');
            var option = {
                rules: {
                    name: {required: true},
                    appid: {required: true},
                    appsecret: {required: true},
                },
                messages: {
                    name: {
                        required: js_lang.name_required,
                    },
                    appid: {
                        required: js_lang.appid_required,
                    },
                    appsecret: {
                        required: js_lang.appsecret_required,
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

    };
})(ecjia.admin, jQuery);

//end