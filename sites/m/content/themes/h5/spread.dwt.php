<?php
/*
Name: 用户中心模板
Description: 这是推广页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    {if $is_weixin}
    var config = '{$config}';
    {/if}

        ecjia.touch.spread.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-spread">
    <div class="ecjia-bg-qr-code">
        <div class="qrcode_image qrcode_image_spread">
            <div class="my-invite-code">
                <p>{t domain="h5"}我的邀请码{/t}</p>
                <div class="code-style">{$invite_user.invite_code}</div>
            </div>
            <img src="{$invite_user.invite_qrcode_image}" />

            <div class="go-to-spread">
                <a class="show_spread_share nopjax external" href="javascript:;"><div class="would-spread">{t domain="h5"}我要邀请{/t}</div></a>
            </div>
        </div>

    </div>

    <div class="ecjia-my-reward">
        <a class="nopjax external" href="{url path='user/index/spread_center_agent'}"><div class="my_reward">{t domain="h5"}我的邀请{/t}<i class="iconfont icon-jiantou-right"></i></div></a>
    </div>
    <p style="height: 1em; background-color: #F7F7F7; margin-bottom: 1em;"></p>
    <div class="invite_explain">
        <p class="invite_explain-literal text-center">{t domain="h5"}邀请说明{/t}</p>
        <div class="invite_explain-content">
            {if $invite_user.invite_explain}
            <!--{foreach from=$invite_user.invite_explain item=invite}-->
            {if $invite}
            <p>{$invite}</p>
            {/if}
            <!--{/foreach}-->
            {/if}
        </div>
    </div>
    <div class="ecjia-spread-share hide"><img src="{$theme_url}images/spread.png"></div>

    <input type="hidden" name="share_title" value="{$share_title}">
    <input type="hidden" name="share_desc" value="{$invite_user.invite_template}">
    <input type="hidden" name="share_image" value="{$image}">
    <input type="hidden" name="share_link" value="{$invite_user.invite_url}">
    <input type="hidden" name="share_page" value="1">

</div>
<!-- {/block} -->