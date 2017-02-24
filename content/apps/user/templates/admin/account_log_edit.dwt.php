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
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid ">
	<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post">
		<fieldset>
			<div class="control-group formSep">
				<label class="control-label">{lang key='user::account_log.label_user_name'}</label>
				<div class="controls users">
					<span class="l_h30">{$user.user_name}</span>
				</div>
			</div>
			<div class="control-group formSep">
				<label class="control-label">{lang key='user::account_log.label_user_money'}</label>
				<div class="controls">
					<select class="w80" name="add_sub_user_money">
						<option value="1" selected="selected">{lang key='user::account_log.add'}</option>
						<option value="-1">{lang key='user::account_log.subtract'}</option>
					</select>
					<input type="text" name="user_money" class="w80 m_l10" value="0"/>
					<span>{lang key='user::account_log.current_value'}{$user.formated_user_money}</span>
				</div>
			</div>
			<div class="control-group formSep">
				<label class="control-label">{lang key='user::account_log.label_frozen_money'}</label>
				<div class="controls">
					<select name="add_sub_frozen_money" class="w80">
						<option value="1" selected="selected">{lang key='user::account_log.add'}</option>
						<option value="-1">{lang key='user::account_log.subtract'}</option>
					</select>
					<input type="text" name="frozen_money" class="w80 m_l10" value="0"/>
					<span>{lang key='user::account_log.current_value'}{$user.formated_frozen_money}</span>
				</div>
			</div>
			<div class="control-group formSep">
				<label class="control-label">{lang key='user::account_log.label_rank_points'}</label>
				<div class="controls">
					<select name="add_sub_rank_points" class="w80">
						<option value="1" selected="selected">{lang key='user::account_log.add'}</option>
						<option value="-1">{lang key='user::account_log.subtract'}</option>
					</select>
					<input type="text" name="rank_points" class="w80 m_l10" value="0"/>
					<span>{lang key='user::account_log.current_value'}{$user.rank_points}</span>
				</div>
			</div>
			<div class="control-group formSep">
				<label class="control-label">{lang key='user::account_log.label_pay_points'}</label>
				<div class="controls">
					<select name="add_sub_pay_points" class="w80">
						<option value="1" selected="selected">{lang key='user::account_log.add'}</option>
						<option value="-1">{lang key='user::account_log.subtract'}</option>
					</select>
					<input type="text" name="pay_points" class="w80 m_l10" value="0"/>
					<span>{lang key='user::account_log.current_value'}{$user.pay_points}</span>
				</div>
			</div>
			<!-- 管理员备注  -->
			<div class="control-group formSep">
				<label class="control-label">{lang key='user::account_log.label_change_desc'}</label>
				<div class="controls">
					<textarea class="span5" name="change_desc" rows="5" >{$user_surplus.admin_note}</textarea>
					<span class="input-must">{lang key='system::system.require_field'}</span>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
					<input type="hidden" name="user_id" value="{$user.user_id}" />
				</div>
			</div>
		</fieldset>
	</form>
</div>
<!-- {/block} -->