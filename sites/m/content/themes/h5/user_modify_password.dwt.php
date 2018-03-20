<?php
/*
Name: 显示注册页面模板
Description: 显示注册页面首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.user.init();
    ecjia.touch.user.submitForm();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
<form class="ecjia-form ecjia-login background-fff" name="theForm" action="{url path='user/profile/modify_password'}" method="post">
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<img src="{$theme_url}images/user/user.png">
			<input type="text" name="mobile" id="mobile" value="{$mobile}" readonly/>
		</label>
	</div>
	
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input p_r7">
			<img src="{$theme_url}images/user/code.png">
			<input type="tel" name="code" id="code" placeholder="请输入验证码" max-length="6" />
		</label>
		<input type="button" class="btn get-code" id="get_code" data-url='{url path="user/profile/get_sms_code"}' data-time="60" value="获取验证码" />
	</div>
	
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<img src="{$theme_url}images/user/password.png">
			<input type="text" onfocus="this.type='password'" name="password" placeholder="请设置密码" />
		</label>
	</div>
	
	<p class="notice">密码为6-20位，为了安全请不要使用过于简单的密码</p>
	
	<div class="ecjia-login-b">
		<div class="around">
			<button class="btn btn-info login-btn" type="submit">提交</button>
		</div>
	</div>
</form>
<!-- {/block} -->
{/nocache}