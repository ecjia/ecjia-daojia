<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.sale_list.init()
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<!--销售明细-->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>{t domain="orders"}温馨提示：{/t}</strong>{t domain="orders"}没有完成的订单不计入销售明细{/t}
</div>
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
		<a class="btn btn-primary" id="sticky_a" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}"><i class="glyphicon glyphicon-download-alt"></i> {$action_link.text}</a>
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
						<span>{t domain="orders"}按时间段查询：{/t}</span>
						<input class="form-control start_date w110" name="start_date" type="text" placeholder='{t domain="orders"}开始时间{/t}' value="{$start_date}">
						<span class="">-</span>
						<input class="form-control end_date w110" name="end_date" type="text" placeholder='{t domain="orders"}结束时间{/t}' value="{$end_date}">
						<input class="btn btn-primary screen-btn" type="submit" value='{t domain="orders"}搜索{/t}'>
					</form>
				</div>
			</header>
			<div class="panel-body">
				<section id="unseen">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr style="border-bottom:1px solid #ddd;">
								<th>
                                    {t domain="orders"}商品名称{/t}
								</th>
								<th class="w200">
                                    {t domain="orders"}订单号{/t}
								</th>
								<th class="w70">
                                    {t domain="orders"}数量{/t}
								</th>
								<th class="w120">
                                    {t domain="orders"}售价{/t}
								</th>
								<th class="w110">
                                    {t domain="orders"}售出日期{/t}
								</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$sale_list_data.item key=key item=list} -->
							<tr>
								<td>
									{assign var =goods_url value=RC_Uri::url('goods/merchant/preview',"id={$list.goods_id}")}
									<a href="{$goods_url}" target="_blank">{$list.goods_name}</a>
								</td>
								<td>
									{$list.order_sn}
								</td>
								<td>
									{$list.goods_num}
								</td>
								<td>
									{$list.sales_price}
								</td>
								<td>
									{$list.sales_time}
								</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="dataTables_empty" colspan="5">{t domain="orders"}没有找到任何记录{/t}</td>
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