<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_config.init();
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
				<label class="control-label">提现手续费：</label>
				<div class="controls">
					<input type="text" class="span5" name="withdraw_fee" value="{$withdraw_fee}"/> %
					<span class="help-block">手续费按用户提现金额的百分比进行收取。如提现1000，手续费10%，则提现时，只能提取900。</span>
				</div>
			</div>

			<div class="control-group formSep">
				<label class="control-label">最低提现金额：</label>
				<div class="controls">
					<input type="text" class="span5" name="withdraw_min_amount" value="{$withdraw_min_amount}"/> 元
					<span class="help-block">当用户提现金时，最低提现金额不能小于此值。</span>
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
