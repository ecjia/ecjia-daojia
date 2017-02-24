<?php
/*
Name: 账户提现模板
Description: 账户提现页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<form class="ecjia-account ecjia-form user-profile-form" action="{url path='user/account/withdraw_account'}" method="post">
	<p class="account-top text-ty">{t}账户余额：{$user.formated_user_money}{/t}</p>
	<div class="form-group form-group-text account-lr-fom no-border">
		<label class="input">
			<span>{t}金额{/t}</span>
			<input placeholder="{t}建议提现100元以上的金额{/t}" name="amount" value="" />
		</label>
	</div>
	<div class="account-top2">
	    <p1 class="text-ty">备注：（最长100个字）</p1>
		<div class="form-group form-group-text ecjia-withdraw">
		<textarea  class="textarea-style" name="user_note"></textarea>
		</div>
		<input name="act" type="hidden" value="profile" />
		<div class="text-center account-top2">
			<input class="btn btn-info" name="submit" type="submit" value="{t}提现申请{/t}" />
		</div>
	</div>	
</form>
<!-- {/block} -->
