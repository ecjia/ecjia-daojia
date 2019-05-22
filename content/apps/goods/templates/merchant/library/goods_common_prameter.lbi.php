<div class="accordion-group panel panel-default">
   <div class="accordion-body in collapse" id="collapseSeven">
        <table class="table table-striped m_b0">
			<tbody>
				<!-- {foreach from=$common_parameter_list item=pra} -->
					<tr>
						<td align="center">{$pra.attr_name}:</td>
						<td align="left">{$pra.attr_value}</td>
					</tr>
				<!-- {foreachelse} -->
					<tr>
						<td class="no-records w200" colspan="2">{t domain="goods"}暂未设置参数{/t}</td>
					</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
  </div>
</div>