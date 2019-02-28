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
			<i class="fontello-icon-search"></i>{t domain="orders"}高级查询{/t}</a>
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
					">{t domain="orders"}全部{/t}
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
					">{t domain="orders"}已完成{/t}
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
					">{t domain="orders"}未提货{/t}
					<span class="badge badge-info">{if $count.await_ship}{$count.await_ship}{else}0{/if}</span> 
				</a>
			</li>
			<li class="{if $filter.composite_status eq 102}active{/if}">
				<a class="data-pjax" href="{$search_url}
					{if $filter.extension_code}&extension_code={$filter.extension_code}{/if}
					&composite_status=102
					{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
					{if $filter.keywords}&keywords={$filter.keywords}{/if}
					">{t domain="orders"}已提货{/t}
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
					">{t domain="orders"}待付款{/t}
					<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span> 
				</a>
			</li>
		</ul>
	
		<div class="choose_list f_r" >
			<input type="text" name="merchant_keywords" value="{$filter.merchant_keywords}" placeholder='{t domain="orders"}请输入商家名称关键字{/t}'/>
			<input type="text" name="keywords" value="{$filter.keywords}" placeholder='{t domain="orders"}请输入订单编号或购买者姓名{/t}'/>
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
						<th class="w150">{t domain="orders"}商家名称{/t}</th>
						<th class="w150">{t domain="orders"}下单时间{/t}</th>
						<th class="w150">{t domain="orders"}购买者信息{/t}</th>
						<th class="w150">{t domain="orders"}总金额{/t}</th>
						<th class="w110">{t domain="orders"}应付金额{/t}</th>
						<th class="w100">{t domain="orders"}订单状态{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.order_list item=order key=okey} -->
					<tr>
						<td class="hide-edit-area">
							{$order.order_sn}{if $order.extension_code eq "group_buy"}<span class="groupbuy-icon">{t domain="orders"}团{/t}</span>{elseif $order.extension_code eq "exchange_goods"}{t domain="orders"}（积分兑换）{/t}{/if}
							<div class="edit-list">
								<a href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' class="data-pjax" title='{t domain="orders"}查看{/t}'>{t domain="orders"}查看{/t}</a>
								{if $order.can_remove}
								&nbsp;|&nbsp;
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="orders"}您确定要删除该订单么？{/t}' href='{url path="orders/admin/remove_order" args="order_id={$order.order_id}"}' title='{t domain="orders"}删除{/t}'>{t domain="orders"}删除{/t}</a>
								{/if}
							</div>
						</td>
						<td>
							{$order.seller_name}{if $order.manage_mode eq 'self'}<span class="ecjiafc-red">{t domain="orders"}（自营）{/t}</span>{/if}
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
					<tr><td class="no-records" colspan="9">{t domain="orders"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$order_list.page} -->	
		</div>
	</div>
</div>
<form action="{$form_action}" name="orderpostForm" id="listForm" data-pjax-url="{$search_action}" method="post"></form>
<!-- {/block} -->