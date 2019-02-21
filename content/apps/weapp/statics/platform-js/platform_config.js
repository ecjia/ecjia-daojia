// JavaScript Document
;(function (app, $) {
    app.platform = {
        init: function () {
            ecjia.platform.platform.generate_token();
            ecjia.platform.platform.theForm();
            ecjia.platform.platform.copy();
        },

        generate_token: function () {
            $('.generate_token').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('data-url');
                $.post(url, function (data) {
                    var value = data.val
                    $('input[name="token"]').val(value);
                }, 'json');
            });
        },

        theForm: function () {
            var $form = $('form[name="theForm"]');
            var option = {
                rules: {
                    server_url: {required: true},
                    server_token: {required: true, rangelength: [3, 32]},
                    aeskey: {required: true, rangelength: [42, 44]},
                },
                messages: {
                    server_url: {required: js_lang.server_url_required},
                    server_token: {required: js_lang.server_token_required, rangelength: js_lang.server_token_rangelength},
                    aeskey: {required: js_lang.aeskey_required, rangelength: js_lang.aeskey_rangelength},
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

        copy: function () {
            $(".copy-url-btn").off('click').on('click', function (e) {
                var url_clipboard = new ClipboardJS('.copy-url-btn');
                url_clipboard.on('success', function (e) {
                    ecjia.platform_ui.alert(js_lang.copy_success, {ok: js_lang.ok});
                    e.clearSelection();
                    url_clipboard.destroy();
                });
                url_clipboard.on('error', function (e) {
                    ecjia.platform_ui.alert(js_lang.copy_failed, {ok: js_lang.ok});
                    e.clearSelection();
                    url_clipboard.destroy();
                });
            });

            $(".copy-token-btn").off('click').on('click', function (e) {
                var token_clipboard = new ClipboardJS('.copy-token-btn');
                token_clipboard.on('success', function (e) {
                    ecjia.platform_ui.alert(js_lang.copy_success, {ok: js_lang.ok});
                    e.clearSelection();
                    token_clipboard.destroy();
                });
                token_clipboard.on('error', function (e) {
                    ecjia.platform_ui.alert(js_lang.copy_failed, {ok: js_lang.ok});
                    e.clearSelection();
                    token_clipboard.destroy();
                });
            });
        }
    };
})(ecjia.platform, jQuery);

//end