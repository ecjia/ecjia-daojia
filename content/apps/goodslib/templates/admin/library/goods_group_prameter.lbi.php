<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<!-- {foreach from=$group_parameter_list item=group_pra} -->
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<tbody>
					<tr>
						<td align="left" colspan="2"><strong>{$group_pra.attr_group_name}</strong></td>
					</tr>
					<tr>
						<td align="left">{$group_pra.values.attr_name}:</td>
						<td align="left">{$group_pra.values.attr_value}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- {foreachelse} -->
<div class="accordion-group panel panel-default">
	{t domain="goods"}暂未设置参数{/t}
<div>
<!-- {/foreach} -->