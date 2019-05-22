<?php 
/*
Name: 店铺商品模版
Description: 店铺商品列表页
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$goods_list item=goods} -->
<li>
	<a class="linksGoods w nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.goods_id}&product_id={$goods.product_id}">
		<img class="pic" src="{$goods.img.small}">
		<dl>
			<dt>{$goods.name}</dt>
			<dd><label>{if $goods.unformatted_promote_price neq 0 && $goods.unformatted_promote_price lt $goods.unformatted_shop_price}{$goods.promote_price}{else}{$goods.shop_price}{/if}</label></dd>
		</dl>
	</a>
	{if $shop_closed neq 1}
		{if $goods.specification}
		<div class="goods_attr goods_spec_{$goods.id}">
			<span class="choose_attr spec_goods" rec_id="{$goods.rec_id}" goods_id="{$goods.id}" data-store="{$goods.store_id}" data-num="{$goods.num}" data-spec="{$goods.default_spec}" data-url="{RC_Uri::url('cart/index/check_spec')}&store_id={$goods.store_id}">{t domain="h5"}选规格{/t}</span>
			{if $goods.num}<i class="attr-number">{$goods.num}</i>{/if}
		</div>
		{else}
		<div class="box" id="goods_{$goods.id}">
	    	<span class="reduce {if $goods.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$goods.rec_id}">{t domain="h5"}减{/t}</span>
	    	<label class="{if $goods.num}show{else}hide{/if}">{$goods.num}</label>
			<span class="add" data-toggle="add-to-cart" rec_id="{$goods.rec_id}" goods_id="{$goods.id}">{t domain="h5"}加{/t}</span>
		</div>
		{/if}
	{/if}
</li>
<!-- {foreachelse} -->	
<div class="ecjia-merchant-goods ecjia-nolist">
	<p><img src="{$theme_url}images/wallet/null280.png"></p>
	{t domain="h5"}暂无相关商品数据{/t}
</div>
<!-- {/foreach} -->	
<!-- {/block} -->
{/nocache}