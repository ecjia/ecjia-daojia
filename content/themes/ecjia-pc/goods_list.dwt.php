<?php defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');?>
<!-- {extends file="ecjia-pc.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.pc.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->

{if $has_store}
<div class="ecjia-goods-list">
	<div class="goods-category ecjia-content">
		{if $keywords}
			<span class="category-item">搜索结果</span>
			<span class="category-item"><i class="iconfont icon-jiantou-right"></i><span class="ecjia-green">"{$keywords}"</span></span>
		{else}
			<span class="category-item">所有分类</span>
			<span class="category-item"><i class="iconfont icon-jiantou-right"></i><a href="{$goods_url}&cat_id={$cat_info.cat_id}"><span class="{if $cat_id eq $cat_info.cat_id}ecjia-green{/if}">{$cat_info.cat_name}</span></a></span>
			{if $cat_info.child_cat}
				<!-- {foreach from=$cat_info.child_cat item=c} -->
				{if $cat_id eq $c.cat_id}
				<span class="category-item"><i class="iconfont icon-jiantou-right"></i><a href="{$goods_url}&cat_id={$c.cat_id}"><span class="{if !$select_id}ecjia-green{/if}">{$c.cat_name}</span></a></span>
				{/if}
				{if $c.children}
					<!-- {foreach from=$c.children item=v key=k} -->
					{if $select_id eq $v.cat_id}
					<span class="category-item"><i class="iconfont icon-jiantou-right"></i><a href="{$goods_url}&cat_id={$v.cat_id}"><span class="ecjia-green">{$v.cat_name}</span></a></span>
					{/if}
					<!-- {/foreach} -->
				{/if}
				<!-- {/foreach} -->
			{/if}
		{/if}
	</div>
	{if !$keywords}
	<div class="goods-category ecjia-content category-list">
		<div class="category-item-list">
			<span class="category-item">分类：</span>
			<span class="category-item {if $cat_id eq $cat_info.cat_id}curr{/if}"><a href="{$goods_url}&cat_id={$cat_info.cat_id}">全部</a></span>
			<!-- {foreach from=$cat_info.child_cat item=val key=key} -->
			<span class="category-item {if $cat_id eq $val.cat_id}curr{/if}">
				<a class="cat-ul" href="{$goods_url}&cat_id={$val.cat_id}">{$val.cat_name}</a>
			</span>
			<!-- {/foreach} -->
		</div>
		<div class="sub-category">
			<!-- {foreach from=$cat_info.child_cat item=val key=key} -->
			{if $val.children}
			<div class="sub-cat" {if $cat_id eq $val.cat_id}style="display:block;"{/if}>
				<a class="cat-li {if $select_id eq 0}active{/if}" href="{$goods_url}&cat_id={$cat_id}">全部</a>
				<!-- {foreach from=$val.children item=v key=k} -->
				<a class="cat-li {if $select_id neq 0}{if $select_id eq $v.cat_id}active{/if}{/if}" href="{$goods_url}&cat_id={$val.cat_id}&select_id={$v.cat_id}">{$v.cat_name}</a>
				<!-- {/foreach} -->
			</div>
			{/if}
			<!-- {/foreach} -->
		</div>
	</div>
	{/if}
	
	<div class="ecjia-content goods-list">
		<div class="goods-list-left">
			<div class="f-line">
				<div class="f-sort">
					<a href="{$goods_url}{if $keywords}&keywords={$keywords}{else}&cat_id={$cat_id}{if $select_id}&select_id={$select_id}{/if}{/if}&type=all" class="{if $type eq 'all' || (!$type && !$sort_by)}curr{/if}">全部商品</a>
               		<a href="{$goods_url}{if $keywords}&keywords={$keywords}{else}&cat_id={$cat_id}{if $select_id}&select_id={$select_id}{/if}{/if}&type=hot" class="{if $type eq 'hot'}curr{/if}">热门推荐</a>
                	<a class="{if !$type && $sort_by eq 'sales_volume'}curr{/if}" href="{$goods_url}{if $keywords}&keywords={$keywords}{else}&cat_id={$cat_id}{if $select_id}&select_id={$select_id}{/if}{/if}&sort_by=sales_volume&sort_order=desc">
           				销量<i class="iconfont icon-jiantou-bottom"></i>
					</a>
                   	<a class="{if !$type && $sort_by eq 'shop_price'}curr{/if}" href="{$goods_url}{if $keywords}&keywords={$keywords}{else}&cat_id={$cat_id}{if $select_id}&select_id={$select_id}{/if}{/if}&sort_by=shop_price&sort_order={if $sort_order eq desc}asc{else}desc{/if}">
                   		价格<i class="iconfont {if $sort_order eq desc}icon-jiantou-bottom{else}icon-jiantou-top{/if}"></i>
					</a>
				</div>
			</div>
			<div class="f-list">
				<!-- {if $goods_list} -->
					<!-- {foreach from=$goods_list item=val key=key} -->
					<div class="goods-item">
						<a href="{$goods_info_url}&goods_id={$val.goods_id}">
							<img src="{if $val.goods_img}{$val.goods_img}{else}{$theme_url}/images/default/default_goods.png{/if}" />
							<div class="goods-name">{$val.goods_name}</div>
							<div class="shop-name">
								<i class="icon-merchant"></i>
								<span class="name">{$val.store_name}</span>								
							</div>
							<div class="item-list">
								<span class="goods-price">{if $val.unformatted_promote_price neq 0}{$val.promote_price}{else}{$val.shop_price}{/if}</span>
								<span class="view-detail">查看详情</span>
							</div>
						</a>
					</div>
					<!-- {/foreach} -->
					<!-- {$page} -->
				<!-- {else} -->
				<p class="no_goods">很抱歉，没有找到相关的商品</p>
				<!-- {/if} -->
			</div>
		</div>
		<div class="goods-list-right">
			<div class="right-title">推荐商家</div>
			<!-- {foreach from=$store_list item=val} -->
			<div class="store-item">
				<a href="{RC_Uri::url('merchant/goods/init')}&store_id={$val.store_id}">
					<img class="store-logo" src="{if $val.store_info.shop_logo}{RC_Upload::upload_url($val.store_info.shop_logo)}{else}{$theme_url}images/default_store.png{/if}" />
					<div class="shop-name">{$val.store_info.merchants_name}</div>
				</a>
				<div class="score-val" data-val="{$val.comment_rank}"></div>
			
				<div class="info">
					<span class="orders-num">成功接单：<span class="ecjia-red">{$val.order_amount}</span></span>
					<span class="praise-num">好评率：<span class="ecjia-red">{$val.comment_percent}%</span></span>
				</div>
			</div>
			<!-- {foreachelse} -->
			<p class="no_store">很抱歉，没有找到相关的商家</p>
			<!-- {/foreach} -->
		</div>
	</div>
</div>
{else}
<div class="m_t80">
<!-- #BeginLibraryItem "/library/no_content.lbi" --><!-- #EndLibraryItem -->
</div>
{/if}

<!-- #BeginLibraryItem "/library/page_footer.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/choose_city.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/nav.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->