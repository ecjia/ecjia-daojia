<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sale_order.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!--销售排行-->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{lang key='orders::statistic.tips'}</strong>{lang key='orders::statistic.no_sale_sort'}
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
			<a class="btn plus_or_reply"  id="sticky_a" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}&sort_by={$filter.sort_by}&sort_order={$filter.sort_order}{if $smarty.get.merchant_keywords}&merchant_keywords={$smarty.get.merchant_keywords}{/if}{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}"><i class="fontello-icon-download"></i>{t}{$action_link.text}{/t}</a>
		<!-- {/if} -->
		<!-- {if $smarty.get.store_id} -->
			<a class="btn plus_or_reply" href='{RC_Uri::url("orders/admin_sale_order/init", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t}返回全部{/t}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="choose_list f_r">
		<form class="f_r" action="{$search_action}"  method="post" name="theForm">
			<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{lang key='goods::goods.enter_merchant_keywords'}" size="15" />
			<span>{lang key='orders::statistic.select_date_lable'}</span>
			<input class="start_date f_l w110" name="start_date" type="text" placeholder="{lang key='orders::statistic.start_date'}" value="{$start_date}">
			<span class="f_l">-</span>
			<input class="end_date f_l w110" name="end_date" type="text" placeholder="{lang key='orders::statistic.end_date'}" value="{$end_date}">
			<input class="btn screen-btn" type="submit" name="submit" value="{lang key='orders::statistic.search'}">
		</form>
	</div>
</div>

<div class="row-fluid">
	<table class="table table-striped" id="smpl_tbl">
		<thead>
			<tr data-sorthref='{url path="orders/admin_sale_order/init" args="start_date={$start_date}&end_date={$end_date}"}'>
				<th class="w100">{lang key='orders::statistic.order_by'}</th>
				<th>{lang key='orders::statistic.goods_name'}</th>
				<th>{lang key='orders::order.merchants_name'}</th>
				<th class="w100">{lang key='orders::statistic.goods_sn'}</th>
				<th class="w80 sorting" data-toggle="sortby" data-sortby="goods_num">{lang key='orders::statistic.sell_amount'}</th>
				<th class="w120">{lang key='orders::statistic.sell_sum'}</th>
				<th class="w120">{lang key='orders::statistic.percent_count'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$goods_order_data.item key=key item=list} -->
			<tr>
				<td>{$key+1}</td>
				<td>
					<a href='{RC_Uri::url("goods/admin/preview", "id={$list.goods_id}")}' target="_blank">{$list.goods_name}</a>
				</td>
				<td>
					<a href='{RC_Uri::url("orders/admin_sale_order/init", "store_id={$list.store_id}{$url_args}")}' >{$list.merchants_name}<a href='{RC_Uri::url("store/admin/preview", "store_id={$list.store_id}")}' title="查看商家资料" target="_blank"><i class="fontello-icon-info-circled"></i></a></a>
				</td>
				<td>{$list.goods_sn}</td>
				<td>{$list.goods_num}</td>
				<td>{$list.turnover}</td>
				<td>{$list.wvera_price}</td>
			</tr>
			<!-- {foreachelse} -->
	    	<tr><td class="dataTables_empty" colspan="7">{lang key='system::system.no_records'}</td></tr>
	  		<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$goods_order_data.page} -->
</div>
<!-- {/block} -->