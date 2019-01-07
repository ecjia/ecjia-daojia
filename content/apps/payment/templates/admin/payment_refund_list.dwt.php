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
			<input class="date f_l w100" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="开始日期">
			<span class="f_l">至</span>
			<input class="date f_l w100" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="结束日期">
			<button class="btn select-button" type="button">筛选</button>
		</form>
		<form method="post" action='{url path="payment/admin_payment_refund/init"}{if $filter.start_date}&start_date={$filter.start_date}{/if}{if $filter.end_date}&end_date={$filter.end_date}{/if}' name="searchForm">
			<div class="top_right f_r" >
				<input class="w130" type="text" name="order_sn" value="{$smarty.get.order_sn}" placeholder="请输入订单号"/>
				<input class="w200" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入退款流水号"/>
				<button class="btn m_l5" type="submit">{lang key='user::users.serach'}</button>
			</div>
			<div class="f_r m_r5">
				<select class="w150" name="refund_status">
					<option value="">请选择交易状态</option>
					<option value="wait" {if $filter.refund_status eq 'wait'}selected{/if}>待处理</option>
					<option value="refunded" {if $filter.refund_status eq 'refunded'}selected{/if}>已退款</option>
					<option value="processing" {if $filter.refund_status eq 'processing'}selected{/if}>处理中</option>
					<option value="failed" {if $filter.get.refund_status eq 'failed'}selected{/if}>退款失败</option>
					<option value="closed" {if $filter.get.refund_status eq 'closed'}selected{/if}>退款关闭</option>
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
					<th class="w130">订单号</th>
					<th class="w210">订单退款流水号 / 支付公司退款流水号</th>
					<th class="w110">支付名称</th>
					<th class="w110">退款金额</th>
					<th class="w130">创建时间 / 退款时间</th>
					<th class="w100">退款状态</th>
				</tr>
			</thead>

			<!-- {foreach from=$payment_refund.list item=list} -->
			<tr>
				<td class="hide-edit-area">{$list.order_sn}
					<div class="edit-list">
						<a href='{url path="payment/admin_payment_refund/payment_refund_info" args="id={$list.id}"}' class="data-pjax" title="查看">查看</a>
					</div>
				</td>
				<td>{$list.refund_out_no}<br>{$list.refund_trade_no}</td>
				<td>{$list.pay_name}</td>
				<td>{$list.refund_fee}</td>
				<td>{$list.refund_create_time}<br>{$list.refund_confirm_time}</td>
				<td>{$list.label_refund_status}</td>
			</tr>
			<!-- {foreachelse} -->
			<td class="no-records" colspan="6">{t}没有找到任何记录{/t}</td>
            <!-- {/foreach} -->
		</table>
		<!-- {$payment_refund.page} -->	
	</div>
</div>
<!-- {/block} -->