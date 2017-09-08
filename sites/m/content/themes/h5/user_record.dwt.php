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
        	<li><a {if $smarty.get.status eq ''}class="ecjia-green left-bottom ecjia-green-rf"{else}class="left-bottom ecjia-green-rf"{/if} id="left-bottom" href="{url path='user/account/record' args='status='}">{t}全部{/t}</a></li>
        	<li><a {if $smarty.get.status eq 'raply'}class="ecjia-green ecjia-green-rf"{else}class="ecjia-green-rf"{/if} href="{url path='user/account/record' args='status=raply'}">{t}提现{/t}</a></li>
        	<li><a {if $smarty.get.status eq 'deposit'}class="ecjia-green right-bottom ecjia-green-rf"{else}class="right-bottom ecjia-green-rf"{/if} id="right-bottom" href="{url path='user/account/record' args='status=deposit'}">{t}充值{/t}</a></li>
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
    <!-- {foreach from=$sur_amount key=key item=group} -->
	<p class="record-time record-time-{$key}">{if $key eq $now_mon}{'本月'}{else}{$key}{'月'}{/if}</p>
	<div class="record-list account-record-list" >
		<ul>
		{foreach from=$group item=item}
			<li class="record-single">
			<a href="{RC_Uri::url('user/account/record_info')}&account_id={$item.account_id}&format_amount={$item.format_amount}&pay_status={$item.pay_status}&type={$item.type}&type_lable={$item.type_lable}&add_time={$item.add_time}&payment_id={$item.payment_id}&payment_name={$item.payment_name}&amount={$item.amount}&order_sn={$item.order_sn}">
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
    <!-- {foreachelse} -->
	<div class="ecjia-nolist">
		<div class="img-norecord">暂无明细记录</div>
	</div>
	<!--{/foreach}-->
<!-- {/block} -->
{/nocache}