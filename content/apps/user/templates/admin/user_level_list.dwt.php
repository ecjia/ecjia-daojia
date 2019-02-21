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
	<strong>{t domain="user"}温馨提示：{/t}</strong>{t domain="user"}默认统计30天内，排名前30的订单总数以及下单总金额对比。{/t}
</div>

<div>
	<h3 class="heading">{t domain="user"}会员图表展示{/t}</h3>
</div>

<div class="row-fluid row-fluid-stats">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal">
				<div class="tab-content">
					<div class="tab-pane active">
						<div class="tab-pane-change t_c m_b10">
							<a class="btn {if $stats eq 'order_money' || !$stats}btn-gebo{/if} data-pjax" href="{RC_Uri::url('user/admin_level/init')}&stats=order_money{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}">{t domain="user"}下单总金额{/t}</a>
							<a class="btn {if $stats eq 'order_count'}btn-gebo{/if} m_l10 data-pjax" href="{RC_Uri::url('user/admin_level/init')}&stats=order_count{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}">{t domain="user"}下单总数{/t}</a>
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
		<a class="btn plus_or_reply" href='{RC_Uri::url("user/admin_level/download")}'><i class="fontello-icon-download"></i>{t domain="user"}导出Excel{/t}</a>
	</h3>
</div>

<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t domain="user"}温馨提示：{/t}</strong>{t domain="user"}最多可搜索90天时间以内的数据。{/t}
</div>


<div class="row-fluid batch">
	<form action="{RC_Uri::url('user/admin_level/init')}{if $smarty.get.sort_by}&sort_by={$smarty.get.sort_by}{/if}{if $smarty.get.sort_order}&sort_order={$smarty.get.sort_order}{/if}"
	 name="searchForm" method="post">
		<div class="choose_list f_r">
			<div>
			<input class="date f_l w150" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder='{t domain="user"}开始日期{/t}'>
			<span class="f_l">{t domain="user"}至{/t}</span>
			<input class="date f_l w150" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder='{t domain="user"}结束日期{/t}'>
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="user"}请输入会员名称关键字{/t}' />
			<button class="btn search-btn" type="button">{t domain="user"}搜索{/t}</button>
			</div>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr data-sorthref='{RC_Uri::url("user/admin_level/init", "{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}")}'>
						<th class="w100">{t domain="user"}会员排行{/t}</th>
						<th class="w180">{t domain="user"}会员名称{/t}</th>
						<th data-toggle="sortbyDesc" data-sortby="avaliable_money">{t domain="user"}可用资金{/t}</th>
						<th data-toggle="sortbyDesc" data-sortby="integral">{t domain="user"}积分{/t}</th>
						<th data-toggle="sortbyDesc" data-sortby="order_count">{t domain="user"}下单总数{/t}</th>
						<th data-toggle="sortbyDesc" data-sortby="order_money">{t domain="user"}下单总金额{/t}</th>
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
								<a target="__blank" href='{url path="user/admin/info" args="id={$val.user_id}"}'>{t domain="user"}查看详情{/t}</a>
							</div>
						</td>
						<td>{$val.formated_avaliable_money}</td>
						<td>{$val.integral}</td>
						<td>{$val.order_count}</td>
						<td>{$val.formated_order_money}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr>
						<td class="no-records" colspan="6">{t domain="user"}没有找到任何记录{/t}</td>
					</tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$list.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->