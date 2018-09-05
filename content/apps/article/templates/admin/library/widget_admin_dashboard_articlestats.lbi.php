<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="move-mod-group" id="widget_admin_dashboard_articlestats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$article_title}</h3>
	</div>
	<div class="heading clearfix move-mod-head no-border">
		<h3 class="pull-left">最新发布</h3>
	</div>
	<table class="table table-striped ecjiaf-wwb article_stats_table">
		<tbody>
			<!-- {foreach from=$article item=val} -->
			<tr>
				<td>
					<p class="m_b5">
						<a href="{RC_Uri::url('article/admin/preview')}&id={$val.article_id}" target="_black" title="{$val.title}">{$val.title}</a>
						<span class="ecjiaf-fr">{RC_Time::local_date('Y-m-d H:i:s', $val.add_time)}</span>
					</p>
					<p class="m_b5">文章由【{if $val.merchants_name}{$val.merchants_name}{else}平台{/if}】发布</p>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td class="no-records">
					暂无文章
				</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
	{if $article}
	<div class="ecjiaf-tar"><a href="{RC_Uri::url('article/admin/init')}" title="查看更多">查看更多</a></div>
	{/if}

	<div class="heading clearfix move-mod-head no-border">
		<h3 class="pull-left">近期评论</h3>
	</div>
	<table class="table table-striped ecjiaf-wwb article_stats_table">
		<tbody>
			<!-- {foreach from=$article_comment item=val} -->
			<tr>
				<td>
					<div class="td-left"><img src="{$val.avatar_img}" /></div>
					<div class="td-right">
						<p class="m_b5">{$val.user_name}</p>
						<p class="m_b5">对文章<a href="{RC_Uri::url('article/admin/preview')}&id={$val.id_value}" target="_black" title="{$val.title}">《{$val.title}》</a>发表评论</p>
						<p class="m_b5">{$val.content}</p>
					</div>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td class="no-records">
					暂无评论
				</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
	{if $article_comment}
	<div class="ecjiaf-tar"><a href="{RC_Uri::url('article/admin/article_comment_list')}&publishby=total_comments" title="查看更多">查看更多</a></div>
	{/if}
</div>

<style type="text/css">
	.heading.no-border {
		border: none;
		margin-bottom: 10px;
	}

	.table.article_stats_table td {
		border-top: none;
		border-bottom: 1px solid #eee;
	}

	.table.article_stats_table tr:last-child td {
		border-bottom: none;
	}

	.table.article_stats_table td img {
		width: 80px;
		height: 80px;
		float: left;
		margin: 0px 10px 0 10px;
		border-radius: 4px;
	}

	.table.article_stats_table .td-left {
		float: left;
	}

	.table.article_stats_table .td-right {
		margin-left: 100px;
	}
</style>