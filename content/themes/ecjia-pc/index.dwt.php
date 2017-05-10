<?php defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');?>
<!-- {extends file="ecjia-pc.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	sessionStorage.removeItem('index_swiper');
	ecjia.pc.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->

<div class="ecjia-category-nav">
	<div class="category-info ecjia-category">
		<div class="ecjia-category-info">
			<!-- {foreach from=$cat item=val key=key} -->
			<div class="ecjia-category-info-l1">
				<a class="ecjia-category-l2" href="{$goods_url}&cat_id={$val.id}">
					<span class="category-icon"><img src="{if $val.img}{$val.img}{else}{$theme_url}images/category/category_all_on.png{/if}"></span>{$val.name}
					<i class="iconfont icon-jiantou-right"></i>
				</a>
				<div class="ecjia-category-info-l2">
					<div class="cate_detail">
						<!-- {foreach from=$val.cat_id item=v key=k} -->
						<dl class="cate_detail_item cate_detail_item_{$k}">
							<dt class="cate_detail_tit">
								<a class="cate_detail_tit_lk" href="{$goods_url}&cat_id={$v.id}">{$v.name}
								<i class="iconfont icon-jiantou-right"></i>
								</a>
							</dt>
							<dd class="cate_detail_con">
							<!-- {if $v.cat_id} -->
								<!-- {foreach from=$v.cat_id item=c} -->
								<a class="cate_detail_con_lk" href="{$goods_url}&cat_id={$c.id}">
									<img src="{$c.img}">
									<span class="cat_name">{$c.name}</span>
								</a>
								<!-- {/foreach} -->
							<!-- {else} -->
								<a class="cate_detail_con_lk" href="{$goods_url}&cat_id={$v.id}">
									<img src="{$v.img}">
									<span class="cat_name">{$v.name}</span>
								</a>
							<!-- {/if} -->
							</dd>
						</dl>
						<!-- {/foreach} -->
					</div>
				</div>
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
	<div class="category-bg"></div>
</div>

<div class="ecjia-cycleimage">
	<div id="swiper-web" class="swiper-container">
		<div class="swiper-wrapper">
			<!-- {foreach from=$cycleimage item=val} -->
			<div class="swiper-slide" style="background:url('{$val.image}') center center no-repeat;">
				<a href="{$val.url}"></a>
			</div>
			<!-- {/foreach} -->
		</div>
		{if $count gt 1}
		<div class="swiper-pagination swiper-index-pagination"></div>
		{/if}
	</div>
</div>

{if $has_goods}
<div class="ecjia-category-container ecjia-background-fff">
	<!-- {foreach from=$cat_list item=val key=key} -->
	{if $val.children}
	<div class="ecjia-category-item" id="item-{$key}">
		<div class="ecjia-category-content">
			<div class="cat-item cat-ul">{$val.name}</div>
			<div class="category-list">
				<!-- {foreach from=$val.children item=v key=k} -->
				{if $v.goods_list}
				<li class="cat-item" data-id="{$v.id}"><span>{$v.name}</span></li>
				{/if}
				<!-- {/foreach} -->
			</div>
			
			<!-- {foreach from=$val.children item=children key=key} -->
				{if $key eq 0}
				<div class="more-category"><a href="{$goods_url}&cat_id={$children.id}" data-url="{$goods_url}">更多<i class="iconfont icon-jiantou-right"></i></a></div>
				{/if}
				<!-- {if $children.goods_list} -->
				<div class="category-goods ecjiaf-dn category-goods-{$children.id}">
					<!-- {foreach from=$children.goods_list item=c} -->
					<div class="goods-item">
						<a href="{$goods_info_url}&goods_id={$c.goods_id}">
							<img src="{if $c.goods_img}{$c.goods_img}{else}{$theme_url}images/default/default_goods.png{/if}"/>
							<div class="goods-name">{$c.goods_name}</div>
							<div class="item-list">
								<span class="goods-price">{if $c.unformatted_promote_price neq 0}{$c.promote_price}{else}{$c.shop_price}{/if}</span>
								<span class="view-detail">查看详情</span>
							</div>
						</a>
					</div>
					<!-- {/foreach} -->
				</div>
				<!-- {/if} -->
			<!-- {/foreach} -->
		</div>
	</div>
	{/if}
	<!-- {/foreach} -->
</div>
{else}
<!-- #BeginLibraryItem "/library/no_content.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="J_f J_lift lift" id="lift">
	<ul class="lift_list">
		<!-- {foreach from=$cat_list item=val key=key} -->
		{if $val.children}
		<li class="J_lift_item lift_item lift_item_first" data-id="item-{$key}">
			<a href="javascript:;" class="lift_btn"> 
				<span class="category-icon" data-item="#item-{$key}">
					<img src="{if $val.image}{$val.image}{else}{$theme_url}images/category/category_all_on.png{/if}">
					<span>{$val.name}</span>
				</span>
			</a>
		</li>
		{/if}
		<!-- {/foreach} -->
	</ul> 
</div>

<!-- #BeginLibraryItem "/library/page_footer.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/choose_city.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/nav.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->