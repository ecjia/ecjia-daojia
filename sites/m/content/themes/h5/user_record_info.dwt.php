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
    ecjia.touch.user.record_cancel();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-account record-info" method="post">
    <div class="user-img">
        <img src="{$user.avatar_img}">
        <p class="user-name">{$user.name}</p>
    </div>
    <p class="record-money">{$sur_amount.formatted_amount}</p>
    <p class="record-status">{$sur_amount.pay_status}</p>
    <div class="record-info">
        <p class="record-val">{$sur_amount.order_sn}</p>
        <p class="record-key">订单编号</p>

        <p class="record-val">{$sur_amount.lable_type}</p>
        <p class="record-key">交易类型</p>

        <p class="record-val">{$sur_amount.formatted_real_amount}</p>
        <p class="record-key">到账金额</p>

        <p class="record-val">{$sur_amount.formatted_pay_fee}</p>
        <p class="record-key">手续费用</p>

        <p class="record-val">{$sur_amount.pay_name}</p>
        <p class="record-key">{if $sur_amount.type eq 'withdraw'}提现方式{else}充值方式{/if}</p>

        <p class="record-val">{$sur_amount.add_time}</p>
        <p class="record-key">{if $sur_amount.type eq 'withdraw'}申请时间{else}充值时间{/if}</p>

    </div>
    {if $sur_amount.pay_status neq '已完成' && $sur_amount.pay_status neq '已取消'}
    <form class="ecjia-form" name="useraccountForm" action="{url path='user/account/recharge_account'}" method="post">
        {if $sur_amount.type eq 'deposit'}
        <div class="two-btn btn-bottom">
            <input name="record_type" type="hidden" value={$sur_amount.type}/>
            <input name="account_id" type="hidden" value={$sur_amount.account_id}>
            <input name="payment_id" type="hidden" value={$sur_amount.payment_id}/>
            <input name="amount" type="hidden" value={$sur_amount.amount}/>
            <input name="brownser_wx" type="hidden" value="{$brownser_wx}"/>
            <input name="brownser_other" type="hidden" value="{$brownser_other}"/>

            <input class="btn ecjia-fl btn-c" id="record_cancel" name="record_cancel" data-url="{url path='user/account/record_cancel'}" type="button" value="{t}取消{/t}"/>

            <a class="btn ecjiaf-fr ecjia-fl nopjax external" href="{RC_Uri::url('user/account/recharge_again')}&format_amount={$sur_amount.format_amount}&order_sn={$sur_amount.order_sn}&account_id={$sur_amount.account_id}&payment_id={$sur_amount.payment_id}">{t}继续充值{/t}</a>
        </div>
        {else}
        <div class="two-btn btn-bottom">
            <div class="info">
                <p class="apply-img"></p>
                <p class="apply">已申请</p>
            </div>
            <input name="record_type" type="hidden" value={$sur_amount.type}/>
            <input name="account_id" type="hidden" value={$sur_amount.account_id}>
            <input class="btn ecjiaf-fr ecjia-fl" id="record_cancel" name="record_cancel" data-url="{url path='user/account/record_cancel'}" type="button" value="{t}取消{/t}"/>
        </div>
        {/if}
    </form>
    {/if}
</div>
<!-- {/block} -->