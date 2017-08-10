<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_surplus.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<form name="searchForm" action="{$form_action}" method="post">
		<div class="choose_list span12">
			<input class="date f_l w230" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="{lang key='user::user_account_manage.start_date'}">
			<span class="f_l">{lang key='user::user_account_manage.to'}</span>
			<input class="date f_l w230" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="{lang key='user::user_account_manage.end_date'}">
			<button class="btn select-button" type="button">{lang key='user::user_account_manage.filter'}</button>
		</div>
		<div class="top_right f_r m_t_30">
			<input type="text" name="keywords" placeholder="{lang key='user::user_account_manage.username_confirm'}" value="{$order_list.filter.keywords}"/>
			<button class="btn m_l5" type="submit">{lang key='system::system.button_search'}</button>
		</div>
	</form>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl">
			<thead>
				<tr>
					<th>{lang key='user::user_account_manage.username'}</th>
					<th class="w150">{lang key='user::user_account_manage.order_sn'}</th>
					<th class="w130">{lang key='user::user_account_manage.surplus'}</th>
					<th class="w130">{lang key='user::user_account_manage.integral_money'}</th>
					<th class="w150">{lang key='user::user_account_manage.add_time'}</th>
					<th class="w70">{lang key='system::system.handler'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$order_list.order_list item=order} -->
				<tr align="center">
					<td class="first-cell">{if $order.user_name}{$order.user_name}{else}{t}{lang key='user::user_account_manage.anonymous_member'}{/t}{/if}</td>
					<td>{$order.order_sn}</td>
					<td>{$order.surplus}</td>
					<td>{$order.integral_money}</td>
					<td align="center">{$order.add_time}</td>
					<td align="center">
						<a target="_blank" href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' title="{lang key='user::user_account_manage.view_order'}" >{lang key='user::user_account_manage.view'}</a>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$order_list.page} -->
	</div>
</div>
<!-- {/block} -->