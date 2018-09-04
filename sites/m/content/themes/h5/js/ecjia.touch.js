/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {
    ecjia.touch = {
        init: function () {
            if ($.cookie('h5_index') === undefined || $.cookie('longitude') === undefined || $.cookie('latitude') === undefined) {
                var key = $("input[name='key']").val();
                var referer = $("input[name='referer']").val();
                var geolocation = new qq.maps.Geolocation(key, referer);
                geolocation.getLocation(showPosition, showErr);

                function showPosition(result) {
                    var lat = result.lat;
                    var lng = result.lng;
                    var url = $("#get_location").attr('data-url');
                    url += '&lat=' + lat + '&lng=' + lng;
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            ecjia.pjax(data.url);
                        },
                    });
                };

                function showErr(err) {
                    console.log(err);
                };
                var date = new Date();
                date.setTime(date.getTime() + (30 * 60 * 1000));
                $.cookie('h5_index', 'first', {
                    expires: date
                });
            }

            ecjia.touch.setpjax();
            ecjia.touch.asynclist();
            ecjia.touch.ecjia_menu();
            ecjia.touch.region_change();
            ecjia.touch.selectbox();
            ecjia.touch.valid();
            ecjia.touch.toggle_collapse();
            ecjia.touch.close_banner();
            ecjia.touch.close_app_download();
            ecjia.touch.search_header();
            ecjia.touch.del_history();
            ecjia.touch.copy_btn();
            ecjia.touch.clear_cache();
            ecjia.touch.select_city();

            $("body").greenCheck();
        },

        //搜索关键词定位开始
        address_list: function () {
            $('#search_location_list').koala({
                delay: 300,
                keyup: function (event) {
                    var url = $(this).attr('data-url');
                    var region = $(".ecjia-zu").children().html();
                    var keywords = $("input[name='address']").val();
                    if (region != 'undefined') {
                        url += '&region=' + region
                    }
                    if (keywords != 'undefined') {
                        url += '&keywords=' + keywords;
                    }
                    if (keywords == '') {
                        $('.ecjia-zw').show();
                        $('.ecjia-list.ecjia-address-list.ecjia-select-address').show();
                        $('.ecjia-location-list-wrap.near-location-list').show();
                        $('.ecjia-location-list-wrap.location-search-result').html('');
                        $('.ecjia-near-address').show();
                    } else {
                        $('.ecjia-zw').hide();
                        $('.ecjia-list.ecjia-address-list.ecjia-select-address').hide();
                        $('.ecjia-location-list-wrap.near-location-list').hide();
                        $('.ecjia-location-list-wrap.location-search-result').html('');
                        $('.ecjia-near-address').hide();
                    }
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            ecjia.touch.address_value(data.content.data);
                        },
                    });
                }
            });
            ecjia.touch.add_link();
        },

        address_value: function (data) {
            if (data) {
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        var opt = '<li data-lng="' + data[i].location.lng + '" data-lat="' + data[i].location.lat + '"><p class="list_wrapper a1"><span class="ecjia-list_title ecjia-location-list-title">' + data[i].title + '</span><span class="ecjia-list_title ecjia-location-list-address">' + data[i].address + '</span></p></li>'
                        $('.ecjia-location-list-wrap.location-search-result').append(opt);
                    };
                }
            }
            ecjia.touch.add_link();
        },

        //点击搜索结果事件
        add_link: function () {
            var type = $("#ecjia-zs").attr('data-type');
            if (type == 'index') {
                var Uarry = $(".ecjia-location-list-wrap li");
                $('.ecjia-location-list-wrap li').bind('click', function () {
                    var lng = $(this).attr("data-lng");
                    var lat = $(this).attr("data-lat");
                    var count = $(this).index();
                    var Tresult = Uarry.eq(count).text();
                    var title = $(this).children().children("span[class*='ecjia-location-list-title']").html();
                    var address = $(this).children().children("span[class*='ecjia-location-list-address']").html();
                    var city_id = $('input[name="city_id"]').val();
                    var city_name = $('input[name="city_name"]').val();

                    var date = new Date();
                    date.setTime(date.getTime() + (30 * 60 * 1000));

                    $.cookie('location_address', address, {
                        expires: date
                    });
                    $.cookie('location_name', title, {
                        expires: date
                    });
                    $.cookie('longitude', lng, {
                        expires: date
                    });
                    $.cookie('latitude', lat, {
                        expires: date
                    });
                    $.cookie('location_address_id', 0, {
                        expires: date
                    });

                    $.cookie('city_id', city_id, {
                        expires: date
                    });
                    $.cookie('city_name', city_name, {
                        expires: date
                    });

                    var referer_url = $.cookie('referer_url');
                    var url = $("#ecjia-zs").attr('data-url');
                    if (referer_url != undefined && referer_url.length != 0) {
                        url = referer_url;
                    }
                    ecjia.pjax(url);
                    $.cookie('referer_url', '', 1);
                });
            } else if (type == 'address') {
                $('.ecjia-location-list-wrap li').bind('click', function () {
                    var lng = $(this).attr("data-lng");
                    var lat = $(this).attr("data-lat");
                    var title = $(this).find(".ecjia-location-list-title").text();
                    var address = $(this).find(".ecjia-location-list-address").text();
                    var url = $("#ecjia-zs").attr('data-url');
                    url += '&addr=' + address + '&name=' + title + '&latng=' + lat + ',' + lng;
                    ecjia.pjax(url);
                });
            }
        },
        //搜索关键词定位结束

        copy_btn: function () {
            var clipboard = new Clipboard('.copy-btn');
            clipboard.on('success', function (e) {
                alert("复制成功！");
            });
        },

        clear_cache: function () {
            $('.clear_cache').off('click').on('click', function () {
                var $this = $(this),
                    url = $this.attr('data-url'),
                    message = $this.attr('data-message');

                var myApp = new Framework7();
                myApp.modal({
                    title: message,
                    buttons: [{
                        text: '取消',
                        onClick: function () {
                            $('.modal').remove();
                            $('.modal-overlay').remove();
                            return false;
                        }
                    }, {
                        text: '确定',
                        onClick: function () {
                            sessionStorage.clear();
                            $.post(url, function (data) {
                                var refresh_url = data.url;
                                iosOverlay({
                                    text: '清除缓存中，请稍后...',
                                    duration: 2e3,
                                });
                                setTimeout(function () {
                                    location.href = refresh_url;
                                }, 50);
                            });
                        },
                    }]
                });
            });
        },

        select_city: function () {
            var history_city = $.localStorage('history_city');
            if (history_city != undefined) {
                history_city = JSON.parse(history_city);
                var html = '<h2 class="history-city-title"><span>历史访问城市</span></h2><ul class="history-city-list">';
                for (var i = history_city.length - 1; i >= 0; i--) {
                    html += '<li class="data-li"><p class="select-city-li" data-id=' + history_city[i].id + '>' + history_city[i].city_name + '</p></li>';
                }
                html += '</ul>';
                $('.ecjia-history-city').html(html);
            }

            var height = $(window).height();
            var letter_height = $('.letter').height();
            var top = (height - letter_height) / 2;
            $('.letter').css('top', top);

            $('.select-city-li').off('click').on('click', function () {
                var $this = $(this);
                var id = $this.attr('data-id');
                var city_name = $this.text();
                var address_id = $('input[name="address_id"]').val();
                var url = $("#cityall").attr('data-url');

                var date = new Date();
                date.setTime(date.getTime() + (30 * 60 * 1000));

                var city = {
                    id: id,
                    city_name: city_name
                };
                var history_city = $.localStorage('history_city');
                var push = 1;

                if (history_city == undefined) {
                    history_city = [];
                } else {
                    history_city = JSON.parse(history_city);
                    //重复的不追加
                    for (var i = history_city.length - 1; i >= 0; i--) {
                        if (history_city[i].id == id) {
                            push = 0;
                            break;
                        }
                    }
                }
                if (push == 1) {
                    //超过3个 删除首个
                    if (history_city.length == 3) {
                        history_city.shift();
                    }
                    history_city.push(city);
                }
                history_city = JSON.stringify(history_city);
                //存入缓存
                $.localStorage('history_city', history_city);

                if (id) {
                    $.cookie('city_id', id, {
                        expires: date
                    });
                    $.cookie('city_name', city_name, {
                        expires: date
                    });
                    url += '&city_id=' + id;
                }
                if (address_id) {
                    url += '&id=' + address_id;
                }
                ecjia.pjax(url);
            });

            //点击索引查询城市
            $('.letter a').off('click').on('click', function () {
                var s = $(this).html();
                var top = $(this).attr('data-top');
                if (top == 'top') {
                    $('html,body').stop(true, false).animate({
                        scrollTop: 0
                    }, 500);
                } else {
                    if ($('#' + s + '1').offset() == undefined) {
                        return false;
                    }
                    var top = $('#' + s + '1').offset().top;
                    $('html,body').stop(true, false).animate({
                        scrollTop: top
                    }, 500);
                    $("#showLetter span").html(s);
                    $("#showLetter").show().delay(1000).hide(0);
                }
            });

            //中间的标记显示
            $('body').on('onMouse', '.showLetter span', function () {
                $("#showLetter").show().delay(500).hide(0);
            });
        },

        /**
         * 设置PJAX
         */
        setpjax: function () {
            /* PJAX基础配置项 */
            ecjia.pjaxoption = {
                timeout: 10000,
                container: '.ecjia',
                /* 内容替换的容器 */
                cache: false,
                /* 是否使用缓存 */
                storage: false,
                /* 是否使用本地存储 */
                titleSuffix: '.pjax' /* 标题后缀 */
            };

            /* ecjia.pjax */
            ecjia.extend({
                pjax: function (url, callback) {
                    var option = $.extend(ecjia.pjaxoption, {
                        url: url,
                        callback: function () {
                            if (typeof (callback) === 'function') callback();
                        }
                    });
                    $.pjax(option);
                    delete ecjia.pjaxoption.url;
                }
            });
            /* pjax刷新当前页面 */
            ecjia.pjax.reload = function () {
                $.pjax.reload(ecjia.pjaxoption.container, ecjia.pjaxoption);
            };
            /* 移动pjax方法的调用，使用document元素委派pjax点击事件 */
            if ($.support.pjax) {
                $(document).on('click', 'a:not(.nopjax)', function (event) {
                    $.pjax.click(event, ecjia.pjaxoption.container, ecjia.pjaxoption);
                });
            }
        },

        pjaxloadding: function () {
            //增加一个加载动画
            $('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
        },

        /**
         * 展示信息，成功和失败。
         */
        showmessage: function (options) {
            var defaults = {
                message: false,
                /* message 提示信息 */
                is_show: true,
                /* message 提示信息 */
                state: 'success',
                /* state 信息状态 */
                links: false,
                /* links 链接对象 */
                close: true,
                /* close 是否可以关闭 */
                pjaxurl: '' /* pjax刷新页面后显示message的时候传递的pjaxURL参数 */
            };

            var options = $.extend({}, defaults, options);
            options.message && options.is_show && alert(options.message);
            options.pjaxurl && ecjia.pjax(options.pjaxurl);
        },

        alert: function (text) {
            var app = new Framework7({
                modalButtonOk: "确定",
                modalTitle: ''
            });
            app.alert(text);
        },

        /**
         * 加载列表的触发器方法
         */
        asynclist: function () {
            if ($('[data-toggle="asynclist"]').length) {
                var $this = $('[data-toggle="asynclist"]'),
                    options = {
                        areaSelect: '[data-toggle="asynclist"]',
                        areaClass: $this.attr('class'),
                        url: $this.attr('data-url'),
                        size: $this.attr('data-size'),
                        page: $this.attr('data-page'),
                        type: $this.attr('data-type'),
                        color: $this.attr('data-color')
                    };
                ecjia.touch.more(options);
                $loader = $('<a class="load-list" style="background-color:' + options.color + '" href="javascript:;"><div class="loaders"><div class="loader"><div class="loader-inner ball-pulse"><div></div><div></div><div></div></div></div></div></a>');
                if ($this.parent().find('.load-list').length == 0) {
                    $this.after($loader);
                }
            }
        },

        /**
         * 加载列表方法
         */
        more: function (options) {
            $('.is-last').remove();
            $(window).scrollTop(0);
            var defaults = {
                    url: false, //url 			请求地址
                    page: 1, //page			分页
                    size: 10, //size			分页数量
                    areaSelect: '#J_ItemList', //areaSelect	模块select
                    areaClass: '', //areaClass		模块class
                    scroll: true, //scroll		滑动加载
                    offset: 100, //offset		滑动预留
                    trigger: '.load-list', //trigger		点击的触发器
                    lock: false, //lock			锁
                    type: '', //type			类型
                },
                options = $.extend({}, defaults, options),
                scroll_list = function () {
                    if (!options.lock && ($(window).scrollTop() > $(document).height() - $(window).height() - options.offset)) {
                        var area_class = options.areaClass;
                        options.areaClass = options.areaClass.replace(new RegExp(' ', 'gm'), '.'); //替换空格为点，多个class
                        if ($('.' + options.areaClass).parent().find('.is-last').length != 0) {
                            return false;
                        }
                        options.areaClass = area_class;

                        options.lock = true;
                        ecjia.touch.load_list(options);
                        options.page++;
                    }
                };
            scroll_list();
            if (options.scroll) {
                window.onscroll = function () {
                    scroll_list();
                };
                $('.wd').scroll(function () {
                    if ($(this).find('.is-last').length != 0) {
                        return false;
                    }
                    scroll_list();
                });
                $('.store-container').scroll(function () {
                    scroll_list();
                });
            } else {
                var add_more_btn = '<button id="load_more_btn" class="btn btn-default btn-lg">点击加载更多</button>';
                $('[data-flag="add_load_more_btn"]').after(add_more_btn);
                $("#load_more_btn").on("click", function () {
                    scroll_list();
                    $(this).attr("data-scroll", "false");
                });
            }
        },
        more_callback: function () {
            ecjia.touch.delete_list_click();
        },

        /**
         * 数据操作方法
         */
        load_list: function (options) {
            if (!options.url) return console.log('缺少参数！');
            $(options.trigger).show();
            if ($('[data-toggle="asynclist"]').attr('class') == options.areaClass) {
                $('[data-toggle="asynclist"]').attr('data-page', parseInt(options.page) + 1);
            }
            $.get(options.url, {
                page: options.page,
                size: options.size,
                action_type: options.type
            }, function (data) {
                if ($(options.areaSelect).hasClass(options.areaClass)) {
                    var area_class = options.areaClass;
                    options.areaClass = options.areaClass.replace(new RegExp(' ', 'gm'), '.'); //替换空格为点，多个class
                    $('.' + options.areaClass).append(data.list);
                    options.areaClass = area_class;
                }
                options.lock = data.is_last;
                $(options.trigger).hide();
                if (data.is_last == 1) {
                    $(options.trigger).addClass('is-last');
                    $("#load_more_btn").remove();
                }
                if (data.spec_goods) {
                    if (window.releated_goods != undefined) {
                        $.extend(window.releated_goods, data.spec_goods);
                    } else {
                        window.releated_goods = data.spec_goods;
                    }
                }
                ecjia.touch.more_callback();
                var list_length = $.trim(data.list).length;
                ecjia.touch.update_hot_time(list_length);
                ecjia.touch.category.add_tocart();
                ecjia.touch.category.remove_tocart();
                ecjia.touch.category.store_toggle();
                ecjia.touch.record_time();
                ecjia.touch.category.image_preview();
                ecjia.touch.user.cancel_order();
            });
        },

        record_time: function () {
            var date = new Date;
            var year = date.getFullYear();
            for (var i = 2017; i <= year; i++) {
                for (var j=1; j<13; j++) {
                    if (j<10) {
                        j = '0' + j;
                    }
                    $('.record-time-'+ i + "-" + j +':first').show();
                }
            }
        },

        delete_list_click: function () {
            $(document).off('click', '[data-toggle="del_list"]');
            $(document).on('click', '[data-toggle="del_list"]', function (e) {
                e.preventDefault();
                var $this = $(this),
                    id = $this.attr('data-id'),
                    msg = $this.attr('data-msg') ? $this.attr('data-msg') : '您确定要删除此条信息吗？',
                    url = $this.attr('data-url');
                if (id && url) {
                    var myApp = new Framework7({
                        modalButtonCancel: '取消',
                        modalButtonOk: '确定',
                        modalTitle: ''
                    });
                    myApp.confirm(msg, function () {
                        ecjia.touch.delete_list({
                            id: id,
                            url: url
                        });
                    });
                }
            });
        },

        delete_list: function (options) {
            $.get(options.url, {
                id: options.id
            }, function (data) {
                ecjia.touch.showmessage(data);
            }, 'json');
        },

        /* 下方相关商品滑动块的JS */
        touch_slide: function () {
            TouchSlide({
                slideCell: "#picScroll",
                titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                autoPage: "true", //自动分页
                pnLoop: "false", // 前后按钮不循环
                switchLoad: "_src" //切换加载，真实图片路径为"_src"
            });
        },

        region_change: function () {
            $('[data-toggle="region_change"]').on('change', function () {
                var $this = $(this),
                    id = $this.attr("id"),
                    index = $this.attr("data-index") || '',
                    url = $this.attr("data-url"),
                    type = $this.attr("data-type"),
                    target = $this.attr("data-target"),
                    parent = $this.val();
                if ($("#selCountries" + index).val() == 0) {
                    $("#selProvinces" + index).children("option:gt(0)").remove();
                    $("#selCities" + index).children("option:gt(0)").remove();
                    $("#selDistricts" + index).children("option:gt(0)").remove();
                    //$("#selDistricts"+index).hide();
                } else {
                    if (id == "selCountries" + index) {
                        //$("#selDistricts"+index).hide();
                    } else if (id == "selProvinces") {
                        //$("#selDistricts"+index).hide();
                        if ($("#selProvinces" + index).val() == 0) {
                            $("#selCities" + index).children("option:gt(0)").remove();
                        }
                    } else if (id == "selCities") {
                        //$("#selDistricts"+index).show();
                        if ($("#selCities" + index).val() == 0) {
                            $("#selDistricts" + index).children("option:gt(0)").remove();
                        }
                    }
                    $.get(url, {
                        'type': type,
                        'target': target,
                        'parent': parent
                    }, function (data) {
                        if (data.state == 'success') {
                            var opt = '';
                            for (var i = 0; i < data.regions.length; i++) {
                                opt += '<option value="' + data.regions[i].region_id + '">' + data.regions[i].region_name + '</option>';
                            }
                            if (id == "selCountries" + index) {
                                $("#selProvinces" + index).children("option:gt(0)").remove();
                                $("#selProvinces" + index).children("option").after(opt);
                            } else if (id == "selProvinces" + index) {
                                $("#selCities" + index).children("option:gt(0)").remove();
                                $("#selCities" + index).children("option").after(opt);
                            } else if (id == "selCities" + index) {
                                $("#selDistricts" + index).children("option:gt(0)").remove();
                                $('#selDistricts').show();
                                $("#selDistricts" + index).children("option").after(opt);
                            }
                        } else {
                            ecjia.touch.showmessage(data);
                        }
                    }, 'json');
                }

            });

            $('[data-toggle="choose_address"]').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    url = $this.attr('href'),
                    referer = $this.attr('data-referer');
                if ($this.hasClass('disabled')) {
                    return false;
                }
                $('[data-toggle="choose_address"]').addClass('disabled');
                if (url == undefined) {
                    iosOverlay({
                        text: '该地址超出配送范围',
                        duration: 2e3,
                        onbeforehide: function () {
                            $('[data-toggle="choose_address"]').removeClass('disabled');
                        },
                    });
                    return false;
                }
                if (referer != undefined) {
                    referer = encodeURIComponent(referer);
                    url += '&referer_url=' + referer;
                }
                $.get(url, function (data) {
                    ecjia.pjax(data.pjaxurl);
                });
            })
        },

        ecjia_menu: function () {
            $(document).off('click', '.ecjia-menu .main');
            $(document).on('click', '.ecjia-menu .main', function () {
                if ($('.ecjia-menu').hasClass('active')) {
                    $('.ecjia-menu').removeClass('active');
                } else {
                    $('.ecjia-menu').addClass('active');
                }
            });
            var _x_start, _y_start, _x_move, _y_move, _x_end, _y_end, left_start, bottom_start, top_start;
            var length = $('.ecjia-menu').length;
            if (length > 0) {
                document.getElementById("ecjia-menu").addEventListener('touchstart', function (e) {
                    _x_start = e.touches[0].pageX;
                    _y_start = e.touches[0].pageY;
                    left_start = $("#ecjia-menu").css("left");
                    bottom_start = $("#ecjia-menu").css("bottom");
                    top_start = $("#ecjia-menu").offset().top - $("body").scrollTop();
                    //阻止浏览器下拉事件
                    $('body').css('overflow-y', 'hidden');
                    window.addEventListener('touchmove', function (event) {
                        event.preventDefault;
                    }, false);
                });
                document.getElementById("ecjia-menu").addEventListener('touchmove', function (e) {
                    _x_move = e.touches[0].pageX;
                    _y_move = e.touches[0].pageY;
                    //$("#ecjia-menu").css("left", parseFloat(_x_move)-parseFloat(_x_start)+parseFloat(left_start)+"px");
                    var bottom = parseFloat(_y_start) - parseFloat(_y_move) + parseFloat(bottom_start);
                    var top = parseFloat(_y_move) - parseFloat(_y_start) + parseFloat(top_start);
                    if (bottom < 100 || top < 250) {
                        return false;
                    }
                    $("#ecjia-menu").css("bottom", bottom + 'px');
                });
                document.getElementById("ecjia-menu").addEventListener('touchend', function (e) {
                    var _x_end = e.changedTouches[0].pageX;
                    var _y_end = e.changedTouches[0].pageY;
                    $('body').css('overflow-y', 'auto').off('touchmove');
                });
                $(".ecjia-menu .icon-top").click(function () {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 300);
                    $('.ecjia-menu .main').click();
                });
            }
        },

        toggle_collapse: function () {
            $(document).on('click', '[data-trigger="collapse"]', function (e) {
                e.preventDefault();
                var o_this = $(this),
                    o_parent = o_this.attr('data-parent') ? o_this.parents(o_this.attr('data-parent')) : o_this,
                    o_toggle = o_parent.find(o_this.attr('href')) || o_this.next();

                o_parent.hasClass('active') ? o_parent.addClass('active') : o_parent.removeClass('active');

                if (o_toggle.is(":visible")) {
                    o_toggle.hide();
                } else {
                    o_toggle.show();
                }
            });
        },

        selectbox: function () {
            $('.ecjia-form select').each(function (index) {
                var obj_this = $(this),
                    obj_abter = $('<div class="select"><i class="iconfont"></i></div>');
                obj_this.after(obj_abter);
                obj_abter.append(obj_this);
            });
        },

        valid: function () {
            var $ecjiaform = $(".ecjia-form");
            $ecjiaform.length && $ecjiaform.each(function (index) {
                var need_valid = $(this).attr('data-valid') == 'novalid' ? false : true;
                if (need_valid) {
                    $(this).on('submit', function (e) {
                        e.preventDefault();
                        return false;
                    }).Validform({
                        tiptype: 4,
                        ajaxPost: true,
                        callback: function (data) {
                            ecjia.touch.showmessage(data);
                        }
                    });
                }
            });
        },

        close_app_download: function () {
            $('.ecjia-app-download .icon-close').on('click', function () {
                $.cookie('hide_download', 1, {
                    expires: 7
                });
                $('.ecjia-app-download').remove();
            });
        },

        close_banner: function () {
            $(document).off('click', '.close-banner');
            $(document).on('click', '.close-banner', function () {
                $('.bottom-banner img').slideUp();
                var url = $(this).attr('data-url');
                $.get(url, function () {});
            });
        },

        search_header: function () {
            var k = $('#keywordBox').val();
            $('#keywordBox').val('').focus().val(k);

            $('.btn-search').off('click').on('click', function (e) {
                var val = $('input[name="keywords"]').val().trim(),
                    url = $('.ecjia-form').attr('action'),
                    form = $('.ecjia-form');

                var is_order_list = $('input[name="keywords"]').attr("data-type");
                if (is_order_list) {
                    if (!val) {
                        //						ecjia.pjax(url);
                        return false;
                    } else {
                        ecjia.pjax(url + '&keywords=' + val);
                        return false;
                    }
                } else {
                    if (!val) {
                        $("#keywordBox").blur();
                        return false;
                    } else {
                        ecjia.pjax(url + '&keywords=' + val);
                        return false;
                    }
                }
            });
            $('.search-goods').off('click').on('click', function () {
                var $this = $(this),
                    url = $this.attr('data-url'),
                    keywords = $this.attr('data-val');
                if (keywords && keywords != undefined) {
                    url += '&keywords=' + keywords;
                };
                ecjia.pjax(url);
            });
        },

        enter_search: function () {
            $("body").keyup(function () {
                if (event.which == 13) {
                    $('.btn-search').trigger('click');
                }
            });
        },

        del_history: function () {
            $(document).off('click', '[data-toggle="del_history"]');
            $(document).on('click', '[data-toggle="del_history"]', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('data-href') || $this.attr('href');

                var myApp = new Framework7();
                myApp.modal({
                    title: '确定清空搜索记录？',
                    buttons: [{
                        text: '取消',
                    }, {
                        text: '确定',
                        onClick: function () {
                            $.get(url, function (data) {
                                if (data.pjaxurl != '') {
                                    refresh_url = data.pjaxurl;
                                } else {
                                    refresh_url = window.location.href;
                                }
                                ecjia.pjax(refresh_url);
                            }, 'json');
                        },
                    }]
                });
            });
        },

        //更新热门推荐时间
        update_hot_time: function (length) {
            if (length != 0) {
                var nowTime = new Date(),
                    hour = checkTime(nowTime.getHours()),
                    minute = checkTime(nowTime.getMinutes()),
                    time = hour + ':' + minute;

                var html = '<i class="icon-goods-hot"></i>' + time + ' 热门推荐已更新';
                $('.ecjia-new-goods').find('.goods-index-title').html(html);
            };
        },
    };

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    };

    //PJAX跳转执行
    $(document).on('pjax:complete', function () {
        window.onscroll = null;
        ecjia.touch.selectbox();
        ecjia.touch.valid();
        ecjia.touch.more_callback = function () {
            ecjia.touch.delete_list_click();
        };
    });

    //PJAX开始
    $(document).on('pjax:start', function () {
        ecjia.touch.index.removeItem();
        ecjia.touch.pjaxloadding();
        if (window.releated_goods != undefined && window.releated_goods.length != 0) {
            window.releated = $.extend({}, window.releated_goods);
        }
    });

    //PJAX前进、返回执行
    $(document).on('pjax:popstate', function () {
        window.scrollTo(0, 1);
    });

    //PJAX历史和跳转都会执行的方法
    $(document).on('pjax:end', function () {
        if (typeof (releated_goods) != "undefined") {
            if (releated_goods.length != 0) {
                window.releated_goods = $.extend({}, releated_goods, window.releated);
            }
        }
        if ($.find('.is-last').length == 0) {
            ecjia.touch.asynclist();
        }
        $('.la-ball-atom').remove();

        //关闭menu
        if ($('.ecjia-menu').hasClass('active')) {
            $('.ecjia-menu').removeClass('active');
        }
        ecjia.touch.search_header();
        ecjia.touch.category.init();
        ecjia.touch.index.swiper_promotion();
        ecjia.touch.ecjia_menu();
        ecjia.touch.region_change();
        ecjia.touch.goods_detail.change();
        ecjia.touch.index.init_swiper();
        ecjia.touch.clear_cache();

        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == "micromessenger" || ua.match(/ECJiaBrowse/i) == "ecjiabrowse") {
            var title = $(document).attr('title');
            var $body = $('body');
            document.title = title;
            var $iframe = $("<iframe style='display:none;' src='/favicon.ico'></iframe>");
            $iframe.on('pjax:end', function () {
                setTimeout(function () {
                    $iframe.off('pjax:end').remove();
                }, 0);
            }).appendTo($body);
        }

        //从购物车进入商家店铺页面自动弹出购物车
        if ($.find('.ecjia-from-page').length) {
            var from = $('.ecjia-from-page').val();
            if (from == 'cart') {
                //超出范围的店铺
                if ($('.ecjia-from-page').hasClass('out-range')) {
                    $('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
                        event.preventDefault;
                    }, false); //禁用滚动条

                    //弹出提示
                    var myApp = new Framework7();
                    myApp.modal({
                        title: '您的定位已超出该店配送区域',
                        buttons: [{
                            text: '知道了',
                            //点击确定后显示购物车
                            onClick: function () {
                                $('.modal').remove();
                                $('.modal-overlay').remove();
                                $('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条

                                //购物车不为空
                                if ($('.minicart-goods-list').find('.a5n').length != 0) {
                                    //显示购物车
                                    ecjia.touch.category.show_cart();
                                    $(".ecjia-store-goods .a1n .a1x").css({
                                        overflow: "hidden"
                                    }); //禁用店铺商品滚动条
                                }
                            },
                        }]
                    });
                } else {
                    //购物车不为空
                    if ($('.minicart-goods-list').find('.a5n').length != 0) {
                        //显示购物车
                        ecjia.touch.category.show_cart();
                        $(".ecjia-store-goods .a1n .a1x").css({
                            overflow: "hidden"
                        }); //禁用店铺商品滚动条
                    }

                }
                return false;
            }
        }
    });
})(ecjia, jQuery);

$(function () {
    /* 页面载入后自动执行 */
    ecjia.touch.init();
    window.alert = ecjia.touch.alert;
});

//end