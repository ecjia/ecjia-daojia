<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.bill.init()
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>温馨提示：</strong>{t}当月账单未出请查看结算记录{/t}
</div>
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
	        					<th>{t}账单周期{/t}</th>
	        					<th class="w200">{t}订单数量{/t}</th>
	        					<th class="w120">{t}入账金额{/t}</th>
	        					<th class="w120">{t}退款金额{/t}</th>
	        					<th class="w120">{t}佣金比例{/t}</th>
	        					<th class="w110">{t}账单金额{/t}</th>
	        					<th class="w110">{t}打款状态{/t}</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<!-- {foreach from=$bill_list.item key=key item=list} -->
	        				<tr>
	        					<td>
	        						{assign var=goods_url value=RC_Uri::url('commission/merchant/detail',"id={$list.bill_id}")}
	        						<a href="{$goods_url}" target="_blank">{$list.bill_month}</a>
	        					</td>
	        					<td>订单({$list.order_count}) 退货({$list.refund_count})</td>
	        					<td>￥{$list.order_amount}</td>
	        					<td>￥{$list.refund_amount}</td>
	        					<td>{$list.percent_value}%</td>
	        					<td>￥{$list.bill_amount}</td>
	        					<td>
	        					{if $list.pay_status eq 1}
	        					<a class="label btn-warning">未打款</a>
	        					{else if $list.pay_status eq 2}
	        					<a class="label btn-info tooltip_ecjia" rel="popover" data-placement="bottom" title="打款时间" data-content="{$list.pay_time_formate}">第{$list.pay_count}笔打款</a>
	        					{else if $list.pay_status eq 3}
	        					<a class="label btn-success tooltip_ecjia" rel="popover" data-placement="bottom" title="打款时间" data-content="{$list.pay_time_formate}">已打款</a>
	        					{/if}
	        					</td>
	        				</tr>
	        				<!-- {foreachelse} -->
	        		    	<tr><td class="dataTables_empty" colspan="8">没有找到任何记录</td></tr>
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