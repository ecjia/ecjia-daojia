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
				<div class="m_t5">
					{if $account_info.is_paid eq 0}
					{t domain="withdraw"}未确认{/t}
					{else if $account_info.is_paid eq 1}
					{t domain="withdraw"}已确认{/t}
					{else if $account_info.is_paid eq 2}
					<span class="ecjiafc-red">
						{t domain="withdraw"}已取消{/t}
					</span>
					{/if}
				</div>
				<div class="m_t5 ecjiafc-blue">{if $account_info.is_paid neq 2}{$account_info.add_time}{else}{$account_info.review_time}{/if}</div>
			</div>
		</li>
		<li>
			<div class="{if $is_paid eq 1}step-done{/if}">
				<div class="step-no">2</div>
				<div class="m_t5">
					{if $account_info.is_paid eq 1}
					{t domain="withdraw"}已付款{/t}
					{else}
					{t domain="withdraw"}未付款{/t}
					{/if}
				</div>
				<div class="m_t5 ecjiafc-blue">{$account_info.pay_time}</div>
			</div>
		</li>
		<li class="step-last">
			<div class="{if $is_paid eq 1}step-cur{else}step-done{/if}">
				<div class="step-no">3</div>
				<div class="m_t5">
					{if $account_info.is_paid eq 1}
					{t domain="withdraw"}已完成{/t}
					{else}
					{t domain="withdraw"}未完成{/t}
					{/if}
				</div>
				{if $account_info.is_paid eq 1}
				<div class="m_t5 ecjiafc-blue">{$account_info.review_time}</div>
				{/if}
			</div>
		</li>
	</ul>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
					<strong>{t domain="withdraw"}订单信息{/t}</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic1">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}订单编号：{/t}</strong></div>
							</td>
							<td>{$account_info.order_sn}</td>
							<td>
								<div align="right"><strong>{t domain="withdraw"}状态：{/t}</strong></div>
							</td>
							<td>
								{if $account_info.is_paid eq 0}
								{t domain="withdraw"}待审核{/t}
								{else if $account_info.is_paid eq 1}
								{t domain="withdraw"}已完成{/t}
								{else}
								{t domain="withdraw"}已取消{/t}
								{/if}

								{if $account_info.is_paid eq 1}
								<a class="btn m_l5 withdraw_query" href="javascript:;" data-url="{RC_Uri::url('withdraw/admin/query')}&id={$account_info.id}">{t domain="withdraw"}对账查询{/t}</a>
								{/if}
							</td>
						</tr>

						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}会员名称：{/t}</strong></div>
							</td>
							<td>
								{if $account_info.user_name}
								{$account_info.user_name}
								{else}
								{t domain="withdraw"}匿名会员{/t}
								{/if}
								<a href="{RC_Uri::url('finance/admin_account_log/init')}&account_type=user_money&user_id={$account_info.user_id}" target="_blank">{t domain="withdraw"} [ 查看余额变动 ] {/t}</a>
							</td>
							<td>
								<div align="right"><strong>{t domain="withdraw"}申请金额：{/t}</strong></div>
							</td>
							<td>{$account_info.formated_apply_amount}</td>
						</tr>

						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}提现手续费：{/t}</strong></div>
							</td>
							<td>{$account_info.formated_pay_fee}</td>
							<td>
								<div align="right"><strong>{t domain="withdraw"}到账金额：{/t}</strong></div>
							</td>
							<td><strong class="ecjiafc-red ecjiaf-fs3">{$account_info.formated_real_amount}</strong></td>
						</tr>

						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}提现方式：{/t}</strong></div>
							</td>
							<td>
								{if $account_info.payment_name}{$account_info.payment_name}{else}{t domain="withdraw"}银行转账提现{/t}{/if}
							</td>
                            <td>
                                <div align="right"><strong>{t domain="withdraw"}收款人姓名：{/t}</strong></div>
                            </td>
                            <td>
                                <strong class="ecjiafc-red ecjiaf-fs3">{$account_info.user_name}</strong>
                            </td>
						</tr>

						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}申请时间：{/t}</strong></div>
							</td>
							<td>{$account_info.add_time}</td>
                            <td>
                                <div align="right"><strong>{t domain="withdraw"}提现账户：{/t}</strong></div>
                            </td>
                            <td>
                                <strong class="ecjiafc-red ecjiaf-fs3">{$account_info.formated_payment_name}</strong>
                            </td>
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
					<strong>{t domain="withdraw"}订单操作{/t}</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic2">
				<form class="form-horizontal" method="post" action="{$form_action}" name="theForm">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right"><strong>{t domain="withdraw"}备注信息：{/t}</strong></div>
								</td>
								<td colspan="3">
									<textarea class="span10" name="admin_note" cols="55" rows="6" placeholder='{t domain="withdraw"}请输入审核备注信息{/t}'>{$account_info.admin_note}</textarea>
								</td>
							</tr>

							<tr>
								<td>
									<div align="right"><strong>{t domain="withdraw"}操作：{/t}</strong></div>
								</td>
								<td>
									{if $id}
									<input type="hidden" name="id" value="{$id}" />
									<input type="hidden" name="user_name" value="{$account_info.user_name}" />
									<input class="btn btn-gebo" type="submit" name="confirm" value='{t domain="withdraw"}同意{/t}' />
									<input class="btn" type="submit" value='{t domain="withdraw"}取消{/t}' />
									{else}
									<input class="btn btn-gebo" type="submit" value='{t domain="withdraw"}确定{/t}' />
									{/if}
									<div class="m_t5">
										{t domain="withdraw"}【同意】操作后，同意并打款给当前用户；{/t}<br />
										{t domain="withdraw"}【取消】操作后，订单状态更改为“已取消”，提现金额返还给对应账号；{/t}
									</div>
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
					<strong>{t domain="withdraw"}平台审核操作{/t}</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic2">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}操作人：{/t}</strong></div>
							</td>
							<td>{$account_info.admin_user}</td>
							<td>
								<div align="right"><strong>{t domain="withdraw"}审核时间：{/t}</strong></div>
							</td>
							<td>{$account_info.review_time}</td>
						</tr>
						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}审核备注：{/t}</strong></div>
							</td>
							<td colspan="3">{$account_info.admin_note}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		{/if}
	</div>
</div>

{if $account_info.is_paid eq 1 && $record_info}
<div class="row-fluid">
	<div class="span12">
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
					<strong>{t domain="withdraw"}提现流水记录{/t}</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="telescopic1">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}商户单号：{/t}</strong></div>
							</td>
							<td>{$record_info.order_sn}</td>
							<td>
								<div align="right"><strong>{t domain="withdraw"}提现状态：{/t}</strong></div>
							</td>
							<td>{$record_info.label_withdraw_status}</td>
						</tr>
						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}支付公司单号：{/t}</strong></div>
							</td>
							<td>{$record_info.trade_no}</td>
							<td>
								<div align="right"><strong>{t domain="withdraw"}付款商户号：{/t}</strong></div>
							</td>
							<td>{$record_info.partner_id}</td>
						</tr>
						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}付款账号：{/t}</strong></div>
							</td>
							<td>{$record_info.account}</td>
							<td>
								<div align="right"><strong>{t domain="withdraw"}创建时间：{/t}</strong></div>
							</td>
							<td>{$record_info.create_time}</td>
						</tr>
						<tr>
							<td>
								<div align="right"><strong>{t domain="withdraw"}付款成功时间：{/t}</strong></div>
							</td>
							<td>{$record_info.payment_time}</td>
							<td>
								<div align="right"><strong>{t domain="withdraw"}转账时间：{/t}</strong></div>
							</td>
							<td>{$record_info.transfer_time}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
{/if}

<!-- {/block} -->