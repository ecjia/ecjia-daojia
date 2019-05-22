<?php 
/*
Name: 促销商品模版
Description: 促销商品列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- 异步促销商品列表 start-->
<!-- {if $goods_list} -->
<!-- {foreach from=$goods_list item=val} -->
<li class="ecjia-margin">
	<div class="list-page-goods-img">
		<div class="goods-img">
			<a class="nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}{if $val.product_id neq 0}&product_id={$val.product_id}{/if}"><img class="img" src="{$val.img.thumb}" alt="{$val.name}"></a>
			<span class="promote-time" data-type="2" value="{$val.promote_end_date}"></span>
			<img class="sales-icon" src="{$theme_url}images/icon-promote@2x.png">
		</div>
		<div class="list-page-box">
			<a class="nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}{if $val.product_id neq 0}&product_id={$val.product_id}{/if}"><span class="goods-name">{$val.name}</span></a>
			<p class="store-name">
				<span><i class="iconfont icon-shop"></i> {$val.store_name}</span>
				<span class="self-label">{t domain="h5"}自营{/t}</span>
			</p>
			<div class="list-page-goods-price">
				<div class="left">
					<p>{$val.shop_price}</p>

					<!--{if $val.market_price}-->
					<del>{$val.market_price}</del>
					<!--{/if}-->
				</div>
				<a class="btn go-buy nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}{if $val.product_id neq 0}&product_id={$val.product_id}{/if}">立即购买</a>
			</div>
		</div>
	</div>
</li>
<!-- {/foreach} -->
<!-- {else} -->
<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		{t domain="h5"}暂无促销{/t}
		{if $promotion_type neq 'all'}
		<a class="btn btn-small" style="margin-top: 1em;" type="button" href="{RC_Uri::url('goods/index/promotion')}&promotion_type=all">{t domain="h5"}查看更多{/t}</a>
		{/if}
	</div>
</div>
<!-- {/if} -->
<!-- 异步商品列表end -->
<!-- {/block} -->
{/nocache}