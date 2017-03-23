// JavaScript Document
;(function (app, $) {
    app.comment_manage = {
        init: function () {
            app.comment_manage.list_search();
            app.comment_manage.toggle_view();
            app.comment_manage.quick_reply();
            app.comment_manage.set_comment_config();
            app.comment_manage.approve();
        },
 
        list_search: function () {
        	  $(".no-show-status").on('click', function (e) {
                  $('.hide-status').hide();
              });
        	  $(".no-show-rank").on('click', function (e) {
                  $('.hide-rank').hide();
              });
        	  $(".no-show-img").on('click', function (e) {
                  $('.hide-img').hide();
              }); 
            $(".search_comment").on('click', function (e) {
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keyword']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        },
        
        toggle_view: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('href');
                var val = $this.attr('data-val') || 'allow';
                var status = $this.attr('data-status') || '';
                var data = {
                    check: val,
                    status: status
                }
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.post(url, data, function (data) {
                            	console.log(data);
                            	ecjia.admin.showmessage(data);
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.post(url, data, function (data) {
                    	console.log(data);
                    	ecjia.admin.showmessage(data);
                    }, 'json');
                }
            });
        },
        
        approve: function (option) {
            $('.approve').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('href');
                var val = $this.attr('data-val');
                var status = $this.attr('data-status');
                var data = {
                    check: val,
                    status: status
                }
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.post(url, data, function (data) {
                            	console.log(data);
                            	ecjia.admin.showmessage(data);
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.post(url, data, function (data) {
                    	console.log(data);
                    	ecjia.admin.showmessage(data);
                    }, 'json');
                }
            });
        },
        
        quick_reply: function () {			
            $(".quick_reply").on('click', function (e) {
                e.preventDefault();
                var url 	   = $(this).attr('data-url');
                var comment_id = $(this).attr('data-id');
                var status	   = $(this).attr('data-status');
                var list	   = $(this).attr('data-list');
                var data = {
                	reply_content: $("input[name='reply_content']").val(),
                	comment_id: comment_id,
                	list	  : list
                };
                $.get(url, data, function (data) {
                	ecjia.admin.showmessage(data);
                }, 'json');
            });
		},
		
		set_comment_config: function () {
			$('.info-toggle-button').toggleButtons({
				label: {  
                     enabled: "开启",  
                     disabled: "关闭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
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
		},
    }
    
    /*评论详情*/
    app.comment_manage_info = {
        init: function () {
            app.comment_manage_info.toggle_view_info();
            app.comment_manage_info.submit_info();
            app.comment_manage_info.remail();
        },
        
        toggle_view_info: function (option) {
            $('.toggle_view_info').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('href');
                var val = $this.attr('data-val') || 'reply_allow';
                var status = $this.attr('data-status') || '';
                var data = {
                    check: val,
                    status: status
                }
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.post(url, data, function (data) {
                            	ecjia.admin.showmessage(data);
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.post(url, data, function (data) {
                    	ecjia.admin.showmessage(data);
                    }, 'json');
                }
            });
        },
        
        submit_info: function () {
            var $this = $('form[name="theForm"]');
            var option = {
                rules: {
                    content: {
                        required: true
                    },
                    email: {
                        required: true
                    }
                },
                messages: {
                    content: {
                        required: ""
                    }
                },
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.state == "success") {
                                var url = $("form[name='theForm']").attr('data-edit-url');
                                ecjia.pjax(url, function () {
                                    ecjia.admin.showmessage(data);
                                });
                            }
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $this.validate(options);
        },
        
        remail: function () {
            $('#rmail').on('click', function () {
                if ($("textarea[name='content']").val() == "") {
                    var data = {
                        message: js_lang.content_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else {
                    var url = $(this).attr("data-url");
                    var email = $("input[name='email']").val();
                    var parent_id = $("input[name='parent_id']").val();
                    var comment_id = $("input[name='comment_id']").val();
                    var content = $("textarea[name='content']").val();
                    $.ajax({
                        type: "POST",
                        data: {
                            email: email,
                            parent_id: parent_id,
                            comment_id: comment_id,
                            content: content,
                            remail: 1
                        },
                        url: url,
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            });
        },
        
        star: function () {
            /* 评论等级 START */
            var Class = {
                create: function () {
                    return function () {
                        this.initialize.apply(this, arguments);
                    }
                }
            }
            var Extend = function (destination, source) {
                for (var property in source) {
                    destination[property] = source[property];
                }
            }
 
                function stopDefault(e) {
                    if (e && e.preventDefault) {
                        e.preventDefault();
                    } else {
                        window.event.returnValue = false;
                    }
                    return false;
                }
                /**
                 * 星星打分组件
                 *
                 * @author    Yunsd
                 * @date        2010-7-5
                 */
            var Stars = Class.create();
            Stars.prototype = {
                initialize: function (star, options) {
                    this.SetOptions(options); //默认属性
                    var flag = 999; //定义全局指针
                    var isIE = (document.all) ? true : false; //IE?
                    var starlist = document.getElementById("stars1").getElementsByTagName("a"); //星星列表
                    var input = document.getElementById(this.options.Input) || document.getElementById(star + "-input"); // 输出结果
                    var tips = document.getElementById(this.options.Tips) || document.getElementById(star + "-tips"); // 打印提示
                    var nowClass = " " + this.options.nowClass; // 定义选中星星样式名
                    var tipsTxt = this.options.tipsTxt; // 定义提示文案
                    var len = starlist.length; //星星数量
                    for (i = 0; i < len; i++) {
                        starlist[i].value = i;
                        starlist[i].onclick = function (e) {
                            stopDefault(e);
                            this.className = this.className + nowClass;
                            flag = this.value;
                            var value = this.getAttribute("data-value");
                            $("input[name='comment_rank']").val(value);
                        }
                        starlist[i].onmouseover = function () {
                            if (flag < 999) {
                                var reg = RegExp(nowClass, "g");
                                starlist[flag].className = starlist[flag].className.replace(reg, "")
                            }
                        }
                        starlist[i].onmouseout = function () {
                            if (flag < 999) {
                                starlist[flag].className = starlist[flag].className + nowClass;
                            }
                        }
                    };
                    if (isIE) { //FIX IE下样式错误
                        var li = document.getElementById(star).getElementsByTagName('li');
                        for (var i = 0, len = li.length; i < len; i++) {
                            var c = li[i];
                            if (c) {
                                c.className = c.getElementsByTagName('a')[0].className;
                            }
                        }
                    }
                },
                //设置默认属性
                SetOptions: function (options) {
                    this.options = {
                        Input: "",
                        Tips: "",
                        nowClass: "current-rating",
                        tipsTxt: [js_lang.one_level, js_lang.two_level, js_lang.three_level, js_lang.four_level, js_lang.five_level]
                    };
                    Extend(this.options, options || {});
                }
            }
            var Stars1 = new Stars("stars1");
            var Stars1 = new Stars("stars2");
            /* 评论等级 END */
        }
    }
 
    /* 选择评论商品 */
    app.comment_goods = {
        init: function () {
            app.comment_manage_info.star();
            app.comment_goods.userForm();
            app.comment_goods.submit_form();
        },
        
        submit_form: function () {
            var $this = $('form[name="goods_comment_form"]');
            var option = {
                rules: {
                    content: {
                        required: true
                    },
                },
                messages: {
                    content: {
                        required: ""
                    }
                },
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                        	ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $this.validate(options);
        },
        
        userForm: function () {
            //搜索会员信息
            $(".search_users").on("click", function () {
                var keyword = $("input[name='keyword']").val();
                var url = $("input[name='url']").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        keyword: keyword
                    },
                    dataType: "json",
                    success: function (data) {
                        $('.nav-list-ready').html('');
                        if (data.user.length > 0) {
                            for (var i = 0; i < data.user.length; i++) {
                                var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.user[i].value + '"]').length ? 'disabled' : '';
                                var opt = '<li class="ms-elem-selectable ' + disable + '" data-id="' + data.user[i].value +
                                    '" data-name="' + data.user[i].user_name + '"><span>' + data.user[i].user_name + '</span></li>'
                                $('.nav-list-ready').append(opt);
                            }
                        } else {
                            $('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.select_user_empty + '</span></li>');
                        }
                        app.comment_goods.search_opt();
                        app.comment_goods.click_search_user();
                    },
                    error: function () {
                        smoke.alert(js_lang.request_failed);
                    }
                })
            }),
            
            //搜索商品信息
            $(".search_goods").on("click", function () {
                var keywords = $("input[name='keywords']").val();
                var url = $("input[name='url_goods']").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        keywords: keywords
                    },
                    dataType: "json",
                    success: function (data) {
                        $('.nav-list-ready-goods').html('');
                        if (data.goods.length > 0) {
                            for (var i = 0; i < data.goods.length; i++) {
                                var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.goods[i].value + '"]').length ? 'disabled' : '';
                                var opt = '<li class="ms-elem-selectable ' + disable + '" data-id="' + data.goods[i].value +
                                    '" data-name="' + data.goods[i].goods_name + '"><span>' + data.goods[i].goods_name + '</span></li>'
                                $('.nav-list-ready-goods').append(opt);
                            }
                        } else {
                            $('.nav-list-ready-goods').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.select_goods_empty + '</span></li>');
                        }
                        app.comment_goods.search_opt_goods();
                        app.comment_goods.click_search_goods();
                    },
                    error: function () {
                        smoke.alert(js_lang.request_failed);
                    }
                })
            })
        },
        
        search_opt: function () {
            //li搜索筛选功能
            $('#ms-search').quicksearch(
                $('.ms-elem-selectable', '#serarch_user_list'), {
                onAfter: function () {
                    $('.ms-group').each(function () {
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
        
        search_opt_goods: function () {
            //li搜索筛选功能
            $('#ms-search-goods').quicksearch(
                $('.ms-elem-selectable', '#serarch_goods_list'), {
                onAfter: function () {
                    $('.ms-group').each(function () {
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
        
        click_search_user: function () {
            //点击搜索列表效果-----会员
            $('.select_user li').on('click', function () {
                var $this = $(this);
                $('.select_user li').removeClass('selected');
                $this.addClass('selected');
                var user_id = $this.attr('data-id');
                var user_name = $this.attr('data-name');
                $('.new_userinfo_wrap').show();
                $('.new_userinfo').text(user_name);
                $('input[name="user_id"]').val(user_id);
                $('input[name="user_name"]').val(user_name);
            });
        },
        
        click_search_goods: function () {
            //点击搜索列表效果-------商品
            $('.select_goods li').on('click', function () {
                var $this = $(this);
                $('.select_goods li').removeClass('selected');
                $this.addClass('selected');
                var goods_id = $this.attr('data-id');
                var goods_name = $this.attr('data-name');
                $('.new_goodsinfo_wrap').show();
                $('.new_goodsinfo').text(goods_name);
                $('input[name="goods_id"]').val(goods_id);
            });
        },
    },
 
 
    /* 选择评论文章 */
    app.comment_article = {
        init: function () {
            app.comment_manage_info.star();
            app.comment_article.userForm();
            app.comment_article.submit_form();
        },
        
        submit_form: function () {
            var $this = $('form[name="article_comment_form"]');
            var option = {
                rules: {
                    content: {
                        required: true
                    },
                },
                messages: {
                    content: {
                        required: ""
                    }
                },
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                        	ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $this.validate(options);
        },
        
        userForm: function () {
            //搜索会员信息
            $(".search_users").on("click", function () {
                var keyword = $("input[name='keyword']").val();
                var url = $("input[name='url']").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        keyword: keyword
                    },
                    dataType: "json",
                    success: function (data) {
                        $('.nav-list-ready').html('');
                        if (data.user.length > 0) {
                            for (var i = 0; i < data.user.length; i++) {
                                var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.user[i].value + '"]').length ? 'disabled' : '';
                                var opt = '<li class="ms-elem-selectable ' + disable + '" data-id="' + data.user[i].value +
                                    '" data-name="' + data.user[i].user_name + '"><span>' + data.user[i].user_name + '</span></li>'
                                $('.nav-list-ready').append(opt);
                            }
 
                        } else {
                            $('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.select_user_empty + '</span></li>');
                        }
                        app.comment_article.search_opt();
                        app.comment_article.click_search_user();
                    },
                    error: function () {
                        smoke.alert(js_lang.request_failed);
                    }
                })
            }),
            //搜索文章信息
            $(".search_goods").on("click", function () {
                var keywords = $("input[name='keywords']").val();
                var url = $("input[name='url_goods']").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        keywords: keywords
                    },
                    dataType: "json",
                    success: function (data) {
                        $('.nav-list-ready-goods').html('');
                        if (data.article.length > 0) {
                            for (var i = 0; i < data.article.length; i++) {
                                var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.article[i].value + '"]').length ? 'disabled' : '';
                                var opt = '<li class="ms-elem-selectable ' + disable + '" data-id="' + data.article[i].value +
                                    '" data-name="' + data.article[i].title + '"><span>' + data.article[i].title + '</span></li>'
                                $('.nav-list-ready-goods').append(opt);
                            }
 
                        } else {
                            $('.nav-list-ready-goods').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.select_goods_empty + '</span></li>');
                        }
                        app.comment_article.search_opt_article();
                        app.comment_article.click_search_article();
                    },
                    error: function () {
                        smoke.alert(js_lang.request_failed);
                    }
                })
            })
        },
        
        search_opt: function () {
            //li搜索筛选功能
            $('#ms-search').quicksearch(
                $('.ms-elem-selectable', '#serarch_user_list'), {
                onAfter: function () {
                    $('.ms-group').each(function () {
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
        
        search_opt_article: function () {
            //li搜索筛选功能
            $('#ms-search-goods').quicksearch(
                $('.ms-elem-selectable', '#serarch_goods_list'), {
                onAfter: function () {
                    $('.ms-group').each(function () {
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
        
        click_search_user: function () {
            //点击搜索列表效果-----会员
            $('.select_user li').on('click', function () {
                var $this = $(this);
                $('.select_user li').removeClass('selected');
                $this.addClass('selected');
                var user_id = $this.attr('data-id');
                var user_name = $this.attr('data-name');
                $('.new_userinfo_wrap').show();
                $('.new_userinfo').text(user_name);
                $('input[name="user_id"]').val(user_id);
                $('input[name="user_name"]').val(user_name);
            });
        },
        
        click_search_article: function () {
            //点击搜索列表效果-------文章
            $('.select_goods li').on('click', function () {
                var $this = $(this);
                $('.select_goods li').removeClass('selected');
                $this.addClass('selected');
                var article_id = $this.attr('data-id');
                var title = $this.attr('data-name');
                $('.new_goodsinfo_wrap').show();
                $('.new_goodsinfo').text(title);
                $('input[name="article_id"]').val(article_id);
            });
        },
    }
    
})(ecjia.admin, jQuery);
 
// end