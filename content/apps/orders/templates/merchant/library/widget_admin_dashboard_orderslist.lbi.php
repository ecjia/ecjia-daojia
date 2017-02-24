<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="move-mod-group" id="widget_admin_dashboard_orderslist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
		<span class="pull-right label label-important">{$order_count}</span>
	</div>

	<table class="table table-striped table-bordered mediaTable">
		<thead>
			<tr>
				<th class="optional">{t}订单号{/t}</th>
				<th class="essential persist">{t}下单时间{/t}</th>
				<th class="optional">{t}总金额{/t}</th>
				<th class="optional">{t}订单状态{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$order_list item=order key=okey} -->
			<tr>
				<td>
					<a href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' class="sepV_a" title="Edit">{$order.order_sn}</a>
				</td>
				<td>{$order.short_order_time}</td>
				<td>{$order.formated_total_fee}</td>
				<td>{$lang.os[$order.order_status]},{$lang.ps[$order.pay_status]},{$lang.ss[$order.shipping_status]}</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
	<div class="ecjiaf-tar"><a href='{url path="orders/admin/init"}' title="{t}查看更多{/t}">{t}查看更多{/t}</a></div>
</div>