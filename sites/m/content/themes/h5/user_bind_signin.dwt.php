<?php
/*
Name: 第三方登录绑定
Description: 这是登录绑定页
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
<form class="ecjia-form ecjia-login" name="theForm" action="{url path='connect/index/bind_signin_do'}" method="post">
	<div class="form-group margin-right-left">
		<label class="input">
			<i class="iconfont icon-dengluyonghuming"></i>
			<input placeholder="{$lang.name_or_mobile}" name="username" datatype="*3-16|zh2-7" errormsg="用户名错误请重新输入！" nullmsg="请输入用户名户或手机号" />
		</label>
	</div>
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<i class="iconfont icon-lock "></i>
			<i class="iconfont icon-attention ecjia-login-margin-l"  id="password1"></i>
			<input placeholder="{$lang.input_passwd}" name="password" type="password" id="password-1" datatype="*6-16" errormsg="密码错误请重新输入！" nullmsg="请输入密码" />
		</label>
	</div>
	<!-- 判断是否启用验证码{if $enabled_captcha} -->
	<div class="form-group">
		<label class="input captcha-img">
			<i class="iconfont icon-pic"></i>
			<input data-rule='notEmpty' name="captcha" placeholder="{$lang.comment_captcha}" />
			<img src="{url path='captcha/index/init'}" alt="captcha" onClick="this.src='{url path='captcha/index/init'}&t='+Math.random();" />
		</label>
	</div>
	<!--{/if}-->
	<div class="ecjia-login-b ecjia-login-login-foot margin-right-left">
		<a class="ecjiaf-fr ecjia-margin-r ecjia-margin-t" href="{url path='user/get_password/mobile_register'}">{$lang.forgot_password}?</a>
	</div>
	<div class="ecjia-login-b">
	    <div class="around">
	        <input type="hidden" name="connect_code" value="{$connect_code}">
	        <input type="hidden" name="open_id" value="{$open_id}">
            <input type="hidden" name="referer" value="{$smarty.get.referer}" />
            <input type="submit" class="btn btn-info login-btn" value="关联" />
	    </div>	
	</div>
</form>
<!-- {/block} -->
{/nocache}