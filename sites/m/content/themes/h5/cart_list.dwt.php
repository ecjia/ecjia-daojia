<?php
/*
Name: 购物车列表模板
Description: 购物车列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<a href="{RC_Uri::url('location/index/select_location')}{if $referer_url}&referer_url={$referer_url}{/if}">
	<div class="flow-address flow-cart {if $address_id eq 0 || !$address_id}location_address{/if}">
		<label class="ecjiaf-fl">{t}送至：{/t}</label>
		<div class="ecjiaf-fl address-info">
			{if $address_id gt 0}
				<span>{$address_info.consignee}</span>
				<span>{$address_info.mobile}</span>
				<p class="ecjia-truncate2 address-desc">{$address_info.address}{$address_info.address_info}</p>
			{else}
				<span>{$smarty.cookies.location_name}</span>
			{/if}
		</div>
	</div>
</a>

<!-- {if !$not_login} -->
	<!-- {if $cart_list} -->
	<div class="ecjia-flow-cart">
		<ul>
			<!-- {foreach from=$cart_list item=val} -->
			<li class="cart-single">
				<div class="item">
					<div class="check-wrapper">
						<span class="cart-checkbox check_all {if $val.total.check_all eq 1}checked{/if}" id="store_check_{$val.seller_id}" data-store="{$val.seller_id}"></span>
					</div>
					<div class="shop-title-content">
						<a href="{RC_Uri::url('merchant/index/init')}&store_id={$val.seller_id}">
							<span class="shop-title-name"><i class="iconfont icon-shop"></i>{$val.seller_name}</span>
							{if $val.manage_mode eq 'self'}<span class="self-store">自营</span>{/if}
						</a>
						<span class="shop-edit" data-store="{$val.seller_id}" data-type="edit">编辑</span>
					</div>
				</div>
				<ul class="items">
					<!-- {foreach $val.goods_list item=v} -->
					<li class="item-goods cart_item_{$val.seller_id} {if $v.is_disabled}disabled{/if}">
						<span class="cart-checkbox checkbox_{$val.seller_id} {if $v.is_checked eq 1}checked{/if} {if $v.is_disabled}disabled{/if}" data-store="{$val.seller_id}" rec_id="{$v.rec_id}" goods_id="{$v.goods_id}" data-num="{$v.goods_number}"></span>
						<div class="cart-product">
							<a class="cart-product-photo" href="{RC_Uri::url('goods/index/show')}&goods_id={$v.goods_id}">
								<img src="{$v.img.thumb}">
								{if $v.is_disabled}
								<div class="product_empty">库存不足</div>
								{/if}
							</a>
							<div class="cart-product-info">
								<div class="cart-product-name {if $v.is_disabled}disabled{/if}"><a href="{RC_Uri::url('goods/index/show')}&goods_id={$v.goods_id}">{$v.goods_name}</a></div>
								<div class="cart-product-price {if $v.is_disabled}disabled{/if}">{if $v.goods_price eq 0}免费{else}{$v.formated_goods_price}{/if}</div>
								<div class="ecjia-input-number input_number_{$val.seller_id} {if $v.is_disabled}disabled{/if}" data-store="{$val.seller_id}">
			                        <span class="ecjia-number-group-addon" data-toggle="remove-to-cart" rec_id="{$v.rec_id}" goods_id="{$v.goods_id}">－</span>
			                        {if $v.is_disabled}
			                        <span class="ecjia-number-contro">{$v.goods_number}</span>
			                        {else}
			                        <input type="tel" class="ecjia-number-contro" value="{$v.goods_number}" autocomplete="off" rec_id="{$v.rec_id}"/>
			                        {/if}
			                        <span class="ecjia-number-group-addon" data-toggle="add-to-cart" rec_id="{$v.rec_id}" goods_id="{$v.goods_id}">＋</span>
			                    </div>
							</div>
						</div>
					</li>
					<!-- {/foreach} -->
				</ul>
				<div class="item-count">
					<span class="count">合计：</span>
					<span class="price price_{$val.seller_id}">{$val.total.goods_price}{if $val.total.discount neq 0}<lable class="discount">(已减{$val.total.discount})</lable>{/if}</span>
					<a class="check_cart check_cart_{$val.seller_id} {if !$val.total.check_one}disabled{/if}" data-href="{RC_Uri::url('cart/flow/checkout')}" data-store="{$val.seller_id}" data-address="{$address_id}" data-rec="{$val.total.data_rec}" href="javascript:;">去结算</a>
				</div>
			</li>
			<input type="hidden" name="update_cart_url" value="{RC_Uri::url('cart/index/update_cart')}">
			<!-- {/foreach} -->
		</ul>
		<div class="flow-nomore-msg"></div>
	</div>
	<!-- {/if} -->
<!-- {/if} -->
<div class="flow-no-pro {if $cart_list}hide{elseif $no_login}show{/if}">
	<div class="ecjia-nolist">
		您还没有添加商品
		{if $not_login}
		<a class="btn btn-small" type="button" href="{url path='user/user_privilege/login'}{if $referer_url}&referer_url={$referer_url}{/if}">{t}点击登录{/t}</a>
		{else}
		<a class="btn btn-small" type="button" href="{url path='touch/index/init'}">{t}去逛逛{/t}</a>
		{/if}
	</div>
</div>
<!-- #BeginLibraryItem "/library/choose_address_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->