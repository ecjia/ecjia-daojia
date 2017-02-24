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
	<strong>{lang key='orders::statistic.tips'}</strong>{lang key='orders::statistic.no_included_member'}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} --><a class="btn plus_or_reply"  id="sticky_a" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}&sort_by={$filter.sort_by}&sort_order={$filter.sort_order}"><i class="fontello-icon-download"></i>{t}{$action_link.text}{/t}</a><!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="choose_list f_r">
		<form class="f_r" action="{$search_action}"  method="post" name="theForm">
			<span>{lang key='orders::statistic.select_date_lable'}</span>
			<input class="start_date f_l w110" name="start_date" type="text" placeholder="{lang key='orders::statistic.start_date'}" value="{$start_date}">
			<span class="f_l">-</span>
			<input class="end_date f_l w110" name="end_date" type="text" placeholder="{lang key='orders::statistic.end_date'}" value="{$end_date}">
			<input class="btn screen-btn" type="submit" value="{lang key='orders::statistic.search'}">
		</form>
	</div>
</div>

<div class="row-fluid">
	<table class="table table-striped" id="smpl_tbl">
		<thead>
			<tr data-sorthref='{url path="orders/admin_users_order/init" args="start_date={$start_date}&end_date={$end_date}"}'>
				<th class="w100">{lang key='orders::statistic.order_by'}</th>
				<th class="w200">{lang key='orders::statistic.member_name'}</th>
				<th class="w200 sorting" data-toggle="sortby" data-sortby="order_num">{lang key='orders::statistic.order_amount'}</th>
				<th class="w110" data-toggle="sortby" data-sortby="turnover">{lang key='orders::statistic.buy_sum'}</th>
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
	    	<tr><td class="dataTables_empty" colspan="4">{lang key='system::system.no_records'}</td></tr>
	  		<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$users_order_data.page} -->
</div>
<!-- {/block} -->