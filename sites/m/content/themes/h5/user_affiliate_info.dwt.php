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
    <p class="record-money">{$sur_amount.formatted_change_amount}</p>
    <p class="record-status">{$sur_amount.label_status}</p>
    <div class="record-info">
        <p class="record-val">{$sur_amount.order_sn}</p>
        <p class="record-key">{t domain="h5"}订单编号{/t}</p>

        <p class="record-val">{$sur_amount.label_type}</p>
        <p class="record-key">{t domain="h5"}交易类型{/t}</p>

        <p class="record-val">{$sur_amount.formatted_change_amount}</p>
        <p class="record-key">{t domain="h5"}到账金额{/t}</p>

        <p class="record-val">{$sur_amount.formatted_change_time}</p>
        <p class="record-key">{if $sur_amount.type eq 'withdraw'}{t domain="h5"}申请时间{/t}{else}{t domain="h5"}充值时间{/t}{/if}</p>

    </div>
</div>
<!-- {/block} -->