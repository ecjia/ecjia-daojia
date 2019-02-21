<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.bill.record()
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
	<!-- {if $action_link} -->
	<div class="pull-right">
	  <a class="btn btn-primary" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}"><i class="fa fa-reply"></i>{$action_link.text}</a>
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
	        				    <th class="w80">{t domain="commission"}类型{/t}</th>
	        					<th class="w120">{t domain="commission"}订单编号{/t}</th>
	        					<th class="w120">{t domain="commission"}订单金额{/t}</th>
	        					<th class="w120">{t domain="commission"}分佣金额{/t}</th>
	        					<th class="w80">{t domain="commission"}佣金比例{/t}</th>
	        					<th class="w110">{t domain="commission"}佣金金额{/t}</th>
	        					<th class="w120">{t domain="commission"}入账时间{/t}</th>
	        					<th class="w110">{t domain="commission"}结算时间{/t}</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<!-- {foreach from=$record_list.item key=key item=list} -->
	        				<tr>
	            				<td>
	        						{if $list.order_type eq 'buy' || $list.order_type eq 'quickpay'}{t domain="commission"}收入{/t}{/if}{if $list.order_type eq 'refund'}{t domain="commission"}支出{/t}{/if}
	        					</td>
	        					<td>
	        					{if $list.order_type eq 'buy'}
	        						{assign var=order_url value=RC_Uri::url('orders/merchant/info',"order_id={$list.order_id}")}
	        					{else} 
	        						{assign var=order_url value=RC_Uri::url('quickpay/mh_order/order_info',"order_id={$list.order_id}")}
	        					{/if}
	        						
	    					       <a href="{$order_url}" target="_blank">{$list.order_sn}</a>
	        					</td>
	        					<td>￥{$list.total_fee}</td>
	        					<td>￥{$list.commission_fee}</td>
	        					<td>{$list.percent_value}%</td>
	        					<td>￥{$list.brokerage_amount}</td>
	        					<td>{$list.add_time}</td>
	        					<td>
	        					{if $list.bill_status eq 0}
	        					<a class="label btn-warning">{t domain="commission"}未结算{/t}</a>
	        					{else if $list.bill_status eq 1}
	        					<a class="label btn-success tooltip_ecjia" rel="popover" data-placement="bottom" title="{t domain="commission"}结算时间{/t}" data-content="{$list.bill_time}">{t domain="commission"}已结算{/t}</a>
	        					{/if}
	        					</td>
	        				</tr>
	        				<!-- {foreachelse} -->
	        		    	<tr><td class="dataTables_empty" colspan="8">{t domain="commission"}没有找到任何记录{/t}</td></tr>
	        		  		<!-- {/foreach} -->
	        			</tbody>
	        		</table>
	              </section>
	          </div>
      	</section>
      	<!-- {$record_list.page} -->
	</div>
</div>
<!-- {/block} -->