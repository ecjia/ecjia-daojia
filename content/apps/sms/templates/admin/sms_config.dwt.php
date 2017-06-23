<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sms_config_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
	<div class="row-fluid">
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm"  >
			<fieldset>
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