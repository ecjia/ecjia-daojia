<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>刮刮卡</title>
<link rel="stylesheet" type="text/css" href="{$css_url}">
</head>
	<body data-role="page" class="activity-scratch-card-winning">
		<div class="main">
			<div class="cover">
				<img src="{$bannerbg}">
				<div id="prize">谢谢参与</div>
				<div id="scratchpad"></div>
			</div>
			<div class="content">
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">奖项设置</div>
						<div class="Detail">
	                        {if $prize}
								<div class="content">
									<!-- {foreach from=$prize item=val }-->
									 <p>{$val.0}:{$val.1}(奖品数量：{$val.2})</p>
								 	<!-- {/foreach} -->
								</div>
							{/if}
						</div>
					</div>
				</div>
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">活动说明</div>
						<div class="Detail">
							<p>剩余抽奖次数：<span id="num">{$prize_num}</span></p>
							<p>{$description}</p>
						</div>
					</div>
				</div>
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">中奖记录</div>
						<div class="Detail">
							{if $list}
								<div class="content">
									 <!-- {foreach from=$list item=val}-->
									  <p> {$val['nickname']} 获得奖品 ：{$val['prize_name']}</p>
									 <!-- {/foreach} -->
								</div>	 
							{else}
							 	 <p>暂无获奖记录</p>
							{/if}
						</div>
					</div>
				</div>
			</div>
			<div style="clear:both;">
			</div>
		</div>
		
		
<script type="text/javascript" src="{$jq_url}"></script>
<script type="text/javascript" src="{$js_url}"></script>
		
<script type="text/javascript">
$(function() {
	var ISWeixin = !!navigator.userAgent.match(/MicroMessenger/i); //wp手机无法判断
    if(!ISWeixin){
        var rd_url = location.href.split('#')[0];  // remove hash
        var oauth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri='+encodeURIComponent(rd_url) + '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
        location.href = oauth_url;
        return false;
    }
	var isLucky = false, level = "谢谢参与";
	$.getJSON('{$form_action}', { act:'draw' }, function(result){
		if(result.status == 2){
			$("#scratchpad").wScratchPad('enabled');
			alert(result.msg);
			return false;
		}
		else if(result.status == 1){
			isLucky = true;
			level = result.level;
			$("#prize").html(level);
		}
		$("#scratchpad").wScratchPad({
			width: 150,
			height: 60,
			color: "#a9a9a7",  //覆盖的刮刮层的颜色
			scratchDown: function(e, percent) {
				$(this.canvas).css('margin-right', $(this.canvas).css('margin-right') == "0px" ? "1px" : "0px");
				if(percent > 23){
					$("#scratchpad").wScratchPad('clear');
					$.getJSON('{$form_action}', { act:'do', prize_type:result.prize_type, prize_name:result.msg, prize_level:result.level }, function(data){
						if(result.num >= 0){
							$("#num").html(result.num);
						}
						if(data.status == 1){
							var msg = "恭喜中了" + result.level + "\r\n" + "快去领奖吧";
							if(data.link && confirm(msg)){
								location.href = data.link;
                        		return false;
							}
							else{
								location.reload();
								return false;
							}
						}else if(data.status == 0){
							if(confirm(result.msg + "\r\n再来一次")){
								location.reload();
								return false;
							}
						}
					});
				}
			}
		}); 
	});
});
</script>
</body>
</html>
<!-- {/nocache} -->