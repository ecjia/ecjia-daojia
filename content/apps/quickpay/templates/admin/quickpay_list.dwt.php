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
		<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin/init" args="{if $filter.merchant_name}&merchant_name={$filter.merchant_name}{/if}{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>{t domain="quickpay"}全部 {/t} <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'on_going'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin/init" args="type=on_going{if $filter.merchant_name}&merchant_name={$filter.merchant_name}{/if}{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>{t domain="quickpay"}正在进行中{/t} <span class="badge badge-info">{if $type_count.on_sale}{$type_count.on_sale}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'self'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin/init" args="type=self{if $filter.merchant_name}&merchant_name={$filter.merchant_name}{/if}{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>{t domain="quickpay"}自营{/t} <span class="badge badge-info">{if $type_count.self}{$type_count.self}{else}0{/if}</span> </a></li>
	</ul>
	
	<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="quickpay"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='quickpay/admin/batch'}" data-msg='{t domain="quickpay"}您确实要删除选中的买单规则吗？{/t}' data-noSelectMsg='{t domain="quickpay"}请先选中要删除的买单规则！{/t}' data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="quickpay"}删除买单规则{/t}</a></li>
			</ul>
		</div>
		<div class="choose_list f_r">
			<input type="text" name="merchant_name" value="{$smarty.get.merchant_name}" placeholder='{t domain="quickpay"}请输入商家名称{/t}'/>
			<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder='{t domain="quickpay"}请输入买单规则名称{/t}'/> 
			<button class="btn search_quickpay" type="button">{t domain="quickpay"}搜索{/t}</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
				    <th class="w150">{t domain="quickpay"}买单标题{/t}</th>
				    <th class="w150">{t domain="quickpay"}商家名称{/t}</th>
				    <th class="w150">{t domain="quickpay"}买单优惠类型{/t}</th>
				    <th class="w100">{t domain="quickpay"}开始时间{/t}</th>
				    <th class="w100">{t domain="quickpay"}结束时间{/t}</th>
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
						  	<a class="data-pjax" href='{url path="quickpay/admin/edit" args="id={$quickpay.id}&store_id={$quickpay.store_id}"}' >{t domain="quickpay"}编辑{/t}</a>&nbsp;|&nbsp;
				          	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="quickpay"}你确定要删除该买单规则吗？{/t}' href='{url path="quickpay/admin/remove" args="id={$quickpay.id}"}' >{t domain="quickpay"}删除{/t}</a>
				        {else}
				        	<a target="_blank" href='{url path="quickpay/admin/detail" args="id={$quickpay.id}"}'>{t domain="quickpay"}查看详情{/t}</a>
				        {/if}	
		    	  	</div>
		      	</td>
		      	<td class="ecjiafc-red">{$quickpay.merchants_name}</td>
		      	<td>
			      	{if $quickpay.activity_type eq 'discount'}
			      	{t domain="quickpay"}价格折扣{/t}
			      	{elseif $quickpay.activity_type eq 'everyreduced'}
			      	{t domain="quickpay"}每满多少减多少，最高减多少{/t}
			      	{elseif $quickpay.activity_type eq 'reduced'}
			      	{t domain="quickpay"}满多少减多少{/t}
			      	{/if}
		      	</td>
		      	<td>{$quickpay.start_time}</td>
		      	<td>{$quickpay.end_time}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="6">{t domain="quickpay"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->