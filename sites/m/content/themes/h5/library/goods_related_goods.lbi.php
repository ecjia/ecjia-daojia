<?php
/*
Name: 商品祥情相关商品
Description: 这是商品祥情相关商品
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {if $goods_info.related_goods} -->
<div class="address-warehouse ecjia-margin-t address-warehouse-new">
    <div class="ecjia-form">
        <div class="may-like-literal"><span class="may-like">{t domain="h5"}猜你喜欢{/t}</span></div>
    </div>
    <div class="ecjia-margin-b form-group ecjia-form">
        <div class="bd">
            <ul class="ecjia-list ecjia-like-goods-list">
                <!--{foreach from=$goods_info.related_goods item=goods name=goods}-->
                <!-- {if $smarty.foreach.goods.index < 6 } -->
                <li>
                    <a class="nopjax external" href='{url path="goods/index/show" args="goods_id={$goods.goods_id}&product_id={$goods.product_id}"}'>
									<span class="like-goods-img">
										<img src="{$goods.img.url}" alt="{$goods.name}" title="{$goods.name}" /></span>
                    </a>
                    <p class="link-goods-name ecjia-goods-name-new">{$goods.name}</p>
                    <div class="link-goods-price">
                        <span class="goods-price">{$goods.shop_price}</span>
                        {if $goods_info.shop_closed neq 1}
                        {if $goods.specification}
                        <div class="goods_attr goods_spec_{$goods.id}" goods_id="{$goods_info.id}">
						<span class="choose_attr spec_goods" rec_id="{$goods.rec_id}" goods_id="{$goods.id}" data-num="{$goods.num}"
                            data-spec="{$goods.default_spec}" data-url="{RC_Uri::url('cart/index/check_spec')}" data-store="{$store_id}">{t domain="h5"}选规格{/t}</span>
                            {if $goods.num}<i class="attr-number">{$goods.num}</i>{/if}
                        </div>
                        {else}
                        <span class="goods-price-plus may_like_{$goods.goods_id}" data-toggle="add-to-cart" rec_id="{$goods.rec_id}"
                              goods_id="{$goods.id}" data-num="{$goods.num}"></span>
                        {/if}
                        {/if}
                    </div>
                </li>
                <!--{/if}-->
                <!--{/foreach}-->
            </ul>
        </div>
    </div>
</div>
<!-- {/if} -->
{/nocache}