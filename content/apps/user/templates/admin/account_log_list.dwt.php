<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_log.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<h3 class="heading">
	<strong>{lang key='user::account_log.account_desc'}</strong>
	<small>（{lang key='user::account_log.label_user_name'}{$user.user_name}）</small>
	<!-- {if $action_link} -->
	<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-dollar"></i>{$action_link.text}</a>
	<!-- {/if} -->	
</h3>

<div class="row-fluid">
	<div class="span3  move-mod" >
		<div class="move-mod-group">
			<div class="manage_box">
				<div class="ov_group">
					<div class="p_line_up p_canvas">3,5,9,7,12,8,16</div>
					<div class="ov_text">
						{lang key='user::account_log.label_user_money'}<br/>
						<span class="ecjiafc-0000FF">{$user.formated_user_money}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="span3  move-mod" >
		<div class="move-mod-group">
			<div class="manage_box">
				<div class="ov_group">
					<div class="p_line_down p_canvas">20,16,14,18,15,14,14,13,12,10,10,8</div>
					<div class="ov_text">
						{lang key='user::account_log.label_frozen_money'}<br/>
						<span class="ecjiafc-FF0000">{$user.formated_frozen_money}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="span3  move-mod" >
		<div class="move-mod-group">
			<div class="manage_box">
				<div class="ov_group">
					<div class="p_bar_up p_canvas">2,4,9,7,12,8,16</div>
					<div class="ov_text">
						{lang key='user::account_log.label_rank_points'}<br/>
						{$user.rank_points}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="span3  move-mod" >
		<div class="move-mod-group">
			<div class="manage_box">
				<div class="ov_group">
					<div class="p_bar_down p_canvas">20,15,18,14,10,13,9,7</div>
					<div class="ov_text">
						{lang key='user::account_log.label_pay_points'}<br/>
						{$user.pay_points}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="m_t20">
	<h3 class="heading">
		<!-- {if $ur_here}<strong>{$ur_here}</strong>{/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="choose_list span12">
		<form method="post" action="{$form_action}" name="searchForm">
			<select class="w120" name="account_type" id="account_type">
				<option value="" {if $account_type eq ''}selected="selected"{/if}>{lang key='user::account_log.all_account'}</option>
				<option value="user_money" {if $account_type eq 'user_money'}selected="selected"{/if}>{lang key='user::account_log.user_money'}</option>
				<option value="frozen_money" {if $account_type eq 'frozen_money'}selected="selected"{/if}>{lang key='user::account_log.frozen_money'}</option>
				<option value="rank_points" {if $account_type eq 'rank_points'}selected="selected"{/if}>{lang key='user::account_log.rank_points'}</option>
				<option value="pay_points" {if $account_type eq 'pay_points'}selected="selected"{/if}>{lang key='user::account_log.pay_points'}</option>
			</select>
			<button class="data-pjax btn select-button" type="button">{lang key='user::account_log.filter'}</button>
		</form>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped" id="smpl_tbl">
			<thead>
				<tr>
					<th class="w150">{lang key='user::account_log.change_time'}</th>
					<th>{lang key='user::account_log.list_change_desc'}</th>
					<th class="w100">{lang key='user::account_log.user_money'}</th>
					<th class="w100">{lang key='user::account_log.frozen_money'}</th>
					<th class="w100">{lang key='user::account_log.rank_points'}</th>
					<th class="w130">{lang key='user::account_log.pay_points'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$account_list.account item=account}-->
				<tr>
					<td>{$account.change_time}</td>
					<td>{$account.change_desc|escape:html}</td>
					<td align="right">
						<!-- {if $account.user_money gt 0} -->
						<span class="ecjiafc-0000FF">+{$account.user_money}</span>
						<!-- {elseif $account.user_money lt 0} -->
						<span class="ecjiafc-FF0000">{$account.user_money}</span>
						<!-- {else} -->
						{$account.user_money}
						<!-- {/if} -->
					</td>
					<td align="right">
						<!-- {if $account.frozen_money gt 0} -->
						<span class="ecjiafc-0000FF">+{$account.frozen_money}</span>
						<!-- {elseif $account.frozen_money lt 0} -->
						<span class="ecjiafc-FF0000">{$account.frozen_money}</span>
						<!-- {else} -->
						{$account.frozen_money}
						<!-- {/if} -->
					</td>
					<td align="right">
						<!-- {if $account.rank_points gt 0} -->
						<span class="ecjiafc-0000FF">+{$account.rank_points}</span>
						<!-- {elseif $account.rank_points lt 0} -->
						<span class="ecjiafc-FF0000">{$account.rank_points}</span>
						<!-- {else} -->
						{$account.rank_points}
						<!-- {/if} -->
					</td>
					<td align="right">
						<!-- {if $account.pay_points gt 0} -->
						<span class="ecjiafc-0000FF">+{$account.pay_points}</span>
						<!-- {elseif $account.pay_points lt 0} -->
						<span class="ecjiafc-FF0000">{$account.pay_points}</span>
						<!-- {else} -->
						{$account.pay_points}
						<!-- {/if} -->
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$account_list.page} -->
	</div>
</div>
<!-- {/block} -->