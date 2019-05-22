<?php 
/*
Name: 分类商品页
Description: 这是分类商品页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/index_header.lbi" --><!-- #EndLibraryItem -->
<div class="ecjia-category-goods-tab">
    <ul>
        <li>
            <span class="{if !$sort_by}active{/if}">
                <a class="fnUrlReplace" href="{RC_Uri::url('goods/category/store_list')}{if $keywords}&keywords={$keywords}{/if}{if $cid}&cid={$cid}{/if}">{t domain="h5"}综合{/t}</a>
            </span>
        </li>
        <li>
            <span class="{if $sort_by eq 'is_hot'}active{/if}">
                <a class="fnUrlReplace" href="{RC_Uri::url('goods/category/store_list')}&sort_by=is_hot{if $keywords}&keywords={$keywords}{/if}{if $cid}&cid={$cid}{/if}">{t domain="h5"}热销{/t}</a>
            </span>
        </li>
        <li>
            <span class="{if $sort_by eq 'price'}active{/if}">
                <a class="fnUrlReplace" href="{RC_Uri::url('goods/category/store_list')}&sort_by=price&sort_order={if $sort_order eq 'asc'}desc{else}asc{/if}{if $keywords}&keywords={$keywords}{/if}{if $cid}&cid={$cid}{/if}">{t domain="h5"}价格{/t}
                    {if $sort_order eq ''}
                    <img src="{$theme_url}images/sort/price_sort.png" width="10" height="10">
                    {else if $sort_order eq 'asc'}
                    <img src="{$theme_url}images/sort/price_sort_asc.png" width="10" height="10">
                    {else if $sort_order eq 'desc'}
                    <img src="{$theme_url}images/sort/price_sort_desc.png" width="10" height="10">
                    {/if}
                </a>
            </span>
        </li>
    </ul>
</div>

<div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;">
    <div class="bd">
        <ul class="ecjia-margin-b ecjia-list ecjia-list-two list-page-two ecjia-category-goods-ul" id="J_ItemList" data-toggle="asynclist"
            data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='goods/category/ajax_store_goods'}{if $sort_by}&sort_by={$sort_by}{/if}{if $sort_by eq 'price'}&sort_order={if $sort_order eq 'asc'}desc{else}asc{/if}{/if}{if $keywords}&keywords={$keywords}{/if}{if $cid}&cid={$cid}{/if}">
        </ul>
    </div>
</div>
<!-- {/block} -->

{/nocache}