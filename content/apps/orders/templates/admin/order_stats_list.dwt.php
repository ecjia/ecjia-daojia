<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var data = '{$data}';
	var stats = '{$stats}';
	ecjia.admin.order_stats.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{lang key='orders::statistic.tips'}</strong>统计店铺排名前30的销量以及成交金额对比
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid row-fluid-stats">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal">
				<div class="tab-content">
					<div class="tab-pane active">
						<div class="tab-pane-change t_c m_b10">
							<a class="btn btn-gebo data-pjax" href="{RC_Uri::url('orders/admin_order_stats/init')}&stats=valid_order{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}">成交订单数</a>
							<a class="btn m_l10 data-pjax" href="{RC_Uri::url('orders/admin_order_stats/init')}&stats=valid_amount{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}">成交总金额</a>
						</div>
						<div class="order_stats">
							<div id="order_stats">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row-fluid batch">
	<form action="{RC_Uri::url('orders/admin_order_stats/init')}{if $smarty.get.sort_by}&sort_by={$smarty.get.sort_by}{/if}{if $smarty.get.sort_order}&sort_order={$smarty.get.sort_order}{/if}" name="searchForm" method="post">
		<div class="choose_list f_r">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入商家名称关键字" />
			<button class="btn search-btn" type="button">搜索</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr data-sorthref='{RC_Uri::url("orders/admin_order_stats/init", "{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}")}'>
						<th class="w180">商家名称</th>
						<th data-toggle="sortby" data-sortby="total_order">下单总数</th>
						<th data-toggle="sortby" data-sortby="total_amount">下单总金额</th>
						<th data-toggle="sortby" data-sortby="valid_order">成交订单数</th>
						<th data-toggle="sortby" data-sortby="valid_amount">成交总金额</th>
						<th data-toggle="sortby" data-sortby="level" class="w100">店铺排行</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$list.item key=key item=val} -->
					<tr>
						<td class="hide-edit-area">
							{$val.merchants_name}
							<div class="edit-list">
								<a class="data-pjax" href='{url path="orders/admin_order_stats/stats" args="store_id={$val.store_id}"}'>查看统计</a>
							</div>
						</td>
						<td>{$val.total_order}</td>
						<td>{$val.formated_total_amount}</td>
						<td>{$val.valid_order}</td>
						<td>{$val.formated_valid_amount}</td>
						<td>{$val.level}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr>
						<td class="no-records" colspan="6">{lang key='system::system.no_records'}</td>
					</tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$list.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->