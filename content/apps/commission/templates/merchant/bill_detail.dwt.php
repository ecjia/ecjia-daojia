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
	  <a class="btn btn-primary" href="{$action_link.href}&start_date={$start_date}&end_date={$end_date}"><i class="fa fa-reply"></i>{$action_link.text}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
          	<header class="panel-heading">{t domain="commission"}本月账单概况{/t}</header>
          
          	<div class="panel-body">
              	<section id="unseen">
	                <table class="table table-bordered table-striped table-condensed">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td align="right" width="30%">{t domain="commission"}账单编号：{/t}</td>
								<td width="20%">{$bill_info.bill_sn}</td>
								<td align="right" width="30%">{t domain="commission"}月份：{/t}</td>
								<td width="20%">{$bill_info.bill_month}</td>
							</tr>
							<tr>
								<td align="right">{t domain="commission"}入账订单数：{/t}</td>
								<td>{$bill_info.order_count}</td>
								<td align="right">{t domain="commission"}入账总金额：{/t}</td>
								<td>{$bill_info.order_amount_formatted}</td>
							</tr>
							<tr>
								<td align="right">{t domain="commission"}退款订单数：{/t}</td>
								<td>{$bill_info.refund_count}</td>
								<td align="right">{t domain="commission"}退款总金额：{/t}</td>
								<td>{$bill_info.refund_amount_formatted}</td>
							</tr>
							<tr>
								<td align="right">{t domain="commission"}佣金百分比：{/t}</td>
								<td>{$bill_info.percent_value}%&nbsp;<a title="{t domain="commission"}以订单入账比例为准{/t}"><i class="fa fa-question-circle"></i></a></td>
								<td align="right"><h4>{t domain="commission"}本月账单金额：{/t}</h4></td>
								<td><h4 class="ecjiaf-ib ecjiafc-red"><b>{$bill_info.bill_amount_formatted}</b></h4>
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
            <li class="{if !$smarty.get.page }active{/if}"><a href="collapse.html#day" data-toggle="tab">{t domain="commission"}每日账单{/t}</a></li>
            <li class="{if $smarty.get.page }active{/if}"><a href="collapse.html#detail" data-toggle="tab">{t domain="commission"}账单明细{/t}</a></li>
        </ul>
        
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade {if !$smarty.get.page } active in{/if}" id="day">
                <table class="table table-striped table-advance table-hover">
        			<thead>
        				<tr>
        					<th>{t domain="commission"}账单日期{/t}</th>
        					<th class="">{t domain="commission"}订单数量{/t}</th>
        					<th class="">{t domain="commission"}退款数量{/t}</th>
						    <th>{t domain="commission"}入账金额{/t}</th>
						    <th>{t domain="commission"}退款金额{/t}</th>
						    <th>{t domain="commission"}佣金比例{/t}</th>
						    <th>{t domain="commission"}商家有效佣金{/t}</th>
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
    						    <td class="">{$commission.order_amount_formatted}</td>
    						    <td class="">{$commission.refund_amount_formatted}</td>
    						    <!-- {if $commission.percent_value} -->
    						    <td>{$commission.percent_value}%</td>
    						    <!-- {else} -->
    						    <td>100%</td>
    						    <!-- {/if} -->
    						    <td>{$commission.brokerage_amount_formatted}</td>
    						</tr>
    						<!-- {foreachelse} -->
    					   <tr><td class="no-records" colspan="7">{t domain="commission"}没有找到任何记录{/t}</td></tr>
    					<!-- {/foreach} -->
        			</tbody>
        		</table>
            </div>
            <div class="tab-pane fade {if $smarty.get.page } active in{/if}" id="detail">
                <table class="table table-striped table-advance table-hover">
        			<thead>
        				<tr>
        					<th class="w80">{t domain="commission"}类型{/t}</th>
        					<th class="w120">{t domain="commission"}订单编号{/t}</th>
        					<th class="w120">{t domain="commission"}金额{/t}</th>
        					<th class="w80">{t domain="commission"}佣金比例{/t}</th>
        					<th class="w110">{t domain="commission"}佣金金额{/t}</th>
        					<th class="w120">{t domain="commission"}入账时间{/t}</th>
        					<th class="w110">{t domain="commission"}结算状态{/t}</th>
        				</tr>
        			</thead>
        			<tbody>
        			<!-- {foreach from=$record_list.item key=key item=list} -->
        				<tr>
            				<td>
        						{if $list.order_type eq 'buy' || $list.order_type eq 'quickpay'}{t domain="commission"}收入{/t}{/if}{if $list.order_type eq 'refund'}{t domain="commission"}支出{/t}{/if}
        					</td>
        					<td>
        						{assign var=order_url value=RC_Uri::url('orders/merchant/info',"order_id={$list.order_id}")}
    					       <a href="{$order_url}" target="_blank">{$list.order_sn}</a>
        					</td>
        					<td>{$list.total_fee_formatted}</td>
        					<td>{$list.percent_value}%</td>
        					<td>{$list.brokerage_amount_formatted}</td>
        					<td>{$list.add_time}</td>
        					<td>{if $list.bill_status eq 0}{t domain="commission"}未结算{/t}{else}{t domain="commission"}已结算{/t}{/if}</td>
        				</tr>
        			<!-- {foreachelse} -->
        		    	<tr><td class="dataTables_empty" colspan="8">{t domain="commission"}没有找到任何记录{/t}</td></tr>
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