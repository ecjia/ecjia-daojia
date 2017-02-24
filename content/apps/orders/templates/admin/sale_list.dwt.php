<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sale_list.init()
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!--销售明细-->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{lang key='orders::statistic.tips'}</strong>{lang key='orders::statistic.no_sales_details'}
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} --><a class="btn plus_or_reply" href="{$action_link.href}{$url_args}{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}"><i class="fontello-icon-download"></i>{t}{$action_link.text}{/t}</a><!-- {/if} -->
		<!-- {if $smarty.get.store_id} --><a class="btn plus_or_reply" href='{RC_Uri::url("orders/admin_sale_list/init", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t}返回全部{/t}</a><!-- {/if} -->
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
			<input class="btn screen-btn" type="submit" value="{lang key='orders::statistic.search'}">
		</form>
	</div>
</div>

<div class="row-fluid">
	<table class="table table-striped" id="smpl_tbl">
		<thead>
			<tr>
				<th>{lang key='orders::statistic.goods_name'}</th>
				<th class="w200">{lang key='orders::order.merchants_name'}</th>
				<th class="w200">{lang key='orders::statistic.order_sn'}</th>
				<th class="w70">{lang key='orders::statistic.amount'}</th>
				<th class="w120">{lang key='orders::statistic.sell_price'}</th>
				<th class="w110">{lang key='orders::statistic.sell_date'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$sale_list_data.item key=key item=list} -->
			<tr>
				<td>
					<a href='{RC_Uri::url("goods/admin/preview", "id={$list.goods_id}")}' target="_blank">{$list.goods_name}</a>
				</td>
				<td><a href='{RC_Uri::url("orders/admin_sale_list/init", "store_id={$list.store_id}{$url_args}")}' title="查看此商家明细">{$list.merchants_name}</a><a href='{RC_Uri::url("store/admin/preview", "store_id={$list.store_id}")}' title="查看商家资料" target="_blank"><i class="fontello-icon-info-circled"></i></a></td>
				<td><a href='{RC_Uri::url("orders/admin/info", "order_sn={$list.order_sn}")}' target="_blank">{$list.order_sn}</a></td>
				<td>{$list.goods_num}</td>
				<td>{$list.sales_price}</td>
				<td>{$list.sales_time}</td>
			</tr>
			<!-- {foreachelse} -->
	    	<tr><td class="dataTables_empty" colspan="6">{lang key='system::system.no_records'}</td></tr>
	  		<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$sale_list_data.page} -->
</div>
<!-- {/block} -->
