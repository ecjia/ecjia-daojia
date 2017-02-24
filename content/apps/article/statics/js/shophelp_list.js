// JavaScript Document
;(function (app, $) {
    app.shophelp_list = {
        init: function () {
            /* 帮助信息列表 添加分类form提交*/
            $form = $("form[name='addcatForm']");
            var option = {
                submitHandler: function () {
                    $form.bind('form-pre-serialize', function (event, form, options, veto) {
                        (typeof (tinyMCE) != "undefined") && tinyMCE.triggerSave();
                    }).ajaxSubmit({
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
        
        info: function () {
            $form = $("form[name='theForm']");
            var option = {
                rules: {
                    title: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: js_lang.shophelp_title_required
                    },
                },
                submitHandler: function () {
                    $form.bind('form-pre-serialize', function (event, form, options, veto) {
                        (typeof (tinyMCE) != "undefined") && tinyMCE.triggerSave();
                    }).ajaxSubmit({
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
    };
 
})(ecjia.admin, jQuery);
 
// end