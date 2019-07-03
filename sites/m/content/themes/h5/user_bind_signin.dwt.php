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
			<input placeholder='{t domain="h5"}请输入用户名或手机号{/t}' name="username" datatype="*3-16|zh2-7" errormsg='{t domain="h5"}手机号错误请重新输入！{/t}' nullmsg='{t domain="h5"}请输入手机号{/t}' />
		</label>
	</div>
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<i class="iconfont icon-lock "></i>
			<i class="iconfont icon-attention ecjia-login-margin-l"  id="password1"></i>
			<input placeholder='{t domain="h5"}请输入密码{/t}' name="password" type="password" id="password-1" datatype="*6-16" errormsg='{t domain="h5"}密码错误请重新输入！{/t}' nullmsg='{t domain="h5"}请输入密码{/t}' />
		</label>
	</div>
	<!-- 判断是否启用验证码{if $enabled_captcha} -->
	<div class="form-group">
		<label class="input captcha-img">
			<i class="iconfont icon-pic"></i>
			<input data-rule='notEmpty' name="captcha" placeholder='{t domain="h5"}验证码{/t}' />
			<img src="{url path='captcha/index/init'}" alt="captcha" onClick="this.src='{url path='captcha/index/init'}&t='+Math.random();" />
		</label>
	</div>
	<!--{/if}-->
	<div class="ecjia-login-b ecjia-login-login-foot margin-right-left">
		<a class="ecjiaf-fr ecjia-margin-r ecjia-margin-t" href="{url path='user/get_password/mobile_register'}">{t domain="h5"}忘记密码？{/t}</a>
	</div>
	<div class="ecjia-login-b">
	    <div class="around">
	        <input type="hidden" name="connect_code" value="{$connect_code}">
	        <input type="hidden" name="open_id" value="{$open_id}">
            <input type="hidden" name="referer" value="{$referer}" />
            <input type="submit" class="btn btn-info login-btn" value='{t domain="h5"}关联{/t}' />
	    </div>	
	</div>
</form>
<!-- {/block} -->
{/nocache}