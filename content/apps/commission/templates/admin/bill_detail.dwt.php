<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.bill_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
    
<div class="row-fluid">
    <div class="col-lg-12 foldable-list ">
        <div class="accordion-group">
    		<div class="accordion-heading">
    			<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>本月账单概况</strong></a>
    		</div>
    		<div class="accordion-body in collapse" id="collapseOne">
    			<table class="table table-oddtd m_b0">
    				<tbody class="first-td-no-leftbd">
    					<tr>
    						<td align="right" width="30%"><div align="right"><strong>账单编号：</strong></div></td>
    						<td width="20%">{$bill_info.bill_sn} <a href='{url path="store/admin/preview" args="store_id={$bill_info.store_id}"}' class=" m_l10">{$bill_info.merchants_name}</a></td>
    						<td align="right" width="30%"><div align="right"><strong>月份：</strong></div></td>
    						<td width="20%">{$bill_info.bill_month}</td>
    					</tr>
    					<tr>
    						<td align="right"><div align="right"><strong>入账订单数：</strong></div></td>
    						<td>{$bill_info.order_count}</td>
    						<td align="right"><div align="right"><strong>入账总金额：</strong></div></td>
    						<td>￥{$bill_info.order_amount}</td>
    					</tr>
    					<tr>
    						<td align="right"><div align="right"><strong>退款订单数：</strong></div></td>
    						<td>{$bill_info.refund_count}</td>
    						<td align="right"><div align="right"><strong>退款总金额：</strong></div></td>
    						<td class="">￥{$bill_info.refund_amount}</td>
    					</tr>
    					<tr>
    						<td align="right"><h4 align="right">本月账单金额：</h4></td>
    						<td colspan="3"><b class="ecjiaf-fs3 ecjiafc-red">￥{$bill_info.bill_amount}</b><span class="m_l10 m_r10">({$bill_info.percent_value}%，以订单入账比例为准)</span>
    						</td>
    					</tr>
    					<tr>
    						<td align="right"><div align="right"><strong>操作：</strong></div></td>
    						<td colspan="3">账单不对？<a href='{RC_Uri::url("commission/admin/bill_refresh")}' class="cursor_pointer toggle_view" data-id="{$bill_info.bill_id}" data-msg="您确定要重新生成账单吗？" title="点击重新生成账单">重新生成<i class="fontello-icon-cw"></i></a>
    						</td>
    				</tbody>
                </table>
    		</div>
        </div>

        
        <div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="{if !$smarty.get.page }active{/if}"><a href="#tab1" data-toggle="tab">每日账单</a></li>
				<li class="{if $smarty.get.page }active{/if}"><a href="#tab2" data-toggle="tab">账单明细</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane {if !$smarty.get.page }active{/if}" id="tab1">
					<table class="table table-striped table-advance table-hover m_b0">
        			<thead>
        				<tr>
        					<th>{t}账单日期{/t}</th>
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
    						    <td class="ecjiaf-tar">￥{$commission.order_amount}</td>
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
				<div class="tab-pane {if $smarty.get.page }active{/if}" id="tab2">
					<table class="table table-striped table-advance table-hover m_b0">
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
        						{if $list.order_type eq 'buy'}订单{elseif $list.order_type eq 'refund'}<span class="">退款</span>{elseif $list.order_type eq 'quickpay'}优惠买单{/if}
        					</td>
        					<td>
        						{assign var=order_url value=RC_Uri::url('orders/admin/info',"order_id={$list.order_id}")}
    					       <a href="{$order_url}" target="_blank">{$list.order_sn}</a>
        					</td>
        					<td>￥{$list.total_fee}</td>
        					<td>{$list.percent_value}%</td>
        					<td>
        					{if $list.order_type eq 'buy'}￥{$list.brokerage_amount}{/if}
        					{if $list.order_type eq 'refund'}<span class="">￥{$list.brokerage_amount}</span>{/if}
        					</td>
        					<td>{$list.add_time}</td>
        					<td>{if $list.bill_status eq 0}未结算{else}已结算{/if}</td>
        				</tr>
        			<!-- {foreachelse} -->
        		    	<tr><td class="dataTables_empty" colspan="9">没有找到任何记录</td></tr>
        		  	<!-- {/foreach} -->
        			</tbody>
        		</table>
        		<!-- {$record_list.page} -->
				</div>
			</div>
		</div>
				
    </div>
</div>
<!-- {/block} -->