<?php
/*
Name: 商家入驻查询验证码模板
Description: 这是商家入驻查询验证码页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.franchisee.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-form ecjia-login">
	<p class="ecjiaf-tac ecjia-margin-b">已发送验证码到{$mobile}</p>

	<div id="payPassword_container">
		<div class="franchisee_pass_container">
			<input class="input" type="tel" maxlength="1">  
			<input class="input" type="tel" maxlength="1">
			<input class="input" type="tel" maxlength="1">
			<input class="input" type="tel" maxlength="1">
			<input class="input" type="tel" maxlength="1">
			<input class="input" type="tel" maxlength="1">
		</div>
	</div>
	
	<input type="hidden" name="url" value="{$url}" />
	<input type="hidden" name="mobile" value="{$mobile}" />
    <p class="ecjiaf-tac blue resend_sms" data-url="{$resend_url}">重新发送验证码</p>
</div>
<!-- {/block} -->
{/nocache}