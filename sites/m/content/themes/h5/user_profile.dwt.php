<?php
/*
Name:  会员中心：编辑个人资料模板
Description:  会员中心：编辑个人资料首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user ecjia-account">
    <div class="ecjia-user ecjia-user-head ecjia-account">
        <ul class="ecjia-list list-short nmargin-t">
            <li class="account-phone">
                <span class="icon-name margin-no-l">{t domain="h5"}头像{/t}</span>
                <div class="user-img-text"><img src="{$user_img}"></div>
            </li>
        </ul>
    </div>

    <div class="ecjia-list list-short">
        <li class="height-3">
            <a href="{url path='user/profile/modify_username'}">
                <span class="icon-name margin-no-l">{t domain="h5"}用户名{/t}</span>
                <span class="icon-price text-color">{$user.name}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
        <li class="ecjia-user-border-b height-3">
            <a>
                <span class="icon-name margin-no-l">{t domain="h5"}用户等级{/t}</span>
                <span class="icon-price text-color">{$user.rank_name}</span>
            </a>
        </li>
    </div>

    <div class="ecjia-list list-short">
        <li>
            <a href='{url path="user/profile/{if $user.mobile_phone}bind_info{else}account_bind{/if}" args="type=mobile"}'>
                <span class="icon-name margin-no-l">{t domain='h5'}绑定手机{/t}</span>
                <span class="icon-price">{if $user.mobile_phone}{$user.mobile_phone}{else}{t domain='h5'}未绑定{/t}{/if}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
        <li>
            <a href='{url path="user/profile/{if $user.email}bind_info{else}account_bind{/if}" args="type=email"}'>
                <span class="icon-name margin-no-l">{t domain='h5'}绑定邮箱{/t}</span>
                <span class="icon-price">{if $user.email}{$user.email}{else}{t domain='h5'}未绑定{/t}{/if}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
        <li>
            <a href='{url path="user/profile/wx_bind_status"}'>
                <span class="icon-name margin-no-l">{t domain='h5'}绑定微信{/t}</span>
                <span class="icon-price">{if $user.wechat_is_bind eq 1}{$user.wechat_nickname}{else}{t domain='h5'}未绑定{/t}{/if}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
    </div>

    <div class="ecjia-list list-short">
        <li>
            <a href="{url path='user/profile/set_pay_password'}">
                <span class="icon-name margin-no-l">{if $user.has_paypassword neq 1}{t domain="h5"}设置{/t}{else}{t domain="h5"}修改{/t}{/if}{t domain="h5"}支付密码{/t}</span>
                {if $user.has_paypassword neq 1}
                <span class="icon-price">{t domain="h5"}未设置{/t}</span>
                {/if}
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
        <li>
            <a href="{url path='user/profile/edit_password'}">
                <span class="icon-name margin-no-l">{t domain="h5"}设置登录密码{/t}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
        {if $available_withdraw_way}
        <li>
            <a href="{url path='user/profile/withdraw'}">
                <span class="icon-name margin-no-l">{t domain="h5"}提现账户{/t}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
        {/if}
        <li>
            <a href="{url path='user/profile/cancel_account'}">
                <span class="icon-name margin-no-l">{t domain="h5"}注销账号{/t}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
    </div>
</div>

<!-- {if !$is_weixin} -->
<div class="ecjia-button-top-list">
    <input class="btn btn-info nopjax external" name="logout" type="submit" data-url="{url path='user/privilege/logout'}" value='{t domain="h5"}退出登录{/t}'>
</div>
<!-- {/if} -->

<!-- {/block} -->
<!-- {/nocache} -->