<?php 
/*
Name: 店铺详情
Description: 这是店铺详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-store-detail">
	<div class="item1">
		<div class="item1-info">
			<div class="store-info">
				<div class="basic-info">
					<div class="store-left">
						<img src="{if $data.seller_logo}{$data.seller_logo}{else}{$theme_url}images/store_default.png{/if}">
					</div>
					<div class="store-right">
						<div class="store-name">
							{$data.seller_name}
							{if $data.distance}{$data.distance}{/if}
							{if $data.manage_mode eq 'self'}<span>自营</span>{/if}</div>
						<div class="store-range">
							<i class="iconfont icon-remind"></i>{$data.label_trade_time}
						</div>
					</div>
					<div class="clear"></div>
				</div>
				{if $data.favourable_list}
				<ul class="store-promotion">
					<!-- {foreach from=$data.favourable_list item=list} -->
					<li class="promotion">
						<span class="promotion-label">{$list.type_label}</span>
						<span class="promotion-name">{$list.name}</span>
					</li>
					<!-- {/foreach} -->
				</ul>
				{/if}
					
				{if $data.goods_count}
				<ul class="store-goods">
					<li class="goods-info">
						<span class="store-goods-count">{$data.goods_count.count}</span><br>
						<span class="store-goods-desc">全部商品</span>
						<span class="goods-border"></span>
					</li>
					<li class="goods-info">
						<span class="store-goods-count">{$data.goods_count.new_goods}</span><br>
						<span class="store-goods-desc">上新</span>
						<span class="goods-border"></span>
					</li>
					<li class="goods-info">
						<span class="store-goods-count">{$data.goods_count.best_goods}</span><br>
						<span class="store-goods-desc">促销</span>
						<span class="goods-border"></span>
					</li>
					<li class="goods-info">
						<span class="store-goods-count">{$data.goods_count.hot_goods}</span><br>
						<span class="store-goods-desc">店铺动态</span>
					</li>
				</ul>
				<ul class="comments">
					<li>
						<span class="comment-name">商品评分</span>
						<span class="comment-result">{$data.comment.comment_goods}</span>	
					</li>
					<li>
						<span class="comment-name">服务评分</span>
						<span class="comment-result">{$data.comment.comment_goods}</span>	
					</li>
					<li>
						<span class="comment-name">时效评分</span>
						<span class="comment-result">{$data.comment.comment_goods}</span>	
					</li>
				</ul>
				<div class="store-hr"></div>
				<div class="store-tel">
					<span class="tel-name">商家电话</span>
					<p class="tel-result"><a href="tel:{$data.telephone}">{if $data.telephone}{$data.telephone}{else}暂无{/if}</a></p>
				</div>
				<div class="store-hr"></div>
				<ul class="store-other-info">
					<li>
						<span class="other-info-name">公司名称</span>
						<p class="other-info-result">{if $data.shop_name}{$data.shop_name}{else}暂无{/if}</p>
					</li>
					<li>
						<span class="other-info-name">所在地区</span>
						<p class="other-info-result">{if $data.shop_address}{$data.shop_address}{else}暂无{/if}</p>
					</li>
					<li>
						<span class="other-info-name">店铺公告</span>
						<p class="other-info-result">{if $data.seller_notice}{$data.seller_notice}{else}暂无{/if}</p>
					</li>
				</ul>
				{/if}
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->