<?php
/*
Name: 店铺商品模版
Description: 这是店铺商品
Libraries: merchant_goods
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$goods_list item=goods} -->
<li>
	<a class="linksGoods w" href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.id}">
		<img class="pic" src="{$goods.img.small}">
		<dl>
			<dt>{$goods.name}</dt>
			<dd><label>{if $goods.promote_price}{$goods.promote_price}{else}{$goods.shop_price}{/if}</label></dd>
		</dl>
	</a>
	{if $goods.specification}
	<div class="goods_attr goods_spec_{$goods.id}">
		<span class="choose_attr spec_goods" rec_id="{$goods.rec_id}" goods_id="{$goods.id}" data-num="{$goods.num}" data-spec="{$goods.default_spec}" data-url="{RC_Uri::url('cart/index/check_spec')}&store_id={$goods.store_id}">选规格</span>
		{if $goods.num}<i class="attr-number">{$goods.num}</i>{/if}
	</div>
	{else}
	<div class="box" id="goods_{$goods.id}">
    	<span class="reduce {if $goods.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$goods.rec_id}">减</span>
    	<label class="{if $goods.num}show{else}hide{/if}">{$goods.num}</label>
		<span class="add" data-toggle="add-to-cart" rec_id="{$goods.rec_id}" goods_id="{$goods.id}">加</span>
	</div>
	{/if}
</li>
<!-- {foreachelse} -->	
<div class="ecjia-merchant-goods ecjia-nolist">
	<p><img src="{$theme_url}images/wallet/null280.png"></p>
	暂无相关商品数据
</div>
<!-- {/foreach} -->	
<!-- {/block} -->
{/nocache}