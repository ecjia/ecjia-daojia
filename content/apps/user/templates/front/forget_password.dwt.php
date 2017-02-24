<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="{$keywords}" />
<meta name="Description" content="{$description}" />
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
<title>{$page_title}</title>
<link href="{$front_url}/app.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<!-- {if $error_msg} -->
	<div class="error_msg">
		<span>{t}{$error_msg}{/t}</span>
	</div>
	<!--{/if}-->
	
	<!--*找回密码界面  start-->
	<!--{if $action eq 'forget_pwd'} -->
	<div class="forget-password">
		<form action="{url path='user/get_password/check_userinfo'}" method="post" name="getPassword">
	        <ul>
	        	<li>
	        		<input class="text-type" name="user_name" autocomplete="off" type="text" placeholder="{if $type eq 'mobile'}{t}请输入您注册时的手机号{/t}{else}{t}请输入您注册时的用户名{/t}{/if}"/>
	        		<span class="display-none cancel-btn"><img src="{$front_url}/images/cancel.png"/></span>
	        	</li>
	        	<!-- {if $type neq 'mobile'} -->
	        	<li>
	        		<input class="text-type" name="email" type="text" placeholder="{t}请输入您注册时的邮件地址{/t}"  autocomplete="off"/>
	        		<span class="display-none cancel-btn"><img src="{$front_url}/images/cancel.png"/></span>
	        	</li>
	        	<!-- {/if} -->
	        	<!-- {if $captcha_url} -->
	        	<li>
	        		<input class="text-type-code" name="captcha" type="text" placeholder="{t}验证码{/t}"/>
	        		<img class="captcha-img" data-src="{$captcha_url}" data-toggle="change_captcha" alt="captcha" src="{$captcha_url}" name="media-boject" />
	        	</li>
	        	<!-- {/if} -->
	        </ul>
	        <div class="app-button">
	        	<input type='hidden' value='{$type}' name='type'/>
        		<button class="button" type="submit" name="submit">{t}下一步{/t}</button>
	        </div>
		</form>
	</div>
	<!--{/if}-->
	<!--*找回密码界面  end-->
	
	<!-- *选择找回密码方式界面 start -->
	<!--{if $action eq 'editpassword_method'} -->
	<div class="forget-password">
		<div class="content">
			{t}基于对您当前的操作环境的检测，请选择以下任一种方式进行校验{/t}
		</div>
		<ul>
			<li>
				<button data-href="{url path='user/get_password/reset_pwd_mail'}" class="choose">
				{t}验证电子邮箱{/t}
				</button>
			</li>
			<!--{if $passwd_answer}-->
			<li>
				<button data-href="{url path='user/get_password/reset_pwd_question'}" class="choose">
					{t}回答安全保护问题{/t}
				</button>
			</li>
			<!--{/if}-->
		</ul>
	</div>
	<!--{/if}-->
	<!-- *选择找回密码方式界面 end -->

	<!-- *通过发送邮件校验码找回账号方式界面 start -->
	<!-- {if $action eq 'reset_pwd_mail'} -->
	<div class="forget-password">
		<div class="content">
			<!-- {if $type neq 'email'} -->
			{t}验证码已发送到您的手机{/t}
			<!-- {else} -->
			{t}验证码已发送到您的邮箱{/t}
			<!-- {/if} -->
		</div>
		<div class="content">
			{$email_msg}
		</div>
		<form action="{url path='user/get_password/check_code'}" method="post" name='checkcode'>
			<ul>
				<li>
					<input class="text-type-code" name="code" type="text" placeholder="{t}校验码{/t}"/>
					<span class="code-span" data-time="60">60秒后重发</span>
					<span class="code-repeat display-none" data-url='{url path="user/get_password/reset_pwd_mail_repeat" args="type={$type}"}'>重发校验码</span>
				</li>
			</ul>
			<div class="app-button">
				<input type='hidden' value="{$type}" name='type'/>
	        	<button class="disabled-btn" type="submit" name="submit" disabled="true">{t}下一步{/t}</button>
			</div>
		</form>
		<!-- {if $type eq 'email'} -->
		<div class="change_request">
    		<a href="{url path='user/get_password/change_reset_pwd'}">{t}选择其它校验方式{/t}</a>
    	</div>
    	<!-- {/if} -->
	</div>
	<!--{/if}-->
	<!-- *通过发送邮件校验码找回账号方式界面 end -->
	
	<!--*通过问题找回密码的确认找回账号界面      暂时没用到 -->
    <!--{if $action eq 'qpassword_name'} -->
    <div class="forget-password">
    	<div class="title-content">
    		<strong>{t}请输入您注册的用户名以取得您的密码提示问题。{/t}</strong>
    	</div>
    	<form action="{url path='user/get_password/get_passwd_question'}" method="post">
    		<ul>
    			<li>
    				<input class="text-type" name="user_name" autocomplete="off" type="text" placeholder="{t}用户名{/t}"/>
    				<span class="display-none cancel-btn"><img src="{$front_url}/images/cancel.png"/></span>
    			</li>
    		</ul>
    		<div class="app-button">
        		<input class="button" type="submit" name="submit" value="{t}下一步{/t}" />
	        </div>
    	</form>
    </div>
	<!--{/if}-->

	<!--*根据输入账号显示密码问题界面 -->
    <!--{if $action eq 'reset_pwd_question'} -->
    <div class="forget-password">
    	<div class="content">
    		{$passwd_question}<!-- 请根据您注册时设置的密码问题输入设置的答案 -->
    	</div>
    	<form action="{url path='user/get_password/check_answer'}" method="post" name="getPassword">
    		<ul>
    			<li>
    				<input class="text-type" name="passwd_answer" type="text" placeholder="{t}填入答案{/t}"/>
    				<span class="display-none cancel-btn"><img src="{$front_url}/images/cancel.png"/></span>
    			</li>
    			<!-- 判断是否启用验证码{if $enabled_captcha} -->
    			<li>
    				<input type="text" size="8" name="captcha" class="inputBg" />
    				<img src="index.php?m=main&c=captchas&a=init&is_login=1&{$rand}" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='index.php?m=main&c=captchas&a=init&is_login=1&'+Math.random()" />
    			</li>
    			<!--{/if}-->
    		</ul>
    		<div class="app-button">
    			<button class="disabled-btn" type="submit" name="submit" disabled="true">{t}下一步{/t}</button>
    		</div>
    	</form>
    	<div class="change_request">
    		<a href="{url path='user/get_password/change_reset_pwd'}">{t}选择其它校验方式{/t}</a>
    	</div>
    </div>
    <!--{/if}-->

	<!-- {if $action eq 'reset_pwd_form'} -->
	<div class="forget-password">
		<div class="title-content">
    		<strong>{t}新登录密码仅用于本店账户登录{/t}</strong>
    	</div>
    	<form action="{url path='user/get_password/reset_pwd'}" method="post" name="reset_pwd_form">
    		<ul>
    			<li>
    				<input class="text-type" name="new_password" type="password" placeholder="{t}新密码{/t}" autocomplete="off" />
    				<span class="display-none cancel-btn"><img src="{$front_url}/images/cancel.png"/></span>
    			</li>
    			<li>
    				<input class="text-type" name="confirm_password" type="password" placeholder="{t}确认密码{/t}" autocomplete="off" />
    				<span class="display-none cancel-btn"><img src="{$front_url}/images/cancel.png"/></span>
    			</li>
    		</ul>
    		<div class="explain-content">
    			{t}密码由6-20位英文字母、数字或者符号组成{/t}
    		</div>
    		<div class="show-password">
    			<span data-img="{$front_url}"><img src="{$front_url}/images/empty_circle.png"/></span>&nbsp;{t}显示密码{/t}
    		</div>
    		<div class="app-button">
	            <input type="hidden" name="uid" value="{$uid}" />
	            <input type="hidden" name="code" value="{$code}" />
        		<button class="button" type="submit" name="submit">{t}下一步{/t}</button>
	        </div>
    	</form>
	</div>
	<!--{/if}-->

	
	<!-- {if $action eq 'success'} -->
	<div class="forget-password">
		<div class="title-content success">
			<p><img src="{$front_url}/images/success.png"/></p>
    		<p><strong>{t}密码修改成功，请返回重新登录！{/t}</strong></p>
    	</div>
    </div>
	<!--{/if}-->
	<!--#找回密码界面 end-->
	
<!-- {* 包含脚本文件 *} -->
<script src="{$front_url}/js/jquery.min.js" type="text/javascript"></script>
<script src="{$ecjia_js}" type="text/javascript"></script>

<script src="{$front_url}/js/ecjia-front.js" type="text/javascript"></script>
<script src="{$front_url}/js/forget_password.js" type="text/javascript"></script>

<script type="text/javascript">
	ecjia.front.get_password.init();
</script>

</body>
</html>
