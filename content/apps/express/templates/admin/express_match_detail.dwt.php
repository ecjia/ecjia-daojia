<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.match_list.init()
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
	<div class="span12">
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
		<div class="move-mod-group" id="widget_admin_dashboard_briefing">
			<ul class="list-mod list-mod-briefing move-mod-head">
				<li class="span3">
					<div class="bd">{if $order_number}{$order_number}{else}0{/if}<span class="f_s14"> 单</span></div>
					<div class="ft"><i class="fontello-icon-chart-bar"></i>订单数量</div>
				</li>
				<li class="span3">
					<div class="bd">{$money.all_money}<span class="f_s14"> 元</span></div>
					<div class="ft"><i class="fontello-icon-truck"></i>配送总费用</div>
				</li>
				<li class="span3">
					<div class="bd">{$money.express_money}<span class="f_s14"> 元</span></div>
					<div class="ft"><i class="fontello-icon-yen"></i>配送员应得</div>
				</li>
				<li class="span3">
					<div class="bd">{$account_money}<span class="f_s14"> 元</span></div>
					<div class="ft"><i class="fontello-icon-user"></i>已结算费用</div>
				</li>
			</ul>
		</div>
		
		<table class="table table-striped table-hide-edit">
			<thead>
				<tr>
					<th class="w150">下单时间</th>
					<th>配送单号</th>
					<th class="w100">任务类型</th>
					<th class="w100">配送总费用</th>
					<th class="w100">平台应得</th>
					<th class="w100">配送员应得</th>
					<th class="w100">结算状态</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$order_list.list item=list} -->
				<tr>
					<td>{$list.receive_time}</td>
					<td>{$list.express_sn}</td>
					<td>{if $list.from eq 'grab'}抢单{else}派单{/if}</td>
					<td>¥{$list.shipping_fee}</td>
					<td>¥{$list.store_money}</td>
					<td>¥{$list.commision}</td>
					<td>{if $list.commision_status eq 1}已结算{else}<font class="ecjiafc-red">未结算</font>{/if}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="dataTables_empty" colspan="7">没有找到任何记录</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$order_list.page} -->
	</div>
</div>
<!-- {/block} -->