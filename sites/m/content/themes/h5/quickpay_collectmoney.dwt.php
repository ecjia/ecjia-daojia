<?php
/*
Name: 优惠买单页面
Description: 优惠买单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="meta"} -->
<style>
body { background: #fff; }
</style>
<!-- {/block} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.quickpay.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod ecjia-header ecjia-store-banner" style="position:relative;background: url('{if $store_info.seller_banner}{$store_info.seller_banner}{else}{$theme_url}images/default_store_banner.png{/if}') center center no-repeat;background-size: 144% 100%;">
	<div class="ecjia-store-brief quickpay-brief" style="position:relative;">
		<a class="nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$store_id}">
			<img src="{if $store_info.seller_logo}{$store_info.seller_logo}{else}{$theme_url}images/store_default.png{/if}">
		</a>
		<div class="store-name"><a class="nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$store_id}">{$store_info.seller_name}</a></div>
	</div>
</div>

<input type="hidden" name="from" value="{$from}" class="ecjia-from-page {if $out eq 1}out-range{/if}" />

<div class="ecjia-quickpay-form">
	{if $store_info.shop_closed eq 1}
	<div class="shop_closed_notice">{t domain="h5"}商家打烊中，优惠买单尚未开始~{/t}</div>
	{/if}
	<form name="quickpayForm" action="{if $direct_pay eq 1}{url path='quickpay/flow/flow_checkorder'}{else}{url path='quickpay/flow/done'}{/if}" method="post" data-url="{url path='quickpay/flow/flow_checkorder'}">
		<div class="ecjia-quickpay-content">
			<div class="quickpay-content-title">
				{t domain="h5"}消费总金额（元）{/t}
			</div>
			<div class="quickpay-content-input">
				<div class="logo">￥</div>
				<input type="number" placeholder='{t domain="h5"}请询问店员后输入{/t}' step="0.01" name="order_money" maxlength="9" {if $store_info.shop_closed eq 1}readonly{/if}/>
			</div>
			<div class="quickpay-content-block">
				<a class="more-discount external" href="{RC_Uri::url('user/quickpay/init')}&store_id={$store_id}">{t domain="h5"}更多优惠选择 >>>{/t}</a>
			</div>
		</div>
		<div class="ecjia-service-content-bottom">
			<input type="hidden" name="activity_id" class="auto_activity_id"/>
			<input type="hidden" name="store_id" value="{$store_id}">
			<input type="hidden" name="direct_pay" value="{$direct_pay}">
			<input class="btn quickpay_done external check_quickpay_btn" type="button" value='{t domain="h5"}我要买单{/t}' />
		</div>
	</form>

	<div class="ecjia-pay-content">
		<div class="ecjia-pay-content-area">
			<div class="pay-content-title">{t domain="h5"}确认付款{/t}
			<image class="pay-content-close" src="{$theme_url}images/icon/close.png" />
			</div>
			<div class="pay-content-price"></div>
			<div class="pay-content-li">
			<div class="left">{t domain="h5"}消费金额{/t}</div>
			<div class="right goods-amount"></div>
			</div>
			<div class="pay-content-li">
			<div class="left">{t domain="h5"}优惠金额{/t}</div>
			<div class="right red discount"></div>
			</div>
			<div class="pay-content-li">
			<div class="left">{t domain="h5"}实付金额{/t}</div>
			<div class="right total-fee"></div>
			</div>
			<div class="pay-content-btn">
				<input type="hidden" name="quickpay_done_url" value="{url path='quickpay/flow/done'}">
				<input type="hidden" name="pay_url" value="{url path='user/quickpay/dopay'}">
				<button class="btn confirm-pay-btn" data-money="" data-activity="" data-paycode="{$payment.pay_code}">{t domain="h5"}确认买单{/t}</button>
				<div class="wei-xin-pay hide"></div>
			</div>
		</div>
	</div>
</div>      
<!-- {/block} -->
{/nocache}