<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">

</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="panel panel-body">
	<div class="quickpay-time-base">
		<ul class="">
			<li class="step-first">
				<div class="{if $status eq 1}step-cur{/if} {if $status eq 2 || $status eq 3}step-done{/if}">
					<div class="step-no">{if $status eq 1}1{/if}</div>
					<div class="m_t5">{t domain="commission"}提交申请{/t}</div>
					<div class="m_t5 ecjiafc-blue">{$data.add_time}</div>
				</div>
			</li>
			<li class="step-last">
				<div class="{if $status eq 2 || $status eq 3}step-cur{/if}">
					<div class="{if $status eq 3}step-failed{else}step-no{/if}">2</div>
					<div class="m_t5">
						{if $status eq 1}
                        {t domain="commission"}等待平台审核{/t}
						{else if $status eq 2}
                        {t domain="commission"}平台审核，打款完成{/t}
						{else if $status eq 3}
                        {t domain="commission"}已拒绝{/t}
						{/if}
					</div>
					{if $status eq 2 || $status eq 3}
					<div class="m_t5 ecjiafc-blue">{$data.audit_time}</div>
					{/if}
				</div>
			</li>
		</ul>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div id="accordion2" class="panel panel-default">
			<div class="panel-heading">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					<h4 class="panel-title"><strong>{t domain="commission"}基本信息{/t}</strong></h4>
				</a>
			</div>
			<div class="accordion-body in collapse" id="collapseOne">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>{t domain="commission"}流水号：{/t}</strong></div></td>
							<td>{$data.order_sn}</td>
							<td><div align="right"><strong>{t domain="commission"}状态：{/t}</strong></div></td>
							<td>{if $data.status eq 1}{t domain="commission"}待审核{/t}{else if $data.status eq 2}{t domain="commission"}已审核{/t}{else if $data.status eq 3}{t domain="commission"}已拒绝{/t}{/if}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="commission"}提现金额：{/t}</strong></div></td>
							<td class="amount_price">{$data.amount}</td>
							<td><div align="right"><strong>{t domain="commission"}提现方式：{/t}</strong></div></td>
							<td>{if $data.account_type eq 'bank'}{t domain="commission"}银行卡{/t}{else if $data.account_type eq 'alipay'}{t domain="commission"}支付宝{/t}{/if}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="commission"}收款账号：{/t}</strong></div></td>
							<td>{$data.bank_name} ({$data.account_number})</td>
							<td><div align="right"><strong>{t domain="commission"}申请时间：{/t}</strong></div></td>
							<td>{$data.add_time}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="commission"}申请内容：{/t}</strong></div></td>
							<td colspan="3">{$data.staff_note}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
		{if $data.status neq 1}
		<div id="accordion2" class="panel panel-default">
			<div class="panel-heading">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
					<h4 class="panel-title"><strong>{t domain="commission"}平台审核操作{/t}</strong></h4>
				</a>
			</div>
			<div class="accordion-body in collapse" id="collapseTwo">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>{t domain="commission"}操作人：{/t}</strong></div></td>
							<td>{$data.admin_name}</td>
							<td><div align="right"><strong>{t domain="commission"}审核时间：{/t}</strong></div></td>
							<td>{$data.add_time}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="commission"}审核备注：{/t}</strong></div></td>
							<td colspan="3">{$data.admin_note}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		{/if}
	</div>
</div>
<!-- {/block} -->