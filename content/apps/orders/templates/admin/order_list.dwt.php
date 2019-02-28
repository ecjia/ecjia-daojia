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
			<i class="fontello-icon-search"></i>高级查询</a>
	</h3>
</div>
<!-- #BeginLibraryItem "/library/order_operate.lbi" -->
<!-- #EndLibraryItem -->

<!-- #BeginLibraryItem "/library/order_search.lbi" -->
<!-- #EndLibraryItem -->

<ul class="nav nav-pills">
	<li class="{if $filter.composite_status eq ''}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}" href="{$search_url}">全部
			<span class="badge badge-info">{if $count.all}{$count.all}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $filter.composite_status eq 100}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=100" href="{$search_url}&composite_status=100">待付款
			<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span>
		</a>
	</li>

	<li class="{if $filter.composite_status eq 105}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=105" href="{$search_url}&composite_status=105">待接单
			<span class="badge badge-info">{if $count.unconfirmed}{$count.unconfirmed}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $filter.composite_status eq 101}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=101" href="{$search_url}&composite_status=101">待发货
			<span class="badge badge-info">{if $count.await_ship}{$count.await_ship}{else}0{/if}</span>
		</a>
	</li>
	<li class="{if $filter.composite_status eq 104}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=104" href="{$search_url}&composite_status=104">待收货
			<span class="badge badge-info">{if $count.shipped}{$count.shipped}{else}0{/if}</span>
		</a>
	</li>

	<li class="{if $filter.composite_status eq 102}active{/if}">
		<a class="data-pjax" data-href="{RC_Uri::url('orders/admin/init')}&composite_status=102" href="{$search_url}&composite_status=102">已完成
			<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span>
		</a>
	</li>
</ul>

<div class="row-fluid batch">
	<form action="{RC_Uri::url('orders/admin/init')}{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}" name="searchForm" method="post">
		<select class="down-menu w180" name="status" id="select-rank">
			<option value="-1">订单状态</option>
			<!-- {html_options options=$status_list selected=$filter.composite_status} -->
		</select>
		<a class="btn m_l5 screen-btn">{t}筛选{/t}</a>

		<div class="choose_list f_r">
			<input type="text" name="merchant_keywords" value="{$filter.merchant_keywords}" placeholder="请输入商家名称关键字" />
			<input type="text" name="keywords" value="{$filter.keywords}" placeholder="请输入订单编号或购买者信息" />
			<button class="btn" type="submit">搜索</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr>
						<th class="w100">订单编号</th>
						<th class="w180">商家名称</th>
						<th class="w150">下单时间</th>
						<th class="w150">购买者信息</th>
						<th class="w150">总金额</th>
						{if $filter.extension_code eq "group_buy"}
						<th class="w150">保证金</th>
						{/if}
						<th class="w110">应付金额</th>
						{if $filter.extension_code eq "group_buy"}
						<th class="w130">团购状态</th>
						{/if}
						<th class="w100">订单状态</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.order_list item=order key=okey} -->
					<tr>
						<td class="hide-edit-area">
							{$order.order_sn}
							<div class="edit-list">
								<a href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' class="data-pjax" title="查看">查看</a>
								{if $order.can_remove} &nbsp;|&nbsp;
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='您确定要删除该订单么？' href='{url path="orders/admin/remove_order" args="order_id={$order.order_id}"}'
								    title="删除">删除</a>
								{/if}
							</div>
						</td>
						<td>
							{$order.seller_name}{if $order.manage_mode eq 'self'}
							<span class="ecjiafc-red">（自营）</span>{/if}
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
						<td class="no-records" colspan="{if $filter.extension_code eq 'group_buy'}9{else}7{/if}">没有找到任何记录</td>
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
