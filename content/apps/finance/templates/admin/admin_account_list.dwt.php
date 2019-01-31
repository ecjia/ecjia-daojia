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
		<a class="btn plus_or_reply" href="{RC_Uri::url('finance/admin_account/download')}&type=finished"><i class="fontello-icon-download"></i>{t domain="finance"}导出Excel{/t}</a>
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
                {t domain="finance"}待审核{/t}<span class="badge badge-info">{if $type_count.wait}{$type_count.wait}{else}0{/if}</span>
			</a>
		</li>

		<li class="{if $filter.type eq 'finished'}active{/if}">
			<a class="data-pjax" href='{RC_Uri::url("finance/admin_account/init")}&type=finished
				{if $filter.payment}&payment={$filter.payment}{/if}
				{if $filter.start_date}&start_date={$filter.start_date}{/if}
				{if $filter.end_date}&end_date={$filter.end_date}{/if}
				{if $filter.keywords}&keywords={$filter.keywords}{/if}
				'>
                {t domain="finance"}已完成{/t}<span class="badge badge-info">{if $type_count.finished}{$type_count.finished}{else}0{/if}</span>
			</a>
		</li>

		<li class="{if $filter.type eq 'canceled'}active{/if}">
			<a class="data-pjax" href='{RC_Uri::url("finance/admin_account/init")}&type=canceled
				{if $filter.payment}&payment={$filter.payment}{/if}
				{if $filter.start_date}&start_date={$filter.start_date}{/if}
				{if $filter.end_date}&end_date={$filter.end_date}{/if}
				{if $filter.keywords}&keywords={$filter.keywords}{/if}
				'>
                {t domain="finance"}已取消{/t}<span class="badge badge-info">{if $type_count.canceled}{$type_count.canceled}{else}0{/if}</span>
			</a>
		</li>
	</ul>

	<form action="{$form_action}" name="searchForm" method="post">
		<div class="btn-group f_l m_t10">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="finance"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$batch_action}" data-msg="{t domain="finance"}已完成的申请无法被删除，你确定要删除选中的列表吗？{/t}" data-noSelectMsg="{t domain="finance"}请选中要操作的项{/t}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="finance"}批量删除{/t}</a></li>
			</ul>
		</div>

		<div class="choose_list f_r m_t10">
			<select class="w120" name="payment">
				<option value="">{t domain="finance"}充值方式{/t}</option>
				<!-- {foreach from=$payment item=item} -->
				{if $item.pay_code neq 'pay_balance'}
				<option value="{$item.pay_code}" {if $smarty.get.payment eq $item.pay_code} selected {/if}>{$item.pay_name} </option>
                {/if}
                <!-- {/foreach} -->
			</select>
			<span class="f_l">{t domain="finance"}申请时间：{/t}</span>
			<input class="date f_l w150" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="{t domain="finance"}开始日期{/t}">
			<span class="f_l">{t domain="finance"}至{/t}</span>
			<input class="date f_l w150" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="{t domain="finance"}结束日期{/t}">
			<input type="text" name="keywords" value="{$list.filter.keywords}" placeholder="{t domain="finance"}请输入会员手机号或名称等关键字{/t}" />
			<button class="btn select-button" type="button">{t domain="finance"}搜索{/t}</button>
		</div>

	</form>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped" id="smpl_tbl">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox" /></th>
					<th class="w130">{t domain="finance"}订单编号{/t}</th>
					<th class="w150">{t domain="finance"}会员名称{/t}</th>
					<th class="w130">{t domain="finance"}充值金额{/t}</th>
					<th class="w130">{t domain="finance"}充值方式{/t}</th>
					<th class="w150">{t domain="finance"}申请时间{/t}</th>
					<th class="w130">{t domain="finance"}处理状态{/t}</th>
					<th class="w80">{t domain="finance"}操作{/t}</th>
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
					<td>{if $item.user_name}{$item.user_name}{else}{t domain="finance"}匿名用户{/t}{/if}</td>
					<td align="right">{$item.surplus_amount}</td>
					<td>{if $item.payment}{$item.payment}{else}{t domain="finance"}银行转账{/t}{/if}</td>
					<td align="center">{$item.add_date}</td>
					<td align="center">
                        {if $item.is_paid eq 1}
                        {t domain="finance"}已完成{/t}
                        {elseif $item.is_paid eq 0}
                        {t domain="finance"}待审核{/t}
                        {else}
                        {t domain="finance"}已取消{/t}
                        {/if}
                    </td>
					<td align="center">
						<a class="data-pjax no-underline" href='{url path="finance/admin_account/check" args="id={$item.id}{if $type}&type={$type}{/if}"}' title="{t domain="finance"}查看{/t}"><i class="fontello-icon-doc-text"></i></a>
						{if $item.is_paid neq 1}
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t domain="finance"}您确定要删除充值提现记录吗？{/t}" href='{url path="finance/admin_account/remove" args="id={$item.id}{if $type}&type={$type}{/if}"}' title="{t domain="finance"}删除{/t}"><i class="fontello-icon-trash"></i></a>
						{/if}
					</td>
				</tr>
				<!-- {foreachelse}-->
				<tr>
					<td class="no-records" colspan="9">{t domain="finance"}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$list.page} -->
	</div>
</div>
<!-- {/block} -->