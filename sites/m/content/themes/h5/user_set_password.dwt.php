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
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="user-register">
    <!--{if $enabled_sms_signin eq 1} 支持手机短信功能-->
	<ul class="ecjia-list ecjia-list-two ecjia-nav" role="tablist">
		<li class="active"><a href="#one" role="tab" data-toggle="tab">{$lang.mobile_login}</a></li>
		<li><a href="#two" role="tab" data-toggle="tab">{$lang.emaill_login}</a></li>
	</ul>
    <!-- {/if} -->
        <div class="tab-pane{if $enabled_sms_signin neq 1} active{/if}" id="two">
    		<form class="ecjia-form ecjia-login" name="register" action="{url path='user/privilege/set_password'}" method="post">
    			<input type="hidden" name="flag" id="flag" value="register" />
    			<div class="form-group margin-right-left">
    				<label class="input">
    					<i class="iconfont icon-gerenzhongxin icon-set"></i>
    					<input name="username" type="text" id="username" name="username" errormsg="{$lang.msg_mast_length}" placeholder="{$lang.input_name}" />
    				</label>
    			</div>
    			<div>
        			 <ul class="ecjia-login-login-foot">
        			     <li class="remark-size">{$lang.set_your_password}</li>
        			 </ul>
    			</div>

    			<div class="form-group bf margin-right-left">
    				<label class="input">
    					<i class="iconfont icon-unlock"></i>
    					<i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
    					<input name="password" id="password-1" type="password" errormsg="请输入6 ~ 16 位的密码" placeholder="{$lang.input_passwd}">
    				</label>
    			</div>
    			<div class="ecjia-login-b">
    				<div class="around margin-top">
    				<button class="btn btn-info login-btn" name="signin" data-url="{RC_Uri::url('user/index/set_password')}" type="submit">{$lang.login_finish}</button>
    				</div>
    			</div>
    		</form>
    	</div>
	</div>
<!-- {/block} -->