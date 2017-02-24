<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="move-mod-group" id="widget_admin_dashboard_loglist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
	</div>
	<table class="table table-striped table-bordered mediaTable ecjiaf-wwb">
		<tbody>
			<!-- {foreach from=$help_urls item=url key=name} -->
			<tr>
				<td>
					<p class="m_b5">{$name}: <a href="{$url}" target="_black">{$url}</a></p>
				</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>