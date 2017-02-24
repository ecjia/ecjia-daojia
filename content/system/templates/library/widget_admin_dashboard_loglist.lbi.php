<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="move-mod-group" id="widget_admin_dashboard_loglist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
	</div>
	<table class="table table-striped table-bordered mediaTable ecjiaf-wwb">
		<tbody>
			<!-- {foreach from=$log_lists item=log key=key} -->
			<tr>
				<td>{RC_Time::local_date('Y-m-d H:i:s', $log.log_time)} {t}管理员{/t} {$log.user_name|escape:html}, {t}在{/t} {RC_Ip::area($log.ip_address)} {t}IP下{/t} {$log.log_info}{t}。{/t}</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td>{t}暂无操作日志{/t}</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
	<div class="ecjiaf-tar"><a href="{RC_Uri::url('@admin_logs/init')}" title="{t}查看更多{/t}">{t}查看更多{/t}</a></div>
</div>