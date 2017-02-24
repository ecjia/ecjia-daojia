<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="control-group formSep">
	<label class="control-label">{$var.name}：</label>
	<div class="controls">
        <table>
			<tr>
				<th scope="col">{t}类型{/t}</th>
				<th scope="col">{t}税率（％）{/t}</th>
			</tr>
			<tr>
				<td><input class="w166" name="invoice_type[]" type="text" value="{$ecjia_config.invoice_type.type[0]}" /></td>
				<td><input class="w166" name="invoice_rate[]" type="text" value="{$ecjia_config.invoice_type.rate[0]}" /></td>
			</tr>
			<tr>
				<td><input class="w166" name="invoice_type[]" type="text" value="{$ecjia_config.invoice_type.type[1]}" /></td>
				<td><input class="w166" name="invoice_rate[]" type="text" value="{$ecjia_config.invoice_type.rate[1]}" /></td>
			</tr>
			<tr>
				<td><input class="w166" name="invoice_type[]" type="text" value="{$ecjia_config.invoice_type.type[2]}" /></td>
				<td><input class="w166" name="invoice_rate[]" type="text" value="{$ecjia_config.invoice_type.rate[2]}" /></td>
			</tr>
		</table>
        <!-- {if $var.desc} -->
		<span class="help-block" id="notice{$var.code}">{$var.desc|nl2br}</span>
		<!-- {/if} -->
	</div>
</div>