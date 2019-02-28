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
				<label class="control-label">{t domain="orders"}未付款订单取消：{/t}</label>
				<div class="controls">
					<input type="text" class="span5" name="orders_auto_cancel_time" value="{if $orders_auto_cancel_time}{$orders_auto_cancel_time}{else}0{/if}"/> 
					<span class="help-block">{t domain="orders"}会员未付款的订单，在设置时间（单位：分钟）后若还没有支付，系统将会自动取消未付款的订单，默认0代表不设置，不设置则未支付订单将不会自动取消。{/t}</span>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="submit" value='{t domain="orders"}确定{/t}' class="btn btn-gebo" />
				</div>
			</div>
		</fieldset>
	</form>
</div>
<!-- {/block} -->
