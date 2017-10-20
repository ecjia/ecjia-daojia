<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sale_list.init()
	var test = '{$sale_list_data.select_value}';
	if (test) {
		$("select[name='month_beginMonth']").find("option[value='']").attr("selected",true);
	} else {
		$("select[name='month_beginMonth']").find("option[value='']").attr("selected",false);
	}
</script>
<style>
.sale_desc{
	float: left;
}
.sale_desc span{	
	color:#e62129;
	line-height:60px;
}
</style>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>温馨提示：</strong>没有完成的订单不计入销售明细。
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply" href="{$action_link.href}&start_date={$filter.start_date}&end_date={$filter.end_date}"><i class="fontello-icon-download"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="form-group choose_list sqq">
			<form class="form-inline" action="{$search_action}" method="post" name="searchForm">
				<span>按照年份查：</span>
		        {html_select_date prefix="year_begin" class="no_search w110" time=$filter.start_date start_year="-10" reverse_years=true display_months=false display_days=false }
		        <span style="margin-left: 15px;">按月份查：</span>
		        {html_select_date prefix="month_begin" class="no_search w110" time=$filter.end_date display_years=false display_days=false field_order="YMD" month_format="%m" month_empty="全年"}
				<input type="submit" name="search_sale_data" value="查询" class="btn screen-btn"/>
			</form>
		</div>
	</div>
</div>

<div class="sale_desc">
	订单共计：<span>{if $order_count}{$order_count}{else}0{/if}</span>&nbsp;单&nbsp;&nbsp;&nbsp;
	实际总金额共计：<span>¥{if $order_amount}{$order_amount}{else}0{/if}</span>&nbsp;元
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit">
			<thead>
				<tr>
					<th class="w150">日期</th>
					<th class="w100">订单数量（单）</th>
					<th class="w100">消费总金额（元）</th>
					<th class="w100">优惠总金额（元）</th>
					<th class="w100">实付总金额（元）</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$sale_list_data.item item=list} -->
				<tr>
					<td>{$list.period}</td>
					<td>{$list.order_count}</td>
					<td>¥{$list.goods_amount}</td>
					<td>¥{$list.favorable_amount}</td>
					<td>¥{$list.order_amount}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="dataTables_empty" colspan="5">没有找到任何记录</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$sale_list_data.page} -->
	</div>
</div>
<!-- {/block} -->