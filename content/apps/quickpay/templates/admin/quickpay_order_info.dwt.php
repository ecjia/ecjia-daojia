<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->


<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<!-- #BeginLibraryItem "/library/quickpay_order_step.lbi" --><!-- #EndLibraryItem -->

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="orderpostForm" id="listForm" data-url='{url path="orders/admin/operate_post" args="order_id={$order.order_id}"}'  data-pjax-url='{url path="orders/admin/info" args="order_id={$order.order_id}"}' data-list-url='{url path="orders/admin/init"}' data-remove-url="{$remove_action}">
			<div id="accordion2" class="foldable-list form-inline">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{t domain="quickpay"}基本信息{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{t domain="quickpay"}订单编号：{/t}</strong></div></td>
									<td>
										{$order_info.order_sn}
									</td>
									<td><div align="right"><strong>{t domain="quickpay"}订单状态：{/t}</strong></div></td>
									<td>{$order_info.status}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="quickpay"}购买人姓名：{/t}</strong></div></td>
									<td>
										{$order_info.user_name}
									</td>
									<td><div align="right"><strong>{t domain="quickpay"}购买人手机号：{/t}</strong></div></td>
									<td>{$order_info.user_mobile}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="quickpay"}支付方式：{/t}</strong></div></td>
									<td>
										{$order_info.pay_name}
									</td>
									<td><div align="right"><strong>{t domain="quickpay"}支付时间：{/t}</strong></div></td>
									<td>{$order_info.pay_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="quickpay"}优惠类型：{/t}</strong></div></td>
									<td>
										{$order_info.activity_name}
									</td>
									<td><div align="right"><strong>{t domain="quickpay"}买单来源：{/t}</strong></div></td>
									<td>{$order_info.referer}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse"  data-target="#collapseFive">
							<strong>{t domain="quickpay"}费用信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFive">
						<table class="table m_b0">
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="quickpay"}买单消费总金额：{/t}</strong>¥{if $order_info.goods_amount}{$order_info.goods_amount}{else}0{/if}
										- <strong>{t domain="quickpay"}买单：{/t}</strong>¥{if $order_info.discount}{$order_info.discount}{else}0{/if}
										- <strong>{t domain="quickpay"}使用积分抵扣：{/t}</strong>¥{if $order_info.integral_money}{$order_info.integral_money}{else}0{/if}
										- <strong>{t domain="quickpay"}使用红包抵扣：{/t}</strong>¥{if $order_info.bonus}{$order_info.bonus}{else}0{/if}
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										= {t domain="quickpay"}买单实付金额：{/t}<strong>{$order_info.order_amount}</strong>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseSix"><strong>{t domain="quickpay"}操作记录{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseSix">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<td class="w150">{t domain="quickpay"}操作者{/t}</td>
									<td class="w150">{t domain="quickpay"}操作时间{/t}</td>
									<td class="w180">{t domain="quickpay"}订单状态{/t}</td>
									<td>{t domain="quickpay"}操作备注{/t}</td>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$action_list item=action} -->
								<tr>
									<td>{$action.action_user_name}</td>
									<td>{$action.add_time}</td>
									<td>{$action.order_status_name}</td>
									<td>{$action.action_note}</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="no-records" colspan="4">{t domain="quickpay"}该订单暂无操作记录{/t}</td>
								</tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->