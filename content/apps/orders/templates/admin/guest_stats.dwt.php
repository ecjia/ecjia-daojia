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
				<strong>会员购买率（会员购买率 = 有订单会员数 ÷ 会员总数）</strong>
			</a>
		</div>
		<div class="accordion-body in collapse" id="user">
			<table class="table table-oddtd m_b0">
				<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>会员总数</strong></div></td>
						<td>{$user_num}</td>
						<td><div align="right"><strong>有订单会员数</strong></div></td>
						<td>{$have_order_usernum}</td>
					</tr>
					<tr>
						<td><div align="right"><strong>会员订单总数</strong></div></td>
						<td>{$user_order_turnover}</td>
						<td><div align="right"><strong>会员购买率</strong></div></td>
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
				<strong>每会员平均订单数及购物额（每会员订单数 = 会员订单总数 ÷ 会员总数）（每会员购物额 = 会员购物总额 ÷ 会员总数）</strong>
			</a>
		</div>
		<div class="accordion-body in collapse" id="user_all">
			<table class="table table-oddtd m_b0">
				<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>会员购物总额</strong></div></td>
						<td>{$user_all_turnover}</td>
						<td><div align="right"><strong>每会员订单数</strong></div></td>
						<td>{$ave_user_ordernum}</td>
					</tr>
					<tr>
						<td><div align="right"><strong>每会员购物额</strong></div></td>
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
				<strong>匿名会员平均订单额及购物总额（匿名会员平均订单额 =  匿名会员购物总额 ÷ 匿名会员订单总数）</strong>
			</a>
		</div>
		<div class="accordion-body in collapse" id="guest_all">
			<table class="table table-oddtd m_b0">
				<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>匿名会员购物总额</strong></div></td>
						<td>{$guest_all_turnover}</td>
						<td><div align="right"><strong>匿名会员订单总数</strong></div></td>
						<td>{$guest_order_num}</td>
					</tr>
					<tr>
						<td><div align="right"><strong>匿名会员平均订单额</strong></div></td>
						<td colspan="3">{$guest_order_amount}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
{/if}
<!-- {/block} -->