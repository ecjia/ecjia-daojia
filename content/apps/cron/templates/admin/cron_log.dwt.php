<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->

<!-- {/block} -->
<!-- {block name="main_content"} -->
<!-- {if $ur_here}{/if} -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>


<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w100">{t domain="cron"}计划任务名称{/t}</th>
					<th class="w300">{t domain="cron"}错误信息{/t}</th>
					<th class="w100">{t domain="cron"}运行时间{/t}</th>
					<th class="w50">{t domain="cron"}计划任务ID{/t}</th>
				</tr>
			</thead>

			<!-- {foreach from=$data.list item=list} -->
			<tr>
				<td>{$list.name}</td>
				<td>{$list.return}</td>
				<td>{$list.runtime}</td>
				<td>{$list.cron_manager_id}</td>
			</tr>
			<!-- {foreachelse} -->
			<td class="no-records" colspan="4">{t domain="cron"}没有找到任何记录{/t}</td>
            <!-- {/foreach} -->
		</table>
		<!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->