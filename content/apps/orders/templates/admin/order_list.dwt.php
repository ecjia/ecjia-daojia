<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<a class="btn plus_or_reply show_order_search" href="javascript:;">
			<i class="fontello-icon-search"></i>{t domain="orders"}高级查询{/t}</a>
	</h3>
</div>
<!-- #BeginLibraryItem "/library/order_operate.lbi" -->
<!-- #EndLibraryItem -->

<!-- #BeginLibraryItem "/library/order_search.lbi" -->
<!-- #EndLibraryItem -->

<ul class="nav nav-pills">
	<li class="{if $filter.composite_status eq ''}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}" href="{$search_url}">{t domain="orders"}全部{/t}
			<span class="badge badge-info">{if $count.all}{$count.all}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $filter.composite_status eq 100}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=100" href="{$search_url}&composite_status=100">{t domain="orders"}待付款{/t}
			<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span>
		</a>
	</li>

	<li class="{if $filter.composite_status eq 105}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=105" href="{$search_url}&composite_status=105">{t domain="orders"}待接单{/t}
			<span class="badge badge-info">{if $count.unconfirmed}{$count.unconfirmed}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $filter.composite_status eq 101}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=101" href="{$search_url}&composite_status=101">{t domain="orders"}待发货{/t}
			<span class="badge badge-info">{if $count.await_ship}{$count.await_ship}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $filter.composite_status eq 104}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=104" href="{$search_url}&composite_status=104">{t domain="orders"}待收货{/t}
			<span class="badge badge-info">{if $count.shipped}{$count.shipped}{else}0{/if}</span>
		</a>
	</li>

	<li class="{if $filter.composite_status eq 102}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=102" href="{$search_url}&composite_status=102">{t domain="orders"}已完成{/t}
			<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span>
		</a>
	</li>
</ul>

<div class="row-fluid batch">
	<form action="{RC_Uri::url('orders/admin/init')}{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}" name="searchForm" method="post">
		<select class="down-menu w180" name="status" id="select-rank">
			<option value="-1">{t domain="orders"}订单状态{/t}</option>
			<!-- {html_options options=$status_list selected=$filter.composite_status} -->
		</select>
		<a class="btn m_l5 screen-btn">{t domain="orders"}筛选{/t}</a>

		<div class="choose_list f_r">
			<input type="text" name="merchant_keywords" value="{$filter.merchant_keywords}" placeholder='{t domain="orders"}请输入商家名称关键字{/t}' />
			<input type="text" name="keywords" value="{$filter.keywords}" placeholder='{t domain="orders"}请输入订单编号或购买者信息{/t}' />
			<button class="btn" type="submit">{t domain="orders"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr>
						<th class="w100">{t domain="orders"}订单编号{/t}</th>
						<th class="w180">{t domain="orders"}商家名称{/t}</th>
						<th class="w150">{t domain="orders"}下单时间{/t}</th>
						<th class="w150">{t domain="orders"}购买者信息{/t}</th>
						<th class="w150">{t domain="orders"}总金额{/t}</th>
						{if $filter.extension_code eq "group_buy"}
						<th class="w150">{t domain="orders"}保证金{/t}</th>
						{/if}
						<th class="w110">{t domain="orders"}应付金额{/t}</th>
						{if $filter.extension_code eq "group_buy"}
						<th class="w130">{t domain="orders"}团购状态{/t}</th>
						{/if}
						<th class="w100">{t domain="orders"}订单状态{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.order_list item=order key=okey} -->
					<tr>
						<td class="hide-edit-area">
							{$order.order_sn}
							<div class="edit-list">
								<a href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' class="data-pjax" title='{t domain="orders"}查看{/t}'>{t domain="orders"}查看{/t}</a>
								{if $order.can_remove} &nbsp;|&nbsp;
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="orders"}您确定要删除该订单么？'{/t}
                                   href='{url path="orders/admin/remove_order" args="order_id={$order.order_id}"}' title='{t domain="orders"}删除{/t}'>{t domain="orders"}删除{/t}</a>
								{/if}
							</div>
						</td>
						<td>
							{$order.seller_name}{if $order.manage_mode eq 'self'}
							<span class="ecjiafc-red">{t domain="orders"}（自营）{/t}</span>{/if}
						</td>
						<td>
							{$order.order_time}
						</td>
						<td align="left">
							{$order.consignee}
						</td>
						<td align="right" valign="top" nowrap="nowrap">{$order.formated_total_fee}</td>
						{if $filter.extension_code eq "group_buy"}
						<td>{$order.formated_bond}</td>
						{/if}
						<td align="right" valign="top" nowrap="nowrap">{$order.formated_order_amount}</td>
						{if $filter.extension_code eq "group_buy"}
						<td>
							<span class="
								{if $order.groupbuy_status eq 1}
								badge badge-groupbuy-underway
								{else if $order.groupbuy_status eq 2}
								badge badge-groupbuy-finished
								{else if $order.groupbuy_status eq 3}
								badge badge-groupbuy-success
								{else if $order.groupbuy_status eq 4}
								badge badge-groupbuy-fail
								{/if}">
								{$order.groupbuy_status_desc}
							</span>
						</td>
						{/if}
						<td align="center" valign="top" nowrap="nowrap" {if $order.pay_status eq 0}class="ecjiafc-red" {/if}>{$order.label_order_status}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr>
						<td class="no-records" colspan="{if $filter.extension_code eq 'group_buy'}9{else}7{/if}">{t domain="orders"}没有找到任何记录{/t}</td>
					</tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$order_list.page} -->
		</div>
	</div>
</div>
<form action="{$form_action}" name="orderpostForm" id="listForm" data-pjax-url="{$search_action}" method="post"></form>
<!-- {/block} -->
