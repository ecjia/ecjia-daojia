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
		{if $order_model eq 'default'}
		<a href="{RC_Uri::url('orders/merchant/today_order')}" class="btn btn-primary nopjax" target="__blank">当天订单</a>
		{/if}
		{if $order_model eq 'storepickup'}
		<a href="{RC_Uri::url('orders/mh_validate_order/init')}" class="btn btn-primary nopjax">
			<i class="fa fa-search"></i> 验单查询
		</a>
		{/if}
		<a href="javascript:;" class="btn btn-primary show_order_search">
			<i class="fa fa-search"></i> 高级查询
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
					{if $order_model eq 'default'}
					<li class="{if $filter.composite_status eq ''}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}" href="{$search_url}">{lang key='orders::order.all'}
							<span class="badge badge-info">{if $count.all}{$count.all}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 100}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=100" href="{$search_url}&composite_status=100">待付款
							<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span>
						</a>
					</li>

					<li class="{if $filter.composite_status eq 105}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=105" href="{$search_url}&composite_status=105">待接单
							<span class="badge badge-info">{if $count.unconfirmed}{$count.unconfirmed}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 101}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=101" href="{$search_url}&composite_status=101">待发货
							<span class="badge badge-info">{if $count.await_ship}{$count.await_ship}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 104}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=104" href="{$search_url}&composite_status=104">待收货
							<span class="badge badge-info">{if $count.shipped}{$count.shipped}{else}0{/if}</span>
						</a>
					</li>

					<li class="{if $filter.composite_status eq 102}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=102" href="{$search_url}&composite_status=102">已完成
							<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span>
						</a>
					</li>
					{/if} 
					{if $order_model eq 'storebuy'}
					<li class="{if $filter.composite_status eq 102}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=102" href="{$search_url}&composite_status=102">已完成
							<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 100}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=100" href="{$search_url}&composite_status=100">待付款
							<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span>
						</a>
					</li>
					{/if} 
					{if $order_model eq 'storepickup'}
					<li class="{if $filter.composite_status eq 101 || !$filter.composite_status}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=101" href="{$search_url}&composite_status=101">未提货
							<span class="badge badge-info">{if $count.await_ship}{$count.await_ship}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 102}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=102" href="{$search_url}&composite_status=102">已提货
							<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 100}active{/if}">
						<a class="data-pjax" data-href="{RC_Uri::url('orders/merchant/init')}&composite_status=100" href="{$search_url}&composite_status=100">待付款
							<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span>
						</a>
					</li>
					{/if}
				</ul>
			</div>

			<div class='col-lg-12 panel-heading form-inline'>
				<div class="btn-group form-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-cogs"></i> {lang key='goods::goods.batch_handle'}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu operate_note" data-url='{url path="orders/merchant/operate_note"}'>
						{if $order_model eq 'default'}
						<li>
							<a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}&operation=confirm"
							    data-msg="{lang key='orders::order.confirm_approval_order'}" data-noSelectMsg="{lang key='orders::order.pls_select_order'}"
							    href="javascript:;">
								<i class="fa fa-check"></i> 接单</a>
						</li>
						<li>
							<a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}&operation=remove"
							    data-msg="{lang key='orders::order.remove_confirm'}" href="javascript:;">
								<i class="fa fa-trash-o"></i> {lang key='system::system.remove'}</a>
						</li>
						{/if}
						<li>
							<a class="batch-operate batch-operate-cancel" data-operatetype="cancel" data-url="{$form_action}&operation=cancel" data-cancel-msg="{lang key='orders::order.confirm_order_cancel'}"
							    href="javascript:;">
								<i class="fa fa-times"></i> {lang key='orders::order.op_cancel'}</a>
						</li>
						<li>
							<a class="batch-print" data-url="{$form_action}&print=1" href="javascript:;">
								<i class="fa fa-print"></i> {lang key='orders::order.print_order'}</a>
						</li>
					</ul>
				</div>
				{if $order_model eq 'default'}
				<div class="form-group">
					<select class="w180" name="status" id="select-rank">
						<option value="-1">{lang key='orders::order.all_status'}</option>
						<!-- {html_options options=$status_list selected=$filter.composite_status } -->
					</select>
				</div>
				<button class="btn btn-primary screen-btn" type="button">
					<i class="fa fa-search"></i> {lang key='orders::order.filter'} </button>
				{/if}
				<form class="form-inline pull-right" action="{RC_Uri::url('orders/merchant/init')}{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}{if $smarty.get.composite_status}&composite_status={$smarty.get.composite_status}{/if}"
				    method="post" name="searchForm">
					<div class="form-group">
						<input type="text" class="form-control w230" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入订单编号或购买者信息">
					</div>
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-search"></i> {lang key='orders::order.search'}</button>
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
									<th class="w130">订单编号</th>
									<th class="w180">{lang key='orders::order.order_time'}</th>
									<th class="w150">购买者信息</th>
									<th class="w120">{lang key='orders::order.total_fee'}</th>
									<th class="w110">{lang key='orders::order.order_amount'}</th>
									<th class="w150">{lang key='orders::order.all_status'}</th>
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
											<a href='{url path="orders/merchant/info" args="order_id={$order.order_id}"}' class="data-pjax" title="{lang key='orders::order.detail'}">{t}查看详情{/t}</a>
											{if $order.can_remove} &nbsp;|&nbsp;
											<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t name="{$order.order_sn}"}您确定要删除订单[ %1 ]吗？{/t}' href='{url path="orders/merchant/remove_order" args="order_id={$order.order_id}"}'
											    title="{t}移除{/t}">{t}移除{/t}</a>
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
									<td>{$order.formated_order_amount}</td>
									<td {if $order.pay_status eq 0}class="ecjiafc-red" {/if}>{$order.label_order_status}</td>
								</tr>
								<!-- {foreachelse}-->
								<tr>
									<td class="no-records" colspan="8">{lang key='system::system.no_records'}</td>
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
<form action="{$form_action}{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}" name="orderpostForm" id="listForm" data-pjax-url="{$search_action}" method="post"></form>
<!-- {/block} -->