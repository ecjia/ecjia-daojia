// JavaScript Document
;
(function (app, $) {
    app.list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .search_friendlink").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '' && keywords != undefined) {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });

            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var href = $this.attr('href');
                var val = $this.attr('data-val') || 'allow';
                var option = {
                    href: href,
                    val: val
                };
                var url = option.href;
                var val = {
                    change: option.val
                };
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.get(url, val, function (data) {
                                var url = $this.attr("data-pjax-url");
                                ecjia.pjax(url, function () {
                                    ecjia.admin.showmessage(data);
                                });
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.get(url, val, function (data) {
                        var url = $this.attr("data-pjax-url");
                        ecjia.pjax(url, function () {
                            ecjia.admin.showmessage(data);
                        });
                    }, 'json');
                }
            });
        },
    };

    /* **编辑** */
    app.edit = {
        init: function (get_value) {
            var type = $('#type').val();
            if (type == 1) {
                $('#show_src').css("display", "none");
                $("#show_local").css("display", "block");
            }

            $("input[name='link_logo']").click(function () {
                var brand_type = $(this).val();
                if (brand_type == 0) {
                    $('#show_src').css("display", "block");
                    $('#show_local').css("display", "none");
                } else {
                    $('#show_src').css("display", "none");
                    $("#show_local").css("display", "block");
                }
            });

            app.edit.submit_form();
        },

        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    link_name: {
                        required: true
                    },
                    link_url: {
                        required: true
                    }
                },
                messages: {
                    link_name: {
                        required: js_lang.link_name_required
                    },
                    link_url: {
                        required: js_lang.link_url_required
                    }
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
    };

})(ecjia.admin, jQuery);

// end