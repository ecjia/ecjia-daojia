<?php
/*
Name: 商家公告及优惠信息
Description: 这是商家公告及优惠信息弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-store-modal">
	<div class="modal-inners">
		<span class="ecjia-close-modal-icon"><i class="iconfont icon-close"></i></span>
		<div class="modal-title">{$store_info.seller_name}</div>
		{if $store_info.favourable_list}
		<div class="hd">
			<h2>
				<span class="line"></span>
				<span class="goods-index-title">优惠信息</span>
			</h2>
		</div>
		<ul class="store-promotion">
			<!-- {foreach from=$store_info.favourable_list item=list} -->
			<li class="promotion">
				<span class="promotion-label">{$list.type_label}</span>
				<span class="promotion-name">{$list.name}</span>
			</li>
			<!-- {/foreach} -->
			<div class="clear_both"></div>
		</ul>
		{/if}
		<div class="hd">
			<h2>
				<span class="line"></span>
				<span class="goods-index-title">商城公告</span>
			</h2>
		</div>
		<div class="store-notice">{$store_info.seller_notice}</div>
	</div>
</div>
<div class="ecjia-store-modal-overlay ecjia-store-modal-overlay-visible"></div>