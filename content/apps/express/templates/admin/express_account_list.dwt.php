<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_list.init()
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} --><small>（当前配送员：{$name}）</small>
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12 all">
		<div class="sale_desc">
			当前账户余额：<strong><font class="ecjiafc-red">{$user_money}</font></strong>元
		</div>

		<div class="form-group choose_list">
			<form class="f_l" name="searchForm" action="{$form_action}" method="post">
			<span>选择日期：</span>
				<input class="date f_l w230" name="start_date" type="text" value="{$start_date}" placeholder="请选择开始时间">
				<span class="f_l">至</span>
				<input class="date f_l w230" name="end_date" type="text" value="{$end_date}" placeholder="请选择结束时间">
				<button class="btn select-button" type="button">查询</button>
				<input type="hidden" name="user_id" value="{$user_id}">
			</form>
		</div>
	</div>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit">
			<thead>
				<tr>
					<th class="w150">账户变动时间</th>
					<th>账户变动原因</th>
					<th class="w100">可用资金账户</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$log_list.list item=list} -->
				<tr>
					<td>{$list.change_time}</td>
					<td>{$list.change_desc}</td>
					<td>+¥{$list.user_money}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="dataTables_empty" colspan="3">没有找到任何记录</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$log_list.page} -->
	</div>
</div>
<!-- {/block} -->