<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sms_config_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
    <h3 class="heading">
		{lang key='sms::sms.platform_config'}
		{if $action_link}
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
	<div class="row-fluid">
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm"  >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='sms::sms.label_sms_account'}</label>
					<div class="controls">
						<input type='text' name='sms_user_name' value="{$config_user}" size='20' /> 
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='sms::sms.label_sms_password'}</label>
					<div class="controls">
						<input type="password" name='sms_password' value="{$config_password}" size='20' /> 
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="checkaction controls" data-url="{url path='sms/admin_config/check_balance'}">
						<input type="button" value="{lang key='sms::sms.search_balance'}" class="check btn"/>
						<span class="balance help-block ecjiaf-fs3"></span> 
					</div>
				</div>
				
				<div>
					<h3 class="heading">
						<!-- {if $ur_here}{$ur_here}{/if} -->
					</h3>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='sms::sms.label_shop_mobile'}</label>
					<div class="controls">
						<input type='text' name='sms_shop_mobile' value="{$config_mobile}" size='20' /> 
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='sms::sms.label_config_order'}</label>
					<div class="controls chk_radio">
						<input type="radio" name="config_order" value="1" {if $config_order eq 1} checked="true" {/if}/>{lang key='sms::sms.send_sms'}
						<input type="radio" name="config_order" value="0"{if $config_order eq 0} checked="true" {/if}/>{lang key='sms::sms.not_send_sms'} 
						<span class="help-block">{lang key='sms::sms.config_order_notice'}</span> 
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='sms::sms.label_config_money'}</label>
					<div class="controls chk_radio">
						<input type="radio" name="config_money" value="1" {if $config_money eq 1} checked="true" {/if}/>{lang key='sms::sms.send_sms'}
						<input type="radio" name="config_money" value="0" {if $config_money eq 0} checked="true" {/if}/>{lang key='sms::sms.not_send_sms'}
						<span class="help-block">{lang key='sms::sms.config_money_notice'}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='sms::sms.label_config_shipping'}</label>
					<div class="controls chk_radio">
						<input type="radio" name="config_shipping" value="1" {if $config_shipping eq 1} checked="true" {/if}/>{lang key='sms::sms.send_sms'}
						<input type="radio" name="config_shipping" value="0" {if $config_shipping eq 0} checked="true" {/if}/>{lang key='sms::sms.not_send_sms'}
						<span class="help-block">{lang key='sms::sms.config_shipping_notice'}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='sms::sms.label_config_user'}</label>
					<div class="controls chk_radio">
						<input type="radio" name="config_user" value="1" {if $config_user_sign_in eq 1} checked="true" {/if}/>{lang key='sms::sms.send_sms'}
						<input type="radio" name="config_user" value="0" {if $config_user_sign_in eq 0} checked="true" {/if}/>{lang key='sms::sms.not_send_sms'}
						<span class="help-block">{lang key='sms::sms.config_user_notice'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='sms::sms.sms_receipt_code'}</label>
					<div class="controls chk_radio">
						<input type="radio" name="sms_receipt_verification" value="1" {if $config_sms_receipt_verification eq 1} checked="true" {/if}/>{lang key='sms::sms.send_sms'}
						<input type="radio" name="sms_receipt_verification" value="0" {if $config_sms_receipt_verification eq 0} checked="true" {/if}/>{lang key='sms::sms.not_send_sms'}
						<span class="help-block">{lang key='sms::sms.receipt_code_notice'}</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->