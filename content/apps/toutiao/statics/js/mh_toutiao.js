// JavaScript Document
;
(function(app, $) {
    app.material_edit = {
        init: function() {
            app.material_edit.clone();
            // app.material_edit.edit_area();
            app.material_edit.remove_area();
            app.material_edit.form_submit();
            app.material_edit.title_show();
            app.material_edit.image_show();
            app.material_edit.issue_submit();
            app.material_edit.upload_multi_articles();
            app.material_edit.remove_child_article();
            var index = $('.mobile_news_view').find('.select_mobile_area').length;
            if (index >= 8) {
                $('.create_news').hide();
            } else {
                $('.create_news').show();
            }
        },
        clone: function() {
            $('a[data-toggle="clone-object"]').off('click').on('click', function(e) {
                $('div.hide').find('input').prop('disabled', true);
                $('div.hide').find('textarea').prop('disabled', true);
                $('div.hide').find('checkbox').prop('disabled', true);
                $('.create_news').hide();
                $('.btn-preview').hide();
                var index = $('.select_mobile_area').length;
                $('.material_info').children().children('h4').html('图文素材' + index);
                $('input[name="title"]').val('');
                $('input[name="sort"]').val('');
                $('input[name="author"]').val('');
                $('textarea[name="description"]').val('');
                $('.fileupload').removeClass('fileupload-exists').addClass('fileupload-new');
                $('.image_preview').remove();
                $('.fileupload-preview').addClass('fileupload-exists').removeClass('fileupload-new').html('');
                $('.fileupload').children('a').removeAttr('data-toggle').removeAttr('data-href').removeAttr('data-msg').attr({
                    'data-dismiss': 'fileupload'
                });
                $('input[name="id"]').val('');
                $('input[name="content_url"]').val('http://');
                $('input[name="index"]').val(index - 1);
                var $this = $(this),
                    $parentobj = $($this.attr('data-parent')),
                    $parentobj_clonearea = $($this.attr('data-clone-area'))
                before = $this.attr('data-before') || 'before',
                    $childobj = $($this.attr('data-child')),
                    $childobj_clonearea = $($this.attr('data-child-clone-area')),
                    form_action = $('input[name="add_url"]').val();
                option = {
                    parentobj: $parentobj,
                    parentobj_clonearea: $parentobj_clonearea,
                    before: before,
                    childobj: $childobj,
                    childobj_clonearea: $childobj_clonearea
                };
                !$parentobj ? console.log(js_lang.clone_no_parent) : app.material_edit.clone_obj(option);
                $('form[name="theForm"]').attr('action', form_action);
                $(document).unbind('keyup').on("keyup", "input[name^='title']", function() {
                    $this = $(this);
                    if ($this.val() == '') {
                        $('.material_info_select').find('.title_show').html(js_lang.title);
                    } else {
                        $('.material_info_select').find('.title_show').html($this.val());
                    }
                });
                $(document).unbind('change').on("change", 'input[name^="image_url"]', function() {
                    $this = $(this);
                    var index = $this.parents('.select_mobile_area').index() + 1;
                    if ($this.val() == '') {
                        $('.material_info_select').find('.show_image').html(js_lang.thumbnail);
                    } else {
                        setTimeout(function() {
                            var src = $this.parents('.controls').find("img").attr('src');
                            var html = '<img src="' + src + '"/>';
                            $('.material_info_select').find('.show_image').html(html);
                        }, 500);
                    }
                });
                $('.mobile_news_view').find('.select_mobile_area').removeClass('active');
                $('.material_info_select').addClass('active');
                $("#content").children().find('iframe').contents().find('body.view').html('<p><br></p>');
                var editor = UE.getEditor('content');
                editor.setContent('');
            });
        },
        clone_obj(options) {
            if (!options.parentobj) return console.log(js_lang.batch_less_parameter);
            var tmpObj = options.parentobj.clone();
            tmpObj.removeClass('hide');
            tmpObj.removeClass('mobile_news_auxiliary_clone');
            (options.before == 'before') ? options.parentobj_clonearea.before(tmpObj): options.parentobj_clonearea.after(tmpObj);
            if (options.childobj && options.childobj_clonearea) {
                var size = options.childobj_clonearea.children('div').length + 2;
                if (size >= 9) {
                    var error = {
                        'message': js_lang.images_most8,
                        'state': 'error'
                    };
                    ecjia.merchant.showmessage(error);
                    return false;
                }
                $('.material_add_info').children().children('h4').html(js_lang.graphic + size);
                num = size - 1;
            }
            //清空默认数据
            options.parentobj.find('input').not(":hidden").val('');
            //编辑区域展示效果js
            app.material_edit.edit_area_show(num);
            app.material_edit.remove_area();
        },
        edit_area_show: function(num) {
            var tmp = $('.mobile_news_edit').children().eq(num);
            tmp.removeClass('hide');
        },
        edit_area: function() {
            $('.fa.fa-edit').off('click').on('click', function(e) {
                e.preventDefault();
                $('.material_info_select').not('.hide').remove();
                $('.create_news').show();
                var index = $(this).parents('.select_mobile_area').index() + 1;
                $('.mobile_news_view').find('.select_mobile_area').removeClass('active');
                $(this).parents('.select_mobile_area').addClass('active');
                $('.material_info').children().children('h4').html(js_lang.graphic + index);
                var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(index - 1);
                $(document).unbind('keyup').on("keyup", "input[name^='title']", function() {
                    if ($(this).val() == '') {
                        edit_area.find('.title_show').html(js_lang.title);
                    } else {
                        edit_area.find('.title_show').html($(this).val());
                    }
                });
                $(document).unbind('change').on("change", 'input[name^="image_url"]', function() {
                    $this = $(this);
                    if ($(this).val() == '') {
                        edit_area.find('.show_image').html(js_lang.thumbnail);
                    } else {
                        setTimeout(function() {
                            var src = $this.parents('.controls').find("img").attr('src');
                            var html = '<img src="' + src + '"/>';
                            edit_area.find('.show_image').html(html);
                        }, 500);
                    }
                });
                var url = $(this).parent().attr('data-href');
                var id = $(this).parent().attr('data-id')
                if (url == undefined || id == undefined) {
                    return false;
                }
                var form_action = $('input[name="update_url"]').val();
                $('form[name="theForm"]').attr('action', form_action + '&id=' + id);
                $.get(url, id, function(data) {
                    $('input[name="title"]').val(data.content.title);
                    $('input[name="author"]').val(data.content.author);
                    $('input[name="sort"]').val(data.content.sort);
                    $('textarea[name="description"]').val(data.content.description);
                    $('input[name="id"]').val(data.content.id);
                    $('input[name="content_url"]').val(data.content.content_url);
                    $('input[name="index"]').val(index - 1);
                    $("#content").children().find('iframe').contents().find('body.view').html(data.content.content);
                    var editor = UE.getEditor('content');
                    content = editor.setContent(data.content.content);
                }, "JSON");
                app.material_edit.edit_area_show(index);
            });
        },
        remove_area: function() {
            $('[data-toggle="remove_material"]').on('click', function() {
                var $this = $(this);
                var msg = $this.attr('data-msg'),
                    id = $this.attr('data-id'),
                    url = $this.attr('data-href');
                ecjia.merchant_ui.confirm(msg, function(e) {
                    if (e) {
                        $.get(id, url, function(data) {
                            ecjia.pjax(window.location.href, function() {
                                ecjia.merchant.showmessage(data);
                            });
                        }, 'json');
                    }
                }, {
                    ok: js_lang.ok,
                    cancel: js_lang.cancel
                });
            });
            $('[data-toggle="remove_edit_mask"]').off('click').on('click', function() {
                var $this = $(this);
                href = $this.attr('data-href');
                ecjia.pjax(href);
            });
        },
        issue_submit: function() {
            $('.issue').on('click', function(e) {
                var url = $(this).attr('data-url');
                $.get(url, function(data) {
                    ecjia.merchant.showmessage(data);
                }, 'json');
            });
        },
        form_submit: function() {
            $('div.hide').find('input').prop('disabled', true);
            $('div.hide').find('textarea').prop('disabled', true);
            $('div.hide').find('checkbox').prop('disabled', true);
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    title: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: js_lang.title_placeholder_graphic
                    },
                },
                submitHandler: function() {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function(data) {
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        },
        title_show: function() {
            var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(0);
            $(document).unbind('keyup').on("keyup", "input[name^='title']", function() {
                $this = $(this);
                if ($this.val() == '') {
                    edit_area.find('.title_show').html(js_lang.title);
                } else {
                    edit_area.find('.title_show').html($this.val());
                }
            });
        },
        image_show: function() {
            var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(0);
            $(document).unbind('change').on("change", 'input[name^="image_url"]', function() {
                $this = $(this);
                var index = $this.parents('.select_mobile_area').index() + 1;
                if ($this.val() == '') {
                    edit_area.eq(0).find('.show_image').html(js_lang.thumbnail);
                } else {
                    setTimeout(function() {
                        var src = $this.parents('.controls').find("img").attr('src');
                        var html = '<img src="' + src + '"/>';
                        edit_area.eq(0).find('.show_image').html(html);
                    }, 500);
                }
            });
        },
        img_item_click: function() {
            $('.img_item').off('click').on('click', function() {
                var $this = $(this),
                    child = $this.children('.img_item_bd');
                if (child.hasClass('selected')) {
                    child.removeClass('selected');
                    return false;
                }
                child.addClass('selected');
                $this.siblings('li').children('.img_item_bd').removeClass('selected');
            });
        },
        upload_multi_articles: function() {
            $('.article_handle').off('click').on('click', function(e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                $.post(url, function(data) {
                    ecjia.merchant.showmessage(data);
                })
            });
        },
        remove_child_article: function() {
            $("[data-toggle='remove_child_material']").off('click').on('click', function(e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                $.post(url, function(data) {
                    ecjia.merchant.showmessage(data);
                })
            });
        }
    };
})(ecjia.merchant, jQuery);
// end