<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.quickpay_config.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid">
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" >
		<fieldset>
			<div>
				<h3 class="heading">
					<!-- {if $ur_here}{$ur_here}{/if} -->
				</h3>
			</div>
			
			<div class="control-group formSep">
				<label class="control-label">规则描述：</label>
				<div class="controls">
					<textarea class="span7" name="quickpay_rule" >{$quickpay_rule}</textarea>
					<span class="input-must"><span class="require-field">*</span></span>
				</div>
			</div>
			
			<div class="control-group formSep">
				<label class="control-label">收款手续费：</label>
				<div class="controls">
					<input type="text" class="span7" name="quickpay_fee" value="{$quickpay_fee}"/>
					<span class="input-must"><span class="require-field">*</span></span>
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<input type="submit" value="确定" class="btn btn-gebo" />
				</div>
			</div>
		</fieldset>
	</form>
</div>
<!-- {/block} -->