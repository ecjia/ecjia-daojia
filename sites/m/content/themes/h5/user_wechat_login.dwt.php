<?php
/*
Name: 微信登录模板
Description: 这是微信登录页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-wechat-login">
	<div class="notice">{t domain="h5"}微信一键登录，更方便，更安全{/t}</div>
	<div class="safe-area"><img src="{$theme_url}images/user/safe.png" /></div>
	<a class="external btn nopjax" href="{url path='connect/index/init' args='connect_code=sns_wechat&login_type=snsapi_userinfo'}">
		<li class="thirdparty-weixin"></li>
		<img src="{$theme_url}images/user/wechat.png" />{t domain="h5"}微信登录{/t}
	</a>
    <p class="other-type">{t domain="h5"}使用其他方式登录{/t}</p>
    
    <div class="login-type-list">
    	<div class="type-item">
    		<a href="{$login_url}">
	    		<img src="{$theme_url}images/user/phone_login.png">
	    		<p>{t domain="h5"}手机号{/t}</p>
    		</a>
    	</div>
    	
    	<div class="type-item">
    		<a href="{$pass_login_url}">
	    		<img src="{$theme_url}images/user/user_login.png">
	    		<p>{t domain="h5"}账号密码{/t}</p>
    		</a>
    	</div>
    </div>
</div>
<!-- {/block} -->