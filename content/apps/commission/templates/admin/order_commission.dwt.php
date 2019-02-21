<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_com.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<p><strong>{t domain="commission"}温馨提示：{/t}</strong></p>
	<p>1.{t domain="commission"}请谨慎使用，防止重复结算；{/t}</p>
	<p>2.{t domain="commission"}“结算”：未结算订单使用，进行结算并更新账户金额和结算状态；{/t}</p>
	<p>3.{t domain="commission"}“已结算”：已结算过订单更新状态。{/t}</p>
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
					<strong>{t domain="commission"}基本信息{/t}</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic1">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>{t domain="commission"}订单号：{/t}</strong></div></td>
							<td>{$info.order_sn} {if $info.order_type eq 'buy'}
                                {t domain="commission"}购物订单{/t}
						{else if $info.order_type eq 'refund'}
                                {t domain="commission"}退款{/t}
						{else if $info.order_type eq 'quickpay'}
                                {t domain="commission"}优惠买单{/t}
						{/if}</td>
							<td><div align="right"><strong>{t domain="commission"}状态：{/t}</strong></div></td>
							<td>{if $info.bill_status eq 0}{t domain="commission"}未结算{/t}{else if $info.bill_status eq 1}{t domain="commission"}已结算{/t} ({$info.bill_time}){/if}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="commission"}商家名称：{/t}</strong></div></td>
							<td><a href='{url path="store/admin/preview" args="store_id={$info.store_id}"}' >{$info.merchants_name}</a></td>
							<td><div align="right"><strong>{t domain="commission"}佣金比例：{/t}</strong></div></td>
							<td>{$info.percent_value}</td>			
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="commission"}订单金额：{/t}</strong></div></td>
							<td class="amount_price">{$info.order_amount}</td>
							<td><div align="right"><strong>{t domain="commission"}佣金金额：{/t}</strong></div></td>
							<td class="amount_price">{$info.brokerage_amount}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
    	<form class="form-horizontal" method="post" action="{$form_action}" name="theForm">
    	{if $info.bill_status neq 1}
    		<input type="hidden" name="detail_id" value="{$info.detail_id}">
    		<input class="btn btn-gebo" type="submit" name="agree" value="{t domain="commission"}结算{/t}" />
    		<input class="btn m_l10" type="submit" name="refuse" value="{t domain="commission"}已结算{/t}" />
    	{/if}
    	</form>
	</div>
</div>

<!-- {/block} -->