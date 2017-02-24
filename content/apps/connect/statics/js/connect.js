;(function (app, $) {
    app.connect_list = {
        init: function () {
            $(".ajaxall").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.admin.showmessage(data);
                }, 'json');
            });
        }
    };
 
    app.connect_edit = {
        init: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    connect_name: {
                        required: true
                    },
                    connect_desc: {
                        required: true
                    },
                },
                messages: {
                    connect_name: {
                        required: js_lang.name_required
                    },
                    connect_desc: {
                        required: js_lang.desc_required
                    },
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
        }
    };
 
})(ecjia.admin, jQuery);
 
// end