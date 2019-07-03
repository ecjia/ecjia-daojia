<?php
/*
Name: 获取全部订单模板
Description: 获取全部订单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.enter_search();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
{if $type == 'whole'}
    <header class="ecjia-order-search">
        <div class="ecjia-header">
        	<div class="ecjia-search-header ecjia-search">
        		<form class="ecjia-form" action="{url path='user/order/order_list&type=whole'}{if $store_id neq 0}&store_id={$store_id}{/if}">
        			<input name="keywords" type="search" placeholder='{t domain="h5"}商品名称/订单号{/t}' {if $keywords}value={$keywords}{/if} data-type="search_order">
        			<i class="iconfont icon-search btn-search"></i>
        		</form>
        	</div>
    	</div>
    </header>
{/if}

<div class="ecjia-order-list ">
    {if $order_list}
	<ul class="ecjia-margin-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='#order/async_order_list'}&keywords={$keywords}" data-size="10" data-page="1" data-type="{$type}">
		<!-- 订单异步加载 -->
	</ul>
	{else}
    <div class="ecjia-nolist">
    	{t domain="h5"}暂无相关订单{/t}
    </div>
	{/if}
</div>
<!-- {/block} -->
{/nocache}