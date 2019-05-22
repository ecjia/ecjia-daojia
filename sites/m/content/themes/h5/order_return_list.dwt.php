<?php
/*
Name: 申请售后列表模板
Description: 这是申请售后列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user ecjia-margin-b">
	{if !$refund_sn}
	 <div class="ecjia-return-title">{t domain="h5"}售后类型选择{/t}</div>
     <ul class="ecjia-list ecjia-return-list">
        <li>
			<a class="data-pjax" href="{url path='user/order/return_order'}&type=refund&order_id={$order_id}">
				<div class="ecjia-return-item">
        			<img class="return-item-icon" src="{$theme_url}images/icon/icon-refund.png">
        			<div class="return-item-right">
        				<span class="title">{t domain="h5"}仅退款{/t}</span>
        				<p class="notice">{t domain="h5"}全部商品/部分商品未收到，或商家协商同意{/t}</p>
        			</div>
        			<i class="iconfont icon-jiantou-right"></i>
        		</div>
        	</a>
		</li>
		
		<li>
			<a class="data-pjax" href="{url path='user/order/return_order'}&type=return&order_id={$order_id}">
				<div class="ecjia-return-item">
        			<img class="return-item-icon" src="{$theme_url}images/icon/icon-return.png">
        			<div class="return-item-right">
        				<span class="title">{t domain="h5"}退货退款{/t}</span>
        				<p class="notice">{t domain="h5"}如您已收到商品或收到送错的商品{/t}</p>
        			</div>
        			<i class="iconfont icon-jiantou-right"></i>
        		</div>
        	</a>
		</li>
    </ul>
    {/if}
    
    {if $order_list}
    <div class="ecjia-return-title">{t domain="h5"}售后进度查询{/t}</div>
    <div class="ecjia-return-list">
		<div class="a7 ah">
			<ul class="a8 ao" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/order/async_return_order_list'}&order_id={$order_id}" data-size="10" data-page="1">
				<!-- 订单异步加载 -->
			</ul>
		</div>
	</div>
	{/if}
</div>
<!-- {/block} -->

{/nocache}