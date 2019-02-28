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
		<select class="w120" name="rank" id="select-rank">
			<option value="0">{t domain="user"}所有等级{/t}</option>
			<!--{foreach from=$user_ranks item=item}-->
			<option value="{$item.rank_id}" {if $smarty.get.rank eq $item.rank_id} selected="selected" {/if}>{$item.rank_name}</option>
			<!-- {/foreach} -->
		</select>
		<a class="btn m_l5 screen-btn">{t domain="user"}筛选{/t}</a>
		<div class="top_right f_r" >
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="user"}请输入会员名称／邮箱／手机{/t}' />
			<button class="btn m_l5" type="submit">{t domain="user"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit" style="table-layout:fixed;">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
					<th class="w100">{t domain="user"}会员名称{/t}</th>
					<th class="w150">{t domain="user"}邮件地址{/t}</th>
					<th class="w100">{t domain="user"}手机号码{/t}</th>
					<th class="w100">{t domain="user"}可用资金{/t}</th>
					<th class="w50">{t domain="user"}积分{/t}</th>
					<th class="w50">{t domain="user"}所属等级{/t}</th>
					<th class="w100">{t domain="user"}注册日期{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!--{foreach from=$user_list.user_list item=user}-->
				<tr>
					<td>
						<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$user.user_id}" />
					</td>
					<td class="hide-edit-area">
						{if $user.user_name}
							{$user.user_name}
						{/if}
						<div class="edit-list">
							<a class="data-pjax" href='{url path="user/admin/edit" args="id={$user.user_id}"}' title='{t domain="user"}编辑{/t}'>{t domain="user"}编辑{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="user/admin/info" args="id={$user.user_id}"}'>{t domain="user"}详细信息{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="user/admin/address_list" args="id={$user.user_id}"}' title='{t domain="user"}收货地址{/t}'>{t domain="user"}收货地址{/t}</a>&nbsp;|&nbsp;
							<a target="_blank" href='{url path="orders/admin/init" args="user_id={$user.user_id}"}' title='{t domain="user"}查看订单{/t}'>{t domain="user"}查看订单{/t}</a>&nbsp;|&nbsp;
							
							<a target="_blank" href='{url path="finance/admin_account_log/init" args="account_type=user_money&user_id={$user.user_id}"}'>{t domain="user"}查看余额变动{/t}</a>&nbsp;|&nbsp;
							<a target="_blank" href='{url path="finance/admin_account_log/init" args="account_type=pay_points&user_id={$user.user_id}"}'>{t domain="user"}查看积分变动{/t}</a>&nbsp;|&nbsp;
							<a target="_blank" href='{url path="finance/admin_account_log/init" args="account_type=rank_points&user_id={$user.user_id}"}'>{t domain="user"}查看成长值变动{/t}</a>
						</div>
					</td>
					<td>
						<!-- {if $user.email} -->
						<span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-trigger="editable" data-url="{url path='user/admin/edit_email'}" data-name="email" data-pk="{$user.user_id}" data-title='{t domain="user"}编辑邮箱地址{/t}'>{$user.email}</span>
						<span class="ecjiafc-f00">{if $user.is_validated}{t domain="user"}（已验证）{/t}{/if}</span>
						<!-- {/if} -->
					</td>
					<td>{$user.mobile_phone}</td>
					<td>{$user.user_money}</td>
					<td>{$user.pay_points}</td>
					<td>{$user.rank_name}</td>
					<td>{if $user.reg_time}{$user.reg_time}{else}1970-01-01 00:00:00{/if}</td>
				</tr>
				<!--{foreachelse}-->
				<tr><td class="no-records" colspan="8">{t domain="user"}没有找到任何记录{/t}</td></tr>
				<!--{/foreach} -->
			</tbody>
		</table>
		<!-- {$user_list.page} -->
	</div>
</div>
<!-- {/block} -->