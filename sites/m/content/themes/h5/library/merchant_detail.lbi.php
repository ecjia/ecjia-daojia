<?php
/*
Name: 快速导航
Description: 这是首页和用户中心页面的快速导航模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-store-detail ecjia-store-toggle hide" id="store-seller">
	<div class="store-hr"></div>
	<ul class="store-goods">
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.count}</span><br>
			<span class="store-goods-desc">全部商品</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.new_goods}</span><br>
			<span class="store-goods-desc">上新</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.best_goods}</span><br>
			<span class="store-goods-desc">促销</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.hot_goods}</span><br>
			<span class="store-goods-desc">店铺动态</span>
		</li>
	</ul>
	<div class="store-hr"></div>
	{if $store_info.favourable_list}
	<ul class="store-promotion">
		<!-- {foreach from=$store_info.favourable_list item=list} -->
		<li class="promotion">
			<span class="promotion-label">{$list.type_label}</span>
			<span class="promotion-name">{$list.name}</span>
		</li>
		<!-- {/foreach} -->
	</ul>
	{/if}
	<div class="store-hr"></div>
	<div class="store-tel">
		<span class="tel-name"><i class="icon-shop-phone"></i>商家电话</span>
		<p class="tel-result">{if $store_info.telephone}{$store_info.telephone}<a href="tel:{$store_info.telephone}"><i class="icon-call-phone"></i></a>{else}暂无{/if}</p>
	</div>
	<div class="store-hr"></div>
	<ul class="store-other-info">
		<li>
			<span class="other-info-name"><i class="icon-shop-buliding"></i>公司名称</span>
			<p class="other-info-result">{if $store_info.shop_name}{$store_info.shop_name}{else}暂无{/if}</p>
		</li>
		<li>
			<span class="other-info-name"><i class="icon-shop-location"></i>所在地区</span>
			<p class="other-info-result">{if $store_info.shop_address}{$store_info.shop_address}{else}暂无{/if}</p>
		</li>
		<li>
			<span class="other-info-name"><i class="icon-shop-time"></i>营业时间</span>
			<p class="other-info-result">{if $store_info.label_trade_time}{$store_info.label_trade_time}{else}暂无{/if}</p>
		</li>
		<li>
			<span class="other-info-name"><i class="icon-shop-description"></i>商家简介</span>
			<p class="other-info-result">{if $store_info.shop_description}{$store_info.shop_description}{else}暂无{/if}</p>
		</li>
	</ul>
</div>
