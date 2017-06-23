// JavaScript Document
;(function (app, $) {
    app.article_list = {
        init: function () {
            /* 判断按纽是否可点 */
            $('.batch-btn').attr('disabled', 'disabled');
 
            //筛选功能
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&cat_id=' + $("#select-cat option:selected").val();
                ecjia.pjax(url);
            })
 
            //搜索功能
            $("form[name='searchForm'] .search_articles").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
            
            //批量转移
            app.article_list.batch_move_cat();
            app.article_list.toggle_view();
        },
        toggle_view: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('href');
                var val = $this.attr('data-val') || 'allow';
                var status = $this.attr('data-status');
                var article_id = $this.attr('data-id');
                var data = {
                    check: val,
                    status: status,
                    article_id: article_id
                }
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.post(url, data, function (data) {
                            	ecjia.merchant.showmessage(data);
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.post(url, data, function (data) {
                    	ecjia.merchant.showmessage(data);
                    }, 'json');
                }
            });
        },
        batch_move_cat: function () {
            var batch_url = $("a[name=move_cat_ture]").attr("data-url");
            $(".batch-move-btn").on('click', function (e) {
                var checkboxes = [];
                $(".checkbox:checked").each(function () {
                    checkboxes.push($(this).val());
                });
                if (checkboxes == '') {
                    smoke.alert(js_lang.select_moved_article);
                    return false;
                } else {
                    $('#movetype').modal('show');
                }
            });
            
            $("a[name=move_cat_ture]").on('click', function (e) {
                $('#movetype').modal('hide');
            });
            
            $("select[name=target_cat]").on('change', function (e) {
                var target_cat = $(this).val();
                $("a[name=move_cat_ture]").attr("data-url", batch_url + '&target_cat=' + target_cat);
            });
        }
    }
 
    /* 文章编辑新增js初始化 */
    app.article_info = {
        init: function () {
            //记录排序名称
            $('.move-mod-head').attr('data-sortname', 'article_info');
            
            //执行排序
            ecjia.merchant.set_sortIndex('article_info');
 
            app.article_info.submit_form();
            app.article_info.term_meta();
            app.article_info.term_meta_key();
        },
 
        submit_form: function (formobj) {
            var $form = $("form[name='infoForm']");
            var option = {
                rules: {
                    title: {
                        required: true
                    },
                    cat_id: {
                        required: true,
                        min: 1
                    },
                },
                messages: {
                    title: {
                        required: js_lang.article_title_required
                    },
                    cat_id: {
                        min: js_lang.no_select_cat
                    },
                },
                submitHandler: function () {
                    $form
                        .bind('form-pre-serialize', function (event, form, options, veto) {
                        (typeof (tinyMCE) != "undefined") && tinyMCE.triggerSave();
                    })
                        .ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
 
            // 注册百度编辑器快捷提交事件
            ecjia.editor_submit = function () {
                $form.submit();
            }
        },
 
        term_meta: function () {
            $('[data-toggle="add_term_meta"]').on('click', function (e) {
                e.preventDefault();
                var $add = $('.term_meta_add'),
                    key = $add.find('[name="term_meta_key"]').val(),
                    value = $add.find('[name="term_meta_value"]').val(),
                    id = $add.attr('data-id'),
                    extension_code = $add.attr('data-extension-code'),
                    active = $add.attr('data-active');
                $.post(active, 'article_id=' + id + '&extension_code=' + extension_code + '&key=' + key + '&value=' + value, function (data) {
                    ecjia.merchant.showmessage(data);
                }, 'JSON')
 
            });
            $('[data-toggle="edit_term_meta"]').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    $tr = $this.parents('tr'),
                    $edit = $('.term_meta_edit'),
                    key = $tr.find('[name="term_meta_key"]').val(),
                    value = $tr.find('[name="term_meta_value"]').val(),
                    meta_id = $tr.find('[name="term_meta_id"]').val(),
                    id = $edit.attr('data-id'),
                    extension_code = $edit.attr('data-extension-code'),
                    active = $edit.attr('data-active');
                $.post(active, 'article_id=' + id + '&meta_id=' + meta_id + '&key=' + key + '&value=' + value, function (data) {
                    ecjia.merchant.showmessage(data);
                }, 'JSON')
 
            });
        },
 
        term_meta_key: function () {
            $('select[data-toggle="change_term_meta_key"]').on('change', function (e) {
                e.preventDefault();
                var $this = $(this),
                    $input = $this.parents('.term_meta_add').find('input[name="term_meta_key"]'),
                    $checked = $this.find(':checked'),
                    value = $checked.val();
 
                $input.val(value);
            });
            $('[data-toggle="add_new_term_meta"]').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    $form = $this.parents('.term_meta_add'),
                    $select = $form.find('select[data-toggle="change_term_meta_key"]'),
                    value = $select.find(':checked').val(),
                    $input = $form.find('input[name="term_meta_key"]');
 
                if ($this.hasClass('new')) {
                    $this.removeClass('new').text(js_lang.add_new_columns);
                    // $this.parent().removeClass('p_t5');
                    $input.addClass('hide').val(value);
                    $select.next('.chzn-container').removeClass('hide');
                } else {
                    $this.addClass('new').text(js_lang.back_select_term);
                    // $this.parent().addClass('p_t5');
                    $input.removeClass('hide').val('');
                    $select.next('.chzn-container').addClass('hide');
                }
            });
        }
    }
 
    /* 关联商品 */
    app.link_goods = {
        init: function () {
            $(".nav-list-ready ,.ms-selection .nav-list-content").disableSelection();
            app.link_goods.search_link_goods();
            app.link_goods.del_link_article();
            app.link_goods.submit_link_article();
        },
 
        search_link_goods: function () {
            /* 查找商品 */
            $('[data-toggle="searchGoods"]').on('click', function () {
                var $choose_list = $('.goods_list'),
                    searchURL = $choose_list.attr('data-url');
                var filters = {
                    'JSON': {
                        'keyword': $choose_list.find('[name="keyword"]').val(),
                        'cat_id': $choose_list.find('[name="cat_id"] option:checked').val(),
                        'brand_id': $choose_list.find('[name="brand_id"] option:checked').val(),
                    }
                };
                $.get(searchURL, filters, function (data) {
                    app.link_goods.load_link_article_opt(data);
                }, "JSON");
            })
        },
 
        load_link_article_opt: function (data) {
            $('.nav-list-ready').html('');
            if (data.content.length > 0) {
                for (var i = 0; i < data.content.length; i++) {
                    var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.content[i].value + '"]').length ? 'disabled' : '';
                    var opt = '<li class="ms-elem-selectable ' + disable + '" id="articleId_' + data.content[i].value + '" data-id="' + data.content[i].value + '"><span>' + data.content[i].text + '</span></li>'
                    $('.nav-list-ready').append(opt);
                };
            } else {
                $('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.select_goods_empty + '</span></li>');
            }
            app.link_goods.search_link_article_opt();
            app.link_goods.add_link_article();
        },
 
        search_link_article_opt: function () {
            //li搜索筛选功能
            $('#ms-search').quicksearch(
                $('.ms-elem-selectable', '#ms-custom-navigation'), {
                onAfter: function () {
                    $('.ms-group').each(function (index) {
                        $(this).find('.isShow').length ? $(this).css('display', 'block') : $(this).css('display', 'none');
                    });
                    return;
                },
                show: function () {
                    this.style.display = "";
                    $(this).addClass('isShow');
                },
                hide: function () {
                    this.style.display = "none";
                    $(this).removeClass('isShow');
                },
            });
        },
 
        add_link_article: function () {
            $('.nav-list-ready li')
                .on('click', function () {
                var $this = $(this),
                    tmpobj = $('<li class="ms-elem-selection"><input type="hidden" name="goods_id[]" value="' + $this.attr('data-id') + '" />' + $this.text() +
                        '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>');
                if (!$this.hasClass('disabled')) {
                    tmpobj.appendTo($(".ms-selection .nav-list-content"));
                    $this.addClass('disabled');
                }
                //给新元素添加点击事件
                tmpobj.on('dblclick', function () {
                    $this.removeClass('disabled');
                    tmpobj.remove();
                }).find('i.del').on('click', function () {
                    tmpobj.trigger('dblclick');
                });
            });
        },
 
        del_link_article: function () {
            //给右侧元素添加点击事件
            $('.nav-list-content .ms-elem-selection').on('dblclick', function () {
                var $this = $(this);
                $(".nav-list-ready li").each(function (index) {
                    if ($(".nav-list-ready li").eq(index).attr('id') == 'articleId_' + $this.find('input').val()) {
                        $(".nav-list-ready li").eq(index).removeClass('disabled');
                    }
                });
                $this.remove();
            }).find('i.del').on('click', function () {
                $(this).parents('li').trigger('dblclick');
            });
        },
 
        submit_link_article: function () {
            //表单提交
            $('form[name="theForm"]').on('submit', function (e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var info = {
                    'linked_array': []
                };
                $('.nav-list-content li').each(function (index) {
                    var goods_id = $('.nav-list-content li').eq(index).find('input').val();
                    info.linked_array.push({
                        'goods_id': goods_id
                    });
                });
                $.get(url, info, function (data) {
                    ecjia.merchant.showmessage(data);
                });
            })
        }
    }
 
})(ecjia.merchant, jQuery);
 
// end