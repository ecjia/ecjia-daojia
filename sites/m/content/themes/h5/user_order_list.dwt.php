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
	{foreach from=$lang.merge_order_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
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
        			<input id="keywordBox" name="keywords" type="search" placeholder="商品名称/订单号" {if $keywords}value={$keywords}{/if} data-type="search_order">
        			<i class="iconfont icon-search btn-search"></i>
        		</form>
        	</div>
    	</div>
    </header>
{/if}

<div class="ecjia-order-list ">
    {if $order_list}
	<ul class="ecjia-margin-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='order/async_order_list'}&keywords={$keywords}" data-size="10" data-page="1" data-type="{$type}">
		<!-- 订单异步加载 -->
	</ul>
	{else}
    <div class="ecjia-nolist">
    	{t}暂无相关订单{/t}
    </div>
	{/if}
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$order_list item=list} -->
<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
	<div class="order-hd">
		<a class="ecjiaf-fl" href='{url path="merchant/index/init" args="store_id={$list.seller_id}"}'>
			<i class="iconfont icon-shop"></i>{$list.seller_name} <i class="iconfont icon-jiantou-right"></i>
		</a>
		<a class="ecjiaf-fr" href='{url path="user/order/order_detail" args="order_id={$list.order_id}"}'><span class="ecjia-color-green">{$list.label_order_status}</span></a>
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='{url path="user/order/order_detail" args="order_id={$list.order_id}&type=detail"}'>
			<ul class="{if count($list.goods_list) > 1}goods-list{else}goods-item{/if} goods_attr_ul"><!-- goods-list 多个商品隐藏商品名称,goods-item -->
				<!-- {foreach from=$list.goods_list item=goods name=goods} -->
				<!-- {if $smarty.foreach.goods.iteration gt 3} -->
				<!-- 判断不能大于4个 -->
				<li class="goods-img-more">
					<i class="icon iconfont">&#xe62e;</i>
					<p class="ecjiaf-ib">共{$list.goods_number}件</p>
				</li>
				<!-- {break} -->
				<!-- {/if} -->
				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon {if $list.goods_list|@count gt 1}goods_attr{/if}">
					<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					{if $goods.goods_number gt 1}<span class="ecjia-icon-num top">{$goods.goods_number}</span>{/if}
					{if $list.goods_list|@count eq 1}
					<div class="goods_attr_list">
						<p class="ecjiaf-fl goods-name">{$goods.name}</p>
						{if $goods.goods_attr}
    					<div class="order_list_attr">
    						<!-- {foreach from=$goods.goods_attr item=attr} -->
    					   	{if $attr.name}{$attr.name}:{$attr.value}{/if}
    						<!-- {/foreach} -->
    					</div>
    					{/if}
    				</div>
					{/if}
				</li>
				<!-- {/foreach} -->
			</ul>
		</a>
	</div>
	<div class="order-ft">
		<span><a href='{url path="user/order/order_detail" args="order_id={$list.order_id}&type=detail"}'>订单金额：<span class="ecjia-color-red">{$list.formated_total_fee}</span></a></span>
		<span class="two-btn ecjiaf-fr">
		{if $list.order_status_code eq 'await_pay'} <a class="btn btn-hollow" href='{url path="pay/index/init" args="order_id={$list.order_id}&from=list"}'>去支付</a>
		<!-- if $list.order_status_code eq 'finished' || $list.order_status_code eq 'canceled' -->
		{else} <a class="btn btn-hollow" href='{url path="user/order/buy_again" args="order_id={$list.order_id}&from=list"}'>再次购买</a>
		{/if}
		{if $list.shipping_status eq '1'} <a class="btn btn-hollow" href='{url path="user/order/affirm_received" args="order_id={$list.order_id}&from=list"}'>确认收货</a>{/if}
		{if $list.shipping_status eq '2'} <a class="btn btn-hollow" href='{url path="user/order/comment_list" args="order_id={$list.order_id}&from=list"}'>评价晒单</a>{/if}
		</span>
	</div>
</li>
<!-- {foreachelse} -->
<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}