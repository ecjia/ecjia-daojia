<?php
/*
Name: 促销商品详情模板
Description: 这是促销商品详情模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.touch.goods_detail.init();
ecjia.touch.category.init();
{if $is_weixin}
var config = '{$config}';
{/if}

{if $releated_goods}
var releated_goods = {$releated_goods};
{/if}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-goods-detail-header ecjia-header-index" style="background:#47aa4d none repeat scroll 0 0;">
	<ul>
		<li><a class="goods-tab tab1 active" href="javascript:;" data-type="1">{t domain="h5"}商品{/t}</a></li>
		<li><a class="goods-tab tab2" href="javascript:;" data-type="2">{t domain="h5"}详情{/t}</a></li>
		<li><a class="goods-tab tab3" href="javascript:;" data-type="3">{t domain="h5"}评价{/t}</a></li>
	</ul>
</div>
{if $no_goods_info eq 1}
<div class="ecjia-no-goods-info">{t domain="h5"}不存在的信息{/t}</div>
{/if}
<!-- 切换商品页面start -->
{if $no_goods_info neq 1}
<div class="ecjia-goods-basic-info" id="goods-info-one">
	<!--商品图片相册start-->
	<div class="focus" id="focus">
		<div class="hd">
			<ul></ul>
		</div>
		<div class="bd">
			<!-- Swiper -->
			<div class="swiper-container swiper-goods-img">
				<div class="swiper-wrapper">
					{if $goods_info.pictures}
					<!--{foreach from=$goods_info.pictures item=picture}-->
					<div class="swiper-slide" style="margin-top:3.5em;">
						<span class="wheel-planting-goods-img">
							<img src="{$picture.thumb}" style="height: 40rem;" /></span>
					</div>
					<!--{/foreach}-->
					{else}
					<div class="swiper-slide">
						<img src="{$theme_url}images/default-goods-pic.png" />
					</div>
					{/if}
				</div>
				<!-- Add Pagination -->
				{if count($goods_info.pictures) > 1}
				<div class="swiper-pagination"></div>
				{/if}
			</div>
		</div>
	</div>
	<!--商品图片相册end-->
	<!--商品属性介绍-->
	<form action="{url path='cart/index/add_to_cart'}" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY">
		<div class="goods-info">
			<div class="goods-info-property  goods-info-property-new">
				<!--商品描述-->
				<div class="goods-style-name goods-style-name-new">
					<div class=" ecjiaf-fl goods-name-new">
						<span class="background-ff8214">{t domain="h5"}促{/t}</span>
						{$goods_info.goods_name}
					</div>
				</div>
				
				<div class="goods-groupbuy-div">
					<div class="groupbuy-left {if $goods_info.promote_user_limited}two-line{/if}">
						<p>{t domain="h5" 1={$goods_info.promote_limited}}限购总数：%1 件{/t}</p>
						{if $goods_info.promote_user_limited}<p>{t domain="h5" 1={$goods_info.promote_user_limited}}每人限购：%1 件{/t}</p>{/if}
					</div>

					<div class="groupbuy-right">
						<p class="text-left">{t domain="h5"}距离促销结束{/t}</p>
						<span class="goods-detail-promote" data-type="2" value="{$goods_info.promote_end_time}"></span>
					</div>
				</div>
				
				<div class="goods-price goods-price-new" goods_id="{$goods_info.id}" data-price="{$goods_info.promote_price}">
					<!-- $goods.is_promote and $goods.gmt_end_time -->

					<!--{if ($goods_info.promote_price gt 0) AND ($goods_info.promote_start_date lt $goods_info.promote_end_date) AND ($goods_info.promote_price lt $goods_info.unformatted_shop_price)} 促销-->

					<div class="ecjia-price-time">
						<div class="time-left">
							{if $goods_info.default_product_spec.product_shop_price_label neq ''}
								<span class="ecjia-promote_price-span">{$goods_info.default_product_spec.product_shop_price_label}</span>
							{else}
								<span class="ecjia-promote_price-span">{$goods_info.shop_price}</span>
							{/if}
							<del>{t domain="h5"}原价：{/t}{$goods_info.unformatted_shop_price}</del></br>
						</div>

						{if $goods_info.shop_closed neq 1}
						<div class="cart-plus-right goods_spec_{$goods_info.id}" goods_id="{$goods_info.id}">
							{if $goods_info.specification}
							<span class="goods-add-cart choose_attr {if $goods_info.in_related_goods eq 1}spec_goods{/if}" goods_id="{$goods_info.id}">{t domain="h5"}选规格{/t}</span>
							{if $goods_attr_num}<i class="attr-number" style="right: 0.2em;top: 0.2em;">{$goods_attr_num}</i>{/if}
							{else}
							<span class="goods-add-cart add-cart-a {if $rec_id}hide{/if}" data-toggle="add-to-cart"
							 goods_id="{$goods_info.id}" act_id="{$goods_info.goods_activity_id}">{t domain="h5"}加入购物车{/t}</span>
							<div class="ecjia-goods-plus-box {if !$rec_id}hide{/if} box" id="goods_{$goods_info.id}">
								<span class="reduce" data-toggle="remove-to-cart" rec_id="{$rec_id}">{t domain="h5"}减{/t}</span>
								<label>{if !$rec_id}1{else}{$num}{/if}</label>
								<span class="add detail-add" data-toggle="add-to-cart"
								 rec_id="{$rec_id}" goods_id="{$goods_info.id}">{t domain="h5"}加{/t}</span>
							</div>
							{/if}
						</div>
						{/if}
					</div>
					<!--{else}-->
					<span class="ecjia-price-span">{if $goods_info.promote_price gt 0}{$goods_info.formated_promote_price}{else}{$goods_info.shop_price}{/if}</span>
					{if $goods_info.market_price}
                    <del>{t domain="h5"}市场价：{/t}{$goods_info.market_price}</del>
                    {/if}

					{if $goods_info.shop_closed neq 1}
					{if $goods_info.specification}
					<span class="goods_spec_{$goods_info.id}">
						<span class="goods-add-cart choose_attr {if $goods_info.in_related_goods eq 1}spec_goods{/if}" goods_id="{$goods_info.id}">{t domain="h5"}选规格{/t}</span>
						{if $goods_attr_num}<i class="attr-number">{$goods_attr_num}</i>{/if}
					</span>
					{else}
					<span class="goods-add-cart market-goods-add-cart add-cart-a {if $rec_id}hide{/if}" data-toggle="add-to-cart"
					 rec_id="{$rec_id}" goods_id="{$goods_info.id}" act_id="{$goods_info.goods_activity_id}">{t domain="h5"}加入购物车{/t}</span>
					<div class="ecjia-goods-plus-box ecjia-market-plus-box {if !$rec_id}hide{/if} box" id="goods_{$goods_info.id}">
						<span class="reduce" data-toggle="remove-to-cart" rec_id="{$rec_id}">{t domain="h5"}减{/t}</span>
						<label>{if !$rec_id}1{else}{$num}{/if}</label>
						<span class="add detail-add" data-toggle="add-to-cart" rec_id="{$rec_id}"
						 goods_id="{$goods_info.id}">{t domain="h5"}加{/t}</span>
					</div>
					{/if}
					{/if}
					<!-- {/if} -->
					
					{if $goods_info.default_product_spec.product_goods_attr_label neq ''}
					<div class="groupbuy_notice">
						<div class="item">
							<div class="left" style="width:3em;">{t domain="h5"}已选{/t}</div>
							<div class="right" style="margin-left:3em;">{$goods_info.default_product_spec.product_goods_attr_label}</div>
						</div>
					</div>
					{/if}
				</div>
				<!-- {if $goods_info.favourable_list} -->
				<div class="ecjia-favourable-goods-list">
					<ul class="store-promotion">
						<!-- {foreach from=$goods_info.favourable_list item=favour  name=foo} -->
						<!-- {if $smarty.foreach.foo.index < 2 } -->
						<li class="promotion">
							<span class="promotion-label">{$favour.type_label}</span>
							<span class="promotion-name">{$favour.name}</span>
						</li>
						<!-- {/if} -->
						<!-- {/foreach} -->
					</ul>
				</div>
				<!-- {/if} -->
				<input type="hidden" value="{RC_Uri::url('cart/index/update_cart')}" name="update_cart_url" />
				<input type="hidden" value="{$goods_info.seller_id}" name="store_id" />
			</div>
			<a class="nopjax external" href='{url path="merchant/index/init" args="store_id={$goods_info.seller_id}"}'>
				<div class="bd goods-type ecjia-margin-t store-name">
					<div class="goods-option-con goods-num goods-option-con-new">
						<div class="ecjia-merchants-name">
							<span class="shop-title-name"><i class="iconfont icon-shop"></i>{$goods_info.seller_name}</span>
							<i class="iconfont icon-jiantou-right"></i>
						</div>
					</div>
				</div>
			</a>

			<a class="goods-tab tab3" href="javascript:;" data-type="3">
				<div class="bd goods-type ecjia-margin-t">
					<div class="goods-option-con goods-num goods-option-con-new">
						<div class="ecjia-merchants-name">
							{if $comment_list.list}
							<span class="shop-title-name">{t domain="h5" 1={$comment_number.all}}商品评价(%1人评价){/t}</span>
							<i class="iconfont icon-jiantou-right"></i>
							<span class="comment_score">{$comment_list.comment_percent}{t domain="h5"}好评{/t}</span>
							{else}
							<span class="shop-title-name">{t domain="h5"}商品评价{/t}</span>
							<i class="iconfont icon-jiantou-right"></i>
							{/if}
						</div>
					</div>
				</div>
			</a>


            <!-- #BeginLibraryItem "/library/goods_smiple_comment.lbi" --><!-- #EndLibraryItem -->
            <!-- #BeginLibraryItem "/library/goods_related_goods.lbi" --><!-- #EndLibraryItem -->
		</div>
	</form>
</div>
{/if}
<!-- 切换商品页面end -->

<!-- 切换详情页面start -->
<!-- #BeginLibraryItem "/library/goods_description.lbi" --><!-- #EndLibraryItem -->
<!-- 切换详情页面end -->

<div class="goods-desc-info active ecjia-seller-comment" id="goods-info-three" style="margin-top:7.5em;">
<!-- #BeginLibraryItem "/library/goods_comment.lbi" --><!-- #EndLibraryItem -->
</div>

<!-- #BeginLibraryItem "/library/goods_cart.lbi" --><!-- #EndLibraryItem -->
<!-- 遮罩层 -->
<div class="a53" style="display: none;"></div>
<input type="hidden" name="share_title" value="{$goods_info.goods_name}">
<input type="hidden" name="share_desc" value="{$goods_info.goods_brief}">
<input type="hidden" name="share_image" value="{$product_info.img.thumb}">
<input type="hidden" name="share_link" value="{$share_link}">
<input type="hidden" name="share_page" value="1">

<input type="hidden" name="product_id" value="0" data-url="{RC_Uri::url('goods/index/show')}&goods_id={$goods_info.id}"/>

<!-- #BeginLibraryItem "/library/address_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/goods_attr_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/goods_attr_static_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/preview_image.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/change_goods_num.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
{/nocache}