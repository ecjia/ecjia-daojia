<?php
/*
Name: 支付结算模板
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-flow-done ecjia-pay">
    {if $tips_show}
    <div class="flow-success">
        <p>恭喜您，订单已经生成~</p>
    </div>
    {/if}
    <ul class="ecjia-list ecjia-margin-t">
        <li>订单金额：<span class="ecjiaf-fr">{$detail.formated_total_fee}</span></li>
        <li>支付方式：<span class="ecjiaf-fr flow-msg">{$data.pay_name}</span></li>
    </ul>
    <div class="ecjia-margin-t ecjia-margin-b flow-msg">{if $data.pay_status eq 'success'}支付成功！{else}{$pay_error}{/if}</div>
    {if $payment_list}
    <ul class="ecjia-list ecjia-margin-t">
        <li>
                        其它支付方式 <span class="ecjiaf-fr"></span>
        </li>
    </ul>
    <ul class="ecjia-list list-short payment-list">
    <!-- {foreach from=$payment_list item=list} -->
        <li>
            <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}"><a href='{url path="pay/index/init" args="order_id={$data.order_id}&pay_id={$list.pay_id}&pay_code={$list.pay_code}"}'>{$list.pay_name}</a></span>
        </li>
    <!-- {/foreach} -->
    </ul>
    {/if}

    {if $pay_online}
    <div class="ecjia-margin-t ecjia-margin-b">
        <a class="btn" href="{$pay_online}">确认支付</a>
    </div>
    {/if}
    
    {if $pay_button}
    	{$pay_button}
    {/if}
    
    {if $data.pay_code eq 'pay_cod'}
    <ul class="ecjia-list">
       <li>下单成功，请货到后付款</li>
    </ul>
    {/if}
    
    {if $data.pay_status eq 'success' || $data.pay_code eq 'pay_cod'}
    <div class="ecjia-margin-t ecjia-margin-b two-btn">
        <a class="btn" href='{url path="touch/index/init"}'>去购物</a>
        <a class="btn" href='{url path="user/order/order_detail" args="order_id={$data.order_id}"}'>查看订单</a>
    </div>
    {/if}
</div>
<!-- {/block} -->