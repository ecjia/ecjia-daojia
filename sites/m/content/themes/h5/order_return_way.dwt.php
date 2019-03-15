<?php
/*
Name: 返还方式模板
Description: 这是返还方式页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.return_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<form name='theForm' action="{url path='user/order/add_return_way'}" enctype="multipart/form-data" method="post">
	<div class="ecjia-order-detail ecjia-return-way">
		<div class="ecjia-checkout ecjia-margin-b">
			<div class="flow-goods-list">
				{if $type eq 'home'}
				<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}取件信息{/t}</p>
				<div class="co">
					<p class="cp"><span class="cs">{t domain="h5"}取货方式：{/t}</span><b>{$return_info.return_way_name}</b></p>
					<p class="cp"><span class="cs">{t domain="h5"}取货地址：{/t}</span><label class="cr"><input type="text" name="pickup_address" value="{$return_info.pickup_address}"></label></p>
					<p class="cp"><span class="cs">{t domain="h5"}期望取件时间：{/t}<span class="ecjia-red">*</span></span><label class="cr"><input type="text" readonly name="expect_pickup_time"></label></p>
				</div>
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}联系人信息{/t}</p>
				<div class="co">
					<p class="cp"><span class="cs">{t domain="h5"}联系人：{/t}<span class="ecjia-red">*</span></span><label class="cr"><input type="text" name="contact_name" value="{$return_info.contact_name}"></label></p>
					<p class="cp"><span class="cs">{t domain="h5"}联系电话：{/t}<span class="ecjia-red">*</span></span><label class="cr"><input type="text" type="number" name="contact_phone" value="{$return_info.contact_phone}"></label></p>
				</div>
	
				{else if $type eq 'express'}
			
				<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}返还地址{/t}</p>
				<div class="co">
					<p class="cp line"><span class="cs">{t domain="h5"}收件人：{/t}</span><b>{$return_info.recipients}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.recipients}">{t domain="h5"}复制{/t}</span></p>
					<p class="cp line"><span class="cs">{t domain="h5"}联系方式：{/t}</span><b>{$return_info.contact_phone}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.contact_phone}">{t domain="h5"}复制{/t}</span></p>
					<p class="cp"><span class="cs">{t domain="h5"}收件地址：{/t}</span><b class="cv">{$return_info.recipient_address}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.recipient_address}">{t domain="h5"}复制{/t}</span></p>
					
					<input type="hidden" name="recipients" value="{$return_info.recipients}">
					<input type="hidden" name="contact_phone" value="{$return_info.contact_phone}">
					<input type="hidden" name="recipient_address" value="{$return_info.recipient_address}">
				</div>
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}快递信息{/t}</p>
				<div class="co">
					<p class="cp line"><span class="cs">{t domain="h5"}快递名称：{/t}</span><label class="cr ct"><input type="text" name="shipping_name" placeholder='{t domain="h5"}请输入快递名称{/t}'></label></p>
					<p class="cp"><span class="cs">{t domain="h5"}快递单号：{/t}</span><label class="cr ct"><input type="text" name="shipping_sn" placeholder='{t domain="h5"}请输入快递单号{/t}'></label></p>
				</div>
				
				{else if $type eq 'shop'}
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">{t domain="h5"}返还地址{/t}</p>
				<div class="co">
					<p class="cp line"><span class="cs">{t domain="h5"}店铺名称：{/t}</span><b>{$return_info.store_name}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.store_name}">{t domain="h5"}复制{/t}</span></p>
					<p class="cp line"><span class="cs">{t domain="h5"}联系方式：{/t}</span><b>{$return_info.store_service_phone}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.store_service_phone}">{t domain="h5"}复制{/t}</span></p>
					<p class="cp text"><span class="cs">{t domain="h5"}店铺地址：{/t}</span><b class="cv">{$return_info.store_address}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.store_address}">{t domain="h5"}复制{/t}</span></p>
				</div>
				
				<input type="hidden" name="store_name" value="{$return_info.store_name}">
				<input type="hidden" name="contact_phone" value="{$return_info.store_service_phone}">
				<input type="hidden" name="store_address" value="{$return_info.store_address}">
				
				{/if}
				<div class="order-ft-link">
					<input type="hidden" name="refund_sn" value="{$refund_sn}">
					<input type="hidden" name="type" value="{$type}">
					<input class="btn btn-small btn-hollow" name="add-return-btn" type="submit" value='{t domain="h5"}提交{/t}'/>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="mod_address_slide" id="shippingTimeArea">
	<div class="mod_address_slide_main">
		<div class="mod_address_slide_head">
			{t domain="h5"}取件时间{/t}<i class="iconfont icon-close"></i>
		</div>
		<div class="mod_address_slide_body">
			<ul class="mod_address_slide_tabs navBar">
				<!-- {foreach from=$return_info.expect_pickup_date.dates item=val} -->
				<li data-date="{$val}">{$val}</li>
				<!-- {/foreach} -->
			</ul>
			<ul class="mod_address_slide_list selShip hide">
				<!-- {foreach from=$return_info.expect_pickup_date.times item=val} -->
				<li data-time="{$val.start_time}-{$val.end_time}">{$val.start_time}-{$val.end_time}</li>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->
{/nocache}