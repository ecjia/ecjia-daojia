<?php
/*
Name: 选择配送时间
Description: 选择配送时间
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" >
	ecjia.touch.init();
</script>
<script type="text/javascript">
$(function(){
	showShippingTime();
	$("input[name='shipping_date']").change(function(){
		showShippingTime();
	});
	function showShippingTime() {
		var checked_date = $("input[name='shipping_date']:checked").val();
		$(".data-shipping").hide();
		$(".shipping-time-" + checked_date).show();
	}
});
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form id="theForm" name="theForm" action='{url path="cart/flow/checkout" args="{if $smarty.session.order_address_temp.store_id}store_id={$smarty.session.order_address_temp.store_id}&{/if}address_id={$address_id}&rec_id={$rec_id}"}' method="post">
    <div class="ecjia-select ecjia-shipping-date">
        <p class="select-title ecjia-margin-l">选择日期</p>
        <ul class="ecjia-list">
            <!-- {foreach from=$shipping.shipping_date item=list} -->
            <label class="select-item" for="shipping_{$list.date}">
                <li>
                    <span>{$list.date}</span>
                    <span class="ecjiaf-fr">
                        <label class="ecjia-check"><input type="radio" id="shipping_{$list.date}" name="shipping_date" value="{$list.date}"
                        {if $temp.shipping_date eq $list.date} checked="true"{/if}>
                        </label>
                    </span>
                </li>
            </label>
            <!-- {/foreach} -->
        </ul>
        <p class="select-title ecjia-margin-l">选择时间段</p>
        <!-- {foreach from=$shipping.shipping_date item=date key=index} -->
        <ul class="ecjia-list data-shipping shipping-time-{$index}">
            <!-- {foreach from=$date.time item=list} -->
            <label class="select-item" for="shipping_{$index}{$list.start_time}-{$list.end_time}">
                <li>{assign var="shipping_time" value="{$list.start_time}-{$list.end_time}"}
                    <span>{$shipping_time}</span>
                    <span class="ecjiaf-fr">
                        <label class="ecjia-check"><input type="radio" id="shipping_{$index}{$list.start_time}-{$list.end_time}" name="shipping_time" value="{$shipping_time}"
                        {if $temp.shipping_time eq $shipping_time && $temp.shipping_date eq $index} checked="true"{/if}>
                        </label>
                    </span>
                </li>
            </label>
            <!-- {/foreach} -->
        </ul>
        <!-- {/foreach} -->
        <div class="ecjia-margin-t ecjia-margin-b">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
			<input class="btn btn-info" name="shipping_date_update" type="submit" value="确定"/>
        </div>
    </div>
</form>
<!-- {/block} -->
{/nocache}