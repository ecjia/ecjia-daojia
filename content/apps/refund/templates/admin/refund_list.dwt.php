<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.refund_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<a class="btn plus_or_reply data-pjax" href='{RC_Uri::url("orders/admin_order_back/init")}'>旧版退货单列表</a>
	</h3>
	
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid">
	<ul class="nav nav-pills">
		<li class="{if $filter.refund_type eq ''}active{/if}">
			<a class="data-pjax" href='{url path="refund/admin/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.refund_status}&refund_status={$filter.refund_status}{/if}"}'>
				全部
				<span class="badge badge-info">
					{if $data.count.count}{$data.count.count}{else}0{/if}
				</span> 
			</a>
		</li>
		<li class="{if $filter.refund_type eq 'refund'}active{/if}">
			<a class="data-pjax" href='{url path="refund/admin/init" args="refund_type=refund{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.refund_status}&refund_status={$filter.refund_status}{/if}"}'>
				仅退款
				<span class="badge badge-info">{if $data.count.refund}{$data.count.refund}{else}0{/if}</span>
			</a>
		</li>
		<li class="{if $filter.refund_type eq 'return'}active{/if}">
			<a class="data-pjax" href='{url path="refund/admin/init" args="refund_type=return{if $filter.keywords}&keywords={$filter.keywords}{/if}"}{if $filter.refund_status}&refund_status={$filter.refund_status}{/if}'>
			退货退款
			<span class="badge badge-info">{if $data.count.return_refund}{$data.count.return_refund}{else}0{/if}</span>
			</a>
		</li>
		
		<li class="{if $filter.refund_type eq 'cancel'}active{/if}">
			<a class="data-pjax" href='{url path="refund/admin/init" args="refund_type=cancel{if $filter.keywords}&keywords={$filter.keywords}{/if}"}{if $filter.refund_status}&refund_status={$filter.refund_status}{/if}'>
			撤单退款
			<span class="badge badge-info">{if $data.count.cancel}{$data.count.cancel}{else}0{/if}</span>
			</a>
		</li>
	</ul>
	
	<div class="choose_list f_r">
		<form class="f_r" action="{$search_action}"  method="post" name="searchForm">
			<span>申请时间：</span>
			<input class="f_l w110 date" name="start_date" type="text" placeholder="开始时间" value="{$smarty.get.start_date}">
			<span class="f_l">至</span>
			<input class="f_l w110 date" name="end_date" type="text" placeholder="结束时间" value="{$smarty.get.end_date}">
			
			<select class="w130" name="refund_status">
				<option value="" {if $smarty.get.refund_status eq '' and $smarty.get.refund_status neq 0}selected{/if}>处理状态</option>
				<option value="0" {if $smarty.get.refund_status neq '' and $smarty.get.refund_status eq 0}selected{/if}>无</option>
				<option value="1" {if $smarty.get.refund_status eq 1}selected{/if}>待处理</option>
				<option value="2" {if $smarty.get.refund_status eq 2}selected{/if}>已打款</option>
			</select>
			
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入商家名称或退款/订单编号"/>
			<input class="btn screen-btn" type="submit" value="搜索">
		</form>
	</div>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr  data-sorthref='{url path="refund/admin/init"}'>
				    <th class="w150">退款编号</th>
				    <th class="w150">商家名称</th>
				    <th class="w150">订单编号</th>
				    <th class="w50">申请类型</th>
				    <th class="w50">退款金额</th>
				    <th class="w150" data-toggle="sortby" data-sortby="add_time">申请时间</th>
				    <th class="w50">处理状态</th>
				    <th class="w50">商家确认</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$data.list item=list} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$list.refund_sn}
		     	  	<div class="edit-list">
				        {if $list.refund_type eq 'refund' OR $list.refund_type eq 'cancel'}
							<a class="data-pjax" href='{url path="refund/admin/refund_detail" args="refund_id={$list.refund_id}"}' title="查看详情">{t}查看详情{/t}</a>
						{else}
							<a class="data-pjax" href='{url path="refund/admin/return_detail" args="refund_id={$list.refund_id}"}' title="查看详情">{t}查看详情{/t}</a>
						{/if}
		    	  	</div>
		      	</td>
		      	<td>{$list.merchants_name}</td>
		      	<td>{$list.order_sn}</td>
		      	<td>
    				{if $list.refund_type eq 'refund'}仅退款{elseif $list.refund_type eq 'return'}退货退款{else}撤单退款{/if}
    			</td>
		      	<td>{$list.refund_total_amount}</td>
		      	<td>{$list.add_time}</td>
		      	<td>
					{if $list.refund_status eq 1}<font class="ecjiafc-red">待处理</font>{elseif $list.refund_status eq 2}<font class="ecjiafc-green">已打款</font>{else}无{/if}
				</td>
				<td>
					{if $list.status eq 0}待审核{elseif $list.status eq 1}<font class="ecjiafc-green">同意</font>{elseif $list.status eq 10}已取消{else}不同意{/if}
				</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->