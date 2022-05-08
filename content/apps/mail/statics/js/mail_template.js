// JavaScript Document
;(function (app, $) {
    app.mail_template_list = {
        init: function () {

        },

    };

    app.mail_template_info = {
        init: function () {
            app.mail_template_info.ajax_event();
            app.mail_template_info.submit_info();
        },

        ajax_event :function(){
            $("#template_code").change(function () {
                var subject_text = $("#template_code option:selected").text();
                var subject_val = $("#template_code option:selected").val();
                subject = subject_text.replace('['+ subject_val + ']', "");

                if (subject_val !== 0){
                     $('#subject').val(subject);
                     var url = $("#data-href").val();
                     var filters = {
                         'code': subject_val,
                         'channel_code': $("#channel_code").val(),
                     };
                     $.post(url, filters, function (data) {
                         $('#content').val(data.template);
                         $('.help-block').html(data.content);
                         //设置编辑器的内容
                         if (editor_content !== undefined) {
                             editor_content.setContent(data.template);
                         }
                     }, "JSON");
                } else {
                     $('#subject').val('');
                     $('#content').val('');
                     $('.help-block').text('')
                }
            })
        },

        submit_info: function () {
            var option = {
                rules: {
                    subject: {
                        required: true
                    },
                    content: {
                        required: true
                    }
                },
                messages: {
                    subject: {
                        required: js_lang_mail_template.subject_no_empty
                    },
                    content: {
                        required: js_lang_mail_template.content_no_empty
                    }
                },
                submitHandler: function () {
                    $("form[name='theForm']").ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $("form[name='theForm']").validate(options);
        },
    };
 
})(ecjia.admin, jQuery);
 
// end