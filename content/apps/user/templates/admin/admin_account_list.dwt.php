<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid batch">
	<form action="{$form_action}" name="searchForm" method="post">
		<div class="wspan12">
			<div class="top_right f_r">
				<input type="text" name="keywords" value="{$list.filter.keywords}" placeholder="{lang key='user::user_account.user_name_keyword'}"/>
				<button class="btn m_l5" type="submit">{lang key='system::system.button_search'}</button>
			</div>
		</div>
		
		<div class="btn-group f_l m_t10">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='user::user_account.bulk_operations'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$batch_action}" data-msg="{lang key='user::user_account.application_confirm'}" data-noSelectMsg="{lang key='user::user_account.select_operated_confirm'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='user::user_account.batch_deletes'}</a></li>
			</ul>
		</div>
		
		<div class="choose_list f_r m_t10">
			<select class="w80" name="process_type">
			<option value="-1" >{lang key='user::user_account.process_type'}</option>
			<option value="0" {if $list.filter.process_type eq 0} selected="selected" {/if}>{lang key='user::user_account.surplus_type.0'}</option>
			<option value="1" {if $smarty.get.process_type eq 1} selected="selected" {/if} >{lang key='user::user_account.surplus_type.1'}</option>
			</select>
			<select class="w120" name="payment">
				<option value="">{lang key='user::user_account.pay_mothed'}</option>
				<!-- {foreach from=$payment item=item} -->
				<option value="{$item.pay_name}" {if $list.filter.payment eq $item.pay_name} selected="selected" {/if}>{$item.pay_name}</option> 
				<!-- {/foreach} -->
			</select>
			<select class="w80" name="is_paid">
				<option value="-1">{lang key='user::user_account.status'}</option>
				<option value="0" {if $list.filter.is_paid eq 0} selected="selected" {/if}>{lang key='user::user_account.unconfirm'}</option>
				<option value="1" {if $smarty.get.is_paid eq 1} selected="selected" {/if}>{lang key='user::user_account.confirm'}</option>
				<option value="2" {if $smarty.get.is_paid eq 2} selected="selected" {/if}>{lang key='user::user_account.cancel'}</option>
			</select>
			<input class="date f_l w150" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="{lang key='user::user_account.start_date'}">
			<span class="f_l">{lang key='user::user_account.to'}</span>
			<input class="date f_l w150" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="{lang key='user::user_account.end_date'}">
			
			<button class="btn select-button" type="button">{lang key='user::user_account.filter'}</button>
		</div>
		
	</form>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped" id="smpl_tbl">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
					<th>{lang key='user::user_account.user_id'}</th>
					<th>{lang key='user::user_account.surplus_amount'}</th>
					<th class="w110">{lang key='user::user_account.pay_mothed'}</th>
					<th class="w50">{lang key='user::user_account.process_type'}</th>
					<th class="w80">{lang key='user::user_account.status'}</th>
					<th class="w130">{lang key='user::user_account.add_date'}</th>
					<th class="w80">{lang key='system::system.handler'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list.list item=item}-->
				<tr>
					<td class="center-td">
						<!-- {if $item.is_paid neq 1} -->
						<input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$item.id}" />
						<!-- {else} -->
						<input type="checkbox" value="{$item.id}" disabled="disabled" />
						<!-- {/if} -->
					</td>
					<td>{if $item.user_name}{$item.user_name}{else}{lang key='user::user_account.no_user'}{/if}</td>
					<td align="right">{$item.surplus_amount}</td>
					<td>{if $item.payment}{$item.payment}{/if}</td>
					<td align="center">{$item.process_type_name}</td>
					<td align="center">{if $item.is_paid eq 1}{lang key='user::user_account.confirm'}{elseif $item.is_paid eq 0}{lang key='user::user_account.unconfirm'}{else}{lang key='user::user_account.cancel'}{/if}</td>
					<td align="center">{$item.add_date}</td>
					<td align="center">
						<!-- {if $item.is_paid eq 1} -->
						<a class="data-pjax no-underline" href='{url path="user/admin_account/edit" args="id={$item.id}"}' title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
						<!-- {else} -->
						<a class="data-pjax no-underline" href='{url path="user/admin_account/check" args="id={$item.id}"}' title="{lang key='user::user_account.check'}" ><i class="fontello-icon-doc-text"></i></a>
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='user::user_account.delete_surplus_confirm'}" href='{url path="user/admin_account/remove" args="id={$item.id}"}' title="{lang key='user::user_account.delete'}"><i class="fontello-icon-trash"></i></a>
						<!-- {/if} -->
					</td>
				</tr>
				<!-- {foreachelse}-->
				<tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$list.page} -->
	</div>
</div>

<!-- {/block} -->