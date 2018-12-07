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
					<label class="control-label">当前会员：</label>
					<div class="controls l_h30">{$user.user_name}</div>
				</div>

				{if $type eq 'add_pay_points' || $type eq 'minus_pay_points'}
				<div class="control-group formSep">
					<label class="control-label">当前账户积分：</label>
					<div class="controls l_h30 ecjiafc-red f_s15">{$user.pay_points}</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">会员积分：</label>
					<div class="controls">
						<input type="text" class="span6" name="pay_points" value="0" />
					</div>
				</div>
				{/if}

				{if $type eq 'add_rank_points' || $type eq 'minus_rank_points'}
				<div class="control-group formSep">
					<label class="control-label">当前账户成长值：</label>
					<div class="controls l_h30 ecjiafc-red f_s15">{$user.rank_points}</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">所属会员等级：</label>
					<div class="controls l_h30">{$user.user_rank_name}</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">会员成长值：</label>
					<div class="controls">
						<input type="text" class="span6" name="rank_points" value="0" />
					</div>
				</div>
				{/if}

				<div class="control-group formSep">
					<label class="control-label">变动原因：</label>
					<div class="controls">
						<textarea class="span6" name="change_desc" cols="30" rows="10"></textarea>
						<span class="input-must">*</span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="user_id" value="{$user_id}" />
						<input type="hidden" name="type" value="{$type}" />
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->