<?php
/*
Name: 店铺商品模版
Description: 这是店铺商品
Libraries: merchant_goods
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-header ecjia-store-banner" style="background: url('{if $store_info.seller_banner}{$store_info.seller_banner}{else}{$theme_url}images/default_store_banner.png{/if}') center center no-repeat;background-size: 144% 100%;">
	<div class="ecjia-store-brief">
		<li class="store-info {if $store_info.favourable_count}boder-eee{/if}">
			<div class="basic-info">
				<div class="store-left">
					<img src="{if $store_info.seller_logo}{$store_info.seller_logo}{else}{$theme_url}images/store_default.png{/if}">
				</div>
				<div class="store-right">
					<div class="store-title">
						<span class="store-name">{$store_info.seller_name}</span>
						{if $store_info.distance} <span class="seller-distance">{$store_info.distance}</span>{/if}
						{if $store_info.manage_mode eq 'self'}<span class="manage-mode">自营</span>{/if}
						{if $store_info.is_follower eq 1}
							<span class="follower not" data-toggle="follow_store" data-type=0 data-url="{$follow_url}">已关注</span>
						{else}
							<span class="follower" data-toggle="follow_store" data-type=1 data-url="{$follow_url}"><i class="iconfont icon-add"></i>关注</span>
						{/if}
					</div>
					<div class="store-range">
						<i class="icon-shop-time"></i>{$store_info.label_trade_time}
						{if $store_info.allow_use_quickpay eq 1}
						<a href="{RC_Uri::url('user/quickpay/init')}&store_id={$store_id}"><span class="check">买单</span></a>
						{/if}
					</div>
					<div class="store-description"><i class="icon-shop-notice"></i>{$store_info.seller_notice}</div>
				</div>
			</div>
		</li>
		{if $store_info.favourable_list}
		<ul class="store-promotion" id="promotion-scroll">
			<!-- {foreach from=$store_info.favourable_list item=list} -->
			<li class="promotion">
				<span class="promotion-label">{$list.type_label}</span>
				<span class="promotion-name">{$list.name}</span>
			</li>
			<!-- {/foreach} -->
		</ul>
		{/if}
		{if $store_info.favourable_count}
		<li class="favourable_notice">共{$store_info.favourable_count}个活动<i class="iconfont icon-jiantou-right"></i></li>
		{/if}
	</div>
	<div class="ecjia-header-right">
		<!-- {if $header_right.icon neq ''} -->
			<i class="{$header_left.icon}"></i>
		<!-- {else} -->
			<!-- {if $header_right.search neq ''} -->
			<a href="{$header_right.search_url}">{$header_right.search}</a>
			<!-- {/if} -->
		<!-- {/if} -->
	</div>
</div>
<input type="hidden" name="from" value="{$smarty.get.from}" class="ecjia-from-page {if $smarty.get.out eq 1}out-range{/if}" />