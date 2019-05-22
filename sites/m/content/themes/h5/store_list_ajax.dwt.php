<?php 
/*
Name: 分类店铺
Description: 这是分类店铺页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
	<!-- {foreach from=$goods_list item=val} -->
	<li class="search-goods-list">
		<a class="linksGoods w nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}&product_id={$val.product_id}">
			<img class="pic" src="{$val.img.small}">
			<dl>
				<dt>{$val.name}</dt>
				<dd></dd>
				<dd><label>{$val.shop_price}</label></dd>
			</dl>
		</a>
		{if $store_info.shop_closed neq 1}
		<div class="box" id="goods_{$val.id}">
			<!-- {if $val.specification} -->
			<div class="goods_attr goods_spec_{$val.id}">
				<span class="choose_attr spec_goods" rec_id="{$val.rec_id}" goods_id="{$val.id}" data-num="{$val.num}" data-spec="{$val.default_spec}" data-url="{RC_Uri::url('cart/index/check_spec')}&store_id={$val.store_id}">{t domain="h5"}选规格{/t}</span>
				{if $val.num}<i class="attr-number">{$val.num}</i>{/if}
			</div>
			<!-- {else} -->
			<span class="reduce {if $val.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$val.rec_id}">{t domain="h5"}减{/t}</span>
			<label class="{if $val.num}show{else}hide{/if}">{$val.num}</label>
			<span class="add" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.id}">{t domain="h5"}加{/t}</span>
			<!-- {/if} -->
		</div>
		{/if}
	</li>
	<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}