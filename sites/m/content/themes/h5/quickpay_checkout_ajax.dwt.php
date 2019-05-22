<?php
/*
Name: 闪惠付款
Description: 这是闪惠付款页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
{if $activity_list}
<div class="item_list">
	<div class="quickpay_div content">
		<!-- {foreach from=$activity_list item=val} -->
		<li class="outher_d">
			<span class="radio-height radio-mr-t">
				<label class="ecjia-check ecjiaf-fr" for="activity_{$val.activity_id}">
					<input type="radio" id="activity_{$val.activity_id}" name="activity_id" value="{$val.activity_id}" {if $val.is_allow_use eq 0}disabled{else if $val.is_favorable eq 1}checked{/if}>
				</label>
			</span>
			<span class="shanhui">{t domain="h5"}买单{/t}</span>
			<span class="slect-title">{$val.title}</span>
			{if $val.is_allow_use eq 0}
			<span class="ecjiaf-fr ecjia-margin-r ecjia-color-aaa">{t domain="h5"}不可用{/t}</span>
			{else}
			<span class="ecjiaf-fr ecjia-margin-r">-{$val.formated_discount}</span>
			{/if}
		</li>
		<!-- {/foreach} -->
	</div>
</div>
{/if}

{if $arr.bonus_list|count gt 0 || $arr.allow_use_integral}
<div class="item_list ecjia-margin-t">
	<div class="quickpay_div content">
		{if $arr.allow_use_bonus && $arr.bonus_list|count gt 0}
	    <li class="outher_d">
	    	{if $arr.bonus_list|count gt 0}
	        <a class="nopjax external" href='{url path="user/quickpay/bonus" args="store_id={$store_id}"}'>
	            <div class="icon-wallet"></div>
	            <span class="icon-name">{t domain="h5"}使用红包{/t}</span>
	            <span class="fav_info">{t domain="h5" 1={count($arr.bonus_list)}}%1个可用{/t}</span>
	            
	            <i class="iconfont icon-jiantou-right"></i>
	            <input type="hidden" name="bonus" value="{$temp.bonus}">
				{if $temp.bonus}
	  			<span class="other_width">{$arr['bonus_list'][$temp.bonus]['type_name']} [{$arr['bonus_list'][$temp.bonus]['bonus_money_formated']}] </span>
	      		{/if}
	        </a>
	        {/if}
	    </li>
	    {/if}
	    
	    {if $arr.allow_use_integral && $arr.order_max_integral neq 0}
	    <li class="outher_d">
	        <a class="nopjax external" href='{url path="user/quickpay/integral" args="store_id={$store_id}"}'>
	            <div class="icon-wallet"></div>
	            <span class="icon-name">{t domain="h5"}使用{/t}{$integral_name}</span>
	            {if $temp.integral gt 0}
	            <span class="fav_info">{$temp.integral}{$integral_name}</span>
	            <input type="hidden" name="integral" value="{$temp.integral}" />
	            {else}
	            <span class="fav_info">{if $data.user_integral lt $arr.order_max_integral }{$data.user_integral}{else}{$arr.order_max_integral}{/if}{t domain="h5" 1={$integral_name}}%1可用{/t}</span>
	            {/if}
	            <i class="iconfont icon-jiantou-right"></i>
				{if $temp.integral && $temp.integral_bonus}
				<span class="other_width">{$temp.integral}{$integral_name}{t domain="h5" 1={$temp.integral_bonus}}抵%1元{/t}</span>
				{/if}
	        </a>
	    </li>
	    {/if}
	</div>
</div>
{/if}

<div class="quickpay_div ecjia-margin-t background_fff item_list">
	<li class="outher_d">
		<span>{t domain="h5"}实付金额{/t}</span>
		<span class="ecjiaf-fr total_fee">{if $total_fee}￥{$total_fee}{else}￥0.00{/if}</span>
	</li>
</div>
<!-- {/block} -->
{/nocache}