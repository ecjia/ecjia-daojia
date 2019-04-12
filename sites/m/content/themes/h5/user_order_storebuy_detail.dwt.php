<?php
/*
Name: 扫码购订单详情模板
Description: 这是扫码购订单详情页
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
				<a class="ecjiaf-fl nopjax external" href='{url path="merchant/index/init" args="store_id={$order.store_id}"}'>
					<i class="iconfont icon-shop"></i>{$order.seller_name}
				</a>
				<div class="ecjiaf-fr"><span class="ecjiaf-order-status">{t domain="h5"}扫码购{/t}</span></div>
			</div>
			<ul class="goods-item">
				<!-- {foreach from=$order.goods_list item=goods} -->
				<li>
				    <a class="nopjax external" href='{url path="goods/index/show" args="goods_id={$goods.goods_id}"}'>
					<div class="ecjiaf-fl goods-img">
						<img src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">{$goods.name}</p>
						<p class="ecjia-goods-attr goods-attr">{t domain="h5"}货号：{/t}{$goods.goods_sn}</p>
						<p class="ecjia-color-red goods-attr-price">{$goods.formated_shop_price}</p>
					</div>
					<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
					</a>
				</li>
				<!-- {/foreach} -->
			</ul>
			<ul class="ecjia-list">
				<li>{t domain="h5"}商品金额：{/t}<span class="ecjiaf-fr ">{$order.formated_goods_amount}</span></li>
				<li>{$integral_name}{t domain="h5"}抵扣：{/t}<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_integral_money}</span></li>
				<li>{t domain="h5"}红包抵扣：{/t}<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_bonus}</span></li>
				<li>{t domain="h5"}优惠金额：{/t}<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_discount}</span></li>
				<li>{t domain="h5"}应付金额：{/t}<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_total_fee}</span></li>
			</ul>

			<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}订单信息{/t}</p>
			<ul class="ecjia-list">
			    <li><span class="ecjiaf-fl width-25-p">{t domain="h5"}订单编号：{/t}</span><span class="width-75-p">{$order.order_sn}</span><button class="copy-btn" data-clipboard-text="{$order.order_sn}">{t domain="h5"}复制{/t}</button></li>
			    <li><span class="ecjiaf-fl width-25-p">{t domain="h5"}下单时间：{/t}</span><span class="ecjiaf-fr width-75-p">{$order.formated_add_time}</span></li>
				<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}支付方式：{/t}</span><span class="ecjiaf-fr width-75-p">{$order.pay_name}</span></li>
			</ul>
			<div class="order-ft-link">
				<a class="btn btn-small btn-hollow external" href="{if $order.service_phone}tel://{$order.service_phone}{else}javascript:alert('{t domain='h5'}无法联系卖家{/t}');{/if}">{t domain="h5"}联系卖家{/t}</a>
				{if $order.pay_status eq 0 && $order.order_status lt 2}<a class="btn btn-small btn-hollow cancel_order" href='{url path="user/order/order_cancel" args="order_id={$order.order_id}"}'>{t domain="h5"}取消订单{/t}</a> <a class="btn btn-small btn-hollow" href='{url path="payment/pay/init" args="order_id={$order.order_id}"}'>{t domain="h5"}去支付{/t}</a>{/if}
				{if $order.shipping_status eq '1'} <a class="btn btn-small btn-hollow" href='{url path="user/order/affirm_received" args="order_id={$order.order_id}"}'>{t domain="h5"}确认收货{/t}</a>{/if}
				{if $order.shipping_status eq '2'} <a class="btn btn-small btn-hollow" href='{url path="user/order/comment_list" args="order_id={$order.order_id}"}'>{t domain="h5"}评价晒单{/t}</a>{/if}
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->