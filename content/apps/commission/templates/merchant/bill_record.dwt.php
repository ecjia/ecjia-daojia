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
	        				    <th class="w80">{t}类型{/t}</th>
	        					<th class="w120">{t}订单编号{/t}</th>
	        					<th class="w120">{t}下单时间{/t}</th>
	        					<th class="w120">{t}金额{/t}</th>
	        					<th class="w150">{t}订单状态{/t}</th>
	        					<th class="w80">{t}佣金比例{/t}</th>
	        					<th class="w110">{t}佣金金额{/t}</th>
	        					<th class="w120">{t}入账时间{/t}</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<!-- {foreach from=$record_list.item key=key item=list} -->
	        				<tr>
	            				<td>
	        						{if $list.order_type eq 1}收入{/if}{if $list.order_type eq 2}支出{/if}
	        					</td>
	        					<td>
	        						{assign var=order_url value=RC_Uri::url('orders/merchant/info',"order_id={$list.order_id}")}
	    					       <a href="{$order_url}" target="_blank">{$list.order_sn}</a>
	        					</td>
	        					<td>{$list.order_add_time_formate}</td>
	        					<td>￥{$list.total_fee}</td>
	        					<td>{$lang_os[$list.order_status]},{$lang_ps[$list.pay_status]},{$lang_ss[$list.shipping_status]}</td>
	        					<td>{$list.percent_value}%</td>
	        					<td>￥{$list.brokerage_amount}</td>
	        					<td>{$list.add_time_formate}</td>
	        				</tr>
	        				<!-- {foreachelse} -->
	        		    	<tr><td class="dataTables_empty" colspan="8">没有找到任何记录</td></tr>
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