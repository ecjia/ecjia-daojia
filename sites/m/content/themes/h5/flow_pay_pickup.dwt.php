<?php
/*
Name: 选择支付方式、提货时间时间
Description: 选择支付方式、提货时间时间模版
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
<form id="theForm" name="theForm" action='{url path="cart/flow/storepickup_checkout" args="{if $smarty.session.order_address_temp.store_id}store_id={$smarty.session.order_address_temp.store_id}&{/if}address_id={$address_id}&rec_id={$rec_id}"}' method="post">
    <div class="ecjia-select">
    	<div class="ecjia-select-white">
    		{if $payment_list.online || $payment_list.offline}
	        <p class="select-title ecjia-margin-l"><span class="icon-pay-title"></span>{t domain="h5"}支付方式{/t}</p>
	        <ul class="ecjia-list">
	        
	        	<!-- {if $payment_list.online} -->
	            <label class="select-item">
	                <li class="select-item-li">
	                	<!-- {foreach from=$payment_list.online item=rs} -->
	                    <span class="select-pay-title {if $temp.pay_id eq $rs.pay_id}active{/if}" data-payment="{$rs.pay_id}">{$rs.pay_name}</span>
	                    <!-- {/foreach} -->
	                </li>
	            </label>
	            <!-- {/if} -->
	            
	            <!-- {if $payment_list.offline} -->
	            <label class="select-item">
	                <li class="select-item-li">
	                	<!-- {foreach from=$payment_list.offline item=rs} -->
	                    <span class="select-pay-title {if $temp.pay_id eq $rs.pay_id}active{/if}" data-payment="{$rs.pay_id}">{$rs.pay_name}</span>
	                    <!-- {/foreach} -->
	                </li>
	            </label>
	            <!-- {/if} -->
	        </ul>
	        {/if}
	        
			{if $pickup_time}
	        <ul class="ecjia-list border-top-none">
	            <label class="select-item select-shipping-date show">
	                <li>
	                	<span class="slect-title">{t domain="h5"}提货时间{/t}</span>
	                	<span class="ecjiaf-fr icon-span"><i class="iconfont icon-jiantou-right"></i></span>
	                	<span class="ecjiaf-fr shipping-time">{if $temp.pickup_date}{$temp.pickup_date} {$temp.pickup_time}{/if}</span>
	                </li>
	                <input type="hidden" name="pickup_date" value="{$temp.pickup_date}">
            		<input type="hidden" name="pickup_time" value="{$temp.pickup_time}">
	            </label>
	        </ul>
	        {/if}
        </div>
        
        <div class="ecjia-margin-t ecjia-margin-b">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
            <input type="hidden" name="payment" value="{$temp.pay_id}">
			<input class="btn btn-info" name="payment_pickup_update" type="submit" value='{t domain="h5"}确定{/t}' />
        </div>
    </div>
</form>

<div class="mod_address_slide" id="shippingTimeArea">
	<div class="mod_address_slide_main">
		<div class="mod_address_slide_head">
			{t domain="h5"}提货时间{/t}<i class="iconfont icon-close"></i>
		</div>
		<div class="mod_address_slide_body">
			<ul class="mod_address_slide_tabs navBar">
				<!-- {foreach from=$pickup_time item=val} -->
				<li class="{if $temp.pickup_date eq $val.date}active{/if}" data-date="{$val.date}">{$val.date}</li>
				<!-- {/foreach} -->
			</ul>
			<ul class="mod_address_slide_list selShip">
				<!-- {foreach from=$pickup_time item=val} -->
					<!-- {foreach from=$val.time item=date} -->
						{assign var="pick_time" value="{$date.start_time}-{$date.end_time}"}
						<li class="{$temp.pickup_time} {$val.date} {if $temp.pickup_time eq $pick_time && $temp.pickup_date eq $val.date}active{/if} {if $temp.pickup_date neq $val.date}hide{/if}" data-date="{$val.date}" data-time="{$date.start_time}-{$date.end_time}">{$date.start_time}-{$date.end_time}</li>
					<!-- {/foreach} -->
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->
{/nocache}