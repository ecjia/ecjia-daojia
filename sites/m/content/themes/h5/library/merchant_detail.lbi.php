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
			<span class="store-goods-desc">{t domain="h5"}全部商品{/t}</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.new_goods}</span><br>
			<span class="store-goods-desc">{t domain="h5"}上新{/t}</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.best_goods}</span><br>
			<span class="store-goods-desc">{t domain="h5"}促销{/t}</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.hot_goods}</span><br>
			<span class="store-goods-desc">{t domain="h5"}店铺动态{/t}</span>
		</li>
	</ul>
	
	{if $store_info.allow_use_quickpay eq 1}
	<div class="store-hr"></div>
	<ul class="store-promotion">
		<li class="quick">
			<span class="quick-label">{t domain="h5"}买单{/t}</span>
			<span class="quick-name">{t domain="h5"}买单立享优惠{/t}</span>
			<a class="quick-btn" href="{RC_Uri::url('user/quickpay/init')}&store_id={$store_info.id}" >{t domain="h5"}优惠买单{/t}</a>
		</li>
		{if $store_info.quick_activity_list}
		<ul class="quick-item">
		<!-- {foreach from=$store_info.quickpay_activity_list item=list key=key} -->
		<li class="quick-li">
			<div class="quick-left">
				<span class="quick-name">{$list.title}</span>
				{if $list.limit_time_weekly neq '' || $list.limit_time_daily neq ''}
				<span class="quick-time">（{$list.limit_time_weekly}&nbsp;{$list.limit_time_daily}）</span>
				{/if}
			</div>
		</li>
		<!-- {/foreach} -->
		</ul>
		{/if}
	</ul>
	{/if}
	
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
		<span class="tel-name"><i class="icon-shop-phone"></i>{t domain="h5"}商家电话{/t}</span>
		<p class="tel-result">{if $store_info.telephone}{$store_info.telephone}<a class="external" href="tel:{$store_info.telephone}"><i class="icon-call-phone"></i></a>{else}{t domain="h5"}暂无{/t}{/if}</p>
	</div>
	<div class="store-hr"></div>
	<ul class="store-other-info">
		<li>
			<span class="other-info-name"><i class="icon-shop-buliding"></i>{t domain="h5"}公司名称{/t}</span>
			<p class="other-info-result">{if $store_info.shop_name}{$store_info.shop_name}{else}{t domain="h5"}暂无{/t}{/if}</p>
		</li>
		<li>
			<span class="other-info-name"><i class="icon-shop-location"></i>{t domain="h5"}所在地区{/t}</span>
			{if $store_info.shop_address}<a href="{$header_right.location_url}" class="nopjax external">{/if}
				<p class="other-info-result {if $store_info.shop_address}shop-address-result{/if}">{if $store_info.shop_address}{$store_info.shop_address}{else}{t domain="h5"}暂无{/t}{/if}</p>
				<i class="icon-position"></i>
			{if $store_info.shop_address}</a>{/if}
		</li>
		<li>
			<span class="other-info-name"><i class="icon-shop-time"></i>{t domain="h5"}营业时间{/t}</span>
			<p class="other-info-result">{if $store_info.label_trade_time}{$store_info.label_trade_time}{else}{t domain="h5"}暂无{/t}{/if}</p>
		</li>
		<li>
			<span class="other-info-name"><i class="icon-shop-description"></i>{t domain="h5"}商家简介{/t}</span>
			<p class="other-info-result">{if $store_info.seller_description}{$store_info.seller_description}{else}{t domain="h5"}暂无{/t}{/if}</p>
		</li>
		{if $store_info.business_licence_pic}
		<li>
			<span class="other-info-name"><i class="icon-shop-description"></i>{t domain="h5"}营业执照{/t}</span>
			<div class="other-info-result business_licence_pic">
				<div class="img-list img-pwsp-list" data-pswp-uid="business_licence_pic">
					<figure><span><a class="nopjax external" href="{$store_info.business_licence_pic}"><img src="{$store_info.business_licence_pic}" /></a></span></figure>
				</div>
			</div>
		</li>
		{/if}
	</ul>
</div>
