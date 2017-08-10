<?php
/*
Name: 订单详情模板
Description: 这是订单详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-detail">
	<ul class="ecjia-list ecjia-list-two ecjia-nav ecjia-margin-t-n">
		<li class="{if $smarty.get.type neq 'detail'} active{/if}"><a class="nopjax" href="#one" role="tab" data-toggle="tab">订单状态</a></li>
		<li class="{if $smarty.get.type eq 'detail'} active{/if}"><a class="nopjax" href="#two" role="tab" data-toggle="tab">订单详情</a></li>
	</ul>
	<div class="goods-describe order-log-list {if $smarty.get.type neq 'detail'} active{/if}" id="one">
		<!-- {foreach from=$order.order_status_log item=info} -->
		<div class='order-log-item {$info.status} {if count($order.order_status_log) lt 2} item-only{/if}'>
			<div class="order-log">
				<span>{$info.order_status}</span><span class="ecjiaf-fr order-time">{$info.time}</span>
				<p>{$info.message}</p>{if $info.status eq 'express_user_pickup' && $order.express_mobile}<a class="tel" href="tel://{$order.express_mobile}"></a>{/if}
			</div>
		</div>
		<!-- {/foreach} -->
	</div>
	<div class="ecjia-checkout goods-describe ecjia-margin-b {if $smarty.get.type eq 'detail'} active{/if} " id="two">
		<div class="flow-goods-list">
			<div class="order-hd">
				<a class="ecjiaf-fl" href='{url path="merchant/index/init" args="store_id={$order.store_id}"}'>
					<i class="iconfont icon-shop"></i>{$order.seller_name}
				</a>
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
						<p class="ecjia-goods-attr goods-attr">
						<!-- {foreach from=$goods.goods_attr item=attr} -->
						{if $attr.name}{$attr.name}:{$attr.value}{/if}
						<!-- {/foreach} -->
						</p>
						<p class="ecjia-color-red goods-attr-price">{$goods.formated_shop_price}</p>
					</div>
					<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
					</a>
				</li>
				<!-- {/foreach} -->
			</ul>
			<ul class="ecjia-list">
				<li>商品金额：<span class="ecjiaf-fr ">{$order.formated_goods_amount}</span></li>
				<li>税费金额：<span class="ecjiaf-fr ">{$order.formated_tax}</span></li>
				<li>积分抵扣：<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_integral_money}</span></li>
				<li>红包抵扣：<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_bonus}</span></li>
				<li>优惠：<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_discount}</span></li>
				<li>运费：<span class="ecjiaf-fr ">{$order.formated_shipping_fee}</span></li>
				<li>共计：<span class="ecjiaf-fr ">{$order.formated_total_fee}</span></li>
			</ul>
			<p class="select-title ecjiaf-fwb ecjia-margin-l">配送信息</p>
			<ul class="ecjia-list">
			    <!-- <li><span class="ecjiaf-fl width-25-p">发货时间：</span><span class="ecjiaf-fr width-75-p">{if $order.shipping_time}{$order.shipping_time}{else}暂未发货{/if}</span></li> -->
				{if $order.expect_shipping_time neq ' ' && $order.expect_shipping_time neq '' && $order.expect_shipping_time neq 'undefined'}<li><span class="ecjiaf-fl width-25-p">送达时间：</span><span class="ecjiaf-fr width-75-p">{$order.expect_shipping_time}</span></li>{/if}
				<li style="height: auto;"><span class="ecjiaf-fl width-25-p">收货地址：</span>
				<span class="ecjiaf-fr width-75-p">{$order.consignee} {$order.mobile}</span>
				<span class="ecjiaf-fr width-75-p">{$order.province} {$order.city} {$order.district}{$order.address}</span></li>
				<li><span class="ecjiaf-fl width-25-p">配送方式：</span><span class="ecjiaf-fr width-75-p">{$order.shipping_name}</span></li>
				{if $order.express_user}<li><span class="ecjiaf-fl width-25-p">配送员：</span><span class="ecjiaf-fr width-75-p">{$order.express_user} {$order.express_mobile}</span></li>{/if}
			</ul>
			<p class="select-title ecjiaf-fwb ecjia-margin-l">订单信息</p>
			<ul class="ecjia-list">
				<li><span class="ecjiaf-fl width-25-p">发票抬头：</span><span class="ecjiaf-fr width-75-p">{if $order.inv_title_type}{$order.inv_payee}{else}无{/if}</span></li>
				<li><span class="ecjiaf-fl width-25-p">发票识别码：</span><span class="ecjiaf-fr width-75-p">{if $order.inv_tax_no}{$order.inv_tax_no}{else}无{/if}</span></li>
				<li><span class="ecjiaf-fl width-25-p">订单编号：</span><span class="ecjiaf-fr width-75-p">{$order.order_sn}</span></li>
				<li><span class="ecjiaf-fl width-25-p">下单时间：</span><span class="ecjiaf-fr width-75-p">{$order.formated_add_time}</span></li>
				<li class="remark"><span class="ecjiaf-fl width-25-p">订单备注：</span><span class="ecjiaf-fr width-75-p">{if $order.postscript}{$order.postscript}{else}无{/if}</span></li>
				<li><span class="ecjiaf-fl width-25-p">支付方式：</span><span class="ecjiaf-fr width-75-p">{$order.pay_name}</span></li>
			</ul>
			<div class="order-ft-link">
				<a class="btn btn-small btn-hollow external" href="{if $order.service_phone}tel://{$order.service_phone}{else}javascript:alert('无法联系卖家');{/if}">联系卖家</a>
				{if $order.pay_status eq 0 && $order.order_status lt 2}<a class="btn btn-small btn-hollow" href='{url path="user/order/order_cancel" args="order_id={$order.order_id}"}'>取消订单</a> <a class="btn btn-small btn-hollow" href='{url path="pay/index/init" args="order_id={$order.order_id}"}'>去支付</a>{/if}
				{if $order.shipping_status eq '1'} <a class="btn btn-small btn-hollow" href='{url path="user/order/affirm_received" args="order_id={$order.order_id}"}'>确认收货</a>{/if}
				{if $order.order_status gt 1 || ($order.shipping_status eq 0 && $order.pay_status neq 0)} <a class="btn btn-small btn-hollow" href='{url path="user/order/buy_again" args="order_id={$order.order_id}"}'>再次购买</a>{/if}
				{if $order.shipping_status eq '2'} <a class="btn btn-small btn-hollow" href='{url path="user/order/comment_list" args="order_id={$order.order_id}"}'>评价晒单</a>{/if}
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->