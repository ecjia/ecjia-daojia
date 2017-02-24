<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="control-group formSep">
	<label class="control-label">{$var.name}：</label>
	<div class="controls">
        <select class="w350" name="value[{$var.id}]" id="chosen_a" data-placeholder="Choose a Country...">
        	<!-- {html_options values=$lang_list output=$lang_list selected=$var.value} -->
        </select>
        <!-- {if $var.desc} -->
		<span class="help-block" id="notice{$var.code}">{$var.desc|nl2br}</span>
		<!-- {/if} -->
	</div>
</div>