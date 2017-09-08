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
	<strong>{lang key='orders::statistic.tips'}</strong>{lang key='orders::statistic.no_order_default'}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply" id="sticky_a" href='{$action_link.href}&start_time={$filter.start_month_time}&end_time={$filter.end_month_time}&query_type={$filter.query_type}'><i class="fontello-icon-download"></i>{$action_link.text}</a>
	    <!-- {/if} -->
	</h3>
</div>

<form action="{$form_action}" method="post" name="searchForm">
	<div class="row-fluid">
		<div class="choose_list f_r">
			<strong class="f_l">{lang key='orders::statistic.year_status_lable'}</strong>
			{html_select_date prefix="year_begin" class="w80" time=$filter.start_time start_year="2006" end_year="+1" display_days=false display_months=false}
			<span class="f_l">-</span>
			{html_select_date prefix="year_end" class="w80" time=$filter.end_time start_year="2006" end_year="+1" display_days=false display_months=false}
			<input type="submit" name="query_by_year" value="{lang key='orders::statistic.query'}" class="btn screen-btn" />
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="choose_list f_r">
			<strong class="f_l">{lang key='orders::statistic.month_status_lable'}</strong>
			{html_select_date prefix="month_begin" class="w80" time=$filter.start_month_time start_year="2006" end_year="+1" display_days=false field_order="YMD" month_format="%m"}
			<span class="f_l">-</span>
			{html_select_date prefix="month_end" class="w80" time=$filter.end_month_time start_year="2006" end_year="+1" display_days=false field_order="YMD" month_format="%m"}
			<input type="submit" name="query_by_month" value="{lang key='orders::statistic.query'}" class="btn screen-btn1" />
		</div>
	</div>
</form>

<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="{if $page eq 'init'}active{/if}"><a class="data-pjax" href='{url path="orders/admin_sale_general/init"}'>{lang key='orders::statistic.order_status'}</a></li>
				<li class="{if $page eq 'sales_trends'}active{/if}"><a class="data-pjax" href='{url path="orders/admin_sale_general/sales_trends"}'>{lang key='orders::statistic.turnover_status'}</a></li>
			</ul>
			<form class="form-horizontal">
				<div class="tab-content">
					{if $page eq 'init'}
					<div class="tab-pane active" id="tab1">
						<div class="m_t10">
							<div id="order_count" data-url='{RC_Uri::url("orders/admin_sale_general/get_order_status","start_time={$filter.start_time}&end_time={$filter.end_time}&start_month_time={$filter.start_month_time}&end_month_time={$filter.end_month_time}&query_type={$filter.query_type}&order_type=1")}'>
							</div>
						</div>
					</div>
					{/if}
					{if $page eq 'sales_trends'}
					<div class="tab-pane active" id="tab2">
						<div class="m_t10">
							<div id="order_amount" data-url='{RC_Uri::url("orders/admin_sale_general/get_order_status","start_time={$filter.start_time}&end_time={$filter.end_time}&start_month_time={$filter.start_month_time}&filter.end_month_time={$filter.end_month_time}&query_type={$filter.query_type}&order_type=0")}'>
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