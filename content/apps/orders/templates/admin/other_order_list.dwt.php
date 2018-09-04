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
		<a class="btn plus_or_reply show_order_search" href="javascript:;">
			<i class="fontello-icon-search"></i>高级查询</a>
	</h3>
</div>

<!-- #BeginLibraryItem "/library/order_search.lbi" -->
<!-- #EndLibraryItem -->

<div class="row-fluid batch" >
	<form action="{$search_url}
		{if $filter.extension_code}&extension_code={$filter.extension_code}{/if}
		{if $filter.composite_status}&composite_status={$filter.composite_status}{/if}
		" name="searchForm" method="post" >
		<ul class="nav nav-pills f_l">
			<li class="{if $filter.composite_status eq ''}active{/if}">
				<a class="data-pjax" href="{$search_url}
					{if $filter.extension_code}&extension_code={$filter.extension_code}{/if}
					{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
					{if $filter.keywords}&keywords={$filter.keywords}{/if}
					">{lang key='orders::order.all'} 
					<span class="badge badge-info">{if $count.all}{$count.all}{else}0{/if}</span> 
				</a>
			</li>
			{if $filter.extension_code eq 'storebuy'}
			<li class="{if $filter.composite_status eq 102}active{/if}">
				<a class="data-pjax" href="{$search_url}
					{if $filter.extension_code}&extension_code={$filter.extension_code}{/if}
					&composite_status=102
					{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
					{if $filter.keywords}&keywords={$filter.keywords}{/if}
					">已完成
					<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span> 
				</a>
			</li>
			{/if}
			
			{if $filter.extension_code eq 'storepickup'}
			<li class="{if $filter.composite_status eq 101}active{/if}">
				<a class="data-pjax" href="{$search_url}
					{if $filter.extension_code}&extension_code={$filter.extension_code}{/if}
					&composite_status=101
					{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
					{if $filter.keywords}&keywords={$filter.keywords}{/if}
					">未提货
					<span class="badge badge-info">{if $count.await_ship}{$count.await_ship}{else}0{/if}</span> 
				</a>
			</li>
			<li class="{if $filter.composite_status eq 102}active{/if}">
				<a class="data-pjax" href="{$search_url}
					{if $filter.extension_code}&extension_code={$filter.extension_code}{/if}
					&composite_status=102
					{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
					{if $filter.keywords}&keywords={$filter.keywords}{/if}
					">已提货
					<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span> 
				</a>
			</li>			
			{/if}
			
			<li class="{if $filter.composite_status eq 100}active{/if}">
				<a class="data-pjax" href="{$search_url}
					{if $filter.extension_code}&extension_code={$filter.extension_code}{/if}
					&composite_status=100
					{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
					{if $filter.keywords}&keywords={$filter.keywords}{/if}
					">待付款
					<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span> 
				</a>
			</li>
		</ul>
	
		<div class="choose_list f_r" >
			<input type="text" name="merchant_keywords" value="{$filter.merchant_keywords}" placeholder="{lang key='orders::order.enter_merchant_keywords'}"/> 
			<input type="text" name="keywords" value="{$filter.keywords}" placeholder="请输入订单编号或购买者姓名"/> 
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
						<th class="w150">{lang key='orders::order.merchants_name'}</th>
						<th class="w150">{lang key='orders::order.order_time'}</th>
						<th class="w150">购买者信息</th>
						<th class="w150">{lang key='orders::order.total_fee'}</th>
						<th class="w110">{lang key='orders::order.order_amount'}</th>
						<th class="w100">{lang key='orders::order.all_status'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.order_list item=order key=okey} -->
					<tr>
						<td class="hide-edit-area">
							{$order.order_sn}{if $order.extension_code eq "group_buy"}{lang key='orders::order.group_buy'}{elseif $order.extension_code eq "exchange_goods"}{lang key='orders::order.exchange_goods'}{/if}
							<div class="edit-list">
								<a href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' class="data-pjax" title="{lang key='orders::order.detail'}">{lang key='orders::order.detail'}</a>
								{if $order.can_remove}
								&nbsp;|&nbsp;
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{lang key='orders::order.confirm_delete_order'}' href='{url path="orders/admin/remove_order" args="order_id={$order.order_id}"}' title="{lang key='orders::order.op_remove'}">{lang key='orders::order.op_remove'}</a>
								{/if}
							</div>
						</td>
						<td>
							{$order.seller_name}{if $order.manage_mode eq 'self'}<span class="ecjiafc-red">（自营）</span>{/if}
						</td>
						<td>
							{$order.order_time}
						</td>
						<td align="left">
							{$order.consignee}
						</td>
						<td align="right" valign="top" nowrap="nowrap">{$order.formated_total_fee}</td>
						<td align="right" valign="top" nowrap="nowrap">{$order.formated_order_amount}</td>
						<td align="center" valign="top" nowrap="nowrap">{$order.label_order_status}</td>
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
<form action="{$form_action}" name="orderpostForm" id="listForm" data-pjax-url="{$search_action}" method="post"></form>
<!-- {/block} -->