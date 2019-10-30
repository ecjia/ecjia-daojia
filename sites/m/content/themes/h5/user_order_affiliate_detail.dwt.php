<?php
/*
Name: 销售个人奖励详情
Description: 销售个人奖励详情
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->
<div class="ecjia-reward-detail">
    <div class="reward-detail-top">
        {if $data.separate_status eq 'await_separate'}
        <div class="status"><img src="{$theme_url}images/affiliate/wait_affiliate.png" /></div>
        {else if $data.separate_status eq 'separated'}
        <div class="status"><img src="{$theme_url}images/affiliate/affiliated.png" /></div>
        {else if $data.separate_status eq 'cancel_separated'}
        <div class="status"><img src="{$theme_url}images/affiliate/cancel_seprate.png" /></div>
        {/if}
        <p>{$data.label_separate_status}</p>

        {if $data.separate_status neq 'await_seprate'}
        <p class="price">{$data.formatted_affiliated_amount}</p>
        {/if}

        <div class="detail-list">
            <p><span class="ecjiaf-fl">{t domain="h5"}订单编号{/t}</span><span class="ecjiaf-fr">{$data.order_sn}</span></p>
            <p><span class="ecjiaf-fl">{t domain="h5"}购买人{/t}</span><span class="ecjiaf-fr">{$data.buyer}</span></p>
            <p><span class="ecjiaf-fl">{t domain="h5"}下单时间{/t}</span><span class="ecjiaf-fr">{$data.formatted_order_time}</span></p>
        </div>
    </div>

    <div class="reward-detail-bottom">
        <div class="bottom-hd">
            <a class="nopjax external" href="{RC_Uri::Url('merchant/index/init')}&store_id={$data.store_id}">
                <img src="{$theme_url}images/icon/store_green.png" />&nbsp;{$data.store_name} <i class="iconfont icon-jiantou-right" style="top:0;"></i>
            </a>
        </div>

        {foreach from=$data.goods_list item=val}
        <ul class="goods-item">
            <li class="goods-img">
                <img class="ecjiaf-fl" src="{$val.img.thumb}" />
            </li>
            <div class="goods-right">
                <div class="goods-name">{$val.goods_name}</div>
                <p class="block">{t domain="h5"}货号：{/t}{$val.goods_sn}</p>
                <div class="block">
                    <span class="ecjiaf-fl">x{$val.goods_number}</span>
                    <span class="ecjiaf-fr ecjia-color-red">{$val.formatted_goods_price}</span>
                </div>
            </div>
        </ul>
        {/foreach}

        <div class="detail-list">
            <p><span class="ecjiaf-fl">{t domain="h5"}订单合计{/t}</span><span class="ecjiaf-fr">{$data.formatted_total_amount}</span></p>
            {if $data.formatted_affiliated_amount}
            <p><span class="ecjiaf-fl">{t domain="h5"}获得分成{/t}</span><span class="ecjiaf-fr ecjia-color-red">{$data.formatted_affiliated_amount}</span></p>
            {/if}
        </div>
    </div>
</div>
<!-- {/block} -->
{/nocache}