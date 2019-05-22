<!-- {foreach from=$group_parameter_list item=group_pra} -->
<div class="accordion-group panel panel-default">
   <div class="accordion-body in collapse" id="collapseSeven">
        <table class="table table-striped m_b0">
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
<!-- {foreachelse} -->
<div class="accordion-group panel panel-default">
	{t domain="goods"}暂未设置参数{/t}
<div>
<!-- {/foreach} -->