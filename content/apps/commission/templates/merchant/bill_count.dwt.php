<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.bill.record()
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h3><!-- {if $ur_here}{$ur_here}{/if} --></h3>
  	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
	  <a class="btn btn-primary" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}"><i class="fa fa-reply"></i> {t}{$action_link.text}{/t}</a>
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
                    	<span>按时间段查询：</span>
                    	<input class="form-control start_date w110" name="start_date" type="text" placeholder="开始时间" value="{$smarty.get.start_date}">
    					<span class="">-</span>
    					<input class="form-control end_date w110" name="end_date" type="text" placeholder="结束时间" value="{$smarty.get.end_date}">
    					<input class="btn btn-primary screen-btn" type="submit" value="搜索">
                	</form>
             	 </div>
          	</header>
          
			<div class="panel-body">
              	<section id="unseen">
                	<table class="table table-striped table-advance table-hover">
	        			<thead>
	        				<tr>
	        					<th>{t}日期{/t}</th>
	        					<th class="w150">{t}订单数量{/t}</th>
	        					<th class="w150">{t}订单分成金额{/t}</th>
	        					<th class="w150">{t}退款数量{/t}</th>
	        					<th class="w150">{t}退款分成金额{/t}</th>
	        					<th class="w150">{t}有效分成金额{/t}</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        			<!-- <tr>
	    					<td>
	    						收入
	    					</td>
	    					<td>
	    					   {assign var=order_url value=RC_Uri::url('orders/merchant/info',"order_id={$list.bill_id}")}
	    					   <a href="{$order_url}" target="_blank">2016092662223</a>
	    					</td>
	    					<td>2015-05-12 12:12</td>
	    					<td>￥965.24</td>
	    					<td>已付款已发货</td>
	    					<td>85%</td>
	    					<td>￥812.25</td>
	    					<td>2015-05-12 12:12</td>
	    				</tr> -->
	        			<!-- {foreach from=$bill_day_list.item key=key item=list} -->
	        				<tr>
	            				<td>
	            				{assign var=record_url value=RC_Uri::url('commission/merchant/record',"start_date={$list.day}&end_date={$list.day}")}
	    					       <a href="{$record_url}" target="_blank">{$list.day}</a>
	        					</td>
	        					<td>{$list.order_count}</td>
	        					<td>￥{$list.order_amount}</td>
	        					<td>{$list.refund_count}</td>
	        					<td>￥{$list.refund_amount}</td>
	        					<td>￥{$list.brokerage_amount}</td>
	        				</tr>
	        			<!-- {foreachelse} -->
	        		    	<tr><td class="dataTables_empty" colspan="8">没有找到任何记录</td></tr>
	        		  	<!-- {/foreach} -->
	        			</tbody>
        			</table>
				</section>
			</div>
		</section>
		<!-- {$bill_day_list.page} -->
	</div>
</div>
<!-- {/block} -->