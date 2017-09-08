<?php
/*
Name: 资金管理模板
Description: 资金管理页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<ul class="ecjia-list ecjia-account">
	<a href="{url path='user/account/record'}"><p class="cash_list">交易记录</p></a>
	<div class="ecjia-nolist ecjia-margin-t5">
		<i class="glyphicon glyphicon-piggy-bank"></i>
		{if $user}
		<span class="nolist-size">可用余额：<span>{$user.formated_user_money}</span></span>
		{else}
		<p>{t}暂无账单记录{/t}</p>
		{/if}
	</div>
	<div class="two-btn">
		<a  href="{url path='user/account/recharge'}" class="btn nopjax">{t}充值{/t}</a>
		<a  href="{url path='user/account/withdraw'}" class="btn ecjia-btn-e5">{t}提现{/t}</a>
	</div>
</ul>
<!-- {/block} -->