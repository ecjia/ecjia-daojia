<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="move-mod-group" id="widget_admin_dashboard_ordersstat">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
		<span class="pull-right label label-important">{$order_count}</span>
	</div>

	<table class="table table-bordered mediaTable dash-table-oddtd">
		<thead>
			<tr>
				<th colspan="4" class="optional">{lang key='orders::order.order_stats_info'}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><a href='{url path="orders/admin/init" args="composite_status={$status.await_ship}"}' title="{lang key='orders::order.not_shipping_orders'}">{lang key='orders::order.not_shipping_orders'}</a></td>
				<td class="dash-table-color"><strong>{$order.await_ship}</strong></td>
				<td><a href='{url path="orders/admin/init" args="composite_status={$status.unconfirmed}"}' title="{lang key='orders::order.unconfirmed_orders'}">{lang key='orders::order.unconfirmed_orders'}</a></td>
				<td><strong>{$order.unconfirmed}</strong></td>
			</tr>
			<tr>
				<td><a href='{url path="orders/admin/init" args="composite_status={$status.await_pay}"}' title="{lang key='orders::order.unpaid_orders'}">{lang key='orders::order.unpaid_orders'}</a></td>
				<td><strong>{$order.await_pay}</strong></td>
				<td><a href='{url path="orders/admin/init" args="composite_status={$status.finished}"}' title="{lang key='orders::order.finished_orders'}">{lang key='orders::order.finished_orders'}</a></td>
				<td><strong>{$order.finished}</strong></td>
			</tr>
			<tr>
				<td><a href='{url path="orders/admin/init" args="composite_status={$status.shipped_part}"}' title="{lang key='orders::order.parts_delivery_order'}">{lang key='orders::order.parts_delivery_order'}</a></td>
				<td><strong>{$order.shipped_part}</strong></td>
				<td><a href='{url path="user/admin_account/init" args="process_type=1&is_paid=0"}' title="{lang key='orders::order.refund_application'}">{lang key='orders::order.refund_application'}</a></td>
				<td><strong>{$new_repay}</strong></td>
			</tr>
		</tbody>
	</table>
</div>