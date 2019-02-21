<?php
/*
Name: 订单确认模板
Description: 订单确认页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.flow.init();
	ecjia.touch.flow.init_pay();
	$.localStorage('address_title', $(document).attr("title"));
	$.localStorage('address_url', window.location.href);
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-checkout ecjia-padding-b">
	{if $show_storepickup}
	<div class="ecjia-checkout-tab">
		<a href="{if $shipping_type eq 'default'}javascript:;{else}{RC_Uri::url('cart/flow/checkout')}&store_id={$store_id}&rec_id={$rec_id}{/if}"><span class="tab tab-left {if $shipping_type eq 'default' || $shipping_type eq 'default_storepickup'}active{/if}">配送上门</span></a><a href="{if $shipping_type eq 'storepickup'}javascript:;{else}{RC_Uri::url('cart/flow/storepickup_checkout')}&store_id={$store_id}&rec_id={$rec_id}{/if}"><span class="tab tab-right {if $shipping_type eq 'storepickup'}active{/if}">门店提货</span></a>
	</div>
	{/if}
	<form id="theForm" name="checkForm" action="{$done_url}" method="post">
		
		{if $shipping_type eq 'default' || $shipping_type eq 'default_storepickup'}
		<a class="ecjia-default-shipping" href="{if !$address_list && !$address_id}{RC_Uri::url('user/address/add_address')}&clear=1{else}{RC_Uri::url('user/address/address_list')}&store_id={$store_id}&rec_id={$rec_id}&type=choose{/if}">
			<div class="flow-address ecjia-margin-b {if !$data.consignee}choose-address{/if}">
				<label class="ecjiaf-fl"><i class="icon-position"></i></label>
				<!-- {if !$address_id && !$address_list} -->
				<p class="notice">新建收货地址</p>
				<!-- {else} -->
				{if $data.consignee}
				<div class="ecjiaf-fl address-info">
					<span>{$data.consignee.consignee|escape}</span>
					<span>{$data.consignee.mobile}</span>
					<p class="ecjia-truncate2 address-desc">{$data.consignee.province_name}{$data.consignee.city_name}{$data.consignee.district_name}{$data.consignee.street_name} {$data.consignee.address}{$data.consignee.address_info}</p>
				</div>
				{else}
				<p class="notice">已有地址超过配送范围，请重新选择或添加</p>
				{/if}
				<!-- {/if} -->
				<i class="iconfont icon-jiantou-right"></i>
			</div>
		</a>
		<section class="checklist line flex">
			<a class="check_address" href='{url path="cart/flow/pay_shipping" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				<span class="pay_title">支付配送</span>
				
				<div class="ecjia-select-pay">
					<div class="select-pay-left">
						<span class="select_nav ecjia-truncate">{$selected_payment.pay_name}</span>
						<span class="select_nav ecjia-truncate">{$selected_shipping.shipping_name}</span>
						
						{if $selected_shipping.shipping_date_enable && $selected_shipping.shipping_date}
						<span class="select_nav ecjia-truncate">{if !$selected_shipping.shipping_date}<span class="ecjia-color-999">暂无可选时间</span>{elseif $temp.shipping_date && $temp.shipping_time}{$temp.shipping_date} {$temp.shipping_time}{/if}</span>
						<input type="hidden" name="shipping_date" value="{$temp.shipping_date}" />
						<input type="hidden" name="shipping_time" value="{$temp.shipping_time}" />
						{/if}
					</div>
					<i class="iconfont icon-jiantou-right"></i>
					<input type="hidden" name="shipping_id" value="{$selected_shipping.shipping_id}" />
					<input type="hidden" name="pay_id" value="{$selected_payment.pay_id}" />
				</div>
			</a>
		</section>
		{/if}
		
		{if $shipping_type eq 'storepickup'}
		<div class="ecjia-storepickup">
			<div class="flow-address ecjia-margin-b {if !$data.consignee}choose-address{/if}">
				<label class="ecjiaf-fl"><i class="icon-store"></i></label>
				<div class="ecjiaf-fl address-info">
					<span>前往【{$store_info.seller_name}】门店提货</span>
					<p class="ecjia-truncate2 address-desc">店铺电话：{$store_info.telephone}</p>
					<p class="ecjia-truncate2 address-desc">{$store_info.shop_address}</p>
				</div>
				<a class="nopjax external" href="{$location_url}"><i class="icon-shopguide"></i></a>
			</div>
		</div>
		<section class="checklist line border-top-none flex">
			<a class="check_address" href='{url path="cart/flow/pay_pickup" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				<span class="pay_title">支付提货</span>
				<div class="ecjia-select-pay">
					<div class="select-pay-left">
						<span class="select_nav ecjia-truncate">{$selected_payment.pay_name}</span>
						<span class="select_nav ecjia-truncate">提货时间</span>
						
						{if $temp.pickup_date && $temp.pickup_date}
						<span class="select_nav ecjia-truncate">{if $temp.pickup_date && $temp.pickup_time}{$temp.pickup_date} {$temp.pickup_time}{/if}</span>
						<input type="hidden" name="pickup_date" value="{$temp.pickup_date}" />
						<input type="hidden" name="pickup_time" value="{$temp.pickup_time}" />
						{/if}
					</div>
					<i class="iconfont icon-jiantou-right"></i>
					<input type="hidden" name="pay_id" value="{$selected_payment.pay_id}" />
					<input type="hidden" name="shipping_id" value="{$selected_shipping.shipping_id}" />
					
				</div>
			</a>
		</section>
		{/if}
		
		<section class="flow-goods-list border">
			{if count($data.goods_list) gt 1}<a href='{url path="cart/flow/goods_list" args="address_id={$address_id}&rec_id={$rec_id}"}'>{/if}
			<ul class="{if count($data.goods_list) > 1}goods-list{else}goods-item{/if}"><!-- goods-list 多个商品隐藏商品名称,goods-item -->
				<!-- {foreach from=$data.goods_list item=goods name=goods} -->
				<!-- {if $smarty.foreach.goods.iteration gt 3} -->
				<!-- {break} -->
				<!-- {/if} -->
				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon">
					{if 0}<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.goods_name}" title="{$goods.goods_name}" />
					{if $goods.goods_number gt 1}<span class="ecjia-icon-num top">{$goods.goods_number}</span>{/if}
					<span class="ecjiaf-fl goods-name ecjia-truncate2">{$goods.goods_name}</span>{/if}
					<div class="ecjiaf-fl">
					<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.goods_name}" title="{$goods.goods_name}" />
					{if $goods.goods_number gt 1}<span class="ecjia-icon-num top">{$goods.goods_number}</span>{/if}
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">{$goods.goods_name}</p>
						<p class="ecjia-goods-attr goods-attr">
					<!-- {foreach from=$goods.goods_attr item=attr} -->
					{if $attr.name}{$attr.name}:{$attr.value}{/if}
					<!-- {/foreach} -->
					</p>
						<p class="ecjia-color-red">{$goods.formated_goods_price}</p>
					</div>
					<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
				</li>
				<!-- {/foreach} -->
				<!-- {if count($data.goods_list) gt 1} -->
				<!-- 判断不能大于4个 -->
				<li class="goods-img-more">
					<!-- {if count($data.goods_list) gt 3} --><i class="icon iconfont">&#xe62e;</i>{/if}
					<p class="ecjiaf-ib">共{$total_goods_number}件</p>
					<i class="icon iconfont icon-right">&#xe6aa;</i>
				</li>
				<!-- {/if} -->
			</ul>
			{if count($data.goods_list) gt 1}</a>{/if}
		</section>

		<section class="checklist border note">
			<span class="note-title">备注</span>
			<input class="note" type="text" name="note" placeholder="我们将尽力满足您的要求" />
		</section>
		<div class="ecjia-margin-b"></div>
		
		{if $data.allow_can_invoice}
		<section class="checklist">
			<a class="check_address" href='{url path="cart/flow/invoice" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				<span>发票信息<!-- invoice --></span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{if $temp.inv_type_name == 'personal'}个人{else if}{$temp.inv_payee}{/if}</span>
				<input type="hidden" name="inv_title_type" value="{$temp.inv_type_name}" />
				<input type="hidden" name="inv_payee" value="{$temp.inv_payee}" />
				<input type="hidden" name="inv_tax_no" value="{$temp.inv_bill_code}" />
				<input type="hidden" name="inv_content" value="{$temp.inv_content}" />
				<input type="hidden" name="inv_type" value="{$temp.inv_type}" />
			</a>
		</section>
		<div class="ecjia-margin-b"></div>
		{/if}
		
		{if $data.allow_use_bonus}
		<section class="checklist">
			{if $data.bonus|count gt 0}
			    <a class="check_address" href='{url path="cart/flow/bonus" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				<span>使用红包</span>
				<span class="ecjia-tag">{count($data.bonus)}个可用</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav_short ecjia-truncate">{$data.bonus[$temp.bonus].bonus_name}</span>
				<input type="hidden" name="bonus" value="{$temp.bonus}">
			</a>
			{else}
			<a href='javascript:;' title="不可用">
			    <span class="ecjia-color-999">使用红包</span>
			    <span class="ecjia-tag ecjia-tag-disable">不可用</span>
			</a>
			{/if}
		</section>
		{/if}
		
		{if $data.allow_use_integral}
		<section class="checklist ecjia-margin-b">
			{if $data.order_max_integral eq 0}
				<a href='javascript:;' title="不可用">
				    <span class="ecjia-color-999">使用{$integral_name}</span>
				    <span class="ecjia-tag ecjia-tag-disable">不可用</span>
				</a>
				{else}
				<a class="check_address" href='{url path="cart/flow/integral" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				    <span>使用{$integral_name}</span>
    				{if $temp.integral gt 0}
    				<span class="ecjiaf-fr select_nav ecjia-truncate">{$temp.integral}{$integral_name}</span>
    				<input type="hidden" name="integral" value="{$temp.integral}" />
    				{else}
    				<span class="ecjia-tag">{if $data.your_integral lt $data.order_max_integral }{$data.your_integral}{else}{$data.order_max_integral}{/if}{$integral_name}可用</span>
    				{/if}
    				<i class="iconfont icon-jiantou-right"></i>
				</a>
			{/if}				
		</section>
		{/if}

		<section class="ecjia-margin-t checkout-select checkout-pro-list">
			<!-- #BeginLibraryItem "/library/order_total.lbi" --><!-- #EndLibraryItem -->
		</section>
		<p class="ecjia-margin-t ecjia-margin-l ecjia-color-green">本订单由{$store_info.seller_name}发货并提供售后服务</p>

		<section class="ecjia-margin-t">
			<input type="hidden" name="rec_id" value="{$rec_id}">
			<input type="hidden" name="address_id" value="{$address_id}">
			<input class="btn btn-info" name="submit" type="submit" value="提交订单（应付{$total.amount_formated}）" />
			<input name="step" type="hidden" value="done" />
		</section>
	</form>
</div>
<!-- {/block} -->
{/nocache}