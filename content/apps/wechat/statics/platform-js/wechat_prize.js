// JavaScript Document
;
(function (app, $) {
    app.prize_list = {
        init: function () {
            $(".ajaxswitch").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.platform.showmessage(data);
                }, 'json');
            });

            $(".ajaxissue").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.platform.showmessage(data);
                }, 'json');
            });

            $('.screen-btn').off('click').on('click', function (e) {
                e.preventDefault();
                var type = $("select[name='activity_type'] option:selected").val();
                var url = $("form[name='form']").attr('action');

                if (type) {
                    ecjia.pjax(url + '&type=' + type);
                } else {
                    ecjia.pjax(url);
                }
            });

            var wechat_type = $("input[name='wechat_type']").val();
            $('.send_message').off('click').on('click', function () {
                $('#send_message').modal('show');
                var $this = $(this);
                if (wechat_type == 0 || wechat_type == 1) {
                    $('.modal-body').css('max-height', "450px");
                } else {
                    $('.modal-body').css('max-height', "400px");
                }
                $('textarea[name="message_content"]').val('');
                var openid = $this.attr('data-openid');
                var nickname = $this.attr('data-nickname');
                var uid = $this.attr('data-uid');

                $('input[name="openid"]').val(openid);
                $('input[name="nickname"]').val(nickname);
                $('input[name="uid"]').val(uid);

                $('.openid').html(openid);
                $('.nickname').html(nickname);

                var $form = $("form[name='the_form']");
                var option = {
                    rules: {
                        message_content: {
                            required: true
                        }
                    },
                    messages: {
                        message_content: {
                            required: js_lang.content_require
                        }
                    },
                    submitHandler: function () {
                        $form.ajaxSubmit({
                            dataType: "json",
                            success: function (data) {
                                $('#send_message').modal('hide');
                                $(".modal-backdrop").remove();
                                ecjia.platform.showmessage(data);
                            }
                        });
                    }
                }
                var options = $.extend(ecjia.platform.defaultOptions.validate, option);
                $form.validate(options);
            });
        }
    };
})(ecjia.platform, jQuery);

// end