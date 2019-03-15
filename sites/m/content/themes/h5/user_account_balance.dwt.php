<?php
/*
Name: 资金管理模板
Description: 资金管理页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user_account.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->


<ul class="ecjia-list ecjia-account">
	<a href="{url path='user/account/record'}">
		<p class="cash_list">{t domain="h5"}交易记录{/t}</p>
	</a>
	<div class="ecjia-nolist ecjia-margin-t5">
		<i class="glyphicon glyphicon-piggy-bank"></i>
		{if $user}
		<span class="nolist-size">{t domain="h5"}可用余额：{/t}<span>{$user.formated_user_money}</span></span>
		{else}
		<p>{t domain="h5"}暂无账单记录{/t}</p>
		{/if}
	</div>
	<div class="two-btn">
		<a href="{url path='user/account/recharge'}" class="btn nopjax external">{t domain="h5"}充值{/t}</a>
		{if $has_withdraw_method}
		<a href="{url path='user/account/withdraw'}" class="btn ecjia-btn-e5 fnUrlReplace">{t domain="h5"}提现{/t}</a>
		{else}
		<a href="javascript:;" class="btn ecjia-btn-e5 withdraw-btn" data-url="{$url}">{t domain="h5"}提现{/t}</a>
		{/if}
	</div>
</ul>

<!-- {/block} -->
<!-- {/nocache} -->