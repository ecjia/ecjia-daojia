<?php
/*
Name: 图形验证码模板
Description: 这是图形验证码页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
<div class="ecjia-form ecjia-login">
	<div class="form-group margin-right-left">
		<label class="input">
			<span class="captcha"><img src="data:image/png;base64,{$captcha_image}"></span>
			<input type="text" placeholder='{t domain="h5"}请输入左侧验证码{/t}' name="code_captcha" class="code_captcha">
		</label>
	</div>
    <div class="around">
        <input type="hidden" name="referer_url" value="{$smarty.get.referer_url}" />
        <input type="button" class="btn btn-info login-btn" name="ecjia-captcha-validate" value='{t domain="h5"}验证{/t}' data-url="{$url}"/>
    </div>
    <p class="ecjiaf-tac blue refresh_captcha" data-url="{$refresh_url}">{t domain="h5"}看不清，换一张{/t}</p>
</div>
<!-- {/block} -->
<!-- {/nocache} -->
