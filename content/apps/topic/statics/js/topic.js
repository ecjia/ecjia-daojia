// JavaScript Document
;(function (app, $) {
    app.topic_list = {
        init: function () {
            /* 判断按纽是否可点 */
            $('.batch-btn').attr('disabled', 'disabled');
            //搜索功能
            $("form[name='searchForm'] .search_topic").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                	url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        }
    };
 
    /* **编辑** */
    app.topic_edit = {
        topic_info_init: function (get_value) {
            $(".date").datepicker({
                format: "yyyy-mm-dd"
            });
            var type = $("input[name='topic_img_type']:checked").val();
            if (type == 1) {
                $('#show_src').css("display", "none");
                $("#show_local").css("display", "block");
            }
 
            var type2 = $("input[name='title_pic_type']:checked").val();
            if (type2 == 1) {
                $('#show_src2').css("display", "none");
                $("#show_local2").css("display", "block");
            }
 
            $("input[name='topic_img_type']").click(function () {
                var topicimg_type = $(this).val();
                if (topicimg_type == 0) {
                    $('#show_src').css("display", "block");
                    $('#show_local').css("display", "none");
                } else {
                    $('#show_src').css("display", "none");
                    $("#show_local").css("display", "block");
                }
            });
 
            $("input[name='title_pic_type']").click(function () {
                var titlepic_type = $(this).val();
                if (titlepic_type == 0) {
                    $('#show_src2').css("display", "block");
                    $('#show_local2').css("display", "none");
                } else {
                    $('#show_src2').css("display", "none");
                    $("#show_local2").css("display", "block");
                }
            });
 
            $("#topic_type").change(function () {
                $(this).children().each(function (i) {
                    $("#topic_type_" + $(this).val()).hide();
                })
                $("#topic_type_" + $(this).val()).show();
            });
            app.topic_edit.colorpicker();
            app.topic_edit.submit_form();
        },
 
        colorpicker: function () {
            $('#cp1').colorpicker({
                format: 'hex'
            });
        },
 
        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    topic_name: {
                        required: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    }
                },
                messages: {
                    topic_name: {
                        required: js_lang.topic_name_required
                    },
                    start_time: {
                        required: js_lang.start_time_required
                    },
                    end_time: {
                        required: js_lang.end_time_required
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
 
    /* **添加专题分类** */
    app.link_cat = {
        init: function (get_value) {
            var $form = $("form[name='theForm']");
            var option = {
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
 
    /*加载商品 */
    app.link_goods = {
        init: function () {
            $(".nav-list-ready ,.ms-selection .nav-list-content").disableSelection();
            app.link_goods.selectcat();
            app.link_goods.search_link_goods();
            app.link_goods.del_link_article();
            app.link_goods.submit_form();
        },
 
        selectcat: function () {
            $("#topic_cat_select").change(function () {
                $('.nav-list-ready').html('');
                var val = $("#topic_cat_select option:selected").val();
                $("#target_select li").each(function (i) {
                    var aa = $(this).attr("data-key");
                    if (aa == val) {
                        $(this).removeClass('hide').addClass('isShow');
                    } else {
                        $(this).addClass('hide').removeClass('isShow');
                    }
                });
            });
        },
 
        search_link_goods: function () {
            /* 查找商品 */
            $('[data-toggle="searchGoods"]').on('click', function () {
                var $choose_list = $(this).parents('[data-url]'),
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
                    var disable = $('.nav-list-content .ms-elem-selection').not('.hide').find('input[data-value="' + data.content[i].value + '"]').length ? 'disabled' : '';
                    var opt = '<li class="ms-elem-selectable ' + disable + '" id="articleId_' + data.content[i].value +
                        '" data-id="' + data.content[i].value + '"><span>' + data.content[i].text + '</span></li>'
                    $('.nav-list-ready').append(opt);
                };
            } else {
                $('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.no_message + '</span></li>');
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
                var val = $("#topic_cat_select option:selected").val();
                var $this = $(this),
                    tmpobj = $('<li class="ms-elem-selection"><input type="hidden" name="goods_id[' + val + '_' + $this.attr('data-id') + 
                    	']" value="' + $this.text() + '|' + $this.attr('data-id') + '" />' 
                    	+ $this.text() + '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>');
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
                    if ($(".nav-list-ready li").eq(index).attr('id') == 'articleId_' + $this.find('input').attr('data-value')) {
                        $(".nav-list-ready li").eq(index).removeClass('disabled');
                    }
                });
                $this.remove();
            }).find('i.del').on('click', function () {
                $(this).parents('li').trigger('dblclick');
            });
        },
 
        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
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
    }
    
})(ecjia.admin, jQuery);
 
// end