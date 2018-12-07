<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var data = '{$data}';
	var stats = '{$stats}';
	ecjia.admin.user_level.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{lang key='orders::statistic.tips'}</strong>统计会员排名前30的订单总数以及下单总金额对比。
</div>

<div>
	<h3 class="heading">会员图表展示</h3>
</div>

<div class="row-fluid row-fluid-stats">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal">
				<div class="tab-content">
					<div class="tab-pane active">
						<div class="tab-pane-change t_c m_b10">
							<a class="btn {if $stats eq 'order_money' || !$stats}btn-gebo{/if} data-pjax" href="{RC_Uri::url('user/admin_level/init')}&stats=order_money{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}">下单总金额</a>
							<a class="btn {if $stats eq 'order_count'}btn-gebo{/if} m_l10 data-pjax" href="{RC_Uri::url('user/admin_level/init')}&stats=order_count{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}">下单总数</a>
						</div>
						<div class="user_level">
							<div id="user_level">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div>
	<h3 class="heading">
		{$ur_here}
		<a class="btn plus_or_reply" href='{RC_Uri::url("user/admin_level/download")}'><i class="fontello-icon-download"></i>导出Excel</a>
	</h3>
</div>

<div class="row-fluid batch">
	<form action="{RC_Uri::url('user/admin_level/init')}{if $smarty.get.sort_by}&sort_by={$smarty.get.sort_by}{/if}{if $smarty.get.sort_order}&sort_order={$smarty.get.sort_order}{/if}"
	 name="searchForm" method="post">
		<div class="choose_list f_r">
			<input class="date f_l w150" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="开始日期">
			<span class="f_l">至</span>
			<input class="date f_l w150" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="结束日期">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入会员名称关键字" />
			<button class="btn search-btn" type="button">搜索</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr data-sorthref='{RC_Uri::url("user/admin_level/init", "{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}")}'>
						<th data-toggle="sortbyDesc" data-sortby="level" class="w100">会员排行</th>
						<th class="w180">会员名称</th>
						<th data-toggle="sortbyDesc" data-sortby="avaliable_money">可用资金</th>
						<th data-toggle="sortbyDesc" data-sortby="integral">积分</th>
						<th data-toggle="sortbyDesc" data-sortby="order_count">下单总数</th>
						<th data-toggle="sortbyDesc" data-sortby="order_money">下单总金额</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$list.item key=key item=val} -->
					<tr>
						<td {if $val.level lt 4}class="ecjiaf-fwb ecjiaf-fs3"{/if}>
							{$val.level}
						</td>
						<td class="hide-edit-area">
							{$val.user_name}
							<div class="edit-list">
								<a target="__blank" href='{url path="user/admin/info" args="id={$val.user_id}"}'>查看详情</a>
							</div>
						</td>
						<td>{$val.formated_avaliable_money}</td>
						<td>{$val.integral}</td>
						<td>{$val.order_count}</td>
						<td>{$val.formated_order_money}</td>
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