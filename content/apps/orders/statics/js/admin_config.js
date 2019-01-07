// JavaScript Document
;
(function(app, $) {
    app.admin_config = {
        init: function() {
            app.admin_config.form();
        },
        form: function() {
            var option = {
                submitHandler: function() {
                    $("form[name='theForm']").ajaxSubmit({
                        dataType: "json",
                        success: function(data) {
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