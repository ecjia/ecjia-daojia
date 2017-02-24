<section class="panel">
    <div class="task-thumb-details">
          <h1>操作日志</h1>
    </div>
    <table class="table personal-task ">
        <tbody>
			<!-- {foreach from=$log_lists item=log key=key} -->
			<tr>
				<td style="text-align:left;">{RC_Time::local_date('Y-m-d H:i:s', $log.log_time)} {t}管理员{/t}{$log.name|escape:html}, {t}在{/t}{RC_Ip::area($log.ip_address)}{t}IP下{/t}{$log.log_info}。</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td style="text-align:center;" class="no-records" colspan="1">{t}暂无操作日志{/t}</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
    </table>
    <div class="ecjiaf-tar" style="margin-right:15px;padding-bottom:15px;"><a href="{RC_Uri::url('staff/mh_log/init')}" title="{t}查看更多{/t}">{t}查看更多{/t}</a></div>
</section>

