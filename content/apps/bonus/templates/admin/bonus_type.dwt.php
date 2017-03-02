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
		<a class="data-pjax" href='{url path="bonus/admin/init" args="{if $filter.send_type !== ''}&send_type={$filter.send_type}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.type_keywords}&type_keywords={$filter.type_keywords}{/if}"}'>{lang key='bonus::bonus.all'} 
			<span class="badge badge-info">{if $count.count}{$count.count}{else}0{/if}</span> 
		</a>
	</li>
	<li class="{if $filter.type eq 'self'}active{/if}">
		<a class="data-pjax" href='{url path="bonus/admin/init" args="type=self{if $filter.send_type !== ''}&send_type={$filter.send_type}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.type_keywords}&type_keywords={$filter.type_keywords}{/if}"}'>{lang key='bonus::bonus.self'}
			<span class="badge badge-info">{if $count.self}{$count.self}{else}0{/if}</span> 
		</a>
	</li>
</ul>

<div class="row-fluid">
	<form class="form-inline" action="{$search_action}{if $filter.type}&type={$filter.type}{/if}" method="post" name="searchForm">
		<div class="f_r">
			<!-- 关键字 -->
			<input class="m_l5" type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{lang key='bonus::bonus.enter_merchant_keywords'}" size="15" />
			<input class="m_l5" type="text" name="type_keywords" value="{$smarty.get.type_keywords}" placeholder="{lang key='bonus::bonus.enter_type_keywords'}" size="15" />
			<button class="btn" type="submit">{lang key='system::system.button_search'}</button>
		</div>
		
		<div class="screen f_l">
			<!-- 级别 -->
			<select name="send_type" class="no_search w150" id="select-bonustype">
				<option value=''  {if $filter.send_type eq '' } selected="true" {/if}>{lang key='bonus::bonus.all_send_type'}</option>
				<option value='0' {if $filter.send_type eq '0'} selected="true" {/if}>{lang key='bonus::bonus.send_by.0'}</option>
				<option value='1' {if $filter.send_type eq '1'} selected="true" {/if}>{lang key='bonus::bonus.send_by.1'}</option>
				<option value='2' {if $filter.send_type eq '2'} selected="true" {/if}>{lang key='bonus::bonus.send_by.2'}</option>
				<option value='3' {if $filter.send_type eq '3'} selected="true" {/if}>{lang key='bonus::bonus.send_by.3'}</option>
			</select>
			<button class="btn screen-btn m_l5 m_r5" type="button">{lang key='bonus::bonus.filter'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit">
			<thead>
				<tr>
				<th>{lang key='bonus::bonus.type_name'}</th>
				<th class="w180">{lang key='bonus::bonus.merchants_name'}</th>
				<th class="w150">{lang key='bonus::bonus.send_type'}</th>
				<th class="w100">{lang key='bonus::bonus.type_money'}</th>
				<th class="w100">{lang key='bonus::bonus.min_amount'}</th>
				<th class="w100">{lang key='bonus::bonus.send_count'}</th>
				<th class="w80">{lang key='bonus::bonus.use_count'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$type_list.item item=type} -->
				<tr>
					<td class="hide-edit-area hide_edit_area_bottom" >
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/admin/edit_type_name')}" data-name="type_name" data-pk="{$type.type_id}" data-title="{lang key='bonus::bonus.edit_bonus_type_name'}">{$type.type_name}</span>
						<br/>
						<div class="edit-list">
							<a class="data-pjax" href='{RC_Uri::url("bonus/admin/bonus_list", "bonus_type={$type.type_id}")}' title="{lang key='bonus::bonus.view_bonus'}">{lang key='bonus::bonus.view_bonus'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{RC_Uri::url("bonus/admin/edit", "type_id={$type.type_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a> &nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='bonus::bonus.remove_bonustype_confirm'}" href='{RC_Uri::url("bonus/admin/remove", "id={$type.type_id}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a>
							{if $type.send_type neq 2 && $type.send_type neq 4}
							&nbsp;|&nbsp;<a class="data-pjax" href='{RC_Uri::url("bonus/admin/send", "id={$type.type_id}&send_by={$type.send_type}")}' title="{lang key='bonus::bonus.send_bonus'}">{lang key='bonus::bonus.send_bonus'}</a>        
							{/if}
							{if $type.send_type eq 3}
							&nbsp;|&nbsp;<a href='{RC_Uri::url("bonus/admin/gen_excel", "tid={$type.type_id}")}' title="{lang key='bonus::bonus.gen_excel'}">{lang key='bonus::bonus.gen_excel'}</a> 
							{/if}
						</div>
					</td> 
					<td>
						<!-- {if $type.user_bonus_type eq 2} -->
						<font style="color:#0e92d0;">{lang key='bonus::bonus.general_audience'}</font>
						<!-- {else}-->
						<font style="color:#F00;">{$type.user_bonus_type}</font>
						<!-- {/if} -->
					</td>
					<td>{$type.send_by}</td>
					<td>
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/admin/edit_type_money')}" data-name="type_money" data-pk="{$type.type_id}" data-title="{lang key='bonus::bonus.edit_bonus_money'}">{$type.type_money}</span>
					</td>
					<td>
						<!-- {if $type.send_type eq 2} -->
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('bonus/admin/edit_min_amount')}" data-name="min_amount" data-pk="{$type.type_id}" title="{lang key='bonus::bonus.edit_order_limit'}">{$type.min_amount}</span>
						<!-- {else} -->
						0.00
						<!-- {/if} -->
					</td>
					<td>{$type.send_count}</td>
					<td>{$type.use_count}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$type_list.page} -->
	</div>
</div>
<!-- {/block} -->