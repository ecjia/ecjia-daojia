<?php 
/*
Name: 红包模板
Description: 红包页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
var bonus_sn_error = '{$lang.bonus_sn_error}';
var bonus_sn_empty = '{$lang.bonus_sn_empty}';
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<ul class="ecjia-list ecjia-list-three ecjia-bonus ecjia-bonus-top-head ecjia-nav ecjia-bonus-border-right">
	<li {if $smarty.get.status eq 'allow_use'} class="red-bottom"{elseif $smarty.get.status eq ''}class="red-bottom"{else}class=''{/if}><a {if $smarty.get.status eq 'allow_use'} class="red-font"{elseif $smarty.get.status eq ''}class="red-font"{else}class=""{/if} href="{url path='user/bonus/init' args='status=allow_use'}">{t}可使用{/t}</a></li>
	<li {if $smarty.get.status eq 'is_used'} class="red-bottom"{else}class=""{/if}><a {if $smarty.get.status eq 'is_used'} class="red-font"{else}class=""{/if} href="{url path='user/bonus/init' args='status=is_used'}">{t}已使用{/t}</a></li>
	<li {if $smarty.get.status eq 'expired'} class="red-bottom"{else}class=""{/if}><a {if $smarty.get.status eq 'expired'} class="red-font right-border"{else}class="right-border"{/if} href="{url path='user/bonus/init' args='status=expired'}">{t}已过期{/t}</a></li>
</ul>
<div class="ecjia-bonus bonus_explain">
    <a href="{$bonus_readme_url}">使用说明</a> 
</div>
{if $smarty.get.status eq 'allow_use'}
<ul class="ecjia-bouns-list ecjia-margin-t ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/bonus/async_allow_use'}" data-size="10"></ul>
{elseif $smarty.get.status eq 'is_used'}
<ul class="ecjia-bouns-list ecjia-margin-t ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/bonus/async_is_used'}" data-size="10"></ul>
{elseif $smarty.get.status eq 'expired'}
<ul class="ecjia-bouns-list ecjia-margin-t ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/bonus/async_expired'}" data-size="10"></ul>
{elseif $smarty.get.status eq ''}
<ul class="ecjia-bouns-list ecjia-margin-t ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/bonus/async_allow_use'}" data-size="10"></ul>
{/if}
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
    <!--{foreach from=$bonus item=item}-->
	<li class="ecjia-margin-b list-l-size">
		<div class="user-bonus-info {if $item.label_status eq '未使用'}user-bonus-head{else}user-bonus-head-expired{/if}">
			<div {if $item.status eq 'allow_use'} class="type-l"{else}class="type-l color-3a"{/if}">
			    <span class="bonus-amount">{$item.formatted_bonus_amount}</span><br>
			    {if $item.seller_name == ''}
			    <span class="bonus-store">全场通用</span>
			    {else}
			    <span class="bonus-store">指定{$item.seller_name}店铺使用</span>
			    {/if}
			</div>
			<div  {if $item.status eq 'allow_use'} class="type-r"{else}class="type-r color-3a"{/if}>
			    <div {if $item.status eq 'expired'}class="img-is-used"{elseif $item.status eq 'is_used'}class="img-expired"{else}class=""{/if}></div>
				<p class="type-name">{$item.bonus_name}</p>
				<p class="min_goods_amount">满{$item.formatted_request_amount}使用</p>
				<p class="type-date">{$item.formatted_start_date}{'-'}{$item.formatted_end_date}</p>
			</div>
		</div>
	</li>
	<!-- {foreachelse} -->
	<div class="ecjia-user-bonus">
		<div class="ecjia-nolist">暂无红包</div>
	</div>
	<!--{/foreach}-->
<!-- {/block} -->
{/nocache}