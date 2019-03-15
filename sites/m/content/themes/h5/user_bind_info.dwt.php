<?php
/*
Name:  查看绑定手机号
Description:  查看绑定手机号
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!--{nocache}-->

<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $type eq 'mobile'}
<div class="ecjia-check-info">
    <div class="bind-info">
        <p>{t domain="h5"}已绑：{/t}{$user.mobile_phone}</p>
    </div>
    <div>
        <a class="btn btn-info nopjax external" href="{RC_uri::url('user/profile/account_bind')}&type=mobile&status=change">{t domain="h5"}更换手机号{/t}</a>
    </div>
</div>
{elseif $type eq 'email'}
<div class="ecjia-check-info">
    <div class="bind-info">
        <p>{t domain="h5"}已绑：{/t}{$user.email}</p>
    </div>
    <div>
        <a class="btn btn-info nopjax external" href="{RC_uri::url('user/profile/account_bind')}&type=email&status=change">{t domain="h5"}更换邮箱号{/t}</a>
    </div>
</div>
{elseif $type eq 'wechat'}

<form class="ecjia-user ecjia-form ecjia-user-no-border-b" name="accountBind" action="{$form_url}" method="post">
    <div class="ecjia-check-info">
        <div class="bind-info">
            <p>
                <!--{if $user.wechat_is_bind eq 1}-->
                    <!--{if $user.wechat_nickname}-->
                        {t domain="h5"}已绑：{/t}<!--{$user.wechat_nickname}-->
                    <!--{else}-->
                        {t domain="h5"}已绑定{/t}
                    <!--{/if}-->
                <!--{else}-->
                    {t domain="h5"}暂未绑定{/t}
                <!--{/if}-->
            </p>
        </div>

        {if $user.wechat_is_bind eq 1}
        <div class="ecjia-input">
            <div class="input-li b_b b_t">
                {if $user.mobile_phone}
                <span class="input-fl">{t domain="h5"}手机号码{/t}</span>
                <span class="mobile_phone">{$user.mobile_phone}</span>
                <input class="get_code" type="button" id="get_code" value='{t domain="h5"}获取验证码{/t}' data-url="{url path='user/profile/get_code'}&type=user_unbind_connect" />
                <input type="hidden" name="mobile" value="{$user.mobile_phone}" />
                {else}
                <span class="input-fl">{t domain="h5"}手机号码{/t}</span>
                <span class="mobile_phone">{t domain="h5"}请先去绑定手机号{/t}</span>
                <div class="bind_notice"><a class="external nopjax" href="{RC_Uri::url('user/profile/account_bind')}&type=mobile">{t domain="h5"}去绑定{/t}</a></div>
                {/if}
            </div>

            <div class="input-li">
                <span class="input-fl">{t domain="h5"}验证码{/t}</span>
                <input class="text_left" type="text" name="smscode" placeholder='{t domain="h5"}请输入手机验证码{/t}' value=""/>
            </div>
        </div>
        {/if}

        <div class="ecjia-margin-t2">
            <!--{if $user.wechat_is_bind eq 1}-->
            <input class="btn btn-info" name="submit" type="submit" value='{t domain="h5"}解绑微信{/t}'>
            <!--{else}-->
            <a class="btn btn-info nopjax external" href='{url path="connect/index/authorize" args="connect_code=sns_wechat"}'>{t domain="h5"}去绑定{/t}</a>
            <!--{/if}-->
        </div>
    </div>
    <input type="hidden" name="type" value="unbind_wechat">
</form>

{/if}
<!-- {/block} -->

<!--{/nocache}-->