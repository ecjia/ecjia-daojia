<?php defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');?>
<!-- {extends file="ecjia-pc.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.pc.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
{if $shop_info}
<!-- #BeginLibraryItem "/library/merchant_header.lbi" --><!-- #EndLibraryItem -->
<div class="ecjia-goods-list ecjia-merchant-goods ecjia-store-goods">
    <div class="ecjia-content merchant-goods-list category-list goods-category">
        <div class="goods-list-left">
            <div class="merchant-goods">
                <ul class="merchant-header">
                    <a href="javascript:;" class="store-header-li curr"><li>商品</li></a>
                    <a class="store-header-li" href="{RC_Uri::url('merchant/index/comment')}&store_id={$store_id}"><li>评价</li></a>
                    <a class="nopjax store-header-li" href="{RC_Uri::url('merchant/index/detail')}&store_id={$store_id}"><li>商家详情</li></a>
                </ul>
                <hr class="store-header-hr">
            </div>
            <div class="category-item-list">
                <span class="category-item">商品分类：</span>
                <span class="category-item {if !$cat_id}curr{/if}"><a href="{$cat_url}">全部</a></span>
	            <!-- {foreach from=$cat_arr item=val key=key} -->
				<span class="category-item {if $cat_id eq $val.cat_id}curr{/if}">
					<a class="cat-ul" href="{$cat_url}&cat_id={$val.cat_id}">{$val.cat_name}</a>
				</span>
				<!-- {/foreach} -->
            </div>
            
            {if $cat_arr}
	       	<div class="sub-category">
				<!-- {foreach from=$cat_arr item=val key=key} -->
				{if $val.children}
				<div class="sub-cat" {if $cat_id eq $val.cat_id}style="display:block;"{/if}>
					<a class="cat-li {if $select_id eq 0}active{/if}" href="{$cat_url}&cat_id={$cat_id}">全部</a>
					<!-- {foreach from=$val.children item=v key=k} -->
					<a class="cat-li {if $select_id neq 0}{if $select_id eq $v.cat_id}active{/if}{/if}" href="{$cat_url}&cat_id={$val.cat_id}&select_id={$v.cat_id}">{$v.cat_name}</a>
					<!-- {/foreach} -->
				</div>
				{/if}
				<!-- {/foreach} -->
			</div>
			{/if}

			<div class="f-list">
				<!-- {if $goods_list} -->
					<!-- {foreach from=$goods_list item=val key=key} -->
					<div class="goods-item">
						<a href="{$goods_info_url}&goods_id={$val.id}">
							<img src="{if $val.goods_img}{$val.goods_img}{else}{$theme_url}/images/default/default_goods.png{/if}" />
							<div class="goods-name">{$val.name}</div>
							<div class="item-list">
								<span class="goods-price">￥{$val.shop_price}</span>
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