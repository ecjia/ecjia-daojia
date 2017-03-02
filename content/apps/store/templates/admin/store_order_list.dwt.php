<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.commission.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		（佣金百分比：{$percent_value}&nbsp;佣金总金额：{if $order_list.filter.all_brokerage_amount}{$order_list.filter.all_brokerage_amount}{else}0{/if}）
		<!-- {if $action_link} -->
			<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<!-- 批量操作 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="choose_list f_r" >
			<span>开始时间：</span>
			<input type="text" class="w110 start_time" name="start_time" value="{$smarty.get.start_time}">
			<span>结束时间：</span>
			<input type="text" class="w100 end_time" name="end_time" value="{$smarty.get.end_time}"/> 
			<input type="submit" value="搜索" class="btn" />
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<div class="tab-content">
			<!-- system start -->
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead>
						<tr>
						    <th class="w100">{t}订单编号{/t}</th>
						    <th>{t}下单时间{/t}</th>
						    <th>{t}收货人{/t}</th>
						    <th>{t}总金额{/t}</th>
						    <th>{t}应付金额{/t}</th>
						    <th>{t}佣金金额{/t}</th>
						    <th class="w150">{t}订单状态{/t}</th>
						    <th class="w70">{t}结算状态{/t}</th>
						 </tr>
					</thead>
   				 	<!-- {foreach from=$order_list.item item=order} -->
					<tr>
						<td>{$order.order_sn}</td>
						<td>{$order.buyer|escape}<br/>{$order.short_order_time}</td>
						<td>{$order.consignee|escape}{if $order.tel} [TEL: {$order.tel|escape}]{/if} <br />{$order.address|escape}</td>
					    <td>{$order.formated_total_fee}</td>
					    <td>{$order.formated_order_amount}</td>
					    <td>{$order.formated_brokerage_amount}</td>
					    <td>{$lang.os[$order.order_status]},{$lang.ps[$order.pay_status]},{$lang.ss[$order.shipping_status]}</td>
					    <td><i class="{if $order.is_settlement}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url='{RC_Uri::url("store/admin_commission/toggle_state","id={$order.store_id}&order_sn={$order.order_sn}")}' data-id="{$order.order_id}"></i></td>
					</tr>
					<!-- {foreachelse} -->
				   <tr><td class="no-records" colspan="8">{t}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$order_list.page} -->
			</div>
		</div>
	</div>
</div> 
<!-- {/block} -->