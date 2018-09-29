<?php
/*
Name: 订单详情模板
Description: 这是订单详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script>
var arr = JSON.parse('{$arr}');
var center = new qq.maps.LatLng(arr.from.location.lat, arr.from.location.lng);
var map = new qq.maps.Map(document.getElementById("expressMap"), {
    center: center,
    zoom: 13
});
var infoWin = new qq.maps.InfoWindow({
    map: map
});
var latlngs = [
    new qq.maps.LatLng(arr.from.location.lat, arr.from.location.lng),
    new qq.maps.LatLng(arr.to.location.lat, arr.to.location.lng)
];
var anchor = new qq.maps.Point(75, 42),
size = new qq.maps.Size(150, 85),
origin = new qq.maps.Point(0, 0),
icon_0 = new qq.maps.MarkerImage(theme_url + 'images/icon/icon-shopping-express.png', size, origin, anchor);

for (var i = 0;i < latlngs.length; i++) {
    (function(n){
        if (n == 0) {
            var marker = new qq.maps.Marker({
                position: latlngs[n],
                map: map,
                icon: icon_0
            });
        }
    })(i);
} 
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-order-detail">
	<div class="goods-describe order-log-list {if $smarty.get.type neq 'detail'} active{/if}" id="one">
		<!-- {foreach from=$order.order_status_log item=info} -->
		<div class='order-log-item {$info.status} {if count($order.order_status_log) lt 2} item-only{/if} {if $express_info}express-status-icon{/if}'>
			<div class="order-log">
				<a href="{RC_Uri::url('user/order/express_position')}&code={$order.shipping_code}&express_id={$order.express_id}&order_id={$order.order_id}&store_id={$order.store_id}">
					<span>{$info.order_status}</span><span class="ecjiaf-fr order-time">{$info.time}</span>
					<p>{$info.message}</p>
				</a>
				{if $info.status eq 'express_user_pickup' && $order.express_mobile}
				<a class="tel" href="tel://{$order.express_mobile}"></a>
				{/if}
				{if $express_info && $info.status eq 'express_user_pickup'}
				<div class="ecjia-express-user-position">
					<div id="expressMap"></div>
				</div>
				{/if}
			</div>
		</div>
		<!-- {/foreach} -->
	</div>
</div>
<!-- {/block} -->