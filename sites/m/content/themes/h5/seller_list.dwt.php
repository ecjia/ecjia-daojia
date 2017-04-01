<?php 
/*
Name: 分类店铺
Description: 这是分类店铺页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-store-goods-list">
	<ul class="ecjia-store-list m_t0" id="ecjia-seller-list" {if $is_last neq 1}data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='goods/category/seller_list'}&type=ajax_get&cid={$cid}"{/if}>
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- {foreach from=$data item=val} -->
	<li class="single_item">
		<ul class="single_store">
			<li class="store-info">
				<a href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
				<div class="basic-info">
					<div class="store-left">
						<img src="{$val.seller_logo}">
					</div>
					<div class="store-right">
						<div class="store-name">
							{$val.seller_name}{if $val.manage_mode eq 'self'}<span>自营</span>{/if}
							{if $val.distance}<span class="store-distance">{$val.distance}</span>{/if}
						</div>
						<div class="store-range">
							<i class="icon-shop-time"></i>{$val.label_trade_time}
						</div>
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
				</a>
			</li>
		</ul>
	</li>
	<!-- {foreachelse} -->
	<div class="search-no-pro">
		<div class="ecjia-nolist">
			<p><img src="{$theme_url}images/no_store.png"></p>
			暂时没有商家
		</div>
	</div>
	<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}