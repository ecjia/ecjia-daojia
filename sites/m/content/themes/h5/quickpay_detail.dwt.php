<?php
/*
Name: 闪惠详情
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.quickpay.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list ecjia-order-detail ecjia-order-pad">
	<form name="quickpay_form" action="{url path='user/quickpay/dopay'}" method="post" >
	    <div class="franchisee-process-hint quickpay-hint"> 
	    	{if $data.order_status_str eq 'unpaid'}
	        <img class="quickpay-status-img" src="{$theme_url}images/user_center/wait_paid.png">
	        {else if $data.order_status_str eq 'canceled'}
	        <img class="quickpay-status-img" src="{$theme_url}images/user_center/cancel.png">
	        {else}
	        <img class="quickpay-status-img" src="{$theme_url}images/user_center/apply.png">
	        {/if}
	        <p class="quickpay-status-g {if $data.order_status_str eq 'unpaid' || $data.order_status_str eq 'canceled'}unpaid{/if}">{$data.label_order_status}</p>
	    </div>
	    <div class="franchisee-info quickpay-detail">
	        <ul>
	            <p>
	                <span class="ecjiaf-fl fran-info-color">订单编号</span>
	                <span class="ecjiaf-fr">{$data.order_sn}</span>
	            </p>
	            {if $data.title}
	            <p>
	                <span class="ecjiaf-fl fran-info-color">优惠名称</span>
	                <span class="ecjiaf-fr">{$data.title}</span>
	            </p>
	            {/if}
	            <p>
	                <span class="ecjiaf-fl fran-info-color">消费金额</span>
	                <span class="ecjiaf-fr">{$data.formated_goods_amount}</span>
	            </p>
	            <p>
	                <span class="ecjiaf-fl fran-info-color">优惠金额</span>
	                <span class="ecjiaf-fr">-{$data.formated_total_discount}</span>
	            </p>
	            <p>
	                <span class="ecjiaf-fl fran-info-color">实付金额</span>
	                <span class="ecjiaf-fr">{$data.formated_order_amount}</span>
	            </p>
	            <p>
	                <span class="ecjiaf-fl fran-info-color">买单时间</span>
	                <span class="ecjiaf-fr address-span">{$data.formated_add_time}</span>
	            </p>
	           	{if $data.pay_name}
	            <p>
	                <span class="ecjiaf-fl fran-info-color">支付方式</span>
	                <span class="ecjiaf-fr address-span">{$data.pay_name}</span>
	            </p>
	            {/if}
	        </ul>
	    </div>
	    
	    <div class="order-ft-link">
	    	<input type="hidden" name="order_id" value="{$data.order_id}">
	    	<input  type="hidden" name="pay_code" value="{$data.pay_code}" />
	    	{if $data.order_status_str eq 'unpaid'}
	    		<a class="btn btn-small btn-hollow external quickpay_order_handle" href="{RC_Uri::url('user/quickpay/cancel')}&order_id={$data.order_id}" data-message="您确定要取消该订单吗？">取消订单</a>
		    	{if $data.pay_code eq ''}
		    	<a class="btn btn-small btn-hollow external" href="{RC_Uri::url('user/quickpay/pay')}&order_id={$data.order_id}">去支付</a>
		    	{else}
		    	<input type="submit" class="btn btn-small btn-hollow external quick_pay_btn" value="去支付" />
		    	{/if}
	    	<div class="wei-xin-pay hide"></div>
	    	{/if}
	    	
	    	{if $data.order_status_str eq 'canceled'}
	    	<a class="btn btn-small btn-hollow external quickpay_order_handle" href="{RC_Uri::url('user/quickpay/delete')}&order_id={$data.order_id}" data-message="您确定要删除该订单吗？">删除订单</a>
	    	{else}
	        <a class="btn btn-small btn-hollow external" href="tel://{$data.service_phone}">联系卖家</a>
	        {/if}
	    </div>
	</form>
</div>
<!-- {/block} -->
{/nocache}