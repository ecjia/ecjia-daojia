<?php
/*
Name: PC端首页右下角悬浮导航
Description: 这是PC端的首页右下角悬浮导航
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="suspension">
	<div class="suspension-box">
		{if $info.kf_qq neq ''}
		<div class="suspension-box-item">
			<a id="webqq" href="http://wpa.qq.com/msgrd?v=3&uin={$info.kf_qq}&site={$info.http_host}&menu=yes" target="_blank" class="qq j-icon a"><i>qq</i></a>
			<div class="tencent j-tencent j-box">
				<a id="webqqf" href="http://wpa.qq.com/msgrd?v=3&uin={$info.kf_qq}&site={$info.http_host}&menu=yes" target="_blank">
				<i class="tencent-i">tencent</i>
				<b class="tencent-b"><span class="tencent-span"><img class="tencent-qq" src="{$theme_url}images/nav/qq-tencent.png" alt=""></span></b>
				<p class="tencent-p">
					在线客服<br>
					点击交谈
				</p>
				</a>
			</div>
		</div>
		{/if}
		
		{if $info.service_phone}
		<div class="suspension-box-item">
			<a class="a tel j-icon"><i>tel</i></a>
			<div class="tel j-box">
				<strong>服务热线：</strong>
				<p>{$info.service_phone}</p>
				<i></i>
			</div>
		</div>
		{/if}
		
		{if $info.shop_wechat_qrcode}
		<div class="suspension-box-item">
			<a class="code j-icon a"><i>code</i></a>
			<div class="code j-box">
				<img src="{$info.shop_wechat_qrcode}">
				<p>
					扫一扫，微信关注EC+到家
				</p>
				<i></i>
			</div>
		</div>
		{/if}
		<a class="back_top j-back-top a"><i>back_top</i></a>
	</div>
</div>