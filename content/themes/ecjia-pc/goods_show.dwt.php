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
                        <span>{t domain="ecjia-pc"}价格{/t}</span>
                        {if $goods_info.promote_price && $goods_info.promote_price != 0}
                            <span class="fl_price">￥{$goods_info.f_price}</span>
                            <span class="original_price">{t domain="ecjia-pc"}原价：{/t}{$goods_info.shop_price}</span>
                            <input name="goods_promote_price" type="hidden" value={$goods_info.promote_price} />
                        {else}
                            <span class="fl_price">￥{$goods_info.f_price}</span>
                            <span class="original_price">{t domain="ecjia-pc"}原价：{/t}{$goods_info.market_price}</span>
                            <input name="goods_promote_price" type="hidden" value={$goods_info.shop_price} />
                        {/if}
                     </p>
                        {if $goods_info.favourable_list}
                            <div class="privilege"><span>{t domain="ecjia-pc"}优惠{/t}</span>
                                <!-- {foreach from=$goods_info.favourable_list item=val key=key} -->
                                    <span class="panel_red">{$val.name}</span>
                        		<!-- {/foreach} -->
                            </div>
              
                        {/if}
                        <p class="sold_out"><span>{t domain="ecjia-pc"}已售{/t}</span><span class="sales">{$goods_info.order_amount}</span></p>
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
                <p><span>{t domain="ecjia-pc"}扫一扫{/t}</span><span>{t domain="ecjia-pc"}手机购买{/t}</span></p>
            </div>
        </div>
        
         <div class="panel_sao">
            <div class="panel_sao_pa">
                <img src="{$goods_info.url}">
                <p><span>{t domain="ecjia-pc"}扫一扫{/t}</span><span>{t domain="ecjia-pc"}手机购买{/t}</span></p>
            </div>
        </div>
                
        <div class="merchant">
            <div class="merchant_title">{t domain="ecjia-pc"}商家{/t}</div>
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
                <p><span>{t domain="ecjia-pc"}成功接单{/t}</span><span>{$shop_info.order_amount}</span></p>
                <p><span>{t domain="ecjia-pc"}接单率{/t}</span><span>{$shop_info.order_precent}%</span></p>
                <p><span>{t domain="ecjia-pc"}好评率{/t}</span><span>{$shop_info.comment_percent}%</span></p>
            </div>
        </div>
        
        <div class="goods_introduce">
            <div class="cut_off"><img src="{$theme_url}images/default/cut_off.png"></div>
            {if $goods_info.properties}
            <div class="specification">
                <div class="goods_specification">
                    <p class="rhombus"></p>
                    <p class="goods_description">{t domain="ecjia-pc"}商品参数{/t}</p>
                </div>
                <div class="parameters">
                    <!--{foreach from=$goods_info.properties_new item=val key=key}-->
                    <span>{$val.name}：{$val.value}</span>
                    {if $val@last}
                    <p></p>
                    {else}
                    {if $val@iteration is even}<p></p>{/if}
                    {/if}
                    <!-- {/foreach} -->
                </div>

            </div>
            {/if}
        	{if $goods_info.goods_desc}
            	<div class="goods_introduce_title"><p class="rhombus"><p class="goods_description">{t domain="ecjia-pc"}商品介绍{/t}</p></div>
                <div class="goods_introduce_detail"> 
            	   {$goods_info.goods_desc}
            	</div>
        	{else}
            	   <div class="no_goods_desc">{t domain="ecjia-pc"}暂无商品介绍{/t}</div>
        	{/if}
        </div>
        
        <div class="down_sao">
            <div class="sao_code">
                <span class="sao_back"><img src="{$theme_url}images/default/bolang.png"></span>
                <span class="sao_tow"><img src="{$goods_info.mobile_iphone_qrcode}"></span>
            </div>
            <div class="sao_text">
                <p>{t domain="ecjia-pc"}扫一扫{/t}</p>
                <p>{t domain="ecjia-pc"}下载APP{/t}</p>
            </div>
        </div>
        {else}
        <div class="no_goods_info">
               <p>{t domain="ecjia-pc"}该商品不存在{/t}</p>
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