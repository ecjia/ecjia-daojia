<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.refund_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
	    <div class="panel">
	     	<div class="panel-body panel-body-small">
        		<ul class="nav nav-pills pull-left">
        			<li class="{if $filter.refund_type eq ''}active{/if}">
        				<a class="data-pjax" href='{url path="refund/merchant/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.status}&status={$filter.status}{/if}"}'>
	        				全部
	        				<span class="badge badge-info">
	        					{if $refund_list.count.count}{$refund_list.count.count}{else}0{/if}
	        				</span> 
        				</a>
        			</li>
        			<li class="{if $filter.refund_type eq 'refund'}active{/if}">
        				<a class="data-pjax" href='{url path="refund/merchant/init" args="refund_type=refund{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.status}&status={$filter.status}{/if}"}'>
        					仅退款
        					<span class="badge badge-info">{if $refund_list.count.refund}{$refund_list.count.refund}{else}0{/if}</span>
        				</a>
        			</li>
        			<li class="{if $filter.refund_type eq 'return'}active{/if}">
        				<a class="data-pjax" href='{url path="refund/merchant/init" args="refund_type=return{if $filter.keywords}&keywords={$filter.keywords}{/if}"}{if $filter.status}&status={$filter.status}{/if}'>
        				退货退款
        				<span class="badge badge-info">{if $refund_list.count.return_refund}{$refund_list.count.return_refund}{else}0{/if}</span>
        				</a>
        			</li>
        		</ul>
            </div>
            
			<div class='col-lg-12 panel-heading form-inline'>
        		<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}">
        		   <div class="screen f_r">
						<div class="form-group">
						  	<span>申请时间：</span>
		                    <input class="form-control date w110" name="start_date" type="text" placeholder="开始时间" value="{$smarty.get.start_date}">
		    				<span class="">-</span>
		    				<input class="form-control date w110" name="end_date" type="text" placeholder="结束时间" value="{$smarty.get.end_date}">
						</div>

						<div class="form-group">
							<select class="w130" name="status">
								<option value="" {if $smarty.get.status eq '' and $smarty.get.status neq 0}selected{/if}>处理状态</option>
								<option value="0" {if $smarty.get.status neq '' and $smarty.get.status eq 0}selected{/if}>待审核</option>
								<option value="1" {if $smarty.get.status eq 1}selected{/if}>同意</option>
								<option value="10" {if $smarty.get.status eq 10}selected{/if}>已取消</option>
								<option value="11" {if $smarty.get.status eq 11}selected{/if}>不同意</option>
							</select>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" style="width: 200px;" name="keywords" value="{$filter.keywords}" placeholder="请输入订单编号或退款编号">
						</div>
						
						<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> 搜索 </button>
					</div>
				</form>
			</div>

			<div class="panel-body panel-body-small">
				<section class="panel">
					 <table class="table table-striped table-hide-edit">
				        <thead>
        					<tr data-sorthref='{url path="refund/merchant/init"}'>
        						<th class="w200">退款编号</th>
        						<th class="w100">退款方式</th>
        						<th class="w200">订单编号</th>
        						<th class="w150">退款金额</th>
        						<th class="w200" data-toggle="sortby" data-sortby="add_time">申请时间</th>
        						<th class="w100">处理状态</th>
        						<th class="w100">平台确认</th>
        					</tr>
				        </thead>
				        <tbody>
					    <!-- {foreach from=$refund_list.list item=order} -->
    					<tr>
    						<td class="hide-edit-area">
    							{$order.refund_sn}
    							<div class="edit-list">
    								{if $order.refund_type eq 'refund'}
    									<a class="data-pjax" href='{url path="refund/merchant/refund_detail" args="refund_id={$order.refund_id}"}' title="查看详情">{t}查看详情{/t}</a>
    								{else}
    									<a class="data-pjax" href='{url path="refund/merchant/return_detail" args="refund_id={$order.refund_id}"}' title="查看详情">{t}查看详情{/t}</a>
    								{/if}
    								
    							</div>
    						</td>
    						<td>
    							{if $order.refund_type eq 'refund'}仅退款{else}退货退款{/if}
    						</td>
    						<td>
    							{$order.order_sn}
    						</td>
    						<td>{$order.refund_total_amount}</td>
    						<td>{$order.add_time}</td>
    						<td>
    							{if $order.status eq 0}待审核{elseif $order.status eq 1}同意{elseif $order.status eq 10}已取消{else}不同意{/if}
							</td>
							<td>
								{if $order.refund_status eq 1}待处理{elseif $order.refund_status eq 2}已打款{else}无{/if}
							</td>
    					</tr>
    					<!-- {foreachelse}-->
    					<tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
    					<!-- {/foreach} -->
				        </tbody>
			         </table>
				</section>
				<!-- {$refund_list.page} -->
			</div>
	     </div>
     </div>
</div>
<!-- {/block} -->