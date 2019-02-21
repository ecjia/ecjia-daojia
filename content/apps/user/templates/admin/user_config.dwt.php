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
			<h3 class="heading">{t domain="user"}PC设置{/t}</h3>
			<div class="control-group formSep">
				<label class="control-label">{t domain="user"}是否开启会员中心：{/t}</label>
				<div class="controls chk_radio">
					<input type="radio" name="pc_enabled_member" value="1" {if $pc_enabled_member eq 1} checked {/if}> <span>{t domain="user"}开启{/t}</span>
					<input type="radio" name="pc_enabled_member" value="0" {if !$pc_enabled_member || $pc_enabled_member eq 0} checked {/if}> <span>{t domain="user"}关闭{/t}</span>
					<div class="clear"></div>
					<div class="help-block">{t domain="user"}开启则显示PC会员中心，关闭则隐藏{/t}</div>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" value='{t domain="user"}确定{/t}' class="btn btn-gebo" />
				</div>
			</div>
		</div>
	</form>
</div>
<!-- {/block} -->