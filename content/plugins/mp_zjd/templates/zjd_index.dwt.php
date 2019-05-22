<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$title}</title>
    <link rel="stylesheet" type="text/css" href="{$style_css}">
</head>

<body>
    <div class="grid">
        <div id="hammer">
            <img src="{$img_6_png}" height="87" width="74" alt="">
        </div>
        <div id="f">
            <img src="{$img_4_png}" />
        </div>
        <div id="banner">
            <dl>
                <dt>
                    <a href="javascript:;">
                        <img src="{$egg_1_png}">
                    </a>
                    <a href="javascript:;">
                        <img src="{$egg_1_png}">
                    </a>
                    <a href="javascript:;">
                        <img src="{$egg_1_png}">
                    </a>
                    <a href="javascript:;">
                        <img src="{$egg_1_png}">
                    </a>
                    <a href="javascript:;">
                        <img src="{$egg_1_png}">
                    </a>
                    <a href="javascript:;">
                        <img src="{$egg_1_png}">
                    </a>
                    <a href="javascript:;">
                        <img src="{$egg_1_png}">
                    </a>
                </dt>
                <dd></dd>
            </dl>
        </div>

        <div class="block">
            <div class="title">{t domain="mp_zjd"}剩余次数{/t}</div>
            <div class="content">
                <p>{t domain="mp_zjd"}您当前还剩余{/t}
                    <span class="font-size16"> {$prize_num} </span>{t domain="mp_zjd"}次抽奖机会{/t}</p>
            </div>
        </div>
        <div class="block">
            <div class="title">{t domain="mp_zjd"}活动规则{/t}</div>
            <div class="content">
                <p>{$description}</p>
            </div>
        </div>
        <div class="block">
            <div class="title">{t domain="mp_zjd"}奖项设置{/t}</div>
            {if $prize}
            <div class="content">
                <!-- {foreach from=$prize item=val }-->
                <p>
                    {if $val.prize_level eq '0'} {t domain="mp_zjd"}特等奖：{/t} {elseif $val.prize_level eq '1'} {t domain="mp_zjd"}一等奖：{/t} {elseif $val.prize_level eq '2'} {t domain="mp_zjd"}二等奖：{/t} {elseif $val.prize_level
                    eq '3'} {t domain="mp_zjd"}三等奖：{/t} {elseif $val.prize_level eq '4'} {t domain="mp_zjd"}四等奖：{/t} {elseif $val.prize_level eq '5'} {t domain="mp_zjd"}五等奖：{/t} {/if} {$val.prize_name}{if $val.prize_type eq 2}（{$val.prize_value}）{/if}（剩余奖品数量：{$val.prize_number}）
                </p>
                <!-- {/foreach} -->
            </div>
            {else}
            <p>{t domain="mp_zjd"}暂无设置{/t}</p>
            {/if}
        </div>
        <div class="block">
            <div class="title">{t domain="mp_zjd"}中奖记录{/t}</div>
            {if $list}
            <div class="content">
                <!-- {foreach from=$list item=val}-->
                <p> {$val.user_name} {t domain="mp_zjd"}获得奖品 ：{/t}{$val.prize_name} {if $val.prize_type eq 2}（{$val.prize_value}）{/if}</p>
                <!-- {/foreach} -->
            </div>
            {else}
            <p>{t domain="mp_zjd"}暂无获奖记录{/t}</p>
            {/if}
        </div>
    </div>
    <div id="mask"></div>
    <div id="dialog" class="yes">
        <div id="content"></div>
        <a href="javascript:;" id="link">{t domain="mp_zjd"}去看看{/t}</a>
        <button id="close">{t domain="mp_zjd"}关闭{/t}</button>
    </div>
    <!-- 我的奖品 -->
    <div class="prize-btn">
        <a href="{$prize_url}">
            <img width="50%" src="{$my_prize_png}">
        </a>
    </div>

    <script type="text/javascript" src="{$jquery_js}"></script>
    <script>
        $(function () {
            var js_lang_award = '{$js_lang_award}';
            var timer, forceStop;
            var wxch_Marquee = function (id) {
                try {
                    document.execCommand("BackgroundImageCache", false, true);
                } catch (e) {};
                var container = document.getElementById(id),
                    original = container.getElementsByTagName("dt")[0],
                    clone = container.getElementsByTagName("dd")[0],
                    speed = arguments[1] || 10;
                clone.innerHTML = original.innerHTML;
                var rolling = function () {
                    if (container.scrollLeft == clone.offsetLeft) {
                        container.scrollLeft = 0;
                    } else {
                        container.scrollLeft++;
                    }
                }
                this.stop = function () {
                    clearInterval(timer);
                }
                timer = setInterval(rolling, speed); //设置定时器
                container.onmouseover = function () {
                    clearInterval(timer)
                } //鼠标移到marquee上时，清除定时器，停止滚动
                container.onmouseout = function () {
                    if (forceStop) return;
                    timer = setInterval(rolling, speed);
                } //鼠标移开时重设定时器
            };

            var wxch_stop = function () {
                clearInterval(timer);
                forceStop = true;
            };
            var wxch_start = function () {
                forceStop = false;
                wxch_Marquee("banner", 20);
            };

            wxch_Marquee("banner", 20);

            var $egg;

            $("#banner a").on('click', function () {
                wxch_stop();
                $egg = $(this);
                var offset = $(this).position();
                $hammer = $("#hammer");
                $hammer.animate({
                    left: (offset.left + 30)
                }, 1000, function () {
                    $(this).addClass('hit');
                    $("#f").css('left', offset.left).show();
                    $egg.find('img').attr('src', '{$egg_2_png}');
                    setTimeout(function () {
                        wxch_result.call(window);
                    }, 500);
                });
            });

            $("#mask").on('click', function () {
                $(this).hide();
                $("#dialog").hide();
                $egg.find('img').attr('src', '{$egg_1_png}');
                $("#f").hide();
                $("#hammer").css('left', '-74px').removeClass('hit');
                wxch_start();
                window.location.reload();
            });

            $("#close").click(function () {
                $("#mask").trigger('click');
                window.location.reload();
            });

            function wxch_result() {
                var url = '{$form_action}';
                $.get(url, function (data) {
                    $("#mask").show();

					if (data.state == 'success') {
						var success = js_lang_award + '"' + data.prize_name + '"';
                        $("#content").html(success);
                        $("#link").attr("href", data.link);
                        $("#dialog").attr("class", 'yes').show();
					} else if (data.state == 'error') {
                        $("#content").html(data.message);
                        $("#dialog").attr("class", 'no').show();
                        return false;
                    }
                });
            }
        });
    </script>
    <!-- {/nocache} -->

</body>

</html>