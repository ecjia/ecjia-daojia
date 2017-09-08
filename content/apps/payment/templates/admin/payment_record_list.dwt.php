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
	<form method="post" action='{url path="payment/admin_payment_record/init"}' name="searchForm">
		<div class="top_right f_r" >
			<input class="w130" type="text" name="order_sn" value="{$smarty.get.order_sn}" placeholder="{lang key='payment::payment.find_order_sn'}"/>
			<input class="w200" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入支付订单号或流水号"/>
			<button class="btn m_l5" type="submit">{lang key='user::users.serach'}</button>
		</div>
		<div class="f_r m_r5">
			<select class="w150" name="pay_status">
				<option value="0">请选择交易状态</option>
				<option value="1" {if $smarty.get.pay_status eq 1}selected{/if}>等待付款</option>
				<option value="2" {if $smarty.get.pay_status eq 2}selected{/if}>付款成功</option>
			</select>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w130">{lang key='payment::payment.order_sn'}</th>
					<th class="w100">{lang key='payment::payment.trade_type'}</th>
					<th class="w200">支付订单号 / 流水号</th>
					<th class="w110">{lang key='payment::payment.pay_name'}</th>
					<th class="w110">{lang key='payment::payment.total_fee'}</th>
					<th class="w130">{lang key='payment::payment.create_time'} / {lang key='payment::payment.pay_times'}</th>
					<th class="w100">{lang key='payment::payment.pay_status'}</th>
				</tr>
			</thead>

			<!-- {foreach from=$modules.item item=list} -->
			<tr>
				<td class="hide-edit-area">{$list.order_sn}
					<div class="edit-list">
						<a href='{url path="payment/admin_payment_record/info" args="id={$list.id}"}' class="data-pjax" title="{lang key='orders::order.detail'}">查看</a>
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
			<td class="no-records" colspan="7">{t}没有找到任何记录{/t}</td>
            <!-- {/foreach} -->
		</table>
		<!-- {$modules.page} -->	
	</div>
</div>
<!-- {/block} -->