<?php
/*
Name: 商品祥情页购物车
Description: 这是商品祥情页购物车
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="store-add-cart a4w">
    <div class="a52"></div>
    <a href="javascript:void 0;" class="a4x {if $real_count.goods_number}light{else}disabled{/if} outcartcontent show show_cart"
       show="false">
        {if $real_count.goods_number}
        <i class="a4y">
            {if $real_count.goods_number gt 99}99+{else}{$real_count.goods_number}{/if}
        </i>
        {/if}
    </a>
    <div class="a4z" style="transform: translateX(0px);">
        {if $goods_info.shop_closed eq 1}
        <div class="a61">{t domain="h5"}商家打烊了{/t}</div>
        <div class="a62">{t domain="h5"}营业时间{/t} {$goods_info.label_trade_time}</div>
        {else}
        {if !$real_count.goods_number}
        <div class="a50">{t domain="h5"}购物车是空的{/t}</div>
        {else}
        <div>
            {$count.goods_price}{if $count.discount neq 0}<label>{t domain="h5" 1={$count.discount}}(已减%1){/t}</label>{/if}
        </div>
        {/if}
        {/if}
    </div>
    <a class="a51 {if !$count.check_one || $count.meet_min_amount neq 1}disabled{/if} check_cart"
       data-href="{RC_Uri::url('cart/flow/checkout')}" data-store="{$goods_info.seller_id}"
       data-address="{$address_id}" data-rec="{$data_rec}" href="javascript:;" data-text='{t domain="h5"}去结算{/t}'>
        {if $count.meet_min_amount eq 1 || !$count.label_short_amount}{t domain="h5"}去结算{/t}{else}{t domain="h5" 1={$count.label_short_amount}}还差%1起送{/t}{/if}
    </a>

    <div class="minicart-content" style="transform: translateY(0px); display: block;">
        <a href="javascript:void 0;" class="a4x {if $count.goods_number}light{else}disabled{/if} incartcontent show_cart"
           show="false">
            {if $real_count.goods_number}
            <i class="a4y">
                {if $real_count.goods_number gt 99}99+{else}{$real_count.goods_number}{/if}
            </i>
            {/if}
        </a>
        <i class="a57"></i>
        <div class="a58 ">
            <span class="a69 a6a {if $count.check_all}checked{/if}" data-toggle="toggle_checkbox" data-children=".checkbox" id="checkall">{t domain="h5"}全选{/t}</span>
            <p class="a6c">{t domain="h5" 1={$count.goods_number}}(已选%1件){/t}</p>
            <a href="javascript:void 0;" class="a59" data-toggle="deleteall" data-url="{RC_Uri::url('cart/index/update_cart')}">{t domain="h5"}清空购物车{/t}</a>
        </div>

        <div class="a5b" style="max-height: 21em;">
            <div class="a5l single">
                {if $goods_info.favourable_list}
                <ul class="store-promotion" id="store-promotion">
                    <!-- {foreach from=$goods_info.favourable_list item=list} -->
                    <li class="promotion">
                        <span class="promotion-label">{$list.type_label}</span>
                        <span class="promotion-name">{$list.name}</span>
                    </li>
                    <!-- {/foreach} -->
                </ul>
                {/if}
                <ul class="minicart-goods-list single">
                    <!-- {foreach from=$cart_list item=cart} -->
                    <li class="a5n single {if $cart.is_disabled eq 1}disabled{/if}">
						<span class="a69 a5o {if $cart.is_checked}checked{/if} checkbox {if $cart.is_disabled eq 1}disabled{/if}"
                              data-toggle="toggle_checkbox" rec_id="{$cart.rec_id}"></span>
                        <table class="a5s">
                            <tbody>
                            <tr>
                                <td style="width:75px; height:75px">
                                    <img class="a7g" src="{$cart.img.small}">
                                    <div class="product_empty">
                                        {if $cart.is_disabled eq 1}{$cart.disabled_label}{/if}
                                    </div>
                                </td>
                                <td>
                                    <div class="a7j">{$cart.goods_name}</div>
                                    {if $cart.attr}<div class="a7s">{$cart.attr}</div>{/if}
                                    <span class="a7c">
											{if $cart.goods_price eq 0}{t domain="h5"}免费{/t}{else}{$cart.formated_goods_price}{/if}
										</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="box" id="goods_cart_{$cart.id}">
							<span class="a5u reduce {if $cart.is_disabled eq 1}disabled{/if} {if $cart.attr}attr_spec{/if}" data-toggle="remove-to-cart"
                                  rec_id="{$cart.rec_id}" goods_id="{$cart.id}"></span>
                            <lable class="a5x" {if $cart.is_disabled neq 1}data-toggle="change-number" {/if} rec_id="{$cart.rec_id}"
                            goods_id="{$cart.id}" goods_num="{$cart.goods_number}">{$cart.goods_number}</lable>
                            <span class="a5v {if $cart.is_disabled eq 1}disabled{/if} {if $cart.attr}attr_spec{/if}" data-toggle="add-to-cart"
                                  rec_id="{$cart.rec_id}" goods_id="{$cart.id}"></span>
                        </div>
                    </li>
                    <input type="hidden" name="rec_id" value="{$cart.rec_id}" />
                    <!-- {/foreach} -->
                </ul>
                <div class="a5m single"></div>
            </div>
        </div>
    </div>
</div>