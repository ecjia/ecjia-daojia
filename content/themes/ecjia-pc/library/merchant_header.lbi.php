<?php
/*
Name: PC端店铺详情
Description: 这是PC端的店铺详情模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="background-f6">
    <div class="ecjia-content">
        <div class="merchant-promotions-ul">
            <div class="promotions-li move-mouse">
                <div class="triangle">
                </div>
                <div class="store-left">
                    <img src="{$shop_info.shop_logo}">
                </div>
                <div class="store-right">
                    <div class="store-title">
                        <span class="store-name">{$shop_info.merchants_name}</span>
                        {if $shop_info.manage_mode eq self}
                            <div class="manage-mode">自营</div>       
                        {/if}           
                    </div>
                    <div class="score-val" data-val="{$shop_info.comment_rank}"></div>
                    <div class="store-info">
                       <span>营业时间： {$shop_info.trade_time}</span>
                        {if $shop_info.business_status eq 1}
                             <div class="business-status">营业中</div>
                         {else if $shop_info.business_status eq 0}
	                         <div class="business-status">暂停营业</div>
		                {/if}
                    </div>
                    <p class="store-description store-info">商家公告： {$shop_info.value}</p>
                </div>
                <div class="goods-border"></div>
            </div>
            <div class="store-link">
                <p class="prompt-message">
                    <span>扫一扫</span>
                    <span class="store-green">进入店铺</span>
                </p>
                <div class="store-qrcode">
                    <img src="{$shop_info.store_qrcode}" >
                </div>
            </div>
        </div>
        <div class="store-detail-info">
            <div class="message-block">
                <dl>
                    <dt>{$shop_info.order_amount}</dt>
                    <dd>成功接单</dd>
                <span class="message-border"></span>
                </dl>
                <dl>
                    <dt>{$shop_info.order_precent}%</dt>
                    <dd>接单率</dd>
                <span class="message-border"></span>
                </dl>
                <dl>
                    <dt>{$shop_info.comment_percent}%</dt>
                    <dd>好评率</dd>
                </dl>
            </div>
            <div class="about-store">
                <p>商家地址：{$shop_info.address}</p>
                <p>商家电话：{$shop_info.kf_mobile}</p>
                <p>商家公告：<span class="f34">{$shop_info.value}</span></p>
            </div>
        </div>
        <div class="ecjia-cycleimage">
            {if $shop_info.banner_pic}
            <img src="{$shop_info.banner_pic}">
            {else}
            <img src="{$theme_url}/images/default/default_banner_pic.png">
            {/if}
        </div>
        
        {if $shop_info.activity}
        <div class="store-comment m_b0">
            <div class="promotion-code">
                <div class="promotion-span">
                    <span>店铺优惠</span>
                </div>
                <ul class="promotion-ul">
                	<!-- {foreach from=$shop_info.activity item=val key=key} -->
                    <li class="promotion-ul-li">
                        <div class="ticket">
                            <div class="a6d">
                                {if $val.act_type eq '1'}
                                <span>￥</span>
                                <span class="promotion-num">{$val.act_type_ext}</span>
                                {elseif $val.act_type eq '2'}
                                <span class="promotion-num">{$val.discount}</span>
                                <span>折</span>
                                {/if}
                            </div>
                            <div class="a6e">
                                <p>{$val.act_mode}</p>
                                <p>{$val.act_name}</p>
                            </div>
                        </div>
                    </li>
                	<!-- {/foreach} -->
                </ul>
            </div>
        </div>
        {/if}
    </div>
</div>