// JavaScript Document
;(function (app, $) {
    app.toutiao = {
        init: function () {
            app.toutiao.insert();
            app.toutiao.search();
            $('#info-toggle-button').toggleButtons({
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
        },
        
        insert: function () {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    title: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: js_lang.title_required
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
        },
 
        search: function () {
            $("form[name='searchForm']").on('submit', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var url = $("form[name='searchForm']").attr('action');
                if (keywords == '') {
                    ecjia.pjax(url);
                } else {
                    ecjia.pjax(url + '&keywords=' + keywords);
                }
            });
        }
    };
    
})(ecjia.admin, jQuery);
 
// end