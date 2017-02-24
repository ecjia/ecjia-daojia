// JavaScript Document
;(function (app, $) {
    app.mobile_news = {
        info: function () {
            app.mobile_news.clone();
            app.mobile_news.edit_area();
            app.mobile_news.remove_area();
            app.mobile_news.form_submit();
            app.mobile_news.title_show();
            app.mobile_news.image_show();
            app.mobile_news.issue_submit();
        },
        
        clone: function () {
            $('a[data-toggle="clone-object"]').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    $parentobj = $($this.attr('data-parent')),
                    $parentobj_clonearea = $($this.attr('data-clone-area'))
                    before = $this.attr('data-before') || 'before',
                    $childobj = $($this.attr('data-child')),
                    $childobj_clonearea = $($this.attr('data-child-clone-area')),
                    option = {
                        parentobj: $parentobj,
                        parentobj_clonearea: $parentobj_clonearea,
                        before: before,
                        childobj: $childobj,
                        childobj_clonearea: $childobj_clonearea
                    };
                !$parentobj ? console.log(js_lang.not_set_parameter) : app.mobile_news.clone_object(option);
            });
        },
 
        clone_object: function (options) {
            if (!options.parentobj) return console.log(js_lang.operate_miss_parameter);
            var tmpObj = options.parentobj.clone();
            tmpObj.removeClass('ecjiaf-dn');
            tmpObj.removeClass('mobile_news_auxiliary_clone');
 
            (options.before == 'before') ? options.parentobj_clonearea.before(tmpObj) : options.parentobj_clonearea.after(tmpObj);
 
            if (options.childobj && options.childobj_clonearea) {
                var clone_child = options.childobj.clone();
                clone_child.removeClass('ecjiaf-dn').removeClass('mobile_news_editarea_clone');
                var size = options.childobj_clonearea.children('div').size() + 1;
 
                if (size >= 9) {
                    var error = {
                        'message': js_lang.most_eight,
                        'state': 'error'
                    };
                    ecjia.admin.showmessage(error);
                    return false;
                }
                clone_child.children('h4').html(js_lang.mobile_news + size);
                num = size - 1;
                clone_child.find('input[type="radio"]').each(function (i) {
                    $(this).attr('name', $(this).attr('data-name') + '_' + num + '[]');
                });
                options.childobj_clonearea.append(clone_child);
            }
            //清空默认数据
            options.parentobj.find('input').not(":hidden").val('');
            $(".nouniform").uniform();
            //编辑区域展示效果js
            app.mobile_news.edit_area_show(num);
        },
        
        edit_area_show: function (num) {
            $('.mobile_news_edit').children().addClass('ecjiaf-dn').eq(num).removeClass('ecjiaf-dn');
        },
        
        edit_area: function () {
            $('.icon-pencil').die('click').live('click', function () {
                var index = $(this).parents('.select_mobile_area').index();
                app.mobile_news.edit_area_show(index);
            });
        },
        
        remove_area: function () {
            $('.icon-trash').die('click').live('click', function () {
                if ($(this).parent('a').hasClass('ajaxremove')) {
                    return;
                }
                var index = $(this).parents('.select_mobile_area').index();
                $('.mobile_news_edit').children().eq(0).removeClass('ecjiaf-dn');
                $('.mobile_news_edit').children('.mobile_news_edit_area').eq(index).remove();
            });
        },
        
        issue_submit: function () {
            $('.issue').on('click', function (e) {
                var url = $(this).attr('data-url');
                $.get(url, function (data) {
                    ecjia.admin.showmessage(data);
                }, 'json');
            });
        },
        
        form_submit: function () {
            $('form[name="theForm"]').submit(function (e) {
                e.preventDefault();
                var flog = false;
                $('.mobile_news_edit').children().find('input[name^="title"]').each(function (i) {
                    if ($(this).val() == '') {
                        num = i + 1;
                        $('.mobile_news_edit').children().addClass('ecjiaf-dn').eq(0).removeClass('ecjiaf-dn');
                        var error = {
                            'message': js_lang.enter_mobile_news + num + js_lang.the_title,
                            'state': 'error'
                        };
                        ecjia.admin.showmessage(error);
                        flog = true;
                        return false;
                    }
                });
                if (flog) {
                    return false;
                }
                $('.mobile_news_edit').children().find('.thumbnail').each(function (i) {
                    if ($(this).children().length <= 0) {
                        num = i + 1;
                        $('.mobile_news_edit').children().addClass('ecjiaf-dn').eq(0).removeClass('ecjiaf-dn');
                        var error = {
                            'message': js_lang.upload_mobile_news + num + js_lang.the_cover,
                            'state': 'error'
                        };
                        ecjia.admin.showmessage(error);
                        flog = true;
                        return false;
                    }
                    var val = $("input[name='max_id']").val();
                    if (val != undefined) {
                        var j = $('.mobile_news_edit').children().eq(i).find('input[name="url"]').val();
                        if (j == undefined) {
                            var src = $(this).children().attr('src');
                            if (src.indexOf("http://") < 0) {
                                var value = parseInt(val) + 1;
                                $("input[name='max_id']").val(value);
                                $('.mobile_news_edit').children().eq(i).find('input[name="image_url[]"]').attr('name', 'image_url[' + value + ']');
                            }
                        }
                    }
                });
                if (flog) {
                    return false;
                }
                $('.mobile_news_edit').children().find('textarea[name^="description"]').each(function (i) {
                    if ($(this).val() == '') {
                        num = i + 1;
                        $('.mobile_news_edit').children().addClass('ecjiaf-dn').eq(0).removeClass('ecjiaf-dn');
                        var error = {
                            'message': js_lang.enter_mobile_news + num + js_lang.the_abstract,
                            'state': 'error'
                        };
                        ecjia.admin.showmessage(error);
                        flog = true;
                        return false;
                    }
                });
                if (flog) {
                    return false;
                }
                $('.mobile_news_edit').children().find('input[name^="content_url"]').each(function (i) {
                    if ($(this).val() == '') {
                        num = i + 1;
                        $('.mobile_news_edit').children().addClass('ecjiaf-dn').eq(0).removeClass('ecjiaf-dn');
                        var error = {
                            'message': js_lang.enter_mobile_news + num + js_lang.the_graphic_link,
                            'state': 'error'
                        };
                        ecjia.admin.showmessage(error);
                        flog = true;
                        return false;
                    }
                });
                if (flog) {
                    return false;
                }
 
                $(this).ajaxSubmit({
                    dataType: "json",
                    success: function (data) {
                        ecjia.admin.showmessage(data);
                    }
                });
            });
        },
        
        title_show: function () {
            $('input[name^="title"]').live('keyup', function () {
                var index = $(this).parents('.mobile_news_edit_area').index();
                if ($(this).val() == '') {
                    $('.select_mobile_area').eq(index).find('.title_show').html(js_lang.title);
                } else {
                    $('.select_mobile_area').eq(index).find('.title_show').html($(this).val());
                }
            });
        },
        
        image_show: function () {
            $('input[name^="image_url"]').live('change', function () {
                var index = $(this).parents('.mobile_news_edit_area').index();
                $this = $(this);
                if ($(this).val() == '') {
                    $('.select_mobile_area').eq(index).find('.show_image').html(js_lang.title);
                } else {
                    setTimeout(function () {
                        var src = $this.parents('.controls').find("img").attr('src');
                        var html = '<img src="' + src + '"/>';
                        $('.select_mobile_area').eq(index).find('.show_image').html(html);
                    }, 500);
                }
            });
        },
    }
    
})(ecjia.admin, jQuery);
 
// end