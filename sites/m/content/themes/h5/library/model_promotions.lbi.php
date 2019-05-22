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
		<h2><i class="icon-promotion"></i>{t domain="h5"}限时促销{/t}<a href="{$more_sales}" class="more_info">{t domain="h5"}更多{/t}</a></h2>
	</div>
	<div class="swiper-container swiper-promotion-goods">
		<div class="swiper-wrapper">
			<!-- {foreach from=$value.data item=val} 循环商品 -->
			<div class="swiper-slide">
				<a class="list-page-goods-img nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}{if $val.product_id neq 0}&product_id={$val.product_id}{/if}">
					<div class="goods-image">
						<img src="{$val.img.small}" alt="{$val.name}">
						<img class="sales-icon" src="{$theme_url}images/icon-promote@2x.png">
					</div>
					<div class="list-page-box">
						<div class="goods-name">{$val.name}</div>
						<div class="list-page-goods-price">
							<span>{$val.shop_price}</span>
							<span><del>{$val.market_price}</del></span>
						</div>
						<div class="promote-time time" value="{$val.promote_end_date}" data-type="3"></div>
					</div>
				</a>
			</div>
			<!-- {/foreach} -->
		</div>
		<div class="swiper-pagination"></div>
	</div>
</div>
{/if}