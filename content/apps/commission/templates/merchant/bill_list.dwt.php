<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.bill.init()
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>{t domain="commission"}温馨提示：{/t}</strong>{t domain="commission"}当月账单未出请查看日账单和订单分成{/t}
</div>
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
	  <a class="btn btn-primary" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}"><i class="fa fa-reply"></i> {$action_link.text}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
          	<header class="panel-heading">
              	<div class="t_r">
	                <form class="form-inline" action="{$search_action}" method="post" name="searchForm">
	                    <span>{t domain="commission"}按时间段查询：{/t}</span>
	                    <input class="form-control start_date w110" name="start_date" type="text" placeholder="{t domain="commission"}开始时间{/t}" value="{$smarty.get.start_date}">
	    				<span class="">-</span>
	    				<input class="form-control end_date w110" name="end_date" type="text" placeholder="{t domain="commission"}结束时间{/t}" value="{$smarty.get.end_date}">
	    				<input class="btn btn-primary screen-btn" type="submit" value="{t domain="commission"}搜索{/t}">
	                </form>
              	</div>
          	</header>
          
			<div class="panel-body">
				<section id="unseen">
					<table class="table table-striped table-advance table-hover">
	        			<thead>
	        				<tr>
	        					<th>{t domain="commission"}账单周期{/t}</th>
	        					<th class="w120">{t domain="commission"}订单数量{/t}</th>
	        					<th class="w120">{t domain="commission"}退款数量{/t}</th>
	        					<th class="w120">{t domain="commission"}入账金额{/t}</th>
	        					<th class="w120">{t domain="commission"}退款金额{/t}</th>
	        					<th class="w120">{t domain="commission"}佣金比例{/t}</th>
	        					<th class="w110">{t domain="commission"}账单金额{/t}</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<!-- {foreach from=$bill_list.item key=key item=list} -->
	        				<tr>
	        					<td>
	        						{assign var=goods_url value=RC_Uri::url('commission/merchant/detail',"id={$list.bill_id}")}
	        						<a href="{$goods_url}" target="_blank">{$list.bill_month}</a>
	        					</td>
	        					<td>{$list.order_count}</td>
	        					<td>{$list.refund_count}</td>
	        					<td>￥{$list.order_amount}</td>
	        					<td>￥{$list.refund_amount}</td>
	        					<td>{$list.percent_value}%</td>
	        					<td>￥{$list.bill_amount}</td>
	        				</tr>
	        				<!-- {foreachelse} -->
	        		    	<tr><td class="dataTables_empty" colspan="8">{t domain="commission"}没有找到任何记录{/t}</td></tr>
	        		  		<!-- {/foreach} -->
	        			</tbody>
	        		</table>
				</section>
			</div>
		</section>
      <!-- {$bill_list.page} -->
	</div>
</div>
<!-- {/block} -->