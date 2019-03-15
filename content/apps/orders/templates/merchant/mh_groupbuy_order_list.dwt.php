<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var date = '';
	ecjia.merchant.order.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2>
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>
	</div>
	<div class="pull-right">
		<a href="javascript:;" class="btn btn-primary show_order_search">
			<i class="fa fa-search"></i> {t domain="orders"}高级查询{/t}
		</a>
	</div>
	<div class="clearfix"></div>
</div>

<!-- #BeginLibraryItem "/library/order_operate.lbi" -->
<!-- #EndLibraryItem -->

<!-- #BeginLibraryItem "/library/order_search.lbi" -->
<!-- #EndLibraryItem -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills">
					<li class="{if $filter.composite_status eq ''}active{/if}">
						<a class="data-pjax" href="{RC_Uri::url('orders/merchant/init')}
							{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">{t domain="orders"}全部{/t}
							<span class="badge badge-info">{if $count.all}{$count.all}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 100}active{/if}">
						<a class="data-pjax" href="{RC_Uri::url('orders/merchant/init')}
							{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}
							&composite_status=100
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">{t domain="orders"}待付款{/t}
							<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 101}active{/if}">
						<a class="data-pjax" href="{RC_Uri::url('orders/merchant/init')}
							{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}
							&composite_status=101
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">{t domain="orders"}待发货{/t}
							<span class="badge badge-info">{if $count.await_ship}{$count.await_ship}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 104}active{/if}">
						<a class="data-pjax" href="{RC_Uri::url('orders/merchant/init')}
							{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}
							&composite_status=104
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">{t domain="orders"}待收货{/t}
							<span class="badge badge-info">{if $count.shipped}{$count.shipped}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 102}active{/if}">
						<a class="data-pjax" href="{RC_Uri::url('orders/merchant/init')}
							{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}
							&composite_status=102
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">{t domain="orders"}已完成{/t}
							<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span>
						</a>
					</li>
				</ul>
			</div>

			<div class='col-lg-12 panel-heading form-inline'>
				<div class="btn-group form-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-cogs"></i> {t domain="orders"}批量操作{/t}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu operate_note" data-url='{url path="orders/merchant/operate_note"}'>
						<li>
							<a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}&operation=confirm"
							    data-msg='{t domain="orders"}您确定要审批这些订单吗？{/t}' data-noSelectMsg='{t domain="orders"}请选择需要操作的订单{/t}'
							    href="javascript:;">
								<i class="fa fa-check"></i> 接单</a>
						</li>
						<li>
							<a class="batch-operate batch-operate-cancel" data-operatetype="cancel" data-url="{$form_action}&operation=cancel" data-cancel-msg='{t domain="orders"}您确定要取消这些订单吗？{/t}'
							    href="javascript:;">
								<i class="fa fa-times"></i> {t domain="orders"}取消{/t}</a>
						</li>
						<li>
							<a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}&operation=remove"
							    data-msg='{t domain="orders"}删除订单将清除该订单的所有信息。您确定要这么做吗？{/t}' href="javascript:;">
								<i class="fa fa-trash-o"></i> {t domain="orders"}删除{/t}</a>
						</li>
						<li>
							<a class="batch-print" data-url="{$form_action}&print=1" href="javascript:;">
								<i class="fa fa-print"></i> {t domain="orders"}打印订单{/t}</a>
						</li>
					</ul>
				</div>
				<div class="form-group">
					<select class="w180" name="status" id="select-rank">
						<option value="-1">{t domain="orders"}订单状态{/t}</option>
						<!-- {html_options options=$status_list selected=$filter.composite_status } -->
					</select>
				</div>
				<button class="btn btn-primary screen-btn" type="button">
					<i class="fa fa-search"></i> {t domain="orders"}筛选{/t} </button>
				<form class="form-inline pull-right" action="{RC_Uri::url('orders/merchant/init')}
					{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}
					" method="post" name="searchForm">
					<div class="form-group">
						<input type="text" class="form-control w230" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="orders"}请输入订单编号或购买者信息{/t}'>
					</div>
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-search"></i> {t domain="orders"}搜索{/t}</button>
				</form>
			</div>

			<div class="panel-body">
				<div class="row-fluid">
					<section class="panel">
						<table class="table table-striped table-hide-edit">
							<thead>
								<tr>
									<th class="table_checkbox check-list w30">
										<div class="check-item">
											<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox" />
											<label for="checkall"></label>
										</div>
									</th>
									<th class="w130">{t domain="orders"}订单编号{/t}</th>
									<th class="w150">{t domain="orders"}下单时间{/t}</th>
									<th class="w150">{t domain="orders"}购买者信息{/t}</th>
									<th class="w120">{t domain="orders"}总金额{/t}</th>
									<th class="w110">{t domain="orders"}保证金{/t}</th>
									<th class="w110">{t domain="orders"}应付金额{/t}</th>
									<th class="w110">{t domain="orders"}团购状态{/t}</th>
									<th class="w80">{t domain="orders"}订单状态{/t}</th>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$order_list.order_list item=order key=okey} -->
								<tr>
									<td class="check-list">
										<div class="check-item">
											<input id="check_{$order.order_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$order.order_id}" />
											<label for="check_{$order.order_id}"></label>
										</div>
									</td>
									<td class="hide-edit-area">
										{$order.order_sn}
										<div class="edit-list">
											<a href='{url path="orders/merchant/info" args="order_id={$order.order_id}"}' class="data-pjax" title='{t domain="orders"}查看{/t}'>{t domain="orders"}查看详情{/t}</a>
											{if $order.can_remove} &nbsp;|&nbsp;
											<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="orders" 1="{$order.order_sn}"}您确定要删除订单[ %1 ]吗？{/t}'
                                               href='{url path="orders/merchant/remove_order" args="order_id={$order.order_id}"}' title='{t domain="orders"}移除{/t}'>{t domain="orders"}移除{/t}</a>
											{/if}
										</div>
									</td>
									<td>
										{$order.order_time}
									</td>
									<td align="left">
										{$order.consignee}
									</td>
									<td>{$order.formated_total_fee}</td>
									<td>{$order.formated_bond}</td>
									<td>{$order.formated_order_amount}</td>
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
									<td {if $order.pay_status eq $payed}class="ecjiafc-red" {/if}>{$order.label_order_status}</td>
								</tr>
								<!-- {foreachelse}-->
								<tr>
									<td class="no-records" colspan="10">{t domain="orders"}没有找到任何记录{/t}</td>
								</tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
					</section>
					<div>
						<!-- {$order_list.page} -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<form action="{$form_action}" name="orderpostForm" id="listForm" data-pjax-url="{$search_action}" method="post"></form>
<!-- {/block} -->