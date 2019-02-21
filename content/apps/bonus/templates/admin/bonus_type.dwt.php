<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.bonus_type.list();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a  class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<ul class="nav nav-pills">
	<li class="{if $filter.type eq ''}active{/if}">
		<a class="data-pjax" href='{url path="bonus/admin/init" args="{if $filter.send_type !== ''}&send_type={$filter.send_type}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.type_keywords}&type_keywords={$filter.type_keywords}{/if}"}'>{t domain="bonus"}全场通用{/t}
			<span class="badge badge-info">{if $count.platform}{$count.platform}{else}0{/if}</span> 
		</a>
	</li>
	<li class="{if $filter.type eq 'self'}active{/if}">
		<a class="data-pjax" href='{url path="bonus/admin/init" args="type=self{if $filter.send_type !== ''}&send_type={$filter.send_type}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.type_keywords}&type_keywords={$filter.type_keywords}{/if}"}'>{t domain="bonus"}自营{/t}
			<span class="badge badge-info">{if $count.self}{$count.self}{else}0{/if}</span> 
		</a>
	</li>
	<li class="{if $filter.type eq 'merchant'}active{/if}">
		<a class="data-pjax" href='{url path="bonus/admin/init" args="type=merchant{if $filter.send_type !== ''}&send_type={$filter.send_type}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.type_keywords}&type_keywords={$filter.type_keywords}{/if}"}'>{t domain="bonus"}商家{/t}
			<span class="badge badge-info">{if $count.merchant}{$count.merchant}{else}0{/if}</span> 
		</a>
	</li>
</ul>

<div class="row-fluid">
	<form class="form-inline" action="{$search_action}{if $filter.type}&type={$filter.type}{/if}" method="post" name="searchForm">
		<div class="f_r">
			<!-- 关键字 -->
			<input class="m_l5" type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder='{t domain="bonus"}请输入商家名称关键字{/t}' size="15" />
			<input class="m_l5" type="text" name="type_keywords" value="{$smarty.get.type_keywords}" placeholder='{t domain="bonus"}请输入类型名称关键字{/t}' size="15" />
			<button class="btn" type="submit">{t domain="bonus"}搜索{/t}</button>
		</div>
		
		<div class="screen f_l">
			<!-- 级别 -->
			<select name="send_type" class="no_search w150" id="select-bonustype">
				<option value=''  {if $filter.send_type eq '' } selected="true" {/if}>{t domain="bonus"}所有发放类型{/t}</option>
				<option value='0' {if $filter.send_type eq '0'} selected="true" {/if}>{t domain="bonus"}按用户发放{/t}</option>
				<option value='1' {if $filter.send_type eq '1'} selected="true" {/if}>{t domain="bonus"}按商品发放{/t}</option>
				<option value='2' {if $filter.send_type eq '2'} selected="true" {/if}>{t domain="bonus"}按订单金额发放{/t}</option>
				<option value='3' {if $filter.send_type eq '3'} selected="true" {/if}>{t domain="bonus"}线下发放的红包{/t}</option>
			</select>
			<button class="btn screen-btn m_l5 m_r5" type="button">{t domain="bonus"}筛选{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit">
			<thead>
				<tr>
				<th>{t domain="bonus"}类型名称{/t}</th>
				<th class="w180">{t domain="bonus"}商家名称{/t}</th>
				<th class="w150">{t domain="bonus"}发放类型{/t}</th>
				<th class="w100">{t domain="bonus"}红包金额{/t}</th>
				<th class="w100">{t domain="bonus"}订单下限{/t}</th>
				<th class="w100">{t domain="bonus"}发放数量{/t}</th>
				<th class="w80">{t domain="bonus"}使用数量{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$type_list.item item=type} -->
				<tr>
					<td class="hide-edit-area hide_edit_area_bottom" >
						{if $filter.type eq ''}
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/admin/edit_type_name')}" data-name="type_name" data-pk="{$type.type_id}" data-title='{t domain="bonus"}编辑红包类型名称{/t}'>{$type.type_name}</span>
						{else}{$type.type_name}{/if}
						<br/>
						<div class="edit-list">
						{if $filter.type eq 'self' || $filter.type eq 'merchant'}
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="bonus"}您确定要删除该红包类型吗？{/t}' href='{RC_Uri::url("bonus/admin/remove", "id={$type.type_id}")}' title='{t domain="bonus"}移除{/t}'>{t domain="bonus"}删除{/t}</a>
						{else}
							<a class="data-pjax" href='{RC_Uri::url("bonus/admin/bonus_list", "bonus_type={$type.type_id}")}' title='{t domain="bonus"}查看红包{/t}'>{t domain="bonus"}查看红包{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{RC_Uri::url("bonus/admin/edit", "type_id={$type.type_id}")}' title='{t domain="bonus"}编辑{/t}'>{t domain="bonus"}编辑{/t}</a> &nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="bonus"}您确定要删除该红包类型吗？{/t}' href='{RC_Uri::url("bonus/admin/remove", "id={$type.type_id}")}' title='{t domain="bonus"}移除{/t}'>{t domain="bonus"}删除{/t}</a>
							{if $type.send_type neq 2 && $type.send_type neq 4}
							&nbsp;|&nbsp;<a class="data-pjax" href='{RC_Uri::url("bonus/admin/send", "id={$type.type_id}&send_by={$type.send_type}")}' title='{t domain="bonus"}发放红包{/t}'>{t domain="bonus"}发放红包{/t}</a>
							{/if}
							{if $type.send_type eq 3}
							&nbsp;|&nbsp;<a href='{RC_Uri::url("bonus/admin/gen_excel", "tid={$type.type_id}")}' title='{t domain="bonus"}导出报表{/t}'>{t domain="bonus"}导出报表{/t}</a>
							{/if}
						{/if}
						</div>
					</td> 
					<td>
						<!-- {if $type.user_bonus_type eq 2} -->
						<font style="color:#0e92d0;">{t domain="bonus"}全场通用{/t}</font>
						<!-- {else}-->
						<font style="color:#F00;">{$type.user_bonus_type}</font>
						<!-- {/if} -->
					</td>
					<td>{$type.send_by}</td>
					<td>
						{if $filter.type eq ''}
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/admin/edit_type_money')}" data-name="type_money" data-pk="{$type.type_id}" data-title='{t domain="bonus"}编辑红包金额{/t}'>{$type.type_money}</span>
						{else}
						{$type.type_money}
						{/if}
					</td>
					<td>
						<!-- {if $type.send_type eq 2} -->
						{if $filter.type eq ''}
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/admin/edit_min_amount')}" data-name="min_amount" data-pk="{$type.type_id}" title='{t domain="bonus"}编辑订单下限金额{/t}'>{$type.min_amount}</span>
						{else}
						{$type.min_amount}
						{/if}
						<!-- {else} -->
						0.00
						<!-- {/if} -->
					</td>
					<td>{$type.send_count}</td>
					<td>{$type.use_count}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="10">{t domain="bonus"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$type_list.page} -->
	</div>
</div>
<!-- {/block} -->