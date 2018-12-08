<?php
/*
Name: 团购模块
Description: 这是首页的团购模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{if $value.data}
<div class="ecjia-mod ecjia-promotion-model ecjia-margin-t {if $count eq $key && !$data}ecjia-mod-pb35{/if}">
	<div class="head-title">
		<h2><i class="icon-groupbuy"></i>限时团购<a href="{RC_Uri::url('goods/index/groupbuy')}" class="more_info">更多</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<!-- {foreach from=$value.data item=val} 循环商品 -->
			<div class="swiper-slide">
				<a class="list-page-goods-img nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}&act_id={$val.goods_activity_id}">
					<span class="goods-img">
                        <img src="{$val.img.small}" alt="{$val.name}">
                    </span>
					<span class="list-page-box">
						<span class="goods-name">{$val.name}</span>
						<span class="list-page-goods-price">
							<!--{if $val.promote_price neq 0}-->
							<span>{$val.formated_promote_price}</span>
							<!--{else}-->
							<span>{$val.formated_market_price}</span>
							<!--{/if}-->
							<!--{if $val.shop_price}-->
                    		<span><del>{$val.formated_shop_price}</del></span>
                    		<!--{/if}-->
						</span>
					</span>
				</a>
				<img class="sales-icon" src="{$theme_url}images/icon-groupbuy.png">
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
</div>
{/if}