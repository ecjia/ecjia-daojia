<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>幸运大转盘</title>
<link rel="stylesheet" type="text/css" href="{$css_url}">
</head>
<body>
<div class="content-wrap">
    <div id="roundabout">
        <div class="r-panel">
            <div class="dots"></div>
            <div data-count="{$countprize}" class="lucky">
            	{if $prize}
					<!-- {foreach from=$prize item=val }-->
					 	 <span data-level="{$val.0}">{$val.0}</span>
				 	<!-- {/foreach} -->
				{/if}
            </div>
            <div class="point-panel"></div>
            <div class="point-arrow"></div>
            <div class="point-cdot"></div>
            <div class="point-btn"></div>
        </div>
    </div>
    <div class="info-box">
        <div class="info-box-inner">
            <h4>剩余次数</h4>
            <div>您当前还剩余<span style="font-size: 16px;"> {$prize_num} </span>次抽奖机会</div>
        </div>
    </div>
    <div class="info-box">
        <div class="info-box-inner">
            <h4>奖项设置</h4>
            <div>
               	{if $prize}
					<!-- {foreach from=$prize item=val }-->
					 	<p>{$val.0}:{$val.1}(奖品数量：{$val.2})</p>
				 	<!-- {/foreach} -->
				{/if}
            </div>
        </div>
    </div>
    <div class="info-box">
        <div class="info-box-inner">
            <h4>活动规则</h4>
            <div>{$description}</div>
        </div>
    </div>
    <div class="info-box">
        <div class="info-box-inner">
            <h4>中奖记录</h4>
            <div>
                {if $list}
					<!-- {foreach from=$list item=val}-->
					<p> {$val['nickname']} 获得奖品 ：{$val['prize_name']}</p>
					<!-- {/foreach} -->
				{else}
			 		<p>暂无获奖记录</p>
				{/if}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{$jq_url}"></script>
<script type="text/javascript" src="{$easing_url}"></script>
<script type="text/javascript" src="{$Rotate_url}"></script>
<script type="text/javascript">
    $(function(){
        var ISWeixin = !!navigator.userAgent.match(/MicroMessenger/i); //wp手机无法判断
//         if(!ISWeixin){
//             var rd_url = location.href.split('#')[0];  // remove hash
//             var oauth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri='+encodeURIComponent(rd_url) + '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
//             location.href = oauth_url;
//             return false;
//         }
        var dot_round = 0;
        var lucky_span = $('.lucky span');
        var lucky_p = LUCKY_POS[lucky_span.length];
        lucky_span.each(function(idx, item){
            item = $(item);
            item.addClass('item' + lucky_p[idx] + ' z' + item.text().length);
            item.rotate(LUCKY_ROTATE[lucky_p[idx]]);
        });
        var NOL_TXTs = ['再接再厉', '不要灰心', '没有抽中', '谢谢参与', '祝您好运', '不要灰心', '就差一点'];
        for (var i = 1; i <= 12; i++){
            if ($('.lucky .item' + i).length == 0){
                var item = $('<span class="item' + i + ' nol z4">' + NOL_TXTs[i > 6 ? 12 - i : i] + '</span>').appendTo('.lucky');
                item.rotate(LUCKY_ROTATE[i]);
            }
        }
        $('.lucky span').show();

        $('.point-btn').click(function(){
            var lucky_l = POINT_LEVEL[$('.lucky').data('count')];
            $.getJSON('{$form_action}', '', function(data){
                //中奖
                if(data.status == 1){
                    var b = $(".lucky span[data-level='"+data.level+"']").index();
                    var a = lucky_l[b];
                    var msg = '恭喜中了' + $(".lucky span[data-level='"+data.level+"']").text();
                    $(".point-btn").hide();
                    $(".point-arrow").rotate({ 
                        duration:3000, //转动时间 
                        angle: 0, 
                        animateTo:1800 + a, //转动角度 
                        easing: $.easing.easeOutSine, 
                        callback: function(){
                            $(".point-btn").show();
                            if(data.link && confirm(msg+"\r\n快去领奖吧")){
                                location.href = data.link;
                                return false;
                                window.location.reload(); 
                            }
                        } 
                    });
                }
                else if(data.status == 2){
                    //未登录
                    alert(data.msg);
                    return false;
                }
                else{
                    var a = 0;
                    var arrow_angle;
                    while (true){
                        arrow_angle = ~~(Math.random() * 12);
                        if ($.inArray(arrow_angle * 30, lucky_l) == -1) break;
                    }
                    a = arrow_angle * 30;
                    var msg = $(".lucky span.item"+arrow_angle).text() ? $(".lucky span.item"+arrow_angle).text() : '没有抽中';
                    $(".point-btn").hide();
                    $(".point-arrow").rotate({ 
                        duration:3000, //转动时间 
                        angle: 0, 
                        animateTo:1800 + a, //转动角度 
                        easing: $.easing.easeOutSine, 
                        callback: function(){ 
                            alert(msg);
                            $(".point-btn").show();
                            window.location.reload(); 
                        } 
                    });
                }

            });
            
        });
        //跑马灯
        dot_timer = setInterval(function(){
            dot_round = dot_round == 0 ? 15 : 0;
            $('.dots').rotate(dot_round);
        }, 800);

    })

    var POINT_LEVEL = { 3: [30, 150, 270], 4: [30, 90, 210, 270], 5:[30, 90, 150, 210, 270], 6:[30, 90, 150, 210, 270, 330], 7:[30, 90, 150, 210, 270, 330, 0], 8:[30, 90, 150, 210, 270, 330, 0, 180],9:[30, 90, 150, 210, 270, 330, 0, 180, 120] };
    var LUCKY_POS = { 3:[1,5,9], 4:[1,3,7,9], 5:[1,3,5,7,9], 6:[1,3,5,7,9,11], 7:[1,3,5,7,9,11,12], 8:[1,3,5,7,9,11,12,6], 9:[1,3,5,7,9,11,12,6,4] };
    var LUCKY_ROTATE = { 1:-15, 2:14, 3:45, 4:75, 5:103, 6:134, 7:167, 8:197, 9:224, 10:255, 11:283, 12:316 };
</script>

</body>
</html>
<!-- {/nocache} -->