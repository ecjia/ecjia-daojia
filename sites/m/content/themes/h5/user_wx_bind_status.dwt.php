<?php
/*
Name: 微信绑定状态
Description: 微信绑定状态
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");
exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    // ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user ecjia-account">
    <div class="title">当前平台</div>
    <div class="ecjia-list list-short m_t0">
        <li class="height-3">
            <a href='{url path="user/profile/bind_info" args="type=wechat"}'>
                <span class="icon-name margin-no-l">{$cur_platform.connect_name}</span>
                <span class="icon-price text-color">{if $cur_platform.status eq 1}{t domain='h5'}已绑定{/t}{else}{t domain='h5'}未绑定{/t}{/if}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
    </div>

    {if $other_platform}
    <div class="title">其他平台</div>
    <div class="ecjia-list list-short m_t0">
        {foreach from=$other_platform item=list}
        <li class="height-3">
            <span class="icon-name margin-no-l">{$list.connect_name}</span>
            <span class="icon-price text-color">{t domain='h5'}已绑定{/t}</span>
        </li>
        {/foreach}
    </div>
    {/if}

</div>
<!-- {/block} -->

<!-- {/nocache} -->