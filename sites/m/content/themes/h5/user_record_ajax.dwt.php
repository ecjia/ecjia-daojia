<?php
/*
Name: 交易记录模板
Description: 交易记录页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {if $sur_amount} -->
<!-- {foreach from=$sur_amount key=key item=group} -->
<p class="record-time record-time-{substr($key, 0, 7)}">
    {if $key eq $now_mon}
    本月
    {else if $now_year eq substr($key, 0, 4)}
    {substr($key, 5, 2)}月
    {else}
    {substr($key, 0, 7)}月
    {/if}
</p>
<div class="record-list account-record-list" >
    <ul>
        <!-- {foreach from=$group item=item} -->
        <li class="record-single">
            <a href="{RC_Uri::url('user/account/record_info')}&account_id={$item.account_id}&log_id={$item.log_id}">
                <div class="record-l">
                    <span class="user-photo"><img src="{$user_img}" alt=""></span>
                </div>
                <div class="record-r">
                    <div class="record-r-l">
                        <span class="account-record-big">{$item.type_lable}</span>
                        <span class="record-time account-record-sm">{$item.add_time}</span>
                    </div>
                    <div class="record-r-r">
                        <span class="account-record-big">{$item.amount}</span>
                        <span class="account-record-sm">{$item.pay_status}</span>
                    </div>
            </a>
        </li>
        <!-- {/foreach} -->
    </ul>
</div>
<!-- {/foreach} -->
<!-- {else} -->
<!-- {if $pages eq 1} -->
<div class="ecjia-nolist">
    <div class="img-norecord">{t domain="h5"}暂无明细记录{/t}</div>
</div>
<!-- {/if} -->
<!-- {/if} -->
<!-- {/block} -->
{/nocache}