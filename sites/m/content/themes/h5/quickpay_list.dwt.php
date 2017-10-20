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

<div class="ecjia-order-list ">
	{if $order_list}
	<ul class="ecjia-margin-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/quickpay/async_quickpay_list'}" data-size="10" data-page="1">
		<!-- 订单异步加载 -->
	</ul>
	{else}
    <div class="ecjia-nolist">
    	{t}暂无买单记录{/t}
    </div>
	{/if}
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$data item=list} -->
<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
	<div class="order-hd">
		<a class="ecjiaf-fl" href='{url path="merchant/index/init" args="store_id={$list.store_id}"}'>
			<i class="iconfont icon-shop"></i>{$list.store_name} <i class="iconfont icon-jiantou-right"></i>
		</a>
		<a class="ecjiaf-fr" href='{url path="user/quickpay/quickpay_detail" args="order_id={$list.order_id}"}&store_id={$list.store_id}'><span class="{if $list.order_status_str eq 'paid'}ecjia-color-green{else}ecjia-color-red{/if}">{$list.label_order_status}</span></a>
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='{url path="user/quickpay/quickpay_detail" args="order_id={$list.order_id}&store_id={$list.store_id}"}'>
			<ul class="quickpay-info-list">
				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon quickpay-w">
					<img class="ecjiaf-fl" src="{$list.store_logo}" alt="{$list.store_name}" title="{$list.store_name}" />
				    <ul>
				        <li class="quickpay-info-li">
				            <span class="quickpay-info">订单编号</span>2234253453342
				        </li>
				        <li class="quickpay-info-li">
				            <span class="quickpay-info">优惠金额</span>{$list.formated_total_discount}
				        </li>
				        <li class="quickpay-info-li">
				            <span class="quickpay-info">实付金额</span>{$list.formated_order_amount}
				        </li>
				        <li class="quickpay-info-li">
				            <span class="quickpay-info">买单时间</span>{$list.formated_add_time}
				        </li>
				    </ul>
				</li>
			</ul>
		</a>
	</div>
</li>
<!-- {/foreach} -->		
<!-- {/block} -->
{/nocache}