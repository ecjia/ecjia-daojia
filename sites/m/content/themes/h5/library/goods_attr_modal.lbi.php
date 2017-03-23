<?php
/*
Name: 选择商品规格
Description: 这是选择商品规格弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<div class="ecjia-goodsAttr-modal ecjia-attr-modal">
	<div class="modal-inners">
		<span class="ecjia-close-modal-icon"><i class="iconfont icon-close"></i></span>
		<div class="modal-title">{$goods_info.goods_name}</div>
		<div class="goods-attr-list">
			<!-- {foreach from=$goods_info.specification item=value key=key} -->
			<div class="goods-attr" data-index="{$key}">
				<p class="attr-name">{$value.name}</p>
				<ul>
					<!-- {foreach from=$value.value item=val key=key} -->
					<li class="{if $goods_info.has_spec eq 0}{if $key eq 0}active{/if}{else}{if $val.active eq 1}active{/if}{/if}" data-attr="{$val.id}" data-price="{$val.price}">{$val.label}</li>
					<!-- {/foreach} -->
				</ul>
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
	<div class="modal-buttons modal-buttons-2 modal-buttons-vertical">
		<div class="modal-left">
			<span class="goods-attr-price">{if $current_spec.goods_price}{$current_spec.goods_price}{else}￥{$goods_info.spec_price}{/if}</span>
			<span class="goods-attr-name">{$current_spec.attr}</span>
		</div>
		<div class="ecjia-choose-attr-box box {if $current_spec.rec_id}show{else}hide{/if}" id="goods_{$goods_info.id}">
			<span class="add add_spec" data-toggle="add-to-cart" goods_id="{$goods_info.id}" rec_id="{$current_spec.rec_id}"></span>
		    <label>{$current_spec.goods_number}</label>
		    <span class="reduce remove_spec" data-toggle="remove-to-cart" goods_id="{$goods_info.id}" rec_id="{$current_spec.rec_id}"></span>
		</div>           
		<a class="add-tocart add_spec {if $current_spec.rec_id}hide{else}show{/if}" data-toggle="add-to-cart" goods_id="{$goods_info.id}">加入购物车</a>
		<input type="hidden" name="goods_price" value="{if $goods_info.promote_price}{$goods_info.promote_price}{else}{$goods_info.unformatted_shop_price}{/if}" />
		<input type="hidden" name="check_spec" value="{RC_Uri::url('cart/index/check_spec')}&store_id={$goods_info.seller_id}" />
	</div>
</div>
<div class="ecjia-goodsAttr-overlay ecjia-goodsAttr-overlay-visible"></div>
{/nocache}