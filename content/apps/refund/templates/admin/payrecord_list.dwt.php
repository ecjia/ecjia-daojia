<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.payrecord_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid">
	<ul class="nav nav-pills">
		<li class="{if $filter.back_type eq 'wait'}active{/if}">
			<a class="data-pjax" href='{url path="refund/admin_payrecord/init" args="back_type=wait{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.refund_type}&status={$filter.refund_status}{/if}"}'>
				{t domain="refund"}待退款{/t}<span class="badge badge-info">{if $data.count.wait}{$data.count.wait}{else}0{/if}</span>
			</a>
		</li>
		
		<li class="{if $filter.back_type eq 'have'}active{/if}">
			<a class="data-pjax" href='{url path="refund/admin_payrecord/init" args="back_type=have{if $filter.keywords}&keywords={$filter.keywords}{/if}"}{if $filter.refund_type}&status={$filter.refund_status}{/if}'>
				{t domain="refund"}已退款{/t}<span class="badge badge-info">{if $data.count.have}{$data.count.have}{else}0{/if}</span>
			</a>
		</li>
	</ul>
	
	<div class="choose_list f_r">
		<form class="f_r" action="{$search_action}"  method="post" name="searchForm">
			<span>{t domain="refund"}申请时间：{/t}</span>
			<input class="f_l w110 date" name="start_date" type="text" placeholder='{t domain="refund"}开始时间{/t}' value="{$smarty.get.start_date}">
			<span class="f_l">{t domain="refund"}至{/t}</span>
			<input class="f_l w110 date" name="end_date" type="text" placeholder='{t domain="refund"}结束时间{/t}' value="{$smarty.get.end_date}">
			
			<select class="w130" name="refund_type">
				<option value="" >{t domain="refund"}申请类型{/t}</option>
				<option value="refund" {if $smarty.get.refund_type eq 'refund'}selected{/if}>{t domain="refund"}仅退款{/t}</option>
				<option value="return" {if $smarty.get.refund_type eq 'return'}selected{/if}>{t domain="refund"}退货退款{/t}</option>
				<option value="cancel" {if $smarty.get.refund_type eq 'cancel'}selected{/if}>{t domain="refund"}撤单退款{/t}</option>
			</select>
			
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="refund"}请输入商家名称或退款编号{/t}'/> 
			<input class="btn screen-btn" type="submit" value='{t domain="refund"}搜索{/t}'>
		</form>
	</div>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="w150">{t domain="refund"}退款编号{/t}</th>
				    <th class="w150">{t domain="refund"}商家名称{/t}</th>
				    <th class="w150">{t domain="refund"}订单编号{/t}</th>
				    <th class="w100">{t domain="refund"}支付方式{/t}</th>
				    <th class="w100">{t domain="refund"}退款金额{/t}</th>
				    <th class="w100">{t domain="refund"}申请时间{/t}</th>
				    {if $smarty.get.back_type eq 'have'}
					    <th class="w100">{t domain="refund"}退款时间{/t}</th>
				    {/if}
				    <th class="w100">{t domain="refund"}处理状态{/t}</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$data.list item=list} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$list.refund_sn}
		     	  	<div class="edit-list">
						<a class="data-pjax" href='{url path="refund/admin_payrecord/detail" args="refund_id={$list.refund_id}"}' title='{t domain="refund"}查看详情{/t}'>{t domain="refund"}查看详情{/t}</a>
		    	  	</div>
		      	</td>
		      	<td>{$list.merchants_name}</td>
		      	<td>{$list.order_sn}</td>
		      	<td>
    				{if $list.back_pay_name}{$list.back_pay_name}{/if}
    			</td>
		      	<td>{$list.order_money_paid}</td>
		      	<td>{$list.add_time}</td>
		      	{if $smarty.get.back_type eq 'have'}
			      	<td>{$list.action_back_time}</td>
		      	{/if}
				<td>
					{if $list.action_back_time}{t domain="refund"}已退款{/t}{else}{t domain="refund"}待退款{/t}{/if}<br>
					{if $smarty.get.back_type eq 'have'}
					{if $list.action_back_type eq 'original'}{t domain="refund"}原路退回{/t}{elseif $list.action_back_type eq 'surplus'}{t domain="refund"}退回余额{/t}{/if}
					{/if}
				</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" {if $smarty.get.back_type eq 'have'}colspan="8"{else}colspan="7"{/if}>{t domain="refund"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->