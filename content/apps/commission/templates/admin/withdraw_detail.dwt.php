<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.withdraw.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="order-status-base m_b20">
	<div class="quickpay-time-base">
		<ul class="">
			<li class="step-first">
				<div class="{if $status eq 1}step-cur{/if} {if $status eq 2 || $status eq 3}step-done{/if}">
					<div class="step-no">{if $status eq 1}1{/if}</div>
					<div class="m_t5">提交申请</div>
					<div class="m_t5 ecjiafc-blue">{$data.add_time}</div>
				</div>
			</li>
			<li class="step-last">
				<div class="{if $status eq 2 || $status eq 3}step-cur{/if}">
					<div class="{if $status eq 3}step-failed{else}step-no{/if}">2</div>
					<div class="m_t5">
						{if $status eq 1}
						等待审核
						{else if $status eq 2}
						已审核，打款完成
						{else if $status eq 3}
						已拒绝
						{/if}
					</div>
					{if $status eq 3 || $status eq 2}
					<div class="m_t5 ecjiafc-blue">{$data.audit_time}</div>
					{/if}
				</div>
			</li>
		</ul>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
					<strong>基本信息</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic1">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>流水号：</strong></div></td>
							<td>{$data.order_sn}</td>
							<td><div align="right"><strong>状态：</strong></div></td>
							<td>{if $data.status eq 1}待审核{else if $data.status eq 2}已审核{else if $data.status eq 3}已拒绝{/if}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>提现金额：</strong></div></td>
							<td class="amount_price">{$data.format_amount}</td>
							<td><div align="right"><strong>提现方式：</strong></div></td>
							<td>{if $data.account_type eq 'bank'}银行卡{else if $data.account_type eq 'alipay'}支付宝{/if}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>收款账号：</strong></div></td>
							<td>{$data.bank_name} ({$data.account_number})</td>
							<td><div align="right"><strong>申请时间：</strong></div></td>
							<td>{$data.add_time}</td>			
						</tr>
						<tr>
							<td><div align="right"><strong>申请内容：</strong></div></td>
							<td colspan="3">{$data.staff_note}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
	<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic2">
					<strong>可执行操作</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic2">
				<form class="form-horizontal" method="post" action="{$form_action}" name="fundForm">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							{if $status eq 1}
							<tr>
								<td><div align="right"><strong>备注信息：</strong></div></td>
								<td colspan="3">
									<textarea class="span10" name="admin_note" cols="55" rows="6">{$data.admin_note}</textarea>
									<span class="input-must">*</span>
								</td>
							</tr>
							<tr>
								<td><div align="right"></div></td>
								<td>
									<input type="hidden" name="id" value="{$data.id}">
									<input class="btn btn-gebo" type="submit" name="agree" value="同意" />
									<input class="btn m_l10" type="submit" name="refuse" value="拒绝" />
								</td>
							</tr>
							{/if}
							
							{if $status eq 2 || $status eq 3}
							<tr>
								<td><div align="right"><strong>操作人：</strong></div></td>
								<td>{$data.admin_name}</td>
								<td><div align="right"><strong>审核时间：</strong></div></td>
								<td>{$data.add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>审核备注：</strong></div></td>
								<td colspan="3">{$data.admin_note}</td>
							</tr>
							{/if}
						</tbody>
					</table>
				</form>	
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->