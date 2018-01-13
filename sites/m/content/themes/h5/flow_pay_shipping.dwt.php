<?php
/*
Name: 选择支付 、配送、配送时间
Description: 选择支付 、配送、配送时间模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" >
	ecjia.touch.flow.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form id="theForm" name="theForm" action='{url path="cart/flow/checkout" args="{if $smarty.session.order_address_temp.store_id}store_id={$smarty.session.order_address_temp.store_id}&{/if}address_id={$address_id}&rec_id={$rec_id}"}' method="post">
    <div class="ecjia-select">
    	<div class="ecjia-select-white">
    		{if $payment_list.online || $payment_list.offline}
	        <p class="select-title ecjia-margin-l"><span class="icon-pay-title"></span>支付方式</p>
	        <ul class="ecjia-list">
	        	{if $payment_list.online}
	            <label class="select-item">
	                <li class="select-item-li">
	                	<!-- {foreach from=$payment_list.online item=rs} -->
	                    <span class="select-pay-title {if $temp.pay_id eq $rs.pay_id}active{/if}" data-payment="{$rs.pay_id}">{$rs.pay_name}</span>
	                    <!-- {/foreach} -->
	                </li>
	            </label>
	            {/if}
	            
	            {if $payment_list.offline}
	            <label class="select-item">
	                <li class="select-item-li">
	                	<!-- {foreach from=$payment_list.offline item=rs} -->
	                    <span class="select-pay-title {if $temp.pay_id eq $rs.pay_id}active{/if}" data-payment="{$rs.pay_id}">{$rs.pay_name}</span>
	                    <!-- {/foreach} -->
	                </li>
	            </label>
	            {/if}
	        </ul>
	        {/if}
	        
			{if $shipping_list || $shipping.shipping_date}
	        <p class="select-title ecjia-margin-l"><span class="icon-shipping-title"></span>配送方式</p>
	        <ul class="ecjia-list">
	        	{if $shipping_list}
	            <label class="select-item">
	                <li class="select-item-li">
	                	<!-- {foreach from=$shipping_list item=list} -->
	                    <span class="select-shipping-title {if $temp.shipping_id eq $list.shipping_id}active{/if}" data-shipping="{$list.shipping_id}" data-code="{$list.shipping_code}">{$list.shipping_name}</span>
	                    <!-- {/foreach} -->
	                </li>
	            </label>
	            {/if}
	            
	            <label class="select-item select-shipping-date {if $shipping.shipping_code eq 'ship_o2o_express'}show{/if}">
	                <li>
	                	<span class="slect-title">送达时间</span>
	                	<span class="ecjiaf-fr icon-span"><i class="iconfont icon-jiantou-right"></i></span>
	                	<span class="ecjiaf-fr shipping-time">{if $temp.shipping_date}{$temp.shipping_date} {$temp.shipping_time}{/if}</span>
	                </li>
	                <input type="hidden" name="shipping_date" value="{$temp.shipping_date}">
            		<input type="hidden" name="shipping_time" value="{$temp.shipping_time}">
	            </label>
	        </ul>
	        {/if}
        </div>
        
        <div class="ecjia-margin-t ecjia-margin-b">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
            
            <input type="hidden" name="payment" value="{$temp.pay_id}">
            <input type="hidden" name="shipping" value="{$temp.shipping_id}">
			<input class="btn btn-info" name="payment_shipping_update" type="submit" value="确定"/>
        </div>
    </div>
</form>

<div class="mod_address_slide" id="shippingTimeArea">
	<div class="mod_address_slide_main">
		<div class="mod_address_slide_head">
			送货时间<i class="iconfont icon-close"></i>
		</div>
		<div class="mod_address_slide_body">
			<ul class="mod_address_slide_tabs navBar">
				<!-- {foreach from=$shipping_list item=list} -->
				{if $list.shipping_code eq 'ship_o2o_express'}
				<!-- {foreach from=$list.shipping_date item=val} -->
				<li class="{if $temp.shipping_date eq $val.date}active{/if}" data-date="{$val.date}">{$val.date}</li>
				<!-- {/foreach} -->
				{/if}
				<!-- {/foreach} -->
			</ul>
			<ul class="mod_address_slide_list selShip">
				<!-- {foreach from=$shipping_list item=list} -->
					{if $list.shipping_code eq 'ship_o2o_express'}
					<!-- {foreach from=$list.shipping_date item=date} -->
						<!-- {foreach from=$date.time item=time} -->
						{assign var="shipping_time" value="{$time.start_time}-{$time.end_time}"}
						<li class="{$temp.shipping_time} {$date.date} {if $temp.shipping_time eq $shipping_time && $temp.shipping_date eq $date.date}active{/if} {if $temp.shipping_date neq $date.date}hide{/if}" data-date="{$date.date}" data-time="{$time.start_time}-{$time.end_time}">{$time.start_time}-{$time.end_time}</li>
						<!-- {/foreach} -->
					<!-- {/foreach} -->
					{/if}
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->
{/nocache}