<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="move-mod-group" id="widget_admin_dashboard_loglist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
	</div>
	<table class="table table-striped table-bordered mediaTable ecjiaf-wwb">
		<tbody>
			<!-- {foreach from=$product_news item=news key=key name=news} -->
				<!-- {if $smarty.foreach.news.first} -->
				<tr>
					<td>
						<p class="m_b5"><a href="{$news.url}" target="_black" title="{$news.url}">{$news.title}</a><span class="ecjiaf-fr">{$news.time|date_format:"%Y-%m-%d"}</span></p>
						<p class="m_b0">{$news.description}</p>
					</td>
				</tr>
				<!-- {else} -->
				<tr>
					<td><a href="{$news.url}" target="_black" title="{$news.url}">{$news.title}</a><span class="ecjiaf-fr">{$news.time|date_format:"%Y-%m-%d"}</span></td>
				</tr>
				<!-- {/if} -->
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>