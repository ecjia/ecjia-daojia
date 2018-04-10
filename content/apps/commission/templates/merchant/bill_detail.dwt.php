<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.bill.init()
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
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
          	<header class="panel-heading">本月账单概况</header>
          
          	<div class="panel-body">
              	<section id="unseen">
	                <table class="table table-bordered table-striped table-condensed">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td align="right" width="30%">账单编号：</td>
								<td width="20%">{$bill_info.bill_sn}</td>
								<td align="right" width="30%">月份：</td>
								<td width="20%">{$bill_info.bill_month}</td>
							</tr>
							<tr>
								<td align="right">入账订单数：</td>
								<td>{$bill_info.order_count}</td>
								<td align="right">入账总金额：</td>
								<td>￥{$bill_info.order_amount}</td>
							</tr>
							<tr>
								<td align="right">退款订单数：</td>
								<td>{$bill_info.refund_count}</td>
								<td align="right">退款总金额：</td>
								<td>￥{$bill_info.refund_amount}</td>
							</tr>
							<tr>
								<td align="right">佣金百分比：</td>
								<td>{$bill_info.percent_value}%&nbsp;<a title="以订单入账比例为准"><i class="fa fa-question-circle"></i></a></td>
								<td align="right"><h4>本月账单金额：</h4></td>
								<td><h4 class="ecjiaf-ib ecjiafc-red"><b>￥{$bill_info.bill_amount}</b></h4>
								</td>{if 0} = {$bill_info.available_amount} * {$bill_info.percent_value}%{/if}
							</tr>
						</tbody>
	                </table>
				</section>
			</div>
		</section>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
	<section class="panel panel-body">
    	<ul id="myTab" class="nav nav-tabs">
            <li class="{if !$smarty.get.page }active{/if}"><a href="collapse.html#day" data-toggle="tab">每日账单</a></li>
            <li class="{if $smarty.get.page }active{/if}"><a href="collapse.html#detail" data-toggle="tab">账单明细</a></li>
        </ul>
        
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade {if !$smarty.get.page } active in{/if}" id="day">
                <table class="table table-striped table-advance table-hover">
        			<thead>
        				<tr>
        					<th>{t}账单日期{/t}</th>
        					<th class="">{t}订单数量{/t}</th>
        					<th class="">{t}退款数量{/t}</th>
						    <th>{t}入账金额{/t}</th>
						    <th>{t}退款金额{/t}</th>
						    <th>{t}佣金比例{/t}</th>
						    <th>{t}商家有效佣金{/t}</th>
        				</tr>
        			</thead>
        			<tbody>
        			<!-- {foreach from=$bill_list.item item=commission} -->
    						<tr>
    							<td>
    							{$commission.day}
    							</td>
    							<td>{$commission.order_count}</td>
	        					<td>{$commission.refund_count}</td>
    						    <td class="">￥{$commission.order_amount}</td>
    						    <td class="">￥{$commission.refund_amount}</td>
    						    <!-- {if $commission.percent_value} -->
    						    <td>{$commission.percent_value}%</td>
    						    <!-- {else} -->
    						    <td>{t}100%{/t}</td>
    						    <!-- {/if} -->
    						    <td>￥{$commission.brokerage_amount}</td>
    						</tr>
    						<!-- {foreachelse} -->
    					   <tr><td class="no-records" colspan="7">{t}没有找到任何记录{/t}</td></tr>
    					<!-- {/foreach} -->
        			</tbody>
        		</table>
            </div>
            <div class="tab-pane fade {if $smarty.get.page } active in{/if}" id="detail">
                <table class="table table-striped table-advance table-hover">
        			<thead>
        				<tr>
        					<th class="w80">{t}类型{/t}</th>
        					<th class="w120">{t}订单编号{/t}</th>
        					<th class="w120">{t}金额{/t}</th>
        					<th class="w80">{t}佣金比例{/t}</th>
        					<th class="w110">{t}佣金金额{/t}</th>
        					<th class="w120">{t}入账时间{/t}</th>
        					<th class="w110">{t}结算状态{/t}</th>
        				</tr>
        			</thead>
        			<tbody>
        			<!-- {foreach from=$record_list.item key=key item=list} -->
        				<tr>
            				<td>
        						{if $list.order_type eq 'buy' || $list.order_type eq 'quickpay'}收入{/if}{if $list.order_type eq 'refund'}支出{/if}
        					</td>
        					<td>
        						{assign var=order_url value=RC_Uri::url('orders/merchant/info',"order_id={$list.order_id}")}
    					       <a href="{$order_url}" target="_blank">{$list.order_sn}</a>
        					</td>
        					<td>￥{$list.total_fee}</td>
        					<td>{$list.percent_value}%</td>
        					<td>￥{$list.brokerage_amount}</td>
        					<td>{$list.add_time}</td>
        					<td>{if $list.bill_status eq 0}未结算{else}已结算{/if}</td>
        				</tr>
        			<!-- {foreachelse} -->
        		    	<tr><td class="dataTables_empty" colspan="8">没有找到任何记录</td></tr>
        		  	<!-- {/foreach} -->
        			</tbody>
        		</table>
        		<!-- {$record_list.page} -->
            </div>
        </div>
        </section>
  	</div>
</div>
<!-- {/block} -->