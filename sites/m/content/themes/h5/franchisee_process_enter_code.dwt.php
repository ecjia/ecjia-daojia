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
<div class="ecjia-address-list">
	<div class="franchisee-search-title ecjia-margin-t">验证码已发送至</div>

	<p class="ecjiaf-tac ecjia-margin-b ecjia-margin-t">手机号<span class="ecjia-color-orange">{$mobile}</span>，<span class="ecjiaf-tac blue resend_sms" data-url="{$resend_url}"></span></p>

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
    
</div>
<!-- {/block} -->
{/nocache}