<?php
/*
Name: 找回密码设置新密码模板
Description: 这是设置新密码
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
<form class="ecjia-form  ecjia-login" name="reset_password" action="{url path='user/get_password/reset_password'}" method="post">
	<div class="form-group margin-right-left">
		<label class="input">
			<i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
			<input class="padding-left05" id="password-1" placeholder="{$lang.input_new_password}" name="passwordf" type="password" errormsg="密码错误请重新输入！" autocomplete="off" />
		</label>
	</div>
	<div class="form-group ecjia-login-margin-top margin-right-left">
		<label class="input">
			<i class="iconfont icon-attention ecjia-login-margin-l show-password" id="password2"></i>
			<input class="padding-left05" id="password-2" type="password" errormsg="密码错误请重新输入！" name="passwords" placeholder="{$lang.input_new_password_again}"/>
		</label>
	</div>
	<div class="ecjia-login-b ecjia-login-margin-top">
	    <div class="around">
            <input type="submit" name="reset_password" class="btn btn-info login-btn" data-url="{RC_Uri::url('user/get_password/reset_password')}" value="{$lang.login_finish}" />
	    </div>	
	</div>
</form>
<!-- {/block} -->
