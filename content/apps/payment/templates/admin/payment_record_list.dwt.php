<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.payment_list.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<!-- {if $ur_here}{/if} -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid batch" >
	<div class="choose_list span12">
		<form class="f_l" name="searchdateForm" action='{url path="payment/admin_payment_record/init"}' method="post">
			<input class="date f_l w100" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder='{t domain="payment"}开始日期{/t}'>
			<span class="f_l">{t domain="payment"}至{/t}</span>
			<input class="date f_l w100" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder='{t domain="payment"}结束日期{/t}'>
			<button class="btn select-button" type="button">{t domain="payment"}筛选{/t}</button>
		</form>
		<form method="post" action='{url path="payment/admin_payment_record/init"}{if $filter.start_date}&start_date={$filter.start_date}{/if}{if $filter.end_date}&end_date={$filter.end_date}{/if}' name="searchForm">
			<div class="top_right f_r" >
				<input class="w130" type="text" name="order_sn" value="{$smarty.get.order_sn}" placeholder='{t domain="payment"}请输入商城订单编号{/t}'/>
				<input class="w200" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="payment"}请输入支付订单号或流水号{/t}'/>
				<button class="btn m_l5" type="submit">{t domain="payment"}搜索{/t}</button>
			</div>
			<div class="f_r m_r5">
				<select class="w150" name="pay_status">
					<option value="0">{t domain="payment"}请选择交易状态{/t}</option>
					<option value="1" {if $smarty.get.pay_status eq 1}selected{/if}>{t domain="payment"}等待付款{/t}</option>
					<option value="2" {if $smarty.get.pay_status eq 2}selected{/if}>{t domain="payment"}付款成功{/t}</option>
				</select>
			</div>
		</form>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w130">{t domain="payment"}商城订单编号{/t}</th>
					<th class="w100">{t domain="payment"}交易类型{/t}</th>
					<th class="w200">{t domain="payment"}支付订单号 / 流水号{/t}</th>
					<th class="w110">{t domain="payment"}支付名称{/t}</th>
					<th class="w110">{t domain="payment"}支付金额{/t}</th>
					<th class="w130">{t domain="payment"}创建时间 / 付款时间{/t}</th>
					<th class="w100">{t domain="payment"}交易状态{/t}</th>
				</tr>
			</thead>

			<!-- {foreach from=$modules.item item=list} -->
			<tr>
				<td class="hide-edit-area">{$list.order_sn}
					<div class="edit-list">
						<a href='{url path="payment/admin_payment_record/info" args="id={$list.id}"}' class="data-pjax" title='{t domain="payment"}查看{/t}'>{t domain="payment"}查看{/t}</a>
					</div>
				</td>
				<td>{$list.trade_type}</td>
				<td>{$list.order_trade_no}<br>{$list.trade_no}</td>
				<td>{$list.pay_name}</td>
				<td>{$list.total_fee}</td>
				<td>{$list.create_time}<br>{$list.pay_time}</td>
				<td>{$list.pay_status}</td>
			</tr>
			<!-- {foreachelse} -->
			<td class="no-records" colspan="7">{t domain="payment"}没有找到任何记录{/t}</td>
            <!-- {/foreach} -->
		</table>
		<!-- {$modules.page} -->	
	</div>
</div>
<!-- {/block} -->