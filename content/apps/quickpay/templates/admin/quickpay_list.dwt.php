<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.quickpay_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<ul class="nav nav-pills">
		<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin/init" args="{if $filter.merchant_name}&merchant_name={$filter.merchant_name}{/if}{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>全部 <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'on_going'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin/init" args="type=on_going{if $filter.merchant_name}&merchant_name={$filter.merchant_name}{/if}{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>正在进行中 <span class="badge badge-info">{if $type_count.on_sale}{$type_count.on_sale}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'self'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin/init" args="type=self{if $filter.merchant_name}&merchant_name={$filter.merchant_name}{/if}{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>自营 <span class="badge badge-info">{if $type_count.self}{$type_count.self}{else}0{/if}</span> </a></li>
	</ul>
	
	<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>批量操作
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='quickpay/admin/batch'}" data-msg="您确实要删除选中的买单规则吗？" data-noSelectMsg="请先选中要删除的买单规则！" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>删除买单规则</a></li>
			</ul>
		</div>
		<div class="choose_list f_r">
			<input type="text" name="merchant_name" value="{$smarty.get.merchant_name}" placeholder="请输入商家名称"/>
			<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder="请输入买单规则名称"/> 
			<button class="btn search_quickpay" type="button">搜索</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
				    <th class="w150">买单标题</th>
				    <th class="w150">商家名称</th>
				    <th class="w150">买单优惠类型</th>
				    <th class="w100">开始时间</th>
				    <th class="w100">结束时间</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$data.list item=quickpay} -->
		    <tr>
		    	<!-- {if $quickpay.manage_mode eq 'self'} -->
					<td>
						<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$quickpay.id}"/></span>
					</td>
				<!-- {else} -->
					<td>
						<span><input type="checkbox" name="checkboxes[]" class="checkbox1" value="{$quickpay.id}" disabled="true" /></span>
					</td>
				<!-- {/if} -->
	    	
		      	<td class="hide-edit-area">
					{$quickpay.title}
		     	  	<div class="edit-list">
			     	  	{if $quickpay.manage_mode eq 'self'}
						  	<a class="data-pjax" href='{url path="quickpay/admin/edit" args="id={$quickpay.id}&store_id={$quickpay.store_id}"}' title="编辑">编辑</a>&nbsp;|&nbsp;
				          	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="你确定要删除该买单规则吗？" href='{url path="quickpay/admin/remove" args="id={$quickpay.id}"}' title="删除">删除</a>
				        {else}
				        	<a target="_blank" href='{url path="quickpay/admin/detail" args="id={$quickpay.id}"}' title="查看详情">查看详情</a>
				        {/if}	
		    	  	</div>
		      	</td>
		      	<td class="ecjiafc-red">{$quickpay.merchants_name}</td>
		      	<td>{if $quickpay.activity_type eq 'discount'}价格折扣{elseif $quickpay.activity_type eq 'everyreduced'}每满多少减多少，最高减多少{else $quickpay.activity_type eq 'reduced'}满多少减多少{/if}</td>
		      
		      	<td>{$quickpay.start_time}</td>
		      	<td>{$quickpay.end_time}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->