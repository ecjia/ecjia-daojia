<?php
/*
Name: 关注店铺列表
Description: 关注店铺列表
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$data item=val} -->
<li class="store-info">
	<div class="basic-info">
		<div class="store-left">
			<a class="seller-logo nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.store_id}">
				<img src="{$val.store_logo}">
				{if $val.shop_closed eq 1}
				<div class="shop_closed_mask">{t domain="h5"}休息中{/t}</div>
				{/if}
			</a>
		</div>
		<div class="store-right">
			<div class="store-title">
				<span class="store-name">{$val.store_name}</span>
				{if $val.manage_mode eq 'self'}<span class="manage_mode">{t domain="h5"}自营{/t}</span>{/if}
				<span class="store-distance">{$val.distance}</span>
			</div>
			<div class="store-range">
				<i class="icon-shop-time"></i>{$val.label_trade_time}
				
				<!-- {if $val.allow_use_quickpay eq 1} -->
				<a href="{RC_Uri::url('user/quickpay/init')}&store_id={$val.store_id}"><span class="store-quickpay-btn">{t domain="h5"}买单{/t}</span></a>
				<!-- {/if} -->
				
			</div>
			{if $val.store_notice}
			<div class="store-notice">
				<i class="icon-shop-notice"></i>{$val.store_notice}
			</div>
			{/if}
			<!-- {if $val.favourable_list} -->
			<ul class="store-promotion">
				<!-- {foreach from=$val.favourable_list item=list} -->
				<li class="promotion">
					<span class="promotion-label">{$list.type_label}</span>
					<span class="promotion-name">{$list.name}</span>
				</li>
				<!-- {/foreach} -->
			</ul>
			<!-- {/if} -->
			
			<!-- {if $val.allow_use_quickpay eq 1 && $val.quickpay_activity_list} -->
			<ul class="store-promotion">
				<!-- {foreach from=$val.quickpay_activity_list item=list key=key} -->
				{if $key eq 0}
				<li class="quick">
					<span class="quick-label">{t domain="h5"}买单{/t}</span>
					<span class="promotion-name">{$list.title}</span>
				</li>
				{/if}
				<!-- {/foreach} -->
			</ul>
			<!-- {/if} -->
			{if $val.seller_goods}
			<div class="suggest-goods-list">
				<!-- {foreach from=$val.seller_goods item=goods key=key} -->
				<!-- {if $key < 4} -->
				<a class="nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.store_id}">
					<img src="{$goods.img.small}">
					<span class="goods_price">{$goods.shop_price}</span>
				</a>
				<!-- {/if} -->
				<!-- {/foreach} -->
			</div>
			{/if}
		</div>
		<div class="clear_both"></div>
	</div>
	<div class="remove-info" data-toggle="follow_store" data-type=0 data-url='{url path="merchant/index/follow_store" args="store_id={$val.store_id}"}' data-message='{t domain="h5"}确定取消关注该店铺？{/t}'><span>{t domain="h5"}删除{/t}</span></div>
</li>
<!-- {foreachelse} -->
<div class="ecjia-empty-list">
    <div class="ecjia-nolist">
    	{t domain="h5"}暂无关注店铺{/t}
    </div>
</div>
<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}