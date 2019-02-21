<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<p><strong>{t domain="withdraw"}温馨提示：{/t}</strong></p>
	<p>{t domain="withdraw"}线下提现申请：指用户通过线下人工或其他渠道套现，由管理员提交申请后，自动记录对应账号内提现数据及金额变动。{/t}</p>
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post">
			<div class="span7">
				<fieldset>
					<div class="control-group formSep">
						<label class="control-label">{t domain="withdraw"}会员手机号码：{/t}</label>
						<div class="controls">
							<input class="w350 user-mobile" name="user_mobile" action='{url path="withdraw/admin/validate_acount"}' type="text" value="{if $user.mobile_phone}{$user.mobile_phone}{/if}" />
							<span class="input-must">*</span>
							<div class="help-block">{t domain="withdraw"}输入正确手机号，查询会员基本信息。{/t}</div>
						</div>
					</div>

					<div class="control-group formSep">
						<label class="control-label">{t domain="withdraw"}提现金额：{/t}</label>
						<div class="controls">
							<input class="w350" type="text" name="apply_amount" data-url="{RC_Uri::url('withdraw/admin/check_pay_fee')}" /> {t domain="withdraw"}元{/t}
							<span class="input-must">*</span>
							<span class="help-block">{t domain="withdraw"}提现金额不能大于可用余额，管理员操作提现将不受最低提现金额限制。{/t}</span>
						</div>
					</div>

					<div class="control-group formSep">
						<label class="control-label">{t domain="withdraw"}提现手续费：{/t}</label>
						<div class="controls l_h30 withdraw_pay_fee">￥0.00</div>
					</div>

					{if $plugins}
					<div class="control-group formSep ">
						<label class="control-label">{t domain="withdraw"}提现方式：{/t}</label>
						<div class="controls chk_radio" data-url="{RC_Uri::url('withdraw/admin/get_user_bank')}">
							{foreach from=$plugins item=val}
							<input class="uni_style" type="radio" name="payment" value="{$val.withdraw_code}" /><span>{$val.withdraw_name}</span>
							{/foreach}
							<span class="help-block">{t domain="withdraw"}选择微信钱包后确认，系统会向微信发送打款请求，并在对应会员账户中生成对应提现记录，当请求被微信方处理成功后，申请会被自动处理为已完成状态{/t}</span>
							<span class="help-block">{t domain="withdraw"}当选择银行转账提现后，需工作人员线下打款确认，申请才会被处理为已完成状态。{/t}</span>
						</div>
					</div>
					{/if}

					<div class="user_bank_card"></div>

					<div class="control-group formSep">
						<label class="control-label">{t domain="withdraw"}管理员备注：{/t}</label>
						<div class="controls">
							<textarea class="span12" name="admin_note" rows="6">{$user_surplus.admin_note}</textarea>
						</div>
						<div class="controls">
							<select class="select_admin_note span12">
								<option value="0">{t domain="withdraw"}请选择管理员备注{/t}</option>
								<option value="1">{t domain="withdraw"}线下打款{/t}</option>
								<option value="2">{t domain="withdraw"}已通过线下银行汇款成功{/t}</option>
								<option value="3">{t domain="withdraw"}会员在线下门店通过现金方式提现完成{/t}</option>
								<option value="4">{t domain="withdraw"}现金提现成功{/t}</option>
								<option value="5">{t domain="withdraw"}已打款至用户微信零钱{/t}</option>
								<option value="6">{t domain="withdraw"}人工记录资金变动{/t}</option>
							</select>
							<span class="help-block">{t domain="withdraw"}此备注仅限管理员查看，备注内容可使用快捷用语。{/t}</span>
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<input type="hidden" name="user_id" value="{if $user.user_id}{$user.user_id}{/if}" />
							<button class="btn btn-gebo" type="submit">{t domain="withdraw"}确定{/t}</button>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="span5 withdraw_card_content">{if $content}{$content}{/if}</div>
		</form>
	</div>
</div>
<!-- {/block} -->