<?php
/*
Name: 购物车商品清单模板
Description: 购物车商品清单
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-order-detail ecjia-flow-goodslist">
	<div class="ecjia-checkout ecjia-margin-b">
		<div class="flow-goods-list">
			<ul class="goods-item">
				<!-- {foreach from=$list item=goods} -->
				<li>
					<div class="ecjiaf-fl goods-img">
						<img src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">{$goods.goods_name}</p>
						<p class="ecjia-goods-attr2">{if $goods.attr}{$goods.attr}{/if}</p>
						<p class="ecjia-color-red goods-attr-price">{$goods.formated_goods_price}</p>
					</div>
					<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
				</li>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->
{/nocache}