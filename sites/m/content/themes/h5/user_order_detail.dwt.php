<?php
/*
Name: 订单详情模板
Description: 这是订单详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.cancel_order();
	ecjia.touch.user.return_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-detail">
	<div class="ecjia-checkout ecjia-margin-b">
		<div class="flow-goods-list">
		    <div class="order-status-head">
			    <a href="{url path='user/order/order_detail'}&order_id={$order.order_id}&type={'status'}">
			        <span class="order-status-img">
			        	<p></p>
			        	{if $order.order_status_code eq 'finished'}
							<img src="{$theme_url}images/order_status/finished_2.png">
			        	{else if $order.order_status_code eq 'shipped'}
							<img src="{$theme_url}images/order_status/shipped_2.png">
						{else if $order.order_status_code eq 'await_pay'}
							<img src="{$theme_url}images/order_status/wait_pay_2.png">
						{else if $order.order_status_code eq 'await_ship' || $order.order_status_code eq 'confirmed'}
							<img src="{$theme_url}images/order_status/confirmed_2.png">
						{else if $order.order_status_code eq 'shipped_part'}
							<img src="{$theme_url}images/order_status/shipped_2.png">
						{else if $order.order_status_code eq 'canceled'}
							<img src="{$theme_url}images/order_status/canceled_2.png">
						{else if $order.order_status_code eq 'refunded' || $order.order_status_code eq 'refund'}
							<img src="{$theme_url}images/order_status/refund_2.png">
						{else if $order.order_status_code eq 'payed'}
							<img src="{$theme_url}images/order_status/wait_confirm_2.png">
                        {else}
                            <img src="{$theme_url}images/order_status/done_2.png">
			        	{/if}
			        </span>
			        <div class="order-status-msg">
	    		        <span class="order-head-top"><span class="order-head-font">{$headInfo.order_status}</span><span class="ecjiaf-fr order-color">{$headInfo.time}</span></span>
	    		        <p class="ecjia-margin-t status"><span class="order-color order-status">{$headInfo.message}</span><span class="ecjiaf-fr more-status">{t domain="h5"}更多状态 >{/t}</span></p>
			        </div>
		        </a>
		    </div>

			{if $express_info}
			<div class="order-express-info">
				<a href="{url path='user/order/express_info'}&order_id={$order.order_id}"><div class="express-info-title">{t domain="h5"}物流信息{/t}<span class="ecjiaf-fr"><i class="iconfont icon-jiantou-right"></i></span></div></a>
				<div class="express-info-item">
					<div class="ecjia-li-pitch">
						{if $express_info.content.time eq 'error'}
						<div class="at-timeline at-timeline at-timeline--pending at-timeline--pending">
							<div class="at-timelineitem at-timelineitem">
								<div class="at-timelineitem__tail at-timelineitem__tail"></div>
								<div class="at-timelineitem__dot at-timelineitem__dot"></div>
								<div class="at-timelineitem__content at-timelineitem__content">
									<div class="at-timelineitem__content-item at-timelineitem__content-item">{$express_info.content.context}</div>
								</div>
							</div>
						</div>
						{else}
							{foreach from=$express_info.content item=v key=k}
								{if $k eq 0}
								<div class="at-timeline at-timeline at-timeline--pending at-timeline--pending">
									<div class="at-timelineitem at-timelineitem">
										<div class="at-timelineitem__tail at-timelineitem__tail"></div>
										<div class="at-timelineitem__dot at-timelineitem__dot"></div>
										<div class="at-timelineitem__content at-timelineitem__content">
											<div class="at-timelineitem__content-item at-timelineitem__content-item">{$v.context}</div>
											<div class="at-timelineitem__content-item-time">{$v.time}</div>
										</div>
									</div>
								</div>
								{/if}
							{/foreach}
						{/if}
					</div>
				</div>
			</div>
			{/if}
		    
			<div class="order-hd">
				<a class="ecjiaf-fl nopjax external" href='{url path="merchant/index/init" args="store_id={$order.store_id}"}'>
					<i class="iconfont icon-shop"></i>{$order.seller_name}
				</a>
			</div>
			<ul class="goods-item">
				<!-- {foreach from=$order.goods_list item=goods} -->
				<li>
				    <a class="nopjax external" href='{url path="goods/index/show" args="goods_id={$goods.goods_id}&product_id={$goods.product_id}"}'>
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
                {if $order.extension_code eq 'group_buy'}
                    <li>{t domain="h5"}商品保证金：{/t}<span class="ecjiaf-fr">{$order.formated_order_deposit}</span></li>
                {else}
                    <li>{t domain="h5"}商品金额：{/t}<span class="ecjiaf-fr ">{$order.formated_goods_amount}</span></li>
                {/if}

                {if $order.tax neq 0}
                <li>{t domain="h5"}税费金额：{/t}<span class="ecjiaf-fr ">{$order.formated_tax}</span></li>
                {/if}

                {if $order.integral_money neq 0}
                <li>{$integral_name}{t domain="h5"}抵扣：{/t}<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_integral_money}</span></li>
                {/if}

                {if $order.bonus neq 0}
                <li>{t domain="h5"}红包抵扣：{/t}<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_bonus}</span></li>
                {/if}

                {if $order.discount neq 0}
                <li>{t domain="h5"}优惠金额：{/t}<span class="ecjiaf-fr ecjia-color-red ">-{$order.formated_discount}</span></li>
                {/if}

                <li>{t domain="h5"}运费：{/t}<span class="ecjiaf-fr ">{$order.formated_shipping_fee}</span></li>

                {if $order.pay_fee neq 0}
                <li>{t domain="h5"}手续费：{/t}<span class="ecjiaf-fr ">{$order.formated_pay_fee}</span></li>
                {/if}

                {if $order.extension_code eq 'group_buy'}
                    <li>{t domain="h5"}已支付：{/t}<span class="ecjiaf-fr">{$order.formated_payed}</span></li>
                    <li>{t domain="h5"}待支付余额：{/t}<span class="ecjiaf-fr ecjia-color-red">{$order.formated_order_amount}</span></li>
                {else}
                    <li>{t domain="h5"}共计：{/t}<span class="ecjiaf-fr ">{$order.formated_total_fee}</span></li>
                {/if}
			</ul>
			
			{if $order.order_mode eq 'storepickup'}
				<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}自提信息{/t}</p>
				<ul class="ecjia-list">
				    <li><span class="ecjiaf-fl width-25-p">{t domain="h5"}提货时间：{/t}</span><span class="ecjiaf-fr width-75-p">{if $order.expect_shipping_time}{$order.expect_shipping_time}{else}{t domain="h5"}暂无{/t}{/if}</span></li>
					<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}提货码：{/t}</span><span class="ecjiaf-fr width-75-p">{if $order.pickup_code}{$order.pickup_code}{else}{t domain="h5"}暂无{/t}{/if}</span></li>
					<li style="height: auto; position: relative;">
						<span class="ecjiaf-fl width-25-p">{t domain="h5"}提货门店：{/t}</span>
						<span class="ecjiaf-fr width-75-p p_d">{$order.seller_name} {if $order.service_phone}({$order.service_phone}){/if}</span>
						<span class="ecjiaf-fr width-75-p">{$order.store_address}</span>
						{if $location_url}
						<a class="nopjax external" href="{$location_url}"><i class="icon-shopguide-detail"></i></a>
						{/if}
					</li>
				</ul>
			{else}
				<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}配送信息{/t}</p>
				<ul class="ecjia-list">
				    <!-- <li><span class="ecjiaf-fl width-25-p">{t domain="h5"}发货时间：{/t}</span><span class="ecjiaf-fr width-75-p">{if $order.shipping_time}{$order.shipping_time}{else}{t domain="h5"}暂未发货{/t}{/if}</span></li> -->
					{if $order.expect_shipping_time neq ' ' && $order.expect_shipping_time neq '' && $order.expect_shipping_time neq 'undefined'}<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}送达时间：{/t}</span><span class="ecjiaf-fr width-75-p">{$order.expect_shipping_time}</span></li>{/if}
					<li style="height: auto;"><span class="ecjiaf-fl width-25-p">{t domain="h5"}收货地址：{/t}</span>
					<span class="ecjiaf-fr width-75-p">{$order.consignee} {$order.mobile}</span>
					<span class="ecjiaf-fr width-75-p">{$order.province}{$order.city}{$order.district}{$order.street} {$order.address}</span></li>
					<li>
						<span class="ecjiaf-fl width-25-p">{t domain="h5"}配送员：{/t}</span><span class="ecjiaf-fr width-75-p">
						{if $order.express_user}
							{$order.express_user}
							{if $express_url}
							<span>
								<a style="float: right;display: inline-block;" class="nopjax external" href="{$express_url}">
									<img class="order-map" src="{$theme_url}images/icon/order-map.png">
								</a>
							</span>
							{/if}
						{else}
							{t domain="h5"}暂无{/t}
						{/if}
						</span>
					</li>
					<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}配送员号码：{/t}</span><span class="ecjiaf-fr width-75-p">{if $order.express_user}{$order.express_mobile}{else}{t domain="h5"}暂无{/t}{/if}</span></li>
					<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}配送方式：{/t}</span><span class="ecjiaf-fr width-75-p">{$order.shipping_name}</span></li>
				</ul>
			{/if}
			
			{if $order.shipping_code == 'ship_cac' && $order.pickup_code neq '' && $order.order_mode neq 'storepickup'}
			<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}提货信息{/t}</p>
			<ul class="ecjia-list">
				<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}提货码：{/t}</span><span class="ecjiaf-fr width-75-p">{$order.pickup_code}</span></li>
				<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}提货状态：{/t}</span><span class="ecjiaf-fr width-75-p">{if $order.pickup_status == 0}{t domain="h5"}未提取{/t}{else}{t domain="h5"}已提取{/t}{/if}</span></li>
				<li hidden><span class="ecjiaf-fl width-25-p">{t domain="h5"}有效期至：{/t}</span><span class="ecjiaf-fr width-75-p">{$order.pickup_code_expiretime}</span></li>
			</ul>
			{/if}
			
			<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}订单信息{/t}</p>
			<ul class="ecjia-list">
			    <li><span class="ecjiaf-fl width-25-p">{t domain="h5"}订单编号：{/t}</span><span class="width-75-p">{$order.order_sn}</span><button class="copy-btn" data-clipboard-text="{$order.order_sn}">{t domain="h5"}复制{/t}</button></li>
			    <li><span class="ecjiaf-fl width-25-p">{t domain="h5"}下单时间：{/t}</span><span class="ecjiaf-fr width-75-p">{$order.formated_add_time}</span></li>
				<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}支付方式：{/t}</span><span class="ecjiaf-fr width-75-p">{$order.pay_name}</span></li>
				<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}发票抬头：{/t}</span><span class="ecjiaf-fr width-75-p">{if $order.inv_payee}{$order.inv_payee}{else if $order.inv_type neq ''}{t domain="h5"}个人{/t}{else}{t domain="h5"}暂无{/t}{/if}</span></li>
				<li><span class="ecjiaf-fl width-25-p">{t domain="h5"}发票识别码：{/t}</span><span class="ecjiaf-fr width-75-p">{if $order.inv_tax_no}{$order.inv_tax_no}{else}{t domain="h5"}暂无{/t}{/if}</span></li>
				<li class="remark"><span class="ecjiaf-fl width-25-p">{t domain="h5"}订单备注：{/t}</span><span class="ecjiaf-fr width-75-p">{if $order.postscript}{$order.postscript}{else}{t domain="h5"}暂无{/t}{/if}</span></li>
			</ul>
			<div class="order-ft-link">
				<a class="btn btn-small btn-hollow external" href="{if $order.service_phone}tel://{$order.service_phone}{else}javascript:alert('{t domain='h5'}无法联系卖家{/t}');{/if}">{t domain="h5"}联系卖家{/t}</a>
				{if !$order.refund_info}
					{if $order.order_status_code eq 'await_pay'}
                        {if $order.extension_code neq 'group_buy'}
						<a class="btn btn-small btn-hollow cancel_order_unpay" href='{url path="user/order/order_cancel" args="order_id={$order.order_id}"}'>{t domain="h5"}取消订单{/t}</a>
                        {/if}
						<a class="btn btn-small btn-hollow" href='{url path="payment/pay/init" args="order_id={$order.order_id}{if $order.extension_code eq 'group_buy'}&type=group_buy{/if}"}'>
							{if $order.has_deposit eq 1}{t domain="h5"}支付余额{/t}{else}{t domain="h5"}去支付{/t}{/if}
						</a>
					{/if}
					
					{if $order.order_status_code eq 'await_ship' || $order.order_status_code eq 'payed'}
						<a class="btn btn-small btn-hollow" href='{url path="user/order/return_order" args="order_id={$order.order_id}"}'>{t domain="h5"}申请退款{/t}</a>
					{/if}
					
					{if $order.order_status_code eq 'shipped'} 
						<a class="btn btn-small btn-hollow affirm_received" href='{url path="user/order/affirm_received" args="order_id={$order.order_id}"}'>{t domain="h5"}确认收货{/t}</a>
						<a class="btn btn-small btn-hollow" href='{url path="user/order/return_order" args="order_id={$order.order_id}"}'>{t domain="h5"}申请退款{/t}</a>
					{/if}
				{/if}
				
				{if $order.order_status_code eq 'payed' && $order.extension_code neq 'group_buy'}
					<a class="btn btn-small btn-hollow" href='{url path="user/order/buy_again" args="order_id={$order.order_id}"}'>{t domain="h5"}再次购买{/t}</a>
				{/if}
				
				{if ($order.refund_type eq 'refund' || $order.refund_type eq 'return') && $order.refund_status eq 'going'}
				<a class="btn btn-small btn-hollow undo_reply" href='{url path="user/order/undo_reply" args="order_id={$order.order_id}&refund_sn={$order.refund_info.refund_sn}"}'>{t domain="h5"}撤销申请{/t}</a>
				{/if}
				
				{if !$order.refund_info && $order.order_status_code eq 'finished'}
				<a class="btn btn-small btn-hollow" href='{url path="user/order/comment_list" args="order_id={$order.order_id}"}'>{t domain="h5"}评价晒单{/t}</a>
				{/if}
				
				{if $order.order_status_code eq 'refunded' || $order.order_status_code eq 'finished' || $order.refund_info}
					{if $order.refund_info}
					<a class="btn btn-small btn-hollow" href='{url path="user/order/return_detail" args="order_id={$order.order_id}{if $order.refund_info}&refund_sn={$order.refund_info.refund_sn}{/if}"}'>{t domain="h5"}售后详情{/t}</a>
					{else}
					<a class="btn btn-small btn-hollow" href='{url path="user/order/return_list" args="order_id={$order.order_id}"}'>{t domain="h5"}售后{/t}</a>
					{/if}
				
				{/if}
			</div>
		</div>
	</div>
	<input type="hidden" name="reason_list" value='{$reason_list}'>
</div>
<!-- {/block} -->