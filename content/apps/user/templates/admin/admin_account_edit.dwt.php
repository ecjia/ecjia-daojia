<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_edit.init();
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
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_user_id'}</label>
					<div class="controls">
						<input class="w350" name="username" type="text" value="{if $user_name}{$user_name}{else if $smarty.get.id}匿名会员{else}{/if}" {if $user_surplus.is_paid} readonly="true" {/if} />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_surplus_amount'}</label>
					<div class="controls">
						<input class="w350" type="text" name="amount" value="{$user_surplus.amount}" {if $user_surplus.is_paid} readonly="true" {/if} />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_pay_mothed'}</label>
					<div class="controls">
						<select class="w350" name="payment" {if $user_surplus.is_paid} disabled="disabled" {/if}>
							<option value="">{lang key='user::user_account.please_select'}</option>
							<!-- {foreach from=$payment item=item} -->
							<option value="{$item.pay_name}" {if $user_surplus.payment eq $item.pay_name} selected="selected" {/if}>{$item.pay_name}</option> 
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				<!-- 类型 -->
				<div class="control-group formSep ">
					<label class="control-label">{lang key='user::user_account.label_process_type'}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="process_type" value="0" {if $user_surplus.process_type eq 0} checked="checked" {/if} {if $user_surplus.is_paid} disabled="true" {/if} /><span>{lang key='user::user_account.surplus_type.0'}</span>
						<input class="uni_style" type="radio" name="process_type" value="1" {if $user_surplus.process_type eq 1} checked="checked" {/if} {if $user_surplus.is_paid} disabled="true" {/if} /><span>{lang key='user::user_account.surplus_type.1'}</span>
					</div>
				</div>
				<!-- 管理员备注 -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_surplus_notic'}</label>
					<div class="controls">
						<textarea class="span9" name="admin_note" rows="6" >{$user_surplus.admin_note}</textarea>
					</div>
				</div>
				<!-- 会员描述 -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_surplus_desc'}</label>
					<div class="controls">
						<textarea class="span9" name="user_note" cols="10" rows="6" {if $user_surplus.is_paid} disabled="true" {/if}>{$user_surplus.user_note}</textarea>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_account.label_status'}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="is_paid" value="0" {if $user_surplus.is_paid eq 0} checked="true"{/if} {if $user_surplus.is_paid} disabled="true" {/if}/>{lang key='user::user_account.unconfirm'}
						<input class="uni_style" type="radio" name="is_paid" value="1" {if $user_surplus.is_paid eq 1} checked="true"{/if}{if $user_surplus.is_paid} disabled="true" {/if} />{lang key='user::user_account.confirm'}
						<input class="uni_style" type="radio" name="is_paid" value="2" {if $user_surplus.is_paid eq 2} checked="true"{/if} {if $user_surplus.is_paid} disabled="true" {/if}/>{lang key='user::user_account.cancel'}
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="id" value="{$user_surplus.id}" />
						<!-- {if $user_surplus.process_type eq 0 || $user_surplus.process_type eq 1} -->
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						<!-- {/if} -->
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->