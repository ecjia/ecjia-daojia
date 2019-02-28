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
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t domain="orders"}温馨提示：{/t}</strong>{t domain="orders"}统计店铺排名前30的销量以及成交金额对比{/t}
</div>

<div class="row-fluid row-fluid-stats">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal">
				<div class="tab-content">
					<div class="tab-pane active">
						<div class="tab-pane-change t_c m_b10">
							<a class="btn {if $stats eq 'valid_amount' || !$stats}btn-gebo{/if} data-pjax" href="{RC_Uri::url('orders/admin_order_stats/init')}&stats=valid_amount{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}">{t domain="orders"}成交总金额{/t}</a>
							<a class="btn {if $stats eq 'valid_order'}btn-gebo{/if} m_l10 data-pjax" href="{RC_Uri::url('orders/admin_order_stats/init')}&stats=valid_order{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}">{t domain="orders"}成交订单数{/t}</a>
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

<div>
	<h3 class="heading">
        {t domain="orders"}店铺排行榜{/t}
	</h3>
</div>

<div class="row-fluid batch">
	<form action="{RC_Uri::url('orders/admin_order_stats/init')}{if $smarty.get.sort_by}&sort_by={$smarty.get.sort_by}{/if}{if $smarty.get.sort_order}&sort_order={$smarty.get.sort_order}{/if}"
	    name="searchForm" method="post">
		<div class="choose_list f_r">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="orders"}请输入商家名称关键字{/t}' />
			<button class="btn search-btn" type="button">{t domain="orders"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr data-sorthref='{RC_Uri::url("orders/admin_order_stats/init", "{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}")}'>
						<th class="w100">{t domain="orders"}店铺排行{/t}</th>
						<th class="w180">{t domain="orders"}商家名称{/t}</th>
						<th data-toggle="sortbyDesc" data-sortby="total_order">{t domain="orders"}下单总数{/t}</th>
						<th data-toggle="sortbyDesc" data-sortby="total_amount">{t domain="orders"}下单总金额{/t}</th>
						<th data-toggle="sortbyDesc" data-sortby="valid_order">{t domain="orders"}成交订单数{/t}</th>
						<th data-toggle="sortbyDesc" data-sortby="valid_amount">{t domain="orders"}成交总金额{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$list.item key=key item=val} -->
					<tr>
						<td {if $val.level lt 4}class="ecjiaf-fwb ecjiaf-fs3"{/if}>{$val.level}</td>
						<td class="hide-edit-area">
							{$val.merchants_name}
							<div class="edit-list">
								<a class="data-pjax" href='{url path="orders/admin_order_stats/stats" args="store_id={$val.store_id}"}'>{t domain="orders"}查看统计{/t}</a>
							</div>
						</td>
						<td>{$val.total_order}</td>
						<td>{$val.formated_total_amount}</td>
						<td>{$val.valid_order}</td>
						<td>{$val.formated_valid_amount}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr>
						<td class="no-records" colspan="6">{t domain="orders"}没有找到任何记录{/t}</td>
					</tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$list.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->