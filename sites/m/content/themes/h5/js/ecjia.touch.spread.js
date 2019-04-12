/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {
    ecjia.touch.spread = {
        init: function () {
            ecjia.touch.spread.would_spread();
            ecjia.touch.spread.hint();
            ecjia.touch.spread.article();
        },
        
        would_spread: function () {
            $('.would-spread').off('click').on('click', function (e) {
                e.preventDefault();
                var ua = navigator.userAgent.toLowerCase();
                if (ua.match(/MicroMessenger/i) == "micromessenger") {
                    $('.ecjia-spread-share').removeClass('hide').css('top', $('body').scrollTop() + 'px');
                    //禁用滚动条
                    $('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
                        event.preventDefault;
                    }, false);
                    $('.ecjia-spread-share').on('click', function () {
                        $('.ecjia-spread-share').addClass('hide');
                        $('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
                    })
                } else {
                    alert(js_lang.please_open_link);
                }
            });
        },

        article: function () {
            //滚动条事件
            $(window).scroll(function () {
                //获取滚动条的滑动距离
                var scroH = $(this).scrollTop();
                $("ul .pf").each(function (i) {
                    //滚动时候pf离顶部的距离
                    var pfTop = $(this).offset().top;
                    //滚动条的滑动距离大于等于定位元素距离浏览器顶部的距离，就固定，反之就不固定
                    div_height = $(this).height();
                    $("ul").each(function () {
                        //取出ul下的第一个li
                        var li = $(this).children(".article-init").first();
                        if (scroH > 0) {
                            li.css("margin-top", div_height);
                        }
                    });
                    if (pfTop - scroH < div_height) {
                        if (scroH <= 0) {
                            $("ul .pf").css({
                                "position": '',
                                "top": '',
                                "z-index": ''
                            });
                            $("ul .article-init").css("margin-top", 0);
                        } else {
                            $(this).css({
                                "position": "fixed",
                                "top": 0,
                                "z-index": 9
                            });
                            $(this).siblings('.pf').css({
                                "position": "relative"
                            });
                        }
                    }
                });
            });
        },

        hint: function () {
            var mySwiper3 = new Swiper('.swiper-reward', {
                slidesPerView: 3,
                centeredSlides: true,
                paginationClickable: true,
                initialSlide: 12,
                slideToClickedSlide: true,
                onSlideChangeEnd: function (swiper) {
                    var index = swiper.activeIndex;
                    if (index == undefined) {
                        index = 12;
                    }
                    ecjia.touch.spread.reward_detail(index);
                },
            });

            $('.alert-text1').on('click', function () {
                var integral_name = $(this).attr('data-integralname');
                alert(sprintf(js_lang.point_reward, integral_name, integral_name));
                $(".modal-overlay").css('transition-duration', "0ms");
                $(".modal-in").css("position", "absolute");
                $(".modal-inner").css("background-color", "#FFF");
                $(".modal-button-bold").css("background-color", "#FFF");
            });
            $('.alert-text2').on('click', function () {
                alert(js_lang.bonus_reward);
                $(".modal-overlay").css('transition-duration', "0ms");
                $(".modal-in").css("position", "absolute");
                $(".modal-inner").css("background-color", "#FFF");
                $(".modal-button-bold").css("background-color", "#FFF");
            });
            $('.alert-text3').on('click', function () {
                alert(js_lang.money_reward);
                $(".modal-overlay").css('transition-duration', "0ms");
                $(".modal-in").css("position", "absolute");
                $(".modal-inner").css("background-color", "#FFF");
                $(".modal-button-bold").css("background-color", "#FFF");
            });
        },

        reward_detail: function (index) {
            var div = $('.swiper-wrapper').children('.swiper-slide');
            $(".detail-list").attr('data-url', '');
            $(".detail-list").attr('data-toggle', '');

            var date = div.eq(index).children('div').attr('data-date');
            var url = $('input[name="reward_url"]').val();
            var info = {
                'date': date
            };
            $(".detail-list").html('');
            $(window).scrollTop(0);

            $.get(url, info, function (data) {
                $(".detail-list").attr('data-url', data.data.url);
                $(".detail-list").attr('data-toggle', data.data.data_toggle);
                $(".detail-list").html(data.list);
                $('.load-list').remove();

                if (data.list == null && parseInt($('.detail-list').children('li').length) == 0) {
                    var empty = '<div class="ecjia-nolist">' +
                        '<div class="img-nolist">' + '<div class="img-noreward">' + js_lang.no_reward + '</div>' + '</div>' +
                        '</div>';
                    $(".detail-list").html(empty);
                }
                ecjia.touch.asynclist();
            });
        },
    };

})(ecjia, jQuery);

//end