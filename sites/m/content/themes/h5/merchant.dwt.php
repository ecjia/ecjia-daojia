<?php
/*
Name: 店铺商品
Description: 这是店铺商品页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod page_hearder_hide ecjia-fixed">
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
</div>

<!-- #BeginLibraryItem "/library/merchant_head.lbi" --><!-- #EndLibraryItem -->
<div class="ecjia-mod ecjia-store-ul">
	<ul>
		<li class="ecjia-store-li"><span class="active">购物</span></li>
		<li class="ecjia-store-li" data-url="{$url}&status=comment"><span>评价</span></li>
		<li class="ecjia-store-li"><span class="{if $status eq 'store'}active{/if}">商家</span></li>
	</ul>
</div>
<div class="ecjia-mod ecjia-store-goods ecjia-store-toggle">
	<div class="a1n a2g">
		<div class="a21 clearfix">
			<ul class="a1o">
				<!-- {if $store_info.goods_count.best_goods gt 0} -->
				<li class="a1p {if $action_type eq 'best'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}&type=best" data-toggle="toggle-category" data-type="best">精选</strong>
				</li>
				<!-- {/if} -->

				<!-- {if $store_info.goods_count.hot_goods gt 0} -->
				<li class="a1p {if $action_type eq 'hot'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}&type=hot" data-toggle="toggle-category" data-type="hot">热销</strong>
				</li>
				<!-- {/if} -->

				<!-- {if $store_info.goods_count.new_goods gt 0} -->
				<li class="a1p {if $action_type eq 'new'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}&type=new" data-toggle="toggle-category" data-type="new">新品</strong>
				</li>
				<!-- {/if} -->

				<li class="a1p {if (!$category_id && !$action_type) || $action_type eq 'all'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}&type=all" data-toggle="toggle-category" data-type="all">全部</strong>
				</li>

				<!-- {if $store_category} -->
					<!-- {foreach from=$store_category item=val} -->
					<li class="a1p {if $val.id eq $category_id}a1r{/if}">
						<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}" data-category="{$val.id}" data-toggle="toggle-category">{$val.name}</strong>
						<!-- {if $val.children} -->
							<strong class="a1v">
							<!-- {foreach from=$val.children item=v} -->
							<span class="a1u h a1w" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}" data-category="{$v.id}" data-toggle="toggle-category">
								{$v.name}
							</span>
							<!-- {/foreach} -->
							</strong>
						<!-- {/if} -->
					</li>
					<!-- {/foreach} -->
				<!-- {/if} -->
			</ul>
			<div class="a20">
				{$type_name}({$goods_num})
			</div>
			<div class="a1x wd" id="wd_list">
				<div class="a1z r2 a0h">
					<ul class="store_goods_{$action_type}" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='merchant/index/ajax_goods'}&store_id={$store_id}" data-type="{$action_type}">
					</ul>
				</div>
			</div>
			<input type="hidden" value="{RC_Uri::url('cart/index/update_cart')}" name="update_cart_url" />
			<input type="hidden" value="{$store_id}" name="store_id" />
			<input type="hidden" value="{$action_type}" name="type" />
		</div>
	</div>
</div>
<!-- #BeginLibraryItem "/library/merchant_detail.lbi" --><!-- #EndLibraryItem -->

<div class="ecjia-mod store-add-cart a4w">
	<div class="a52"></div>
	<a href="javascript:void 0;" class="a4x {if $real_count.goods_number}light{else}disabled{/if} outcartcontent show show_cart" show="false">
		{if $real_count.goods_number}
		<i class="a4y">
		{if $real_count.goods_number gt 99}99+{else}{$real_count.goods_number}{/if}
		</i>
		{/if}
	</a>
	<div class="a4z" style="transform: translateX(0px);">
		{if !$real_count.goods_number}
			<div class="a50">购物车是空的</div>
		{else}
		<div>
			{$count.goods_price}{if $count.discount neq 0}<label>(已减{$count.discount})</label>{/if}
		</div>
		{/if}
	</div>
	<a class="a51 {if !$count.check_one}disabled{/if} check_cart" data-href="{RC_Uri::url('cart/flow/checkout')}" data-store="{$store_id}" data-address="{$address_id}" data-rec="{$rec_id}">去结算</a>
	<div class="minicart-content" style="transform: translateY(0px); display: block;">
		<a href="javascript:void 0;" class="a4x {if $count.goods_number}light{else}disabled{/if} incartcontent show_cart" show="false">
			{if $real_count.goods_number}
			<i class="a4y">
			{if $real_count.goods_number gt 99}99+{else}{$real_count.goods_number}{/if}
			</i>
			{/if}
		</a>
		<i class="a57"></i>
		<div class="a58 ">
			<span class="a69 a6a {if $count.check_all}checked{/if}" data-toggle="toggle_checkbox" data-children=".checkbox" id="checkall">全选</span>
			<p class="a6c">(已选{$count.goods_number}件)</p>
			<a href="javascript:void 0;" class="a59" data-toggle="deleteall" data-url="{RC_Uri::url('cart/index/update_cart')}">清空购物车</a>
		</div>
		
		<div class="a5b" style="max-height: 25em;">
			<div class="a5l single">
				{if $store_info.favourable_list}
				<ul class="store-promotion" id="store-promotion">
					<!-- {foreach from=$store_info.favourable_list item=list} -->
					<li class="promotion">
						<span class="promotion-label">{$list.type_label}</span>
						<span class="promotion-name">{$list.name}</span>
					</li>
					<!-- {/foreach} -->
				</ul>
				{/if}
				<ul class="minicart-goods-list single">
					<!-- {foreach from=$cart_list item=cart} -->
					<li class="a5n single {if $cart.is_disabled eq 1}disabled{/if}">
						<span class="a69 a5o {if $cart.is_checked}checked{/if} checkbox {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="toggle_checkbox" rec_id="{$cart.rec_id}"></span>
						<table class="a5s">
							<tbody>
								<tr>
									<td style="width:75px; height:75px">
										<img class="a7g" src="{$cart.img.small}">
										{if $cart.is_disabled eq 1}
										<div class="product_empty">{$cart.disabled_label}</div>
										{/if}
									</td>
									<td>
										<div class="a7j">{$cart.goods_name}</div>
										{if $cart.attr}<div class="a7s">{$cart.attr}</div>{/if}
										<span class="a7c">
										{if $cart.goods_price eq 0}免费{else}{$cart.formated_goods_price}{/if}
										</span>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="box" id="goods_cart_{$cart.goods_id}">
							<span class="a5u reduce {if $cart.is_disabled eq 1}disabled{/if} {if $cart.attr}attr_spec{/if}" data-toggle="remove-to-cart" rec_id="{$cart.rec_id}" goods_id="{$cart.goods_id}"></span>
							<lable class="a5x">{$cart.goods_number}</lable>
							<span class="a5v {if $cart.is_disabled eq 1}disabled{/if} {if $cart.attr}attr_spec{/if}" data-toggle="add-to-cart" rec_id="{$cart.rec_id}" goods_id="{$cart.goods_id}"></span>
						</div>
					</li>
					<input type="hidden" name="rec_id" value="{$cart.rec_id}" />
					<!-- {/foreach} -->
				</ul>
				<div class="a5m single"></div>
			</div>
		</div>
	</div>
</div>
<!-- 遮罩层 -->
<div class="a53" style="display: none;"></div>
<!-- #BeginLibraryItem "/library/address_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/store_notice_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/goods_attr_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/goods_attr_static_modal.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步购物车列表 start-->
	<!-- {foreach from=$list item=val} 循环商品 -->
	<li class="a5n single {if $val.is_disabled eq 1}disabled{/if}">
		<span class="a69 a5o {if $val.is_checked}checked{/if} checkbox {if $val.is_disabled eq 1}disabled{/if}" data-toggle="toggle_checkbox" rec_id="{$val.rec_id}"></span>
		<table class="a5s">
			<tbody>
				<tr>
					<td style="width:75px; height:75px">
						<img class="a7g" src="{$val.img.small}">
						<div class="product_empty">
						{if $val.is_disabled eq 1}{$val.disabled_label}{/if}
						</div>
					</td>
					<td>
						<div class="a7j">{$val.goods_name}</div> 
						{if $val.attr}<div class="a7s">{$val.attr}</div>{/if}
						<span class="a7c">
						{if $val.goods_price eq 0}免费{else}{$val.formated_goods_price}{/if}
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="box" id="goods_cart_{$val.goods_id}">
			<span class="a5u reduce {if $val.is_disabled eq 1}disabled{/if} {if $val.attr}attr_spec{/if}" data-toggle="remove-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.goods_id}"></span>
			<lable class="a5x">{$val.goods_number}</lable>
			<span class="a5v {if $val.is_disabled eq 1}disabled{/if} {if $val.attr}attr_spec{/if}" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.goods_id}"></span>
		</div>
	</li>
	<input type="hidden" name="rec_id" value="{$val.rec_id}" />
	<!-- {/foreach} -->
	<!-- 异步购物车列表end -->
<!-- {/block} -->
{/nocache}