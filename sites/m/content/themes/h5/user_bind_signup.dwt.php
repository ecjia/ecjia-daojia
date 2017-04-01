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
<div class="user-register">
    <div class="tab-pane{if $enabled_sms_signin neq 1} active{/if}" id="two">
		<form class="ecjia-form ecjia-login" name="theForm" action="{url path='connect/index/bind_signup_do'}" method="post">
			<input type="hidden" name="flag" id="flag" value="register" />
			<div class="form-group ecjia-margin-t margin-right-left">
				<label class="input">
					<i class="iconfont icon-mobilefill icon-set"></i>
					<input type="text" name="mobile" id="mobile" datatype="m" errormsg="手机号格式不正确" placeholder="请输入手机号" />
				</label>
			</div>
			<div class="form-group small-text ecjia-margin-t">
				<label class="input-1">
					<input name="code" type="text" datatype="n6-6" errormsg="请输入正确格式的验证码" placeholder="{$lang.input_verification}" />
				</label>
			</div>
			<div class="small-submit ecjia-margin-t">
                    <input type="hidden" name="referer" value="{$smarty.get.referer}" />
                    <span><input type="button" class="btn btn-info login-btn" value="{$lang.return_verification}"  data-url="{url path='user/privilege/signup'}" id="get_code"  /></span>
        	</div>
			<div class="form-group bf margin-right-left five-margin-top">
				<label class="input">
					<i class="iconfont icon-yanzhengma"></i>
					<input name="verification" id="verification" type="text" datatype="*6-10" placeholder="邀请码6位数字或字母" errormsg="邀请码6位数字或字母" ignore="ignore">
				</label>
			</div>
			<div class="form-group ecjia-margin-t margin-right-left">
				<label class="input">
					<i class="iconfont icon-dengluyonghuming"></i>
					<input name="username" id="username" type="text" value="" datatype="*3-16|zh2-7" placeholder="请输入用户名" errormsg="用户名不正确">
				</label>
			</div>
			<div class="form-group ecjia-margin-t margin-right-left">
				<label class="input">
					<i class="iconfont icon-unlock"></i>
					<i class="iconfont icon-attention ecjia-login-margin-l"></i>
					<input name="password" id="password1" type="password" datatype="*6-16" placeholder="请输入密码" errormsg="请输入6-16位密码">
				</label>
			</div>
			<div class="ecjia-login-b ">
				<input name="connect_code" type="hidden" value="{$connect_code}" />
				<input name="open_id" type="hidden" value="{$open_id}" />
				<input type="hidden" name="back_act" value="{$back_act}" />
				<div class="around margin-top">
				<button class="btn btn-info login-btn" type="submit">{t}注册并关联{/t}</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->
{/nocache}