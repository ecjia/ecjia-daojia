<?php
/*
Name: 显示注册页面模板
Description: 显示注册页面首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
<form class="ecjia-login" action="{url path='user/get_password/mobile_register'}" method="post">
    <div class="ecjia-form">
        <div class="form-group margin-right-left">
    		<label class="input-1">
    			<input name="mobile" type="text" placeholder='{t domain="h5"}请输入用户名或手机号{/t}'>
    		</label>
    	</div>
        <p class="text-st">{t domain="h5"}请输入收到的短信验证码{/t}</p>
    	<div class="form-group small-text">
    		<label class="input-1">
    			<input name="code" type="text" id="code" placeholder='{t domain="h5"}输入验证码{/t}' />
    		</label>
    	</div>
    	<div class="small-submit">
    	    <input name="mobile1" type="hidden" value={$mobile} />
            <input type="button" class="btn login-btn" value='{t domain="h5"}获取验证码{/t}' name="get_code" data-url="{url path='user/get_password/mobile_register_account'}" id="get_code" />
        </div>
    	 <div class="around">
	       <input class="btn btn-info login-btn ecjia-login-margin-top" id="mobile_register" name="mobile_register" type="submit" data-url="{RC_Uri::url('user/get_password/mobile_register')}" value='{t domain="h5"}下一步{/t}' />
    	 </div>
	 </div> 
</form>
<!-- {/block} -->