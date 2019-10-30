<?php
/*
Name: 订单分成
Description: 订单分成列表
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->
<div class="ecjia-reward-list list-three">
    <div class="reward-head">
        <a class="fnUrlReplace" href='{url path="user/order/affiliate"}'><div class="reward-head-item {if !$status}active{/if}"><span>全部</span></div></a>
        <a class="fnUrlReplace" href='{url path="user/order/affiliate"}&status=await_separate'><div class="reward-head-item {if $status eq 'await_separate'}active{/if}"><span>{t domain="h5"}待分成{/t}</span></div></a>
        <a class="fnUrlReplace" href='{url path="user/order/affiliate"}&status=separated'><div class="reward-head-item {if $status eq 'separated'}active{/if}"><span>{t domain="h5"}已分成{/t}</span></div></a>
    </div>

    <ul class="reward-list" id="reward-list" data-toggle="asynclist" data-url="{url path='user/order/ajax_order_affiliate'}{if $status}&status={$status}{/if}" data-loadimg="{$theme_url}dist/images/loader.gif">
    </ul>
</div>
<!-- {/block} -->

{/nocache}