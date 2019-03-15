<?php
/*
Name: PC端没有内容提示模块
Description: 这是PC端的没有内容提示模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-no-content">
	<div class="content">
		<div class="content-container">
			<div class="current-city">{t domain="ecjia-pc"}当前选择位置：{/t}{$info.city_name}</div>
			<p>{t domain="ecjia-pc"}抱歉！您切换的区域暂时还没有店铺和商品。{/t}</p>
			<p>{t domain="ecjia-pc"}赶快来入驻吧{/t}</p>
			<a class="nopjax" href="{$info.merchant_url}" target="_blank"><span class="go_settled">{t domain="ecjia-pc"}去入驻{/t}</span></a>
			<p>{t domain="ecjia-pc"}或者您还可以{/t}<span class="choose-city">{t domain="ecjia-pc"}去其他位置看看哦{/t}</span></p>
		</div>
	</div>
</div>