<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_check.init();
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
	<ul class="">
		<li class="step-first">
			<div class="{if $is_paid neq 1}step-cur{else}step-done{/if}">
				<div class="step-no">{if $account_info.is_paid neq 1}1{/if}</div>
				<div class="m_t5">{if $account_info.is_paid eq 0}未确认{else if $account_info.is_paid eq 1}已确认{else if $account_info.is_paid eq 2}<span class="ecjiafc-red">已取消</span>{/if}</div>
				<div class="m_t5 ecjiafc-blue">{if $account_info.is_paid neq 2}{$account_info.add_time}{else}{$account_info.review_time}{/if}</div>
			</div>
		</li>
		<li>
			<div class="{if $is_paid eq 1}step-done{/if}">
				<div class="step-no">2</div>
				<div class="m_t5">{if $account_info.is_paid eq 1}已付款{else}未付款{/if}</div>
				<div class="m_t5 ecjiafc-blue">{$account_info.pay_time}</div>
			</div>
		</li>
		<li class="step-last">
			<div class="{if $is_paid eq 1}step-cur{else}step-done{/if}">
				<div class="step-no">3</div>
				<div class="m_t5">{if $account_info.is_paid eq 1}已完成{else}未完成{/if}</div>
				<div class="m_t5 ecjiafc-blue">{$account_info.review_time}</div>
			</div>
		</li>
	</ul>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
					<strong>订单信息</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic1">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>订单编号：</strong></div></td>
							<td>{$account_info.order_sn}</td>
							<td><div align="right"><strong>状态：</strong></div></td>
							<td>{if $account_info.is_paid eq 0}待审核{else if $account_info.is_paid eq 1}已完成{else}已取消{/if}</td>
						</tr>

						<tr>
							<td><div align="right"><strong>{lang key='user::user_account.label_user_id'}</strong></div></td>
							<td>
								{if $account_info.user_name}
									{$account_info.user_name}
								{else}
									{lang key='user::user_account.anonymous_member'}
								{/if}
							</td>
							<td><div align="right"><strong>充值金额：</strong></div></td>
							<td>{$account_info.formated_amount}</td>				
						</tr>

						<tr>
							<td><div align="right"><strong>充值方式：</strong></div></td>
							<td>{if $account_info.pay_name}{$account_info.pay_name}{else}银行转账{/if}</td>
							<td><div align="right"><strong>申请时间：</strong></div></td>
							<td>{$account_info.add_time}</td>
						</tr>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		{if $is_paid eq 0}
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic2">
					<strong>订单操作</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic2">
				<form class="form-horizontal" method="post" action="{if $account_info.is_paid neq 1}{$check_action}{else}{$form_action}{/if}" name="theForm">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>备注信息：</strong></div></td>
								<td colspan="3">
									<textarea class="span10" name="admin_note" cols="55" rows="6" placeholder="请输入审核备注信息">{$account_info.admin_note}</textarea>
								</td>
							</tr>
							
							<tr>
								<td><div align="right"><strong>操作：</strong></div></td>
								<td>
								{if $id}
									<input type="hidden" name="id" value="{$id}" />
									<input type="hidden" name="user_name" value="{$account_info.user_name}" />
									<input class="btn btn-gebo" type="submit" name="confirm" value="同意" />
									<input class="btn" type="submit" value="取消" />
								{else}
									<input class="btn btn-gebo" type="submit" value="{lang key='system::system.button_submit'}" />
								{/if}
								</td>
							</tr>
						</tbody>
					</table>
				</form>	
			</div>
		</div>
		{else}
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic2">
					<strong>平台审核操作</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic2">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>操作人：</strong></div></td>
							<td>{$account_info.admin_user}</td>
							<td><div align="right"><strong>审核时间：</strong></div></td>
							<td>{$account_info.review_time}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>审核备注：</strong></div></td>
							<td colspan="3">{$account_info.admin_note}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		{/if}
	</div>
</div>

<!-- {/block} -->