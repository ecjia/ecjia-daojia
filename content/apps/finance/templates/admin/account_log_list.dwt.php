<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.account_log.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<h3 class="heading">
	<strong>{$ur_here}</strong>
	<small>（{t domain="finance"}当前会员：{/t}{$user.user_name}）</small>
	<a href="{$back_link.href}" class="btn plus_or_reply"><i class="fontello-icon-reply"></i>{$back_link.text}</a>

	<!--{if $link2}-->
	<a href="{$link2.href}" class="btn plus_or_reply {if $link2.pjax}data-pjax{/if}" {if !$link2.pjax}target="_blank" {/if}> <i class="{$link2.i}"></i>{$link2.text}</a>
	<!--{/if}-->

	<!--{if $link1}-->
	<a href="{$link1.href}" class="btn plus_or_reply {if $link1.pjax}data-pjax{/if}" {if !$link1.pjax}target="_blank" {/if}> <i class="{$link1.i}"></i>{$link1.text}</a>
	<!--{/if}-->

	<!--{if $link4}-->
	<a href="{$link4.href}" class="btn plus_or_reply {if $link4.pjax}data-pjax{/if}" {if !$link4.pjax}target="_blank" {/if}> <i class="{$link4.i}"></i>{$link4.text}</a>
	<!--{/if}-->

	<!--{if $link3}-->
	<a href="{$link3.href}" class="btn plus_or_reply {if $link3.pjax}data-pjax{/if}" {if !$link3.pjax}target="_blank" {/if}> <i class="{$link3.i}"></i>{$link3.text}</a>
	<!--{/if}-->

</h3>

<div class="row-fluid">
	<div class="span12">
		<div class="account_info">
			<div class="item">
				{if $account_type eq 'user_money'}
				<span>{t domain="finance"}当前账户可用余额：{/t}<span class="ecjiafc-red">{$user.formated_user_money}</span></span>
				<span class="m_l30">{t domain="finance"}冻结资金：{/t}<span class="ecjiafc-red">{$user.formated_frozen_money}</span></span>

				{else if $account_type eq 'pay_points'}
				<span>{t domain="finance"}当前账户积分：{/t}<span class="ecjiafc-red">{$user.pay_points}</span></span>

				{else if $account_type eq 'rank_points'}
				<span>{t domain="finance"}当前账户成长值：{/t}<span class="ecjiafc-red">{$user.rank_points}</span></span>
				<span class="m_l30">{t domain="finance"}所属会员等级：{/t}</span><span class="ecjiafc-red">{if $user.user_rank_name}{$user.user_rank_name}{else}{t domain="finance"}暂无{/t}{/if}</span></span>
				{/if}
			</div>
			<div class="item">
				<div class="choose_list m_t10">
					<form action="{$form_action}" method="post" name="searchForm">
						<span class="f_l">{t domain="finance"}选择日期：{/t}</span>
						<input class="date f_l w150" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder='{t domain="finance"}请选择开始时间{/t}'> <span class="f_l">{t domain="finance"}至{/t}</span>
						<input class="date f_l w150" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder='{t domain="finance"}请选择结束时间{/t}'> <button class="btn select-button" type="button">{t domain="finance"}查询{/t}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div>
	<h3 class="heading">
		{$second_heading}
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped" id="smpl_tbl">
			<thead>
				<tr>
					<th class="w150">{t domain="finance"}变动时间{/t}</th>
					<th>{t domain="finance"}变动原因{/t}</th>

					{if $account_type eq 'user_money'}
					<th class="w150">{t domain="finance"}资金变动{/t}</th>
					<th class="w150">{t domain="finance"}冻结资金{/t}</th>
					{else if $account_type eq 'pay_points'}
					<th class="w150">{t domain="finance"}积分变动{/t}</th>
					{else if $account_type eq 'rank_points'}
					<th class="w150">{t domain="finance"}成长值变动{/t}</th>
					{/if}

					<th class="w150">{t domain="finance"}关联订单{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$account_list.account item=account}-->
				<tr>
					<td>{$account.change_time}</td>
					<td>{$account.change_desc|escape:html}</td>

					<td>
						{if $account_type eq 'user_money'}
						<!-- {if $account.user_money gt 0} -->
						<span class="ecjiafc-0000FF">+{$account.user_money}</span>
						<!-- {elseif $account.user_money lt 0} -->
						<span class="ecjiafc-red">{$account.user_money}</span>
						<!-- {else} -->
						{$account.user_money}
						<!-- {/if} -->
						{else if $account_type eq 'pay_points'}
						<!-- {if $account.pay_points gt 0} -->
						<span class="ecjiafc-0000FF">+{$account.pay_points}</span>
						<!-- {elseif $account.pay_points lt 0} -->
						<span class="ecjiafc-red">{$account.pay_points}</span>
						<!-- {else} -->
						{$account.pay_points}
						<!-- {/if} -->
						{else if $account_type eq 'rank_points'}
						<!-- {if $account.rank_points gt 0} -->
						<span class="ecjiafc-0000FF">+{$account.rank_points}</span>
						<!-- {elseif $account.rank_points lt 0} -->
						<span class="ecjiafc-red">{$account.rank_points}</span>
						<!-- {else} -->
						{$account.rank_points}
						<!-- {/if} -->
						{/if}
					</td>

					{if $account_type eq 'user_money'}
					<td>
						<!-- {if $account.frozen_money gt 0} -->
						<span class="ecjiafc-0000FF">+{$account.frozen_money}</span>
						<!-- {elseif $account.frozen_money lt 0} -->
						<span class="ecjiafc-red">{$account.frozen_money}</span>
						<!-- {else} -->
						{$account.frozen_money}
						<!-- {/if} -->
					</td>
					{/if}

					<td><a href="{RC_Uri::url('orders/admin/info')}&order_sn={$account.from_value}" target="_blank">{$account.from_value}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="5">{t domain="finance"}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$account_list.page} -->
	</div>
</div>
<!-- {/block} -->