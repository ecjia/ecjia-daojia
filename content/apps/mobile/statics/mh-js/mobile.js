// JavaScript Document
;
(function(app, $) {
    app.staff_info = {
        init: function() {
            app.staff_info.theForm();
        },
        theForm: function() {
            var $form = $("form[name='theForm']");
            var option = {
                submitHandler: function() {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function(data) {
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        }
    }
})(ecjia.merchant, jQuery);
//end