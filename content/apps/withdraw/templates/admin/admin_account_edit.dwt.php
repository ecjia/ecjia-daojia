<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title=""
		 title=""></i></button>
	<p><strong>温馨提示：</strong></p>
	<p>线下提现申请：指用户通过线下人工或其他渠道套现，由管理员提交申请后，自动记录对应账号内提现数据及金额变动。</p>
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
					<label class="control-label">{lang key='user::user_account.user_mobile'}：</label>
					<div class="controls">
						<input class="w350 user-mobile" name="user_mobile" action='{url path="withdraw/admin/validate_acount"}' type="text"
						 value="{if $user_mobile}{$user_mobile}{else if $smarty.get.id}匿名会员{else}{/if}" {if $user_surplus.is_paid}
						 readonly="true" {/if} />
						<span class="input-must">{lang key='system::system.require_field'}</span>
						<div class="help-block">输入正确手机号，查询会员基本信息。</div>
					</div>
				</div>

<!--				<div class="control-group-user hide">-->
<!--					<div class="control-group formSep">-->
<!--						<label class="control-label">会员名称：</label>-->
<!--						<div class="controls userinfo l_h30">-->
<!--						</div>-->
<!--					</div>-->
<!---->
<!--					<div class="control-group formSep">-->
<!--						<label class="control-label">可用余额：</label>-->
<!--						<div class="controls user_money l_h30">-->
<!--						</div>-->
<!--					</div>-->
<!---->
<!--					<div class="control-group formSep">-->
<!--						<label class="control-label">微信昵称：</label>-->
<!--						<div class="controls wechat_nickname">-->
<!--							<span></span>-->
<!--							<div class="help-block">仔细查看会员手机号、名称、微信昵称是否正确，若正确请忽视，若不正确，请主动调整手机号。</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->

				<div class="control-group formSep">
					<label class="control-label">提现金额：</label>
					<div class="controls">
						<input class="w350" type="text" name="apply_amount" data-url="{RC_Uri::url('withdraw/admin/check_pay_fee')}" /> 元
						<span class="input-must">{lang key='system::system.require_field'}</span>
						<span class="help-block">提现金额不能大于可用余额，管理员操作提现将不受最低提现金额限制。</span>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">提现手续费：</label>
					<div class="controls l_h30 withdraw_pay_fee">￥0.00</div>
				</div>

				{if $plugins}
				<div class="control-group formSep ">
					<label class="control-label">提现方式：</label>
					<div class="controls chk_radio" data-url="{RC_Uri::url('withdraw/admin/get_user_bank')}">
                        {foreach from=$plugins item=val}
						<input class="uni_style" type="radio" name="payment" value="{$val.withdraw_code}" /><span>{$val.withdraw_name}</span>
                        {/foreach}
						<span class="help-block">选择微信钱包后确认，系统会向微信发送打款请求，并在对应会员账户中生成对应提现记录，当请求被微信方处理成功后，申请会被自动处理为已完成状态</span>
						<span class="help-block">当选择银行转账提现后，需工作人员线下打款确认，申请才会被处理为已完成状态。</span>
					</div>
				</div>
				{/if}

                <div class="user_bank_card">

                </div>

				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_surplus_notic'}</label>
					<div class="controls">
						<textarea class="span12" name="admin_note" rows="6">{$user_surplus.admin_note}</textarea>
					</div>
					<div class="controls">
						<select class="select_admin_note span12">
							<option value="0">请选择管理员备注</option>
							<option value="1">线下打款</option>
							<option value="2">已通过线下银行汇款成功</option>
							<option value="3">会员在线下门店通过现金方式提现完成</option>
                            <option value="4">现金提现成功</option>
                            <option value="5">已打款至用户微信零钱</option>
                            <option value="6">人工记录资金变动</option>
						</select>
						<span class="help-block">此备注仅限管理员查看，备注内容可使用快捷用语。</span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
                        <input type="hidden" name="user_id" />
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
					</div>
				</div>
			</fieldset>
            </div>
            <div class="span5 withdraw_card_content">

            </div>
		</form>
	</div>
</div>
<!-- {/block} -->