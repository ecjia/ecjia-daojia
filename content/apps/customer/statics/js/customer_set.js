// JavaScript Document
;
(function(app, $) {
    app.customer_set = {
        init: function() {
            app.customer_set.theForm();
        },
        //添加必填项js
        theForm: function() {
            var $form = $("form[name='theForm']");
            var option = {
                submitHandler: function() {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function(data) {
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
