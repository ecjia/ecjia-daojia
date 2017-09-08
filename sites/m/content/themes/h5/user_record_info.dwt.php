<?php
/*
Name: 交易流水记录模板
Description: 交易流水记录页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.touch.user_account.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-account record-info" method="post">
    <div class="user-img"><img src="{$user_img}">
        <p class="user-name">{$user.name}</p>
    </div>
    <p class="record-money">{$sur_amount.format_amount}</p>
    <p class="record-status">{$sur_amount.pay_status}</p>
    <div class="record-info">
        <p class="record-val">{$sur_amount.order_sn}</p>
        <p class="record-key">订单编号</p>
        <p class="record-val">{if $sur_amount.type eq 'raply'}账户余额{else}{$sur_amount.payment_name}{/if}</p>
        <p class="record-key">支付方式</p>
        <p class="record-val">{$sur_amount.type_lable}</p>
        <p class="record-key">交易类型</p>
        <p class="record-val">{$sur_amount.add_time}</p>
        <p class="record-key">{if $sur_amount.type eq 'raply'}申请时间{else}充值时间{/if}</p>
    </div>
	{if $sur_amount.pay_status eq '已完成'}
    {elseif $sur_amount.pay_status eq ''}
    {else}
        <form  class="ecjia-form" name="useraccountForm" action="{url path='user/account/recharge_account'}" method="post" >
        {if $sur_amount.type eq 'deposit'}
            <div class="two-btn btn-bottom">
                <input name="record_type" type="hidden" value={$sur_amount.type} />
                <input name="account_id" type="hidden" value={$sur_amount.account_id}>
                <input name="payment_id" type="hidden" value={$sur_amount.payment_id} />
                <input name="amount" type="hidden" value={$sur_amount.amount} />
                <input name="brownser_wx" type="hidden" value={$brownser_wx} />
                <input name="brownser_other" type="hidden" value={$brownser_other} />
        		<input class="btn ecjia-fl btn-c" id="record_cancel" name="record_cancel" data-url="{url path='user/account/record_cancel'}" type="submit" value="{t}取消{/t}" />
        		{if $sur_amount.payment_name eq '微信支付'}
        			<input class="btn ecjiaf-fr ecjia-fl" name="record_sure" data-url="{url path='user/account/recharge_account'}" type="submit" value="{t}充值{/t}" />
        			<div class="wei-xin-pay hide"></div>
        		{else}
        			<input class="btn btn-recharge ecjiaf-fr ecjia-fl alipay-btn" type="submit" value="{t}充值{/t}" />
        			<input type="hidden" name="record" value="1">
        		{/if}
        	</div>
        {else}
            <div class="two-btn btn-bottom">
                <p class="apply-img"></p>
                <p class="apply">已申请</p>
                <input name="record_type" type="hidden" value={$sur_amount.type} />
                <input name="account_id" type="hidden" value={$sur_amount.account_id}>
                <input class="btn ecjiaf-fr btn-c ecjia-fl" id="record_cancel" name="record_cancel" data-url="{url path='user/account/record_cancel'}" type="submit" value="{t}取消{/t}" />
        	</div>	
        {/if}	
        </form>
	{/if}
</div>
<!-- {/block} -->