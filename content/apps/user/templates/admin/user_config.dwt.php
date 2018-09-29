<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_config.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm">
		<div class="span12">
			<h3 class="heading">PC设置</h3>
			<div class="control-group formSep">
				<label class="control-label">是否开启会员中心：</label>
				<div class="controls chk_radio">
					<input type="radio" name="pc_test" value="1" {if $pc_test.on eq 1} checked {/if}>
					<span>开启</span>
					<input type="radio" name="pc_test" value="0" {if !$pc_test.on || $pc_test.on eq 0} checked {/if}>
					<span>关闭</span>
					<div class="clear"></div>
					<div class="help-block">开启则显示PC会员中心，关闭则隐藏</div>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
				</div>
			</div>
		</div>
	</form>
</div>
<!-- {/block} -->
