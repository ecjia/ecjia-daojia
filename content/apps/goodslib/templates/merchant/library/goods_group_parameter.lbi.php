<!-- {foreach from=$group_parameter_list item=group_pra} -->
<div class="accordion-group panel panel-default">
   <div class="accordion-body in collapse" id="collapseSeven">
        <table class="table table-striped m_b0">
			<tbody>
				<tr>
					<td align="left" colspan="2"><strong>{$group_pra.attr_group_name}</strong></td>
				</tr>
				{if $group_pra.values}
				<!-- {foreach from=$group_pra.values item=value} -->
					<tr>
						<td  width="20%"><div  align="right">{$value.attr_name}:</div></td>
						<td align="left">{$value.attr_value}</td>
					</tr>
				<!-- {/foreach} -->
				{/if}
			</tbody>
		</table>
  </div>
</div>
<!-- {foreachelse} -->
<div class="accordion-group panel panel-default">
	{t domain="goods"}暂未设置参数{/t}
<div>
<!-- {/foreach} -->