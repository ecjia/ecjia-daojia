<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
{if $action != 'pay_log'}
var MAX_AMOUNT = {$merchants_info.pay_amount};
ecjia.admin.bill_pay.init();
{/if}
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
    			<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>账单概况</strong></a>
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
    						<td align="right"><div align="right"><strong>入账总金额：</strong></div></td>
    						<td>￥{$bill_info.order_amount}</td>
    					</tr>
    					<tr>
    						<td align="right"><div align="right"><strong>退款订单数：</strong></div></td>
    						<td>{$bill_info.refund_count}</td>
    						<td align="right"><div align="right"><strong>退款总金额：</strong></div></td>
    						<td class="ecjiafc-red">￥{$bill_info.refund_amount}</td>
    					</tr>
    					<tr>
    						<td align="right"><div align="right"><strong>有效分成金额：</strong></div></td>
    						<td>￥{$bill_info.available_amount}</td>
    						<td align="right"><div align="right"><strong>佣金百分比：</strong></div></td>
    						<td>{$bill_info.percent_value}%</td>
    					</tr>
    					<tr>
    						<td align="right"><h4 align="right">本月账单金额：</h4></td>
    						<td colspan="1"><b class="ecjiaf-fs3">￥{$bill_info.bill_amount}</b><span class="m_l10 m_r10">= {$bill_info.order_amount} * {$bill_info.percent_value}%</span>
    						</td><td align="right"><div align="right"><strong>打款状态：</strong></div></td>
    						<td>
    						 {if $bill_info.pay_status eq 1}
        					<a class="label btn-warning">未打款</a>
        					{else if $bill_info.pay_status eq 2}
        					<a class="label btn-info hint--top" data-hint="打款时间:{$bill_info.pay_time_formate}">第{$log_list.filter.count_all}笔打款</a>
        					{else if $bill_info.pay_status eq 3}
        					<a class="label btn-success hint--top" data-hint="打款时间:{$bill_info.pay_time_formate}">已打款</a>&nbsp;(共{$log_list.filter.count_all}笔)
        					{/if}
    						 </td>
    					</tr>
    				</tbody>
                </table>
    		</div>
        </div>

        <div class="accordion-group">
    		<div class="accordion-heading accordion-heading-url">
    			<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFour">
    				<strong>流水明细</strong>
    			</div>
    		</div>
    		<div class="accordion-body in collapse" id="collapseFour">
    		     <table class="table table-striped table-advance table-hover m_b0">
        			<thead>
        				<tr>
        				    <th class="w120">{t}打款时间{/t}</th>
        				    <th class="w110">{t}打款人{/t}</th>
        					<th class="w80">{t}打款金额{/t}</th>
        					<th class="w80">{t}收款人{/t}</th>
        					<th class="w120">{t}银行账号{/t}</th>
        					<th class="w120">{t}收款银行{/t}</th>
        					<th class="w150">{t}开户行支行{/t}</th>
        					<th class="w110">{t}手机号{/t}</th>
        				</tr>
        			</thead>
        			<tbody>
        			<!-- {foreach from=$log_list.item key=key item=list} -->
        				<tr>
            				<td>{$list.add_time_formate}</td>
            				<td>{$list.user_name}</td>
            				<td>￥{$list.bill_amount}</td>
        					<td>{$list.payee}</td>
        					<td>{$list.bank_account_number}</td>
        					<td>{$list.bank_name}</td>
        					<td>{$list.bank_branch_name}</td>
        					<td>{$list.mobile}</td>
        				</tr>
        			<!-- {foreachelse} -->
        		    	<tr><td class="dataTables_empty" colspan="8">没有找到任何记录</td></tr>
        		  	<!-- {/foreach} -->
        			</tbody>
        		</table>
    		</div>
        </div>
        {if $action != 'pay_log'}
        {if $bill_info.pay_status neq 3}
        <!-- 打款操作 -->
        <div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapsePay"><strong>打款操作</strong></a>
			</div>
			<div class="accordion-body in collapse" id="collapsePay">
			<form class="" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr> 
							<td width="15%"><div align="right"><strong>剩余打款金额：</strong></div></td> 
							<td colspan="3">
    							<div class="control-group m_b0"><div class="controls">
    							<input type="text" name="pay_amount" value="{$merchants_info.pay_amount}" /><span class="input-must">{lang key='system::system.require_field'}</span>
    							</div></div>
							</td>
						</tr>
						<tr> 
							<td width="15%"><div align="right"><strong>收款人：</strong></div></td> 
							<td colspan="3">
    							<div class="control-group m_b0"><div class="controls">
    							<input type="text" name="payee" value="{$merchants_info.bank_account_name}" /><span class="input-must">{lang key='system::system.require_field'}</span>
    							</div></div>
							</td>
						</tr>
						<tr> 
							<td width="15%"><div align="right"><strong>收款卡号：</strong></div></td> 
							<td colspan="3">
    							<div class="control-group m_b0"><div class="controls">
    							<input type="text" name="bank_account_number" value="{$merchants_info.bank_account_number}" class="w330" /><span class="input-must">{lang key='system::system.require_field'}</span>
    							</div></div>
							</td>
						</tr>
						<tr> 
							<td width="15%"><div align="right"><strong>收款银行：</strong></div></td> 
							<td colspan="3">
    							<div class="control-group m_b0"><div class="controls">
    							<input type="text" name="bank_name" value="{$merchants_info.bank_name}" class="w330" /><span class="input-must">{lang key='system::system.require_field'}</span>
    							</div></div>
							</td>
						</tr>
						<tr> 
							<td width="15%"><div align="right"><strong>收款银行支行：</strong></div></td> 
							<td colspan="3"><input type="text" name="bank_branch_name" value="{$merchants_info.bank_branch_name}" class="w330" /></td>
						</tr>
						<tr> 
							<td width="15%"><div align="right"><strong>手机号：</strong></div></td> 
							<td colspan="3"><input type="text" name="mobile" value="{$merchants_info.contact_mobile}" /></td>
						</tr>
						<tr>
							<td><div align="right"><strong>当前可执行操作：</strong></div></td>
							<td colspan="3">
							    <input name="bill_id" type="hidden" value="{$bill_info.bill_id}">	
								<button class="btn btn-gebo operatesubmit f_l" type="submit" name="after_service">保存打款记录</button><p class="help-block f_l m_t5 m_l15">打款后请及时保存打款记录</p>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			</div>
		</div>
		{/if}
		{/if}
	</div>
</div>
<!-- {/block} -->