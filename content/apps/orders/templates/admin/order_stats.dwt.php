<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var data = '{$data}';
	ecjia.admin.order_stats.init();
	{if $page eq 'init'}
		{if $is_multi eq ''}
			ecjia.admin.chart.order_general();
		{else if $is_multi eq 1}
			ecjia.admin.chart.order_status();
		{/if}
	{else if $page eq 'shipping_status'}
		{if $is_multi eq ''}
			ecjia.admin.chart.ship_status();
		{else if $is_multi eq 1}
			ecjia.admin.chart.ship_stats();
		{/if}
	{else if $page eq 'pay_status'}
		{if $is_multi eq ''}
			ecjia.admin.chart.pay_status();
		{else if $is_multi eq 1}
			ecjia.admin.chart.pay_stats();
		{/if}
	{/if}
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{lang key='orders::statistic.tips'}</strong>{lang key='orders::statistic.order_stats_date'}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if !$is_multi} -->	
			<!-- {if $action_link} -->
				<a class="btn plus_or_reply" id="sticky_a" href='{$action_link.href}&start_date={$start_date}&end_date={$end_date}'><i class="fontello-icon-download"></i>{$action_link.text}</a>
	    	<!-- {/if} -->
	    <!-- {/if} -->
	</h3>
</div>

<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_submit">
				<strong>{lang key='orders::statistic.order_stats_info'}</strong>
			</a>
		</div>
		<div class="accordion-body in collapse" id="goods_info_area_submit">
			<table class="table table-oddtd m_b0">
				<tbody class="first-td-no-leftbd">
					<tr>
							<td><div align="right"><strong>{lang key='orders::statistic.overall_sum_lable'}</strong></div></td>
							<td>{$order_stats.total_turnover}</td>
							<td><div align="right"><strong>{lang key='orders::statistic.overall_choose'}</strong></div></td>
							<td>{$order_stats.click_count}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{lang key='orders::statistic.kilo_buy_amount'}</strong></div></td>
							<td>{$order_stats.click_ordernum}</td>
							<td><div align="right"><strong>{lang key='orders::statistic.kilo_buy_sum'}</strong></div></td>
							<td>{$order_stats.click_turnover}</td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="choose_list f_r">
		<form action="{$form_action}" method="post" name="searchForm">
			<span>{lang key='orders::statistic.select_date_lable'}</span>
	  		<input type="text" class="start_date w110" name="start_date" value="{$start_date}" placeholder="{lang key='orders::statistic.start_date'}"/>
	  		<span>-</span>
	  		<input type="text" class="end_date w110" name="end_date" value="{$end_date}" placeholder="{lang key='orders::statistic.end_date'}"/>
	  		<input type="submit" name="submit" value="{lang key='orders::statistic.query'}" class="btn screen-btn" />
	  	</form>
	</div>
</div>

<div class="row-fluid">
	<div class="choose_list f_r">
		<form action="{$form_action}" method="post" name="selectForm">
			<span>{lang key='orders::statistic.select_month_lable'}</span>
			<!-- {foreach from=$start_date_arr item=sta key=k} -->
			<input type="text" name="year_month" value="{$sta}" class="year_month w110 f_r"/>
			<!-- {if $k < 4} --><span class="f_r">-</span><!-- {/if} -->
			<!-- {/foreach} -->
			<input type="hidden" name="is_multi" value="1" />
    		<input type="submit" name="submit" value="{lang key='orders::statistic.query'}" class="btn screen-btn1" />
		</form>
	</div>
</div>
	
<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="{if $page eq 'init'}active{/if}"><a class="data-pjax" href='{url path="orders/admin_order_stats/init"}{if $start_date}&start_date={$start_date}{/if}&end_date={$end_date}&is_multi={$is_multi}{if $year_month}&year_month={$year_month}{/if}'>{lang key='orders::statistic.order_circs'}</a></li>
				<li class="{if $page eq 'shipping_status'}active{/if}"><a class="data-pjax" href='{url path="orders/admin_order_stats/shipping_status"}{if $start_date}&start_date={$start_date}{/if}&end_date={$end_date}&is_multi={$is_multi}{if $year_month}&year_month={$year_month}{/if}'>{lang key='orders::statistic.shipping_method'}</a></li>
				<li class="{if $page eq 'pay_status'}active{/if}"><a class="data-pjax" href='{url path="orders/admin_order_stats/pay_status"}{if $start_date}&start_date={$start_date}{/if}&end_date={$end_date}&is_multi={$is_multi}{if $year_month}&year_month={$year_month}{/if}'>{lang key='orders::statistic.pay_method'}</a></li>
			</ul>
			<form class="form-horizontal">
				<div class="tab-content">
					<!-- {if $page eq 'init'} -->
					<div class="tab-pane active" id="tab1">
						<!-- {if $is_multi eq ''} -->
						<div class="order_general">
							<div id="order_general" data-url='{RC_Uri::url("orders/admin_order_stats/get_order_general","start_date={$start_date}&end_date={$end_date}&is_multi={$is_multi}")}'>
							</div>
						</div>
						<!-- {elseif $is_multi eq 1} -->
						<div class="order_status">
							<div id="order_status" data-url='{RC_Uri::url("orders/admin_order_stats/get_order_status","is_multi={$is_multi}&year_month={$year_month}")}'>
							</div>
						</div>
						<!-- {/if} -->
					</div>
					<!-- {/if} -->
					
					<!-- {if $page eq 'shipping_status'} -->
					<div class="tab-pane active" id="tab2">
						<!-- {if $is_multi eq ''} -->
			          	<div class="ship_status">
							<div id="ship_status" data-url='{RC_Uri::url("orders/admin_order_stats/get_ship_status","start_date={$start_date}&end_date={$end_date}&is_multi={$is_multi}")}'>
							</div>
						</div>
						<!-- {elseif $is_multi eq 1} -->
						<div class="ship_stats">
							<div id="ship_stats" data-url='{RC_Uri::url("orders/admin_order_stats/get_ship_stats","is_multi={$is_multi}&year_month={$year_month}")}'>
							</div>
						</div>
						<!-- {/if} -->
					</div>
					<!-- {/if} -->
					
					<!-- {if $page eq 'pay_status'} -->
					<div class="tab-pane active" id="tab3">
						<!-- {if $is_multi eq ''} -->
			        	<div class="pay_status">
							<div id="pay_status" data-url='{RC_Uri::url("orders/admin_order_stats/get_pay_status","start_date={$start_date}&end_date={$end_date}&is_multi={$is_multi}")}'>
							</div>
						</div>
						<!-- {elseif $is_multi eq 1} -->
						<div class="pay_stats">
							<div id="pay_stats" data-url='{RC_Uri::url("orders/admin_order_stats/get_pay_stats","is_multi={$is_multi}&year_month={$year_month}")}'></div>
						</div>
						<!-- {/if} -->
					</div>
					<!--{/if}-->
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->