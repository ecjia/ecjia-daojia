<?php
/*
Name: 到店购物订单详情模板
Description: 这是到店购物订单详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.cancel_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-detail">
	<div class="ecjia-checkout ecjia-margin-b">
		<div class="flow-goods-list">
			<div class="order-hd">
				<a class="ecjiaf-fl" href='{url path="merchant/index/init" args="store_id={$order.store_id}"}'>
					<i class="iconfont icon-shop"></i>{$order.seller_name}
				</a>
				<div class="ecjiaf-fr"><span class="ecjiaf-order-status">到店购物</span></div>
			</div>
			<ul class="goods-item">
				<!-- {foreach from=$order.goods_list item=goods} -->
				<li>
				    <a href='{url path="goods/index/show" args="goods_id={$goods.goods_id}"}'>
					<div class="ecjiaf-fl goods-img">
						<img src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">{$goods.name}</p>
						<p class="ecjia-goods-attr goods-attr">货号：{$goods.goods_sn}</p>
						<p class="ecjia-color-red goods-attr-price">{$goods.formated_shop_price}</p>
					</div>
					<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
					</a>
				</li>
				<!-- {/foreach} -->
			</ul>
			<ul class="ecjia-list">
				<li>商品金额：<span class="ecjiaf-fr ">{$order.formated_goods_amount}</span></li>
				<li>积分抵扣：<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_integral_money}</span></li>
				<li>红包抵扣：<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_bonus}</span></li>
				<li>优惠金额：<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_discount}</span></li>
				<li>应付金额：<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_discount}</span></li>
			</ul>

			<p class="select-title ecjiaf-fwb ecjia-margin-l">订单信息</p>
			<ul class="ecjia-list">
			    <li><span class="ecjiaf-fl width-25-p">订单编号：</span><span class="width-75-p">{$order.order_sn}</span><button class="copy-btn" data-clipboard-text="{$order.order_sn}">复制</button></li>
			    <li><span class="ecjiaf-fl width-25-p">下单时间：</span><span class="ecjiaf-fr width-75-p">{$order.formated_add_time}</span></li>
				<li><span class="ecjiaf-fl width-25-p">支付方式：</span><span class="ecjiaf-fr width-75-p">{$order.pay_name}</span></li>
			</ul>
			<div class="order-ft-link">
				<a class="btn btn-small btn-hollow external" href="{if $order.service_phone}tel://{$order.service_phone}{else}javascript:alert('无法联系卖家');{/if}">联系卖家</a>
				{if $order.pay_status eq 0 && $order.order_status lt 2}<a class="btn btn-small btn-hollow cancel_order" href='{url path="user/order/order_cancel" args="order_id={$order.order_id}"}'>取消订单</a> <a class="btn btn-small btn-hollow" href='{url path="pay/index/init" args="order_id={$order.order_id}"}'>去支付</a>{/if}
				{if $order.shipping_status eq '1'} <a class="btn btn-small btn-hollow" href='{url path="user/order/affirm_received" args="order_id={$order.order_id}"}'>确认收货</a>{/if}
				{if $order.shipping_status eq '2'} <a class="btn btn-small btn-hollow" href='{url path="user/order/comment_list" args="order_id={$order.order_id}"}'>评价晒单</a>{/if}
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->