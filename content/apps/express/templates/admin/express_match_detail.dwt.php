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
		<!-- {if $ur_here}{$ur_here}{/if} --><small>{t domain="express" 1={$name}}（当前配送员：%1）{/t}</small>
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="form-group choose_list">
			<form class="f_l" name="searchForm" action="{$form_action}" method="post">
			<span>{t domain="express"}选择日期：{/t}</span>
				<input class="date f_l w230" name="start_date" type="text" value="{$start_date}" placeholder='{t domain="express"}请选择开始时间{/t}'>
				<span class="f_l">{t domain="express"}至{/t}</span>
				<input class="date f_l w230" name="end_date" type="text" value="{$end_date}" placeholder='{t domain="express"}请选择结束时间{/t}'>
				<button class="btn select-button" type="button">{t domain="express"}查询{/t}</button>
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
					<div class="bd">{if $order_number}{$order_number}{else}0{/if}<span class="f_s14"> {t domain="express"}单{/t}</span></div>
					<div class="ft"><i class="fontello-icon-chart-bar"></i>{t domain="express"}订单数量{/t}</div>
				</li>
				<li class="span3">
					<div class="bd">{$money.all_money}<span class="f_s14"> {t domain="express"}元{/t}</span></div>
					<div class="ft"><i class="fontello-icon-truck"></i>{t domain="express"}配送总费用{/t}</div>
				</li>
				<li class="span3">
					<div class="bd">{$money.express_money}<span class="f_s14"> {t domain="express"}元{/t}</span></div>
					<div class="ft"><i class="fontello-icon-yen"></i>{t domain="express"}配送员应得{/t}</div>
				</li>
				<li class="span3">
					<div class="bd">{$account_money}<span class="f_s14"> {t domain="express"}元{/t}</span></div>
					<div class="ft"><i class="fontello-icon-user"></i>{t domain="express"}已结算费用{/t}</div>
				</li>
			</ul>
		</div>
		
		<table class="table table-striped table-hide-edit">
			<thead>
				<tr>
					<th class="w150">{t domain="express"}下单时间{/t}</th>
					<th>{t domain="express"}配送单号{/t}</th>
					<th class="w100">{t domain="express"}任务类型{/t}</th>
					<th class="w100">{t domain="express"}配送总费用{/t}</th>
					<th class="w100">{t domain="express"}平台应得{/t}</th>
					<th class="w100">{t domain="express"}配送员应得{/t}</th>
					<th class="w100">{t domain="express"}结算状态{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$order_list.list item=list} -->
				<tr>
					<td>{$list.receive_time}</td>
					<td>{$list.express_sn}</td>
					<td>{if $list.from eq 'grab'}{t domain="express"}抢单{/t}{else}{t domain="express"}派单{/t}{/if}</td>
					<td>¥{$list.shipping_fee}</td>
					<td>¥{$list.store_money}</td>
					<td>¥{$list.commision}</td>
					<td>{if $list.commision_status eq 1}{t domain="express"}已结算{/t}{else}<font class="ecjiafc-red">{t domain="express"}未结算{/t}</font>{/if}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="dataTables_empty" colspan="7">{t domain="express"}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$order_list.page} -->
	</div>
</div>
<!-- {/block} -->