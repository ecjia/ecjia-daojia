<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.shipping_config.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
    <h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
	<div class="row-fluid">
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm"  >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">App Key:</label>
					<div class="controls">
						<input type='text' name='express_key' value="{$cloud_express_key}" size='20' /> 
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">App Secret:</label>
					<div class="controls">
						<input type="text" name='express_secret' value="{$cloud_express_secret}" size='20' /> 
						<span class="input-must">{lang key='system::system.require_field'}</span>
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