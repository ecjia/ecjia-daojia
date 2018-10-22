<?php
/*
Name: 首页轮播图模块
Description: 这是首页的轮播图banner模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod {if $count eq $key && !$data}ecjia-mod-pb35{/if}">
	<!-- {if $value.data} -->
	<div class="bd ecjia-mod-cycleimage">
		<div class="swiper-container" id="swiper-touchIndex">
			<div class="swiper-wrapper">
				<!--{foreach from=$value.data item=img}-->
				<div class="swiper-slide"><a href="{$img.url}"><img src="{$img.photo.url}" /></a></div>
				<!--{/foreach}-->
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</div>
	<!-- {/if} -->
</div>
