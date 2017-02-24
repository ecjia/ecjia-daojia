<?php
/*
Name: 首页轮播图模块
Description: 这是首页的轮播图banner模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $cycleimage}banner滚动图片 -->
<div class="ecjia-mod focus" id="focus">
	<div class="hd">
		<ul></ul>
	</div>
	<div class="bd">
		<!-- Swiper -->
		<div class="swiper-container swiper-touchIndex">
			<div class="swiper-wrapper">
				<!--{foreach from=$cycleimage item=img}-->
				<div class="swiper-slide"><a target="_blank" href="{$img.url}"><img src="{$img.photo.url}" /></a></div>
				<!--{/foreach}-->
			</div>
			<!-- Add Pagination -->
			<div class="swiper-pagination"></div>
		</div>
	</div>
</div>
<!-- {/if} -->
