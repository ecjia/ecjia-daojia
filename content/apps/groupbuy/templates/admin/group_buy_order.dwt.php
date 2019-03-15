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
			<input type="text" name="order_sn" value="{$order_list.filter.order_sn}" placeholder='{t domain="groupbuy"}请输入订单编号关键词{/t}'/>
			<input type="text" name="user_name" value="{$order_list.filter.user_name}" placeholder='{t domain="groupbuy"}请输入用户名关键词{/t}'/>
			<button class="btn search-btn" type="button">{t domain="groupbuy"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr>
						<th class="w130">{t domain="groupbuy"}订单号{/t}</th>
						<th class="w100">{t domain="groupbuy"}商家名称{/t}</th>
						<th class="w120">{t domain="groupbuy"}下单时间{/t}</th>
						<th>{t domain="groupbuy"}购买用户信息{/t}</th>
						<th class="w100">{t domain="groupbuy"}总金额{/t}</th>
						<th class="w50">{t domain="groupbuy"}保证金{/t}</th>
						<th class="w100">{t domain="groupbuy"}应付金额{/t}</th>
						<th class="w100">{t domain="groupbuy"}订单状态{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.orders item=order key=okey} -->
					<tr>
						<td class="hide-edit-area">
							{$order.order_sn}<span class="groupbuy-icon">{t domain="groupbuy"}团{/t}</span>
							<div class="edit-list">
								<a href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' target="_blank" title='{t domain="groupbuy"}查看{/t}'>{t domain="groupbuy"}查看{/t}</a>
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
					<tr><td class="no-records" colspan="9">{t domain="groupbuy"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$order_list.page} -->	
		</div>
	</div>
</div>
<!-- {/block} -->