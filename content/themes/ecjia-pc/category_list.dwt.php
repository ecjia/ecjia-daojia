<?php defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');?>
<!-- {extends file="ecjia-pc.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	sessionStorage.removeItem('merchant_swiper');
	ecjia.pc.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->   
 
<div class="category {if !$has_store}m_b0{/if}">
    <div class="ecjia-content">
    	{if $cycleimage}
        <div class="category-cycleimage">
			<div id="swiper-merchant-cycleimage" class="swiper-container">
				<div class="swiper-wrapper">
					<!-- {foreach from=$cycleimage item=val} -->
					<div class="swiper-slide" style="background:url('{$val.image}') center center no-repeat;">
						<a href="{$val.url}"></a>
					</div>
					<!-- {/foreach} -->
				</div>
				{if $count gt 1}
				<div class="swiper-pagination swiper-merchant-pagination"></div>
				{/if}
			</div>
        </div>
        {/if}
        
        {if $has_store}
        <div class="category_list">
            <div class="ecjia-category-swiper">
				<div id="category-swiper-web" class="swiper-container" data-url='{RC_Uri::url("merchant/store/category")}'>
					<div class="swiper-wrapper">
						<div class="category_name category_all swiper-slide {if !$cat_id}my-active{/if}">
	                        <p class="text {if !$cat_id}green{/if}"><a href='{RC_Uri::url("merchant/store/category")}'>全部分类</a></p>
			            </div>
			            <!--{foreach from=$category_list item=val key=key}-->
			            <div class="category_name swiper-slide {if $cat_id eq $key}my-active{/if}" id="{$key}">
		             		<p class="text {if $cat_id eq $key}green{/if}"><a href='{RC_Uri::url("merchant/store/category", "cat_id={$key}")}'>{$val.cat_name}</a></p>
			            </div>
			            <!-- {/foreach} -->
			     	</div>
			 	</div>
			 	<div class="swiper-button-prev swiper-button-white"></div>
    			<div class="swiper-button-next swiper-button-white"></div>
			</div>
        </div>
        {/if}
    </div>
    
    {if $has_store}
    <div class="store_list">
        <div class="store_list_title">
            <img src="{$theme_url}images/default/store_list_line.png"/>
            <img src="{if $store_list.cat_img}{$store_list.cat_img}{else}{$theme_url}images/category/category_all_on.png{/if}"/>
            <span>{$store_list.cat_name}</span>
            	<img src="{$theme_url}images/default/store_list_line.png"/>
        	</span>
        </div>
        {if $store_list.item}
        <!--{foreach from=$store_list.item item=val key=key}-->
            <a href="{RC_Uri::url('merchant/goods/init')}&store_id={$val.store_id}">
            <div class="category_store">
                {if $val.banner_pic}
                    <div class="shop_banner"><img src="{$val.banner_pic}"/></div>
                {else}
                    <div class="shop_banner"><img src="{$theme_url}images/default/default800.png"/></div>
                {/if}
                <div class="store_info">
                    {if $val.shop_logo}
                        <img class="store_info_img" src="{RC_Upload::upload_url($val.shop_logo)}">
                    {else}
                        <img class="store_info_img" src="{$theme_url}images/default255.png">
                    {/if}
                    <div class="store_msg">
                        <div class="store_name">{$val.merchants_name}</div>
                        {if $val.manage_mode == 'self'}
                        <p class="self">自营</p>
                        {/if}
                        <br/>
                        <div class="store-range">
                            <div class="score-val" data-val="{$val.comment_rank}"></div>
                        </div>
                    </div>
                    <div class="panel_sao">
                        <div class="panel_sao_pa">
                            <img src="{$val.store_qrcode}">
                            <p><span>扫一次</span><span>立即购买</span></p>
                        </div>
                    </div>
                </div>
                <div class="announcement">
                    {if $val.shop_trade_time}
                    <div class="business_time">
					     <img src="{$theme_url}images/clock_50.png"/>
					     <span>{$val.shop_trade_time}</span>
    				</div>
    				{/if}
                    {if $val.value}
        				<div class="advertisement">
        				    <img src="{$theme_url}images/bugle_50.png"/>
        					<div class="goods-price">{$val.value}</div>
        				</div>
    				{/if}
    				{if $val.activity}
                        <!--{foreach from=$val.activity item=v key=k}-->
                            {if $k < 2}
                            <div class="favorable"><span>{if $v.act_type == '1'}满{else if $v.act_type =='2'}折{/if}</span><span>{$v.act_name}</span></div>
                            {/if}
                        <!-- {/foreach} -->
                    {/if}
                </div>
            </div>
            </a>
        <!-- {/foreach} -->
        {else}
        <div class="no_store_desc">很抱歉，没有找到相关的商家</div>
        {/if}
        {$store_list.page}
    </div>
    {else}
	<!-- #BeginLibraryItem "/library/no_content.lbi" --><!-- #EndLibraryItem -->
	{/if}
</div>

<!-- #BeginLibraryItem "/library/page_footer.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/choose_city.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/nav.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->