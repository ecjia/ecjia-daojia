<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped">
				<tbody>
					<!-- {foreach from=$common_parameter_list item=pra} -->
					<tr style="border-bottom:1px solid #ccc;">
						<td width="20%"><div  align="right">{$pra.attr_name}:</div></td>
						<td align="left">{$pra.attr_value}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr>
						<td class="no-records w200" colspan="2">{t domain="goods"}暂未设置参数{/t}</td>
					</tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
		</div>
	</div>
</div>