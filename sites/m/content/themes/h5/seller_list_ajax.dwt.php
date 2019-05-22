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
<!-- {foreach from=$data item=val} -->
<li class="single_item">
	<ul class="single_store">
		<li class="store-info">
			<a class="nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
			<div class="basic-info">
				<div class="store-left">
					<img src="{$val.seller_logo}">
					{if $val.shop_closed eq 1}
						<div class="shop_closed_mask">{t domain="h5"}休息中{/t}</div>
					{/if}
				</div>
				<div class="store-right">
					<div class="store-title">
						<span class="store-name">{$val.seller_name}</span>
						{if $val.manage_mode eq 'self'}<span class="manage_mode">{t domain="h5"}自营{/t}</span>{/if}
						{if $val.distance}<span class="store-distance">{$val.distance}</span>{/if}
					</div>
					<div class="store-range">
						<i class="icon-shop-time"></i>{$val.label_trade_time}
						<!-- {if $val.allow_use_quickpay eq 1} -->
							<a href="{RC_Uri::url('user/quickpay/init')}&store_id={$val.id}"><span class="store-quickpay-btn">{t domain="h5"}买单{/t}</span></a>
						<!-- {/if} -->
					</div>
					{if $val.seller_notice neq ''}
					<div class="store-notice">
						<i class="icon-shop-notice"></i>{$val.seller_notice}
					</div>
					{/if}
				</div>
				<div class="clear"></div>
			</div>
			{if $val.favourable_list}
			<ul class="store-promotion">
				<!-- {foreach from=$val.favourable_list item=list} -->
				<li class="promotion">
					<span class="promotion-label">{$list.type_label}</span>
					<span class="promotion-name">{$list.name}</span>
				</li>
				<!-- {/foreach} -->
			</ul>
			{/if}

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

			</a>
		</li>
	</ul>
</li>
<!-- {foreachelse} -->
<div class="search-no-pro">
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/no_store.png"></p>
		{t domain="h5"}暂时没有商家{/t}
	</div>
</div>
<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}