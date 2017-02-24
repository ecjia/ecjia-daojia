// JavaScript Document
;(function (app, $) {
    app.ad_position_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .search_ad_position").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        }
    };
 
    /* **编辑** */
    app.ad_position_edit = {
        init: function () {
            app.ad_position_edit.submit_form();
        },
        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    position_name: {
                        required: true
                    },
                    ad_width: {
                        required: true
                    },
                    ad_height: {
                        required: true
                    },
                },
                messages: {
                    position_name: {
                        required: js_lang.position_name_required
                    },
                    ad_width: {
                        required: js_lang.ad_width_required
                    },
                    ad_height: {
                        required: js_lang.ad_height_required
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

//end