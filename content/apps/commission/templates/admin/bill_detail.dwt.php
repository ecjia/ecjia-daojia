<!-- {extends file="ecjia.dwt.php"} -->

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
    						<td width="20%">{$bill_info.bill_sn} <a href='{url path="store/admin/preview" args="store_id={$bill_info.store_id}"}' class="ecjiafc-red m_l10">{$bill_info.merchants_name}</a></td>
    						<td align="right" width="30%"><div align="right"><strong>月份：</strong></div></td>
    						<td width="20%">{$bill_info.bill_month}</td>
    					</tr>
    					<tr>
    						<td align="right"><div align="right"><strong>入账订单数：</strong></div></td>
    						<td>{$bill_info.order_count}</td>
    						<td align="right"><div align="right"><strong>订单总金额：</strong></div></td>
    						<td>￥{$bill_info.order_amount}</td>
    					</tr>
    					<tr>
    						<td align="right"><div align="right"><strong>退款订单数：</strong></div></td>
    						<td>{$bill_info.refund_count}</td>
    						<td align="right"><div align="right"><strong>退款总金额：</strong></div></td>
    						<td class="ecjiafc-red">￥{$bill_info.refund_amount}</td>
    					</tr>
    					<tr>
    						<td align="right"><h4 align="right">本月账单金额：</h4></td>
    						<td><b class="ecjiaf-fs3">￥{$bill_info.bill_amount}</b><span class="m_l10 m_r10">({$bill_info.percent_value}%，以订单入账比例为准)</span>
    						</td>
    						<td align="right"><div align="right"><strong>打款状态：</strong></div></td>
    						<td>
    						 {if $bill_info.pay_status eq 1}
        					<a class="label btn-warning">未打款</a>
        					<a class="ecjiaf-tdn m_l10" target="_blank" href='{url path="commission/admin/pay" args="bill_id={$bill_info.bill_id}"}'>
								<button class="btn btn-gebo" type="button">去打款</button>
							</a>
        					{else if $bill_info.pay_status eq 2}
        					<a class="label btn-info hint--top" title="点击查看打款日志" href='{url path="commission/admin/pay_log" args="bill_id={$bill_info.bill_id}"}' data-hint="打款时间:{$bill_info.pay_time_formate}">第{$bill_info.pay_count}笔打款</a>
        					<a class="ecjiaf-tdn m_l10" target="_blank" href='{url path="commission/admin/pay" args="bill_id={$bill_info.bill_id}"}'>
								<button class="btn btn-gebo" type="button">去打款</button>
							</a>
        					{else if $bill_info.pay_status eq 3}
        					<a class="label btn-success hint--top" title="点击查看打款日志" href='{url path="commission/admin/pay_log" args="bill_id={$bill_info.bill_id}"}' data-hint="打款时间:{$bill_info.pay_time_formate}">已打款</a>&nbsp;(共{$bill_info.pay_count}笔)
        					{/if}
        					<!-- <a class="label btn-success hint--top" data-hint="打款时间:2015-25-65 14:12{$bill_info.pay_time_formate}">已打款</a> -->
    						 </td>
    					</tr>
    				</tbody>
                </table>
    		</div>
        </div>

        <div class="accordion-group">
    		<div class="accordion-heading accordion-heading-url">
    			<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFour">
    				<strong>账单明细</strong>
    			</div>
    		</div>
    		<div class="accordion-body in collapse" id="collapseFour">
    		     <table class="table table-striped table-advance table-hover m_b0">
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
        						{if $list.order_type eq 1}订单{/if}{if $list.order_type eq 2}<span class="ecjiafc-red">退款</span>{/if}
        					</td>
        					<td>
        						{assign var=order_url value=RC_Uri::url('orders/admin/info',"order_id={$list.order_id}")}
    					       <a href="{$order_url}" target="_blank">{$list.order_sn}</a>
        					</td>
        					<td>{$list.order_add_time_formate}</td>
        					<td>￥{$list.total_fee}</td>
        					<td>{$lang_os[$list.order_status]},{$lang_ps[$list.pay_status]},{$lang_ss[$list.shipping_status]}</td>
        					<td>{$list.percent_value}%</td>
        					<td>
        					{if $list.order_type eq 1}￥{$list.brokerage_amount}{/if}
        					{if $list.order_type eq 2}<span class="ecjiafc-red">￥{$list.brokerage_amount}</span>{/if}
        					</td>
        					<td>{$list.add_time_formate}</td>
        				</tr>
        			<!-- {foreachelse} -->
        		    	<tr><td class="dataTables_empty" colspan="8">没有找到任何记录</td></tr>
        		  	<!-- {/foreach} -->
        			</tbody>
        		</table>
    		</div>
        </div>
        <!-- {$record_list.page} -->
    </div>
</div>
<!-- {/block} -->