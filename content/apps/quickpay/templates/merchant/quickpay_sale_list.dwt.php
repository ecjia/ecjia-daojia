<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.sale_list.init()
	var test = '{$sale_list_data.select_value}';
	if (test) {
		$("select[name='month_beginMonth']").find("option[value='']").attr("selected",true);
	} else {
		$("select[name='month_beginMonth']").find("option[value='']").attr("selected",false);
	}
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>温馨提示：</strong>没有完成的订单不计入销售明细。
</div>

<div class="page-header">
	<div class="pull-left">
		<h3><!-- {if $ur_here}{$ur_here}{/if} --></h3>
	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
		<a class="btn btn-primary" id="sticky_a" href="{$action_link.href}&start_date={$filter.start_date}&end_date={$filter.end_date}"><i class="glyphicon glyphicon-download-alt"></i> {t}{$action_link.text}{/t}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<section class="panel" >
			<header class="panel-heading">
				<div class="form-group choose_list">
					<form class="form-inline" action="{$search_action}" method="post" name="searchForm">
						<span>按照年份查：</span>
		                {html_select_date prefix="year_begin" class="no_search w110" time=$filter.start_date start_year="-10" reverse_years=true display_months=false display_days=false }
		                <span style="margin-left: 15px;">按月份查：</span>
		                {html_select_date prefix="month_begin" class="no_search w110" time=$filter.end_date display_years=false display_days=false field_order="YMD" month_format="%m" month_empty="全年"}
						<input type="submit" name="search_sale_data" value="查询" class="btn btn-primary screen-btn"/>
					</form>
				</div><br>
				<div class="sale_desc">订单共计：<span>{if $order_count}{$order_count}{else}0{/if}</span>&nbsp;单&nbsp;&nbsp;&nbsp;实际总金额共计：<span>¥{if $order_amount}{$order_amount}{else}0{/if}</span>&nbsp;元</div>
			</header>
		</section>
		
		<section class="panel">
			<div class="panel-body">
				<section id="unseen">
					<table class="table table-striped table-advance table-hover">
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
				</section>
			</div>
		</section>
	</div>
</div>
<!-- {/block} -->