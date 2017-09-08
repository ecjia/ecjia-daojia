<?php defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');?>
<!-- {extends file="ecjia-pc.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.pc.init();
</script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script type="text/javascript">
var address = '{$shop_info.address}';
var geocoder,map,marker = null;
map = new qq.maps.Map(document.getElementById('allmap'),{
    zoom: 18
});
var info = new qq.maps.InfoWindow({
    map: map
});
//调用地址解析类
geocoder = new qq.maps.Geocoder({
    complete : function(result){
        map.setCenter(result.detail.location);
        var marker = new qq.maps.Marker({
            map:map,
            position: result.detail.location
        });

        //默认显示标记提示 
        info.open();
        info.setContent('<div style="width:auto;height:20px;">'+
            result.detail.address+'</div>');
        info.setPosition(result.detail.location);
        
        //添加监听事件 当标记被点击了  设置图层
        qq.maps.event.addListener(marker, 'click', function() {
            info.open();
            info.setContent('<div style="width:auto;height:20px;">'+
                result.detail.address+'</div>');
            info.setPosition(result.detail.location);
        });
    }
});
geocoder.getLocation(address);
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
	            <a href='{$goods_url}' class="store-header-li"><li>商品</li></a>
	            <a href='{$comment_url}' class="store-header-li"><li>评价</li></a>
	            <a href='javascript:;' class="nopjax store-header-li active"><li>商家详情</li></a>
	        </ul>
	        <hr class="store-header-hr" />
	        
            <div class="store-detail">
    		    <div class="store-option">
    		        <div class="store-left"><img src="{$shop_info.shop_logo}"></div>
    		        <div class="store-right">
    		            <div class="store-title">
    		                <span class="store-name">{$shop_info.merchants_name}</span>
    		                {if $shop_info.manage_mode eq self}
    		                    <span class="manage-mode">自营</span>        
    		                {/if}            
    		            </div>
    		            <div class="store-range">
                            <span>总体评分：</span><span class="score-val" data-val="{$shop_info.comment_rank}"></span>
    		            </div>
    		            <div class="store-range">
    		                <span>营业时间： {$shop_info.trade_time}</span>
    		                {if $shop_info.business_status eq 1}
    		                     <div class="business-status">营业中</div>
		                    {else if $shop_info.business_status eq 0}
		                         <div class="business-status">暂停营业</div>
    		                {/if}
    		            </div>
    		        </div>
    		    </div>
    		    <hr class="store-detail-hr" />
    		    <div class="store-option">
    		        <dl>
    		            <dt>{$shop_info.order_amount}</dt>
    		            <dd>成功接单</dd>
    		        <span class="store-detail-title-border"></span>
    		        </dl>
    		        <dl>
    		            <dt>{$shop_info.order_precent}%</dt>
    		            <dd>接单率</dd>
    		        <span class="store-detail-title-border"></span>
    		        </dl>
    		        <dl>
    		            <dt>{$shop_info.comment_percent}%</dt>
    		            <dd>好评率</dd>
    		        </dl>
    		    </div>
    		    <hr class="store-detail-hr" />
    		    <div class="store-info">
                    <p class="range18">商家公告：{$shop_info.value}</p>
                    <p class="range18">商家电话：{$shop_info.kf_mobile}</p>
                    <p class="range18">商家地址：{$shop_info.address}</p>
                    <p class="range18">商家简介：{$shop_info.shop_description}</p>
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