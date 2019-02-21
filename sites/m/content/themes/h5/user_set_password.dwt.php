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
		<li class="active"><a href="#one" role="tab" data-toggle="tab">手机注册</a></li>
		<li><a href="#two" role="tab" data-toggle="tab">邮箱注册</a></li>
	</ul>
    <!-- {/if} -->
        <div class="tab-pane{if $enabled_sms_signin neq 1} active{/if}" id="two">
    		<form class="ecjia-form ecjia-login" name="register" action="{url path='user/privilege/set_password'}" method="post">
    			<input type="hidden" name="flag" id="flag" value="register" />
    			<div class="form-group margin-right-left">
    				<label class="input">
    					<i class="iconfont icon-gerenzhongxin icon-set"></i>
    					<input name="username" type="text" id="username" name="username" autocomplete="off" errormsg="用户名必须为3-15个字符" placeholder="请输入用户名" value="{$user_name}"/>
    				</label>
    			</div>
    			<div>
        			 <ul class="ecjia-login-login-foot m_r0">
        			     <li class="remark-size">请设置登录密码</li>
        			 </ul>
    			</div>

    			<div class="form-group bf margin-right-left">
    				<label class="input">
    					<i class="iconfont icon-unlock"></i>
    					<i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
    					<input name="password" id="password-1" type="password" autocomplete="off" errormsg="请输入6 ~ 16 位的密码" placeholder="请输入密码">
    				</label>
    			</div>
    			
    			{if $invited eq 0}
    			<div>
    				<ul class="ecjia-login-login-foot m_r0 verification">
	        			<label class="ecjia-checkbox">
			      			<input type="checkbox" name="show_verification" value="1" />
			            </label>我有邀请码
		      		</ul>
    			</div>
    			
    			<div class="form-group bf margin-right-left verification_div">
    				<label class="input">
    					<input class="p_d0" name="verification" type="text" errormsg="请输入邀请码" placeholder="请输入邀请码">
    				</label>
    			</div>
    			{/if}
    			
    			<div class="ecjia-login-b">
    				<div class="around margin-top">
    				<button class="btn btn-info login-btn" name="signin" data-url="{$set_url}" id="signin" type="submit">完成</button>
    				</div>
    			</div>
    		</form>
    	</div>
	</div>
<!-- {/block} -->