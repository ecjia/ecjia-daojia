// JavaScript Document
;(function (app, $) {
    app.shoparticle_info = {
        init: function () {
            $form = $('form[name="theForm"]');
            var option = {
                rules: {
                    title: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: js_lang.shopinfo_title_required
                    },
                },
                submitHandler: function () {
                    $("form[name='theForm']").bind('form-pre-serialize', function (event, form, options, veto) {
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
            $("form[name='theForm']").validate(options);
        }
    };
    
})(ecjia.admin, jQuery);
 
// end