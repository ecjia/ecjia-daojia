// JavaScript Document
;
(function (app, $) {
    app.subscribe_message = {
        init: function () {
            $('.readed_message').off('click').on('click', function (e) {
                var $this = $(this),
                    admin_id = $this.attr('data-id'),
                    url = $this.attr('data-href'),
                    chat_id = $this.attr('data-chatid'),
                    last_id = $this.attr('data-lastid'),
                    info = {
                        last_id: last_id,
                        chat_id: chat_id
                    };
                e.preventDefault();
                if (!$this.attr('disabled')) {
                    $.get(url, info, function (data) {
                        if (data.msg_list) {
                            for (var i = data.msg_list.length - 1; i >= 0; i--) {
                                var is_myself = data.msg_list[i].iswechat == 1 ? 1 : 0;
                                var options = {
                                    send_time: data.msg_list[i].send_time,
                                    msg: data.msg_list[i].msg,
                                    chat_user: data.msg_list[i].nickname,
                                    is_myself: is_myself,
                                    oldstart: 1,
                                    type: data.msg_list[i].type,
                                    media_content: data.msg_list[i].media_content_html
                                };
                                app.subscribe_message.addMsgItem(options);
                            }
                            ;
                            var new_last_id = data.last_id ? data.last_id : parseInt(last_id) - 10;
                            $this.attr('data-lastid', new_last_id);
                            data.msg_list.length < 10 && $this.text(data.message).attr('disabled', 'disabled');
                            $('.chat_msg.media-list').prepend($this.parents('.chat_msg'));
                            $('.chat-box').stop().animate({
                                scrollTop: 0
                            }, 1000);
                        } else {
                            $this.text(data.message).attr('disabled', 'disabled');
                        }
                    })
                }
            });

            $('.send_msg').off('click').on('click', function (e) {
                app.subscribe_message.sendMsg();
                e.preventDefault();
            });

            $(".set-label-btn").off('click').on('click', function (e) {
                var openid = $(this).attr('data-openid');
                var uid = $(this).attr('data-uid');
                $('input[name="openid"]').val(openid);
                $('input[name="uid"]').val(uid);
                searchURL = $(this).attr('data-url');
                var filters = {
                    'uid': uid,
                };
                $('.popover_tag_list').html('');
                $.post(searchURL, filters, function (data) {
                    $('#set_label').modal('show');
                    app.subscribe_message.load_opt(data);
                }, "JSON");
            });

            $(".set_label").off('click').on('click', function (e) {
                var $form = $("form[name='label_form']");
                $form.ajaxSubmit({
                    dataType: "json",
                    success: function (data) {
                        $('#set_label').modal('hide');
                        $(".modal-backdrop").remove();
                        ecjia.platform.showmessage(data);
                    }
                });
            });
            app.subscribe_message.edit_customer_remark();
            app.subscribe_message.show_message_modal();
        },

        load_opt: function (data) {
            if (data.content.length > 0) {
                for (var i = 0; i < data.content.length; i++) {
                    if (data.content[i].checked == 1) {
                        var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" checked="checked" name="tag_id[]" value="' + data.content[i].tag_id + '" id="tag_' + data.content[i].tag_id + '"><label for="tag_' + data.content[i].tag_id + '"></label><span class="lbl_content">' + data.content[i].name + '</span></label>');
                    } else {
                        var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" name="tag_id[]" value="' + data.content[i].tag_id + '" id="tag_' + data.content[i].tag_id + '"><label for="tag_' + data.content[i].tag_id + '"></label><span class="lbl_content">' + data.content[i].name + '</span></label>');
                    }
                    $('.popover_tag_list').append($opt);
                }
            }
            $('.frm_checkbox_label').off('click').on('click', function () {
                $("input[name='tag_id[]']").attr('disabled', true);
                if ($("input[name='tag_id[]']:checked").length >= 3) {
                    $("input[name='tag_id[]']:checked").attr('disabled', false);
                } else {
                    $("input[name='tag_id[]']").attr('disabled', false);
                }
            });
        },

        //编辑备注
        edit_customer_remark: function () {
            $('.edit_remark_icon').off('click').on('click', function (e) {
                e.preventDefault();
                var remark = $('input[name="remark"]').val();
                $('.remark_info').hide();
                $('.edit_remark_icon').hide();
                $('.remark').show();
            });

            $('.remark_ok').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    remark = $('input[name="remark"]').val(),
                    url = $('.edit_remark_url').attr('data-url'),
                    openid = $('.edit_remark_url').attr('data-openid'),
                    page = $('.edit_remark_url').attr('data-page'),
                    uid = $('.edit_remark_url').attr('data-uid'),
                    old_remark = $('.edit_remark_url').attr('data-remark'),
                    info = {
                        remark: remark,
                        openid: openid,
                        page: page,
                        uid: uid
                    };
                if (remark == old_remark) {
                    $('.remark_info').show();
                    $('.edit_remark_icon').show();
                    $('.remark').hide();
                } else {
                    $.post(url, info, function (data) {
                        ecjia.platform.showmessage(data);
                    }, 'json');
                }
            });

            $('.remark_cancel').off('click').on('click', function (e) {
                e.preventDefault();
                var remark = $('input[name="remark"]').val();
                $('.remark_info').show();
                $('.edit_remark_icon').show();
                $('.remark').hide();
            });
        },

        //素材消息预览弹出框
        show_message_modal: function () {
            $('.preview_img').off('click').on('click', function () {
                var $this = $(this),
                    type = $this.attr('data-type'),
                    title = '';

                $('#show_message').find('.inner_main').html('');
                if (type == 'image') {
                    title = js_lang.image_preview;
                    var src = $this.attr('src');
                    $('#show_message').find('.inner_main').html('<img style="width:100%;height:100%;" src="' + src + '" />');
                } else if (type == 'voice') {
                    var src = $this.attr('data-src');
                    title = js_lang.voice_preview;
                    $('#show_message').find('.inner_main').html('<video autoplay style="width:100%;height:100px;" src="' + src + '" controls></video')
                } else if (type == 'video') {
                    var src = $this.attr('data-src');
                    title = js_lang.video_preview;
                    $('#show_message').find('.inner_main').html('<video autoplay style="width:100%;height:99%;" src="' + src + '" controls></video')
                }
                $('#show_message').find('.modal-title').html(title);
                $('#show_message').modal('show');
            })
        },

        /*
         * 发送信息
         */
        sendMsg: function () {
            var msg = $("#chat_editor").val(),
                post_url = $('.chat_box').attr('data-url'),
                chat_user = $('#chat_user').val(),
                nickname = $('#nickname').val(),
                openid = $('#openid').val(),
                account_name = $('#account_name').val(),
                media_id = $('input[name="media_id"]').val(),
                info = {
                    message: msg,
                    uid: chat_user,
                    openid: openid,
                    media_id: media_id
                },
                type = $('.material-table').find('.nav-link.active').parent('.nav-item').attr('data-type');

            if (msg != "" || media_id != undefined) {
                $.post(post_url, info, function (data) {
                    if (data.state == 'error') {
                        ecjia.platform.showmessage(data);
                        return false;
                    }
                    var options = {
                        send_time: data.send_time,
                        msg: msg,
                        chat_user: account_name,
                        is_myself: 1,
                        media_id: media_id,
                        type: type
                    };
                    app.subscribe_message.addMsgItem(options);
                }, 'json');
            } else {
                $('#chat_editor').focus();
            }
            $('#chat_editor').val('');
        },

        /*
         * 添加信息节点到聊天框中
         */
        addMsgItem: function (options) {
            var msg_cloned = $('.msg_clone').clone();
            options.oldstart ? $('.chat_msg.media-list').prepend(msg_cloned) : $('.chat_msg.media-list').append(msg_cloned);
            var html = '';
            if (options.media_id != undefined && options.media_id != '') {
                $('.js_appmsgArea').find('.link_dele').remove();
                $('.js_appmsgArea').find('input[name="media_id"]').remove();
                $('.create-type__list').show();
                if (options.type == 'news') {
                    html = $('.js_appmsgArea').find('.weui-desktop-media__list-col');
                } else {
                    html = $('.js_appmsgArea').find('.img_preview');
                }
            } else {
                if (options.media_content != undefined) {
                    html = options.media_content;
                } else {
                    html = options.msg;
                }
            }
            msg_cloned.find('.media-text').html(html);
            msg_cloned.find('.chat_msg_date').html(options.send_time);
            msg_cloned.find('.chat_user_name').html(options.chat_user);
            !options.is_myself && msg_cloned.removeClass('chat-msg-mine').addClass('chat-msg-you');
            msg_cloned.removeClass('msg_clone').show();

            app.subscribe_message.show_message_modal();
            $('.chat-box').stop().animate({
                scrollTop: $('.chat-box .card-body').height()
            }, 1000);
        },
    };

    app.admin_subscribe = {
        init: function () {
            $(".ajaxswitch").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.platform.showmessage(data);
                }, 'json');
            });

            $('.search-btn').off('click').on('click', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var url = $("form[name='search_from']").attr('action'); //请求链接
                if (keywords == 'undefind') keywords = '';
                if (url == 'undefind') url = '';

                if (keywords == '') {
                    ecjia.pjax(url);
                } else {
                    ecjia.pjax(url + '&keywords=' + keywords);
                }
            });

            app.admin_subscribe.edit_tag();

            $(".ajaxmenu").off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                $this.html(js_lang.getting).addClass('disabled');

                var info = '';
                var value = $(this).attr('data-value');
                if (value == 'get_usertag') {
                    info = js_lang.get_user_tag;
                } else {
                    info = js_lang.get_user_info;
                }

                var url = $(this).attr('data-url');
                var message = $(this).attr('data-msg');
                if (message) {
                    ecjia.platform_ui.confirm(message, function (e) {
                        e && $.ajax({
                            type: "get",
                            url: url,
                            dataType: "json",
                            success: function (data) {
                                $this.html(info).removeClass('disabled');
                                ecjia.platform.showmessage(data);
                            }
                        });
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    app.admin_subscribe.get_userinfo(url);
                }
            });

            app.admin_subscribe.batch_set_label();
            app.admin_subscribe.create_session();
            app.admin_subscribe.session_form();
        },

        get_userinfo: function (url) {
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function (data) {
                    ecjia.platform.showmessage(data);
                    if (data.notice == 1) {
                        var url = data.url;
                        app.admin_subscribe.get_userinfo(url + '&p=' + data.p);
                    }
                }
            });
        },

        edit_tag: function () {
            $('.subscribe-icon-edit').off('click').on('click', function () {
                $('input[name="new_tag"]').val('');
                var old_tag_name = $(this).attr('data-name');
                $('.old_tag').html(old_tag_name);
                $('.old_tag_name').show();
                var id = $(this).attr('value');
                $('#edit_tag input[name="id"]').val(id);
                $('#edit_tag').modal('show');
                var $form = $("form[name='edit_tag']");
                var option = {
                    rules: {
                        new_tag: {
                            required: true,
                            maxlength: 6
                        },
                    },
                    messages: {
                        new_tag: {
                            required: js_lang.tag_name_required,
                            maxlength: js_lang.tag_name_maxlength
                        }
                    },
                    submitHandler: function () {
                        var new_tag_name = $('input[name="new_tag"]').val();
                        if (new_tag_name == old_tag_name) {
                            $('#edit_tag').modal('hide');
                            $(".modal-backdrop").remove();
                            return false;
                        }
                        $form.ajaxSubmit({
                            dataType: "json",
                            success: function (data) {
                                $('#edit_tag').modal('hide');
                                $(".modal-backdrop").remove();
                                ecjia.platform.showmessage(data);
                            }
                        });
                    }
                }
                var options = $.extend(ecjia.platform.defaultOptions.validate, option);
                $form.validate(options);
            });

            $('.subscribe-icon-plus').off('click').on('click', function () {
                $('input[name="new_tag"]').val('');
                $('#add_tag').modal('show');
                var $form = $("form[name='add_tag']");
                var option = {
                    rules: {
                        new_tag: {
                            required: true,
                            maxlength: 6
                        },
                    },
                    messages: {
                        new_tag: {
                            required: js_lang.tag_name_required,
                            maxlength: js_lang.tag_name_maxlength
                        }
                    },
                    submitHandler: function () {
                        $form.ajaxSubmit({
                            dataType: "json",
                            success: function (data) {
                                $('#add_tag').modal('hide');
                                $(".modal-backdrop").remove();
                                ecjia.platform.showmessage(data);
                            }
                        });
                    }
                }
                var options = $.extend(ecjia.platform.defaultOptions.validate, option);
                $form.validate(options);
            });
        },

        batch_set_label: function () {
            $(".set-label-btn").off('click').on('click', function (e) {
                var openid = $(this).attr('data-openid');
                var uid = $(this).attr('data-uid');
                searchURL = $(this).attr('data-url');
                var filters = {
                    'uid': uid,
                };
                if (openid != '' && openid != undefined) {
                    $('input[name="openid"]').val(openid);
                    $('input[name="uid"]').val(uid);
                } else {
                    var checkboxes = [];
                    $(".checkbox:checked").each(function () {
                        checkboxes.push($(this).val());
                    });
                    if (checkboxes == '') {
                        ecjia.platform_ui.alert(js_lang.pls_select_user, {
                            ok: js_lang.ok,
                        });
                        return false;
                    } else {
                        $('input[name="openid"]').val(checkboxes);
                    }
                }
                $('.popover_tag_list').html('');
                $.post(searchURL, filters, function (data) {
                    app.admin_subscribe.load_opt(data);
                }, "JSON");
                $('#set_label').modal('show');
            });

            $(".set_label").off('click').on('click', function (e) {
                var $form = $("form[name='label_form']");
                $form.ajaxSubmit({
                    dataType: "json",
                    success: function (data) {
                        $('#set_label').modal('hide');
                        $(".modal-backdrop").remove();
                        ecjia.platform.showmessage(data);
                    }
                });
            });
        },

        load_opt: function (data) {
            if (data.content.length > 0) {
                for (var i = 0; i < data.content.length; i++) {
                    if (data.content[i].checked == 1) {
                        var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" checked="checked" name="tag_id[]" value="' + data.content[i].tag_id + '" id="tag_' + data.content[i].tag_id + '"><label for="tag_' + data.content[i].tag_id + '"></label><span class="lbl_content">' + data.content[i].name + '</span></label>');
                    } else {
                        var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" name="tag_id[]" value="' + data.content[i].tag_id + '" id="tag_' + data.content[i].tag_id + '"><label for="tag_' + data.content[i].tag_id + '"></label><span class="lbl_content">' + data.content[i].name + '</span></label>');
                    }
                    $('.popover_tag_list').append($opt);
                }
            }
            $('.frm_checkbox').off('click').on('click', function () {
                var c = $("input[name='tag_id[]']:checked").length,
                    limit = 3;
                if (c > limit) {
                    $(this).prop('checked', false);
                    $(".label_block").show();
                    c--;
                } else {
                    $(".label_block").hide();
                }
            });
        },

        create_session: function () {
            $(".create_session").off('click').on('click', function (e) {
                var openid = $(this).attr('data-openid');
                $('input[name="openid"]').val(openid);
                $('#create_session').modal('show');
            });
        },

        session_form: function () {
            var $form = $("form[name='session_form']");
            var option = {
                rules: {
                    kf_account: {
                        required: true
                    }
                },
                messages: {
                    kf_account: {
                        required: js_lang.kf_account_required
                    }
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            $('#create_session').modal('hide');
                            $(".modal-backdrop").remove();
                            ecjia.platform.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.platform.defaultOptions.validate, option);
            $form.validate(options);
        },
    };
})(ecjia.platform, jQuery);

// end