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
        <ul class="ecjia-list ecjia-list-four ecjia-nav ecjia-account ecjia-bonus-border-right1">
            <li><a {if $status eq ''}class="ecjia-green left-bottom ecjia-green-rf"{else}class="left-bottom ecjia-green-rf"{/if} id="left-bottom" href="{url path='user/account/record' args='status='}">{t domain="h5"}全部{/t}</a></li>
            <li><a {if $status eq 'raply'}class="ecjia-green ecjia-green-rf"{else}class="ecjia-green-rf"{/if} href="{url path='user/account/record' args='status=raply'}">{t domain="h5"}提现{/t}</a></li>
            <li><a {if $status eq 'deposit'}class="ecjia-green ecjia-green-rf"{else}class="ecjia-green-rf"{/if} href="{url path='user/account/record' args='status=deposit'}">{t domain="h5"}充值{/t}</a></li>
            <li><a {if $status eq 'affiliate'}class="ecjia-green right-bottom ecjia-green-rf"{else}class="right-bottom ecjia-green-rf"{/if} id="right-bottom" href="{url path='user/account/record' args='status=affiliate'}">{t domain="h5"}推广{/t}</a></li>
        </ul>
    </div>
</div>
{if $status eq ''}
<div><ul class="ecjia-account-record ecjia-list list-short ecjia-user-no-border-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/account/ajax_record'}" data-size="10"></ul></div>
{elseif $status eq 'raply'}
<div><ul class="ecjia-account-record ecjia-list list-short ecjia-user-no-border-b" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/account/ajax_record_raply'}" data-size="10"></ul></div>
{elseif $status eq 'deposit'}
<div><ul class="ecjia-account-record ecjia-list list-short ecjia-user-no-border-b" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/account/ajax_record_deposit'}" data-size="10"></ul></div>
{elseif $status eq 'affiliate'}
<div><ul class="ecjia-account-record ecjia-list list-short ecjia-user-no-border-b" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/account/ajax_record'}&type=affiliate" data-size="10"></ul></div>
{/if}
<!-- {/block} -->

{/nocache}