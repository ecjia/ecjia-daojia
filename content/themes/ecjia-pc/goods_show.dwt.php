<?php defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');?>
<!-- {extends file="ecjia-pc.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.pc.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
      
{if $has_store}  
<div class="goods_info_back">
    <div class="goods_info ecjia-content">
    	{if $goods_info.goods_id}
        <div class="goods_current_screen">{$goods_info.cat_html}</div>
        <div class="goods_info_panel">
            <img src="{if $goods_info.goods_thumb}{$goods_info.goods_thumb}{else}{$theme_url}images/default/default_goods.png{/if}" />
            <div class="f_goods_info_msg">
                <p class="goods_name">{$goods_info.goods_name}</p>
                <div class="goods_attribute">
                    <p class="goods_price">
                        <span>价格</span>
                        {if $goods_info.promote_price && $goods_info.promote_price != 0}
                            <span class="fl_price">￥{$goods_info.f_price}</span>
                            <span class="original_price">原价：{$goods_info.shop_price}</span>
                            <input name="goods_promote_price" type="hidden" value={$goods_info.promote_price} />
                        {else}
                            <span class="fl_price">￥{$goods_info.f_price}</span>
                            <span class="original_price">原价：{$goods_info.market_price}</span>
                            <input name="goods_promote_price" type="hidden" value={$goods_info.shop_price} />
                        {/if}
                     </p>
                        {if $goods_info.favourable_list}
                            <div class="privilege"><span>优惠</span>
                                <!-- {foreach from=$goods_info.favourable_list item=val key=key} -->
                                    <span class="panel_red">{$val.name}</span>
                        		<!-- {/foreach} -->
                            </div>
              
                        {/if}
                        <p class="sold_out"><span>已售</span><span class="sales">{$goods_info.order_amount}</span></p>
                        <!-- {foreach from=$goods_info.specification item=value key=key} -->
                        <span class="standard">{$value.name}</span>
                        <ul>
                            <!-- {foreach from=$value.value item=val key=key} -->
                                <li data-attr="{$val.id}" data-price="{$val.price}">{$val.label}</li>
                    		<!-- {/foreach} -->
                        </ul>
                        <!-- {/foreach} -->
                    </div>
                </div>
             <div class="sao_small_img">
                <img src="{$goods_info.url}">
                <p><span>扫一扫</span><span>手机购买</span></p>
            </div>
        </div>
        
         <div class="panel_sao">
            <div class="panel_sao_pa">
                <img src="{$goods_info.url}">
                <p><span>扫一扫</span><span>手机购买</span></p>
            </div>
        </div>
                
        <div class="merchant">
            <div class="merchant_title">商家</div>
            <a href="{RC_Uri::url('merchant/goods/init')}&store_id={$goods_info.store_id}">
	            <div class="merchant_img">
                    <span><img src="{if $shop_info.shop_logo}{RC_Upload::upload_url($shop_info.shop_logo)}{else}{$theme_url}images/default255.png{/if}" /></span>
	            </div>
            </a>
            <div class="merchant_name">
                <p>{$shop_info.merchants_name}</p>
            </div>
             <div class="store-range">
                <div class="score-val" data-val="{$shop_info.comment_rank}"></div>
            </div>
            <div class="merchant_order_msg">
                <p><span>成功接单</span><span>{$shop_info.order_amount}</span></p>
                <p><span>接单率</span><span>{$shop_info.order_precent}%</span></p>
                <p><span>好评率</span><span>{$shop_info.comment_percent}%</span></p>
            </div>
        </div>
        
        <div class="goods_introduce">
            <div class="cut_off"><img src="{$theme_url}images/default/cut_off.png"></div>
            {if $goods_info.properties}
            <div class="specification">
                <div class="goods_specification"><p class="rhombus"></p><p class="goods_description">规格参数</p></div>
                <!--{foreach from=$goods_info.properties item=val key=key}-->
                    <div class="parameters">
                        <span class="p1">{$val.name1}：{$val.value1}</span>
                        {if $val.name2}<span class="p2">{$val.name2}：{$val.value2}</span>{/if}
                        <p></p>
                    </div>   
                <!-- {/foreach} -->         
            </div>
            {/if}
        	{if $goods_info.goods_desc}
            	<div class="goods_introduce_title"><p class="rhombus"><p class="goods_description">商品介绍</p></div>
                <div class="goods_introduce_detail"> 
            	   {$goods_info.goods_desc}
            	</div>
        	{else}
            	   <div class="no_goods_desc">暂无商品介绍</div>
        	{/if}
        </div>
        
        <div class="down_sao">
            <div class="sao_code">
                <span class="sao_back"><img src="{$theme_url}images/default/bolang.png"></span>
                <span class="sao_tow"><img src="{$goods_info.mobile_iphone_qrcode}"></span>
            </div>
            <div class="sao_text">
                <p>扫一扫</p>
                <p>下载APP</p>
            </div>
        </div>
        {else}
        <div class="no_goods_info">
               <p>该商品不存在</p>
        </div>
        {/if}
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