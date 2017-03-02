<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.sale_order.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<!--销售排行-->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>温馨提示：</strong>{t}没有完成的订单不计入销售排行{/t}
</div>
<div class="page-header">
	<div class="pull-left">
		<h3><!-- {if $ur_here}{$ur_here}{/if} --></h3>
	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
		<a class="btn btn-primary" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}&sort_by={$filter.sort_by}&sort_order={$filter.sort_order}"><i class="glyphicon glyphicon-download-alt"></i> {t}{$action_link.text}{/t}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix">
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="t_r">
					<form class="form-inline" action="{$search_action}" method="post" name="theForm">
						<span>按时间段查询：</span>
						<input class="form-control start_date w110" name="start_date" type="text" placeholder="开始时间" value="{$start_date}">
						<span class="">-</span>
						<input class="form-control end_date w110" name="end_date" type="text" placeholder="结束时间" value="{$end_date}">
						<input class="btn btn-primary screen-btn" type="submit" value="搜索">
					</form>
				</div>
			</header>
			<div class="panel-body">
				<section id="unseen">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr data-sorthref='{url path="orders/mh_sale_order/init" args="start_date={$start_date}&end_date={$end_date}"}'>
								<th class="w100">
									{t}排行{/t}
								</th>
								<th>
									{t}商品名称{/t}
								</th>
								<th class="w100">
									{t}货号{/t}
								</th>
								<th class="w80 sorting" data-toggle="sortby" data-sortby="goods_num">
									{t}销售量{/t}
								</th>
								<th class="w120" data-toggle="sortby" data-sortby="turnover">
									{t}销售额{/t}
								</th>
								<th class="w120">
									{t}均价{/t}
								</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_order_data.item key=key item=list} -->
							<tr>
								<td>
									{$key+1}
								</td>
								<td>
				            		{assign var =goods_url value=RC_Uri::url('goods/merchant/preview',"id={$list.goods_id}")}
									<a href="{$goods_url}" target="_blank">{$list.goods_name}</a>
								</td>
								<td>
									{$list.goods_sn}
								</td>
								<td>
									{$list.goods_num}
								</td>
								<td>
									{$list.turnover}
								</td>
								<td>
									{$list.wvera_price}
								</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="dataTables_empty" colspan="6">没有找到任何记录</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
					<!-- {$goods_order_data.page} -->
				</section>
			</div>
		</section>
	</div>
</div>
<!-- {/block} -->