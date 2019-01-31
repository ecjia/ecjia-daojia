<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_log_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div>
	<h3 class="heading">
		{if $ur_here}{$ur_here}{/if}
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}当前会员：{/t}</label>
					<div class="controls l_h30">{$user.user_name}</div>
				</div>

				{if $type eq 'add_pay_points' || $type eq 'minus_pay_points'}
				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}当前账户积分：{/t}</label>
					<div class="controls l_h30 ecjiafc-red f_s15">{$user.pay_points}</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}会员积分：{/t}</label>
					<div class="controls">
						<input type="text" class="span6" name="pay_points" value="0" />
					</div>
				</div>
				{/if}

				{if $type eq 'add_rank_points' || $type eq 'minus_rank_points'}
				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}当前账户成长值：{/t}</label>
					<div class="controls l_h30 ecjiafc-red f_s15">{$user.rank_points}</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}所属会员等级：{/t}</label>
					<div class="controls l_h30">{$user.user_rank_name}</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}会员成长值：{/t}</label>
					<div class="controls">
						<input type="text" class="span6" name="rank_points" value="0" />
					</div>
				</div>
				{/if}

				{if $type eq 'add_user_money' || $type eq 'minus_user_money'}
				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}当前账户余额：{/t}</label>
					<div class="controls l_h30 ecjiafc-red f_s15">{$user.formated_user_money}</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">
                        {if $type eq 'add_user_money'}
                        {t domain="finance"}增加金额：{/t}
                        {else}
                        {t domain="finance"}减少金额：{/t}
                        {/if}
                    </label>
					<div class="controls">
						<input type="text" class="span6" name="user_money" value="0" />
					</div>
				</div>
				{/if}

				<div class="control-group formSep">
					<label class="control-label">{t domain="finance"}变动原因：{/t}</label>
					<div class="controls">
						<textarea class="span6" name="change_desc" cols="30" rows="10"></textarea>
						<span class="input-must">*</span>
					</div>
					{if $type eq 'add_user_money' || $type eq 'minus_user_money'}
					<div class="controls">
						<select class="select_admin_note span5">
							<option value="0">{t domain="finance"}请选择管理员备注{/t}</option>
							<option value="1">{t domain="finance"}线下消费{/t}</option>
							<option value="2">{t domain="finance"}人工记录资金变动{/t}</option>
							<option value="3">{t domain="finance"}线下门店已通过现金方式消费/充值{/t}</option>
							<option value="4">{t domain="finance"}退款资金返还用户账户余额{/t}</option>
						</select>
					</div>
					{/if}
				</div>

				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="user_id" value="{$user_id}" />
						<input type="hidden" name="type" value="{$type}" />
						<button class="btn btn-gebo" type="submit">{t domain="finance"}确定{/t}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->