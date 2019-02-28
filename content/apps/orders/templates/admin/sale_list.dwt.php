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
	<strong>{t domain="orders"}温馨提示：{/t}</strong>{t domain="orders"}没有完成的订单不计入销售明细{/t}
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} --><a class="btn plus_or_reply" href="{$action_link.href}{$url_args}{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}"><i class="fontello-icon-download"></i>{$action_link.text}</a><!-- {/if} -->
		<!-- {if $smarty.get.store_id} --><a class="btn plus_or_reply" href='{RC_Uri::url("orders/admin_sale_list/init", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t domain="orders"}返回全部{/t}</a><!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="choose_list f_r">
		<form class="f_r" action="{$search_action}"  method="post" name="theForm">
			<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder='{t domain="orders"}请输入商家关键字{/t}' size="15" />
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
			<tr>
				<th>{t domain="orders"}商品名称{/t}</th>
				<th class="w200">{t domain="orders"}商家名称{/t}</th>
				<th class="w200">{t domain="orders"}订单号{/t}</th>
				<th class="w70">{t domain="orders"}数量{/t}</th>
				<th class="w120">{t domain="orders"}售价{/t}</th>
				<th class="w110">{t domain="orders"}售出日期{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$sale_list_data.item key=key item=list} -->
			<tr>
				<td>
					<a href='{RC_Uri::url("goods/admin/preview", "id={$list.goods_id}")}' target="_blank">{$list.goods_name}</a>
				</td>
				<td><a href='{RC_Uri::url("orders/admin_sale_list/init", "store_id={$list.store_id}{$url_args}")}' title='{t domain="orders"}查看此商家明细{/t}'>{$list.merchants_name}</a><a href='{RC_Uri::url("store/admin/preview", "store_id={$list.store_id}")}' title='{t domain="orders"}查看商家资料{/t}' target="_blank"><i class="fontello-icon-info-circled"></i></a></td>
				<td><a href='{RC_Uri::url("orders/admin/info", "order_sn={$list.order_sn}")}' target="_blank">{$list.order_sn}</a></td>
				<td>{$list.goods_num}</td>
				<td>{$list.sales_price}</td>
				<td>{$list.sales_time}</td>
			</tr>
			<!-- {foreachelse} -->
	    	<tr><td class="dataTables_empty" colspan="6">{t domain="orders"}没有找到任何记录{/t}</td></tr>
	  		<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$sale_list_data.page} -->
</div>
<!-- {/block} -->
