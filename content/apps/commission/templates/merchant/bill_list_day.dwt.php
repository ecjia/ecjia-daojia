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
	        					<th class="w120">{t}账单日期{/t}</th>
	        					<th class="w120">{t}入账金额{/t}</th>
	        					<th class="w120">{t}退款金额{/t}</th>
	        					<th class="w80">{t}佣金比例{/t}</th>
	        					<th class="w120">{t}佣金金额{/t}</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<!-- {foreach from=$bill_list.item key=key item=list} -->
	        				<tr>
	            				<td>
	        						{$list.day}
	        					</td>
	        					<td class="ecjiafc-tar">￥{$list.order_amount}</td>
	        					<td class="ecjiafc-red">￥{$list.refund_amount}</td>
	        					<!-- {if $commission.percent_value} -->
    						    <td>{$list.percent_value}%</td>
    						    <!-- {else} -->
    						    <td>100%</td>
    						    <!-- {/if} -->
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
      	<!-- {$bill_list.page} -->
	</div>
</div>
<!-- {/block} -->