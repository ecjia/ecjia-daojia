<?php
/*
Name: 首页推荐商家
Description: 这是推荐商家
Libraries: suggest_store
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $data} -->
<div class="ecjia-mod ecjia-store-model ecjia-margin-t">
	<div class="head-title">
		<h2><i class="icon-store"></i>推荐店铺</h2>
	</div>
	<ul class="ecjia-suggest-store" id="suggest_store_list" {if $is_last neq 1}data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_suggest_store'}" data-page="2" {/if}>
		<!-- {foreach from=$data item=val} -->
		<li class="store-info">
			<div class="basic-info">
				<div class="store-left">
					<a href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
						<img src="{$val.seller_logo}">
					</a>
				</div>
				<div class="store-right">
					<a href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
						<div class="store-title">
							<span class="store-name">{$val.seller_name}</span>
							{if $val.manage_mode eq 'self'}<span class="manage_mode">自营</span>{/if}
							<span class="store-distance">{$val.distance}</span>
						</div>
						<div class="store-range">
							<i class="icon-shop-time"></i>{$val.label_trade_time}
						</div>
						<div class="store-notice">
							<i class="icon-shop-notice"></i>{$val.seller_notice}
						</div>
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
						<!-- {if $val.quickpay_activity_list} -->
						<ul class="store-promotion">
							<!-- {foreach from=$val.quickpay_activity_list item=list key=key} -->
							{if $key eq 0}
							<li class="quick">
								<span class="quick-label">买单</span>
								<span class="promotion-name">{$list.title}</span>
							</li>
							{/if}
							<!-- {/foreach} -->
						</ul>
						<!-- {/if} -->
					</a>
					{if $val.seller_goods}
					<div class="suggest-goods-list">
						<!-- {foreach from=$val.seller_goods item=goods key=key} -->
						<!-- {if $key < 4} -->
						<a href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
							<img src="{$goods.img.small}">
							<span class="goods_price">{if $goods.promote_price}{$goods.promote_price}{else}{$goods.shop_price}{/if}</span>
						</a>
						<!-- {/if} -->
						<!-- {/foreach} -->
					</div>
					{/if}
				</div>
				<div class="clear_both"></div>
			</div>
		</li>
		<!-- {/foreach} -->
	</ul>
</div>
<!-- {/if} -->