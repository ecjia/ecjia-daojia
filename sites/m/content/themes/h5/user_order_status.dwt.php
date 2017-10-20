<?php
/*
Name: 订单详情模板
Description: 这是订单详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-detail">
	<div class="goods-describe order-log-list {if $smarty.get.type neq 'detail'} active{/if}" id="one">
		<!-- {foreach from=$order.order_status_log item=info} -->
		<div class='order-log-item {$info.status} {if count($order.order_status_log) lt 2} item-only{/if}'>
			<div class="order-log">
				<span>{$info.order_status}</span><span class="ecjiaf-fr order-time">{$info.time}</span>
				<p>{$info.message}</p>{if $info.status eq 'express_user_pickup' && $order.express_mobile}<a class="tel" href="tel://{$order.express_mobile}"></a>{/if}
			</div>
		</div>
		<!-- {/foreach} -->
	</div>
</div>
<!-- {/block} -->