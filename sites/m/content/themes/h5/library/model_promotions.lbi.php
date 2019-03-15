<?php
/*
Name: 促销专场模块
Description: 这是首页的促销专场模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{if $value.data}
<div class="ecjia-mod ecjia-promotion-model ecjia-margin-t {if $count eq $key && !$data}ecjia-mod-pb35{/if}">
	<div class="head-title">
		<h2><i class="icon-promotion"></i>{t domain="h5"}促销商品{/t}<a href="{$more_sales}" class="more_info">{t domain="h5"}更多{/t}</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<!-- {foreach from=$value.data item=val} 循环商品 -->
			<div class="swiper-slide">
				<a class="list-page-goods-img nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}">
					<span class="goods-img">
						<img src="{$val.img.small}" alt="{$val.name}">
						<span class="promote-time" value="{$val.promote_end_date}"></span>
					</span>
					<span class="list-page-box">
						<span class="goods-name">
							{if $val.manage_mode eq 'self'}
							<span class="self-label">{t domain="h5"}自营{/t}</span>
							{/if}
							<span class="name-label">{$val.name}</span>
						</span>
						<span class="list-page-goods-price">
							<!--{if $val.unformatted_promote_price neq 0}-->
							<span>{$val.promote_price}</span>
							<!--{else}-->
							<span>{$val.shop_price}</span>
							<!--{/if}-->
							<!--{if $val.shop_price}-->
							<span><del>{$val.shop_price}</del></span>
							<!--{/if}-->
						</span>
					</span>
				</a>
				<img class="sales-icon" src="{$theme_url}images/icon-promote@2x.png">
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
</div>
{/if}