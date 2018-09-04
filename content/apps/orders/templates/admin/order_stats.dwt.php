<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var data = '{$data}';
	var order_stats_json = '{$order_stats_json}';
	ecjia.admin.order_stats.init(); 
	{if $page eq 'init'}
	ecjia.admin.chart.order_general(); 
	{else if $page eq 'shipping_status'}
	ecjia.admin.chart.ship_status(); 
	{else if $page eq 'pay_status'}
	ecjia.admin.chart.pay_status(); 
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
		<a class="btn plus_or_reply" id="sticky_a" href='{$action_link.href}&store_id={$store_id}&year={$year}{if $month}&month={$month}{/if}'>
			<i class="fontello-icon-download"></i>{$action_link.text}</a>
		<a class="btn plus_or_reply nopjax" id="sticky_a" href='{RC_Uri::url("orders/admin_order_stats/init")}'>
			<i class="fontello-icon-reply"></i>订单统计</a>
	</h3>
</div>

<div class="row-fluid">
	<div class="choose_list f_r">
		<form action="{$form_action}" method="post" name="searchForm">
			<div class="screen f_r">
				<span>选择年份：</span>
				<div class="f_l m_r5">
					<select class="w150" name="year">
						<option value="0">请选择年份</option>
						<!-- {foreach from=$year_list item=val} -->
						<option value="{$val}" {if $val eq $year}selected{/if}>{$val}</option>
						<!-- {/foreach} -->
					</select>
				</div>
				<span>选择月份：</span>
				<div class="f_l m_r5">
					<select class="no_search w120" name="month">
						<option value="0">全年</option>
						<!-- {foreach from=$month_list item=val} -->
						<option value="{$val}" {if $val eq $month}selected{/if}>{$val}</option>
						<!-- {/foreach} -->
					</select>
				</div>
				<button class="btn screen-btn" type="button">查询</button>
			</div>
		</form>
	</div>
</div>
<div class="row-fluid">
	<div class="ecjia-order-amount">
		<div class="item">
			<div class="price">{$order_stats.await_pay_count}</div>
			<div class="type">待付款订单（元）</div>
		</div>
		
		<div class="item">
			<div class="price">{$order_stats.await_ship_count}</div>
			<div class="type">待发货订单（元）</div>
		</div>
		
		<div class="item">
			<div class="price">{$order_stats.shipped_count}</div>
			<div class="type">已发货订单（元）</div>
		</div>
		
		<div class="item">
			<div class="price">{$order_stats.returned_count}</div>
			<div class="type">退货订单（元）</div>
		</div>
		
		<div class="item">
			<div class="price">{$order_stats.canceled_count}</div>
			<div class="type">已取消订单（元）</div>
		</div>
		
		<div class="item">
			<div class="price">{$order_stats.finished_count}</div>
			<div class="type">已完成订单（元）</div>
		</div>
	</div>
</div>

<div class="m_t20">
	<h3 class="heading">
		订单类型
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal">
				<div class="tab-content">
					<div class="tab-pane active" id="tab">
						<div class="span4">
							<div id="order_type_chart" style="width: 100%;height:212px;">
							</div>
						</div>
						<div class="span8">
							<div class="row-fluid">
								<table class="table table-striped table-hide-edit">
									<thead>
										<tr>
											<th class="w180">订单类型</th>
											<th>总订单数</th>
											<th>总金额数</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><a href="{RC_Uri::url('orders/admin/init')}" target="__blank">配送型订单</a></td>
											<td>{$order_stats.order_count_data.order_count}</td>
											<td>{$order_stats.order_count_data.total_fee}</td>
										</tr>
										<tr>
											<td><a href="{RC_Uri::url('orders/admin/init')}&extension_code=group_buy" target="__blank">团购型订单</a></td>
											<td>{$order_stats.groupbuy_count_data.order_count}</td>
											<td>{$order_stats.groupbuy_count_data.total_fee}</td>
										</tr>
										<tr>
											<td><a href="{RC_Uri::url('orders/admin/init')}&extension_code=storebuy" target="__blank">到店型订单</a></td>
											<td>{$order_stats.storebuy_count_data.order_count}</td>
											<td>{$order_stats.storebuy_count_data.total_fee}</td>
										</tr>
										<tr>
											<td><a href="{RC_Uri::url('orders/admin/init')}&extension_code=storepickup" target="__blank">自提型订单</a></td>
											<td>{$order_stats.storepickup_count_data.order_count}</td>
											<td>{$order_stats.storepickup_count_data.total_fee}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="m_t20">
	<h3 class="heading">
		数据统计
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="{if $page eq 'init'}active{/if}">
					<a class="data-pjax" href='{url path="orders/admin_order_stats/stats"}&store_id={$store_id}&year={$year}{if $month}&month={$month}{/if}'>{lang key='orders::statistic.order_circs'}</a>
				</li>
				<li class="{if $page eq 'shipping_status'}active{/if}">
					<a class="data-pjax" href='{url path="orders/admin_order_stats/shipping_status"}&store_id={$store_id}&year={$year}{if $month}&month={$month}{/if}'>{lang key='orders::statistic.shipping_method'}</a>
				</li>
				<li class="{if $page eq 'pay_status'}active{/if}">
					<a class="data-pjax" href='{url path="orders/admin_order_stats/pay_status"}&store_id={$store_id}&year={$year}{if $month}&month={$month}{/if}'>{lang key='orders::statistic.pay_method'}</a>
				</li>
			</ul>
			<form class="form-horizontal">
				<div class="tab-content">
					<!-- {if $page eq 'init'} -->
					<div class="tab-pane active">
						<div class="order_general">
							<div id="order_general">
							</div>
						</div>
					</div>
					<!-- {/if} -->

					<!-- {if $page eq 'shipping_status'} -->
					<div class="tab-pane active">
						<div class="ship_status">
							<div id="ship_status">
							</div>
						</div>
					</div>
					<!-- {/if} -->

					<!-- {if $page eq 'pay_status'} -->
					<div class="tab-pane active">
						<div class="pay_status">
							<div id="pay_status">
							</div>
						</div>
					</div>
					<!--{/if}-->
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->