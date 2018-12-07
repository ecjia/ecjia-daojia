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

		{if $filter.type eq 'finished'}
		<a class="btn plus_or_reply" href="{RC_Uri::url('finance/admin_account/download')}&type=finished"><i class="fontello-icon-download"></i>导出Excel</a>
		{/if}

		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid batch">
	<ul class="nav nav-pills">
		<li class="{if !$filter.type}active{/if}">
			<a class="data-pjax" href='{RC_Uri::url("finance/admin_account/init")}
				{if $filter.payment}&payment={$filter.payment}{/if}
				{if $filter.start_date}&start_date={$filter.start_date}{/if}
				{if $filter.end_date}&end_date={$filter.end_date}{/if}
				{if $filter.keywords}&keywords={$filter.keywords}{/if}
				'>
				待审核<span class="badge badge-info">{if $type_count.wait}{$type_count.wait}{else}0{/if}</span>
			</a>
		</li>

		<li class="{if $filter.type eq 'finished'}active{/if}">
			<a class="data-pjax" href='{RC_Uri::url("finance/admin_account/init")}&type=finished
				{if $filter.payment}&payment={$filter.payment}{/if}
				{if $filter.start_date}&start_date={$filter.start_date}{/if}
				{if $filter.end_date}&end_date={$filter.end_date}{/if}
				{if $filter.keywords}&keywords={$filter.keywords}{/if}
				'>
				已完成<span class="badge badge-info">{if $type_count.finished}{$type_count.finished}{else}0{/if}</span>
			</a>
		</li>

		<li class="{if $filter.type eq 'canceled'}active{/if}">
			<a class="data-pjax" href='{RC_Uri::url("finance/admin_account/init")}&type=canceled
				{if $filter.payment}&payment={$filter.payment}{/if}
				{if $filter.start_date}&start_date={$filter.start_date}{/if}
				{if $filter.end_date}&end_date={$filter.end_date}{/if}
				{if $filter.keywords}&keywords={$filter.keywords}{/if}
				'>
				已取消<span class="badge badge-info">{if $type_count.canceled}{$type_count.canceled}{else}0{/if}</span>
			</a>
		</li>
	</ul>

	<form action="{$form_action}" name="searchForm" method="post">
		<div class="btn-group f_l m_t10">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='user::user_account.bulk_operations'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$batch_action}" data-msg="{lang key='user::user_account.application_confirm'}"
					 data-noSelectMsg="{lang key='user::user_account.select_operated_confirm'}" data-name="checkboxes" href="javascript:;"><i
						 class="fontello-icon-trash"></i>{lang key='user::user_account.batch_deletes'}</a></li>
			</ul>
		</div>

		<div class="choose_list f_r m_t10">
			<select class="w120" name="payment">
				<option value="">充值方式</option>
				<!-- {foreach from=$payment item=item} -->
				{if $item.pay_code neq 'pay_balance'}
				<option value="{$item.pay_code}" {if $smarty.get.payment eq $item.pay_code} selected {/if}>{$item.pay_name} </option>
				{/if}
				 <!-- {/foreach} -->
			</select>
			<span class="f_l">申请时间：</span>
			<input class="date f_l w150" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="{lang key='user::user_account.start_date'}">
			<span class="f_l">{lang key='user::user_account.to'}</span>
			<input class="date f_l w150" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="{lang key='user::user_account.end_date'}">
			<input type="text" name="keywords" value="{$list.filter.keywords}" placeholder="{lang key='user::user_account.user_keyword'}" />
			<button class="btn select-button" type="button">搜索</button>
		</div>

	</form>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped" id="smpl_tbl">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox" /></th>
					<th class="w130">{lang key='user::user_account.order_sn'}</th>
					<th class="w150">{lang key='user::user_account.user_id'}</th>
					<th class="w130">充值金额</th>
					<th class="w130">充值方式</th>
					<th class="w150">申请时间</th>
					<th class="w130">处理状态</th>
					<th class="w80">{lang key='system::system.handler'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list.list item=item}-->
				<tr>
					<td class="center-td">
						<!-- {if $item.is_paid neq 1} -->
						<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$item.id}" />
						<!-- {else} -->
						<input type="checkbox" value="{$item.id}" disabled="disabled" />
						<!-- {/if} -->
					</td>
					<td><a class="data-pjax" href='{url path="finance/admin_account/check" args="order_sn={$item.order_sn}&id={$item.id}{if $type}&type={$type}{/if}"}'>{$item.order_sn}</a></td>
					<td>{if $item.user_name}{$item.user_name}{else}{lang key='user::user_account.no_user'}{/if}</td>
					<td align="right">{$item.surplus_amount}</td>
					<td>{if $item.payment}{$item.payment}{else}银行转账{/if}</td>
					<td align="center">{$item.add_date}</td>
					<td align="center">{if $item.is_paid eq 1}{lang key='user::user_account.confirm'}{elseif $item.is_paid eq 0}{lang
						key='user::user_account.wait_check'}{else}{lang key='user::user_account.canceled'}{/if}</td>
					<td align="center">
						<a class="data-pjax no-underline" href='{url path="finance/admin_account/check" args="id={$item.id}{if $type}&type={$type}{/if}"}'
						 title="查看"><i class="fontello-icon-doc-text"></i></a>
						{if $item.is_paid neq 1}
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='user::user_account.delete_surplus_confirm'}"
						 href='{url path="finance/admin_account/remove" args="id={$item.id}{if $type}&type={$type}{/if}"}' title="{lang key='user::user_account.delete'}"><i
							 class="fontello-icon-trash"></i></a>
						{/if}
					</td>
				</tr>
				<!-- {foreachelse}-->
				<tr>
					<td class="no-records" colspan="9">{lang key='system::system.no_records'}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$list.page} -->
	</div>
</div>
<!-- {/block} -->