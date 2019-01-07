<?php
/*
Name: 售后详情模板
Description: 这是售后详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.return_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-order-detail">
	<div class="ecjia-checkout ecjia-margin-b">
		<div class="flow-goods-list">
			<div class="order-status-head margin-bottom-none">
			    <a href="{url path='user/order/return_detail'}&refund_sn={$order.refund_sn}&type={'status'}">
			        <span class="order-status-img"><p></p><img src="{$theme_url}images/address_list/50x50_2.png"></span>
			        <div class="order-status-msg">
	    		        <span class="order-head-top"><span class="order-head-font">{$refund_logs.label_status}</span><span class="ecjiaf-fr order-color">{$refund_logs.formatted_action_time}</span></span>
	    		        <p class="ecjia-margin-t status"><span class="order-color order-status">{$refund_logs.log_description}</span><span class="ecjiaf-fr more-status">更多状态 ></span></p>
			        </div>
		        </a>
	        </div>
	        
			<p class="select-title ecjiaf-fwb ecjia-margin-l">售后商品</p>
		    <ul class="goods-item">
				<!-- {foreach from=$order.goods_list item=goods} -->
				<li>
				    <a class="nopjax external" href='{url path="goods/index/show" args="goods_id={$goods.goods_id}"}'>
					<div class="ecjiaf-fl goods-img">
						<img src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">{$goods.name}</p>
						<p class="ecjia-goods-attr goods-attr">{$goods.goods_attr}</p>
						<p class="ecjia-color-red goods-attr-price">{$goods.formated_goods_price}</p>
					</div>
					<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
					</a>
				</li>
				<!-- {/foreach} -->
			</ul>
			
			<div class="return-item">
				<div class="c9">
					<p><i class="c6">{$order.refund_goods_amount}</i><b>退商品金额</b></p>
					
					{if $order.refund_shipping_fee neq '0'}
					<p><i class="c6">{$order.refund_shipping_fee}</i><b>退配送费</b></p>
					{/if}
					
					{if $order.refund_integral neq '0'}
					<p><i class="c6">{$order.refund_integral}</i><b>退{$integral_name}</b></p>
					{/if}
					
					{if $order.refund_inv_tax neq '0'}
					<p><i class="c6">{$order.refund_inv_tax}</i><b>退发票</b></p>
					{/if}
					
					<p><i class="c6 ecjia-red">{$order.refund_total_amount}</i><b>退总金额</b></p>
					<p class="ca"><span>温馨提示:</span><b>退商品金额是按照您实际支付的商品金额进行退回，如有问题，请联系客服。</b></p>
				</div>
			</div>
			
			<p class="select-title ecjiaf-fwb ecjia-margin-l">问题描述</p>
			<div class="co">
				<p class="cp"><span>售后原因：</span><b>{$order.reason}</b></p>
				<p class="cp"><span>问题描述：</span><b>{if $order.refund_desc}{$order.refund_desc}{else}暂无{/if}</b></p>
				{if $order.return_images}
				<p class="cq">
					<span>售后图片：</span>
					<b>
						<!-- {foreach from=$order.return_images item=img} -->
						<img src="{$img}">
						<!-- {/foreach} -->
					</b>
				</p>
				{/if}
			</div>
			
			{if $order.selected_returnway_info}
			<p class="select-title ecjiaf-fwb ecjia-margin-l">取货信息</p>
				{if $order.selected_returnway_info.return_way_code eq 'home'}
				<div class="co">
					{if $order.selected_returnway_info.return_way_name}
					<p class="cp"><span>退货方式：</span><b>{$order.selected_returnway_info.return_way_name}</b></p>
					{/if}
					{if $order.selected_returnway_info.expect_pickup_time}
					<p class="cp"><span>取货时间：</span><b>{$order.selected_returnway_info.expect_pickup_time}</b></p>
					{/if}
					{if $order.selected_returnway_info.pickup_address}
					<p class="cp"><span>取货地址：</span><b>{$order.selected_returnway_info.pickup_address}</b></p>
					{/if}
					{if $order.selected_returnway_info.contact_name}
					<p class="cp"><span>联系人：</span><b>{$order.selected_returnway_info.contact_name}</b></p>
					{/if}
					{if $order.selected_returnway_info.contact_phone}
					<p class="cp"><span>联系电话：</span><b>{$order.selected_returnway_info.contact_phone}</b></p>
					{/if}
				</div>
				{/if}
				
				{if $order.selected_returnway_info.return_way_code eq 'express'}
				<div class="co">
					{if $order.selected_returnway_info.return_way_name}
					<p class="cp"><span>退货方式：</span><b>{$order.selected_returnway_info.return_way_name}</b></p>
					{/if}
					{if $order.selected_returnway_info.recipients}
					<p class="cp"><span>收件人：</span><b>{$order.selected_returnway_info.recipients}</b></p>
					{/if}
					{if $order.selected_returnway_info.contact_phone}
					<p class="cp"><span>联系方式：</span><b>{$order.selected_returnway_info.contact_phone}</b></p>
					{/if}
					{if $order.selected_returnway_info.recipient_address}
					<p class="cp"><span>收件地址：</span><b>{$order.selected_returnway_info.recipient_address}</b></p>
					{/if}
					{if $order.selected_returnway_info.shipping_name}
					<p class="cp"><span>快递名称：</span><b>{$order.selected_returnway_info.shipping_name}</b></p>
					{/if}
					{if $order.selected_returnway_info.shipping_sn}
					<p class="cp"><span>快递单号：</span><b>{$order.selected_returnway_info.shipping_sn}</b></p>
					{/if}
				</div>
				{/if}
				
				{if $order.selected_returnway_info.return_way_code eq 'shop'}
				<div class="co">
					{if $order.selected_returnway_info.return_way_name}
					<p class="cp"><span>退货方式：</span><b>{$order.selected_returnway_info.return_way_name}</b></p>
					{/if}
					{if $order.selected_returnway_info.store_name}
					<p class="cp"><span>店铺名称：</span><b>{$order.selected_returnway_info.store_name}</b></p>
					{/if}
					{if $order.selected_returnway_info.contact_phone}
					<p class="cp"><span>联系方式：</span><b>{$order.selected_returnway_info.contact_phone}</b></p>
					{/if}
					{if $order.selected_returnway_info.store_address}
					<p class="cp"><span>店铺地址：</span><b>{$order.selected_returnway_info.store_address}</b></p>
					{/if}
				</div>
				{/if}
			{/if}

			<div class="order-ft-link">
				{if $order.status eq 'canceled'}
				<span class="canceled">本次申请已撤销</span>
				{else}
				<a class="btn btn-small btn-hollow external" href="{if $order.store_service_phone}tel://{$order.store_service_phone}{else}javascript:alert('无法联系卖家');{/if}">联系卖家</a>
				{/if}
				
				{if $order.refund_type eq 'refund' && $order.refund_status neq 'refunded'}
					{if $order.status eq 'agree' || $order.refund_status eq 'refunded'}
<!-- 						<a class="btn btn-small btn-hollow external" href="{url path='user/order/return_detail'}&refund_sn={$order.refund_sn}&type=return_money">退款详情</a> -->
					{/if}
					
					{if $order.status eq 'uncheck'}
						<a class="btn btn-small btn-hollow undo_reply" href='{url path="user/order/undo_reply" args="order_id={$order_id}&refund_sn={$order.refund_sn}"}'>撤销申请</a>
					{/if}
					
					{if $order.status eq 'refused'}
						<a class="btn btn-small btn-hollow" href='{url path="user/order/return_order" args="order_id={$order_id}&refund_sn={$order.refund_sn}"}'>重新申请</a>
					{/if}
				{/if}
				
				{if $order.refund_type eq 'return' && $order.refund_status neq 'refunded'}
					{if $order.status eq 'uncheck'}
						<a class="btn btn-small btn-hollow undo_reply" href='{url path="user/order/undo_reply" args="order_id={$order_id}&refund_sn={$order.refund_sn}"}'>撤销申请</a>
					{/if}
					
					{if $order.status eq 'agree' && !$order.selected_returnway_info}
						{if $return_way_info}
						<a class="btn btn-small btn-hollow data-pjax" href='{url path="user/order/return_way" args="refund_sn={$order.refund_sn}&type={$return_way_info.return_way_code}"}'>返还方式</a>
						{else}
						<a class="btn btn-small btn-hollow data-pjax" href='{url path="user/order/return_way_list" args="refund_sn={$order.refund_sn}"}'>返还方式</a>
						{/if}
					{/if}
					
					{if $order.status eq 'refused'}
						<a class="btn btn-small btn-hollow" href='{url path="user/order/return_order" args="order_id={$order_id}&refund_sn={$order.refund_sn}&type={$order.refund_type}"}'>重新申请</a>
					{/if}
				{/if}
				
				{if $order.refund_status eq 'refunded' || $order.refund_status eq 'checked'}
					<a class="btn btn-small btn-hollow external" href="{url path='user/order/return_detail'}&refund_sn={$order.refund_sn}&type=return_money">退款详情</a>
				{/if}
			</div>
		</div>
	</div>
	<input type="hidden" name="reason_list" value='{$reason_list}'>
</div>
<!-- #BeginLibraryItem "/library/shipping_fee_modal.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
{/nocache}