<?php
/*
Name: 店铺列表模版
Description: 这是店铺列表
Libraries: store_list
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$data item=val} -->
<li class="single_item">
    <ul class="single_store">
        <li class="store-info">
            <a class="nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
	            <div class="basic-info">
	                <div class="store-left">
	                    <img src="{$val.seller_logo}">
	                    {if $val.shop_closed eq 1}
							<div class="shop_closed_mask">休息中</div>
						{/if}
	                </div>
	                <div class="store-right">
	                    <div class="store-title">
	                    <span class="store-name">{$val.seller_name}</span>
	                    {if $val.manage_mode eq 'self'}<span class="manage_mode">自营</span>{/if}</div>
	                    {if $val.distance}<span class="store-distance">{$val.distance}</span>{/if}
	                    <div class="store-range">
	                        <i class="icon-shop-time"></i>{$val.label_trade_time}
	                        <!-- {if $val.allow_use_quickpay eq 1} -->
							<a href="{RC_Uri::url('user/quickpay/init')}&store_id={$val.id}"><span class="store-quickpay-btn">买单</span></a>
							<!-- {/if} -->
	                    </div>
	                </div>
	                <div class="clear"></div>
	            </div>
	            {if $val.favourable_list}
	            <ul class="store-promotion">
	                <!-- {foreach from=$val.favourable_list item=list} -->
	                <li class="promotion">
	                    <span class="promotion-label">{$list.type_label}</span>
	                    <span class="promotion-name">{$list.name}</span>
	                </li>
	                <!-- {/foreach} -->
	            </ul>
	            {/if}
	            <!-- {if $val.allow_use_quickpay eq 1 && $val.quickpay_activity_list} -->
				<ul class="store-promotion">
					<!-- {foreach from=$val.quickpay_activity_list item=list key=key} -->
					{if $key eq 0}
					<li class="promotion">
						<span class="promotion-label">买单</span>
						<span class="promotion-name">{$list.title}</span>
					</li>
					{/if}
					<!-- {/foreach} -->
				</ul>
				<!-- {/if} -->
            </a>
            {if $val.seller_goods}
            <ul class="store-goods">
                <!-- {foreach from=$val.seller_goods key=key item=goods} -->
                    <a class="nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.goods_id}">
	                    <li class="goods-info {if $key gt 2}goods-hide-list{/if}">
	                        <span class="goods-image"><img src="{$goods.img.small}"></span>
	                        <p>
	                            {$goods.name}
	                            <label class="price">{if $goods.promote_price}{$goods.promote_price}{else}{$goods.shop_price}{/if}</label>
	                        </p>
	                    </li>
                    </a>
                <!-- {/foreach} -->
            </ul>
            {/if}
        </li>
    </ul>
    {if $val.goods_count > 3}
    <ul>
        <li class="goods-info view-more">
			查看更多（{$val.goods_count-3}）<i class="iconfont icon-jiantou-bottom"></i>
        </li>
        <li class="goods-info view-more retract hide">
			收起<i class="iconfont icon-jiantou-top"></i>
        </li>
    </ul>
    {/if}
</li>		
<!-- {/foreach} -->	
<!-- {/block} -->