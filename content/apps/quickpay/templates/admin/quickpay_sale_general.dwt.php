<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
var templateCounts = '{$data}';
	ecjia.admin.sale_general.init();
{if $page eq 'init'}
	ecjia.admin.chart.order_count();
{else if $page eq 'sales_trends'}
	ecjia.admin.chart.order_amount();
{/if}
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t domain="quickpay"}温馨提示：{/t}</strong>{t domain="quickpay"}只有已付款的订单才计入订单统计。{/t}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply" id="sticky_a" href='{$action_link.href}&start_time={$filter.start_month_time}&end_time={$filter.end_month_time}&query_type={$filter.query_type}'><i class="fontello-icon-download"></i>{$action_link.text}</a>
	    <!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<ul class="list-mod list-mod-briefing move-mod-head">
			<li class="span3">
				<div class="bd">
					<p class="count_p">{if $data_count.order_count}{$data_count.order_count}{else}0{/if}</p>
					<p>{t domain="quickpay"}订单数量（单）{/t}</p>
				</div>
			</li>
			
			<li class="span3">
				<div class="bd">
					<p class="count_p">¥{if $data_count.goods_amount}{$data_count.goods_amount}{else}0{/if}</p>
					<p>{t domain="quickpay"}消费总金额（元）{/t}</p>
				</div>
			</li>
			
			<li class="span3">
				<div class="bd">
					<p class="count_p">¥{if $data_count.favorable_amount}{$data_count.favorable_amount}{else}0{/if}</p>
					<p>{t domain="quickpay"}优惠总金额（元）{/t}</p>
				</div>
			</li>
			
			<li class="span3">
				<div class="bd">
					<p class="count_p">¥{if $data_count.order_amount}{$data_count.order_amount}{else}0{/if}</p>
					<p>{t domain="quickpay"}实付总金额（元）{/t}</p>
				</div>
			</li>
		</ul>
	</div>
</div>

<div class="sale-filter">
	<form action="{$form_action}" method="post" name="searchForm">
		<div class="row-fluid">
			<div class="choose_list f_r">
				<strong class="f_l">{t domain="quickpay"}年走势：{/t}</strong>
				{html_select_date prefix="year_begin" class="w80" time=$filter.start_time start_year="2006" end_year="+1" display_days=false display_months=false}
				<span class="f_l">-</span>
				{html_select_date prefix="year_end" class="w80" time=$filter.end_time start_year="2006" end_year="+1" display_days=false display_months=false}
				<input type="submit" name="query_by_year" value='{t domain="quickpay"}查询{/t}' class="btn screen-btn" />
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="choose_list f_r">
				<strong class="f_l">{t domain="quickpay"}月走势：{/t}</strong>
				{html_select_date prefix="month_begin" class="w80" time=$filter.start_month_time start_year="2006" end_year="+1" display_days=false field_order="YMD" month_format="%m"}
				<span class="f_l">-</span>
				{html_select_date prefix="month_end" class="w80" time=$filter.end_month_time start_year="2006" end_year="+1" display_days=false field_order="YMD" month_format="%m"}
				<input type="submit" name="query_by_month" value='{t domain="quickpay"}查询{/t}' class="btn screen-btn1" />
			</div>
		</div>
	</form>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="{if $page eq 'init'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_sale_general/init"}'>{t domain="quickpay"}订单走势{/t}</a></li>
				<li class="{if $page eq 'sales_trends'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_sale_general/sales_trends"}'>{t domain="quickpay"}销售额走势{/t}</a></li>
			</ul>
			<form class="form-horizontal">
				<div class="tab-content">
					{if $page eq 'init'}
					<div class="tab-pane active" id="tab1">
						<div class="m_t10">
							<div id="order_count" data-url='{RC_Uri::url("quickpay/admin_sale_general/get_order_status","start_time={$filter.start_time}&end_time={$filter.end_time}&start_month_time={$filter.start_month_time}&end_month_time={$filter.end_month_time}&query_type={$filter.query_type}&order_type=1")}'>
							</div>
						</div>
					</div>
					{/if}
					{if $page eq 'sales_trends'}
					<div class="tab-pane active" id="tab2">
						<div class="m_t10">
							<div id="order_amount" data-url='{RC_Uri::url("quickpay/admin_sale_general/get_order_status","start_time={$filter.start_time}&end_time={$filter.end_time}&start_month_time={$filter.start_month_time}&filter.end_month_time={$filter.end_month_time}&query_type={$filter.query_type}&order_type=0")}'>
							</div>
						</div>
					</div>
					{/if}
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->