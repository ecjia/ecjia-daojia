<?php 
/*
Name: 交易记录模板
Description: 交易记录页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-account-list-f">
    <div class="ecjia-account-list">
        <ul class="ecjia-list ecjia-list-three ecjia-nav ecjia-account ecjia-bonus-border-right1">
        	<li><a {if $smarty.get.status eq ''}class="ecjia-green left-bottom ecjia-green-rf"{else}class="left-bottom ecjia-green-rf"{/if} id="left-bottom" href="{url path='user/account/record' args='status='}">{t domain="h5"}全部{/t}</a></li>
        	<li><a {if $smarty.get.status eq 'raply'}class="ecjia-green ecjia-green-rf"{else}class="ecjia-green-rf"{/if} href="{url path='user/account/record' args='status=raply'}">{t domain="h5"}提现{/t}</a></li>
        	<li><a {if $smarty.get.status eq 'deposit'}class="ecjia-green right-bottom ecjia-green-rf"{else}class="right-bottom ecjia-green-rf"{/if} id="right-bottom" href="{url path='user/account/record' args='status=deposit'}">{t domain="h5"}充值{/t}</a></li>
        </ul>
    </div>
</div>
{if $smarty.get.status eq ''}
<div><ul class="ecjia-account-record ecjia-list list-short ecjia-user-no-border-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/account/ajax_record'}" data-size="10"></ul></div>
{elseif $smarty.get.status eq 'raply'}
<div><ul class="ecjia-account-record ecjia-list list-short ecjia-user-no-border-b" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/account/ajax_record_raply'}" data-size="10"></ul></div>
{elseif $smarty.get.status eq 'deposit'}
<div><ul class="ecjia-account-record ecjia-list list-short ecjia-user-no-border-b" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/account/ajax_record_deposit'}" data-size="10"></ul></div>
{/if}
<!-- {/block} -->

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
                <a href="{RC_Uri::url('user/account/record_info')}&account_id={$item.account_id}">
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
<!--{/nocache}-->