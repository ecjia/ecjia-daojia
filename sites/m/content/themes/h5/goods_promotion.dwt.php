<?php 
/*
Name: 促销商品模版
Description: 促销商品列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.index.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-promotion-model">
	<ul class="ecjia-promotion-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_goods' args='type=promotion'}">
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步促销商品列表 start-->
	<!-- {if $goods_list} -->
	<!-- {foreach from=$goods_list item=val} -->
		<li class="ecjia-margin-t">
			<a class="list-page-goods-img" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}">
				<span class="goods-img">
                    <img src="{$val.img.thumb}" alt="{$val.name}">
                    <span class="promote-time" data-type="1" value="{$val.promote_end_date}"></span>    
                </span>
				<span class="list-page-box">
					<span class="goods-name">
						{if $val.manage_mode eq 'self'}
						<span class="self-label">自营</span>
						{/if}
						<span class="name-label">{$val.name}</span>
					</span>
					<span class="list-page-goods-price">
						<!--{if $val.promote_price}-->
						<span>{$val.promote_price}</span>
						<!--{else}-->
						<span>{$val.shop_price}</span>
						<!--{/if}-->
						<!--{if $val.shop_price}-->
	          			<del>原价：{$val.shop_price}</del>
	          			<!--{/if}-->
					</span>
				</span>
			</a>
			<img class="sales-icon" src="{$theme_url}images/icon-promote@2x.png">
		</li>
	<!-- {/foreach} -->
	<!-- {else} -->
	<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
		<div class="ecjia-nolist">
			<p><img src="{$theme_url}images/wallet/null280.png"></p>
			暂无商品
		</div>
	</div>
	<!-- {/if} -->
	<!-- 异步商品列表end -->
<!-- {/block} -->
{/nocache}