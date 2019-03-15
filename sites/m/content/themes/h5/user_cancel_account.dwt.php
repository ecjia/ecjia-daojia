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
        <img class="ecjia-user-avatar" src="{$user.avatar_img}" />
        <div class="info">{t domain="h5" 1={$user.name}}将 %1 账号注销{/t}</div>
    </div>
    <div class="cancel-notice">{t domain="h5"}在您操作注销账号之前，请先确认以下信息，以保证您的账号、财产安全：{/t}</div>
    <div class="cancel-sub">
        <ul>
            <li><i><img src="{$theme_url}images/user/cancel.png" /></i>{t domain="h5"}账号处于安全状态，未发生被盗等风险；{/t}</li>
            <li><i><img src="{$theme_url}images/user/cancel.png" /></i>{t domain="h5"}请确保账号内交易无未完成订单；{/t}</li>
            <li><i><img src="{$theme_url}images/user/cancel.png" /></i>{t domain="h5"}请确保账号内无余额或已结清；{/t}</li>
            <li><i><img src="{$theme_url}images/user/cancel.png" /></i>{t domain="h5"}无任何纠纷，包括投诉举报或被投诉举报；{/t}</li>
            <li><i><img src="{$theme_url}images/user/cancel.png" /></i>{t domain="h5"}已经解除与其他网站、其他APP的授权登录或绑定关系；{/t}</li>
            <li><i><img src="{$theme_url}images/user/cancel.png" /></i>{t domain="h5"}为了账户安全，在您操作注销后，我们将会给您30日的“后悔期”，即先将您的账户锁定30日，30日后，如您未提出异议或未重新“激活账号”，我们将注销您的账户，账户一旦被注销将不可恢复；{/t}</li>
        </ul>
    </div>
</div>
<div class="ecjia-cancel-account-notice">{t domain="h5"}轻按下方“注销账号”按钮，则表示您已阅读并同意{/t}<a class="nopjax external" href="{RC_Uri::url('article/shop/detail')}&title={$article.title}&article_id={$article.article_id}">{t domain="h5"}《注销须知》{/t}</a></div>

<button class="btn confirm-cancel-account">{t domain="h5"}注销账号{/t}</button>

<input type="hidden" name="check_mobile" value="{RC_Uri::url('user/profile/check_mobile')}&type=user_delete_account" />
<input type="hidden" name="confirm_cancel_account" value="{RC_Uri::url('user/profile/confirm_cancel_account')}" />

<div class="ecjia-cancelAccount-modal">
    <div class="modal-inners">
        <span class="ecjia-close-modal-icon"><i class="iconfont icon-close"></i></span>
        <div class="modal-title">{t domain="h5"}验证手机号{/t}</div>
        <div class="modal-title-notice">{t domain="h5"}请输入手机{$user.str_mobile_phone}收到的验证码{/t}</div>
        <div id="payPassword_container">
            <div class="pass_container">
                <input class="input" type="tel" maxlength="1" tableindex=0 />
                <input class="input" type="tel" maxlength="1" tableindex=1 />
                <input class="input" type="tel" maxlength="1" tableindex=2 />
                <input class="input" type="tel" maxlength="1" tableindex=3 />
                <input class="input" type="tel" maxlength="1" tableindex=4 />
                <input class="input" type="tel" maxlength="1" tableindex=5 />
            </div>
            <div class="pass-notice disabled"><span>60s</span>{t domain="h5"}后重新发送{/t}</div>
        </div>
    </div>
    <div class="modal-buttons modal-buttons-2">
        <span class="modal-button cancel_confirm">{t domain="h5"}取消{/t}</span>
        <span class="modal-button confirm_cancel">{t domain="h5"}确定{/t}</span>
    </div>
</div>
<div class="ecjia-cancelAccount-overlay ecjia-cancelAccount-overlay-visible"></div>
<!-- {/block} -->
{/nocache}