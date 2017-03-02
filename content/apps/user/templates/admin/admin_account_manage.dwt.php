<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_manage.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply" href="{$action_link.href}" ><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="choose_list span12">
		<form class="f_l" name="searchForm" action="{$form_action}" method="post">
			<input class="date f_l w230" name="start_date" type="text" value="{$start_date}" placeholder="{lang key='user::user_account_manage.start_date'}">
			<span class="f_l">{lang key='user::user_account_manage.to'}</span>
			<input class="date f_l w230" name="end_date" type="text" value="{$end_date}" placeholder="{lang key='user::user_account_manage.end_date'}">
			<button class="btn select-button" type="button">{lang key='user::user_account_manage.filter'}</button>
		</form>
	</div>
</div>

<!-- 会员账户信息 -->
<div class="row-fluid">
	<div class="span6  move-mod" >
		<div class="move-mod-group">
			<div class="heading clearfix move-mod-head">
				<h3 class="pull-left">{lang key='user::user_account_manage.user_account_info'}</h3>
			</div>

			<div class="manage_box">
				<div class="ov_group">
					<div class="p_bar_up p_canvas">2,4,9,7,12,8,16</div>
					<div class="ov_text">
						<strong>{$account.voucher_amount}</strong>
						<a href='{url path="user/admin_account/init" args="process_type=0&is_paid=1&start_date={$start_date}&end_date={$end_date}"}'>
							{lang key='user::user_account_manage.user_add_money'}
						</a>
					</div>
				</div>
				<div class="ov_group">
					<div class="p_bar_down p_canvas">20,15,18,14,10,13,9,7</div>
					<div class="ov_text">
						<strong>{$account.to_cash_amount}</strong> 
						<a href='{url path="user/admin_account/init" args="process_type=1&is_paid=1&start_date={$start_date}&end_date={$end_date}"}'>
							{lang key='user::user_account_manage.user_repay_money'}
						</a>
					</div>
				</div>
				<div class="ov_group">
					<div class="p_line_up p_canvas">3,5,9,7,12,8,16</div>
					<div class="ov_text">
						<strong>{$account.user_money}</strong> 
						<a href='{url path="user/admin/init"}'>
							{lang key='user::user_account_manage.user_money'}
						</a>
					</div>
				</div>
				<div class="ov_group">
					<div class="p_line_down p_canvas">20,16,14,18,15,14,14,13,12,10,10,8</div>
					<div class="ov_text">
						<strong class="red">{$account.frozen_money}</strong> 
						<a href='{url path="user/admin/init"}'>
							{lang key='user::user_account_manage.frozen_money'}
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- 积分余额信息 -->
	<div class="span6  move-mod" >
		<div class="move-mod-group">
			<div class="heading clearfix move-mod-head">
				<h3 class="pull-left">{lang key='user::user_account_manage.surplus_info'}</h3>
			</div>
			<div class="manage_box">
				<div class="ov_group">
					<div class="p_bar_up p_canvas">2,4,9,7,12,8,16</div>
					<div class="ov_text">
						<strong>{$account.surplus}</strong> 
						<a href='{url path="user/admin_account_manage/surplus" args="start_date={$start_date}&end_date={$end_date}"}'>
							{lang key='user::user_account_manage.order_surplus'}
						</a>
					</div>
				</div>
				<div class="ov_group">
					<div class="p_bar_down p_canvas">20,15,18,14,10,13,9,7</div>
					<div class="ov_text">
						<strong>{$account.integral_money}</strong> 
						<a href='{url path="user/admin_account_manage/surplus" args="start_date={$start_date}&end_date={$end_date}"}'>
							{lang key='user::user_account_manage.integral_money'}
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->