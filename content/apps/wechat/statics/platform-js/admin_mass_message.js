// JavaScript Document
;
(function (app, $) {
    app.mass_message = {
        init: function () {
            $(".ajaxswitch").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.platform.showmessage(data);
                }, 'json');
            });

            $("select[name='mass_type']").change(function (e) {
                e.preventDefault();
                var mass_type = $("select[name='mass_type'] option:selected").val();
                if (mass_type == 'by_group') {
                    $('.by_group').removeClass('d-none');
                } else {
                    $('.by_group').addClass('d-none');
                }
            });

            app.mass_message.theForm();
            app.mass_message.preview_msg();
        },
        //添加必填项js
        theForm: function () {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    rule_name: {
                        required: true
                    },
                    rule_keywords: {
                        required: true
                    }
                },
                messages: {
                    rule_name: {
                        required: js_lang.rule_name_required
                    },
                    rule_keywords: {
                        required: js_lang.rule_keywords_required
                    }
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.platform.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.platform.defaultOptions.validate, option);
            $form.validate(options);
        },

        preview_msg: function () {
            $('.preview_msg').off('click').on('click', function () {
                var type = $('input[name="content_type"]').val();
                if (type == 'text') {
                    var content = $('textarea[name="content"]').val();
                    if (content == '') {
                        ecjia.platform_ui.alert(js_lang.preview_content_required, {
                            ok: js_lang.ok,
                        });
                        return false;
                    }
                } else {
                    var media_id = $('input[name="media_id"]').val();
                    if (media_id == '' || media_id == undefined) {
                        ecjia.platform_ui.alert(js_lang.preview_material_required, {
                            ok: js_lang.ok,
                        });
                        return false;
                    }
                }
                $('#preview_msg').modal('show');
            });

            $('.confirm-send').off('click').on('click', function () {
                var type = $('input[name="content_type"]').val();
                var content = $('textarea[name="content"]').val();
                var media_id = $('input[name="media_id"]').val();
                var wechat_account = $('input[name="wechat_account"]').val();
                var url = $('input[name="preview_url"]').val();
                if (wechat_account == '') {
                    $('.frm_msg.fail').css('display', 'block').html(js_lang.preview_account_required);
                    return false;
                } else {
                    $('.frm_msg.fail').css('display', 'none').html('');
                    var info = {
                        type: type,
                        content: content,
                        media_id: media_id,
                        wechat_account: wechat_account
                    }
                    $.post(url, info, function (data) {
                        if (data.stats == 'error') {
                            $('.frm_msg.fail').css('display', 'block').html(data.message);
                            return false;
                        }
                        $('#preview_msg').modal('hide');
                        $(".modal-backdrop").remove();
                        ecjia.platform.showmessage(data);
                    })
                }
            });
        },

    }
})(ecjia.platform, jQuery);

// end