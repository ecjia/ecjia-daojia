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
					<span class="panel-item">账户余额：<span class="price">{$account.formated_money}</span></span>
					{if $account.frozen_money neq 0}
	      			<span class="panel-item">冻结资金：<span class="price">{$account.formated_frozen_money}</span></span>
	      			{/if}
	      			<span class="panel-item">保证金：<span class="price">{$account.formated_deposit}</span></span>
	      			<span class="panel-item">可用余额：<span class="price">{$account.formated_amount_available}</span></span>
				</div>
				<div><h3 class="heading">资金明细</h3></div>
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead>
						<th class="w150">结算时间</th>
        				<th>类型/单号</th>
        				<th class="w150">收支金额（元）</th>
        				<th class="w150">账户余额（元）</th>
					</thead>
				 	<!-- {foreach from=$data.item item=list} -->
					<tr>
						<td>{$list.change_time}</td>
						<td>
							{if $list.change_type eq 'charge'}
							充值
							{else if $list.change_type eq 'withdraw'}
							提现
							{else if $list.change_type eq 'bill'}
							结算
							{/if}
							&nbsp;
							{$list.change_desc}									
						</td>
						<td {if $list.change_type eq 'withdraw'}class="withdraw-price"{/if}>{$list.money}</td>
						<td>{$list.store_money}</td>
					</tr>
					<!-- {foreachelse} -->
				   	<tr><td class="no-records" colspan="4">{t}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->