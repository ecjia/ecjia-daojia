<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="move-mod-group" id="widget_admin_dashboard_orderslist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
		<span class="pull-right label label-important">{$order_count}</span>
	</div>

	<table class="table table-striped table-bordered mediaTable">
		<thead>
			<tr>
				<th class="optional">{lang key='orders::order.order_sn'}</th>
				<th class="essential persist">{lang key='orders::order.order_time'}</th>
				<th class="optional">{lang key='orders::order.total_fee'}</th>
				<th class="optional">{lang key='orders::order.order_status'}</th>
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
				<td>{$lang_os[$order.order_status]},{$lang_ps[$order.pay_status]},{$lang_ss[$order.shipping_status]}</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
	<div class="ecjiaf-tar"><a href='{url path="orders/admin/init"}' title="{lang key='orders::order.more'}">{lang key='orders::order.more'}</a></div>
</div>