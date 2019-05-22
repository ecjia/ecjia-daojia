<?php
/*
Name: 新品首发
Description: 这是首页的新品首发模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{if $value.data}
<div class="ecjia-mod ecjia-new-model ecjia-margin-t {if $count eq $key && !$data}ecjia-mod-pb35{/if}">
	<div class="head-title ecjia-new-goods">
		<h2><i class="icon-best"></i>{t domain="h5"}店长推荐{/t}<a href="{$more_best}" class="more_info">{t domain="h5"}更多{/t}</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<!-- {foreach from=$value.data item=val} 循环商品 -->
			<div class="swiper-slide">
				<a class="list-page-goods-img nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}&product_id={$val.product_id}">
					<span class="goods-img"><img src="{$val.img.small}" alt="{$val.name}"></span>
					<span class="list-page-box">
						<span class="goods-name">
							{if $val.manage_mode eq 'self'}
							<span class="self-label">{t domain="h5"}自营{/t}</span>
							{/if}
							<span class="name-label">{$val.name}</span>
						</span>
						<span class="list-page-goods-price">
							<span>{$val.shop_price}</span>
						</span>
					</span>
				</a>
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
</div>
{/if}