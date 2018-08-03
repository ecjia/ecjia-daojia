<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.groupbuy_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class=" fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid batch" >
	<form action="{$search_action}{if $filter.type}&type={$filter.type}{/if}" name="searchForm" method="post">
		<div class="choose_list f_r" >
			<input type="text" name="order_sn" value="{$order_list.filter.order_sn}" placeholder="请输入订单编号关键词"/> 
			<input type="text" name="user_name" value="{$order_list.filter.user_name}" placeholder="请输入用户名关键词"/> 
			<button class="btn search-btn" type="button">{lang key='orders::order.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr>
						<th class="w130">{lang key='orders::order.order_sn'}</th>
						<th class="w100">{lang key='orders::order.merchants_name'}</th>
						<th class="w120">{lang key='orders::order.order_time'}</th>
						<th>{lang key='orders::order.user_purchase_information'}</th>
						<th class="w100">{lang key='orders::order.total_fee'}</th>
						<th class="w50">保证金</th>
						<th class="w100">{lang key='orders::order.order_amount'}</th>
						<th class="w100">{lang key='orders::order.all_status'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.orders item=order key=okey} -->
					<tr>
						<td class="hide-edit-area">
							{$order.order_sn}<span class="groupbuy-icon">团</span>
							<div class="edit-list">
								<a href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' target="__blank" title="{lang key='orders::order.detail'}">{lang key='orders::order.detail'}</a>
							</div>
						</td>
						<td class="ecjiafc-red">
							{$order.merchants_name}
						</td>
						<td>
							{$order.user_name}<br/>{$order.short_order_time}
						</td>
						<td align="left">
							{$order.consignee} [TEL：{$order.mobile}]<br/>{$order.address}
						</td>
						<td align="right" valign="top" nowrap="nowrap">{$order.formated_total_fee}</td>
						<td align="right" valign="top" nowrap="nowrap"></td>
						<td align="right" valign="top" nowrap="nowrap">{$order.formated_order_amount}</td>
						<td align="center" valign="top" nowrap="nowrap">{$os[$order.order_status]},{$ps[$order.pay_status]},{$ss[$order.shipping_status]}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr><td class="no-records" colspan="9">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$order_list.page} -->	
		</div>
	</div>
</div>
<!-- {/block} -->