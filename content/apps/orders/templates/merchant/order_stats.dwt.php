<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var data = '{$data}';
	var order_stats_json = '{$order_stats_json}';
	ecjia.merchant.order_stats.init(); 
	{if $page eq 'init'}
	ecjia.merchant.chart.order_general(); 
	{else if $page eq 'shipping_status'}
	ecjia.merchant.chart.ship_status(); 
	{else if $page eq 'pay_status'}
	ecjia.merchant.chart.pay_status(); 
	{/if}
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
		<i class="fa fa-times" data-original-title="" title=""></i>
	</button>
	<strong>{t domain="orders"}温馨提示：{/t}</strong>{t domain="orders"}订单统计数据默认显示当年全年统计数据{/t}
</div>

<div class="page-header">
	<div class="pull-left">
		<h2>{if $ur_here}{$ur_here}{/if}</h2>
	</div>
	<div class="pull-right">
		<a href="{$action_link.href}&year={$year}{if $month}&month={$month}{/if}" class="btn btn-primary nopjax"><i class="fa fa-download"></i> {$action_link.text}</a>
	</div>
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body">
				<div class="choose_list f_r">
					<form action="{$form_action}" method="post" name="searchForm">
						<div class="screen f_r">
							<span>{t domain="orders"}选择年份：{/t}</span>
							<div class="f_l m_r5">
								<select class="w150" name="year">
									<option value="0">{t domain="orders"}请选择年份{/t}</option>
									<!-- {foreach from=$year_list item=val} -->
									<option value="{$val}" {if $val eq $year}selected{/if}>{$val}</option>
									<!-- {/foreach} -->
								</select>
							</div>
							<span>{t domain="orders"}选择月份：{/t}</span>
							<div class="f_l m_r5">
								<select class="no_search w120" name="month">
									<option value="0">{t domain="orders"}全年{/t}</option>
									<!-- {foreach from=$month_list item=val} -->
									<option value="{$val}" {if $val eq $month}selected{/if}>{$val}</option>
									<!-- {/foreach} -->
								</select>
							</div>
							<button class="btn btn-primary screen-btn" type="button">{t domain="orders"}查询{/t}</button>
						</div>
					</form>
				</div>
			</div>

			<div class="panel-body">
				<div class="row-fluid">
					<div class="ecjia-order-amount">
						<div class="item">
							<div class="price">{$order_stats.await_pay_count}</div>
							<div class="type">{t domain="orders"}待付款订单（元）{/t}</div>
						</div>

						<div class="item">
							<div class="price">{$order_stats.await_ship_count}</div>
							<div class="type">{t domain="orders"}待发货订单（元）{/t}</div>
						</div>

						<div class="item">
							<div class="price">{$order_stats.shipped_count}</div>
							<div class="type">{t domain="orders"}已发货订单（元）{/t}</div>
						</div>

						<div class="item">
							<div class="price">{$order_stats.returned_count}</div>
							<div class="type">{t domain="orders"}退货订单（元）{/t}</div>
						</div>

						<div class="item">
							<div class="price">{$order_stats.canceled_count}</div>
							<div class="type">{t domain="orders"}已取消订单（元）{/t}</div>
						</div>

						<div class="item">
							<div class="price">{$order_stats.finished_count}</div>
							<div class="type">{t domain="orders"}已完成订单（元）{/t}</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="page-header">
					<div class="pull-left">
						<h4>{t domain="orders"}订单类型{/t}</h4>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="panel-body">
				<div class="row-fluid edit-page">
					<form class="form-horizontal">
						<div class="tab-content">
							<div class="tab-pane active" id="tab">
								<div class="col-lg-5">
									<div id="order_type_chart" style="width: 100%;height:212px;">
									</div>
								</div>
								<div class="col-lg-7">
									<div class="row-fluid">
										<table class="table table-striped table-hide-edit">
											<thead>
												<tr>
													<th class="w180">{t domain="orders"}订单类型{/t}</th>
													<th>{t domain="orders"}总订单数{/t}</th>
													<th>{t domain="orders"}总金额数{/t}</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><a href="{RC_Uri::url('orders/merchant/init')}" target="_blank">{t domain="orders"}配送型订单{/t}</a></td>
													<td>{$order_stats.order_count_data.order_count}</td>
													<td>{$order_stats.order_count_data.total_fee}</td>
												</tr>
												<tr>
													<td><a href="{RC_Uri::url('orders/merchant/init')}&extension_code=group_buy" target="_blank">{t domain="orders"}团购型订单{/t}</a></td>
													<td>{$order_stats.groupbuy_count_data.order_count}</td>
													<td>{$order_stats.groupbuy_count_data.total_fee}</td>
												</tr>
												<tr>
													<td><a href="{RC_Uri::url('orders/merchant/init')}&extension_code=storebuy" target="_blank">{t domain="orders"}到店型订单{/t}</a></td>
													<td>{$order_stats.storebuy_count_data.order_count}</td>
													<td>{$order_stats.storebuy_count_data.total_fee}</td>
												</tr>
												<tr>
													<td><a href="{RC_Uri::url('orders/merchant/init')}&extension_code=storepickup" target="_blank">{t domain="orders"}自提型订单{/t}</a></td>
													<td>{$order_stats.storepickup_count_data.order_count}</td>
													<td>{$order_stats.storepickup_count_data.total_fee}</td>
												</tr>
												<tr>
													<td><a href="{RC_Uri::url('orders/merchant/init')}&extension_code=cashdesk" target="_blank">{t domain="orders"}收银台型订单{/t}</a></td>
													<td>{$order_stats.cashdesk_count_data.order_count}</td>
													<td>{$order_stats.cashdesk_count_data.total_fee}</td>
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

			<div class="panel-body">
				<section id="unseen">
					<ul class="nav nav-tabs">
						<li class="{if $page eq 'init'}active{/if}">
							<a class="data-pjax" href='{url path="orders/mh_order_stats/init"}&year={$year}{if $month}&month={$month}{/if}'>{t domain="orders"}订单概况{/t}</a>
						</li>
						<li class="{if $page eq 'shipping_status'}active{/if}">
							<a class="data-pjax" href='{url path="orders/mh_order_stats/shipping_status"}&year={$year}{if $month}&month={$month}{/if}'>{t domain="orders"}配送方式{/t}</a>
						</li>
						<li class="{if $page eq 'pay_status'}active{/if}">
							<a class="data-pjax" href='{url path="orders/mh_order_stats/pay_status"}&year={$year}{if $month}&month={$month}{/if}'>{t domain="orders"}支付方式{/t}</a>
						</li>
					</ul>
					<form class="form-horizontal">
						<div class="tab-content">
							{if $page eq 'init'}
							<div class="tab-pane active">
								<div class="span12">
									<div id="order_general">
									</div>
								</div>
							</div>
							{/if} {if $page eq 'shipping_status'}
							<div class="tab-pane active">
								<div class="span12">
									<div id="ship_status">
									</div>
								</div>
							</div>
							{/if} {if $page eq 'pay_status'}
							<div class="tab-pane active">
								<div class="span12">
									<div id="pay_status">
									</div>
								</div>
							</div>
							{/if}
						</div>
					</form>
				</section>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->