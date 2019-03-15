<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">

</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
	</div>
	<div class="span9">
		<div class="tab-content">
			<div class="row-fluid">
				<div class="row fund-title">
					<span class="panel-item">{t domain="store"}账户余额：{/t}<span class="price">{$account.formated_money}</span></span>
					{if $account.frozen_money neq 0}
	      			<span class="panel-item">{t domain="store"}冻结资金：{/t}<span class="price">{$account.formated_frozen_money}</span></span>
	      			{/if}
	      			<span class="panel-item">{t domain="store"}保证金：{/t}<span class="price">{$account.formated_deposit}</span></span>
	      			<span class="panel-item">{t domain="store"}可用余额：{/t}<span class="price">{$account.formated_amount_available}</span></span>
				</div>
				<div><h3 class="heading">{t domain="store"}资金明细{/t}</h3></div>
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead>
						<th class="w150">{t domain="store"}结算时间{/t}</th>
        				<th>{t domain="store"}类型/单号{/t}</th>
        				<th class="w150">{t domain="store"}收支金额（元）{/t}</th>
        				<th class="w150">{t domain="store"}账户余额（元）{/t}</th>
					</thead>
				 	<!-- {foreach from=$data.item item=list} -->
					<tr>
						<td>{$list.change_time}</td>
						<td>
							{if $list.change_type eq 'charge'}
								{t domain="store"}充值{/t}
							{else if $list.change_type eq 'withdraw'}
								{t domain="store"}提现{/t}
							{else if $list.change_type eq 'bill'}
								{t domain="store"}结算{/t}
							{/if}
							&nbsp;
							{$list.change_desc}									
						</td>
						<td {if $list.change_type eq 'withdraw'}class="withdraw-price"{/if}>{$list.money}</td>
						<td>{$list.store_money}</td>
					</tr>
					<!-- {foreachelse} -->
				   	<tr><td class="no-records" colspan="4">{t domain="store"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->