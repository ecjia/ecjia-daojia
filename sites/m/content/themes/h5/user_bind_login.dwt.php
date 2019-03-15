<?php
/*
Name: 安全问题找回密码模板
Description: 安全问题找回密码页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-login">
    <div class="user-img"><img src="{$user_img}"></div>
    <div class="ecjia-margin-l">
        <p class="p-top3 text-size">
        <span class="text-color">{t domain="h5"}亲爱的{/t}{if $connect_code eq 'sns_qq'}QQ{else if $connect_code eq 'sns_wechat'}{t domain="h5"}微信{/t}{/if}{t domain="h5"}用户：{/t}</span>
        <span><big>{$user_name}</big></span>
        </p>
        <p class="text-size">{t domain="h5"}为了给您更多的福利，请关联一个账号{/t}</p>
    </div>
	<div class="ecjia-login-b ecjia-margin-b ecjia-margin-t">
	    <p class="select-title ecjia-margin-l ">{t domain="h5"}还没有账号？{/t}</p>
        <a href="{$data.login_url}" class="btn">{t domain="h5"}快速注册{/t}</a>
	</div>
	<div class="ecjia-login-b ecjia-margin-t">
	    <p class="select-title ecjia-margin-l ">{t domain="h5"}已有账号{/t}</p>
        <a href="{$data.bind_url}" class="btn btn-hollow">{t domain="h5"}立即关联{/t}</a>
	</div>
</div>
<!-- {/block} -->
{/nocache}