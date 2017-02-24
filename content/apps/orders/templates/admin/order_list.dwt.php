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
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class=" fontello-icon-search"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<!-- #BeginLibraryItem "/library/order_operate.lbi" --><!-- #EndLibraryItem -->

<ul class="nav nav-pills">
	<li class="{if $filter.type eq ''}active{/if}">
		<a class="data-pjax" href='{url path="orders/admin/init" args="{if $filter.composite_status !== '' && $filter.composite_status != -1}&composite_status={$filter.composite_status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}"}'>{lang key='orders::order.all'} 
			<span class="badge badge-info">{if $count.count}{$count.count}{else}0{/if}</span> 
		</a>
	</li>
	<li class="{if $filter.type eq 'self'}active{/if}">
		<a class="data-pjax" href='{url path="orders/admin/init" args="type=self{if $filter.composite_status !== '' && $filter.composite_status != -1}&composite_status={$filter.composite_status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}"}'>{lang key='orders::order.self'}
			<span class="badge badge-info">{if $count.self}{$count.self}{else}0{/if}</span> 
		</a>
	</li>
</ul>

<div class="row-fluid batch" >
	<form action="{$search_action}{if $filter.type}&type={$filter.type}{/if}" name="searchForm" method="post" >
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='orders::order.bulk_operations'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu operate_note" data-url='{url path="orders/admin/operate_note"}'>
				<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}&operation=confirm" data-msg="{lang key='orders::order.confirm_approval_order'}" data-noSelectMsg="{lang key='orders::order.pls_select_order'}" href="javascript:;"><i class="fontello-icon-ok"></i>{lang key='orders::order.op_confirm'}</a></li>
				<li><a class="batch-operate batch-operate-invalid" data-operatetype="invalid" data-url="{$form_action}&operation=invalid" data-invalid-msg="{lang key='orders::order.confirm_order_invalid'}" href="javascript:;"><i class="fontello-icon-block"></i>{lang key='orders::order.op_invalid'}</a></li>
				<li><a class="batch-operate batch-operate-cancel" data-operatetype="cancel" data-url="{$form_action}&operation=cancel" data-cancel-msg="{lang key='orders::order.confirm_order_cancel'}" href="javascript:;"><i class="fontello-icon-cancel"></i>{lang key='orders::order.op_cancel'}</a></li>
				<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}&operation=remove" data-msg="{lang key='orders::order.remove_confirm'}" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='system::system.remove'}</a></li>
				<li><a class="batch-print" data-url="{$form_action}&print=1" href="javascript:;"><i class="fontello-icon-print"></i>{lang key='orders::order.print_order'}</a></li>
			</ul>
			<input name="batch" type="hidden" value="1" />
		</div>
		<!-- 订单状态-->
		<select class="down-menu w120" name="status" id="select-rank">
			<option value="-1">{lang key='orders::order.all_status'}</option>
			<!-- {html_options options=$status_list selected=$order_list.filter.composite_status } -->
		</select>
		<a class="btn m_l5 screen-btn">{t}筛选{/t}</a>
		<div class="choose_list f_r" >
			<input type="text" name="merchant_keywords" value="{$order_list.filter.merchant_keywords}" placeholder="{lang key='orders::order.enter_merchant_keywords'}"/> 
			<input type="text" name="keywords" value="{$order_list.filter.keywords}" placeholder="{lang key='orders::order.pls_consignee'}"/> 
			<button class="btn" type="submit">{lang key='orders::order.search_order'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr>
						<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox" /></th>
						<th class="w100">{lang key='orders::order.order_sn'}</th>
						<th class="w100">{lang key='orders::order.merchants_name'}</th>
						<th class="w120">{lang key='orders::order.order_time'}</th>
						<th>{lang key='orders::order.user_purchase_information'}</th>
						<th class="w120">{lang key='orders::order.total_fee'}</th>
						<th class="w110">{lang key='orders::order.order_amount'}</th>
						<th class="w150">{lang key='orders::order.all_status'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.orders item=order key=okey} -->
					<tr>
						<td><input type="checkbox" class="checkbox" name="order_id[]"  value="{$order.order_id}" /></td>
						<td class="hide-edit-area">
							{$order.order_sn}{if $order.extension_code eq "group_buy"}{lang key='orders::order.group_buy'}{elseif $order.extension_code eq "exchange_goods"}{lang key='orders::order.exchange_goods'}{/if}
							{if $order.stet eq 1}<font style="color:#0e92d0;">{lang key='orders::order.child_order'}</font>{elseif $order.stet eq 2}<font style="color:#F00;"><span data-original-title="{foreach from=$order.children_order item=val}{$val};{/foreach}" data-toggle="tooltip">{lang key='orders::order.main_order'}</span></font>{/if}
							<div class="edit-list">
								<a href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' class="data-pjax" title="{lang key='orders::order.detail'}">{lang key='orders::order.detail'}</a>
								{if $order.can_remove}
								&nbsp;|&nbsp;
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{lang key='orders::order.confirm_delete_order'}' href='{url path="orders/admin/remove_order" args="order_id={$order.order_id}"}' title="{lang key='orders::order.op_remove'}">{lang key='orders::order.op_remove'}</a>
								{/if}
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
						<td align="right" valign="top" nowrap="nowrap">{$order.formated_order_amount}</td>
						<td align="center" valign="top" nowrap="nowrap">{$os[$order.order_status]},{$ps[$order.pay_status]},{$ss[$order.shipping_status]}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$order_list.page} -->	
		</div>
	</div>
</div>
<!-- {/block} -->