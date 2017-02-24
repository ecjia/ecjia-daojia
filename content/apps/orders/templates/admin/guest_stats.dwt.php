<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<!-- 客户统计 -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	    <!-- {if $action_link} -->
		<a class="btn plus_or_reply" id="sticky_a" href='{$action_link.href}'><i class="fontello-icon-download"></i>{$action_link.text}</a>
	    <!-- {/if} -->
	</h3>
</div>

<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#user">
				<strong>{lang key='orders::statistic.percent_buy_member'}{lang key='orders::statistic.buy_member_formula'}</strong>
			</a>
		</div>
		<div class="accordion-body in collapse" id="user">
			<table class="table table-oddtd m_b0">
				<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{lang key='orders::statistic.member_count'}</strong></div></td>
						<td>{$user_num}</td>
						<td><div align="right"><strong>{lang key='orders::statistic.order_member_count'}</strong></div></td>
						<td>{$have_order_usernum}</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{lang key='orders::statistic.member_order_count'}</strong></div></td>
						<td>{$user_order_turnover}</td>
						<td><div align="right"><strong>{lang key='orders::statistic.percent_buy_member'}</strong></div></td>
						<td>{$user_ratio}%</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="foldable-list move-mod-group m_t20" id="goods_info_sort_submit">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#user_all">
				<strong>{lang key='orders::statistic.order_turnover_peruser'}{lang key='orders::statistic.member_order_amount'}{lang key='orders::statistic.member_buy_amount'}</strong>
			</a>
		</div>
		<div class="accordion-body in collapse" id="user_all">
			<table class="table table-oddtd m_b0">
				<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{lang key='orders::statistic.member_sum'}</strong></div></td>
						<td>{$user_all_turnover}</td>
						<td><div align="right"><strong>{lang key='orders::statistic.average_member_order'}</strong></div></td>
						<td>{$ave_user_ordernum}</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{lang key='orders::statistic.member_order_sum'}</strong></div></td>
						<td colspan="3">{$ave_user_turnover}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

{if 0}
<div class="foldable-list move-mod-group m_t20" id="goods_info_sort_submit">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#guest_all">
				<strong>{lang key='orders::statistic.order_turnover_percus'}{lang key='orders::statistic.guest_all_ordercount'}</strong>
			</a>
		</div>
		<div class="accordion-body in collapse" id="guest_all">
			<table class="table table-oddtd m_b0">
				<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{lang key='orders::statistic.guest_member_orderamount'}</strong></div></td>
						<td>{$guest_all_turnover}</td>
						<td><div align="right"><strong>{lang key='orders::statistic.guest_member_ordercount'}</strong></div></td>
						<td>{$guest_order_num}</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{lang key='orders::statistic.guest_order_sum'}</strong></div></td>
						<td colspan="3">{$guest_order_amount}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
{/if}
<!-- {/block} -->