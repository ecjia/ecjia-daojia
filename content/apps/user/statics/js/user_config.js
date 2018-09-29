;
(function (app, $) {
    app.user_config = {
        init: function () {
            app.user_config.form();
        },

        form: function () {
            var $this = $('form[name="theForm"]');
            var option = {
                submitHandler: function () {
                    $this.ajaxSubmit({
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