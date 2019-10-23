<?php
/*
Name: 开店个人奖励
Description: 开店个人奖励
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->
<div class="ecjia-reward-team">
    <div class="reward-team-top">
        <p class="total-num">推广店铺总数（人）</p>
        <p class="number">{if $total}{$total}{else}0{/if}</p>
    </div>

    <div class="ecjia-reward-list">
        <div class="reward-store-head">
            <a class="fnUrlReplace" href='{url path="user/store/reward"}'><div class="reward-head-item {if !$status}active{/if}"><span>直推店铺</span></div></a>
            <a class="fnUrlReplace" href='{url path="user/store/reward"}&status=sub_recommend'><div class="reward-head-item {if $status eq 'sub_recommend'}active{/if}"><span>下级推广店铺</span></div></a>
        </div>
        <ul style="margin-top: 1em" class="reward-list" id="reward-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/personal/ajax_store_list'}{if $smarty.get.status}&status={$smarty.get.status}{/if}">
        </ul>
    </div>
</div>

<!-- {/block} -->
{/nocache}