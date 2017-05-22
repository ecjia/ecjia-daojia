<?php 
/*
Name: 历史记录模板
Description: 这是历史记录页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<!-- {if $history} -->
<div>
	<ul class="ecjia-list ecjia-history-list list-page list-page-one" data-page="{$page}" data-url="{url path='category/asynclist' args="cid={$id}&brand={$brand_id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&page={$page}&sort={$sort}&order={$order}&keywords={$keywords}"}">
		<!--{foreach from=$history item=goods}-->
		<li class="single_item">
			<a class="list-page-goods-img" href="{$goods.url}">
				<span class="goods-img ecjiaf-fl">
					<img src="{$goods.goods_thumb}" alt="{$goods.goods_name}">
				</span>
				<span class="list-page-box ecjiaf-fr">
					<span class="goods-name">{$goods.goods_name}</span>
					<span class="list-page-goods-price">
						<!--{if $goods.promote_price}-->
						<span>{$goods.promote_price}</span>
						<!--{else}-->
						<span>{$goods.shop_price}</span>
						<!--{/if}-->
						<del>{$goods.market_price}</del>
					</span>
				</span>
			</a>
		</li>
		<!-- {/foreach} -->
	</ul>
	<div class="ecjia-margin-t ecjia-margin-b">
		<a class="btn btn-info btn-loginout clear_history nopjax external" href="{url path='user/index/clear_history'}">{t}清空浏览历史{/t}</a>
	</div>
</div>
<!-- {else} -->
<div class="ecjia-nolist">
    <i class="iconfont icon-footprint"></i>
	<p>{t}暂无浏览历史记录{/t}</p>
</div>
<!-- {/if} -->
<!-- {/block} -->