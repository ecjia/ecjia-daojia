<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.payment_refund_list.init();
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
		<form class="f_l" name="searchdateForm" action='{url path="payment/admin_payment_refund/init"}' method="post">
			<input class="date f_l w100" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder='{t domain="payment"}开始日期{/t}'>
			<span class="f_l">{t domain="payment"}至{/t}</span>
			<input class="date f_l w100" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder='{t domain="payment"}结束日期{/t}'>
			<button class="btn select-button" type="button">{t domain="payment"}筛选{/t}</button>
		</form>
		<form method="post" action='{url path="payment/admin_payment_refund/init"}{if $filter.start_date}&start_date={$filter.start_date}{/if}{if $filter.end_date}&end_date={$filter.end_date}{/if}' name="searchForm">
			<div class="top_right f_r" >
				<input class="w130" type="text" name="order_sn" value="{$smarty.get.order_sn}" placeholder='{t domain="payment"}请输入订单号{/t}'/>
				<input class="w200" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="payment"}请输入退款流水号{/t}'/>
				<button class="btn m_l5" type="submit">{t domain="payment"}搜索{/t}</button>
			</div>
			<div class="f_r m_r5">
				<select class="w150" name="refund_status">
					<option value="">{t domain="payment"}请选择交易状态{/t}</option>
					<option value="wait" {if $filter.refund_status eq 'wait'}selected{/if}>{t domain="payment"}待处理{/t}</option>
					<option value="refunded" {if $filter.refund_status eq 'refunded'}selected{/if}>{t domain="payment"}已退款{/t}</option>
					<option value="processing" {if $filter.refund_status eq 'processing'}selected{/if}>{t domain="payment"}处理中{/t}</option>
					<option value="failed" {if $filter.get.refund_status eq 'failed'}selected{/if}>{t domain="payment"}退款失败{/t}</option>
					<option value="closed" {if $filter.get.refund_status eq 'closed'}selected{/if}>{t domain="payment"}退款关闭{/t}</option>
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
					<th class="w130">{t domain="payment"}订单号{/t}</th>
					<th class="w210">{t domain="payment"}订单退款流水号 / 支付公司退款流水号{/t}</th>
					<th class="w110">{t domain="payment"}支付名称{/t}</th>
					<th class="w110">{t domain="payment"}退款金额{/t}</th>
					<th class="w130">{t domain="payment"}创建时间 / 退款时间{/t}</th>
					<th class="w100">{t domain="payment"}退款状态{/t}</th>
				</tr>
			</thead>

			<!-- {foreach from=$payment_refund.list item=list} -->
			<tr>
				<td class="hide-edit-area">{$list.order_sn}
					<div class="edit-list">
						<a href='{url path="payment/admin_payment_refund/payment_refund_info" args="id={$list.id}"}' class="data-pjax" title='{t domain="payment"}查看{/t}'>{t domain="payment"}查看{/t}</a>
					</div>
				</td>
				<td>{$list.refund_out_no}<br>{$list.refund_trade_no}</td>
				<td>{$list.pay_name}</td>
				<td>{$list.refund_fee}</td>
				<td>{$list.refund_create_time}<br>{$list.refund_confirm_time}</td>
				<td>{$list.label_refund_status}</td>
			</tr>
			<!-- {foreachelse} -->
			<td class="no-records" colspan="6">{t domain="payment"}没有找到任何记录{/t}</td>
            <!-- {/foreach} -->
		</table>
		<!-- {$payment_refund.page} -->	
	</div>
</div>
<!-- {/block} -->