<?php
/*
Name: 设置支付密码模板
Description: 这是设置支付密码模版页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-user ecjia-form ecjia-user-no-border-b" name="payPassForm" action="{url path='user/profile/check_pay_pass'}" method="post">
	<div class="ecjia-form ecjia-login">
		<p class="ecjiaf-tac ecjia-margin-b">{if !$type}设置6位数字支付密码{else if $type eq 'confirm'}再次确认六位数字支付密码{/if}</p>
		
		<div id="payPassword_container">
			<div class="pass_container">
				<input class="input" type="tel" maxlength="1">  
				<input class="input" type="tel" maxlength="1">
				<input class="input" type="tel" maxlength="1">
				<input class="input" type="tel" maxlength="1">
				<input class="input" type="tel" maxlength="1">
				<input class="input" type="tel" maxlength="1">
			</div>
		</div>
		
		<input type="hidden" name="type" value="{$type}" />
		<input type="hidden" name="url" value="{$url}" />
		
		<p class="ecjiaf-tac">为提供更好的支付体验，请设置由6位数字组合的支付密码</p>

		{if $type eq 'confirm'}
		<div class="ecjia-margin-t3">
			<input type="hidden" name="confirm_password" value="" />
			<input type="hidden" name="not_auto_post" value="1" />
			<input class="btn btn-info" name="submit" type="submit" value="确定" id="account_bind_btn" />
		</div>
		{/if}
	</div>
</form>

<!-- {/block} -->
{/nocache}