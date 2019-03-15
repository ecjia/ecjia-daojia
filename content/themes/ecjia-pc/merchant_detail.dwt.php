<?php defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');?>
<!-- {extends file="ecjia-pc.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.pc.init();
</script>
<script charset="utf-8" src="{$map_qq_url}"></script>
<script type="text/javascript">
//腾讯地图
var map, markersArray = [];

var lat = '{$shop_info.latitude}';
var lng = '{$shop_info.longitude}';
var address = '{$shop_info.address}';
var latLng = new qq.maps.LatLng(lat, lng);

var map = new qq.maps.Map(document.getElementById("allmap"),{
    center: latLng,
    zoom: 16
});

var info = new qq.maps.InfoWindow({
    map: map
});

setTimeout(function(){
    var marker = new qq.maps.Marker({
        position: latLng,
        map: map
    });
    info.open();
    info.setContent('<div style="width:auto;height:20px;">'+ address +'</div>');
    info.setPosition(latLng);
    markersArray.push(marker);
}, 500);
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
{if $shop_info}
<!-- #BeginLibraryItem "/library/merchant_header.lbi" --><!-- #EndLibraryItem -->
<div class="background-f6">
    <div class="ecjia-content">
        <div class="store-comment">
            <ul class="store-header">
                <a href='{$goods_url}' class="store-header-li"><li>{t domain="ecjia-pc"}商品{/t}</li></a>
                <a href='{$comment_url}' class="store-header-li"><li>{t domain="ecjia-pc"}评价{/t}</li></a>
                <a href='javascript:;' class="nopjax store-header-li active"><li>{t domain="ecjia-pc"}商家详情{/t}</li></a>
            </ul>
            <hr class="store-header-hr" />

            <div class="store-detail">
                <div class="store-option">
                    <div class="store-left"><img src="{$shop_info.shop_logo}"></div>
                    <div class="store-right">
                        <div class="store-title">
                            <span class="store-name">{$shop_info.merchants_name}</span>
                            {if $shop_info.manage_mode eq self}
                                <span class="manage-mode">{t domain="ecjia-pc"}自营{/t}</span>
                            {/if}
                        </div>
                        <div class="store-range">
                            <span>{t domain="ecjia-pc"}总体评分：{/t}</span><span class="score-val" data-val="{$shop_info.comment_rank}"></span>
                        </div>
                        <div class="store-range">
                            <span>{t domain="ecjia-pc"}营业时间：{/t} {$shop_info.trade_time}</span>
                            {if $shop_info.business_status eq 1}
                                 <div class="business-status">{t domain="ecjia-pc"}营业中{/t}</div>
                            {else if $shop_info.business_status eq 0}
                                 <div class="business-status">{t domain="ecjia-pc"}暂停营业{/t}</div>
                            {/if}
                        </div>
                    </div>
                </div>
                <hr class="store-detail-hr" />
                <div class="store-option">
                    <dl>
                        <dt>{$shop_info.order_amount}</dt>
                        <dd>{t domain="ecjia-pc"}成功接单{/t}</dd>
                    <span class="store-detail-title-border"></span>
                    </dl>
                    <dl>
                        <dt>{$shop_info.order_precent}%</dt>
                        <dd>{t domain="ecjia-pc"}接单率{/t}</dd>
                    <span class="store-detail-title-border"></span>
                    </dl>
                    <dl>
                        <dt>{$shop_info.comment_percent}%</dt>
                        <dd>{t domain="ecjia-pc"}好评率{/t}</dd>
                    </dl>
                </div>
                <hr class="store-detail-hr" />
                <div class="store-info">
                    <p class="range18">{t domain="ecjia-pc"}商家公告：{/t}{$shop_info.value}</p>
                    <p class="range18">{t domain="ecjia-pc"}商家电话：{/t}{$shop_info.kf_mobile}</p>
                    <p class="range18">{t domain="ecjia-pc"}商家地址：{/t}{$shop_info.address}</p>
                    <p class="range18">{t domain="ecjia-pc"}商家简介：{/t}{$shop_info.shop_description}</p>
                </div>
                <div class="store-map">
                    <div id="allmap"></div>
                    <div style="display: none">{$coord.longitude}{$coord.latitude}</div>
                </div>
            </div>
        </div>
    </div>
</div>
{else}
<div class="m_t80">
<!-- #BeginLibraryItem "/library/no_content.lbi" --><!-- #EndLibraryItem -->
</div>
{/if}
<!-- #BeginLibraryItem "/library/page_footer.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/choose_city.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/nav.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
