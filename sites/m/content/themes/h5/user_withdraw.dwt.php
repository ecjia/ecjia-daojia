<?php
/*
Name:  会员中心：提现管理模板
Description:  会员中心：提现管理
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
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
    <div class="ecjia-list list-short">
        {foreach from=$available_withdraw_way item=list}
        <li class="height-3">
            <a class="fnUrlReplace" href="{url path='user/profile/account_bind'}&type={$list.bank_type}">
                <span class="icon-name margin-no-l">{$list.bank_name}</span>
                <span class="icon-price text-color">{if $list.bind_info}{$list.bind_info.cardholder}{else}{t domain="h5"}未设置{/t}{/if}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
        {/foreach}
    </div>
</div>
<!-- {/block} -->

<!-- {/nocache} -->