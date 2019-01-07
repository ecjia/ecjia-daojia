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
							<td>
                                {if $account_info.is_paid eq 0}待审核{else if $account_info.is_paid eq 1}已完成{else}已取消{/if}

                                {if $account_info.is_paid eq 1}
                                <a class="btn m_l5 withdraw_query" href="javascript:;" data-url="{RC_Uri::url('withdraw/admin/query')}&id={$account_info.id}">对账查询</a>
                                {/if}

                            </td>
						</tr>

						<tr>
							<td><div align="right"><strong>{lang key='user::user_account.label_user_id'}</strong></div></td>
							<td>
								{if $account_info.user_name}
									{$account_info.user_name}
								{else}
									{lang key='user::user_account.anonymous_member'}
								{/if}
                                <a href="{RC_Uri::url('finance/admin_account_log/init')}&account_type=user_money&user_id={$account_info.user_id}" target="_blank"> [ 查看余额变动 ] </a>
							</td>
							<td><div align="right"><strong>申请金额：</strong></div></td>
							<td>{$account_info.formated_apply_amount}</td>				
						</tr>

						<tr>
							<td><div align="right"><strong>提现手续费：</strong></div></td>
							<td>{$account_info.formated_pay_fee}</td>
							<td><div align="right"><strong>到账金额：</strong></div></td>
							<td><strong class="ecjiafc-red ecjiaf-fs3">{$account_info.formated_real_amount}</strong></td>
						</tr>

						<tr>
							<td><div align="right"><strong>提现方式：</strong></div></td>
							<td>
                                {if $account_info.payment_name}{$account_info.payment_name}{else}银行转账提现{/if}
                            </td>
							<td><div align="right"><strong>提现账户：</strong></div></td>
							<td>
                                <strong class="ecjiafc-red ecjiaf-fs3">{$account_info.formated_payment_name}</strong>
							</td>
						</tr>

						<tr>
							<td><div align="right"><strong>申请时间：</strong></div></td>
							<td colspan="3">{$account_info.add_time}</td>
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
				<form class="form-horizontal" method="post" action="{$form_action}" name="theForm">
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
									<div class="m_t5">
										【同意】操作后，同意并打款给当前用户；<br/>
										【取消】操作后，订单状态更改为“已取消”，提现金额返还给对应账号；
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

{if $account_info.is_paid eq 1 && $record_info}
<div class="row-fluid">
    <div class="span12">
        <div class="accordion-group">
            <div class="accordion-heading">
                <div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
                    <strong>提现流水记录</strong>
                </div>
            </div>
            <div class="accordion-body in collapse" id="telescopic1">
                <table class="table table-oddtd m_b0">
                    <tbody class="first-td-no-leftbd">
                        <tr>
                            <td><div align="right"><strong>商户单号：</strong></div></td>
                            <td>{$record_info.order_sn}</td>
                            <td><div align="right"><strong>提现状态：</strong></div></td>
                            <td>{$record_info.label_withdraw_status}</td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>支付公司单号：</strong></div></td>
                            <td>{$record_info.trade_no}</td>
                            <td><div align="right"><strong>付款商户号：</strong></div></td>
                            <td>{$record_info.partner_id}</td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>付款账号：</strong></div></td>
                            <td>{$record_info.account}</td>
                            <td><div align="right"><strong>创建时间：</strong></div></td>
                            <td>{$record_info.create_time}</td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>付款成功时间：</strong></div></td>
                            <td>{$record_info.payment_time}</td>
                            <td><div align="right"><strong>转账时间：</strong></div></td>
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