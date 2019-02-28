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
			<a  class="btn btn-primary data-pjax" href='{RC_Uri::url("orders/mh_back/init")}' id="sticky_a" style="float:right;margin-top:-3px;">{t domain="refund"}旧版退货单列表{/t}</a>
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
	        				{t domain="refund"}全部{/t}
	        				<span class="badge badge-info">
	        					{if $refund_list.count.count}{$refund_list.count.count}{else}0{/if}
	        				</span> 
        				</a>
        			</li>
        			<li class="{if $filter.refund_type eq 'refund'}active{/if}">
        				<a class="data-pjax" href='{url path="refund/merchant/init" args="refund_type=refund{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.status}&status={$filter.status}{/if}"}'>
        					{t domain="refund"}仅退款{/t}
        					<span class="badge badge-info">{if $refund_list.count.refund}{$refund_list.count.refund}{else}0{/if}</span>
        				</a>
        			</li>
        			<li class="{if $filter.refund_type eq 'return'}active{/if}">
        				<a class="data-pjax" href='{url path="refund/merchant/init" args="refund_type=return{if $filter.keywords}&keywords={$filter.keywords}{/if}"}{if $filter.status}&status={$filter.status}{/if}'>
        				{t domain="refund"}退货退款{/t}
        				<span class="badge badge-info">{if $refund_list.count.return_refund}{$refund_list.count.return_refund}{else}0{/if}</span>
        				</a>
        			</li>
        			
        			<li class="{if $filter.refund_type eq 'cancel'}active{/if}">
        				<a class="data-pjax" href='{url path="refund/merchant/init" args="refund_type=cancel{if $filter.keywords}&keywords={$filter.keywords}{/if}"}{if $filter.status}&status={$filter.status}{/if}'>
        				{t domain="refund"}撤单退款{/t}
        				<span class="badge badge-info">{if $refund_list.count.cancel}{$refund_list.count.cancel}{else}0{/if}</span>
        				</a>
        			</li>
        			
        		</ul>
            </div>
            
			<div class='col-lg-12 panel-heading form-inline'>
        		<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}">
        		   <div class="screen f_r">
						<div class="form-group">
						  	<span>{t domain="refund"}申请时间：{/t}</span>
		                    <input class="form-control date w110" name="start_date" type="text" placeholder='{t domain="refund"}开始时间{/t}' value="{$smarty.get.start_date}">
		    				<span class="">-</span>
		    				<input class="form-control date w110" name="end_date" type="text" placeholder='{t domain="refund"}结束时间{/t}' value="{$smarty.get.end_date}">
						</div>

						<div class="form-group">
							<select class="w130" name="status">
								<option value="" {if $smarty.get.status eq '' and $smarty.get.status neq 0}selected{/if}>{t domain="refund"}处理状态{/t}</option>
								<option value="0" {if $smarty.get.status neq '' and $smarty.get.status eq 0}selected{/if}>{t domain="refund"}待审核{/t}</option>
								<option value="1" {if $smarty.get.status eq 1}selected{/if}>{t domain="refund"}同意{/t}</option>
								<option value="10" {if $smarty.get.status eq 10}selected{/if}>{t domain="refund"}已取消{/t}</option>
								<option value="11" {if $smarty.get.status eq 11}selected{/if}>{t domain="refund"}不同意{/t}</option>
							</select>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" style="width: 200px;" name="keywords" value="{$filter.keywords}" placeholder='{t domain="refund"}请输入订单编号或退款编号{/t}'>
						</div>
						
						<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> {t domain="refund"}搜索{/t} </button>
					</div>
				</form>
			</div>

			<div class="panel-body panel-body-small">
				<section class="panel">
					 <table class="table table-striped table-hide-edit">
				        <thead>
        					<tr data-sorthref='{url path="refund/merchant/init"}'>
        						<th class="w200">{t domain="refund"}退款编号{/t}</th>
        						<th class="w100">{t domain="refund"}退款方式{/t}</th>
        						<th class="w200">{t domain="refund"}订单编号{/t}</th>
        						<th class="w150">{t domain="refund"}退款金额{/t}</th>
        						<th class="w200" data-toggle="sortby" data-sortby="add_time">{t domain="refund"}申请时间{/t}</th>
        						<th class="w100">{t domain="refund"}处理状态{/t}</th>
        						<th class="w100">{t domain="refund"}平台确认{/t}</th>
        					</tr>
				        </thead>
				        <tbody>
					    <!-- {foreach from=$refund_list.list item=order} -->
    					<tr>
    						<td class="hide-edit-area">
    							{$order.refund_sn}
    							<div class="edit-list">
    								{if $order.refund_type eq 'refund'}
    									<a class="data-pjax" href='{url path="refund/merchant/refund_detail" args="refund_id={$order.refund_id}"}' >{t}查看详情{/t}</a>
    								{else}
    									<a class="data-pjax" href='{url path="refund/merchant/return_detail" args="refund_id={$order.refund_id}"}' >{t}查看详情{/t}</a>
    								{/if}
    								
    							</div>
    						</td>
    						<td>
    							{if $order.refund_type eq 'refund'}{t domain="refund"}仅退款{/t}{else}{t domain="refund"}退货退款{/t}{/if}
    						</td>
    						<td>
    							{$order.order_sn}
    						</td>
    						<td>{$order.refund_total_amount}</td>
    						<td>{$order.add_time}</td>
    						<td>
    							{if $order.status eq 0}{t domain="refund"}待审核{/t}{elseif $order.status eq 1}{t domain="refund"}同意{/t}{elseif $order.status eq 10}{t domain="refund"}已取消{/t}{else}{t domain="refund"}不同意{/t}{/if}
							</td>
							<td>
								{if $order.refund_status eq 1}{t domain="refund"}待处理{/t}{elseif $order.refund_status eq 2}{t domain="refund"}已打款{/t}{else}{t domain="refund"}无{/t}{/if}
							</td>
    					</tr>
    					<!-- {foreachelse}-->
    					<tr><td class="no-records" colspan="7">{t domain="refund"}没有找到任何记录{/t}</td></tr>
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