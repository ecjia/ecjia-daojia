<?php 
/*
Name: 红包模板
Description: 红包页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
    <!--{foreach from=$bonus item=item}-->
	<li class="ecjia-margin-b list-l-size">
		<div class="user-bonus-info {if $item.label_status eq '未使用'}user-bonus-head{else}user-bonus-head-expired{/if}">
			<div {if $item.status eq 'allow_use'} class="type-l"{else}class="type-l color-3a"{/if}">
			    <span class="bonus-amount">{$item.formatted_bonus_amount}</span><br>
			    {if $item.seller_id eq 0}
			    <span class="bonus-store">{t domain="h5"}全场通用{/t}</span>
			    {else}
			    <span class="bonus-store">{t domain="h5" 1={$item.seller_name}}指定%1店铺使用{/t}</span>
			    {/if}
			</div>
			<div  {if $item.status eq 'allow_use'} class="type-r"{else}class="type-r color-3a"{/if}>
			    <div {if $item.status eq 'expired'}class="img-is-used"{elseif $item.status eq 'is_used'}class="img-expired"{else}class=""{/if}></div>
				<p class="type-name">{$item.bonus_name}</p>
				<p class="min_goods_amount">{t domain="h5" 1={$item.formatted_request_amount}}满%1使用{/t}</p>
				<p class="type-date">{$item.formatted_start_date}{'-'}{$item.formatted_end_date}</p>
			</div>
		</div>
	</li>
	<!-- {foreachelse} -->
	<div class="ecjia-user-bonus">
		<div class="ecjia-nolist">{t domain="h5"}暂无红包{/t}</div>
	</div>
	<!--{/foreach}-->
<!-- {/block} -->
{/nocache}