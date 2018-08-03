<?php
/*
Name: 更改支付方式页面
Description: 
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

<form class="ecjia-form" name="payForm" action="{url path='payment/pay/pay_order'}" method="post">
    <div class="ecjia-flow-done ecjia-pay">
        <p class="ecjia-payment-notice">当前订单不支持原有支付方式，请切换新的支付方式继续支付。</p>


        <ul class="ecjia-list ecjia-margin-t">
            <li>订单金额：<span class="ecjiaf-fr">{$detail.formated_total_fee}</span></li>
            <li>支付方式：<span class="ecjiaf-fr flow-msg">{$detail.pay_name}</span></li>
        </ul>
        
        {if $payment_list}
            <ul class="ecjia-list ecjia-margin-t">
                <li>
                    其它支付方式 <span class="ecjiaf-fr"></span>
                </li>
            </ul>

            <ul class="ecjia-list list-short payment-list">
            <!-- {foreach from=$payment_list item=list} -->
                <li>
                    <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                        <label for="{$list.pay_id}" class="ecjiaf-fr ecjia-check">
                            <input type="radio" id="{$list.pay_id}" name="pay_id" value="{$list.pay_id}"{if $list.checked}checked="true"{/if} >
                        </label>
                        {$list.pay_name}
                    </span>
                </li>
            <!-- {/foreach} -->
            </ul>
        {/if}

        <div class="ecjia-margin-t ecjia-margin-b">
            <input name="order_id" type="hidden" value="{$detail.order_id}" />
            <input class="btn btn-recharge confirm-payment" name="submit" type="submit" value="{t}确认支付{/t}" />
        </div>
        <div class="wei-xin-pay hide"></div>
    </div>
</form>
<!-- {/block} -->
{/nocache}