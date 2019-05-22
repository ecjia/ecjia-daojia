<?php 
/*
Name: 新品推荐模版
Description: 新品推荐列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- 异步商品列表 start-->
<!-- {if $goods_list} -->
<!-- {foreach from=$goods_list item=goods} 循环商品 -->
<li class="single_item">
	<a class="list-page-goods-img nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.id}&product_id={$goods.product_id}">
		<span class="goods-img">
			<img src="{$goods.img.thumb}" alt="{$goods.name}">
		</span>
		<span class="list-page-box">
			<p class="merchants-name"><i class="iconfont icon-shop"></i>{$goods.seller_name}{if $goods.manage_mode eq 'self'}<span class="manage_mode">{t domain="h5"}自营{/t}</span>{/if}</p>
			<span class="goods-name">{$goods.name}</span>
			<span class="list-page-goods-price">
				<span>{$goods.shop_price}</span>
			</span>
		</span>
	</a>
</li>
<!-- {/foreach} -->
<!-- {else} -->
<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		{t domain="h5"}暂无商品{/t}
	</div>
</div>
<!-- {/if} -->
<!-- 异步商品列表end -->
<!-- {/block} -->
{/nocache}