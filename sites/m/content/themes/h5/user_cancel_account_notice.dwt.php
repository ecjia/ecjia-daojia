<?php
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-cancel-account">
    <div class="content">
        <img class="ecjia-user-avatar" src="{$theme_url}images/order_status/cannot_confirm_2.png" />
        <div class="info">已提交注销</div>
    </div>
    <div class="cancel-notice s">为了您的账户安全，我们将会给您30日的“后悔期”，即先将您的账户锁定30日，30日后，如您未提出异议或未重新点击下方按钮“激活账号”，我们将注销您的账户，账户一旦被注销将不可恢复。</div>

    <div class="lefttime" data-time='{$user.delete_time}'>
        <span>剩余时间：</span>
        <span class="days"></span>天
        <em>:</em>
        <span class="hours"></span>
        <em>:</em>
        <span class="minutes"></span>
        <em>:</em>
        <span class="seconds"></span>
    </div>

</div>
<button class="btn confirm-activate-account">激活账号</button>

<input type="hidden" name="check_mobile" value="{RC_Uri::url('user/profile/check_mobile')}&type=user_activate_account" />
<input type="hidden" name="confirm_cancel_account" value="{RC_Uri::url('user/profile/confirm_activate_account')}" />

<div class="ecjia-cancelAccount-modal">
    <div class="modal-inners">
        <span class="ecjia-close-modal-icon"><i class="iconfont icon-close"></i></span>
        <div class="modal-title">验证手机号</div>
        <div class="modal-title-notice">请输入手机{$user.str_mobile_phone}收到的验证码</div>
        <div id="payPassword_container">
            <div class="pass_container">
                <input class="input" type="tel" maxlength="1" tableindex=0 />
                <input class="input" type="tel" maxlength="1" tableindex=1 />
                <input class="input" type="tel" maxlength="1" tableindex=2 />
                <input class="input" type="tel" maxlength="1" tableindex=3 />
                <input class="input" type="tel" maxlength="1" tableindex=4 />
                <input class="input" type="tel" maxlength="1" tableindex=5 />
            </div>
            <div class="pass-notice disabled"><span>60s</span>后重新发送</div>
        </div>
    </div>
    <div class="modal-buttons modal-buttons-2">
        <span class="modal-button cancel_confirm">取消</span>
        <span class="modal-button confirm_cancel">确定</span>
    </div>
</div>
<div class="ecjia-cancelAccount-overlay ecjia-cancelAccount-overlay-visible"></div>
<!-- {/block} -->
{/nocache}