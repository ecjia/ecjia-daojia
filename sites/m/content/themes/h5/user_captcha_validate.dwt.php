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
    <div class="franchisee-search-title ecjia-margin-t">{t domain="h5"}身份验证，请输入图中验证码{/t}</div>

    <div class="captcha franchisee-img-captcha"><img src="data:image/png;base64,{$captcha_image}"></div>
    <p class="ecjiaf-tac blue refresh_captcha" data-url="{$refresh_url}">{t domain="h5"}看不清，换一张{/t}</p>

    <div class="franchisee-input-captcha">
        <input class="input-captcha" name="code_captcha" placeholder='{t domain="h5"}请输入图形验证码 {/t}' type="text" /><br>
    </div>
    <div class="around">
        <input type="hidden" name="referer_url" value="{$referer_url}" />
        <input type="button" class="btn btn-info login-btn" name="ecjia-captcha-validate" value='{t domain="h5"}验证{/t}' data-url="{$url}"/>
    </div>
</div>
<!-- {/block} -->
<!-- {/nocache} -->
