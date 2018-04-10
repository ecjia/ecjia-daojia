<?php
/*
Name: 手机登录模板
Description: 这是手机登录页
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
<div class="ecjia-form ecjia-login">
	<div class="form-group margin-right-left">
		<label class="input">
			<span class="roaming">+86</span>
			<input placeholder="手机号" name="mobile_phone" class="mobile_phone">
		</label>
	</div>
    <div class="around">
        <input type="hidden" name="referer_url" value="{$smarty.get.referer_url}" />
        <input type="button" class="btn btn-info login-btn" name="ecjia-mobile-login" value="{$lang.login}" data-url="{url path='user/privilege/mobile_login'}"/>
    </div>
    <p class="ecjiaf-tac">未注册手机验证后自动注册登录，享新人好礼</p>
    
    {if $sns_qq eq 1 || $sns_wechat eq 1}
    <p class="ecjiaf-tac other-account">其他账号登录</p>
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