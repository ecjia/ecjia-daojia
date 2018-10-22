<?php
/*
Name: 首页模板
Description: 这是首页
Libraries: page_menu,page_header,model_banner,model_nav,model_brand_list
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.index.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<!-- TemplateBeginEditable name="页面内容" desc="首页侧边栏" -->
<!-- #BeginLibraryItem "/library/index_header.lbi" --><!-- #EndLibraryItem -->
{nocache}
<div class="ecjia-placeholder"></div>
{if $home_data}
<!-- {foreach from=$home_data item=value key=key} -->
	{if $value.module eq 'home_cycleimage'}
	<!-- #BeginLibraryItem "/library/model_banner.lbi" --><!-- #EndLibraryItem -->
	{else if $value.module eq 'home_shortcut'}
	<!-- #BeginLibraryItem "/library/model_nav.lbi" --><!-- #EndLibraryItem -->
	{else if $value.module eq 'home_complex_adsense_one'}
	<!-- #BeginLibraryItem "/library/model_adsense.lbi" --><!-- #EndLibraryItem -->
	{else if $value.module eq 'best_goods'}
	<!-- #BeginLibraryItem "/library/model_suggest_goods.lbi" --><!-- #EndLibraryItem -->
	{else if $value.module eq 'new_goods'}
	<!-- #BeginLibraryItem "/library/model_new_goods.lbi" --><!-- #EndLibraryItem -->
	{else if $value.module eq 'promote_goods'}
	<!-- #BeginLibraryItem "/library/model_promotions.lbi" --><!-- #EndLibraryItem -->
	{else if $value.module eq 'groupbuy_goods'}
	<!-- #BeginLibraryItem "/library/model_groupbuy.lbi" --><!-- #EndLibraryItem -->
	{else if $value.module eq 'home_complex_adsense_two'}
	<!-- #BeginLibraryItem "/library/model_adsense_two.lbi" --><!-- #EndLibraryItem -->
	{/if}
<!-- {/foreach} -->
{/if}

<!-- #BeginLibraryItem "/library/model_store.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->

<!-- TemplateBeginEditable name="页面内容二" desc="页面内容二" -->
<!-- #BeginLibraryItem "/library/model_download.lbi" --><!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->
{/nocache}
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步商品列表 start-->
	<!-- {foreach from=$goods_list item=goods} 循环商品 -->
	<li class="single_item">
		<a class="list-page-goods-img" href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.id}">
			<span class="goods-img">
				<img src="{$goods.img.thumb}" alt="{$goods.name}">
			</span>
			<span class="list-page-box">
				<p class="merchants-name"><i class="iconfont icon-shop"></i>{$goods.seller_name}</p>
				<span class="goods-name">{$goods.name}</span>
				<span class="list-page-goods-price">
					<span>{$goods.shop_price}</span>
				</span>
			</span>
		</a>
	</li>
	<!-- {/foreach} -->
	<!-- 异步商品列表end -->
<!-- {/block} -->