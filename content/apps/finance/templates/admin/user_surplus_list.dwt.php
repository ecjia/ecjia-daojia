<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_surplus.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<form name="searchForm" action="{$form_action}" method="post">
		<div class="choose_list span12">
			<input class="date f_l w230" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="{t domain="finance"}开始日期{/t}">
			<span class="f_l">{t domain="finance"}至{/t}</span>
			<input class="date f_l w230" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="{t domain="finance"}结束日期{/t}">
			<button class="btn select-button" type="button">{t domain="finance"}筛选{/t}</button>
		</div>
		<div class="top_right f_r m_t_30">
			<input type="text" name="keywords" placeholder="{t domain="finance"}请输入会员名称或订单号{/t}" value="{$order_list.filter.keywords}"/>
			<button class="btn m_l5" type="submit">{t domain="finance"}搜索{/t}</button>
		</div>
	</form>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl">
			<thead>
				<tr>
					<th>{t domain="finance"}会员名{/t}</th>
					<th class="w150">{t domain="finance"}订单号{/t}</th>
					<th class="w130">{t domain="finance"}使用余额{/t}</th>
					<th class="w130">{t domain="finance"}积分使用余额{/t}</th>
					<th class="w150">{t domain="finance"}订单时间{/t}</th>
					<th class="w70">{t domain="finance"}操作{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$order_list.order_list item=order} -->
				<tr align="center">
					<td class="first-cell">{if $order.user_name}{$order.user_name}{else}{t domain="finance"}匿名会员{/t}{/if}</td>
					<td>{$order.order_sn}</td>
					<td>{$order.surplus}</td>
					<td>{$order.integral_money}</td>
					<td align="center">{$order.add_time}</td>
					<td align="center">
						<a target="_blank" href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' title="{t domain="finance"}查看订单{/t}">{t domain="finance"}查看{/t}</a>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="6">{t domain="finance"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$order_list.page} -->
	</div>
</div>
<!-- {/block} -->