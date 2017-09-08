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
        <span class="text-color">亲爱的{if $connect_code eq 'sns_qq'}QQ{else if $connect_code eq 'sns_wechat'}微信{/if}用户：</span>
        <span><big>{$user_name}</big></span>
        </p>
        <p class="text-size">为了给您更多的福利，请关联一个账号</p>
    </div>
	<div class="ecjia-login-b ecjia-margin-b ecjia-margin-t">
	    <p class="select-title ecjia-margin-l ">还没有账号？</p>
        <a href="{$data.login_url}" class="btn">快速注册</a>
	</div>
	<div class="ecjia-login-b ecjia-margin-t">
	    <p class="select-title ecjia-margin-l ">已有账号</p>
        <a href="{$data.bind_url}" class="btn btn-hollow">立即关联</a>
	</div>
</div>
<!-- {/block} -->
{/nocache}