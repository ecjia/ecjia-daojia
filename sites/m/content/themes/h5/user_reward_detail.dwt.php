<?php
/*
Name: 奖励明细
Description: 奖励明细
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.spread.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-spread">
    <div class="reward-detail">
        <div class="swiper-container swiper-reward">
            <div class="swiper-wrapper">
            	<!--{foreach from=$month item=date name=d}-->
                <div class="swiper-slide">
                    <div data-date="{$date.invite_data}">
                    	<p>{$date.label_invite_data}</p>
                    </div>
                </div>
            	<!--{/foreach}-->
            </div>
            <input type="hidden" value="{RC_Uri::url('user/bonus/async_reward_detail')}" name="reward_url"/>
        </div>
    </div>
</div>  
<div class="ecjia-spread-detail">
    <ul class="ecjia-list list-short detail-list" data-loadimg="{$theme_url}dist/images/loader.gif"  data-page="2" data-toggle="{if $is_last}asynclist{/if}" data-url="{if $is_last}{url path='async_reward_detail'}&date={$max_month}{/if}">
        <!--{foreach from=$data item=record}-->
        <li>
	         <span class="record-label">{$record.label_reward_type}</span>
	         <span class="icon-price-red ecjiaf-fr">{$record.give_reward}</span>
	         <span class="record-time">{$record.reward_time}</span>
	    </li>
        <!-- {foreachelse} -->
        <div class="ecjia-nolist">
	        <div class="img-noreward">暂无奖励</div>
		</div>
        <!-- {/foreach} -->
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
    <!--{foreach from=$data item=record}-->
    <li>
        <span class="record-label">{$record.label_reward_type}</span>
		<span class="icon-price-red ecjiaf-fr">{$record.give_reward}</span>
        <span class="record-time">{$record.reward_time}</span>
    </li>
   	<!-- {foreachelse} -->
	<div class="ecjia-nolist">
		<div class="img-noreward">暂无奖励</div>
	</div>
    <!-- {/foreach} -->
<!-- {/block} -->
{/nocache}