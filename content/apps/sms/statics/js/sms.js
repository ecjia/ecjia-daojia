// JavaScript Document
;(function (app, $) {
    app.sms_list = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
            //时间筛选
            $(".select-button").click(function (e) {
                e.preventDefault();
 
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: js_lang.start_lt_end_time,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
                var url = $("form[name='searchForm']").attr('action');
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
                ecjia.pjax(url);
            });
 
            //关键字搜索功能
            $(".search_sms").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val();
                ecjia.pjax(url);
            });
 
            $(".ajaxsms").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.admin.showmessage(data);
                }, 'json');
            });
        }
    };
 
    /* **编辑** */
    app.sms_edit = {
        init: function () {
            app.sms_edit.submit_form();
        },
        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    send_num: {
                        required: true
                    },
                    msg: {
                        required: true
                    },
                },
                messages: {
                    send_num: {
                        required: js_lang.send_num_required
                    },
                    msg: {
                        required: js_lang.msg_required
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