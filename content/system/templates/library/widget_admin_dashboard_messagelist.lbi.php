<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="move-mod-group" id="widget_admin_dashboard_messagelist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
		<span class="pull-right label label-info"><a class="ecjiafc-white" href="{url path='@admin_message/init'}">{t}我要留言{/t}</a></span>
	</div>
	<table class="table table-striped table-bordered mediaTable">
		<thead>
			<tr>
				<th class="essential persist">{t}留言内容{/t}</th>
				<th class="optional">{t}留言者{/t}</th>
				<th class="optional w130">{t}发送日期{/t}</th>
				<th class="essential w30">{t}操作{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$msg_lists item=msg key=key} -->
			<tr>
				<td>{$msg.message}</td>
				<td>{$msg.user_name|escape:html}</td>
				<td>{$msg.sent_time}</td>
				<td>
					<a class="sepV_a" href="{url path='@admin_message/init'}" title="Edit"><i class="fontello-icon-chat"></i></a>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td colspan="5">{t}暂无留言信息{/t}</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>