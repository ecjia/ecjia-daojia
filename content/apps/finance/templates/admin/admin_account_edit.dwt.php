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
	<p><strong>{t domain="finance"}温馨提示：{/t}</strong></p>
	<p>{t domain="finance"}线下充值申请：指用户已通过线下实体店或其他渠道支付相应金额后，由管理员提交申请，记录用户线下充值的数据，方便日后商城财务对账。{/t}</p>
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
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}会员手机号码：{/t}</label>
					<div class="controls">
						<input class="w350 user-mobile" name="user_mobile" action='{url path="finance/admin_account/validate_acount"}' type="text" value="{if $user.mobile_phone}{$user.mobile_phone}{/if}" />
						<span class="input-must">*</span>
						<div class="help-block">{t domain="finance"}输入正确手机号，查询会员基本信息。{/t}</div>
					</div>
				</div>

				<div class="control-group formSep {if !$user}username{/if} user">
					<label class="control-label">{t domain="finance"}会员名称：{/t}</label>
					<div class="controls userinfo">
						<span>{$user.user_name}</span>
						<div class="help-block">{t domain="finance"}仔细查看会员手机号、名称是否正确，若正确请忽视，若不正确，请主动调整手机号。{/t}</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">{t domain="finance"}充值方式：{/t}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="pay_type" value="0" checked /><span>{t domain="finance"}固定金额{/t}</span>
						<input class="uni_style" type="radio" name="pay_type" value="1" /><span>{t domain="finance"}随机金额{/t}</span>
					</div>
				</div>

				<div class="control-group formSep fixed_amount">
					<label class="control-label">{t domain="finance"}金额：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="amount" value="{$user_surplus.amount}" {if $user_surplus.is_paid} readonly="true" {/if} /> {t domain="finance"}元{/t}
						<span class="input-must">*</span>
						<span class="help-block">{t domain="finance"}充值金额必须大于0{/t}</span>
					</div>
				</div>

				<div class="random_amount">
					<div class="control-group">
						<label class="control-label">{t domain="finance"}最小金额：{/t}</label>
						<div class="controls">
							<input class="w350" type="text" name="min_amount" /> {t domain="finance"}元{/t}
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="finance"}最大金额：{/t}</label>
						<div class="controls">
							<input class="w350" type="text" name="max_amount" /> {t domain="finance"}元{/t}
							<span class="input-must">*</span>
							<span class="help-block">{t domain="finance"}金额最多保留2位小数{/t}</span>
						</div>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}支付方式：{/t}</label>
					<div class="controls l_h30">{t domain="finance"}现金{/t}</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}管理员备注：{/t}</label>
					<div class="controls">
						<textarea class="span6" name="admin_note" rows="6">{$user_surplus.admin_note}</textarea>
					</div>
					<div class="controls">
						<select class="select_admin_note span5">
							<option value="0">{t domain="finance"}请选择管理员备注{/t}</option>
							<option value="1">{t domain="finance"}随机奖励金额{/t}</option>
							<option value="2">{t domain="finance"}管理员手动充值{/t}</option>
							<option value="3">{t domain="finance"}用户已在线下门店现金支付{/t}</option>
							<option value="4">{t domain="finance"}通过线下柜台、手机银行或网银将款项转账至商城账号上{/t}</option>
						</select>
						<span class="help-block">{t domain="finance"}此备注仅限管理员查看，备注内容可使用快捷用语。{/t}</span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="finance"}确定{/t}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->