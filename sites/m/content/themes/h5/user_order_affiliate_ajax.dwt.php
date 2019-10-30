<?php
/*
Name: 订单分成
Description: 订单分成列表
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {if $list} -->
<!-- {foreach from=$list item=val} -->
<li class="reward-item ecjia-margin-t">
    <div class="reward-hd">
        {t domain="h5"}订单编号{/t}&nbsp;{$val.order_sn}
        <span class="ecjiaf-fr ecjia-color-red">{$val.label_separate_status}</span>
    </div>
    <div class="flow-goods-list">
        <a class="ecjiaf-db" href='{url path="user/order/affiliate_detail" args="id={$val.order_id}"}'>
            <!-- {foreach from=$val.goods_list key=k item=v} -->
            {if $k eq 0}
            <ul class="goods-item">
                <li class="goods-img">
                    <img class="ecjiaf-fl" src="{$v.img.thumb}" />
                </li>
                <div class="goods-right">
                    <div class="goods-name">{$v.goods_name}</div>
                    <p class="block">{$v.formatted_goods_price}</p>
                </div>
            </ul>
            {/if}
            <!-- {/foreach} -->
        </a>
    </div>

    <div class="reward-ft">
        <em class="ecjiaf-fl">{$val.formatted_order_time}</em>
        <em class="ecjiaf-fr ecjia-color-red">{$val.formatted_affiliated_amount}</em>
    </div>

</li>
<!-- {/foreach} -->
<!-- {else} -->
<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
    <div class="ecjia-nolist">
        <p><img src="{$theme_url}images/wallet/null280.png"></p>
        {t domain="h5"}暂无分成记录{/t}
    </div>
</div>
<!-- {/if} -->
<!-- {/block} -->
{/nocache}