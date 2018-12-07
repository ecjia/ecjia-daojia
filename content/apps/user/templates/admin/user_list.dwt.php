<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_list.init();
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

<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
<!-- 		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='user::users.bulk_operations'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}" data-msg="{lang key='user::users.delete_confirm'}" data-noSelectMsg="{lang key='user::users.select_user'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='user::users.button_remove'}</a></li>
			</ul>
		</div> -->

		<select class="w120" name="rank" id="select-rank">
			<option value="0">{lang key='user::users.all_option'}</option>
			<!--{foreach from=$user_ranks item=item}-->
			<option value="{$item.rank_id}" {if $smarty.get.rank eq $item.rank_id} selected="selected" {/if}>{$item.rank_name}</option>
			<!-- {/foreach} -->
		</select>
		<a class="btn m_l5 screen-btn">{lang key='user::users.filter'}</a>
		<div class="top_right f_r" >
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入会员名称／邮箱／手机"/> 
			<button class="btn m_l5" type="submit">{lang key='user::users.serach'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit" style="table-layout:fixed;">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
					<th class="w100">会员名称</th>
					<th class="w150">{lang key='user::users.email'}</th>
					<th class="w100">手机号码</th>
					<th class="w100">{lang key='user::users.user_money'}</th>
					<th class="w50">积分</th>
					<th class="w50">所属等级</th>
					<th class="w100">{lang key='user::users.reg_date'}</th>
				</tr>
			</thead>
			<tbody>
				<!--{foreach from=$user_list.user_list item=user}-->
				<tr>
					<td>
						<input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$user.user_id}" />
					</td>
					<td class="hide-edit-area">
						{if $user.user_name}
							{$user.user_name}
						{/if}
						<div class="edit-list">
							<a class="data-pjax" href='{url path="user/admin/edit" args="id={$user.user_id}"}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="user/admin/info" args="id={$user.user_id}"}'>{lang key='user::users.details'}</a>&nbsp;|&nbsp; 
							<a class="data-pjax" href='{url path="user/admin/address_list" args="id={$user.user_id}"}' title="{lang key='user::users.address_list'}">{lang key='user::users.address_list'}</a>&nbsp;|&nbsp;
							<a target="_blank" href='{url path="orders/admin/init" args="user_id={$user.user_id}"}' title="{lang key='user::users.view_order'}">{lang key='user::users.view_order'}</a>&nbsp;|&nbsp;
							
							<a target="_blank" href='{url path="finance/admin_account_log/init" args="account_type=user_money&user_id={$user.user_id}"}' title="">查看余额变动</a>&nbsp;|&nbsp;
							<a target="_blank" href='{url path="finance/admin_account_log/init" args="account_type=pay_points&user_id={$user.user_id}"}' title="">查看积分变动</a>&nbsp;|&nbsp;
							<a target="_blank" href='{url path="finance/admin_account_log/init" args="account_type=rank_points&user_id={$user.user_id}"}' title="">查看成长值变动</a>

							<!-- <a target="_blank" href='{url path="finance/admin_account_log/init" args="user_id={$user.user_id}"}' title="{lang key='user::users.view_deposit'}">{lang key='user::users.view_deposit'}</a>&nbsp;|&nbsp; -->
							<!-- <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='user::users.delete_confirm'}" href='{url path="user/admin/remove" args="id={$user.user_id}"}' title="{lang key='user::users.delete'}">{lang key='user::users.delete'}</a> -->
						</div>
					</td>
					<td>
						<!-- {if $user.email} -->
						<span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-trigger="editable" data-url="{url path='user/admin/edit_email'}" data-name="email" data-pk="{$user.user_id}" data-title="{lang key='user::users.edit_email_address'}">{$user.email}</span>
						<span class="ecjiafc-f00">{if $user.is_validated}{lang key='user::users.validated'}{/if}</span>
						<!-- {/if} -->
					</td>
					<td>{$user.mobile_phone}</td>
					<td>{$user.user_money}</td>
					<td>{$user.pay_points}</td>
					<td>{$user.rank_name}</td>
					<td>{if $user.reg_time}{$user.reg_time}{else}{t}1970-01-01 00:00:00{/t}{/if}</td>
				</tr>
				<!--{foreachelse}-->
				<tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
				<!--{/foreach} -->
			</tbody>
		</table>
		<!-- {$user_list.page} -->
	</div>
</div>
<!-- {/block} -->