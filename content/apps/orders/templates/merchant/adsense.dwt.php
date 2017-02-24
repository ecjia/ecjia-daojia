<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<!--站外投放JS-->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
			<a class="btn plus_or_reply" id="sticky_a" href='{$action_link.href}'><i class="fontello-icon-forward"></i>{$action_link.text}</a>
		<!-- {/if} -->
		<!-- {if $action_link_download} -->
			<a class="btn plus_or_reply" id="sticky_a" href='{$action_link_download.href}'><i class="fontello-icon-download"></i>{$action_link_download.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<table class="table table-striped" id="smpl_tbl">
		<thead>
			<tr>
				<th class="w180">{t}投放的名称{/t}</th>
				<th class="w300">{t}点击来源{/t}</th>
				<th class="w100">{t}点击次数{/t}</th>
				<th class="w150">{t}有效订单数{/t}</th>
				<th class="w150">{t}产生订单总数{/t}</th>
			</tr>
		</thead>
		<tbody>
		<!-- {if $ads_stats} -->
		<!-- {foreach from=$ads_stats item=list} -->
			<tr>
				<td>{$list.ad_name}</td>
				<td>{$list.referer}</td>
				<td>{$list.clicks}</td>
				<td>{$list.order_confirm}</td>
				<td>{$list.order_num}</td>
			</tr>
		<!-- {/foreach} -->
		<!-- {/if} -->
		<!-- {if $goods_stats} -->
		<!-- {foreach from=$goods_stats item=info} -->
			<tr>
			    <td>{$info.ad_name}</td>
			    <td>{$info.referer}</td>
			    <td align="right">{$info.clicks}</td>
			    <td align="right">{$info.order_confirm}</td>
			    <td align="right">{$info.order_num}</td>
		  	</tr>
		<!-- {/foreach} -->
		<!-- {/if} -->
		<!-- {if $ads_stats eq '' AND $goods_stats eq ''} -->
			<tr>
				<td class="dataTables_empty" colspan="5">{t}没有统计数据{/t}</td>
			</tr>
		<!-- {/if} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->