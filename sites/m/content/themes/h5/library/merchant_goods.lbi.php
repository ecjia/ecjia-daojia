<?php
/*
Name: 店铺商品模版
Description: 这是店铺商品
Libraries: merchant_goods
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->

<!-- {foreach from=$goods_list item=goods} -->
<li>
	<a class="linksGoods w" href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.id}">
		<img class="pic" src="{$goods.img.small}">
		<dl>
			<dt>{$goods.name}</dt>
			<dd><label>{$goods.shop_price}</label></dd>
		</dl>
	</a>
	<div class="box" id="goods_{$goods.id}">
    	<span class="reduce {if $goods.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$goods.rec_id}">减</span>
    	<label class="{if $goods.num}show{else}hide{/if}">{$goods.num}</label>
		<span class="add" data-toggle="add-to-cart" rec_id="{$goods.rec_id}" goods_id="{$goods.id}">加</span>
	</div>
</li>
<!-- {foreachelse} -->	
<div class="ecjia-merchant-goods ecjia-nolist">
	<p><img src="{$theme_url}images/no_goods.png"></p>
	暂无相关商品数据
</div>
<!-- {/foreach} -->	
<!-- {/block} -->