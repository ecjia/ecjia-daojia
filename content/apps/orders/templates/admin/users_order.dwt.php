<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_order.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!--会员排行-->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t domain="orders"}温馨提示：{/t}</strong>{t domain="orders"}没有完成过订单交易的会员不计入会员排行{/t}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} --><a class="btn plus_or_reply" id="sticky_a" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}&sort_by={$filter.sort_by}&sort_order={$filter.sort_order}"><i class="fontello-icon-download"></i>{$action_link.text}</a><!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="choose_list f_r">
		<form class="f_r" action="{$search_action}" method="post" name="theForm">
			<span>{t domain="orders"}按时间段查询：{/t}</span>
			<input class="start_date f_l w110" name="start_date" type="text" placeholder='{t domain="orders"}开始日期{/t}' value="{$start_date}">
			<span class="f_l">-</span>
			<input class="end_date f_l w110" name="end_date" type="text" placeholder='{t domain="orders"}结束日期{/t}' value="{$end_date}">
			<input class="btn screen-btn" type="submit" value='{t domain="orders"}搜索{/t}'>
		</form>
	</div>
</div>

<div class="row-fluid">
	<table class="table table-striped" id="smpl_tbl">
		<thead>
			<tr data-sorthref='{url path="orders/admin_users_order/init" args="start_date={$start_date}&end_date={$end_date}"}'>
				<th class="w100">{t domain="orders"}排行{/t}</th>
				<th class="w200">{t domain="orders"}会员名{/t}</th>
				<th class="w200 sorting" data-toggle="sortby" data-sortby="order_num">{t domain="orders"}订单数(单位：个){/t}</th>
				<th class="w110" data-toggle="sortby" data-sortby="turnover">{t domain="orders"}购物金额{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$users_order_data.item key=key item=list} -->
			<tr>
				<td>{$key+1}</td>
				<td>{$list.user_name}</td>
				<td>{$list.order_num}</td>
				<td>{$list.turnover}</td>
			</tr>
			<!-- {foreachelse} -->
	    	<tr><td class="dataTables_empty" colspan="4">{t domain="orders"}没有找到任何记录{/t}</td></tr>
	  		<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$users_order_data.page} -->
</div>
<!-- {/block} -->