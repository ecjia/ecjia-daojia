<?php
/*
Name: 用户登录模板
Description: 这是用户登录页
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
<div class="ecjia-form  ecjia-login">
	<div class="form-group margin-right-left">
		<label class="input">
			<input class="p_d0" placeholder='{t domain="h5"}请输入用户名或手机号{/t}' name="username">
		</label>
	</div>
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
			<input class="p_d0" placeholder='{t domain="h5"}密码{/t}' id="password-1" name="password" type="password">
		</label>
	</div>
	<div class="ecjia-login-login-foot ecjia-margin-b">
		<a class="ecjiaf-fr ecjia-margin-t" href="{url path='user/get_password/init'}">{t domain="h5"}忘记密码？{/t}</a>
	</div>
    <div class="around">
        <input type="hidden" name="referer_url" value="{$referer_url}" />
        <input type="button" class="btn btn-info login-btn" name="ecjia-login" value='{t domain="h5"}登录{/t}' data-url="{url path='user/privilege/signin'}"/>
    </div>
    {if $sns_qq eq 1 || $sns_wechat eq 1}
    <p class="ecjiaf-tac other-account">{t domain="h5"}其他帐号登录{/t}</p>
    {/if}
	<ul class="thirdparty-wrap">
		{if $sns_qq eq 1}
    	<a class="nopjax external" href="{url path='connect/index/init' args='connect_code=sns_qq'}"><li class="thirdparty-qq"></li></a>
    	{/if}
    	{if $sns_wechat eq 1}
    	<a href="{$wechat_login_url}"><li class="thirdparty-weixin"></li></a>
    	{/if}
	</ul>
</div>
<!-- {/block} -->