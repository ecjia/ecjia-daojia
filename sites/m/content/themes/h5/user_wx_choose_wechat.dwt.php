<?php
/*
Name: 选择微信
Description: 选择微信
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
            <a class="fnUrlReplace" href='{url path="user/profile/account_bind" args="type=wechat"}&code={$cur_platform.connect_code}'>
                <span class="icon-name margin-no-l">{$cur_platform.connect_name}</span>
                <span class="icon-price text-color">{if $cur_platform.selected_status eq 1}{t domain='h5'}已绑定{/t}{else}{t domain='h5'}未绑定{/t}{/if}</span>
                {if $cur_platform.selected_status eq 1}
                <i class="iconfont icon-roundcheckfill margin-r-icon" style="color: #47aa4d;"></i>
                {/if}
            </a>
        </li>
    </div>

    {if $other_platform}
    <div class="title">其他平台</div>
    <div class="ecjia-list list-short m_t0">
        {foreach from=$other_platform item=list}
        <a class="fnUrlReplace" href='{url path="user/profile/account_bind" args="type=wechat"}&code={$list.connect_code}'>
            <li class="height-3">
                <span class="icon-name margin-no-l">{$list.connect_name}</span>
                <span class="icon-price text-color">{if $list.selected_status eq 1}{t domain='h5'}已绑定{/t}{else}{t domain='h5'}未绑定{/t}{/if}</span>
                {if $list.selected_status eq 1}
                <i class="iconfont icon-roundcheckfill margin-r-icon" style="color: #47aa4d;"></i>
                {/if}
            </li>
        </a>
        {/foreach}
    </div>
    {/if}

</div>
<!-- {/block} -->

<!-- {/nocache} -->