{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>{$name}公众号扫码关注</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/qrcode.css" />
	</head>
	<body>
		<div id="app" class="wrapper">
			<div>
	            <div class="pn_index" style="background-image: url({$front_url}/images/qrcode_back.png);">
	            	<div class="pn_index_title">
	            		<img src="{$user_info.headimgurl}" ><span>{$user_info.nickname}</span>
	            	</div>
	            	<div class="pn_index_redpacket">
	            		<img src="{$url}" >
	            	</div>
	            	<div class="pn_index_redpacket_cover">
	            		<img src="{$front_url}/images/progress.png">
	            		<div class="cover_content">
	            			<span>扫描二维码</span>
	            			<span>关注公众号</span>
	            			<span>邀请成功</span>
	            		</div>
	            	</div>
	            	<div class="pn_index_invite">
	            		<dl>我邀请的人数：<span>{$count}</span>人</dl>
	            		<div class="invite_content">
	            			<!-- {foreach from=$user_list item=val} -->
		            		<dt><dd><span>{date('Y-m-d H:i', $val.subscribe_time)}</span><div class="right">{$val.nickname}</div></dd><dt>
		            		<!-- {foreachelse} -->
		            		<div class="t_c">暂无邀请</div>
		            		<!-- {/foreach} -->
	            		</dt>
	            	</div>
	            </div>
            </div>
        </div>
	</body>
</html>
{/nocache}