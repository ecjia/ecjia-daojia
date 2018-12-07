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
	<p>线下充值申请：指用户已通过线下实体店或其他渠道支付相应金额后，由管理员提交申请，记录用户线下充值的数据，方便日后商城财务对账。</p>
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
					<label class="control-label">{lang key='user::user_account.user_mobile'}：</label>
					<div class="controls">
						<input class="w350 user-mobile" name="user_mobile" action='{url path="finance/admin_account/validate_acount"}'
						 type="text" value="{if $user_mobile}{$user_mobile}{else if $smarty.get.id}匿名会员{else}{/if}" {if
						 $user_surplus.is_paid} readonly="true" {/if} />
						<span class="input-must">{lang key='system::system.require_field'}</span>
						<div class="help-block">输入正确手机号，查询会员基本信息。</div>
					</div>
				</div>

				<div class="control-group formSep username user">
					<label class="control-label">会员名称：</label>
					<div class="controls userinfo">
						<span></span>
						<div class="help-block">仔细查看会员手机号、名称是否正确，若正确请忽视，若不正确，请主动调整手机号。</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">充值方式：</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="pay_type" value="0" checked /><span>固定金额</span>
						<input class="uni_style" type="radio" name="pay_type" value="1" /><span>随机金额</span>
					</div>
				</div>

				<div class="control-group formSep fixed_amount">
					<label class="control-label">{lang key='user::user_account.label_surplus_amount'}</label>
					<div class="controls">
						<input class="w350" type="text" name="amount" value="{$user_surplus.amount}" {if $user_surplus.is_paid} readonly="true"
						 {/if} /> 元
						<span class="input-must">{lang key='system::system.require_field'}</span>
						<span class="help-block">充值金额必须大于0</span>
					</div>
				</div>

				<div class="random_amount">
					<div class="control-group">
						<label class="control-label">最小金额：</label>
						<div class="controls">
							<input class="w350" type="text" name="min_amount" /> 元
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">最大金额：</label>
						<div class="controls">
							<input class="w350" type="text" name="max_amount" /> 元
							<span class="input-must">{lang key='system::system.require_field'}</span>
							<span class="help-block">金额最多保留2位小数</span>
						</div>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_pay_mothed'}</label>
					<div class="controls l_h30">现金</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_surplus_notic'}</label>
					<div class="controls">
						<textarea class="span6" name="admin_note" rows="6">{$user_surplus.admin_note}</textarea>
					</div>
					<div class="controls">
						<select class="select_admin_note span5">
							<option value="0">请选择管理员备注</option>
							<option value="1">随机奖励金额</option>
							<option value="2">管理员手动充值</option>
							<option value="3">用户已在线下门店现金支付</option>
							<option value="4">通过线下柜台、手机银行或网银将款项转账至商城账号上</option>
						</select>
						<span class="help-block">此备注仅限管理员查看，备注内容可使用快捷用语。</span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->